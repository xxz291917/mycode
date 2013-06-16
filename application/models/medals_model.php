<?php

class Medals_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'medals';
    }

    public function update_old($data) {
        if (!is_array($data))
            return TRUE;
        $medals = $this->get_all();
        $medals = $this->key_list($medals);
        foreach ($data as $key => $val) {
            $is_update = FALSE;
            $tmp = array();
            $tmp['display_order'] = intval($val['display_order']);
            $tmp['is_open'] = isset($val['is_open']) && intval($val['is_open'])?1:0;
            $name = isset($val['name']) ? trim($val['name']) : '';
            !empty($name) && $tmp['name'] = $name;
            $tmp['description'] = trim($val['description']);
            $tmp['image'] = trim($val['image']);
            foreach ($tmp as $k => $v) {
                if ($medals[$key][$k] != $v) {
                    $is_update = TRUE;
                    break;
                }
            }
            if ($is_update) {
                if (!$this->update($tmp, array('id' => $key))) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function insert_new($data) {
        if (!is_array($data))
            return TRUE;
        foreach ($data as $key => $val) {
            $name = trim($val['name']);
            if (!empty($name)) {
                $insert_data['display_order'] = intval($val['display_order']);
                $insert_data['is_open'] = isset($val['is_open']) && intval($val['is_open'])?1:0;
                $name = isset($val['name']) ? trim($val['name']) : '';
                $insert_data['name'] = $name;
                $insert_data['description'] = trim($val['description']);
                $insert_data['image'] = trim($val['image']);
                if (!$this->insert($insert_data)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

}

?>
