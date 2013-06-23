<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Config_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'config';
        $this->id = '';
    }
    
    /**
     * 获取所有config，并格式化为name=>value的形式。
     * @return type
     */
    public function get_config() {
        $return = array();
        $configs = $this->get_all();
        foreach ($configs as $key => $config) {
            $return[$config['name']] = $config['value'];
        }
        return $return;
    }

    public function update_value($update_data) {
        if (empty($update_data)) {
            return false;
        }
        $sql = "REPLACE INTO {$this->table} (name,value) VALUES ";
        foreach ($update_data as $key => $val) {
            $sql .= "('$key','$val'),";
        }
        $sql = trim($sql, ',');
//        echo $sql;die;
        return $this->db->query($sql);
    }

    /* power by llw
     * 2013-06-20
     * 允许附件扩展名列表
     */

    public function get_list() {
        $sql = "SELECT * FROM $this->table where name='attachments_config' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /* power by llw
     * 2013-06-23
     * 积分列表
     */

    public function get_credits_list() {
        $sql = "SELECT * FROM credit_name  ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /**
     * power by llw
     * 2013-06-23
     * 更新积分设置
     */
    public function update_credit($data, $where) {
        $this->load->database();
        $result = $this->db->where('credit_x', $where);
        $result = $this->db->update('credit_name', $data);
        return $result;
    }

    /**
     * 更新附件设置
     */
    public function update_config($str_value) {
        $result = parent::update_increment($data, $where);
        return $result;
    }

}

?>
