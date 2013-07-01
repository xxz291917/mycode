<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 * 主要处理首页相关的调用和业务。
 *
 * @author		xiaxuezhi
 */
class Biz_image extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model'));
        $this->load->library('image_lib');
        //$this->load->helper('date');
    }

    public function icon_upload() {
        $field_name = 'icon';
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $config['upload_path'] = './uploads/icon';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($field_name)) {
            $error = array('error' => $this->upload->display_errors());
            $return = array('error' => 1, 'message' => $error['error']);
            return $return;
        } else {
            $data = $this->upload->data();
            $thumb = $this->create_thumb($data['full_path']);
            if($thumb){
                $file_path = trim($config['upload_path'], './') . '/' . $thumb;
                $return = array('error' => 0, 'message' => '生成缩略图失败','data'=>$file_path);
                return $return;
            }else{
                $return = array('error' => 1, 'message' => '生成缩略图失败');
                return $return;
            }
        }
    }
    
    
    public function create_thumb($full_path,$width = 50,$height = 50, $suffix='_s'){
        $config['image_library'] = 'gd2';
        $config['source_image'] = $full_path;
//        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        
        $paths = pathinfo($full_path);
        $new_file_name = $paths['filename'].$suffix.'.'.$paths['extension'];
        $new_image = $paths['dirname'].'/'.$new_file_name;
        $config['new_image'] = $new_image;
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            return false;
        }else{
            return $new_file_name;
        }
    }

}

?>
