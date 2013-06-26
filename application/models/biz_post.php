<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理普通的发帖回帖业务。
 *
 * @author		xiaxuezhi
 */
class Biz_post extends CI_Model {

    static $specials = array(1=>'biz_post', 2 => 'biz_ask', 3 => 'biz_poll', 4 => 'biz_debate');

    public function __construct() {
        parent::__construct();
        $this->load->model('posts_model','topics_model');
    }

    public function init_show($topic,$id) {
            $this->load->model('biz_pagination');
            //获取本主题下的回复和分页
            $author = $this->input->get('author', TRUE);
            $where = !empty($author) ? " author_id = '$author' " : '1';
            $where .= " AND topic_id = '$id' AND status =1";
            $per_num = $this->config->item('per_num');
            $total_num = $this->posts_model->get_count($where);
            //生成分页字符串
            $base_url = current_url();
            $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
            $page_str = $page_obj->create_links();
            $start = max(0, ($page_obj->cur_page - 1) * $per_num);
            $posts = $this->posts_model->get_posts_list($where, '*', 'post_time', $start, $per_num);
            //获取需要的用户信息
            $uids = array();
            foreach ($posts as $post) {
                $uids[] = $post['author_id'];
                if($post['is_first']==1){
                    $var['related_posts'] = $this->topics_model->related_posts($id, 10, 'user');
                }
            }
            $users = $this->users_model->get_userinfo_by_ids(array_unique($uids));
            
            //为前面获取的变量赋值到$var
            $var['posts'] = $posts;
            $var['users'] = $users;
            $var['page'] = $page_str;
            
            return $var;
    }
    
    /**
     * 接受参数，完成发帖或者回复的数据库操作。
     * @param type $post
     * @param type $type
     * @return boolean
     */
    public function post($post, $type = 'post') {
        $post = $this->safe_filter($post); //安全过滤，不包括html转义，也就是说在一定条件下可以使用html代码
        $forum_id = intval($post['forum_id']);
        $special = intval($post['special']);
        
        //特殊贴钩子（处理业务之前调用）
        if ($special != 1) {
            $special_class = self::$specials[$special];
            if(!empty($special_class)){
                $this->load->model($special_class);
                $method = 'pre_'.$type;
                if(method_exists($this->$special_class, $method)){
                    $this->$special_class->$method($post);
                }
            }
        }
        
        //根据html权限检测是否需要过滤html
        $is_html = $this->biz_permission->get_is('html', $forum_id);
        
        if ('post' == $type) {
            //插入topics表
            $tags = $this->topics_model->format_tags($post['tags']);
            $topics_data['forum_id'] = $forum_id;
            $topics_data['category_id'] = intval($post['category']);
            $topics_data['author'] = $this->user['username'];
            $topics_data['author_id'] = $this->user['id'];
            $topics_data['post_time'] = $this->time;
            $topics_data['subject'] = html_escape($post['subject']);
            $topics_data['tags'] = $tags;
            $topics_data['special'] = $special;
            $topics_data['replies'] = 0;
            $topics_data['status'] = $this->biz_permission->get_check($forum_id) > 0 ? 4 : 1;
            $this->topics_model->insert($topics_data);
            $tid = $this->db->insert_id();
            if (empty($tid)) {
                $this->message('发帖topics失败。');
            }
            $this->tags_model->insert_tags($tags, $tid);
        } elseif ('reply' == $type) {
            $tid = $post['topic_id'];
            //更新topics表
            $topics_data['replies'] = ':1';
            $topics_data['last_author'] = $this->user['username'];
            $topics_data['last_author_id'] = $this->user['id'];
            $topics_data['last_post_time'] = $this->time;
            $this->topics_model->update_increment($topics_data, array('id' => $tid));
            //更新topics_posted表，如果回复的帖子不是我发起的，则记录我参与过的帖子。
            if ($this->user['id'] != $post['topic_author_id']) {
                $is_posted = $this->topics_posted_model->check_is_posted($tid);
                if (!$is_posted) {
                    $this->topics_posted_model->insert(array('user_id' => $this->user['id'], 'topic_id' => $tid, 'time'=>$this->time));
                }
            }
            
            if (!empty($post['post_id'])) {
                $quote_post = $this->posts_model->get_by_id($post['post_id']);
                $quote_content = $this->get_quote_content($quote_post);
            }
            
        }
        
        //插入posts表
        $posts_data['topic_id'] = $tid;
        $posts_data['forum_id'] = $forum_id;
        $posts_data['author'] = $this->user['username'];
        $posts_data['author_id'] = $this->user['id'];
        $posts_data['author_ip'] = $this->ip;
        $posts_data['post_time'] = $this->time;
        $posts_data['subject'] = html_escape($post['subject']);
        $posts_data['content'] = (!empty($quote_content) ? $quote_content : '') . ($is_html ? $post['content'] : html_escape($post['content']));
        $posts_data['attachment'] = 0;
        $posts_data['is_first'] = 'post' == $type ? 1 : 0;
        $posts_data['is_bbcode'] = $this->biz_permission->get_is('bbcode', $forum_id);
        $posts_data['is_smilies'] = $this->biz_permission->get_is('smilies', $forum_id);
        $posts_data['is_media'] = $this->biz_permission->get_is('media', $forum_id);
        $posts_data['is_html'] = $this->biz_permission->get_is('html', $forum_id);
        $posts_data['is_anonymous'] = $this->biz_permission->get_is('anonymous', $forum_id);
        $posts_data['is_hide'] = $this->biz_permission->get_is('hide', $forum_id);
        $posts_data['is_sign'] = $this->biz_permission->get_is('sign', $forum_id);
        $posts_data['position'] = $this->posts_model->get_max_position($tid)+1;
        $posts_data['status'] = $this->biz_permission->get_check($forum_id) == 2 ? 4 : 1; //回复帖子也审核
        $this->posts_model->insert($posts_data);
        $pid = $this->db->insert_id();
        if (empty($pid)) {
            $this->message('发帖posts失败。');
        }
        
        //特殊贴钩子（完成基本业务后调用）
        if(!empty($special_class)){
            $method = $type;
            if(method_exists($this->$special_class, $method)){
                $this->$special_class->$method($tid,$post,$pid);
            }
        }
        
        //更新用户上传的附件（图片和文件）
        if (!empty($post['attachments'])) {
            $this->load->model(array('attachments_unused_model', 'attachments_model'));
            $aids = join(',', $post['attachments']);
            $attachments = $this->attachments_unused_model->get_list("id in($aids)");
            foreach ($attachments as &$attachment) {
                $attachment['topic_id'] = $tid;
                $attachment['post_id'] = $pid;
                $attachment['is_remote'] = 0;
                $attachment['downloads'] = 0;
            }
            if (!$this->attachments_model->insert_batch($attachments)) {
                $this->message('插入附件表失败。');
            } else {
                $this->attachments_unused_model->delete("id in($aids)");
            }
        }
        
        //删除可能存在的草稿箱
        $draft_where = array('user_id'=>$this->user['id'], 'special'=>$special);
        if($type == 'post'){
            $draft_where['forum_id'] = $forum_id;
        }else{
            $draft_where['topic_id'] = $tid;
        }
        $this->load->model('drafts_model');
        $this->drafts_model->delete($draft_where);
        
        //更新用户积分
        $credit = $this->forums_model->get_credit($forum_id, $type);
        $update_credit = $this->users_extra_model->update_credits($credit, $this->user['id'], $type);
        if (!$update_credit) {
            $this->message('更新用户积分失败。');
        }
        
        //更新用户user_extra信息
        $this->users_extra_model->post_increment();
        
        //更新用户forums_statistics信息
        $this->forums_statistics_model->post_increment($forum_id, $tid, $type);
        
        return TRUE;
    }

