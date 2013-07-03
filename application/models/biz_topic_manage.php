<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Biz_topic_manage extends CI_Model {

    public $action;
    private $manage_arr = array('allow_top' => '置顶',
        'allow_digest' => '推荐精华',
        'is_highlight' => '高亮',
        'is_bump' => '升降',
        'is_move' => '移动',
        'is_editcategory' => '分类',
        'is_ban' => '屏蔽',
        'is_close' => '关闭',
        'is_del' => '删除',
//        'is_copy' => '复制',
//        'is_merge' => '合并',
//        'is_split' => '切分',
        );
    public static $status = array('ban' => 3, 'close' => 5, 'del' => 2);

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model','posts_model'));
        //$this->load->helper('date');
    }

    /**
     * 从私有属性$manage_arr中分离权限关键字和说明文字。
     *  'digest' => '推荐精华',
        'highlight' => '高亮',
        'bump' => '升降',
        'move' => '移动',
     * @return type
     */
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
    private function get_full_action($action) {
        foreach ($this->manage_arr as $key => $value) {
            list($null, $tmp_action) = explode('_', $key);
            if ($tmp_action == $action) {
                return $key;
            }
        }
    }
    /**
     * 过滤$manage_arr中没有权限的元素。
     * @param type $forum_id
     * @return type
     */
    public function get_permission_manage($forum_id) {
        //获取管理权限
        $admin_permission = $this->groups_model->get_admin_permission($forum_id);
        //获取页面中展示的可操作的链接
        $manage_arr = $this->get_manage_arr();
        foreach ($manage_arr as $key => $val) {
            if (empty($admin_permission[$key])) {
                unset($manage_arr[$key]);
            }
        }
        return $manage_arr;
    }
    
    /**
     * fixme
     * 检测主题管理的权限，可以检测多个主题，只要一个主题所属板块没有权限就返回false。
     * @param type $topic_ids
     * @param type $action
     * @param type $post
     * @return boolean
     */
    public function check_manager_permission($topic_ids, $action, $post = '') {
        !is_array($topic_ids) && $topic_ids = array($topic_ids);
        empty($post) && $post = $this->input->post(null,true);
        $topics = $this->topics_model->get_list('id in(' . join(',', $topic_ids) . ')');
        $permission = array();
        foreach ($topics as $topic) {
            //此主题是我的发布的，不做检查，直接通过。
            if($topic['author_id'] == $this->user['id']){
                continue;
            }
            if (!isset($permission[$topic['forum_id']])) {
                $admin_permission = $this->groups_model->get_admin_permission($topic['forum_id']);
                //var_dump($admin_permission);
                $permission_action = $this->get_full_action($action);
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
        empty($post) && $post = $this->input->post(null,true);
        
        //置顶、高亮、推荐精华
        if (in_array($action, array('top', 'highlight', 'digest'))) {
            //需要更新topics表
            if (is_array($post[$action])) {
                $post[$action] = join(',', $post[$action]);
            }
            $topics_update = array($action => $post[$action]);
            //var_dump($topics_update);die;
            if ($action == 'digest') {//推荐精华是一起的，所以，加精华，顺便推荐。
                $topics_update['recommend'] = empty($post[$action])?0:1;
            }
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
            if(!empty($post[$action])){
               //需要更新topics_endtime表
                $this->topics_endtime_model->delete('topic_id in(' . join(',', $topic_ids) . ') AND action=\''.$action.'\'');
                if(!empty($post['end_time'])){
                    $post['end_time']+=3600*24-1;
                }
                foreach ($topic_ids as $topic_id) {
                    $topics_endtime[] = array(
                        'topic_id' => $topic_id,
                        'action' => $action,
                        'end_time' => $post['end_time']
                    );
                }
                $this->topics_endtime_model->insert_batch($topics_endtime); 
            }
        }elseif($action == 'bump'){
            //更新当前帖子的最后回复时间。
            $last_post_time = $post[$action]==1?$this->time:strtotime('-1 year');
            $topics_update = array('last_post_time' => $last_post_time);
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
        }elseif(in_array($action, array('ban','close','del'))){
            $tmp_stasus = $post[$action]==1?self::$status[$action]:1;
            $topics_update = array('status' => $tmp_stasus);
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
        }elseif($action == 'pass'){//审核通过，目前只用于后台的管理操作。
            $tmp_stasus = 1;//审核通过，状态直接变为1.
            $topics_update = array('status' => $tmp_stasus);
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
        }elseif($action == 'move'){
            //更新当前帖子版块id。
            $topics_update = array('forum_id' => $post[$action]);
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
        }elseif($action == 'editcategory'){
            //更新当前帖子版块id。
            $topics_update = array('category_id' => $post[$action]);
            $this->topics_model->update($topics_update, 'id in(' . join(',', $topic_ids) . ')');
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
        
//'copy' => '复制',
//'merge' => '合并',
//'split' => '切分',);
    }
    
    /**
     * 管理posts的操作
     * @param type $posts_ids
     * @param type $action
     * @param type $post
     */
    public function manage_post($posts_ids, $action, $post = '') {
            $this->load->model(array('posts_log_model','posts_top_model'));
            if(in_array($action, array('ban','del'))){
                $tmp_stasus = $post[$action]==1?self::$status[$action]:1;
                $topics_update = array('status' => $tmp_stasus);
                $this->posts_model->update($topics_update, 'id in(' . join(',', $posts_ids) . ')');
            }elseif($action == 'pass'){//审核通过，目前只用于后台的管理操作。
                $tmp_stasus = 1;//审核通过，状态直接变为1.
                $topics_update = array('status' => $tmp_stasus);
                $this->posts_model->update($topics_update, 'id in(' . join(',', $posts_ids) . ')');
            }
            //添加管理日志
            foreach ($posts_ids as $topic_id) {
                $topics_log[] = array(
                    'post_id' => $topic_id,
                    'user_id' => $this->user['id'],
                    'username' => $this->user['username'],
                    'time' => $this->time,
                    'action' => $action,
                    'data' => json_encode($post),
                    'reason' => $post['reason']
                );
            }
            //topics_log_model
            $this->posts_log_model->insert_batch($topics_log);
    }
    

}
