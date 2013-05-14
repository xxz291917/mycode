<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forums_statistics_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'forums_statistics';
        $this->id = 'forum_id';
    }

    public function post_increment($forum_id) {
        $extra_data['last_post_id'] = $this->user['id'];
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
            $extra_data['today_posts'] = $this->is_today($last_post_time) ? ':1' : 0;
            $extra_data['topics'] = ':1';
            $extra_data['today_topics'] = $this->is_today($last_post_time) ? ':1' : 0;
            return $this->update_increment($extra_data, array('forum_id' => $forum_id));
        }
    }

}

?>
