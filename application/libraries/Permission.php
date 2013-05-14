<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission {
    static $ci;
    
    public function __construct() {
        self::$ci = & get_instance();
        self::$ci->load->model(array('forums_model','groups_admin_model','users_belong_model'));
    }
    
    public function check_post_num(){
        $is_perm = TRUE;
        if(self::$ci->user['group']['max_post_num']>0){
            $is_perm = self::$ci->user['group']['max_post_num']>self::$ci->user['today_posts'];
            if($is_perm && self::$ci->user['group']['min_pertime']>0){
                //获取最后发帖时间
                $is_perm = self::$ci->user['group']['min_pertime']<=(self::$ci->time-self::$ci->user['last_post_time']);
            }
        }
        return $is_perm;
    }
    
    public function check_upload_num(){
        $is_perm = TRUE;
        if(self::$ci->user['group']['max_upload_num']>0){
            $is_perm = self::$ci->user['group']['max_upload_num']>self::$ci->user['today_uploads'];
        }
        return $is_perm;
    }
    
    public function is_today($this_time){
        return date('Ymd', $this_time) == date('Ymd', self::$ci->time);
    }
    

}

?>