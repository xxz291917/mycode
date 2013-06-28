<?php

class Users_admin_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='users_admin';
        $this->id="user_id";
    }
    
}

?>
