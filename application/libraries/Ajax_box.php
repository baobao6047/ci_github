<?php
/**
 * @package     CodeIgniter luwiso@qq.com
 * @author      luo
 * @copyright       Copyright (c) 2008 - 2016 luo, Inc.
 * @since       Version 1.0
 */
class Ajax_box {
//rules "required|emailmin_length[2]|max_length[30]xss_clean"
    private $var_str = '';
    //文本
    private $var_name = '';
    //文本框名提示名字
    private $var_number = '';
    private $box_name = '';
    //最小数,,最大数

    /**
     * @param string $var_str
     * @param string $var_name
     * @param string $rules
     * @param string $box_name
     * @param string $data_array
     * @param int $code
     * @param bool|true $die_with_json 是否结束并返回json格式字符串。如果是false，就返回错误提示信息，不结束。
     * @return string
     */
    public function set_rules($var_str = 'xxxxx@163.com', $var_name = '电子邮箱', $rules = 'required',$box_name = "",$data_array="",$code=0,$die_with_json = true) {
        if($var_str === 'undefined'){//undefined  字符串视为空字符串
            $var_str = '';
        }
        $this -> var_str = $var_str;
        $this -> var_name = $var_name;
        $this -> box_name = $box_name;
        $rules = $rules;
        $rull_arr = explode('|', $rules);
        for ($i = 0; $i < count($rull_arr); $i++) {
            $func = $rull_arr[$i];
            preg_match("/([\w_]+)\[(\d+|.+?)\]/", $rull_arr[$i], $rull_parm_arr);
            if(count($rull_parm_arr)==3){
                $func = $rull_parm_arr[1];
                $this -> var_number = $rull_parm_arr[2];
            }
            $data = $this -> $func();
            if ($data['success'] == false) {
                //exit($this -> ajax_error(array('alert_str' => $data['data'])));
                if($die_with_json){
                    header("Content-type: text/html; charset=utf-8");
                    exit($this -> ajax_error(array('code'=>$code+0,"success" => false, "msg" => $data['data'], "ui_name" => $box_name,"data"=>$data_array)));
                }
                return array('code'=>$code+0,"success" => false, "msg" => $data['data'], "ui_name" => $box_name,"data"=>$data_array);
            }
            $this -> var_str = $data['data'];
        }
        return $this -> var_str;

    }
    private function var_trim() {
        return $data = array('success' => true, 'data' => trim($this -> var_str));
    }
    private function pass() {
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    /**
     * 莫林杰
     * 修改时间：2017年1月3日 17:16:53
     * 修改字段为数组时的判定方式
     */
    private function required() {
        if (mb_strlen($this->var_str) == 0) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不能为空');
        }
        if (is_array($this->var_str)){
            foreach ($this->var_str as $k=>$v){
                trim($this->var_str[$k]);
            }
        }else{
            $this->var_str = trim($this->var_str);
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function email() {
        if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this -> var_str)) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不正确');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function min_length() {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($this -> var_str) < $this -> var_number) {
                return $data = array('success' => false, 'data' => $this -> var_name . '不能小于' . $this -> var_number . '字符');
            }
            return $data = array('success' => true, 'data' => $this -> var_str);
        }
        if (strlen($this -> var_str) < $this -> var_number) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不能小于' . $this -> var_number . '字符');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function max_length() {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($this -> var_str) > $this -> var_number) {
                return $data = array('success' => false, 'data' => $this -> var_name . '不能超过' . $this -> var_number . '字符');
            }
            return $data = array('success' => true, 'data' => $this -> var_str);
        }

        if (strlen($this -> var_str) > $this -> var_number) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不能超过' . $this -> var_number . '字符');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }


    private function is_length() {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($this -> var_str) != $this -> var_number) {
                return $data = array('success' => false, 'data' => $this -> var_name . '长度必须为' . $this -> var_number . '字符');
            }
            return $data = array('success' => true, 'data' => $this -> var_str);
        }

        if (strlen($this -> var_str) != $this -> var_number) {
            return $data = array('success' => false, 'data' => $this -> var_name . '长度必须为' . $this -> var_number . '字符');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }


    private function is_num() {
        if ($this -> var_str && !is_numeric($this -> var_str)) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不是纯数字!');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function no_is_num() {
        if (is_numeric($this -> var_str)) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不能为纯数字!');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    //手机号码检查
    private function is_mobile() {
        if (!is_numeric($this -> var_str)) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不正确!');
        }
        if (strlen($this -> var_str) != 11) {
            return $data = array('success' => false, 'data' => $this -> var_name . '必须是11位!');
        }
        if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0123456789]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|147[0-9]{8}$|177[0-9]{8}$/", $this -> var_str)) {
            //验证通过
            return $data = array('success' => true, 'data' => $this -> var_str);;
        }
        return $data = array('success' => false, 'data' => $this -> var_name . '不正确!');
    }

    // 用户不存在输出json
    private function is_user_phone()
    {
        $ci = &get_instance();
        $ci->load->database();
        $user = $ci->db->select('uid')
            ->get_where('user', ['phone'=>$this->var_str], 1)
            ->row_array();

        if (!$user) {
            return $data = array('success'=>false,'data'=>$this->var_name . '不存在');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);;
    }

    //用户已输在输出json
    private function no_user_phone() {
        $ci = &get_instance();
        $ci->load->database();
        $user = $ci->db->select('uid')
            ->get_where('user', array('phone'=>$this->var_str), 1)
            ->row_array();
        if ($user) {
            return $data = array('success'=>false,'data'=> $this->var_name . '已经存在');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);;
    }

    private function no_ymbol() {
        if (!preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/",$this -> var_str)) {
            return $data = array('success' => false, 'data' => $this -> var_name . '不合规范，请不要带特别符号');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function select_type() {
        $num = intval($this -> var_str);
        if ($num<1) {
            return $data = array('success' => false, 'data' =>'请选择'. $this -> var_name);
        }
        return $data = array('success' => true, 'data' => $num);
    }

    private function xss_clean() {
        $this -> var_str = str_replace("'", "", $this -> var_str);
        $this -> var_str = str_replace("<", "", $this -> var_str);
        $this -> var_str = str_replace(">", "", $this -> var_str);
        $this -> var_str = str_replace('"', "", $this -> var_str);
        $this -> var_str = str_replace('&', "", $this -> var_str);
        $this -> var_str = str_replace('/', "", $this -> var_str);
        $this -> var_str = str_replace('\\', "", $this -> var_str);
        $this -> var_str = str_replace('-', "", $this -> var_str);
        $this -> var_str = str_replace(',', "", $this -> var_str);
        $this -> var_str = str_replace('|', "", $this -> var_str);
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function integer() {
        return $data = array('success' => true, 'data' => intval($this -> var_str));
    }

    /**
     * 验证正整数
     * @return array
     */
    private function positive()
    {
        $var = $this -> var_str;
        if (!empty($var) && !preg_match('/^[0-9]*$/',$var)){
            return $data = array('success' => false, 'data' => $this -> var_name . '不是一个正整数！');
        }
        return $data = array('success' => true, 'data' => $var);
    }

    /**
     * 莫林杰
     * 2017年4月12日 08:02:40
     * 日期验证规则
     * @return array
     */
    private function date()
    {
        $date = $this -> var_str;
        if (!empty($date) && !preg_match('/^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/',$date)){
            return $data = array('success' => false, 'data' => $this -> var_name . '不是一个正确的日期格式！');
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    /**
     * 莫林杰
     * 2017年1月18日 11:52:20
     * 分页页码
     */
    private function page()
    {
        $data = $this->var_str;
        if ($data){
            if (!is_numeric($data) || intval($data) < 1){
                return $data = array('success' => false, 'data' => $this -> var_name . '不是一个正确的页码!');
            }
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    //返回绝对值
    private function absolute()
    {
        return $data = array('success' => true, 'data' => abs($this -> var_str));
    }

    /**
     * 判断长度是否在某个区间內，或是否为指定长度
     * length[1,5] 或 length[10]
     * @return array
     */
    private function length()
    {
        $str = $this->var_str;
        $range = explode(',', $this -> var_number);
        if (count($range) == 2){
            if (mb_strlen($str) < $range[0] || mb_strlen($str) > $range[1]) {
                return $data = ['success' => false, 'data' => $this->var_name . '长度必须在' . $range[0] . '到' . $range[1] . '之间'];
            }
        }elseif(count($range) == 1){
            if (mb_strlen($str) != $range[0]){
                return $data = ['success' => false, 'data' => $this->var_name . '长度必须为' . $range[0]];
            }
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    /**
     * 判断数字大小是否在某个范围內
     * in[1,5]
     * @return array
     */
    private function in()
    {
        $str = $this->var_str;
        $range = explode(',', $this -> var_number);
        if (!in_array($str, $range)){
            return $data = ['success' => false, 'data' => $this->var_name . '非指定值'];
        }

        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    private function between()
    {
        $str = $this->var_str;
        $range = explode(',', $this -> var_number);
        if ($str < $range[0] || $str > $range[1]) {
            return $data = ['success' => false, 'data' => $this->var_name . '大小必须在' . $range[0] . '到' . $range[1] . '之间'];
        }
        return $data = array('success' => true, 'data' => $this -> var_str);
    }

    /**
     * ajax返回：错误
     * @param $data 错误信息
     * @return void 输出并终止执行
     */
    private function ajax_error($data = NULL) {
        die(json_encode($data));
    }

}
?>