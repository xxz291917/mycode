<li class="reward">
  <label for="price">悬赏价格: </label>
  <input type="text" value="<?php echo set_value('price', '0'); ?>" class="inp cdgray pubInpW2" name="price">
  <span> <?php echo $view_name; ?></span>
  <em>价格不能低于 1 两, 您有<i><?php echo $price; ?></i><?php echo $view_name; ?></em>
</li>
