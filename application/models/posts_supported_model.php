<?php

class Posts_supported_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='posts_supported';
        $this->id = 'post_id';
    }
    
}

?>
