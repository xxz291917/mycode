
<table class="table2">
  <tr class="split">
    <td>
    <?php foreach($manage_arr as $key=>$val){?>
    <a target="dialog" href="<?php echo base_url('index.php/topic/manage/'.$val[0].'/'.$topic['id']);?>"><?=$val[1]?></a>
    <?php }?>
    </td>
  </tr>
</table>

<table class="table">
  <colgroup>
  <col style="background-color: #8cd5ff;" width="150">
  <col >
  </colgroup>
<?php if(!empty($first_post)){
	$user = $users[$first_post['author_id']];
?>
  <tr>
    <td>
        <?php echo $user['username'];?><br/>
        <?php echo $user['group']['name'];?><br/>
        总分：<?php echo $user['credits'];?><br/>
        <?php foreach ($credit_name as $key => $val) {
                echo $val['view_name'].'：'.$user[$key].'<br/>';
            }
            ?>
    </td>
    <td>标题：<?php echo $first_post['subject'];?><br/>
        <?php echo "发表于：".timespan($first_post['post_time']);?><br/>
        内容：<?php echo $first_post['content'];?><br/>
        
        帖子选项：<br/>
        
        
        
        签名：<?php echo $user['signature'];?><br/>
    </td>
  </tr>
<?php }?>
  
  <?php
  if(!empty($posts)){
   foreach ($posts as $post) { 
      $user = $users[$post['author_id']];
      ?>
  <tr>
    <td>
        <?php echo $user['username'];?><br/>
        <?php echo $user['group']['name'];?><br/>
        总分：<?php echo $user['credits'];?><br/>
        <?php foreach ($credit_name as $key => $val) {
                echo $val['view_name'].'：'.$user[$key].'<br/>';
            }
            ?>
    </td>
    <td>标题：<?php echo $post['subject'];?><br/>
        <?php echo "发表于：".timespan($post['post_time']);?><br/>
        内容：<?php echo $post['content'];?><br/>
        签名：<?php echo $user['signature'];?><br/>
    </td>
  </tr>
  <?php  
     }
	}
    ?>
</table>

<?php empty($page) && $page = '';
echo $page;?>
<p style="text-align:right;">
  <input class="inp_btn" name="submit" type="submit" value="回复" onClick="location.href='<?php echo base_url('index.php/posts/reply/'.$topic['id']);?>'" />
</p>
