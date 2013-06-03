<div class="exfm cl">
<div class="sinf sppoll z">
<dl>
<dt><span class="rq">*</span><label for="affirmpoint">正方观点:</label></dt>
<dd><textarea style="width:210px;" tabindex="1" class="pt" id="affirmpoint" name="affirmpoint"></textarea></dd>
<dt><span class="rq">*</span><label for="negapoint">反方观点:</label></dt>
<dd><textarea style="width:210px;" tabindex="1" class="pt" id="negapoint" name="negapoint"></textarea></dd>
</dl>
</div>
<div class="sadd z">
<dl>
<dt><label for="endtime">结束时间:</label></dt>
<dd class="hasd cl">
<input type="text" tabindex="1" value="" autocomplete="off" onclick="showcalendar(event, this, true)" class="px" id="endtime" name="endtime">
<a onclick="showselect(this, 'endtime')" class="dpbtn" href="javascript:;">^</a>
</dd>
<dt><label for="umpire">裁判:</label></dt>
<dd>
<p><input type="text" tabindex="1" value="" onblur="checkuserexists(this.value, 'checkuserinfo')" class="px" id="umpire" name="umpire"><span id="checkuserinfo"></span></p>
</dd>
</dl>
</div>
</div>