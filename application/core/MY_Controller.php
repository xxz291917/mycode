<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public $user;
    public $ip;
    public $time;
    
    public $enable_cache = false;//是否开启cache

    public function __construct() {
        parent::__construct();
        //aotoload.php中自动加载了$autoload['libraries'] = array('database');$autoload['helper'] = array('url','form');
        $this->load->model(array('users_model', 'groups_model', 'forums_model','users_extra_model'));
        $this->load->library(array('user_agent','encrypt'));
        $this->load->helper('cookie');
        $this->config->load('my_config');
        if(config_item('enable_cache')){
            $this->enable_cache = true;
            $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
        }
        $this->output->enable_profiler(config_item('enable_profiler')); //是否开启profiler。
        
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
        $this->ip = $this->input->ip_address();
        $this->time = time();
        
//        $this->permission = $this->config_model->get_config();
        
        if(!empty($this->user)){//如果用户登录了，则添加最后活动时间，更新在线时长。
            $this->users_extra_model->update_user_active();
        }
//        var_dump($this->user);die;
    }

    protected function echo_ajax($success = 1, $message = '', $data = array(), $redirect='') {
        $ajax_arr = array(
            'success' => $success,
            'message' => $message,
        );
        if (!empty($data)) {
            $ajax_arr['data'] = $data;
        }
        if (!empty($redirect)) {
            $ajax_arr['redirect'] = $redirect;
        }
        
        return json_encode($ajax_arr);
    }

    protected function get_current_url() {
        return base_url("index.php/{$this->uri->segment(1)}/{$this->uri->segment(2)}");
    }
    
}

class MY_Controller extends Base_Controller {

    public $forums;

    public function __construct() {
        parent::__construct();
        $this->load->model(array('biz_permission','config_model'));
        $this->load->helper(array());
        $this->load->library(array());
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
        $this->configs = $this->config_model->get_config();
        //echo $this->agent->referrer();die;
    }

    public function view($view, $vars = array(), $string = false) {
        $view = $view;
        $header = 'header';
        $footer = 'footer';
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

    protected function message($message, $sucess = 0, $redirect = 'BACK') {
        //判断是否是ajax提交
        if ($this->input->is_ajax_request()) {
            $redirect = $redirect == 'BACK' ? '' : $redirect;
            echo $this->echo_ajax($sucess, $message, '', $redirect);
        } else {
            global $OUT;
            $vars['message'] = $message;
            $vars['redirect'] = $redirect;
            $this->view('message', $vars);
            $OUT->_display();
        }
        die;
    }

}

class Admin_Controller extends Base_Controller {

    protected $admin_dir = 'admin';
    protected $date_format = 'Y-m-d H:i:s';
    protected $admin;

    public function __construct() {
        parent::__construct();
        $this->load->vars('date_format', $this->date_format);
        //检查是否是登录用户
        $user_info = get_cookie('user_info');
        if(!empty($user_info)){
            $user_info = $this->encrypt->decode($user_info);
            $user_info = json_decode($user_info, TRUE);
            if(!empty($user_info['id']) && $user_info['id']==$this->user['id']){
                $this->admin = true;
            }
        }
        if(!$this->admin){
            global $OUT;
            $this->load->view('admin/admin_login');
            $OUT->_display();
            die;
        }
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
    
    protected function message($message, $success = 0, $redirect = 'BACK') {
        //判断是否是ajax提交
        if ($this->input->is_ajax_request()) {
            echo $this->echo_ajax($redirect, $message);
        } else {
            global $OUT;
            $vars['message'] = $message;
            $vars['success'] = $success;
            $vars['redirect'] = $redirect;
            $this->view('message', $vars);
            $OUT->_display();
        }
        die;
    }

    /*
     *  <p class="pagination">
      &nbsp;共32条&nbsp;
      <span class="gray">1</span>
      <a href="index.php?admin_doc-search----0-0--2">2</a>
      <a href="index.php?admin_doc-search----0-0--2">››</a>
      </p>
     */
    protected function init_page($base_url = '', $total_rows, $per_page = 20, $my_config = array()) {
        $this->load->library('pagination');
        $config['base_url'] = !empty($base_url) ? $base_url : current_url();
        $config['total_rows'] = $total_rows;
        $config['per_page'] = !empty($per_page) ? $per_page : 20;
        $config['page_query_string'] = true;
        //结构和样式
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<p class="pagination">';
        $config['full_tag_close'] = '</p>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $config['first_link'] = '第一页';
        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';
        $config['last_link'] = '最后一页';
        $config['query_string_segment'] = 'per_page';
        if (!empty($my_config)) {
            $config = array_merge($config, $my_config);
        }
        $this->pagination->initialize($config);
        return $this->pagination;
    }

}