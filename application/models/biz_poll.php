<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 业务模型
 * 主要处理特殊帖子投票相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_poll extends CI_Model {

    static $special = 3;
    static $special_post = 'poll_posts';

    function __construct() {
        parent::__construct();
        $this->load->model(array('poll_model', 'poll_options_model', 'poll_voter_model'));
    }

    public function post($tid, $post) {
        if (empty($tid) || empty($post)) {
            return FALSE;
        }
        //完成poll表的数据
        $poll_data['topic_id'] = $tid;
        $poll_data['is_overt'] = empty($post['is_overt']) ? 1 : 0;
        $poll_data['is_multiple'] = $post['max_choices'] > 1 ? 1 : 0;
        $poll_data['is_visible'] = empty($post['is_visible']) ? 1 : 0;
        $poll_data['max_choices'] = $post['max_choices'];
        $poll_data['expire_time'] = $this->time + ($post['expire_time'] * 3600 * 24);
        $poll_data['preview'] = join('[|]', array_slice($post['poll_option'], 0, 2));
        $poll_data['voters'] = 0;
        $this->poll_model->insert($poll_data);
        //完成poll_options表的数据
        $options_data = array();
        foreach ($post['poll_option'] as $k => $v) {
            $options_data[$k]['topic_id'] = $tid;
            $options_data[$k]['display_order'] = $k;
            $options_data[$k]['option'] = $v;
        }
        $this->poll_options_model->insert_batch($options_data);
    }

    public function check_post($type = 'post') {
        $this->form_validation->set_rules('poll_option[]', '选项', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('max_choices', '选项个数', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('expire_time', '投票有效天数', 'trim|is_natural');
        $this->form_validation->set_rules('is_visible', '', 'regex_match[/[01]/]');
        $this->form_validation->set_rules('is_overt', '', 'regex_match[/[01]/]');

        $this->form_validation->set_message('is_visible', '%s参数不正确。');
        $this->form_validation->set_message('is_overt', '%s参数不正确。');
        $this->form_validation->set_message('max_choices', '%s必须是大于0的正整数');
    }

}

?>
