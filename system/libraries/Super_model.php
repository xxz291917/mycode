<?php

/**
 *
 * @project firstcodeigniter
 * @version $id$
 * @date 2013-04-24
 * @author qinyf
 *
 */
if (!class_exists('CI_Model')) {
    require_once(BASEPATH . 'core/Model' . EXT);
}

class Super_model extends CI_Model {

    public $_table = '';
    public $html_fields = array();

    function Model($tablename, $database = '') {
        parent::__construct();
        $this->load->database($database);
        $this->_table = $tablename;
    }

    /**
     * 返回表的字段信息
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
        $ret = 0;
        //如果未赋表名，则返回假
        if (empty($this->_table)) {
            return $ret;
        }
        $ret = $this->db->insert($this->_table, $record);
        if ($returnid and $ret) {
            if ($this->db->dbdriver == "mysql") {
                return $this->db->insert_id();
            }
        } else {
            return $ret;
        }
    }

    /**
     * 更新记录
     *
     * @param obj $record 数组
     * @param array $condition  查询条件数组
     * @return int
     */
    function update($record, $condition = array('id')) {
        $ret = 0;
        //如果未赋表名，则返回假
        if (empty($this->_table)) {
            return $ret;
        }

        $where = array();
        if (is_array($condition)) {
            foreach ($condition as $k => $v) {
                if (is_array($record)) {
                    if (is_numeric($k)) {
                        if (!empty($record["$v"])) {
                            $where["$v"] = $record["$v"];
                        }
                    } else {
                        $where["$k"] = $v;
                    }
                }
            }
        } elseif (is_string($condition)) {
            $where = $condition;
        }
        if (empty($where)) {
            return $ret;
        }

        $this->db->update($this->_table, $record, $where);
        $ret = $this->db->affected_rows();
        return $ret;
    }

    /**
     * 删除
     *
     * @param array $condition  查询条件数组
     * @return int
     */
    function delete($condition = array()) {
        $ret = 0;
        //如果未赋表名，则返回假
        if (empty($this->_table)) {
            return $ret;
        }
        if (empty($condition)) {
            return $ret;
        }
        $this->db->delete($this->_table, $condition);
        $ret = $this->db->affected_rows();
        return $ret;
    }

    /**
     * 取得一条记录
     *
     * @param array $condition  查询条件数组
     * @return obj
     */
    function get_info($condition = array(), $orderby = '') {
        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($condition, NULL, TRUE);
        }
        if (!empty($orderby)) {
            $this->db->order_by(trim($orderby));
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
    function get_list($condition = array(), $pageno = 1, $pagesize = 20, $orderby = '', $fields = '*') {
        $object_array = array();
        $pagesize = is_numeric($pagesize) && $pagesize > 0 ? $pagesize : 20;
        $offset = $pageno <= 0 ? 0 : ( intval($pageno) - 1 ) * $pagesize;

        $this->db->select($fields);
        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($condition, NULL, FALSE);
        }
        if (!empty($orderby)) {
            $this->db->order_by(trim($orderby));
        }
        if ($pageno > 0) {
            $this->db->limit($pagesize, $offset); //LIMIT 20, 10 
        }

        $query = $this->db->get($this->_table);
        if ($query and $query->num_rows() > 0) {
            $temp = $query->result_array();
            foreach ($temp as $row) {
                foreach ($this->html_fields as $field) {
                    if (array_key_exists($field, $row)) {
                        $row[$field] = htmlspecialchars($row[$field]);
                    }
                }
                $object_array[] = $row;
            }
            $query->free_result(); //释放资源
        }
        return $object_array;
    }

    function query($sql) {
        $query = $this->db->query($sql);
        $object_array = array();
        if ($query and $query->num_rows() > 0) {
            $temp = $query->result_array();
            foreach ($temp as $row) {
                foreach ($this->html_fields as $field) {
                    if (array_key_exists($field, $row)) {
                        $row[$field] = htmlspecialchars($row[$field]);
                    }
                }
                $object_array[] = $row;
            }
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
    function get_count($condition = array(), $field = '*') {
        $this->db->select(' count(' . $field . ') as num', false);
        $this->db->from($this->_table);

        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($condition, NULL, FALSE);
        }

        $query = $this->db->get();
        if ($query) {
            $stdclass = $query->row();
            $num = $stdclass->num;
            $query->free_result(); //释放资源
            return $num;
        } else {
            show_error('Databasee Error.');
        }
    }

    /**
     * 用mysql函数group_concat返回用逗号分隔的字符串,结果常用于做in查询
     * @param array $condition  查询条件数组
     * @return ex:1,2,3
     * demo: getGroupConcat(array('fans'=>'piaolankeke'),'username');
     */
    function get_group_concat($condition = array(), $field) {
        $this->db->select(" group_concat(distinct $field) as fs", false);
        $this->db->from($this->_table);

        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($condition, NULL, FALSE);
        }

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
        } else {
            show_error('Databasee Error.');
        }
    }

    //like query
    //join query

	/**
	 * in 查询取列表
	 */
    function get_list_in($condition = array(), $where_in = array(), $pageno = 1, $pagesize = 20, $orderby = '', $fields = '*') {
        $object_array = array();
        $pagesize = is_numeric($pagesize) && $pagesize > 0 ? $pagesize : 20;
        $offset = $pageno <= 0 ? 0 : ( intval($pageno) - 1 ) * $pagesize;

        $this->db->select($fields);
        if(!empty($condition)){
        	if (is_array($condition)) {
	            $this->db->where($condition);
	        } else {
	            $this->db->where($condition, NULL, FALSE);
	        }
        }
        if (!empty($where_in)) {
            foreach ($where_in as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }
        if (!empty($orderby)) {
            $this->db->order_by(trim($orderby));
        }
        if ($pageno > 0) {
            $this->db->limit($pagesize, $offset); //LIMIT 20, 10 
        }

        $query = $this->db->get($this->_table);
        if ($query and $query->num_rows() > 0) {
            $temp = $query->result_array();
            foreach ($temp as $row) {
                foreach ($this->html_fields as $field) {
                    if (array_key_exists($field, $row)) {
                        $row[$field] = htmlspecialchars($row[$field]);
                    }
                }
                $object_array[] = $row;
            }
            $query->free_result(); //释放资源
        }
        return $object_array;
    }

	/**
	 * in 查询取总数
	 */
    function get_count_in($condition = array(), $where_in = array(), $field = '*') {
        $this->db->select(' count(' . $field . ') as num', false);
        $this->db->from($this->_table);

        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($condition, NULL, FALSE);
        }
        if (!empty($where_in)) {
            foreach ($where_in as $key => $val) {
                $this->db->where_in($key, $val);
            }
        }

        $query = $this->db->get();
        if ($query) {
            $stdclass = $query->row();
            $num = $stdclass->num;
            $query->free_result(); //释放资源
            return $num;
        } else {
            show_error('Databasee Error.');
        }
    }
    
    /**
     * 更新字段+n
     * $key = table field
	 * $condition $key=>$val or string
	 * $setarr $key=>$key+num
	 */
    function update_add_number($record,$condition){
    	$ret = 0;
        //如果未赋表名，则返回假
        if (empty($this->_table)) {
            return $ret;
        }

        $where = $condition;
        if (empty($where)) {
            return $ret;
        }

     	foreach ($record as $k => $v) {
     		$this->db->set($k,$v,false);
     	}
     	$this->db->where($where);
        $this->db->update($this->_table);
        $ret = $this->db->affected_rows();
        return $ret;
    }

}

?>