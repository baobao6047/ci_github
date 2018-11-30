;
// Example:
//
// var $dom1 = $('#dom1'),
//     $dom2 = $('#dom22');
// var exp = new vailForm([{
//     dom: $dom1,
//     vallist: [$dom1.length < 10,function(){return true/false;}],
//     mes:['is too long','function']
// }, {
//     dom: $dom2,
//     vallist: [$dom2.length > 4],
//     mes:['is too sort']
// }]);
// exp.vailStart();
define(function(require, exports, module) {
    var $ = require('jquery');
    var vailForm = function(opt) {
        var _optlist = opt;
        var _initOpt = {
            hide: false
        }
        var res = {
            mark: true,
            mes: ''
        };

        var _objVal = function(obj) {
            var _dom = obj.dom;
            var _list = obj.vailList;
            var _mes = obj.mes;
            if (_dom.is(':hidden')) return true;
            if (!_list || _list.length != _mes.length || _list.length == 0) {
                return console.log("param's len error");
            }
            var _flag = ($.inArray(false, _list) == -1);
            if (_list && !_flag) {
                res.mes = _mes[$.inArray(false, _list)];
                res.dom = _dom;
            }
            return _flag;
        }

        this.objAdd = function(opt) {
            _optlist.push(opt);
        }

        this.vailStart = function() {
            res = {
                mark: true,
                dom: '',
                mes: ''
            };
            for (var i = _optlist.length - 1; i >= 0; i--) {
                if (!_objVal(_optlist[i])) {
                    res.mark = false;
                }
            }
            return res;
        }
        return this;
    }
    module.exports = {
      mvailForm: vailForm
    }
});
