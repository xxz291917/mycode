<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credit_log_model extends MY_Model {

    public $credit_log_action = array('admin_set' => '后台管理员设置',
                                      'ask_action' => '发表问答扣减积分',);

    function __construct() {
        parent::__construct();
        $this->table = 'credit_log';
        $this->load->model(array('credit_rule_model'));
    }

    public function insert_log($credits, $uid, $action = 'admin_set') {
        if(array_key_exists($action,  $this->credit_log_action)){
            $credit_rule['name'] = $this->credit_log_action[$action];
        }else{
            $credit_rule = $this->credit_rule_model->get_one(array('action'=>$action),'name');
        }
        $user = $this->users_model->get_by_id($uid);
        $data['action']= $action;
        $data['description']= !empty($credit_rule['name'])?$credit_rule['name']:$action;
        $data['user_id']= $uid;
        $data['username']= $user['username'];
        $data['time']= $this->time;
        
        foreach ($credits as $key => $value) {
            if ($value==0 || !preg_match('/extcredits[1-8]/', $key))
                continue;
            $data['type'] = $key;
            $data['affect'] = intval($value);
            if(!$this->insert($data)){
                return FALSE;
            }
        }
        return TRUE;
    }
    
    
      /**
     * 获取我的帖子列表。
     * @param int $start
     * @param int $per_num
     */
    public function get_credit_list($type_name,$start, $per_num) {
        $userid = $this->user['id'];
        $where = "type='$type_name' and user_id='$userid' ";
        $result = parent::get_list($where, '*', '', $start, $per_num);
        return $result;
    }

    /**
     * 获取我的帖子记录数。
     */
    public function get_credit_count($type_name) {
        $userid = $this->user['id'];
        $where = "type='$type_name' and user_id='$userid' ";
        $num = $this->get_one($where, 'count(*) num');
        return $num['num'];
    }
    


}

?>
