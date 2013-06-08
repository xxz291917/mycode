<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 业务模型
 * 主要处理特殊帖子辩论相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_debate extends CI_Model {

    static $special = 4;
    static $special_post = 'debate_posts';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('debate_model','debate_posts_model'));
//        $this->load->helper('date');
    }
    
    public function post($tid,$post) {
        if(empty($tid)||empty($post)){
            return FALSE;
        }
        //完成debate表的数据
        $debate_data['topic_id']=$tid;
        $debate_data['user_id']=$this->user['id'];
        $debate_data['start_time']=$this->time;
        $debate_data['end_time']=  strtotime($post['end_time']);
        $debate_data['umpire']=$post['umpire'];
        $debate_data['affirm_point']=$post['affirm_point'];
        $debate_data['negate_point']=$post['negate_point'];
        $this->debate_model->insert($debate_data);
    }
    
    public function check_post($type = 'post') {
        $this->form_validation->set_rules('affirm_point', '正方观点', 'trim|required|max_length[1500]');
        $this->form_validation->set_rules('negate_point', '反方观点', 'trim|required|max_length[1500]');
        $this->form_validation->set_rules('end_time', '结束日期', 'is_strtotime');
        $this->form_validation->set_rules('umpire', '裁判员', 'trim|required|callback_username_check');
    }

}

?>
