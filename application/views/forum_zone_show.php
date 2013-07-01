<!--content-->
<div class="wrap clearfix">                                                                    
    <div class="myPos fsong">><a href="<?php echo base_url();?>">论坛</a></div>
        <!--
        <span class="fr">
            <a href="#">我的帖子</a><i>|</i><a href="#">查看新帖</a>
        </span>-->
    <?php 
    foreach ($forums as $key => $forum) {?>
        <h2 class="homeH2"><a href="<?php echo base_url('index.php/forum/show/'.$forum['id'])?>"><?=$forum['name']?></a></h2>
        
        <ul class="homeList lastLi">
            <?php foreach ($forum['sub'] as $key => $sub) {?>
            <li class="pr">
                <h3><a href="<?=base_url()?>index.php/forum/show/<?=$sub['id']?>"><?=$sub['name']?></a><?php echo !empty($sub['today_posts'])?$sub['today_posts']:0?></h3>
                <p><strong>主题：</strong><?= !empty($sub['topics'])?$sub['topics']:0;?>,<strong> 帖数：</strong><?php echo !empty($sub['posts'])?$sub['posts']:0?></p>
                <a href="<?=base_url()?>index.php/forum/show/<?=$sub['id']?>"><img src="<?php echo base_url().my_set_value('icon',$sub,$this->config->item('forum_icon'))?>" class="pa" alt="图标"></a>
            </li>
            <?php }?>
        </ul>
    <?php }?>
</div>
