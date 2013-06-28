<h3>管理员管理</h3>
<p class="sec_nav">
<a href="<?=base_url().'index.php/admin/users_admin/'?>" class="on"><span>查看管理员</span></a>
<a href="<?=base_url()?>index.php/admin/users_admin/add/"><span>添加管理员</span></a>
</p>
<h4>搜索</h4>
<form name="search" method="get" action="<?=current_url()?>" class="form row">
  <fieldset>
    <div>
      <label for="username">用户名：</label>
      <input name="username" type="text" class="inp_txt" value="<?php echo my_set_value('username',$data);?>" />
    </div>
    <div>
      <label for="email">email：<em class="feedback"></em></label>
      <input name="email" class="inp_txt" type="text" value="<?php echo my_set_value('email',$data);?>" />
    </div>
    <div>
      <label>&nbsp;</label>
      <input class="inp_btn" name="submit" type="submit" value="搜索" />
    </div>
  </fieldset>
</form>
<?php echo form_open(base_url() . 'index.php/admin/groups/index/') ?>
<table class="table" id="act_table">
  <colgroup>
  <col width="100">
  <col width="150">
  <col width="200">
  <col>
  </colgroup>
  <thead>
    <tr>
      <th>UID</th>
      <th>用户名</th>
      <th>电子邮箱</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	!isset($users) && $users = array();
	foreach ($users as $key => $user) {?>
    <tr uid="<?= $user['user_id'] ?>">
      <td><?= $user['user_id'] ?></td>
      <td><?= $user['username'] ?></td>
      <td><?= $user['email'] ?></td>
      <td>
       <a href="<?= base_url() ?>index.php/admin/users_admin/edit/<?= $user['user_id'] ?>">[修改密码]</a>
       <a href="#" class="del">[删除]</a>
       </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php echo $page;?>

<?php echo form_close() ?> 

<script type="text/javascript">
    $(function() {
		//删除
		$('.del',$('#act_table')).live('click',function (e) {
			e.preventDefault();
			var that = this;
			$.Confirm('确定要删除此管理员么？','',function(){
				var currentTr = $(that).parents('tr'),
					uid = currentTr.attr('uid');
				//ajax发送请求，判断是否删除
				$.post(base_url+"index.php/admin/users_admin/delete", { "user_id": uid },
					function(data){
							if(data.success==1){
									currentTr.remove();
							}else{
									$.Alert(data.message,'删除管理员');
							}
					}, "json");
			});
		});
		
    });
</script>