<?php echo form_open(current_url()) ?>
  <input type="hidden" name="submit" value="1">
  <table class="table2" width="400px">
    <colgroup>
    <col width="90">
    <col width="310">
    </colgroup>
    <tr>
    	<th>获胜方</th>
    	<td>
            <select id="stand" name="winner" >
            <option value="1" <?php echo my_set_select('winner', 1,$debate)?>>红方</option>
            <option value="2" <?php echo my_set_select('winner', 2,$debate)?>>蓝方</option>
            <option value="0" <?php echo my_set_select('winner', 0, $debate)?>>中立</option>
          </select>
        </td>
    </tr>
    <tr>
    	<th>最佳辩手</th>
    	<td><select id="stand" name="best_debater" >
            <?php foreach($usernames as $username){ ?>
                <option value="">推荐名单</option>
                <option value="<?=$username['username']?>" <?php echo my_set_select('best_debater', $username['username'],$debate)?>><?=$username['username']?></option>
            <?php }?>
          </select>
            <br/><input style="margin-top: 3px;" type="text" value="<?php echo my_set_value('best_debater2', $debate) ?>" class="inp_txt" name="best_debater2"> 手动填写用户名
        </td>
    </tr>
    <tr>
    	<th>裁判观点</th>
    	<td><textarea cols="45" name="umpire_point" rows="3" class="textarea"><?php echo my_set_value('umpire_point', $debate) ?></textarea></td>
    </tr>
  </table>
  <p class="div_bottom">
    <input class="mainCmtBtn" type="submit" value="确定" />
  </p>
</form>
