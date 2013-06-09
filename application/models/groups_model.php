<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Groups_model extends MY_Model {

    static $moderators_id = 3;
    public $admin_permission = array();
    
    function __construct() {
        parent::__construct();
        $this->table = 'groups';
    }

    //'system', 'special', 'member'
    public function get_groups($type = '') {
        $sql = "select * from {$this->table} where 1 ";
        if (!empty($type)) {
            $sql .= "and type = '$type' order by credits";
        } else {
            $sql .= "order by type,credits";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_key_groups($key = 'id', $type = '') {
        $groups = $this->get_groups($type);
        $key_groups = array();
        foreach ($groups as $v) {
            $key_groups[$v[$key]] = $v;
        }
        return $key_groups;
    }

    public function update_old($data, $type) {
        if (!is_array($data))
            return TRUE;
        elseif (empty($type))
            return FALSE;
        //得到当前的forums
        $groups = $this->get_key_groups('id', $type);
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
                if (!$this->update($tmp, array('id' => $key))) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function insert_new($data, $type) {
        if (!is_array($data))
            return TRUE;
        elseif (empty($type))
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

    /**
     * 生成用户组的下拉菜单选项，格式如下：
     * <optgroup label="会员用户组">
     * <option value="9">限制会员</option>
     * </optgroup>
     * @param array $check_arr 默认选中的用户组数组
     * @return string 
     */
    public function create_options($check_arr = array()) {
        $option = '';
        $type_names = array('system' => '系统用户组', 'special' => '特殊用户组', 'member' => '会员用户组');
        $groups = $this->get_groups();
        $current_type = '';
        foreach ($groups as $key => $group) {
            if ($group['type'] != $current_type) {
                if (empty($current_type)) {
                    $option .= '<optgroup label="' . $type_names[$group['type']] . '">';
                } else {
                    $option .= '</optgroup><optgroup label="' . $type_names[$group['type']] . '">';
                }
                $current_type = $group['type'];
            }
            $checked = in_array($group['id'], $check_arr) ? ' selected="selected"' : '';
            $option .= '<option value="' . $group['id'] . '"' . $checked . '>' . $group['name'] . '</option>';
        }
        $option .= '</optgroup>';
        return $option;
    }

    /**
     * 根据用户的积分，获取，应该属于的用户组。
     * @param int $credits
     * @return int 所属用户组id
     */
    public function rank_by_credits($credits) {
        $where = "credits <=$credits";
        $group = $this->get_one($where, $field = 'id', 'credits desc');
        if ($group) {
            return $group['id'];
        }
        return FALSE;
    }

    /**
     * 将多个用户组的id，合并权限，保留最大权限。
     * @param array $groups_id 数组用户所属的用户组。 
     * @return array 返回处理后的用户组信息。
     */
    public function get_user_group($groups_id = '') {
        //可以考虑将用户的信息保存到缓存里面。
        if (!empty($groups_id)) {
            if (count($groups_id) > 1) {
                $master_id = array_shift($groups_id);
                $return_group = $this->get_by_id($master_id);

                $groups_id = join(',', $groups_id);
                $groups = $this->get_list('id in(' . $groups_id . ')');
                $is_arr = array('is_sign', 'is_anonymous', 'is_html', 'is_bbcode', 'is_smilies', 'is_media', 'is_hide', 'is_permission', 'is_site_visit', 'is_report', 'is_visit', 'is_read', 'is_post', 'is_reply', 'is_upload', 'is_download');
                $max_num_arr = array('max_post_num', 'max_upload_num');
                $min_num_arr = array('check', 'min_pertime');
                $merge_arr = array('allow_special');
                foreach ($groups as $group) {
                    foreach ($group as $key => $val) {
                        if (in_array($key, $is_arr)) {
                            if ($return_group[$key] == 1)
                                continue;
                            $return_group[$key] = max($return_group[$key], $val);
                        }elseif (in_array($key, $max_num_arr)) {
                            if ($return_group[$key] == 0 || $val == 0) {
                                $return_group[$key] = 0;
                            } else {
                                $return_group[$key] = max($return_group[$key], $val);
                            }
                        } elseif (in_array($key, $min_num_arr)) {
                            if ($return_group[$key] == 0)
                                continue;
                            $return_group[$key] = min($return_group[$key], $val);
                        }elseif (in_array($key, $merge_arr)) {
                            $return_group[$key] = $return_group[$key] . ',' . $val;
                        }
                    }
                }
                foreach ($merge_arr as $val) {
                    $return_group[$val] = array_unique(array_filter(explode(',', $return_group[$val])));
                }
                return $return_group;
            } else {
                return $this->get_by_id($groups_id[0]);
            }
        } else {
            return array();
        }
    }

    /**
     * 传入forum_id获取当前用户的在此版块下的管理权限。
     * @param type $forum_id
     */
    public function get_admin_permission($forum_id) {
        //need_cache
        if(isset($this->admin_permission[$forum_id])){
            return $this->admin_permission[$forum_id];
        }
        
        $current_groups = array_unique(array_merge((array) $this->user['group_id'], (array) $this->user['groups']));
        if (empty($current_groups)) {
            return null;
        }
        $this->load->model(array('groups_admin_model'));
        //获取此版块的版主列表
        $managers = $this->forums_model->get_manager_by_id($forum_id);
        if (in_array($this->user['username'], $managers)) {
            if (!in_array(Groups_model::$moderators_id, $current_groups)) {
                //为用户添加版主组
                $current_groups[] = Groups_model::$moderators_id;
            }
        } else {
            //既然当前用户不是此版块的版主则把其版主组去掉。
            $current_groups = array_filter($current_groups, create_function('$var', 'return $var != Groups_model::$moderators_id;'));
        }
        
        //当前的管理组权限合并
        //var_dump($current_groups);
        $admin_permission = array();
        if (!empty($current_groups)) {
            $current_groups = join(',', $current_groups);
            //获取用户组们的管理权限。
            $groups_admin = $this->groups_admin_model->get_list('group_id in (' . $current_groups . ')');
            $max_arr = array('allow_digest', 'allow_top');
            foreach ($groups_admin as $admin) {
                foreach ($admin as $key => $val) {
                    if($key == 'group_id'){
                        continue;
                    }
                    if (!isset($admin_permission[$key])) {
                        $admin_permission[$key] = $val;
                        continue;
                    }
                    if (in_array($key, $max_arr)) {
                        $admin_permission[$key] = max($admin_permission[$key], $val);
                    } else {
                        if ($admin_permission[$key] == 1)
                            continue;
                        $admin_permission[$key] = $val;
                    }
                }
            }
        }
        $this->admin_permission[$forum_id] = $admin_permission;
        return ($admin_permission);
    }

}

?>
