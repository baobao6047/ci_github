<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	const PER_PAGE = 10; // 每页显示的条数

	function __construct()
	{
        parent::__construct();
	}

	public function index()
	{
        echo 'welcome';die;
        $src_path = APPPATH . 'src';
        echo $src_path;

		// echo 'this is a welcome p';
		// echo '<br/>';
		$this->load->view('welcome', compact("src_path"));
    }
    
    public function test()
    {
        $ret = 'test文件';
        $json = json_encode($ret);
        die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
    }
    
    public function add_test()
    {
        $temp = 0;
        $num = intval($this->input->get_post('num'));
        $sum = $temp + $num;
        $json = json_encode($sum);
        die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
    }
    
    public function quantity()
    {
        $ret = 14;
        $json = json_encode($ret);
        die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
    }

	public function lists()
    {
        //获取关键字
        $data['field'] = $field = trim($this->input->get_post('field', TRUE));
        $data['keyword'] = $keyword = trim($this->input->get_post('keyword', TRUE));
        $data['type'] = $type = intval($this->input->get_post('type'));
        $data['status'] = $status = intval($this->input->get_post('status'));

        $where['deleted'] = 0;
        $like = '';
        if ($field && $keyword) {
            $like = array($field => $keyword);
        }
        if ($type) {
            $where['type'] = $type;
        }
        if ($status) {
            $where['status'] = $status;
		}
		
		$this->load->model('welcome_model');

        $list = $this->welcome_model->lists(self::PER_PAGE, $this->offset, $where, $like);
        // 获取分类名
        $cid_1_arr = array_column($list['lists'], 'cid_1');
        $cid_2_arr = array_column($list['lists'], 'cid_2');
        $cids = array_merge($cid_1_arr, $cid_2_arr);
        $data['name_array'] =[];
        if ($cids) {
            $cid_arr = $this->welcome_model->get_cate_name($cids);
            $data['name_array'] = array_column($cid_arr, 'name', 'id');
        }
        $data = array_merge($data, $list);

        $this->load->view('bala', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */