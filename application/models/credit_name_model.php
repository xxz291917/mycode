<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_name_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='credit_name';
    }
    
    public function get_view_name($credit_x=''){
        $credit_name = $this->get_all_by_creditx();
        return $credit_name[$credit_x]['view_name'];
    }
    
    public function get_all_by_creditx() {
        if($this->enable_cache){
            $cache_key = "{$this->table}_get_all_by_creditx";
            return $this->cache->get($cache_key);
        }
        $credit_name = $this->get_all();
        $credit_name = $this->key_list($credit_name, 'credit_x');
        if ($this->enable_cache) {
            $this->cache->save($cache_key, $credit_name, config_item('cache_time'));
        }
        return $credit_name;
    }
    
    
}

?>
