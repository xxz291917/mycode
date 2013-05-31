<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poll extends CI_Model {

    static $special = 3;
    static $special_post = 'poll_posts';
    
    function __construct() {
        parent::__construct();
//        $this->load->model(array('poll_model'));
//        $this->load->helper('date');
    }

}

?>
