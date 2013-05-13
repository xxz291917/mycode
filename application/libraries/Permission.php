<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission {
    static $app;
    
    public function __construct() {
        self::$app = & get_instance();
        self::$app->load->model(array('groups_model','groups_admin_model','users_belong_model'));
    }

    public function get_permission($groups=array()) {
        if(!empty($groups)){
            $groups = join(',', $groups);
            $permissions = self::$app->groups_model->get_list($groups);
            var_dump($permissions);die;
            Groups_model::$moderators_id;
            echo 'xxx';
            $groups;
        }else{
            return FALSE;
        }
    }

}

?>