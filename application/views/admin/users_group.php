<h3>编辑用户：
  <?=$data['username']?>
</h3>
<p class="sec_nav"> <a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/basic"><span>基本信息</span></a> <a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/credit"><span>积分</span></a> <a href="<?=base_url()?>index.php/admin/users/edit/<?=$data['id']?>/group" class="on"><span>用户组</span></a> </p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(base_url().'index.php/admin/users/edit/'.$data['id'].'/group')?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col>
  </colgroup>
  <tr class="split">
    <td colspan="3">所属用户组设置</td>
  </tr>
  <tr>
    <th>用户名</th>
    <td><?php echo set_value('username',$data);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>所属用户组</th>
    <td><select name="group_id" class="select">
        <?=$options?>
      </select></td>
    <td></td>
  </tr>
  <tr>
    <th>扩展用户组</th>
    <td><div class="cross">
        <ul id="J_u_group_default">
          <li> <span class="span_3">用户组</span> <span class="span_3">到期时间</span> </li>
          <?php foreach($groups as $group){?>
          <li> <span class="span_3">
            <label>
            <input type="checkbox" value="<?=$group['group_id']?>" name="groups[]" <?php if(in_array($group['group_id'],$data['groups'])){echo 'checked="checked"';} ?> class="checkbox">
              <?=$group['name']?></label>
            </span>
            <input type="text" value="<?php echo set_date($group['group_id'],$users_belong,'Y-m-d');?>" class="inp_txt" name="endtime[<?=$group['group_id']?>]">
            </li>
            <?php }?>
        </ul>
      </div></td>
    <td></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>
<script type="text/javascript">
$("input[name^='endtime']").datepicker({
	dateFormat:'yy-mm-dd'
	});
</script>