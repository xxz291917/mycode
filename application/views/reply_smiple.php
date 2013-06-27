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
.ke-icon-quote {
 background:url(<?=base_url()?>js/kindeditor/plugins/quote/quote.gif) no-repeat;
	width: 16px;
	height: 16px;
}
.ke-img {
	text-align:center;
}
.pubQAForm li{
    padding:2px 0;
}
</style>
<script type="text/javascript">
var base_url = '<?=base_url()?>';
</script>
<script type="text/javascript" src="<?=base_url()?>js/editor_simple.js"></script>
<!--content-->
    <?php
	$attributes = array('id' => 'postform');
	echo form_open(base_url("index.php/action/reply/{$topic['id']}"),$attributes);
	?>
      <ul class="pubQAForm">
	<?php 
            if(!empty($special_view)){
                $this->load->view($special_view);
            }
        ?>
        <li class="pubQAEdit">
        <textarea name="content" style="width:926px;height:100px;visibility:hidden;"><?php echo $this->posts_model->smiley2html(set_value('content', '')); ?></textarea>
        </li>
        <input type="hidden" name="topic_id" value="<?php echo $topic['id']?>">
        <li style="text-align:right;">
        <input  type="submit" name="submit" class="mainCmtBtn" value="回复">
        </li>
      </ul>
  <?php echo form_close() ?>
<script type="text/javascript">
$(function(){

});
</script>
