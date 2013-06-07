jQuery.extend(jQuery, {
    creatHTML: function(text) {
        if ($("#dialog-message").length > 0) {
            var html = $("#dialog-message").html(text);
        } else {
            var html = $('<div id="dialog-message">' + text + '</div>');
        }
        return html;
    },
    Alert: function(text, title) {
        var html = this.creatHTML(text);
        return html.dialog({
            resizable: false,
            modal: true,
            title: title || "提示信息",
            buttons: {
                "确定": function() {
                    $(this).dialog("close");
                }
            }
        });
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
    },
  // jQuery UI alert弹出提示,一定间隔之后自动关闭
  jTimerAlert: function(text, title, fn, timerMax) {
    var dd = $(
    '<div class="dialog" id="dialog-message">' +
    '  <p>' +
    '    <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 0 0;"></span>' + text +
    '  </p>' +
    '</div>');
    dd[0].timerMax = timerMax || 3;
    return dd.dialog({
      //autoOpen: false,
      resizable: false,
      modal: true,
      show: {
        effect: 'fade',
        duration: 300
      },
      open: function(e, ui) {
        var me = this,
          dlg = $(this),
          btn = dlg.parent().find(".ui-button-text").text("确定(" + me.timerMax + ")");
        --me.timerMax;
        me.timer = window.setInterval(function() {
          btn.text("确定(" + me.timerMax + ")");
          if (me.timerMax-- <= 0) {
            dlg.dialog("close");
            fn && fn.call(dlg);
            window.clearInterval(me.timer); // 时间到了清除计时器
          }
        }, 1000);
      },
      title: title || "提示信息",
      buttons: {
        "确定": function() {
          var dlg = $(this).dialog("close");
          fn && fn.call(dlg);
          window.clearInterval(this.timer); // 清除计时器
        }
      },
      close: function() {
        window.clearInterval(this.timer); // 清除计时器
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
				var field = {};
			}else if(tagName=='FORM'){
				var url = unescape($this.attr("action"));
				var field = $this.serializeArray();
			}
			var html = '<div id="'+rel+'" title="提示信息"></div>';
			html = $(html);
			html.load(url,field, function() {
				//为一个表单添加ajax提交。
				var form = $('#' + rel).find("form");
				if(form.length>0){
					form.submit(function() {
						var action = form.attr('action'),
							method = form.attr('method'),
							fields = form.serialize(),
							ajaxFun = method=='post'?$.post:$.get;
						ajaxFun(action,fields,function(data){
							if(!data.success){
								alert(data.message);
							}else{
								alert(data.message);
								html.dialog("close");
							}
						},'json');
						return false;
					});
				}
			});
			html.dialog(options);
			event.preventDefault();
			return false;
		};
	
	//ajaxA链接扩展
	$("a[target=ajax]").each(function(){
		$(this).click(function(event){
			var $this = $(this);
			$.get($this.attr("href"), function(data){
				if(!data.success){
					alert(data.message);
				}else{
					alert(data.message);
					html.dialog("close");
				}
			},'json');
			event.preventDefault();
		});
	});

	function gettagname(e){
		if (!e) var e = window.event;
		if (e.target) targ = e.target;
		else if (e.srcElement) targ = e.srcElement;
		if (targ.nodeType == 3)// defeat Safari bug
		   targ = targ.parentNode
		return targ.tagName;
	}

});