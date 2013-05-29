<?php

class Posts extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('permission', 'topics_model', 'topics_posted_model', 'posts_model', 'users_extra_model', 'forums_statistics_model'));
    }

    public function index() {
        die;
    }

    public function post($forum_id = '', $special = 1) {
        if (empty($forum_id) || !is_numeric($forum_id)) {
            $this->message('参数错误，请指定要发布的版块！', base_url());
        }
        $forum_show_url = base_url('index.php/forum/show/' . $forum_id);
        $forum = $this->forums_model->get_by_id($forum_id);
        if (empty($forum) || $forum['type'] == 'group') {
            $this->message('参数错误，发布的版块不存在或者不是子版块', $forum_show_url);
        }
        if ($this->input->post('submit') && $this->check_posts('post') && $post = $this->input->post(null)) {
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
                $this->message('发帖成功。', $forum_show_url);
            } else {
                $this->message('发帖失败。', $forum_show_url);
            }
        } else {
            $is_arr = $this->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            $this->view('posts_post',$var);
        }
    }

    public function reply($topic_id = '') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', base_url());
        }

        $forum_show_url = base_url("index.php/topic/show/$topic_id"); //回复完成跳转到帖子的最后一页。
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', $forum_show_url);
        }
        if ($this->input->post('submit') && $this->check_posts('reply') && $post = $this->input->post(null)) {
            //检测权限。
            $is_post = $this->forums_model->check_permission('reply', $topic['forum_id']);
            if (!$is_post) {
                $this->message('您没有权限回复帖子');
            }
            $is_post = $this->permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            $post = array_merge($post, array('topic_id' => $topic_id, 'forum_id' => $topic['forum_id'], 'topic_author_id' => $topic['author_id']));
            if ($this->_post($post, 'reply')) {
                $this->message('发帖成功。', $forum_show_url);
            } else {
                $this->message('发帖失败。', $forum_show_url);
            }
        } else {
            $forum_id = $topic['forum_id'];
            $is_arr = $this->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            $this->view('posts_post',$var);
        }
    }

    /**
     * 接受参数，完成发帖或者回复的数据库操作。
     * @param type $post
     * @param type $type
     * @return boolean
     */
    private function _post($post, $type = 'post') {
        $forum_id = $post['forum_id'];
        if ('post' == $type) {
            //插入topics表
            $topics_data['forum_id'] = $forum_id;
            $topics_data['author'] = $this->user['username'];
            $topics_data['author_id'] = $this->user['id'];
            $topics_data['post_time'] = $this->time;
            $topics_data['subject'] = $post['subject'];
            $topics_data['special'] = $post['special'];
            $topics_data['replies'] = 0;
            $topics_data['status'] = $this->forums_model->get_check($forum_id) > 0 ? 4 : 1;
            $this->topics_model->insert($topics_data);
            $tid = $this->db->insert_id();
            if (empty($tid)) {
                $this->message('发帖topics失败。');
            }
        } elseif ('reply' == $type) {
            //更新topics表
            $topics_data['replies'] = ':1';
            $topics_data['last_author'] = $this->user['username'];
            $topics_data['last_author_id'] = $this->user['id'];
            $topics_data['last_post_time'] = $this->time;
            $tid = $post['topic_id'];
            $this->topics_model->update_increment($topics_data, array('id' => $tid));
            //如果回复的帖子不是我发起的，则更新topics_posted表，记录我参与过的帖子。
            if ($this->user['id'] != $post['topic_author_id']) {
                $topic_id = $this->topics_posted_model->get_one(array('user_id' => $this->user['id'], 'topic_id' => $tid));
                if (empty($topic_id)) {
                    $this->topics_posted_model->insert(array('user_id' => $this->user['id'], 'topic_id' => $tid));
                }
            }
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
        $posts_data['is_first'] = 'post' == $type ? 1 : 0;
        $posts_data['is_bbcode'] = $this->forums_model->get_is('bbcode', $forum_id);
        $posts_data['is_smilies'] = $this->forums_model->get_is('smilies', $forum_id);
        $posts_data['is_media'] = $this->forums_model->get_is('media', $forum_id);
        $posts_data['is_html'] = $this->forums_model->get_is('html', $forum_id);
        $posts_data['is_anonymous'] = $this->forums_model->get_is('anonymous', $forum_id);
        $posts_data['is_hide'] = $this->forums_model->get_is('hide', $forum_id);
        $posts_data['is_sign'] = $this->forums_model->get_is('sign', $forum_id);

        $posts_data['status'] = $this->forums_model->get_check($forum_id) == 2 ? 4 : 1;//回复帖子也审核
        $this->posts_model->insert($posts_data);
        $pid = $this->db->insert_id();
        if (empty($pid)) {
            $this->message('发帖posts失败。');
        }
        //更新用户积分
        $credit = $this->forums_model->get_credit($forum_id, $type);
        $update_credit = $this->users_extra_model->update_credits($credit, $this->user['id'], $type);
        if (!$update_credit) {
            $this->message('更新用户积分失败。');
        }
        //更新用户user_extra信息
        $this->users_extra_model->post_increment();
        //更新用户forums_statistics信息
        $this->forums_statistics_model->post_increment($forum_id, $tid, $type);
        //$this->users_extra_model->update_for_post();
        return TRUE;
    }

    private function check_posts($type = 'post') {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'content',
                'label' => '帖子内容',
                'rules' => 'trim|required'
            )
        );
        if ('post' == $type) {
            $config[] = array(
                'field' => 'subject',
                'label' => '标题',
                'rules' => 'trim|required|min_length[5]|max_length[80]'
            );
        }
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }
    
    private function get_is($forum_id){
        $return = array();
        $is_arr = array('is_bbcode','is_smilies','is_html','is_hide','is_media','is_anonymous','is_sign');
        foreach ($is_arr as $key => $is) {
            $return[$is] = $this->forums_model->get_is($is, $forum_id);
        }
        return $return;
    }

        public function get_smiley_json(){
        $this->load->model(array('smiley_model'));
        $smileys = $this->smiley_model->get_smiley();
        echo $this->echo_ajax(1,count($smileys),$smileys);
        die;
    }

}

?>