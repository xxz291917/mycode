
<h3>勋章详情：
  <?=$data['name']?>
</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/medals/" ><span>&nbsp;&nbsp;管理&nbsp;&nbsp;</span></a>
<a href="<?=current_url()?>" class="on" ><span>&nbsp;&nbsp;详情&nbsp;&nbsp;</span></a>
<a href="<?=base_url()?>index.php/admin/medals/award"><span>手动颁发</span></a>

</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(current_url())?>
<input name="id" type="hidden" value="<?php echo my_set_value('id', $data)?>" />
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="500">
  </colgroup>
  <tr class="split">
    <td colspan="3">详情设置</td>
  </tr>
  <tr>
    <th>名称</th>
    <td><input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo my_set_value('name', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >勋章图片</th>
	<td ><input type="text" class="inp_txt" name="image" value="<?php echo my_set_value('image', $data)?>" > <img style="vertical-align:middle" src="<?php echo base_url('/images/medals/'.my_set_value('image', $data));?>"></td>
    <td >多个版主请用英文的逗号、分号或者空格来分隔。</td>
  </tr>
  <tr>
    <th >领取方式</th>
    <td>
    <label>
        <input type="radio"  name="type" value="0" <?php echo my_set_radio('type', 0, $data)?>/>
        手动颁发</label>
    <label>
        <input type="radio"  name="type" value="1" <?php echo my_set_radio('type', 1, $data)?>/>
        自动颁发</label>
    <!--
    <label>
        <input type="radio"  name="type" value="2" <?php echo my_set_radio('type', 2, $data)?>/>
        申请颁发</label>-->
    </td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >勋章有效期</th>
    <td><input type="text" value="<?php echo my_set_date('expired_time',$data,'Y-m-d');?>" class="inp_txt" name="expired_time"></td>
    <td ></td>
  </tr>
  <tr>
    <th >勋章描述</th>
    <td ><input type="text" class="inp_txt" name="description" value="<?php echo my_set_value('description', $data)?>" ></td>
    <td ></td>
  </tr>
  <tr>
    <th >勋章领取条件</th>
    <td>
    <?php
	foreach($medal_tags as $val){
		echo '<input type="button" class="inp_btn2" value="'.$val[0].'" con="'.$val[1].'" /> ';
		}?>
	<br/><textarea id="condition" style="margin-top:5px; width:360px;" cols="105" name="condition" rows="3" class="textarea"><?php echo my_set_value('condition', $data)?></textarea>
    </td>
    <td> 只有在领取方式，设置为自动颁发的时候，才有效。如 "posts > 100 and extcredits1 > 10" 表示 "发帖数 > 100 并且 威望 > 10"
日期格式 "{Y-M-D}"，如 "{2009-10-1}"。IP 格式 "{x.x.x.x}"，既可输入完整地址，也可只输入 IP 开头，如 "{10.0.0.1}"、"{192.168.0}" </td>
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
	var condition = $('#condition');
	$('.inp_btn2').click( function () { 
		var con = $(this).attr('con');
		var val = condition.val();
		condition.val(val+con);
	});
	
})
</script>