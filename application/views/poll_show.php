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
            <li><span>最后登录：</span><?php echo empty($user['last_login_time'])?0:date('Y-m-d H:i:s',$user['last_login_time']);?></li>
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
          
          <div class="newsCotIn">
          <?php echo $first_post['content'];?>
          </div>
        </article>
        <?php if(!empty($topic['log'])){?>
        <div class="tcTop">本主题由<a href="<?php echo user_url($topic['log']['user_id'])?>"><?php echo $topic['log']['username'];?></a>于 <?php echo time_span($topic['log']['time'],'','','前');?>  <em><?php echo $topic['log']['action_name'];?></em></div>
        <?php }?>
        <!--投票 start-->
        <div class="vote">
          <p>
		<?php if($first_post['is_multiple']){
                    echo '多选';
                }else{
                    echo '单选';
                }
            ?>投票，共有 <?=$first_post['voters']?> 名用户参与了投票  
            <?php if(0&&$first_post['is_visible']){?>（查看投票参与人）<?php }?></p>
          <p>
          <?php
          if(empty($first_post['expire_time']) || $this->time < $first_post['expire_time']){
			$is_over = false;
          	echo '距离投票结束还有：<strong>'. time_span($this->time,$first_post['expire_time'],0).'</strong>';
          }else{
			$is_over = true;
          	echo '投票已于<strong>'. date('Y-m-d H:i:s',$first_post['expire_time']).'</strong> 结束，不能投票。';
          }
          ?>
          </p>
          
        <?php
        $create_function = $first_post['is_multiple'] ? 'form_checkbox' : 'form_radio';
        echo form_open(base_url('index.php/poll/submit/' . $first_post['topic_id']), array('target' => 'ajax', 'title'=>'投票', 'refresh' => 'true'));
        echo '<ol>';
        foreach ($first_post['options'] as $key => $option) {
            echo '<li>';
            $data = array(
                'name' => 'option_' . $first_post['topic_id'] . '[]',
                'value' => $option['id'],
            );
            echo '<label>';
            echo '<span class="fl">';
            echo ($first_post['is_vote'] && !$is_over) ? $create_function($data) : (($key+1).',');
            echo '</span>';
            echo '<p>'.$option['option'].'</p>';
            echo '</label>';
            if (!empty($first_post['percent'])) {
                echo '<div class="voteNums">';
                echo '<span><i style="width:'.$option['percent'].'%;background:#'.dechex(rand(3355443,13421772)).';"></i></span>';
                echo '<em>'.$option['percent'].'%</em>';
                echo '</div>';
            }
            echo '</li>';
        }
        echo '</ol>';
        if ($first_post['is_vote'] && !$is_over) {
            echo form_submit(array('name'=>'submit','class'=>'mainCmtBtn'), '投票');
        }
        echo form_close();
        ?>

        </div>
        <!--投票 end-->   

        <?php if(!empty($topic['tags'])){?>
            <div class="myTag pr">
            <!--a href="#">Photoshop</a>,-->
                <?php echo join(' , ',$topic['tags']);?>
            <i class="pa"></i></div>
        <?php }?>
        
        <ul class="newsBot pa">
          <?php if($base_permission['report']){?>
          <li class="fl"><a href="<?php echo base_url('index.php/action/report/'.$first_post['id'])?>" target="dialog">举报</a></li>
          <?php }?>
          <li><a href="<?=base_url('index.php/action/collect/'.$topic['id'])?>" class="icoCollect" target="ajax">收藏</a></li>
          <?php if($manage_permission['edit'] || $this->biz_permission->get_manage_permission_by_owner('edit',$first_post['author_id'])){?>
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
<?php if(!empty($posts)){?>
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
            <li><span>最后登录：</span><?php echo empty($user['last_login_time'])?0:date('Y-m-d H:i:s',$user['last_login_time']);?></li>
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
          
        <div class="tr myState myState">
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
          <?php } ?>
          <?php if($manage_permission['edit'] || $this->biz_permission->get_manage_permission_by_owner('edit',$post['author_id'])){?>
          <li><a href="<?php echo base_url('index.php/action/edit/'.$post['topic_id'].'/'.$post['id'])?>" class="icoGrade">编辑</a></li>
          <?php } ?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoCite" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/'.$post['id'])?>" target="dialog" width="464px" >引用</a></li>
          <?php } ?>
          <?php if($base_permission['reply']){?>
          <li><a class="icoReplys" href="<?php echo base_url('index.php/action/reply_dialog/'.$post['topic_id'].'/')?>" target="dialog" width="464px" title="快速回复">回复</a></li>
          <?php } ?>
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


  <div class="mainCmt" id="editor_reply">
    <h5>回复帖子</h5>
    <?php $this->load->view('reply_smiple');?>
  </div>

</div>