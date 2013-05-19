<form action="<?php echo base_url('index.php/topic/manage/' . $action);?>" method="post" id="topic_manage">
<input type="hidden" name="submit" value="1">
<input type="hidden" name="topic_id" value="<?=$topic_id?>">
<table class="table2" width="400px">
  <colgroup>
  <col width="80">
  <col width="350">
  </colgroup>
  <tr class="split">
    <td colspan="2">选择了(<span><?php echo $count;?></span>篇)</td>
  </tr>
  
  <?php if(in_array($action,array('top','',''))){}?>
  <tbody>
  <tr>
    <th>置顶</th>
    <td><select name="top" class="select" >
                <option value="1">本版置顶</option>
                <option value="2">分类置顶</option>
                <option value="3">全局置顶</option>
                <option value="0">取消置顶</option>
              </select></td>
  </tr>
  <tr>
    <th>有效期</th>
    <td><input type="text" value="<?php echo my_set_date('end_time',$top=array(),'Y-m-d');?>" class="inp_txt" name="end_time"></td>
  </tr>
  <tr>
    <th>原因</th>
    <td>
    <textarea cols="45" name="reason" rows="3" class="textarea"><?php echo my_set_value('reason', array())?></textarea>
    </td>
  </tr>
  </tbody>
  
</table>
<p class="div_bottom">
  <input class="inp_btn" type="submit" value="提交" />
</p>
</form>
<script type="text/javascript">
$(function(){
	$("input[name^='end_time']",$("#topic_manage")).datepicker({
		dateFormat:'yy-mm-dd'
	});
});
</script>