<?php
defined('BASEPATH') OR exit('');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.ico');?>">

    <!-- App title -->
    <title>Thay đổi mật khẩu</title>

    <!-- App CSS -->
    <link href="<?=base_url('assets/css/style.css');?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="<?=base_url('assets/js/modernizr.min.js');?>"></script>

</head>


<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">

    <div class="account-bg">
        <div class="card-box m-b-0">
            <div class="text-xs-center m-t-20">
                <a href="#" class="logo">
                    <img width="300px" src="<?=base_url('assets/images/logo.png');?>">
                </a>
            </div>
            <div class="m-t-30 m-b-20">
                <div class="col-xs-12 text-xs-center">
                    <h6 class="text-muted text-uppercase m-b-0 m-t-0">Thay đổi mật khẩu</h6>
                </div>
                <div class="col-xs-12 text-xs-center">
                    <h6 class="text-muted text-uppercase m-b-0 m-t-0"><?php echo (!empty($error)) ? '<span style="color: red;">'.$error.'</span>' : ''; ?></h6>
                </div>
                <?=form_open(md5('user') . '/' . md5('changepass')) ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="username" name="username" class="form-control" type="text" required="true" placeholder="Tên người dùng">
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input id="oldpassword" name="oldpassword" class="form-control" type="Password" required="true" placeholder="Mật khẩu cũ">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="newpassword" name="newpassword" class="form-control" type="password" required="true" placeholder="Mật khẩu mới">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input id="cpassword" name="cpassword" class="form-control" type="password" required="true" placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <div class="form-group text-center m-t-30">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Chấp nhận</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            <a href="<?=site_url(md5('user') . '/' . md5('login'));?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Trở về đăng nhập ?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end card-box-->



</div>
<!-- end wrapper page -->


<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<!-- jQuery  -->
<script src="<?=base_url('assets/js/jquery.min.js');?>"></script>
<script src="<?=base_url('assets/js/tether.min.js');?>"></script><!-- Tether for Bootstrap -->
<script src="<?=base_url('assets/js/bootstrap.min.js');?>"></script>
<script src="<?=base_url('assets/js/waves.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.nicescroll.js');?>"></script>
<script src="<?=base_url('assets/plugins/switchery/switchery.min.js');?>"></script>

<!-- App js -->
<script src="<?=base_url('assets/js/jquery.core.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.app.js');?>"></script>

</body>
</html>
