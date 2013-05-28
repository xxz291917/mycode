KindEditor.plugin('hide', function(K) {
        var editor = this, name = 'hide';
        // 点击图标时执行
        editor.clickToolbar(name, function() {
                editor.insertHtml('你好');
                editor.edit.design(false);
        });
});