<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forums_statistics_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'forums_statistics';
        $this->id = 'forum_id';
        $this->load->model(array('permission','index'));
    }

    public function post_increment($forum_id,$topic_id) {
        $extra_data['last_post_id'] = $topic_id;
        $extra_data['last_post_time'] = $this->time;
        $extra_data['last_author'] = $this->user['username'];
        $statics = $this->get_by_id($forum_id);
        if (empty($statics)) {
            $extra_data['forum_id'] = $forum_id;
            $extra_data['posts'] = 1;
            $extra_data['today_posts'] = 1;
            $extra_data['topics'] = 1;
            $extra_data['today_topics'] = 1;
            return $this->insert($extra_data);
        } else {
            $last_post_time = $statics['last_post_time'];
            $extra_data['posts'] = ':1';
            $extra_data['today_posts'] = $this->permission->is_today($last_post_time) ? ':1' : 1;
            $extra_data['topics'] = ':1';
            $extra_data['today_topics'] = $this->permission->is_today($last_post_time) ? ':1' : 1;
            return $this->update_increment($extra_data, array('forum_id' => $forum_id));
        }
    }
    
    
    public function append_to_forums($forums) {
        $statistics = $this->get_all();
        $statistics = $this->key_list($statistics);
        $return = array();
        foreach ($forums as $key => $value) {
            $fourm_id = $value['id'];
            if(isset($statistics[$fourm_id])){
                $this_statistics = $this->index->process_statistics_one($statistics[$fourm_id]);
            }else{
                $this_statistics = array();
            }
            $return[$fourm_id] = array_merge($value,$this_statistics);
        }
        return $return;
    }
    
    
    

}

?>
