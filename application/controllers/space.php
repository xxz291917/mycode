<?php

class Space extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model', 'topics_posted_model', 'biz_pagination', 'credit_name_model'));
    }

    /**
     * 我的帖子。
     */
    public function my_topic() {
        $search = $this->input->get(null, TRUE);
        //生成分页字符串
        $total_num = $this->topics_model->get_topic_count();
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = $this->config->item('per_num');
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        //根据分页符读取列表
        $var['my_topic'] = $this->topics_model->get_topic_list($start, $per_num);
        $var['page'] = $page_str;
        $var['menu'] = 2;
        $this->view('space_topic_list', $var);
    }

    /**
     * 我的回复。
     */
    public function my_posted() {
        $search = $this->input->get(null, TRUE);
        //生成分页字符串
        $total_num = $this->topics_posted_model->get_count();
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 10;
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        //根据分页符读取列表
        $var['my_posted'] = $this->topics_posted_model->get_list($start, $per_num);
        $var['page'] = $page_str;
        $var['menu'] = 0;
        $this->view('space_topic_list', $var);
    }

    /**
     * 我的积分。
     */
    public function my_credit() {
        $arr = $this->uri->uri_to_assoc();
        $type = $arr['t'];
        if (!is_string($type)) {
            $type = "default";
        }
        $var['stars_rank'] = $this->users_model->get_star_html($this->user['group']['stars']);
        
        $search = $this->input->get(null, TRUE);
        $var['credit_name'] = $this->credit_name_model->get_credit_name();

        if ($type == "default") {
            $type_name = $var['credit_name'][0]['credit_x'];
        } else {
            $type_name = $arr['t'];
        }
       
        //生成分页字符串
        $total_num = $this->credit_log_model->get_credit_count($type_name);
        unset($search['submit'], $search['per_page']);
        $query_str = !empty($search) ? http_build_query($search, '', '&') : '';
        $base_url = current_url() . '?' . $query_str;
        $per_num = 10;
        $page_obj = $this->biz_pagination->init_page($base_url, $total_num, $per_num);
        $page_str = $page_obj->create_links();
        $start = max(0, ($page_obj->cur_page - 1) * $per_num);
        //根据分页符读取列表
        $var['my_credit'] = $this->credit_log_model->get_credit_list($type_name, $start, $per_num);
        $var['page'] = $page_str;
        $var['menu'] = 1;

        $var['type_name'] = $type_name;

        $this->view('space_credit_list', $var);
    }

}

?>