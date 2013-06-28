<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends MY_Model {

    public $smileys = null;
    public $attachments = null;

    public function __construct() {
        parent::__construct();
        $this->table = 'posts';
        $this->load->model(array('smiley_model', 'attachments_model'));
    }

    /**
     * 严格按照post_time排序。 
     * @param type $where
     * @param type $field
     * @param type $orderby
     * @param type $limit
     * @param type $length
     * @return type
     */
    public function get_posts_list($where = '', $field = '*', $orderby = '', $limit = 0, $length = 20) {
        $result = parent::get_list($where, $field, $orderby, $limit, $length);
        if (!empty($result)) {
            foreach ($result as $key => &$value) {
                $value = $this->output_filter($value);
            }
        }
        return $result;
    }

    public function output_filter($value) {
        if (empty($value))
            return FALSE;
        //过滤attachments
        $value = $this->attachments2html($value);
        //过滤is_bbcode
        //过滤is_smilies
        if ($value['is_smilies']) {
            $value['content'] = $this->smiley2html($value['content']);
        }
        //过滤is_html
        
        //过滤is_hide
        if($value['is_first'] && $value['is_hide']){
            $value = $this->hide2html($value);
        }
        
        return $value;
    }

    public function input_filter($html) {
        //过滤is_bbcode
        //过滤is_smilies
        //过滤is_html
        //过滤is_hide
    }

    public function html2smiley($str) {
        if (empty($this->smileys)) {
            $this->smileys = $this->smiley_model->get_smiley();
        }
        $str = preg_replace('/<img[^>]+smileId=([\"\']?)(\d+)(\1)[^>]*>/ie', "\$this->smileys[\\2]['code']", $str);
        return $str;
    }
    function smiley2html($str) {
        if (!isset($this->smileys)) {
            $this->smileys = $this->smiley_model->get_smiley();
        }
        if (!empty($this->smileys)) {
            foreach ($this->smileys as $id => $val) {
                $search[] = $val['code'];
                $replace[] = '<img src="' . $val['url'] . '" border="2" smileId="' . $id . '" />';
            }
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

    public function attachments2html($value) {
        //[attach][attachimg]
        $key = $value['topic_id'].'_'.$value['id'];
        if(empty($this->attachments[$key])){
            $attachments = $this->attachments_model->get_list(array('topic_id' => $value['topic_id'], 'post_id' => $value['id']));
            $attachments = $this->key_list($attachments, 'id');
            $this->attachments[$key] = $attachments;
        }
        $attachments = $this->attachments[$key];
        $value['content'] = preg_replace("/\[(attach|attachimg)\](\d+)\[\/\\1\]/ies", "\$this->get_html_for_attach('\\2','\\1',\$attachments)", $value['content']);
        return $value;
    }
    
    private function get_html_for_attach($aid, $type = 'attach',$attachments) {
        //cache
        if (!empty($attachments[$aid])) {
            $attachment = $attachments[$aid];
            $html = '';
            if ('attach' == $type) {
                $href = base_url("index.php/attachment/download/$aid");
                $title = $attachment['description'];
                $title = empty($title)?$attachment['filename']:$title;
                $html = '<a href="' . $href . '" title="' . $title . '">' . $title . '</a>';
            } elseif ('attachimg' == $type) {
                $src = base_url($attachment['path']);
                $title = $attachment['description'];
                $html = '<img src="' . $src . '" title="' . $title . '" alt="' . $title . '" />';
            }
            return $html;
        } else {
            return '';
        }
    }
    
    public function hide2html($value) {
        $this->load->model(array('biz_permission','topics_posted_model'));
        //检测当前用户是否是帖子作者，是否是版主或管理员。（是否有编辑帖子的权限）
        $is_edit = $this->biz_permission->check_manage($value['topic_id'], 'edit');
        if($is_edit || $this->topics_posted_model->check_is_posted($value['topic_id'])){//显示隐藏内容
            $value['content'] = preg_replace("/\[hide\](.+)\[\/hide\]/is", '<div class="showHideCot"><strong>隐藏内容</strong>\1</div>', $value['content']);
        }else{//需要回复才能显示隐藏内容。
            $value['content'] = preg_replace("/\[hide\](.+)\[\/hide\]/is", '<div class="showHide">'.$this->user['username'].'，如果您要查看本帖隐藏内容请<a href="#">回复</a></div>', $value['content']);
        }
        return $value;
    }
    
    public function get_max_position($topic_id) {
        $post = $this->get_one(array('topic_id' => $topic_id), 'position', 'position DESC');
        return empty($post['position']) ? 0 : $post['position'];
    }
    
    public function get_last_post_id($topic_id){
        $post = $this->get_one(array('topic_id' => $topic_id), 'id', 'post_time DESC');
        return empty($post['id']) ? 0 : $post['id'];
    }

}

?>
