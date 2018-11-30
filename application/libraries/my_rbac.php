<?php
/**
 * 基于角色的权限管理
 */
class My_rbac
{
    /**
     * 缓存版本号的KEY
     */
    const RBAC_KEY = 'RBAC_KEY';
    /**
     * 缓存KEY
     */
    const CACHE_KEY = 'system_privilege_methods_new';

    /**
     * 缓存的时间
     */
    const CACHE_TIME = 120;

    // 操作列表（树形）
    protected $_action_tree;
    // 操作列表（展平）
    protected $_actions;
    // 权限点列表
    protected $_methods;
    // 数据库连接
    protected $_db;
    // 当前登录用户UID
    protected $_uid;
    // 当前访问路径
    protected $_path;
    // 当前登录用户可访问操作列表
    protected $_user_actions;
    // 当前登录用户可访问方法列表
    protected $_user_methods;

    public function __construct()
    {
        $this->_init();
    }

    /**
     * 获取数据库链接
     */
    protected function _db()
    {
        if (!$this->_db) {
            $this->_db = get_instance()->load->database('slave', true);
        }
        return $this->_db;
    }

    /**
     * 获取couchbase缓存类(实际使用时因读取配置信息)
     */
    protected function get_couchbase()
    {
        static $_cb = null;
        if ($_cb === null) {
            $host = '192.168.0.17:8091';
            $bucket = 'sk2.com';
            $_cb = new Couchbase ( $host, '', '', $bucket );
        }
        return $_cb;
    }

    /**
     * 递增缓存版本，相当于清除整个权限系统缓存！
     */
    public function version_up()
    {
        // 把缓存中的KEY所对应的值加1
        return get_couchbase()->increment (self::RBAC_KEY, 1, true, 0, 1);
    }

    /**
     * 获取缓存的版本
     */
    public function get_version()
    {
        return get_couchbase()->get(self::RBAC_KEY);
    }

    /**
     * 获取缓存值（附带版本号判断的）
     *
     * @param $key 键
     * @param $version 输出参数，当前版本号
     * @return 键值存在并且有效时返回其值，否则返回FALSE
     */
    public function get_cache($key, &$version = null)
    {
        // 获取多个缓存的值
        $caches = get_couchbase()->getMulti(array(self::RBAC_KEY, $key));

        // 没有找版本号则跟新版本
        $version = isset($caches[self::RBAC_KEY]) ? $caches[self::RBAC_KEY] : $this->version_up();

        // 该key的缓存版本号不存在
        if (!isset($caches[$key][self::RBAC_KEY])) {
            return false;
        }
        // 该key的存储版本号 ！= 现在的版本号
        if ($caches[$key][self::RBAC_KEY] != $version) {
            return false;
        }
        // 该key的缓存中没有value值
        if (!isset($caches[$key]['value'])) {
            return false;
        }
        return $caches[$key]['value'];
    }

    /**
     * 写入缓存值（附带版本号的）
     *
     * @param string $key 键
     * @param mixed $value 值
     * @param int $version 当前版本号
     * @return mixed 成功时返回CB的cas串
     */
    public function set_cache($key, $value, $version)
    {
        $value = array (
            'value' => $value,
            self::VERSION_KEY => $version,
        );
        return get_couchbase ()->set ( $key, $value, self::CACHE_TTL );
    }

    /**
     * 展平数组
     */
    protected function _flatten($name, $action, $is_open = true)
    {
        $id = $action['_id_'];
        $children = isset($action['children']) ? $action['children'] : array();
        unset($action['_id_']);
        unset($action['children']);

        $action['name'] = $name;
        $action['is_open'] = $is_open && (! isset($action['is_open']) || $action['is_open']);
        foreach ($children as $child) {
            $action['children'] []= $child['_id_'];
        }
        $actions = array($id => $action);
        foreach ($children as $name => $child) {
            $children = $this->_flatten($name, $child, $action['is_open']);
            $actions = array_merge($actions, $children);
        }
        return $actions;
    }

