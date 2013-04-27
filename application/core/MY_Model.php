<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table;
    protected $id = 'id';
            
    function __construct() {
        parent::__construct();
    }

    public function get_by_id($id){
        if(!empty($this->table)){
            $sql = 'select * from '.$this->table.' where '.$this->id.'='.$id;
            $query = $this->db->query($sql);
            return $query->row_array();
        }else{
            return array();
        }
    }
    public function insert($data){
        if(!empty($this->table) && !empty($data)){
            return $this->db->insert($this->table, $data);
        }else{
            return FALSE;
        }
    }
    public function update($data,$where){
        if(!empty($this->table) && !empty($data) && !empty($where)){
            return $this->db->update($this->table, $data, $where); 
        }else{
            return FALSE;
        }
    }
    
   public function get_all(){
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
}
?>
