<?php

class Topics_category_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='topics_category';
    }
    
    public function create_options($check_arr = array()) {
        $option = '';
        $categorys = $this->get_all();
        foreach ($categorys as $key => $category) {
            $checked = in_array($category['id'], $check_arr) ? ' selected="selected"' : '';
            $option .= '<option value="' . $category['id'] . '"' . $checked . '>' . $category['name'] . '</option>';
        }
        return !empty($option)?$option:'<option value="0">暂无分类</option>';
    }
    
}

?>
