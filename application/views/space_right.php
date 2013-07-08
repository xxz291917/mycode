<div class="myInfo">
    <a href="#"><img src="<?php echo user_icon($this->user['id'])?>" alt="<?php echo $this->user['username']?>"></a>
    <h4><a href="<?php echo user_url($this->user['id'])?>"><?php echo $this->user['username']?></a><a href="<?php echo $this->config->item('url_setting');?>" class="icoSet"></a></h4>
    <p>
        <span><strong>粉丝：</strong>55</span>
        <span><strong>关注：</strong>55</span>
    </p>
</div>
<ul class="myMsg">
    <li <?= ($menu == 1) ? ' class="current"' : ''; ?> ><a href="<?= base_url() ?>index.php/space/my_credit/t/default" class="icoMark">我的积分</a></li>
    <li <?= ($menu == 2) ? ' class="current"' : ''; ?> ><a href="<?= base_url() ?>index.php/space/my_topic"  class="icoPost">我的帖子</a></li>
    <li <?= ($menu == 3) ? ' class="current"' : ''; ?>><a href="<?= base_url() ?>index.php/space/my_topic" class="icoRemind">我的提醒</a></li>
    <!--li <?= ($menu == 4) ? ' class="current"' : ''; ?>><a href="<?= base_url() ?>index.php/space/my_topic" class="icoCollect">我的收藏</a></li-->
</ul>
