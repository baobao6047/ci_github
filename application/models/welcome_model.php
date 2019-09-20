<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function wx_user($condition = '', $select = '*')
    {
        return $this->db->select($select)->where($condition)->get('user')->row_array();
    }

    public function insert_wxlogin($wxdata)
    {
        $this->db->insert('user', $wxdata);
        return $this->db->insert_id();
    }

    public function update_wxlogin($openid, $wxdata)
    {
        $wxdata['last_login_ip'] = ip('int');
        $wxdata['last_login_time'] = time();
        $this->db->where('openid', $openid)->update('user', $wxdata);
        $user = $this->db->where('openid', $openid)->get('user')->row_array();
        return $user['id'];
    }

    public function get_table($table, $condition = '', $colunm = '*', $arr = false)
    {
        if ($condition) {
            $this->db->where($condition);
        }
        if ($arr) {
            return $this->db->select($colunm)->get($table)->result_array();
        } else {
            return $this->db->select($colunm)->get($table)->row_array();
        }
    }

    /**
     * 活动管理列表
     */
    public function lists($per_page='', $offset='', $where = '', $like = '')
    {
        $this->db->from('try');
        $this->db->where('status <>', 50);
        if ($where) {
            $this->db->where($where);
        }
        if ($like) {
            $this->db->like($like);
        }
        $temp = clone ($this->db);
        if($per_page==''&&$offset==''){
            $arr['lists'] = $this->db->order_by('id', 'desc')->get()->result_array();
        }else{
            $arr['lists'] = $this->db->order_by('id', 'desc')->limit($per_page, $offset)->get()->result_array();
        }
        //总数
        $this->db = $temp;
        $arr['total'] = $this->db->count_all_results();

        return $arr;
    }

    public function get_cate_name($ids)
    {
        $this->db->select('id,name');
        $this->db->where_in('id', $ids);
        $ret = $this->db->get('goods_category')->result_array();
        return $ret;
    }

    public function xml_notify($xml)
    {
        $result = $this->db->where('xml', $xml)->get('wxpay_notify')->row_array();
        if (!empty($result)) {
            return $result['id'];
        }
        $this->db->insert('wxpay_notify', array(
            'xml' => $xml,
            'dateline' => time()
        ));
        return $this->db->insert_id();
    }
}