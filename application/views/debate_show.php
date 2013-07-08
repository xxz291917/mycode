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
      <?php if(!empty($manage_arr)){?>
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
      <?php }?>
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
    <a href="<?php echo user_url($user['id']);?>"><img src="<?php echo user_icon($user['id']);?>" alt="头像"></a>
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
              <a href="<?=user_url($user['id'])?>" class="icoUs1">资料</a>
              <a href="<?=user_url($user['id'])?>" class="icoUs2">串个门</a>
              <a href="<?=base_url('index.php/action/follow/'.$user['id'])?>" class="icoUs3" target="ajax">加关注</a>
          </div>
          <i class="pa"></i> </div>
      </div>
    </div>
    <div class="usName"><a href="<?=user_url($user['id'])?>"><?php echo $user['username'];?></a></div>
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
            <span title="回复数" class="icoMsg2"><?php echo $topic['replies']?></span>
            </div>
          
          <div class="endInfo">
            <?php 
            $isend = false;
            if(!empty($first_post['debate']['best_debater'])){
                $isend = true;
                $result = array(0=>'平局',1=>'红方获胜',2=>'蓝方获胜');
                ?>
              <ul>
                 <li><strong>辩论结果：</strong><strong><?php echo $result[$first_post['debate']['winner']]?></strong></li>
                 <li><strong>评判时间：</strong><?php echo time_span($first_post['debate']['end_time'],'','',' 前')?></li>
                 <li><strong>裁判观点：</strong>
                     <?php echo $first_post['debate']['umpire_point']?>
                 </li>
                 <li><strong>最佳辩手：</strong><?php echo $first_post['debate']['best_debater']?></li>
             </ul>
            <?php }?>
              <p class="tc fb">结束时间：<?php if(!empty($first_post['debate']['end_time'])){
                echo date('Y-m-d H:i:s',$first_post['debate']['end_time']);
              }else{
                echo '等待裁判判决';
              }?>&nbsp;&nbsp;&nbsp;&nbsp;裁判：<?php echo $first_post['debate']['umpire']?></p>
            <?php if($first_post['debate']['umpire'] == $this->user['username']){?>
              <a href="<?php echo base_url('index.php/action/debate_end/'.$first_post['topic_id']);?>" target="dialog">
                  <?php if($isend){
                    echo '编辑裁判观点';
                  }else{
                    echo '结束此次辩论';
                  }?>
              </a>
            <?php }?>
          </div>
          
          <div class="newsCotIn">
          <?php echo $first_post['content'];?>
          </div>
        </article>
        <?php if(!empty($topic['log'])){?>
        <div class="tcTop">本主题由<a href="<?php echo user_url($topic['log']['user_id'])?>"><?php echo $topic['log']['username'];?></a>于 <?php echo time_span($topic['log']['time'],'','','前');?>  <em><?php echo $topic['log']['action_name'];?></em></div>
        <?php }?>
