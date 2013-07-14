<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class import extends MY_Controller {

    private $dzdb;

    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'users_model',
            'users_extra_model',
            'users_medal_model',
            'topics_model',
            'posts_model',
            'poll_model',
            'poll_options_model',
            'poll_voter_model',
            'attachments_model',
            'credit_name_model',
            'ask_model',
            'ask_posts_model',
            'debate_model',
            'debate_posts_model',
            'groups_model',
            'groups_admin_model',
        ));
        $dz_config['hostname'] = "localhost";
        $dz_config['username'] = "root";
        $dz_config['password'] = "";
        $dz_config['database'] = "discuz";
        $dz_config['dbdriver'] = "mysql";
        $dz_config['dbprefix'] = "pre_";
        $dz_config['pconnect'] = FALSE;
        $dz_config['db_debug'] = TRUE;
        $dz_config['cache_on'] = FALSE;
        $dz_config['cachedir'] = "";
        $dz_config['char_set'] = "utf8";
        $dz_config['dbcollat'] = "utf8_general_ci";
        $this->dir = FCPATH . APPPATH . 'sql';
        $this->pre = 'pre_';
        $this->dzdb = $this->load->database($dz_config, TRUE);
        var_dump($this->dzdb);die;
    }

    public function users($maxid = 0) {
        $data = $this->get_data('users');
        if (!empty($data['id'])) {
            $id = $data['id'];
        } else {
            $id = 0;
        }
        if($id>=$maxid){
            echo '333333';die;
        }
        $endid = $id + 100;
        $usertable = 'common_member';
        $counttable = 'common_member_count';
        $sql = "SELECT * FROM $this->pre$usertable u left join $this->pre$counttable c ON c.uid=u.uid WHERE u.uid BETWEEN $id AND $endid limit 0,100";
        $query = $this->dzdb->query($sql); 
        $rows = $query->result_array();
        echo 123;die;
        var_dump($rows);die;
        
        if (!empty($rows)) {
            $table1 = $this->get_need($usertable);
            $table2 = $this->get_need($counttable);
            $batch1 = array();
            $batch2 = array();
            $field1 = $this->get_need($usertable . '_to');
            $field2 = $this->get_need($counttable . '_to');
            foreach ($rows as $key => $row) {
                
                foreach ($row as $k => $v) {
                    if (!empty($field1[$k])) {
                        $batch1[$key][$field1[$k]] = $v;
                    } elseif (!empty($field2[$k])) {
                        $batch2[$key][$field2[$k]] = $v;
                    }
                }
            }
            $r1 = $this->users_model->insert_batch($batch1);
            $r2 = $this->users_extra_model->insert_batch($batch2);
            if ($r1 && $r2) {
                $this->set_data('user', array('id' => $endid));
                if($endid>=$maxid){
                    $redirect = current_url();
                    $this->message('处理成功:'.$endid, 1, $redirect); 
                }else{
                    echo '处理完成:'.$endid;die;
                }
            }else{
                echo '处理失败:'.$endid;die;
            }
        }
    }

    public function get_need($table) {
        $common_member = 'users';
        $common_member_to = array(
            'uid' => 'id',
            'email' => 'email',
            'username' => 'username',
            'adminid' => 'group_id',
            'groupid' => 'member_id',
            'groupexpiry' => 'id',
            'regdate' => 'regdate',
            'credits' => 'credits',
            'status' => 'status',
        );
        $common_member_count = 'users_extra';
        $common_member_count_to = array(
            'uid' => 'user_id',
            'extcredits1' => 'extcredits1',
            'extcredits2' => 'extcredits2',
            'extcredits3' => 'extcredits3',
            'extcredits4' => 'extcredits4',
            'extcredits5' => 'extcredits5',
            'extcredits6' => 'extcredits6',
            'extcredits7' => 'extcredits7',
            'extcredits8' => 'extcredits8',
            'posts' => 'posts',
            'digestposts' => 'digests',
            'todayattachs' => 'today_uploads',
        );
        return $$table;
    }

    public function get_data($action) {
        $filename = $this->dir . $action;
        if (file_exists($filename)) {
            $data = file_get_contents($filename);
            return json_decode($data, TRUE);
        } else {
            return FALSE;
        }
    }

    public function set_data($action, $data) {
        $filename = $this->dir . $action;
        file_put_contents($filename, json_encode($data));
    }

}

?>
