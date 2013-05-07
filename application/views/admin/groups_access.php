<h3>设置用户组：
  <?=$data['name']?>
</h3>
<p class="sec_nav"> <a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/basic"><span>基本设置</span></a> <a href="<?=base_url()?>index.php/admin/groups/edit/<?=$data['id']?>/access" class="on"><span>论坛权限</span></a> </p>
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
    <td colspan="3">论坛权限</td>
  </tr>
  <tr>
    <th>允许特殊主题</th>
    <td><ul>
        <li>
          <input type="checkbox" value="1" name="allow_special[]" <?php echo set_checkbox('allow_special', '1',$data); ?> class="checkbox">
          投票主题</li>
        <li>
          <input type="checkbox" value="2" name="allow_special[]" <?php echo set_checkbox('allow_special', '2',$data); ?> class="checkbox">
          问答主题</li>
        <li>
          <input type="checkbox" value="3" name="allow_special[]" <?php echo set_checkbox('allow_special', '3',$data); ?> class="checkbox">
          活动主题</li>
      </ul></td>
    <td></td>
  </tr>
  <tr>
    <th>发帖审核</th>
    <td><label>
        <input type="radio"  name="check" value="0" <?php echo set_radio('check', 0, $data)?> />
        不审核</label>
      <label>
        <input type="radio"  name="check" value="1" <?php echo set_radio('check', 1, $data)?> />
        审核主题</label>
      <label>
        <input type="radio"  name="check" value="2" <?php echo set_radio('check', 2, $data)?> />
        审核主题和回复</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许站点访问</th>
    <td><label>
        <input type="radio"  name="is_site_visit" value="1" <?php echo set_radio('is_site_visit', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_site_visit" value="0" <?php echo set_radio('is_site_visit', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许设置帖子权限</th>
    <td><label>
        <input type="radio"  name="is_permission" value="1" <?php echo set_radio('is_permission', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_permission" value="0" <?php echo set_radio('is_permission', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许使用隐藏标签</th>
    <td><label>
        <input type="radio"  name="is_hide" value="1" <?php echo set_radio('is_hide', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_hide" value="0" <?php echo set_radio('is_hide', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许匿名发帖</th>
    <td><label>
        <input type="radio"  name="is_anonymous" value="1" <?php echo set_radio('is_anonymous', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_anonymous" value="0" <?php echo set_radio('is_anonymous', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许举报帖子</th>
    <td><label>
        <input type="radio"  name="is_report" value="1" <?php echo set_radio('is_report', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_report" value="0" <?php echo set_radio('is_report', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>每日最多发帖数</th>
    <td><input maxlength="30" class="inp_txt inp_num" name="max_post_num" type="text" value="<?php echo set_value('max_post_num', $data)?>" /></td>
    <td class="v-b" >"0"为不限制</td>
  </tr>
  <tr>
    <th>每日最多附件</th>
    <td><input maxlength="30" class="inp_txt inp_num" name="max_upload_num" type="text" value="<?php echo set_value('max_upload_num', $data)?>" /></td>
    <td class="v-b" >"0"为不限制</td>
  </tr>
  <tr>
    <th>最小发帖间隔</th>
    <td><input maxlength="30" class="inp_txt inp_num" name="min_pertime" type="text" value="<?php echo set_value('min_pertime', $data)?>" />
      分</td>
    <td class="v-b" >"0"为不限制</td>
  </tr>
  <tr>
    <th>允许浏览版块 </th>
    <td><label>
        <input type="radio"  name="is_visit" value="1" <?php echo set_radio('is_visit', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_visit" value="0" <?php echo set_radio('is_visit', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许浏览帖子 </th>
    <td><label>
        <input type="radio"  name="is_read" value="1" <?php echo set_radio('is_read', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_read" value="0" <?php echo set_radio('is_read', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许发布主题 </th>
    <td><label>
        <input type="radio"  name="is_post" value="1" <?php echo set_radio('is_post', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_post" value="0" <?php echo set_radio('is_post', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许回复主题</th>
    <td><label>
        <input type="radio"  name="is_reply" value="1" <?php echo set_radio('is_reply', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_reply" value="0" <?php echo set_radio('is_reply', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许上传附件</th>
    <td><label>
        <input type="radio"  name="is_upload" value="1" <?php echo set_radio('is_upload', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_upload" value="0" <?php echo set_radio('is_upload', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
  <tr>
    <th>允许下载附件 </th>
    <td><label>
        <input type="radio"  name="is_download" value="1" <?php echo set_radio('is_download', 1, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="is_download" value="0" <?php echo set_radio('is_download', 0, $data)?>/>
        否</label></td>
    <td></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>