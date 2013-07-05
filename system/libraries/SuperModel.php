<?php

/**
 *
 * @project firstcodeigniter
 * @version $id$
 * @date 2008-2-19
 * @author haojue
 * @copyright (c) 2008 CSDN
 *
 */
if (!class_exists('CI_Model')) {
    require_once(BASEPATH . 'core/Model' . EXT);
}

class SuperModel extends CI_Model {

    public $_table = '';
    public $html_fields = array();

    function Model($tablename, $database = '') {

        parent::__construct();
        $this->load->database($database);
        $this->_table = $tablename;
    }

    /*
      返回表的字段信息
     */

    function fields() {
        return $this->db->field_data($this->_table);
    }

    /**
     * 插入记录
     *
     * @param obj $record 插入数据对象，一般不要赋主键id
     * @return int
     */
    function insert($record, $returnid = true) {
        //如果未赋表名，则返回假
        if (empty($this->_table))
            return 0;
        $ret = $this->db->insert($this->_table, $record);
        if ($returnid and $ret) {
            if ($this->db->dbdriver == "oci8") {
                return 0;
                //return $ret;
            }
            if ($this->db->dbdriver == "mysql")
                return $this->db->insert_id();
        }
        else
            return $ret;
    }

    /**
     * 更新记录
     *
     * @param obj $record 数据对象
     * @param array $condition  查询条件数组
     * @return int
     */
    function update($record, $condition = array('id')) {
        //如果未赋表名，则返回假
        if (empty($this->_table))
            return 0;

        $where = array();
        foreach ($condition as $k => $v) {
            if (is_array($record)) {
                if (is_numeric($k)) {
                    if (!empty($record["$v"])) {
                        $where["$v"] = $record["$v"];
                    }
                } else {
                    $where["$k"] = $v;
                }
            } else {
                if (is_numeric($k)) {
                    if (!empty($record->$v)) {
                        $where["$v"] = $record->$v;
                    }
                } else {
                    $where["$k"] = $v;
                }
            }
        }
        if (empty($where))
            return 0;

        $this->db->update($this->_table, $record, $where);
        return $this->db->affected_rows();
    }

    /**
     * 删除
     *
     * @param array $condition  查询条件数组
     * @return int
     */
    function delete($condition = array()) {
        if (empty($this->_table))
            return 0;
        if (empty($condition))
            return 0;
        $this->db->delete($this->_table, $condition);
        return $this->db->affected_rows();
    }

    /**
     * 取得一条记录
     *
     * @param array $condition  查询条件数组
     * @return obj
     */
    function getInfo($condition = array()) {
        //$this->db->select("*");
        //$this->db->from($this->_table);
        if (is_array($condition))
            $this->db->where($condition);
        else {
            $this->db->where($condition, NULL, TRUE);
        }

        $query = $this->db->get($this->_table);

        if ($query) {
            if ($query->num_rows() > 0) {
                $ret = $query->row_array();
                foreach ($this->html_fields as $field) {
                    if (array_key_exists($field, $ret)) {
                        $ret[$field] = htmlspecialchars($ret[$field]);
                    }
                }
                $query->free_result();
            } else {
                $ret = array();
            }
            return $ret;
        } else {
            show_error('Databasee Error.');
        }
    }

    /**
     * 取得记录列表
     *
     * @param array $condition  查询条件数组
     * @param string $orderby 排序字符串
     * @param int $pageno
     * @param int $pagesize
     * @return array
     */
    function getList($condition = array(), $orderby = '', $pageno = 1, $pagesize = 20, $fields = '*') {
        $pagesize = is_numeric($pagesize) && $pagesize > 0 ? $pagesize : 20;
        $offset = $pageno <= 0 ? 0 : ( intval($pageno) - 1 ) * $pagesize;

        $this->db->select($fields);
        if (is_array($condition))
            $this->db->where($condition);
        else
            $this->db->where($condition, NULL, FALSE);
        if (!empty($orderby)) {
            $this->db->order_by(trim($orderby));
        }
        if ($pageno > 0)
            $this->db->limit($pagesize, $offset); //LIMIT 20, 10

        $query = $this->db->get($this->_table);
        if ($query and $query->num_rows() > 0) {
            $temp = $query->result_array();
            if (array_key_exists('id', $temp[0])) {
                foreach ($temp as $row) {

                    foreach ($this->html_fields as $field) {
                        if (array_key_exists($field, $row)) {
                            $row[$field] = htmlspecialchars($row[$field]);
                        }
                    }
                    if (array_key_exists('id', $row)) {
                        $object_array[$row['id']] = $row;
                    }
                }
            } else {
                $object_array = $temp;
            }
            $query->free_result(); //释放资源
        } else {
            $object_array = array();
        }
        return $object_array;
    }

    function query($sql) {
        $query = $this->db->query($sql);
        $object_array = array();
        if ($query and $query->num_rows() > 0) {
            $temp = $query->result();
            if (property_exists($temp[0], 'id')) {
                foreach ($temp as $row) {
                    $object_array[$row->id] = $row;
                }
            }else
                $object_array = $temp;
            $query->free_result(); //释放资源
        }
        return $object_array;
    }

    function execute($sql) {
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /**
     * 取得记录条数
     *
     * @param array $condition  查询条件数组
     * @return unknown
     */
    function getCount($condition = array(), $field = '*') {
        $this->db->select(' count(' . $field . ') as num', false);
        $this->db->from($this->_table);

        if (is_array($condition))
            $this->db->where($condition);
        else
            $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
        if ($query) {
            $stdclass = $query->row();
            $num = $stdclass->num;
            $query->free_result(); //释放资源
            return $num;
        }else
            show_error('Databasee Error.');
    }

    /*
     * 用mysql函数group_concat返回用逗号分隔的字符串,结果常用于做in查询
     * @param array $condition  查询条件数组
     * @return ex:1,2,3
     * demo: getGroupConcat(array('fans'=>'piaolankeke'),'username');
     */

    function getGroupConcat($condition = array(), $field) {
        $this->db->select(" group_concat(distinct $field) as fs", false);
        $this->db->from($this->_table);

        if (is_array($condition))
            $this->db->where($condition);
        else
            $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
        if ($query) {
            $stdclass = $query->row();
            $fs = $stdclass->fs;
            $query->free_result(); //释放资源
            $arr_fs = explode(',', $fs);
            $ret = '';
            foreach ($arr_fs as $row) {
                if (is_numeric($row)) {
                    $ret .= "$row,";
                } else {
                    $ret .= "'$row',";
                }
            }
            if (substr($ret, -1, 1) == ',') {
                $ret = substr($ret, 0, -1);
            }
            return $ret;
        }else
            show_error('Databasee Error.');
    }

    function getListByPage($condition = array(), $orderby = '', $pageno = 1, $pagesize = 20, $fields = '*') {
        $pagesize = is_numeric($pagesize) && $pagesize > 0 ? $pagesize : 20;
        $offset = $pageno <= 0 ? 0 : ( intval($pageno) - 1 ) * $pagesize;
        $ret = array();
        $ret['count'] = -1;
        $ret['hasPrev'] = $pageno > 1 ? 1 : 0;
        $ret['hasNext'] = 0;
        $data['page'] = $pageno;
        $data['limit'] = $pagesize;
        $ret['contentList'] = array();
        if (empty($condition))
            $condition = '1=1';
        $this->db->select($fields);
        if (is_array($condition))
            $this->db->where($condition);
        else
            $this->db->where($condition, NULL, FALSE);
        $orderby = trim($orderby);
        if (!empty($orderby)) {
            $this->db->order_by($orderby);
        }
        if ($pageno > 0)
            $this->db->limit($pagesize + 1, $offset);
        $query = $this->db->get($this->_table);
        if ($query and $query->num_rows() > 0) {
            $conentList = $query->result();
            if (count($conentList) > $pagesize) {
                array_pop($conentList);
                $ret['hasNext'] = 1;
            }
            $ret['contentList'] = $conentList;
            $query->free_result();
        }

        $this->db->select(' count(1) as num', false);
        $this->db->from($this->_table);
        $this->db->where($condition, NULL, FALSE);
        $query = $this->db->get();
        if ($query) {
            $stdclass = $query->row();
            $num = $stdclass->num;
            $query->free_result();
            $ret['count'] = $num;
        }

        return $ret;
    }

}

?>