<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model'));
        $this->load->helper('date');
    }

    public function process_statistics($statistics) {
        foreach ($statistics as $key => $value) {
            $statistics[$key] = $this->process_statistics_one($value);
        }
        return $statistics;
    }
    
    public function process_statistics_one($stat) {
        if(empty($stat)){
            return;
        }
        $stat['subject'] = $this->topics_model->get_subject_by_id($stat['last_post_id']);
        $stat['last_post_time'] = timespan($stat['last_post_time']);
        return $stat;
    }

}

?>
