<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理特殊帖子问答相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_Ask extends CI_Model {

    static $special = 2;
    static $special_post = 'ask_post';
    static $ask_credit_action = 'ask_action'; //发表问题积分动作关键字
    public $ask_credit_type = 'extcredits2'; //发表问题所有扣减的积分项

    public function __construct() {
        parent::__construct();
        $this->load->model(array('ask_model', 'ask_posts_model', 'users_extra_model'));
    }

    public function post($tid, $post) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成ask表的数据
        $ask_data['topic_id'] = $tid;
        $ask_data['price'] = $post['price'];
        $ask_data['forum_id'] = $post['forum_id'];
        $ask_data['category_id'] = $post['category'];
        $is_insert = $this->ask_model->insert($ask_data);
        //从用户身上扣减分数
        $credits = array($this->ask_credit_type => 0 - $post['price']);
        $is_update_credit = $this->users_extra_model->update_credits($credits, $this->user['id'], self::$ask_credit_action);
        if ($is_insert && $is_update_credit) {
            return TRUE;
        } else {
            log_message('error', '发表问题，扣减积分出错。');
            return false;
        }
    }

    public function check_post($type = 'post') {
//        $this->form_validation->set_rules('highlight[0]', '高亮颜色', 'required|color');
//        $this->form_validation->set_rules('highlight[1]', '粗体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[2]', '斜体', 'regex_match[/[01]/]');
//        $this->form_validation->set_rules('highlight[3]', '下划线', 'regex_match[/[01]/]');
//        $this->form_validation->set_message('regex_match', '%s参数不正确。');
//        $this->form_validation->set_message('color', '%s不是正确的颜色值。');
    }

    public function reply($tid, $post, $pid) {
        if (empty($post) || empty($pid) || empty($tid)) {
            return FALSE;
        }
        
        $topics_data['replies'] = ':1';
        $this->topics_model->update_increment($topics_data, array('id' => $tid));
        
        //插入ask_posts，为以后的回答投票做准备。
        $ask_posts = array(
            'topic_id' => $tid,
            'post_id' => $pid,
            'user_id' => $this->user['id'],
            'supports' => 0,
            'opposes' => 0,
        );
        return $this->ask_posts_model->insert($ask_posts);
    }

    public function init_post() {
        $this->load->model('credit_name_model');
        //得到对应的积分名字
        $var['view_name'] = $this->credit_name_model->get_view_name($this->ask_credit_type);
        //得到当前用户的积分数
        $var['price'] = $this->user[$this->ask_credit_type];
        return $var;
    }

    public function init_show($topic, $id) {
        $this->load->model('biz_pagination');
        $where = "topic_id = '$id' AND is_first = '1'";
        $first_post = $this->posts_model->get_one($where);
        $var['first_post'] = $this->posts_model->output_filter($first_post);
        //特殊主题需要的其他变量
        if (method_exists($this, 'append_first_post')) {
            $var['first_post'] = $this->append_first_post($var['first_post']);
        }

        $count_sql = "SELECT count(*) num FROM posts p LEFT JOIN ask_posts a ON a.post_id=p.id  WHERE ";
        $list_sql = "SELECT p.*,a.supports,a.opposes FROM posts p LEFT JOIN ask_posts a ON a.post_id=p.id  WHERE ";

        $where = " p.topic_id = '$id' AND p.is_first != 1 AND p.status =1 ";
        $count_sql .= $where . " LIMIT 0,1";
        $query = $this->db->query($count_sql);
        $num = $query->row_array();
        $total_num = $num['num'];

        //生成分页字符串
        $base_url = current_url();
        $per_num = $this->config->item('per_num');
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();

        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $order = $this->input->get('order', TRUE);
        $order_by = $order == 'supports' ? ' ORDER BY supports DESC' : ' ORDER BY post_time ';
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

    public function append_first_post($first_post) {
        if (empty($first_post)) {
            return FALSE;
        }
        //添加上ask表里的附加字段
        $ask = $this->ask_model->get_by_id($first_post['topic_id']);
        $first_post = $first_post + $ask;
        $related_posts = $this->topics_model->related_posts($first_post['topic_id']);
        $first_post['related_posts'] = $related_posts;
        return $first_post;
    }

    
    public function deal_support($post_id,$type){
        $field = $type=='support'?'supports':'opposes';
        $update_data[$field] = ':1';
        return $this->ask_posts_model->update_increment($update_data, array('id'=>$post['topic_id']));
    }
    
}

?>
