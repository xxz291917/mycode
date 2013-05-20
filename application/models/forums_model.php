<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forums_model extends MY_Model {

    public $forums;

    function __construct() {
        parent::__construct();
        $this->table = 'forums';
    }

    function initialize() {
        return TRUE;
    }

    public function get_format_forums($forums=array()) {
        if(empty($forums)){
            $forums = $this->get_forums();
        }
        return $this->format($forums);
    }
    
    public static function create_options($forums,$check_arr = array()) {
        $option = '';
        $current_type = '';
        foreach ($forums as $key => $forum) {
            empty($current_type) && $current_type = $forum['type'];
            if ($forum['type'] == 'group') {
                if(!empty($option)){
                    $option .= '</optgroup>';
                }
                $option .= '<optgroup label="' . $forum['name'] . '">';
            } else {
                $prefix = $forum['type'] == 'forum'?'|- ':'&nbsp;&nbsp;|- ';
                $checked = in_array($forum['id'], $check_arr) ? ' selected="selected"' : '';
                $option .= '<option value="' . $forum['id'] . '"' . $checked . '>' . $prefix.$forum['name'] . '</option>';
            }
            if(!empty($forum['sub'])){
                $option .= self::create_options($forum['sub'],$check_arr);
            }
        }
        if($current_type == 'group'){
            $option .= '</optgroup>';
        }
        return $option;
    }
    
    public function get_forums() {
        if (empty($this->forums)) {
            $this->db->order_by("display_order");
            $query = $this->db->get($this->table);
            $this->forums = $query->result_array();
        }
        return $this->forums;
    }
    
    public function get_sub_forums($id){
        return $this->get_list(array('parent_id'=>$id),'*', '', 0, 100);
    }

    public function get_key_forums($key = 'id') {
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
            $tmp['manager'] = $manager;
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
                        $insert_data['create_user'] = $this->user['username'];
                        $insert_data['create_user_id'] = $this->user['id'];
                        $insert_data['create_time'] = time();
                        if ($this->insert($insert_data)) {
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

    public function form_filter($forums, $type = 'en') {
        foreach ($forums as $key => $value) {
            if ($type == 'en') {
                switch ($key) {
                    case 'submit':
                        unset($forums[$key]);
                        break;
                    case 'manager':
                        $forums[$key] = $this->format_manager($value);
                        break;
                    case 'display_order':
                        $forums[$key] = intval($value);
                        break;
                    case 'allow_special':
                    case 'allow_visit':
                    case 'allow_read':
                    case 'allow_post':
                    case 'allow_reply':
                    case 'allow_upload':
                    case 'allow_download':
                        $forums[$key] = join(',', $value);
                        break;
                    case 'credit_setting':
                        $forums[$key] = json_encode($value);
                        break;
                    default:
                        $forums[$key] = trim($value);
                        break;
                }
            } else {
                switch ($key) {
                    case 'allow_special':
                    case 'allow_visit':
                    case 'allow_read':
                    case 'allow_post':
                    case 'allow_reply':
                    case 'allow_upload':
                    case 'allow_download':
                        //权限存取的规则都是，以逗号分隔的用户组id。
                        $forums[$key] = explode(',', $value);
                        break;
                    case 'credit_setting':
                        $forums[$key] = json_decode($value, TRUE);
                        break;
                }
            }
        }
        return $forums;
    }

    /**
     * 传入版块id和动作,检测当前用户有没有相应的权限
     * @param int $id 版块id
     * @param string $action 相应的动作比如（'report','visit','read','post','reply','upload','download'）
     * @return boolean
     */
    public function check_permission( $action,$id='') {
        $actions = array('report', 'visit', 'read', 'post', 'reply', 'upload', 'download');
        if (in_array($action, $actions)) {
            $group_key = 'is_' . $action;
            if (isset($this->user['group'][$group_key]) && $this->user['group'][$group_key] == 1) {
                if ('report' == $action) {
                    return TRUE;
                }
                if(!empty($id)){
                    $forum = $this->get_by_id($id);
                    $forum_key = 'allow_' . $action;
                    $permission = $forum[$forum_key];
                    if (empty($permission)) {
                        return TRUE;
                    } else {
                        $permission = explode(',', $permission);
                        $tmp = array_intersect($this->user['groups'], $permission);
                        if (!empty($tmp)) {
                            return TRUE;
                        }
                    }
                }else{
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * 用户组的审核机制和版块自己的审核机制，取较严厉者。
     * @param type $id
     * @return type
     */
    public function get_check($id) {
        $forum = $this->get_by_id($id);
        $forum_check = $forum['check'];
        $group_check = $this->user['group']['check'];
        return max($forum_check, $group_check);
    }

    public function get_is($type,$id='') {
        $types = array('bbcode', 'smilies', 'media', 'html','anonymous','hide','sign','permission');
        if (in_array($type, $types)) {
            $group_key = 'is_' . $type;
            if ($this->user['group'][$group_key] == 1) {
                if(!empty($id)){
                    $forum = $this->get_by_id($id);
                    $forum_key = 'is_' . $type;
                    if (empty($forum[$forum_key])) {
                        return 1;
                    } else {
                        return $forum[$forum_key];
                    }
                }else{
                    return 1;
                }
            }
        }
        return 0;
    }

    /**
     * 用户组的审核机制和版块自己的审核机制，取较严厉者。
     * post,reply,digest,postattach ,getattach ,daylogin ,search
     * 
     * @param type $id
     * @return type
     */
    public function get_credit($id, $rule = '') {
        //有些积分规则是需要判断条件的，比如登录。
        if ($rule == 'daylogin') {
            if (date('Ymd', $this->user['last_visit_time']) == date('Ymd', $this->time)) {
                return FALSE;
            }
        }
        $this->load->model('credit_rule_model');
        $rules = $this->credit_rule_model->get_one("action = '$rule'");
        if (!empty($rules)) {
            $forum = $this->get_by_id($id);
            $credit_setting = $forum['credit_setting'];
            $credit_setting = json_decode($credit_setting, TRUE);
            if (!empty($credit_setting[$rule])) {
                $rules = array_merge($rules, $credit_setting[$rule]);
            }
        }
        return $rules;
    }
    
    public function get_manager_by_id($id){
        $forum = $this->get_by_id($id);
        return array_filter(explode(',', $forum['manager']));
    }
    
}

?>
