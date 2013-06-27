<style>
.pubQAForm2 li{padding:3px 0;}
.pubQAForm2 li select {
    border: 1px solid #8F939C;
    line-height: 30px;
    padding: 5px 5px 5px;
}
</style>

<!--content-->
    <?php
	echo form_open(base_url("index.php/action/reply_dialog/$topic_id/$post_id"),array('id'=>'reply_dialog'));
	?>
      <ul class="pubQAForm2">
        <li>
          <input type="text" value="<?php echo set_value('subject', ''); ?>" placeholder="Re:<?=$topic['subject']?>"  name="subject" style="width:300px" class="inp inpTxt">
          <a href="<?php echo base_url("index.php/action/reply/$topic_id/$post_id");?>">高级编辑</a>
        </li>
	<?php 
		if(!empty($special_view)){
			$this->load->view($special_view);
		}
	?>
    <?php if(!empty($quote_content)){ ?>
    	<li>
        <?php echo $quote_content; ?>
        </li>
    <?php } ?>
        <li class="pubQAEdit">
          <textarea name="content"  class="inp" style="width:426px;height:100px;"></textarea>
        </li>
        <li>
        <input type="hidden" name="submit" value="1">
        <input type="submit" class="mainCmtBtn" id="publish_dialog" value="回复">
        </li>
      </ul>
  <?php echo form_close() ?>
  
