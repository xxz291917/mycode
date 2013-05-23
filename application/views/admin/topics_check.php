<h3>审核管理</h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/topics/check/" class="on"><span>帖子审核</span></a>
<a href="<?=base_url()?>index.php/admin/posts/check"><span>回复审核</span></a>
</p>
<?php $this->load->view('admin/topics_search');?>
<table class="table2">
  <colgroup>
  <col width="80">
  <col width="80">
  <col width="200">
  <col width="150">
  <col width="200">
  <col width="120">
  <col>
  </colgroup>
  <form method="post" action="" target="dialog" id="todialog" refresh="true">
  <tbody>
    <tr class="split">
      <td colspan="6">待审核列表</td>
    </tr>
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
      <td><b>状态：</b><?php echo $status[$topic['status']]; ?></td>
      <td><b>主题：</b><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}");?>" target="_blank"><?= $topic['subject'] ?></a></td>
      <td><b>作者：</b><?= $topic['author'] ?></td>
      <td><b>发表于：</b><?= date($date_format,$topic['post_time']) ?></td>
      <td><b>所属板块：</b><?= $topic['forum_name'] ?></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="5">
      <textarea name="test" cols="150" rows="3" disabled="disabled"><?= $topic['content'] ?></textarea>
      </td>
    </tr>
    <?php }if(empty($topics)){ ?>
    <tr>
      <td></td>
      <td colspan="5">
      暂无需要审核的帖子。
      </td>
    </tr>
	<?php }?>
    <tr>
      <td>
	  <input type="checkbox" class="checkbox" name="ok" >全选</td>
      <td colspan="8" id="op">
        <a class="inp_btn2" href="<?php echo base_url('index.php/admin/topics/deal_check/pass');?>">通过</a>
        <a class="inp_btn2" href="<?php echo base_url('index.php/admin/topics/deal_check/del');?>">删除</a>
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