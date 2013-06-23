<h3 class="col-h3">附件设置</h3>
<div class="table_list">
    <table  class="table" id="act_table">
        <form method="post" action="" id="config_form">
            <colgroup>
                <col width="200" />
                <col  />         
            </colgroup>
            <thead>
                <tr>
                    <th colspan="2">
                        本功能可限定某特定类型附件的最大尺寸，当这里设定的尺寸小于用户组允许的最大尺寸时，指定类型的附件尺寸限制将按本设定为准。
                        您可以设置某类附件最大尺寸为 0 以整体禁止这类附件被上传。
                    </th>
                <tr>
                    <th>扩展名（小写）</th>
                    <th>最大尺寸（单位KB）</th>
                </tr>
            </thead>

            <?php
       
            if (empty($config)) {
                ?>
                <tr height="40">
                    <td><input type="text" name="name0" id="name0"  value=""></td>
                    <td ><input type="text" name="value0"  id="value0" value=""></td>
                </tr>        
                <?php
            } else {
                
                foreach ($config as $key => $v) {
                    if (!empty($v)) {
                        $val = explode(',', $v);
                        ?>          
                        <tr height="40" aid="<?= $key ?>">
                            <td><input type="text" name="name<?= $key ?>"  id="name<?= $key ?>"  value="<?php echo $val[0] ?>" ></td>
                            <td><input type="text" name="value<?= $key ?>" id="value<?= $key ?>" value="<?php echo $val[1] ?>" class="inp_txt"></td>
                        </tr>     
                        <?php
                    }
                }
            }
            ?>       
            <tbody id="line_group">
                <tr>
                    <td style="padding-left:38px;" colspan="2"><input type="button" id="add_group" value="+添加新分类" class="inp_btn2"/></td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="count" id="count" value="<?php echo $count; ?>">
                        <input class="inp_btn" id="submit" type="button" value="提交" />
                    </td>
                </tr>
            </tbody>
        </form>
    </table>


</div>

<script type="text/javascript">

    $("#add_group").live('click', function() {
        //得到点击者以及点击者的fid和级别。
        var count = $("#count").val();
        //得到点击者以及点击者的fid和级别。
        var group = $("#line_group");
        var html = getHtml(count);
        group.before(html);

    });

    function getHtml(global_id) {
        global_id++;
        $("#count").val(global_id);
        return '<tr height=40 ><td><input type="text" name="name' + global_id + '" id="name' + global_id + '"  value="" ></td><td><input type="text" name="value' + global_id + '" id="value' + global_id + '" value="" ></td></tr>';
    }

    $("#submit").live('click', function() {
        var count = $("#count").val();
        var name = "";
        var value_v = "";
        var str_value = "";
        for (var i = 0; i <= count; i++) {
            name = $("#name" + i).val();
            value_v =parseFloat($("#value" + i).val());
            str_value += name + "," + value_v + "/";
         }
        $.post(base_url+"index.php/admin/attachment_config/update", { "str_value": str_value },
                                function(data){
                                     if(data.success==1){
                                           alert("成功！")
                                        }
          }, "json");
    });


</script>