    /**
     * 递归循环处理html，使其成为安全的代码。主要是过滤可执行的代码。并不过滤html。
     * @param type $str
     * @return type
     */
    public function safe_filter($str) {
        if (is_array($str)) {
            foreach ($str as $k => $val) {
                $str[$k] = $this->safe_filter($val);
            }
            return $str;
        } elseif (is_string($str)) {
            $farr = array(
                "/<\/?(script|i?frame|style|object)[^>]*>/ies",
                "/<[^>]*on[a-zA-Z]+\s*=[^>]*>/ies", //过滤javascript的on事件
            );
            $str = preg_replace($farr, "htmlspecialchars('\\0')", $str);
            return $str;
        } else {
            return $str;
        }
    }

    public function check_post($type = 'post', $special = 1) {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'content',
                'label' => '帖子内容',
                'rules' => 'trim|required'
            )
        );
        if ('post' == $type) {
            $config[] = array(
                'field' => 'subject',
                'label' => '标题',
                'rules' => 'trim|required|min_length[5]|max_length[80]'
            );
        }
        
        //校验特殊主题
        if ($special != 1) {
            $special_class = self::$specials[$special];
            $this->load->model($special_class);
            $this->$special_class->check_post($type);
        }

        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    /**
     * 得到某个版块的编辑器权限，返回数组。
     * @param int $forum_id 版块id
     * @return array
     */
    public function get_is($forum_id) {
        $return = array();
        $is_arr = array('is_bbcode', 'is_smilies', 'is_html', 'is_hide', 'is_media', 'is_anonymous', 'is_sign');
        foreach ($is_arr as $key => $is) {
            $return[$is] = $this->biz_permission->get_is($is, $forum_id);
        }
        return $return;
    }
    
    public function get_quote_content($post){
        $maxlen = 20;
        if(empty($post)){
            return '';
        }
        $post['content'] = preg_replace('/<blockquote.+<\/blockquote>/i', '', $post['content']);
        if (function_exists('mb_strlen')) {
            $suffix = (mb_strlen($post['content']) > $maxlen) ? '……' : '';
        }else{
            $suffix = (strlen($post['content']) > $maxlen) ? '……' : '';
        }
        return '<blockquote class="blockquote">'."{$post['author']} 发表于 " . date('Y-m-d H:i:s', $post['post_time']) . "<br/>" . utf8_substr($post['content'], 0, 20).$suffix.'</blockquote>';
    }

}

?>
