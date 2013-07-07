<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Editor extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model();
    }

    public function get_js() {
        $this->load->view('editor_js',$var);
    }
    
    
}
