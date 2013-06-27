<!--content-->
<div class="wrap bgWhite clearfix">
  <div class="col3">
        <h3 class="tagA">
            <a href="<?= base_url() ?>index.php/space/my_topic"   <?php if ($menu == 2) {  echo "class=current"; } ?> >我的帖子</a>
            <a href="<?= base_url() ?>index.php/space/my_posted"  <?php if ($menu == 0) { echo "class=current"; } ?> >我的回复</a>
        </h3>
        <div class="tagACot">
                    <?php
                    if ($menu == 2) {
                        $this->load->view('space_topic');
                    } else if ($menu == 0) {
                        $this->load->view('space_posted');
                    }
                    ?>
                </div>
            </div>  
            <div class="col4">
        <?php $this->load->view('space_right'); ?>
    </div>    
</div>
<!--footer-->
