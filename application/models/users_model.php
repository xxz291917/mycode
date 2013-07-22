<?php

class Users_model extends MY_Model {

    static $max_active = 1800;//用户在线最大离开时间。
    
    function __construct() {
        parent::__construct();
        $this->table = 'users';
        $this->load->model(array('groups_model', 'users_belong_model','users_medal_model'));
    }

    /**
     * 根据cookie信息中的id，初始化用户信息。
     * @return type
     */
    function get_userinfo() {
        /** 用户信息从cookie中获取。
         * array(4) {
          ["id"]=>
          string(2) "14"
          ["name"]=>
          string(9) "xxz291917"
          ["email"]=>
          string(17) "xxz291917@163.com"
          ["register_date"]=>
          string(10) "1372916951"
          }
         */
        
        $this->load->library('user_lib');
        $passport_user = $this->user_lib->getUser();
        //$userInfo = $this->user_lib->getUserInfo(14,1);
//        var_dump($user);
        $user_id = !empty($passport_user['id'])?$passport_user['id']:0;
        //否则从passport获取登录信息。
//        if(empty($user)){
//            $user_id = '1';
//            //更新最后登录时间。
//            $this->users_extra_model->update(array('last_login_time'=>$this->time), array('user_id'=>$this->user['id']));
//        }
        if(!empty($user_id)){//已经登录了，获取登录信息。
            if($this->enable_cache){
                $cache_key = "get_userinfo_$user_id";
                $user = $this->cache->get($cache_key);
                if(!empty($user)){
                    return $user;
                }
            }
            $user = $this->get_users_by_ids($user_id);
            if(empty($user)){
                $insert_data['id'] = $passport_user['id'];
                $insert_data['username'] = $passport_user['name'];
                $insert_data['email'] = !empty($passport_user['email'])?$passport_user['email']:'';
                $insert_data['regdate'] = $passport_user['register_date'];
                $insert_data['member_id'] = 10;
                $insert_data['status'] = 1;
                //var_dump($insert_data);die;
                $this->insert($insert_data);
//                $this->load->model('users_extra_model');
                $extra_data['user_id'] = $passport_user['id'];
                $this->users_extra_model->insert($extra_data);
                
                $user = $this->get_users_by_ids($user_id);
            }
//            var_dump($user);die;
            $current_groups = array(empty($user['group_id']) ? $user['member_id'] : $user['group_id']);
            //检测是否有过期的扩展组，更新。
            if (!empty($user['groups'])) {
                $new_groups = $this->refresh_blong($user_id);
                if ($new_groups !== FALSE) {
                    $user['groups'] = $new_groups;
                }
            }
            if (!empty($user['groups'])) {
                $user['groups'] = explode(',', $user['groups']);
                //根据扩展组信息，得出合并后的用户组。
                $current_groups = array_unique(array_merge($current_groups, $user['groups']));
            }
            $user['groups'] = $current_groups; //用户所属的用户组
            $user['group'] = $this->groups_model->get_user_group($current_groups);
            if ($this->enable_cache) {
                $this->cache->save($cache_key, $user, config_item('cache_time'));
            }
        }else{
            //为用户赋值用户组为游客。
            $user['id'] = 0;
            $user['username'] = '游客'; //所属管理组id
            $user['group_id'] = 0; //所属管理组id
            $current_groups[] = Groups_model::$tourist_id;
            $user['groups'] = $current_groups; //用户所属的用户组
            $user['group'] = $this->groups_model->get_user_group($current_groups);
        }
        return $user;
    }

    //检测是否有过期的扩展组，更新。
    private function refresh_blong($user_id) {
        $ex_groups = $this->users_belong_model->get_list("user_id = '$user_id'");
        if (is_array($ex_groups) && !empty($ex_groups)) {
            $remove = $remain = array();
            foreach ($ex_groups as $value) {
                if ($value['end_time'] != 0 && $value['end_time'] <= $this->time) {
                    $remove[] = $value['group_id'];
                } else {
                    $remain[] = $value['group_id'];
                }
            }
            if (!empty($remove)) {
                $remove = join(',', $remove);
                $this->users_belong_model->delete("user_id = '$user_id' AND group_id in($remove)");
                $remain = !empty($remain) ? join(',', $remain) : '';
                $this->update(array('groups' => $remain), "id = '$user_id'");
                return $remain;
            }
        }
        return FALSE;
    }

    public function exist_in_group($group_id = 0) {
        $sql = 'SELECT id FROM ' . $this->table . ' WHERE group_id = \'' . $group_id . '\' or member_id = \'' . $group_id . '\' AND status!=2 LIMIT 1';
        $query = $this->db->query($sql);
        $id = $query->row_array();
        return empty($id) ? TRUE : FALSE;
    }

