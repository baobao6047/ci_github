define('tts', ['jquery', 'dialog'], function(require, exports, module) {
    var $ = require('jquery');
    var artDialog = require('dialog');
    $('body').on('click', '#demo', function() {
        alert('a连接最新3');
    });
    $('.aaaa').click(function() {
        // alert('aaada');
        var d = artDialog({
            title: '追加份数',
            content: '大多情况下只需要一个content参数就能解决问题',
            width: '360',
            height: '200',
        });
        d.showModal();
    });

});
seajs.use("tts");