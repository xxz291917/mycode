<!--content-->
<div class="wrap bgWhite clearfix">
    <div class="col3">
        <ul class="usTip myRanks">
            <li><h4><a href="#">流温故知新</a></h4><span class="myRank"><i class="icoSun"></i><i class="icoSun"></i><i class="icoMoon"></i><i class="icoStar"></i></span></li>
        </ul>
        <ul class="userInfo">
            <li><span>积分：</span>998分</li>
            <li><span>等级：</span>10级</li>
            <li><span>排名：</span>998名</li>
            <li><span>升级还需：</span>998分</li>
            <li><span>金子：</span>998两</li>
            <li><span>银子：</span>998两</li>
            <li><span>威望：</span>998</li>
            <li><span>义气：</span>998</li>
        </ul>
        <h3 class="tagA mt20">
            <?php
            !isset($credit_name) && $credit_name = array();
            foreach ($credit_name as $key => $name) {
                ?>          
                <a href="<?= base_url() ?>index.php/space/my_credit/t/<?php echo $name['credit_x']; ?>" <?php
            if ($name['credit_x'] == $type_name) {
                echo "class=current";
            }
                ?> ><?php echo $name['view_name']; ?></a>
<?php } ?>
        </h3>
        <div class="tagACot">
            <ul class="tblList">
                <li class="th">
                    <ul>
                        <li class="td1">操作类型</li>
                        <li class="td2">变化</li>
                        <li class="td3">描述</li>
                        <li class="td4">时间</li>
                    </ul>
                </li>
                <?php
                !isset($my_credit) && $my_credit = array();
                foreach ($my_credit as $key => $credit) {
                    ?>       
                    <li>
                        <ul>
                            <li class="td1"><?php echo $credit['action']; ?></li>
                            <li class="td2"><?php echo $credit['affect']; ?></li>
                            <li class="td3"><?php echo $credit['description']; ?></li>
                            <li class="td4"><?php echo date('Y-m-d H:i:s', $credit['time']); ?></li>
                        </ul>
                    </li>

            <?php } ?>
            </ul>
<?php echo $page; ?>
        </div>
    </div>  
    <div class="col4">
<?php $this->load->view('space_right'); ?>
    </div>    
</div>
<!--footer-->
