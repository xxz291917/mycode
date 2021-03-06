<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('attachments_model', 'reports_model', 'biz_topic_manage', 'posts_model'));
    }

    /**
     * 举报管理
     */
    public function index() {
        $search = $this->input->get(null, TRUE);
        $where = '';
        $where .= $this->search_where($search);
        //联合查询表
        $table_a = 'reports';
        $table_b = 'topics';
        $filed = 'a.id,a.user_id,a.operate_user,a.operate_time,a.reason,b.author,b.subject';
        $orderby = 'a.id DESC ';
        //生成分页字符串
        $total_num = $this->attachments_model->get_count($table_a, $table_b, $where);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 10;
        $page_obj = $this->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        //获取用户
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $topics = $this->attachments_model->get_list($table_a, $table_b, $filed, $where, $orderby, $start, $per_num);

        //得到版块选项
        $default_forums = !empty($search['forums']) ? $search['forums'] : array();
        $forums = $this->forums_model->get_format_forums();
        $var['forums_option'] = $this->forums_model->create_options($forums, $default_forums);
        $var['data'] = $search;
        $var['topics'] = $topics;
        $var['page'] = $page_str;
        $manage_arr = $this->biz_topic_manage->get_manage_arr();
        $var['manage_arr'] = $manage_arr;
        $this->view('reports', $var);
    }

    /**
     * 生成where条件的程序。
     */
    private function search_where($post = '') {
        empty($post) && $post = $this->input->get(null, TRUE);
        $where = 'where a.status=0 and  a.topic_id=b.id  ';
        if (!empty($post['forums'])) {
            $forum_ids = join(',', $post['forums']);
            $where .= "and b.forum_id in($forum_ids) ";
        }
        if (!empty($post['user'])) {
            $post['user'] = trim($post['user']);
            if (is_numeric($post['user'])) {
                $where .= " and a.user_id = '{$post['user']}' ";
            } else {
                $where .= " and b.author like '%{$post['user']}%' ";
            }
        }
        if (!empty($post['content'])) {
            $post['content'] = trim($post['content']);
            $where .= "AND b.subject LIKE '%{$post['content']}%' ";
        }
        if (!empty($post['start_time'])) {
            $post['start_time'] = strtotime(trim($post['start_time']));
            $where .= "AND a.operate_time >= '{$post['start_time']}' ";
        }
        if (!empty($post['end_time'])) {
            $post['end_time'] = my_strtotime(trim($post['end_time']));
            $where .= "AND a.operate_time <= '{$post['end_time']}' ";
        }


        return $where;
    }

    /**
     * 管理附件，接收post过来的file_id,填写删除原因，然后删除附件。
     */
    public function del() {
        //格式化ids并检测，两种方式获取ids，get或者post数组。
        empty($action) && $action = $this->input->post('action');
        empty($file_id) && $file_id = $this->input->post('file_id');

        if (is_numeric($action)) {
            if (empty($file_id)) {
                $this->message('参数错误，请指定您的操作id！', 0);
            }
            foreach ($file_id as $id) {
                if (is_numeric($file_id)) {
                    $this->message('参数错误，主题id格式错误！', 0);
                } else {
                    $this->reports_model->delete($id, $action);
                    $this->message('操作完成！', 1);
                }
            }
        }
    }

}

?>