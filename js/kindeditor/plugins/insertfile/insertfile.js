/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('insertfile', function(K) {
	var self = this, name = 'insertfile',
		allowFileUpload = K.undef(self.allowFileUpload, true),
		allowFileManager = K.undef(self.allowFileManager, false),
		formatUploadUrl = K.undef(self.formatUploadUrl, true),
		uploadJson = K.undef(self.uploadJson, self.basePath + 'php/upload_json.php'),
		extraParams = K.undef(self.extraFileUploadParams, {}),
		filePostName = K.undef(self.filePostName, 'imgFile'),
		lang = self.lang(name + '.');
        var target = 'kindeditor_upload_iframe_' + new Date().getTime();
        var insertFile = function(url, title, aid){
            return '<a aid="' + aid + '" class="ke-insertfile" href="' + url + '" data-ke-src="' + url + '" target="_blank">' + title + '</a>';
        }
	self.plugin.fileDialog = function(options) {
		var fileUrl = K.undef(options.fileUrl, 'http://'),
			fileTitle = K.undef(options.fileTitle, ''),
			clickFn = options.clickFn;
		var html = [
			'<div style="padding:20px;">',
                        '<iframe name="' + target + '" style="display:none;"></iframe>',
                        '<form class="ke-upload-area ke-form" method="post" enctype="multipart/form-data" target="' + target + '" action="' + K.addParam(uploadJson, 'dir=file') + '">',
                        //file
                        '<div class="ke-dialog-row">',
                        '<label style="width:60px;">' + lang.localUrl + '</label>',
                        '<input type="text" name="localUrl" class="ke-input-text" tabindex="-1" style="width:200px;" readonly="true" /> &nbsp;',
                        '<input type="button" class="ke-upload-button" value="' + lang.upload + '" />',
                        '</div>',
			//title
			'<div class="ke-dialog-row">',
			'<label for="keTitle" style="width:60px;">' + lang.title + '</label>',
			'<input type="text" id="keTitle" class="ke-input-text" name="title" value="" style="width:160px;" /></div>',
			'</div>',
			//form end
			'</form>',
			'</div>'
			].join('');
		var dialog = self.createDialog({
			name : name,
			width : 450,
			title : self.lang(name),
			body : html,
			yesBtn : {
				name : self.lang('yes'),
				click : function(e) {
                                        if (dialog.isLoading) {
						return;
					}
                                        if (uploadbutton.fileBox.val() == '') {
                                                alert(self.lang('pleaseSelectFile'));
                                                return;
                                        }
                                        dialog.showLoading(self.lang('uploadLoading'));
                                        uploadbutton.submit();
                                        localUrlBox.val('');
                                        return;
				}
			}
		}),
		div = dialog.div;

		var localUrlBox = K('[name="localUrl"]', div),
			viewServerBtn = K('[name="viewServer"]', div),
			titleBox = K('[name="title"]', div);

		if (allowFileUpload) {
			var uploadbutton = K.uploadbutton({
				button : K('.ke-upload-button', div)[0],
				fieldName : filePostName,
				extraParams : extraParams,
                                form : K('.ke-form', div),
                                target : target,
                                width: 60,
				afterUpload : function(data) {
					dialog.hideLoading();
					if (data.error === 0) {
                                            var url = data.url,title=data.title,aid=data.aid;
                                            if (formatUploadUrl) {
                                                    url = K.formatUrl(url, 'absolute');
                                            }
                                            if (url == 'http://' || K.invalidUrl(url)) {
                                                    alert(self.lang('invalidUrl'));
                                                    localUrlBox[0].focus();
                                                    return;
                                            }
                                            localUrlBox.val(url);
                                            if (self.afterUpload) {
                                                    self.afterUpload.call(self, url, data, name);
                                            }
                                            if (K.trim(title) === '') {
                                                    title = url;
                                            }
                                            var html = insertFile(url, title, aid);
                                            K.uploadFiles[aid]=html;
                                            clickFn.call(self, url, title, aid);
					} else {
						alert(data.message);
					}
				},
				afterError : function(html) {
					dialog.hideLoading();
					self.errorDialog(html);
				}
			});
                        uploadbutton.fileBox.change(function(e) {
                                localUrlBox.val(uploadbutton.fileBox.val());
                        });
                        /*
			uploadbutton.fileBox.change(function(e) {
				dialog.showLoading(self.lang('uploadLoading'));
				uploadbutton.submit();
			});*/
		} else {
			K('.ke-upload-button', div).hide();
		}
		if (allowFileManager) {
			viewServerBtn.click(function(e) {
				self.loadPlugin('filemanager', function() {
					self.plugin.filemanagerDialog({
						viewType : 'LIST',
						dirName : 'file',
						clickFn : function(url, title,aid) {
							if (self.dialogs.length > 1) {
								K('[name="url"]', div).val(url);
								if (self.afterSelectFile) {
									self.afterSelectFile.call(self, url);
								}
								self.hideDialog();
							}
						}
					});
				});
			});
		} else {
			viewServerBtn.hide();
		}
		localUrlBox.val(fileUrl);
		titleBox.val(fileTitle);
		localUrlBox[0].focus();
		localUrlBox[0].select();
	};
	self.clickToolbar(name, function() {
		self.plugin.fileDialog({
			clickFn : function(url, title, aid) {
                                var html = insertFile(url, title, aid);
				self.insertHtml(html).hideDialog().focus();
			}
		});
	});
});
