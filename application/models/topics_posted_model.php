<?php

class Topics_posted_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='topics_posted';
    }
    
    /**
     * 检查当前用户是否回复过此帖子。
     * @param type $topic_id
     */
    public function check_is_posted($topic_id) {
        $is_posted = $this->get_one(array('topic_id'=>$topic_id,'user_id'=>$this->user['id']));
        return !empty($is_posted);
    }
    
}

?>
