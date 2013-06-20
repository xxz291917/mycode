
<h3>用户组管理</h3>
<p class="sec_nav">
    <a href="<?= base_url() ?>index.php/admin/groups/index/member" <?php if($type=='member'){?>class="on"<?php }?>><span>会员组</span></a>
    <a href="<?= base_url() ?>index.php/admin/groups/index/system" <?php if($type=='system'){?>class="on"<?php }?>><span>系统组</span></a>
    <a href="<?= base_url() ?>index.php/admin/groups/index/special" <?php if($type=='special'){?>class="on"<?php }?>><span>自定义组</span></a>
</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->
<?php echo form_open(base_url() . 'index.php/admin/groups/index/' . $type) ?>
<?php //echo set_value('seo_title', $data) ?>

<table class="table fspan">
    <colgroup><col width="50">
        <col width="210">
        <col width="90">
    </colgroup>
    <thead>
        <tr>
            <th>编号</th>
            <th>头衔</th>
            <th>星星数</th>
            <?php if($type=='member'){?>
            <th width="200">升级点数需求</th>
            <?php }?>
            <th>操作</th>
        </tr>
    </thead>
    <tbody id="groups_view">
        <?php
        foreach ($groups as $key => $group) {
            $next_stars = isset($groups[$key + 1]['credits']) ? $groups[$key + 1]['credits'] : 99999;
            ?>
            <tr>
                <td><?= $group['id'] ?></td>
                <td><input type="text" value="<?= $group['name'] ?>" name="old[<?=$group['id']?>][name]" class="inp_txt"></td>
                <td>
                    <input type="text" value="<?= $group['stars'] ?>" name="old[<?=$group['id']?>][stars]" class="inp_txt inp_num">
                </td>
                <?php if($type=='member'){?>
                <td><input type="text" value="<?= $group['credits'] ?>" name="old[<?=$group['id']?>][credits]" class="inp_txt inp_long_num"> ~ <?php echo $next_stars ?></td>
                <?php }?>
                <td>
                    <a href="<?= base_url() ?>index.php/admin/groups/edit/<?= $group['id'] ?>">[基本设置]</a>
                    <?php if(in_array($group['id'],$admin_ids)){?>
                    <a href="<?= base_url() ?>index.php/admin/groups/admin_edit/<?= $group['id'] ?>">[管理设置]</a>
                    <?php }?>
                    <?php if($type=='member' || $type=='special'){?>
                    <a href="#" class = "del" gid="<?= $group['id'] ?>">[删除]</a>
                    <?php }?>
                </td>
            </tr>
<?php } ?>
    </tbody>
    <?php if($type!=='system'){?>
    <tbody>
        <tr>
            <td></td>
            <td><input type="text" name="newname" class="inp_txt"></td>
            <td><input type="text" name="newstars"  class="inp_txt inp_num"></td>
            <?php if($type=='member'){?>
            <td><input type="text" name="newcredits" class="inp_txt inp_long_num"></td>
            <?php }?>
            <td><input type="button" id="add_new" value="添加" class="inp_btn2"/></td>
        </tr>
    </tbody>
    <?php }?>
</table>
<p class="div_bottom">
    <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>

<script type="text/javascript">
$(document).ready(function() {
        var global_id = 0,type='<?php echo $type;?>';
	$("#add_new").click(function(){
                var groupsView = $("#groups_view"),
                    newName = $("input[name='newname']"),
                    newstars = $("input[name='newstars']"),
                    newcredits = $("input[name='newcredits']"),
                    checkArr = type=='member'?[newName,newstars,newcredits]:[newName,newstars],
                    isCheck = true;
		//得到点击者以及点击者的fid和级别。
                $.each(checkArr, function(i, n){
                    if($.trim(n.val())==''){
                        n.focus();
                        isCheck = false;
                        return false;
                    }
                });
                if(isCheck){
                    var html = '<tr><td></td>\
                    <td><input type="text" value="'+newName.val()+'" name="new['+global_id+'][name]" class="inp_txt"></td>\
                    <td><input type="text" value="'+newstars.val()+'" name="new['+global_id+'][stars]" class="inp_txt inp_num"></td>';
                    if(type=='member'){
                        html += '<td><input type="text" value="'+newcredits.val()+'" name="new['+global_id+'][credits]" class="inp_txt inp_long_num"></td>';
                    }
                    html += '<td><a href="#" class = "del" gid="0" >[删除]</a></td></tr>';
                    groupsView.append(html);
                    $.each(checkArr, function(i, n){
                        n.val('');
                    });
                    global_id++;
                }
		return false;
	});
	
	//版块删除
	$('.del',$('#groups_view')).live('click',function (e) {
		e.preventDefault();
                var that = this;
		$.Confirm('确定要删除此用户组么？','',function(){
                    var currentTr = $(that).parents('tr'),
                        gid = $(that).attr('gid');
                    //含子版不删除
                    if(gid != 0) {
                        //ajax发送请求，判断是否删除
                        $.post(base_url+"index.php/admin/groups/delete", { "id": gid },
                                function(data){
                                        if(data.success==1){
                                                currentTr.remove();
                                        }else{
                                                $.Alert(data.message,'删除用户组提示');
                                        }
                                }, "json");
                    }else{
                        currentTr.remove();
                    }
                });
	});
});
</script>