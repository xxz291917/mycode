<?php echo form_open(current_url()) ?>
  <input type="hidden" name="submit" value="1">
  <input type="hidden" name="post_id" value="<?= $post_id ?>">
  <table class="table2" width="400px">
    <colgroup>
    <col width="90">
    <col width="310">
    </colgroup>
    <tr>
    	<th>举报理由</th>
    	<td><textarea cols="45" name="reason" rows="3" class="textarea"><?php echo my_set_value('reason', array()) ?></textarea></td>
    </tr>
  </table>
  <p class="div_bottom">
    <input class="mainCmtBtn" type="submit" value="确定" />
  </p>
</form>
