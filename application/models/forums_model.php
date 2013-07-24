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
    
    public static function create_options($forums='',$check_arr = array()) {
        $option = '';
        $current_type = '';
        foreach ($forums as $key => $forum) {
            //redirect后，过滤。
            if($forum['redirect']!=0){
                continue;
            }
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
    
    public function get_forums($closed = 1) {
        if($this->enable_cache){
            $cache_key = "get_forums".$closed;
            $this->forums = $this->cache->get($cache_key);
        }
        if (empty($this->forums)) {
            $where = $closed ? 1 : array('status' => 1);
            $this->forums = $this->get_list($where,'*','display_order');
            if ($this->enable_cache) {
                $this->cache->save($cache_key, $this->forums, config_item('cache_time'));
            }
        }
        return $this->forums;
    }
    
    /**
     * 获取传入id的子版块，只一层。
     * @param type $id
     * @return type
     */
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
                        $insert_data['create_time'] = $this->time;
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
     * 全局积分规则和板块积分规则的合并，版块覆盖全局。
     * 规则如下：post,reply,digest,postattach ,getattach ,daylogin ,search
     * 
     * @param type $id
     * @return array 版块在此rule下的加减积分数组
     */
    public function get_credit($id, $rule = '') {
        //有些积分规则是需要判断条件的，比如登录。
        if ($rule == 'daylogin') {
            //判断是否是今天第一次登录。
            if (date('Ymd', $this->user['last_login_time']) == date('Ymd', $this->time)) {
                return false;
            }
        }
        $this->load->model('credit_rule_model');
        $rules = $this->credit_rule_model->get_one("action = '$rule'");
        if (!empty($rules)) {
            //取出版块信息
            $forum = $this->get_by_id($id);
            $credit_setting = $forum['credit_setting'];
            $credit_setting = json_decode($credit_setting, TRUE);
            if (!empty($credit_setting[$rule])) {
                $rules = array_merge($rules, $credit_setting[$rule]);
            }
        }
        return $rules;
    }
    
    /**
     * 取出版块下设置的版主id。
     * @param type $id
     * @return type
     */
    public function get_manager_by_id($id){
        $forum = $this->get_by_id($id);
        return array_filter(explode(',', $forum['manager']));
    }
    
    public function get_nav_forums($id){
        $forums = $this->get_key_forums();
        $nav[$id] = $forums[$id]['name'];
        for($i=1;$i<=3;$i++){
            $parent_id = $forums[$id]['parent_id'];
            $id = $parent_id;
            if($id == 0){
                break;
            }else{
                $nav[$id] = $forums[$id]['name'];
            }
        }
        return array_reverse($nav,TRUE);
//        var_dump($nav);die;
    }
    
    public function get_nav_str($forum_id){
        //获取导航面包屑，论坛>综合交流>活动专区>现代程序员的工作环境
        $nav = array();
        $nav_forums = $this->get_nav_forums($forum_id);
        foreach ($nav_forums as $key => $val) {
            $nav[] = array($val, base_url('index.php/forum/show/'.$key));
        }
        return $nav;
    }
    
    /**
     * 根据id得到版块的信息，包括统计信息。
     * @param type $forum_id
     */
    public function get_info_by_id($forum_id) {
        $forum = $this->get_by_id($forum_id);
        $forums_statistics = $this->forums_statistics_model->get_by_id($forum_id);
        return array_merge($forum, $forums_statistics);
    }
    
    /**
     * 处理redirect的版块的信息，除了名称，层级，描述外。其余的都替换成redirect的信息。
     * @param type $forums
     */
    public function handle_redirect($forums){
        $remain = array('id','parent_id','name','description','icon','display_order','create_user','create_user_id','create_time');
        foreach($forums as &$forum){
            if(!empty($forum['redirect'])){
                $redirect_forum = $forums[$forum['redirect']];
                foreach($forum as $key=>$val){
                    if(!in_array($key, $remain)){
                        $forum[$key] = $redirect_forum[$key];
                    }
                }
            }
        }
        return $forums;
    }
    
    /**
     * 获取传入id的层次结构的版块信息。
     * @param type $forum_id
     * @param type $forums
     * @return type
     */
    public function get_sub_forums_by_id($forum_id, $forums) {
        $sub_forums = array();
        if (empty($forum_id)) {
            return $forums;
        }
        foreach ($forums as $key => $forum) {
            if ($forum['id'] == $forum_id) {
                return $forum['sub'];
            } elseif (!empty($forum['sub'])) {
                $sub_forums =  $this->get_sub_forums_by_id($forum_id, $forum['sub']);
                if(!empty($sub_forums)){
                    return $sub_forums;
                }
            }
        }
    }
    
    /**
     * 获取传入id的所有子id，循环递归多层。
     * @param type $forum_id
     * @param type $forums
     * @return type
     */
    public function get_all_ids($forums) {
        static $ids = array();
        if(empty($forums)){
            return '';
        }
        foreach ($forums as $key => $forum) {
            $ids[] = $forum['id'];
            if (!empty($forum['sub'])) {
                $this->get_all_ids($forum['sub']);
            }
        }
        return $ids;
    }
    
}

?>
