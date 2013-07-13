<?php

class Forum extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('biz_index', 'forums_statistics_model', 'biz_pagination'));
    }

    public function show($forum_id) {
        if (empty($forum_id) || !is_numeric($forum_id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $forum = $this->forums_model->get_info_by_id($forum_id);
        if (empty($forum)) {
            $this->message('参数错误，版块不存在');
        }
        //是否关闭
        if($forum['status']==0){
            $managers = explode(',', $forum['manager']);
            if (!in_array($this->user['username'], $managers) && $this->user['group']['id'] != 1) {
                $this->message('本版论坛暂时关闭。');
            }
        }
        
        if($forum['parent_id']==0){//如果是分区，转向到分区展示页面。
            $this->zone_show($forum_id);
            return;
        }
        $forum['allow_special'] = explode(',', $forum['allow_special']);
        $var['forum'] = $forum;
        
        //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
        $nav = $this->forums_model->get_nav_forums($forum_id);
        $var['nav'] = $nav;
        
        //版块导航
        $forums = $this->forums_model->get_forums();
        $var['forums'] = $this->forums_model->get_format_forums($forums);
//        $sub_forums = $this->forums_model->get_sub_forums($forum_id);
//        $var['sub_forums'] = $sub_forums;
        
        //初始化页面中需要的链接。
        $order_url = preg_replace('/.(order|per_page)=[^&]+/','',my_current_url());
        $var['order_url'] = $order_url.(strpos($order_url, '?')?'&':'?').'order=';
        $var['category_url'] = current_url().(!empty($forum_id)?"?forum_id=$forum_id&category_id=":"?category_id=");
        
        //获取分类
        $this->load->model('topics_category_model');
        $category_where = "forum_id=$forum_id";
        $topic_categorys = $this->topics_category_model->get_list($category_where,'*','display_order');
        $topic_categorys = $this->topics_category_model->key_list($topic_categorys);
        $var['topic_categorys'] = $topic_categorys;
        
        $where = " forum_id = '$forum_id' AND status IN(1,4,5)";
        //按版块搜索
        $var['forum_id'] = $forum_id;
        //获取此版块下的版主
        $mannager = array_filter(explode(',', $forum['manager']));
        $mannager = $this->users_model->get_user_by_names($mannager);
        $var['mannager'] = $mannager;
        //获取此版块下的推荐帖
        $top_topics = $this->topics_model->get_list('forum_id = '.$forum_id.' AND top > 0');
        $var['top_topics'] = $top_topics;

        //分类搜索
        $category_id = intval($this->input->get('category_id'));
        if(!empty($category_id)){
            $where .= " AND category_id = '$category_id'";
        }
        
        $per_num = $this->config->item('per_num');
        $total_num = $this->topics_model->get_count($where);
        //生成分页字符串
        $base_url = page_url();
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        
        //添加排序查看数、回复数、最后回复
        $order = trim($this->input->get('order',TRUE));
        $order = in_array($order,array('views','replies','last_post_time'))?$order:'last_post_time';
        $topics = $this->topics_model->get_list($where, '*', $order.' DESC', $start, $per_num);
        
        //为前面获取的变量赋值到$var
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        
        $var['seo']['title'] = $this->configs['seo_topic_title'];
        $var['seo']['description'] = $this->configs['seo_topic_description'];
        $var['seo']['keywords'] = $this->configs['seo_topic_keywords'];

        $this->view('forum_show',$var);
    }

    public function zone_show($forum_id) {
        if (empty($forum_id) || !is_numeric($forum_id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $forum = $this->forums_model->get_info_by_id($forum_id);
        if (empty($forum)) {
            $this->message('参数错误，版块不存在');
        }
        $forums = $this->forums_model->get_forums();
        $forums = $this->forums_statistics_model->append_to_forums($forums);
        $forums = $this->forums_model->get_format_forums($forums);
        foreach ($forums as $key => $forum) {
            if($forum['id']!=$forum_id){
                unset($forums[$key]);
            }
        }
        $var['forums'] = $forums;
        $this->view('forum_zone_show',$var);
    }


    public function show2($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $forum = $this->forums_model->get_by_id($id);
        if (empty($forum)) {
            $this->message('参数错误，版块不存在');
        }
        //获取版块信息
        $var['forum'] = $this->forums_model->get_by_id($id);
        $statistics = $this->forums_statistics_model->get_by_id($id);
        if (!empty($statistics)) {
            $statistics = $this->biz_index->process_statistics_one($statistics);
            $var['forum'] = array_merge($var['forum'], $statistics);
        }
        $var['admin_permission'] = $this->groups_model->get_admin_permission($id);
        //获取所有子版块
        $sub_forums = $this->forums_model->get_sub_forums($id);
        $var['sub_forums'] = $this->forums_statistics_model->append_to_forums($sub_forums);

        //获取本版块下的主题
        if (!empty($var['forum']['topics'])) {
            $per_num = $this->config->item('per_num');
            $total_num = $var['forum']['topics'];
            //生成分页字符串
            $base_url = $this->get_current_url() . "/$id";
            $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
            $page_str = $page_obj->create_links();
            $start = max(0, ($page_obj->cur_page - 1) * $per_num);
            $topics = $this->topics_model->get_list(array('forum_id' => $id), '*', 'last_post_time DESC', $start, $per_num);

            $var['topics'] = $topics;
            $var['page'] = $page_str;
        }
        $this->view('forum_show', $var);
    }

}

?>