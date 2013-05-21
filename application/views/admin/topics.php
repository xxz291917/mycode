<h3>帖子管理</h3>
<h4>搜索帖子</h4>
<form name="search" method="get" action="<?=current_url()?>" class="form row">
  <fieldset>
    <div>
      <label for="forums">版块：</label>
      <select name="forums[]" size="5" multiple="multiple" class="select">
        <?=$forums_option?>
      </select>
    </div>
    <div>
      <label for="user">用户名/用户id：</label>
      <input name="user" type="text" class="inp_txt" value="<?php echo my_set_value('user',$data);?>" />
    </div>
    <div>
      <label for="content">标题关键字：<em class="feedback"></em></label>
      <input name="content" class="inp_txt" type="text" value="<?php echo my_set_value('content',$data);?>" />
    </div>
    <div>
      <label>发帖时间：<em class="feedback"></em></label>
      <input name="start_time" class="inp_txt inp_date_num" type="text" value="<?php echo my_set_date('start_time',$data,'Y-m-d');?>" /> -
      <input name="end_time" class="inp_txt inp_date_num" type="text" value="<?php echo my_set_date('end_time',$data,'Y-m-d');?>" />
    </div>
    <div>
      <label>&nbsp;</label>
      <input class="inp_btn" name="submit" type="submit" value="搜索" />
    </div>
  </fieldset>
</form>
<table class="table">
  <colgroup>
  <col width="100">
  <col width="150">
  <col width="200">
  <col width="200">
  <col width="200">
  <col>
  </colgroup>
  <thead>
    <tr>
      <th>ID</th>
      <th>标题</th>
      <th>作者</th>
      <th>发布时间</th>
      <th>所属板块</th>
      <th>回复/查看</th>
    </tr>
  </thead>
  
  <form method="post" action="" target="dialog" id="todialog">
  <tbody>
    <?php 
	!isset($topics) && $topics = array();
	foreach ($topics as $key => $topic) {?>
    <tr>
      <td>
	  <input type="checkbox" class="checkbox" name="topic_id[]" value="<?= $topic['id'] ?>">
	  <?= $topic['id'] ?></td>
      <td><?= $topic['subject'] ?></td>
      <td><?= $topic['author'] ?></td>
      <td><?= date($date_format,$topic['post_time']) ?></td>
      <td><?= $topic['forum_name'] ?></td>
      <td><?php echo "{$topic['replies']}/{$topic['views']}"; ?></td>
    </tr>
    <?php }if(empty($topics)){ ?>
    <tr>
      <td colspan="6">
      没有符合条件的帖子
      </td>
    </tr>
	<?php }?>
    <tr>
      <td>
	  <input type="checkbox" class="checkbox" name="ok" >全选</td>
      <td colspan="5" id="op">
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
        $("input[name='start_time'] , input[name='end_time']").datepicker({
            dateFormat: 'yy-mm-dd'
        });
		
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