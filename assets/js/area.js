/**
 * Created by dungang.
 */
+function ($) {
    'use strict';
    function load(url,type,code,assemble) {
        $.getJSON(url,{code:code,type:type},function(data){
            assembleOptions(assemble,data);
        });
    }
    
    function assembleOptions(obj,data) {
        $.each(data,function(i,item){
            obj.append($("<option></option>").val(item["code"]).text(item["name"]));
        });
    }

    $.fn.area = function (options) {

        var opts = $.extend({},$.fn.area.default,options);
        return this.each(function () {
            var _this = $(this);

            var id = _this.attr('id');
            var province = $('#' + id + opts.provinceCode);
            var city = $('#' + id + opts.cityCode);
            var area = $('#' + id + opts.areaCode);

            function updateRefer(obj,refer) {
                if (obj.val() != ""){
                    var text = obj.find('option:selected').text();
                    var referInput = _this.find('input[name="'+refer+'"]');
                    referInput && referInput.val(text);
                }
            }

            if (opts.enabled == false) {
                province.attr('disabled','disabled');
                city.attr('disabled','disabled');
                area.attr('disabled','disabled');
                return false;
            }
            province.change(function () {
                city.empty();
                city.append($("<option></option>").val('').text('请选择城市'));
                area.empty();
                area.append($("<option></option>").val('').text('请选择区/县'));
                load(opts.url,'city',province.val(),city);
                updateRefer(province,opts.provinceName);
            });
            city.change(function () {
                area.empty();
                area.append($("<option></option>").val('').text('请选择区/县'));
                load(opts.url,'area',city.val(),area);
                updateRefer(city,opts.cityName);
            });
            area.change(function () {
                updateRefer(area,opts.areaName);
            });
            updateRefer(province,opts.provinceName);
            updateRefer(city,opts.cityName);
            updateRefer(area,opts.areaName);

        })
    };
    
    $.fn.area.default = {
        url:'',
        provinceCode:'provinceCode',
        cityCode:'cityCode',
        areaCode:'areaCode',
        provinceName:'province',
        cityName:'city',
        areaName:'area',
        enabled:true
    };
}(jQuery);