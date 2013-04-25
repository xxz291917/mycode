<?php

class MY_Controller extends CI_Controller {

    protected $user;
    protected $forums;

    function __construct() {
        parent::__construct();

        $this->load->model(array('users_model', 'forums_model'));
        $this->load->helper(array());
        $this->load->library(array());
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
    }

    function message($message, $redirect = '', $type = 1) {
        $this->view->assign('message', $message);
        $this->view->assign('redirect', $redirect);
        if ($type == 0) {
            $this->view->display('message');
        } else if ($type == 1) {
            $this->view->display('admin_message');
        } else {
            $this->view->assign('ajax', 1);
            $this->view->assign('charset', WIKI_CHARSET);
            $this->view->display('message');
        }
        exit;
    }

}

class Admin_Controller extends CI_Controller {

    protected $admin_dir = 'admin';

    public function __construct() {
        parent::__construct();
    }

    public function view($view, $vars = array(), $string = false) {
        $view = $this->admin_dir . '/' . $view;
        $header = $this->admin_dir . '/admin_header';
        $footer = $this->admin_dir . '/admin_footer';
        if ($string) {
            $result = $this->load->view($header, $vars, true);
            $result .= $this->load->view($view, $vars, true);
            $result .= $this->load->view($footer, $vars, true);
            return $result;
        } else {
            $this->load->view($header, $vars);
            $this->load->view($view, $vars);
            $this->load->view($footer, $vars);
        }
    }

    protected function message($message, $redirect = 'BACK') {
        $vars['message'] = $message;
        $vars['redirect'] = $redirect;
        $this->view('admin_message',$vars);
    }

}