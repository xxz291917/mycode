<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ask extends CI_Model {

    static $special = 2;
    static $special_post = 'ask_posts';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('poll_model','poll_options_model','poll_voter_model'));
//        $this->load->helper('date');
    }
    
    public function post($tid,$post) {
        if(empty($tid)||empty($post)){
            return FALSE;
        }
        //完成poll表的数据
        $poll_data['topic_id']=$tid;
        $poll_data['is_overt']=$post['is_overt'];
        $poll_data['is_multiple']=$post['max_choices']>1?1:0;
        $poll_data['is_visible']=$post['is_visible'];
        $poll_data['max_choices']=$post['max_choices'];
        $poll_data['expire_time']=strtotime($post['expire_time']);
        $poll_data['preview']=join('[|]',array_slice($post['poll_option'], 0, 2));
        $poll_data['voters']=0;
        $this->poll_model->insert($poll_data);
        //完成poll_options表的数据
        $options_data = array();
        foreach($post['poll_option'] as $k=>$v){
            $options_data[$k]['topic_id']=$tid;
            $options_data[$k]['display_order']=$k;
            $options_data[$k]['option']=$v;
        }
        $this->poll_options_model->insert_batch($options_data);
    }
    
    public function check_post($type = 'post') {
//        $this->form_validation->set_rules('highlight[0]', '高亮颜色', 'required|color');
//        $this->form_validation->set_rules('highlight[1]', '粗体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[2]', '斜体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[3]', '下划线', 'regex_match[/[01]/]');
//        $this->form_validation->set_message('regex_match', '%s参数不正确。');
//        $this->form_validation->set_message('color', '%s不是正确的颜色值。');
    }

}

?>
