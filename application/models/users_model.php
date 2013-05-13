<?php

class Users_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'users';
        $this->load->model(array('groups_model', 'users_belong_model'));
    }

    /**
     * 根据cookie信息中的id，初始化用户信息。
     * @return type
     */
    function get_userinfo() {
        $user_id = '1';

        $u = 'id,email,username,credits,group_id,member_id,groups,icon,gender,signature,regdate,';
        $ex = 'posts,digests,today_posts,today_uploads,last_visit_time,last_login_ip,last_post_time,last_active_time,online_time,extcredits1,extcredits2,extcredits3,extcredits4,extcredits5,extcredits6,extcredits7,extcredits8';
        $sql = "SELECT $u $ex FROM {$this->table} u LEFT JOIN users_extra ex ON ex.user_id=u.id WHERE u.id=$user_id LIMIT 0,1";
        $query = $this->db->query($sql);
        $user = $query->row_array();

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
        $user['group'] = $this->groups_model->get_user_group($current_groups);
//        var_dump($user);die;
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

}

?>
