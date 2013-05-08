<h3>编辑用户：
  <?=$data['username']?>
</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/basic"><span>基本信息</span></a>
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/credit" class="on"><span>积分</span></a>
<a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/group"><span>用户组</span></a>
</p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(base_url().'index.php/admin/users/edit/'.$data['id'].'/credit')?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col>
  </colgroup>
  <tr class="split">
    <td colspan="3">积分设置</td>
  </tr>
  <tr>
    <th>用户名</th>
    <td><?php echo set_value('username',$data);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>总积分</th>
    <td><?php echo set_value('credits',$data);?></td>
    <td></td>
  </tr>
  <?php foreach($credit_names as $credit){?>
  <tr>
    <th><?=$credit['view_name']?></th>
    <td><input class="inp_txt inp_long_num" name="<?=$credit['credit_x']?>" type="text" value="<?=$users_extra[$credit['credit_x']]?>" />
    <td></td>
  </tr>
  <?php }?>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>