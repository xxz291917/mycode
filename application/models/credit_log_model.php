<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credit_log_model extends MY_Model {

    public $credit_log_action = array('admin_set' => '后台管理员设置');

    function __construct() {
        parent::__construct();
        $this->table = 'credit_log';
        $this->load->model(array('credit_rule_model'));
    }

    public function insert_credits($credits, $uid, $action = 'admin_set') {
        if(array_key_exists($action,  $this->credit_log_action)){
            $credit_rule['name'] = $this->credit_log_action[$action];
        }else{
            $credit_rule = $this->credit_rule_model->get_one(array('action'=>$action),'name');
        }
        $user = $this->users_model->get_by_id($uid);
        $data['action']= $action;
        $data['description']= $credit_rule['name'];
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

}

?>
