<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public $user;
    public $ip;
    public $time;

    public function __construct() {
        parent::__construct();
        //aotoload.php中自动加载了$autoload['libraries'] = array('database');$autoload['helper'] = array('url','form');
        $this->load->model(array('users_model', 'groups_model', 'forums_model'));
        $this->load->library(array('user_agent'));
        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
        $this->ip = $this->input->ip_address();
        $this->time = time();
//        var_dump($this->user);die;
//        $this->output->enable_profiler(TRUE); //是否开启profiler。
    }

    protected function echo_ajax($success = 1, $message = '', $data = array()) {
        $ajax_arr = array(
            'success' => $success,
            'message' => $message,
        );
        if (!empty($data)) {
            $ajax_arr['data'] = $data;
        }
        return json_encode($ajax_arr);
    }

    protected function get_current_url() {
        return base_url("index.php/{$this->uri->segment(1)}/{$this->uri->segment(2)}");
    }

    protected function upload() {
//        $config['upload_path'] = './uploads/';
//        $config['allowed_types'] = 'gif|jpg|png';
//        $config['max_size'] = '100';
//        $config['max_width'] = '1024';
//        $config['max_height'] = '768';
        $this->load->library('upload');
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        }
    }

}

class MY_Controller extends Base_Controller {

    public $forums;

    public function __construct() {
        parent::__construct();
        $this->load->model(array());
        $this->load->helper(array());
        $this->load->library(array());
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
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

    protected function message($message, $redirect = 'BACK') {
        //判断是否是ajax提交
        if ($this->input->is_ajax_request()) {
            echo $this->echo_ajax($redirect, $message);
        } else {
            global $OUT;
            $vars['message'] = $message;
            $vars['redirect'] = $redirect;
            $this->view('message', $vars);
            $OUT->_display();
        }
        die;
    }

    /**
      <p class="pagination">
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

class Admin_Controller extends Base_Controller {

    protected $admin_dir = 'admin';
    protected $date_format = 'Y-m-d H:i:s';

    public function __construct() {
        parent::__construct();
        $this->load->vars('date_format', $this->date_format);
//        $this->config->load('admin');
//        var_dump($this->config->item('query_string_segment'));die;
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
        //判断是否是ajax提交
        if ($this->input->is_ajax_request()) {
            echo $this->echo_ajax($redirect, $message);
        } else {
            global $OUT;
            $vars['message'] = $message;
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