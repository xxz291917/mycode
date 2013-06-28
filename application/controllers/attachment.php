<?php

class Attachment extends MY_Controller {

    private $mimes = array();
            
    function __construct() {
        parent::__construct();
        $this->load->model(array('attachments_model'));
        $this->get_mime();
    }

    public function download($aid) {
        if (empty($aid) || !is_numeric($aid)) {
            $this->message('参数错误，请指定要下载的文件id！');
        }
        $attachments = $this->attachments_model->get_by_id($aid);
        if (empty($attachments)) {
            $this->message('参数错误，附件不存在');
        }
        //更新下载次数
        $this->attachments_model->update_increment(array('downloads'=>':1'),array('id'=>$aid));
        $this->download_file($attachments['path']);
    }

    private function get_mime(){
        if (defined('ENVIRONMENT') AND is_file(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php')) {
            include(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php');
        } elseif (is_file(APPPATH . 'config/mimes.php')) {
            include(APPPATH . 'config//mimes.php');
        } else {
            return FALSE;
        }
        $this->mimes = $mimes;
        unset($mimes);
    }

    private function download_file($full_path) {
        if (headers_sent())
            die('Headers Sent');
        
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
        
        if (file_exists($full_path)) {
            $fsize = filesize($full_path);
            $path_parts = pathinfo($full_path);
            $ext = strtolower($path_parts["extension"]);
            
            if(isset($this->mimes[$ext])){
                $ctype = is_array($this->mimes[$ext])?$this->mimes[$ext][0]:$this->mimes[$ext];
            }else{
                $ctype = "application/force-download";
            }
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: $ctype");
            header("Content-Disposition: attachment; filename=\"" . basename($full_path) . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $fsize);
            ob_clean();
            flush();
            readfile($full_path);
        }
        else
            die('File Not Found');
    }

}

?>