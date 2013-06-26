<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credits extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('credit_name_model'));
    }

    /**
     * 附件设置
     */
    public function index() {

        $credits = $this->credit_name_model->get_credits_list();
        $var['credits'] = $credits;
        $var['count'] = count($credits);
        $this->view('credits_config', $var);
    }

    /**
     * 更新用户的积分设置。
     */
    public function update() {
        $str_value = $this->input->post();
       // print_r($str_value);
        for ($i = 0; $i < 8; $i++) {
            $cx = "credit_x_" . $i;
            if (empty($str_value[$cx])) {
                $str_value[$cx] =0;
         
            } else {
                $str_value[$cx] = 1;
            
            }
            $vn = "view_name_" . $i;
            $ic = "icon" . $i;
            $un = "unit" . $i;
            $j = $i + 1;
            $file="extcredits".$j;
            $data = array(
                'status' => $str_value[$cx],
                'view_name' => $str_value[$vn],
                'icon' => $str_value[$ic],
                'unit' => $str_value[$un],
            );
            $this->credit_name_model->update_credit($data, $file);
         }
            echo "<script type=text/javascript>alert('设置成功');history.back();</script>";
            die;
      
    }

}

?>