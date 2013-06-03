<?php

class Debate_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='debate';
        $this->id='topic_id';
        
    }
    
}

?>
