<!--content-->
<div class="wrap clearfix">                                                                    
    <div class="myPos fsong">><a href="<?php echo base_url();?>">论坛</a></div>
    
    
    <div class="siteTip">
        <span class="fr">
        <?php if($this->user['id']>0){?>
            <a href="<?php echo base_url('/index.php/space/my_topic')?>">我的帖子</a>
        <?php }?>
        </span>
        <em>今日:</em><?=$totals['today_posts']?><i>|</i><em>总帖子:</em><?=$totals['posts']?><i>|</i><em>会员:</em><?=$totals['users']?><i>|</i><em>欢迎新会员:</em><?=$last_user['username']?>
    </div>
    <div class="hTop">
        <div id="lunbo">
            <div id="lunbo_bg"></div> 
            <div id="lunbo_info"></div>
            <ul>
                <li class="on">1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
                <li>5</li>
            </ul>
            <div id="lunbo_list">
                <?php foreach ($last_image_topics as $key => $topic) {
					if(empty($topic['path'])){continue;}
					?>
                <a href="<?php echo base_url('index.php/topic/show/'.$topic['topic_id'])?>" target="_blank"><img src="<?php echo base_url().$topic['path']?>" title="<?php echo $topic['subject']?>" alt="<?php echo $topic['description']?>" /></a>
                <?php }?>
            </div>
        </div>    
        <div class="topList">
            <h2>最新帖子</h2>
            <ol>
                <?php foreach ($new_topics as $key => $topic) {
                    $k = $key + 1;
                    $class = $k <= 3 ? 'class="topC"' : '';
                    if ($k > 8) {
                        break;
                    }
                ?>
                <li><i <?=$class?>><?=$k?></i><a href="<?php echo base_url('index.php/topic/show/'.$topic['id'])?>" title="<?php echo $topic['subject']?>"><?php echo $topic['subject']?></a></li>
                <?php }?>
            </ol>
        </div>
        <div class="topList">
            <h2>最新回复</h2>
            <ol>
                <?php foreach ($last_post_topics as $key => $topic) {
                    $k = $key + 1;
                    $class = $k <= 3 ? 'class="topC"' : '';
                    if ($k > 8) {
                        break;
                    }
                ?>
                <li><i <?=$class?>><?=$k?></i><a href="<?php echo base_url('index.php/topic/show/'.$topic['id'])?>" title="<?php echo $topic['subject']?>"><?php echo $topic['subject']?></a></li>
                <?php }?>
            </ol>
        </div>
        <dl class="topToday">
            <dt>今日排行</dt>
            <?php foreach($posts_users as $user){ ?>
            <dd>
                <figure>
                    <a href="<?php echo user_url($user['id'])?>"><img src="<?php echo user_icon($user['id'])?>" alt="<?=$user['username']?>"></a>
                    <figcaption><a href="<?php echo user_url($user['id'])?>" title="<?=$user['username']?>"><?=$user['username']?></a></figcaption>
                </figure>
            </dd>
            <?php } ?>
        </dl>
    </div>
    
    <?php 
    $num = count($forums);
    foreach ($forums as $key => $forum) {?>
        <h2 class="homeH2"><a href="<?php echo base_url('index.php/forum/show/'.$forum['id'])?>"><?=$forum['name']?></a></h2>
        
        <ul class="homeList  <?php if($key+1==$num){?>lastLi<?php }?>  ">
            <?php foreach ($forum['sub'] as $key => $sub) {
				if($sub['no_index']!=1){
                                    if(empty($sub['redirect_ask_id'])){
                                        $forum_url = base_url('index.php/forum/show/');
                                    }else{
                                        $forum_url = base_url('index.php/bbs/ask_show/');
                                    }
				?>
            <li class="pr">
                <h3><a href="<?=$forum_url.'/'.$sub['id']?>"><?=$sub['name']?></a><?php echo !empty($sub['today_posts'])?$sub['today_posts']:0?></h3>
                <p><strong>主题：</strong><?= !empty($sub['topics'])?$sub['topics']:0;?>,<strong> 帖数：</strong><?php echo !empty($sub['posts'])?$sub['posts']:0?></p>
                <a href="<?=$forum_url.'/'.$sub['id']?>"><img src="<?php echo base_url().my_set_value('icon',$sub,$this->config->item('forum_icon'))?>" class="pa" alt="图标"></a>
            </li>
            <?php } ?>
				<?php if(!empty($sub['sub'])){ foreach ($sub['sub'] as $key => $lite_sub) {
					if($lite_sub['no_index']==1){
						continue;
					}
                                        if(empty($lite_sub['redirect_ask_id'])){
                                            $forum_url = base_url('index.php/forum/show/');
                                        }else{
                                            $forum_url = base_url('index.php/bbs/ask_show/');
                                        }
					?>
                <li class="pr">
                    <h3><a href="<?=$forum_url.'/'.$lite_sub['id']?>"><?=$lite_sub['name']?></a><?php echo !empty($lite_sub['today_posts'])?$lite_sub['today_posts']:0?></h3>
                    <p><strong>主题：</strong><?= !empty($lite_sub['topics'])?$lite_sub['topics']:0;?>,<strong> 帖数：</strong><?php echo !empty($lite_sub['posts'])?$lite_sub['posts']:0?></p>
                    <a href="<?=$forum_url.'/'.$lite_sub['id']?>"><img src="<?php echo base_url().my_set_value('icon',$lite_sub,$this->config->item('forum_icon'))?>" class="pa" alt="图标"></a>
                </li>
                <?php }}?>
            <?php }?>
        </ul>
    <?php }?>
</div>