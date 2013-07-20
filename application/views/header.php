


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $seo['title']?></title>
<meta name="description" content="<?php echo $seo['description']?>">
<meta name="keywords" content="<?php echo $seo['keywords']?>">
<link rel="stylesheet" href="<?=base_url()?>css/main.css">
<!--[if IE]>
<script src="<?=base_url()?>js/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/front_style.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" href="<?=base_url()?>js/kindeditor/themes/default/default.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<link href="<?=base_url()?>js/syntaxhighlighter/styles/shCoreDefault.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>js/syntaxhighlighter/styles/shThemeEclipse.css" type="text/css" rel="Stylesheet" />
</head>
<body>

<a id="returnTop"  href="#top"></a> 
<!--header-->
<div class="nav">
  <div class="navWrap clearfix">
    <ul class="mainNav">
      <li class="icoHome"><a href="<?=base_url()?>">首页</a></li>
      <li class="pr"><a href="<?=base_url()?>" class="icoDown">论坛</a>
        <ul class="pa">
          <li><a href="<?php echo base_url('/html5')?>">HTML5</a></li>
          <li><a href="<?php echo base_url('/ios')?>">IOS</a></li>
          <li><a href="<?php echo base_url('/android')?>">Android</a></li>
          <li><a href="<?php echo base_url('/unity3d')?>">Unity3d</a></li>
          <li><a href="<?php echo base_url('/cocos2d')?>">Cocos2d-x</a></li>
          <li><a href="<?php echo base_url('/flash')?>">Flash</a></li>
        </ul>
      </li>
      <!--li><a href="#">资讯</a></li-->
      <li><a href="<?php echo $this->config->item('url_blog')?>" target="_blank">博客</a></li>
      <!--li><a href="#">专题</a></li>
      <li><a href="#">天地行</a></li>
      <li><a href="#">招聘</a></li>
      <li><a href="#">下载</a></li-->
    </ul>
    
        <?php if($this->user['id']>0){?>
    	<ul class="logInfo">
          <li class="welTip">欢迎你，<a href="<?php echo user_url($this->user['id'])?>"><?php echo $this->user['username']?></a></li>
          <li class="icoBlog"><a href="<?php echo $this->config->item('url_blog')?>index.php/article/article_list/view/V/uid/18/uname/<?php echo $this->user['username']?>">blog</a></li>
          <li class="pr"><a href="#" class="icoNote pa"></a>
            <ul class="pa">
              <li><a href="<?php echo $this->config->item('url_setting')?>index.php/letter/reply/get_list">查看回复<i></i></a></li>
              <li><a href="<?php echo $this->config->item('url_setting')?>index.php/letter/message/index">查看留言<i></i></a></li>
            </ul>
          </li>
          <li class="pr"><a href="<?php echo $this->config->item('url_setting')?>index.php/letter/letter_user/get_list" class="icoEmail"></a></li>
              <!--li class="pr subShow"><a href="#" class="icoNote pa"><span>99+</span></a>
                <ul class="pa">
                  <li><a href="#">给我的回复<i>6</i></a></li>
                  <li><a href="#">申请加好友<i>8</i></a></li>
                </ul>
              </li>
              <li class="pr subShow"><a href="#" class="icoEmail pa"><span>12</span></a>
                <ul class="pa">
                  <li><a href="#">给我的回复<i>26</i></a></li>
                  <li><a href="#">申请加好友<i>99+</i></a></li>
                </ul>
              </li-->
          <li class="pr"><a href="#" class="icoSet"></a>
            <ul class="pa">
              <li><a href="<?php echo $this->config->item('url_setting')?>index.php/user_info/modify/">管理中心</a></li>
              <li><a href="<?php echo base_url('index.php/space/my_topic')?>">帖子管理</a></li>
              <li><a href="<?php echo $this->config->item('passport_logout')?>">退出</a></li>
            </ul>
          </li>
        </ul>
        <?php }else{?>
          <ul class="logInfo">
              <li class="fsong"><a href="<?php echo $this->config->item('passport_login')?>">登录</a>|<a href="<?php echo $this->config->item('passport_register')?>">注册</a></li>
          </ul>
        <?php }?>
  </div>
</div>

<div class="header wrap">
  <h1><a href="<?php echo base_url();?>">9Tech开发者社区</a></h1>
  <div class="search">

      <input type="text" id="" name="" maxlength="" value="" class="" autocomplete="off" placeholder="请输入关键字">
      <button>搜索</button>

  </div>
</div>

<div class="subNav wrap">
  <ul>
    <li><a href="<?php echo base_url()?>">首页</a></li>
    <li><a href="<?php echo base_url()?>">论坛</a></li>
	<li><a href="<?php echo base_url('/html5')?>">HTML5</a></li>
    <li><a href="<?php echo base_url('/ios')?>">IOS</a></li>
    <li><a href="<?php echo base_url('/android')?>">Android</a></li>
    <li><a href="<?php echo base_url('/unity3d')?>">Unity3d</a></li>
    <li><a href="<?php echo base_url('/cocos2d')?>">Cocos2d-x</a></li>
    <li><a href="<?php echo base_url('/flash')?>">Flash</a></li>
  </ul>
</div>
<script>
$(function(){
	$('.icoDown').parent().hover(function() {
$(this).addClass('current');
$(this).addClass('bgmainNav'); 
},function(){
$(this).removeClass('current');
$(this).removeClass('bgmainNav'); 
});
	});
</script>