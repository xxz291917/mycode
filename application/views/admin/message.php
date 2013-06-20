<?php
$class = $success?'success':'error';
?>
<dl class="message <?=$class?>">
	<dt>提示信息</dt>
	<dd><?php echo $message ?></dd>
	<dd>
        <?php if ($redirect == 'BACK'){ ?>
		<a href="javascript:history.back();">点击返回……</a>
        <?php }elseif($redirect){ ?>
			<a href="<?php echo $redirect?>">3秒钟自动跳转……</a>
			<script type="text/javascript">
			function redirect(url, time) {
				setTimeout("window.location='" + url + "'", time * 1000);
			}
			redirect('<?php echo $redirect?>', 3);
			</script>
        <?php } ?>
	</dd>
</dl>
