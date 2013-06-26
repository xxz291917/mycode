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
        <input class="hidden" type="checkbox" value="0"  <?php echo set_radio('is_visible', 0); ?> name="is_visible">
        <i class="btnUnCheck"></i>
      </li>
      <li>
        <span>公开投票人信息：</span>
        <i class="btnCheck"></i>
        <input type="checkbox" class="hidden" value="1" <?php echo set_radio('is_overt', 1); ?> name="is_overt">
      </li>
    </ul>
  </div>
</li>