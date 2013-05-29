/**
* 添加高亮插件SyntaxHighlighter
*/
KindEditor.plugin('code2', function(K) {
	var self = this, name = 'code2';
	self.clickToolbar(name, function() {
		var lang = self.lang(name + '.'),
			html = ['<div style="padding:10px 20px;">',
				'<div class="ke-dialog-row">',
				'<select class="ke-code-type">',
				'<option value="javascript">javascript</option>',
				'<option value="css">css</option>',
				'<option value="xml">xml</option>',
				'<option value="html">html</option>',
				'<option value="php">php</option>',
				'<option value="text">text</option>',
				'<option value="java">java</option>',
				'<option value="applescript">applescript</option>',
				'<option value="as3">as3</option>',
				'<option value="shell">shell</option>',
				'<option value="coldfusion">coldfusion</option>',
				'<option value="c">c</option>',
				'<option value="csharp">c#</option>',
				'<option value="perl">perl</option>',
				'<option value="python">python</option>',
				'<option value="ruby">ruby</option>',
				'<option value="delphi">delphi</option>',
				'<option value="pascal">pascal</option>',
				'<option value="diff">diff</option>',
				'<option value="erlang">erlang</option>',
				'<option value="groovy">groovy</option>',
				'<option value="javafx">javafx</option>',
				'<option value="sass">sass scss</option>',
				'<option value="scala">scala</option>',
				'<option value="sql">sql</option>',
				'<option value="vb">vb</option>',
				'</select>',
				'</div>',
				'<textarea class="ke-textarea" style="width:408px;height:260px;"></textarea>',
				'</div>'].join(''),
			dialog = self.createDialog({
				name : name,
				width : 450,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
						var type = K('.ke-code-type', dialog.div).val(),
							code = textarea.val(),
							//cls = type === '' ? '' :  ' lang-' + type,
							//html = '<pre class="prettyprint' + cls + '">\n' + K.escape(code) + '</pre> ';
							html = '<pre class="codeprint brush:' + type + ';">' + K.escape(code) + '</pre> ';
						if (K.trim(code) === '') {
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
