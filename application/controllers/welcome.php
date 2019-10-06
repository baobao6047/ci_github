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
        echo 'test';
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * 获取 & 更新 用户信息
     */
    public function wx_check_user()
    {
        $wx_info = $this->_wx_info(); // 从微信服务器获取用户信息
        
        $wxuser = $this->welcome_model->wx_user(array('openid' => $wx_info['openid']));
        if (!$wxuser || !$wxuser['mobile']) {
            callback_error('还未注册，请先进行注册');
        }

        $wxdata = array(
            'last_login_ip' => ip('int'),
            'last_login_time' => time(),
            'token' => md5(md5($wx_info['openid']) . time())
        );
        $wuid = $this->welcome_model->update_wxlogin($wx_info['openid'], $wxdata);

        callback_success(array('wuid' => $wuid, 'token' => $wxdata['token']));
    }

    /**
     * 注册
     */
    public function register()
    {
        $mobile = trim($this->input->get_post('mobile', true));
        $nickname = trim($this->input->get_post('nickname', true));
        $avatar = trim($this->input->get_post('avatar', true));
        $mobile OR callback_error('请传入手机号');
        // TODO 验证手机格式没做~懒
        $wxuser = $this->welcome_model->wx_user(array('mobile' => $mobile));
        $wxuser AND callback_error('该手机号已注册，请换个手机号注册');
        $wx_info = $this->_wx_info(); // 从微信服务器获取用户信息

        // TODO 头像~昵称写入  从wx.getSetting中获取
        $wxdata = array(
            'openid' => $wx_info['openid'],
            'nickname' => $nickname,
            'avatar' => $avatar,
            'mobile' => $mobile,
            'dateline' => time(),
            'reg_ip' => ip('int'),
            'reg_time' => time(),
            'last_login_ip' => ip('int'),
            'last_login_time' => time(),
            'token' => md5(md5($wx_info['openid']) . time()),
        );
        $wuid = $this->welcome_model->insert_wxlogin($wxdata);

        callback_success(array('wuid' => $wuid, 'token' => $wxdata['token']));
    }

    /**
     * 通过小程序code -> 从微信服务器 -> 获取用户openid等信息
     */
    private function _wx_info()
    {
        $code = trim($this->input->get_post('code', true));
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
        return $wx_info;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */