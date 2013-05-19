<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table;
    protected $id = 'id';
    protected $list = array();

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
            if (':' !== $value[0]) {
                $sql_tmp .= "$key='$value',";
            } else {
                $value = substr($value, 1);
                $sql_tmp .= "$key=$key" . ($value > 0 ? '+' : '') . "$value,";
            }
        }
        $sql .= trim($sql_tmp, ',') . ' ';
        $sql .= $this->create_where($where);
        return $this->db->query($sql);
    }

    public function delete($where) {
        if (!empty($this->table) && !empty($where)) {
            return $this->db->delete($this->table, $where);
        } else {
            return FALSE;
        }
    }

    public function get_by_id($id, $cache = true) {
        if (!isset($this->list[$id]) || !$cache) {
            if (!empty($this->table)) {
                $sql = 'select * from ' . $this->table . ' where ' . $this->id . '=' . $id;
                $query = $this->db->query($sql);
                $this->list[$id] = $query->row_array();
            } else {
                return array();
            }
        }
        return $this->list[$id];
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
        $query = $this->db->get($this->table);
        return $query->result_array();
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

    protected function upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        }
    }

}

?>
