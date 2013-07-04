<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>论坛</title>
<meta name="description" content="论坛">
<meta name="keywords" content="论坛">
<link rel="stylesheet" href="<?=base_url()?>css/main.css">
<!--[if IE]>
<script src="js/html5.js"></script>
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
<div class="navBox pr">
  <div class="nav pa">
    <div class="navWrap pr">
      <h1 class="pa"><a href="http://test.9tech.cn">9Tech开发者社区</a></h1>
      <ul class="mainNav">
        <li class="mainNavHome"><a href="<?=base_url()?>">首页</a></li>
        <li class="current"><a href="<?=base_url()?>">论坛</a></li>
        <li><a href="<?php echo $this->config->item('url_blog')?>" target="_blank">博客</a></li>
        <li><a href="<?php echo $this->config->item('url_blog')?>" target="_blank">专题</a></li>
        <li><a href="<?php echo $this->config->item('url_blog')?>" target="_blank">活动</a></li>
        <li><a href="<?php echo $this->config->item('url_download')?>" target="_blank">下载</a></li>
      </ul>
      <div class="mainNavR">
        <?php if($this->user['id']>0){?>
        <ul class="logInfo">
          <li><a href="#" class="icoNote"></a></li>
          <li><a href="#" class="icoEmail"></a></li>
          <!--
          <li class="pr subShow"><a href="#" class="icoNote pa"><span>99+</span></a></li>
          <li class="pr subShow"><a href="#" class="icoEmail pa"><span>12</span></a></li>
          -->
          <li class="pr ml10">
              <a href="#" class="icoSet"></a>
            <ul class="pa">
              <li><a href="#">账号设置</a></li>
              <li><a href="<?php echo $this->config->item('passport_logout')?>">退出</a></li>
            </ul>
          </li>
          <li class="welTip"><a href="<?php echo user_url($this->user['id'])?>"><img src="<?php echo user_icon($this->user['id'])?>" alt="<?php echo $this->user['username']?>" title="<?php echo $this->user['username']?>"></a></li>
        </ul>
        <?php }else{?>
          <ul class="logInfo">
              <li class="fsong"><a href="<?php echo $this->config->item('passport_login')?>">登录</a>|<a href="<?php echo $this->config->item('passport_register')?>">注册</a></li>
          </ul>
        <?php }?>
        <!--a href="javascript:void(0);" class="searchBtn fr">搜索</a-->
      </div>
      <div class="searchBox pa">
        <input type="tel" value="请输入关键字" class="inpTxt">
        <button>搜索</button>
        <a class="searchCls"></a>
      </div>
    </div>
  </div>
</div>