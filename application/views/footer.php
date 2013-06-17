<!--footer-->
<footer class="footer wrap">
  <p><span>Powered by <strong><a target="_blank" href="http://www.discuz.net">Discuz!</a></strong> X2</span><a href="archiver/">Archiver</a>|<a href="forum.php?mobile=yes">手机版</a>|<strong><a target="_blank" href="http://www.9RIA.com/">9RIA.com</a></strong>|( <a target="_blank" href="http://www.miitbeian.gov.cn/">京ICP备11007422号-2</a> )<a title="防水墙保卫网站远离侵害" target="_blank" href="http://discuz.qq.com/service/security"><img src="static/image/common/security.png"></a></p>
  <p><span>&copy; 2001-2011 <a target="_blank" href="http://www.comsenz.com">Comsenz Inc.</a></span>GMT+8, 2013-6-15 12:03<span id="debuginfo">, Processed in 0.113182 second(s), 22 queries.</p>
</footer> 
<!--滚动-->
<div class="scroll pa">
<a class="btnShare">分享到<i>+</i></a>
<a href="#top" class="btnBackTop">返回顶部</a>
</div> 

<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery-ui/jquery-ui.min.js"></script>

<script charset="utf-8" src="<?=base_url()?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?=base_url()?>js/kindeditor/lang/zh_CN.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/json2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/dialog-ex.js"></script>

<script src="<?=base_url()?>js/animateBackground-plugin.js"></script>
<script src="<?=base_url()?>js/main.js"></script>

<script src="<?=base_url()?>js/syntaxhighlighter/scripts/shCore.js" type="text/javascript"></script>
<script src="<?=base_url()?>js/syntaxhighlighter/scripts/shAutoloader.js" type="text/javascript"></script>
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
</body>
</html>