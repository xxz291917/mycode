<?php

class Users_belong_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'users_belong';
        $this->id = 'user_id';
    }

    function update_batch($data, $uid) {
        //删除所有
        if($this->delete(array($this->id=>$uid))){
            //添加批量
            if(!empty($data)){
               $insert_data = array();
                foreach ($data as $gid => $end_time) {
                    $insert_data[$gid][$this->id]=$uid;
                    $insert_data[$gid]['group_id']=$gid;
                    $insert_data[$gid]['end_time']=strtotime($end_time);
                }
                return $this->db->insert_batch($this->table, $insert_data); 
            }
        }
        return FALSE;
    }
    
    
}

?>
