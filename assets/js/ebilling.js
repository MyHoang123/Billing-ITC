/**
 * Created by levuh on 18/05/2018.
 */
/**
 * Created by ad on 11/30/2017.
 */
var _arrContentBtnLoading = {};

Array.prototype.diff = function(a) {
    return this.filter(function(i) {return a.indexOf(i) < 0;});
};

Array.prototype.getIndexs = function (cols) {
    var result = [];
    if(Array.isArray(this)){
        if(Array.isArray(cols)){
            this.forEach(function (item, idx) {
                if(cols.indexOf(item) > -1){
                    result.push(idx);
                }
            });
            return result;
        }else{
            this.forEach(function (item, idx) {
                if(item == cols){
                    return result.push(idx);
                }
            });
        }
    }
    return result;
};

$.fn.blockUI = function() {
    this.block({ 
        message: '<i class="la la-spinner spinner"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait',
            'box-shadow': '0 0 0 1px #ddd'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
    return this;
};

$.fn.waiting = function() {
    if( this.is( "select") && this.hasClass("selectpicker") ){
        this.html('').append( '<option class="waiting" data-content="<i class=\'la la-spinner spinner\' style=\'margin: 0 47%\'></i>">-</option>' )
                     .selectpicker("refresh");
    }

    return this;
};

function convertDateTimeFormat(fullDateTime, format) {
    var dateTime = '';

    if(fullDateTime) {
        var date = fullDateTime.split( " " )[0];
        var time = fullDateTime.split( " " )[1];

        var datePath = date.split(/[\/\-]/);
        var timePath = time ? time.split(":") : "00:00:00".split(":");

        var year = datePath.filter( p=> p.length == 4 )[0];
        var month = datePath[1];
        var day = datePath.filter( p=> p.length <= 2 && datePath.indexOf(p) != datePath.indexOf(month)  )[0];

        var hour = timePath[0] ? timePath[0] : 0;
        var minute = timePath[1] ? timePath[1] : 0;
        var second = timePath[2] ? timePath[2] : 0;

        var now = new Date(year, month, day, hour, minute, second);
        
        if(!now || now.toString().indexOf('Invalid') != -1){
            return fullDateTime;
        }

        if(month.toString().length == 1) {
            var month = '0'+month;
        }
        if(day.toString().length == 1) {
            var day = '0'+day;
        }
        if(hour.toString().length == 1) {
            var hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
            var minute = '0'+minute;
        }
        if(second.toString().length == 1) {
            var second = '0'+second;
        }

        if (typeof format === "undefined" || format === null) {
            format = '';
        }

        switch(format){
            case '':
            case 'd/m/y':
                dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'd-m-y':
                dateTime = day+'-'+month+'-'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'y/m/d':
                dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;
                break;
            case 'y-m-d':
                dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
                break;
            case 'm/d/y':
                dateTime = month+'/'+day+'/'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'm-d-y':
                dateTime = month+'-'+day+'-'+year+' '+hour+':'+minute+':'+second;
                break;
            default:
                dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;
                break;
        }
    } else {
        dateTime = '';
    }

    return dateTime;
}
 
function getDateTime(fullDateTime, format) {
    var dateTime = '';

    if(fullDateTime) {
        var ua = window.navigator.userAgent;
        var td = '';
        var msie = ua.indexOf("MSIE");
        var tdie = ua.indexOf("Trident");
        var safari = ua.indexOf("Safari");

        if (msie > 0 || tdie > 0 || safari > 0)
        {
            var year = fullDateTime.substr(0, 4);
            var month = parseInt(fullDateTime.substr(5, 2))-1;
            var day = fullDateTime.substr(8, 2);
            var h = fullDateTime.substr(11, 2);
            var i = fullDateTime.substr(14, 2);
            var s = fullDateTime.substr(17, 2);
            var now = new Date(year, month, day, h, i, s);
        }
        else
        {
            var now = new Date(fullDateTime);
        }

        if(now.toString().indexOf('Invalid') != -1){
            return fullDateTime;
        }

        var year    = now.getFullYear();
        var month   = now.getMonth()+1;
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        var second  = now.getSeconds();

        if(month.toString().length == 1) {
            var month = '0'+month;
        }
        if(day.toString().length == 1) {
            var day = '0'+day;
        }
        if(hour.toString().length == 1) {
            var hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
            var minute = '0'+minute;
        }
        if(second.toString().length == 1) {
            var second = '0'+second;
        }

        if (typeof format === "undefined" || format === null) {
            format = '';
        }

        switch(format){
            case '':
            case 'd/m/y':
                dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'd-m-y':
                dateTime = day+'-'+month+'-'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'y/m/d':
                dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;
                break;
            case 'y-m-d':
                dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
                break;
            case 'm/d/y':
                dateTime = month+'/'+day+'/'+year+' '+hour+':'+minute+':'+second;
                break;
            case 'm-d-y':
                dateTime = month+'-'+day+'-'+year+' '+hour+':'+minute+':'+second;
                break;
            default:
                dateTime = day+'/'+month+'/'+year+' '+hour+':'+minute+':'+second;
                break;
        }
    } else {
        dateTime = '';
    }

    return dateTime;
}

function dateformat(timestamp) {
    var date = new Date(timestamp*1000);
    var year = date.getFullYear();
    var month = ("0"+(date.getMonth()+1)).substr(-2);
    var day = ("0"+date.getDate()).substr(-2);
    var hour = ("0"+date.getHours()).substr(-2);
    var minutes = ("0"+date.getMinutes()).substr(-2);
    var seconds = ("0"+date.getSeconds()).substr(-2);

    return day+"/"+month+"/"+year+" "+hour+":"+minutes+":"+seconds;
}
function getMonth(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getMonth() + 1;
}
function getYear(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getFullYear();
}
function getDay(timestamp) {
    var date = new Date(timestamp*1000);
    return date.getDate();
}
function daysInMonth (month, year) {
    return new Date(year, month, 0).getDate();
}

function fromDatetoDate(month, year){
    var result = [];
    result.push("01"+"/"+ (month.length>1?month:"0"+month)+"/"+year);
    result.push(daysInMonth(month, year)+"/"+ (month.length>1?month:"0"+month)+"/"+year);
    return result;
}

function changeDateFormat(formatstring, value){
    if(!value) return "";
    var finddate = value.split(/[ ]+|T/);
    var time = finddate[0].indexOf(":") == -1 ? finddate[1] : finddate[0];

    formatstring = formatstring.toLowerCase();
    var year_start = formatstring.indexOf("y");
    var year_length = (formatstring.match(/y/g)).length;

    var month_start = formatstring.indexOf("m");
    var month_length = (formatstring.match(/m/g)).length;

    var day_start = formatstring.indexOf("d");
    var day_length = (formatstring.match(/d/g)).length;

    var y = value.substring(year_start, year_start + year_length);
    var m = value.substring(month_start, month_start + month_length);
    var d = value.substring(day_start, day_start + day_length);

    return (y.length == 2 ? ("20"+y) : y) + "-" + (m.length == 1 ? "0"+m : m) + "-" + (d.length == 1 ? "0"+d : d) + " " + time;
}

function adjustheader(headtbl, bodytbl, hasrow){
    window.setTimeout(function () {
        var addw = (window.navigator.userAgent.indexOf('Firefox') > -1 ? 0 : 1);
        $(headtbl).css('width',  (parseFloat(window.getComputedStyle(bodytbl).width) + addw) + "px");
        if(hasrow){
            var _thbody = $(bodytbl).find('thead tr th');
            $.each($(headtbl).find('thead tr th'), function (k, v) {
                $(v).css('width', parseFloat(getComputedStyle(_thbody[$(v).index()]).width)+'px');
            });
        }
        var element = document.getElementsByClassName("dataTables_scrollBody")[0];
        if(element.scrollHeight - element.scrollTop !== element.clientHeight){
            $('.dataTables_scrollHeadInner').css("width", element.scrollWidth +'px');
        }
    }, 2);
}

function setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toUTCString());
}

