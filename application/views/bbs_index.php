
<table class="table2">
    <colgroup>
        <col>
        <col width="50">
        <col width="250">
        <col style="color:#F00;">
    </colgroup>
    <?php foreach ($forums as $forum) { 
        if(!empty($forum['sub'])){
    ?>
        <tr class="split">
            <td colspan="3"><a href="<?=base_url()?>index.php/forum/show/<?=$forum['id']?>"><?=$forum['name']?></a></td>
        </tr>
        <?php foreach ($forum['sub'] as $sub) { ?>
            <tr>
                <td><a href="<?=base_url()?>index.php/forum/show/<?=$sub['id']?>"><?=$sub['name']?></a></td>
                <td>
                    <?php
                    if (isset($sub['topics'])) {
                        echo "{$sub['topics']} / {$sub['posts']}";
                    } else {
                        echo '0 / 0';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($sub['topics'])) {
                        echo "<a href=\"".base_url()."index.php/topics/show\">{$sub['subject']}</a> <br/>{$sub['last_post_time']} {$sub['last_author']}";
                    } else {
                        echo '从未';
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    <?php 
        }
    }
    ?>
</table>
