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
    
<!--主题帖子展示-->
<?php if(!empty($first_post)){ 
    $user = $users[$first_post['author_id']];
    ?>
<ul class="newsCot">
 <li class="clearfix">
        
  <div class="newsCotL">
    <div class="usFace pr">
    <a href="#"><img src="<?php echo base_url(!empty($user['icon'])?$user['icon']:'images/default.png');?>" alt="头像"></a>
    <span class="pa usFaceBg"></span>
      <span class="pa usFaceP"><?php echo $user['group']['name'];?></span>
      <i class="pa icoSj2"></i>
      <div class="usFaceInfoBox pa">
        <div class="usFaceInfo pr">

        <?php if($user['online']){echo '<div class="usFaceInfoTit">当前在线</div>';}else{echo '<div class="usFaceInfoTit cOffLine">当前不在线</div>';}?>
          <ul>
            <li class="usUid"><span>UID：</span><?php echo $user['id'];?></li>
            <li><span>注册时间：</span><?php echo date('Y-m-d H:i:s',$user['regdate']);?></li>
            <li><span>在线时间：</span><?php echo $user['online_time']?></li>
            <li><span>最后登录：</span><?php echo date('Y-m-d H:i:s',$user['last_login_time']);?></li>
        	<?php foreach ($credit_name as $key => $val) {
                echo "<li><span>{$val['view_name']}：</span>{$user[$key]} {$val['unit']}</li>";
            }
            ?>
            <li><span>总积分：</span><?php echo $user['credits'];?></li>
            <li><span>帖子：</span><?php echo $user['posts'];?></li>
          </ul>
          <div class="usFaceInfoBot">
              <a href="<?=$this->config->item('user_url').$user['id']?>" class="icoUs1">资料</a>
              <a href="<?=$this->config->item('user_url').$user['id']?>" class="icoUs2">串个门</a>
              <a href="<?=base_url('index.php/action/follow/'.$user['id'])?>" class="icoUs3" target="ajax">加关注</a>
          </div>
          <i class="pa"></i> </div>
      </div>
    </div>
    <div class="usName"><a href="<?=$this->config->item('user_url').$user['id']?>"><?php echo $user['username'];?></a></div>
    <ul class="usTip">
      <li><span class="fl">等级：</span><?php echo $user['stars_rank'];?></li>
      <li><span class="fl">积分：</span><?php echo $user['credits'];?></li>
      <li class="icoHonour">
      	<?php foreach($user['medals'] as $medal){?>
        	<img style="vertical-align:middle" src="<?php echo base_url('/images/medals/'.my_set_value('image', $medal));?>">
        <?php }?>
      </li>
    </ul>
  </div>
      <!--first_post-->
      <div class="newsCotR pr">
        <article class="newsCots">
          <h1 class="fyahei"><?= $first_post['subject']?></h1>
          
            <div class="newsTip">
            <span>发表于 <?php echo time_span($first_post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$first_post['topic_id'].'/?author='.$first_post['author_id']);?>">只看该作者</a></span>
            <span title="阅读数" class="icoEye"><?php echo $topic['views']?></span>
            <span title="回复数" class="icoMsg2"><?php echo $first_post['replies']?></span>
            </div>
          
          <div class="qaTop">
            <span><i class="icoAIng"></i>
                <?php if($first_post['best_answer'] == 0){
                    echo '未解决';
                }else{
                    echo '已解决';
                } ?>
            </span>
            <span><i class="icoMark"></i>赏金<em>   <?php echo $first_post['price'] ?>   </em>两</span>
          </div>
          
          <div class="newsCotIn">
          <?php echo $first_post['content'];?>
          </div>
        </article>
        
        <?php if(!empty($topic['log'])){?>
        	<div class="tcTop">本主题由<a href="<?php echo user_url($topic['log']['user_id'])?>"><?php echo $topic['log']['username'];?></a>于 <?php echo time_span($topic['log']['time'],'','','前');?>  <em><?php echo $topic['log']['action_name'];?></em></div>
        <?php }?>
        
        <div class="qa">
          <span class="mainCmtBtn">我来回答</span>
          <a style="display:none" href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/'.$first_post['id'])?>" target="dialog" width="464px" title="我来回答"> </a>
          <div class="qaBor">
            <div class="qaBorLi">
              <h4>问问专家</h4>
              <div class="qaBorLiTop pr">
                <a href="#"><img src="images/temp.jpg" alt="名称"></a>
                <p><a href="#">浪漫的杯子</a><strong>Flash问答区活跃用户</strong></p>
                <a href="#" class="pa">向TA提问</a>
              </div>
              <dl>
                <dt>相关问题：</dt>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
              </dl>
            </div>
            <div class="qaBorLi bordNo">
              <h4>Flash的专家</h4>
              <div class="qaBorLiTop pr">
                <a href="#"><img src="images/temp.jpg" alt="名称"></a>
                <p><a href="#">浪漫的杯子</a><strong>Flash问答区活跃用户</strong></p>
                <a href="#" class="pa">向TA提问</a>
              </div>
              <dl>
                <dt>相关问题：</dt>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
                <dd><a href="#" title="标题">江苏常熟“天上人间”酷似人民大会堂【高清组图】</a></dd>
              </dl>
            </div>
          </div>
        </div> 
          
        <?php if(!empty($topic['tags'])){?>
            <div class="myTag pr">
            <!--a href="#">Photoshop</a>,-->
                <?php echo join(' , ',$topic['tags']);?>
            <i class="pa"></i></div>
        <?php }?>
        
        <div class="orderBy">
          <span>回复排序列：</span>
          <ul>
            <li><a href="<?php echo base_url('index.php/topic/show/'.$first_post['topic_id']);?>" class="btnUserDeft">默认</a></li>
            <li><a href="<?php echo base_url('index.php/topic/show/'.$first_post['topic_id'].'/?order=supports');?>" class="btnUserDeft">支持数</a></li>
          </ul>
        </div>
        
        <ul class="newsBot pa">
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$first_post['id'])?>" target="dialog">举报</a></li>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$first_post['topic_id'].'/'.$first_post['id'])?>" class="icoGrade">编辑</a></li>
          <li><a href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/'.$first_post['id'])?>" target="dialog" width="464px" title="快速回复" class="icoReplys">回复</a></li>
        </ul>
      </div>
    </li>
  </ul>
