<!--content-->
<?php
$top_class = array(1=>'icoTop1',2=>'icoTop2',3=>'icoTop3');
$special_class = array(2=>'icoVote',3=>'icoCoin',4=>'icoVs');
$post_class = array(0=>'icoRepNo',1=>'icoRep');
?>
<div class="wrap clearfix">
    <div class="myPos fsong">>
        <a href="<?php echo base_url(); ?>">论坛</a><?php
        if (!empty($nav)) {
            echo '>';
            $nav_num = count($nav);
            $i = 0;
            foreach ($nav as $key => $val) {
                $i++;
                $link = '<a href="' . base_url('index.php/forum/show/' . $key) . '">' . $val . '</a>>';

                if ($nav_num == $i) {
                    $link = substr($link, 0, -1);
                }
                echo $link;
            }
        }
        ?>
    </div>
    <div class="col1 pr"> 
        <nav class="leftNav">
      <?php foreach($forums as $subforum){?>
      <dl>
        <dt><a href="javascript:void(0);"><?php echo $subforum['name']; ?></a></dt>
        	<?php 
			if(!empty($subforum['sub'])){
			foreach($subforum['sub'] as $sub){?>
        		<dd><a href="<?php echo base_url('index.php/forum/show/'.$sub['id']);?>"><?php echo $sub['name']; ?></a></dd>
        	<?php }}?>
      </dl>
      <?php }?>

        </nav>
        <span class="leftNavCtrl pa"></span>
    </div>
    <div class="col2">
        <div class="boardInfo">

            <div class="boardInfoTop">
                        <?php if (!empty($forum)) { ?>
                    <h3>
                        <a href="<?php echo base_url('index.php/bbs/ask/?forum_id=' . $forum['id']); ?>">
    <?php echo $forum['name'] ?>
                        </a>
                    </h3>

                    <span class="fl">
                        今日：<strong><?php echo isset($forum['today_posts']) ? $forum['today_posts'] : 0 ?></strong>
                        主题总数：<strong><?php echo isset($forum['topics']) ? $forum['topics'] : 0 ?></strong>
                    </span>

                    <span class="fr">
                        <!--<a href="#">收藏本版</a>
                        <a href="#" class="btnRss">订阅</a>-->
                        <i></i></span>
                </div>
            <?php } ?>

                <?php if (!empty($mannager)) { ?>
                <div class="boardMsgr">
                    <strong>版主：</strong>
                    <?php
                    foreach ($mannager as $user) {
                        $users[] = '<a href="' . user_url($user['id']) . '">' . $user['username'] . '</a>,';
                    }
                    echo join(',', $users);
                    ?>
                </div>
            <?php } ?>

            <!--推荐帖子-->
            <?PHP
            if (!empty($recommend_topics)) {
                foreach ($recommend_topics as $topic) {
                    echo '<p><strong><a href="' . base_url() . 'index.php/topic/show/' . $topic['id'] . '">' . $topic['subject'] . '</a></strong></p>';
                }
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
            </ul>

<?php empty($page) && $page = '';
echo $page; ?>

        </div>
        <div class="list">

                    <?php if (!empty($topic_categorys)) { ?>
                <div class="tags">
                    <strong><a href="<?= $category_url . '0' ?>">全部</a></strong>
                    <ul>
                <?php
                foreach ($topic_categorys as $topic_category) {
                    echo '<li><a href="' . $category_url . $topic_category['id'] . '">' . $topic_category['name'] . '</a></li>';
                }
                ?>
                    </ul>
                </div>
<?php } ?>
      <ul class="listCot listCotShow">
                <li class="listCotShowOrder">
                    <ul>
                        <li class="td1">筛选：</li>
                        <li class="td2">
                            <a href="<?= $order_url . 'views' ?>">查看数</a>
                            <a href="<?= $order_url . 'replies' ?>">回复数</a>
                            <a href="<?= $order_url . 'last_post_time' ?>">最后回复时间</a>
                        </li>
                        <li class="td4">作者</li>
                        <li class="td5">回复/查看</li>
                        <li class="td6">最后发表</li>
                    </ul>
                </li>
        
                <?php if (!empty($top_topics)) { ?>
                    <?php
                    foreach ($top_topics as $topic) {
                        if (!empty($topic['category_id'])) {
                            $topic_category = $topic_categorys[$topic['category_id']];
                        } else {
                            $topic_category = false;
                        }
                        $class = $top_class[$topic['top']];
                        ?>
                        
			<li>
                            <ul>
                                <li class="td1"><i class="<?=$class?>"></i></li>
                                <li class="td2">
                                    <strong>
        							<?php if (!empty($topic_category)) { ?>
                                            <a href="<?= $category_url . $topic_category['id'] ?>">[<?= $topic_category['name'] ?>]</a>
        							<?php } else { ?>
                                            [<?= '暂无分类' ?>]
        							<?php } ?>
                                    </strong>
                                    <a href="<?= base_url() . 'index.php/topic/show/' . $topic['id'] ?>" title="<?= $topic['subject'] ?>">
									<?php if(!empty($topic['highlight'])){
										echo highlight($topic['highlight'],$topic['subject']);
                                    }else{
										echo 	$topic['subject'];
									}?>
                                    </a>
                                </li>
                                <li class="td4">
                                    <a href="#"><img src="<?php echo user_icon($topic['author_id']) ?>" alt="<?= $topic['author'] ?>"></a>
                                    <span class="tdSpan1"><a href="<?= user_url($topic['author_id']) ?>"><?= $topic['author'] ?></a></span>
                                    <span class="tdSpan2"><?php echo time_span($topic['post_time'], '', 3600 * 24, '前'); ?></span>
                                </li>
                                <li class="td5">
                                    <span class="tdSpan1"><a href="<?= base_url() . 'index.php/action/reply/' . $topic['id'] ?>"><?= $topic['replies'] ?></a></span>
                                    <span class="tdSpan2"><?= $topic['views'] ?></span>
                                </li>
                                <li class="td6">
                                    <span class="tdSpan1">
                                        <?php if(!empty($topic['last_author'])){?>
                                        <a href="<?= user_url($topic['last_author_id']) ?>"><?= $topic['last_author'] ?></a>
                                        <?php }else{?>
                                        无
                                        <?php }?>
                                    </span>
                                    <span class="tdSpan2">
                                        <?php if(!empty($topic['last_post_time'])){?>
                                        <?php echo time_span($topic['last_post_time'], '', 3600 * 24, '前'); ?>
                                        <?php }?>
                                    </span>
                                </li>
                            </ul>
                        </li>
					<?php } ?>
                        <div class="blkTit">版块主题</div>
                <?php }?>
           </ul>
      
            <ul class="listCot listCotShow">
                <?php if (!empty($topics)) { ?>
                    <?php
                    foreach ($topics as $topic) {
                        if (!empty($topic['category_id']) && isset($topic_categorys[$topic['category_id']])) {
                            $topic_category = $topic_categorys[$topic['category_id']];
                        } else {
                            $topic_category = false;
                        }
                        if($topic['recommend'] > 0){
                            $class = 'icoRecd';
                        }elseif($topic['special'] > 1){
                            $class = $special_class[$topic['special']];
                        }else{
                            $class = ($this->time-$topic['last_post_time']>3600*24)?$post_class[0]:$post_class[1];
                        }
                        ?>
                        <li>
                            <ul>
                                <li class="td1"><i class="<?=$class?>"></i></li>
                                <li class="td2">
                                    <strong>
        							<?php if (!empty($topic_category)) { ?>
                                            <a href="<?= $category_url . $topic_category['id'] ?>">[<?= $topic_category['name'] ?>]</a>
        							<?php } else { ?>
                                            [<?= '暂无分类' ?>]
        							<?php } ?>
                                    </strong>
                                    <a href="<?= base_url() . 'index.php/topic/show/' . $topic['id'] ?>" title="<?= $topic['subject'] ?>">
									<?php if(!empty($topic['highlight'])){
										echo highlight($topic['highlight'],$topic['subject']);
                                    }else{
										echo 	$topic['subject'];
									}?>
                                    </a>
                                </li>
                                <li class="td4">
                                    <a href="#"><img src="<?php echo user_icon($topic['author_id']) ?>" alt="<?= $topic['author'] ?>"></a>
                                    <span class="tdSpan1"><a href="<?= user_url($topic['author_id']) ?>"><?= $topic['author'] ?></a></span>
                                    <span class="tdSpan2"><?php echo time_span($topic['post_time'], '', 3600 * 24, '前'); ?></span>
                                </li>
                                <li class="td5">
                                    <span class="tdSpan1"><a href="<?= base_url() . 'index.php/action/reply/' . $topic['id'] ?>"><?= $topic['replies'] ?></a></span>
                                    <span class="tdSpan2"><?= $topic['views'] ?></span>
                                </li>
                                <li class="td6">
                                    <span class="tdSpan1">
                                        <?php if(!empty($topic['last_author'])){?>
                                        <a href="<?= user_url($topic['last_author_id']) ?>"><?= $topic['last_author'] ?></a>
                                        <?php }else{?>
                                        无
                                        <?php }?>
                                    </span>
                                    <span class="tdSpan2">
                                        <?php if(!empty($topic['last_post_time'])){?>
                                        <?php echo time_span($topic['last_post_time'], '', 3600 * 24, '前'); ?>
                                        <?php }?>
                                    </span>
                                </li>
                            </ul>
                        </li>
    <?php } ?>
<?php } else { ?>
                    <li>没有符合条件的帖子。</li>
            <?php } ?>
            </ul>

        </div>
        
        <div class="menuPage clearfix">

<?php if (!empty($forum_id)) { ?>
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
                </ul>
<?php } ?>

<?php empty($page) && $page = '';
echo $page; ?>

        </div>
    </div>

</div>