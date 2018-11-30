<?php
/**
 * redis缓存
 */
class My_redis
{
    /**
     * 错误信息
     */
    public $error;
    /**
     * redis对象
     */
    private $instance;

    private $config = array(
        'host'=>'127.0.0.1',
        'port'=>6379,
        'auth'=>'root',    //是否有用户验证，默认无密码验证。如果不是为null，则为验证密码
        'timeout'=>0,   //连接超时,0为不超时
        'reserved'=>null,
        'retry_interval'=>100,  //单位是 ms 毫秒
        'reconnect'=>false //连接超时是否重连  默认不重连
    );

    /**
     * 获取redis实例
     */
    public function get_instance()
    {
        if (!$this->instance instanceof Redis) {
            $this->instance = new Redis();
            if (!$this->instance->connect($this->config['host'], $this->config['port'], $this->config['timeout'])) {
                $this->error = 'redis链接失败';
                return false;
            }
            return $this->instance;
        }
        return $this->instance;
    }

    /**
     * redis缓存
     * @param $key 缓存的key
     * @param $data 缓存的数据,设为false为清除缓存
     * @param $expire 缓存的时间(默认半小时)
     */
    public function redis_cache($key, $data = null, $expire = 1800)
    {
        if ($data === null) {
            return $this->instance->get($key);
        }
        if ($data === false) {
            return $this->instance->delete($key);
        }
        return $this->instance->set($key, $data, $expire);
    }

    public function test()
    {
        print_r($this->config);
    }
}
