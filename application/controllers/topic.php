<?php

class Topic extends MY_Controller {

    static $per_num = 10;
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('index','forums_statistics_model','posts_model','credit_name_model'));
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
        $var['admin_permission'] = $this->groups_model->get_admin_permission($topic['forum_id']);
        
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
        $users = $this->users_model->key_list($users,'id');
        
        $credit_name = $this->credit_name_model->get_all();
        $credit_name = $this->credit_name_model->key_list($credit_name,'credit_x');

        $var['posts'] = $posts;
        $var['users'] = $users;
        $var['credit_name'] = $credit_name;
        $var['page'] = $page_str;
        
        //最后更新topics点击数
        $this->topics_model->update_increment(array('views'=>':1'),array('id'=>$id));
        
        $this->view('topic_show',$var);
    }
    
}

?>