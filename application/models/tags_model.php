<?php

class Tags_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='tags';
    }
    
    public function insert_tags($tags,$tid) {
        if(empty($tid) || empty($tags)){
            return FALSE;
        }
        if(is_string($tags)){
            $tags = explode(',', $tags);
        }
        $inser_data = array();
        foreach ($tags as $key=>$tag) {
            $inser_data[$key]['topic_id'] = $tid;
            $inser_data[$key]['tag'] = $tag;
        }
        return $this->insert_batch($inser_data);
    }
}

?>
