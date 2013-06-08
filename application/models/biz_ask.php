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
    static $ask_credit_action = 'ask_action'; //发表问题积分动作关键字
    
    public $ask_credit_type = 'extcredits2';//发表问题所有扣减的积分项
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('ask_model','users_extra_model'));
//        $this->load->helper('date');
    }
    
    public function post($tid,$post) {
        if(empty($tid)||empty($post)){
            return FALSE;
        }
        //完成ask表的数据
        $ask_data['topic_id']=$tid;
        $ask_data['price']=$post['price'];
        $is_insert = $this->ask_model->insert($ask_data);
        //从用户身上扣减分数
        $credits = array($this->ask_credit_type=>0-$post['price']);
        $is_update_credit = $this->users_extra_model->update_credits($credits,  $this->user['id'],  self::$ask_credit_action);
        if($is_insert && $is_update_credit){
            return TRUE; 
        }else{
            log_message('error', '发表问题，扣减积分出错。');
            return false;
        }
    }
    
    public function check_post($type = 'post') {
//        $this->form_validation->set_rules('highlight[0]', '高亮颜色', 'required|color');
//        $this->form_validation->set_rules('highlight[1]', '粗体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[2]', '斜体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[3]', '下划线', 'regex_match[/[01]/]');
//        $this->form_validation->set_message('regex_match', '%s参数不正确。');
//        $this->form_validation->set_message('color', '%s不是正确的颜色值。');
    }
    
    public function init_var(){
        $this->load->model('credit_name_model');
        //得到对应的积分名字
        $var['view_name'] = $this->credit_name_model->get_view_name($this->ask_credit_type);
        //得到当前用户的积分数
        $var['price'] = $this->user[$this->ask_credit_type];
        return $var;
    }

}

?>
