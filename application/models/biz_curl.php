<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 *
 * @author		xiaxuezhi
 */
class Biz_curl extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model(array('topics_model'));
    }

    function my_fopen($url, $post = '', $limit = 0, $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
        $return = '';
        $matches = parse_url($url);
        $host = $matches['host'];
        @$path = $matches['path'] ? $matches['path'] . '?' . $matches['query'] . '#' . $matches['fragment'] : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;
        if (is_array($post)) {
            $post = http_build_query($post, '', '&');
        }
        if ($post) {
            $out = "POST $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $site_url\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= 'Content-Length: ' . strlen($post) . "\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cache-Control: no-cache\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
            $out .= $post;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            //$out .= "Referer: $site_url\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
        }
        $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        if (!$fp) {
            return '';
        } else {
            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if (!$status['timed_out']) {
                $firstline = true;
                while (!feof($fp)) {
                    $header = @fgets($fp);
                    if ($firstline && (false === strstr($header, '200'))) {
                        return '';
                    }
                    $firstline = false;
                    if ($header && ($header == "\r\n" || $header == "\n")) {
                        break;
                    }
                }
                $stop = false;
                while (!feof($fp) && !$stop) {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $return .= $data;
                    if ($limit) {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            @fclose($fp);
            return $return;
        }
    }

    function my_curl($url, $postdata = '') {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => 1
        );
        if ($postdata != '') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $postdata;
        }
        curl_setopt_array($ch, $options);
        $buf = curl_exec($ch);
        curl_close($ch);
        return $buf;
    }

}

?>
