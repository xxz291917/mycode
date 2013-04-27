<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='groups';
    }

    public function get_format_forums($cache = TRUE) {
        
    }
}

?>
