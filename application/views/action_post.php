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
        background:url(<?= base_url() ?>js/kindeditor/plugins/smiley/smile.gif) no-repeat;
        height: 16px;
        width: 16px;
    }
    .ke-icon-hide {
        background:url(<?= base_url() ?>js/kindeditor/plugins/hide/hide.gif) no-repeat;
        width: 16px;
        height: 16px;
    }
    .ke-icon-quote {
        background:url(<?= base_url() ?>js/kindeditor/plugins/quote/quote.gif) no-repeat;
        width: 16px;
        height: 16px;
    }
    .ke-img {
        text-align:center;
    }
</style>
<script type="text/javascript">
    var base_url = '<?= base_url() ?>';
    $(function(){
			<?php if($type == 'edit'){?>
				KindEditor.uploadImages=<?=$edit_data['uploadImages']?>;
				KindEditor.uploadFiles=<?=$edit_data['uploadFiles']?>;
			<?php }else{?>
				KindEditor.uploadImages={};
				KindEditor.uploadFiles={};
			<?php }?>
    });
</script>
<script type="text/javascript" src="<?= base_url() ?>js/editor.js"></script>
<!--content-->
<div class="wrap">
    <div class="myPos fsong">>
        <?php
        $nav_num = count($nav);
        foreach ($nav as $key => $val) {
            $link = '<a href="' . $val[1] . '">' . $val[0] . '</a>>';
            if ($nav_num == $key + 1) {
                $link = substr($link, 0, -1);
            }
            echo $link;
        }
        ?>
    </div>

    <div class="pubQA">
        <?php
        $attributes = array('id' => 'postform');
        echo form_open(current_url(), $attributes);
        ?>
        <h4>
            <?php
            $special_names = array(1 => '普通', 2 => '问答', 3 => '投票', 4 => '辩论');
            if ($type == 'post') {
                echo '发布' . $special_names[$special] . '帖';
            } elseif ($type == 'edit') {
                echo '编辑帖子';
                if (empty($_POST)) {
                    $_POST = $edit_data;
                }
            } else {
                echo '回复帖子';
            }
            ?>
        </h4>
        <ul class="pubQAForm">
            <li>
                <?php if ($type == 'post' || ( $type == 'edit' && $post['is_first']==1)) { ?>
                    <select name="category">
                        <?php echo $category_option; ?>
                    </select>
                <?php } ?>
                <input type="text" value="<?php echo set_value('subject', ''); ?>" name="subject" class="inp pubInpW1">
                <label></label>
            </li>

            <?php if ($type == 'reply' && !empty($quote_content)) { ?>
                <li>
                    <?php echo $quote_content; ?>
                </li>
            <?php } ?>

            <?php
            if (!empty($special_view)) {
                $this->load->view($special_view);
            }
            ?>

            <input type="hidden" name="special" value="<?php echo $special ?>"><!--保存草稿使用-->
            
            <li class="pubQAEdit">
                <textarea name="content" style="width:958px;height:340px;visibility:hidden;"><?php echo $this->posts_model->smiley2html(set_value('content', '')); ?></textarea>
            </li>
            <?php if ($type == 'post' || ($type == 'edit' && $post['is_first']==1)) { ?>
                <li>
                    <input type="text" value="<?php echo set_value('tags', ''); ?>" name="tags" id="tags" size="60" class="inp pubInpW3">
                    <label></label>
                </li>
                <input type="hidden" name="forum_id" value="<?php echo $forum_id ?>"><!--保存草稿使用-->
            <?php } elseif ($type == 'reply') { ?>
                <input type="hidden" name="topic_id" value="<?php echo $topic['id'] ?>"><!--保存草稿使用-->
            <?php } ?>

            <li>
					<?php //$edit_push
					 	if(!empty($_POST['attachments'])){?>
                        <?php foreach($_POST['attachments'] as $attachments){?>
                    	<input type="hidden" name="attachments[]" value="<?php echo set_value('attachments[]', ''); ?>" />
                    	<?php }?>
                    <?php }?>
                <input  type="submit" name="submit" class="mainCmtBtn" value="提交" />
                <button type="button" class="mainCmtBtn btnGray" id="preview">预览</button>
                <?php if ($type != 'edit') {?>
                <button type="button" class="mainCmtBtn btnGray" id="drafts">保存草稿</button>
                <?php }?>
            </li>
        </ul>
    </div> 
    <?php echo form_close() ?>
</div>
<script type="text/javascript">

    $(function() {
        var thisform = $("#postform");
        //如果有草稿箱，提示用户。
<?php
if (!empty($draft)) {
    ?>
            var draft = <?php echo $draft; ?>,
                    drafts_tip = '您当前有未发表的草稿需要使用么？',
                    drafts_title = '草稿箱提示';

            $.Confirm(drafts_tip, drafts_title, function() {
                $.each(draft, function(i, n) {
                    if (i == 'content') {
                        editor.html(n);
                    } else {
                        var field = thisform.find("[name='" + i + "']");
                        field.val(n);
                        if (field.attr('change') === '0') {
                            field.attr('change', 1);
                        }
                    }
                });
            });
<?php } ?>

		//提交错误提示
		<?php
		$errors = my_validation_errors();
		if (!empty($errors)) {
		?>
            var error = <?php echo $errors; ?>;
            $.Alert(error.join(','), '错误提示');
		<?php } ?>

        var drafts = $("#drafts"),
            tipsArr = {'subject': '<?php echo !empty($topic['subject']) ? "Re:{$topic['subject']}" : '请输入帖子标题' ?>', 'tags': "标签间请用'空格'或'逗号'隔开，最多可添加5个标签。"};

        $.each(tipsArr, function(i, n) {
            var field = thisform.find("[name='" + i + "']");

            if (field.val() == '') {
                field.val(tipsArr[i]);
            }

            field.focus(function() {
                if (field.val() == tipsArr[i]) {
                    field.val('');
                }
            }).blur(function() {
                if (field.val() == '') {
                    field.val(tipsArr[i]);
                }
            });
        });

        thisform.submit(function(event) {
			editor.sync();
            $.each(tipsArr, function(i, n) {
                var field = thisform.find("[name='" + i + "']");
                if (field.val() == tipsArr[i]) {
                    field.val('');
                }
            });
			var url = thisform.attr('action'),
				method = thisform.attr('method'),
				fields = thisform.serialize(),
				ajaxFun = method == 'post' ? $.post : $.get;
				fields+='&submit=1';
			ajaxFun(url, fields, function(data) {
				if(data.redirect){
					var options = {buttons: {
						"确定": function() {
								$(this).dialog("close");
								window.location.href = data.redirect;
							}
					}};
				}else{
					var options = {};
				}
				if(!data.success){
					$.Alert(data.message,'',options);
				}else{
					$.Alert(data.message,'',options);
					html.dialog("close");
				}
			}, 'json');
			event.preventDefault();
			return false;
        });
		
		if(drafts.length>0){
			drafts.click(function(event) {
				editor.sync();
	
				$.each(tipsArr, function(i, n) {
					var field = thisform.find("[name='" + i + "']");
					if (field.val() == tipsArr[i]) {
						field.val('');
					}
				});
	
				var url = unescape('<?php echo base_url('index.php/action/safe_drafts') ?>'),
						method = thisform.attr('method'),
						fields = thisform.serialize(),
						ajaxFun = method == 'post' ? $.post : $.get;
				ajaxFun(url, fields, function(data) {
					if (!data.success) {
						$.Alert(data.message);
					} else {
						$.Alert(data.message);
					}
				}, 'json');
				event.preventDefault();
				return false;
			});
		}

    });

</script>
