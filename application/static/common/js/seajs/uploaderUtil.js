/**
 *
 * 图片上传工具类
 *
 */
define(function(require, exports, module) {

    var $ = require("jquery");
    require("webuploader");

    var uploaderUtil = function() {};

    /*
     *
     */
    uploaderUtil.prototype.btnLoader = function(opt) {
        var _opt = {
            max: 1, // 最大数量
            btn: '', // 上传按钮
            btnText: '', // 按钮文字
            showView: '', // 图片预览
            url: '', // 上传路径
            name: '', // 上传name
            success: function(file) {}, // 上传成功
            error: function(file, res) {}, // 上传失败
            delete: function(file) {}, // 删除图片
        };
        _opt = $.extend({}, _opt, opt);
        var loader = new WebUploader.create({
            auto: true, // 选完文件后，是否自动上传
            pick: {
                id: $.type(_opt.btn) == 'string' ? _opt.btn : '',
                multiple: false
            },
            swf: $('#domain_seller').val() + '/Uploader.swf',
            server: _opt.url,
            fileNumLimit: _opt.max,
            fileVal: _opt.name,
            multiple: false,
            accept: {
                title: "Images",
                extensions: "gif,jpg,jpeg,png",
                mimeTypes: "image/gif,image/jpg,image/jpeg,image/png"
            }
        });
        loader.onError = function(e) {
            alert(e);
        }
        //图片上传
        loader.onUploadSuccess = function(file, res) {
            if (!res.success) {
                alert('图片上传失败，原因：' + res.data);
                this.removeFile(file.id, true);
                if ($.isFunction(_opt.error())) {
                    _opt.error(file);
                }
            } else {
                var thumbWidth = 60;
                var thumbHeight = 60;
                var $imgBox = $(_opt.showView);
                var $cont = $('<div class="J_imgThumb" data-imgData="' + res.data + '" id="' + file.id + '" style="float:left;overflow:hidden;height:60px;width:60px;display:inline-block;margin-right:5px;cursor:pointer;"></div>');
                loader.makeThumb(file, function(error, src) {
                    if (error) {
                        alert('图片预览失败');
                        return;
                    }
                    var $img = $('<img style="width:' + thumbWidth + 'px;height:' + thumbWidth + 'px;" src="' + $('#domain_img').val() + res.data + '">');
                    var $imgShowItem = '<div class="J_imgShowItem"><span data-fid="' + file.id + '" class="J_ImgDel' + file.id + '" style="background:#ccc;color:#fff;text-align:center;position:absolute;right:0;top:0;line-height:20px;padding:0 5px;cursor:pointer;">删除图片</span><img style="width: auto;height: auto;max-width: 298px;max-height: 298px;display:inline-block;text-align:center;line-height:400px;" src="' +
                        $('#domain_img').val() + res.data + '"></div>';
                    $imgBox.find('.J_imgThumb').length > 0 ? $imgBox.find('.J_imgThumb').last().after($cont.append($img)) : $imgBox.prepend($cont.append($img));
                    $imgBox.find('.J_imgShow').find('.J_imgShowItem').hide();
                    $imgBox.find('.J_imgShow').length > 0 ? $imgBox.find('.J_imgShow').append($imgShowItem) : $imgBox.append('<div class="J_imgShow" style="border:1px solid #ccc;width:300px;height:  300px;text-align:center;line-height:300px;position:relative;"></div>').find('.J_imgShow').append($imgShowItem);
                    if ($.isFunction(_opt.success(file))) {
                        _opt.success(file);
                    }
                }, thumbWidth, thumbHeight);
                $('body').on('click', '.J_ImgDel' + file.id, function() {
                    var result = confirm('是否删除图片？');
                    if (result) {
                        loader.removeFile($(this).data('fid'));
                        var index = $(this).parent().index();
                        $(_opt.showView).find('.J_imgThumb').eq(index).remove();
                        $(_opt.showView).find('.J_imgShow').hide();
                        $(this).parent().remove();
                        if ($.isFunction(_opt.delete())) {
                            _opt.delete(id);
                        }
                    }
                });
                $('body').on('click', '#' + file.id, function() {
                    $imgBox.find('.J_imgShow').show();
                    $imgBox.find('.J_imgShowItem').hide().eq($(this).index()).show();
                });
            }
        }

        loader.initFunction = function(files, callback, dcall) {
            console.log(files);
            var _id = 'Fuckimg';
            $.map(files, function(value, index) {
                htvalue = $('#domain_img').val() + value;
                var thumbWidth = 60;
                var thumbHeight = 60;
                var $imgBox = $(_opt.showView);
                var $cont = $('<div class="J_imgThumb" data-imgData="' + value + '" id="' + _id + index + '" style="float:left;overflow:hidden;height:60px;width:60px;display:inline-block;margin-right:5px;cursor:pointer;"></div>');
                var $img = $('<img src="' + htvalue + '" style="width:' + thumbWidth + 'px;height:' + thumbHeight + 'px;">');
                var $imgShowItem = '<div class="J_imgShowItem"><span data-fid="' + _id + index + '" class="J_ImgDel' + _id + index + '" style="background:#ccc;color:#fff;text-align:center;position:absolute;right:0;top:0;line-height:20px;padding:0 5px;cursor:pointer;">删除图片</span><img style="width: auto;height: auto;max-width: 298px;max-height: 298px;display:inline-block;text-align:center;line-height:400px;" src="' + htvalue + '"></div>';
                $imgBox.find('.J_imgThumb').length > 0 ? $imgBox.find('.J_imgThumb').last().after($cont.append($img)) : $imgBox.prepend($cont.append($img));
                $imgBox.find('.J_imgShow').find('.J_imgShowItem').hide();
                $imgBox.find('.J_imgShow').length > 0 ? $imgBox.find('.J_imgShow').append($imgShowItem) : $imgBox.append('<div class="J_imgShow" style="border:1px solid #ccc;width:300px;height:  300px;text-align:center;line-height:300px;position:relative;"></div>').find('.J_imgShow').append($imgShowItem);
                $('body').on('click', '.J_ImgDel' + _id + index, function() {
                    var result = confirm('是否删除图片？');
                    if (result) {
                        var index = $(this).parent().index();
                        $(_opt.showView).find('.J_imgThumb').eq(index).remove();
                        $(_opt.showView).find('.J_imgShow').hide();
                        $(this).parent().remove();
                        if ($.isFunction(dcall)) {
                            dcall();
                        }
                    }
                });
                $('body').on('click', '#' + _id + index, function() {
                    $imgBox.find('.J_imgShow').show();
                    $imgBox.find('.J_imgShowItem').hide().eq($(this).index()).show();
                });
                if ($.isFunction(_opt.success)) {
                    _opt.success();
                }
                if ($.isFunction(callback)) {
                    callback();
                }
            });
        }
        return loader;
    }

    module.exports = uploaderUtil.prototype;
});
