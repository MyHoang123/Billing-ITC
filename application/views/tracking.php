<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .scanfcode_googel_cnt {
        width: 100%;
        padding: 0;
        background-color: #fff;
        box-shadow: 0 1px 2px 1px #ccc;
        height: 45px;
    }

    .scanfcode_googel_cnt:hover,
    input.google_in:focus {
        box-shadow: 0 2px 6px 2px #ccc;
    }

    .scanfcode_googel_cnt input {
        border: solid 0 lightgray;
        width: 100%;
        height: 45px;
        padding: 0 20px;
        font-size: 25px;
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }

    .btn {
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .btn-default {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(243, 243, 243)), color-stop(1, rgb(225, 225, 225))) !important;
        background: -moz-linear-gradient(center top, rgb(243, 243, 243) 0%, rgb(225, 225, 225) 100%) !important;
    }

    .tabs-line.tabs-line-5x .nav-link {
        border-bottom-width: 5px !important;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent !important;
    }

    .submit_3 {
        cursor: pointer;
    }

    label.font-bold {
        border-bottom: dashed 1px #e0d39b;
        font-size: 13px;
        overflow: hidden;
        white-space: nowrap;
        color: navy;
    }

    .shadow-box {
        -webkit-box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
        -moz-box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
        box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
    }

    #cont-details {
        -webkit-box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
        -moz-box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
        box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.15) !important;
    }

    #cont-details .row.form-group {
        margin-bottom: 0.3rem !important;
    }

    .flex-height {
        height: 82vh !important;
    }

    .flex-pdtop {
        padding-top: 10% !important;
    }

    .google_in::-moz-placeholder {
        font-size: 15px;
        font-style: italic;
    }

    .google_in::-webkit-input-placeholder {
        font-size: 15px;
        font-style: italic;
    }

    .google_in:-ms-input-placeholder {
        font-size: 15px;
        font-style: italic;
    }

    .search-box h2 {
        font-size: 30px;
        letter-spacing: -1px;
        color: #DFBF84;
        text-transform: uppercase;
        text-shadow: 1px 1px 0 #000;
        margin: 10px 0 24px;
        text-align: center;
        line-height: 50px;
    }

    /*.s-bg{*/

    /*background: rgba(212,228,239,1);*/
    /*background: -moz-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,0.88) 100%);*/
    /*background: -webkit-gradient(left top, right top, color-stop(0%, rgba(212,228,239,1)), color-stop(100%, rgba(134,174,204,0.88)));*/
    /*background: -webkit-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,0.88) 100%);*/
    /*background: -o-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,0.88) 100%);*/
    /*background: -ms-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,0.88) 100%);*/
    /*background: linear-gradient(to right, rgba(212,228,239,1) 0%, rgba(134,174,204,0.88) 100%);*/
    /*filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e4ef', endColorstr='#86aecc', GradientType=1 );*/

    /*}*/
</style>

