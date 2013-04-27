<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit" class="on"><span>积分设置</span></a> </p>
<h3>积分设置</h3>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->
<?php echo form_open_multipart(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
  <table class="table fspan">
    <colgroup>
    <col style="width:280px;">
      </col>
    <col>
      </col>
    </colgroup>
    <tr>
      <td><span>版块名称</span>
          <input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo set_value('name', $data)?>" /></td>
      <td class="v-b" >&nbsp;</td>
    </tr>
    <tr>
      <td><span>版主列表</span>
        <input maxlength="120" class="inp_txt" name="manager" type="text" value="<?php echo set_value('manager', $data)?>" /></td>
      <td class="v-b" ><p>多个版主请用英文的逗号、分号或者空格来分隔。</p></td>
    </tr>
    <tr>
      <td><span>排列顺序</span>
        <input style="width:30px" class="inp_txt" name="display_order" type="text" value="<?php echo set_value('display_order', $data)?>" /></td>
      <td class="v-b" ><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td><span>版块图标</span>
        <input type="file" value="<?php echo set_value('icon', $data)?>" name="icon"></td>
      <td class="v-t" ><p>页面底部可以显示第三方统计</p></td>
    </tr>
    <tr>
      <td><span>版块简介</span>
        <textarea cols="45" name="description" rows="3" class="textarea"><?php echo set_value('description', $data)?></textarea></td>
      <td class="v" ><p>支持HTML代码<br/>
        </p></td>
    </tr>
    <tr>
      <td><span>关闭版块</span><label>
          <input type="radio"  name="status" value="0" <?php echo set_radio('status', 0, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="status" value="1" <?php echo set_radio('status', 1, $data)?>/>
          否</label>
        </td>
      <td>
      暂时将站点关闭，其他人无法访问，但不影响管理员访问。</td>
    </tr>
  </table>
  <p class="submit">
    <input class="inp_btn" name="submit" type="submit" value="提交" />
  </p>
<?php echo form_close() ?>