<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medals extends Admin_Controller {

    public $type_names = array(0=>'手动颁发',1=>'自动颁发',2=>'申请颁发');
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('medals_model','medals_log_model','users_medal_model'));
    }
    
    public function index() {
         if ($this->input->post('submit')) {
            $setting = array('site_name','manager_email','icp','statistic_code','closed');
            $seo = array(
                'seo_index_title','seo_index_keywords','seo_index_description',
                'seo_topic_title','seo_topic_keywords','seo_topic_description',
                'seo_post_title','seo_post_keywords','seo_post_description');
            $this_arr = $$type;
            $settings = $this->input->post();
            foreach ($settings as $name => $value) {
                if(!in_array($name, $this_arr)){
                    unset($settings[$name]);
                }else{
                    if($name!='statistic_code'){
                        $settings[$name] = html_escape($value);
                    }
                }
            }
            if ($this->config_model->update_value($settings)) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $medals = $this->medals_model->get_all();
            $var['type_names'] = $this->type_names;
            $var['medals'] = $medals;
            $this->view('medals', $var);
        }
    }

    public function edit($type='setting') {
        if ($this->input->post('submit')) {
            $setting = array('site_name','manager_email','icp','statistic_code','closed');
            $seo = array(
                'seo_index_title','seo_index_keywords','seo_index_description',
                'seo_topic_title','seo_topic_keywords','seo_topic_description',
                'seo_post_title','seo_post_keywords','seo_post_description');
            $this_arr = $$type;
            $settings = $this->input->post();
            foreach ($settings as $name => $value) {
                if(!in_array($name, $this_arr)){
                    unset($settings[$name]);
                }else{
                    if($name!='statistic_code'){
                        $settings[$name] = html_escape($value);
                    }
                }
            }
            if ($this->config_model->update_value($settings)) {
                $this->message('修改成功！');
            } else {
                $this->message('修改失败！');
            }
        } else {
            $setting = 'site_setting';
            $seo = 'site_seo';
            $this_view = $$type;
            $settings = $this->config_model->get_config();
            $var['data'] = $settings;
            $this->view($this_view, $var);
        }
    }

    public function delete() {
        
    }

    private function search_where($post='') {
    }
    
}

?>