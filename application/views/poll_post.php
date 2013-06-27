
<li class="voteBox">    
  <div class="voteBoxTit"><strong>投票选项：</strong>(最多可选50项)</div>
  <div class="voteBoxL">
    <ol>
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
        <input type="text" class="inp" value="<?php echo set_value('expire_time', 0); ?>" name="expire_time">
        <label>天</label>
      </li>
      <li>
        <span>投票后可查看结果：</span>
        <input id="is_visible" type="hidden" value="<?php echo set_value('is_visible', 0); ?>" name="is_visible">
        <i></i>
      </li>
      <li>
        <span>公开投票人信息：</span>
        <input id="is_overt" type="hidden" value="<?php echo set_value('is_overt', 0); ?>" name="is_overt">
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
})

</script>