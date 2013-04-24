<?php

class Bbs extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->model('users_model');
        $this->users_model->get_userinfo();
        //echo 'Hello World!';
        //$this->load->library('someclass');
        //$this->someclass->test();  // 对象的实例名永远都是小写的 
        //$this->load->library('email');
        die;
    }

    public function comments($e = "My Real Title") {
        $data['title'] = $e;
        $data['heading'] = "My Real Heading";

        $this->load->view('bbsview', $data);
    }
//public function _remap($method)
//{
//    if ($method == 'index')
//    {
//        $this->$method();
//    }
//    else
//    {
//        $this->comments();
//    }
//}

public function _output($output)
{
    echo 333;
    echo $output;
}
}

?>