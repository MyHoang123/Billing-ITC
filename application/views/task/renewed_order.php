<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />

<style>
	.nav-tabs{
		height: inherit!important;
	}
	.m-row-selected{
		background: violet;
	}
	.MT-toggle, .PY-toggle{
		display: none;
	}
	.MT-toggle button, .PY-toggle button {
		background-color: #fff!important;
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
	
	.grid-hidden{
		display: none;
	}

	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		height: 100%;
		padding: 0;
		max-width: 100%!important;
	}

	.modal-dialog-mw-py .modal-body{
		width: 90%!important;
		margin: auto;
	}

	.unchecked-Salan{
		pointer-events: none;
	}
	span.col-form-label {
		width: 100%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label{
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.add-payer {
		flex: 1;          /* shorthand for: flex-grow: 1, flex-shrink: 1, flex-basis: 0 */
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}

	.add-payer-container {
		transform: scaleX(0);
		position: absolute;
		width: 100%;
		height: 100%;

		top: 0;
		left: 0;

		background: #8e9eab; /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #8e9eab, #eef2f3); /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #8e9eab, #eef2f3);

		-webkit-transition: transform 1s linear; /* For Safari 3.1 to 6.0 */
		transition: transform 1s linear;
		transform-origin: left center;
		z-index: 1;
		padding: 7px 0 7px 20px;
	}

	.payer-show{
		transform: scaleX(1);
	}

	#payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}

</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">GIA HẠN LỆNH</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row pl-1">
					<div class="col-3 ibox mb-0 border-e pb-1 pt-3">
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Loại lệnh</label>
							<div class="col-sm-7">
								<select id="ord-type" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
									<option value="">--</option>
									<option value="NH">Nâng Hạ</option>
									<option value="DV">Dịch Vụ</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Từ ngày</label>
							<div class="col-sm-7 input-group input-group-sm">
								<input class="form-control form-control-sm text-center input-required" id="fromDate" type="text" placeholder="Từ ngày" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Đến ngày</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm text-center input-required" id="toDate" placeholder="Đến ngày" type="text" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số PIN</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="pinCode" placeholder="Số PIN" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số lệnh</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="ordNo" placeholder="Số lệnh" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số container</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="cntrNo" placeholder="Số container" type="text">
							</div>
						</div>

						<div class="row form-group mt-4">
							<div class="col-sm-7 input-group ml-sm-auto">
								<button id="reload" class="btn btn-warning btn-sm btn-block"
													data-loading-text="<i class='la la-spinner spinner'></i>Tìm kiếm" 
													title="Tìm kiếm">
									<span class="btn-icon"><i class="fa fa-search"></i>Tìm kiếm</span>
								</button>
							</div>
						</div>

						<span class="row" style="border-bottom: 1px solid #ddd"></span>
						
						<div class="row form-group mt-3">
							<div class="col-sm-5 input-group m-sm-auto">
								<label class="checkbox checkbox-inline checkbox-blue col-form-label" title="Tính cước">
									<input type="checkbox" name="hasPayment" id="hasPayment" value="0">
									<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
									Tính cước
								</label>
							</div>
							<div class="col-sm-7">
								<button id="save" class="btn btn-primary btn-sm btn-block" 
																data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu"
																title="Lưu dữ liệu">

									<span class="btn-icon"><i class="fa fa-save"></i>Lưu dữ liệu</span>
								</button>
							</div>
						</div>

						<div class="payment-details mt-4" style="display: none; ">
							<div class="row form-group">
								<label class="col-sm-5 col-form-label" title="Đối tượng thanh toán">Đối tượng TT</label>
								<div class="col-sm-7 input-group">
									<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
									<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
											title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
										<i class="ti-search"></i>
									</span>
								</div>
								<input class="hiden-input" id="cusID" readonly>
								<input class="hiden-input" id="payment-type" readonly>
							</div>
							<div id="INV_DRAFT_TOTAL">
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Thành tiền</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-blue" id="AMOUNT"></span>
									</div>
								</div>
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Giảm trừ</label>
									<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT"></span>
								</div>
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Tiền thuế</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-blue" id="VAT"></span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Tổng tiền</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-danger" id="TAMOUNT"></span>
									</div>
								</div>
							</div>

							<div id="publish-type" class="row form-group mt-3">
								<div class="col-12 ml-sm-auto">
									<div class="row input-group">
										<label class="col-form-label radio radio-outline-warning text-warning mx-auto">
											<input name="publish-opt" value="e-inv" type="radio" checked>
											<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
											HĐ điện tử
										</label>
										<label class="col-form-label radio radio-outline-danger text-danger mr-2 mx-auto">
											<input name="publish-opt" value="m-inv" type="radio">
											<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
											HĐ giấy
										</label>
										<label class="col-form-label radio radio-outline-blue text-blue mr-2 mx-auto">
											<input name="publish-opt" type="radio" value="dft" >
											<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
											Phiếu thu
										</label>
									</div>
								</div>
							</div>

							<div id="m-inv-container" class="row form-group hiden-input">
								<label class="col-sm-3 col-form-label">Số HĐ kế tiếp</label>
								<div class="col-form-label text-danger font-bold">
									<?php if( isset( $ssInvInfo ) && count( $ssInvInfo ) > 0 ){ ?>
										<span id="ss-invNo">
											<?= $ssInvInfo['serial'].substr("00000000".$ssInvInfo['invno'], -8)?>
											<?php if( $isDup ) { ?>
												&ensp;
												[BỊ TRÙNG]
											<?php } ?>
										</span>
										&ensp;
										<button id="change-ssinvno" class="btn btn-outline-secondary btn-sm mr-1"
																	data-toggle="modal"
																	data-target="#change-ssinv-modal"
																	title="Thay đổi hóa đơn sử dụng tiếp theo">
											<span class="btn-icon"><i class="fa fa-pencil"></i>Thay đổi</span>
										</button>
									<?php } else{ ?>
										<span id="ss-invNo">
											Chưa khai báo hóa đơn tiếp theo!
										</span>
										&ensp;
										<button id="change-ssinvno" class="btn btn-outline-primary btn-sm mr-1"
																	data-toggle="modal"
																	data-target="#change-ssinv-modal"
																	title="Khai báo số hóa đơn sử dụng tiếp theo">
											<span class="btn-icon"><i class="fa fa-pencil"></i>Khai báo</span>
										</button>
									<?php } ?>
								</div>
							</div>

							<div class="row form-group mt-4">
								<div class="col-sm-7 ml-sm-auto">
									<button id="calculate" class="btn btn-outline-secondary btn-sm btn-block" 
															data-loading-text="<i class='la la-spinner spinner'></i>Đang tính"
															title="Tính cước">

										<span class="btn-icon"><i class="fa fa-calculator"></i>Tính cước</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- ///////////////////////////////// -->
					<div class="col-9 pl-3 pr-0">
						<div class="ibox mb-0 border-e p-3 content-group">
							<div class="table-responsive">
								<table id="tbl-content" class="table table-striped display nowrap" cellspacing="0"  style="width: 100%">
									<thead>
										<tr>
											<th col-name="STT" class="editor-cancel">STT</th>
											<th col-name="rowguid">RowGuid</th>
											<th col-name="OrderNo" class="editor-cancel">Số lệnh</th>
											<th col-name="CntrNo" class="editor-cancel">Số container</th>
											<th col-name="PinCode" class="editor-cancel">Số PIN</th>
											<th col-name="CJModeName" class="editor-cancel">Phương Án</th>
											<th col-name="ExpDate" class="editor-cancel">Hạn lệnh</th>
											<th col-name="ExpPluginDate" class="editor-cancel">Hạn điện lạnh</th>
											<th col-name="NewExpDate" class="data-type-date">Gia hạn lệnh</th>
											<th col-name="NewExpPluginDate" class="data-type-datetime">Gia hạn điện lạnh</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

						<div class="ibox mb-0 border-e p-3 mt-3 payment-details" style="display: none;">
							<div class="table-responsive">
								<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0">
									<thead>
									<tr>
										<th>STT</th>
										<th>Số phiếu tính cước</th>
										<th>Số lệnh</th>
										<th>Mã biểu cước</th>
										<th>Tên biểu cước</th>
										<th>ĐVT</th>
										<th>Loại công việc</th>
										<th>PTGN</th>
										<th>Loại hàng</th>
										<th>Kích cỡ ISO</th>
										<th>Hàng/rỗng</th>
										<th>Nội/ngoại</th>
										<th>Số lượng</th>
										<th>Đơn giá</th>
										<th>Chiết khấu (%)</th>
										<th>Đơn giá CK</th>
										<th>Đơn giá sau CK</th>
										<th>Thành tiền</th>
										<th>Thuế (%)</th>
										<th>Tiền thuế</th>
										<th>Tổng tiền</th>
										<th>Loại tiền</th>
										<th>IX_CD</th>
										<th>CNTR_JOB_TYPE</th>
										<th>VAT_CHK</th>
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
	</div>
</div>

<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0"  style="width: 100%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Mã ĐT</th>
							<th>MST</th>
							<th>Tên</th>
							<th>Địa chỉ</th>
							<th>HTTT</th>
						</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" style="position: relative; padding: 22px 15px !important">
				<div class="add-payer-container">
					<div class="row">
						<div class="col-sm-11 col-xs-11">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
									<div class="row form-group">
										<label class="col-sm-3 col-form-label" title="Mã số thuế">MST</label>
										<div class="col-sm-9">
											<input class="form-control form-control-sm" id="add-payer-taxcode" type="text" placeholder="Mã số thuế">
										</div>
									</div>
								</div>

								<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<div class="row form-group">
										<label class="col-sm-2 col-form-label" title="Tên đối tượng thanh toán">Tên</label>
										<div class="col-sm-10">
											<input class="form-control form-control-sm" id="add-payer-name" type="text" placeholder="Tên">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="row form-group">
										<label class="col-sm-1 col-form-label" title="Địa chỉ">Địa chỉ</label>
										<div class="col-sm-11">
											<input class="form-control form-control-sm" id="add-payer-address" type="text" placeholder="Địa chỉ">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-1 col-xs-1" style="margin: auto 0;">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="row form-group">
										<a id="save-payer" class="btn btn-sm text-primary" title="Lưu" style="padding: 14px; font-size: 1.2rem">
											<span class="btn-icon"><i class="fa fa-save"></i></span>
										</a>
									</div>
									<div class="row form-group">
										<a id="close-payer-content" class="btn btn-sm text-danger" title="Đóng lại" style="padding: 14px; font-size: 1.3rem">
											<span class="btn-icon"><i class="fa fa-close"></i></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="add-payer">
					<button id="b-add-payer" class="btn btn-outline-success" title="Thêm khách hàng">
						<i class="fa fa-plus"></i>
						Thêm khách hàng
					</button>
				</div>

				<button type="button" id="select-payer" class="btn btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="change-ssinv-modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 300px">
		<div class="modal-content" style="border-radius: 5px">
			<div class="modal-header" style="border-radius: 5px;background-color: #fdf0cd;">
				<h4 class="modal-title text-primary font-bold" id="groups-modalLabel">Khai báo số hóa đơn</h4>
				<i class="btn fa fa-times text-primary" data-dismiss="modal"></i>
			</div>
			<div class="modal-body" style="margin:3px;border-radius: 5px;overflow-y: auto;max-height: 90vh">
				<div class="form-group pb-3">
					<label class="col-form-label">Mẫu hóa đơn</label>
					<input class="form-control form-control-sm" id="inv-prefix" type="text" placeholder="Mẫu hóa đơn">
				</div>
				<div class="form-group pb-3">
					<label class="col-form-label">Từ số - đến số</label>
					<div class="input-group">
						<input class="form-control form-control-sm" id="inv-no-from" maxlength="7" type="text" placeholder="Từ số">
						<input class="form-control form-control-sm ml-2" id="inv-no-to" maxlength="7" type="text" placeholder="Đến số">
					</div>
				</div>
				<div class="form-group">
					<p class="text-muted m-b-20">Số hóa đơn kế tiếp sẽ được sử dụng là giá trị <br> [Từ số] được nhập vào ở trên!</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm-ssInvInfo" class="btn btn-sm btn-outline-warning">
					<i class="fa fa-check"></i>
					Xác nhận
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Hủy bỏ
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function () {
		var _colContent = ["STT", "rowguid", "OrderNo", "CntrNo", "PinCode", "CJModeName", "ExpDate", "ExpPluginDate"
							, "NewExpDate", "NewExpPluginDate"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE"
							, "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT"
							, "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"];

		var tblContent = $('#tbl-content');

		var payers= [], _lstOrder = [], _lst = [];

		// ------------binding shortcut key press------------
		ctrlDown = false,
        ctrlKey = 17,
        cmdKey = 91,
        rKey = 82,

	    $(document).keydown(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
	    }).keyup(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
	    });

	    $(document).keydown(function(e) {
	        if (ctrlDown && e.keyCode == rKey){
	        	alert('reload filter');
	        	return false;
	        } 
	    });

	    //---------datepicker modified---------
	    $('#fromDate, #toDate').datepicker({
			dateFormat: "dd/mm/yy",
			startDate: moment().format('DD/MM/YYYY'),
			todayHighlight: true,
			autoclose: true
		});

		$('#fromDate').val(moment().subtract(1, "months").format('DD/MM/YYYY'));
		$('#toDate').val(moment().format('DD/MM/YYYY'));

        var dtContent = tblContent.DataTable({
			columnDefs: [
				{
					type: "num", className: "text-center", targets: _colContent.indexOf("STT")
				},
				{
					visible: false, targets: _colContent.indexOf("rowguid")
				},
				{
					className: 'text-center',
					width: "150px",
					visible: false,
					targets: _colContent.getIndexs(["ExpPluginDate", "NewExpPluginDate"])
				},
				{
					className: 'text-center',
					width: "150px",
					targets: _colContent.indexOf("NewExpDate"),
					render: function (data, type, full, meta) {
						var temp = Array.isArray( data ) ? data[0] : data;
						return temp ? temp.split(" ")[0] + " 23:59:59" : "";
					}
				},
				{
					className: 'text-center',
					targets: _colContent.getIndexs(["OrderNo", "CntrNo", "PinCode", "ExpDate", "NewExpDate"])
				},
			],
			buttons: [],
			infor: false,
			scrollY: '259px',
			paging: false,
            keys: true,
            autoFill: {
                focus: 'focus',
                columns: _colContent.getIndexs(["ExpPluginDate", "NewExpDate", "NewExpPluginDate"])
            },
            select: true,
            rowReorder: false,
            arrayColumns: _colContent
		});

		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '217px'
		});

		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [
				{
					 type: "num"
					,targets: [0]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colPayer.getIndexs(["CusName", "Address"])
				}
			],
			buttons: [],
			infor: false,
			scrollY: '45vh'
		});

		load_payer();

		tblContent.editableTableWidget();

