<h3>帖子管理</h3>
<?php $this->load->view('admin/topics_search'); ?>
<table class="table">
    <colgroup>
        <col width="80">
        <col width="350">
        <col width="150">
        <col width="200">
        <col width="120">
        <col width="50">
        <col width="100">
        <col width="50">
        <col>
    </colgroup>
    <thead>
        <tr>
            <th>ID</th>
            <th>附件名称</th>
            <th>主题</th>
            <th>作者</th>
            <th>上传时间</th>
            <th>尺寸</th>     
            <th>下载次数</th>
            <th></th>
        </tr>
    </thead>

    <form method="post" action="<?= base_url() ?>index.php/admin/attachments/del"  id="todialog"  >
        <tbody>
            <?php
            !isset($topics) && $topics = array();
            foreach ($topics as $key => $topic) {
                ?>
                <tr>
                    <td>
                        <input type="checkbox" class="checkbox" name="file_id[]" value="<?= $topic['id'] ?>">
                        <?= $topic['id'] ?></td>
                    <td><?php echo $topic['filename']; ?></td>
                    <td><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}"); ?>" target="_blank"><?= $topic['subject'] ?></a></td>
                    <td><?= $topic['author'] ?></td>
                    <td><?= date($date_format, $topic['upload_time']) ?></td>
                    <td><?= $topic['size'] ?></td>
                    <td><?php echo $topic['downloads']; ?></td>
                    <td><a href="<?= base_url() ?>index.php/attachment/download/<?php echo $topic['id']; ?>" target="_blank" >下载</a></td>
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
                <td><input type="button" name="delbutton" id="delbutton" value="删除" ></td>
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

        $("#delbutton").click(function(e) {

            $.Confirm('确定要删除此附件吗？', '', function() {

                if ($("#todialog").serialize() == '') {
                    $.Alert('请选中一直要操作的对象');
                    return false;
                }
                $("#todialog").submit();

            });
        });
    });



</script>