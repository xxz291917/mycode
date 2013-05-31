<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends MY_Model {

    public $smileys = null;
    public $attachments = null;

    public function __construct() {
        parent::__construct();
        $this->table = 'posts';
        $this->id = 'id';
        $this->load->model(array('smiley_model','attachments_model'));
    }

    public function get_posts_list($where = '', $field = '*', $orderby = '', $limit = 0, $length = 20) {
        $result = parent::get_list($where, $field, $orderby, $limit, $length);
        if(!empty($result)){
            foreach ($result as $key => &$value) {
                $value = $this->output_filter($value);
            }
        }
        return $result;
    }

    public function output_filter($value) {
        if(empty($value)) return FALSE;
        //过滤attachments
        $value = $this->attachments2html($value);
        //过滤is_bbcode
        //过滤is_smilies
        if($value['is_smilies']){
            $value['content'] = $this->smiley2html($value['content']);
        }
        //过滤is_html
        //过滤is_hide
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
        //此处加一个cache
        $attachments = $this->attachments_model->get_list(array('topic_id'=>$value['topic_id'],'post_id'=>$value['id']));
        $this->attachments = $this->key_list($attachments,'id');
        //[attach][attachimg]
        $value['content'] = preg_replace("/\[(attach|attachimg)\](\d+)\[\/\\1\]/ies", "\$this->get_html_for_attach('\\2','\\1')", $value['content']);
        return $value;
    }
    private function get_html_for_attach($aid,$type='attach') {
        if(!empty($this->attachments[$aid])){
            $attachment = $this->attachments[$aid];
            $html = '';
            if('attach'==$type){
                $href = base_url("index.php/attachment/download/$aid");
                $title = $attachment['description'];
                $html = '<a href="'.$href.'" title="'.$title.'">'.$title.'</a>';
            }elseif('attachimg'==$type){
                $src = base_url($attachment['path']);
                $title = $attachment['description'];
                $html = '<img src="'.$src.'" title="'.$title.'" alt="'.$title.'" />';
            }
            return $html;
        }else{
            return '';
        }
    }

}

?>
