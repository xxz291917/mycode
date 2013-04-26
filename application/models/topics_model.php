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
}

?>
