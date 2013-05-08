<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public $user;

    function __construct() {
        parent::__construct();
        $this->load->model(array('users_model', 'forums_model'));
        //初始化用户信息（包括所属用户组）
        $this->user = $this->users_model->get_userinfo();
//        var_dump($this->user);die;
    }

    protected function ajax_json($success = 1, $data = array()) {
        return json_encode(array('success' => $success, 'data' => $data));
    }

}

class MY_Controller extends Base_Controller {

    public $forums;

    function __construct() {
        parent::__construct();
        $this->load->model();
        $this->load->helper(array());
        $this->load->library(array('user_agent'));
        //初始化版块信息
        $this->forums = $this->forums_model->initialize();
        //echo $this->agent->referrer();die;
    }

}

class Admin_Controller extends Base_Controller {

    protected $admin_dir = 'admin';
    protected $query_string_segment = 'per_page';
    protected $date_format = 'Y-m-d H:i:s';

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->vars('date_format',  $this->date_format);
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
        $vars['message'] = $message;
        $vars['redirect'] = $redirect;
        $this->view('message', $vars);
    }

    /*
     *  <p class="pagination">
      &nbsp;共32条&nbsp;
      <span class="gray">1</span>
      <a href="index.php?admin_doc-search----0-0--2">2</a>
      <a href="index.php?admin_doc-search----0-0--2">››</a>
      </p>
     */
    protected function create_page($base_url = '', $total_rows, $per_page = 20) {
        $this->load->library('pagination');
        $config['base_url'] = !empty($base_url) ? $base_url : current_url();
        $config['total_rows'] = $total_rows;
        $config['per_page'] = !empty($per_page) ? $per_page : 20;
        $config['uri_segment'] = 3;
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
        $config['query_string_segment'] = $this->query_string_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    protected function get_per_page($default = 0) {
        $per_page = $this->input->get($this->query_string_segment, TRUE);
        empty($per_page) && $per_page = $default;
        return $per_page;
    }
    
}