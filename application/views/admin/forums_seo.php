<h3>编辑版块：
  <?=$data['name']?>
</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo" class="on"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/category"><span>主题分类</span></a> 
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit"><span>积分设置</span></a>
</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  </colgroup>
  <tr class="split">
    <td colspan="3">SEO设置</td>
  </tr>
  <tr>
    <th>title</th>
    <td><input class="inp_txt" name="seo_title" type="text" value="<?php echo my_set_value('seo_title', $data)?>" /></td>
    <td></td>
  </tr>
  <tr>
    <th>keywords</th>
    <td><input class="inp_txt" name="seo_keywords" type="text" value="<?php echo my_set_value('seo_keywords', $data)?>" /></td>
    <td>
    <td></td>
  </tr>
  <tr>
    <th>description</th>
    <td><textarea cols="45" name="seo_description" rows="3" class="textarea"><?php echo my_set_value('seo_description', $data)?></textarea></td>
    <td>
    <td></td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>