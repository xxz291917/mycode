<?php

class Topic extends MY_Controller {

    static $per_num = 5;


    function __construct() {
        parent::__construct();
        $this->load->model(array('topic_manage', 'forums_statistics_model', 'posts_model', 'credit_name_model'));
    }

    public function show($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $topic = $this->topics_model->get_by_id($id);
        if (empty($topic)) {
            $this->message('参数错误，主题不存在');
        }
        $var['topic'] = $topic;
        //获取管理权限
        $var['admin_permission'] = $this->groups_model->get_admin_permission($topic['forum_id']);
        //获取页面中展示的可操作的链接
        $manage_arr = $this->topic_manage->get_manage_arr();
        foreach ($manage_arr as $key => $val) {
            if (empty($var['admin_permission'][$key])) {
                unset($manage_arr[$key]);
            }
        }
        $var['manage_arr'] = $manage_arr;

        //获取本主题下的回复
        $per_num = self::$per_num;
        $total_num = $var['topic']['replies'] + 1;
        //生成分页字符串
        $base_url = $this->get_current_url() . "/$id";
        $config['uri_segment'] = 4;
        $page_obj = $this->init_page($base_url, $total_num, $per_num, $config);
        $page_str = $page_obj->create_links();

        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $posts = $this->posts_model->get_list(array('topic_id' => $id), '*', 'post_time', $start, $per_num);

        //获取需要的用户信息
        $uids = array();
        foreach ($posts as $post) {
            $uids[] = $post['author_id'];
        }
        $users = $this->users_model->get_users_by_ids(array_unique($uids));
        $groups = $this->groups_model->get_key_groups();
        $key_users = array();
        foreach ($users as $key => $value) {
            $group_id = empty($value['group_id']) ? $value['member_id'] : $value['group_id'];
            $key_users[$value['id']] = $value;
            $key_users[$value['id']]['group'] = $groups[$group_id];
        }

        $credit_name = $this->credit_name_model->get_all();
        $credit_name = $this->credit_name_model->key_list($credit_name, 'credit_x');

        $var['posts'] = $posts;
        $var['users'] = $key_users;
        $var['credit_name'] = $credit_name;
        $var['page'] = $page_str;

        //最后更新topics点击数
        $this->topics_model->update_increment(array('views' => ':1'), array('id' => $id));

        $this->view('topic_show', $var);
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
            $this->topic_manage->manage($topic_id,$action,$post);
            $this->message('操作完成！', 1);
        } else {
            $var['action'] = $action;
            $var['topic_id'] = join(',', $topic_id);
            $var['count'] = count($topic_id);
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
                $this->form_validation->set_rules('top', '置顶类型', 'required|less_than[4]');
                $this->form_validation->set_rules('end_time', '有效时间', 'required|trim|is_strtotime|strtotime|greater_than[' . time() . ']');
                $this->form_validation->set_message('is_strtotime', '选择的时间格式不正确。');
                $this->form_validation->set_message('greater_than', '选择的时间必须小于当前时间。');
                break;

            default:
                break;
        }
//'top' => '置顶',
//'digest' => '推荐精华',
//'highlight' => '高亮',
//'bump' => '提升',
//'move' => '移动',
//'editcategory' => '分类',
//'ban' => '屏蔽',
//'close' => '关闭',
//'del' => '删除',
//'copy' => '复制',
//'merge' => '合并',
//'split' => '切分',);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

}
?>