<?php
defined('BASEPATH') OR exit('');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/line-awesome/css/line-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/themify-icons/css/themify-icons.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/animate.css/animate.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/toastr/toastr.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');?>" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <!-- THEME STYLES-->
    <link href="<?=base_url('assets/css/main.min.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/css/ebilling.css');?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>

        .blur {
            background: background: url("<?=base_url('assets/img/register-bgr-4.jpg');?>") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
        }

        label.has-error{
            color: #f75a5f;
        }
        label{
            color: navy;
        }

        .cover {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(117, 54, 230, .1);
        }

        .register-content {
            margin: 25px auto 50px;
            background: url("<?=base_url('assets/img/products/bg-notebook-2.png');?>");
            background-repeat: no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
        }

        .auth-head-icon {
            position: relative;
            height: 60px;
            width: 60px;
            margin-bottom: -15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            background-color: #fff;
            color: #5c6bc0;
            box-shadow: 0 5px 20px #d6dee4;
            border-radius: 50%;
            transform: translateY(-25%);
            z-index: 2;
        }
        input:not(.captcha) {
            border-left: none!important;
            border-top: none!important;
            border-right: none!important;
            background-color: transparent!important;
        }
        a#to-login:hover, button[type=reset]:hover{
            color: #000088;
        }
        .bootstrap-tagsinput{
            border: none!important;
            background-color: transparent!important;
            cursor: default!important;
        }
        .bootstrap-tagsinput input{
            cursor: default!important;
        }

        .ibox-body{
            margin-left: 80px!important;
        }
    </style>