<!-- 辩论帖特有的展示-->
        <div class="debate">
          <div class="debateTit">
            <span class="btnUp">顶</span>
            <div class="voteNum">
              <span class="voteNumL" style="width:<?=$first_post['debate']['affirm_percent']?>%;"><?=$first_post['debate']['affirm_votes']?>票</span>
              <span class="voteNumR" style="width:<?=$first_post['debate']['negate_percent']?>%;"><?=$first_post['debate']['negate_votes']?>票</span>
            </div>
            <span class="btnUp2">顶</span>
          </div>
          
          
          <div class="debateCot pr">
            <div class="debateCotLi">
              <p class="thesis pr"><?=$first_post['debate']['affirm_point']?><span></span><i class="icoSj pa"></i></p>
              <div  class="thesisUs">
              <?php if(!empty($first_post['debate']['affirm_first'])){?>
                <a href="<?= user_url($first_post['debate']['affirm_first']['author_id'])?>">
                    <img src="<?php echo user_icon($first_post['debate']['affirm_first']['author_id'])?>" alt="<?=$first_post['debate']['affirm_first']['author']?>">
                </a>
                <p>
                    <a href="<?= user_url($first_post['debate']['affirm_first']['author_id'])?>">
                      <?=$first_post['debate']['affirm_first']['author']?>
                    </a>：
                        <?php echo html_escape(utf8_substr($first_post['debate']['affirm_first']['content'],0,30))?> 
                </p>
              <?php }?>
              </div>
              <ul>
              	<?php foreach($first_post['debate']['affirm_users'] as $user){?>
                	<li><a href="<a href="<?= user_url($user['user_id'])?>"><?=$user['username']?></a>">
                    <img src="<?php echo user_icon($user['user_id'])?>" alt="<?=$user['username']?>"></a></li>
                <?php }?>
              </ul>
              <a href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/?stand=1')?>" target="dialog" width="464px" title="发表观点" class="postView">发表红方观点</a>
            </div>
              
            <div class="debateCotLi userBlue">
              <p class="thesis pr"><?=$first_post['debate']['negate_point']?><span></span><i class="icoSj pa"></i></p>
              <div  class="thesisUs">
              <?php if(!empty($first_post['debate']['negate_first'])){?>
                <a href="<?= user_url($first_post['debate']['negate_first']['author_id'])?>"><img src="<?php echo user_icon($first_post['debate']['negate_first']['author_id'])?>" alt="<?=$first_post['debate']['negate_first']['author']?>"></a>
                <p><a href="<?= user_url($first_post['debate']['negate_first']['author_id'])?>"><?=$first_post['debate']['negate_first']['author']?></a>：<?php echo html_escape(utf8_substr($first_post['debate']['negate_first']['content'],0,30))?> </p>
              <?php }?>
              </div>
              <ul>
              	<?php foreach($first_post['debate']['negate_users'] as $user){?>
                	<li><a href="<a href="<?= user_url($user['user_id'])?>"><?=$user['username']?></a>">
                    <img src="<?php echo user_icon($topic['user_id'])?>" alt="<?=$user['username']?>"></a></li>
                <?php }?>
              </ul>
              <a href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/?stand=2')?>" target="dialog" width="464px" title="发表观点" class="postView">发表蓝方观点</a>
            </div>
              
            <span class="debateCotHr pa"></span>
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
            <li><a href="<?php echo base_url('index.php/topic/show/'.$first_post['topic_id'].'/?stand=1');?>" class="btnUserRed">红方</a></li>
            <li><a href="<?php echo base_url('index.php/topic/show/'.$first_post['topic_id'].'/?stand=2');?>" class="btnUserBlue">蓝方</a></li>
          </ul>
        </div>
        
        <ul class="newsBot pa">
          <?php if($base_permission['report']){?>
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$first_post['id'])?>" target="dialog">举报</a></li>
          <?php }?>
          <li><a href="<?=base_url('index.php/action/collect/'.$topic['id'])?>" class="icoCollect" target="ajax">收藏</a></li>
          <?php if($manage_permission['edit']){?>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$first_post['topic_id'].'/'.$first_post['id'])?>" class="icoGrade">编辑</a></li>
          <?php }?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoCite" href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/'.$first_post['id'])?>" target="dialog" width="464px" >引用</a></li>
          <?php }?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoReplys" href="<?php echo base_url('index.php/action/reply_dialog/'.$first_post['topic_id'].'/')?>" target="dialog" width="464px" title="快速回复">回复</a></li>
          <?php }?>
          
        </ul>
      </div>
    </li>
  </ul>
<?php } ?>


<!--回复帖子循环展示-->

<ul class="newsCot">
<?php foreach ($posts as $post) {
    $user = $users[$post['author_id']];
?>
<li class="clearfix">
  <div class="newsCotL"><!--user-->
    <div class="usFace pr">
    <a href="<?php echo user_url($user['id']);?>"><img src="<?php echo user_icon($user['id']);?>" alt="头像"></a>
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
              <a href="<?=user_url($user['id'])?>" class="icoUs1">资料</a>
              <a href="<?=user_url($user['id'])?>" class="icoUs2">串个门</a>
              <a href="<?=base_url('index.php/action/follow/'.$user['id'])?>" class="icoUs3" target="ajax">加关注</a>
          </div>
          <i class="pa"></i> </div>
      </div>
    </div>
    <div class="usName"><a href="<?=user_url($user['id'])?>"><?php echo $user['username'];?></a></div>
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
          
        <div class="tr myState myState2">
          <?php if(!empty($post['stand'])){?>
            <?php if(1==$post['stand']){?>
            <span class="btnLRed">红方</span>
            <?php }elseif(2==$post['stand']){?>
            <span class="btnLBlue">蓝方</span>
            <?php }?>
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
          <div class="newsCotIn">
            <?php echo $post['content'];?>
          </div>
        </article>
                
        <!-- 广告
        <div class="newsAD fsong"><i></i>本次大会更注难，并分享实战经验。为庆祝此次大会<cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a><cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a></div>
        -->
        <ul class="newsBot pa">
          <?php if($base_permission['report']){?>
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$post['id'])?>" target="dialog">举报</a></li>
          <?php }?>
          <?php if($manage_permission['edit']){?>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$post['topic_id'].'/'.$post['id'])?>" class="icoGrade">编辑</a></li>
          <?php }?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoCite" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/'.$post['id'])?>" target="dialog" width="464px" >引用</a></li>
          <?php }?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoReplys" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/')?>" target="dialog" width="464px" title="快速回复">回复</a></li>
          <?php }?>
        </ul>
      </div>
    </li>
<?php } ?>
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
  $('.btnUp').click(function(){
	  var url = '<?php echo base_url('index.php/action/debate_vote/'.$topic['id'].'/1');?>';
	  $.getJSON(url, function(data){
		  if(!data.success){
				$.Alert(data.message);
			}else{
				$.Alert(data.message);
				html.dialog("close");
			}
		});
	});
  $('.btnUp2').click(function(){
	  var url = '<?php echo base_url('index.php/action/debate_vote/'.$topic['id'].'/2');?>';
	  	  $.getJSON(url, function(data){
		  if(!data.success){
				$.Alert(data.message);
			}else{
				$.Alert(data.message);
				html.dialog("close");
			}
		});
	});
});
</script>