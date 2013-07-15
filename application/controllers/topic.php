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
        $this->load->model(array('biz_topic_manage','biz_post', 'forums_statistics_model', 'posts_model', 'credit_name_model'));
    }

    /**
     * 帖子展示页面，包括特殊帖子。
     * @param type $id
     */
    public function show($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的帖子！');
        }
        $topic = $this->topics_model->get_by_id($id);
        if (empty($topic)) {
            $this->message('参数错误，主题不存在');
        }
        
        $forum = $this->forums_model->get_info_by_id($topic['forum_id']);
        if (empty($forum)) {
            $this->message('参数错误，帖子所属版块不存在');
        }
        //版块是否关闭
        if($forum['status']==0){
            $managers = explode(',', $forum['manager']);
            if (!in_array($this->user['username'], $managers) && $this->user['group']['id'] != 1) {
                $this->message('本帖子所属版论坛暂时关闭。');
            }
        }
        $forum['allow_special'] = explode(',', $forum['allow_special']);
        $var['forum'] = $forum;
        $var['forum_id'] = $topic['forum_id'];
        
        $topic['tags'] = array_filter(explode(',', $topic['tags']));
        
        //如果是置顶，高亮，推荐精华。则获取时间。
        if($topic['top']>0 || $topic['highlight']!='' || $topic['digest']>0 || $topic['recommend']=1){
            //删除过期的设置
            $update_data = $this->biz_post->update_thdr($id);
            if(!empty($update_data)){
                $topic = array_merge($topic,$update_data);
            }
            $action_names = array('top'=>'置顶','highlight'=>'高亮','digest'=>'推荐精华');
            $this->load->model('topics_log_model');
            foreach(array('top','highlight','digest') as $action){
                if(!empty($topic[$action])){
                    $topic['log'] = $this->topics_log_model->get_one("topic_id = $id AND action = '$action'",'user_id,username,time','time desc');
                    if(!empty($topic['log'])){
                        $topic['log']['action_name'] = $action_names[$action];
                    }
                    break;
                }
            }
        }
        
        $var['topic'] = $topic;
        //获取当前用户管理帖子的链接。
        $var['manage_arr'] = $this->biz_topic_manage->get_permission_manage($topic['forum_id']);
        
        //根据不同的主题来获取不同的业务类。
        if($topic['special']>1){
            $class = biz_post::$specials[$topic['special']];
            $this->load->model($class);
        }else{
            $class = 'biz_post';
        }
        
        //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
        $nav = $this->forums_model->get_nav_str($topic['forum_id']);
        $nav[] = array($topic['subject'], current_url());
        $var['nav'] = $nav;
        
        //判断特殊主题帖子类下是否有init_show方法，如果有则调用，如果没有则调用biz_post下的方法。
        $func = 'init_show';
        $cls = method_exists($this->$class, $func)?$this->$class:$this->biz_post;
        $args = func_get_args();
        array_unshift($args, $topic);
        $special_var = call_user_func_array(array($cls, $func), $args);
        $var = array_merge($var, $special_var);
        

        //获取回复的点评
        if(!empty($var['posts'])){
            $view_comment_num = 5;
            $comments = array();
            $few_comment_ids = array();
            $this->load->model('posts_comment_model');
            foreach($var['posts'] as &$post){
                $post['content'] = nl2br($post['content']);
                if($post['comment']>0){
                    if($post['comment']<=$view_comment_num){
                        $few_comment_ids[] = $post['id'];
                    }else{
                        $comments[$post['id']] = $this->posts_comment_model->get_list(array('post_id'=>$post['id']),'*','time desc',0,$view_comment_num);
                    }
                }
            }
            if(!empty($few_comment_ids)){
               $few_comments = $this->posts_comment_model->get_few_list($few_comment_ids);
               if(!empty($few_comments)){
                   $comments = $comments + $few_comments;
               }
            }
            $var['comments'] = $comments;
        }
        
        //如果是特殊帖子回复需要做相应的处理。
        empty($topic['special']) && $topic['special'] = 1;
        $special = $topic['special'];
        if (intval($special) > 1 ) {
            $class = biz_post::$specials[$special];
            $this->load->model($class);
            if(method_exists($this->$class, 'get_reply_view')){
                $var['special_view'] = $this->$class->get_reply_view($topic['id']);
            }
            if (method_exists($this->$class, 'init_reply')) {
                $special_var = $this->$class->init_reply($topic['id']);
                $var = $var + $special_var;
            }
        }

        //获取积分名称。
        $credit_name = $this->credit_name_model->get_all_by_creditx();
        $var['credit_name'] = $credit_name;
        
        //最后更新topics点击数
        $this->topics_model->update_increment(array('views' => ':1'), array('id' => $id));
        
        //得到header头信息
        $var['seo']['title'] = $this->configs['seo_post_title'];
        $var['seo']['description'] = $this->configs['seo_post_description'];
        $var['seo']['keywords'] = $this->configs['seo_post_keywords'];
        
        //得到当前用户对此帖子的管理权限
        $manage_permission = $this->biz_permission->get_manage_permission_no_owner($id);
        $var['manage_permission'] = $manage_permission;
        $base_permission = $this->biz_permission->get_base_permission($topic['forum_id']);
        $var['base_permission'] = $base_permission;
        
        //获取当前用户在此版块下的编辑器权限。（前台过过滤编辑器，重点是对于提交的内容会做相应的处理）
        $is_arr = $this->biz_permission->get_edit_permission($topic['forum_id']);
        $var['is_arr'] = json_encode($is_arr);
        
        //展示模板
        $view_template = self::$post_view[$topic['special']];
        $this->view($view_template, $var);
    }

    
    public function position($topic_id,$post_id='last') {
        if (!is_numeric($topic_id) || (!is_numeric($post_id) && $post_id!='last')) {
            $this->message('参数错误！');
        }
        
        if($post_id=='last'){
            $post_id = $this->posts_model->get_last_post_id($topic_id);
            if(!is_numeric($post_id)){
                $this->message('参数错误!');
            }
        }
        //echo $post_id;die;
        $post = $this->posts_model->get_by_id($post_id);
        $topic = $this->topics_model->get_by_id($topic_id);
        if (empty($topic)||empty($post)) {
            $this->message('参数错误，帖子不存在');
        }

        $where = " topic_id = '$topic_id' AND (status =1 or status =4) ";
        if($topic['special']!=1){
            $where .= "AND is_first != 1";
        }
        $where .= " AND post_time <= '{$post['post_time']}'";
        
        $per_num = $this->config->item('per_num');
        $total_num = $this->posts_model->get_count($where);
        $page_num = ceil($total_num/$per_num);
        $redirect_url = base_url("index.php/topic/show/$topic_id/?per_page=$page_num #p_$post_id");
        redirect($redirect_url);
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
            $post = $this->input->post(null,true);
            //检测权限。
            if (!$this->biz_topic_manage->check_manager_permission($topic_id, $action, $post)) {
                $this->message('操作的主题，没有权限。', 0);
            }
            $this->biz_topic_manage->manage($topic_id, $action, $post);
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
                $topic[$action] = $topic['status'] == Biz_topic_manage::$status[$action] ? 1 : 0;
            } elseif ($action == 'move') {//移动版块
                $forums = $this->forums_model->get_format_forums();
                $forums_option = $this->forums_model->create_options($forums, array($topic['forum_id']));
                $var['forums_option'] = $forums_option;
            } elseif ($action == 'editcategory') {//移动分类
                $this->load->model('topics_category_model');
                $category_option = $this->topics_category_model->create_options($topic['forum_id'],array($topic['category_id']));
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