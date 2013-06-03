<?php

class Posts extends MY_Controller {

    static $specials = array(2=>'ask',3=>'poll',4=>'debate');
            
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
        if ($this->input->post('submit') && $this->check_post('post',$special) && $post = $this->input->post(null)) {
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
            $var['special'] = $special;
            if($special !=1){
                $class = self::$specials[$special];
                $this->load->model($class);
//                var_dump($this->user);die;
                $var['special_post'] = $class::$special_post;
            }
            $this->view('posts_post', $var);
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
        //通过了check校验
        if ($this->input->post('submit') && $this->check_post('reply',$topic['special']) && $post = $this->input->post(null)) {
            //检测权限。
            $is_post = $this->forums_model->check_permission('reply', $topic['forum_id']);
            if (!$is_post) {
                $this->message('您没有权限回复帖子');
            }
            $is_post = $this->permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            //构造post数组。
            $post = array_merge($post, array('topic_id' => $topic_id, 'forum_id' => $topic['forum_id'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            if ($this->_post($post, 'reply')) {
                $this->message('发帖成功。', $forum_show_url);
            } else {
                $this->message('发帖失败。', $forum_show_url);
            }
        } else {
            $forum_id = $topic['forum_id'];
            $is_arr = $this->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            $this->view('posts_post', $var);
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
            //特殊主题完成自己特有的发帖操作。
            if($post['special']!=1){
                $class = self::$specials[$post['special']];
                $this->load->model($class);
                $this->$class->post($tid,$post);
            }
        } elseif ('reply' == $type) {
            //更新topics表
            $topics_data['replies'] = ':1';
            $topics_data['last_author'] = $this->user['username'];
            $topics_data['last_author_id'] = $this->user['id'];
            $topics_data['last_post_time'] = $this->time;
            $tid = $post['topic_id'];
            $this->topics_model->update_increment($topics_data, array('id' => $tid));
            //更新topics_posted表，如果回复的帖子不是我发起的，则记录我参与过的帖子。
            if ($this->user['id'] != $post['topic_author_id']) {
                $topic_id = $this->topics_posted_model->get_one(array('user_id' => $this->user['id'], 'topic_id' => $tid));
                if (empty($topic_id)) {
                    $this->topics_posted_model->insert(array('user_id' => $this->user['id'], 'topic_id' => $tid));
                }
            }
            //特殊主题完成自己特有的回复操作。
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
        $posts_data['status'] = $this->forums_model->get_check($forum_id) == 2 ? 4 : 1; //回复帖子也审核
        $this->posts_model->insert($posts_data);
        $pid = $this->db->insert_id();
        if (empty($pid)) {
            $this->message('发帖posts失败。');
        }
        //更新用户上传的附件（图片和文件）
        if(!empty($post['attachments'])){
            $this->load->model(array('attachments_unused_model','attachments_model'));
            $aids = join(',', $post['attachments']);
            $attachments = $this->attachments_unused_model->get_list("id in($aids)");
            foreach ($attachments as &$attachment) {
                $attachment['topic_id']=$tid;
                $attachment['post_id']=$pid;
                $attachment['is_remote']=0;
                $attachment['downloads']=0;
            }
            if(!$this->attachments_model->insert_batch($attachments)){
                $this->message('插入附件表失败。');
            }else{
                $this->attachments_unused_model->delete("id in($aids)");
            }
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
        return TRUE;
    }

    private function check_post($type = 'post',$special=1) {
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
        //校验特殊主题
        if($special!=1){
            $class = self::$specials[$special];
            $this->load->model($class);
            $this->$class->check_post($type);
        }
        
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    private function get_is($forum_id) {
        $return = array();
        $is_arr = array('is_bbcode', 'is_smilies', 'is_html', 'is_hide', 'is_media', 'is_anonymous', 'is_sign');
        foreach ($is_arr as $key => $is) {
            $return[$is] = $this->forums_model->get_is($is, $forum_id);
        }
        return $return;
    }

    public function get_smiley_json() {
        $this->load->model(array('smiley_model'));
        $smileys = $this->smiley_model->get_smiley();
        echo $this->echo_ajax(1, count($smileys), $smileys);
        die;
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
        if($gets['dir']=='file'){
            $config['upload_path'] = './uploads/file';
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|htm|html|txt|zip|rar|gz|bz2|gif|jpg|jpeg|png|bmp';
            $config['max_size'] = '2048';
        }elseif($gets['dir']=='image'){
            $config['upload_path'] = './uploads/image';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
            $config['max_size'] = '100';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
        }
        $this->load->library('upload',$config);
        if (!$this->upload->do_upload($field_name)) {
            $error = array('error' => $this->upload->display_errors());
            $return = array('error'=>1,'message'=>$error['error']);
            echo json_encode($return);die;
        } else {
            $this->load->model(array('attachments_unused_model','attachments_model'));
            $data = $this->upload->data();
            $file_path = trim($config['upload_path'], './').'/'.$data['file_name'];
            $title = $this->input->post('title');
            
            //将文件保存到未使用附件表。
            //$id = $this->attachments_model->get_max_id();
            //$insert_data['id']=$id+1;//id是附件表最大id+1，确保附件id的唯一。//默认是自增id，所以一般不会出问题。
            $insert_data['user_id']=$this->user['id'];
            $insert_data['upload_time']=$this->time;
            $insert_data['size']=$data['file_size'];
            $insert_data['extension']=  trim($data['file_ext'],'.');
            $insert_data['filename']=$data['file_name'];
            $insert_data['path']=$file_path;
            $insert_data['is_image']=$data['is_image'];
            $insert_data['description']=$title;
            $insert_data['is_thumb']=0;
            
            $this->attachments_unused_model->insert($insert_data);
            $aid = $this->db->insert_id();
            
            $file_url = base_url($file_path);
            $return = array('error'=>0,'url'=>$file_url,'aid'=>$aid,'title'=>$title);
            echo json_encode($return);die;
        }
    }

}

?>