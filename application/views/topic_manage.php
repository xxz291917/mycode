<form action="<?php echo base_url('index.php/topic/manage/' . $action);?>" method="post">
<table class="table2" width="400px">
  <colgroup>
  <col width="80">
  <col width="350">
  </colgroup>
  <tr class="split">
    <td colspan="2">选择了(<span><?php echo $count;?></span>篇)</td>
  </tr>
  
  <tbody>
  <tr>
    <th>置顶</th>
    <td><select name="top" class="select" >
                <option value="1">本版置顶</option>
                <option value="2">分类置顶</option>
                <option value="3">全局置顶</option>
                <option value="0" id="J_topped_cancel">取消置顶</option>
              </select></td>
  </tr>
  <tr>
    <th>有效期</th>
    <td><input type="text" value="<?php echo my_set_date('top_time',$top=array(),'Y-m-d');?>" class="inp_txt" name="top_time"></td>
  </tr>
  </tbody>
  
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
</form>