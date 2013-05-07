<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups extends Admin_Controller {

    private $table = 'forums_model';

    function __construct() {
        parent::__construct();
        $this->load->model(array('groups_model', 'groups_admin_model'));
    }

    //'system', 'special', 'member'
    public function index($type = 'member') {
        if ($posts = $this->input->post()) {
            $is_update = $this->groups_model->update_old($this->input->post('old'), $type);
            $is_insert = $this->groups_model->insert_new($this->input->post('new'), $type);
            if ($is_update && $is_insert) {
                $this->message('操作成功');
            } else {
                $this->message('操作失败');
            }
        } else {
            //获取某个类别的用户组信息
            $groups = $this->groups_model->get_groups($type);
            $groups_admin = $this->groups_admin_model->get_groups('group_id');
            $admin_ids = array();
            foreach ($groups_admin as $key => $val) {
                $admin_ids[] = $val['group_id'];
            }
            $var['groups'] = $groups;
            $var['type'] = $type;
            $var['admin_ids'] = $admin_ids;
            $this->view('groups', $var);
        }
    }

    public function delete() {
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            //检查此用户组下是否有用户。
            if (!$this->users_model->exist_in_group($id)) {
                $message = $this->ajax_json(0, '此用户组下面存在用户，不允许被删除！');
            } else {
                if ($this->groups_model->delete(array('id' => $id))) {
                    $message = $this->ajax_json(1);
                } else {
                    $message = $this->ajax_json(0, '操作数据库失败！');
                }
            }
        } else {
            $message = $this->ajax_json(1);
        }
        echo $message;
        die;
    }

    public function edit($id = '', $type = 'basic') {
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $groups = $this->input->post();
            $groups = $this->groups_model->form_filter($groups, 'en');
            if ($this->groups_model->update($groups, array('id' => $id))) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->load->helper('form');
            $groups = $this->groups_model->get_by_id($id);
            $groups = $this->groups_model->form_filter($groups, 'de');
            $var['data'] = $groups;
            $this->view('groups_' . $type, $var);
        }
    }

    public function admin_edit($id = '') {
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $groups = $this->input->post();
            $groups = $this->groups_admin_model->form_filter($groups);
            if ($this->groups_admin_model->update($groups, array('group_id' => $id))) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            //获取某个类别的用户组信息
            $groups = $this->groups_admin_model->get_by_id($id);
            $var['data'] = $groups;
            $this->view('groups_admin', $var);
        }
    }

}

?>