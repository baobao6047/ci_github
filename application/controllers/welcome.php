<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	const PER_PAGE = 10; // 每页显示的条数

	function __construct()
	{
        parent::__construct();
        $this->load->model('welcome_model');
	}

	public function index()
	{
        $test = $this->welcome_model->test('experiencer', array('uid' => 54));
        print_r($test);
        echo '<hr>';
        $src_path = APPPATH . 'src';
        echo $src_path;
        echo $this->config->item('domain_src') . 'common/js/seajs/sea.js';
        echo "<hr>";
        echo '最新';
        echo "<hr>";

		$this->load->view('welcome', compact("src_path"));
    }
    
    public function test()
    {
        $ret = 'test文件';
        $json = json_encode($ret);
        die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */