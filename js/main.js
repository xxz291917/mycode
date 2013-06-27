/*顶部导航搜索菜单*/
$(document).ready(function() {
	$('.searchBtn').click(function()  {
		$('.nav').animate({
			bottom:'-70px',
			paddingTop:'71px',
			backgroundPosition:'(0 -208px)'
		},300);
		$('.nav h1').animate({
			top:'-60px',
			width:'156px',
			height:'54px'
		},300);
		$('.nav h1 a').animate({
			width:'156px',
			height:'54px',
			backgroundPosition:'(0 -240px)'
		},300);
		$('.searchBox').fadeIn('slow');
		$('.searchBox input').focus();
	});
	$('.searchCls').click(function() {
		$('.nav').animate({
			bottom:0,
			paddingTop:0,
			backgroundPosition:'(0 -279px)'
		},300);
		$('.nav h1').animate({
			top:'4px',
			width:'117px',
			height:'40px'
		},300);
		$('.nav h1 a').animate({
			width:'117px',
			height:'40px',
			backgroundPosition:'(0 0)'
		},300);
		$('.searchBox').fadeOut('slow');
	});
});
//顶部导航下拉菜单
$(document).ready(function() {
	$('.icoUser').hover(function() {
		$(this).addClass('current');
	},function(){
		$(this).removeClass('current');
	});	
});
//正文页左侧头像隐藏层
$(document).ready(function() {
	$('.usFace').hover(function() {
		$(this).find('.usFaceInfoBox').fadeIn();
	},function(){
		$(this).find('.usFaceInfoBox').fadeOut();
	});	
});
//管理菜单下拉菜单
$(document).ready(function() {
	$('.hasMenu').hover(function() {
		$(this).addClass('menuShow');
	},function(){
		$(this).removeClass('menuShow');
	});	
});

//判断文本框的值是否为空，有值的情况就隐藏提示语，没有值就显示
$(document).ready(function() {
	$('.inpTxt').each(function() {
    	var txt = $(this).val();
		$(this).attr('change',0);
    	$(this).focus(function() {
    		if($(this).attr('change') == 0) {
				$(this).val("");
				$(this).addClass('cdgray');
			};
   		}).blur(function() {
    		if($(this).val() == "") {
				$(this).attr('change',0);
				$(this).val(txt);
				$(this).removeClass('cdgray');
			}else{
				$(this).attr('change',1);
			}
   		});  
    }); 
});

/*点击回复下拉层*/
$(document).ready(function() {
	$('.icoReply').toggle(
		function () {
			$('.replyCot').hide();
			$(this).addClass('icoReply2');
			$(this).text('展开回复');
		},
		function () {
			$('.replyCot').show();
			$(this).removeClass('icoReply2');
			$(this).text('收起回复');
		}
	);
});
//滚条提示
var scrollUp;
scrollUp || (scrollUp = {});
(function(a) {
    a.fn.extend({
        returntop: function() {
            if (this[0]) {
                var b = this.click(function() {
                    a('html, body').animate({
                        scrollTop: 0
                    },
                    120)
                }),
                c = null;
                a(window).bind('scroll',
                function() {
                    var d = a(document).scrollTop(),
                    e = a(window).height();
                    0 < d ? b.css('bottom', '100px') : b.css('bottom', '-200px');
                    a.browser.msie && ($.browser.version == '6.0') && (b.hide(), clearTimeout(c), c = setTimeout(function() {
                        b.show();
                        clearTimeout(c)
                    },
                    1E3), b.css('top', d + e - 125))
                })
            }
        }

    })	
})($);
$('.scroll').returntop();
//帖子列表左侧菜单展开效果
$(document).ready(function() {
	$('.leftNav dt a').toggle(	
		function () {
			$(this).parent().parent().addClass('clsLeftNav');	
			//设置左侧隐藏菜单的 cookie
			document.cookie='leftNavState=isHide';		 
		},
		function () {
			$(this).parent().parent().removeClass('clsLeftNav');
		}
	); 
	//获取左侧隐藏菜单的 cookie
	var leftNavState = document.cookie;	
	if( leftNavState = 'isHide') {
		$('.leftNavCtrl').parent().parent().addClass('leftNavShow');
	}
	
});
//帖子列表左侧菜单隐藏效果
$(document).ready(function() {
	$('.leftNavCtrl').toggle(	
		function () {
			$(this).parent().parent().addClass('leftNavShow');
		},
		function () {
			$(this).parent().parent().removeClass('leftNavShow');
		}
	);    
});
//帖子列表右侧最小化规则
$(document).ready(function() {
	$('.boardInfoTop i').toggle(	
		function () {
			$(this).parent().parent().parent().addClass('noticeShow');
		},
		function () {
			$(this).parent().parent().parent().removeClass('noticeShow');
		}
	);    
});
//帖子列表右侧标签切换
$(document).ready(function() {
	$('.listTag a').click(function() {
		$('.listTag li').removeClass('current');
		$(this).parent().addClass('current');
	});    
});
//帖子列表标签切换
$(document).ready(function(){
	var list = $('.listTag a');
	$(".listCotShow li ul:last").addClass('bordNo');
	list.each(function(i){
		var o = $(this);
		o.click(function(){			
			list.removeClass('current');
			o.addClass('current');			
			$('.listCot').removeClass('listCotShow').eq(i).addClass('listCotShow');
			$('.listCotShow li ul:last').addClass('bordNo');
		});
	});
});
//发布投票贴删除添加投票效果
$(document).ready(function() {
	$('.voteBoxL li span.btnCls').live('click',function() {
		if( $('.voteBoxL li').length > 1 ) {
			$(this).parent().remove();
			return false;
		}	
	});	 
	$('.btnAddVote').click(function() {
		$('.voteBoxL li:last').clone().appendTo('ol').find('input').val('');
	}); 
});
//发布投票模拟checkbox
$(document).ready(function() {
	$('.btnUnCheck').toggle(	
		function () {
			$(this).parent().find('input').val('1');
			$(this).removeClass('btnUnCheck').addClass('btnCheck');
			
		},
		function () {
			$(this).parent().find('input').val('0');
			$(this).removeClass('btnCheck').addClass('btnUnCheck');
		}
	); 
	$('.btnCheck').toggle(	
		function () {
			$(this).parent().find('input').val('0');
			$(this).removeClass('btnCheck').addClass('btnUnCheck');
		},
		function () {
			$(this).parent().find('input').val('1');
			$(this).removeClass('btnUnCheck').addClass('btnCheck');
		}
	);    
});










































































