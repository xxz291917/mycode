<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('posts_model','users_extra_model','forums_statistics_model'));
    }

    /**
     * 论坛首页
     */
    public function index() {
        //获取所有版块
        $forums = $this->forums_model->get_forums(0);
        $forums = $this->forums_statistics_model->append_to_forums($forums);
        $forums = $this->forums_model->handle_redirect($forums);//处理redirect
        $var['forums'] = $this->forums_model->get_format_forums($forums);

        $totals = array(
            'posts' =>0,
            'topics' =>0,
            'today_posts' =>0,
            'today_topics' =>0,
        );
        foreach($forums as $forum){
            foreach ($totals as $key => $val) {
                if(isset($forum[$key]))
                $totals[$key] += $forum[$key];
            }
        }
        //获取总用户数
        $totals['users'] = $this->users_model->get_count();
        $var['totals'] = $totals;
        //获取最后用户数
        $last_user = $this->users_model->get_one(1, 'id,username', 'regdate desc');
        $var['last_user'] = $last_user;
        
        //获取最新帖子
        $new_topics = $this->topics_model->get_list(1, 'id,subject', 'post_time desc',0,8);
        $var['new_topics'] = $new_topics;
        //获取最新回复的topic_id
        $last_post_topics = $this->topics_model->get_list('1', 'id,subject', 'last_post_time desc',0,8);
        $var['last_post_topics'] = $last_post_topics;
        //获取带图片的最新帖子
        $last_image_topics = $this->posts_model->get_list('is_first =1 AND attachment=1 AND status = 1', 'id,topic_id,subject', 'post_time desc',0,10);
        $post_ids = array();
        foreach ($last_image_topics as $key => $topic) {
            $post_ids[] = $topic['id'];
        }
        $last_images = $this->attachments_model->get_images($post_ids);
        $last_images = $this->attachments_model->key_list($last_images,'post_id');
        foreach ($last_image_topics as $key => &$topic) {
            if(!empty($last_images[$topic['id']])){
                $topic += $last_images[$topic['id']];
            }
        }
        $var['last_image_topics'] = $last_image_topics;
        //今日发帖量用户排行
        $uses = $this->users_extra_model->get_list(1, 'user_id', 'today_posts desc',0,14);
        $user_ids =array();
        foreach ($uses as $key => $user) {
            $user_ids[] = $user['user_id'];
        }
        $posts_users = $this->users_model->get_names_by_ids($user_ids);
        $var['posts_users'] = $posts_users;
        
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
        //初始化页面中需要的链接。
        $type_url = preg_replace('/.(type|per_page)=[^&]+/','',my_current_url());
        $order_url = preg_replace('/.(order|per_page)=[^&]+/','',my_current_url());
        $var['type_url'] = $type_url.(strpos($type_url, '?')?'&':'?').'type=';
        $var['order_url'] = $order_url.(strpos($order_url, '?')?'&':'?').'order=';
        $var['category_url'] = current_url().(!empty($forum_id)?"?forum_id=$forum_id&category_id=":"?category_id=");
        //获取分类
        $this->load->model('topics_category_model');
        $category_where = empty($forum_id)?"":"forum_id=$forum_id";
        $topic_categorys = $this->topics_category_model->get_list($category_where,'*','display_order');
        $topic_categorys = $this->topics_category_model->key_list($topic_categorys);
        $var['topic_categorys'] = $topic_categorys;
        
        $where = '1';
        //按版块搜索
        if(!empty($forum_id)){
            $var['forum_id'] = $forum_id;
            //获取此版块的基本信息
            $current_forum = $this->forums_model->get_info_by_id($forum_id);
            //获取此版块下的版主
            $mannager = array_filter(explode(',', $current_forum['manager']));
            $mannager = $this->users_model->get_user_by_names($mannager);
            $var['current_forum'] = $current_forum;
            $var['mannager'] = $mannager;
            //获取此版块下的推荐帖
            $recommend_topics = $this->topics_model->get_list('recommend = 1 AND special =2');
            $var['recommend_topics'] = $recommend_topics;
            
            //生成按版块搜索条件
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
                $where .= " AND best_answer = 0";
                break;
            case 2://待解决
                $where .= " AND best_answer != 0";
                break;
            case 3://零回答
                $where .= " AND replies = 0";
                break;
        }
        $per_num = $this->config->item('per_num');
        $total_num = $this->ask_model->get_count($where);
        //生成分页字符串
        $base_url = page_url();
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        //添加排序高赏金、最新发布、最后回复
        $order = trim($this->input->get('order',TRUE));
        $order = in_array($order,array('post_time','price','last_post_time'))?$order:'last_post_time';
        $topics = $this->ask_model->get_list($where, '*', $order.' DESC', $start, $per_num);
        if(!empty($topics)){
            //获取需要的主题其他信息
            $tids = array();
            foreach ($topics as $topic) {
                $tids[] = $topic['topic_id'];
            }
            $full_topics = $this->topics_model->get_list('id in('.  join(',',array_unique($tids)).')');
            $full_topics = $this->topics_model->key_list($full_topics);
            
            foreach ($topics as $key => &$topic) {
                $topic = array_merge($topic,$full_topics[$topic['topic_id']]);
            }
        }
//        var_dump($topics);die;
        //为前面获取的变量赋值到$var
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        
//        var_dump($var['forums']);die;
        $this->view('ask_index',$var);
    }

}

?>