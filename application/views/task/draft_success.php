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
                        <?php if( isset( $draftNos ) && count( $draftNos ) > 0 ){ ?>
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
                <div class="col-sm-4 mx-sm-auto">
                    <a class="btn btn-dark btn-rounded btn-block text-white" onclick="goBack()">LÀM LỆNH MỚI</a>
                </div>
                <div class="col-sm-4 mx-sm-auto">
                    <button id="print-order" class="btn btn-warning btn-rounded btn-block">IN LỆNH</button>
                </div>

            <?php if( isset( $draftNos ) && count( $draftNos ) > 0 ){ ?>
                <div class="col-sm-4">
                    <button id="show-dft" class="btn btn-blue btn-rounded btn-block">IN PHIẾU TÍNH CƯỚC</button>
                </div>
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
        <i class="la la-arrow-left" style="font-size: 25px;" title="Đóng"></i>
    </div>
</div>
<div id="Print-NH" class="m-hidden">
    
</div>
<div id="Print-DR" class="m-hidden">
    
</div>
<div id="Print-DV" class="m-hidden">
    
</div>
<script src="<?= base_url('assets/js/jsprint.js'); ?>"></script>
<script>
    function goBack() {
        window.location.replace(document.referrer);
    }
    var tempNH = `<div class="NH-content" style="height:578.268px; position: relative;margin-top: 53px; left: 120.945px; font-weight: bold; font-size: 1.1em; font-family: 'Arial', 'Sans-serif'; page-break-after: always">
        <span style="position: absolute;z-index: 1;top: 0; left: 0;" class="OrderNo"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 272px;" class="InvNo"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 575px;" class="ExpDate"></span>
        <span style="position: absolute;z-index: 1;top: 27px; left: 90px;" class="CJModeName"></span>
        <span style="position: absolute;z-index: 1;top: 30px; left: 472px;">Hạn điện:</span>
        <span style="position: absolute;z-index: 1;top: 27px; left: 575px;" class="ExpPluginDate"></span>
        <span style="position: absolute;z-index: 1;top: 68px; left: 20px; font-size: 0.9em;" class="SHIPPER_NAME"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 45px;" class="BL_BKNo"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 495px;" class="BerthDate"></span>
        <span style="position: absolute;z-index: 1;top: 128px; left: 20px;">
            <span class="ShipName"></span>/<span class="ImVoy"></span>/<span class="ExVoy"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 128px; left: 538px;">
            <span class="POL"></span>/<span class="POD"></span>/<span class="FPOD"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 178px; left: 27px; font-size: 1.2em;" class="CntrNo"></span>
        <span style="position: absolute;z-index: 1;top: 178px; left: 215px; font-size: 0.9em; font-weight: normal">
            <span class="SealNo"></span> + <span class="SealNo1"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 178px; left: 435px;" class="OprID"></span>
        <span style="position: absolute;z-index: 1;top: 178px; left: 640px;" class="Status"></span>
        <span style="position: absolute;z-index: 1;top: 213px; left: 26px;" class="CMDWeight"></span>
        <span style="position: absolute;z-index: 1;top: 213px; left: 234px;" class="ISO_SZTP"></span>
        <span style="position: absolute;z-index: 1;top: 213px; left: 440px;" class="CARGO_TYPE_NAME"></span>
        <span style="position: absolute;z-index: 1;top: 250px; left: 45px;" class="Temperature"></span>
        <span style="position: absolute;z-index: 1;top: 250px; left: 250px;" class="Vent"></span>
        <span style="position: absolute;z-index: 1;top: 250px; left: 393px;" class="UNNO"></span>
        <span style="position: absolute;z-index: 1;top: 250px; left: 601px;" class="OOG"></span>
        <span style="position: absolute;z-index: 1;top: 321px; left: 0;" class="YardPos"></span>
        <span style="position: absolute;z-index: 1;top: 321px; left: 226px; max-width: 395px; word-wrap: break-word; font-weight: normal;" class="Note"></span>
        <span style="position: absolute;z-index: 1;top: 350px; left: 270px; max-width: 395px; word-wrap: break-word; font-weight: bold; font-size: 1.3em; border: 0px solid #212529" class="isTLHQ"></span>
        <img style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:425px;left:0" class="QR_IMAGE"></img>
		<span style="position: absolute;z-index: 1;top: 437px; left: 90px;font-weight: bold; font-size: 1.2em;" class="PinCode"></span>
        <span style="position: absolute;z-index: 1;top: 487px; left: 90px;" class="UserName"></span>
    </div>`;

    var tempDR = `<div class="DR-content" style="height:578.268px; position: relative;margin-top: 76px; left: 120.945px; font-weight: bold; font-size: 0.9em; font-family: 'Arial', 'Sans-serif'; page-break-after: always">
        <span style="position: absolute;z-index: 1;top: 0; left: 0; font-size: 1.1em;" class="OrderNo"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 272px; font-size: 1.1em;" class="InvNo"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 575px; font-size: 1.1em;" class="ExpDate"></span>
        <span style="position: absolute;z-index: 1;top: 29px; left: 90px; font-size: 1.2em;" class="CJModeName"></span>
        <span style="position: absolute;z-index: 1;top: 35px; left: 472px;">Hạn điện:</span>
        <span style="position: absolute;z-index: 1;top: 30px; left: 575px;" class="ExpPluginDate"></span>
        <span style="position: absolute;z-index: 1;top: 68px; left: 20px;" class="SHIPPER_NAME"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 45px;" class="BL_BKNo"></span>
        <span style="position: absolute;z-index: 1;top: 102px; left: 438px;" class="Quantity"></span>
        <span style="position: absolute;z-index: 1;top: 100px; left: 595px;" class="BerthDate"></span>
        <span style="position: absolute;z-index: 1;top: 128px; left: 20px;">
            <span class="ShipName"></span>/<span class="ImVoy"></span>/<span class="ExVoy"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 130px; left: 490px;">
            <span class="POL"></span>/<span class="POD"></span>/<span class="FPOD"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 178px; left: 27px; font-size: 1.4em;" class="CntrNo"></span>
        <span style="position: absolute;z-index: 1;top: 180px; left: 215px; font-size: 0.9em; font-weight: normal">
            <span class="SealNo"></span> + <span class="SealNo1"></span>
        </span>
        <span style="position: absolute;z-index: 1;top: 180px; left: 435px; font-size: 1.4em;" class="OprID"></span>
        <span style="position: absolute;z-index: 1;top: 182px; left: 640px;" class="Status"></span>
        <span style="position: absolute;z-index: 1;top: 215px; left: 26px;" class="CMDWeight"></span>
        <span style="position: absolute;z-index: 1;top: 215px; left: 234px; font-size: 1.4em;" class="ISO_SZTP"></span>
        <span style="position: absolute;z-index: 1;top: 217px; left: 440px;" class="CARGO_TYPE_NAME"></span>
        <span style="position: absolute;z-index: 1;top: 252px; left: 45px;" class="Temperature"></span>
        <span style="position: absolute;z-index: 1;top: 252px; left: 250px;" class="Vent">0.00</span>
        <span style="position: absolute;z-index: 1;top: 252px; left: 393px;" class="UNNO"></span>
        <span style="position: absolute;z-index: 1;top: 252px; left: 601px;" class="OOG">0.0/0.0/0.0</span>
        <span style="position: absolute;z-index: 1;top: 321px; left: 0;" class="YardPos">B2-04-03-2</span>
        <span style="position: absolute;z-index: 1;top: 321px; left: 226px; max-width: 395px; word-wrap: break-word;" class="Note"></span>
        <img style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:410px;left:0" class="QR_IMAGE"></img>
		<span style="position: absolute;z-index: 1;top: 425px; left: 90px;font-weight: bold; font-size: 1.3em;" class="PinCode"></span>
        <span style="position: absolute;z-index: 1;top: 476px; left: 90px;" class="UserName"></span>
    </div>`;

    var tempDV = `<div class="DV-content" style="height:574px; position: relative;margin-top: 85px; left: 120.945px; font-weight: bold; font-size: 1.1em; font-family: 'Arial', 'Sans-serif'; page-break-after: always">
        <span style="position: absolute;z-index: 1;top: 0; left: 0;" class="OrderNo">1234567789</span>
        <span style="position: absolute;z-index: 1;top: 0; left: 345px;" class="InvNo"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 575px;" class="ExpDate"></span>
        <span style="position: absolute;z-index: 1;top: 30px; left: 90px;" class="CJModeName"></span>
        <span style="position: absolute;z-index: 1;top: 69px; left: 20px; font-size: 0.9em;" class="SHIPPER_NAME"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 45px;" class="BL_BKNo"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 375px;" class="NameDD"></span>
        <span style="position: absolute;z-index: 1;top: 97px; left: 605px;" class="PersonalID"></span>
        <!-- <span style="position: absolute;z-index: 1;top: 33.5vh; left: 60vw;" class="Quantity">40</span> -->
        <span style="position: absolute;z-index: 1;top: 128px; left: 20px;">
            <span class="ShipName"></span>/<span class="ImVoy"></span>/<span class="ExVoy"></span>
        </span>
		<span style="position: absolute;z-index: 1;top: 128px; left: 545px;" class="BerthDate"></span>
        <span style="position: absolute;z-index: 1;top: 180px; left: 0; font-size: 0.9em; font-weight: normal" class="Note"></span>
        <div id="service-list" style="text-align: center;position: absolute;z-index: 1;top: 231px; left: -80px">
            <table>
                <tbody style="font-size: 0.8em;">
                    
                </tbody>
            </table>
        </div>
        <span style="position: absolute;z-index: 1;top: 357px; left: 0;" class="IssueDate"></span>
        <span style="position: absolute;z-index: 1;top: 357px; left: 235px;" class="startDate"></span>
        <span style="position: absolute;z-index: 1;top: 357px; left: 500px;" class="endDate"></span>
        <img style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:390px;left:0" src="<?=$qr;?>"></img>
		<span style="position: absolute;z-index: 1;top: 400px; left: 90px;font-weight: bold; font-size: 1.2em;" class="PinCode"></span>
        <span style="position: absolute;z-index: 1;top: 455px; left: 90px;" class="UserName"></span>
    </div>`;

    var tempRowDV = `<tr style="border: 1px solid">
        <td style="width: 27px;height: 16px; text-align: center;" class="STT"></td>
        <td style="width: 135px;height: 16px; text-align: center; font-weight: bold;" class="CntrNo"></td>
        <td style="width: 80px;height: 16px; text-align: center;" class="OprID"></td>
        <td style="width: 46px;height: 16px; text-align: center;" class="ISO_SZTP"></td>
        <td style="width: 52px;height: 16px; text-align: center;" class="Status"></td>
        <td style="width: 80px;height: 16px; text-align: center;" class="CMDWeight"></td>
        <td style="width: 88px;height: 16px; text-align: center;" class="SealNo"></td>
        <td style="width: 88px;height: 16px; text-align: center;" class="YardPos"></td>
        <td style="width: 125px;height: 16px; text-align: center;" class="Remark"></td>
    </tr>`; 

    $(document).ready(function(){
        ctrlDown = false,
        ctrlKey = 17,
        cmdKey = 91,
        rKey = 219,

	    $(document).keydown(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
	    }).keyup(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
        });

	    $(document).keydown(function(e) {
	        if (ctrlDown && e.keyCode == rKey){
	        	$.confirm({
                    columnClass: 'col-md-3 col-md-offset-3',
                    titleClass: 'font-size-17',
                    title: 'Margin Top NH;DR;DV;HD',
                    content: '<div class="input-group-icon input-group-icon-left">'
                                +'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>'
                                +'<input autofocus class="form-control form-control-sm" id="num-row" value="1">'
                            +'</div>',
                    buttons: {
                        ok: {
                            text: 'OK',
                            btnClass: 'btn-sm btn-primary btn-confirm',
                            keys: ['Enter'],
                            action: function(){
                                var input = this.$content.find('input#num-row');
                                var errorText = this.$content.find('.text-danger');
                                if(!input.val().trim()){
                                    return false;
                                }else{
                                    var dt = input.val().split(";");
                                    localStorage.setItem("margin_nh", dt[0] ? dt[0] : "53px");
                                    localStorage.setItem("margin_dr", dt[1] ? dt[1] : "76px");
                                    localStorage.setItem("margin_dv", dt[2] ? dt[2] : "85px");
                                    localStorage.setItem("margin_hd", dt[3] ? dt[3] : "85px");
                                }
                            }
                        },
                        later: {
                            text: 'Hủy',
                            btnClass: 'btn-sm',
                            keys: ['ESC']
                        }
                    }
                });
	        	return false;
	        } 
        });

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

        $("#print-order").on("click", function(){
            // PrintElem( "contorder" );
            var data = <?= json_encode($print_data); ?>;
            $("#Print-NH, #Print-DR, #Print-DV").html('');

            if( data && data.length > 0 )
            {
                //set data for LOLO
                var loloServiceList = data.filter( p => p.OrderType == 'NH' );
                if( loloServiceList.length > 0 )
                {
                    var loloPrintContent = $("#Print-NH");
                    
                    $.each( loloServiceList, function(idx, item){
                        loloPrintContent.append( tempNH );

                        if( localStorage.getItem("margin_nh") ){
                            loloPrintContent.find('.NH-content:last').css("margin-top", localStorage.getItem("margin_nh") );
                        }

                        $.each(Object.keys( item ), function(idx, key){
                            if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
                                item[key] = getDateTime( item[key] );
                            }

                            if( key == 'cTLHQ' && item['CJMode_CD'] == 'LAYN' ){
								var txtTLHQ = item['cTLHQ'] == '1' ? 'ĐÃ THANH LÝ HQ' : 'CHƯA THANH LÝ HQ';
								loloPrintContent.find('.NH-content:last').find('span.isTLHQ').css("border", "3px solid #212529");
								loloPrintContent.find('.NH-content:last').find('span.isTLHQ').text( txtTLHQ );
							}
                            else if (key == 'QrData') {
                                loloPrintContent.find('.QR_IMAGE:last').attr('src', item[key]);
                            }
                            else{
								loloPrintContent.find('.NH-content:last').find('span.' + key).text( item[key] );
							}
                        });
                    } );

                    loloPrintContent.print();
                }

                //set data for STUFF - UNSTUFF
                var stuffList = data.filter( p => p.OrderType == 'DR' );
                if( stuffList.length > 0 )
                {
                    var stuffPrintContent = $("#Print-DR");
                    $.each( stuffList, function(idx, item){
                        stuffPrintContent.append( tempDR );

                        if( localStorage.getItem("margin_dr") ){
                            stuffPrintContent.find('.DR-content:last').css("margin-top",  localStorage.getItem("margin_dr") );
                        }

                        $.each(Object.keys( item ), function(idx, key){
                            if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
                                item[key] = getDateTime( item[key] );
                            }

                            if (key == 'QrData') {
                                stuffPrintContent.find('.QR_IMAGE:last').attr('src', item[key]);
                            }
                            
                            stuffPrintContent.find('.DR-content:last').find('span.' + key).text( item[key] );
                        });
                    } );
                    stuffPrintContent.print();
                }

                //set data for service
                var serviceList = data.filter( p => p.OrderType == 'DV' );
                if( serviceList.length > 0 )
                {
                    var servicePrintContent = $("#Print-DV");
                    var groupByCjMode = serviceList.reduce(function (r, a) {
                                        r[a.CJMode_CD] = r[a.CJMode_CD] || [];
                                        r[a.CJMode_CD].push(a);
                                        return r;
                                    }, Object.create(null));
					
					var arrays = [], numOfRow = 5;
					
                    $.each( groupByCjMode, function( cjmode, items ){
						
						while ( items.length > 0) {
							arrays.push( items.splice( 0, numOfRow ) );
						}

                        var i=1;
						$.each( arrays, function(idx, serviceItem){
                            if(serviceItem.length == 0){ return; }
							servicePrintContent.append( tempDV );
                            if( localStorage.getItem("margin_dv") ){
                                servicePrintContent.find('.DV-content:last').css("margin-top",  localStorage.getItem("margin_dv") );
                            }
							//set data for header
							var headerData = serviceItem[0];
							$.each( Object.keys( headerData ), function(idx, key){
								if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
									headerData[key] = getDateTime( headerData[key] );
								}

								servicePrintContent.find('.DV-content:last').find('span.' + key).text( headerData[key] );
							});

							//set data for each row and append to table
							$.each( serviceItem, function(idx, item){
								servicePrintContent.find('.DV-content:last').find( "table tbody" ).append( tempRowDV );
								var lastRow = servicePrintContent.find( "table tbody tr:last" );
								lastRow.find('td.STT').text( i++ );
								$.each(Object.keys( item ), function(ix, key){
									lastRow.find('td.' + key).text( item[key] );
								});
							} );
						} );
                    } );
                    
                    servicePrintContent.print();
                    servicePrintContent.html('');
					//var win = window.open("", "_blank");
                    //$(win.document.body).append(servicePrintContent);
                }
                
                // $('.m-show-modal').print();
                // PrintElem( "Print-content" );
                // var bppd = document.getElementById("Print-content");bppd.focus();bppd.contentWindow.print();
            }else{
                toastr["warning"]( "Không có dữ liệu in ấn!<br> Vui lòng kiểm tra lại!" )
            }
        });

        // $("#file-show-content").load(function(){
        //     var pdf = document.getElementById( "file-show-content" );
        //     pdf.focus();
        //     pdf.contentWindow.print();
        // });

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