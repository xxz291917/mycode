<style>
.ke-icon-code2 {
	background-position: 0px -960px;
	width: 16px;
	height: 16px;
}
.ke-icon-image2 {
	background-position: 0px -496px;
	width: 16px;
	height: 16px;
}
.ke-icon-smiley {
	background:url(<?=base_url()?>js/kindeditor/plugins/smiley/smile.gif) no-repeat;
    height: 16px;
    width: 16px;
}
.ke-icon-hide {
	background:url(<?=base_url()?>js/kindeditor/plugins/hide/hide.gif) no-repeat;
	width: 16px;
	height: 16px;
}
.ke-icon-quote {
	background:url(<?=base_url()?>js/kindeditor/plugins/quote/quote.gif) no-repeat;
	width: 16px;
	height: 16px;
}
.ke-img{ text-align:center;}
</style>
<script>
		KindEditor.uploadImages={};
		KindEditor.uploadFiles={};
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
				hide : '插入隐藏内容',
				code2 : '插入代码',
				image2 : '插入图片',
				'image2.remoteImage' : '网络图片',
				'image2.localImage' : '本地上传',
				'image2.remoteUrl' : '图片地址',
				'image2.localUrl' : '上传文件',
				'image2.size' : '图片大小',
				'image2.width' : '宽',
				'image2.height' : '高',
				'image2.resetSize' : '重置大小',
				'image2.defaultAlign' : '默认方式',
				'image2.leftAlign' : '左对齐',
				'image2.rightAlign' : '右对齐',
				'image2.imgTitle' : '图片说明',
				'image2.upload' : '浏览...',
				smiley : '插入表情',
				quote : '插入引用内容',
				'insertfile.localUrl' : '附件',
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
						cssPath : [
						'<?=base_url()?>js/kindeditor/plugins/code2/codeprint.css',
						'<?=base_url()?>js/kindeditor/plugins/quote/quote.css',
						],
						useContextmenu:false,
						uploadJson : '<?=base_url()?>index.php/posts/do_upload/',   //<<相对于kindeditor3.5.5\plugins\image\image.html 
						//fileManagerJson : '../../php/file_manager_json2.php',   //<<相对于kindeditor3.5.5\plugins\file_manager\file_manager.html 
						allowFileManager : false,
						afterUpload : function(url,data,name) {
							//postform
							if(data.aid!=undefined){
								var postform = $("#postform");
								postform.append('<input type="hidden" name="attachments[]" value="' + data.aid + '" />');
							}
						},
						extraFileUploadParams : {
						},
						fillDescAfterUploadImage:false,
						
						items : [
						'fontname', 'fontsize', 
						'|','justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 
						'|','insertorderedlist', 'insertunorderedlist','indent', 'outdent',
						'|','wordpaste','clearhtml','quickformat','selectall','fullscreen','source',
						'/',
						'bold', 'italic', 'underline','strikethrough',
						'|','forecolor', 'hilitecolor',
						'|','hr', 'table','link', 'unlink',
						'|','smiley','image2','insertfile',/*'media',*/'code2','quote',
						'|','undo', 'redo','|','hide'],
						htmlTags : {
							font : ['id', 'class', 'color', 'size', 'face', '.background-color'],
							span : [
								'id', 'class', '.color', '.background-color', '.font-size', '.font-family', '.background',
								'.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.line-height'
							],
							div : [
								'id', 'class', 'align', '.border', '.margin', '.padding', '.text-align', '.color',
								'.background-color', '.font-size', '.font-family', '.font-weight', '.background',
								'.font-style', '.text-decoration', '.vertical-align', '.margin-left'
							],
							table: [
								'id', 'class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'bordercolor',
								'.padding', '.margin', '.border', 'bgcolor', '.text-align', '.color', '.background-color',
								'.font-size', '.font-family', '.font-weight', '.font-style', '.text-decoration', '.background',
								'.width', '.height', '.border-collapse'
							],
							'td,th': [
								'id', 'class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor',
								'.text-align', '.color', '.background-color', '.font-size', '.font-family', '.font-weight',
								'.font-style', '.text-decoration', '.vertical-align', '.background', '.border'
							],
							a : ['id', 'class', 'href', 'target', 'name'],
							embed : ['id', 'class', 'src', 'width', 'height', 'type', 'loop', 'autostart', 'quality', '.width', '.height', 'align', 'allowscriptaccess'],
							img : ['id', 'class', 'src', 'width', 'height', 'border', 'alt', 'title', 'align', '.width', '.height', '.border','smileid','aid'],
							'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : [
								'id', 'class', 'align', '.text-align', '.color', '.background-color', '.font-size', '.font-family', '.background',
								'.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.text-indent', '.margin-left'
							],
							pre : ['id', 'class'],
							hr : ['id', 'class', '.page-break-after'],
							'br,tbody,tr,strong,b,sub,sup,em,i,u,strike,s,del' : ['id', 'class'],
							iframe : ['id', 'class', 'src', 'frameborder', 'width', 'height', '.width', '.height']
						},
						//将内容格式化为bbcode
						afterCreate:function(){
							//this.html(bbc2html(this.html()));
						},
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
				//处理表情符号，变为code
				if(KindEditor.smileys!=null){
					str = str.replace(/<img[^>]+smileId=(["']?)(\d+)(\1)[^>]*>/ig, function($0, $1, $2) {return KindEditor.smileys[$2].code;});
				}
				//处理上传的图片，变为code
				if(KindEditor.uploadImages!=null){
					str = str.replace(/<img[^>]+aid=(["']?)(\d+)(\1)[^>]*>/ig, "[attachimg]$2[/attachimg]");
				}
				//处理上传的附件，变为code
				if(KindEditor.uploadFiles!=null){
					str = str.replace(/<a[^>]+aid=(["']?)(\d+)(\1)[^>]*>[^>]*<\/a>/ig, "[attach]$2[/attach]");
				}
				return str;
			}
			function bbc2html(str){
				//处理表情符号，变为html
				var smileys = KindEditor.smileys;
				if(smileys != null) {
					for(var id in smileys) {
						var re = new RegExp(preg_quote(smileys[id].code), "g");
						str = str.replace(re, '<img src="' + smileys[id].url + '" border="0" smileId="' + id + '" />');
					}
				}
				//bbcode图片，变为html
				str = str.replace(/\[attachimg\](\d+)\[\/attachimg\]/g, function($0,$1,$2){
													if(typeof KindEditor.uploadImages[$1] == "undefined"){
														return '';
													}else{
														return KindEditor.uploadImages[$1]
													}
												});
				//bbcode附件，变为html
				str = str.replace(/\[attach\](\d+)\[\/attach\]/g, function($0,$1,$2){
													if(typeof(KindEditor.uploadFiles[$1]) == "undefined"){
														return '';
													}else{
														return KindEditor.uploadFiles[$1]
													}
												});
				return str;
			}
			function preg_quote(str) {
				return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "\\$1");
			}
			function isEmptyObject(obj){
				for(var n in obj){return false} 
				return true;
			} 
		});
		
</script>
<?php
	$attributes = array('id' => 'postform');
	echo form_open(current_url(),$attributes);
?>
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
  <?php if($special!=1){?>
  <tr>
    <td>
		<?php $this->load->view($special_post);?>
    </td>
    <td style="color:#F00;"><?php echo form_error('subject'); ?></td>
  </tr>
  <?php }?>
  <tr>
    <td><textarea name="content" style="width:700px;height:360px;visibility:hidden;"><?php echo $this->posts_model->smiley2html(set_value('content', '填写帖子内容')); ?></textarea></td>
    <td style="color:#F00;"><?php echo form_error('content'); ?></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="发布" />
  <input class="inp_btn3" name="submit" type="submit" value="保存草稿" style=" margin-left:39px;" />
</p>
<?php echo form_close() ?>