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
            //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
            $nav = $this->forums_model->get_nav_str($forum_id);
            $nav[] = array('发布帖子', current_url());
            $var['nav'] = $nav;
            
            $this->load->model('topics_category_model');
            $category_option = $this->topics_category_model->create_options($forum_id);
            $var['category_option'] = $category_option;
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_post->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            
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
            $post = array_merge($post, array('topic_id' => $topic_id, 'post_id' => $post_id, 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/last');
            if ($this->biz_post->post($post, 'reply')) {
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
            $var['special'] = $special;
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
            
            $var['post_id'] = $post_id;
            if (is_numeric($post_id)) {
                $post = $this->posts_model->get_by_id($post_id);
                if (empty($post)) {
                    $this->message('参数错误，回复的帖子不存在', 0, $forum_show_url);
                }
                $var['post'] = $post;
                $var['quote_content'] = $this->biz_post->get_quote_content($post);
            }
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_post->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            
            $var['type'] = 'reply';
            $var['topic_id'] = $topic_id;
            $this->view('action_post', $var);
        }
    }
    
    
    public function reply_dialog($topic_id = '',$post_id = '') {
        if (empty($topic_id) || !is_numeric($topic_id)) {
            $this->message('参数错误，请指定要发布的主题！', 0, base_url());
        }
        
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)) {
            $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
        }
        
        if ($this->input->post('submit') && $post = $this->input->post(null)) {
            //检测字段
            if(!$this->biz_post->check_post('reply', $topic['special'])){
                $this->message('您输入的参数有问题，请检查。');
            }
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
            $post = array_merge($post, array('topic_id' => $topic_id, 'post_id' => $post_id, 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/last');
            if ($this->biz_post->post($post, 'reply')) {
                $this->message('回复成功，现在查看？', 1, $forum_show_url);
            } else {
                $this->message('回复失败。', 0);
            }
            
        }else{
            $var['topic'] = $topic;
            $var['post_id'] = $post_id;
            if (is_numeric($topic_id)) {
                $post = $this->posts_model->get_by_id($post_id);
                if (empty($post)) {
                    $this->message('参数错误，发布的主题不存在', 0, $forum_show_url);
                }
                $var['post'] = $post;
                $var['quote_content'] = $this->biz_post->get_quote_content($post);
            }
            //如果是特殊帖子需要做相应的处理。
            $special = $topic['special'];
            if ($special != 1) {
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
            $is_arr = $this->biz_post->get_is($topic['forum_id']);
            $var['is_arr'] = $is_arr;
            $var['topic_id'] = $topic_id;
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
            $post = array_merge($post, array('topic_id' => $topic_id, 'post_id' => $post_id, 'forum_id' => $topic['forum_id'],'special'=>$topic['special'], 'topic_author_id' => $topic['author_id']));
            //完成回复。
            $forum_show_url = base_url('index.php/topic/position/'.$topic_id.'/last');
            if ($this->biz_post->post($post, 'reply')) {
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
            $var['special'] = $special;
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
            
            $var['post_id'] = $post_id;
            if (is_numeric($post_id)) {
                $post = $this->posts_model->get_by_id($post_id);
                if (empty($post)) {
                    $this->message('参数错误，回复的帖子不存在', 0, $forum_show_url);
                }
                $var['post'] = $post;
                $var['quote_content'] = $this->biz_post->get_quote_content($post);
            }
            
            //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
            $is_arr = $this->biz_post->get_is($forum_id);
            $var['is_arr'] = $is_arr;
            
            $var['type'] = 'reply';
            $var['topic_id'] = $topic_id;
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
        $this->load->model(array('ask_model'));
        $post = $this->posts_model->get_by_id($post_id);
        $topic = $this->topics_model->get_by_id($post['topic_id']);
        if(empty($post) || empty($topic) || $topic['special']!=2){
            $this->message('参数错误');
        }
        $update_data = array('best_answer'=>$post_id);
        if($this->ask_model->update($update_data,array('topic_id'=>$post['topic_id']))){
            $this->message('操作成功',1);
        }else{
            $this->message('操作失败');
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
            $report_post = $this->input->post();
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
            $this->view('report', $var);
        }
    }
    
    /**
     * 保存草稿，帖子和回复的草稿
     */
    public function safe_drafts(){
        $this->load->model('drafts_model');
        $post = $this->input->post(null);
        
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
    
}

?>
