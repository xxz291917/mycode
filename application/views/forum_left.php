    <div class="col1 pr"> 
        <nav class="leftNav">
      <?php foreach($forums as $subforum){?>
      <dl>
        <dt><a href="javascript:void(0);"><?php echo $subforum['name']; ?></a></dt>
        	<?php 
			if(!empty($subforum['sub'])){
			foreach($subforum['sub'] as $sub){?>
        		<dd><a href="<?php echo base_url('index.php/forum/show/'.$sub['id']);?>"><?php echo $sub['name']; ?></a></dd>
        	<?php }}?>
      </dl>
      <?php }?>

        </nav>
        <span class="leftNavCtrl pa"></span>
    </div>
    