    /**
     * 初始化数据
     */
    protected function _init()
    {
        $this->_uid = get_user()['id'] ? get_user()['id'] : 0;

        // 获取文件名、类名、方法名
        $rtr = load_class('Router', 'core');
        $d = $rtr->fetch_directory () and $this->_path [] = str_replace ( '/', '', $d );
        $c = $rtr->fetch_class () and $this->_path [] = $c;
        $m = $rtr->fetch_method () and $this->_path [] = $m;

        // 有缓存则读取，没有则写入
        if (($data = $this->get_cache(self::CACHE_KEY)) && is_array($data)) {
            $this->_actions = $data ['actions'];
            $this->_action_tree = $data ['action_tree'];
            $this->_methods = $data ['methods'];
        } else {
            $ci = get_instance();
            $ci->load->config('privilege');
            $this->_action_tree = $ci->config->item('privilege');

            $actions = [];
            foreach ($this->_action_tree as $name => $action) {
                $actions = array_merge($actions, $this->_flatten($name, $action));
            }

            $methods = [];
            foreach ($actions as $action) {
                if (isset($action['codes'])) {
                    $methods = array_merge($methods, $action['codes']);
                }
            }

            // 包含基础方法
            foreach ($methods as $method) {
                $pos = strpos($method, '~');
                if ($pos !== false) {
                    $base_method = substr($method, 0, $pos);
                    if (! in_array($base_method, $methods)) {
                        $methods []= $base_method;
                    }
                }
            }

            $this->_actions = $actions;
            $this->_methods = $methods;
            $version = $this->get_version();
            $this->set_cache (self::CACHE_KEY, array ('actions' => $actions, 'action_tree' => $this->_action_tree, 'methods' => $methods), $version);

            $this->_user_actions = $this->get_user_actions($this->_uid);
            $this->_user_methods = $this->get_user_methods($this->_uid);
        }
    }

    /**
     * 获取当前用户操作列表
     */
    public function get_user_actions($uid, $use_cache = true)
    {
        if (! $uid) {
            return false;
        }
        
        $cache_key = 'user_actions_new_' . $uid;
        if ($use_cache) {
            if ($actions = $this->get_cache ( $cache_key, $version )) {
                if (is_array ( $actions )) {
                    return $actions;
                }
            }
        } else {
            $version = $this->get_version ();
        }
        
        $actions = array ();
        do {
            // 获取用户
            $user = $this->_db ()->select ( 'uid, is_super' )->where ( 'uid', $this->_uid )
            ->get ( 'system_privilege_user' )->row_array ();
            if (! $user) {
                $methods = false;
                break;
            }
        
            // 判断是否是超级管理员
            if ($user ['is_super']) {
                $actions = array_keys($this->_actions);
            } else {
                // 获取用户所属管理组
                $group_user = $this->_db ()->select ( 'group_id' )->where ( 'user_id', $uid )
                    ->get ( 'system_privilege_group_user' )->result_array ();
                if (! $group_user) {
                    break;
                }
        
                // 获取操作
                $actions = $this->_db ()
                    ->where_in ( 'group_id', array_column ( $group_user, 'group_id' ))
                    ->get ( 'system_privilege_group_action_new' )
                    ->result_array ();
                if (! $actions) {
                    break;
                }
                $actions = array_column ( $actions, 'action_id' );
            }
        } while (false);
        
        // 排除未开启的操作
        $actions = array_filter($actions, function ($id) {
            return isset($this->_actions[$id]['is_open']) ? $this->_actions[$id]['is_open'] : true;
        });
        $this->set_cache ( $cache_key, $actions, $version );
        return $actions;
    }

