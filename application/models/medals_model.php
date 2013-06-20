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

    public function get_medal_tags() {
        $this->load->model('credit_name_model');
        $credit_names = $this->credit_name_model->get_all();
        $condition = array();
        foreach($credit_names as $val){
            $condition[] = array($val['view_name'],$val['credit_x']);
        }
        $fix_condition = array(array('注册时间', 'regdate'),
            array('注册天数', 'regday'),
            array('注册IP', 'regip'),
            array('最后登录IP', 'lastip'),
            array('精华帖数', 'digestposts'),
            array('发帖数', 'posts'),
            array('主题数', 'topics'),
            array('在线时间(小时)', 'oltime'),
            array('+', ' + '),
            array('-', ' - '),
            array('*', ' * '),
            array('/', ' / '),
            array('>', ' > '),
            array('>=', ' >= '),
            array('<', ' < '),
            array('<=', ' <= '),
            array('=', ' = '),
            array('(', ' ( '),
            array(')', ' ) '),
            array('并且', ' and '),
            array('或', ' or '),);
        $condition = array_merge($condition,$fix_condition);
        return $condition;
    }
}

?>
