<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medals extends Admin_Controller {

    public $type_names = array(0 => '手动颁发', 1 => '自动颁发', 2 => '申请颁发');

    function __construct() {
        parent::__construct();
        $this->load->model(array('medals_model', 'medals_log_model', 'users_medal_model'));
    }

    public function index() {
        if ($this->input->post('submit')) {
            $medals = $this->input->post(null, true);
            if (!empty($medals['old'])) {
                if ($this->medals_model->update_old($medals['old'])) {
                    unset($medals['old']);
                } else {
                    $this->message('修改分类失败');
                }
            }
            if (!empty($medals['new'])) {
                if ($is_insert = $this->medals_model->insert_new($medals['new'])) {
                    unset($medals['new']);
                } else {
                    $this->message('添加分类失败');
                }
            }
            $this->message('修改成功！', 1);
        } else {
            $medals = $this->medals_model->get_all();
            $var['type_names'] = $this->type_names;
            $var['medals'] = $medals;
            $this->view('medals', $var);
        }
    }

    public function delete() {
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            if ($this->medals_model->delete(array('id' => $id))) {
                $this->message('操作成功。', 1);
            } else {
                $this->message('操作数据库失败。');
            }
        } else {
            $this->message('操作成功。', 1);
        }
    }

    public function detail($id) {
        if (empty($id)) {
            $this->message('参数错误！');
        }
        if ($this->input->post('submit')) {
            $medal = $this->input->post(null, true);
            $update_data['name'] = trim($medal['name']);
            $update_data['image'] = trim($medal['image']);
            $update_data['type'] = intval($medal['type']) ? 1 : 0;
            $update_data['expired_time'] = strtotime($medal['expired_time']);
            $update_data['description'] = trim($medal['description']);
            $update_data['condition'] = trim($medal['condition']);
            if ($this->medals_model->update($update_data, array('id' => $id))) {
                $this->message('修改成功！', 1);
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->load->model('credit_name_model');
            $medal = $this->medals_model->get_by_id($id);
            $var['data'] = $medal;
            $var['medal_tags'] = $this->medals_model->get_medal_tags();
            $this->view('medals_detail', $var);
        }
    }

    public function award() {
        if ($this->input->post('submit')) {
            $this->load->model(array('medals_log_model','users_medal_model'));
            $award = $this->input->post(null, true);
            //处理空格分隔的用户名
            $user_name = trim($award['user_name']);
            if( empty($user_name)|| !isset($award['medals']) || count($award['medals'])==0){
                $this->message('参数错误，用户名或者勋章必须选择！');
            }
            $user_names = preg_split('/\s+/', $award['user_name']);
            $users = $this->users_model->get_user_by_names($user_names);
            if(empty($users)){
                $this->message('参数错误，没找到用户！');
            }
            $log_data = $user_medal_data = array();
            $expired_time = strtotime($award['expired_time']);
            if(!empty($expired_time) && $expired_time+(3600*24) <= $this->time){
                $this->message('参数错误，过期时间不能小于当前时间！');
            }
            foreach ($users as $key=>$user) {
                $my_medals = $this->users_medal_model->get_list(array('user_id'=>$user['id']));
                if(!empty($my_medals)){
                    $my_key_medals = array();
                    foreach ($my_medals as $my_medal) {
                        $my_key_medals[] = $my_medal['medal_id'];
                    }
                }
                foreach ($award['medals'] as $k => $medal_id) {
                    if(!empty($my_key_medals) && in_array($medal_id, $my_key_medals)){
                        continue;
                    }
                    $log_data[$key.'_'.$k]['user_id'] = $user['id'];
                    $log_data[$key.'_'.$k]['medal_id'] = $medal_id;
                    $log_data[$key.'_'.$k]['time'] = $this->time;
                    $log_data[$key.'_'.$k]['expired_time'] = $expired_time;
                    
                    $user_medal_data[$key.'_'.$k]['user_id'] = $user['id'];
                    $user_medal_data[$key.'_'.$k]['medal_id'] = $medal_id;
                    $user_medal_data[$key.'_'.$k]['expired_time'] = $expired_time;
                }
            }
            if(empty($log_data) || empty($user_medal_data)){
                $this->message('所有用户都已拥有此勋章，数据库未做任何改变！',1);
            }else{
              $is_log_succ = $this->medals_log_model->insert_batch($log_data);
              $is_user_medal_succ = $this->users_medal_model->insert_batch($user_medal_data);
              if ($is_log_succ && $is_user_medal_succ) {
                    $this->message('修改成功！', 1);
                } else {
                    $this->message('修改失败！');
                }
            }
        } else {
            $where  = "(expired_time='' || expired_time >'{$this->time}') AND is_open = 1 AND type = 0";
            $award = $this->medals_model->get_list($where, '*', 'display_order');
            $var['medals'] = $award;
            $this->view('medals_award', $var);
        }
    }

}

?>