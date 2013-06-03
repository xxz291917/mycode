<?php

class Poll_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='poll';
        $this->id='topic_id';
        
    }
    
}

?>
