<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_admin_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='groups_admin';
        $this->id='group_id';
    }
    
    public function get_groups($fields = '') {
        $fields = !empty($fields)?$fields:'*';
        $sql = "SELECT ga.$fields,g.name,g.type,g.stars FROM {$this->table} ga LEFT JOIN groups g ON g.id = ga.group_id WHERE 1 ORDER BY g.type";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_by_id($id){
        if(!empty($this->table)){
            $sql = "SELECT ga.*,g.name,g.type,g.stars FROM {$this->table} ga LEFT JOIN groups g ON g.id = ga.group_id where {$this->id}=$id";
            $query = $this->db->query($sql);
            return $query->row_array();
        }else{
            return array();
        }
    }
    
    public function form_filter($datas) {
        $checkbox_arr = array('is_editpost','is_checkpost','is_copythread','is_mergethread','is_splitthread','is_movethread','is_delpost','is_banpost','is_highlight','is_recommend','is_bump','is_closethread');
        foreach ($datas as $key => $value) {
            if(in_array($key, $checkbox_arr)){ 
                continue;
            }
            switch ($key) {
                case 'submit':
                    unset($datas[$key]);
                    break;
                default:
                    $datas[$key] = trim($value);
                    break;
            }
        }
        foreach ($checkbox_arr as $k=>$v){
            $datas[$v] = (isset($datas[$v])&&!empty($datas[$v]))?1:0;
        }
        return $datas;
    }
    
    
    
}

?>
