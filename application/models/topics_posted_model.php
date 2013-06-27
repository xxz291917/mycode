<?php

class Topics_posted_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='topics_posted';
    }
    
    /**
     * 检查当前用户是否回复过此帖子。
     * @param type $topic_id
     */
    public function check_is_posted($topic_id) {
        $is_posted = $this->get_one(array('topic_id'=>$topic_id,'user_id'=>$this->user['id']));
        return !empty($is_posted);
    }
    
    /**
     * 获取我回复帖子的列表 
     */
    public function get_list($limit = 0, $length = 20) {
        $userid = $this->user['id'];
        $where = " where  a.topic_id=b.id and a.user_id='$userid' ";
        $sql = "SELECT a.user_id,a.topic_id,a.time,b.subject,b.id,b.author  FROM  topics_posted as a,topics as b  $where ";
        if (!empty($orderby)) {
            $sql .= "ORDER BY a.time DESC ";
        }
        if ($length > 0) {
            $sql .= "LIMIT $limit,$length";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
        if (!empty($result)) {
            return $result;
        }
    }
    
     /**
     * 获取上传附件列表   
     */
    public function get_count() {
        $userid = $this->user['id'];
        $where = " where a.topic_id=b.id and a.user_id='$userid' ";
        $sql = "SELECT count(a.user_id) as num  FROM  topics_posted as a,topics as b  $where ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $num = $row->num;
        }
        return $num;
    }
 

}

?>
