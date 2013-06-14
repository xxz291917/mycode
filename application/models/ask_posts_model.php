<?php

class Ask_posts_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='ask_posts';
        $this->id = 'post_id';
    }
    
}

?>
