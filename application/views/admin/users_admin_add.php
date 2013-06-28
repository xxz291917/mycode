<h3>添加后台管理员</h3>
<p class="sec_nav">
<a href="<?=base_url().'index.php/admin/users_admin/'?>" ><span>查看管理员</span></a>
<a href="<?=base_url()?>index.php/admin/users_admin/add/" class="on"><span>添加管理员</span></a>
</p>

<?php echo form_open(base_url().'index.php/admin/users_admin/add/')?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col>
  </colgroup>
  <tr class="split">
    <td colspan="3">基本信息</td>
  </tr>
  <tr>
    <th>用户名</th>
    <td><input class="inp_txt" name="username" type="text" value="" /></td>
    <td>必须是前台已经存在的用户名。</td>
  </tr>
  <tr>
    <th>email</th>
    <td><input class="inp_txt" name="email" type="text" value="" /></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <th>重置密码</th>
    <td><input class="inp_txt" name="password" type="password" value="" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>再次输入密码</th>
    <td><input class="inp_txt" name="repassword" type="password" value="" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="添加" />
</p>
<?php echo form_close() ?>