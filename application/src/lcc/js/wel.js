define('wel', ['jquery', 'dialog', 'common/js/seajs/laydate.dev'], function(require, exports, module) {
    // define(function(require) {
    var $ = require("jquery");
    var artDialog = require('dialog');
    require("common/js/seajs/laydate.dev");

    $('body').on('click', '#demo', function() {
        // artDialog({
        //         content: '欢迎你来到对话框世界！',
        //         lock: true,
        //         style: 'succeed noClose'
        //     },
        //     function() {
        //         alert('你点了确定');
        //     },
        //     function() {
        //         alert('你点了取消');
        //     }
        // );
        alert('a连接');
    });
    $('.aaaa').on('click', function() {
        $.ajax({
            url: '/welcome/test',
            dataType: 'json',
            type: 'post',
            data: {
                try_id: 1,
                status: 2
            },
            success: function(msg) {
                alert('活动' + msg);
            },
            error: function(e) {
                console.log('系统错误');
                console.log(e);
            }
        });
    });


    $('.add').on('click', function() {

        function total(callBack) {
            $.ajax({
                url: '/welcome/quantity',
                dataType: 'json',
                type: 'post',
                data: {},
                success: function(msg) {
                    if (!!msg) {
                        callBack(msg);
                    }
                },
                error: function(e) {
                    console.log('系统错误');
                    console.log(e);
                }
            });
        }

        function tpl(num) {
            var cont = ' <style media="screen"> #addform input{ height: 27px; } #addform p{ margin-top: 20px; } #addform .btn{ background: #F86769; color: #fff; border:0; height: 27px; border-radius: 4px; } </style> ' +
                '<form id="addform" class="row">' +
                '<p class="clearfix"><label class="col-sm-4 col-xs-4 f-tar">剩余份数</label>' + num + ' 份</p>' +
                '<p class="clearfix"><label class="col-sm-4 col-xs-4 f-tar">追加份数</label><input type="text" name="num" class=" input col-sm-6 col-xs-6"></p>' +
                '<p class="clearfix"><button class="J_addsub btn col-sm-3 col-xs-3 col-sm-offset-4 col-xs-offset-4">确定</button></p>' +
                '</form>';
            return cont;
        }
    });
});
seajs.use("wel");