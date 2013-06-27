<div class="wrap">
  <div class="myPos fsong">>
  <a href="<?php echo base_url();?>">论坛</a>>
  <?php 
  	$position_names = array(1=>'沙发',2=>'板凳',3=>'地板');
    $point_names = array(1=>'红方',2=>'蓝方');
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
              <a href="#" class="icoUs3">加关注</a>
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
            <span title="回复数" class="icoMsg2"><?php echo $topic['replies']?></span>
            </div>
          
          <div class="newsCotIn">
          <?php echo $first_post['content'];?>
          </div>
        </article>
          
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
                <a href="<?= $this->config->item('user_url').$first_post['debate']['affirm_first']['author_id']?>"><img src="<?= $this->config->item('user_icon').$first_post['debate']['affirm_first']['author_id']?>" alt="<?=$first_post['debate']['affirm_first']['author']?>"></a>
                <p><a href="<?= $this->config->item('user_url').$first_post['debate']['affirm_first']['author_id']?>"><?=$first_post['debate']['affirm_first']['author']?></a>：<?php echo utf8_substr($first_post['debate']['affirm_first']['content'],0,30)?> </p>
              <?php }?>
              </div>
              <ul>
              	<?php foreach($first_post['debate']['affirm_users'] as $user){?>
                	<li><a href="<a href="<?= $this->config->item('user_url').$user['user_id']?>"><?=$user['username']?></a>">
                    <img src="<?= $this->config->item('user_icon').$user['user_id']?>" alt="<?=$user['username']?>"></a></li>
                <?php }?>
              </ul>
              <a href="javascript:void(0);" class="postView">发表红方观点</a>
            </div>
              
            <div class="debateCotLi userBlue">
              <p class="thesis pr"><?=$first_post['debate']['negate_point']?><span></span><i class="icoSj pa"></i></p>
              <div  class="thesisUs">
              <?php if(!empty($first_post['debate']['negate_first'])){?>
                <a href="<?= $this->config->item('user_url').$first_post['debate']['negate_first']['author_id']?>"><img src="<?= $this->config->item('user_icon').$first_post['debate']['negate_first']['author_id']?>" alt="<?=$first_post['debate']['negate_first']['author']?>"></a>
                <p><a href="<?= $this->config->item('user_url').$first_post['debate']['negate_first']['author_id']?>"><?=$first_post['debate']['negate_first']['author']?></a>：<?php echo utf8_substr($first_post['debate']['negate_first']['content'],0,30)?> </p>
              <?php }?>
              </div>
              <ul>
              	<?php foreach($first_post['debate']['negate_users'] as $user){?>
                	<li><a href="<a href="<?= $this->config->item('user_url').$user['user_id']?>"><?=$user['username']?></a>">
                    <img src="<?= $this->config->item('user_icon').$user['user_id']?>" alt="<?=$user['username']?>"></a></li>
                <?php }?>
              </ul>
              <a href="javascript:void(0);" class="postView">发表蓝方观点</a>
            </div>
              
            <span class="debateCotHr pa"></span>
          </div>
        </div>
          
        <div class="myTag pr"><a href="#">Photoshop</a>,<a href="#">Dota</a>,<a href="#">物理</a>,<a href="#">化学</a><i class="pa"></i></div>  
        <div class="orderBy">
          <span>回复排序列：</span>
          <ul>
            <li><a href="#" class="btnUserDeft">默认</a></li>
            <li><a href="#" class="btnUserRed">红方</a></li>
            <li><a href="#" class="btnUserBlue">蓝方</a></li>
          </ul>
        </div>
        
        <ul class="newsBot pa">
          <li class="fl"><a href="#">举报</a></li>
          <li><a href="#" class="icoEdit">评分</a></li>
          <li><a href="#" class="icoCollect">收藏</a></li>
          <li><a href="#" class="icoGrade">编辑</a></li>
          <li><a href="#editor_reply" class="icoReplys reply_editor">回复</a></li>
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

  <div class="newsCotL">
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
              <a href="#" class="icoUs3">加关注</a>
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
        
      <div class="newsCotR pr">
          
        <div class="tr myState myState2">
            <span class="btnLBlue"><?php echo $point_names[$post['stand']];?></span>
            <div class="newsTip">
            <span>发表于 <?php echo time_span($post['post_time'],'','','前');?> |<a href="<?php echo base_url('index.php/topic/show/'.$post['topic_id'].'/?author='.$post['author_id']);?>">只看该作者</a></span>
            </div>
            <?php if(empty($position_names[$post['position']])){
                          echo $post['position'].'#';
                  }else{
                          echo $position_names[$post['position']];
                  }?>
        </div>
        
        <article class="newsCots">
          <h2 class="fyahei">现代程序员的工作环境</h2>          
          <div class="newsCotIn">
            <p>7天前，32岁的漯河人周三江倒在郑州东区的马路边上，再也没有醒来。周三江72岁的老父亲来郑州商都路派出所办理死亡证明时被索要3000元运尸费，而且不开发票，这个数字顿时吓住了老人。从周三江的死亡地点到医院太平间区区15公里，为何会花费3000元运尸费？警察和太平间工作人员均表示，这是"不成文的规定"。<em>(今天10:17)</em></p>
          </div>
        </article>
                
               
        <div class="cmtCot">
          <span class="btnCmt">点评</span>
          <a href="#"><img src="images/temp.jpg" alt="名称"></a>
          <div class="cmtCotR"><a href="#">浪漫的杯子</a>从周三江的死亡地点到医院太平间区区15公里，为何会花费3000元运尸费？<span><em>发表于：</em>2012-12-12 15：22</span><span><em>IP：</em>158.236.232.232</span></div>
        </div>
        <div class="newsAD fsong"><i></i>本次大会更注难，并分享实战经验。为庆祝此次大会<cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a><cite>|</cite><a href="#">本次大会更注重交流与互难，并分享实</a></div>
        
        <ul class="newsBot pa">
          <li class="fl"><a href="#">举报</a></li>
          <li><a href="#" class="icoEdit">评分</a></li>
          <li><a href="#" class="icoCite">引用不着</a></li>
          <li><a href="#" class="icoReplys">回复</a></li>
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
            <li><a href="#" class="ico1">发表帖子</a></li>
            <li><a href="#" class="ico2">发起投票</a></li>
            <li><a href="#" class="ico3">发布悬赏</a></li>
            <li><a href="#" class="ico4">发起辩论</a></li>
            <li><a href="#" class="ico5">发起活动</a></li>
            <li><a href="#" class="ico6">出售商品</a></li>
          </ul>
        </div>        
      </li>
      <li><a href="javascript:void(0);">回复</a></li>
    </ul>
    <div class="pagenum"><a href="../2.html" class="btnPre"></a><a href="#" class="current">1</a><a href="../2.html">2</a><a href="../3.html">3</a><a href="../4.html">4</a><a href="../5.html">5</a><a href="../6.html">6</a><a href="../7.html">7</a><a href="../8.html">8</a>...<a href="../100.html">100</a><a href="../2.html" class="btnNext"></a></div>
  </div>


  <div class="mainCmt" id="editor_reply">
    <h5>回复帖子</h5>
    <?php $this->load->view('reply_smiple');?>
  </div>

</div>