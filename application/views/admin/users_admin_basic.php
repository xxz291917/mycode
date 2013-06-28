<h3>编辑管理员：<?=$data['username']?>
</h3>
<p class="sec_nav">
<a href="<?=base_url().'index.php/admin/users_admin/edit/'.$data['user_id']?>" class="on"><span>重置密码</span></a>
<a href="<?=base_url()?>index.php/admin/users_admin/add/"><span>添加管理员</span></a>
</p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(base_url().'index.php/admin/users_admin/edit/'.$data['user_id'])?>
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
    <th>UID</th>
    <td><?php echo my_set_value('user_id',$data);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>用户名</th>
    <td><?php echo my_set_value('username',$data);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>email</th>
    <td><?php echo my_set_value('email',$data);?></td>
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
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>