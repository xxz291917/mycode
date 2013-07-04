<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$config['enable_profiler'] = FALSE;//是否开启profiler。

$config['enable_cache'] = false;
$config['cache_time'] = 6*5;

$config['per_num'] = 10;
//默认的版块图标
$config['forum_icon'] = 'uploads/icon/forum/default.png';

//用户个人空间链接地址
$config['user_url'] = base_url().'index.php/user/show/';
//头像
$config['user_icon'] = base_url().'index.php/user/icon/';

//关注接口地址
$config['user_follow'] = 'http://hi.9tech.cn/index.php/follow/do_follow';
//获取用户粉丝数和关注数
$config['user_get_fans'] = 'http:// hi.9tech.cn/index.php/services/userinfo/get_fans_num/';
//回复通知接口
$config['user_publish'] = 'http://hi.9tech.cn/index.php/services/notice/do_publish';

//passport 注册
$config['passport_register'] = 'http://test.9tech.cn/passport/register.php';
//passport 登录
$config['passport_login'] = 'http://test.9tech.cn/passport/login.php';
//passport 退出
$config['passport_logout'] = 'http://test.9tech.cn/passport/logout.php';

?>
