<?php

class Poll_voter_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='poll_voter';
    }
    
}

?>
