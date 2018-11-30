<?php

class Base_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    private function _init()
    {
       // 加载过滤工具
       $this->load->library('ajax_box');
    }

    /**
	 * @param $input_name
	 * @param string $output
	 * @param string $rules
	 * @param string $box_name
	 * @param string $data_array
	 * @param int $code
	 * @param bool|true $die_with_json 如果验证不通过，是否结束并返回json。false则不结束，只返回错误信息。
	 * @return mixed
	 */
    public function get($input_name, $output = "", $rules = "pass",$box_name = "",$data_array = "",$code=0,$die_with_json = true) {
	    return $this -> ajax_box -> set_rules($this -> input -> get($input_name), $output, $rules,$box_name,$data_array,$code,$die_with_json);
    }
    
    public function post($input_name, $output = "", $rules = "pass",$box_name = "",$data_array = "",$code=0,$die_with_json = true) {
	    return $this -> ajax_box -> set_rules($this -> input -> post($input_name), $output, $rules,$box_name,$data_array,$code,$die_with_json);
	}
}
