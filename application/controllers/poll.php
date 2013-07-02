<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model','poll_model'));
    }

    /**
     * 用户提交投票选项
     */
    public function submit($topic_id) {
        $post_key = 'option_'.$topic_id;
        $options = $this->input->post($post_key,TRUE);
        if(empty($options)||empty($topic_id)){
            $this->message('参数错误，请重新检查');
        }
        
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，投票的主题不存在');
        }
        //检测是否有投票的权限，等同于回复权限。
        $is_post = $this->biz_permission->check_base('reply', $topic['forum_id']);
        if (!$is_post) {
            $this->message('您没有投票的权限');
        }
        
        $poll = $this->poll_model->get_by_id($topic_id);
        if(empty($poll)){
            $this->message('参数错误，请重新检查');
        }elseif (count($options)>$poll['max_choices']) {
            $this->message('超过允许的最大投票数，请重新检查');
        }
        //将投票插入到数据库中，完成投票操作。
        if($this->poll_model->submit_poll($topic_id,$options)){
            $this->message('投票成功！',1);
        }else{
            $this->message('网络原因，投票失败！');
        }
    }
    
    public function view_voter($topic_id) {
        $poll = $this->poll_model->get_by_id($topic_id);
        if(empty($poll) || !$poll['is_overt']){
            $this->message('参数错误！');
        }
        //初始化投票选项，放入option索引里
        $options = $this->poll_options_model->get_list(array('topic_id' => $topic_id));
        if(empty($options)){
            $this->message('参数错误！');
        }
        //未完待续
        
    }
    
}

?>