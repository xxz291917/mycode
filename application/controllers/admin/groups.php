<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends Admin_Controller {

    private $table = 'forums_model';

    function __construct() {
        parent::__construct();
        $this->load->model(array('groups_model'));
    }

    //'system', 'special', 'member'
    public function index($type='member') {
        if ($posts = $this->input->post()) {
            $is_update = $this->groups_model->update_old($this->input->post('old'),$type);
            $is_insert = $this->groups_model->insert_new($this->input->post('new'),$type);
            if ($is_update && $is_insert) {
                $this->message('操作成功');
            } else {
                $this->message('操作失败');
            }
        } else {
            //获取某个类别的用户组信息
            $groups = $this->groups_model->get_groups($type);
            $var['groups'] = $groups;
            $var['type'] = $type;
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
                if ($this->groups_model->delete(array('id'=>$id))) {
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
            $forums = $this->input->post();
            $forums = $this->forums_model->form_filter($forums, 'en');
            if ($this->forums_model->update($forums, array('id' => $id))) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $this->load->helper('form');
            $forums = $this->forums_model->get_by_id($id);
            $forums = $this->forums_model->form_filter($forums, 'de');
            $var['data'] = $forums;
            //如果是权限设置，还要获取用户组信息。
            if ($type == 'access') {
                $this->load->model('groups_model');
                $var['groups'] = $this->groups_model->get_all();
                $var['group_names'] = array('system' => '系统用户组', 'member' => '会员用户组', 'special' => '特殊用户组');
            } elseif ($type == 'credit') {
                //获取启用的积分名称
                $this->load->model('credit_name_model');
                $var['credit_names'] =$this->credit_name_model->get_all();
                $this->load->model('credit_rule_model');
                $var['credit_rules'] =$this->credit_rule_model->get_all();
                $var['cycle_names'] = array(0 => '一次', 1 => '一天', 2 => '整点',3=>'间隔时间',4=>'不限');
            }
            $this->view('groups_' . $type, $var);
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
            //获取积分规则
            
            //获取启用的积分名称
//            credit_name
            
            $forums = $this->forums_model->form_filter($forums, 'de');
            $var['data'] = $forums;
            $this->view('forums_' . $type, $var);
        }
    }
    
    
    public function logout() {
        $this->load->model('User_model');
        $this->User_model->logout();
        redirect(site_aurl('login'));
    }

}

?>