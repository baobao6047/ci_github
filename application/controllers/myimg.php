<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myimg extends CI_Controller {
    function __construct()
	{
        parent::__construct();
    }
    
    public function up_img()
    {
        echo 'img';
        $this->load->view('upimg');
    }

    /**
     * 图片上传
     */
    public function try_imgs()
    {
        $path = $this->upload_img('try');
        print_r($path);
    }
    
    /**
     * 单文件上传方法
     * @param $img 上传文件
     * @param string $size 大小
     * @param boolean $name 文件命名
     * @param string $path 报错路径
     * @return mixed
     */
    public function upload_img($img, $size = '', $name = false, $path = '')
    {
        if (!isset($_FILES[$img])) {
            print_r('无上传控件');
        }

        $this->load->library('uploader');
        $file = $_FILES[$img];

        if ($file['error'] != UPLOAD_ERR_OK || $file == '') {
            print_r('上传文件为空');
        }
        if (!$path) {
            $path = $img . '/' . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time());
        }
        $this->uploader->allowed_size($size ? $size : config_item('_allowed_file_size'));
        $this->uploader->addFile($file);
        if ($this->uploader->file_info() === false) {
            print_r($this->uploader->get_error());
        }
        return $this->uploader->save($path, $name);
    }
}