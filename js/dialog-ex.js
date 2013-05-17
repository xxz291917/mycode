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
  },
  // jQuery UI 弹出iframe窗口
  jOpen: function(url, options) {
    var html =
    '<div class="dialog" id="dialog-window" title="提示信息">' +
    ' <iframe src="' + url + '" frameBorder="0" style="border: 0; " scrolling="auto" width="100%" height="100%"></iframe>' +
    '</div>';
    return $(html).dialog($.extend({
      modal: true,
      closeOnEscape: false,
      draggable: false,
      resizable: false,
      close: function(event, ui) {
        $(this).dialog("destroy"); // 关闭时销毁
      }
    }, options));
  }
});

var base_url = '<?=base_url()?>';
$(function(){
	//弹出框A链接扩展
	$("a[target=dialog]").each(function(){
		$(this).click(function(event){
			var $this = $(this);
			var title = $this.attr("title") || $this.text();
			var rel = $this.attr("rel") || "my_dialog";
			var fresh = $this.attr("fresh") || false;
			var options = {
				title: title,
				modal: true,
				resizable: false,
				width: '400',
				close: function(event, ui) {
						// 关闭时销毁
						$(this).dialog("destroy");
						if(fresh){//是否需要刷新窗口？
							alert(fresh);
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
			var url = unescape($this.attr("href"));
			/*
			var html =
			'<div id="'+rel+'" title="提示信息">' +
			' <iframe src="' + url + '" frameBorder="0" style="border: 0; " scrolling="auto" width="100%" height="100%"></iframe>' +
			'</div>';
			*/
			var html = '<div id="'+rel+'" title="提示信息"></div>';
			html = $(html);
			html.dialog(options);
			html.load(url,function(){
					var form = $('#my_dialog').find("form");
					form.submit(function(){
						alert(123);
						return false;
					});
				});
			return false;
		});
	});
	
	//为一个表单添加ajax提交。
	var ajaxForm = {
		init:function(id){
			var form = $('#my_dialog');
			alert(form.html());
			form.submit(function(){
				alert(123);
				return false;
				});
			},
		};
	
	
	
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