<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topics extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model','biz_topic_manage','posts_model'));
    }

    /**
     * 帖子管理
     */
    public function index() {
        $search = $this->input->get(null, TRUE);
        $where = '1 ';
        $where .= $this->search_where($search);
        
        //生成分页字符串
        $total_num = $this->topics_model->get_count($where);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 10;
        $page_obj = $this->init_page($base_url, $total_num,$per_num);
        $page_str = $page_obj->create_links();
        //获取用户
        $start = max(0,($page_obj->cur_page-1)*$per_num);
        $topics = $this->topics_model->get_list($where, '*', '', $start,$per_num);
        $key_forums = $this->forums_model->get_key_forums();
        foreach ($topics as $key=>$topic) {
            $topics[$key]['forum_name'] = $key_forums[$topic['forum_id']]['name'];
        }
        
        //得到版块选项
        $default_forums = !empty($search['forums']) ? $search['forums'] : array();
        $forums = $this->forums_model->get_format_forums();
        $var['forums_option'] = $this->forums_model->create_options($forums,$default_forums);
        $var['data'] = $search;
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        $manage_arr = $this->biz_topic_manage->get_manage_arr();
        $var['manage_arr'] = $manage_arr;
        $this->view('topics', $var);
    }

    public function delete() {
        
    }

    /**
     * 公用search部门可以公用search生成where条件的程序。
     */
    private function search_where($post='') {
        empty($post) && $post = $this->input->get(null, TRUE);
        $where = '';
        if (!empty($post['forums'])) {
            $forum_ids = join(',', $post['forums']);
            $where .= "and forum_id in($forum_ids) ";
        }
        if (!empty($post['user'])) {
            $post['user'] = trim($post['user']);
            if(is_numeric($post['user'])){
                $where .= "and (author_id = '{$post['user']}' or author = '{$post['user']}') ";
            }else{
                $where .= "and author = '{$post['user']}' ";
            }
        }
        if (!empty($post['content'])) {
            $post['content'] = trim($post['content']);
            $where .= "AND subject LIKE '%{$post['content']}%' ";
        }
        if (!empty($post['start_time'])) {
            $post['start_time'] = strtotime(trim($post['start_time']));
            $where .= "AND post_time >= '{$post['start_time']}' ";
        }
        if (!empty($post['end_time'])) {
            $post['end_time'] = my_strtotime(trim($post['end_time']));
            $where .= "AND post_time <= '{$post['end_time']}' ";
        }
        return $where;
    }

    /**
     * 管理审核帖子
     */
    public function check() {
        $search = $this->input->get(null, TRUE);
        $where = 'status = 4  ';
        $where .= $this->search_where($search);
        //生成分页字符串
        $total_num = $this->topics_model->get_count($where);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 5;
        $page_obj = $this->init_page($base_url, $total_num,$per_num);
        $page_str = $page_obj->create_links();
        //获取用户
        $start = max(0,($page_obj->cur_page-1)*$per_num);
        $topics = $this->topics_model->get_list($where, '*', '', $start,$per_num);
        $key_forums = $this->forums_model->get_key_forums();
        foreach ($topics as $key=>$topic) {
            $topics[$key]['forum_name'] = $key_forums[$topic['forum_id']]['name'];
            $ids[] = $topic['id'];
        }
        if(!empty($ids)){
          //获取涉及的帖子的内容
            $ids = join(',', $ids);
            $contents = $this->posts_model->get_posts_list("topic_id in($ids)");
            $contents = $this->posts_model->key_list($contents,'topic_id');
            foreach ($topics as $key=>$topic) {
                $topics[$key]['content'] = $contents[$topic['id']]['content'];
            }
        }
        
        //得到版块选项
        $default_forums = !empty($search['forums']) ? $search['forums'] : array();
        $forums = $this->forums_model->get_format_forums();
        $var['forums_option'] = $this->forums_model->create_options($forums,$default_forums);
        $var['data'] = $search;
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        $manage_arr = $this->biz_topic_manage->get_manage_arr();
        $var['manage_arr'] = $manage_arr;
        $this->view('topics_check', $var);
    }

    /**
     * 管理审核帖子
     */
    public function deal_check($action='pass',$topic_id='') {
        if(!in_array($action, array('pass','del'))){
            $this->message('参数错误，请指定您的操作类型！', 0);
        }
        //格式化ids并检测，两种方式获取ids，get或者post数组。
        empty($topic_id) && $topic_id = $this->input->post('topic_id');
        is_string($topic_id) && $topic_id = array_unique(array_filter(explode(',', $topic_id)));
        if(empty($topic_id)){
            $this->message('参数错误，请指定您的操作id！', 0);
        }
        foreach ($topic_id as $id) {
            if (!is_numeric($id)) {
                $this->message('参数错误，主题id格式错误！', 0);
            }
        }
        if ($this->input->post('submit')) {
            $post = $this->input->post(null,true);
            $this->biz_topic_manage->manage($topic_id,$action,$post);
            $this->message('操作完成！', 1);
        } else {
            $var['action'] = $action;
            $var['action_url'] = 'index.php/admin/posts/deal_check/';
            $var['topic_id'] = join(',', $topic_id);
            $var['count'] = count($topic_id);
            $this->load->view('topic_manage', $var);
        }
    }
    
}

?>