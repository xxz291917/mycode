<?php

class Attachments_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'attachments';
        $this->id = 'id';
    }

    public function get_max_id() {
        $num = $this->get_one('', 'max(id) maxid');
        return $num['maxid'];
    }
    
    public function get_images($post_ids) {
        if(empty($post_ids)){
            return array();
        }
        $post_ids = join(',', $post_ids);
        $sql = "select min(upload_time) upload_time,post_id,filename,path,description from attachments where post_id in($post_ids) and is_image=1 group by post_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
//    /**
//     * 获取上传附件列表   
//     */
//    public function get_list($table_a = 'attachments', $table_b = 'topics', $filed = 'a.id', $where = '',$orderby='', $limit = 0, $length = 20) {
//      
//        $sql = "SELECT $filed  FROM  $table_a as a,$table_b  as b  $where ";
//        if (!empty($orderby)) {
//            $sql .= "ORDER BY $orderby ";
//        }
//        if ($length > 0) {
//            $sql .= "LIMIT $limit,$length";
//        }
//        $query = $this->db->query($sql);
//        return $query->result_array();
//        if (!empty($result)) {
//            return $result;
//        }
//    }
//
//    /**
//     * 获取上传附件列表   
//     */
//    public function get_count($table_a = 'attachments', $table_b = 'topics', $where = '', $limit = 0, $length = 20) {
//        $sql = "SELECT count(a.id) as num FROM  $table_a as a ,$table_b as b  $where ";
//        $query = $this->db->query($sql);
//        if ($query->num_rows() > 0) {
//            $row = $query->row();
//            $num = $row->num;
//        }
//        return $num;
//    }
//
//    /**
//     * 删除附件--更新附件状态status为9
//     */
//    public function delete($file_id) {
//        $file_update = array('status' => 9);
//        $where = "id='$file_id '";
//        $result = parent::update_increment($file_update, $where);
//        return $result;
//    }

}

?>
