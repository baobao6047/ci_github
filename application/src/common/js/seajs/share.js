    /**
     * 分享插件
     */
define(function(require, exports, module) {
    var $ = require("jquery");

     //插件初始化
    function init(target, options) {
        var settings = $.extend({}, $.fn.socialShare.defaults, options);


        //添加腾讯微博分享事件
        $("body").on("click",".msb_network_button.tQQ",function(){
            tQQ(this,settings);
        });
        //添加QQ空间分享事件
        $("body").on("click",".msb_network_button.qZone",function(){
            qZone(this,settings);
        });
        //添加新浪微博分享事件
        $("body").on("click",".msb_network_button.sina",function(){
            sinaWeibo(this,settings);
        });
        //qq好友
        $("body").on("click",".msb_network_button.qqF",function(){
            qqF(this,settings);
        });
    }

    function replaceAPI (api,options) {//encodeURIComponent()把字符串作为 URI 组件进行编码
        api = api.replace('{url}', encodeURIComponent(options.url));
        api = api.replace('{title}', encodeURIComponent(options.title));
        api = api.replace('{content}', encodeURIComponent(options.content));
        api = api.replace('{pic}', encodeURIComponent(options.pic));

        return api;
    }

    function tQQ(target,options){
        var options = $.extend({}, $.fn.socialShare.defaults, options);
        window.open(replaceAPI(tqq,options));
    }

    function qZone(target,options){
        var options = $.extend({}, $.fn.socialShare.defaults, options);
        window.open(replaceAPI(qzone,options));
    }

    function sinaWeibo(target,options){
        var options = $.extend({}, $.fn.socialShare.defaults, options);
        window.open(replaceAPI(sina,options));
    }

    function qqF(target,options){
        var options = $.extend({}, $.fn.socialShare.defaults, options);
        window.open(replaceAPI(qqFriend,options));
    }


    $.fn.socialShare = function(options, param) {
        if(typeof options == 'string'){
            var method = $.fn.socialShare.methods[options];
            if(method)
                return method(this,param);
        }else
            init(this,options);
    }


    //插件默认参数
    // $.fn.socialShare.defaults = {
    //     url: window.location.href,
    //     title: document.title,
    //     content: '',
    //     pic: ''
    // }

    //插件方法
    $.fn.socialShare.methods = {
        //初始化方法
        init:function(jq,options){
            return jq.each(function(){
                init(this,options);
            });
        },
        tQQ:function(jq,options){
            return jq.each(function(){
                tQQ(this,options);
            })
        },
        qZone:function(jq,options){
            return jq.each(function(){
                qZone(this,options);
            })
        },
        sinaWeibo:function(jq,options) {
            return jq.each(function(){
                sinaWeibo(this,options);
            });
        },
        qqF:function(jq,options) {
            return jq.each(function(){
                qqF(this,options);
            });
        }
    }


    //分享地址
    var qzone = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url={url}&title={title}&pics={pic}&summary={content}';
    var sina = 'http://service.weibo.com/share/share.php?url={url}&title={title}&pic={pic}&searchPic=false';
    var tqq = 'http://share.v.t.qq.com/index.php?c=share&a=index&url={url}&title={title}&pic={pic}&appkey=801cf76d3cfc44ada52ec13114e84a96';//
    var qqFriend = 'http://connect.qq.com/widget/shareqq/index.html?url={url}&title={title}&pics={pic}&summary={content}';
});