
<h3>SEO设置
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
    <td colspan="3">首页</td>
  </tr>
  <tr>
    <th>title</th>
    <td><input maxlength="30" class="inp_txt" name="seo_index_title" type="text" value="<?php echo my_set_value('seo_index_title', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >keywords</th>
    <td><input maxlength="120" class="inp_txt" name="seo_index_keywords" type="text" value="<?php echo my_set_value('seo_index_keywords', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >description</th>
    <td><input class="inp_txt" name="seo_index_description" type="text" value="<?php echo my_set_value('seo_index_description', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  
  <tr class="split">
    <td colspan="3">帖子列表页</td>
  </tr>
  <tr>
    <th>title</th>
    <td><input maxlength="30" class="inp_txt" name="seo_topic_title" type="text" value="<?php echo my_set_value('seo_topic_title', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >keywords</th>
    <td><input maxlength="120" class="inp_txt" name="seo_topic_keywords" type="text" value="<?php echo my_set_value('seo_topic_keywords', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >description</th>
    <td><input class="inp_txt" name="seo_topic_description" type="text" value="<?php echo my_set_value('seo_topic_description', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  
  <tr class="split">
    <td colspan="3">帖子页面</td>
  </tr>
  <tr>
    <th>title</th>
    <td><input maxlength="30" class="inp_txt" name="seo_post_title" type="text" value="<?php echo my_set_value('seo_post_title', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >keywords</th>
    <td><input maxlength="120" class="inp_txt" name="seo_post_keywords" type="text" value="<?php echo my_set_value('seo_post_keywords', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >description</th>
    <td><input class="inp_txt" name="seo_post_description" type="text" value="<?php echo my_set_value('seo_post_description', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>