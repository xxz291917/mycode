<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view($this->admin_dir . '/admin_main');
    }

    public function info() {
        $this->view('main_info');
    }

    public function login() {
        $post = $this->input->post(NULL, TRUE);
        $this->load->model('users_admin_model');
        if ($post['submit']) {
            $username = trim($post['username']);
            $password = md5(trim($post['password']));
            $admin_user = $this->users_admin_model->get_one(array('username'=>$username,'password'=>$password));
            if ($admin_user['username'] == $username) {
                $user_info = json_encode($admin_user);
                $cookie = array(
                    'name' => 'user_info',
                    'value' => $this->encrypt->encode($user_info),
                    'expire' => '86400',
                );
                set_cookie($cookie);
                redirect(base_url('index.php/admin/main'));
            }
        }
        $this->load->view('admin_login');
    }

    public function logout() {
        $this->load->model('User_model');
        $this->User_model->logout();
        redirect(site_aurl('login'));
    }

}

?>