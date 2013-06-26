<h3 class="col-h3">积分设置</h3>
<div class="table_list">
    <table  class="table" id="act_table">
        <form method="post" action="<?= base_url() ?>index.php/admin/credits/update" id="config_form">
            <colgroup>
                <col width="200" />
                <col  />         
            </colgroup>

            <tbody id="line_group"> 
                <tr height="40" >
                    <td>是否启用</td>
                    <?php
                    for ($i = 0; $i < count($credits); $i++) {
                        ?>          
                        <td><input type="checkbox" name="credit_x_<?php echo $i; ?>"   value="1"   <?php if ($credits[$i]['status'] == 1) {
                        echo "checked=checked";
                    } ?>><?php echo $credits[$i]['credit_x']; ?></td>
                        <?php
                    }
                    ?>  
                </tr> 
                <tr height="40" >
                    <td>名称</td>
                    <?php
                    for ($j = 0; $j < count($credits); $j++) {
                        ?>          
                        <td><input type="type" name="view_name_<?php echo $j; ?>"   value="<?php echo $credits[$j]['view_name']; ?>" ></td>
                        <?php
                    }
                    ?>  
                </tr> 
                <tr height="40" >
                    <td>积分单位</td>
                    <?php
                    for ($i = 0; $i < count($credits); $i++) {
                        ?>          
                        <td><input type="text" name="unit<?php echo $i; ?>"   value="<?php echo $credits[$i]['unit']; ?>"  ></td>
                        <?php
                    }
                    ?>  
                </tr>  
                <tr height="40" >
                    <td>积分图标</td>
                    <?php
                    for ($k = 0; $k < count($credits); $k++) {
                        ?>          
                        <td><input type="type" name="icon<?php echo $k; ?>"   value="<?php echo $credits[$k]['icon']; ?>" ></td>
                        <?php
                    }
                    ?>  
                </tr> 
                <tr>
                    <td colspan="9">
                        <input type="hidden" name="count" value="<?php echo $count; ?>">
                        <input class="inp_btn" id="submit" type="submit" value="提交" />
                    </td>
                </tr>
            </tbody>
        </form>
    </table>


</div>
