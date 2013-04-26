<?php

class Base_Controller extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    protected function ajax_json($success=1,$data=array()){
        return json_encode(array('success'=>$success,'data'=>$data));
    }
}

class MY_Controller extends Base_Controller {

    protected $user;
    protected $forums;

    function __construct() {
        parent::__construct();
        $this->load->model(array('users_model', 'forums_model'));
        $this->load->helper(array());
        $this->load->library(array('user_agent'));
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
        //echo $this->agent->referrer();die;
    }

}

class Admin_Controller extends Base_Controller {

    protected $admin_dir = 'admin';

    public function __construct() {
        parent::__construct();
    }

    public function view($view, $vars = array(), $string = false) {
        $view = $this->admin_dir . '/' . $view;
        $header = $this->admin_dir . '/header';
        $footer = $this->admin_dir . '/footer';
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
        $this->view('message',$vars);
    }

}