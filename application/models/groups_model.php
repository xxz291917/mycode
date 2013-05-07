<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='groups';
    }

    //'system', 'special', 'member'
    public function get_groups($type='') {
        $sql = "select * from {$this->table} where 1 ";
        if(!empty($type)){
            $sql .= "and type = '$type' order by credits";
        }else{
            $sql .= "order by type,credits";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    private function get_key_groups($key = 'id',$type='') {
        $groups = $this->get_groups($type);
        $key_groups = array();
        foreach ($groups as $v) {
            $key_groups[$v[$key]] = $v;
        }
        return $key_groups;
    }
    
    public function update_old($data,$type) {
        if (!is_array($data))
            return TRUE;
        elseif(empty ($type))
            return FALSE;
        //得到当前的forums
        $groups = $this->get_key_groups('id',$type);
        foreach ($data as $key => $val) {
            $is_update = FALSE;
            $tmp = array();
            $name = isset($val['name']) ? trim($val['name']) : '';
            !empty($name) && $tmp['name'] = $name;
            $tmp['stars'] = intval($val['stars']);
            isset($val['credits']) && $tmp['credits'] = intval($val['credits']);
            foreach ($tmp as $k => $v) {
                if ($groups[$key][$k] != $v) {
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

    public function insert_new($data,$type) {
        if (!is_array($data))
            return TRUE;
        elseif(empty ($type))
            return FALSE;
        foreach ($data as $key => $val) {
            $name = trim($val['name']);
            if (!empty($name)) {
                $insert_data['name'] = $name;
                $insert_data['type'] = $type;
                $insert_data['stars'] = intval($val['stars']);
                isset($val['credits']) && $insert_data['credits'] = intval($val['credits']);
                if (!$this->insert($insert_data)) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
    
    public function form_filter($datas, $type = 'en') {
        foreach ($datas as $key => $value) {
            if ($type == 'en') {
                switch ($key) {
                    case 'submit':
                        unset($datas[$key]);
                        break;
                    case 'allow_special':
                        $datas[$key] = join(',', $value);
                        break;
                    case 'extra_setting':
                        $datas[$key] = json_encode($value);
                        break;
                    default:
                        $datas[$key] = trim($value);
                        break;
                }
            } else {
                switch ($key) {
                    case 'allow_special':
                        //权限存取的规则都是，以逗号分隔的用户组id。
                        $datas[$key] = explode(',', $value);
                        break;
                    case 'extra_setting':
                        $datas[$key] = json_decode($value, TRUE);
                        break;
                }
            }
        }
        return $datas;
    }
}

?>
