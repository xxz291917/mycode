/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('smiley', function(K) {
	var self = this, name = 'smiley',
		//path = (self.emoticonsPath || self.pluginsPath + 'smiley/images/'),
		path,smileys=null,
		allowPreview = self.allowPreviewEmoticons === undefined ? true : self.allowPreviewEmoticons,
		currentPageNum = 1;
	self.clickToolbar(name, function() {
		//通过ajax获取数据库中的表情。
		if(K.smileys==null){
			$.ajax({
				type: "POST",
				async: false,
				url: K.smileUrl,
				success: function(json){
					K.smileys = json.data;
				},
				dataType: 'json',
			});
			/*
			$.getJSON(K.smileUrl, function(json){
				K.smileys = json.data;
			});*/
		}
		smileys = K.smileys;
		if(!smileys) return;
		
		function getJsonLength(jsonData){
			var jsonLength = 0;
			for(var item in jsonData){
				jsonLength++;
			}
			return jsonLength;
		}
		var rows = 3, cols = 8, total = getJsonLength(smileys), startNum = 1,
			cells = rows * cols, pages = Math.ceil(total / cells),
			colsHalf = Math.floor(cols / 2),
			wrapperDiv = K('<div class="ke-plugin-emoticons"></div>'),
			elements = [],
			menu = self.createMenu({
				name : name,
				beforeRemove : function() {
					removeEvent();
				}
			});
		menu.div.append(wrapperDiv);
		var previewDiv, previewImg;
		if (allowPreview) {
			previewDiv = K('<div class="ke-preview"></div>').css('right', 0);
			previewImg = K('<img class="ke-preview-img" src="' + smileys[startNum].url + '" />');
			wrapperDiv.append(previewDiv);
			previewDiv.append(previewImg);
		}
		var table = createEmoticonsTable(currentPageNum, wrapperDiv);
		var pageDiv;
		createPageTable(currentPageNum);
		
		function removeEvent() {
			K.each(elements, function() {
				this.unbind();
			});
		}
		function bindPageEvent(el, pageNum) {
			el.click(function(e) {
				removeEvent();
				table.parentNode.removeChild(table);
				pageDiv.remove();
				table = createEmoticonsTable(pageNum, wrapperDiv);
				createPageTable(pageNum);
				currentPageNum = pageNum;
				e.stop();
			});
		}
		function createPageTable(currentPageNum) {
			pageDiv = K('<div class="ke-page"></div>');
			wrapperDiv.append(pageDiv);
			for (var pageNum = 1; pageNum <= pages; pageNum++) {
				if (currentPageNum !== pageNum) {
					var a = K('<a href="javascript:;">[' + pageNum + ']</a>');
					bindPageEvent(a, pageNum);
					pageDiv.append(a);
					elements.push(a);
				} else {
					pageDiv.append(K('@[' + pageNum + ']'));
				}
				pageDiv.append(K('@&nbsp;'));
			}
		}
		function getJsonLength(jsonData){
			var jsonLength = 0;
			for(var item in jsonData){
				jsonLength++;
			}
			return jsonLength;
		}
		function bindCellEvent(cell, j, num) {
			if (previewDiv) {
				cell.mouseover(function() {
					if (j > colsHalf) {
						previewDiv.css('left', 0);
						previewDiv.css('right', '');
					} else {
						previewDiv.css('left', '');
						previewDiv.css('right', 0);
					}
					previewImg.attr('src', smileys[num].url);
					K(this).addClass('ke-on');
				});
			} else {
				cell.mouseover(function() {
					K(this).addClass('ke-on');
				});
			}
			cell.mouseout(function() {
				K(this).removeClass('ke-on');
			});
			cell.click(function(e) {
				self.insertHtml('<img src="' + smileys[num].url + '" border="0" smileId="'+smileys[num].id+'" />').hideMenu().focus();
				e.stop();
			});
		}
		function createEmoticonsTable(pageNum, parentDiv) {
			var table = document.createElement('table');
			parentDiv.append(table);
			if (previewDiv) {
				K(table).mouseover(function() {
					previewDiv.show('block');
				});
				K(table).mouseout(function() {
					previewDiv.hide();
				});
				elements.push(K(table));
			}
			table.className = 'ke-table';
			table.cellPadding = 0;
			table.cellSpacing = 0;
			table.border = 0;
			var num = (pageNum - 1) * cells + startNum;
			for (var i = 0; i < rows; i++) {
				var row = table.insertRow(i);
				for (var j = 0; j < cols; j++) {
					if(num>total) break;
					var cell = K(row.insertCell(j));
					cell.addClass('ke-cell');
					bindCellEvent(cell, j, num);
					var span = K('<span class="ke-img"><img src="' + smileys[num].url + '" border="0" width="20" /></span>');
					cell.append(span);
					elements.push(cell);
					num++;
				}
			}
			return table;
		}
		
	});
});
