<?php
class Users_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_userinfo() {
        $user_id = '1';
        $query = $this->db->query("select u.* from users u left join users_extra ex on ex.user_id=u.id where u.id=$user_id limit 0,1");
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
//        var_dump($user);die;
        return $user;
    }

}

?>
