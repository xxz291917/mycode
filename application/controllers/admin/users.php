<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('users_model', 'groups_model','groups_admin_model', 'users_extra_model','users_belong_model'));
    }

    public function index() {
        $search = $this->input->get(null, TRUE);
        $where = '1 ';
        if (!empty($search['groups'])) {
            $group_ids = join(',', $search['groups']);
            $where .= "and (group_id in($group_ids) or member_id in($group_ids)) ";
        }
        if (!empty($search['username'])) {
            $search['username'] = trim($search['username']);
            $where .= "and username = '{$search['username']}' ";
        }
        if (!empty($search['email'])) {
            $search['email'] = trim($search['email']);
            $where .= "and email = '{$search['email']}' ";
        }
        
        //生成分页字符串
        $total_num = $this->users_model->get_count($where);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 20;
        $page_obj = $this->init_page($base_url, $total_num,$per_num);
        $page_str = $page_obj->create_links();
        //获取用户
        $start = max(0,($page_obj->cur_page-1)*$per_num);
        $users = $this->users_model->get_list($where, '*', '', $start,$per_num);
        
        //得到用户组选项
        $default_groups = !empty($search['groups']) ? $search['groups'] : array();
        $var['groups_option'] = $this->groups_model->create_options($default_groups);
        $var['data'] = $search;
        $var['users'] = $users;
        $var['page'] = $page_str;
        $this->view('users', $var);
    }

    public function edit($id = '', $type = 'basic') {
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $users = $this->input->post();
            
            if($type == 'group'){
                !isset($users['groups']) && $users['groups'] = array();
                foreach ($users['end_time'] as $key => $value) {
                    if (!in_array($key, $users['groups']))
                        unset($users['end_time'][$key]);
                }
                $this->users_belong_model->update_batch($users['end_time'], $id);
                unset($users['end_time']);
            }
            $users = $this->users_model->form_filter($users, 'en');
            if ($type !== 'credit') {
                $usersucc = $this->users_model->update($users, array('id' => $id));
            } else {
                $usersucc = $this->users_extra_model->admin_credits($users,$id);
            }
            if ($usersucc) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->load->helper('form');
            $users = $this->users_model->get_by_id($id);
            $users = $this->users_model->form_filter($users, 'de');
            $var['data'] = $users;
            $var['users_extra'] = $this->users_extra_model->get_by_id($id);
            if ($type == 'credit') {
                //获取启用的积分名称
                $this->load->model('credit_name_model');
                $var['credit_names'] = $this->credit_name_model->get_all();
            }elseif($type == 'group') {
                $default = $users['group_id']!=0?array($users['group_id']):array(0);
                $var['options'] = $this->groups_model->create_options($default);
                $var['groups'] = $this->groups_admin_model->get_groups();
                $users_belong = $this->users_belong_model->get_list(array('user_id'=>$id));
                if($users_belong){
                    foreach ($users_belong as $value) {
                        $var['users_belong'][$value['group_id']] = $value['end_time'];
                    }
                }else{
                    $var['users_belong']=array();
                }
            }
            $this->view('users_' . $type, $var);
        }
    }

}

?>