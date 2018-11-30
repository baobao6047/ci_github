<?php

/**
 * redis队列
 调用例子
    先要在服务器端开启redis的服务
    $this->load->library('my_queue', array('key' => 'lcc')); 创建类
    $res = $this->my_queue->load_data(array(9,7,2,8)); 加入列队
    $res = $this->my_queue->batch_php(array(9,7,2,8)); 取出并清除列队内容
 */
class My_queue
{
    public $error;
    public $ci = null;
    /**
     * redis操作类
     */
    public $redis = null;
    /**
     * 存入列队的key
     */
    public $key;

    // -------------------------------------------------------

    function __construct($data)
    {
        $this->ci = get_instance();
        $this->ci->load->library('my_redis');
        $this->redis = $this->ci->my_redis->get_instance();
        if (!$this->redis) {
            $this->error = $this->ci->my_redis->error;
            return false;
        }
        $this->key = $data['key'];
    }

    /**
     * 加入列队 - 单个
     */
    public function push($data)
    {
        if (!$data) {
            $this->error = '数据为空';
            return false;
        }
        if (is_array($data)) {
            $data = json_encode($data);
        }
        // 在列队尾部加入一个元素
        return $this->redis->rPush($this->key, $data);
    }
    // END push ----------------------------------------------

    /**
     * 手动加载数据到列队 - 批量
     */
    public function load_data($data)
    {
        if (!$data) {
            $this->error = '数据为空';
            return false;
        }
        $total = count($data); // 数据总数
        $i = 0; // 成功数
        foreach ($data as $item) {
            // 移除列队中的相同元素
            $this->redis->lrem($this->key, $item, 0);
            if ($this->push($item)) {
                $i++;
            }
        }

        $res = "导入总量:" . $total . ";成功数量:" . $i . ";失败数量：". ($total - $i);
        return $res;
    }
    // END load_data -----------------------------------------

    /**
     * 移除并输出 - 列队元素(批量)
     */
    public function batch_php($ids)
    {
        if (!$ids || !is_array($ids)) {
            $this->error = '没有移除的元素id或者id不为数组';
            return false;
        }
        
        // 设置redis的模式
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        $data = []; // 输出的元素集
        while ($this->redis->lSize($this->key)) {
            // 阻塞模式弹出队列首元素
            $first = $this->redis->blPop($this->key, 0);
            $data[] = $first[1];
        }
        return $data;
    }
    // END batch_php -----------------------------------------

    /**
     * 获取列队中的首元素
     */
    public function get_first_handle()
    {
        if (!$this->redis->lSize($this->key)) {
            $this->error = $this->key . '缓存列队里没有元素';
            return false;
        }
        $first = $this->redis->lGet($this->key,0);
        return $first;
    }
    // END get_first_handle -----------------------------------------
}
