define('tts', ['jquery', 'dialog'], function(require, exports, module) {
    var $ = require('jquery');
    var artDialog = require('dialog');
    $('body').on('click', '#demo', function() {
        alert('a连接最新3');
    });
    $('.aaaa').click(function() {
        alert('aaada');
        var d = artDialog({
            title: '追加份数',
            content: '大多情况下只需要一个content参数就能解决问题',
            width: '360',
            height: '200',
        });
        d.showModal();
    });

    var toTop = function() {

        var a = function(c, f, e) {
            var d = $(c).click(function() {
                    $("body,html").animate({
                        scrollTop: 0
                    }, e);
                    return false
                }),
                g = $(window),
                b = 1140;
            if (g.width() >= b) {
                $(this).scroll(function() {
                    $(this).scrollTop() > f ? d.fadeIn(e) : d.fadeOut(e)
                })
            }
        };

        $('<a id="backToTop" title="\u56de\u5230\u9876\u90e8" target="_self" href="javascript:;"><i>回到顶部</i><span class="ico-A"></span><span class="ico-B"></span><span class="ico-C"></span></a>').appendTo("body");
        a("#backToTop", 500, 300);

    };
    toTop();

});
seajs.use("tts");