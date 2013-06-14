<div class="exfm cl">
<label for="price">悬赏价格: </label>
<input type="text" value="<?php echo set_value('price', ''); ?>" name="price">
<?php echo form_error('price'); ?>
<?php echo $view_name; ?>
<p class="mtn xg1">
价格不能低于 1 , 您有 <?php echo $price; ?> <?php echo $view_name; ?></p>
</div>
