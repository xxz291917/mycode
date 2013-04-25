<?php

class Forums extends Admin_Controller {

    private $table = 'forums_model';
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model('forums_model');
        if ($posts = $this->input->post()) {
            if ($this->forums_model->update_old($posts['old']) && $this->forums_model->insert_new($posts['new'])) {
                $this->message('操作成功');
            } else {
                $this->message('操作失败');
            }
        } else {
            //获取论坛版块内容
            $forums = $this->forums_model->get_forums();
            $var['forums'] = $forums;
            $this->view('admin_forums', $var);
        }
    }
    
    public function admin_index() {
        echo '测试信息';die;
    }

    public function login() {
        $post = $this->input->post(NULL, TRUE);
        if ($post['opt'] == 'ajax') {
            $this->load->model('User_model');
            $username = trim($post['user_name']);
            $userpass = trim($post['user_pass']);
            if ($this->User_model->login($username, $userpass)) {
                echo 'ok';
                exit;
            } else {
                echo 'error';
                exit;
            }
        }
        $this->load->view('login.php');
    }

    public function logout() {
        $this->load->model('User_model');
        $this->User_model->logout();
        redirect(site_aurl('login'));
    }

}

?>