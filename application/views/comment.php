<?php echo form_open(current_url()) ?>
  <input type="hidden" name="submit" value="1">
  <table class="table2" width="400px">
    <colgroup>
    <col width="90">
    <col width="310">
    </colgroup>
    <tr>
    	<th>点评内容</th>
    	<td><textarea cols="45" name="comment" rows="3" class="textarea"><?php echo my_set_value('comment', array()) ?></textarea></td>
    </tr>
  </table>
  <p class="div_bottom">
    <input class="mainCmtBtn" type="submit" value="点评" />
  </p>
</form>
