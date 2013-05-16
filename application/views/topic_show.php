
<table class="table2">
  <tr class="split">
    <td>
     <a href="">删除主题</a>
     <a href="">升降</a>
     <a href="">置顶</a>
     <a href="">高亮</a>
     <a href="">精华</a>
     <a href="">关闭</a>
     <a href="">移动</a>
     <a href="">分类</a>
     <a href="">复制</a>
     <a href="">合并</a>
     <a href="">切分</a>
     <a href="">屏蔽</a>
     <a href="">标签</a>
    </td>
  </tr>
</table>

<table class="table">
  <colgroup>
  <col style="background-color: #cecece;" width="150">
  <col >
  </colgroup>
  <?php foreach ($posts as $post) { 
      $user = $users[$post['author_id']];
      ?>
  <tr>
    <td>
        <?php echo $user['username'];?><br/>
        总分：<?php echo $user['credits'];?><br/>
        <?php foreach ($credit_name as $key => $val) {
                echo $val['view_name'].'：'.$user[$key].'<br/>';
            }
            ?>
    </td>
    <td>标题：<?php echo $post['subject'];?><br/>
        <?php echo "发表于：".timespan($post['post_time']);?><br/>
        内容：<?php echo $post['content'];?><br/>
    </td>
  </tr>
  <?php  
    }
    ?>
</table>

<?php empty($page) && $page = '';
echo $page;?>
<p style="text-align:right;">
  <input class="inp_btn" name="submit" type="submit" value="回复" onClick="location.href='<?php echo base_url('index.php/posts/reply/'.$topic['id']);?>'" />
</p>
