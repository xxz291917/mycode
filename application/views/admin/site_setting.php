
<h3>站点设置
</h3>
<!--<p class="sec_nav">
    <a href="<?=base_url()?>index.php/admin/forums/edit/basic" class="on"><span>基本设置</span></a>
</p>
<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(current_url())?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  </colgroup>
  <tr class="split">
    <td colspan="3">基本设置</td>
  </tr>
  <tr>
    <th>网站名称</th>
    <td><input maxlength="30" class="inp_txt" name="site_name" type="text" value="<?php echo my_set_value('site_name', $data)?>" /></td>
    <td >站点名称，将显示在浏览器窗口标题等位置</td>
  </tr>
  <tr>
    <th >管理员电子邮箱</th>
    <td><input maxlength="120" class="inp_txt" name="manager_email" type="text" value="<?php echo my_set_value('manager_email', $data)?>" /></td>
    <td >管理员 E-mail，将作为系统发邮件的时候的发件人地址</td>
  </tr>
  <tr>
    <th >ICP 备案信息</th>
    <td><input class="inp_txt" name="icp" type="text" value="<?php echo my_set_value('icp', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >第三方统计代码</th>
    <td><textarea cols="45" name="statistic_code" rows="3" class="textarea"><?php echo my_set_value('statistic_code', $data)?></textarea></td>
    <td ><br/>
    页面底部可以显示第三方统计</td>
  </tr>
  <tr>
    <th >关闭站点</th>
    <td><label>
        <input type="radio"  name="closed" value="1" <?php echo my_set_radio('closed', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="closed" value="0" <?php echo my_set_radio('closed', 0, $data)?>/>
        否</label></td>
    <td> 暂时将站点关闭，其他人无法访问，但不影响管理员访问。</td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>