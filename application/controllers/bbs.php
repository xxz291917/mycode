<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('index','forums_statistics_model'));
    }

    public function index() {
        //获取所有版块
        $forums = $this->forums_model->get_forums();
        $forums = $this->forums_statistics_model->append_to_forums($forums);
        $var['forums'] = $this->forums_model->get_format_forums($forums);
        //var_dump($var['forums']);die;
        //var_dump($this->user);
        $this->view('bbs_index',$var);
    }
    
}

?>