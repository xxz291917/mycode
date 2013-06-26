
<li class="viewpoint">
  <div class="viewpointBlk">
    <h5 class="fyahei">红方观点</h5>
    <textarea class="inp" id="affirm_point" name="affirm_point"><?php echo set_value('affirm_point', ''); ?></textarea>
  </div>          
  <div class="viewpointBlk">
    <h5 class="fyahei cblue">蓝方观点</h5>
    <textarea class="inp" id="negate_point" name="negate_point"><?php echo set_value('negate_point', ''); ?></textarea>
  </div>
  <div class="viewpointLi">
    <label>结束时间：</label>
    <input type="text" value="<?php echo set_value('end_time', ''); ?>" class="inp" id="end_time" name="end_time">
  </div>
  <div class="viewpointLi">
    <label>选定裁判：</label>
    <input type="text" tabindex="1" value="<?php echo set_value('umpire', ''); ?>" class="inp" id="umpire" name="umpire">
  </div>
  
</li>

<script type="text/javascript">
$(function(){
  $("input[name^='end_time']").datepicker({
	dateFormat:'yy-mm-dd'
	});
});
</script>