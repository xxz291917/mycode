<?php

class Ask_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='ask';
        $this->id = 'topic_id';
    }
    
}

?>
