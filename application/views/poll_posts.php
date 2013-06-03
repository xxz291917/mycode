<div class="exfm cl">
  <div class="sinf sppoll z">
    <input type="hidden" value="2" name="fid">
    <input type="hidden" value="1" name="tpolloption">
    <div class="cl">
      <h4 class="z"> <em>选项: </em> 最多可填写 50 个选项 &nbsp;</h4>
    </div>
    <div class="mbm" id="pollm_c_1">
      <p> <a onclick="delpolloption(this)" class="d" href="javascript:;">del</a>
        <input name="poll_option[]" type="text" class="px vm" style="width:290px;" tabindex="1" value="www" autocomplete="off">
        <span style="display: none;" class="vm" id="pollUploadProgress_1"></span>
      </p>
      <p> <a onclick="delpolloption(this)" class="d" href="javascript:;">del</a>
        <input type="text" tabindex="1" style="width:290px;" autocomplete="off" class="px vm" name="poll_option[]">
        <span style="display: none;" class="vm" id="pollUploadProgress_2"></span>
      </p>
      <p> <a onclick="delpolloption(this)" class="d" href="javascript:;">del</a>
        <input type="text" tabindex="1" style="width:290px;" autocomplete="off" class="px vm" name="poll_option[]">
        <span style="display: none;" class="vm" id="pollUploadProgress_3"></span>
      </p>
      <span id="polloption_new"></span>
      <p style="display: none" id="polloption_hidden"> <a onclick="delpolloption(this)" class="d" href="javascript:;">del</a>
        <input type="text" tabindex="1" style="width:290px;" autocomplete="off" class="px vm" name="poll_options[]">
        <span style="display: none;" class="vm" id="pollUploadProgress"></span> <span class="vm" id="newpoll"></span> </p>
      <p><a onclick="addpolloption()" href="javascript:;">+增加一项</a></p>
    </div>
  </div>
  <div class="sadd z">
    <p class="mbn">
      <label for="maxchoices">最多可选</label>
      <input type="text" tabindex="1" value="1" class="px pxs" id="maxchoices" name="max_choices">
      项 </p>
    <p class="mbn">
      <label for="polldatas">记票天数</label>
      <input type="text" tabindex="1" value="" class="px pxs" id="polldatas" name="expire_time">
      天 </p>
    <p class="mbn">
      <input type="checkbox" tabindex="1" value="1" class="pc" id="visibilitypoll" name="is_visible">
      <label for="visibilitypoll">投票后结果可见</label>
    </p>
    <p class="mbn">
      <input type="checkbox" tabindex="1" value="1" class="pc" id="overt" name="is_overt">
      <label for="overt">公开投票参与人</label>
    </p>
  </div>
</div>
