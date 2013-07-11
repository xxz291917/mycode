jQuery.extend(jQuery, {
    creatHTML: function(text) {
        if ($("#dialog-message").length > 0) {
            var html = $("#dialog-message").html(text);
        } else {
            var html = $('<div id="dialog-message">' + text + '</div>');
        }
        return html;
    },
    Alert: function(text, title, options) {
        var html = this.creatHTML(text);
        return html.dialog(
			$.extend({
				resizable: false,
				modal: true,
				title: title || "提示信息",
				buttons: {
					"确定": function() {
						$(this).dialog("close");
					}
				}
			}, options)
		);
    },
    Confirm: function(text, title, fn) {
        var html = this.creatHTML(text);
        html.dialog({
            resizable: false,
            modal: true,
            title: title || "确认信息",
            buttons: {
                "确定": function() {
                    $(this).dialog("close");
                    if (fn && $.isFunction(fn)) {
                        fn();
                    }
                },
                "取消": function() {
                    $(this).dialog("close");
                }
            }
        });
    }
});


$(function(){
	//弹出框A链接扩展
	$("a[target=dialog]").each(function(){
		$(this).click(function(event){
			superDialog(event,$(this));
		});
	});
	$("form[target=dialog]").each(function(){
		$(this).submit(function(event){
			superDialog(event,$(this));
		});
	});
	var superDialog = function(event,$this){
			var tagName = gettagname(event);
			var title = $this.attr("title") || $this.text()||'';
			var rel = $this.attr("rel") || "my_dialog";
			var refresh = $this.attr("refresh") || false;
			var options = {
				title: title,
				modal: true,
				resizable: false,
				width: '400',
				close: function(event, ui) {
						// 关闭时销毁
						$(this).dialog("destroy");
						if(refresh){//是否需要刷新窗口？
							window.location.reload();
						}
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
			if(tagName=='A'){
				var url = unescape($this.attr("href"));
				var field = null;
                                var ajaxFun = $.get;
			}else if(tagName=='FORM'){
				var url = unescape($this.attr("action"));
				var field = $this.serializeArray();
                                var ajaxFun = $.post;
			}
			
			if ($("#"+rel).length > 0) {
				var html = $("#"+rel);
			} else {
				var html = '<div id="'+rel+'" title="提示信息"></div>';
				html = $(html);
			}
                        //$.Alert('正在努力……');
                        ajaxFun(url, field,function(data){
                            
                            if(data.substr(0,1)=='{'){
                                data = JSON.parse(data);
                            }
                            if(typeof data == 'object'){
                                $.Alert(data.message);
                            }else{
                                html.html(data);
                                //为一个表单添加ajax提交。
				var form = $('#' + rel).find("form");
				if(form.length>0){
					form.submit(function() {
						var action = form.attr('action'),
							method = form.attr('method'),
							fields = form.serialize(),
							ajaxFun = method=='post'?$.post:$.get;
						ajaxFun(action,fields,function(data){
							if(data.redirect){
								var options = {buttons: {
									"确定": function() {
											$(this).dialog("close");
											window.location.href = data.redirect;
										}
								}};
							}else{
								var options = {};
							}
							
							if(!data.success){
								$.Alert(data.message,'',options);
							}else{
								$.Alert(data.message,'',options);
								html.dialog("close");
							}
						},'json');
						return false;
					});
				}
                                html.dialog(options);
                            }
                        });
			event.preventDefault();
			return false;
		};
	
	//弹出框A链接扩展
	$("a[target=ajax]").each(function(){
		$(this).click(function(event){
			superAjax(event,$(this));
		});
	});
	$("form[target=ajax]").each(function(){
		$(this).submit(function(event){
			superAjax(event,$(this));
		});
	});
	var superAjax = function(event,$this){
		var tagName = gettagname(event);
		var refresh = $this.attr("refresh") || false;
		var confirm = $this.attr("confirm") || false;
		var title = $this.attr("title") || $this.text()||'';
		if(tagName=='A'){
			var url = unescape($this.attr("href")),
			    fields = null,
				ajaxFun = $.get;
		}else if(tagName=='FORM'){
			var url = unescape($this.attr("action")),
				method = $this.attr('method'),
				fields = $this.serialize(),
				ajaxFun = method=='post'?$.post:$.get;
		}
		var handle = function(){
			$.Alert('正在努力……');
			ajaxFun(url,fields,function(data){
				var options = {buttons: {
						"确定": function() {
									$(this).dialog("close");
									if(refresh){
										window.location.reload();
									}
								}
					}};
				if(!data.success){
					$.Alert(data.message,title);
				}else{
					$.Alert(data.message,title,options);
				}
			},'json');
		}
		if(confirm){
			$.Confirm(confirm, title, handle);
		}else{
			handle();
		}
		event.preventDefault();
		return false;
	};

	function gettagname(e){
		if (!e) var e = window.event;
		if (e.target) targ = e.target;
		else if (e.srcElement) targ = e.srcElement;
		if (targ.nodeType == 3)// defeat Safari bug
		   targ = targ.parentNode
		return targ.tagName;
	}

});