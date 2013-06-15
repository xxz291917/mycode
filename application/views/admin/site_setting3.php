
<h3 class="col-h3">版块管理</h3>
<p class="sec_nav"> 
    <a href="index.php?admin_category-list" class="on"  ><span>基本设置</span></a>
    <a href="index.php?admin_category-add"><span>权限设置</span></a>
    <a href="index.php?admin_category-merge"  ><span>积分设置</span></a>
</p>
<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>
<p class="map">全局：站点设置</p>
<form method="POST" action="index.php?admin_setting-base">
<table class="table">
	<colgroup>
		<col  style="width:300px;"></col>
		<col></col>
	</colgroup>
	<tr>
		<td><span>网站名称</span>
			<input maxlength="30" class="inp_txt" name="setting[site_name]" type="text" value="{$basecfginfo['site_name']}" />
		</td>
		<td class="v-b" >网站名称，将显示在页面Title处</td>
	</tr>	
	<tr>
		<td><span>网站URL</span><input maxlength="120" class="inp_txt" name="setting[site_url]" type="text" value="{$basecfginfo['site_url']}" /></td>
		<td class="v-b" ><p>网站 URL，作为网站资源的根路径使用<br/>
			如果更改此处URL，需要去后台重启云搜索，<br />以便云端初始化本站信息。<br />
			注: 本设置填写错误可能导致图片显示异常</p>
			</td>
	</tr>	
	<tr>
		<td><span>站内公告</span><textarea cols="45" name="setting[site_notice]" rows="5" class="textarea">{$setting[site_notice]}</textarea></td>
		<td class="v" ><p>站内公告可以由管理员自行添加，或者使用默认公告内容<br/> 
管理员自行修改文本框中的公告内容后，点击保存按钮<br/>  
如需使用默认公告内容，只需将公告内容留空即可。 <br/> </p>
</td>
	</tr>
	<tr>
		<td><span>网站备案信息</span><input maxlength="20" class="inp_txt" name="setting[site_icp]" type="text" value="{$basecfginfo['site_icp']}" /></td>
		<td class="v-b" >如果网站已备案，在此输入，它将显示在页面底部，没有请留空</td>
	</tr>	
	<tr>
		<td><span>第三方统计代码</span><textarea class="textarea" rows="6" name="setting[statcode]" cols="50" >{$basecfginfo['statcode']}</textarea></td>
		<td class="v-t" ><p>页面底部可以显示第三方统计</p></td>
	</tr>
	<tr>
		
		<td><span>{lang stylemanage}</span><br/>{lang styleDefaultSetInfo}</td>
		<td>
			<label><input type="radio"  name="setting[style_user_select]" value="1" {if $basecfginfo['style_user_select']=='1'}checked{/if}/>{lang commonYes}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio"  name="setting[style_user_select]" value="0" {if $basecfginfo['style_user_select']=='0'}checked{/if}/>{lang commonNo}</label>
		</td>
	</tr>
	<tr>
		<td><span>是否需要兼容以前版本模板</span><br />选择兼容，首页将获取以前模板所需的数据，否则不再获取数据。</td>
		<td>
			<label><input type="radio"  name="setting[compatible]" value="1" {if $basecfginfo['compatible']=='1'}checked{/if}/>{lang commonYes}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio"  name="setting[compatible]" value="0" {if $basecfginfo['compatible']=='0'}checked{/if}/>{lang commonNo}</label>
		</td>
	</tr>
	<tr>
		<td><span>关闭网站</span><br />暂时将站点关闭，其他人无法访问，但不影响管理员访问。</td>
		<td>
			<label><input type="radio"  name="setting[close_website]" value="1" {if $basecfginfo['close_website']=='1'}checked{/if}/>{lang commonYes}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio"  name="setting[close_website]" value="0" {if $basecfginfo['close_website']=='0'}checked{/if}/>{lang commonNo}</label>
		</td>
	</tr>
	<tr id="closeWebsiteReason" style="display:none">
		<td><span>{lang closeWebsiteReason}</span>{lang closeWebsiteReasonTip}</td>
		<td>
		<textarea class="textarea" name="setting[close_website_reason]" style="width:300px" rows="3">{$basecfginfo['close_website_reason']}</textarea>
		</td>
	</tr>
</table>
<p class="div_bottom">
	<input class="inp_btn" name="settingsubmit" type="submit" value="{lang commonSave}" />&nbsp;&nbsp;
	<input class="inp_btn" type="reset" value="{lang commonReset}" />
</p>
</form>
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