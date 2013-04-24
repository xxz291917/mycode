<?php
class Users_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    
    function get_userinfo(){
        $user_id = '1';
        $query = $this->db->get('users');
        $this->db->from('id');
        var_dump($query->result_array());die;
        
    }
    
}
?>
