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

    public function notify_xml()
    {
        $xml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        if (!$xml) {
            echo $this->_back_xml('未接收到xml');
            exit;
        }

        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if (!$values) {
            echo $this->_back_xml('xml解析失败');
            exit;
        }

        $this->notify_model->xml_notify($xml);

        echo $this->_back_xml('OK', true);
        exit;
    }

    private function _back_xml($msg = '', $state = false)
    {
        $error = $state ? 'SUCCESS' : 'FAIL';
        return printf('<xml><return_code><![CDATA[%s]]></return_code><return_msg><![CDATA[%s]]></return_msg></xml>', $error, $msg);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */