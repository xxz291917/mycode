<!--我的回复列表-->
<ul class="myRepList">
    <?php
    !isset($my_posted) && $my_posted = array();
    foreach ($my_posted as $key => $topic) {
        ?>       

        <li class="pr">
            <p><a href="<?php echo base_url("index.php/topic/show/{$topic['id']}"); ?>" target="_blank" ><?= $topic['subject'] ?></a></p>
            <p><span><?php echo date('Y-m-d H:i:s',$topic['time']); ?></span></p><i class="pa"></i>
        </li>

    <?php } ?>
</ul>
<?php echo $page; ?>
