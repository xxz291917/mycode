<?php

class Forums extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //获取论坛版块内容
        
        
        
        $this->view('admin_forums');
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