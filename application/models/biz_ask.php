<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 业务模型
 * 主要处理特殊帖子问答相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_Ask extends CI_Model {

    static $special = 2;
    static $special_post = 'ask_posts';
    static $special_post = 'ask_posts';
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('ask_model'));
//        $this->load->helper('date');
    }
    
    public function post($tid,$post) {
        if(empty($tid)||empty($post)){
            return FALSE;
        }
        //完成ask表的数据
        $ask_data['topic_id']=$tid;
        $ask_data['price']=$post['price'];
        $this->ask_model->insert($ask_data);
        //从用户身上扣减分数
        
        
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
