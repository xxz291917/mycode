<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$config['enable_profiler'] = FALSE;//是否开启profiler。

$config['enable_cache'] = TRUE;
$config['cache_time'] = 2*5;

$config['per_num'] = 10;
//默认的版块图标
$config['forum_icon'] = 'uploads/icon/forum/default.png';

//用户个人空间链接地址
$config['user_url'] = 'http://me.9ria.com/index.php/homepage/main/';
//关注接口地址
$config['user_follow'] = 'http://me.9ria.com/index.php/follow/do_follow';
//获取用户粉丝数和关注数
$config['user_get_fans'] = 'http://me.9ria.com/index.php/services/userinfo/get_fans_num/';
//回复通知接口
$config['user_notice'] = 'http://me.9ria.com/index.php/services/notice/do_publish';
//我的动态
$config['user_feed'] = 'http://me.9ria.com/index.php/services/feed/do_publish';
//我的收藏
$config['user_collect'] = 'http://me.9ria.com/index.php/services/favorite/do_publish';

//passport 注册
$config['passport_register'] = 'http://passport.9ria.com/register.php';
//passport 登录
$config['passport_login'] = 'http://passport.9ria.com/login.php';
//passport 退出
$config['passport_logout'] = 'http://passport.9ria.com/logout.php';


//博客地址
$config['url_blog'] = 'http://blog.9ria.com/';

//个人中心地址
$config['url_setting'] = 'http://me.9ria.com/';

//下载地址
$config['url_download'] = 'http://download.9ria.com/';
//专题地址
$config['url_xxxx'] = 'http://passport.9ria.com/logout.php';

?>
