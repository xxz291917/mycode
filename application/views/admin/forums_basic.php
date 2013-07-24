
<h3>编辑版块：
  <?=$data['name']?>
</h3>
<p class="sec_nav">
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic" class="on"><span>基本设置</span></a>
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/category"><span>主题分类</span></a> 
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
    <a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit"><span>积分设置</span></a>
</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>--> 
<?php echo form_open_multipart(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
<table class="table2">
  <colgroup>
  <col class="th">
  <col width="300">
  </colgroup>
  <tr class="split">
    <td colspan="3">基本设置</td>
  </tr>
  <tr>
    <th>版块名称</th>
    <td><input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo my_set_value('name', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >版主列表</th>
    <td><input maxlength="120" class="inp_txt" name="manager" type="text" value="<?php echo my_set_value('manager', $data)?>" /></td>
    <td >多个版主请用英文的逗号、分号或者空格来分隔。</td>
  </tr>
  <tr>
    <th >排列顺序</th>
    <td><input class="inp_txt inp_num" name="display_order" type="text" value="<?php echo my_set_value('display_order', $data)?>" /></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <th >版块图标</th>
    <td><input type="file" value="<?php echo my_set_value('icon', $data)?>" name="icon"><img src="<?php echo base_url().$data['icon']?>"></td>
    <td ></td>
  </tr>
  <tr>
    <th >版块简介</th>
    <td><textarea cols="45" name="description" rows="3" class="textarea"><?php echo my_set_value('description', $data)?></textarea></td>
    <td >支持HTML代码<br/></td>
  </tr>
  <tr>
    <th >版块重定向其他版块</th>
    <td><input type="text" class="inp_txt" value="<?php echo my_set_value('redirect', $data)?>" name="redirect"></td>
    <td >此版块的展示内容和发布的帖子，都将转向到重定向的版块。<br/></td>
  </tr>
  <tr>
    <th >版块重定向的问答汇总版块id</th>
    <td><input type="text" class="inp_txt" value="<?php echo my_set_value('redirect_ask_id', $data)?>" name="redirect_ask_id"></td>
    <td >此版块的展示内容转向到重定向的问答汇总版块，发布的帖子还在原版块。<br/></td>
  </tr>
  <tr>
    <th >版块重定向URL</th>
    <td><input type="text" class="inp_txt" value="<?php echo my_set_value('redirect_url', $data)?>" name="redirect_url"></td>
    <td >此版块将不能再发布帖子，点击将转向到新的URL。<br/></td>
  </tr>
  <tr>
    <th >是否显示到首页</th>
    <td><label>
        <input type="radio"  name="no_index" value="0" <?php echo my_set_radio('no_index', 0, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="no_index" value="1" <?php echo my_set_radio('no_index', 1, $data)?>/>
        否</label></td>
    <td> 因为版块太多，此选项设定此版块是否显示到首页（只对二级和三级版块有效）</td>
  </tr>
  <tr>
    <th >关闭版块</th>
    <td><label>
        <input type="radio"  name="status" value="0" <?php echo my_set_radio('status', 0, $data)?>/>
        是</label>
      <label>
        <input type="radio"  name="status" value="1" <?php echo my_set_radio('status', 1, $data)?>/>
        否</label></td>
    <td> 暂时将站点关闭，其他人无法访问，但不影响管理员访问。</td>
  </tr>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>