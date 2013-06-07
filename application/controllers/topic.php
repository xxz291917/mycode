<?php

class Topic extends MY_Controller {

    static $per_num = 10;
    static $post_view = array(
        1 => 'topic_show',
        2 => 'ask_show',
        3 => 'poll_show',
        4 => 'debate_show',
    );

    function __construct() {
        parent::__construct();
        $this->load->model(array('topic_manage', 'forums_statistics_model', 'posts_model', 'credit_name_model'));
    }

    public function show($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的帖子！');
        }
        $topic = $this->topics_model->get_by_id($id);
        if (empty($topic)) {
            $this->message('参数错误，主题不存在');
        }
        //获取本主题帖子
        $var['topic'] = $topic;

        //获取有管理权限的管理数组
        $var['manage_arr'] = $this->topic_manage->get_permission_manage($topic['forum_id']);

        //如果是特殊主题获取主题帖子
        if($topic['special']>1){
            $where = "'topic_id' = '$id' AND is_first = 1";
            $first_post = $this->posts_model->get_one($where);
            $var['first_post'] = $this->posts_model->output_filter($first_post);
        }
        
        //获取本主题下的回复和分页
        $where = $topic['special']>1?" is_first != 1":'1';
        $where .= " AND topic_id = '$id' AND status =1";
        $per_num = self::$per_num;
        //$total_num = $var['topic']['replies'] + 1;
        $total_num = $this->posts_model->get_count($where);
        //生成分页字符串
        $base_url = $this->get_current_url() . "/$id";
        $config['uri_segment'] = 4;
        $page_obj = $this->init_page($base_url, $total_num, $per_num, $config);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $posts = $this->posts_model->get_posts_list($where, '*', 'post_time', $start, $per_num);
        //获取需要的用户信息
        $uids = array();
        foreach ($posts as $post) {
            $uids[] = $post['author_id'];
        }
        $users = $this->users_model->get_users_by_ids(array_unique($uids));
        
        $groups = $this->groups_model->get_key_groups();
        $need_users = array();
        foreach ($users as $key => $value) {
            $group_id = empty($value['group_id']) ? $value['member_id'] : $value['group_id'];
            $need_users[$value['id']] = $value;
            $need_users[$value['id']]['group'] = $groups[$group_id];
        }

        $credit_name = $this->credit_name_model->get_all();
        $credit_name = $this->credit_name_model->key_list($credit_name, 'credit_x');

        $var['posts'] = $posts;
        $var['users'] = $need_users;
        $var['credit_name'] = $credit_name;
        $var['page'] = $page_str;

        //最后更新topics点击数
        $this->topics_model->update_increment(array('views' => ':1'), array('id' => $id));
        
        //展示模板
        $view_template = self::$post_view[$topic['special']];
        $this->view($view_template, $var);
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
        if (empty($topic_id)) {
            $this->message('参数错误，请指定您的操作id！', 0);
        }
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

    /**
     * 参数校验
     * @param type $action
     * @return type
     */
    private function check_manage($action) {
        $this->load->library('form_validation');
        switch ($action) {
            case 'top'://置顶
            case 'digest'://加精
                $this->form_validation->set_rules($action, $action . '类型', 'required|less_than[4]');
                break;
            case 'highlight'://高亮
                $this->form_validation->set_rules('highlight[0]', '高亮颜色', 'required|color');
                $this->form_validation->set_rules('highlight[1]', '粗体', 'regex_match[/[01]/]');
                $this->form_validation->set_rules('highlight[2]', '斜体', 'regex_match[/[01]/]');
                $this->form_validation->set_rules('highlight[3]', '下划线', 'regex_match[/[01]/]');
                $this->form_validation->set_message('regex_match', '%s参数不正确。');
                $this->form_validation->set_message('color', '%s不是正确的颜色值。');
                break;
            case 'bump'://提升
            case 'ban'://屏蔽
            case 'close'://关闭
            case 'del'://删除
                $this->form_validation->set_rules($action, '类型', 'regex_match[/[01]/]');
                $this->form_validation->set_message('regex_match', '%s参数不正确。');
                break;
            case 'move'://移动
                $this->form_validation->set_rules($action, '版块id', 'required|is_natural_no_zero');
                $this->form_validation->set_message('is_natural_no_zero', '%s参数不正确。');
                break;
            case 'editcategory'://分类
                $this->form_validation->set_rules($action, '主题分类id', 'required|is_natural_no_zero');
                $this->form_validation->set_message('is_natural_no_zero', '%s参数不正确。');
                break;
            default:
                break;
        }
        if (in_array($action, array('top', 'digest', 'highlight')) && $this->input->post('end_time') != 0) {
            $this->form_validation->set_rules('end_time', '有效时间', 'required|trim|is_strtotime|strtotime|greater_than[' . time() . ']');
            $this->form_validation->set_message('is_strtotime', '选择的时间格式不正确。');
            $this->form_validation->set_message('greater_than', '选择的时间不能小于当前时间。');
        }
//'copy' => '复制',
//'merge' => '合并',
//'split' => '切分',);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

}

?>