<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topics extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model','topic_manage'));
    }

    /**
     * 帖子管理
     */
    public function index() {
        $search = $this->input->get(null, TRUE);
        $where = '1 ';
        if (!empty($search['forums'])) {
            $forum_ids = join(',', $search['forums']);
            $where .= "and forum_id in($forum_ids) ";
        }
        if (!empty($search['user'])) {
            $search['user'] = trim($search['user']);
            if(is_numeric($search['user'])){
                $where .= "and (author_id = '{$search['user']}' or author = '{$search['user']}') ";
            }else{
                $where .= "and author = '{$search['user']}' ";
            }
        }
        if (!empty($search['content'])) {
            $search['content'] = trim($search['content']);
            $where .= "AND subject LIKE '%{$search['content']}%' ";
        }
        if (!empty($search['start_time'])) {
            $search['start_time'] = strtotime(trim($search['start_time']));
            $where .= "AND post_time >= '{$search['start_time']}' ";
        }
        if (!empty($search['end_time'])) {
            $search['end_time'] = strtotime(trim($search['end_time']));
            $where .= "AND post_time <= '{$search['end_time']}' ";
        }
        
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
        }
        
        //得到版块选项
        $default_forums = !empty($search['forums']) ? $search['forums'] : array();
        $forums = $this->forums_model->get_format_forums();
        $var['forums_option'] = $this->forums_model->create_options($forums,$default_forums);
        $var['data'] = $search;
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        $manage_arr = $this->topic_manage->get_manage_arr();
        $var['manage_arr'] = $manage_arr;
        $this->view('topics', $var);
    }

    public function delete() {
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            //检查此版块下是否有帖子、
            $this->load->model('topics_model');
            if (!$this->topics_model->exist_in_forum($id)) {
                $message = $this->echo_ajax(0, '此版块下面存在主题，不允许被删除！');
            } else {
                if ($this->db->delete('forums', array('id' => $id))) {
                    $message = $this->echo_ajax(1);
                } else {
                    $message = $this->echo_ajax(0, '操作数据库失败！');
                }
            }
        } else {
            $message = $this->echo_ajax(1);
        }
        echo $message;
        die;
    }

    /**
     * 回收站管理
     */
    public function recycle() {
        
    }

    /**
     * 管理帖子，接收post过来的topic_id,填写删除原因，然后删除帖子。
     */
    public function manage($action, $topic_id = '') {
        //$action是必须传入的参数，代表要操作的类型。
        if (empty($action)) {
            $this->message('参数错误，请指定您的操作！', 0);
        }
        //格式化ids并检测，两种方式获取ids，get或者post数组。
        empty($topic_id) && $topic_id = $this->input->post('topic_id');
        is_string($topic_id) && $topic_id = array_unique(array_filter(explode(',', $topic_id)));
        foreach ($topic_id as $id) {
            if (!is_numeric($id)) {
                $this->message('参数错误，主题id格式错误！', 0);
            }
        }
        if ($this->input->post('submit')) {
            //验证提交的参数。
            if (!$this->check_manage($action)) {
                $error_message = $this->form_validation->error_string(); //ajax显示错误信息。
                $this->message($error_message, 0);
            }
            $post = $this->input->post();
            //检测权限。
            if (!$this->topic_manage->check_manager_permission($topic_id, $action, $post)) {
                $this->message('操作的主题，没有权限。', 0);
            }
            $this->topic_manage->manage($topic_id, $action, $post);
            $this->message('操作完成！', 1);
        } else {
            $var['action'] = $action;
            $var['topic_id'] = join(',', $topic_id);
            $var['count'] = count($topic_id);

            //取出第一个id的参数来。
            $topic = $this->topics_model->get_by_id($topic_id[0]);
            if (in_array($action, array('top', 'digest', 'highlight'))) {//置顶、精华、高亮
                $this->load->model('topics_endtime_model');
                $end_time = $this->topics_endtime_model->get_one(array('topic_id' => $topic_id[0], 'action' => $action), 'end_time');
                $topic['end_time'] = empty($end_time) ? 0 : $end_time['end_time'];
            } elseif (in_array($action, array('ban', 'close', 'del'))) {//屏蔽、关闭、删除
                $topic[$action] = $topic['status'] == Topic_manage::$status[$action] ? 1 : 0;
            } elseif ($action == 'move') {//移动版块
                $forums = $this->forums_model->get_format_forums();
                $forums_option = $this->forums_model->create_options($forums, array($topic['forum_id']));
                $var['forums_option'] = $forums_option;
            } elseif ($action == 'editcategory') {//移动分类
                $this->load->model('topics_category_model');
                $category_option = $this->topics_category_model->create_options(array($topic['category_id']));
                $var['category_option'] = $category_option;
            } elseif (in_array($action, array('copy', 'merge', 'split'))) {
                echo '暂未开发';
                die;
            }
            $var['topic'] = $topic;
            $this->load->view('topic_manage', $var);
        }
    }

}

?>