function setCookietoEndofDay(c_name, value) {
    var now = new Date();
    var expire = new Date();
    expire.setFullYear(now.getFullYear());
    expire.setMonth(now.getMonth());
    expire.setDate(now.getDate()+1);
    expire.setHours(0);
    expire.setMinutes(0);
    expire.setSeconds(0);

    document.cookie = c_name + "=" + escape(value) + ((expire == null) ? "" : ";expires=" + expire.toUTCString());
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        var c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            var c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function deleteCookie(c_name){
    document.cookie = c_name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


function setDateRange(issueDateFrom, issueDateTo, dateFormat) {
    if (!dateFormat || typeof dateFormat === undefined) {
        dateFormat = 'dd/mm/yy';
    }

    let fromOpt = {
        controlType: 'select',
        oneLine: true,
        dateFormat: dateFormat,
        onClose: function (dateText, inst) {
            if (issueDateTo.val() != '') {
                var testStartDate = issueDateFrom.datepicker('getDate');
                var testEndDate = issueDateTo.datepicker('getDate');
                if (testStartDate > testEndDate)
                    issueDateTo.datepicker('setDate', testStartDate);
            } else {
                issueDateTo.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            issueDateTo.datepicker('option', 'minDate', issueDateFrom.datepicker('getDate'));
        }
    };

    let toOpt = {
        controlType: 'select',
        oneLine: true,
        dateFormat: dateFormat,
        onClose: function (dateText, inst) {
            if (issueDateFrom.val() != '') {
                var testStartDate = issueDateFrom.datepicker('getDate');
                var testEndDate = issueDateTo.datepicker('getDate');
                if (testStartDate > testEndDate)
                    issueDateFrom.datepicker('setDate', testEndDate);
            } else {
                issueDateFrom.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            issueDateFrom.datepicker('option', 'maxDate', issueDateTo.datepicker('getDate'));
        }
    };

    issueDateFrom.datepicker(fromOpt);
    issueDateTo.datepicker(toOpt);
}

function setDateTimeRange(issueDateFrom, issueDateTo, dateFormat, timeFormat) {
    if (!dateFormat || typeof dateFormat === undefined) {
        dateFormat = 'dd/mm/yy';
    }
    if (!timeFormat || typeof timeFormat === undefined) {
        timeFormat = 'HH:mm';
    }

    let fromOpt = {
        controlType: 'select',
        oneLine: true,
        dateFormat: dateFormat,
        timeFormat: timeFormat,
        timeInput: true,
        onClose: function (dateText, inst) {
            if (issueDateTo.val() != '') {
                var testStartDate = issueDateFrom.datetimepicker('getDate');
                var testEndDate = issueDateTo.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    issueDateTo.datetimepicker('setDate', testStartDate);
            } else {
                issueDateTo.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            issueDateTo.datetimepicker('option', 'minDate', issueDateFrom.datetimepicker('getDate'));
        }
    };

    let toOpt = {
        controlType: 'select',
        oneLine: true,
        dateFormat: dateFormat,
        timeFormat: timeFormat,
        timeInput: true,
        onClose: function (dateText, inst) {
            if (issueDateFrom.val() != '') {
                var testStartDate = issueDateFrom.datetimepicker('getDate');
                var testEndDate = issueDateTo.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    issueDateFrom.datetimepicker('setDate', testEndDate);
            } else {
                issueDateFrom.val(dateText);
            }
        },
        onSelect: function (selectedDateTime) {
            issueDateFrom.datetimepicker('option', 'maxDate', issueDateTo.datetimepicker('getDate'));
        }
    };

    issueDateFrom.datetimepicker(fromOpt);
    issueDateTo.datetimepicker(toOpt);
}

(function($) {
    var origAppend = $.fn.prepend;
    $.fn.prepend = function () {
        return origAppend.apply(this, arguments).trigger("prepend");
    };
})(jQuery);

(function($) {
    var origAppend = $.fn.toggleClass;
    $.fn.toggleClass = function () {
        return origAppend.apply(this, arguments).trigger("toggleClass");
    };

    $.fn.button = function (action) {
        var appendElem = $(this).attr('data-loading-text');
        var id = $(this).attr('id');

        switch(action){
            case "loading":
                $(this).prop('disabled', true);
                var content = $(this).html();
                _arrContentBtnLoading[id] = content;
                $(this).html('').append(appendElem);
                break;
            case "reset":
                $(this).prop('disabled', false);
                $(this).html('').append(_arrContentBtnLoading[id]);
                delete _arrContentBtnLoading[id];
                break;
        }
        return $(this);
    };
})(jQuery);

//expand or collapse div contain filter control
$(function() {
    $('.collapsible-box i.la').on('click', function () {
        $(this).parent().find('.ibox-body').toggle(700);
        if($(this).hasClass('la-angle-double-down')){
            $(this).removeClass('la-angle-double-down')
                .addClass('la-angle-double-up');
        }else{
            $(this).removeClass('la-angle-double-up')
                .addClass('la-angle-double-down');
        }

    });
    $('table.dataTable tr').on('click', function () {
        $('.m-row-selected').removeClass('m-row-selected');
        $(this).addClass('m-row-selected');
    });
});
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

$.fn.extend({
    has_required: function () {
        var checkError = [];
        var datas = $(this);

        if($(this).parent().is('td') || $(this).is('select')){
            $(this).parent().removeClass('error');
        }else{
            $(this).removeClass('error');
        }
        $.each(datas, function(key, data) {
            if($(data).is('input') || $(data).is('select') || $(data).is('textarea')){
                if(!data.value || data.value == '0') {
                    if($(data).parent().is('td') || $(data).is('select')){
                        $(data).parent().addClass('error');
                    }else{
                        $(data).addClass('error');
                    }
                    checkError.push('error');
                }
            }

            if( $(data).is("td") ){
                if(!$(data).text()) {
                    $(data).addClass('error');
                    checkError.push('error');
                }
            }
        });
        
        return checkError.length > 0;
    },
    clear_error: function () {
        $(this).removeClass('error');
    },
    check_cont_iso: function () {
        var con = $(this).val();
        if (!con || con == "" || con.length != 11) { return false; }
        con = con.toUpperCase();
        var re = /^[A-Z]{4}\d{7}/;
        if (re.test(con)) {
            var sum = 0;
            for (i = 0; i < 10; i++) {
                var n = con.substr(i, 1);
                if (i < 4) {
                    n = "0123456789A?BCDEFGHIJK?LMNOPQRSTU?VWXYZ".indexOf(con.substr(i, 1));
                }
                n *= Math.pow(2, i);
                sum += n;
            }
            if (con.substr(0, 4) == "HLCU") {
                sum -= 2;
            }
            sum %= 11;
            sum %= 10;
            return sum == con.substr(10);
        } else {
            return false;
        }
    },
    autocompleteText: function (arr, callback_success, callback_error) {
        $(this).autocomplete({
            source: arr,
            minLength: 1,
            create: function( event, ui ) {
                $(document).find('.ui-helper-hidden-accessible').remove();
            }
        });
        if($(this).parent().is('td')){
            $(this).on('change', function () {
                if(arr.indexOf($(this).val()) == "-1" && arr.indexOf($(this).val().toUpperCase()) == "-1"){
                    $(this).val('');
                    $(this).parent().addClass('error');
                    $('.toast').remove();
                    var idx = $(this).parent().closest('tr').children().index($(this).parent());
                    var colheadertext = $(this).parent().closest('table').find('thead tr td:eq('+ idx +')').first().text();
                    toastr['error'](colheadertext + ' không phù hợp!');
                    if(callback_error){
                        callback_error($(this));
                    }
                }else{
                    if(callback_success){
                        callback_success($(this));
                    }
                    $(this).parent().removeClass('error');
                }
            });
        }
    }
});

function GET_ALL_DATA_INPUT(objectX, strAttr = 'id'){
	var inputData = {};
	// if (attrValue == "") {
	// 	$(objectX).find('input, select, textarea').each(function(){
	// 		inputData[$(this).attr(strAttr)] = $(this).val();
	// 	});
	// }
	// else {
	// 	$(objectX).find('input[' + attrValue + '], select[' + attrValue + '], textarea[' + attrValue + ']').each(function(){
	// 		inputData[$(this).attr(strAttr)] = $(this).val();
	// 	});
	// }
	$(objectX).find('input, select, textarea').each(function(){
		if (typeof ($(this).attr(strAttr)) != "undefined")
			inputData[$(this).attr(strAttr)] = $(this).val();
		// if ($(this).attr('type') == 'checkbox') {
		// 	if ($(this).context.checked) {
		// 		inputData[$(this).attr(strAttr)] = '1';
		// 	}
		// 	else {
		// 		inputData[$(this).attr(strAttr)] = '0';
		// 	}
		// }
		// else {
		// 	if (typeof ($(this).attr(strAttr)) != "undefined")
		// 		inputData[$(this).attr(strAttr)] = $(this).val();
		// }
	});
	
	return inputData;
}