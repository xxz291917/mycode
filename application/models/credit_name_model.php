<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_name_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='credit_name';
    }
    
    public function get_view_name($credit_x=''){
        $credit_name = $this->get_all();
        $credit_name = $this->key_list($credit_name, 'credit_x');
        return $credit_name[$credit_x]['view_name'];
    }
    
    
}

?>
