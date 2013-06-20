<h3>编辑版块：<?=$data['name']?></h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a> 
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/category" class="on"><span>主题分类</span></a> 
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit"><span>积分设置</span></a> 
</p>

<?php echo form_open(base_url().'index.php/admin/forums/edit/'.$data['id'].'/category/')?>
<table class="table2">
  <colgroup>
    <col class="th" />
    <col width="300" />
  </colgroup>
  <tr class="split">
    <td colspan="3">主题分类</td>
  </tr>
  <tr>
    <th>版块名称</th>
    <td><input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo my_set_value('name', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >是否启用主题分类</th>
    <td><label>
      <input type="radio"  name="is_category" value="1" <?php echo my_set_radio('is_category', 1, $data)?>/>
      是</label>
      <label>
        <input type="radio"  name="is_category" value="0" <?php echo my_set_radio('is_category', 0, $data)?>/>
        否</label></td>
    <td> </td>
  </tr>
  <tr>
    <th >主题分类是否必选</th>
    <td><label>
      <input type="radio"  name="is_cat_necessary" value="1" <?php echo my_set_radio('is_cat_necessary', 1, $data)?>/>
      是</label>
      <label>
        <input type="radio"  name="is_cat_necessary" value="0" <?php echo my_set_radio('is_cat_necessary', 0, $data)?>/>
        否</label></td>
    <td> </td>
  </tr>
</table>

<table  class="table" id="act_table">
  <colgroup>
  <col width="430" />
  <col width="170" />
  <col />
  </colgroup>
<thead>
<tr>
  <th><span >[顺序]</span>分类名称</th>
  <th>只管理员可用</th>
  <th>操作</th>
</tr>
</thead>

<?php foreach($categorys as $k=>$v){?>
<tr cid="<?=$k?>">
  <td>
    <input type="text" name="old[<?=$k?>][display_order]" value="<?php echo $v['display_order']?>" class="inp_txt inp_num">
    <input type="text" name="old[<?=$k?>][name]" value="<?php echo $v['name']?>" class="inp_txt"></td>
  <td><input type="checkbox"  name="old[<?=$k?>][moderators]" value="1" <?php echo my_set_radio('moderators', 1, $v)?>/></td>
  <td><a href="#" class = "del">[删除]</a></td>
</tr>
<?php }?>

<tbody id="line_group">
<tr>
  <td style="padding-left:38px;" colspan="4"><input type="button" id="add_category" value="+添加新分类" class="inp_btn2"/></td>
</tr>
</tbody>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#add_category").live('click',function(){
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
				  <td>\
					<input type="text" name="new['+ new_id +'][display_order]" value="" class="inp_txt inp_num">\
					<input type="text" name="new['+ new_id +'][name]" value="" class="inp_txt">\
					</td>\
				  <td><input type="checkbox"  name="new['+ new_id +'][moderators]" value="1"/></td>\
				  <td><a href="#" class = "del">[删除]</a></td>\
				</tr>';
	}
	
	//版块删除
	$('.del',$('#act_table')).live('click',function (e) {
		e.preventDefault();
		var that = this;
		$.Confirm('确定要删除此分类么？','',function(){
			var currentTr = $(that).parents('tr'),
				cid = currentTr.attr('cid');
			//ajax发送请求，判断是否删除
			$.post(base_url+"index.php/admin/forums/delete_category", { "id": cid },
				function(data){
						if(data.success==1){
								currentTr.remove();
						}else{
								$.Alert(data.message,'删除主题分类');
						}
				}, "json");
		});
	});
		
});
</script>