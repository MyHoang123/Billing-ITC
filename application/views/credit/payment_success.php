<?php
defined('BASEPATH') OR exit('');
?>
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
        margin: auto;
        height: 700px;
        vertical-align: middle;
        padding-top: 60px!important;
    }

    .success-head-icon {
        position: relative;
        height: 100px;
        width: 100px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        background-color: #fff;
        color: green;
        border-radius: 50%;
        transform: translateY(-25%);
        z-index: 2;
        border: solid 10px green;
    }

    .m-show-modal{
        position:fixed;top:0;left:0;width:100vw;height:100vh;display:none; z-index: 1002
    }
    .m-show-modal .m-modal-background{
        background-color:rgba(0,0,0,0.5);width:100%;height:100%;top:0;left:0;position:absolute;z-index:98
    }
    .m-show-modal .m-modal-content{
        position:absolute;top:0;left:0;width:100%;height:100%;z-index:99
    }
    .m-close-modal{
        position: fixed;
        z-index: 100;
        top: 8px;
        right: 12vw;
        color: #fff;
        cursor: pointer;
    }
    .m-close-modal i{
        padding: 5px;
        border-radius: 50%;
    }

    .m-close-modal i:hover{
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-item {
        padding: .95rem 3.5rem!important;
    }
    .btn.dropdown-arrow:after{
        left: .7rem!important;
    }

    .m-hidden{
        display: none;
    }
    #service-list table tbody tr td{
        text-align: center;
    }
</style>

<div class="cover"></div>
<div class="ibox ibox-fullheight">
    <div class="ibox-body notify-content">
        <h1 class="text-center font-bold mb-5">COMPLETE !</h1>
        <div class="text-center">
            <span class="success-head-icon"><i class="fa fa-check"></i></span>
        </div>
        <h5 class="text-center mb-4">Giao dịch đã được thực hiện thành công!</h5>
        <div class="form-group text-center">
            <img style="width: 120px; height: 120px; border: 0; background-color: transparent;" src="<?=$qr;?>"></img>
        </div>

        <?php if( isset( $invInfo ) ){ ?>
            <h5 class="text-center">Mã giao dịch: <span class="font-bold"><?=$invInfo["fkey"];?></span></h5>
            <h5 class="text-center mb-5">Số hóa đơn: <span class="font-bold"><?=$invInfo["serial"].substr("00000000".$invInfo['invno'], -8);?></span></h5>
        <?php } ?>
        
        <div class="ibox-footer row">
            <div class="col-sm-6">
                <a class="btn btn-dark btn-rounded btn-block text-white" onclick="goBack()">GIAO DỊCH MỚI</a>
            </div>
            <div class="col-sm-6">
                <?php if( isset( $invInfo ) ){ ?>
                    <button id="show-inv" class="btn btn-blue btn-rounded btn-block">IN HÓA ĐƠN</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="m-show-modal">
    <div class="m-modal-background">
        
    </div>
    <div class="m-modal-content">
        <iframe id="file-show-content" width="100%" height="100%" type="application/pdf" style="border:none"></iframe>
    </div>
    <div class="m-close-modal" style="display: none;">
        <i class="la la-close" style="font-size: 21px;" title="Đóng"></i>
    </div>
</div>
<script>
    function goBack() {
        window.location.replace(document.referrer);
    }

    $(document).ready(function(){

        $('#show-inv').on('click', function(){
            $('#file-show-content').attr('src'
                , '<?= isset($invInfo["fkey"]) ? site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=".$invInfo["fkey"]) : "";?>');

            $('.m-show-modal').show('fade', function(){
                window.setTimeout( function(){
                    $(".m-close-modal").show( "slide", {direction: "up" }, 300 );
                }, 3000 );
            });
        });

        $('.m-modal-background').click(function(){
            $('.m-show-modal').hide('fade');
        });

        $('.m-close-modal').click(function(){
            $(this).hide();
            $('.m-show-modal').hide('fade');
        });

        $(document).on("keydown", function(e){
            if( e.keyCode == 27 ){
                $('.m-close-modal').trigger("click");;
            }
        });
    });
</script>