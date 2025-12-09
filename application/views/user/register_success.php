<?php
defined('BASEPATH') OR exit('');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Đợi xác nhận</title>
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
        body {
            background-repeat: no-repeat;
            background-size: cover;
        }

        .cover {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(117, 54, 230, .1);
        }

        .notify-content {
            max-width: 800px;
            margin: 100px auto auto;
        }

        .success-head-icon {
            position: relative;
            height: 60px;
            width: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            background-color: #fff;
            color: green;
            box-shadow: 0 5px 20px #d6dee4;
            border-radius: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
    </style>
</head>

<body>
<div class="cover"></div>
<div class="ibox ibox-fullheight notify-content">
    <div class="text-center">
        <span class="success-head-icon"><i class="la la-check"></i></span>
    </div>
    <div class="ibox-body">
        <h5 class="text-center">Hệ thống đã ghi nhận thông tin đăng ký!</h5>
        <h5 class="text-center mb-5">Quản trị viên sẽ xác nhận và thông tin đến địa chỉ mail </h5>
        <div class="ibox-footer row">
            <div class="col-sm-6">
                <a class="btn btn-success btn-rounded btn-block" type="reset" href="<?=site_url(md5('user') . '/' . md5('login'));?>">Đến trang đăng nhập</a>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary btn-rounded btn-block" type="reset" href="<?=site_url(md5('user') . '/' . md5('register'));?>">Tiếp tục đăng ký</a>
            </div>
        </div>
    </div>
</div>
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
<!-- PAGE LEVEL SCRIPTS-->

</body>
</html>