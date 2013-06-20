<?php

class Reports_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table='reports';
    }
    /**
     * 处理或者撤销举报--更新状态status，处理：1 撤销：2
     */
    public function delete($file_id,$status='0') {
        $nowtime=time();
        $file_update = array('status' => $status,'operate_time' => $nowtime);
        $where = "id='$file_id '";
       // echo $where;
        $result = parent::update_increment($file_update, $where);
        return $result;
    }
    
}

?>
