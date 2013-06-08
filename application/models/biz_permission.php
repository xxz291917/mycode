<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Biz_permission extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->model(array('forums_model', 'groups_admin_model', 'users_belong_model'));
    }

    public function check_post_num() {
        $is_perm = TRUE;
        if ($this->user['group']['max_post_num'] > 0) {
            $is_perm = $this->user['group']['max_post_num'] > $this->user['today_posts'];
            if ($is_perm && $this->user['group']['min_pertime'] > 0) {
                //获取最后发帖时间
                $is_perm = $this->user['group']['min_pertime'] <= ($this->time - $this->user['last_post_time']);
            }
        }
        return $is_perm;
    }

    public function check_upload_num() {
        $is_perm = TRUE;
        if ($this->user['group']['max_upload_num'] > 0) {
            $is_perm = $this->user['group']['max_upload_num'] > $this->user['today_uploads'];
        }
        return $is_perm;
    }

    public function is_today($this_time) {
        return date('Ymd', $this_time) == date('Ymd', $this->time);
    }

}

?>
