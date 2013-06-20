<?php

class Attachments_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='attachments';
        $this->id='id';
    }
    
    public function get_max_id() {
        $num = $this->get_one('', 'max(id) maxid');
        return $num['maxid'];
    }
}

?>
