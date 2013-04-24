<?php

class MY_Controller extends CI_Controller {

    protected $user;
    protected $forums;

    function __construct() {
        parent::__construct();
        
        $this->load->model(array('users_model','forums_model'));
        $this->load->helper(array());
        $this->load->library(array());
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
    }

}

class Admin_Controller extends CI_Controller {
    protected $admin_dir = 'admin';
            
    function __construct() {
        parent::__construct();
    }
    
    function view($view, $vars = array(), $string = false) {
        $view = $this->admin_dir.'/'.$view;
        $header = $this->admin_dir.'/admin_header';
        $footer = $this->admin_dir.'/admin_footer';
        if ($string) {
            $result  = $this->load->view($header, $vars, true);
            $result .= $this->load->view($view, $vars, true);
            $result .= $this->load->view($footer, $vars, true);
            return $result;
        } else {
            $this->load->view($header, $vars);
            $this->load->view($view, $vars);
            $this->load->view($footer, $vars);
        }
    }

}