///////// SEARCH PAYER
		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val( $( r ).find( 'td:eq(' + _colPayer.indexOf("VAT_CD") + ')' ).text() );
			$('#cusID').val( $( r ).find( 'td:eq( ' + _colPayer.indexOf("CusID") + ')' ).text() );

			var paymentType = payers.filter( p => p.CusID == $('#cusID').val() && p.VAT_CD == $("#taxcode").val() )[0].CusType;
			$("#payment-type").val( paymentType );

			if( paymentType == "M" ){
				$("#publish-type").removeClass("hiden-input");

				if( !$("input[name='publish-opt']").is(":checked") ){
					$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
					$("#m-inv-container").addClass("hiden-input");
				}
				
			}else{
				$("#publish-type").addClass("hiden-input");
				$("input[name='publish-opt']").prop("checked", false);
			}

			// fillPayer();

			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			var paymentType = payers.filter( p => p.CusID == $('#cusID').val() && p.VAT_CD == $("#taxcode").val() )[0].CusType;
			$("#payment-type").val( paymentType );

			if( paymentType == "M" ){
				$("#publish-type").removeClass("hiden-input");

				if( !$("input[name='publish-opt']").is(":checked") ){
					$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
					$("#m-inv-container").addClass("hiden-input");
				}

			}else{
				$("#publish-type").addClass("hiden-input");
				$("input[name='publish-opt']").prop("checked", false);
			}

			// fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});

		$('#payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

///////// END SEARCH PAYER

//------USING MANUAL INVOICE

		$("input[name='publish-opt']").on("change", function(e){
			if( $(e.target).val() == "m-inv" ){
				$("#m-inv-container").removeClass("hiden-input");
				$("#save").prop("disabled", <?= $isDup || !isset( $ssInvInfo ) || count( $ssInvInfo ) == 0; ?>);
			}else{
				$("#m-inv-container").addClass("hiden-input");
				$("#save").prop("disabled", false);
			}
		});

		$("#confirm-ssInvInfo").on("click", function(){
			if( !$("#inv-prefix").val() ){
				toastr["error"]("Vui lòng nhập mẫu hóa đơn!");
				return;
			}

			if( !$("#inv-no-from").val() ){
				toastr["error"]("Vui lòng nhập số hóa đơn [Từ số]!");
				return;
			}

			if( !$("#inv-no-to").val() ){
				toastr["error"]("Vui lòng nhập số hóa đơn [Đến số]!");
				return;
			}

			$.confirm({
				columnClass: 'col-md-4 col-md-offset-4 mx-auto',
				titleClass: 'font-size-17',
                title: 'Xác nhận',
                content: 'Xác nhận thông tin khai báo hóa đơn này!?',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-sm btn-primary btn-confirm',
                        keys: ['Enter'],
                        action: function(){
                        	var data = {
								invno: $("#inv-no-from").val(),
								serial: $("#inv-prefix").val(),
								fromNo: $("#inv-no-from").val(),
								toNo: $("#inv-no-to").val()
							};	

							var formData = {
								'action': 'save',
								'act': 'use_manual_Inv',
								'useInvData': data
							};

							$("#change-ssinv-modal .modal-content").blockUI();

							$.ajax({
				                url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				                dataType: 'json',
				                data: formData,
				                type: 'POST',
				                success: function (data) {

				                	$("#change-ssinv-modal .modal-content").unblock();

				                    if( data.deny ) {
				                        toastr["error"](data.deny);
				                        return;
				                    }

				                	var invNo = formData.useInvData.serial + formData.useInvData.invno;

				                    if( data.isDup ){
				                    	toastr["error"]("Số hóa đơn bắt đầu ["+ invNo +"] đã tồn tại trong hệ thống!");
				                    	return;
				                    }

				                	$("#change-ssinv-modal").modal('hide');
				                    toastr["success"]("Xác nhận sử dụng Số HĐ ["+ invNo +"] thành công!");
				                    $("#ss-invNo").text(invNo);
				                    $("#change-ssinvno").attr("title", "Thay đổi hóa đơn sử dụng tiếp theo")
				                    					.html( '<span class="btn-icon"><i class="fa fa-pencil"></i>Thay đổi' );

				                    $("#save").prop("disabled", false);
				                },
				                error: function(err){
				                	$("#change-ssinv-modal .modal-content").unblock();
				                	toastr["error"]("Server Error at [confirm-ssInvInfo]!");
				                	console.log(err);
				                }
				            });
                        }
                    },
                    cancel: {
                    	text: 'Hủy',
                    	btnClass: 'btn-sm',
                    	keys: ['ESC'],
                    	action: function() {

                    	}
                    }
                }
            });
		});

