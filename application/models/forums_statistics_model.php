<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forums_statistics_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'forums_statistics';
        $this->id = 'forum_id';
        $this->load->model(array('permission', 'index'));
    }

    /**
     * 发帖或者回帖，更新版块的统计信息。
     * @param int $forum_id 版块id
     * @param int $topic_id 帖子id
     * @param string $type 发帖or回帖
     * @return type
     */
    public function post_increment($forum_id, $topic_id, $type = "post") {
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
            //如果是主题帖子发表，还要在topics上加1
            if ("post" == $type) {
                $extra_data['topics'] = ':1';
                $extra_data['today_topics'] = $this->permission->is_today($last_post_time) ? ':1' : 1;
            }
            return $this->update_increment($extra_data, array('forum_id' => $forum_id));
        }
    }

    /**
     * 为传入的forums数组添加statictis信息
     * @param array $forums 传入的forums数组
     * @return type
     */
    public function append_to_forums($forums) {
        $statistics = $this->get_all();
        $statistics = $this->key_list($statistics);
        $return = array();
        foreach ($forums as $key => $value) {
            $fourm_id = $value['id'];
            if (isset($statistics[$fourm_id])) {
                $this_statistics = $this->index->process_statistics_one($statistics[$fourm_id]);
            } else {
                $this_statistics = array();
            }
            $return[$fourm_id] = array_merge($value, $this_statistics);
        }
        return $return;
    }

}

?>
