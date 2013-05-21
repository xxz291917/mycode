<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>前台测试页面</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/front_style.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/jquery-ui/jquery-ui.min.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/json2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/dialog-ex.js"></script>


<link rel="stylesheet" href="<?=base_url()?>js/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?=base_url()?>js/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?=base_url()?>js/kindeditor/lang/zh_CN.js"></script>
<script>
        var editor;
        KindEditor.ready(function(K) {
                editor = K.create('textarea[name="content"]', {
                        resizeType : 1,
                        allowPreviewEmoticons : false,
                        allowImageUpload : false,
                        items : [
                                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                                'insertunorderedlist', '|', 'emoticons', 'image', 'link']
                });
        });


  
</script>
</head>
<body style="margin: 0 auto; width: 960px;">

<table class="table2">
  <tr class="split">
    <td>
     <a href="<?php echo base_url();?>">首页</a>
     <a href="<?php echo base_url('index.php/admin/main');?>">后台管理</a>
    </td>
  </tr>
</table>
    
    