<div class="row">
    <div class="col-xl-12">
        <div class="ibox mb-2 pb-2 header-box shadow-box flex-height">
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-centered">
                <div class="ibox-body p-3 flex-pdtop search-box">
                    <h2 class="text-center font-bold pb-4" style="color: navy">TRA CỨU THÔNG TIN</h2>
                    <ul class="nav nav-tabs tabs-line tabs-line-5x tabs-line-danger" style="font-size: 14px">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-12-1" data-value="cont" data-toggle="tab"><i class="mr-2"></i>Số Container</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-12-2" data-value="bill" data-toggle="tab"><i class="mr-2"></i>Số Vận Đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-12-3" data-value="booking" data-toggle="tab"><i class="mr-2"></i>Số Booking</a>
                        </li>
                    </ul>
                    <div class="input-group-icon input-group-icon-right form-control-rounded">
                        <span class="input-icon input-icon-right text-primary submit_3" id="search"><i class="ti-search font-bold" style="font-size: 15px"></i></span>
                        <div class="scanfcode_googel_cnt">
                            <input class="google_in search_3" placeholder="Nhập thông tin tìm kiếm ..." />
                        </div>
                    </div>

                    <h4 class="hiden-input booking-error col-form-label text-center pb-4 mt-5"><span style="color: red;">Số booking không tồn tại! Vui lòng thử lại</span></h4>
                    <h4 class="hiden-input cont-error col-form-label text-center pb-4 mt-5"><span style="color: red;">Số container không tồn tại ! Vui lòng thử lại</span></h4>
                    <h4 class="hiden-input bill-error col-form-label text-center pb-4 mt-5"><span style="color: red;">Số vận đơn không tồn tại! Vui lòng thử lại</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 hiden-input content">
        <div class="ibox shadow-box">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col-centered">
                <div class="ibox-body p-0 mt-2">
                    <div class="text-center">
                        <nav aria-label="Page navigation example" style="display: inline-block; margin: 0 auto">
                            <ul class="pagination hiden-input">
                            </ul>
                        </nav>
                    </div>
                    <div class="row border-e p-2 hiden-input pb-2 mb-2" id="cont-details">
                        <div style="width: 100%; font-size: 25px;">
                            <p class="text-center" id="cTLHQ" style="color: #301b9e; font-weight: bold;">Chưa thanh lý Hải Quan</p>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 col-centered">
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label">Hãng khai thác</label>
                                <label id="OprID" class="col-sm-7 col-form-label font-bold">OprID</label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-5 col-form-label">Kích cỡ ISO</label>
                                <label id="ISO_SZTP" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Hàng/rỗng</label>
                                <label id="Status" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Hướng</label>
                                <label id="CntrClass" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Trạng thái</label>
                                <label id="CMStatus" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Vị trí bãi</label>
                                <label id="cLocation" class="col-sm-7 col-form-label font-bold text-danger">22GP</label>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Loại hàng</label>
                                <label id="CARGO_TYPE" class="col-sm-7 col-form-label font-bold">CARGO_TYPE</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Trọng lượng</label>
                                <label id="CMDWeight" class="col-sm-7 col-form-label font-bold">CMDWeight</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Nhiệt độ</label>
                                <label id="Temperature" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Số niêm chì</label>
                                <label id="SealNo" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Nội/ngoại</label>
                                <label id="IsLocal" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 col-centered">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Tàu chuyến</label>
                                <label id="ShipInfo" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">ETB / ETD</label>
                                <label id="ETB_ETD" class="col-sm-7 col-form-label font-bold">ETB_ETD</label>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">BL No</label>
                                <label id="BLNo" class="col-sm-7 col-form-label font-bold">BLNo</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Booking No</label>
                                <label id="BookingNo" class="col-sm-7 col-form-label font-bold">BookingNo</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Ngày vào bãi</label>
                                <label id="DateIn" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Ngày ra bãi</label>
                                <label id="DateOut" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Phương án vào</label>
                                <label id="CJModeName" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Phương án ra</label>
                                <label id="CJModeNameOut" class="col-sm-7 col-form-label font-bold">CJModeNameOut</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">POD / FPOD</label>
                                <label id="POD_FPOD" class="col-sm-7 col-form-label font-bold">POD_FPOD</label>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">CLASS / UNNO</label>
                                <label id="ClassUno" class="col-sm-7 col-form-label font-bold ">22GP</label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Quá khổ</label>
                                <label id="OOG" class="col-sm-7 col-form-label font-bold">22GP</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-sm-12 col-xs-12 table-responsive col-centered hiden-input" id="bb-details">
                <table id="bill-book-details" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
                    <thead>
                        <tr>
                            <th>.No</th>
                            <th>Cont.No</th>
                            <th>Hãng tàu</th>
                            <th>Kích cỡ</th>
                            <th>Vị trí bãi</th>
                            <th>Ngày vào bãi</th>
                            <th>Ngày ra bãi</th>
                            <th>Tình trạng Cntr</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function exec() {
        var form = document.getElementById("form");
        form.submit();
    }
    $(document).ready(function() {
        //        $("body").hasClass("drawer-sidebar") ? $("#sidebar").backdrop() : ($("body").toggleClass("sidebar-mini"), $("body").hasClass("sidebar-mini") || ($("#sidebar-collapse").hide(), setTimeout(function() {
        //            $("#sidebar-collapse").fadeIn(300)
        //        }, 200)));

        var _results = [];
        $('#bill-book-details').DataTable();

        //		$('.btn-option button').on('click', function () {
        //			if($(this).hasClass('btn-primary')) return;
        //
        //			$(this).parent().find('i').remove();
        //			$(this).parent().find('.btn-primary').removeClass('btn-primary').addClass('btn-default');
        //			$(this).removeClass('btn-default').addClass('btn-primary');
        //			$(this).prepend('<i class="fa fa-check"></i>');
        //		});

        $('input.search_3').on('keypress', function(e) {
            if (e.keyCode == 13) {
                $('#search').trigger('click');
            }
        });

        $('#search').on('click', function() {
            if (!$('.search_3').val()) return;
            $('.content, .cont-error, .bill-error, .booking-error, #bb-details, #cont-details, ul.pagination').addClass('hiden-input');
            $('.header-box').addClass('flex-height');
            $('.search-box').addClass('flex-pdtop');

            $('.ibox-body').removeClass('p-2');
            var formdata = {
                'opt': $('a.nav-link.active').attr('data-value'),
                'checkval': $('.search_3').val()
            };
            $.ajax({
                url: "<?= site_url(md5('home') . '/' . md5('index')); ?>",
                dataType: 'json',
                data: formdata,
                type: 'POST',
                success: function(data) {
                    _results = data.results;
                    $('.content').removeClass('hiden-input');

                    if (formdata.opt == "cont") {
                        $('ul.pagination').html('');
                        if (!_results || _results.length == 0) {
                            $('.cont-error').removeClass('hiden-input');
                        } else {
                            if (_results.length > 1) {
                                $('ul.pagination').removeClass('hiden-input');
                                var pagepre = '<li class="page-item"><a class="page-link pre" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                                var pagenext = '<li class="page-item"><a class="page-link next" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
                                //								$('ul.pagination').html('').append(pagepre);
                                for (var i = 1; i <= data.results.length; i++) {
                                    $('ul.pagination').append('<li class="page-item"><a class="page-link page-' + i + '" href="#">' + i + '</a></li>');
                                }
                                //								$('ul.pagination').append(pagenext);
                                $('ul.pagination li.page-item a.page-1').trigger('click');
                            } else {
                                loadContInfo(1);
                            }

                            $('.header-box').removeClass('flex-height');
                            $('.search-box').removeClass('flex-pdtop');
                            $('#cont-details').removeClass('hiden-input');
                            $('.ibox-body').addClass('p-2');
                        }
                    } else {
                        if (!data.results || data.results.length == 0) {
                            if (formdata.opt == "bill") {
                                $('.bill-error').removeClass('hiden-input');
                            } else {
                                $('.booking-error').removeClass('hiden-input');
                            }
                        } else {
                            var rows = [];
                            if (data.results.length > 0) {
                                $('.header-box').removeClass('flex-height');
                                $('.search-box').removeClass('flex-pdtop');
                                $('#bb-details').removeClass('hiden-input');
                                $('.ibox-body').addClass('p-2');
                                for (i = 0; i < data.results.length; i++) {
                                    rows.push([
                                        (i + 1), data.results[i].CntrNo, data.results[i].OprID, data.results[i].LocalSZPT, data.results[i].cLocation, getDateTime(data.results[i].DateIn), getDateTime(data.results[i].DateOut), data.results[i].CMStatus == 'B' ? 'Trên Tàu' : (data.results[i].CMStatus == 'I' ? 'Đang vào bãi' : ((data.results[i].CMStatus == 'S' ? 'Trên bãi' : 'Đã giao ra')))
                                    ]);
                                }
                                $('#bill-book-details').DataTable({
                                    data: rows,
                                    order: [
                                        [0, 'asc']
                                    ],
                                    columnDefs: [{
                                        className: "text-center",
                                        targets: [0, 2, 3, 4, 5, 6, 7]
                                    }],
                                    paging: false
                                });
                            }
                        }
                    }
                },
                error: function(err) {
                    $('input#search').css('pointer-events', '');
                    console.log(err);
                }
            });
        });

        $(document).on('click', 'ul.pagination li.page-item a', function() {
            var idx = $(this).html();
            if ($(this).hasClass('pre')) {
                idx = parseInt($(this).closest('ul').find('.bg-info').html()) - 1;
            }
            if ($(this).hasClass('next')) {
                idx = parseInt($(this).closest('ul').find('.bg-info').html()) + 1;
            }

            if ($(this).hasClass('bg-info')) return;
            $(this).closest('ul').find('.bg-info').removeClass('bg-info text-white');
            $(this).addClass('bg-info text-white');

            loadContInfo(idx);
        });

        function loadContInfo(idx) {
            if (idx < 0 || idx > _results.length) return;
            var critem = _results[idx - 1];
            if (critem) {
                $.each(critem, function(k, v) {
                    $('#cont-details').find('#' + k).html(v);
                });
                $('label#CntrClass').html((critem.CntrClass == '1') ? "Nhập" : ((critem.CntrClass == '2') ? 'Lưu rỗng' : ((critem.CntrClass == '3') ? 'Xuất' : '')));
                $('label#Status').html((critem.Status == 'F') ? "Hàng" : "Rỗng");
                $('label#IsLocal').html((critem.IsLocal == 'F') ? "Ngoại" : "Nội");
                $('label#OOG').html((parseFloat(critem.OOG_TOP) || " - ") + '/' + (parseFloat(critem.OOG_LEFT) || " - ") +
                    '/' + (parseFloat(critem.OOG_RIGHT) || " - ") + '/' + (parseFloat(critem.OOG_BACK) || " - ") +
                    '/' + (parseFloat(critem.OOG_FRONT) || " - "));
                $('label#CMStatus').html((critem.CMStatus == 'S') ? "Stacking" : ((critem.CMStatus == 'D') ? 'Delivery' : ((critem.CMStatus == 'O') ? 'Outgoing' : ((critem.CMStatus == 'I') ? 'Incoming' : ((critem.CMStatus == 'R') ? 'Reserved' : ((critem.CMStatus == 'B') ? 'Baplie Reserved' : 'Remashalling'))))));
                $('label#DateIn').html(getDateTime(critem.DateIn));
                $('label#DateOut').html(getDateTime(critem.DateOut));

                $('label#ETB_ETD').html((getDateTime(critem.ETB) || "-") + " / " + (getDateTime(critem.ETD) || "-"));
                $('label#POD_FPOD').html((critem.POD || "-") + " / " + (critem.FPOD || "-"));

            }
        }
    });
</script>