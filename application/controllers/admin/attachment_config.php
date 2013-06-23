<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attachment_config extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('config_model'));
    }

    /**
     * 附件设置
     */
    public function index() {

        $config = $this->config_model->get_list();
        $value = array();
        if (!empty($config['value'])) {
            $value = explode('/', $config['value']);
        }
        $var['config'] = $value;
        $var['count'] = count($value)-1;
        $this->view('attachment_config', $var);
    }

    /**
     * 更新用户的附件配置。
     */
    public function update() {
        //格式化ids并检测，两种方式获取ids，get或者post数组。        
        $str_value = $this->input->post('str_value');
        if(preg_replace("/([a-zA-Z]|d)+/", "()", $str_value)){
            $str_value=str_replace('undefined,undefined/','',$str_value);
            $this->config_model->update_config($str_value);           
        }
          $message = $this->echo_ajax(1);
          echo $message;
          die;
    }

}
?>