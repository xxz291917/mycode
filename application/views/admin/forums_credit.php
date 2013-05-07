<h3>编辑版块：<?=$data['name']?></h3>
<p class="sec_nav">
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/basic"><span>基本设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/seo"><span>SEO设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/post"><span>帖子相关</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/access"><span>权限设置</span></a>
<a href="<?=base_url()?>index.php/admin/forums/edit/<?=$data['id']?>/credit" class="on"><span>积分设置</span></a>
</p>
<!--<ul class="col-ul tips">
  <li><b>提示: </b></li>
  <li>双击版块名称可编辑版块标题</li>
</ul>-->
<?php echo form_open(base_url().'index.php/admin/forums/edit/'.$data['id'])?>
<table class="table fspan">
<thead>
  <tr>
    <th >用户行为</th>
    <th >周期</th>
    <!--th >间隔时间</th-->
    <th >奖励次数</th>
    <?php foreach ($credit_names as $key => $value) {
        echo '<th >'.$value['view_name'].'</th>';
    }
    ?>
  </tr>
</thead>
  <?php foreach($credit_rules as $rules){ ?>
  <tr>
    <td ><?=$rules['name']?></td>
    <td ><?=$cycle_names[$rules['cycle_type']]?></td>
    <!--td ><?=$rules['cycle_time']?></td-->
    <td ><?=$rules['reward_num']?></td>
    <?php foreach ($credit_names as $key => $value){ ?>
    <td ><input type="text" class="inp_txt inp_num" value="<?php if(isset($data['credit_setting'][$rules['action']][$value['credit_x']])) echo $data['credit_setting'][$rules['action']][$value['credit_x']];?>" name="<?php echo 'credit_setting'.'['.$rules['action'].']'.'['.$value['credit_x'].']'?>"></td>
    <?php }?>
  </tr>
  <?php }?>
</table>
<p class="div_bottom">
  <input class="inp_btn" name="submit" type="submit" value="提交" />
</p>
<?php echo form_close() ?>