<?php

class Topics_category_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='topics_category';
    }
    
    /**
     * 生成select的option选项，传入版块id。分类只跟版块id挂钩。
     * @param type $check_arr
     * @return type
     */
    public function create_options($forum_id, $check_arr = array()) {
        $option = '';
        $categorys = $this->get_list(array('forum_id'=>$forum_id));
        if(empty($categorys)){
            foreach ($categorys as $key => $category) {
                $checked = in_array($category['id'], $check_arr) ? ' selected="selected"' : '';
                $option .= '<option value="' . $category['id'] . '"' . $checked . '>' . $category['name'] . '</option>';
            }
        }
        return !empty($option) ? $option : '<option value="0">暂无分类</option>';
    }
    
    
    public function update_old($data,$forum_id) {
        if (!is_array($data))
            return TRUE;
        //得到当前的forums
        $categorys = $this->get_list(array('forum_id'=>$forum_id));
        $categorys = $this->key_list($categorys);
        foreach ($data as $key => $val) {
            $is_update = FALSE;
            $tmp = array();
            $name = isset($val['name']) ? trim($val['name']) : '';
            !empty($name) && $tmp['name'] = $name;
            $tmp['display_order'] = intval($val['display_order']);
            $tmp['moderators'] = !empty($val['moderators'])?intval($val['moderators']):0;
            foreach ($tmp as $k => $v) {
                if ($categorys[$key][$k] != $v) {
                    $is_update = TRUE;
                    break;
                }
            }
            if ($is_update) {
                if (!$this->update($tmp,array('id'=>$key))) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function insert_new($data,$forum_id) {
        if (!is_array($data))
            return TRUE;
        foreach ($data as $key => $val) {
            $name = trim($val['name']);
            if (!empty($name)) {
                $insert_data['display_order'] = intval($val['display_order']);
                $insert_data['name'] = $name;
                $insert_data['forum_id'] = $forum_id;
                $insert_data['moderators'] = !empty($val['moderators'])?intval($val['moderators']):0;
                if (!$this->insert($insert_data)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
    
}

?>
