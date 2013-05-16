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
<style type="text/css">
</style>
<script type="text/javascript">
	var base_url = '<?=base_url()?>';
	$(function(){
		//弹出框A链接扩展
		$("a[target=dialog]").each(function(){
			$(this).click(function(event){
				var $this = $(this);
				var title = $this.attr("title") || $this.text();
				var rel = $this.attr("rel") || "_blank";
				var options = {
					title: title,
					modal: true,
					resizable: false,
					close: function(event, ui) {
							$(this).dialog("destroy"); // 关闭时销毁
						}
					};
				var position = $this.attr("position"),
				 width = $this.attr("width"),
				 height = $this.attr("height"),
				 maxHeight = $this.attr("maxHeight"),
				 minHeight = $this.attr("minHeight"),
				 maxWidth = $this.attr("maxWidth"),
				 minWidth = $this.attr("minWidth");
				
				if(position) options.position = position;
				if(width)    options.width = width;
				if(height)   options.height = height;
				if(maxHeight)options.maxHeight = maxHeight;

				if(minHeight)options.minHeight = minHeight;
				if(maxWidth) options.maxWidth = maxWidth;
				if(minWidth) options.minWidth = minWidth;
				var url = unescape($this.attr("href"));
				var html =
				'<div class="dialog" id="'+rel+'" title="提示信息">' +
				' <iframe src="' + url + '" frameBorder="0" style="border: 0; " scrolling="auto" width="100%" height="100%"></iframe>' +
				'</div>';
				$(html).dialog(options);
				return false;
			});
		});
		
		//ajaxA链接扩展
		$("a[target=ajax]").each(function(){
			$(this).click(function(event){
				var $this = $(this);
				var rel = $this.attr("rel");
				if (rel) {
					var $rel = $("#"+rel);
					$rel.loadUrl($this.attr("href"), {}, function(){
						$rel.find("[layoutH]").layoutH();
					});
				}
				event.preventDefault();
			});
		});
		$("a[target=ajaxTodo]").each(function(){
			  $(this).click(function(event){
					var $this = $(this);
					var title = $this.attr("title");
					if (title) {
						  alertMsg.confirm(title, {
								okCall: function(){
									  ajaxTodo($this.attr("href"));
								}
						  });
					} else {
						  ajaxTodo($this.attr("href"));
					}
					event.preventDefault();
			  });
		});
	});

</script>
</head>
<body style="margin: 0 auto; width: 960px;">