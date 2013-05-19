<!--<p class="sec_nav">分类管理： <a href="index.php?admin_category-list" class="on"  > <span>{lang magManageCat}</span></a> <a href="index.php?admin_category-add"  ><span>{lang magAddCat}</span></a> <a href="index.php?admin_category-merge"  ><span>{lang magUniteCat}</span></a> </p>-->

<h3 class="col-h3">版块管理</h3>
<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>
<form method="post" action="<?=base_url()?>index.php/admin/forums" >
  <div class="table_list">
    <table  class="table" id="act_table">
      <colgroup>
      <col width="430" />
      <col width="70" />
      <col width="210" />
      <col />
      </colgroup>
      <thead>
        <tr>
          <th><span >[顺序]</span>版块名称</th>
          <th>fid</th>
          <th>版主</th>
          <th>操作</th>
        </tr>
      </thead>
      
      <?php foreach($forums as $key=>$val){?>
          <tbody>
            <tr id="tr_<?php echo $val['id']?>" fid="<?php echo $val['id']?>" ftype="1">
              <td><input type="text" name="old[<?php echo $val['id']?>][order]" value="<?php echo $val['display_order']?>" class="inp_txt inp_num">
                <span fid="<?php echo $val['id']?>"><?php echo $val['name']?></span> 
                <a class="link_add" href="#" style="display: none;">添加新版块</a></td>
              <td class="tar"><?php echo $val['id']?></td>
              <td><input type="text" name="old[<?php echo $val['id']?>][manager]" value="<?php echo $val['manager']?>" class="inp_txt"></td>
              <td><a target="_blank" href="<?=base_url('index.php/forum/show/'.$val['id'])?>">[访问]</a> <a href="<?=base_url()?>index.php/admin/forums/edit/<?php echo $val['id']?>">[编辑]</a> <a href="#" class = "del">[删除]</a></td>
            </tr>
          <?php if(!empty($val['sub'])){ $total = count($val['sub']);?>
            <?php	foreach($val['sub'] as $k=>$v){?>
            <tr id="tr_<?php echo $v['id']?>" fid="<?php echo $v['id']?>" ftype="2">
              <td><span class="plus_icon <?php if($k+1 == $total){?>plus_end_icon <?php }?>"></span>
                <input type="text" name="old[<?php echo $v['id']?>][order]" value="<?php echo $v['display_order']?>" class="inp_txt inp_num">
                <span fid="<?php echo $v['id']?>"><?php echo $v['name']?></span>
                <a class="link_add" href="#" style="display: none;">添加二级版块</a></td>
              <td class="tar"><?php echo $v['id']?></td>
              <td><input type="text" name="old[<?php echo $v['id']?>][manager]" value="<?php echo $v['manager']?>" class="inp_txt"></td>
              <td><a target="_blank" href="<?=base_url('index.php/forum/show/'.$v['id'])?>">[访问]</a> <a href="<?=base_url()?>index.php/admin/forums/edit/<?php echo $v['id']?>">[编辑]</a> <a href="#" class = "del">[删除]</a></td>
            </tr>
                <?php if(!empty($v['sub'])){
					$num = count($v['sub']);?>
					<?php foreach($v['sub'] as $sk=>$sv){?>
                    <tr id="tr_<?php echo $sv['id']?>" fid="<?php echo $sv['id']?>" ftype="3">
                      <td><span class="plus_icon plus_none_icon"></span><span class="plus_icon <?php if($sk+1 == $num){?>plus_end_icon <?php }?>"></span>
                        <input type="text" name="old[<?php echo $sv['id']?>][order]" value="<?php echo $sv['display_order']?>" class="inp_txt inp_num">
                        <span fid="<?php echo $sv['id']?>"><?php echo $sv['name']?></span></td>
                      <td class="tar"><?php echo $sv['id']?></td>
                      <td><input type="text" value="<?php echo $sv['manager']?>" name="old[<?php echo $sv['id']?>][manager]" class="inp_txt"></td>
                      <td><a target="_blank" href="<?=base_url('index.php/forum/show/'.$sv['id'])?>">[访问]</a> <a href="<?=base_url()?>index.php/admin/forums/edit/<?php echo $sv['id']?>">[编辑]</a> <a href="#" class = "del">[删除]</a></td>
                    </tr>
                    <?php }?>
                <?php }?>
            <?php }?>
          
          <?php }?>
          </tbody>
      <?php }?>
      
      <tbody id="line_group">
        <tr>
          <td style="padding-left:38px;" colspan="4"><input type="button" id="add_group" value="+添加新分类" class="inp_btn2"/></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="div_bottom">
    <button class="inp_btn m-r10" type="submit">提交</button>
  </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
	var global_id = 0;
	$('#act_table').find('tr').live('mouseover', function() {
//		$(this).addClass("hover");
		$(".link_add",this).show();
	}).live('mouseout', function () {
//		$(this).removeClass("hover");
		$(".link_add",this).hide();
	});

	$(".link_add").live('click',function(){
		//得到点击者以及点击者的fid和级别。
		var currentTr = $(this).parents('tr'), fid = currentTr.attr('fid'),level = currentTr.attr('ftype');
		var html = forumChild(+level+1,fid);
		currentTr.after(html);
		return false;
	});
	
	$("#add_group").live('click',function(){
		//得到点击者以及点击者的fid和级别。
		var group = $("#line_group");
		var html = forumChild(1,0);
		html = '<tbody>'+html+'</tbody>';
		group.before(html);
		return false;
	});

	//返回一~三级版块添加的html
	function forumChild(forum_level, parent_id){
		global_id++;
		var forum_text, plus_icon='',plus_none_icon_arr = [], new_id = 'new_'+global_id;
		
		if (forum_level === 1) {
			forum_text = '添加新版块';
		} else if (forum_level === 2) {
			forum_text = '添加二级版块';
		} else {
			forum_text = '';
		} 
		if(forum_text!=''){
			forum_text = '<a style="display:none" href="#" class="link_add">'+ forum_text +'</a>';
		}
		//不同级别html差异
		for (var i=2; i < forum_level; i++){
			plus_none_icon_arr.push('<span class="plus_icon plus_none_icon"></span>');
		};
		plus_icon = plus_none_icon_arr.join('');
		if(forum_level>1){
			plus_icon += '<span class="plus_icon plus_end_icon"></span>';
		}
		
		return '<tr id="tr_'+new_id+'" ftype="'+forum_level+'" fid="'+new_id+'">\
					<td>'+ plus_icon +'\
						<input type="text" name="new['+ new_id +'][order]" class="inp_txt inp_num" value="0" >\
						<input type="text" name="new['+ new_id +'][name]"  class="inp_txt" value="">\
						<input type="hidden" name="new['+ new_id +'][pid]" value="'+parent_id+'">\
                        <input type="hidden" name="new['+ new_id +'][type]" value="'+forum_level+'">\
						'+ forum_text +'\
					</td>\
					<td class="tar"></td>\
					<td><input type="text" name="new['+ new_id +'][manager]" class="inp_txt"></td>\
					<td><a href="" class="del">[删除]</a></td>\
				</tr>';
	}
	
	//双击编辑版块名称
	$('span[fid]',$('#act_table')).dblclick( function () { 
		var $this = $(this),
			old_name = $this.text(), //原始版块名
			fid = $this.attr('fid'), //版块id
			input = '<input type="text" value="'+ old_name +'" class="inp_txt" name="old['+fid+'][name]">';
		$this.replaceWith(input);
	});
	
	//版块删除
	$('.del',$('#act_table')).live('click',function (e) {
		e.preventDefault();
                var that = this;
		$.Confirm('确定要删除此版块么？','',function(){
                    var currentTr = $(that).parents('tr'),
                        fid = currentTr.attr('fid'),
                        level = currentTr.attr('ftype'),
                        nextTr = currentTr.next(),
                        nextFid = nextTr.attr('fid'),
                        nextLevel = nextTr.attr('ftype');
                    if(nextLevel==undefined) nextLevel = 0;
                    //含子版不删除
                    if(level < nextLevel) {
                            $.Alert('该版块含有子版块，请先删除所有子版块，再进行此操作！','删除版块提示');
                    }else{
                        //ajax发送请求，判断是否删除
                        $.post(base_url+"index.php/admin/forums/delete", { "id": fid },
                                function(data){
                                        if(data.success==1){
                                                currentTr.remove();
                                        }else{
                                                $.Alert(data.message,'删除版块提示');
                                        }
                                }, "json");
                    }
                });
	});
});
</script>