    public function form_filter($datas, $type = 'en') {
        foreach ($datas as $key => $value) {
            if ($type == 'en') {
                switch ($key) {
                    case 'submit':
                        unset($datas[$key]);
                        break;
                    case 'groups':
                        $datas[$key] = join(',', $value);
                        break;
                    case 'extra_setting':
                        $datas[$key] = json_encode($value);
                        break;
                    default:
                        $datas[$key] = trim($value);
                        break;
                }
                if (in_array($key, array('posts', 'digests', 'today_posts', 'today_uploads', 'extcredits1', 'extcredits2', 'extcredits3', 'extcredits4', 'extcredits5', 'extcredits6', 'extcredits7', 'extcredits8'))) {
                    $datas[$key] = intval($value);
                }
            } else {
                switch ($key) {
                    case 'groups':
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
     * 根据id获取用户信息。
     * @param type $ids
     * @return boolean
     */
    public function get_users_by_ids($ids){
        $u = 'id,email,username,credits,group_id,member_id,groups,icon,gender,signature,regdate,';
        $ex = 'posts,digests,today_posts,today_uploads,last_login_time,last_login_ip,last_post_time,last_active_time,online_time,extcredits1,extcredits2,extcredits3,extcredits4,extcredits5,extcredits6,extcredits7,extcredits8';
        if(is_array($ids) && !empty($ids)){
            $ids = join (',', $ids);
            $where = "u.id in($ids)";
            $result_fun = 'result_array';
        }elseif(is_numeric($ids)){
            $where = "u.id = $ids ";
            $result_fun = 'row_array';
        }else{
            return FALSE;
        }
        $sql = "SELECT $u $ex FROM {$this->table} u LEFT JOIN users_extra ex ON ex.user_id=u.id WHERE $where";
        $query = $this->db->query($sql);
        return $query->$result_fun();
    }
    
    /**
     * 根据id获取用户信息，与get_users_by_ids不同的是添加了用户组信息。
     * @param type $ids
     * @return array
     */
    public function get_userinfo_by_ids($ids) {
        if(empty($ids)){
            return FALSE;
        }
        $users = $this->get_users_by_ids(array_unique($ids));
        $groups = $this->groups_model->get_key_groups();
        $medals = $this->get_medal_by_ids($ids);
        $need_users = array();
        foreach ($users as $key => $value) {
            $group_id = empty($value['group_id']) ? $value['member_id'] : $value['group_id'];
            $need_users[$value['id']] = $value;
            $need_users[$value['id']]['group'] = $groups[$group_id];
            $online = $this->time - $value['last_active_time'] < self::$max_active;
            $need_users[$value['id']]['online'] = $online;
            $need_users[$value['id']]['online_time'] = $online?time_span(0,$value['online_time']):0;
            $need_users[$value['id']]['stars_rank'] = $this->get_star_html($groups[$group_id]['stars']);
            $need_users[$value['id']]['medals'] = isset($medals[$value['id']])?$medals[$value['id']]:array();
        }
        return $need_users;
    }
    
    /**
     * 二进制
     * @param type $stars
     */
    public function get_star_html($stars,$scale=2) {
        $sun  = pow($scale, 2);
        $moon = pow($scale, 1);
        $star = pow($scale, 0);
        $sun_num  = floor($stars/$sun);
        $moon_num = floor($stars%$sun/$moon);
        $star_num = floor($stars%$sun%$moon/$star);
        
        $sun_str = '<i class="icoSun"></i>';
        $moon_str = '<i class="icoMoon"></i>';
        $star_str = '<i class="icoStar"></i>';
        
        $html = '<span class="myRank">';
        $html .= str_repeat($sun_str,  $sun_num);
        $html .= str_repeat($moon_str, $moon_num);
        $html .= str_repeat($star_str, $star_num);
        return $html;
    }


    public function get_user_by_name($name){
        $where = "username = '$name' AND status=1 LIMIT 0,1";
        $result_fun = 'row_array';
        $sql = "SELECT id FROM {$this->table} WHERE $where";
        $query = $this->db->query($sql);
        return $query->$result_fun();
    }
    
    public function get_user_by_names($names) {
        if(is_array($names)){
            $names = "'".join("','", array_unique($names))."'";
        }
        $where = "username in( $names ) AND status=1";
        return $this->get_list($where);
    }

    public function get_medal_by_ids($ids){
        if(is_array($ids) && !empty($ids)){
            $ids = join (',', $ids);
            $where = "user_id in($ids)";
        }elseif(is_numeric($ids)){
            $where = "user_id = $ids";
        }else{
            return FALSE;
        }
        //删除过期的勋章。
        $this->users_medal_model->delete($where." AND expired_time < {$this->time}");
        
        //构造sql语句。
        $sql = "SELECT u.*,m.name,m.image FROM users_medal u LEFT JOIN medals m ON m.id=u.medal_id WHERE u.$where AND (m.expired_time=0 OR m.expired_time > {$this->time}) AND m.is_open =1 ORDER BY m.display_order";
        $query = $this->db->query($sql);
        $medals = $query->result_array();
        $return = array();
        if(is_array($medals)){
            foreach ($medals as $medal) {
                $return[$medal['user_id']][] = $medal;
            }
        }
        return $return;
    }
    
   
    public function get_names_by_ids($ids){
        if(is_array($ids) && !empty($ids)){
            $ids = join (',', $ids);
            $where = "id in($ids)";
            $result_fun = 'result_array';
        }elseif(is_numeric($ids)){
            $where = "id = $ids ";
            $result_fun = 'row_array';
        }else{
            return FALSE;
        }
        $sql = "SELECT id,username FROM {$this->table} WHERE $where";
        $query = $this->db->query($sql);
        return $query->$result_fun();
    }
    
}

?>
