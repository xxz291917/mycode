<!--我的帖子-->
     <ul class="tblList">
         <li class="th">
         <ul>
            <li class="td5 td8">帖子</li>
            <li class="td4">版块</li>
            <li class="td6">回复/浏览</li>
          </ul>
        </li>
        <?php 
          !isset($my_topic) && $my_topic = array();
            foreach ($my_topic as $key => $topic) {
        ?>
       
        <li>
          <ul>
            <li class="td5 td8"><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}"); ?>" target="_blank" ><?= $topic['subject'] ?></a><span></span></li>
            <li class="td4 f14"><a href="#" title="爱世界爱杯子"><?= $topic['forum_id'] ?></a></li>
            <li class="td6 f14"><a href="#"><?= $topic['replies'] ?></a>/<?= $topic['views'] ?></li>
          </ul>
        </li>
            <?php } ?>
      </ul>
      <div class="pagenum"><?php echo $page; ?></div>
    
