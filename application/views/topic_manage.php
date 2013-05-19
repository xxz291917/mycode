<form action="<?php echo base_url('index.php/topic/manage/' . $action); ?>" method="post" id="topic_manage">
    <input type="hidden" name="submit" value="1">
    <input type="hidden" name="topic_id" value="<?= $topic_id ?>">
    <table class="table2" width="400px">
        <colgroup>
            <col width="80">
            <col width="350">
        </colgroup>
        <tr class="split">
            <td colspan="2">选择了(<span><?php echo $count; ?></span>篇) </td>
        </tr>

        <?php if (in_array($action, array('top', 'digest', 'highlight'))) { ?>
            <tbody>
                <tr>
                    <?php if ($action == 'top') { ?>
                        <th>置顶</th>
                        <td><select name="top" class="select" >
                                <option value="1">本版置顶</option>
                                <option value="2">分类置顶</option>
                                <option value="3">全局置顶</option>
                                <option value="0">取消置顶</option>
                            </select></td>
                    <?php } elseif ($action == 'digest') { ?>
                        <th>推荐精华</th>
                        <td><select name="digest" class="select" >
                                <option value="1">精华I</option>
                                <option value="2">精华II</option>
                                <option value="3">精华III</option>
                                <option value="0">取消精华</option>
                            </select></td>
                    <?php } elseif ($action == 'highlight') { ?>
                        <th>高亮</th>
                        <td><input type="text" class="inp_txt" id="color" value="" /> <input type="button" id="colorpicker" value="打开取色器" />
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <th>有效期</th>
                    <td><input type="text" value="<?php echo my_set_date('end_time', $top = array(), 'Y-m-d'); ?>" class="inp_txt" name="end_time"></td>
                </tr>
                <tr>
                    <th>原因</th>
                    <td>
                        <textarea cols="45" name="reason" rows="3" class="textarea"><?php echo my_set_value('reason', array()) ?></textarea>
                    </td>
                </tr>
            </tbody>
        <?php } ?>
    </table>
    <p class="div_bottom">
        <input class="inp_btn" type="submit" value="提交" />
    </p>
</form>
<script type="text/javascript">
    $(function() {
        $("input[name^='end_time']", $("#topic_manage")).datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<script reload="1" type="text/javascript">
function succeedhandle_mods(locationhref) {
hideWindow('mods');
location.href = 'forum.php?mod=viewthread&amp;tid=3&amp;extra=';
}
var lastsel = null;
function switchitemcp(id) {
if(lastsel) {
lastsel.className = '';
}
$(id).className = 'copt';
lastsel = $(id);
}

if($('itemcp_highlight')) {
switchitemcp('itemcp_highlight');
}
function switchhl(obj, v) {
if(parseInt($('highlight_style_' + v).value)) {
$('highlight_style_' + v).value = 0;
obj.className = obj.className.replace(/ cnt/, '');
} else {
$('highlight_style_' + v).value = 1;
obj.className += ' cnt';
}
}
function showHighLightColor(hlid) {
var showid = hlid + '_ctrl';
if(!$(showid + '_menu')) {
var str = '';
var coloroptions = {'0' : '#000', '1' : '#EE1B2E', '2' : '#EE5023', '3' : '#996600', '4' : '#3C9D40', '5' : '#2897C5', '6' : '#2B65B7', '7' : '#8F2A90', '8' : '#EC1282'};
var menu = document.createElement('div');
menu.id = showid + '_menu';
menu.className = 'cmen';
menu.style.display = 'none';
for(var i in coloroptions) {
str += '&lt;a href="javascript:;" onclick="$(\'' + hlid + '\').value=' + i + ';$(\'' + showid + '\').style.backgroundColor=\'' + coloroptions[i] + '\';hideMenu(\'' + menu.id + '\')" style="background:' + coloroptions[i] + ';color:' + coloroptions[i] + ';"&gt;' + coloroptions[i] + '&lt;/a&gt;';
}
menu.innerHTML = str;
$('append_parent').appendChild(menu);
}
showMenu({'ctrlid':hlid + '_ctrl','evt':'click','showid':showid});
}
</script>