<?php } ?>


<!--回复帖子循环展示-->
<?php if(!empty($posts)){?>
<ul class="newsCot">
<?php foreach ($posts as $post) {
    $user = $users[$post['author_id']];
?>
<li class="clearfix">
  <div class="newsCotL"><!--user-->
    <div class="usFace pr">
    <a href="#"><img src="<?php echo base_url(!empty($user['icon'])?$user['icon']:'images/default.png');?>" alt="头像"></a>
    <span class="pa usFaceBg"></span>
    <!--usFaceBg为红色背景 usFaceBg2为绿色背景 usFaceBg3为黄色背景-->
      <span class="pa usFaceP"><?php echo $user['group']['name'];?></span>
      <i class="pa icoSj2"></i>
      <div class="usFaceInfoBox pa">
        <div class="usFaceInfo pr">

        <?php if($user['online']){echo '<div class="usFaceInfoTit">当前在线</div>';}else{echo '<div class="usFaceInfoTit cOffLine">当前不在线</div>';}?>
          <ul>
            <li class="usUid"><span>UID：</span><?php echo $user['id'];?></li>
            <li><span>注册时间：</span><?php echo date('Y-m-d H:i:s',$user['regdate']);?></li>
            <li><span>在线时间：</span><?php echo $user['online_time']?></li>
            <li><span>最后登录：</span><?php echo date('Y-m-d H:i:s',$user['last_login_time']);?></li>
        	<?php foreach ($credit_name as $key => $val) {
                echo "<li><span>{$val['view_name']}：</span>{$user[$key]} {$val['unit']}</li>";
            }
            ?>
            <li><span>总积分：</span><?php echo $user['credits'];?></li>
            <li><span>帖子：</span><?php echo $user['posts'];?></li>
          </ul>
          <div class="usFaceInfoBot">
              <a href="<?=$this->config->item('user_url').$user['id']?>" class="icoUs1">资料</a>
              <a href="<?=$this->config->item('user_url').$user['id']?>" class="icoUs2">串个门</a>
              <a href="<?=base_url('index.php/action/follow/'.$user['id'])?>" class="icoUs3" target="ajax">加关注</a>
          </div>
          <i class="pa"></i> </div>
      </div>
    </div>
    <div class="usName"><a href="<?=$this->config->item('user_url').$user['id']?>"><?php echo $user['username'];?></a></div>
    <ul class="usTip">
      <li><span class="fl">等级：</span><?php echo $user['stars_rank'];?></li>
      <li><span class="fl">积分：</span><?php echo $user['credits'];?></li>
      <li class="icoHonour">
      	<?php foreach($user['medals'] as $medal){?>
        	<img style="vertical-align:middle" src="<?php echo base_url('/images/medals/'.my_set_value('image', $medal));?>">
        <?php }?>
      </li>
    </ul>
  </div><!--userend-->
        
      <div class="newsCotR pr">
          
        <div class="tr myState">
          <?php if(!empty($first_post['best_answer']) && $first_post['best_answer']==$post['id']){?>
            <span class="bestA"><i></i>最佳答案</span>
           <?php }?>
            <div class="newsTip">
            <span>发表于 <?php echo time_span($post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$post['topic_id'].'/?author='.$post['author_id']);?>">只看该作者</a></span>
            </div>
            <a name="p_<?=$post['id']?>">
            <?php if(empty($position_names[$post['position']])){
                          echo $post['position'].'#';
                  }else{
                          echo $position_names[$post['position']];
                  }?>
                  </a>
        </div>
        
        <article class="newsCots">
          <h2 class="fyahei"><?php echo $post['subject']?></h2>
          <div class="newsCotIn haveDig pr">
            <?php echo $post['content'];?>
            <div class="btnDig pa">
              <span class="btnUp"><a refresh="true" href="<?php echo base_url('index.php/action/support/'.$post['id'])?>" target="ajax">赞 <?php echo $post['supports'];?></a></span>
              <span class="btnDown"><a refresh="true" href="<?php echo base_url('index.php/action/oppose/'.$post['id'])?>" target="ajax">踩 <?php echo $post['opposes'];?></a></span>
            </div>
          </div>
        </article>
                
        <!-- 广告
        <div class="newsAD fsong"><i></i>本次大会更注难，并分享实战经验。为庆祝此次大会<cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a><cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a></div>
        -->
        <ul class="newsBot pa">
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$post['id'])?>" target="dialog">举报</a></li>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$post['topic_id'].'/'.$post['id'])?>" class="icoGrade">编辑</a></li>
          <li><a href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/'.$post['id'])?>" target="dialog" width="464px" title="快速回复" class="icoReplys">回复</a></li>
          <?php if($this->user['id']==$topic['author_id'] && !empty($first_post['best_answer'])){?>
          <li><a confirm="确定选择这个帖子为最佳答案么？" href="<?php echo base_url('index.php/action/select_answer/'.$post['id'])?>" target="ajax" title="选为最佳答案" class="icoEdit">最佳答案</a></li>
          <?php }?>
        </ul>
      </div>
    </li>
<?php } ?>
</ul>
  <?php } ?>  

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
      <li><a href="<?php echo base_url('index.php/action/reply/'.$topic['id']);?>">回复</a></li>
    </ul>
        <?php empty($page) && $page = '';
echo $page;?>
   </div>


  <div class="mainCmt" id="editor_reply">
    <h5>回复帖子</h5>
    <?php $this->load->view('reply_smiple');?>
  </div>

</div>
<script>
$(function(){
  $('.mainCmtBtn').click(function(){
	  $(this).next('a').click();
	});
});
</script>