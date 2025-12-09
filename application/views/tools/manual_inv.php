<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right {
			text-align: right;
		}
	}

	.modal-dialog-mw-py {
		position: fixed;
		top: 20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100% !important;
		display: table-cell;
		vertical-align: middle;
	}

	span.col-form-label {
		width: 100%;
		border-bottom: dotted 1px #ccc;
		display: inline-block;
		word-wrap: break-word;
	}

	.modal-dialog-mw-py .modal-body {
		width: 90% !important;
		margin: auto;
	}

	.vertical-alignment-helper {
		display: table;
	}

	.modal-content {
		/* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
		width: inherit;
		height: inherit;
		/* To center horizontally */
		margin: 0 auto;
	}

	#INV_DRAFT_TOTAL span.col-form-label {
		width: 55%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}

	.nav-link.publish-opt:not(.active) {
		text-decoration: underline;
	}

	.scrollable-menu {
		height: auto;
		max-height: 170px;
		overflow-x: hidden;
	}

	.dropdown-menu.dropdown-menu-column {
		max-height: 40vh;
		overflow-y: auto;
	}

	.dropdown-menu.open {
		max-height: none !important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">TẠO HOÁ ĐƠN TAY</div>
				<div class="button-bar-group mr-3">
					<button id="addnew" class="btn btn-outline-success btn-sm">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="remove" class="btn btn-outline-danger btn-sm">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
					<button id="pay-confirm" class="btn btn-outline-primary btn-sm" data-loading-text="<i class='la la-spinner spinner'></i>Đang xử lý" title="Xác nhận thanh toán">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Xác nhận thanh toán</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-2 pb-2 bg-f9 border-e">
				<div class="row my-box pb-1">
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" id="first-col">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Thông tin chung</h5>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tàu/chuyến *</label>
							<div class="col-sm-5 input-group">
								<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
									<i class="ti-search"></i>
								</span>
							</div>
							<!-- <div class="col-sm-4 input-group input-group-sm pl-0">
								<select id="paymentType" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%" title="Chọn loại thanh toán">
									<option value="CAS">Thu ngay</option>
									<option value="CRE">Thu sau</option>
								</select>
							</div> -->
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label" title="Đối tượng thanh toán">Mã KH/ MST</label>
							<div class="col-sm-5 input-group">
								<input class="form-control form-control-sm input-required" id="taxcode" placeholder="Đang nạp ..." type="text" readonly="">
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
									<i class="ti-search"></i>
								</span>
							</div>
							<input class="hiden-input" id="cusID" readonly>
							<div class="col-sm-4 input-group input-group-sm pl-0">
								<select id="paymentMethod" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%" title="Chọn hình thức thanh toán">
									<option value="CK">Chuyển khoản</option>
									<option value="TM">Tiền mặt</option>
									<option value="TM/CK">Tiền mặt/ Chuyển khoản</option>
									<option value="CK">MB Bank QR Payment</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tên</label>
							<div class="col-sm-9">
								<span class="col-form-label">
									<span id="p-payername" class="pr-3"></span>
								</span>

							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Địa chỉ</label>
							<div class="col-sm-9">
								<span class="col-form-label" id="p-payer-addr" style="font-size: 10px!important;">&nbsp;</span>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 col-form-label" title="Đối tượng thanh toán">Số lệnh</label>
							<div class="col-sm-3 pr-0">
								<input class="form-control form-control-sm" id="ref_no" placeholder="Số lệnh" type="text">
							</div>
							<div class="col-sm-6 input-group">
								<span class="input-group-addon bg-white mobile-hiden" style="padding: 0 .5rem" title="Nhập địa chỉ mail của khách hàng khi xuất hoá đơn điện tử">
									<i class="fa fa-envelope"></i>
								</span>
								<input class="form-control form-control-sm" id="mail" placeholder="Địa chỉ e-mail" type="text">
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 col-form-label" title="Đối tượng thanh toán">Mẫu cước</label>
							<div class="col-sm-3 pr-0">
								<select id="inv-temp-currency" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%">
									<option value="VND" selected="">Cước VNĐ</option>
									<option value="USD">Cước USD</option>
								</select>
							</div>
							<div class="col-sm-6">
								<select id="inv-temp" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
									<option value="" selected="">-- Chọn Mẫu cước --</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="INV_DRAFT_TOTAL">
							<div class="col-sm-12">
								<div class="form-group pb-1">
									<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tổng cước phí</h5>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Thành tiền</label>
									<span class="col-form-label text-right font-bold text-blue" id="AMOUNT">0</span>
									&ensp;
									<div class="currency-unit col-form-label text-right font-bold text-blue">VND</div>
								</div>
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Giảm trừ</label>
									<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT">0</span>
									&ensp;
									<div class="currency-unit col-form-label text-right font-bold text-blue">VND</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Tiền thuế</label>
									<span class="col-form-label text-right font-bold text-blue" id="VAT">0</span>
									&ensp;
									<div class="currency-unit col-form-label text-right font-bold text-blue">VND</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Tổng tiền</label>
									<span class="col-form-label text-right font-bold text-danger" id="TAMOUNT">0</span>
									&ensp;
									<div class="currency-unit col-form-label text-right font-bold text-danger">VND</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-sm-12 publish-type">
								<div class="form-group">
									<h5 class="text-primary" style="border-bottom: 1px solid #eee">Loại phát hành</h5>
								</div>
								<div class="form-group">
									<ul class="nav nav-pills nav-pills-rounded nav-pills-air nav-pills-primary nav-justified pb-1">
										<li class="nav-item ml-1">
											<a class="nav-link active publish-opt" href="#tab-12-1" data-value="dft" data-toggle="tab">Phiếu thu</a>
										</li>
										<li class="nav-item ml-1">
											<a class="nav-link publish-opt" href="#tab-12-2" data-value="m-inv" data-toggle="tab">HĐ giấy</a>
										</li>
										<li class="nav-item ml-1">
											<a class="nav-link publish-opt" href="#tab-12-3" data-value="e-inv" data-toggle="tab">HĐ điện tử</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="form-group hiden-input" id="inv-type-container">
							<div class="form-group pb-1">
								<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tuỳ chỉnh HĐ</h5>
							</div>
							<div class="form-group mb-0">
								<label class="col-form-label" title="Loại hóa đơn">Loại HĐ</label>
								<select id="inv-type" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
									<option value="VND" selected=""> Hóa đơn VND </option>
									<option value="USD"> Hóa đơn USD </option>
								</select>
							</div>
							<div class="form-group mb-0">
								<label class="col-form-label" title="Tỉ giá">Tỉ giá</label>
								<input id="ExchangeRate" class="form-control form-control-sm text-right" value="1" placeholder="Tỉ giá" type="text">
							</div>
							<div id="m-inv-date" class="form-group" style="display:block">
								<label class="col-form-label" title="Ngày Hoá đơn">Ngày HĐ</label>
								<input id="inv-date" class="form-control form-control-sm" placeholder="Ngày HĐ" type="text">
							</div>
							<div class="form-group mb-0">
								<div id="m-inv-container" class="form-group mb-0 hiden-input">
									<label class="col-form-label">Số HĐ kế tiếp</label>
									<div class="col-form-label text-danger font-bold">
										<span id="ss-invNo">
											chưa khai báo
										</span>
										<button id="change-ssinvno" class="btn btn-outline-primary btn-sm" style="height: 20px; width:28px" title="Khai báo/ thay đổi số hóa đơn sử dụng tiếp theo">
											<span class="btn-icon"><i class="fa fa-pencil"></i></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0" style="padding: 10px 12px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden" style="padding: 0 5px">
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
						<thead>
							<tr>
								<th col-name="rowguid">rowguid</th>
								<th col-name="STT">STT</th>
								<th col-name="TRF_CODE">Mã BC</th>
								<th col-name="TRF_DESC">Tên biểu cước</th>
								<th col-name="INV_UNIT" max-length=3>ĐVT</th>
								<th col-name="IX_CD" class="autocomplete">Hướng</th>
								<th col-name="CARGO_TYPE" class="autocomplete">Loại hàng</th>
								<th col-name="SZ" class="autocomplete">SIZE</th>
								<th col-name="FE" class="autocomplete">F/E</th>
								<th col-name="IsLocal">Nội/Ngoại (L/F)</th>
								<th col-name="QTY" class="data-type-numeric" float-nums=<?= json_encode($this->config->item('ROUND_NUM_QTY_UNIT')); ?>>Số Lượng</th>
								<th col-name="standard_rate" class="data-type-numeric">Đơn giá gồm thuế</th>
								<th col-name="UNIT_RATE" class="data-type-numeric" float-nums=4>Đơn giá chưa thuế</th>
								<th col-name="AMOUNT" class="data-type-numeric">Thành tiền</th>
								<th col-name="VAT_RATE" class="data-type-numeric">Thuế (%)</th>
								<th col-name="VAT" class="data-type-numeric">Tiền thuế</th>
								<th col-name="TAMOUNT" class="data-type-numeric">Tổng tiền</th>
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

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="row col-xl-12">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-1">
						<div class="form-group">
							<label class="radio radio-outline-primary" style="padding-right: 15px!important;">
								<input name="shipArrStatus" type="radio" value="1" checked>
								<span class="input-span"></span>
								Đến cảng
							</label>
							<label class="radio radio-outline-primary">
								<input name="shipArrStatus" value="2" type="radio">
								<span class="input-span"></span>
								Rời Cảng
							</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-year" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Nhập tên tàu">
									<img id="btn-search-ship" class="pointer" src="<?= base_url('assets/img/icons/Search.ico'); ?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table id="search-ship" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th>Mã Tàu</th>
								<th style="width: 20px">STT</th>
								<th>Tên Tàu</th>
								<th>Chuyến Nhập</th>
								<th>Chuyến Xuất</th>
								<th>Ngày Cập</th>
								<th>ShipKey</th>
								<th>BerthDate</th>
								<th>ShipYear</th>
								<th>ShipVoy</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="display: flex; flex: 1; justify-content: flex-start; align-items: center;">
					<button type="button" id="reload-ship" class="btn btn-sm btn-warning">
						<i class="fa fa-refresh"></i>
						Tải lại
					</button>
				</div>
				<button type="button" id="select-ship" class="btn btn-sm btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>
			</div>
		</div>
	</div>
</div>

<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" style="z-index: 1055">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 100%">
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
			<div class="modal-footer">
				<button type="button" id="select-payer" class="btn btn-sm btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
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
	var allowConfirmAct = false;
	var modalQrPayment = null;
	$(document).ready(function() {
		var _colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_colsPayment = ["rowguid", "STT", "TRF_CODE", "TRF_DESC", "INV_UNIT", "IX_CD", "CARGO_TYPE", "SZ", "FE", "IsLocal", "QTY", "standard_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT"];

		var _results = [],
			_selectShipKey = '',
			_shipData = [],
			tblInv = $("#tbl-inv"),
			_listCalc = [],
			_listTariff = [],
			_useTplts = [],
			payers = [];

		var _cargoTypes = <?= json_encode($cargoTypes) ?>;
		_cargoTypes.map(x => x.Description = x.Description.toUpperCase());
		var invTemps = <?= json_encode($invTemps); ?>;
		var _ssInvInfo = <?= json_encode(isset($ssInvInfo) ? $ssInvInfo : []); ?>;
		var _isDup = <?= json_encode(isset($isDup) ? $isDup : false); ?>;
		var _roundNums = <?= json_encode($this->config->item('ROUND_NUM')); ?>; //them moi lam tron so
		var _roundNumQty_Unit = <?= json_encode($this->config->item('ROUND_NUM_QTY_UNIT')); ?>; //lam tron so luong+don gia theo yeu cau KT
		var _cntrClass = <?= json_encode($cntrClass) ?>;

		if (_cargoTypes.filter(p => p.Code == '*').length == 0) {
			_cargoTypes.push({
				Code: '*',
				Description: '*'
			});
		}

		if (_cntrClass.filter(p => p.CLASS_Code == '*').length == 0) {
			_cntrClass.push({
				CLASS_Code: '*',
				CLASS_Name: '*'
			});
		}

		var _localForeign = [{
					"Code": "*",
					"Name": "*"
				},
				{
					"Code": "L",
					"Name": "Nội"
				},
				{
					"Code": "F",
					"Name": "Ngoại"
				}
			],
			_status = [{
					"Code": "F",
					"Name": "F"
				},
				{
					"Code": "E",
					"Name": "E"
				}
			],
			_size = [{
					"Code": "*",
					"Name": "*"
				},
				{
					"Code": "20",
					"Name": "20"
				},
				{
					"Code": "40",
					"Name": "40"
				},
				{
					"Code": "45",
					"Name": "45"
				}
			];

		//------define table
		$('#search-ship').DataTable({
			scrollY: '35vh',
			paging: false,
			order: [
				[1, 'asc']
			],
			columnDefs: [{
					className: "input-hidden",
					targets: [0, 6, 7]
				},
				{
					className: "text-center",
					targets: [1]
				}
			],
			buttons: [],
			info: false,
			searching: false
		});

		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: [0]
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colPayer.getIndexs(["CusName", "Address"])
				}
			],
			buttons: [],
			infor: false,
			scrollY: '45vh'
		});

		tblInv.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '33vh',
			columnDefs: [{
					targets: _colsPayment.indexOf("rowguid"),
					className: "hiden-input"
				},
				{
					targets: _colsPayment.getIndexs(["STT"]),
					className: "text-center"
				},
				{
					targets: _colsPayment.getIndexs(["QTY"]),
					className: "text-right",
					render: function(data, type, full, meta) {
						return $.fn.dataTable.render.number(',', '.', _roundNumQty_Unit).display(data); //lam tron so luong+don gia theo yeu cau KT
					}
				},
				{
					targets: _colsPayment.getIndexs(["UNIT_RATE"]),
					className: "text-right",
					render: function(data, type, full, meta) {
						return $.fn.dataTable.render.number(',', '.', 4).display(data); //lam tron so luong+don gia theo yeu cau KT
					}
				},
				{
					targets: _colsPayment.getIndexs(["standard_rate", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT"]),
					className: "text-right",
					render: function(data, type, full, meta) {
						return $.fn.dataTable.render.number(',', '.', _roundNums[$('#inv-temp-currency').val()]).display(data); //them moi lam tron so
					}
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-300'>" + data + "</div>";
					},
					targets: _colsPayment.indexOf("TRF_DESC")
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _status.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown",
					targets: _colsPayment.indexOf('FE')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _size.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown",
					targets: _colsPayment.indexOf('SZ')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _localForeign.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown",
					targets: _colsPayment.indexOf('IsLocal')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _cntrClass.filter(p => p.CLASS_Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].CLASS_Name : '';
					},
					className: "text-center show-dropdown",
					targets: _colsPayment.getIndexs(["IX_CD"])
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _cargoTypes.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Description : '';
					},
					className: "text-center show-dropdown",
					targets: _colsPayment.getIndexs(["CARGO_TYPE"])
				}
			],
			order: [],
			keys: true,
			autoFill: {
				focus: 'focus',
				columns: _colsPayment.getIndexs(["TRF_DESC", "INV_UNIT", "IX_CD", "CARGO_TYPE", "SZ", "FE", "IsLocal", "QTY", "standard_rate", "UNIT_RATE", "VAT_RATE"])
			},
			select: true,
			rowReorder: false
		});

		//------define table

		$("#inv-date").datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true
		});

		//------SEARCH SHIP
		autoLoadYearCombo('cb-searh-year');
		search_ship();
		$('#btn-search-ship').on('click', function() {
			search_ship();
		});

		$(document).on('click', '#search-ship tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#search-ship-name').on('keypress', function(e) {
			if (e.which == 13) {
				search_ship();
			}
		});
		$('#select-ship').on('click', function() {
			var r = $('#search-ship tbody').find('tr.m-row-selected').first();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
		});
		$('#unselect-ship').on('click', function() {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

			$('#ship-modal').modal("toggle");
		});

		$('#reload-ship').on("click", function() {
			$('#search-ship-name').val("");
			search_ship();
		})

		$("#remove-ship-selected").on("click", function() {
			_selectShipKey = "";
			$("#shipid").val("");
		});
		//------END SEARCH SHIP

		load_payer();
		loadInvTemp();
		//------MBBANK QR GATEWAY
		$('#paymentMethod').on('change', function() {
            var methodText = $(this).find("option:selected").text(); 
			if (methodText === 'MB Bank QR Payment') {
				if($('a.publish-opt.active').attr('data-value') === 'e-inv'){
					if($('#cusID').val() == ''){
						toastr.error('Vui lòng chọn đối tượng thanh toán trước khi chọn phương thức thanh toán MB Bank QR Payment!');
						$('#paymentMethod').val('').selectpicker('refresh');
						return;
					}
				$('.ibox.collapsible-box').blockUI();
					saveData([],true)
				}
				else {
					toastr.error('MB Bank QR Payment chỉ áp dụng cho hóa đơn điện tử!');
					$('#paymentMethod').val('').selectpicker('refresh');
				}
			}
        });
		//------SEARCH PAYER
		$(document).on('click', '#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function() {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			fillPayer();
			let paytype = (payers || []).filter(p => p.CusID == $("#cusID").val())[0]?.CusType;
			onChangePaymentType(paytype);

			$('#taxcode').removeClass("error");
		});

		$('#search-payer').on('dblclick', 'tbody tr td', function(e) {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());
			$('#taxcode').removeClass("error");

			fillPayer();
			let paytype = (payers || []).filter(p => p.CusID == $("#cusID").val())[0]?.CusType;
			onChangePaymentType(paytype);

			$('#payer-modal').modal("toggle");
		});
		//------END SEARCH PAYER

		///////// ON PAYMENT MODAL
		$('#ExchangeRate')
			.on('keydown', function(e) {
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
					(e.keyCode >= 35 && e.keyCode <= 40) || e.keyCode >= 112) {
					return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			})
			.on("change", function(e) {
				var tempExc = $(e.target).val();
				if (isNaN(parseFloat(tempExc)) || tempExc == 0) {
					$(e.target).val(1);
				} else {
					var n = $.formatNumber(tempExc, {
						format: "#,###.##",
						locale: "us"
					});
					if (n.substring(0, 1) == '.') {
						n = "0" + n;
					}
					$(e.target).val(n);
				}
				calcTotal();
			});

		///////// ON PAYMEMT MODAL

		$('#addnew').on('click', function() {
			if (!$('#inv-temp').val()) {
				toastr.error('Chưa chọn mẫu cước');
				return;
			}

			$.confirm({
				columnClass: 'col-md-3 col-md-offset-3',
				titleClass: 'font-size-17',
				title: 'Thêm dòng mới',
				content: '<div class="input-group-icon input-group-icon-left">' +
					'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>' +
					'<input autofocus class="form-control form-control-sm" id="num-row" type="number" placeholder="Nhập số dòng" value="1">' +
					'</div>',
				buttons: {
					ok: {
						text: 'Xác nhận',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
							var input = this.$content.find('input#num-row');
							var errorText = this.$content.find('.text-danger');
							if (!input.val().trim()) {
								$.alert({
									title: "Thông báo",
									content: "Vui lòng nhập số dòng!.",
									type: 'red'
								});
								return false;
							} else {
								tblInv.newRows(input.val());
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
		});

		//------USING MANUAL INVOICE

		$("a.publish-opt").on("click", function(e) {
			if ($(e.target).attr('data-value') == $('a.publish-opt.active').attr('data-value')) {
				return;
			}

			if ($(e.target).attr('data-value') == 'dft') {
				$("#inv-type-container").addClass("hiden-input");
				return;
			}

			$("#inv-type-container").removeClass("hiden-input");

			if ($(e.target).attr('data-value') == "m-inv") {
				$("#m-inv-container").removeClass("hiden-input");
				let payType = (payers || []).filter(p => p.CusID == $("#cusID").val())[0]?.CusType;

				if (payType == "C") {
					$("#m-inv-date").removeClass("hiden-input");
				} else {
					$("#m-inv-date").addClass("hiden-input");
				}

				$("#pay-confirm").prop("disabled", _isDup || !_ssInvInfo || Object.keys(_ssInvInfo).length == 0);
			} else {
				$("#m-inv-container, #m-inv-date").addClass("hiden-input");
				$("#pay-confirm").prop("disabled", false);
			}
		});

		$('#change-ssinvno').on('click', function() {
			$('#change-ssinv-modal').modal('show');
		});

		$("#confirm-ssInvInfo").on("click", function() {
			if (!$("#inv-prefix").val()) {
				toastr["error"]("Vui lòng nhập mẫu hóa đơn!");
				return;
			}

			if (!$("#inv-no-from").val()) {
				toastr["error"]("Vui lòng nhập số hóa đơn [Từ số]!");
				return;
			}

			if (!$("#inv-no-to").val()) {
				toastr["error"]("Vui lòng nhập số hóa đơn [Đến số]!");
				return;
			}

			$.confirm({
				columnClass: 'col-md-4 col-md-offset-4 mx-auto',
				titleClass: 'font-size-17',
				title: 'Xác nhận',
				content: 'Xác nhận thông tin khai báo hóa đơn này!?',
				onOpen: function(){
					allowConfirmAct = true;
				},
				buttons: {
					ok: {
						text: 'OK',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
							if( !allowConfirmAct ) return false;

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
								url: "<?= site_url(md5('Tools') . '/' . md5('tlManualInvoice')); ?>",
								dataType: 'json',
								data: formData,
								type: 'POST',
								success: function(data) {

									$("#change-ssinv-modal .modal-content").unblock();

									if (data.deny) {
										toastr["error"](data.deny);
										return;
									}

									var invNo = formData.useInvData.serial + formData.useInvData.invno;

									if (data.isDup) {
										toastr["error"]("Số hóa đơn bắt đầu [" + invNo + "] đã tồn tại trong hệ thống!");
										return;
									}

									$("#change-ssinv-modal").modal('hide');
									toastr["success"]("Xác nhận sử dụng Số HĐ [" + invNo + "] thành công!");
									$("#ss-invNo").text(invNo);
									$("#change-ssinvno").attr("title", "Thay đổi hóa đơn sử dụng tiếp theo")
										.html('<span class="btn-icon"><i class="fa fa-pencil"></i>');

									$("#pay-confirm").prop("disabled", false);
								},
								error: function(err) {
									$("#change-ssinv-modal .modal-content").unblock();
									toastr["error"]("Server Error at [confirm-ssInvInfo]!");
									console.log(err);
								}
							});

							allowConfirmAct = false;
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

		//------EVENTS
		$('#ship-modal, #payer-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});

		$("#search").on("click", function() {
			$(this).button("loading");
			search_cont_total();
		});

		$("#inv-temp-currency").on("change", function() {
			tblInv.dataTable().fnClearTable();
			_useTplts = _listTariff = [];
			loadInvTemp();
		});

		$("#inv-temp").on("change", function(e) {
			if (!$('#inv-temp').val()) {
				toastr["error"]("Chọn mẫu cước!");
				return;
			}
			loadTariffSTD($('#inv-temp').val());
		});

		$("#inv-type").on("change", function(e) {
			$('.currency-unit').text($(this).val());
			calcTotal();
		});

		$("#remove").on("click", function() {
			if (tblInv.DataTable().rows().count() == 0) {
				return;
			}

			if (tblInv.DataTable().rows('.selected').count() == 0) {
				toastr["error"]("Chọn ít nhất 1 dòng dữ liệu để xoá!");
				return;
			}

			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Các dòng dữ liệu được chọn sẽ được xóa?',
				buttons: {
					ok: {
						text: 'Chấp nhận',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function() {
							//remove all row to recalculate
							tblInv.DataTable().rows('.selected').remove().draw();
							tblInv.updateSTT(_colsPayment.indexOf("STT"));
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC']
					}
				}
			});
		});

		tblInv.DataTable().on('autoFill', function(e, datatable, cells) {
			var startRowIndex = cells[0][0].index.row;

			var fillQty = cells[0].filter(p => p.index.column == _colsPayment.indexOf("QTY"));
			var notFirstRow = cells.filter(p => cells.indexOf(p) != 0);
			if (fillQty && fillQty.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var qtyCell = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("QTY")).nodes().to$();
					onChangeQty(qtyCell);
				});
			}

			var fillSZ = cells[0].filter(p => p.index.column == _colsPayment.indexOf("SZ"));
			if (fillSZ && fillSZ.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var szCell = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("SZ")).nodes().to$();
					onChangeSZ_FE(szCell);
				});
			}

			var fillFE = cells[0].filter(p => p.index.column == _colsPayment.indexOf("FE"));
			if (fillFE && fillFE.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var szFE = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("FE")).nodes().to$();
					onChangeSZ_FE(szFE);
				});
			}

			var fillstandardRate = cells[0].filter(p => p.index.column == _colsPayment.indexOf("standard_rate"));
			if (fillstandardRate && fillstandardRate.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var szstandardRate = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("standard_rate")).nodes().to$();
					onChangeStandardRate(szstandardRate);
				});
			}

			var fillunitRate = cells[0].filter(p => p.index.column == _colsPayment.indexOf("UNIT_RATE"));
			if (fillunitRate && fillunitRate.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var stdCell = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("UNIT_RATE")).nodes().to$();
					onChangeUnitRate(stdCell);
				});
			}

			var fillvatRate = cells[0].filter(p => p.index.column == _colsPayment.indexOf("VAT_RATE"));
			if (fillunitRate && fillunitRate.length > 0) {
				$.each(notFirstRow, function(idx, item) {
					var vatRateCell = tblInv.DataTable().cell(item[0].index.row, _colsPayment.indexOf("VAT_RATE")).nodes().to$();
					onChangeVatRate(vatRateCell);
				});
			}
		});

		var unitRateChanged = false;
		tblInv.on('change', 'td', function(e) {
			var colidx = $(this).index();

			if (colidx == _colsPayment.indexOf("SZ")) {
				onChangeSZ_FE($(e.target))
			}

			if (colidx == _colsPayment.indexOf("FE")) {
				onChangeSZ_FE($(e.target))
			}

			if (colidx == _colsPayment.indexOf("standard_rate")) {
				onChangeStandardRate($(e.target));
			}

			if (colidx == _colsPayment.indexOf("UNIT_RATE")) {
				onChangeUnitRate($(e.target));
			}

			if (colidx == _colsPayment.indexOf("QTY")) {
				onChangeQty($(e.target));
			}

			if (colidx == _colsPayment.indexOf("VAT_RATE")) {
				onChangeVatRate($(e.target));
			}

			if (colidx == _colsPayment.indexOf("AMOUNT") || colidx == _colsPayment.indexOf("TAMOUNT")) {
				calcTotal();
			}
		})

		$('#pay-confirm').on('click', function() {
			if (!$("#cusID").val()) {
				toastr["error"]("Chọn đối tượng thanh toán");
				$("#taxcode").addClass("error");
				return;
			}

			if (tblInv.DataTable().rows().count() == 0) {
				$('.toast').remove();
				toastr['warning']('Chưa có chi tiết cước!');
				return;
			}

			if (tblInv.DataTable().column(_colsPayment.indexOf("TAMOUNT"))
				.data().toArray()
				.filter(p => parseFloat(p) == 0).length > 0) {
				$('.toast').remove();
				toastr['warning']('Chưa nhập đủ chi tiết cước!');
				return;
			}

			if (!$('#paymentMethod').val()) {
				toastr.error('Chưa chọn hình thức thanh toán!');
				$("#paymentMethod").addClass("error");
				return;
			}

			let payType = payers.filter(p => p.CusID == $("#cusID").val())[0]?.CusType;
			if( !payType ){
				toastr["error"]("Vui lòng chọn lại đối tượng thanh toán");
				$("#taxcode, #cusID").val('');
				$("#taxcode").addClass("error");
				return;
			}
			
			if ($('a.publish-opt.active').attr('data-value') == 'm-inv' && payType == 'C') { // khong cho xuat hd giay thu sau 
				if (!$('#inv-date').val()) {
					toastr.error('Chưa chọn ngày phát hành!');
					$("#inv-date").addClass("error");
					return;
				}
			}

			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Xác nhận phát hành [' + $('a.publish-opt.active').text().toUpperCase() + ']',
				onOpen: function(){
					allowConfirmAct = true;
				},
				buttons: {
					ok: {
						text: 'Tiếp tục',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function() {
							if( !allowConfirmAct ) return false;

							$('#pay-confirm').button("loading");
							$('.ibox.collapsible-box').blockUI();
							if ($('a.publish-opt.active').attr('data-value') == "e-inv") {
								publishInv();
							} else {
								saveData();
							}

							allowConfirmAct = false;
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC']
					}
				}
			});
		});
		//------EVENTS

		//------FUNCTIONS

		function onChangePaymentType(type) {
			var pubType = $('a.publish-opt.active').attr('data-value');
			if (type == 'C') {
				$('#ref_no').val('').prop('readonly', true);

				if (pubType == "m-inv") {
					$('#m-inv-date').removeClass('hiden-input');
				} else {
					$('#m-inv-date').addClass('hiden-input');
				}
			} else {
				$('#ref_no').prop('readonly', false);
				$('#m-inv-date').addClass('hiden-input');
			}

			if (_ssInvInfo && Object.keys(_ssInvInfo).length > 0) {
				var invText = _ssInvInfo['serial'] + ("0000000" + _ssInvInfo['invno']).slice(-7);
				if (_isDup) {
					invText += " [BỊ TRÙNG]";
				}

				$('#ss-invNo').text(invText);
				$('#change-ssinvno').attr('title', 'Thay đổi số hóa đơn sử dụng tiếp theo');
			} else {
				$('#ss-invNo').text('chưa khai báo');
				$('#change-ssinvno').attr('title', 'Khai báo số hóa đơn sử dụng tiếp theo');
			}

			$("#pay-confirm").prop("disabled", pubType == "m-inv" && (_isDup || !_ssInvInfo || Object.keys(_ssInvInfo).length == 0));
		}

		function onChangeSZ_FE(cell) {
			var dtTbl = tblInv.DataTable();
			var rowIdx = dtTbl.cell(cell).index().row;
			var rowguid = dtTbl.cell(rowIdx, _colsPayment.indexOf("rowguid")).data();
			var sz = dtTbl.cell(rowIdx, _colsPayment.indexOf("SZ")).data();
			var fe = dtTbl.cell(rowIdx, _colsPayment.indexOf("FE")).data();
			var qty = dtTbl.cell(rowIdx, _colsPayment.indexOf("QTY")).data();

			var tempTRF = _listTariff.filter(p => p.rowguid == rowguid)[0];

			var colForUnitPrice = sz == "*" ? "AMT_NCNTR" : "AMT_" + fe + sz;
			//giá theo biểu cước
			var tempPrice = tempTRF ? parseFloat(tempTRF[colForUnitPrice]) : undefined;

			if (isNaN(tempPrice) || !fe) {
				dtTbl.cell(rowIdx, _colsPayment.indexOf("standard_rate")).data(0);
				dtTbl.cell(rowIdx, _colsPayment.indexOf("UNIT_RATE")).data(0);
				dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(0);
				dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(0);
				dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(0);

				//thay đổi đơn giá theo biểu cước -> đánh dấu "thay đổi đơn giá" = false;
				unitRateChanged = false;
				calcTotal();
				return;
			}

			//đơn giá
			var unitPriceIncludeVat = tempPrice / ((parseFloat(tempTRF['VAT'] || 0) / 100) + 1);
			var unitPrice = tempTRF['INCLUDE_VAT'] == "1" ? unitPriceIncludeVat : tempPrice;

			//đơn giá gồm thuế
			var standard_rate = tempTRF['INCLUDE_VAT'] == "1" ? tempPrice : unitPriceIncludeVat;

			var roundNum = _roundNums[$('#inv-type').val()];
			//thành tiền
			var amt = parseFloat(qty) * (tempTRF['INCLUDE_VAT'] == "1" ? unitPriceIncludeVat : tempPrice);
			amt = parseFloat(amt.toFixed(roundNum));

			//tiền thuê
			var vatAM = amt * (tempTRF['VAT'] / 100);
			vatAM = parseFloat(vatAM.toFixed(roundNum));

			//tổng tiền
			var tAmount = amt + vatAM;

			dtTbl.cell(rowIdx, _colsPayment.indexOf("standard_rate")).data(standard_rate);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("UNIT_RATE")).data(unitPrice);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(vatAM);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(tAmount);

			//thay đổi đơn giá theo biểu cước -> đánh dấu "thay đổi đơn giá" = false;
			unitRateChanged = false;
			calcTotal();
		}

		function onChangeQty(cell) {
			var dtTbl = tblInv.DataTable();
			var rowIdx = dtTbl.cell(cell).index().row;
			var qty = dtTbl.cell(rowIdx, _colsPayment.indexOf("QTY")).data();
			var vat_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT_RATE")).data() || 0;
			var standard_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("standard_rate")).data();
			var roundNum = _roundNums[$('#inv-type').val()];

			//thành tiền
			var unitRate = parseFloat(standard_rate) / ((parseFloat(vat_rate) / 100) + 1);
			var amt = parseFloat(qty * unitRate);
			var last_amt = parseFloat(amt.toFixed(roundNum));

			if (!unitRateChanged) {
				var rowguid = dtTbl.cell(rowIdx, _colsPayment.indexOf("rowguid")).data();
				var sz = dtTbl.cell(rowIdx, _colsPayment.indexOf("SZ")).data();
				var fe = dtTbl.cell(rowIdx, _colsPayment.indexOf("FE")).data();
				var tempTRF = _listTariff.filter(p => p.rowguid == rowguid)[0];

				var colForUnitPrice = sz == "*" ? "AMT_NCNTR" : "AMT_" + fe + sz;
				//giá theo biểu cước
				var tempPrice = tempTRF ? parseFloat(tempTRF[colForUnitPrice]) : undefined;

				if (isNaN(tempPrice)) {
					dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(0);
					dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(0);
					dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(0);

					calcTotal();
					return;
				}

				//đơn giá có thuế
				var unitPriceIncludeVat = tempPrice / ((parseFloat(tempTRF['VAT']) / 100) + 1);

				//thành tiền
				amt = parseFloat(qty) * (tempTRF['INCLUDE_VAT'] == "1" ? unitPriceIncludeVat : tempPrice);
				last_amt = parseFloat(amt.toFixed(roundNum));
			}

			//tiền thuế
			var vat_amt = (parseFloat(vat_rate) / 100) * amt;
			var last_vat_amt = parseFloat(vat_amt.toFixed(roundNum));

			//tổng tiền
			var tamount = last_amt + last_vat_amt;

			dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(last_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(last_vat_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(tamount);

			calcTotal();
		}

		function onChangeVatRate(cell) {
			var dtTbl = tblInv.DataTable();
			var rowIdx = dtTbl.cell(cell).index().row;
			var unitRate = dtTbl.cell(rowIdx, _colsPayment.indexOf("UNIT_RATE")).data();
			var qty = dtTbl.cell(rowIdx, _colsPayment.indexOf("QTY")).data();
			var amt = dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data();
			var vat_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT_RATE")).data() || 0;
			var roundNum = _roundNums[$('#inv-type').val()];

			//tiền thuế
			var vat_amt = (parseFloat(vat_rate) / 100) * parseFloat(amt);
			var last_vat_amt = parseFloat(vat_amt.toFixed(roundNum));

			//tổng tiền
			var tamount = parseFloat(amt) + last_vat_amt;

			dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(last_vat_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(tamount);

			calcTotal();
		}

		function onChangeUnitRate(cell) {
			var dtTbl = tblInv.DataTable();
			var rowIdx = dtTbl.cell(cell).index().row;
			var unitRate = dtTbl.cell(rowIdx, _colsPayment.indexOf("UNIT_RATE")).data();
			var qty = dtTbl.cell(rowIdx, _colsPayment.indexOf("QTY")).data();
			var vat_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT_RATE")).data() || 0;
			var roundNum = _roundNums[$('#inv-type').val()];

			//thành tiền gồm thuế
			var amtIncludeVat = parseFloat(unitRate) * ((parseFloat(vat_rate) / 100) + 1);
			var last_amtIncludeVat = amtIncludeVat;

			//thành tiền
			var amt = parseFloat(qty) * parseFloat(unitRate);
			var last_amt = parseFloat(amt.toFixed(roundNum));

			//tiền thuế
			var vat_amt = (parseFloat(vat_rate) / 100) * amt;
			var last_vat_amt = parseFloat(vat_amt.toFixed(roundNum));

			//tổng tiền
			var tamount = last_amt + last_vat_amt;

			dtTbl.cell(rowIdx, _colsPayment.indexOf("standard_rate")).data(last_amtIncludeVat);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(last_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(last_vat_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(tamount);

			//user thay đổi đơn giá trên lưới -> đanh dấu "Thany đổi đơn gía" = true
			unitRateChanged = true;
			calcTotal();
		}

		function onChangeStandardRate(cell) {
			var dtTbl = tblInv.DataTable();
			var rowIdx = dtTbl.cell(cell).index().row;
			var standard_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("standard_rate")).data();
			var qty = dtTbl.cell(rowIdx, _colsPayment.indexOf("QTY")).data();
			var vat_rate = dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT_RATE")).data() || 0;
			var roundNum = _roundNums[$('#inv-type').val()];

			//thành tiền chưa thuế
			var amtExcludeVat = parseFloat(standard_rate) / ((parseFloat(vat_rate) / 100) + 1);
			var last_amtExcludeVat = amtExcludeVat;

			//thành tiền
			var amt = parseFloat(qty) * (parseFloat(standard_rate) / ((parseFloat(vat_rate) / 100) + 1));
			var last_amt = parseFloat(amt.toFixed(roundNum));

			//tiền thuế
			var vat_amt = (parseFloat(vat_rate) / 100) * amt;
			var last_vat_amt = parseFloat(vat_amt.toFixed(roundNum));

			//tổng tiền
			var tamount = last_amt + last_vat_amt;

			dtTbl.cell(rowIdx, _colsPayment.indexOf("UNIT_RATE")).data(last_amtExcludeVat);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("AMOUNT")).data(last_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("VAT")).data(last_vat_amt);
			dtTbl.cell(rowIdx, _colsPayment.indexOf("TAMOUNT")).data(tamount);

			//user thay đổi đơn giá trên lưới -> đanh dấu "Thany đổi đơn gía" = true
			unitRateChanged = true;
			calcTotal();
		}

		function calcTotal() {
			var formatNum = '#,###'; //them moi lam tron so
			var roundNum = _roundNums[$('#inv-type').val()];
			if (roundNum > 0) {
				formatNum += "." + ("0000000000".slice(-roundNum));
			}

			var exchange_rate = parseFloat($('#ExchangeRate').val().replace(',', ''));
			//ko quy doi khi 2 loai hoa don giong nhau
			if ($('#inv-temp-currency').val() == $('#inv-type').val()) {
				exchange_rate = 1;
			}

			var amount = tblInv.DataTable()
				.column(_colsPayment.indexOf("AMOUNT"), {
					page: 'current'
				})
				.data()
				.reduce(function(a, b) {
					return parseFloat(a) + parseFloat(b);
				}, 0);
			var totalVAT = tblInv.DataTable()
				.column(_colsPayment.indexOf("VAT"), {
					page: 'current'
				})
				.data()
				.reduce(function(a, b) {
					return parseFloat(a || 0) + parseFloat(b || 0);
				}, 0);

			amount = parseFloat((amount * exchange_rate).toFixed(roundNum));
			totalVAT = parseFloat((totalVAT * exchange_rate).toFixed(roundNum));
			totalAmount = amount + totalVAT;

			$('#AMOUNT').text(amount == 0 ? '0' : $.formatNumber(amount, {
				format: formatNum,
				locale: "us"
			}));
			$('#VAT').text(totalVAT == 0 ? '0' : $.formatNumber(totalVAT, {
				format: formatNum,
				locale: "us"
			}));
			$('#TAMOUNT').text(totalAmount == 0 ? '0' : $.formatNumber(totalAmount, {
				format: formatNum,
				locale: "us"
			}));

			return {
				AMOUNT: amount,
				VAT: totalVAT,
				TAMOUNT: totalAmount,
				DIS_AMT: 0
			};
		}

		function loadTariffSTD(inv_temp) {

			var formdata = {
				'action': 'view',
				'act': 'load_tariff',
				'invTemp': inv_temp
			};

			_useTplts = _useTplts.concat(inv_temp);

			$(".row.ibox-footer").blockUI();
			$('#inv-temp').parent().blockUI();

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlManualInvoice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					$(".row.ibox-footer").unblock();
					$('#inv-temp').parent().unblock();
					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.no_payer) {
						$(".toast").remove();
						toastr["error"](data.no_payer);

						tblInv.dataTable().fnClearTable();
						return;
					}

					var rows = [];
					if (data.results && data.results.length > 0) {
						_listTariff = _listTariff.concat(data.results);
						var lst = data.results;
						var stt = tblInv.DataTable().rows().count() + 1;
						for (i = 0; i < lst.length; i++) {
							var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
							var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ? "Nội" : "");
							rows.push([
								lst[i].rowguid, (stt++), lst[i].TRF_CODE, lst[i].TRF_STD_DESC, lst[i].INV_UNIT, lst[i].IX_CD, lst[i].CARGO_TYPE, '' //iso size
								, '' //FULL - EMPTY
								, lst[i].IsLocal, 0 //lst[i].Quantity
								, 0 //lst[i].StandardTariff
								, 0 //lst[i].Unit_rate
								, 0 //lst[i].Amount
								, lst[i].VAT ? parseFloat(lst[i].VAT) : '', 0 //lst[i].VATAmount
								, 0 //lst[i].SubAmount
							]);
						}
					}

					// tblInv.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblInv.dataTable().fnAddData(rows);
					}

					extendSelectOnGrid();
				},
				error: function(err) {
					$(".toast").remove();
					toastr["error"]("ERROR!");
					$(".row.ibox-footer").unblock();
					$('#inv-temp').parent().unblock();
					tblInv.dataTable().fnClearTable();

					console.log(err);
				}
			});
		}

		function loadInvTemp() {
			var currency = $("#inv-temp-currency").val();
			var html = '<option value="" selected="">-- Chọn Mẫu cước --</option>';
			$.each(invTemps.filter(p => p.CURRENCYID == currency), function(i, v) {
				html += '<option data="' + currency + '" value="' + v.TPLT_NM + '">' + v.TPLT_NM + ' : ' + v.TPLT_DESC + '</option>';
			});

			$("#inv-temp").html(html).selectpicker("refresh");
			$('#inv-type').val(currency).selectpicker('refresh').trigger('change');
			$('#AMOUNT, #VAT, #TAMOUNT').text('0');
		}

		function extendSelectOnGrid() {
			//------SET AUTOCOMPLETE
			var tblHeader = tblInv.parent().prev().find('table');
			tblHeader.find(' th:eq(' + _colsPayment.indexOf('IX_CD') + ') ').setSelectSource(_cntrClass.map(p => p.CLASS_Name));
			tblHeader.find(' th:eq(' + _colsPayment.indexOf('FE') + ') ').setSelectSource(_status.map(p => p.Name));
			tblHeader.find(' th:eq(' + _colsPayment.indexOf('CARGO_TYPE') + ') ').setSelectSource(_cargoTypes.map(p => p.Description));
			tblHeader.find(' th:eq(' + _colsPayment.indexOf('IsLocal') + ') ').setSelectSource(_localForeign.map(p => p.Name));
			tblHeader.find(' th:eq(' + _colsPayment.indexOf('SZ') + ') ').setSelectSource(_size.map(p => p.Name));
			//------SET AUTOCOMPLETE

			//------SET DROPDOWN BUTTON FOR COLUMN
			tblInv.columnDropdownButton({
				data: [{
						colIndex: _colsPayment.indexOf("IX_CD"),
						source: _cntrClass
					}, {
						colIndex: _colsPayment.indexOf("IsLocal"),
						source: _localForeign
					},
					{
						colIndex: _colsPayment.indexOf("FE"),
						source: _status
					},
					{
						colIndex: _colsPayment.indexOf("CARGO_TYPE"),
						source: _cargoTypes
					},
					{
						colIndex: _colsPayment.indexOf("SZ"),
						source: _size
					}
				],
				onSelected: function(cell, itemSelected) {
					tblInv.DataTable().cell(cell).data(itemSelected.attr('code')).draw(false);
					tblInv.DataTable().cell(cell.parent().index(), cell.next()).focus();

					if (cell.index() == _colsPayment.indexOf("SZ")) {
						onChangeSZ_FE(cell);
					}

					if (cell.index() == _colsPayment.indexOf("FE")) {
						onChangeSZ_FE(cell);
					}
				}
			});
			//------SET DROPDOWN BUTTON FOR COLUMN

			tblInv.editableTableWidget();
		}

		function publishInv() {
			let datas = getInvDraftDetail();
			if (datas.length == 0) {
				$.alert({
					title: "Thông báo",
					content: "Không thể xử lý (thiếu thông tin chi tiết hoá đơn)!",
					type: 'red'
				});
				return;
			}

			datas.map(p => p["CURRENCYID"] = $("#inv-temp option:checked").attr("data") ? $("#inv-temp option:checked").attr("data") : "VND");

			let paytype = payers.filter(p => p.CusID == $("#cusID").val())[0].CusType;
			let drTotal = calcTotal();
			let formData = {
				cusTaxCode: $('#taxcode').val(),
				cusAddr: $('#p-payer-addr').text(),
				cusName: $('#p-payername').text(),
				sum_amount: drTotal.AMOUNT,
				vat_amount: drTotal.VAT,
				total_amount: drTotal.TAMOUNT,
				inv_type: $("#inv-type").val(),
				exchange_rate: $("#ExchangeRate").val(),
				isCredit: paytype == 'C' ? '1' : '0',
				paymentMethod: $("#paymentMethod").val(),
				shipInfo: $('#shipid').val(),
				datas: datas
			};

			$.ajax({
				url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.error) {
						$('#pay-confirm').button("reset");
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					saveData(data);
				},
				error: function(err) {
					$('.ibox.collapsible-box').unblock();
					$('#pay-confirm').button("reset");
					console.log(err);
				}
			});
		}
		function publishInvForQr(EirNoDraft) {
			let datas = getInvDraftDetail();
			if (datas.length == 0) {
				$.alert({
					title: "Thông báo",
					content: "Không thể xử lý (thiếu thông tin chi tiết hoá đơn)!",
					type: 'red'
				});
				return;
			}

			datas.map(p => p["CURRENCYID"] = $("#inv-temp option:checked").attr("data") ? $("#inv-temp option:checked").attr("data") : "VND");

			let paytype = payers.filter(p => p.CusID == $("#cusID").val())[0].CusType;
			let drTotal = calcTotal();
			let formData = {
				cusTaxCode: $('#taxcode').val(),
				cusAddr: $('#p-payer-addr').text(),
				cusName: $('#p-payername').text(),
				sum_amount: drTotal.AMOUNT,
				vat_amount: drTotal.VAT,
				total_amount: drTotal.TAMOUNT,
				inv_type: $("#inv-type").val(),
				exchange_rate: $("#ExchangeRate").val(),
				isCredit: paytype == 'C' ? '1' : '0',
				paymentMethod: $("#paymentMethod").val(),
				shipInfo: $('#shipid').val(),
				datas: datas
			};

			$.ajax({
				url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.error) {
						$('#pay-confirm').button("reset");
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}
					saveData(data, false, 'save_qr_payment', EirNoDraft);
				},
				error: function(err) {
					$('.ibox.collapsible-box').unblock();
					$('#pay-confirm').button("reset");
					console.log(err);
				}
			});
		}
		function saveData(invInfo, draft = false, action = null, EirNoDraft) {
			var drDetail = getInvDraftDetail();

			if (drDetail.length == 0) {
				$('.ibox.collapsible-box').unblock();
				$('#paymentMethod').val('').selectpicker('refresh');
				$.alert({
					title: "Thông báo",
					content: "Không thể xử lý (thiếu thông tin chi tiết hoá đơn)!",
					type: 'red'
				});
				return;
			}

			var drTotal = calcTotal();

			if (_selectShipKey) {
				drTotal['ShipKey'] = _selectShipKey;
				var selectedShip = _shipData.filter(p => p.ShipKey == _selectShipKey);
				if (selectedShip.length > 0) {
					drTotal['ShipID'] = selectedShip[0].ShipID;
					drTotal['ShipVoy'] = selectedShip[0].ShipVoy;
					drTotal['ShipYear'] = selectedShip[0].ShipYear;
				}
			}

			drTotal["PAYER_TYPE"] = getPayerType($("#cusID").val());
			drTotal["CusID"] = $("#cusID").val();
			drTotal["PAYMENT_TYPE"] = payers.filter(p => p.CusID == $("#cusID").val())[0].CusType;
			drTotal["ACC_CD"] = $('#paymentMethod').val();
			drTotal["TPLT_NM"] = JSON.stringify(_useTplts);
			drTotal["CURRENCYID"] = $('#inv-type').val();
			drTotal["RATE"] = $("#ExchangeRate").val() ? $("#ExchangeRate").val() : 1;
			drTotal["REF_NO"] = $("#ref_no").val();
			drTotal["INV_DATE"] = $('#inv-date').val();
			drTotal["Mail"] = $("#mail").val();

			var formData = {
				'action': draft ? 'save_draft' : 'save',
				'mailTo': $("#mail").val(),
				'args': {
					'pubType': $('a.publish-opt.active').attr('data-value'),
					'draft_detail': drDetail,
					'draft_total': draft ? [drTotal] : drTotal
				}
			};

			if (typeof invInfo !== "undefined" && invInfo !== null) {
				formData.args["invInfo"] = invInfo;
			}
			if(action !== null) {
				formData['act'] = action;
				formData['draftNo'] = EirNoDraft ?? null;
				formData["invInfo"] = invInfo;
				delete formData.args;
			}
			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlManualInvoice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if(data && data.DraftNoInDB && data.DraftNoInDB.Status && data.DraftNoInDB.DraftNo) {
						return handleClickPayQrMb(data.DraftNoInDB.DraftNo)
					}
					$('.ibox.collapsible-box').unblock();
					if (data.deny) {
						$('#pay-confirm').button("reset");
						toastr["error"](data.deny);
						return;
					}

					if (data.non_invInfo) {
						$('#pay-confirm').button("reset");
						toastr["error"](data.non_invInfo);
						return;
					}

					if (data.isDup) {
						$('#pay-confirm').button("reset");
						toastr["error"]("Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!");
						return;
					}

					if (data.invInfo) {
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?= site_url(md5('Task') . '/' . md5('payment_success')); ?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "invInfo";
						input.value = JSON.stringify(data.invInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					} else if (data.dftInfo) {
						$.confirm({
							columnClass: 'col-md-5 col-md-offset-5',
							titleClass: 'font-size-17',
							type: 'green',
							typeAnimated: true,
							title: 'XUẤT PHIẾU THU THÀNH CÔNG',
							content: '<div style="color:red; font-size:30px">' +
								data.dftInfo.DRAFT_NO +
								'</div>',
							buttons: {
								ok: {
									text: 'Tiếp tục',
									btnClass: 'btn-sm btn-primary btn-confirm',
									keys: ['Enter'],
									action: function() {
										location.reload(true);
									}
								},
								print: {
									text: 'IN PHIẾU',
									btnClass: 'btn-sm btn-default btn-confirm',
									keys: ['Enter'],
									action: function() {
										printDraft(data.dftInfo.DRAFT_NO);
										return false;
									}
								}
							}
						});
					} else {
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error) {
					$('.ibox.collapsible-box').unblock();
					console.log(xhr);
					$('.toast').remove();
					$('#pay-confirm').button("reset");
					toastr['error']("Server Error at [saveData]");
				}
			});
		}
		function handleClickPayQrMb(EirNo) {
                    const totalAmount = $('#TAMOUNT').text() || '0';
                    const numericAmount = totalAmount.replace(/[^\d]/g, '');
                    const amount = parseInt(numericAmount);
                    const customerName = $('#p-payername').text() || 'Customer';
                    const customerTaxCode = $('#p-taxcode').text() || '';
                    // Ensure base_url has trailing slash for proper URL construction
                    let baseUrl = '<?= site_url() ?>';
                    if (!baseUrl.endsWith('/')) {
                        baseUrl += '/';
                    }
                    // Construct URL with parameters
                    const paymentUrl = baseUrl + 'd171035a85cc2258e37d64e18505d78c/106a6c241b8797f52e1e77317b96a201?' +
                        '&amount=' + encodeURIComponent(amount) +
                        '&cusId=' + encodeURIComponent(customerTaxCode) +
                        '&EirNo=' + encodeURIComponent(EirNo) +
                        '&customer_name=' + encodeURIComponent(customerName);
                    // Open in new window/tab
                    modalQrPayment = window.open(paymentUrl, '_blank', 'width=700,height=900,scrollbars=yes,resizable=yes');
                    window.onPaymentSuccess = function(data) {
                        if (data.EirNo) {
							modalQrPayment.close();
							if ($('a.publish-opt.active').attr('data-value') == "e-inv") {
								toastr["success"]("Tiến hành xuất hóa đơn <br> Vui lòng không thao tác !");
								publishInvForQr(data.EirNo);
							}
                        }
                        else {
                            toastr["error"]("Không tìm thấy thông tin!");
                        }
                    };
                    //handle tab close
                    window.onPaymentClosed = function () {
                        $('.ibox.collapsible-box').unblock();
						$('#paymentMethod').val('').selectpicker('refresh');
                    };
                     // Đóng tab con khi tab cha đóng hoặc reload
                    window.addEventListener('beforeunload', () => {
                        if (modalQrPayment && !modalQrPayment.closed) {
                            modalQrPayment.close();
                        }
                    });
        }
		function getInvDraftDetail() {
			var rows = tblInv.getChangedData([], '');

			if (rows.length == 0) {
				return [];
			}

			var draftdetail = [];
			var exchange_rate = parseFloat($('#ExchangeRate').val().replace(',', ''));
			//ko quy doi khi 2 loai hoa don giong nhau
			if ($('#inv-temp-currency').val() == $('#inv-type').val()) {
				exchange_rate = 1;
			}

			var roundNum = _roundNums[$('#inv-type').val()];
			rows.map(p => delete p.STT);

			$.each(rows, function(index, item) {
				if (_cargoTypes.filter(p => p.Code == item.CARGO_TYPE).length == 0 && item.CARGO_TYPE && item.CARGO_TYPE != '*') {
					item.CARGO_TYPE = _cargoTypes.filter(p => p.Description.toUpperCase() == item.CARGO_TYPE.toUpperCase())
						.map(x => x.Code)[0];
				}

				if (exchange_rate > 1) {
					item.standard_rate = parseFloat((item.standard_rate * exchange_rate).toFixed(roundNum));
					item.UNIT_RATE = parseFloat((item.UNIT_RATE * exchange_rate).toFixed(roundNum));
					item.AMOUNT = parseFloat((item.AMOUNT * exchange_rate).toFixed(roundNum));
					item.VAT = parseFloat((item.VAT * exchange_rate).toFixed(roundNum));
					item.TAMOUNT = parseFloat((item.VAT * exchange_rate).toFixed(roundNum));
				}
			});
			return rows;
		}

		function search_ship() {
			var tblSearchShip = $("#search-ship");

			tblSearchShip.dataTable().fnClearTable();
			tblSearchShip.waitingLoad();

			_shipData = [];
			var formdata = {
				'action': 'view',
				'act': 'search_ship',
				'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
				'shipyear': $('#cb-searh-year').val(),
				'shipname': $('#search-ship-name').val()
			};

			$.ajax({
				url: "<?= site_url(md5('Credit') . '/' . md5('creContLiftTotal')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					var rows = [];
					if (data.vsls.length > 0) {
						_shipData = data.vsls;
						for (i = 0; i < data.vsls.length; i++) {
							rows.push([
								data.vsls[i].ShipID, (i + 1), data.vsls[i].ShipName, data.vsls[i].ImVoy, data.vsls[i].ExVoy, getDateTime(data.vsls[i].ETB), data.vsls[i].ShipKey, getDateTime(data.vsls[i].BerthDate), data.vsls[i].ShipYear, data.vsls[i].ShipVoy
							]);
						}
					}

					tblSearchShip.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblSearchShip.dataTable().fnAddData(rows);
					}
				},
				error: function(err) {
					tblSearchShip.dataTable().fnClearTable();
					console.log(err);
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				}
			});
		}

		function load_payer() {
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();
			payers = [];
			$.ajax({
				url: "<?= site_url(md5('Credit') . '/' . md5('creContLiftTotal')); ?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function(data) {
					var rows = [];

					if (data.payers && data.payers.length > 0) {
						payers = data.payers;

						var i = 0;
						$.each(payers, function(index, rData) {
							var r = [];
							$.each(_colPayer, function(idx, colname) {
								var val = "";
								switch (colname) {
									case "STT":
										val = i + 1;
										break;
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
					if (rows.length > 0) {
						tblPayer.dataTable().fnAddData(rows);
					}

					$("#taxcode").prop("readonly", false);
					$("#taxcode").prop("placeholder", "ĐT thanh toán");
				},
				error: function(err) {
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Server Error at [load_payer]!");
				}
			});
		};

		function fillPayer() {
			var py = $("#cusID").val() ? payers.filter(p => p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val()) :
				payers.filter(p => p.VAT_CD == $('#taxcode').val());

			if (py.length > 0) { //fa-check-square
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);

				if (py[0].Email) {
					$("#mail").val(py[0].Email);
				}
				if (py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email) {
					$("#mail").val($("#mail").val() + ',' + py[0].EMAIL_DD);
				}

				$("#taxcode").removeClass("error");

				// if( py[0].CusType == "M" ){
				// 	$("#dv-cash").removeClass("hiden-input");
				// 	$("#dv-credit").addClass("hiden-input");
				// 	//
				// 	$(".publish-type").removeClass("hiden-input");

				// 	if( !$("input[name='publish-opt']").is(":checked") ){
				// 		$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
				// 		$("#m-inv-container").addClass("hiden-input");
				// 	}

				// }
				// else{
				// 	$("#dv-cash").addClass("hiden-input");
				// 	$("#dv-credit").removeClass("hiden-input");
				// 	//
				// 	$(".publish-type").addClass("hiden-input");
				// 	$("input[name='publish-opt']").prop("checked", false);
				// }
			}

			return py.length > 0;
		}

		function getPayerType(id) {
			if (payers.length == 0) return "";
			var py = payers.filter(p => p.CusID == id);
			if (py.length == 0) return "";
			if (py[0].IsOpr == "1") return "SHP";
			if (py[0].IsAgency == "1") return "SHA";
			if (py[0].IsOwner == "1") return "CNS";
			if (py[0].IsLogis == "1") return "FWD";
			if (py[0].IsTrans == "1") return "TRK";
			if (py[0].IsOther == "1") return "DIF";
			return "";
		}

		function printDraft(draftNo) {
			var form = document.createElement("form");
			form.setAttribute("method", "post");
			form.setAttribute("target", "_blank");
			form.setAttribute("action", "<?= site_url(md5('ExportRPT') . '/' . md5('viewDraftPDF')); ?>");

			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = "draftNo";
			input.value = draftNo;
			form.appendChild(input);

			var input2 = document.createElement('input');
			input2.type = 'hidden';
			input2.name = "payerName";
			input2.value = $("#payer-name").val();
			form.appendChild(input2);

			document.body.appendChild(form);
			form.submit();
			document.body.removeChild(form);
		};

		//------FUNCTIONS
	});
</script>
<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>