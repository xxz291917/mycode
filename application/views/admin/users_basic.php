<h3>编辑用户：
  <?=$data['username']?>
</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/basic" class="on"><span>基本信息</span></a>
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/credit"><span>积分</span></a>
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/group"><span>用户组</span></a>
</p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open_multipart(base_url().'index.php/admin/users/edit/'.$data['id'])?>
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
    <td><?php echo my_set_value('id',$data);?></td>
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
    <th>头像</th>
    <td><img name="" src="" alt="用户头像" /></td>
    <td></td>
  </tr>
  <tr>
    <th>用户签名</th>
    <td>
	<textarea cols="45" name="signature" rows="3" class="textarea"><?php echo my_set_value('signature', $data)?></textarea>
    </td>
    <td></td>
  </tr>
  <tr>
    <th>性别</th>
    <td><label>
        <input type="radio"  name="gender" value="1" <?php echo my_set_radio('gender', 1, $data)?>/>
        男</label>
      <label>
        <input type="radio"  name="gender" value="0" <?php echo my_set_radio('gender', 0, $data)?>/>
        女</label></td>
    <td></td>
  </tr>
  <tr>
    <th>用户状态</th>
    <td><label>
        <input type="radio"  name="status" value="1" <?php echo my_set_radio('status', 1, $data)?>/>
        正常</label>
      <label>
        <input type="radio"  name="status" value="2" <?php echo my_set_radio('status', 2, $data)?>/>
        删除</label>
        <label>
        <input type="radio"  name="status" value="3" <?php echo my_set_radio('status', 3, $data)?>/>
        锁定</label></td>
    <td></td>
  </tr>
  <tr>
    <th>最后登录时间</th>
    <td><?php echo my_set_date('regdate',$data);?></td>
    <td></td>
  </tr>

</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>