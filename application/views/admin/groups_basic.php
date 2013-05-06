<h3>设置用户组：<?=$data['name']?></h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/basic" class="on"><span>基本设置</span></a>
<a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/access"><span>论坛权限</span></a>
</p>
<!--<ul class="tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->
<?php echo form_open_multipart(base_url().'index.php/admin/groups/edit/'.$data['id'])?>
  <table class="table fspan">
    <colgroup>
    <col style="width:380px;">
      </col>
    <col>
      </col>
    </colgroup>
    <tr>
      <td><span>用户组名称</span>
          <input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo set_value('name', $data)?>" /></td>
      <td class="v-b" >&nbsp;</td>
    </tr>
    <tr>
      <td><span>用户组图标</span>
        <input type="file" value="<?php echo set_value('icon', $data)?>" name="icon"></td>
      <td class="v-t" ><p>用户组图标</p></td>
    </tr>
    <tr>
      <td><span class="span">允许签名</span>
        <label>
          <input type="radio"  name="is_sign" value="1" <?php echo set_radio('is_sign', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_sign" value="0" <?php echo set_radio('is_sign', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span class="span">允许html</span>
        <label>
          <input type="radio"  name="is_html" value="1" <?php echo set_radio('is_html', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_html" value="0" <?php echo set_radio('is_html', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span class="span">允许bbcode</span>
        <label>
          <input type="radio"  name="is_bbcode" value="1" <?php echo set_radio('is_bbcode', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_bbcode" value="0" <?php echo set_radio('is_bbcode', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span class="span">允许图标</span>
        <label>
          <input type="radio"  name="is_smilies" value="1" <?php echo set_radio('is_smilies', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_smilies" value="0" <?php echo set_radio('is_smilies', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span class="span">允许多媒体</span>
        <label>
          <input type="radio"  name="is_media" value="1" <?php echo set_radio('is_media', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_media" value="0" <?php echo set_radio('is_media', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
  </table>
  <p class="submit">
    <input class="inp_btn" name="submit" type="submit" value="提交" />
  </p>
<?php echo form_close() ?>