<h3>勋章管理</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/medals" class="on"><span>&nbsp;&nbsp;管理&nbsp;&nbsp;</span></a>
<a href="<?=base_url()?>index.php/admin/medals/award"><span>手动颁发</span></a>
</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(current_url())?>
<table class="table fspan" id="act_table">
  <thead>
    <tr>
      <th>显示顺序</th>
      <th>可用</th>
      <th>名称</th>
      <th>描述</th>
      <th>勋章图片</th>
      <th>领取方式</th>
      <th></th>
    </tr>
  </thead>
  <?php 
  
  foreach($medals as $medal){ ?>
  <tr cid="<?=$medal['id'] ?>">
    <td ><input type="text" class="inp_txt inp_num" name="old[<?=$medal['id'] ?>][display_order]" value="<?php echo my_set_value('display_order', $medal)?>" ></td>
    <td ><input type="checkbox" class="checkbox" name="old[<?=$medal['id'] ?>][is_open]" value="1" <?php echo my_set_radio('is_open', 1, $medal)?> ></td>
    <td ><input type="text" class="inp_txt" name="old[<?=$medal['id'] ?>][name]" value="<?php echo my_set_value('name', $medal)?>" ></td>
    <td ><input type="text" class="inp_txt" name="old[<?=$medal['id'] ?>][description]" value="<?php echo my_set_value('description', $medal)?>" ></td>
    <td ><input type="text" class="inp_txt" name="old[<?=$medal['id'] ?>][image]" value="<?php echo my_set_value('image', $medal)?>" > <img style="vertical-align:middle" src="<?php echo base_url('/images/medals/'.my_set_value('image', $medal));?>"></td>
    <td ><?=$type_names[$medal['type']]?></td>
    <td ><a href="<?=base_url()?>index.php/admin/medals/detail/<?=$medal['id']?>">[详情]</a> <a href="#" class = "del">[删除]</a></td>
  </tr>
  <?php }?>
  
    <tbody id="line_group">
    <tr>
      <td style="padding-left:38px;" colspan="4"><input type="button" id="add_medal" value="+添加新勋章" class="inp_btn2"/></td>
    </tr>
    </tbody>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>



<script type="text/javascript">
    $(function() {
		$("#add_medal").live('click',function(){
			//得到点击者以及点击者的fid和级别。
			var group = $("#line_group");
			var html = getHtml();
			group.before(html);
			return false;
		});
		var global_id = 0;
		function getHtml(){
			global_id++;
			var new_id = 'new_'+global_id;
			return '<tr cid="'+new_id+'">\
					<td ><input type="text" class="inp_txt inp_num" name="new['+ new_id +'][display_order]" value="" ></td>\
					<td ><input type="checkbox" class="checkbox" name="new['+ new_id +'][is_open]" value="1" ></td>\
					<td ><input type="text" class="inp_txt" name="new['+ new_id +'][name]" value="" ></td>\
					<td ><input type="text" class="inp_txt" name="new['+ new_id +'][description]" value="" ></td>\
					<td ><input type="text" class="inp_txt" name="new['+ new_id +'][image]" value="" ></td>\
					<td ></td>\
					<td><a href="#" class = "del">[删除]</a></td>\
				</tr>';
		}
		
		//删除勋章
		$('.del',$('#act_table')).live('click',function (e) {
			e.preventDefault();
			var that = this;
			$.Confirm('确定要删除此勋章么？','',function(){
				var currentTr = $(that).parents('tr'),
					cid = currentTr.attr('cid');
				//ajax发送请求，判断是否删除
				$.post(base_url+"index.php/admin/medals/delete", { "id": cid },
					function(data){
							if(data.success==1){
									currentTr.remove();
							}else{
									$.Alert(data.message,'删除勋章');
							}
					}, "json");
			});
		});
		
    });
</script>