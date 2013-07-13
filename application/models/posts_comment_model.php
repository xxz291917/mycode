<?php

class Posts_comment_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='posts_comment';
    }
    
    public function get_few_list($post_ids) {
        if(empty($post_ids)){
            return array();
        }else{
            $return_data = array();
            $post_ids = join(',', array_unique($post_ids));
            $comments = $this->get_list('post_id in('.$post_ids.')', '*','time desc');
            foreach ($comments as $comment){
                $return_data[$comment['post_id']][] = $comment;
            }
            return $return_data;
        }
    }
    
}

?>
