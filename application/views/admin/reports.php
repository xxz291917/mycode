<h3>帖子管理</h3>
<?php $this->load->view('admin/report_search'); ?>
<table class="table">
    <colgroup>
        <col width="80">
        <col width="350">
        <col width="100">
        <col width="100">
        <col width="240">
        <col width="100">
        <col width="100">    
        <col>
    </colgroup>
    <thead>
        <tr>
            <th>ID</th>
            <th>主题</th>
            <th>举报人</th>
            <th>举报时间</th>
            <th>举报原因</th>
            <th>处理人</th> 
            <th>处理时间</th>

        </tr>
    </thead>

    <form method="post" action="<?= base_url() ?>index.php/admin/reports/del"  id="todialog"  >
        <input type="hidden" name="action" id="action" value="1">
        <tbody>
            <?php
            !isset($topics) && $topics = array();
            foreach ($topics as $key => $topic) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" name="file_id[]" value="<?= $topic['id'] ?>">
                        <?= $topic['id'] ?></td>
                    <td><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}"); ?>" target="_blank"><?= $topic['subject'] ?></a></td>
                    <td><?= $topic['user_id'] ?></td>
                    <td><?php if (isset($topic['add_time'])) {
                        echo date($date_format, $topic['add_time']);
                    } else {
                        echo "无";
                    } ?></td>
                    <td><?= $topic['reason'] ?></td>
                    <td><?php if (isset($topic['operate_user'])) {
                echo $topic['operate_user'];
            } else {
                echo "未处理";
            }; ?></td>
                    <td><?php if (isset($topic['operate_time'])) {
                echo date($date_format, $topic['operate_time']);
            } else {
                echo "未处理";
            } ?></td>
                </tr>
<?php }if (empty($topics)) { ?>
                <tr>
                    <td colspan="9">
                        没有符合条件的记录
                    </td>
                </tr>
<?php } ?>
            <tr >
                <td><input type="checkbox" class="checkbox" name="ok" >全选</td>
                <td><input type="button" name="operatebutton" id="operatebutton" value="处理" >&nbsp;&nbsp;<input type="button" name="delbutton" id="delbutton" value="撤销举报" ></td>
            </tr>
        </tbody>
    </form>
</table>

<?php echo $page; ?>

<script type="text/javascript">
    $(function() {
        $("input[name='ok']").change(function() {
            $("input[name='file_id[]']").attr('checked', this.checked);
        });

        $("#operatebutton").click(function(e) {
            $.Confirm('确定要处理此举报吗？', '', function() {
                if ($("#todialog").serialize() == '') {
                    $.Alert('请选中一直要操作的对象');
                    return false;
                }
                $("#todialog").submit();

            });
        });

        $("#delbutton").click(function(e) {
            $.Confirm('确定要撤销此举报吗？', '', function() {
                if ($("#todialog").serialize() == '') {
                    $.Alert('请选中一直要操作的对象');
                    return false;
                }
                $('#action').val('2');
                $('#todialog').attr('action', '<?= base_url() ?>index.php/admin/reports/del');
                $("#todialog").submit();
            });
        });


    });






</script>