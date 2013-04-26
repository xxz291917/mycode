<?php

class Forums extends Admin_Controller {

    private $table = 'forums_model';

    function __construct() {
        parent::__construct();
        $this->load->model('forums_model');
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
                $message = $this->ajax_json(0, '此版块下面存在主题，不允许被删除！');
            } else {
                if ($this->db->delete('forums', array('id' => $id))) {
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

    public function edit($id='') {
        if (empty($id) && !$this->input->post('submit')) {
            $this->message('参数错误！');
        } else if($this->input->post('submit')){
            $forums = $this->input->post();
            if(1){
               $this->message('参数错误！'); 
            }
            $this->message('参数错误！');
        }
        $this->load->helper('form');
        $forums = $this->forums_model->get_by_id($id);
        $var['data'] = $forums;
        $this->view('forums_edit', $var);
    }

    public function logout() {
        $this->load->model('User_model');
        $this->User_model->logout();
        redirect(site_aurl('login'));
    }

}

?>