<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forums extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('forums_model'));
    }

    public function index() {
        if ($posts = $this->input->post()) {
            $is_update = $this->forums_model->update_old($this->input->post('old'));
            $is_insert = $this->forums_model->insert_new($this->input->post('new'));
            if ($is_update && $is_insert) {
                $this->message('操作成功');
            } else {
                $this->message('操作失败');
            }
        } else {
            //获取论坛版块内容
            $forums = $this->forums_model->get_format_forums();
            $var['forums'] = $forums;
            $this->view('forums', $var);
        }
    }

    public function delete() {
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            //检查此版块下是否有帖子、
            $this->load->model('topics_model');
            if (!$this->topics_model->exist_in_forum($id)) {
                $message = $this->echo_ajax(0, '此版块下面存在主题，不允许被删除！');
            } else {
                if ($this->db->delete('forums', array('id' => $id))) {
                    $message = $this->echo_ajax(1);
                } else {
                    $message = $this->echo_ajax(0, '操作数据库失败！');
                }
            }
        } else {
            $message = $this->echo_ajax(1);
        }
        echo $message;
        die;
    }

    public function delete_category() {
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            $this->load->model('topics_category_model');
            if ($this->topics_category_model->delete(array('id' => $id))) {
                $this->message('操作成功。', 1);
            } else {
                $this->message('操作数据库失败。');
            }
        } else {
            $this->message('操作成功。', 1);
        }
    }

    public function edit($id = '', $type = 'basic') {
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $forums = $this->input->post();
            
            //需要加入操作主题分类
            if ($type == 'category') {
                $this->load->model('topics_category_model');
                if(!empty($forums['old'])){
                    if($this->topics_category_model->update_old($forums['old'],$id)){
                        unset($forums['old']);
                    }else{
                        $this->message('修改分类失败');
                    }
                }
                if(!empty($forums['new'])){
                    if($is_insert = $this->topics_category_model->insert_new($forums['new'],$id)){
                        unset($forums['new']);
                    }else{
                        $this->message('添加分类失败');
                    }
                }
            }
            
            $forums = $this->forums_model->form_filter($forums, 'en');
            if ($this->forums_model->update($forums, array('id' => $id))) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $forums = $this->forums_model->get_by_id($id);
            $forums = $this->forums_model->form_filter($forums, 'de');
            $var['data'] = $forums;
            //如果是权限设置，还要获取用户组信息。
            if ($type == 'access') {
                $this->load->model('groups_model');
                $var['groups'] = $this->groups_model->get_groups();
                $var['group_names'] = array('system' => '系统用户组', 'member' => '会员用户组', 'special' => '特殊用户组');
            } elseif ($type == 'credit') {
                //获取启用的积分名称
                $this->load->model('credit_name_model');
                $var['credit_names'] = $this->credit_name_model->get_all();
                $this->load->model('credit_rule_model');
                $var['credit_rules'] = $this->credit_rule_model->get_all();
                $var['cycle_names'] = array(0 => '一次', 1 => '一天', 2 => '整点', 3 => '间隔时间', 4 => '不限');
            } elseif ($type == 'category') {
                //获取本版块下的主题分类
                $this->load->model('topics_category_model');
                $categorys = $this->topics_category_model->get_list(array('forum_id'=>$id),'*','display_order');
                $var['categorys'] = !empty($categorys) ? $this->topics_category_model->key_list($categorys) : array();
            }
            $this->view('forums_' . $type, $var);
        }
    }

    public function credit_edit($id = '') {
        if (empty($id)) {
            $this->message('参数错误！');
        } elseif ($this->input->post('submit')) {
            $forums = $this->input->post();
            $forums = $this->forums_model->form_filter($forums, 'en');
            if ($this->forums_model->update($forums, array('id' => $id))) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->load->helper('form');
            //获取版块积分设置
            $forums = $this->forums_model->get_by_id($id);
            $forums_setting = $this->forums_setting_model->get_by_id($id);
            $forums_setting['credit_setting'];
            $forums = $this->forums_model->form_filter($forums, 'de');
            $var['data'] = $forums;
            $this->view('forums_' . $type, $var);
        }
    }

}

?>