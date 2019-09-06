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
        return $this->db->select($select)->where($condition)->get('wx_user')->row_array();
    }

    public function insert_wxlogin($param, $wx_param)
    {
        $this->db->trans_begin();

        $this->db->insert('wx_login_client', $param);

        $this->db->insert('wx_user', $wx_param);
        $wu_user_id = $this->db->insert_id();

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $wu_user_id;
        }
    }

    public function update_wxlogin($condition = '', $param, $wx_param)
    {
        $this->db->trans_begin();

        $this->db->where($condition)->update('wx_login_client', $param);
        $this->db->where($condition)->update('wx_user', $wx_param);
        $wx_user = $this->db->where($condition)->get('wx_user')->row_array();
        if ($wx_user['uid']) {
            $this->db->where(array('uid' => $wx_user['uid']))->update('user', array('last_login_ip' => ip('int'), 'last_login_time' => time()));
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $wx_user['id'];
        }
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