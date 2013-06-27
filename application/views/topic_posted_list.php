<?php $this->load->view('header'); ?>
<!--content-->
<div class="wrap bgWhite clearfix">
  <div class="col3">    
    <h3 class="tagA mt20"><a href="#" class="current">我的帖子</a><a href="#">我的回复</a></h3>
    <div class="tagACot">
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
            <li class="td6 f14"><a href="#"><?= $topic['replies'] ?></a>/<?= $topic['view'] ?></li>
          </ul>
        </li>
            <?php } ?>
      </ul>
      <div class="pagenum"><a href="#" class="btnPre"></a><a href="#" class="current">1</a><a href="#">2</a><a href="#">3</a><a href="#">4</a><a href="#">5</a><a href="#">6</a><a href="#">7</a><a href="#">8</a>...<a href="#">100</a><a href="#" class="btnNext"></a></div>
    </div>
   </div>  
   <div class="col4">
       <?php $this->load->view('space_right'); ?>
   </div>    
</div>
<!--footer-->
<?php $this->load->view('footer'); ?>