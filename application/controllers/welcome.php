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
        $code = $_GET['code'];
        if ($code) {
            echo $code;die;
        } else {
            echo '接收不到';die;
        }
        $ret = 'test文件';
        echo $ret;die;
        $json = json_encode($ret);
        die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
    }


    public function wx_check_user()
    {
        $code = $this->get_string('code');
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $data = array(
            'appid' => APPID,
            'secret' => SECRET,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        );
        $wx_info = $this->soap_call($url, $data, true);

        if ($wx_info === false || $wx_info === null) {
            $this->failure(3, '微信登陆失败');
        }
        if (isset($wx_info['errcode'])) {
            $this->failure(4, $wx_info['errcode'] . ':' . $wx_info['errmsg']);
        }
        $this->success(200, 'ok', ['openid' => $wx_info['openid']]);
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

    protected function failure($code = 0, $msg = '', $data = [], $ui_name = "alert", $output = true)
    {
        $json_str = json_encode(['code' => $code + 0, "success" => false, "msg" => $msg, "ui_name" => $ui_name, "data" => $data], JSON_UNESCAPED_UNICODE);

        if ($output) {
            die($this->callback_json($json_str));
        } else {
            return $this->callback_json($json_str);
        }
    }

    protected function success($code = 0, $msg = '', $data = [], $ui_name = "alert", $output = true)
    {
        $json_str = json_encode(['code' => $code + 0, "success" => true, "msg" => $msg, "ui_name" => $ui_name, "data" => $data], JSON_UNESCAPED_UNICODE);

        if ($output) {
            die($this->callback_json($json_str));
        } else {
            return $this->callback_json($json_str);
        }
    }

    private function callback_json($json)
    {
        return isset($_GET['callback']) && !$_GET['callback'] ? trim($_GET['callback']) . "($json)" : $json;
    }

    protected function soap_call($url, $data = null, $esolve = false, $use_cert = false)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            if ($data) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }

            if($use_cert == true){
                $sslCertPath = SSLCERTPATH;
                $sslKeyPath = SSLKEYPATH;
                curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLCERT, $sslCertPath);
                curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
                curl_setopt($ch,CURLOPT_SSLKEY, $sslKeyPath);
            }

            $output = curl_exec($ch);
            if ($esolve) {
                $output = json_decode($output, true);
            }
            curl_close($ch);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return $output;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */