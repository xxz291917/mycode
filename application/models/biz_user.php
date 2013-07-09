<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 业务模型
 *
 * @author		xiaxuezhi
 */
class Biz_user extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model(array('biz_curl'));
    }

    function get_funs($user_id) {
        $url = trim($this->config->item('user_get_fans'), '/') . '/' . $user_id;
        $data = $this->biz_curl->my_fopen($url);
        $data = json_decode($data, TRUE);
        if (empty($data) || $data['succ'] <= 0) {
            log_message('error', '用户加关注出错。');
            return FALSE;
        } else {
            return $data['info'];
//            return array('following_num' => '20', 'follower_num' => '30');
        }
    }

    /** 关注
     * url：http://hi.9tech.cn/index.php/follow/do_follow
      方式：post
      数据：uid（被关注的人都passport_user_id）
      返回结果：josn格式
      succ:是否成功标志 — 1表示成功，0/负数表示失败/有错误
      msg：错误提示语 — succ为1是为空
      info：数组，需要返回的一些信息（请提供需要怎样的数据，默认为空）

     * @param type $user_id
     * @return boolean
     */
    function follow($user_id) {
        $url = trim($this->config->item('user_follow'));
        $data = $this->biz_curl->my_fopen($url, array('uid' => $user_id));
        $data = json_decode($data, TRUE);
        if (empty($data) || $data['succ'] <= 0) {
            log_message('error', '用户加关注出错。');
        }
        return $data;
    }

    /** 通知
     * url：http://hi.9tech.cn/index.php/services/notice/do_publish
      方式：post
      数据：type(1bbs 2blog 3reply 4状态)
      obj_id(新增内容对应的id)
      from_passport_user_id(动作发起人passport 用户ID)
      to_passport_user_id(passport用户ID)
      url(帖子/博客的url)
      title（帖子/博客的标题）
      content（描述或评论内容等。bbs帖子body可以为空；blog的博文body为描述，博文的评论body为评论内容）
      create_date（动作产生的时间戳，可以为空，为空时是feed插入数据库的时间戳。例如发帖时间）
     */
    public function publish($type, $obj_id, $from_passport_user_id, $to_passport_user_id, $this_url, $title, $content, $create_date) {
        $url = trim($this->config->item('user_notice'));
        $post = array(
            'type' => $type,
            'obj_id' => $obj_id,
            'from_passport_user_id' => $from_passport_user_id,
            'to_passport_user_id' => $to_passport_user_id,
            'url' => $this_url,
            'title' => $title,
            'content' => $content,
            'create_date' => $create_date,
        );
        $data = $this->biz_curl->my_fopen($url, $post);
        $data = json_decode($data, TRUE);
        if (empty($data) || $data['succ'] <= 0) {
            log_message('error', '同步回复出错。');
        }
        return $data;
    }

    /** 动态
     * url：http://hi.9tech.cn/index.php/services/feed/do_publish
      数据：type（下面$types的key值，value为对应的情况。例如发表博客，type=201）
      //blog
      $types[201] = '发表了博客';
      $types[202] = '评论了博客';
      $types[203] = '收藏了博客';
      //bbs
      $types[302] = '回复了帖子';
      $types[303] = '发布了问题';
      $types[304] = '回答了问题';
      $types[305] = '发起了投票';
      $types[306] = '参与了投票';
      $types[307] = '发起了辩论';
      $types[308] = '参与了评论';
      $types[309] = '收藏了帖子';
      passport_user_id(passport 用户ID)
      url(帖子/博客的url)
      title（帖子/博客的标题）
      body（描述或评论内容等。bbs帖子body可以为空；blog的博文body为描述，博文的评论body为评论内容）
      dateline（动作产生的时间戳，可以为空，为空时是feed插入数据库的时间戳。例如发帖时间）
      返回结果：josn格式
      succ:是否成功标志 — 1表示成功，0/负数表示失败/有错误
      msg：错误提示语 — succ为1是为空
      info：数组，需要返回的一些信息（请提供需要怎样的数据，默认为空）
     */
    public function feed($type = 'post', $special = 1, $user_id, $this_url, $title, $content, $create_date) {
        $url = trim($this->config->item('user_feed'));
        $types = array(
            'post_1' => '301', //发表了帖子
            'post_2' => '303', //发布了问题
            'post_3' => '305', //发起了投票
            'post_4' => '307', //发起了辩论
            'reply_1' => '302', //回复了帖子
            'reply_2' => '304', //回答了问题
            'reply_3' => '306', //参与了投票
            'reply_4' => '308', //参与了评论
        );
        $post = array(
            'type' => $types[$type . '_' . $special],
            'passport_user_id' => $user_id,
            'url' => $this_url,
            'title' => $title,
            'body' => $content,
            'create_date' => $create_date,
        );
        $data = $this->biz_curl->my_fopen($url, $post);
        $data = json_decode($data, TRUE);
        if (empty($data) || $data['succ'] <= 0) {
            log_message('error', '同步回复出错。');
        }
        return $data;
    }

    /** 收藏
     * url：http://hi.9tech.cn/index.php/services/favorite/do_publish
      方式：post
      数据：passport_user_id(passport 用户ID)
      url(帖子/博客的url)
      title（帖子/博客的标题）
      返回结果：josn格式
      succ:是否成功标志 — 1表示成功，0/负数表示失败/有错误
      msg：错误提示语 — succ为1是为空
      info：数组，需要返回的一些信息（请提供需要怎样的数据，默认为空）

     * @param type $topic_id
     */
    public function collect($topic_id) {
        $url = trim($this->config->item('user_collect'));
        $topic = $this->topics_model->get_by_id($topic_id);
        if (!empty($topic)) {
            $collect_data['type'] = 1;
            $collect_data['passport_user_id'] = $this->user['id'];
            $collect_data['url'] = base_url('index.php/topic/show/'.$topic_id);
            $collect_data['title'] = $topic['subject'];
            $data = $this->biz_curl->my_fopen($url, $collect_data);
            $data = json_decode($data, TRUE);
            if (empty($data) || $data['succ'] <= 0) {
                log_message('error', '用户加关注出错。');
            }
            return $data;
        }else{
            return FALSE;
        }
        
    }

}

?>
