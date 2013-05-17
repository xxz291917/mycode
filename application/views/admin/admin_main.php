<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>后台管理中心</title>
<style type="text/css">
html, body {
	height:100%;
	position:relative;
	overflow:hidden;
}
</style>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/style.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(function() {
		initMenu();
	});
	function getMenu(id,obj){
		$("#nav li").removeClass("on");
		$(obj).addClass("on");
		changeMenu(id);
		//$("#main").attr("src",$("#"+id+" .on").attr("href"));
	}
	function changeMenu(id){
		$("#menu").html($("#"+id).html());
		$("#menu a").click( function () {$("#menu a").removeClass("on");$(this).addClass("on")});
	}
	function initMenu(url){
		var url = url || "main/admin_index";
		$("#menulist").find('a').each(function(i){
			if(url.indexOf($(this).attr('href')) >=0){
				var menuId=$(this).parent().parent().parent().attr("id");
				$("#nav li").removeClass("on");
				$("#"+menuId+"menu").addClass("on");
				$("#"+menuId+" a").removeClass("on");
				$(this).addClass("on");
				changeMenu(menuId);
			}
		})
	}
</script>
</head>
<body scrolling="no" style="margin:0">
<table width="100%" height="100%">
<colgroup>
<col width="150">
<col>
</colgroup>
  <tr>
    <td colspan="2" height="56px"><div class="head">
        <p class="r a-r t-tips"> <a href="<?php echo base_url()?>" target="_blank">前台首页</a>|<a href="index.php?admin_main-logout">退出管理中心</a> </p>
        <ul id="nav">
          <li onclick="getMenu('index',this)" id="indexmenu" ><a href="javascript:void(0);"><span>首页</span></a></li>
          <li onclick="getMenu('global',this)" id="globalmenu"><a href="javascript:void(0);"><span>全局</span></a></li>
          <li onclick="getMenu('users',this)" id="usermenu"><a href="javascript:void(0);"><span>用户</span></a></li>
          <li onclick="getMenu('forums',this)" id="plugmenu"><a href="javascript:void(0);"><span>版块管理</span></a></li>
          <li onclick="getMenu('content',this)"  id="contentmenu"><a href="javascript:void(0);"><span>内容</span></a></li>
        </ul>
      </div></td>
  </tr>
  <tr>
    <td valign="top" class="admin_bg">
        <div class="sidebar">
          <div id='menu'> </div>
        </div>
        <div style="display:none" id='menulist'>
          <div id='index'>
            <ul>
              <li><a href="main/admin_index" target="main" class="on">首页信息</a></li>
            </ul>
          </div>
          <div id='global'>
            <ul>
              <li><a href="index.php?admin_setting-base" target="main" >站点设置</a></li>
              <li><a href="index.php?admin_channel" target="main">基本设置</a></li>
              <li><a href="index.php?admin_setting-sec" target="main">附件设置</a></li>
              <li><a href="index.php?admin_setting-index" target="main">积分设置</a></li>
            </ul>
          </div>
          <div id='users'>
            <ul>
              <li><a href="<?=base_url()?>index.php/admin/users" target="main" >用户管理</a></li>
              <li><a href="<?=base_url()?>index.php/admin/groups" target="main">用户组管理</a></li>
            </ul>
          </div>
          <div id='content'>
            <ul>
              <li><a href="index.php?admin_doc" target="main" >主题管理</a></li>
              <li><a href="index.php?admin_attachment" target="main">附件管理</a></li>
              <li><a href="index.php?admin_comment" target="main">审核管理</a></li>
              <li><a href="index.php?admin_hotsearch" target="main">举报管理</a></li>
              <li><a href="index.php?admin_word" target="main">敏感词管理</a></li>
              <li><a href="index.php?admin_recycle" target="main">回收站</a></li>
            </ul>
          </div>
          <div id='forums'>
            <ul>
              <li><a href="<?=base_url()?>index.php/admin/forums" target="main">版块管理</a></li>
              <li><a href="<?=base_url()?>index.php/admin/forums/merge" target="main">版块合并</a></li>
            </ul>
          </div>
        </div></td>
    <td height="95%"  valign="top"><iframe name="main" id="main" marginheight="0" marginwidth="0" frameborder="0" scrolling="yes"  style="width:100%; height:100%; overflow:visible;" src="index.php?{$admin_mainframe}"></iframe></td>
  </tr>
</table>
</body>
</html>