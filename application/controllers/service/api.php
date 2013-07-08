<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class api extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array(
            'biz_permission'));
    }

    public function message($msg, $succ = 0, $info = '') {
        $vars['msg'] = $msg;
        $vars['succ'] = $succ;
        $vars['info'] = $info;
        echo json_encode($vars);
        die;
    }
    
    /**
     * 为其他应用提供的接口，获取某个用户，最近的那条帖子。
      a) 提供的参数为：passport_user_id，num（例如passport_user_id=15&num=5）
      b) 需要的数据格式：json数组
      c) 需要的数组元素： title（帖子的标题），url（帖子的url），dateline（帖子的发布时间或最新更新时间）
     * @param type $user_id
     */
    public function last_topics() {
        $user_id = intval($this->input->post('passport_user_id'));
        //$user_id = intval($this->input->get('passport_user_id'));
        $num = intval($this->input->post('num'));
        if (empty($user_id)) {
            $this->message('参数错误！',-1);
        }
        if($num == 0){
            $num = 20;
        }else if($num>100){
            $num = 100;
        }
        $this->load->model('topics_model');
        $data = $this->topics_model->get_list("author_id = '$user_id' AND status in (1,4,5) ",'id,subject,post_time','post_time DESC',0,$num);
        $info = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $info[$key]['title'] = $value['subject'];
                $info[$key]['url'] = base_url('index.php/topic/show'.$value['id']);
                $info[$key]['dateline'] = $value['post_time'];
            }
        }
        $this->message('获取帖子列表成功！',1,$info);
    }

}

?>
