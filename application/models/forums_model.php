<?php

class Forums_model extends MY_Model {

    public $forums;
    public $format_forums;

    function __construct() {
        parent::__construct();
        $this->table='forums';
    }

    function initialize() {
        return TRUE;
    }

    public function get_format_forums($cache = TRUE) {
        if (!$cache || empty($this->format_forums)) {
            $forums = $this->get_forums();
            if (!empty($forums)) {
                $forums = $this->format($forums);
            }
            $this->format_forums = $forums;
        }
        return $this->format_forums;
    }

    public function get_forums() {
        if (empty($this->forums)) {
            $this->db->order_by("display_order");
            $query = $this->db->get($this->table);
            $this->forums = $query->result_array();
        }
        return $this->forums;
    }

    private function get_key_forums($key = 'id') {
        $forums = $this->get_forums();
        $key_forums = array();
        foreach ($forums as $v) {
            $key_forums[$v[$key]] = $v;
        }
        return $key_forums;
    }

    private function format($forums) {
        if (empty($forums)) {
            return array();
        }
        $new_forums = $tmp = array();
        foreach ($forums as $key => $value) {
            $tmp[$value['parent_id']][] = $value;
        }
        //最多三级分类
        $new_forums = $tmp[0];
        unset($tmp[0]);
        foreach ($new_forums as $key => $value) {//最多三级分类
            if (isset($tmp[$value['id']])) {
                $new_forums[$key]['sub'] = $tmp[$value['id']];
                unset($tmp[$value['id']]);
                foreach ($new_forums[$key]['sub'] as $k => $v) {
                    if (isset($tmp[$v['id']])) {
                        $new_forums[$key]['sub'][$k]['sub'] = $tmp[$v['id']];
                    }
                }
            }
        }
        return $new_forums;
    }

    private function format_manager($manager) {
        return trim(preg_replace('/[,;\s]+/', ',', $manager), ',');
    }

    public function update_old($data) {
        if (!is_array($data))
            return TRUE;
        //得到当前的forums
        $forums = $this->get_key_forums('id');
        foreach ($data as $key => $val) {
            $is_update = FALSE;
            $tmp = array();
            $name = isset($val['name']) ? trim($val['name']) : '';
            $manager = $this->format_manager($val['manager']);
            !empty($name) && $tmp['name'] = $name;
            !empty($manager) && $tmp['manager'] = $manager;
            $tmp['display_order'] = intval($val['order']);
            foreach ($tmp as $k => $v) {
                if ($forums[$key][$k] != $v) {
                    $is_update = TRUE;
                    break;
                }
            }
            if ($is_update) {
                $this->db->where('id', $key);
                if (!$this->db->update($this->table, $tmp)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function insert_new($data) {
        if (!is_array($data))
            return TRUE;
        $type_arr = array(1 => 'group', 2 => 'forum', 3 => 'sub');
        $tmp_pids = array();
        for ($type = 1; $type <= 3; $type++) {
            foreach ($data as $key => $val) {
                if ($val['type'] == $type) {
                    $name = trim($val['name']);
                    if (!empty($name)) {
                        $insert_data['display_order'] = intval($val['order']);
                        $insert_data['name'] = $name;
                        $insert_data['parent_id'] = is_numeric($val['pid']) ? $val['pid'] : $tmp_pids[$val['pid']];
                        $insert_data['type'] = $type_arr[$val['type']];
                        $insert_data['manager'] = $this->format_manager($val['manager']);
                        if ($this->db->insert($this->table, $insert_data)) {
                            $id = $this->db->insert_id();
                            $tmp_pids[$key] = $id;
                        } else {
                            return FALSE;
                        }
                    }
                    unset($data[$key]);
                }
            }
        }
        return TRUE;
    }

}

?>
