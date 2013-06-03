<?php

class Debate_posts_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='debate_posts';
        $this->id='topic_id';
        
    }
    
}

?>
