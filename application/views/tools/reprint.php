<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>

	.m-row-selected{
		background: violet;
	}

	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold!important;
		padding-right: 0 !important;
	}

	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100%!important;
	}

	.modal-dialog-mw-py .modal-body{
		width: 90%!important;
		margin: auto;
	}

    #payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}
	.font-size-14 {
		font-size: 14px!important;
	}

	.box-group {
		border: 1px solid #ccc !important;
		margin-left: -10px;
		padding-top: 10px!important;
		border-radius: 3px!important;
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
        top: 2px;
        right: 11vw;
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

	.m-hidden{
        display: none;
    }
</style>

<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">IN LẠI CHỨNG TỪ</div>
				<div class="button-bar-group mr-3">
					<button type="button" id="load-data" title="Nạp dữ liệu"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-refresh"></i>
						Nạp dữ liệu
					</button>

					<button type="button" id="print-data" title="IN LỆNH"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang In" class="btn btn-sm btn-outline-warning mr-3">
						<i class="fa fa-print"></i>
						IN LỆNH
					</button>

					<button type="button" id="e-reprint" title="In lại hoá đơn điện tử"
							data-loading-text="<i class='la la-spinner spinner'></i>In lại hoá đơn điện tử" class="btn btn-sm btn-outline-secondary">
						<i class="fa fa-internet-explorer"></i>
						In hoá đơn điện tử
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row my-box pb-1">
					<div class="col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-6">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label" title="Số lệnh">Số lệnh</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm" id="ord-no" type="text" placeholder="Số lệnh">
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label" title="Số container">Số container</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm" id="cntr-no" type="text" placeholder="Số container">
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label" title="Số PIN">Số PIN</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm" id="pincode" type="text" placeholder="Số PIN">
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label" title="Số Hoá đơn">Số Hoá đơn</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm" id="invNo" type="text" placeholder="Số Hoá đơn">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="row form-group">
									<label class="radio radio-ebony pr-4">
										<input type="radio" name="ord-type" value="NH" checked>
										<span class="input-span col-form-label"></span>
										Nâng Hạ
									</label>
								</div>
								<div class="row form-group">
									<label class="radio radio-ebony">
										<input type="radio" name="ord-type" value="DV">
										<span class="input-span col-form-label"></span>
										Dịch Vụ
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2">
					<div class="col-12 ibox mb-0 border-e pb-1 pt-3">
						<table id="tbl" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th class="hiden-input">rowguid</th>
								<th>STT</th>
								<th>
									<div class="form-group mb-0">
										<label class="checkbox check-outline-primary">
											<input type="checkbox" name="check-all" style="display: none;">
											<span class="input-span"></span>
											Chọn
										</label>
									</div>
								</th>
								<th>Số Container</th>
								<th>Số Lệnh</th>
								<th>Số PIN</th>
								<th>Phương Án</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
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
        <i class="la la-close" style="font-size: 20px;" title="Đóng"></i>
    </div>
</div>

<div id="Print-NH" class="hiden-input">
    
</div>
<div id="Print-DR" class="hiden-input">
    
</div>
<div id="Print-DV" class="hiden-input">
    
</div>

<script type="text/javascript">
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
        <span style="position: absolute;z-index: 1;top: 330px; left: 270px; max-width: 395px; word-wrap: break-word; font-weight: bold; font-size: 1.3em; border: 0px solid #212529" class="isTLHQ"></span>
        <img id="qr-img" style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:425px;left:0" class="pincode" src=""></img>
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
        <img id="qr-img" style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:410px;left:0" class="pincode" src=""></img>
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
        <img id="qr-img" style="width:90px; height: 90px;background-color:transparent;border: 0;position:absolute;z-index:1;top:390px;left:0" class="pincode" src=""></img>
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
</script>

<script type="text/javascript">
	$(document).ready(function () {
	    var tbl = $( "#tbl" ),
	    	tblPayer = $( "#search-payer" ),
	    	_col = ["rowguid", "STT", "Check", "CntrNo", "OrderNo", "PinCode", "CJModeName"];

	    var _data = [];

		var dttb = tbl.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "hiden-input", targets: _col.indexOf('rowguid') },
				{ type: "num", className: "text-center", targets: _col.indexOf('STT') },
				{ orderable: false, className: "text-center", targets: _col.indexOf('Check') },
				{ className: "text-center", targets: _col.getIndexs( ['CntrNo', 'OrderNo', "PinCode", 'CJModeName'] ) }
			],
			order: [[ _col.indexOf('STT'), 'asc' ]],
			paging: false,
            rowReorder: false,
            buttons: []
		});

		$("#e-reprint").on("click", function(){
			$("#file-show-content").contents().find("body").html("");

			var checkRowguid = tbl.DataTable().rows().data().toArray()
												.filter( p => $( p[ _col.indexOf("Check") ] ).find("input").is(":checked") )
												.map( x => x[ _col.indexOf("rowguid") ] );

			var datas = _data.filter( p => checkRowguid.indexOf( p.rowguid ) != "-1" );

			if( datas.length > 0 ){
				var pinCode = datas[0].PinCode;
				if( pinCode.substr(0, 1) == 'E' ){
					$('#file-show-content').attr('src'
						, '<?= site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=");?>' + pinCode );

					$('.m-show-modal').show('fade', function(){
						window.setTimeout( function(){
							$(".m-close-modal").show( "slide", {direction: "up" }, 300 );
						}, 2000 );
					});
					return;
				}
			}

			$.confirm({
				columnClass: 'col-md-5 col-md-offset-5',
                title: 'Nhập mã giao dịch (số PIN)',
                content: '<div class="form-group">'
                            +'<input autofocus class="form-control form-control-sm font-size-14" id="pincode" placeholder="mã giao dịch (số PIN)"></input>'
                        +'</div>',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-sm btn-primary btn-confirm',
                        keys: ['Enter'],
                        action: function(){
                            var input = this.$content.find('input#pincode');
                            var errorText = this.$content.find('.text-danger');
                            if(!input.val().trim()){
                                $.alert({
                                	title: "Thông báo",
                                    content: "Vui lòng số PIN!.",
                                    type: 'red'
                                });
                                return false;
                            }else{
                            	$('#file-show-content').attr('src'
									, '<?= site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=");?>' + input.val() );

								$('.m-show-modal').show('fade', function(){
									window.setTimeout( function(){
										$(".m-close-modal").show( "slide", {direction: "up" }, 300 );
									}, 2000 );
								});
                            }
                        }
                    },
                    later: {
                    	text: 'Huỷ',
                    	btnClass: 'btn-sm',
                    	keys: ['ESC']
                    }
                }
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

		$(document).on("change", "th input[type='checkbox'][name='check-all']", function(e) {
			var isChecked = $( e.target ).is(":checked");

			var tempChange = '<label class="checkbox checkbox-outline-ebony">'
								+ '<input type="checkbox" name="check-ord" value="'
											+ ( isChecked ? "1" : 0 ) +'" style="display: none;" '+ ( isChecked ? "checked" : "" ) +'>'
								+ '<span class="input-span"></span>';
							+ '</label>';

			var rowEditing = [];
			tbl.DataTable().cells( ':not(.row-disabled)', _col.indexOf("Check") )
							.every( function(){
								this.data(tempChange);
								rowEditing.push( this.index().row );
							} );
		});

		tbl.on('change', 'tbody tr td input[name="check-ord"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');

        	tbl.DataTable().cell(crCell).data(crCell.html()).draw(false);
        });

		$( "#load-data" ).on("click", function(){

			if( !$( "#ord-no" ).val() && !$( "#cntr-no" ).val() && !$( "#pincode" ).val() && !$( "#invNo" ).val() ){
				toastr["error"]("Vui lòng nhập ít nhất một thông tin tìm kiếm!");
				return;
			}

			tbl.dataTable().fnClearTable();
			tbl.waitingLoad();

			var btn = $( "#load-data" );
			btn.button( "loading" );

			var formData = {
				"action": "view",
				"ordNo": $( "#ord-no" ).val(),
				"cntrNo": $( "#cntr-no" ).val(),
				"pinCode": $( "#pincode" ).val(),
				"invNo": $( "#invNo" ).val(),
				"ordType": $("input[name='ord-type']:checked").val()
			};

			$.ajax({
				url: "<?=site_url(md5('Tools') . '/' . md5('tlReprint'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					btn.button("reset");

					if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

					var rows = [];

					if( data.list && data.list.length > 0 )
					{
						_data = data.list;
						
						$.each( data.list, function( i, item ) {
							var r = [];
							$.each( _col, function( idx, colname ){
								var val = "";
								switch(colname){
									case "STT":
										val = i+1;
										break;
									case "Check":
										val = '<label class="checkbox checkbox-outline-ebony">'
												+ '<input type="checkbox" name="check-ord" checked value="1">'
												+ '<span class="input-span"></span>';
											+ '</label>';
										break;
									default:
										val = item[ colname ] ? item[ colname ] : "";
										break;
								}
								r.push( val );
							} );

							rows.push( r );

						} );
					}

					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						$("input[name='check-all']").prop("checked", true);
						tbl.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tbl.dataTable().fnClearTable();
					btn.button("reset");
					$('.toast').remove();
					toastr['error']("Server Error at [Load Data]! ");
					console.log(err);
				}
			});
		});

		$( "#print-data" ).on("click", function(){
			var checkRowguid = tbl.DataTable().rows().data().toArray()
												.filter( p => $( p[ _col.indexOf("Check") ] ).find("input").is(":checked") )
												.map( x => x[ _col.indexOf("rowguid") ] );

			var data = _data.filter( p => checkRowguid.indexOf( p.rowguid ) != "-1" );

			if( data && data.length > 0 )
            {
                //set data for LOLO
                var loloServiceList = data.filter( p => p.OrderType == 'NH' );
                if( loloServiceList.length > 0 )
                {
                    var loloPrintContent = $("#Print-NH");
                    $.each( loloServiceList, function(idx, item){
                        loloPrintContent.append( tempNH );
                        $.each(Object.keys( item ), function(idx, key){
                            if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
                                item[key] = getDateTime( item[key] );
                            }
							
							if( key == 'cTLHQ' && item['CJMode_CD'] == 'LAYN' ){
								var txtTLHQ = item['cTLHQ'] == '1' ? 'ĐÃ THANH LÝ HQ' : 'CHƯA THANH LÝ HQ';
								loloPrintContent.find('.NH-content:last').find('span.isTLHQ').css("border", "3px solid #212529");
								loloPrintContent.find('.NH-content:last').find('span.isTLHQ').text( txtTLHQ );
							}else{
								loloPrintContent.find('.NH-content:last').find('span.' + key).text( item[key] );
							}
                        });

						var imgUrl = "<?= base_url("/assets/img/qrcode_gen/") ?>" + item["PinCode"] + ".png";
						loloPrintContent.find("img.pincode").attr("src", imgUrl);
                    } );
					
					loloPrintContent.find('#qr-img').on('load', function(){
                        loloPrintContent.print();
						loloPrintContent.html('');
                    });
                }

                //set data for STUFF - UNSTUFF
                var stuffList = data.filter( p => p.OrderType == 'DR' );
                if( stuffList.length > 0 )
                {
                    var stuffPrintContent = $("#Print-DR");
                    $.each( stuffList, function(idx, item){
                        stuffPrintContent.append( tempDR );
                        $.each(Object.keys( item ), function(idx, key){
                            if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
                                item[key] = getDateTime( item[key] );
                            }
                            stuffPrintContent.find('.DR-content:last').find('span.' + key).text( item[key] );
                        });

						var imgUrl = "<?= base_url("/assets/img/qrcode_gen/") ?>" + item["PinCode"] + ".png";

						stuffPrintContent.find("img.pincode").attr("src", imgUrl);
                    } );
					
					stuffPrintContent.find('#qr-img').on('load', function(){
                        stuffPrintContent.print();
						stuffPrintContent.html('');
                    });
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
						
						$.each( arrays, function(idx, serviceItem){
                            if(serviceItem.length == 0){ return; }
							servicePrintContent.append( tempDV );

							//set data for header
							var headerData = serviceItem[0];
							$.each( Object.keys( headerData ), function(idx, key){
								if( ['IssueDate', 'ExpDate', 'ExpPluginDate', 'BerthDate'].indexOf(key) != -1 ){
									headerData[key] = getDateTime( headerData[key] );
								}

								servicePrintContent.find('.DV-content:last').find('span.' + key).text( headerData[key] );
							});

							var imgUrl = "<?= base_url("/assets/img/qrcode_gen/") ?>" + serviceItem[0]["PinCode"] + ".png";
							servicePrintContent.find("img.pincode").attr("src", imgUrl);

							//set data for each row and append to table
							var i=1;
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
                    
					servicePrintContent.find('#qr-img').on('load', function(){
                        servicePrintContent.print();
						servicePrintContent.html('');
                    });
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
	});
</script>

<script src="<?= base_url('assets/js/jsprint.js'); ?>"></script>