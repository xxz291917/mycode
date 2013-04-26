<p class="sec_nav"> <a href="index.php?admin_category-list" class="on"  ><span>基本设置</span></a> <a href="index.php?admin_category-add"><span>帖子相关设置</span></a> <a href="index.php?admin_category-add"><span>权限设置</span></a> <a href="index.php?admin_category-merge"  ><span>积分设置</span></a> </p>
<h3>基本设置</h3>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->
<?php echo form_open_multipart(base_url().'index.php/admin/forums/edit')?>
  <table class="table fspan">
    <colgroup>
    <col style="width:280px;">
      </col>
    <col>
      </col>
    </colgroup>
    <tr>
      <td><span>版块名称</span>
          <input maxlength="30" class="inp_txt" name="name" type="text" value="<?php echo set_value('name', $data)?>" /></td>
      <td class="v-b" >&nbsp;</td>
    </tr>
    <tr>
      <td><span>版主列表</span>
        <input maxlength="120" class="inp_txt" name="manager" type="text" value="<?php echo set_value('manager', $data)?>" /></td>
      <td class="v-b" ><p>多个版主请用英文的逗号、分号或者空格来分隔。</p></td>
    </tr>
    <tr>
      <td><span>排列顺序</span>
        <input style="width:30px" class="inp_txt" name="display_order" type="text" value="<?php echo set_value('display_order', $data)?>" /></td>
      <td class="v-b" ><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td><span>版块图标</span>
        <input type="file" value="<?php echo set_value('icon', $data)?>" name="icon"></td>
      <td class="v-t" ><p>页面底部可以显示第三方统计</p></td>
    </tr>
    <tr>
      <td><span>版块简介</span>
        <textarea cols="45" name="description" rows="3" class="textarea"><?php echo set_value('description', $data)?></textarea></td>
      <td class="v" ><p>支持HTML代码<br/>
        </p></td>
    </tr>
    <tr>
      <td><span>发帖审核:</span>
        <label>
          <input type="radio"  name="check" value="0" <?php echo set_radio('check', 0, $data)?> />
          不审核</label>
        <label>
          <input type="radio"  name="check" value="1" <?php echo set_radio('check', 1, $data)?> />
          审核主题</label>
        <label>
          <input type="radio"  name="check" value="2" <?php echo set_radio('check', 2, $data)?> />
          审核主题和回复</label></td>
      <td> 选择"是"将使用户在本版发表的帖子待版主或管理员审查通过后才显示出来，打开此功能后，您可以在用户组中设定哪些组发帖可不经审核，也可以在管理组中设定哪些组可以审核别人的帖子 </td>
    </tr>
    <tr>
      <td><span>允许html</span>
        <label>
          <input type="radio"  name="is_html" value="1" <?php echo set_radio('is_html', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_html" value="0" <?php echo set_radio('is_html', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span>允许bbcode</span>
        <label>
          <input type="radio"  name="is_bbcode" value="1" <?php echo set_radio('is_bbcode', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_bbcode" value="0" <?php echo set_radio('is_bbcode', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span>允许图标</span>
        <label>
          <input type="radio"  name="is_smilies" value="1" <?php echo set_radio('is_smilies', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_smilies" value="0" <?php echo set_radio('is_smilies', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span>允许多媒体</span>
        <label>
          <input type="radio"  name="is_media" value="1" <?php echo set_radio('is_media', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_media" value="0" <?php echo set_radio('is_media', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span>允许匿名发帖</span>
        <label>
          <input type="radio"  name="is_anonymous" value="1" <?php echo set_radio('is_anonymous', 1, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="is_anonymous" value="0" <?php echo set_radio('is_anonymous', 0, $data)?>/>
          否</label></td>
      <td></td>
    </tr>
    <tr>
      <td><span>title</span>
        <input class="inp_txt" name="seo_title" type="text" value="<?php echo set_value('seo_title', $data)?>" /></td>
      <td></td>
    </tr>
    <tr>
      <td><span>keywords</span>
        <input class="inp_txt" name="seo_keywords" type="text" value="<?php echo set_value('seo_keywords', $data)?>" /></td>
      <td>
      <td></td>
    </tr>
    <tr>
      <td><span>description</span>
        <textarea cols="45" name="seo_description" rows="3" class="textarea"><?php echo set_value('seo_description', $data)?></textarea></td>
      <td>
      <td></td>
    </tr>
    <tr>
      <td><span>允许发布的特殊主题</span>
        <ul>
          <li><input type="checkbox" value="1" name="allow_special[]" <?php echo set_checkbox('allow_special', '1',$data); ?> class="checkbox">投票主题</li>
          <li><input type="checkbox" value="2" name="allow_special[]" <?php echo set_checkbox('allow_special', '2',$data); ?> class="checkbox">问答主题</li>
          <li><input type="checkbox" value="3" name="allow_special[]" <?php echo set_checkbox('allow_special', '3',$data); ?> class="checkbox">活动主题</li>
        </ul></td>
      <td></td>
    </tr>
    <tr>
      <td><span>关闭版块</span><label>
          <input type="radio"  name="status" value="0" <?php echo set_radio('status', 0, $data)?>/>
          是</label>
        <label>
          <input type="radio"  name="status" value="1" <?php echo set_radio('status', 0, $data)?>/>
          否</label>
        </td>
      <td>
      暂时将站点关闭，其他人无法访问，但不影响管理员访问。</td>
    </tr>
    <tr id="closeWebsiteReason" style="display:none">
      <td><span>{lang closeWebsiteReason}</span>{lang closeWebsiteReasonTip}</td>
      <td><textarea class="textarea" name="setting[close_website_reason]" style="width:300px" rows="3">{$basecfginfo['close_website_reason']}</textarea></td>
    </tr>
  </table>
  <p class="submit">
    <input class="inp_btn" name="submit" type="submit" value="提交" />
  </p>
<?php echo form_close() ?>
  
<script type="text/javascript">
$(document).ready(function() {
	var global_id = 0;
	$('#act_table').find('tr').live('mouseover', function() {
		$(this).addClass("hover");
		$(".link_add",this).show();
	}).live('mouseout', function () {
		$(this).removeClass("hover");
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
		
		return '<tr id="tr_'+new_id+'" ftype="'+forum_level+'" fid="'+new_id+'"><td></td>\
					<td>'+ plus_icon +'\
						<input type="text" name="new['+ new_id +'][order]" class="inp_txt2" style="width:20px;" value="0" >\
						<input type="text" name="new['+ new_id +'][name]"  class="inp_txt2" value="">\
						<input type="hidden" name="new['+ new_id +'][pid]" value="'+parent_id+'">\
                        <input type="hidden" name="new['+ new_id +'][type]" value="'+forum_level+'">\
						'+ forum_text +'\
					</td>\
					<td class="tar"></td>\
					<td><input type="text" name="new['+ new_id +'][manager]" class="inp_txt2"></td>\
					<td><a href="" class="del">[删除]</a></td>\
				</tr>';
	}
	
	//双击编辑版块名称
	$('span[fid]',$('#act_table')).dblclick( function () { 
		var $this = $(this),
			old_name = $this.text(), //原始版块名
			fid = $this.attr('fid'), //版块id
			input = '<input type="text" value="'+ old_name +'" class="inp_txt2" name="old['+fid+'][name]">';
		$this.replaceWith(input);
	});
	
	//版块删除
	$('.del',$('#act_table')).live('click',function (e) {
		e.preventDefault();
		if(confirm('确定要删除此版块么？')){
			var currentTr = $(this).parents('tr'),
				fid = currentTr.attr('fid'),
				level = currentTr.attr('ftype'),
				nextTr = currentTr.next(),
				nextFid = nextTr.attr('fid'),
				nextLevel = nextTr.attr('ftype');
			if(nextLevel==undefined) nextLevel = 0;
			//含子版不删除
			if(level < nextLevel) {
				$.jAlert('该版块含有子版块，请先删除所有子版块，再进行此操作！','删除版块提示');
			}else{
				//ajax发送请求，判断是否删除
				$.post(base_url+"index.php/admin/forums/delete", { "id": fid },
					function(data){
						if(data.success==1){
							currentTr.remove();
						}else{
							$.jAlert(data.data,'删除版块提示');
						}
					}, "json");
			}
		}
	});
});
</script>