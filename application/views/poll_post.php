
<li class="voteBox">    
  <div class="voteBoxTit"><strong>投票选项：</strong>(最多可选50项)</div>
  <div class="voteBoxL">
    <ol>
    <?php if(!empty($_POST['poll_option'])){?>
		<?php foreach($_POST['poll_option'] as $option){?>
        <li>
            <input name="poll_option[]" class="inp" value="<?php echo set_value('poll_option[]', ''); ?>">
            <?php if($type != 'edit'){?>
            	<span class="btnCls">关闭</span>
            <?php }?>
        </li>
        <?php } ?>
    <?php }else{ ?>
      <li>
      	<input name="poll_option[]" class="inp" value="<?php echo set_value('poll_option[]', ''); ?>">
        <span class="btnCls">关闭</span>
      </li>
      <li>
        <input name="poll_option[]" class="inp" value="<?php echo set_value('poll_option[]', ''); ?>">
        <span class="btnCls">关闭</span>
      </li>              
      <li>
        <input name="poll_option[]" class="inp" value="<?php echo set_value('poll_option[]', ''); ?>">
        <span class="btnCls">关闭</span>
      </li>
    <?php } ?>
    </ol>
    <div class="btnAddBox"><i class="btnAddVote"></i>增加一个选项</div>
  </div>
  <div class="voteBoxR">
    <ul>
      <li>
        <span>最多可选：</span>
        <input type="text" class="inp" value="<?php echo set_value('max_choices', 1); ?>" name="max_choices">
        <label>项</label>
      </li>
      <li>
        <span>持续时间：</span>
        <input type="text" class="inp" value="<?php echo set_value('expire_time', 1); ?>" name="expire_time">
        <label>天</label>
      </li>
      <li>
        <span>投票后可查看结果：</span>
        <input id="is_visible" type="hidden" value="<?php echo set_value('is_visible', 0); ?>" name="is_visible">
        <i></i>
      </li>
      <li>
        <span>公开投票人信息：</span>
        <input id="is_overt" type="hidden" value="<?php echo set_value('is_overt', 1); ?>" name="is_overt">
        <i></i>
      </li>
    </ul>
  </div>
</li>
<script>
$(function(){
	var is_overt = $('#is_overt'),
		is_visible = $('#is_visible'),
	    overtclass = is_overt.val()==0?'btnUnCheck':'btnCheck',
		visibleclass = is_visible.val()==0?'btnUnCheck':'btnCheck',
		changeCls = function(obj,currentCls){
				var newCls = currentCls == 'btnUnCheck'?'btnCheck':'btnUnCheck';
				obj.removeClass(currentCls);
				obj.addClass(newCls);
				var newval = currentCls == 'btnUnCheck'?1:0;
				obj.prev().val(newval);
			};
	is_overt.next().addClass(overtclass).click(function(){
		changeCls($(this),$(this).attr('class'));
	});
	is_visible.next().addClass(visibleclass).click(function(){
		changeCls($(this),$(this).attr('class'));
	});
	
	$('.btnAddVote').click(function() {
		var html = '<li><input name="poll_option[]" class="inp" value=""><span class="btnCls">关闭</span></li>';
		$(".voteBoxL ol").append(html);
	});
	
	$('.btnCls').live('click',function() {
		if( $('.voteBoxL li').length > 1 ) {
			$(this).parent().remove();
			return false;
		}else{
			$.Alert('至少需要保留一个');	
		}
	});	 
	
})

</script>