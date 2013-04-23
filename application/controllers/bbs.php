<?php

class Bbs extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        //echo 'Hello World!';
        var_dump( $this->db);die;
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