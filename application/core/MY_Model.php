<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table;
    protected $id = 'id';

    function __construct() {
        parent::__construct();
    }

    public function insert($data) {
        if (!empty($this->table) && !empty($data)) {
            return $this->db->insert($this->table, $data);
        } else {
            return FALSE;
        }
    }
    
    public function insert_batch($data) {
        if (!empty($this->table) && !empty($data)) {
            return $this->db->insert_batch($this->table, $data);
        } else {
            return FALSE;
        }
    }    
    

    public function update($data, $where) {
        if (!empty($this->table) && !empty($data) && !empty($where)) {
            return $this->db->update($this->table, $data, $where);
        } else {
            return FALSE;
        }
    }

    public function update_increment($data, $where) {
        $sql = "UPDATE $this->table SET  ";
        $sql_tmp = '';
        foreach ($data as $key => $value) {
            if (':' == $value[0]) {
                $value = substr($value, 1);
                $sql_tmp .= "$key = $key" . ($value > 0 ? '+' : '') . "$value,";
            } elseif('+' == $value[0]){
                $value = substr($value, 1);
                $sql_tmp .= "$key = CONCAT_WS(',',$key,'$value')";
            } else {
                $sql_tmp .= "$key = '$value',";
            }
        }
        $sql .= trim($sql_tmp, ',') . ' ';
        $sql .= $this->create_where($where);
//        echo $sql;
        return $this->db->query($sql);
    }

    public function delete($where) {
        if (!empty($this->table) && !empty($where)) {
            return $this->db->delete($this->table, $where);
        } else {
            return FALSE;
        }
    }

    public function get_by_id($id) {
        $return = FALSE;
        if($this->enable_cache){
            $cache_key = "{$this->table}_$id";
            $return = $this->cache->get($cache_key);
        }
        if (empty($return)) {
            if (!empty($this->table)) {
                $sql = 'select * from ' . $this->table . ' where ' . $this->id . '=' . $id;
                $query = $this->db->query($sql);
                $return = $query->row_array();
                if ($this->enable_cache) {
                    $this->cache->save($cache_key, $return, config_item('cache_time'));
                }
            }
        }
        return $return;
    }

    public function get_one($where = '', $field = '*', $orderby = '') {
        $where = $this->create_where($where);
        $sql = "SELECT $field FROM $this->table $where ";
        if (!empty($orderby)) {
            $sql .= "ORDER BY $orderby ";
        }
        $sql .= "LIMIT 0,1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_all() {
        $return = false;
        if($this->enable_cache){
            $cache_key = "get_all_{$this->table}";
            $return = $this->cache->get($cache_key);
            if(!empty($return)){
                return $return;
            }
        }
        $query = $this->db->get($this->table);
        $return = $query->result_array();
        if($this->enable_cache){
            $this->cache->save($cache_key, $return, config_item('cache_time'));
        }
        return $return;
    }
    
    public function key_list($list,$key='') {
        empty($key) && $key = $this->id;
        $return = array();
        if(empty($list)){
            return $return;
        }
        foreach ($list as $value) {
            $return[$value[$key]] = $value;
        }
        return $return;
    }

    public function get_count($where = '') {
        $num = $this->get_one($where, 'count(*) num');
        return $num['num'];
    }

    public function get_list($where = '', $field = '*', $orderby = '', $limit = 0, $length = 20) {
        $where = $this->create_where($where);
        $sql = "SELECT $field FROM $this->table $where ";
        if (!empty($orderby)) {
            $sql .= "ORDER BY $orderby ";
        }
        if ($length > 0) {
            $sql .= "LIMIT $limit,$length";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create_where($where = '') {
        if (!is_array($where)) {
            $where = trim($where);
            if(empty($where)){
                return '';
            }
            if (strncasecmp('WHERE ', $where, 6) != 0) {
                $where = 'WHERE ' . $where;
            }
            return $where;
        }
        $where_str = 'WHERE 1 ';
        foreach ($where as $key => $value) {
            $where_str .= "AND $key='$value' ";
        }
        return $where_str;
    }
    
    public function get_list_append_page($where = '', $field = '*', $orderby = '') {
            $per_num = $this->config->item('per_num');
            $total_num = $this->get_count($where);
            //生成分页字符串
            $base_url = current_url();
            $page_obj = $this->init_page($base_url, $total_num, $per_num);
            $page_str = $page_obj->create_links();
            $start = max(0, ($page_obj->cur_page - 1) * $per_num);
            $list = $this->get_list($where, $field , $orderby, $start, $per_num);
            return array('list'=>$list,'page_str'=>$page_str);
    }
    
    

}

?>
