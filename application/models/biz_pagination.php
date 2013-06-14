<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理首页相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_pagination extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model(array(''));
    }

    public function init_page($base_url = '', $total_rows, $per_page = 20, $my_config = array()) {
        $config['base_url'] = !empty($base_url) ? $base_url : current_url();
        if(FALSE == strpos($config['base_url'], '?')){
            $config['base_url'] = rtrim($config['base_url'], '/') .'/?';
        }
        $config['total_rows'] = $total_rows;
        $config['per_page'] = !empty($per_page) ? $per_page : $this->config->item('per_num');

        //结构和样式
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<p class="pagination">';
        $config['full_tag_close'] = '</p>';
        $config['cur_tag_open'] = '<span>';
        $config['cur_tag_close'] = '</span>';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $config['first_link'] = '第一页';
        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';
        $config['last_link'] = '最后一页';
        $config['page_query_string']	= TRUE;
        $config['query_string_segment'] = 'per_page';
        if (!empty($my_config)) {
            $config = array_merge($config, $my_config);
        }
        $this->pagination->initialize($config);
        return $this->pagination;
    }

}

?>
