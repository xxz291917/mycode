<?php if(!empty($sub_forums)){?>

<table class="table2">
  <colgroup>
  <col>
  <col width="50">
  <col width="250">
  <col style="color:#F00;">
  </colgroup>
  <tr class="split">
    <td colspan="3">子版块</td>
  </tr>
  <?php foreach ($sub_forums as $sub) { ?>
  <tr>
    <td><a href="<?=base_url()?>index.php/forum/show/<?=$sub['id']?>">
      <?=$sub['name']?>
      </a></td>
    <td><?php
                if (isset($sub['topics'])) {
                    echo "{$sub['topics']} / {$sub['posts']}";
                } else {
                    echo '0 / 0';
                }
                ?></td>
    <td><?php
                if (isset($sub['topics'])) {
                    echo "<a href=\"".base_url()."index.php/topics/show\">{$sub['subject']}</a> <br/>{$sub['last_post_time']}前 {$sub['last_author']}";
                } else {
                    echo '从未';
                }
                ?></td>
  </tr>
  <?php 
    }
    ?>
</table>
<?php }?>
<br />
<br />

<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="发帖" onClick="location.href='<?php echo base_url('index.php/posts/post/'.$forum['id']);?>'" />
</p>


<table class="table">
  <colgroup>
  <col>
  <col width="150">
  <col width="150">
  <col width="150">
  </colgroup>
  <tr class="split">
    <td colspan="4">帖子列表</td>
  </tr>
  <thead>
    <tr>
      <td >精华|推荐</td>
      <td >作者</td>
      <td >回复/查看</td>
      <td >最后发表</td>
    </tr>
  </thead>
  <?php if(!empty($topics)){
        foreach ($topics as $topic) { ?>
  <tr>
    <td><a href="<?=base_url()?>index.php/topic/show/<?=$topic['id']?>">
      <?=$topic['subject']?>
      </a></td>
    <td><?php echo "{$topic['author']} <br/> ".time_span($topic['post_time']);?></td>
    <td><?php echo "{$topic['replies']} / {$topic['views']}";?></td>
    <td><?php echo "{$topic['last_author']} <br/> ".time_span($topic['last_post_time']);?></td>
  </tr>
  <?php 
        }    
    }
    ?>
</table>
<?php empty($page) && $page = '';
echo $page;?>
