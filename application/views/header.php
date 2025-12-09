<?php
defined('BASEPATH') OR exit('');
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?=$title;?></title>
    <!--    favicon-->
    <link rel="icon" href="<?=base_url('assets/img/icons/favicon.ico');?>" type="image/ico">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url('assets/vendors/jquery-ui/jquery-ui.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/line-awesome/css/line-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/themify-icons/css/themify-icons.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />

    <!-- PLUGINS STYLES-->
    <link href="<?=base_url('assets/vendors/dataTables/datatables.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/dataTables/jquery.dataTables.min.css');?>" rel="stylesheet" />
    <!--    DATATABLES SCROLL-->
    <link href="<?=base_url('assets/vendors/dataTables/scroller.dataTables.min.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/toastr/toastr.min.css');?>" rel="stylesheet" type="text/css" />

    <!--    CUSTOMIZE FOR DATATABLES-->
    <link href="<?=base_url('assets/css/custom.datatables.css');?>" rel="stylesheet" />

    <!-- THEME STYLES-->
    <link href="<?=base_url('assets/css/main.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/css/ebilling.css');?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
	
	<!-- CORE PLUGINS-->
    <script src="<?=base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery2-1-4.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/metisMenu/dist/metisMenu.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>

    <script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
    
    <script src="<?=base_url('assets/js/contextmenu.js');?>"></script>

    <link href="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.css');?>" rel="stylesheet" />
    <script src="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.js');?>"></script>

    <!--    custom for eblling js-->
    <script src="<?=base_url('assets/js/ebilling.js');?>"></script>
    <script src="<?=base_url('assets/js/datatables.ext.js');?>"></script>
    
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?=base_url('assets/vendors/dataTables/datatables.min.js');?>"></script>

    <!--    TABLES SCROLL-->
    <script src="<?=base_url('assets/vendors/dataTables/dataTables.scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/key_table.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/mindmup-editabletable.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/numeric-input-example.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/autofill.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/select.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/buttons.min.js');?>"></script>

    <!-- Toastr js -->
    <script src="<?=base_url('assets/vendors/toastr/toastr.min.js');?>"></script>

    <!-- Loader -->
    <script src="<?=base_url('assets/vendors/loaders/blockui.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/loaders/progressbar.min.js');?>"></script>
    <script src="<?=base_url('assets/js/moment-timezone-with-data.min.js');?>"></script>

    <style>
        body {
            font-size: 0.9rem!important;
        }
        #user_fullname {
            display: inherit!important;
        }
        .app-title {
            font-family: LineAwesome, serif;
            /*0 5px 10px rgba(0,0,0,.35),*/
            /*0 10px 10px rgba(0,0,0,.3),*/
            background-color: transparent;
            color: #fc4920;
        }
        .brand-font {
            font-family: Helvetica Neue, Helvetica, Arial, serif;
            text-shadow: 0 1px 1px #bbb,
            0 2px 0 #999,
            0 3px 0 #888,
            0 4px 0 #777,
            0 5px 0 #666,
            0 6px 0 #555,
            0 7px 0 #444,
            0 8px 0 #333,
            0 9px 7px #302314;
            background-color: transparent;
        }
        .icon-bar-cl{
            background-color: #fc4920;
        }
        #alogout {
            padding-left: 10px;
        }
        #user-info:hover, #alogout:hover{
            color: #3300aa;
        }
        @media (max-width: 960px) {
            .app-title::after{
                content: 'TOS - BILLING';
                font-size: 4vw;
            }
            #right-out {
                font-size: 2vw;
            }
        }
        @media (max-width: 960px) and (orientation: landscape) {
            .app-title{
                padding-top: 1.05rem;
            }
            .app-title::after{
                content: 'TOS - BILLING';
                font-size: 3vw;
            }
            #right-out {
                font-size: 1.75vw;
            }
        }
        @media (min-width: 960px) and (max-width: 1280px) {
            .app-title::after{
                content: 'THANH TOÁN TRỰC TUYẾN';
                font-size: 2.1vw;
            }
            #right-out {
                font-size: 1.5vw;
            }
        }
        @media (min-width: 1366px) {
            .app-title{
                padding-top: 1rem;
            }
            .app-title::after{
                content: 'THANH TOÁN TRỰC TUYẾN';
            }
        }
        .content-wrapper{
            min-height: 100vh !important;
            background: url("<?=base_url('assets/img/register-bgr-3.jpg');?>");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a href="<?=site_url(md5('home'));?>">
                    <span class="brand brand-font">TOS - BiLLiNG</span>
                    <span class="brand-mini brand-font">TB</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler" href="javascript:;">
                            <span class="icon-bar icon-bar-cl"></span>
                            <span class="icon-bar icon-bar-cl"></span>
                            <span class="icon-bar icon-bar-cl"></span>
                        </a>
                    </li>
                    <li>
                        <div class="ibox-head">
                            <h3 class="font-weight-bold text-center pl-3 app-title"></h3>
                        </div>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul id="right-out" class="nav navbar-toolbar">
                    <li class="dropdown dropdown-user">
                        <a id="user-info" class="nav-link dropdown-toggle link" style="padding-right: 0; ">
                            Welcome,&ensp;<span id="user_fullname"><?=$this->session->userdata('UserName');?></span>
                            <span id="user_name" style="display: none;"><?=$this->session->userdata('UserID');?></span>
                        </a>
                    </li>
                    <li>
                        <a id="alogout" class="d-flex align-items-center" title="đăng xuất" href="<?=site_url(md5('user') . '/' . md5('logout'));?>"><i class="ti-shift-right"></i></a>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->

        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <ul class="side-menu metismenu">
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon ti-home"></i>
                            <span class="nav-label">Dashboards</span>
                        </a>
                    </li>
                    <?php foreach($menus as $menu) {
                        if(count($menu['submenu']) > 0) { ?>
                            <li class="">
                                <a href="javascript:;">
                                    <i class="sidebar-item-icon <?=$menu['MenuIcon'];?>"></i>
                                    <span class="nav-label"><?=$menu['MenuName'];?></span>
                                    <i class="fa fa-angle-right arrow"></i>
                                </a>
                                <ul class="nav-2-level collapse">
                                    <?php foreach($menu['submenu'] as $sub) { ?>
                                        <li>
                                            <a href="<?=site_url(md5($menu['MenuID']) . '/' . md5($sub['MenuID']));?>" title="<?=$sub['MenuName'];?>">
                                                <i class="sidebar-item-icon la la-<?=$sub['MenuIcon'];?>"></i>
                                                <?=$sub['MenuName'];?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                    <?php }} ?>
                </ul>
            </div>
        </nav>


        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content">