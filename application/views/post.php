<?php echo form_open(current_url())?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col style="color:#F00;">
  </colgroup>
  <tr class="split">
    <td colspan="2">发表帖子</td>
  </tr>
    <tr>
    <td><input type="text" value="<?php echo set_value('subject', '输入标题'); ?>" name="subject" class="inp_txt inp_long"></td>
    <td><?php echo form_error('subject'); ?></td>
  </tr>
  <tr>
    <td><textarea name="content" style="width:700px;height:200px;visibility:hidden;"><?php echo set_value('content', '填写帖子内容'); ?></textarea></td>
    <td><?php echo form_error('content'); ?></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="发布" />
  <input class="inp_btn3" name="submit" type="submit" value="保存草稿" style=" margin-left:39px;" />
</p>
<?php echo form_close() ?>