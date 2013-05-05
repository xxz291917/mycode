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