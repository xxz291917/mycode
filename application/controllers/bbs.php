<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        var_dump($this->user);
        die;
    }
    
    
    public function post() {
        $post = $this->input->post(null, TRUE);
        if($post){
            var_dump($post);die;
            
            
            
        }else{
            $this->view('post');
        }
    }

    public function comments($e = "My Real Title") {
        $data['title'] = $e;
        $data['heading'] = "My Real Heading";
        $this->load->view('bbsview', $data);
    }

    public function _output($output) {
        //echo 333;
        echo $output;
    }

}

?>