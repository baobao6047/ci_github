define(function(require, exports, module) {
    var $ = require('jquery');

    (function() {

        $.region = function(opt) {
            opt = opt || {};

            //默认option
            var province_option = '<option value="0">省/自治区/直辖市</option>';
            var city_option = '<option value="0">城市</option>';
            var proper_option = '<option value="0">城区</option>';
            var village_option = '<option value="0">小区/商圈</option>';
            var cate_1_option = '<option value="0">请选择一级分类</option>';
            var cate_2_option = '<option value="0">请选择二级分类</option>';

            var $province = $(opt.province || '');
            var $city = $(opt.city || '');
            var $proper = $(opt.proper || '');
            var $village = $(opt.village || '');
            var $cate_1 = $(opt.cate_1 || '');
            var $cate_2 = $(opt.cate_2 || '');

            var store_pid = $province.val();
            var store_cid = $city.val();
            var store_ppid = $proper.val();
            var store_vid = $village.val();
            var store_cate_pid = $cate_1.val();
            var store_cate_id = $cate_2.val();

            var pidInit = $province.data('init') || 0;
            var cidInit = $city.data('init') || 0;
            var ppidInit = $proper.data('init') || 0;
            var vidInit = $village.data('init') || 0;
            var cpid1Init = $cate_1.data('init') || 0;
            var cpid2Init = $cate_2.data('init') || 0;

            var region_list = opt.region_list || {};
            var cate_list = opt.cate_list || {};

            //选项框初始化
            var options = makeRegionOptions(province_option, region_list);
            if (store_pid == 0 || store_pid == undefined) {
                $province.html(options);
                $city.html(city_option);
                $proper.html(proper_option);
                $village.html(village_option);
            }
            if (store_cate_pid == 0 || store_cate_pid == undefined) {
                var options = makeCateOptions(cate_1_option, cate_list);
                $cate_1.html(options);
                $cate_2.html(cate_2_option);
            }

            //绑定函数
            $province.change(function() {
                var pid = $(this).val();
                if (pid == 0) {
                    $city.html(city_option);
                    $proper.html(proper_option);
                    $village.html(village_option);
                } else {
                    var options = makeRegionOptions(city_option, region_list[pid]['children']);
                    $city.html(options);
                    $proper.html(proper_option);
                    $village.html(village_option);
                }
            });
            $city.change(function() {
                var pid = $province.val();
                var cid = $(this).val();
                if (cid == 0) {
                    $proper.html(proper_option);
                    $village.html(village_option);
                } else {
                    var options = makeRegionOptions(proper_option, region_list[pid]['children'][cid]['children']);
                    $proper.html(options);
                    $village.html(village_option);
                }
            });
            $proper.change(function() {
                var pid = $province.val();
                var cid = $city.val();
                var ppid = $(this).val();
                if (ppid == 0) {
                    $village.html(village_option);
                } else {
                    var options = makeRegionOptions(village_option, region_list[pid]['children'][cid]['children'][ppid]['children']);
                    $village.html(options);
                }
            });
            $cate_1.change(function() {
                var cate_id = $(this).val();
                if (cate_id == 0) {
                    $cate_2.html(cate_2_option);
                } else {
                    var options = makeCateOptions(cate_2_option, cate_list[cate_id]['children']);
                    $cate_2.html(options);
                }
            });

            editInit();


            // 构造地区选项框option
            function makeRegionOptions(option, regionList) {
                var options = option;
                for (var k in regionList) {
                    if (regionList[k]['hidden'] == 0 && regionList[k]['deleted'] == 0) options += '<option value="' + regionList[k]['region_id'] + '">' + regionList[k]['region_name'] + '</option>'
                };
                return options;
            }

            // 构造分类选项框option
            function makeCateOptions(option, cateList) {
                var options = option;
                for (var k in cateList) {
                    if (cateList[k]['enable'] == 1 && cateList[k]['deleted'] == 0) options += '<option value="' + cateList[k]['id'] + '">' + cateList[k]['name'] + '</option>'
                };
                return options;
            }


            //编辑时店铺初始化选项框
            function editInit() {

                $.inArray('' + pidInit, $.map($province.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $province.val(pidInit).change() : $province.val(0).change();

                $.inArray('' + cidInit, $.map($city.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $city.val(cidInit).change() : $city.val(0).change();

                $.inArray('' + ppidInit, $.map($proper.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $proper.val(ppidInit).change() : $proper.val(0).change();

                $.inArray('' + vidInit, $.map($village.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $village.val(vidInit).change() : $village.val(0).change();


                $.inArray('' + cpid1Init, $.map($cate_1.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $cate_1.val(cpid1Init).change() : $cate_1.val(0).change();


                $.inArray('' + cpid2Init, $.map($cate_2.find('option'), function(val) {
                    return $(val).val();
                }))>-1 ? $cate_2.val(cpid2Init).change() : $cate_2.val(0).change();

                // options = makeCateOptions(cate_1_option, cate_list);
                // $cate_1.append(options);
                // options = makeCateOptions(cate_2_option, cate_list[store_cate_pid]['children']);
                // $cate_2.append(options);

            }


            function isset(varb) {
                return varb != 0 && varb != undefined;
            }
        }
    })($);
});
