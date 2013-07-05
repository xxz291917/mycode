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

        <?php if($user['online']){echo '<div class="usFaceInfoTit">当前在线</div>';}else{echo '<div class="usFaceInfoTit">当前不在线</div>';}?>
          <!--如果是离加则加载样式：cOffLine -->
          <ul>
            <li class="usUid"><span>UID：</span><?php echo $user['id'];?></li>
            <li><span>最后登录：</span><?php echo date('y-m-d',$user['last_login_time']);?></li>
            <li><span>在线时间：</span>37 小时</li>
            <li><span>银子：</span>94 两</li>
            <li><span>注册时间：</span>2012-10-14</li>
            <li><span>积分：</span>1448</li>
            <li><span>主题：</span><a href="#">3</a></li>
            <!--若为0则无链接-->
            <li><span>帖子：</span><a href="#">64</a></li>
            <!--若为0则无链接-->
            <li><span>分享：</span><a href="#">2</a></li>
            <!--若为0则无链接-->
            <li><span>精华：</span>0</li>
            <li><span>金子：</span>12 两</li>
          </ul>
          <div class="usFaceInfoBot"><a href="#" class="icoUs1">资料</a><a href="#" class="icoUs2">串个门</a><a href="#" class="icoUs3">加好友</a></div>
          <i class="pa"></i> </div>
      </div>
    </div>
    <div class="usName"><a href="#"><?php echo $user['username'];?></a></div>
    <ul class="usTip">
      <li><span class="fl">等级：</span><?php echo $user['stars_rank'];?></li>
      <li><span class="fl">积分：</span><?php echo $user['credits'];?></li>
      <li class="icoHonour"><span>荣誉学员</span></li>
      <li class="usIco"><a class="usIco1" title="2">收藏</a><a class="usIco2" title="2">勋章</a><a class="usIco3" title="2">顶</a><a class="usIco4" title="2">编辑</a></li>
      <!--titile和文字待定-->
    </ul>
  </div>