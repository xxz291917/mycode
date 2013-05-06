
<h3>编辑版块：<?=$data['name']?></h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post" class="on"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit"><span>积分设置</span></a>
</p>
<?php echo form_open(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
  <table class="table fspan">
    <colgroup>
    <col style="width:380px;">
      </col>
    <col>
      </col>
    </colgroup>

    <tr>
      <td><span>允许发布的特殊主题</span>
        <ul>
          <li><input type="checkbox" value="1" name="allow_special[]" <?php echo set_checkbox('allow_special', '1',$data); ?> class="checkbox">投票主题</li>
          <li><input type="checkbox" value="2" name="allow_special[]" <?php echo set_checkbox('allow_special', '2',$data); ?> class="checkbox">问答主题</li>
          <li><input type="checkbox" value="3" name="allow_special[]" <?php echo set_checkbox('allow_special', '3',$data); ?> class="checkbox">活动主题</li>
        </ul></td>
      <td></td>
    </tr>
    <tr>
      <td><span>发帖审核:</span>
        <label>
          <input type="radio"  name="check" value="0" <?php echo set_radio('check', 0, $data)?> />
          不审核</label>
        <label>
          <input type="radio"  name="check" value="1" <?php echo set_radio('check', 1, $data)?> />
          审核主题</label>
        <label>
          <input type="radio"  name="check" value="2" <?php echo set_radio('check', 2, $data)?> />
          审核主题和回复</label></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td><span class="span">允许匿名发帖</span>
        <label>
          <input type="radio"  name="is_anonymous" value="1" <?php echo set_radio('is_anonymous', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_anonymous" value="0" <?php echo set_radio('is_anonymous', 0, $data)?>/>
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