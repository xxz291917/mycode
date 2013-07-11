<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理特殊帖子投票相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_poll extends CI_Model {

    static $special = 3;
    static $special_post = 'poll_post';

    function __construct() {
        parent::__construct();
        $this->load->model(array('poll_model', 'poll_options_model', 'poll_voter_model'));
    }

    public function init_show($topic, $id) {
        $where = "topic_id = '$id' AND is_first = '1'";
        $first_post = $this->posts_model->get_one($where);
        $var['first_post'] = $this->posts_model->output_filter($first_post);
        //特殊主题需要的其他变量
        if (method_exists($this, 'append_first_post')) {
            $var['first_post'] = $this->append_first_post($var['first_post']);
        }

        $this->load->model('biz_pagination');
        //获取本主题下的回复和分页
        $where = " is_first != 1 AND topic_id = '$id' AND status =1";

        $author = $this->input->get('author', TRUE);
        $where .=!empty($author) ? " AND author_id = '$author' " : '';

        $per_num = $this->config->item('per_num');
        $total_num = $this->posts_model->get_count($where);
        //生成分页字符串
        $base_url = current_url();
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        $posts = $this->posts_model->get_posts_list($where, '*', 'post_time', $start, $per_num);
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

    public function post($tid, $post) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成poll表的数据
        $poll_data['topic_id'] = $tid;
        $poll_data['is_overt'] = empty($post['is_overt']) ? 1 : 0;
        $poll_data['is_multiple'] = $post['max_choices'] > 1 ? 1 : 0;
        $poll_data['is_visible'] = empty($post['is_visible']) ? 1 : 0;
        $poll_data['max_choices'] = intval($post['max_choices']);
        $poll_data['expire_time'] = $this->time + (intval($post['expire_time']) * 3600 * 24);
        $poll_data['preview'] = join('[|]', array_slice(html_escape($post['poll_option']), 0, 2));
        $poll_data['voters'] = 0;
        $this->poll_model->insert($poll_data);
        //完成poll_options表的数据
        $options_data = array();
        foreach ($post['poll_option'] as $k => $v) {
            $options_data[$k]['topic_id'] = $tid;
            $options_data[$k]['display_order'] = $k;
            $options_data[$k]['option'] = html_escape($v);
        }
        $this->poll_options_model->insert_batch($options_data);
    }

    public function check_post($type = 'post') {
        if ($type == 'post') {
            $_POST['poll_option'] = array_filter($_POST['poll_option']);
            $num = count($_POST['poll_option']);
            $_CI = &get_instance();
            if($num<=0){
                $_CI->message('至少需要一个有内容的选项。');
            }elseif($num>50){
                $_CI->message('最多支持50个选项。');
            }
            
            $this->form_validation->set_rules('poll_option[]', '选项', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('max_choices', '最多可选项', 'trim|greater_than[0]|less_than['.$num.']');
            $this->form_validation->set_rules('expire_time', '投票有效天数', 'trim|is_natural|greater_than[0]');
            $this->form_validation->set_rules('is_visible', '', 'regex_match[/[01]/]');
            $this->form_validation->set_rules('is_overt', '', 'regex_match[/[01]/]');

            $this->form_validation->set_message('less_than', '%s不能多于选项数。');
        }
    }

    public function append_first_post($first_post) {
        if (empty($first_post)) {
            return FALSE;
        }
        //添加上poll表里的投票附加字段
        $poll = $this->poll_model->get_by_id($first_post['topic_id']);
        $first_post = $first_post + $poll;

        //初始化投票选项，放入option索引里
        $options = $this->poll_options_model->get_list(array('topic_id' => $first_post['topic_id']));
        $options = empty($options) ? array() : $options;
        $first_post['options'] = $options;

        //获取当前用户是否投过票，是否允许再投票。
        $mypoll = $this->poll_voter_model->get_one(array('topic_id' => $first_post['topic_id'], 'user_id' => $this->user['id']));
        $first_post['is_vote'] = empty($mypoll) ? TRUE : false;

        //根据当前用户获取投票数。（有编辑权利的用户和已经投票有权利查看投票数。）
        if (empty($mypoll)) {
            $this->load->model('biz_permission');
            $is_edit = $this->biz_permission->check_manage($first_post['topic_id'], 'edit');
        }
        if (!empty($mypoll) || $is_edit) {//有编辑权利
            $first_post['percent'] = true;
            $sum_vote = 0;
            foreach ($options as $key => $option) {
                $sum_vote += $option['votes'];
            }
            foreach ($first_post['options'] as $key => &$option) {
                $option['percent'] = !empty($sum_vote) ? round($option['votes'] / $sum_vote, 2) * 100 : 0;
            }
        }
        return $first_post;
    }

    public function post_append(&$post) {
        if (empty($post)) {
            return FALSE;
        }
        //添加上poll表里的投票附加字段
        $poll = $this->poll_model->get_by_id($post['id']);
        $post = $post + $poll;
        //初始化投票选项，放入option索引里
        $options = $this->poll_options_model->get_list(array('topic_id' => $post['id']));
        $options = empty($options) ? array() : $options;
        $post['options'] = $options;
    }

    public function init_edit($topic_id, $post_id) {
        //添加上poll表里的附加字段
        $poll = $this->poll_model->get_by_id($topic_id);
        $poll['expire_time'] = ceil(($poll['expire_time'] - $this->time) / (3600 * 24));

        $options = $this->poll_options_model->get_list(array('topic_id' => $topic_id), '`option`,display_order');
        $poll['poll_option'] = array();
        foreach ($options as $option) {
            $poll['poll_option'][] = $option['option'];
        }
        return $poll;
    }

    public function edit($tid, $post, $pid) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成poll表的数据
        $poll_data['is_overt'] = !empty($post['is_overt']) ? 1 : 0;
        $poll_data['is_multiple'] = $post['max_choices'] > 1 ? 1 : 0;
        $poll_data['is_visible'] = !empty($post['is_visible']) ? 1 : 0;
        $poll_data['max_choices'] = intval($post['max_choices']);
        $poll_data['expire_time'] = $this->time + (intval($post['expire_time']) * 3600 * 24);
        $poll_data['preview'] = join('[|]', array_slice(html_escape($post['poll_option']), 0, 2));
        $this->poll_model->update($poll_data, array('topic_id' => $tid));
        //完成poll_options表的数据
        $poll_options = $this->poll_options_model->get_list(array('topic_id' => $tid));
        $post['poll_option'] = array_filter($post['poll_option']);
        if(count($post['poll_option']) < count($poll_options)){
            $_CI = &get_instance();
            $_CI->message('编辑投票时，选项不能少于原来的项。');
        }
        foreach ($post['poll_option'] as $k => $v) {
            $new_options = array();
            $new_options['display_order'] = $k;
            $new_options['option'] = html_escape($v);
            if (isset($poll_options[$k])) {
                $this->poll_options_model->update($new_options, array('id' => $poll_options[$k]['id']));
            } else {
                $new_options['topic_id'] = $tid;
                $this->poll_options_model->insert($new_options);
            }
        }
    }

}

?>
