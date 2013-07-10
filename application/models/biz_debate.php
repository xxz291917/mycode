<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理特殊帖子辩论相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_debate extends CI_Model {

    static $special = 4;
    static $special_post = 'debate_post';
    static $special_reply = 'debate_reply';

    public function __construct() {
        parent::__construct();
        $this->load->model(array('debate_model', 'debate_posts_model'));
    }

    /**
     * 因为有些情况是需要返回为空的，所以用一个方法来获取这个数值。
     * @param type $topic_id
     * @return string
     */
    public function get_reply_view($topic_id) {
        $is_posted = $this->debate_posts_model->check_is_posted($topic_id);
        if (!$is_posted) {
            return self::$special_reply;
        } else {
            return '';
        }
    }
    
    /**
     * 因为有些情况是需要返回为空的，所以用一个方法来获取这个数值。
     * @param type $topic_id
     * @return string
     */
    public function get_edit_view() {
        return self::$special_reply;
    }

    public function post($tid, $post) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成debate表的数据
        $debate_data['topic_id'] = $tid;
        $debate_data['user_id'] = $this->user['id'];
        $debate_data['start_time'] = $this->time;
        $debate_data['end_time'] = my_strtotime($post['end_time']);
        $debate_data['umpire'] = $post['umpire'];
        $debate_data['affirm_point'] = html_escape($post['affirm_point']);
        $debate_data['negate_point'] = html_escape($post['negate_point']);
        $this->debate_model->insert($debate_data);
    }

    public function reply($tid, $post, $pid) {
        if (empty($post)) {
            return FALSE;
        }
        $tid = $post['topic_id'];
        if (isset($post['stand']) && in_array($post['stand'], array(0,1,2))) {
            //检测当前用户之前为回复过。
            if ($this->debate_posts_model->check_is_posted($tid)) {
                return false;
            }
            //更新debate表的数据，保存下非中立的观点。
            if ($post['stand'] > 0) {
                $stand_type = array(1 => 'affirm', 2 => 'negate');
                $type = $stand_type[$post['stand']];
                $debate = array(
                    $type . '_debaters' => ':1',
                    $type . '_replies' => ':1',
                );
                $this->debate_model->update_increment($debate, array('topic_id' => $tid));
            }
            //插入debate_posts
            $debate_posts = array(
                'topic_id' => $tid,
                'post_id' => $pid,
                'stand' => intval($post['stand']),
                'user_id' => $this->user['id'],
                'post_time' => $this->time,
                'voters' => 0,
            );
            $this->debate_posts_model->insert($debate_posts);
        }
        return TRUE;
    }

    public function check_post($type = 'post') {
        if ($type == 'post') {
            $this->form_validation->set_rules('affirm_point', '正方观点', 'trim|required|max_length[1500]');
            $this->form_validation->set_rules('negate_point', '反方观点', 'trim|required|max_length[1500]');
            $this->form_validation->set_rules('end_time', '结束日期', 'is_strtotime');
            $this->form_validation->set_rules('umpire', '裁判员', 'trim|required|callback_username_check');
        } elseif ($type == 'reply') {
            
        }
    }

    /**
     * 辩论帖展示初始化变量
     * @param type $topic
     * @param type $id
     * @return type
     */
    public function init_show($topic, $id) {
        $this->load->model('biz_pagination');
        $where = "topic_id = '$id' AND is_first = '1'";
        $first_post = $this->posts_model->get_one($where);
        $var['first_post'] = $this->posts_model->output_filter($first_post);
        //特殊主题需要的其他变量
        if (method_exists($this, 'append_first_post')) {
            $var['first_post'] = $this->append_first_post($var['first_post']);
        }
        
        if($topic['status'] !=5 && $this->time >= $var['first_post']['debate']['end_time']){
            $this->load->model(array('topics_model'));
            $this->topics_model->update(array('status'=>5),array('id'=>$id));
        }
        
        $count_sql = "SELECT count(*) num FROM posts p LEFT JOIN debate_posts d ON d.post_id=p.id  WHERE ";
        $list_sql = "SELECT p.*,d.stand,d.voters FROM posts p LEFT JOIN debate_posts d ON d.post_id=p.id  WHERE ";

        $stand = $this->input->get('stand', TRUE);
        $where = $stand !== false ? " d.stand = $stand " : '1';
        
        $author = $this->input->get('author', TRUE);
        $where .= !empty($author) ? " AND p.author_id = '$author' " : '';
        
        $where .= " AND p.topic_id = '$id' AND p.is_first != 1 AND (p.status =1 or p.status =4) ";

        $count_sql .= $where . "LIMIT 0,1";
        $query = $this->db->query($count_sql);
        $num = $query->row_array();
        $total_num = $num['num'];

        //生成分页字符串
        $base_url = page_url();
        $per_num = $this->config->item('per_num');
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();

        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $order_by = ' ORDER BY post_time';
        $list_sql .= $where . $order_by . " LIMIT $start,$per_num";

        $query = $this->db->query($list_sql);
        $posts = $query->result_array();
        if (!empty($posts)) {
            foreach ($posts as $key => &$value) {
                $value = $this->posts_model->output_filter($value);
            }
        }

        //获取需要的用户信息
        $uids = array($var['first_post']['author_id']);
        foreach ($posts as $post) {
            $uids[] = $post['author_id'];
        }
        $users = $this->users_model->get_userinfo_by_ids(array_unique($uids));

        //为前面获取的变量赋值到$var
        $var['posts'] = $posts;
        $var['users'] = $users;
        $var['page'] = $page_str;
        return $var;
    }

    /**
     * 辩论主题帖子添加所需的特殊变量。
     * @param type $first_post
     * @return array
     */
    public function append_first_post($first_post) {
        if (empty($first_post)) {
            return FALSE;
        }
        //得到辩论帖子基本信息以及双方观点数所占比例。
        $debate = $this->debate_model->get_by_id($first_post['topic_id']);
        $total_votes = $debate['affirm_votes'] + $debate['negate_votes'];
        if ($total_votes > 0) {
            $debate['affirm_percent'] = round($debate['affirm_votes'] / $total_votes, 2)*100;
            $debate['negate_percent'] = round($debate['negate_votes'] / $total_votes, 2)*100;
        } else {
            $debate['affirm_percent'] = 50;
            $debate['negate_percent'] = 50;
        }
        
        $topic_id = $first_post['topic_id'];
        
        //得到红方观点10人
        $affirm_users = $this->debate_posts_model->get_list(array('topic_id'=>$topic_id,'stand'=>1),'post_id,user_id','post_time', 0, 11);
        //得到蓝方观点10人
        $negate_users = $this->debate_posts_model->get_list(array('topic_id'=>$topic_id,'stand'=>2),'post_id,user_id','post_time', 0, 11);
        //得到红方和蓝方第一个人的观点
        $affirm_first = array_shift($affirm_users);
        $negate_first = array_shift($negate_users);
        !empty($affirm_first) && $debate['affirm_first'] = $this->posts_model->get_by_id($affirm_first['post_id']);
        !empty($negate_first) && $debate['negate_first'] = $this->posts_model->get_by_id($negate_first['post_id']);
        
        //得到观点人的用户名。
        $uids = array();
        foreach ((array)$affirm_users+(array)$negate_users as $key => $value) {
            $uids[] = $value['user_id'];
        }
        $uids = array_unique($uids);
        if(!empty($uids)){
            $users = $this->users_model->get_names_by_ids($uids);
            $users = $this->users_model->key_list($users);
            foreach ($affirm_users as $key => &$value) {
                $value['username'] = $users[$value['user_id']]['username'];
            }
            foreach ($negate_users as $key => &$value) {
                $value['username'] = $users[$value['user_id']]['username'];
            }
        }
        $debate['affirm_users'] = $affirm_users;
        $debate['negate_users'] = $negate_users;
        
        $first_post['debate'] = $debate;
        return $first_post;
    }

    /**
     * 添加辩论的喜欢数。
     * @param type $post_id
     * @param type $type
     * @return boolean
     */
    public function deal_support($post_id, $type) {
        if ($type == 'support') {
            return $this->debate_posts_model->update_increment(array('voters' => ':1'), array('post_id' => $post_id));
        } else {
            return FALSE;
        }
    }

    public function init_edit($topic_id, $post_id) {
        //添加上ask表里的附加字段
        $debate = $this->debate_model->get_by_id($topic_id, 'end_time,umpire,affirm_point,negate_point');
        $debate['end_time'] = date('Y-m-d', $debate['end_time']);
        return $debate;
    }

    public function init_reply_edit($topic_id, $post_id) {
        //添加上ask表里的附加字段
        $debate = array();
        $debate = $this->debate_posts_model->get_by_id($post_id);
        if(!empty($debate)){
            return array('stand'=>$debate['stand']);
        }
        return array();
    }

    public function edit($tid, $post, $pid) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成debate表的数据更新
        $debate_data['end_time'] = my_strtotime($post['end_time']);
        $debate_data['umpire'] = $post['umpire'];
        $debate_data['affirm_point'] = html_escape($post['affirm_point']);
        $debate_data['negate_point'] = html_escape($post['negate_point']);
        $this->debate_model->update($debate_data,array('topic_id' => $tid));
    }

    public function reply_edit($tid, $post, $pid) {
        //得到当前帖子的观点状态。
        $debate_posts = $this->debate_posts_model->get_by_id($pid);
        $stand_type = array(1 => 'affirm', 2 => 'negate');
        if (!empty($debate_posts) && isset($post['stand']) && $debate_posts['stand'] != $post['stand']) {
            if (!empty($debate_posts['stand'])) {
                $old_type = $stand_type[$debate_posts['stand']];
                $debate = array(
                    $old_type . '_debaters' => ':-1',
                    $old_type . '_replies' => ':-1',
                );
                $this->debate_model->update_increment($debate, array('topic_id' => $tid));
            }
            //更新debate表的数据，保存下非中立的观点。
            if ($post['stand'] > 0) {
                $stand_type = array(1 => 'affirm', 2 => 'negate');
                $type = $stand_type[$post['stand']];
                $debate = array(
                    $type . '_debaters' => ':1',
                    $type . '_replies' => ':1',
                );
                $this->debate_model->update_increment($debate, array('topic_id' => $tid));
            }
        }
        //更新debate_posts
        $debate_posts = array(
            'stand' => intval($post['stand']),
            'post_time' => $this->time,
        );
        $this->debate_posts_model->update($debate_posts, array('post_id' => $pid));
    }

}

?>