    /**
    * 获取当前用户权限列表。
    *
    * @param bool 是否使用缓存
    * @return array|bool 权限列表，用户不存在时返回false
     */
    public function get_user_methods($uid, $use_cache = true)
    {
        if ($uid === null) {
            $uid = $this->_uid;
        }
        if ($uid == $this->_uid) {
            if ($this->_user_methods !== null) {
                return $this->_user_methods;
            }
        }
        if (! $uid) {
            return false;
        }

        $cache_key = 'user_privileges_new_' . $this->_uid;
        if ($use_cache) {
            if ($methods = $this->get_cache ( $cache_key, $version )) {
                if (is_array ( $methods )) {
                    return $methods;
                }
            }
        } else {
            $version = $this->get_version ();
        }

        $methods = array ();
        do {
            $action_ids = $this->_user_actions ?: $this->get_user_actions ( $uid );
            if (! $action_ids) {
                break;
            }

            // 获取方法
            $methods = array();
            foreach ($action_ids as $action_id) {
                if (isset($this->_actions[$action_id]['codes'])) {
                    $methods = array_merge($methods, $this->_actions[$action_id]['codes']);
                }
            }
            if (! $methods) {
                break;
            }

            // 包含基础方法
            foreach ($methods as $method) {
                $pos = strpos($method, '~');
                if ($pos !== false) {
                    $base_method = substr($method, 0, $pos);
                    if (! in_array($base_method, $methods)) {
                        $methods []= $base_method;
                    }
                }
            }
        } while (false);

        $this->set_cache ( $cache_key, $methods, $version );
        return $methods;
    }

    /**
     * 检查权限
     *
     * @description 例如：权限点 USER-BAN~SELLER，USER-BAN 是路径，SELLER 是变体，表示只针对商家。
     * 带有变体的权限点需要手动检查。
     *
     * @param int 用户编号
     * @param string 路径
     * @param string 变体
     * @return bool
     */
    private function access($uid, $path, $variant = null)
    {
        if (is_array ( $path )) {
            $path = implode ( '-', $path );
        }
        $path = strtolower ( $path );
        $segments = explode ( '-', $path );

        // 检查用户存在否，设置权限否
        $user_methods = $this->_user_methods;

        if ($user_methods === false) {
            return false;
        }
        // 检查是否是超级管理员
        if ($user_methods === true) {
            return true;
        }

        // 检查方法列表是否有对应的项，如果没有，则按路径逐级往上检查
        // 如果所有上级路径都没有，则表示这个方法不做权限控制，任何人都可以访问
        if (! in_array ( $path, $this->_methods )) {
            // 往上找时不检查变体
            $variant = null;
            $parents = array_slice ( explode ( '-', $path ), 0, -1 );
            $path = false;
            while ($parents) {
                $path = join ( '-', $parents );
                if (in_array ( $path, $this->_methods )) {
                    break;
                }
                array_pop ( $parents );
            }
            if (! $parents) {
                return true;
            }
        }

        $code = $path;
        if ($variant) {
            $code .= '~' . strtolower ( $variant );
        }
        if (! in_array ( $code, $this->_methods )) {
            return true;
        }
        if (in_array ( $code, $user_methods )) {
            return true;
        }

        return false;
    }

    /**
     * 检查权限
     */
    public function check($path = null, $variant = null)
    {
        $path === null && $path = $this->_path;
        $ret = $this->access ( $this->_uid, $path, $variant );
        return $ret;
    }

    /**
     * 清除权限列表缓存
     *
     * @return void
     */
    public function clear_methods_cache()
    {
        cache ( 'system_privilege_methods_new', false );
    }

    /**
     * 清除某用户权限列表缓存
     *
     * @return void
     */
    public function clear_user_cache($uid)
    {
        $this->get_user_methods($uid, false);
    }

    /**
     * 获取所有操作（平铺）
     */
    public function get_actions()
    {
        return $this->_actions;
    }

    /**
     * 获取所有操作（树形）
     */
    public function get_action_tree()
    {
        return $this->_action_tree;
    }

    /**
     * 检查当前用户是否有某操作的访问权限，用于在视图中过滤没有执行权限的方法入口
     * @param string $action_id
     * @return bool
     */
    public function has_action($action_id)
    {
        return in_array($action_id, $this->_user_actions);
    }
}
