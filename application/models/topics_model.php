<?php

class Topics_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'topics';
    }

    public function exist_in_forum($forum_id = 0) {
        $sql = 'SELECT id FROM ' . $this->table . ' WHERE forum_id = \'' . $forum_id . '\' AND status!=2 LIMIT 1';
        $query = $this->db->query($sql);
        $id = $query->row_array();
        return empty($id) ? TRUE : FALSE;
    }

    public function get_subject_by_id($id) {
        $topic = $this->get_by_id($id);
        empty($topic['subject']) && $topic['subject'] = '';
        return $topic['subject'];
    }

    public function format_tags($tags) {
        $tags = trim($tags);
        if (!empty($tags)) {
            $tags = preg_split('/[\s,]+/', $tags);
            foreach ($tags as &$tag) {
                $tag = html_escape(utf8_substr($tag, 0, 20));//标签最多允许10个字符。
            }
            $tags = join(',', array_slice(array_unique(array_filter($tags)), 0, 5));
        }
        return $tags;
    }

    /**
     * 根据type类型，获取相关文章。
     * @param int $topic_id
     * @param string $type tag|category|user
     */
    public function related_posts($topic_id, $limit = 5, $type = 'tag') {
        $type_fields = array('tag' => 'tags', 'category' => 'category_id', 'user' => 'author_id');
        $field = $type_fields[$type];
        $topics = $this->get_by_id($topic_id);
        $field_val = $topics[$field];
        if (!empty($field_val)) {
            if ('tag' == $type) {
                $field_val = explode(',', $field_val);
                $field_val = $field_val[array_rand($field_val)];
                $where = "FIND_IN_SET('$field_val',$field)";
            } else {
                $where = "$field='$field_val'";
            }
            $posts = $this->get_list($where, 'id,author,author_id,post_time,subject', 'post_time', 0, $limit);
        } else {
            $posts = false;
        }
        return $posts;
    }

}

?>
