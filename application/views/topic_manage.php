<?php 
//审核是后台的操作，发送到后台的处理程序。
empty($action_url) && $action = 'index.php/topic/manage/';
?>

<form action="<?php echo base_url($action_url . $action); ?>" method="post" id="topic_manage">
  <input type="hidden" name="submit" value="1">
  <input type="hidden" name="topic_id" value="<?= $topic_id ?>">
  <table class="table2" width="400px">
    <colgroup>
    <col width="90">
    <col width="310">
    </colgroup>
    <tr class="split">
      <td colspan="2">正在操作(<span><?php echo $count; ?></span>篇帖子) </td>
    </tr>
    <?php if (in_array($action, array('top', 'digest', 'highlight'))) { ?>
    <tbody>
      <tr>
        <?php if ($action == 'top') { ?>
        <th>置顶</th>
        <td><select name="top" class="select" >
            <option value="1" <?php echo my_set_select('top', 1, $topic)?>>本版置顶</option>
            <option value="2" <?php echo my_set_select('top', 2, $topic)?>>分类置顶</option>
            <option value="3" <?php echo my_set_select('top', 3, $topic)?>>全局置顶</option>
            <option value="0" <?php echo my_set_select('top', 0, $topic)?>>取消置顶</option>
          </select></td>
        <?php } elseif ($action == 'digest') { ?>
        <th>推荐精华</th>
        <td><select name="digest" class="select" >
            <option value="1" <?php echo my_set_select('digest', 1, $topic)?>>精华I</option>
            <option value="2" <?php echo my_set_select('digest', 2, $topic)?>>精华II</option>
            <option value="3" <?php echo my_set_select('digest', 3, $topic)?>>精华III</option>
            <option value="0" <?php echo my_set_select('digest', 0, $topic)?>>取消精华</option>
          </select></td>
        <?php } elseif ($action == 'highlight') {
			$highlight = explode(',',$topic['highlight']);
			for($i=1;$i<=3;$i++){
				$cnt[$i] = !empty($highlight[$i])?'cnt':'';
			}
			?>
        <th>高亮</th>
        <td><div class="dopt"> <span class="hasd">
            <input type="hidden" value="<?php echo my_set_value('0',$highlight);?>" name="highlight[0]" id="highlight_color" >
            <input type="hidden" value="<?php echo my_set_value('1',$highlight,0);?>" name="highlight[1]" id="highlight_style_B" >
            <input type="hidden" value="<?php echo my_set_value('2',$highlight,0);?>" name="highlight[2]" id="highlight_style_I" >
            <input type="hidden" value="<?php echo my_set_value('3',$highlight,0);?>" name="highlight[3]" id="highlight_style_U" >
            <a style="background-color:<?php echo my_set_value('0',$highlight);?>" class="pn colorwd" onclick="showHighLightColor('highlight_color')" id="highlight_color" href="javascript:;" ></a> </span>
            <a title="文字加粗" style="text-indent:0;text-decoration:none;font-weight:700;" class="dopt_a <?=$cnt[1]?>" href="javascript:;" >B</a>
            <a title="文字斜体" style="text-indent:0;text-decoration:none;font-style:italic;" class="dopt_a <?=$cnt[2]?>" href="javascript:;" >I</a>
            <a title="文字加下划线" style="text-indent:0;text-decoration:underline;" class="dopt_a <?=$cnt[3]?>" href="javascript:;" >U</a> </div>
        </td>
        <?php } ?>
      </tr>
      <tr>
        <th>有效期</th>
        <td><input type="text" value="<?php echo my_set_date('end_time', $topic, 'Y-m-d'); ?>" class="inp_txt" name="end_time"></td>
      </tr>
    </tbody>
    <?php } elseif($action == 'bump'){?>
    <tbody>
      <tr>
        <th>升降</th>
        <td>
        <label>
        <input type="radio"  name="bump" value="1" />提升帖子</label>
      	<label>
        <input type="radio"  name="bump" value="0" />下沉帖子</label></td>
      </tr>
    </tbody>
    <?php } elseif($action == 'ban'){?>
     <tbody>
      <tr>
        <th>屏蔽</th>
        <td>
        <label>
        <input type="radio"  name="ban" value="1" <?php echo my_set_radio('ban', 1, $topic)?>/>屏蔽</label>
      	<label>
        <input type="radio"  name="ban" value="0" <?php echo my_set_radio('ban', 0, $topic)?>/>未屏蔽</label></td>
      </tr>
    </tbody>
    <?php } elseif($action == 'close'){?>
      <tbody>
      <tr>
        <th>关闭</th>
        <td>
        <label>
        <input type="radio"  name="close" value="1" <?php echo my_set_radio('close', 1, $topic)?>/>关闭</label>
      	<label>
        <input type="radio"  name="close" value="0" <?php echo my_set_radio('close', 0, $topic)?>/>未关闭</label></td>
      </tr>
    </tbody>
	<?php } elseif($action == 'del'){?>
      <tbody>
      <tr>
        <th>删除</th>
        <td>
        <input type="hidden" name="del" value="1" />
        您确定要删除这些帖子么？</td>
      </tr>
    </tbody>
    <?php } elseif($action == 'move'){?>
      <tbody>
      <tr>
        <th>移动到</th>
        <td>
		  <select name="move" class="select" >
            <?php echo $forums_option;?>
          </select>
        </td>
      </tr>
    </tbody>
	<?php } elseif($action == 'editcategory'){?>
      <tbody>
      <tr>
        <th>选择分类</th>
        <td>
		  <select name="editcategory" class="select" >
            <?php echo $category_option;?>
          </select>
        </td>
      </tr>
    </tbody>
    <?php } elseif($action == 'pass'){?>
      <tbody>
      <tr>
        <th>审核</th>
        <td>
        <input type="hidden" name="del" value="1" />
        您确定审核通过这些帖子么？</td>
      </tr>
    </tbody>
    <?php }?>
    
    
    <tr>
    	<th>备注</th>
    	<td><textarea cols="45" name="reason" rows="3" class="textarea"><?php echo my_set_value('reason', array()) ?></textarea></td>
    </tr>
  </table>
  <p class="div_bottom">
    <input class="inp_btn" type="submit" value="确定" />
  </p>
</form>
<script type="text/javascript">
    $(function() {
        $("input[name^='end_time']", $("#topic_manage")).datepicker({
            dateFormat: 'yy-mm-dd'
        });
        <?php if ($action == 'highlight') { ?>
        $(".dopt_a").click(
		function () {
			if($("#highlight_style_"+$(this).text()).val()==0){
				$(this).addClass("cnt");
				$("#highlight_style_"+$(this).text()).val(1);
			}else{
				$(this).removeClass("cnt");
				$("#highlight_style_"+$(this).text()).val(0);
			}
		});
        <?php } ?>
        
    });
</script>