
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
        <?php echo "发表于：".time_span($first_post['post_time']);?><br/>
        内容：<?php echo $first_post['content'];?><br/>
        
        <hr/>
<?php if($first_post['is_multiple']){
		echo '多选';
	}else{
		echo '单选';
	}
?>
投票，共有<?=$first_post['voters']?>名用户参与了投票（查看投票参与人）<br/>
距离投票结束还有：<?php echo time_span($this->time,$first_post['expire_time'],0);?>  <br/>
      	<?php
		$create_function = $first_post['is_multiple']?'form_checkbox':'form_radio';
		echo form_open(base_url('index.php/topic/poll/'.$first_post['topic_id']));
		foreach($first_post['options'] as $option){
			$data = array(
				'name'        => 'option_'.$first_post['topic_id'],
				'value'       => $option['id'],
				'style'       => 'margin:10px',
				);
			echo $create_function($data).$option['option'].'<br/>';
			}
			echo form_submit('submit','投票');
		echo form_close();
			?>
<hr/>        
        
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
        <?php echo "发表于：".time_span($post['post_time']);?><br/>
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
