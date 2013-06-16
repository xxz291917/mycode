<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medals extends Admin_Controller {

    public $type_names = array(0 => '手动颁发', 1 => '自动颁发', 2 => '申请颁发');

    function __construct() {
        parent::__construct();
        $this->load->model(array('medals_model', 'medals_log_model', 'users_medal_model'));
    }

    public function index() {
        if ($this->input->post('submit')) {
            $medals = $this->input->post(null,true);
            if (!empty($medals['old'])) {
                if ($this->medals_model->update_old($medals['old'])) {
                    unset($medals['old']);
                } else {
                    $this->message('修改分类失败');
                }
            }
            if (!empty($medals['new'])) {
                if ($is_insert = $this->medals_model->insert_new($medals['new'])) {
                    unset($medals['new']);
                } else {
                    $this->message('添加分类失败');
                }
            }
            $this->message('修改成功！',1);
        } else {
            $medals = $this->medals_model->get_all();
            $var['type_names'] = $this->type_names;
            $var['medals'] = $medals;
            $this->view('medals', $var);
        }
    }

    public function edit($type = 'setting') {
        if ($this->input->post('submit')) {
            if (!empty($forums['old'])) {
                if ($this->topics_category_model->update_old($forums['old'], $id)) {
                    unset($forums['old']);
                } else {
                    $this->message('修改分类失败');
                }
            }
            if (!empty($forums['new'])) {
                if ($is_insert = $this->topics_category_model->insert_new($forums['new'], $id)) {
                    unset($forums['new']);
                } else {
                    $this->message('添加分类失败');
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
        $id = intval($this->input->post('id'));
        if ($id > 0) {
            if ($this->medals_model->delete(array('id' => $id))) {
                $this->message('操作成功。', 1);
            } else {
                $this->message('操作数据库失败。');
            }
        } else {
            $this->message('操作成功。', 1);
        }
    }

}

?>