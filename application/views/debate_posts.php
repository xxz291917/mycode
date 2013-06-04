<div class="exfm cl">
<div class="sinf sppoll z">
<dl>
<dt><span class="rq">*</span><label for="affirm_point">正方观点:</label></dt>
<dd><textarea style="width:210px;" tabindex="1" class="pt" id="affirm_point" name="affirm_point"><?php echo set_value('affirm_point', ''); ?></textarea><?php echo form_error('affirm_point'); ?></dd>
<dt><span class="rq">*</span><label for="negate_point">反方观点:</label></dt>
<dd><textarea style="width:210px;" tabindex="1" class="pt" id="negate_point" name="negate_point"><?php echo set_value('negate_point', ''); ?></textarea><?php echo form_error('negate_point'); ?></dd>
</dl>
</div>
<div class="sadd z">
<dl>
<dt><label for="endtime">结束时间:</label></dt>
<dd class="hasd cl">
<input type="text" tabindex="1" value="<?php echo set_value('end_time', ''); ?>" autocomplete="off" class="px" id="end_time" name="end_time"><?php echo form_error('end_time'); ?>
</dd>
<dt><label for="umpire">裁判:</label></dt>
<dd>
<p><input type="text" tabindex="1" value="<?php echo set_value('umpire', ''); ?>" class="px" id="umpire" name="umpire"><span id="checkuserinfo"><?php echo form_error('umpire'); ?></span></p>
</dd>
</dl>
</div>
</div>
<script type="text/javascript">
$(function(){
  $("input[name^='end_time']").datepicker({
	dateFormat:'yy-mm-dd'
	});
});
</script>