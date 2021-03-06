/**
* 添加高亮插件SyntaxHighlighter
*/
KindEditor.plugin('quote', function(K) {
	var self = this, name = 'quote';
	self.clickToolbar(name, function() {
		var lang = self.lang(name + '.'),
			html = ['<div style="padding:10px 20px;">',
				'<textarea class="ke-textarea" style="width:318px;height:200px;"></textarea>',
				'</div>'].join(''),
			dialog = self.createDialog({
				name : name,
				width : 360,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
						var type = K('.ke-code-type', dialog.div).val(),
							content = textarea.val(),
							html = '<blockquote class="blockquote">' + K.escape(content) + '</blockquote> <br/>';
						if (K.trim(content) === '') {
							alert(lang.pleaseInput);
							textarea[0].focus();
							return;
						}
						self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			textarea = K('textarea', dialog.div);
		textarea[0].focus();
	});
});
