<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>前台测试页面</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/front_style.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/jquery-ui/jquery-ui.min.css" />
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/json2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/dialog-ex.js"></script>


<link rel="stylesheet" href="<?=base_url()?>js/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="<?=base_url()?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?=base_url()?>js/kindeditor/lang/zh_CN.js"></script>
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
<!--
<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/kindeditor/plugins/code/prettify.css" />
<script type="text/javascript" src="<?=base_url()?>js/kindeditor/plugins/code/prettify.js"></script>
<script> 
$(function(){
 prettyPrint(); 
}); 
</script> 
-->
<script src="<?=base_url()?>js/syntaxhighlighter/scripts/shCore.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/syntaxhighlighter/scripts/shAutoloader.js" type="text/javascript"></script>
<link href="<?=base_url()?>js/syntaxhighlighter/styles/shCoreDefault.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>js/syntaxhighlighter/styles/shThemeEclipse.css" type="text/css" rel="Stylesheet" />
<script type="text/javascript">
$(function(){
	function path(){
	  var args = arguments,
		  result = [];
	  for(var i = 0; i < args.length; i++)
		  result.push(args[i].replace('@', '<?=base_url()?>js/syntaxhighlighter/scripts/'));
	  return result
	};
	SyntaxHighlighter.autoloader.apply(null, path(
	  'applescript            @shBrushAppleScript.js',
	  'actionscript3 as3      @shBrushAS3.js',
	  'bash shell             @shBrushBash.js',
	  'coldfusion cf          @shBrushColdFusion.js',
	  'cpp c                  @shBrushCpp.js',
	  'c# c-sharp csharp      @shBrushCSharp.js',
	  'css                    @shBrushCss.js',
	  'delphi pascal          @shBrushDelphi.js',
	  'diff patch pas         @shBrushDiff.js',
	  'erl erlang             @shBrushErlang.js',
	  'groovy                 @shBrushGroovy.js',
	  'java                   @shBrushJava.js',
	  'jfx javafx             @shBrushJavaFX.js',
	  'js jscript javascript  @shBrushJScript.js',
	  'perl pl                @shBrushPerl.js',
	  'php                    @shBrushPhp.js',
	  'text plain             @shBrushPlain.js',
	  'py python              @shBrushPython.js',
	  'ruby rails ror rb      @shBrushRuby.js',
	  'sass scss              @shBrushSass.js',
	  'scala                  @shBrushScala.js',
	  'sql                    @shBrushSql.js',
	  'vb vbnet               @shBrushVb.js',
	  'xml xhtml xslt html    @shBrushXml.js'
	));
	SyntaxHighlighter.defaults['toolbar'] = false;
	SyntaxHighlighter.all();
}); 


	
</script>