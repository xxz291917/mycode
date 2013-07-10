<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Action extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'biz_permission',
            'biz_post',
            'topics_model',
            'tags_model',
            'topics_posted_model',
            'posts_model',
            'biz_user',
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
        if ($this->user['id'] == 0) {
            $this->message('您还未登录，请<a href="' . $this->config->item('passport_login') . '" target="_blank">登录</a>。');
        }
        //检测权限。
        $is_post = $this->biz_permission->check_base('post', $forum_id);
        if (!$is_post) {
            $message = '您没有权限发表帖子';
            if($this->user['id']==0){
                $message .= '请您<a href="">登录</a>。';
            }
            $this->message($message);
        }
        
        if ($this->input->post('submit') && $post = $this->input->post(null,TRUE)) {
            if(!$this->biz_post->check_post('post', $special)){
                $errors = validation_errors();
                $this->message(nl2br($errors), 0);
            }
            
            $is_post = $this->biz_permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            $post = array_merge($post, array('forum_id' => $forum_id, 'special' => $special));
            if ($topic_id = $this->biz_post->post($post)) {

                    /* 用户动态 */
                $title = $post['subject'];
                $content = utf8_substr($post['content'], 0, 255);
                $forum_show_url = base_url('index.php/topic/show/'.$topic_id);
                $this->biz_user->feed('post',$special, $this->user['id'], $forum_show_url, $title, $content, $this->time);
                    /* 用户动态结束 */
                $this->message('发帖成功。', 0, $forum_show_url);
            } else {
                $this->message('发帖失败。', 0, $forum_show_url);
            }
        } else {
            //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
            $nav = $this->forums_model->get_nav_str($forum_id);
            $nav[] = array('发布帖子', current_url());
            $var['nav'] = $nav;
            
            $this->load->model('topics_category_model');
            $category_option = $this->topics_category_model->create_options($forum_id);
            $var['category_option'] = $category_option;
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_permission->get_edit_permission($forum_id);
            $var['is_arr'] = json_encode($is_arr);
            
            $var['special'] = $special;
            //如果是特殊帖子需要做相应的处理。
            if ($special != 1) {
                $class = biz_post::$specials[$special];
                $this->load->model($class);
                $var['special_view'] = $class::$special_post;
                if (method_exists($this->$class, 'init_post')) {
                    $special_var = $this->$class->init_post();
                    $var = $var + $special_var;
                }
            }
            $var['type'] = 'post';
            
            //为保存草稿使用的版块id
            $var['forum_id'] = $forum_id;
            
            //找出此用户，此版块下的,同类型草稿。
            $where = array('user_id'=>$this->user['id'],'forum_id'=> $forum_id, 'special'=>$special);
            $this->load->model('drafts_model');
            $draft = $this->drafts_model->get_one($where);
            if(!empty($draft)){
                $draft_tmp['subject'] = $draft['subject'];
                $draft_tmp['content'] = $draft['content'];
                $remain_data = $draft['remain_data'];
                $remain_data = json_decode($remain_data, TRUE);
                $draft_tmp = array_merge($draft_tmp,$remain_data);
//                var_dump($draft_tmp);die;
                $draft_tmp = json_encode($draft_tmp);
                $var['draft'] = $draft_tmp;
            }
            
            $this->view('action_post', $var);
        }
    }

    public function reply($topic_id = '',$post_id='') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', 0, base_url());
        }
        $forum_show_url = base_url("index.php/topic/show/$topic_id");
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
        }
        if ($this->user['id'] == 0) {
            $this->message('您还未登录，请<a href="' . $this->config->item('passport_login') . '" target="_blank">登录</a>。');
        }
        //检测权限。
        $is_post = $this->biz_permission->check_base('reply', $topic['forum_id']);
        if (!$is_post) {
            $this->message('您没有权限回复帖子');
        }
        
        //通过了check校验
        if ($this->input->post('submit') && $post = $this->input->post(null,TRUE)) {
            if (!$this->biz_post->check_post('reply', $topic['special'])) {
                $errors = validation_errors();
                $this->message(nl2br($errors), 0);
            }
            $is_post = $this->biz_permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            //构造post数组。
            $post = array_merge($post, array('topic_id' => $topic_id, 'post_id' => $post_id, 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/last');
            if ($post_id = $this->biz_post->post($post, 'reply')) {
                $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/'.$post_id);
                /* start */
                $title = !empty($post['subject'])?$post['subject']:"re:".$topic['subject'];
                $content = utf8_substr($post['content'], 0, 255);
                $this->biz_user->publish('1', $topic_id, $this->user['id'], $topic['author_id'], $forum_show_url, $title, $content, $this->time);
                    /* 用户动态 */
                $this->biz_user->feed('reply',$topic['special'], $this->user['id'], $forum_show_url, $title, $content, $this->time);
                    /* 用户动态结束 */
                /* end */
                $this->message('发帖成功。', 1, $forum_show_url);
            } else {
                $this->message('发帖失败。', 0, $forum_show_url);
            }
        } else {
            $var['topic'] = $topic;
            $forum_id = $topic['forum_id'];
            //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
            $nav = $this->forums_model->get_nav_str($forum_id);
            $nav[] = array('回复帖子', current_url());
            $var['nav'] = $nav;
            
            //如果是特殊帖子需要做相应的处理。
            $special = $topic['special'];
            if ($special != 1) {
                $class = biz_post::$specials[$special];
                $this->load->model($class);
                if(method_exists($this->$class, 'get_reply_view')){
                    $var['special_view'] = $this->$class->get_reply_view($topic_id);
                }
                if (method_exists($this->$class, 'init_reply')) {
                    $special_var = $this->$class->init_reply($topic_id);
                    $var = $var + $special_var;
                }
            }
            
            if (is_numeric($post_id) && $post_id>0) {
                $post = $this->posts_model->get_by_id($post_id);
                if (empty($post)) {
                    $this->message('参数错误，回复的帖子不存在', 0, $forum_show_url);
                }
                $var['post'] = $post;
                $var['quote_content'] = $this->biz_post->get_quote_content($post);
            }
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_permission->get_edit_permission($forum_id);
            $var['is_arr'] = json_encode($is_arr);
            
            
            //找出此用户，此主题下的,同类型草稿。
            $where = array('user_id'=>$this->user['id'],'topic_id'=> $topic_id);
            $this->load->model('drafts_model');
            $draft = $this->drafts_model->get_one($where);
            if(!empty($draft)){
                $draft_tmp['subject'] = $draft['subject'];
                $draft_tmp['content'] = $draft['content'];
                $remain_data = $draft['remain_data'];
                $remain_data = json_decode($remain_data, TRUE);
                $draft_tmp = array_merge($draft_tmp,$remain_data);
//                var_dump($draft_tmp);die;
                $draft_tmp = json_encode($draft_tmp);
                $var['draft'] = $draft_tmp;
            }
            
            
            $var['type'] = 'reply';
            $var['forum_id'] = $forum_id;
            $var['special'] = $special;
            $this->view('action_post', $var);
        }
    }
    
    
    public function reply_dialog($topic_id = '',$post_id = '') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', 0, base_url());
        }
        $post_id = intval($post_id);
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
        }
        
        if($this->user['id']==0){
            $this->message('您还未登录，请<a href="'.$this->config->item('passport_login').'" target="_blank">登录</a>。');
        }
        
        //检测权限。
        $is_post = $this->biz_permission->check_base('reply', $topic['forum_id']);
        if (!$is_post) {
            $this->message('您没有权限回复帖子');
        }
        
        if ($this->input->post('submit') && $post = $this->input->post(null,TRUE)) {
            //检测字段
            if(!$this->biz_post->check_post('reply', $topic['special'])){
                $errors = validation_errors();
                $this->message(nl2br($errors), 0);
            }
            
            $is_post = $this->biz_permission->check_post_num();
            if (!$is_post) {
                $this->message('您发帖太快或者是发帖数太多。');
            }
            //构造post数组。
            $post = array_merge($post, array('topic_id' => $topic_id, 'post_id' => $post_id, 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/last');
            if ($post_id = $this->biz_post->post($post, 'reply')) {
                $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/'.$post_id);
                /* start */
                $title = empty($post['subject'])?$post['subject']:"re:".$topic['subject'];
                $content = utf8_substr($post['content'], 0, 255);
                $this->biz_user->publish('1', $topic_id, $this->user['id'], $topic['author_id'], $forum_show_url, $title, $content, $this->time);
                    /* 用户动态 */
                                echo $topic['special'];die;
                $this->biz_user->feed('reply',$topic['special'], $this->user['id'], $forum_show_url, $title, $content, $this->time);
                    /* 用户动态结束 */
                /* end */
                $this->message('回复成功，现在查看？', 1, $forum_show_url);
            } else {
                $this->message('回复失败。', 0);
            }
            
        }else{
            $var['topic_id'] = $topic_id;
            $var['topic'] = $topic;
            $var['post_id'] = $post_id;
            if (is_numeric($post_id) && $post_id>0) {
                $post = $this->posts_model->get_by_id($post_id);
                if (empty($post)) {
                    $this->message('参数错误，发布的主题不存在', 0);
                }
                $var['post'] = $post;
                $var['quote_content'] = $this->biz_post->get_quote_content($post);
            }
            //如果是特殊帖子需要做相应的处理。
            $special = $topic['special'];
            if ($special != 1) {
                $stand = intval($this->input->get('stand',TRUE));
                if(!empty($stand)){
                    $this->load->model('debate_posts_model');
                    $is_posted = $this->debate_posts_model->check_is_posted($topic_id);
                    if($is_posted){
                        echo '您已经发表过观点！';die;
                    }
                    $_POST['stand'] = $stand;
                }
                
                $class = biz_post::$specials[$special];
                $this->load->model($class);
                if (method_exists($this->$class, 'get_reply_view')) {
                    $var['special_view'] = $this->$class->get_reply_view($topic_id);
                }
                if (method_exists($this->$class, 'init_reply')) {
                    $special_var = $this->$class->init_reply($topic_id);
                    $var = $var + $special_var;
                }
            }
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_permission->get_edit_permission($topic['forum_id']);
            $var['is_arr'] = json_encode($is_arr);
            $var['forum_id'] = $topic['forum_id'];
            $var['special'] = $special;
            $this->load->view('reply_dialog', $var);
        }
    }
    
    public function edit($topic_id = '',$post_id='') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', 0, base_url());
        }
        $forum_show_url = base_url("index.php/topic/show/$topic_id");
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
        }
        
        //检测权限。
        $is_edit = $this->biz_permission->check_manage($topic_id, 'edit');
        if (!$is_edit) {
            $this->message('您没有权限编辑帖子');
        }

        //获取编辑的内容
        if (is_numeric($post_id) && !empty($post_id)) {
            $db_post = $this->posts_model->get_by_id($post_id);
        } else {
            $db_post = $this->posts_model->get_one(array('topic_id' => $topic_id, 'is_first' => '1'));
        }
        if (empty($db_post)) {
            $this->message('参数错误，编辑的帖子不存在', 0, $forum_show_url);
        }
        $var['post'] = $db_post;

        //通过了check校验
        if ($this->input->post('submit') && $post = $this->input->post(null,TRUE)) {
            if(!$this->biz_post->check_post($db_post['is_first']==1?'post':'reply', $topic['special'])){
                $errors = validation_errors();
                $this->message(nl2br($errors), 0);
            }
            //构造post数组。
            $post = array_merge($post, array('topic_id' => $topic_id, 'is_first'=>$db_post['is_first'], 'post_id' => $db_post['id'], 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成编辑。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/'.$post_id);
            if ($this->biz_post->edit($post, 'edit')) {
                $this->message('编辑帖子成功。', 1, $forum_show_url);
            } else {
                $this->message('编辑帖子失败。', 0, $forum_show_url);
            }
        } else {
            //var_dump($_POST);
            $edit_data = array();
            $var['topic'] = $topic;
            $forum_id = $topic['forum_id'];
            
            //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
            $nav = $this->forums_model->get_nav_str($forum_id);
            $nav[] = array('编辑帖子', current_url());
            $var['nav'] = $nav;
            
            $special = $topic['special'];
            //如果是特殊帖子需要做相应的处理。
            if ($special != 1) {
                $class = biz_post::$specials[$special];
                $this->load->model($class);
                if($db_post['is_first']==1){//主题帖子
                    $var['special_view'] = $class::$special_post;
                    if (method_exists($this->$class, 'init_post')) {
                        $special_var = $this->$class->init_post();
                        $var = $var + $special_var;
                    }
                    if (method_exists($this->$class, 'init_edit')) {
                        $special_data = $this->$class->init_edit($topic_id,$post_id);//取出特殊帖子的关联表内容。
                        $edit_data = $edit_data + $special_data;
                    }
                }else{//回复帖子
                    if (method_exists($this->$class, 'init_reply')) {
                        $special_var = $this->$class->init_reply($topic_id);
                        $var = $var + $special_var;
                    }
                    if (method_exists($this->$class, 'init_reply_edit')) {
                        $special_data = $this->$class->init_reply_edit($topic_id,$post_id);//取出特殊帖子的关联表内容。
                        $edit_data = $edit_data + $special_data;
                    }
                    if (isset($edit_data['stand']) && method_exists($this->$class, 'get_edit_view')) {
                        $var['special_view'] = $this->$class->get_edit_view($topic_id);
                    }
                }
            }
            if ($db_post['is_first'] == 1) {//主题帖子
                $this->load->model('topics_category_model');
                $category_option = $this->topics_category_model->create_options($forum_id);
                $var['category_option'] = $category_option;
            }
            
            $db_post = $this->posts_model->output_filter($db_post);
            //获取可能存在的附件
            $attachments = $this->posts_model->get_attachments($db_post);
            $uploadImages=$uploadFiles=array();
            if(!empty($attachments)){
                foreach ($attachments as $key => $attachment) {
                    if($attachment['is_image'] == 1){
                        $uploadImages[$key] = $this->posts_model->get_html_for_attach($key, 'attachimg', $attachments);
                    }else{
                        $uploadFiles[$key] = $this->posts_model->get_html_for_attach($key, 'attach', $attachments);
                    }
                }
                $edit_data['attachments'] = array_keys($attachments);
            }
            $edit_data['uploadImages'] = json_encode($uploadImages);
            $edit_data['uploadFiles'] = json_encode($uploadFiles);
            
//            echo $edit_data['uploadFiles'];
//            echo $edit_data['uploadImages'];die;
            
            $edit_data['subject'] = $db_post['subject'];
            $edit_data['content'] = $db_post['content'];
            $edit_data['tags'] = $topic['tags'];
            $var['edit_data'] = $edit_data;
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_permission->get_edit_permission($forum_id);
            $var['is_arr'] = json_encode($is_arr);
            
            $var['type'] = 'edit';
            $var['forum_id'] = $forum_id;
            $var['special'] = $special;
            $this->view('action_post', $var);
        }
    }
    
    /**
     * 前台编辑器使用的图片和文件上传功能
     * //成功时
     * "error" : 0,
     * "url" : "http://www.example.com/path/to/file.ext"
     * //失败时
     * "error" : 1,
     * "message" : "错误信息"
     */
    public function do_upload($forum_id = '') {
        //检测权限
        $forum_id = intval($forum_id);
        if(empty($forum_id)){
            $return = array('error' => 1, 'message' => '参数错误');
            echo json_encode($return);
            die;
        }
        $isupload = $this->biz_permission->check_base('upload', $forum_id);
        if($isupload == 0){
            $return = array('error' => 1, 'message' => '没有上传的权限。');
            echo json_encode($return);
            die;
        }
        
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
            $config['max_size'] = '1000';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
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
            $title = $this->input->post('title',TRUE);

            //将文件保存到未使用附件表。
            //$id = $this->attachments_model->get_max_id();
            //$insert_data['id']=$id+1;//id是附件表最大id+1，确保附件id的唯一。//默认是自增id，所以一般不会出问题。
            $insert_data['user_id'] = $this->user['id'];
            $insert_data['upload_time'] = $this->time;
            $insert_data['size'] = $data['file_size'];
            $insert_data['extension'] = trim($data['file_ext'], '.');
            $insert_data['filename'] = $data['client_name'];//保存文件的原始名
            $insert_data['path'] = $file_path;
            $insert_data['is_image'] = $data['is_image'];
            $insert_data['description'] = trim($title);
            $insert_data['is_thumb'] = 0;

            $this->attachments_unused_model->insert($insert_data);
            $aid = $this->db->insert_id();

            $file_url = base_url($file_path);
            $return = array('error' => 0, 'url' => $file_url, 'aid' => $aid, 'title' => $title);
            echo json_encode($return);
            die;
        }
    }

    /**
     * 前台编辑器使用的获取数据库表情。
     */
    public function get_smiley_json() {
        $this->load->model(array('smiley_model'));
        $smileys = $this->smiley_model->get_smiley();
        echo $this->echo_ajax(1, count($smileys), $smileys);
        die;
    }

    /**
     * 辩论帖，填写裁判时，校验用户用。
     * @param type $str
     * @return boolean
     */
    public function username_check($str) {
        $user = $this->users_model->get_user_by_name($str);
        if (empty($user['id'])) {
            $this->form_validation->set_message('username_check', '%s不是有效的用户。');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * 帖子支持数
     * @param type $post_id
     */
    public function support($post_id){
        $this->deal_support($post_id,'support');
    }
    public function oppose($post_id){
        $this->deal_support($post_id,'oppose');
    }
    
    /**
     * 处理顶踩的具体程序。
     */
    private function deal_support($post_id,$type='support'){
        //判断是否已经支持过。
        $this->load->model('posts_supported_model');
        $supported = $this->posts_supported_model->get_by_id($post_id);
        if(!empty($supported) && !empty($supported['user_ids'])){
            $user_ids = explode(',', $supported['user_ids']);
            if(in_array($this->user['id'], $user_ids)){
                $this->message('您已经点评过此帖子');
            }
        }
        $post = $this->posts_model->get_by_id($post_id);
        $update_data = array();
        if($post['is_first']==1){
            $field = $type=='support'?'supports':'opposes';
            $update_data[$field] = ':1';
            $is_succ = $this->topics_model->update_increment($update_data, array('id'=>$post['topic_id']));
        }else{
            $topic = $this->topics_model->get_by_id($post['topic_id']);
            if($topic['special']>1){
                $special_class = Biz_post::$specials[$topic['special']];
                if(!empty($special_class)){
                    $this->load->model($special_class);
                    $method = 'deal_support';
                    if(method_exists($this->$special_class, $method)){
                        $is_succ = $this->$special_class->$method($post_id,$type);
                    }else{
                        $is_succ = false;
                    }
                }
            }else{
                $is_succ = false;
            }
        }
        if($is_succ){
            $op_data = array();
            if(!empty($supported)){
                $op_data['user_ids'] = '+'.$this->user['id'];
                $supported = $this->posts_supported_model->update_increment($op_data,array('post_id'=>$post_id));
            }else{
                $op_data['post_id'] = $post_id;
                $op_data['user_ids'] = $this->user['id'];
                $supported = $this->posts_supported_model->insert($op_data);  
            }
            $this->message('操作成功',1);
        }else{
            $this->message('操作失败');
        }
    }
    
    /**
     * 问答帖选择最佳答案，将出入的post_id选为本帖子的最佳答案。
     * @param type $post_id
     */
    public function select_answer($post_id) {
        $this->load->model(array('ask_model','users_extra_model'));
        $post = $this->posts_model->get_by_id($post_id);
        $topic = $this->posts_model->get_by_id($post['topic_id']);
        if($post['topic_id'] !== $this->user['id']){
            $this->message('您不是帖子所有者，无权操作。');
        }
        $ask = $this->ask_model->get_by_id($post['topic_id']);
        if(empty($post) || empty($ask) ){
            $this->message('参数错误');
        }
        if($ask['best_answer']!=0){
            $this->message('此问答已经有了最佳答案！');
        }
        //为最佳答案用户添加积分
        $this->load->model('biz_ask');
        $credits = array($this->biz_ask->ask_credit_type => intval($ask['price']));
        $ask_action = 'best_answer'; //发表问题积分动作关键字
        $is_update_credit = $this->users_extra_model->update_credits($credits, $post['author_id'], $ask_action);
        //var_dump($is_update_credit);die;
        $update_data = array('best_answer'=>$post_id);
        if($this->ask_model->update($update_data,array('topic_id'=>$post['topic_id']))){
            $this->message('操作成功',1);
        }else{
            $this->message('操作失败');
        }
    }
    
    /**
     * 问答帖选择最佳答案，将出入的post_id选为本帖子的最佳答案。
     * @param type $post_id
     */
    public function debate_end($topic_id) {
        $this->load->model(array('debate_model','debate_posts_model'));
        $topic = $this->topics_model->get_by_id($topic_id);
        if(empty($topic)){
            $this->message('参数错误');
        }
        $debate = $this->debate_model->get_by_id($topic_id);
        if(empty($debate)){
            $this->message('参数错误');
        }elseif($debate['umpire']!=$this->user['username']){
            $this->message('您不是指定裁判，暂无权限！');
        }
        $isend = empty($debate['best_debater'])?0:1;
        if ($this->input->post('submit')) {
            $post = $this->input->post(null,TRUE);
            if(trim($post['best_debater2'])!=''){
                $post['best_debater'] = $post['best_debater2'];
            }
            $update_data['winner'] = intval($post['winner']);
            $update_data['best_debater'] = trim($post['best_debater']);
            $update_data['umpire_point'] = trim($post['umpire_point']);
            if(!$isend){
                $update_data['end_time'] = $this->time;
            }
            if(empty($update_data['best_debater'])){
                $this->message('参数错误，最佳辩手不能为空！');
            }elseif(!$this->users_model->get_user_by_name($update_data['best_debater'])){
                $this->message('参数错误，最佳辩手不是有效的用户！');
            }elseif(empty($update_data['umpire_point'])){
                $this->message('裁判员观点不能为空');
            }
            $suc1 = $this->debate_model->update($update_data,array('topic_id'=>$topic_id));
            $suc2 = $this->topics_model->update(array('status'=>5),array('id'=>$topic_id));
            if($suc1 && $suc2){
                $this->message('操作完成！', 1);
            }else{
                $this->message('操作失败！');
            }
        } else {
            //拿到当前发表观点的用户id
            $user_ids = $this->debate_posts_model->get_userids_of_stand($topic_id);
            if(!empty($user_ids)){
                $usernames = $this->users_model->get_names_by_ids($user_ids);
                $var['usernames'] = $usernames;
            }else{
                $var['usernames'] = array();
            }
            if(!empty($debate['best_debater']) && !in_array($debate['best_debater'], $var['usernames'])){
                $debate['best_debater2'] = $debate['best_debater'];
            }
            $var['debate'] = $debate;
            $this->load->view('debate_end', $var);
        }
    }
    
    /**
     * 举报帖子
     * @param type $post_id
     */
    public function report($post_id) {
        $this->load->model('reports_model');
        $post = $this->posts_model->get_by_id($post_id);
        $topic = $this->topics_model->get_by_id($post['topic_id']);
        if(empty($post) || empty($topic)){
            $this->message('参数错误');
        }
        if ($this->input->post('submit')) {
            $report_post = $this->input->post(null,TRUE);
            //检测权限。
            if (!$this->biz_permission->check_base('report', $topic['forum_id'])) {
                $this->message('没有权限。', 0);
            }
            $insert_data = array(
                'topic_id'=>$topic['id'],
                'post_id'=>$post['id'],
                'user_id'=>$this->user['id'],
                'reason'=>html_escape($report_post['reason']),
                'time'=>$this->time,
                'status'=>0,
            );
            if($this->reports_model->insert($insert_data)){
                $this->message('操作完成！', 1);
            }else{
                $this->message('操作失败！');
            }
        } else {
            $var['post_id'] = $post_id;
            $var['post_id'] = $post_id;
            $this->load->view('report', $var);
        }
    }
    
    /**
     * 保存草稿，帖子和回复的草稿
     */
    public function safe_drafts(){
        $this->load->model('drafts_model');
        $post = $this->input->post(null,TRUE);
        
        if(!empty($post['topic_id'])){
            $id_type = "topic_id";
        }elseif(!empty($post['forum_id'])){
            $id_type = "forum_id";
        }else{
            $this->message('参数错误');
        }
        
        $where = array('user_id'=>$this->user['id'],$id_type=> intval($post[$id_type]),'special'=>intval($post['special']));
        $exist = $this->drafts_model->get_one($where);
        
        $drafts['subject'] = html_escape($post['subject']);
        $drafts['content'] = trim($post['content']);
        $drafts['special'] = intval($post['special']);
        unset($post['subject'],$post['content'],$post['special'],$post['submit']);
        $drafts['remain_data'] = json_encode($post);
        $drafts['time'] = $this->time;
        
        if(!empty($exist)){
            $issucc = $this->drafts_model->update($drafts,$where);
        }else{
            $drafts['user_id'] = $this->user['id'];
            $drafts[$id_type] = intval($post[$id_type]);
            $issucc = $this->drafts_model->insert($drafts);
        }
        if($issucc){
            $this->message('操作成功', 1);
        }else{
            $this->message('操作失败');
        }
    }

    /**
     * 辩论帖子投票
     */
    public function debate_vote($topic_id,$stand){
        //判断是否已经支持过。
        $this->load->model('debate_model');
        $debate = $this->debate_model->get_by_id(intval($topic_id));
        if(empty($debate)){
            $this->message('参数错误！');
        }
        $debate['affirm_voterids'] = explode(',', $debate['affirm_voterids']);
        $debate['negate_voterids'] = explode(',', $debate['negate_voterids']);
        $users = ($debate['affirm_voterids']+$debate['negate_voterids']);
        if(!empty($supported) || in_array($this->user['id'], $users)){
            $this->message('您已经投过票！');
        }
        $stand = intval($stand);
        $field = $stand=='1'?'affirm':'negate';
        $update_data[$field.'_votes'] = ':1';
        $update_data[$field.'_voterids'] = '+'.$this->user['id'];
        $is_succ = $this->debate_model->update_increment($update_data, array('topic_id'=>$topic_id));
        if($is_succ){
            $this->message('投票成功',1);
        }else{
            $this->message('投票失败');
        }
    }
    
    /**
     * 关注我
     * @param type $user_id
     */
    public function follow($user_id) {
        $user_id = intval($user_id);
        if(empty($user_id)){
            $this->message('参数错误！'); 
        }
        if ($this->user['id'] == 0) {
            $this->message('您还未登录，请<a href="' . $this->config->item('passport_login') . '" target="_blank">登录</a>。');
        }
        $data = $this->biz_user->follow($user_id);
        if (isset($data['succ']) && $data['succ'] <= 0) {
            $message = !empty($data['msg'])?$data['msg']:'关注失败！';
            $this->message($message);
        } else {
            $this->message('关注成功！',1);
        }
    }
    
    /**
     * 收藏帖子
     * @param type $topic_id
     */
    public function collect($topic_id) {
        $topic_id = intval($topic_id);
        if(empty($topic_id)){
            $this->message('参数错误！'); 
        }
        $data = $this->biz_user->collect($topic_id);
        if (isset($data['succ']) && $data['succ'] > 0) {
            $this->message('收藏帖子成功！',1);
        } else {
            $message = !empty($data['message'])?$data['message']:'收藏帖子失败！';
            $this->message($message);
        }
    }
    
    
}

?>
