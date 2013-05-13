<h3>编辑版块：<?=$data['name']?></h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a> 
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access" class="on"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit"><span>积分设置</span></a> 
</p>

<?php echo form_open(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
<table class="table fspan">
  <colgroup>
  <col style="width:200px;"></col>
  <col></col>
  <col></col>
  <col></col>
  <col></col>
  <col></col>
  </colgroup>
  <thead>
  <tr>
  	<th >用户组</th>
    <th ><input type="checkbox" class="checkbox" set="allow_visit">浏览版块</th>
    <th ><input type="checkbox" class="checkbox" set="allow_read">浏览帖子</th>
    <th ><input type="checkbox" class="checkbox" set="allow_post">发布主题</th>
    <th ><input type="checkbox" class="checkbox" set="allow_reply">主题回复</th>
    <th ><input type="checkbox" class="checkbox" set="allow_upload">上传附件</th>
    <th ><input type="checkbox" class="checkbox" set="allow_download">下载附件</th>
  </tr>
  </thead>
  <?php
  	$current_type = '';
	foreach($groups as $group){
		if($group['type']!=$current_type){
			$current_type = $group['type'];
	  ?>
  <tr class="split">
    <td colspan="7"><?=$group_names[$current_type]?> </td>
  </tr>
  <?php }?>
  <tr>
    <td ><input type="checkbox" class="checkbox" set="<?=$group['id']?>" ><?=$group['name']?></td>
    <td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_visit', $group['id'], $data)?> name="allow_visit[]"></td>
    <td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_read', $group['id'], $data)?> name="allow_read[]"></td>
	<td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_post', $group['id'], $data)?> name="allow_post[]"></td>
	<td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_reply', $group['id'], $data)?> name="allow_reply[]"></td>
    <td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_upload', $group['id'], $data)?> name="allow_upload[]"></td>
    <td ><input type="checkbox" class="checkbox" value="<?=$group['id']?>" <?php echo my_set_checkbox('allow_download', $group['id'], $data)?> name="allow_download[]"></td>
  </tr>
  <?php }?>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>
<script type="text/javascript">
$(document).ready(function() {
	$('input[set]').click(function(){
		var that = $(this),set = that.attr('set');
			if(/\d+/.test(set)){
				$("input[value='"+set+"']").attr('checked',this.checked);
			}else{
				$("input[name='"+set+"[]']").attr('checked',this.checked);
			}
		});
	});
</script>