//------USING MANUAL INVOICE

		tblContent.DataTable().on( 'autoFill', function ( e, datatable, cells ) {
   			var idxs = cells.map( x => x[0].index.row );
   			idxs.shift();
   			tblContent.DataTable().rows( idxs ).nodes().to$().addClass("editing");
		} );

		tblContent.on("change", "td", function(e){
			var colHiddenIndexes = tblContent.DataTable().columns(':not(:visible)').indexes().toArray();
			var tempColumns = _colContent.filter( (p , i) => colHiddenIndexes.indexOf( i ) == -1 );

			// if( $(e.currentTarget).index() == tempColumns.indexOf("NewExpDate") ){
			// 	var newexpDate = new Date( convertDateTimeFormat( $(e.currentTarget).text(), 'y-m-d' ) );
			// 	var oldExpDate = $(e.currentTarget).closest("tr").find( "td:eq("+ tempColumns.indexOf("ExpDate") +")" ).text();
			// 	oldExpDate = new Date( convertDateTimeFormat( oldExpDate, 'y-m-d' ) );

			// 	if( newexpDate <= oldExpDate ){
			// 		$(".toast").remove();
			// 		toastr["error"]("Hạn lệnh mới phải lớn hơn hạn lệnh cũ!");
			// 		tblContent.DataTable().cell( $(e.currentTarget) ).data("").draw(false);
			// 		e.preventDefault();
			// 		return;
			// 	}
			// }

			if( $(e.currentTarget).index() == tempColumns.indexOf("NewExpPluginDate") ){
				var newExpPluginDate = new Date( convertDateTimeFormat( $(e.currentTarget).text(), 'y-m-d' ) );
				var oldExpPluginDate = $(e.currentTarget).closest("tr").find( "td:eq("+ tempColumns.indexOf("ExpPluginDate") +")" ).text();
				oldExpPluginDate = new Date( convertDateTimeFormat( oldExpPluginDate, 'y-m-d' ) );

				if( newExpPluginDate <= oldExpPluginDate ){
					$(".toast").remove();
					toastr["error"]("Hạn điện mới phải lớn hơn hạn điện cũ!");
					tblContent.DataTable().cell( $(e.currentTarget) ).data("").draw(false);
					e.preventDefault();
					return;
				}
			}
		});

		$('#hasPayment').on("change", function(){
			if( $(this).is(":checked") ){
				$("#save").attr({"title": "Thanh toán", "data-loading-text": "<i class='la la-spinner spinner'></i>Thanh toán"})
							.html('<span class="btn-icon"><i class="fa fa-credit-card"></i>Thanh toán</span>');

				tblContent.parent().css("height", "181px");

				$( ".payment-details" ).show("slide", { direction: "up" }, 1000);

			}else{

				$("#save").attr({"title": "Lưu dữ liệu", "data-loading-text": "<i class='la la-spinner spinner'></i>Đang lưu"})
							.html('<span class="btn-icon"><i class="fa fa-save"></i>Lưu dữ liệu</span>');

				$( ".payment-details" ).hide("slide", { direction: "up" }, 1000, function(){
					tblContent.parent().css( "height", "259px" );
				});
			}
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();

		});

		$("#reload").on("click", function(){
			if( !$("#ord-type").val() ){
				toastr["warning"]("Chưa chọn loại lệnh!");
				$("#ord-type").selectpicker('toggle');
				return;
			}

			$('#tbl-inv').dataTable().fnClearTable();

			$('#AMOUNT').text("");
			$('#DIS_AMT').text("");
			$('#VAT').text("");
			$('#TAMOUNT').text("");

			tblContent.waitingLoad();

			$(this).button("loading");

			reloadData();
		});

		$('#calculate').on("click", function(){
			if( !$("#cusID").val() ){

				$("#cusID").parent().addClass("error");

				$(".toast").remove();

				toastr["error"]("Chưa chọn đối tượng thanh toán!");

				return;
			}

			$("#cusID").parent().removeClass("error");

			$(this).button('loading');
			load_payment();
		});

		$('#save').on('click', function () {
			$(this).button("loading");

			if( $( "#hasPayment" ).is(":checked") ){
				switch( $("#payment-type").val() ){
					case "M":
						if( $("input[name='publish-opt']:checked").val() == "e-inv" ){
							publishInv();
						}else{
							saveData();
						}
						break;
					case "C":
						saveData();
						break;
					case "":
					default:
						toastr["error"]("Không xác định được hình thức thanh toán của đối tượng này!");
						$('#save').button("reset");
						break;
				}
			}else{
				updateData();
			}
		});

		function reloadData(){
			var formData = {
				"action": "view",
				"act": "search",
				"fromDate": $("#fromDate").val(),
				"toDate": $("#toDate").val(),
				"ordNo": $("#ordNo").val(),
				"cntrNo": $("#cntrNo").val(),
				"pinCode": $("#pinCode").val(),
				"ordType": $("#ord-type").val()
			};

			_lst = [];

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					if( $("#reload").find("i.spinner").length > 0 ){
						$("#reload").button("reset");
					}
					
					if( response.deny ){
						toastr["error"](response.deny);
						return;
					}

					var rows = [];

		        	if( response.list && response.list.length > 0 ){
						_lst = response.list;

		        		var i = 0;
		        		var showPluginCol = false;

		        		$("#cusID").val(_lst[0]["CusID"]);

		        		if( payers.length > 0 ){
		        			$("#taxcode").val( payers.filter(p=> p.CusID == _lst[0]["CusID"]).map( x => x.VAT_CD )[ 0 ] );
		        			$("#payment-type").val( payers.filter(p=> p.CusID == _lst[0]["CusID"]).map( x => x.CusType )[ 0 ] );
		        		}

			        	$.each(_lst, function(index, rData){
			        		var r = [];
							$.each(_colContent, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "ExpPluginDate":
										if( rData[ colname ] ){
											showPluginCol = true;
											val = getDateTime( rData[ colname ] );
										}
										break;
									case "ExpDate":
									case "NewExpDate":
									case "NewExpPluginDate":
										val = getDateTime( rData[ colname ] );
										break;
									default:
										val = rData[colname] ? rData[colname] : "";
										break;
								}

								r.push(val);
							});

							i++;
							rows.push(r);
			        	});
		        	}

		        	tblContent.dataTable().fnClearTable();

		        	if(rows.length > 0){
						tblContent.dataTable().fnAddData(rows);
		        	}

		        	tblContent.DataTable()
					        		.columns( _colContent.getIndexs(["ExpPluginDate", "NewExpPluginDate"]) ).visible(showPluginCol);
				},
				error: function(err){
					if( $("#reload").find("i.spinner").length > 0 ){
						$("#reload").button("reset");
					}

					tblContent.dataTable().fnClearTable();

					console.log(err);
				}
			});
		}

		function load_payer(){
			var tblPayer = $('#search-payer');

			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function (data) {

					if( data.deny ) {
                        toastr["error"](data.deny);
                        tblPayer.dataTable().fnClearTable();
                        return;
                    }

					var rows = [];

					if(data.payers && data.payers.length > 0){
						payers = data.payers;

		        		var i = 0;
			        	$.each(payers, function(index, rData){
			        		var r = [];
							$.each(_colPayer, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "CusType":
										val = !rData[colname] ? "" : (rData[colname] == "M" ? "Thu ngay" : "Thu sau");
										break;
									default:
										val = rData[colname] ? rData[colname] : "";
										break;
								}
								r.push(val);
							});
							i++;
							rows.push(r);
			        	});
		        	}

		        	tblPayer.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblPayer.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Server Error At [Load Payer]");
				}
			});
		};

		function getEirInfoUpdated()
		{
			var checkData = tblContent.DataTable().rows(".editing").data().toArray();
			if(checkData.length == 0){
				return [];
			}

			var datas = [];
			$.each(checkData, function(idx, item){
				if( item[ _colContent.indexOf( "NewExpDate" ) ] || item[ _colContent.indexOf( "NewExpPluginDate" ) ] ){
					var ret = {
						"rowguid": item[ _colContent.indexOf( "rowguid" ) ],
						"OrderNo": item[ _colContent.indexOf( "OrderNo" ) ],
						"CntrNo": item[ _colContent.indexOf( "CntrNo" ) ],
						"ExpDate": item[ _colContent.indexOf( "ExpDate" ) ],
						"NewExpDate": item[ _colContent.indexOf( "NewExpDate" ) ]
											? item[ _colContent.indexOf( "NewExpDate" ) ].split(" ")[0] + " 23:59:59" : "",
						"ExpPluginDate": item[ _colContent.indexOf( "ExpPluginDate" ) ],
						"NewExpPluginDate": item[ _colContent.indexOf( "NewExpPluginDate" ) ]
					};

					//order type: NH  -  DV
					ret["OrderType"] = _lst.filter( p => p.rowguid == ret.rowguid )[0].OrderType;
					
					//get pincode and CJMODE_CD for update GATE_MONITOR
					ret["PinCode"] = _lst.filter( p => p.rowguid == ret.rowguid )[0].PinCode;
					ret["CJMode_CD"] = _lst.filter( p => p.rowguid == ret.rowguid )[0].CJMode_CD;

					//get master rowguid from SRV_ODR for update RF_ONOFF
					ret["MASTER_ROWGUID"] = _lst.filter( p => p.rowguid == ret.rowguid )[0].MASTER_ROWGUID;
					datas.push(ret);
				}
			});

			return datas;
		}

		function load_payment()
		{
			var datas = getEirInfoUpdated();

			if(datas.length == 0){
				$(".toast").remove();
				toastr["warning"]("Chưa nhập thông tin gia hạn!");
				$("#calculate").button("reset");
				return;
			}

			var tblInv = $('#tbl-inv');

			tblInv.waitingLoad();

			var formdata = {
				"action": "view",
				"act": "load_payment",
				"cusID": $("#cusID").val(),
				"datas": datas
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					tblInv.dataTable().fnClearTable();

					if( data.deny ) {
                        toastr["error"](data.deny);
                        tblInv.DataTable().clear().draw();
                        return;
                    }

					if( data.error && data.error.length > 0 ){
						$.each(data.error, function(){
							toastr["error"](this);
						});
					}

					if(!data.results || data.results.length == 0){
						toastr["warning"]("Không tìm thấy biểu cước phù hợp! Vui lòng kiểm tra lại!");
						tblInv.DataTable().clear().draw();
						return;
					}

					var rows = [];
					if(data.results && data.results.length > 0)
					{
						var lst = data.results, stt = 1;
						_lstOrder = data.renewed_ord ? data.renewed_ord : {};

						for (i = 0; i < lst.length; i++) {
							rows.push([
								(stt++)
								, lst[i].DraftInvoice
								, lst[i].OrderNo ? lst[i].OrderNo : ""
								, lst[i].TariffCode
								, lst[i].TariffDescription
								, lst[i].Unit
								, lst[i].JobMode
								, lst[i].DeliveryMethod
								, lst[i].Cargotype
								, lst[i].ISO_SZTP
								, lst[i].FE
								, lst[i].IsLocal
								, lst[i].Quantity
								, lst[i].StandardTariff
								, 0
								, lst[i].DiscountTariff
								, lst[i].DiscountedTariff
								, lst[i].Amount
								, lst[i].VatRate
								, lst[i].VATAmount
								, lst[i].SubAmount
								, lst[i].Currency
								, lst[i].IX_CD
								, lst[i].CNTR_JOB_TYPE
								, lst[i].VAT_CHK
							]);
						}
					}

					if(rows.length > 0){
						var n = rows.length;
						rows.push([
							n
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, data.SUM_AMT
							, ''
							, data.SUM_VAT_AMT
							, data.SUM_SUB_AMT
							, ''
							, ''
							, ''
							, ''
						]);
						$('#AMOUNT').text($.formatNumber(data.SUM_AMT, { format: "#,###", locale: "us" }));
						$('#DIS_AMT').text($.formatNumber(data.SUM_DIS_AMT, { format: "#,###", locale: "us" }));
						$('#VAT').text($.formatNumber(data.SUM_VAT_AMT, { format: "#,###", locale: "us" }));
						$('#TAMOUNT').text($.formatNumber(data.SUM_SUB_AMT, { format: "#,###", locale: "us" }));
					}

					tblInv.DataTable( {
						data: rows,
						info: false,
						paging: false,
						searching: false,
						buttons: [],
						columnDefs: [
							{ targets: [0, 21], className: "text-center" },
							{ targets: [12], className: "text-right" },
							{ targets: [13, 14, 15, 16, 17, 18, 19, 20], className: "text-right"
								, render: $.fn.dataTable.render.number( ',', '.', 2)
							},
							{ targets: [22, 23, 24], className: "hiden-input" }
						],
						scrollY: '30vh',
						createdRow: function(row, data, dataIndex){
							if(dataIndex == rows.length - 1){
								$(row).addClass('row-total');

								$('td:eq(0)', row).attr('colspan', 17);
								$('td:eq(0)', row).addClass('text-center');
								for(var i = 1; i <= 16; i++ ){
									$('td:eq('+i+')', row).css('display', 'none');
								}

								this.api().cell($('td:eq(0)', row)).data('TỔNG CỘNG');
							}
						}
					} );

					$('#calculate').button("reset");
				},
				error: function(err){
					tblInv.dataTable().fnClearTable();
					$('#calculate').button("reset");
					$(".toast").remove();
					toastr["error"]( "Có lỗi xảy ra! Vui lòng liên hệ với quản trị viên!" );
					console.log(err);
				}
			});
		}

		function addOrdersInfo(){

			$.each(_lstOrder, function(idx, item) {
				item['PTI_Hour'] = 0;

				item['DMETHOD_CD'] = 'NULL';
				item['CusID'] = $('#cusID').val(); //*
				item['PAYER_TYPE'] = getPayerType( item['CusID'] );

				item['OPERATIONTYPE'] = 'NULL';

				item['PAYMENT_TYPE'] = $('#payment-type').val();
				item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

				delete item["OrderNo"];
			});
		}

		function getPayerType(id){
			if(payers.length == 0 ) return "";
			var py =payers.filter(p=> p.CusID == id);
			if(py.length == 0) return "";
			if(py[0].IsOpr == "1") return "SHP";
			if(py[0].IsAgency == "1") return "SHA";
			if(py[0].IsOwner == "1") return "CNS";
			if(py[0].IsLogis == "1") return "FWD";
			if(py[0].IsTrans == "1") return "TRK";
			if(py[0].IsOther == "1") return "DIF";
			return "";
		}

		//PUBLISH INV
		function publishInv()
		{
			var selectPayer = payers.filter( p => p.CusID == $("#taxcode").val() && p.VAT_CD == $("#cusID").val() );

			if(!selectPayer){
				$("toast").remove();
				toastr["error"]( "Không xác định được đối tượng thanh toán!" );

				if( $('#save').find("i.spinner").length > 0 ){
					$('#save').button("reset");
				}
				return;
			}

			addOrdersInfo();

			var datas = getInvDraftDetail();

			if( datas.length == 0 ){
				toastr["info"]("Vui lòng thực hiện tính cước trước!");
				if( $('#save').find("i.spinner").length > 0 ){
					$('#save').button("reset");
				}
				return;
			}

			var formData = {
				cusTaxCode : $('#taxcode').val(),
				cusAddr : selectPayer.map( x => x.Address )[0],
				cusName : selectPayer.map( x => x.CusName )[0],
				sum_amount : $('#AMOUNT').text(),
				vat_amount : $('#VAT').text(),
				total_amount : $('#TAMOUNT').text(),
				datas : datas
			};

			$.ajax({
				url: "<?=site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if( data.deny ) {
						$("#save").button("reset");
                        toastr["error"](data.deny);
                        return;
                    }

					if(data.error){
						$("#save").button("reset");
						$('.toast').remove();
						toastr["error"]( data.error );
						return;
					}
					saveData(data);
				},
				error: function(err){
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi phát hành hóa đơn! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
					console.log(err);
				}
			});
		}

		//SAVE DATA
		function saveData(invInfo){
			var drDetail = getInvDraftDetail();

			var drTotal = {};

			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});
			
			var publish_opt_checked = $("input[name='publish-opt']:checked").val();
			var formData = {
				'action': 'save',
				'updateOrder': getEirInfoUpdated(),
				'data': {
					'pubType': publish_opt_checked ? publish_opt_checked : "credit",
					'odr': _lstOrder,
					'draft_detail': drDetail,
					'draft_total': drTotal
				}
			};

			if( formData.data.pubType != 'credit' && ( !drDetail || drDetail.length == 0 ) ) {
				$('#payment-modal').find('.modal-content').unblock();
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin tính cước!');
				return;
			}

			if (typeof invInfo !== "undefined" && invInfo !== null)
			{
				formData.data["invInfo"] = invInfo;
			}else{
				//trg hop không phải xuất hóa đơn điện tử -> block popup thanh toán ở đây
				$('#payment-modal').find('.modal-content').blockUI();
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {

					if( data.deny ){
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"]( data.deny );
						return;
					}

					if( data.non_invInfo ){
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"] ( data.non_invInfo );
						return;
					}

					if( data.isDup ){
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"] ( "Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!" );
						return;
					}

					if( data.invInfo ){
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?=site_url(md5('Task') . '/' . md5('payment_success'));?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "invInfo";
						input.value = JSON.stringify(data.invInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					}else if( data.dftInfo ){
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?=site_url(md5('Task') . '/' . md5('draft_success'));?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "dftInfo";
						input.value = JSON.stringify(data.dftInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					}
					else{
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error){
					console.log(xhr);
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi lưu lệnh! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
				}
			});
		}

		//UPDATE DATA ONLY
		function updateData(){
			var formData = {
				"action": "save",
				"act": "updateOnly",
				"updateOrder": getEirInfoUpdated()
			};

			if( formData.updateOrder.length == 0 ){
				$(".toast").remove();
				toastr["warning"]( "Chưa nhập thông tin gia hạn" );
				$("#save").button("reset");
				return;
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					
					$("#save").button("reset");

					if(data.deny){
						toastr["error"](data.deny);
						return;
					}
					
					if( data.message ){
						if(data.message.includes("error")){
							$(".toast").remove();
							toastr["error"]( data.message );
							return;
						}
					}

					var dtTbl = tblContent.DataTable();

					var editRowIndexes = dtTbl.rows(".editing").indexes().toArray();

					$.each( editRowIndexes, function(i, rIdx)
					{
						let newExpDate = dtTbl.cell( rIdx, _colContent.indexOf("NewExpDate") ).data();

						if( newExpDate ){
							dtTbl.cell( rIdx, _colContent.indexOf("ExpDate") ).data( newExpDate.split( " " )[0] + " 23:59:59" );
							dtTbl.cell( rIdx, _colContent.indexOf("NewExpDate") ).data("");
						}

						let newExpPluginDate = dtTbl.cell( rIdx, _colContent.indexOf("NewExpPluginDate") ).data();
						if( newExpPluginDate ){
							dtTbl.cell( rIdx, _colContent.indexOf("ExpDate") ).data( newExpPluginDate.split( " " )[0] + " 23:59:59" );
							dtTbl.cell( rIdx, _colContent.indexOf("NewExpPluginDate") ).data("");
						}
						dtTbl.rows(".editing").nodes().to$().removeClass("editing");

					} );

					toastr["success"]("Cập nhật thành công!");

				},
				error: function(xhr, status, error){
					console.log(xhr);
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi cập nhật thông tin! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
				}
			});
		}

		function getInvDraftDetail(){
			var rows = [];
			$('#tbl-inv').find('tbody tr:not(.row-total)').each(function() {
				var nrows = [];
				var ntds = $(this).find('td:not(.dataTables_empty)');
				if(ntds.length > 0)
				{
					ntds.each(function(td){
						nrows.push($(this).text() == "null" ? "" : $(this).text());
					});
					rows.push(nrows);
				}
			});

			var drd = [];
			if(rows.length == 0 ) return drd;
			$.each(rows, function (idx, item) {
				var temp = {};
				for(var i = 1; i <= _colsPayment.length - 1; i++){
					temp[_colsPayment[i]] = item[i];
				}
				temp['Remark'] = $.unique(_lstOrder.map(p=> p.CntrNo)).toString();
				drd.push(temp);
			});
			return drd;
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>