<style>
.ke-icon-code2 {
	background-position: 0px -960px;
	width: 16px;
	height: 16px;
}
.ke-icon-image2 {
	background-position: 0px -496px;
	width: 16px;
	height: 16px;
}
.ke-icon-smiley {
 background:url(<?=base_url()?>js/kindeditor/plugins/smiley/smile.gif) no-repeat;
	height: 16px;
	width: 16px;
}
.ke-icon-hide {
 background:url(<?=base_url()?>js/kindeditor/plugins/hide/hide.gif) no-repeat;
	width: 16px;
	height: 16px;
}
.ke-icon-quote {
 background:url(<?=base_url()?>js/kindeditor/plugins/quote/quote.gif) no-repeat;
	width: 16px;
	height: 16px;
}
.ke-img {
	text-align:center;
}
</style>
<script type="text/javascript" src="<?=base_url()?>js/editor.js"></script>

<?php
	$attributes = array('id' => 'postform');
	echo form_open(current_url(),$attributes);
?>
<table class="table2">
  <colgroup>
  <col >
  <col style="color:#F00;">
  </colgroup>
  <tr class="split">
    <td colspan="2">发表帖子</td>
  </tr>
  <tr>
    <td><input type="text" value="<?php echo set_value('subject', '输入标题'); ?>" name="subject" class="inp_txt inp_long"></td>
    <td style="color:#F00;"><?php echo form_error('subject'); ?></td>
  </tr>
  <?php if($special!=1){?>
  <tr>
    <td><?php 
	if(!empty($special_view)){
		$this->load->view($special_view);
	}
	?></td>
    <td style="color:#F00;"></td>
  </tr>
  <?php }?>
  <tr>
    <td><textarea name="content" style="width:700px;height:360px;visibility:hidden;"><?php echo $this->posts_model->smiley2html(set_value('content', '填写帖子内容')); ?></textarea></td>
    <td style="color:#F00;"><?php echo form_error('content'); ?></td>
  </tr>
  <?php if($type == 'post'){?>
  <tr>
    <td>
    标签: <input type="text" value="<?php echo set_value('tags', ''); ?>" name="tags" id="tags" size="60" class="inp_txt inp_long"><?php echo form_error('tags'); ?><br />
用逗号或空格隔开多个标签，最多可填写 5 个<br />
最近使用标签: 东方闪电, 测试, 是, test
</td>
    <td style="color:#F00;"><?php echo form_error('content'); ?></td>
  </tr>
  <?php }?>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="发布" />
  <input class="inp_btn3" name="submit" type="submit" value="保存草稿" style=" margin-left:39px;" />
</p>
<?php echo form_close() ?>