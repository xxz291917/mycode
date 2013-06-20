<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理首页相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_index extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model'));
        //$this->load->helper('date');
    }

    public function process_statistics($statistics) {
        foreach ($statistics as $key => $value) {
            $statistics[$key] = $this->process_statistics_one($value);
        }
        return $statistics;
    }

    public function process_statistics_one($stat) {
        if (empty($stat)) {
            return;
        }
        $stat['subject'] = $this->topics_model->get_subject_by_id($stat['last_post_id']);
        //处理时间为“最近……”的形式
        $stat['last_post_time'] = time_span($stat['last_post_time']);
        return $stat;
    }

}

?>
