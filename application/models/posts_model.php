<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends MY_Model {

    public $smileys = array();

    public function __construct() {
        parent::__construct();
        $this->table = 'posts';
        $this->id = 'id';
        $this->load->model('smiley_model');
    }

    public function get_list($where = '', $field = '*', $orderby = '', $limit = 0, $length = 20) {
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
        if (empty($this->smileys)) {
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

}

?>
