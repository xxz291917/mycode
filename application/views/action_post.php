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
<script type="text/javascript">
var base_url = '<?=base_url()?>';
</script>
<script type="text/javascript" src="<?=base_url()?>js/editor.js"></script>
<!--content-->
<div class="wrap">
  <div class="myPos fsong">>
    <?php 
  	$nav_num = count($nav);
	foreach($nav as $key=>$val){
		$link = '<a href="'.$val[1].'">'.$val[0].'</a>>';
		if($nav_num == $key+1){
			$link = substr($link,0,-1);
		}
		echo $link;
	}
  ?>
  </div>
  
  <div class="pubQA">    
    <?php
	$attributes = array('id' => 'postform');
	echo form_open(current_url(),$attributes);
	?>
      <h4>发布问答帖</h4>
      <ul class="pubQAForm">
        <li>
          <select name="editcategory">
            <?php echo $category_option;?>
          </select>
          <input type="text" value="<?php echo set_value('subject', '输入问答概述'); ?>" name="subject" class="inp inpTxt pubInpW1">
          <label>（还可输入80字符）</label>
        </li>
        
		<?php 
            if(!empty($special_view)){
                $this->load->view($special_view);
            }
        ?>
        
        <li class="pubQAEdit">
          <textarea name="content" style="width:958px;height:360px;visibility:hidden;"><?php echo $this->posts_model->smiley2html(set_value('content', '')); ?></textarea>
        </li>
      </ul>
      <h4>发布问答帖</h4>
      <ul class="pubQAForm">
        <?php if($type == 'post'){?>
        <li>
          <input type="text" value="<?php echo set_value('tags', "标签间请用'空格'或'逗号'隔开，最多可添加5个标签。"); ?>" name="tags" id="tags" size="60" class="inp inpTxt pubInpW3">
          <label>最近标签：Flash、ios、android</label>
        </li>
        <input type="hidden" name="forum_id" value="<?php echo $forum_id?>">
  		<?php }elseif($type == 'reply'){?>
        <input type="hidden" name="topic_id" value="<?php echo $topic_id?>">
        <?php }?>
        <li>
        <input  type="submit" name="submit" class="mainCmtBtn" value="发布问题">
        <button type="button" class="mainCmtBtn btnGray" id="preview">预览</button>
        <button type="button" class="mainCmtBtn btnGray" id="drafts">保存草稿</button>
        </li>
      </ul>
  </div> 
  <?php echo form_close() ?>
</div>
<script type="text/javascript">

$(function(){
	<?php $errors = my_validation_errors();
	  if(!empty($errors)){
	?>
	var error = <?php echo $errors;?>;
	$.Alert(error.join(','),'错误提示');
	<?php }?>
	
	var publish = $("#publish"),
		drafts = $("#drafts"),
		thisform = $("#postform");
		
	publish.click(function(){
		thisform.submit();
	});
	
	
	drafts.click(function(){
		editor.sync();
		var url = unescape('<?php echo base_url('index.php/action/safe_drafts')?>'),
				method = thisform.attr('method'),
				fields = thisform.serialize(),
				ajaxFun = method=='post'?$.post:$.get;
		ajaxFun(url,fields,function(data){
			if(!data.success){
				$.Alert(data.message);
			}else{
				$.Alert(data.message);
			}
		},'json');
		event.preventDefault();
		return false;
	});
	
});



</script>
