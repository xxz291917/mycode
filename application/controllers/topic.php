<?php

class Topic extends MY_Controller {

    static $per_num = 5;
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('index','forums_statistics_model','posts_model','credit_name_model'));
    }

    private function get_manage_arr() {
        $manage_arr = array('allow_top' => '置顶',
            'allow_digest' => '推荐精华',
            'is_highlight' => '高亮',
            'is_bump' => '提升',
            'is_move' => '移动',
            'is_editcategory' => '分类',
            'is_ban' => '屏蔽',
            'is_close' => '关闭',
            'is_del' => '删除',
            'is_copy' => '复制',
            'is_merge' => '合并',
            'is_split' => '切分',);
        $return_arr = array();
        foreach ($manage_arr as $key => $val) {
            list($null,$action) = explode('_', $key);
            $return_arr[$key] = array($action,$val);
        }
        return $return_arr;
    }


    public function show($id) {
        if (empty($id) || !is_numeric($id)) {
            $this->message('参数错误，请指定要展示的版块！');
        }
        $topic = $this->topics_model->get_by_id($id);
        if(empty($topic)){
            $this->message('参数错误，主题不存在');
        }
        $var['topic'] = $topic;
        //获取管理权限
        $var['admin_permission'] = $this->groups_model->get_admin_permission($topic['forum_id']);
        //获取页面中展示的可操作的链接
        $manage_arr = $this->get_manage_arr();
        foreach ($manage_arr as $key => $val) {
            if(empty($var['admin_permission'][$key])){
                unset($manage_arr[$key]);
            }
        }
        $var['manage_arr'] = $manage_arr;
        
        //获取本主题下的回复
        $per_num = self::$per_num;
        $total_num = $var['topic']['replies']+1;
        //生成分页字符串
        $base_url = $this->get_current_url()."/$id";
        $config['uri_segment'] = 4;
        $page_obj = $this->init_page($base_url, $total_num,$per_num,$config);
        $page_str = $page_obj->create_links();
        
        $start = max(0,($page_obj->cur_page-1)*$per_num);
        $posts = $this->posts_model->get_list(array('topic_id'=>$id), '*', 'post_time', $start,$per_num);
        
        //获取需要的用户信息
        $uids = array();
        foreach ($posts as $post){
            $uids[] = $post['author_id'];
        }
        $users = $this->users_model->get_users_by_ids(array_unique($uids));
        $groups = $this->groups_model->get_key_groups();
        $key_users = array();
        foreach ($users as $key => $value) {
            $group_id = empty($value['group_id'])?$value['member_id']:$value['group_id'];
            $key_users[$value['id']] = $value;
            $key_users[$value['id']]['group'] = $groups[$group_id];
        }
        
        $credit_name = $this->credit_name_model->get_all();
        $credit_name = $this->credit_name_model->key_list($credit_name,'credit_x');

        $var['posts'] = $posts;
        $var['users'] = $key_users;
        $var['credit_name'] = $credit_name;
        $var['page'] = $page_str;
        
        //最后更新topics点击数
        $this->topics_model->update_increment(array('views'=>':1'),array('id'=>$id));
        
        $this->view('topic_show',$var);
    }
    
    /**
     * 管理帖子，接收post过来的topic_id,填写删除原因，然后删除帖子。
     */
    public function manage($action,$topic_id) {
        if (empty($action)) {
            $this->message('参数错误，请指定您的操作！', base_url());
        }
        $topic = $this->topics_model->get_by_id($topic_id);
        if(empty($topic)){
            $this->message('参数错误，主题不存在');
        }
        $var['action'] = $action;
        $post = $this->input->post(null);
        $var['count'] = 1;
        if (isset($post['submit']) && $this->check_manage($action)) {
            //检测权限。
            $admin_permission = $this->groups_model->get_admin_permission($topic['forum_id']);
            
            
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
            //$this->load->view('header2',$var);
            $this->load->view('topic_manage',$var);
            //$this->load->view('footer',$var);
        }
    }
    
}

?>