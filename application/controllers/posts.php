<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('biz_permission',
                                'biz_post',
                                'topics_model',
                                'tags_model',
                                'topics_posted_model',
                                'posts_model',
                                'users_extra_model',
                                'forums_statistics_model'));
    }

    public function post($forum_id = '', $special = 1) {
        if (empty($forum_id) || !is_numeric($forum_id)) {
            $this->message('参数错误，请指定要发布的版块！', 0, base_url());
        }
        $forum_show_url = base_url('index.php/forum/show/' . $forum_id);
        $forum = $this->forums_model->get_by_id($forum_id);
        if (empty($forum) || $forum['type'] == 'group') {
            $this->message('参数错误，发布的版块不存在或者不是子版块', 0, $forum_show_url);
        }
        if ($this->input->post('submit') && $this->biz_post->check_post('post', $special) && $post = $this->input->post(null)) {
            //检测权限。
            $is_post = $this->biz_permission->check_base('post', $forum_id);
            if (!$is_post) {
                $this->message('您没有权限发表帖子');
            }
            $is_post = $this->biz_permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            $post = array_merge($post, array('forum_id' => $forum_id, 'special' => $special));
            if ($this->biz_post->post($post)) {
                $this->message('发帖成功。', 0, $forum_show_url);
            } else {
                $this->message('发帖失败。', 0, $forum_show_url);
            }
        } else {
            $is_arr = $this->biz_post->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            $var['special'] = $special;
            //如果是特殊帖子需要做相应的处理。
            if ($special != 1) {
                $class = biz_post::$specials[$special];
                $this->load->model($class);
                $var['special_post'] = $class::$special_post;
                if (method_exists($this->$class, 'init_var')) {
                    $special_var = $this->$class->init_var();
                    $var = $var + $special_var;
                }
            }
            $var['type'] = 'post';
            $this->view('posts_post', $var);
        }
    }

    public function reply($topic_id = '') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', 0, base_url());
        }
        $forum_show_url = base_url("index.php/topic/show/$topic_id"); //回复完成跳转到帖子的最后一页。
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
        }
        //通过了check校验
        if ($this->input->post('submit') && $this->biz_post->check_post('reply', $topic['special']) && $post = $this->input->post(null)) {
            //检测权限。
            $is_post = $this->biz_permission->check_base('reply', $topic['forum_id']);
            if (!$is_post) {
                $this->message('您没有权限回复帖子');
            }
            $is_post = $this->biz_permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            //构造post数组。
            $post = array_merge($post, array('topic_id' => $topic_id, 'forum_id' => $topic['forum_id'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            if ($this->biz_post->post($post, 'reply')) {
                $this->message('发帖成功。', 1, $forum_show_url);
            } else {
                $this->message('发帖失败。', 0, $forum_show_url);
            }
        } else {
            $forum_id = $topic['forum_id'];
            $is_arr = $this->biz_post->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            $var['type'] = 'replay';
            $this->view('posts_post', $var);
        }
    }

    /**
     * 用户提交投票选项
     */
    public function poll($topic_id) {
        $post_key = 'option_'.$topic_id;
        $options = $this->input->post($post_key);
        if(empty($options)||empty($topic_id)){
            $this->message('参数错误，请重新检查');
        }
        
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，投票的主题不存在');
        }
        //检测是否有投票的权限，等同于回复权限。
        $is_post = $this->biz_permission->check_base('reply', $topic['forum_id']);
        if (!$is_post) {
            $this->message('您没有投票的权限');
        }
        
        $this->load->model('poll_model');
        $poll = $this->poll_model->get_by_id($topic_id);
        if(empty($poll)){
            $this->message('参数错误，请重新检查');
        }elseif (count($options)>$poll['max_choices']) {
            $this->message('超过允许的最大投票数，请重新检查');
        }
        //将投票插入到数据库中，完成投票操作。
        if($this->poll_model->submit_poll($topic_id,$options)){
            $this->message('投票成功！',1);
        }else{
            $this->message('网络原因，投票失败！',1);
        }
    }
    
    
    /**
     * 主要是配合前台编辑器使用的图片和文件上传功能
     * //成功时
     * "error" : 0,
     * "url" : "http://www.example.com/path/to/file.ext"
     * //失败时
     * "error" : 1,
     * "message" : "错误信息"
     */
    public function do_upload() {
        $this->output->set_header('Content-type: text/html; charset=UTF-8');
        $gets = $this->input->get();
        $field_name = 'imgFile';
        //对于上传的不同类型，做不同的参数，后期这个是在后台管理的。
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        if ($gets['dir'] == 'file') {
            $config['upload_path'] = './uploads/file';
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|htm|html|txt|zip|rar|gz|bz2|gif|jpg|jpeg|png|bmp';
            $config['max_size'] = '2048';
        } elseif ($gets['dir'] == 'image') {
            $config['upload_path'] = './uploads/image';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
        }
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($field_name)) {
            $error = array('error' => $this->upload->display_errors());
            $return = array('error' => 1, 'message' => $error['error']);
            echo json_encode($return);
            die;
        } else {
            $this->load->model(array('attachments_unused_model', 'attachments_model'));
            $data = $this->upload->data();
            $file_path = trim($config['upload_path'], './') . '/' . $data['file_name'];
            $title = $this->input->post('title');

            //将文件保存到未使用附件表。
            //$id = $this->attachments_model->get_max_id();
            //$insert_data['id']=$id+1;//id是附件表最大id+1，确保附件id的唯一。//默认是自增id，所以一般不会出问题。
            $insert_data['user_id'] = $this->user['id'];
            $insert_data['upload_time'] = $this->time;
            $insert_data['size'] = $data['file_size'];
            $insert_data['extension'] = trim($data['file_ext'], '.');
            $insert_data['filename'] = $data['file_name'];
            $insert_data['path'] = $file_path;
            $insert_data['is_image'] = $data['is_image'];
            $insert_data['description'] = $title;
            $insert_data['is_thumb'] = 0;

            $this->attachments_unused_model->insert($insert_data);
            $aid = $this->db->insert_id();

            $file_url = base_url($file_path);
            $return = array('error' => 0, 'url' => $file_url, 'aid' => $aid, 'title' => $title);
            echo json_encode($return);
            die;
        }
    }

    public function get_smiley_json() {
        $this->load->model(array('smiley_model'));
        $smileys = $this->smiley_model->get_smiley();
        echo $this->echo_ajax(1, count($smileys), $smileys);
        die;
    }

    public function username_check($str) {
        $user = $this->users_model->get_user_by_name($str);
        if (empty($user['id'])) {
            $this->form_validation->set_message('username_check', '%s不是有效的用户。');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>