<?php

class Topics_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='topics';
    }

    public function exist_in_forum($forum_id=0) {
        $sql = 'SELECT id FROM ' . $this->table . ' WHERE forum_id = \'' . $forum_id . '\' AND status!=2 LIMIT 1';
        $query = $this->db->query($sql);
        $id = $query->row_array();
        return empty($id) ? TRUE : FALSE;
    }
    
    public function get_subject_by_id($id) {
        $topic = $this->get_by_id($id);
        empty($topic['subject']) && $topic['subject']='';
        return $topic['subject'];
    }
    
    public function format_tags($tags) {
        $tags = trim($tags);
        if(!empty($tags)){
            $tags = preg_split('/[\s,]+/', $tags);
            $tags = join(',', array_slice(array_unique(array_filter($tags)), 0, 5));
        }
        return $tags;
    }
    
}

?>
