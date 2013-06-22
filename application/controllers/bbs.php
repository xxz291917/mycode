<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('forums_statistics_model'));
    }

    /**
     * 论坛首页
     */
    public function index() {
        //获取所有版块
        $forums = $this->forums_model->get_forums();
        $forums = $this->forums_statistics_model->append_to_forums($forums);
        $var['forums'] = $this->forums_model->get_format_forums($forums);
        //var_dump($var['forums']);die;
        //var_dump($this->user);
        $this->view('bbs_index',$var);
    }
    
    /**
     * 问答首页
     */
    public function ask() {
        $this->load->model(array('ask_model','biz_pagination'));
        $forum_id = intval($this->input->get('forum_id'));
        //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
        if(!empty($forum_id)){
            $nav = $this->forums_model->get_nav_forums($forum_id);
            $var['nav'] = $nav;
        }
        //左侧版块导航
        $forums = $this->forums_model->get_forums();
        $var['forums'] = $this->forums_model->get_format_forums($forums);
        
        $where = '1';
        //按版块搜索
        if(!empty($forum_id)){
            $var['forum_id'] = $forum_id;
            //获取此版块的基本信息
            $current_forum = $this->forums_model->get_info_by_id($forum_id);
            //获取此版块下的版主名
            $mannager = array_filter(explode(',', $current_forum['manager']));
            $mannager = $this->users_model->get_user_by_names($mannager);
            $var['current_forum'] = $current_forum;
            $var['mannager'] = $mannager;
            //获取此版块下的推荐帖
            $recommend_topics = $this->topics_model->get_list('recommend = 1 AND special =2');
            $var['recommend_topics'] = $recommend_topics;
            
            //按版块搜索条件
            $where .= " AND forum_id = '$forum_id'";
        }else{
            //获取所有问答的今日发帖数和主题数。
            $start_time = strtotime(date('Y-m-d').'00:00:00');
            $end_time = strtotime(date('Y-m-d').'23:59:59');
            $current_forum['today_topics'] = $this->ask_model->get_count(" post_time BETWEEN $start_time AND $end_time ");
            $current_forum['topics'] = $this->ask_model->get_count();
            $var['current_forum'] = $current_forum;
        }
        //分类搜索
        $category_id = intval($this->input->get('category_id'));
        if(!empty($category_id)){
            $where .= " AND category_id = '$category_id'";
        }
        //已解决、待解决、零回答
        $type = intval($this->input->get('type'));
        $var['type'] = $type;
        switch ($type) {
            case 1://已解决
                $where .= " AND best_answer != '0'";
                break;
            case 2://待解决
                $where .= " AND best_answer = '0'";
                break;
            case 3://零回答
                $where .= " AND replies = '0'";
                break;
        }
        $per_num = $this->config->item('per_num');
        $total_num = $this->ask_model->get_count($where);
        //生成分页字符串
        $base_url = current_url();
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        //添加排序高赏金、最新发布、最后回复
        $order = trim($this->input->get('order',TRUE));
        $order = in_array($order,array('post_time','price','lost_post_time'))?$order:'post_time';
        $topics = $this->ask_model->get_list($where, '*', $order.' DESC', $start, $per_num);
        
        if(!empty($topics)){
            //获取需要的主题其他信息
            $tids = array();
            foreach ($topics as $topic) {
                $tids[] = $topic['topic_id'];
            }
            $full_topics = $this->topics_model->get_list('id in('.  join(',',array_unique($tids)).')');
            $var['full_topics'] = $full_topics;
        }
        
        //为前面获取的变量赋值到$var
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        
//        echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];die;
        $connect = strpos(my_current_url(), '?')?'&':'?';
        $var['type_url'] = preg_replace('/.type=\d+/','',my_current_url()).$connect.'type=';
        $var['order_url'] = preg_replace('/.order=\d+/','',my_current_url()).$connect.'order=';
        $var['category_url'] = current_url().(!empty($forum_id)?"?forum_id=$forum_id&category_id =":"?category_id = ");
        
        //获取分类
        $this->load->model('topics_category_model');
        $category_where = empty($forum_id)?"":"forum_id = $forum_id";
        $topic_categorys = $this->topics_category_model->get_list($category_where,'*','display_order');
        $var['topic_categorys'] = $topic_categorys;
//        var_dump($var['forums']);die;
        $this->view('ask_index',$var);
    }
            
    
    
    
}

?>