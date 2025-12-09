<?php
defined('BASEPATH') OR exit('');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" href="<?=base_url('assets/img/icons/favicon.ico');?>" type="image/ico">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/line-awesome/css/line-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/themify-icons/css/themify-icons.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/animate.css/animate.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/toastr/toastr.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <!-- THEME STYLES-->
    <link href="<?=base_url('assets/css/main.min.css');?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <style>
        .blur {
            background: url('<?=base_url('assets/img/login-bgr-9.jpg');?>') no-repeat center center fixed;
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

/*        .blur {*/
/*            background: url('*/<?//=base_url('assets/img/login-bgr-9.jpg');?>/*') no-repeat center center fixed;*/
/*            background-size: cover;*/
/*            overflow: hidden;*/
/*            filter: blur(9px);*/
/*            position: absolute;*/
/*            height: 600px;*/
/*            top: -50px;*/
/*            left: -60px;*/
/*            right: -60px;*/
/*            bottom: -50px;*/
/*        }*/

        .widget {
            /*border-top: 2px solid rgba(255, 255, 255, .5);*/
            /*border-bottom: 2px solid rgba(255, 255, 255, .5);*/
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        a:hover{
            color: navy!important;
        }

        .center {
            position: absolute;
            margin: auto;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .text {
            top: 10%;
            right: 10%;
            left: 60% !important;
        }

        .text h1 {
            text-align: center;
            text-shadow: 1px 1px rgba(0, 0, 0, .1);
            color: #ffffff;
            margin-top: 57px;
            font-family: 'Lora', serif;
            font-weight: 700;
            font-size: 38px;
        }
        .text p {
            text-align: center;
            color: #ffffff;
            text-shadow: 1px 1px rgba(0, 0, 0, .1);
            margin-top: 0;
            font-family: 'Lato', serif;
            font-weight: 400;
            font-size: 22px;
        }

        label, span{
            background-color: transparent!important;
            /*color: #fff!important;*/
        }

        input {
            background-color: transparent!important;
            border-bottom-width: 2px!important;
        }
        /*resize in mobile*/
        @media (orientation: landscape) and ( max-width: 800px) {
            #img-app{
                max-width: 120px;
                /*max-height: 60px;*/
            }
            .text {
                top: 0;
                right: 10px;
                left: 60% !important;
            }
        }
        @media  (orientation: portrait) and ( max-width: 800px) {
            #img-app{
                max-width: 200px;
                /*max-height: 60px;*/
                display: block;
                margin-left: auto;
            }
            .text {
                top: 10%;
                right: 10px;
                left: 30% !important;
            }
            input{
                background-color: #204d74!important;
                border: none !important;
                color: #fff!important;
                /*border-radius: 20px!important;*/
            }
        }
        @media only screen and (max-width: 500px) {
            @-ms-viewport { width: 320px; }
            #img-app{
                max-width: 200px;
                /*max-height: 60px;*/
                display: block;
                margin-left: auto;
            }
            .text {
                top: 10%;
                right: 10px;
                left: 30% !important;
            }
            input{
                background-color: #204d74!important;
                border: none !important;
                color: #fff!important;
            }
        }

    </style>
</head>

<body>
<div class="widget center">
    <div class="blur"></div>
    <div class="text center">
        <?= form_open(md5('user') . '/' . md5('login')) ?>
        <img id="img-app" src="<?=base_url('assets/img/logos/login-logo-10.png');?>">
        <div class="form-group mb-4 <?=(!empty($error)?'has-error':'');?>">
            <span id="error-message" class="help-block"><?=(!empty($error)?$error:'');?></span>
        </div>
        <div class="form-group mb-4 ">
            <input class="form-control form-control-line" type="text" name="UserID" placeholder="Tên đăng nhập" value="<?= isset($_COOKIE['abc']) ? base64_decode($_COOKIE['abc']) : '';?>">
            <input name="check_duplicate" id="check_duplicate" style="display: none;">
            <?php echo form_error('UserID','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group mb-4 ">
            <input class="form-control form-control-line" type="password" name="password" placeholder="Mật khẩu" value="<?= isset($_COOKIE['xyz']) ? base64_decode($_COOKIE['xyz']) : '';?>">
            <?php echo form_error('password','<span class="help-block">','</span>'); ?>
        </div>
        <div class="flexbox mb-5">
                <span class="text-primary">
                    <label class="ui-switch switch-icon mr-2 mb-0">
                        <input type="checkbox" name="rememberme" <?= isset($_COOKIE['abc']) ? 'checked' : '';?>>
                        <span class="text-primary"></span>
                    </label>Ghi nhớ</span>
            <a href="<?=site_url(md5('user') . '/' . md5('changepass'));?>" class="text-primary">Quên mật khẩu?</a>
        </div>
        <div class="form-group mb-4 ">
            <div class="input-group">
                <button id="login" class="btn btn-primary btn-rounded btn-fix mr-2" type="submit">ĐĂNG NHẬP</button>
                <a id="register" class="btn btn-secondary btn-rounded btn-fix" href="<?=site_url(md5('user') . '/' . md5('register'));?>">ĐĂNG KÝ</a>
            </div>
        </div>
        </form>
    </div>
</div>
<footer class="page-footer" style="background-color: transparent!important;">
    <div class="font-13">2018 © <b>C.E.H</b> - Certified Ethical Hacker</div>
    <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
</footer>

<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<!-- CORE PLUGINS-->
<script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/metisMenu/dist/metisMenu.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-idletimer/dist/idle-timer.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/toastr/toastr.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!-- PAGE LEVEL PLUGINS-->
<!-- CORE SCRIPTS-->
<script src="<?=base_url('assets/js/app.min.js');?>"></script>
<script src="<?=base_url('assets/js/ebilling.js');?>"></script>
<!-- PAGE LEVEL SCRIPTS-->
<script>
    $(document).ready(function () {
        $('input[name="UserID"]').focus();
        $('input[name="UserID"]').select();
        if(isMobile.any()){
            $('input').addClass('form-control-sm');
            $('.btn').addClass('btn-sm');
            $('.form-group').removeClass('mb-4');
        }
    });
    $(function() {
        $('form').validate({
            errorClass: "help-block",
            rules: {
                UserID: {
                    required: true,
                    minlength: 1,
                    maxlength: 30
                },
                password: {
                    required: true
                }
            },
            highlight: function(e) {
                $(e).closest(".form-group").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group").removeClass("has-error")
            }
        });
    });
</script>
</body>
</html>