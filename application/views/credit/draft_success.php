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
        margin: auto;
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
        top: 7px;
        left: 360px;
        color: #fff;
        cursor: pointer;
    }
    .m-close-modal i{
        padding: 5px;
        border-radius: 4px;
    }

    .m-close-modal i:hover{
        background-color: #838482;
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

    td{
        padding: 5px 10px;
        text-align: left!important;
        vertical-align: top;
        font-size: 14px;
        color: navy;
    }
</style>

<div class="cover"></div>
<div class="ibox">
    <div class="ibox-body notify-content">
        <h1 class="text-center font-bold mb-5">COMPLETE !</h1>
        <div class="text-center">
            <span class="success-head-icon"><i class="fa fa-check"></i></span>
        </div>
        <h5 class="text-center mb-4">Giao dịch đã được thực hiện thành công!</h5>
        <div class="form-group text-center">
            <img style="width: 120px; height: 120px; border: 0; background-color: transparent;" src="<?=$qr;?>"></img>
        </div>
       
        <div class="form-group text-center">
            <table style="margin:auto">
                <tbody>
                    <tr>
                        <?php if( isset( $pinCode ) ){ ?>
                            <td>Mã giao dịch: </td> <td><span style="font-weight: bold;"><?=$pinCode;?></span></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <?php if( isset( $draftNos ) ){ ?>
                            <td>Phiếu tính cước: </td>
                            <td>
                                <?php foreach ($draftNos as $draftNo) { ?>
                                    <span style="font-weight: bold;"><?= $draftNo; ?></span><br/>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="ibox-footer row" style="padding-top: 25px">
        <div class="col-xl-6 col-lg-6 col-sm-12 mx-sm-auto">
            <div class="row">
                <div class="col-sm-6">
                    <a class="btn btn-dark btn-rounded btn-block text-white" onclick="goBack()">LÀM LỆNH MỚI</a>
                </div>
                <div class="col-sm-6">
                    <?php if( isset( $draftNos ) ){ ?>
                        <button id="show-dft" class="btn btn-blue btn-rounded btn-block">IN PHIẾU TÍNH CƯỚC</button>
                    <?php } ?>
                </div>
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
        <i class="la la-arrow-left" style="font-size: 25px;" title="Đóng"></i>
    </div>
</div>
<script>
    function goBack() {
        window.location.replace(document.referrer);
    }

    $(document).ready(function(){
        $('#show-dft').on('click', function(){
            var draftNo = '<?= implode(" ", $draftNos); ?>';

            $('#file-show-content').attr('src'
                    , draftNo ? ('<?= site_url(md5("ExportRPT") . '/' . md5("viewDraftPDF")) ;?>' + "?draftNo=" + draftNo) : '' );

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

    function PrintElem(elem)
    {
        var mywindow = window.open('', 'PRINT');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body style="margin:0">');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');

        // mywindow.document.close();
        // mywindow.focus();

        // mywindow.print();
        // // mywindow.close();
        // return true;
        
    }
</script>