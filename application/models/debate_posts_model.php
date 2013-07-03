<?php

class Debate_posts_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='debate_posts';
        $this->id='post_id';
    }
    
    /**
     * 检查当前用户是否发表过自己的观点。
     * @param type $topic_id
     */
    public function check_is_posted($topic_id) {
        $is_posted = $this->get_one(array('topic_id'=>$topic_id,'user_id'=>$this->user['id']));
        return !empty($is_posted);
    }
    
    public function get_count_join_topics($where) {
        $where = 
        $sql = "SELECT count(*) num FROM $this->table $where ";
        $sql .= "LIMIT 0,1";
        $query = $this->db->query($sql);
        $num = $query->row_array();
        return $num['num'];
    }
    
    public function get_posts_list($where = '', $field = '*', $orderby = '', $limit = 0, $length = 20) {
        $where = $this->create_where($where);
        $sql = "SELECT $field FROM $this->table $where ";
        if (!empty($orderby)) {
            $sql .= "ORDER BY $orderby ";
        }
        if ($length > 0) {
            $sql .= "LIMIT $limit,$length";
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        
        if (!empty($result)) {
            foreach ($result as $key => &$value) {
                $value = $this->posts_model->output_filter($value);
            }
        }
        return $result;
    }
    
    /**
     * 得到某个帖子的发表过观点的用户的id，并按照支持数排序，取出前20来。
     * @param type $topic_id
     */
    public function get_userids_of_stand($topic_id) {
        $user_ids = $this->get_list(array('topic_id'=>$topic_id),'user_id','voters desc',0,20);
        $ids = array();
        if(!empty($user_ids)){
            foreach ($user_ids as $key => $value) {
                $ids[] = $value['user_id'];
            }
        }
        return $ids;
    }
}

?>
