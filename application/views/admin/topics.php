<h3>帖子管理</h3>
<?php $this->load->view('admin/topics_search');?>
<table class="table">
  <colgroup>
  <col width="80">
  <col width="250">
  <col width="150">
  <col width="200">
  <col width="120">
  <col width="100">
  <col width="100">
  <col width="100">
  <col>
  </colgroup>
  <thead>
    <tr>
      <th>ID</th>
      <th>主题</th>
      <th>作者</th>
      <th>发布时间</th>
      <th>所属板块</th>
      <th>回复/查看</th>
      <th>置顶类型</th>
      <th>精华类型</th>
      <th>帖子状态</th>
    </tr>
  </thead>
  
  <form method="post" action="" target="dialog" id="todialog" refresh="true">
  <tbody>
    <?php 
	!isset($topics) && $topics = array();
	$tops=array('未置顶','版块置顶','分类置顶','全局置顶');
	$digests=array('未设','精华Ⅰ','精华Ⅱ','精华Ⅲ');
	$status=array(0=>'状态异常',1=>'正常',2=>'删除',3=>'屏蔽',4=>'待审核',5=>'关闭');
	
	foreach ($topics as $key => $topic) {?>
    <tr>
      <td>
	  <input type="checkbox" class="checkbox" name="topic_id[]" value="<?= $topic['id'] ?>">
	  <?= $topic['id'] ?></td>
      <td><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}");?>" target="_blank"><?= $topic['subject'] ?></a></td>
      <td><?= $topic['author'] ?></td>
      <td><?= date($date_format,$topic['post_time']) ?></td>
      <td><?= $topic['forum_name'] ?></td>
      <td><?php echo "{$topic['replies']}/{$topic['views']}"; ?></td>
      <td><?php echo $tops[$topic['top']]; ?></td>
      <td><?php echo $digests[$topic['digest']]; ?></td>
      <td><?php echo $status[$topic['status']]; ?></td>
    </tr>
    <?php }if(empty($topics)){ ?>
    <tr>
      <td colspan="9">
      没有符合条件的帖子
      </td>
    </tr>
	<?php }?>
    <tr>
      <td>
	  <input type="checkbox" class="checkbox" name="ok" >全选</td>
      <td colspan="8" id="op">
		<?php foreach($manage_arr as $key=>$val){?>
        <a class="inp_btn2" href="<?php echo base_url('index.php/topic/manage/'.$val[0]);?>"><?=$val[1]?></a>
        <?php }?>
      </td>
    </tr>
  </tbody>
  </form>
</table>

<?php echo $page;?>

<script type="text/javascript">
    $(function() {
		$("input[name='ok']").change(function(){
			$("input[name='topic_id[]']").attr('checked',this.checked);
		});
		
		$("#op a").click(function(event){
			if($("#todialog").serialize()==''){
				$.Alert('请选中一直要操作的对象');
				return false;
			}
			$("#todialog").attr('action',$(this).attr('href'));
			$("#todialog").attr('title',$(this).text());
			$("#todialog").submit();
			event.preventDefault();
		});
    });
</script>