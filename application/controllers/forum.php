<?php

class Forum extends MY_Controller {

    static $per_num = 10;
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('index','forums_statistics_model'));
    }

    public function show($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $forum = $this->forums_model->get_by_id($id);
        if(empty($forum)){
            $this->message('参数错误，版块不存在');
        }
        //获取版块信息
        $var['forum'] = $this->forums_model->get_by_id($id);
        $statistics = $this->forums_statistics_model->get_by_id($id);
        if(!empty($statistics)){
            $statistics = $this->index->process_statistics_one($statistics);
            $var['forum'] = array_merge($var['forum'],$statistics);
        }
        $var['admin_permission'] = $this->groups_model->get_admin_permission($id);
        //获取所有子版块
        $sub_forums = $this->forums_model->get_sub_forums($id);
        $var['sub_forums'] = $this->forums_statistics_model->append_to_forums($sub_forums);
        
        //获取本版块下的主题
        if(!empty($var['forum']['topics'])){
            $per_num = self::$per_num;
            $total_num = $var['forum']['topics'];
            //生成分页字符串
            $base_url = $this->get_current_url()."/$id";
            $config['uri_segment'] = 4;
            $page_obj = $this->init_page($base_url, $total_num,$per_num,$config);
            
            $page_str = $page_obj->create_links();
            $start = max(0,($page_obj->cur_page-1)*$per_num);
            $topics = $this->topics_model->get_list(array('forum_id'=>$id), '*', 'post_time DESC', $start,$per_num);
            
            $var['topics'] = $topics;
            $var['page'] = $page_str;
        }
        $this->view('forum_show',$var);
    }
    
}

?>