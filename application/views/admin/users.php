
<h3>用户管理</h3>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->

<h4>搜索用户</h4>
<form name="search" method="get" action="<?=current_url()?>" class="form row">
  <fieldset>
    <div>
      <label for="url">用户组：</label>
      <select name="groups[]" size="5" multiple="multiple" class="select">
        <?=$groups_option?>
      </select>
    </div>
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
<?php //echo set_value('seo_title', $data) ?>
<table class="table">
  <colgroup>
  <col width="100">
  <col width="150">
  <col width="200">
  <col width="200">
  <col width="200">
  <col>
  </colgroup>
  <thead>
    <tr>
      <th>UID</th>
      <th>用户名</th>
      <th>电子邮箱</th>
      <th>注册时间</th>
      <th>最后登录时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	!isset($users) && $users = array();
	foreach ($users as $key => $user) {?>
    <tr>
      <td><?= $user['id'] ?></td>
      <td><?= $user['username'] ?></td>
      <td><?= $user['email'] ?></td>
      <td><?= date($date_format,$user['regdate']) ?></td>
      <td><?= date($date_format,$user['regdate']) ?></td>
      <td><a href="<?= base_url() ?>index.php/admin/users/edit/<?= $user['id'] ?>">[编辑]</a> <a href="<?= base_url() ?>index.php/admin/groups/admin_edit/<?= $user['id'] ?>">[禁止]</a> <a href="#" class = "del" gid="<?= $user['id'] ?>">[清理]</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<?php echo $page;?>

<?php echo form_close() ?> 