<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='config';
        $this->id='';
    }
    
    /**
     * 获取所有config，并格式化为name=>value的形式。
     * @return type
     */
    public function get_config() {
        $return = array();
        $configs = $this->get_all();
        foreach ($configs as $key => $config) {
            $return[$config['name']] = $config['value'];
        }
        return $return;
    }
    
    public function update_value($update_data){
        if(empty($update_data)){
            return false;
        }
        $sql = "REPLACE INTO {$this->table} (name,value) VALUES ";
        foreach ($update_data as $key => $val) {
            $sql .= "('$key','$val'),";
        }
        $sql = trim($sql,',');
//        echo $sql;die;
        return $this->db->query($sql);
    }
    
}

?>
