<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission {
    static $ci;
    
    public function __construct() {
        self::$ci = & get_instance();
        self::$ci->load->model(array('forums_model','groups_admin_model','users_belong_model'));
    }
    
}

?>