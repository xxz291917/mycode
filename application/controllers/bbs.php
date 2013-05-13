<?php

class Bbs extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        var_dump($this->user);
        die;
    }

    public function post() {
        $post = $this->input->post(null, TRUE);
        if ($post && $this->check_rules()) {
            //表单验证
            // $this->message('验证通过！');
                
            //插入topics表
            //插入posts表
            //更新用户积分
            //更新用户extra信息
            //完成
            
        } else {
            $this->view('post');
        }
    }

    private function check_rules() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'subject',
                'label' => '标题',
                'rules' => 'trim|required|min_length[5]|max_length[12]'
            ),
            array(
                'field' => 'content',
                'label' => '帖子内容',
                'rules' => 'trim|required'
            ),
        );
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    public function comments($e = "My Real Title") {
        $data['title'] = $e;
        $data['heading'] = "My Real Heading";
        $this->load->view('bbsview', $data);
    }

//    public function _output($output) {
//        //echo 333;
//        echo $output;
//    }
}

?>