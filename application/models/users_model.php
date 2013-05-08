<?php
class Users_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='users';
    }

    function get_userinfo() {
        $user_id = '1';
        $query = $this->db->query("select u.* from {$this->table} u left join users_extra ex on ex.user_id=u.id where u.id=$user_id limit 0,1");
//        $this->db->select('id,email');
//        $query = $this->db->get('users',2,0);
//        $this->db->from('id');
//        var_dump($this->db->call_function('get_client_info'));
        $user = $query->row_array();
        if (!empty($user['group_id'])) {
            $query = $this->db->get_where('groups', array('id'=>$user['group_id']), 1, 0);
            $user_group = $query->row_array();
            $user['group'] = $user_group;
        }
        return $user;
    }
    
    public function exist_in_group($group_id=0) {
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
                if(in_array($key, array('posts','digests','today_posts','today_uploads','extcredits1','extcredits2','extcredits3','extcredits4','extcredits5','extcredits6','extcredits7','extcredits8'))){
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
