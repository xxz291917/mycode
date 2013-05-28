<style>
.ke-icon-code2 {
	background-position: 0px -960px;
	width: 16px;
	height: 16px;
}
.ke-icon-smiley {
	background:url(<?=base_url()?>js/kindeditor/plugins/smiley/smile.gif) no-repeat;
    height: 16px;
    width: 16px;
}
.ke-icon-hide {
	background-position: 0px -960px;
	width: 16px;
	height: 16px;
}
.ke-img{ text-align:center;}
</style>
<script>
		KindEditor.smileUrl = "<?=base_url()?>index.php/posts/get_smiley_json";
		KindEditor.smileys=null;
		$.ajax({
			type: "POST",
			url: KindEditor.smileUrl,
			success: function(json){
				KindEditor.smileys = json.data;
			},
			dataType: 'json',
		});
		
		KindEditor.lang({
				hide : '隐藏内容',
				code2 : '插入代码',
				smiley : '插入表情',
		});
        var editor;
        KindEditor.ready(function(K) {
			//alert(K===KindEditor); //true
			//alert(K.VERSION);
                editor = K.create('textarea[name="content"]', {
                        resizeType : 1,
                        allowPreviewEmoticons : true,
                        allowImageUpload : true,
						//代码高亮，样式
						cssPath : ['<?=base_url()?>js/kindeditor/plugins/code2/codeprint.css'],
						items : [
						'fontname', 'fontsize', 
						'|','justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 
						'|','insertorderedlist', 'insertunorderedlist','indent', 'outdent',
						'|','wordpaste','clearhtml','quickformat','selectall','fullscreen','source',
						'/',
						'bold', 'italic', 'underline','strikethrough',
						'|','forecolor', 'hilitecolor',
						'|','hr', 'table','link', 'unlink',
						'|','smiley','image','insertfile','media','code2',
						'|','undo', 'redo','hide'],
	
                });
			//将内容格式化为bbcode
			editor.beforeGetHtml(function(html){
					return html2bbc(html);
				});
			//将bbcode格式化为html
       		editor.beforeSetHtml(function(html){
					return bbc2html(html);
				});
			function html2bbc(str){
				if(str == '') {
					return '';
				}
				//处理表情符号，变为html
				if(KindEditor.smileys!=null){
					str = str.replace(/<img[^>]+smileId=(["']?)(\d+)(\1)[^>]*>/ig, function($1, $2, $3) {return KindEditor.smileys[$3].code;});
				}
				return str;
			}
			function bbc2html(str){
				var smileys = KindEditor.smileys;
				if(smileys != null) {
					for(var id in smileys) {
						re = new RegExp(preg_quote(smileys[id].code), "g");
						str = str.replace(re, '<img src="' + smileys[id].url + '" border="0" smileId="' + id + '" />');
					}
				}
				return str;
			}
			function preg_quote(str) {
				return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "\\$1");
			}
		});
		
</script>
<?php echo form_open(current_url())?>
<table class="table2">
  <colgroup>
  <col >
  <col style="color:#F00;">
  </colgroup>
  <tr class="split">
    <td colspan="2">发表帖子</td>
  </tr>
  <tr>
    <td><input type="text" value="<?php echo set_value('subject', '输入标题'); ?>" name="subject" class="inp_txt inp_long"></td>
    <td style="color:#F00;"><?php echo form_error('subject'); ?></td>
  </tr>
  <tr>
    <td><textarea name="content" style="width:700px;height:200px;visibility:hidden;"><?php echo set_value('content', '填写帖子内容'); ?></textarea></td>
    <td style="color:#F00;"><?php echo form_error('content'); ?></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="发布" />
  <input class="inp_btn3" name="submit" type="submit" value="保存草稿" style=" margin-left:39px;" />
</p>
<?php echo form_close() ?>