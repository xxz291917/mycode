<!--content-->
<div class="wrap">
  <div class="myPos fsong">>
  <a href="<?php echo base_url();?>">论坛</a>>
  <?php 
  	$position_names = array(1=>'沙发',2=>'板凳',3=>'地板');
  	$nav_num = count($nav);
	foreach($nav as $key=>$val){
		$link = '<a href="'.$val[1].'">'.$val[0].'</a>>';
		if($nav_num == $key+1){
			$link = substr($link,0,-1);
		}
		echo $link;
	}
  ?>
  </div>
  
  <div class="menuPage clearfix">
    <ul class="menuTag">
      <li class="pr hasMenu"><a href="javascript:void(0);" class="icoPost">发帖</a>
        <div class="menuBox pa">
          <ul>
            <li class="icoSj"></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/1');?>" class="ico1" target="_blank">发表帖子</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/2');?>" class="ico3" target="_blank">发布问答</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/3');?>" class="ico2" target="_blank">发起投票</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/4');?>" class="ico4" target="_blank">发起辩论</a></li>
            <!--<li><a href="#" class="ico5">发起活动</a></li>
            <li><a href="#" class="ico6">出售商品</a></li>-->
          </ul>
        </div>
      </li>
      <li><a href="javascript:void(0);" onClick="location.href='<?php echo base_url('index.php/action/reply/'.$topic['id']);?>'">回复</a></li>
      <li class="pr hasMenu"><a href="javascript:void(0);" class="icoMag">管理菜单</a>
        <div class="menuBox pa">
          <ul class="menuList">
            <li class="icoSj"></li>
			<?php foreach($manage_arr as $key=>$val){?>
            <li><a target="dialog" href="<?php echo base_url('index.php/topic/manage/'.$val[0].'/'.$topic['id']);?>"><?=$val[1]?></a></li>
            <?php }?>
          </ul>
        </div>
      </li>
    </ul>
    <?php empty($page) && $page = '';
echo $page;?>
</div>

  <ul class="newsCot">
	<?php foreach ($posts as $post) { 
      $user = $users[$post['author_id']];
    ?>
    <li class="clearfix">
        <?php $this->load->view('left_user_view');?>


      <div class="newsCotR pr">
      <?php if($post['is_first']!=1){?>
          <div class="tr myState">
          
          <div class="newsTip">
          <span>发表于 <?php echo time_span($post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$post['topic_id'].'/?author='.$post['author_id']);?>">只看该作者</a></span>
          </div>
		  <?php
			if(empty($position_names[$post['position']])){
				echo $post['position'].'#';
			}else{
				echo $position_names[$post['position']];
			}
			?>
            
        </div>
        <?php }?>
        <article class="newsCots">
          <?php if($post['is_first']==1){?>
          <h1 class="fyahei"><?php echo $post['subject'];?></h1>
          <?php }elseif(!empty($post['subject'])){?>
          <h2 class="fyahei"><?php echo $post['subject'];?></h2>
          <?php }?>
<?php if($post['is_first']==1){?>
          <div class="newsTip">
          <span>发表于 <?php echo time_span($post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$post['topic_id'].'/?author='.$post['author_id']);?>">只看该作者</a></span>
          <?php if($post['is_first']==1){?>
          <span title="阅读数" class="icoEye"><?php echo $topic['views']?></span>
          <span title="回复数" class="icoMsg2"><?php echo $topic['replies']?></span>
          <?php }?>
          </div>
<?php }?>
          <div class="newsCotIn">
          <?php echo $post['content'];?>
          </div>
        </article>
        
        <!--
        <div class="download"> <span class="downloadPsw">解压密码:</span>
          <p>浪漫的杯子，如果您要查看本帖隐藏内容请<a href="#">回复</a></p>
          <div class="downloadUrl"><a href="#" target="_blank">Nape离线API文档.rar</a>(599.78 KB, 下载次数: 269)</div>
          <div class="orgUrl">原文链接：<a href="#">http://bbs.9ria.com/thread-120574-1-1.html</a></div>
        </div>
        
        <div class="reply clearfix pr">
          <div class="replyL">本帖评记记录：共<em>11</em>人评分 银子<em>+42</em></div>
          <div class="replyCot">
            <ul>
              <li>
                <ul>
                  <li class="td1"><a href="#"><img src="/images/temp.jpg" alt="我名" width="50" height="57" /></a></li>
                  <li class="td2"><a href="#">浪漫的杯子</a></li>
                  <li class="td3">+8</li>
                  <li class="td4">郭美美真是个NB的人啊！~</li>
                </ul>
              </li>
              <li>
                <ul>
                  <li class="td1"><a href="#"><img src="/images/temp.jpg" alt="我名" width="50" height="57"></a></li>
                  <li class="td2"><a href="#">浪漫的杯子</a></li>
                  <li class="td3">+8</li>
                  <li class="td4">郭美美真是个NB的人啊！~</li>
                </ul>
              </li>
            </ul>
            <div class="replyCotBot"> <span class="pageRep"><a href="#">上一页</a><a href="#">1</a><a href="#">2</a><a href="#">3</a>...<a href="#">4</a><a href="#">5</a><a href="#">下一页</a></span> <span class="btnGrade">我来评分</span> </div>
          </div>
          <span class="icoReply pa">收起回复</span> </div>
        -->
          <?php if($post['is_first']==1 && !empty($related_posts)){?>
          <div class="related">
          <h3>相关帖子</h3>
          <ul>
            <?php foreach ($related_posts as $key => $related) {?>
              <li><a href="" title="<?php echo $related['subject'];?>"><?php echo $related['subject'];?></a></li>
            <?php }?>
          </ul>
          </div>
          <?php }?>
          
        <ul class="newsBot pa">
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$post['id'])?>" target="dialog">举报</a></li>
          <?php if($post['is_first']==1){?>
          <li><a href="#" class="icoCollect">收藏</a></li>
          <?php }?>
          <!--li><a href="#" class="icoEdit">评分</a></li-->
          <li><a href="#" class="icoGrade">编辑</a></li>
          <li><a href="#" class="icoReplys">回复</a></li>
        </ul>
        
      </div>
      
    </li>

  <?php  
    }
    ?>
     </ul> 
    
  <div class="menuPage clearfix">
    <ul class="menuTag">
      <li class="pr hasMenu"><a href="javascript:void(0);" class="icoPost">发帖</a>
      
        <div class="menuBox pa">
          <ul>
            <li class="icoSj"></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/1');?>" class="ico1" target="_blank">发表帖子</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/2');?>" class="ico3" target="_blank">发布问答</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/3');?>" class="ico2" target="_blank">发起投票</a></li>
            <li><a href="<?php echo base_url('index.php/action/post/'.$topic['forum_id'].'/4');?>" class="ico4" target="_blank">发起辩论</a></li>
          </ul>
        </div>
        
      </li>
      <li><a href="javascript:void(0);">回复</a></li>
    </ul>
        <?php empty($page) && $page = '';
echo $page;?>
   </div>
  <div class="mainCmt">
    <h5>回复帖子</h5>
    <form>
      <textarea name="" cols="" rows="" class="inp"></textarea>
      <button class="mainCmtBtn">回复</button>
    </form>
  </div>
</div>
