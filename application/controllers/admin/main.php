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
        if($this->admin){
            redirect(base_url('index.php/admin/main'));
        }
        $post = $this->input->post(NULL, TRUE);
        $message = '';
        if ($post['submit']) {
            $this->load->model('users_admin_model');
            $username = trim($post['username']);
            $password = md5(trim($post['password']));
            if ($username != $this->user['username']) {
                $message = '请先在前台登录同名用户！';
            } else {
                $admin_user = $this->users_admin_model->get_one(array('username' => $username, 'password' => $password));
                if (!empty($admin_user['username']) && $admin_user['username'] == $username) {
                    $user_info = json_encode($admin_user);
                    $cookie = array(
                        'name' => 'user_info',
                        'value' => $this->encrypt->encode($user_info),
                        'expire' => 3600*24*30,
                    );
                    set_cookie($cookie);
                    redirect(base_url('index.php/admin/main'));
                } else {
                    $message = '用户名或者密码错误！';
                }
            }
        }
        $var['message'] = $message;
        $this->load->view($this->admin_dir.'/admin_login', $var);
    }

    public function logout() {
        $cookie = array(
            'name' => 'user_info',
            'value' => '',
        );
        set_cookie($cookie);
        $this->message('您已经退出管理中心！');
    }

}

?>