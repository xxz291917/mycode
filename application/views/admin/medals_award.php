
<h3>勋章颁发
</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/medals/" ><span>&nbsp;&nbsp;管理&nbsp;&nbsp;</span></a>
<a href="<?=base_url()?>index.php/admin/medals/award" class="on" ><span>手动颁发</span></a>

</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(current_url())?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="200">
  </colgroup>
  <tr class="split">
    <td colspan="3">颁发</td>
  </tr>
  <tr>
    <th>用户名</th>
    <td><input maxlength="30" class="inp_txt" name="user_name" type="text" value="" /></td>
    <td >多个用户请用空格来分隔。</td>
  </tr>
  <tr>
    <th >手动颁发勋章</th>
    <td>
        <div class="cross">
        <ul id="J_u_group_default">
          <?php foreach($medals as $medal){?>
          	<li style="height:32px">
            <span class="span_3">
            <label>
            <input type="checkbox" value="<?=$medal['id']?>" name="medals[]" class="checkbox" />
              <?=$medal['name']?></label>
            </span>
            <img style="vertical-align:middle" src="<?php echo base_url('/images/medals/'.my_set_value('image', $medal));?>">
            </li>
           <?php }?>
        </ul>
        </div>
    </td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >勋章有效期</th>
    <td><input type="text" value="" class="inp_txt" name="expired_time"></td>
    <td >为0或者不为有效日期，则表示不限制。</td>
  </tr>
  <tr>
    <th >颁发原因</th>
    <td >
    <textarea name="description" rows="3" class="textarea"></textarea></td>
    <td ></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>

<script type="text/javascript">
$(function(){
	$("input[name='expired_time']").datepicker({
		dateFormat:'yy-mm-dd'
	});
})
</script>