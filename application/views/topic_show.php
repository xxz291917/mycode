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
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/1'); ?>" class="ico1" target="_blank">发表帖子</a></li>
            
            <?php if(in_array(2,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/2'); ?>" class="ico3" target="_blank">发布问答</a></li>
            <?php }?>
            
            <?php if(in_array(3,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/3'); ?>" class="ico2" target="_blank">发起投票</a></li>
            <?php }?>
            
            <?php if(in_array(4,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/4'); ?>" class="ico4" target="_blank">发起辩论</a></li>
            <?php }?>
          </ul>
        </div>
      </li>
      <li><a href="<?php echo base_url('index.php/action/reply/'.$topic['id']);?>">回复</a></li>
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

  <ul class="newsCot">
    <?php foreach ($posts as $post) { 
      $user = $users[$post['author_id']];
    ?>
        
<li class="clearfix">
    
  <div class="newsCotL">
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
  </div>
  

      <div class="newsCotR pr">
      <?php if($post['is_first']!=1){?>
          <div class="tr myState">
          
          <div class="newsTip">
          <span>发表于 <?php echo time_span($post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$post['topic_id'].'/?author='.$post['author_id']);?>">只看该作者</a></span>
          </div>
          <a name="p_<?=$post['id']?>">
		  <?php
			if(empty($position_names[$post['position']])){
				echo $post['position'].'#';
			}else{
				echo $position_names[$post['position']];
			}
			?></a>
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
          
          <?php if($post['is_first']==1){?>
        <?php if(!empty($topic['log'])){?>
        <div class="tcTop">本主题由<a href="<?php echo user_url($topic['log']['user_id'])?>"><?php echo $topic['log']['username'];?></a>于 <?php echo time_span($topic['log']['time'],'','','前');?>  <em><?php echo $topic['log']['action_name'];?></em></div>
        <?php }?>
                <?php if (!empty($related_posts)) { ?>
                    <div class="related">
                        <h3>相关帖子</h3>
                        <ul>
                            <?php foreach ($related_posts as $key => $related) { ?>
                                <li><a href="<?php echo base_url('index.php/topic/show/' . $related['id']) ?>" title="<?php echo $related['subject']; ?>"><?php echo $related['subject']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
          <?php }?>

        <?php if (!empty($comments[$post['id']])) { ?>
        <div class="cmtCot">
          <span class="btnCmt">点评</span>
          <?php foreach($comments[$post['id']] as $comment){?>
          <a href="<?php echo user_url($comment['user_id'])?>"><img src="<?php echo user_icon($comment['user_id'])?>" alt="<?php echo $comment['username']?>"></a>
          <div class="cmtCotR"><a href="<?php echo user_url($comment['user_id'])?>"><?php echo $comment['username']?></a><?php echo $comment['comment'];?><span><em>发表于：</em><?php echo time_span($comment['time'], '', '', '前');?></span></div>
          <?php } ?>
        </div>
        <?php } ?>
        
        <?php if($post['is_first']==1 && !empty($topic['tags'])){?>
            <div class="myTag pr">
            <!--a href="#">Photoshop</a>,-->
                <?php echo join(' , ',$topic['tags']);?>
            <i class="pa"></i></div>
        <?php }?>
          
        <ul class="newsBot pa">
          <?php if($base_permission['report']){?>
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$post['id'])?>" target="dialog">举报</a></li>
          <?php }?>
          
          <?php if($post['is_first']==1){?>
          <li><a href="<?=base_url('index.php/action/collect/'.$topic['id'])?>" class="icoCollect" target="ajax">收藏</a></li>
          <?php }?>
          
          <!--li><a href="#" class="icoEdit">评分</a></li-->
          <?php if($manage_permission['edit'] || $this->biz_permission->get_manage_permission_by_owner('edit',$post['author_id'])){?>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$post['topic_id'].'/'.$post['id'])?>" class="icoGrade">编辑</a></li>
          <?php }?>
          
          <?php if($base_permission['reply']){?>
          <li><a class="icoEdit" href="<?php echo base_url('index.php/action/comment/'.$post['topic_id'].'/'.$post['id'])?>" target="dialog" width="464px">点评</a></li>
          <li><a class="icoCite" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/'.$post['id'])?>" target="dialog" width="464px" >引用</a></li>
          <?php }?>
          
          <?php if($base_permission['reply']){?>
          <li><a class="icoReplys" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/')?>" target="dialog" width="464px" title="快速回复">回复</a></li>
          <?php }?>
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
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/1'); ?>" class="ico1" target="_blank">发表帖子</a></li>
            
            <?php if(in_array(2,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/2'); ?>" class="ico3" target="_blank">发布问答</a></li>
            <?php }?>
            
            <?php if(in_array(3,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/3'); ?>" class="ico2" target="_blank">发起投票</a></li>
            <?php }?>
            
            <?php if(in_array(4,$forum['allow_special'])){?>
            <li><a href="<?php echo base_url('index.php/action/post/' . $forum_id . '/4'); ?>" class="ico4" target="_blank">发起辩论</a></li>
            <?php }?>
          </ul>
        </div>
      </li>
      <li><a href="<?php echo base_url('index.php/action/reply/'.$topic['id']);?>">回复</a></li>
    </ul>
        <?php empty($page) && $page = '';
echo $page;?>
   </div>
    
  <div class="mainCmt">
    <h5>回复帖子</h5>
    <?php $this->load->view('reply_smiple');?>
  </div>
    
</div>
