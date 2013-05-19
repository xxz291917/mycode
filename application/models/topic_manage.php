<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Topic_manage extends CI_Model {

    public $action;
    private $manage_arr = array('allow_top' => '置顶',
        'allow_digest' => '推荐精华',
        'is_highlight' => '高亮',
        'is_bump' => '提升',
        'is_move' => '移动',
        'is_editcategory' => '分类',
        'is_ban' => '屏蔽',
        'is_close' => '关闭',
        'is_del' => '删除',
        'is_copy' => '复制',
        'is_merge' => '合并',
        'is_split' => '切分',);

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model'));
        $this->load->helper('date');
    }

    public function get_manage_arr() {
        $manage_arr = $this->manage_arr;
        $return_arr = array();
        foreach ($manage_arr as $key => $val) {
            list($null, $action) = explode('_', $key);
            $return_arr[$key] = array($action, $val);
        }
        return $return_arr;
    }

    /**
     * 传入一个action,返回在数据库中的字段值。比如：top=>allow_top
     * @param type $action
     * @return type
     */
    private function get_permission_action($action) {
        foreach ($this->manage_arr as $key => $value) {
            list($null, $tmp_action) = explode('_', $key);
            if ($tmp_action == $action) {
                return $key;
            }
        }
    }

    /**
     * 检测主题管理的权限，可以检测多个主题，只要一个主题所属板块没有权限就返回false。
     * @param type $topic_ids
     * @param type $action
     * @param type $post
     * @return boolean
     */
    public function check_manager_permission($topic_ids, $action, $post = '') {
        empty($post) && $post = $this->input->post();
        $topics = $this->topics_model->get_list('id in(' . join(',', $topic_ids) . ')');
        $permission = array();
        foreach ($topics as $topic) {
            if (!isset($permission[$topic['forum_id']])) {
                $admin_permission = $this->groups_model->get_admin_permission($topic['forum_id']);
                //var_dump($admin_permission);
                $permission_action = $this->get_permission_action($action);
                if (in_array($permission_action, array('allow_digest', 'allow_top'))) {
                    //echo $admin_permission[$permission_action];
                    $return = $admin_permission[$permission_action] >= $post[$action];
                } else {
                    $return = $admin_permission[$permission_action];
                }
                $permission[$topic['forum_id']] = $return;
                if (!$return) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    /**
     * 完成主题管理的数据库修改。
     * 一般要完成主题表、主题管理日志表、有效期表的更新。
     * @param type $topic_ids
     * @param type $action
     * @param type $post
     */
    public function manage($topic_ids, $action, $post = '') {
        $this->load->model(array('topics_log_model','topics_endtime_model'));
        empty($post) && $post = $this->input->post();
        
        //置顶、高亮、推荐精华
        if (in_array($action, array('top', 'hightlight', 'digest'))) {
            //需要更新topics表
            if (is_array($post[$action])) {
                $post[$action] = join(',', $post[$action]);
            }
            $topics_update = array($action => $post[$action]);
            if ($action == 'digest') {//推荐精华是一起的，所以，加精华，顺便推荐。
                $topics_update['recommend'] = 1;
            }
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
            //需要更新topics_endtime表
            $this->topics_endtime_model->delete('topic_id in(' . join(',', $topic_ids) . ') AND action=\''.$action.'\'');
            foreach ($topic_ids as $topic_id) {
                $topics_endtime[] = array(
                    'topic_id' => $topic_id,
                    'action' => $action,
                    'end_time' => $post['end_time']
                );
            }
            $this->topics_endtime_model->insert_batch($topics_endtime);
        }elseif(1){
            
            
        }
        //添加管理日志
        foreach ($topic_ids as $topic_id) {
            $topics_log[] = array(
                'topic_id' => $topic_id,
                'user_id' => $this->user['id'],
                'username' => $this->user['username'],
                'time' => $this->time,
                'action' => $action,
                'data' => json_encode($post),
                'reason' => $post['reason']
            );
        }
        //topics_log_model
        $this->topics_log_model->insert_batch($topics_log);
//'top' => '置顶',
//'digest' => '推荐精华',
//'highlight' => '高亮',
//'bump' => '提升',
//'move' => '移动',
//'editcategory' => '分类',
//'ban' => '屏蔽',
//'close' => '关闭',
//'del' => '删除',
//'copy' => '复制',
//'merge' => '合并',
//'split' => '切分',);
    }

}
