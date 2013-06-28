<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_admin extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('users_model','users_admin_model'));
    }

    public function index() {
        $search = $this->input->get(null, TRUE);
        $where = '1 ';
        if (!empty($search['username'])) {
            $search['username'] = trim($search['username']);
            $where .= "and username = '{$search['username']}' ";
        }
        if (!empty($search['email'])) {
            $search['email'] = trim($search['email']);
            $where .= "and email = '{$search['email']}' ";
        }
        
        //生成分页字符串
        $total_num = $this->users_admin_model->get_count($where);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 20;
        $page_obj = $this->init_page($base_url, $total_num,$per_num);
        $page_str = $page_obj->create_links();
        //获取用户
        $start = max(0,($page_obj->cur_page-1)*$per_num);
        $users = $this->users_admin_model->get_list($where, '*', '', $start,$per_num);
        
        //得到用户组选项
        $default_groups = !empty($search['groups']) ? $search['groups'] : array();
        $var['data'] = $search;
        $var['users'] = $users;
        $var['page'] = $page_str;
        $this->view('users_admin', $var);
    }

    public function delete() {
        $user_id = intval($this->input->post('user_id'));
        if ($user_id > 0) {
            if ($this->users_admin_model->delete(array('user_id' => $user_id))) {
                $this->message('操作成功。', 1);
            } else {
                $this->message('操作数据库失败。');
            }
        } else {
            $this->message('参数错误。');
        }
    }
    
    public function edit($id = '') {
        $id = intval($id);
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $users = $this->input->post();
            $users['password'] = trim($users['password']);
            $users['repassword'] = trim($users['repassword']);
            if(empty($users['password'])){
                $this->message('密码不能为空！');
            }elseif($users['password']!=$users['repassword']){
                $this->message('两次密码输入不一致！');
            }else{
                $update_data['password'] = md5($users['password']);
            }
            $usersucc = $this->users_admin_model->update($update_data, array('user_id' => $id));
            if ($usersucc) {
                $this->message('修改成功！',1);
            } else {
                $this->message('修改失败！');
            }
        } else {
            $users = $this->users_admin_model->get_by_id($id);
            $var['data'] = $users;
            $this->view('users_admin_basic', $var);
        }
    }
    
    public function add() {
        if ($this->input->post('submit')) {
            $users = $this->input->post();
            $users['username'] = trim($users['username']);
            $users['email'] = trim($users['email']);
            $users['password'] = trim($users['password']);
            $users['repassword'] = trim($users['repassword']);
            if(empty($users['username'])){
                $this->message('用户名不能为空！');
            }
            $users_admin = $this->users_admin_model->get_one(array('username'=>$users['username']));
            if(!empty($users_admin)){
                $this->message('此用户已经是管理员！');
            }
            $user = $this->users_model->get_user_by_name($users['username']);
            if(empty($user['id'])){
                $this->message('用户名不是前台存在的用户！');
            }else{
                $users['user_id'] = $user['id'];
            }
            if(empty($users['password'])){
                $this->message('密码不能为空！');
            }elseif($users['password']!=$users['repassword']){
                $this->message('两次密码输入不一致！');
            }
            unset($users['submit'],$users['repassword']);
            $usersucc = $this->users_admin_model->insert($users);
            if ($usersucc) {
                $this->message('修改成功！',1);
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->view('users_admin_add');
        }
    }

}

?>