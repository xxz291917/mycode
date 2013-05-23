<h4>搜索帖子</h4>
<form name="search" method="get" action="<?=current_url()?>" class="form row">
  <fieldset>
    <div>
      <label for="forums">版块：</label>
      <select name="forums[]" size="5" multiple="multiple" class="select">
        <?=$forums_option?>
      </select>
    </div>
    <div>
      <label for="user">用户名/用户id：</label>
      <input name="user" type="text" class="inp_txt" value="<?php echo my_set_value('user',$data);?>" />
    </div>
    <div>
      <label for="content">标题关键字：<em class="feedback"></em></label>
      <input name="content" class="inp_txt" type="text" value="<?php echo my_set_value('content',$data);?>" />
    </div>
    <div>
      <label>发帖时间：<em class="feedback"></em></label>
      <input name="start_time" class="inp_txt inp_date_num" type="text" value="<?php echo my_set_date('start_time',$data,'Y-m-d');?>" /> -
      <input name="end_time" class="inp_txt inp_date_num" type="text" value="<?php echo my_set_date('end_time',$data,'Y-m-d');?>" />
    </div>
    <div>
      <label>&nbsp;</label>
      <input class="inp_btn" name="submit" type="submit" value="搜索" />
    </div>
  </fieldset>
</form>
<script type="text/javascript">
    $(function() {
        $("input[name='start_time'] , input[name='end_time']").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>