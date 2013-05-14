<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_rule_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='credit_rule';
    }
    
    public function get_rules(){
        $credit_rules = $this->credit_rule_model->get_all();
        $rules = array();
        foreach ($credit_rules as $key => $value) {
            $rules[] = $value['action'];
        }
        return $rules;
    }
    
}

?>
