<h3>设置用户组：
  <?=$data['name']?>
</h3>
<p class="sec_nav"> <a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/basic" class="on"><span>基本设置</span></a> <a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/access"><span>论坛权限</span></a> </p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open_multipart(base_url().'index.php/admin/groups/edit/'.$data['id'])?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col>
  </colgroup>
  <tr class="split">
    <td colspan="3">基本设置</td>
  </tr>
  <tr>
    <th>用户组名称</th>
    <td><input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo my_set_value('name', $data)?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>星星数</th>
    <td><input maxlength="5" class="inp_txt inp_num" name="stars" type="text" value="<?php echo my_set_value('stars', $data)?>" />
    <td></td>
  </tr>
  <?php if($data['type']=='member'){?>
  <tr>
    <th>升级点数需求</th>
    <td><input maxlength="30" class="inp_txt inp_long_num" name="credits" type="text" value="<?php echo my_set_value('credits', $data)?>" />
    <td></td>
  </tr>
  <?php }?>
  <tr>
    <th>用户组图标</th>
    <td><input type="file" value="<?php echo my_set_value('icon', $data)?>" name="icon"> <img src="<?php echo base_url().my_set_value('icon', $data)?>"></td>
    <td>用户组图标</td>
  </tr>
  <tr>
    <th>允许个性签名</th>
    <td><label>
        <input type="radio"  name="is_sign" value="1" <?php echo my_set_radio('is_sign', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_sign" value="0" <?php echo my_set_radio('is_sign', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许html</th>
    <td><label>
        <input type="radio"  name="is_html" value="1" <?php echo my_set_radio('is_html', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_html" value="0" <?php echo my_set_radio('is_html', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许bbcode</th>
    <td><label>
        <input type="radio"  name="is_bbcode" value="1" <?php echo my_set_radio('is_bbcode', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_bbcode" value="0" <?php echo my_set_radio('is_bbcode', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许图标</th>
    <td><label>
        <input type="radio"  name="is_smilies" value="1" <?php echo my_set_radio('is_smilies', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_smilies" value="0" <?php echo my_set_radio('is_smilies', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许多媒体</th>
    <td><label>
        <input type="radio"  name="is_media" value="1" <?php echo my_set_radio('is_media', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_media" value="0" <?php echo my_set_radio('is_media', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>