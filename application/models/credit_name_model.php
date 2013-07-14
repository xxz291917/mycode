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
            $credit_name = $this->cache->get($cache_key);
        }
        if(empty($credit_name)){
            $credit_name = $this->get_all();
            $credit_name = $this->key_list($credit_name, 'credit_x');
            if ($this->enable_cache) {
                $this->cache->save($cache_key, $credit_name, $this->config->item('cache_time'));
            }
        }
        return $credit_name;
    }
    
    
    /* power by llw
     * 2013-06-23
     * 积分列表
     */

    public function get_credits_list() {
        $result=parent::get_list('','*');      
        return $result;
    }

    /**
     * power by llw
     * 2013-06-23
     * 更新积分设置
     */
    public function update_credit($data, $file_id) {            
        $this->load->database();  
	$result =$this->db->where('credit_x', $file_id); 
	$result =$this->db->update('credit_name', $data); 
         //$where = " credit_x='$file_id' ";   
       // $result = parent::update($data, $where);
        return $result;
    }
    
   /**
     * 获取积分的名称
     */ 
    public function get_credit_name() {
        $where="status=1";
        $result = parent::get_list($where);
        return $result;
    }
    
    
}

?>