</head>
<body>
    <div class="ibox ibox-fullheight register-content" style="box-shadow: none!important;">
        <div class="blur"></div>
        <div class="text-center">
            <span class="auth-head-icon"><i class="la la-key"></i></span>
        </div>
        <div class="ibox-head">
            <h4 class="text-danger font-bold" style="margin: auto" >ĐĂNG KÝ THÔNG TIN TÀI KHOẢN</h4>
        </div>
        <form class="form-horizontal" method="post" action="" autocomplete="off">
            <div class="ibox-body px-5" >
                <?php if(!empty($error)){ ?>
                    <div class="form-group row">
                        <div class="col-sm-9 ml-sm-auto  <?=(!empty($error)?'has-error':'');?>">
                            <span id="error-message" class="help-block"><?=(!empty($error)?$error:'');?></span>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tên đăng nhập</label>
                    <div class="col-sm-9">
                        <input name="username" class="form-control" placeholder="Tên đăng nhập" type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-sm-3 col-form-label">Mật khẩu</label>
                    <div class="col-sm-4">
                        <input id="password" name="password" class="form-control" placeholder="Mật khẩu" type="password" readonly onfocus="this.removeAttribute('readonly');">
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-sm-3 col-form-label">Nhập lại mật khẩu</label>
                    <div class="col-sm-4">
                        <input name="confirmpassword" class="form-control" placeholder="Xác nhận mật khẩu" type="password">
                    </div>
                </div>
                <div class="form-group  row">
                    <label class="col-sm-3 col-form-label">Tên khách hàng</label>
                    <div class="col-sm-4">
                        <input name="fullname" class="form-control" placeholder="Tên khách hàng" type="text">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Số ĐT</label>
                    <div class="col-sm-3">
                        <input name="phone" class="form-control" placeholder="Số điện thoại" type="tel">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-4" >
                        <input name="email" class="form-control" placeholder="Địa chỉ Email" type="email">
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Số CMND</label>
                    <div class="col-sm-3">
                        <input name="cmnd" class="form-control" placeholder="Số CMND" type="text">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Mã số thuế</label>
                    <div class="col-sm-3">
                        <input id="taxcode" name="taxcode" class="form-control" placeholder="Mã số thuế DN" type="text">
                    </div>
                    <div class="col-sm-6">
                        <input name="taxcode-list" class="form-control border-0" data-role="tagsinput" style="background-color: transparent!important; cursor: default">
                    </div>
                </div>
                <div class="form-group row">
                    <span class="col-sm-9 text-muted ml-sm-auto" style="font-style: italic; font-size: 12px">(*) Thêm nhiều doanh nghiệp: nhập MST và nhấn enter/tab, sau đó nhập tiếp MST khác</span>
                    <span class="col-sm-9 text-muted ml-sm-auto" style="font-style: italic; font-size: 12px">(**) Xóa MST đã thêm: di chuyển chuột vào MST đã được thêm vào, sau đó nhấn vào dấu chéo (x)</span>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tên doanh nghiệp</label>
                    <div class="col-sm-9">
                        <input name="enterprisename" class="form-control" placeholder="Tên doanh nghiệp" type="text" readonly style="background-color: transparent!important;">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Địa chỉ</label>
                    <div class="col-sm-9">
                        <input name="address" class="form-control" placeholder="Địa chỉ" type="text" readonly style="background-color: transparent!important;">
                    </div>
                </div>
            </div>
            <div class="ibox-footer pt-4">
                <div class="form-group row pb-3">
                    <div class="col-sm-8 ml-sm-auto">
                        <div class="row">
                            <div class="col-sm-4">
                                <input name="captcha" class="form-control" type="text" >
                            </div>
                            <div id="imgcaptcha">
                                <?=$captcha;?>
                            </div>
                            <div>
                                <i id="captcha-refresh" class="btn la la-refresh"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 ml-sm-auto">
                    <div class="btn-group mr-4">
                        <span class="btn-label-out btn-label-out-left btn-label-out-primary pointing"><i class="fa fa-user-plus" style="font-size: large"></i></span>
                        <button class="btn btn-outline-primary mr-2 btn-fix mr-2" name="submit" id="submit">
                            <span class="btn-icon">ĐĂNG KÝ</span>
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary btn-fix btn-rounded" type="reset" id="reset">
                        <span class="btn-icon"><i class="fa fa-rotate-left"></i>Tạo lại</span>
                    </button>
                    <a id="to-login" style="float: right; margin-top: 10px" href="<?=site_url(md5('user') . '/' . md5('login'));?>">
                        <span class="btn-label"><i class="la la-forward"></i></span>Trang đăng nhập</a>
                </div>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>

    <!-- CORE PLUGINS-->
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/metisMenu/dist/metisMenu.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-idletimer/dist/idle-timer.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/toastr/toastr.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js');?>"></script>

    <!-- PAGE LEVEL PLUGINS-->
    <!-- CORE SCRIPTS-->
    <script src="<?=base_url('assets/js/app.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.min.js');?>"></script>

    <script src="<?=base_url('assets/js/ebilling.js');?>"></script>

    <script>
        $(document).ready(function () {
            $('#reset').trigger('click');
            $('input[name="taxcode-list"]').tagsinput({
                freeInput: false
            });
            $('.bootstrap-tagsinput input').on('focusin', function () {
               $(this).blur();
            });

            var customers = <?= $customers;?>;
            var cc = '<?= $captcha;?>';
//            $('input[name="taxcode"]').autocompleteText(customers.map(p=> p.CusID));
            $('input[name="taxcode"]').on('change keypress', function (e) {
                if(e.which == 13 || e.type == "change") {
                    if($.inArray($(this).val(), customers.map(p=> p.CusID)) == "-1"){
                        $('.toast').remove();
                        toastr['error']('Thông tin MST ['+ $(this).val() +'] không tồn tại trong hệ thống!\nVui lòng kiểm tra lại hoặc liên hệ với quản trị viên!');
                        $(this).val('');
                        return;
                    }

                    var inputtax = $(this);
                    var cus = customers.filter(p=> p.CusID == $(inputtax).val());

                    $('input[name="enterprisename"]').val(!cus[0] ? "" : cus[0].CusName);
                    $('input[name="address"]').val(!cus[0] ? "" : cus[0].Address);
                    if(cus[0]){
                        $('input[name="taxcode-list"]').tagsinput('add', $(inputtax).val());
                    }
                }
            });

            $('input[name="enterprisename"]').autocompleteText(customers.filter(x=> x.CusName).map(p=> p.CusName));
            $('input[name="enterprisename"]').on('change', function () {
                var inputname = $(this);
                var cus = customers.filter(p=> p.CusName == $(inputname).val());
                $('input[name="taxcode"]').val(!cus[0] ? "" : cus[0].CusID);
                $('input[name="address"]').val(!cus[0] ? "" : cus[0].Address);
            });

            $('#reset').on('click', function () {
                $('input[name="taxcode-list"]').tagsinput('removeAll');
            });

            $('form').on('keypress', function (e) {
                if(e.keyCode == 13){
                    e.preventDefault();
                    return false;
                }
            });

            $(document).on('click', '.bootstrap-tagsinput .tag.label', function () {
                var cus = customers.filter(p=> p.CusID == $(this).text());
                $('input[name="enterprisename"]').val(!cus[0] ? "" : cus[0].CusName);
                $('input[name="address"]').val(!cus[0] ? "" : cus[0].Address);
            });

            $('#captcha-refresh').on('click', function () {
                var formdata = {
                    'recaptcha': 1
                };
                $.ajax({
                    url: "<?=site_url(md5('user') . '/' . md5('register'));?>",
                    dataType: 'json',
                    data: formdata,
                    type: 'POST',
                    success: function (data) {
                        $('#imgcaptcha').html(data.captcha);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            $('#submit').on('click', function () {
                $('form').validate({
                    errorClass: "help-block",
                    rules: {
                        username: {
                            required: true,
                            minlength: 3,
                            maxlength: 30
                        },
                        password: {
                            required: true
                        },
                        confirmpassword: {
                            equalTo: "#password"
                        },
                        fullname: {
                            required: true
                        },
                        email: {
                            required: true
                        },
                        phone: {
                            required: true
                        },
                        cmnd: {
                            required: true
                        },
                        "taxcode-list": {
                            required: true
                        },
                        enterprisename: {
                            required: true
                        },
                        captcha:{
                            required: true
                        }
                    },
                    highlight: function(e) {
                        $(e).parent().addClass("has-error");
                        $(e).parent().prev("label").addClass("has-error");
                    },
                    unhighlight: function(e) {
                        $(e).parent().removeClass("has-error");
                        $(e).parent().prev("label").removeClass("has-error");
                    }
                });
                var formdata = {};
                $.each( $('form').serializeArray(), function (idx, item) {
                    formdata[item.name] = item.value;
                });
                $.ajax({
                    url: "<?=site_url(md5('user') . '/' . md5('register'));?>",
                    dataType: 'json',
                    data: formdata,
                    type: 'POST',
                    success: function (data) {

                    }
                });
            });
        });
    </script>
</body>
</html>
