<?php echo form_open_multipart(base_url().'index.php/bbs/post')?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  <col>
  </colgroup>
  <tr class="split">
    <td colspan="2">发表帖子</td>
  </tr>
    <tr>
    <td><input type="text" value="请输入标题" name="subject" class="inp_txt inp_long"></td>
    <td>test</td>
  </tr>
  <tr>
    <td><textarea name="content" style="width:700px;height:200px;visibility:hidden;">填写帖子内容</textarea></td>
    <td>test</td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>