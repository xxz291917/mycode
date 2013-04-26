<?php
class MY_Model extends CI_Model {

    protected $table;
    protected $id;
            
    function __construct() {
        parent::__construct();
        $this->id = 'id';
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
}
?>
