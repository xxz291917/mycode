<?php

class Posts extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('permission','topics_model', 'posts_model','users_extra_model','forums_statistics_model'));
    }

    public function index() {
        die;
    }

    public function post($forum_id = '', $special = 1) {
        if (empty($forum_id) || !is_numeric($forum_id)) {
            $this->message('参数错误，请指定要发布的版块！', base_url());
        }
        if ($this->check_posts() && $post = $this->input->post(null)) {
            //检测权限。
            $is_post = $this->forums_model->check_permission('post', $forum_id);
            if (!$is_post) {
                $this->message('您没有权限发表帖子');
            }
            $is_post = $this->permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            $post = array_merge($post, array('forum_id' => $forum_id, 'special' => $special));
            if ($this->_post($post)) {
                $this->message('发帖成功。');
            } else {
                $this->message('发帖失败。');
            }
        } else {
            $this->view('posts_post');
        }
    }

    private function _post($post) {
        $forum_id = $post['forum_id'];
        //插入topics表
        $topics_data['forum_id'] = $forum_id;
        $topics_data['author'] = $this->user['username'];
        $topics_data['author_id'] = $this->user['id'];
        $topics_data['post_time'] = $this->time;
        $topics_data['subject'] = $post['subject'];
        $topics_data['special'] = $post['special'];
        $topics_data['status'] = $this->forums_model->get_check($forum_id) > 0 ? 4 : 1;
        $this->topics_model->insert($topics_data);
        $tid = $this->db->insert_id();
        if (empty($tid)) {
            $this->message('发帖topics失败。');
        }
        //插入posts表
        $posts_data['topic_id'] = $tid;
        $posts_data['forum_id'] = $forum_id;
        $posts_data['author'] = $this->user['username'];
        $posts_data['author_id'] = $this->user['id'];
        $posts_data['author_ip'] = $this->ip;
        $posts_data['post_time'] = $this->time;
        $posts_data['subject'] = $post['subject'];
        $posts_data['content'] = $post['content'];
        $posts_data['attachment'] = 0;
        $posts_data['is_first'] = 1;
        $posts_data['is_bbcode'] = $this->forums_model->get_is('bbcode', $forum_id);
        $posts_data['is_smilies'] = $this->forums_model->get_is('smilies', $forum_id);
        $posts_data['is_media'] = $this->forums_model->get_is('media', $forum_id);
        $posts_data['is_html'] = $this->forums_model->get_is('html', $forum_id);
        $posts_data['is_anonymous'] = $this->forums_model->get_is('anonymous', $forum_id);
        $posts_data['is_hide'] = $this->forums_model->get_is('hide', $forum_id);
        $posts_data['is_sign'] = $this->forums_model->get_is('sign', $forum_id);

        $posts_data['status'] = $this->forums_model->get_check($forum_id) == 3 ? 4 : 1;
        $this->posts_model->insert($posts_data);
        $pid = $this->db->insert_id();
        if (empty($pid)) {
            $this->message('发帖posts失败。');
        }
        //更新用户积分
        $credit = $this->forums_model->get_credit($forum_id, 'post');
        $update_credit = $this->users_extra_model->update_credits($credit,$this->user['id'],'post');
        if(!$update_credit){
            $this->message('更新用户积分失败。');
        }
        //更新用户user_extra信息
        $this->users_extra_model->post_increment();
        //更新用户forums_statistics信息
        $this->forums_statistics_model->post_increment($forum_id,$tid);
        //$this->users_extra_model->update_for_post();
        return TRUE;
    }

    private function check_posts() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'subject',
                'label' => '标题',
                'rules' => 'trim|required|min_length[5]|max_length[80]'
            ),
            array(
                'field' => 'content',
                'label' => '帖子内容',
                'rules' => 'trim|required'
            ),
        );
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    public function comments($e = "My Real Title") {
        $data['title'] = $e;
        $data['heading'] = "My Real Heading";
        $this->load->view('bbsview', $data);
    }

//    public function _output($output) {
//        //echo 333;
//        echo $output;
//    }
}

?>