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
        echo '欢迎页';die;

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
        $code = $this->input->get_post('code', true);
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $data = array(
            'appid' => APPID,
            'secret' => SECRET,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        );
        $wx_info = soap_call($url, $data, true);

        if ($wx_info === false || $wx_info === null) {
            callback_error('微信登陆失败');
        }
        if (isset($wx_info['errcode'])) {
            callback_error($wx_info['errcode'] . ':' . $wx_info['errmsg']);
        }

        $client['client_type'] = 3;//1安卓，2苹果，3小程序，4公众号
        $client['dateline'] = time();
        $client['login_ip'] = ip('int');

        $wxdata = array(
            'last_login_ip' => ip('int'),
            'last_login_time' => time(),
            'token' => md5(md5($wx_info['openid']) . time())
        );

        $wxuser = $this->welcome_model->wx_user(array('openid' => $wx_info['openid']));
        if (empty($wxuser)) {
            $wxdata['user_type'] = 1;
            $wxdata['openid'] = $wx_info['openid'];
            $wxdata['dateline'] = time();
            $wxdata['reg_ip'] = ip('int');
            $wxdata['reg_time'] = time();
            $client['openid'] = $wx_info['openid'];
            $wuid = $this->welcome_model->insert_wxlogin($client, $wxdata);
        } else {
            $wuid = $this->welcome_model->update_wxlogin(array('openid' => $wx_info['openid']), $client, $wxdata);
        }

        callback_success(array('wuid' => $wuid, 'token' => $wxdata['token']));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */