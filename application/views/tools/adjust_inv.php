<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/dataTables/extensions/buttons.dataTables.min.css'); ?>" rel="stylesheet" />
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
		width: 50%;
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

	.row.form-group {
		margin-bottom: 8px !important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">ĐIỀU CHỈNH / THAY THẾ HÓA ĐƠN</div>
				<div class="button-bar-group mr-3">
					<button id="addnew" class="btn btn-outline-success btn-sm">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="remove" class="btn btn-outline-danger btn-sm">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
					<button id="action-confirm" class="btn btn-outline-primary btn-sm" data-loading-text="<i class='la la-spinner spinner'></i>Đang xử lý" title="Xác nhận thực hiện">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Xác nhận thực hiện</span>
					</button>
					<button type="button" id="view-draft-inv" title="Xem trước" data-loading-text="<i class='la la-spinner spinner'></i>Đang tạo" class="btn btn-sm btn-outline-secondary mr-1">
						<i class="fa fa-eye"></i>
						Xem trước
					</button>
					<input type="file" id="input-file" style="display: none;">
				</div>
			</div>
			<div class="ibox-body pt-2 pb-2 bg-f9 border-e">
				<div class="row my-box pb-1">
					<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group pb-1">
									<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tìm kiếm</h5>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Loại hóa đơn</label>
									<div class="col-sm-8 input-group input-group-sm">
										<select id="paymentType" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%" title="Loại hóa đơn">
											<option value="CAS" selected>Thu ngay</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Mẫu hóa đơn</label>
									<div class="col-sm-8">
										<span class="col-form-label" id="pattern">&nbsp;</span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Số hóa đơn cũ">Số hóa đơn cũ</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm" id="old_inv_no" data-column="INV_NO" placeholder="Số hóa đơn cũ" type="text">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Số PIN cũ">Số PIN cũ</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm" id="old_pincode" data-column="PinCode" placeholder="Số PIN cũ" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3" id="first-col">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Thông tin chung</h5>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tàu/chuyến</label>
							<div class="col-sm-5 input-group">
								<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
									<i class="ti-search"></i>
								</span>
							</div>
							<div class="col-sm-4 input-group input-group-sm pl-0">
								<select id="inv-type" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" title="Chọn loại tiền">
									<option value="VND"> Hóa đơn VND </option>
									<option value="USD"> Hóa đơn USD </option>
								</select>
							</div>
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
								<select id="paymentMethod" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%" title="Chọn phương thức">
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
					</div>
					<div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
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
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Tỉ giá">Tỉ giá</label>
									<input id="ExchangeRate" class="col-sm-7 form-control form-control-sm text-right" value="1" placeholder="Tỉ giá" type="text">
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row pl-3">
							<div class="col-sm-12">
								<div class="form-group pb-1">
									<h5 class="text-primary" style="border-bottom: 1px solid #eee">Đính kèm</h5>
								</div>
								<div class="row form-group">
									<div class="col-sm-12">
										<input type="file" class="form-control form-control-sm form-control-file" id="attach_file" placeholder="File đính kèm">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-12 col-form-label" title="Ghi chú hóa đơn">Ghi chú hóa đơn</label>
									<div class="col-sm-12">
										<textarea class="form-control form-control-sm" id="adjust_note" placeholder="Ghi chú hóa đơn" rows="2" style="height: 70px;"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-box py-2 mt-2">
					<label class="col-sm-12 col-lg-1 col-form-label font-bold">Loại điều chỉnh</label>
					<div class="col-sm-12 col-lg-11 col-form-label">
						<label class="radio radio-blue pr-4">
							<input type="radio" name="adjust-type" value="2" checked>
							<span class="input-span"></span>
							Điều chỉnh tăng
						</label>
						<label class="radio radio-blue pr-4">
							<input type="radio" name="adjust-type" value="3">
							<span class="input-span"></span>
							Điều chỉnh giảm
						</label>
						<label class="radio radio-blue pr-4">
							<input type="radio" name="adjust-type" value="4">
							<span class="input-span"></span>
							Thay đổi thông tin
						</label>
						<label class="radio radio-blue">
							<input type="radio" name="adjust-type" value="1">
							<span class="input-span"></span>
							Thay thế
						</label>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0 pb-0">
				<label class="col-sm-1 col-form-label" title="Đối tượng thanh toán">Mẫu cước</label>
				<div class="col-sm-2">
					<select id="inv-temp-currency" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%">
						<option value="VND" selected="">Cước VNĐ</option>
						<option value="USD">Cước USD</option>
					</select>
				</div>
				<div class="col-sm-4">
					<select id="inv-temp" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
						<option value="" selected="">-- Chọn Mẫu cước --</option>
					</select>
				</div>
			</div>
			<div class="row ibox-footer border-top-0 ibox-grid" style="padding: 10px 12px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden" style="padding: 0 5px">
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
						<thead>
							<tr>
								<th col-name="rowguid">rowguid</th>
								<th col-name="STT">STT</th>
								<th col-name="TRF_CODE">Mã BC</th>
								<th col-name="TRF_DESC" max-length=250>Tên biểu cước</th>
								<th col-name="Remark" max-length=100>Ghi chú hóa đơn</th>
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

<!-- view-inv-draft modal -->
<div class="modal fade" id="view-inv-draft-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="display: flex;justify-content: center;align-items: center;">
		<div class="modal-content" style="border-radius: 10px!important;">
			<div class="modal-body">
				<iframe id="view-inv-draft-content"></iframe>
			</div>
			<div class="modal-footer p-2">
				<button type="button" id="print-inv-draft" data-loading-text="<i class='la la-spinner spinner'></i>Đang in" class="btn btn-sm btn-outline-primary">
					<i class="fa fa-print"></i>
					In
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng lại
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/jsprint.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var _colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_colsPayment = ["rowguid", "STT", "TRF_CODE", "TRF_DESC", "Remark", "INV_UNIT", "IX_CD", "CARGO_TYPE", "SZ", "FE", "IsLocal", "QTY", "standard_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT"];

		var _results = [],
			_selectShipKey = '',
			_shipData = [],
			tblInv = $("#tbl-inv"),
			_listCalc = [],
			_listTariff = [],
			_useTplts = [],
			_paymentMethods = [],
			_pattern_serials = [];

		var _cargoTypes = <?= json_encode($cargoTypes) ?>;
		_cargoTypes.map(x => x.Description = x.Description.toUpperCase());
		var invTemps = <?= json_encode($invTemps); ?>;
		var _ssInvInfo = <?= json_encode(isset($ssInvInfo) ? $ssInvInfo : []); ?>;
		var _isDup = <?= json_encode(isset($isDup) ? $isDup : false); ?>;
		var _roundNums = <?= json_encode($this->config->item('ROUND_NUM')); ?>; //them moi lam tron so
		var _roundNumQty_Unit = <?= json_encode($this->config->item('ROUND_NUM_QTY_UNIT')); ?>; //lam tron so luong+don gia theo yeu cau KT
		var _cntrClass = <?= json_encode($cntrClass) ?>;

		<?php if (isset($paymentMethod) && count($paymentMethod) > 0) { ?>
			_paymentMethods = <?= json_encode($paymentMethod); ?>;
		<?php } ?>

		<?php if (isset($pattern_serials) && count($pattern_serials) > 0) { ?>
			_pattern_serials = <?= json_encode($pattern_serials); ?>;
		<?php } ?>

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
					"Code": "*",
					"Name": "*"
				}, {
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
					targets: _colsPayment.getIndexs(["TRF_CODE", "INV_UNIT"]),
					className: "input-required"
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
					className: "input-required",
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-300'>" + data + "</div>";
					},
					width: 200,
					targets: _colsPayment.getIndexs(["TRF_DESC"])
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-300'>" + data + "</div>";
					},
					width: 200,
					targets: _colsPayment.getIndexs(["Remark"])
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _status.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown input-required",
					targets: _colsPayment.indexOf('FE')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _size.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown input-required",
					targets: _colsPayment.indexOf('SZ')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _localForeign.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Name : '';
					},
					className: "text-center show-dropdown input-required",
					targets: _colsPayment.indexOf('IsLocal')
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _cntrClass.filter(p => p.CLASS_Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].CLASS_Name : '';
					},
					className: "text-center show-dropdown input-required",
					targets: _colsPayment.getIndexs(["IX_CD"])
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						var temp1 = _cargoTypes.filter(p => p.Code.trim().toUpperCase() === temp.trim().toUpperCase());
						return temp1.length > 0 ? temp1[0].Description : '';
					},
					className: "text-center show-dropdown input-required",
					targets: _colsPayment.getIndexs(["CARGO_TYPE"])
				}
			],
			order: [],
			keys: true,
			autoFill: {
				focus: 'focus',
				columns: _colsPayment.getIndexs(["TRF_DESC", "Remark", "INV_UNIT", "IX_CD", "CARGO_TYPE", "SZ", "FE", "IsLocal", "QTY", "standard_rate", "UNIT_RATE", "VAT_RATE"])
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

		$('select.selectpicker.input-required').on('change', function(e) {
			if (e.target.value) {
				$(e.target).removeClass('error').selectpicker('refresh');
			}
		})

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

			$('#taxcode').removeClass("error");
		});

		$('#search-payer').on('dblclick', 'tbody tr td', function(e) {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			$('#taxcode').removeClass("error");

			fillPayer();

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

		$('#old_inv_no, #old_pincode').on('keypress', function(e) {
			if (e.which == 13 && $(this).val()) {
				if (!$('#paymentType').val()) {
					toastr.warning('Chọn loại hóa đơn');
					e.preventDefault();
					return;
				}

				loadData($(this).data('column'), $(this).val());
			}
		});

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
		
		
		$('#paymentType').on('change', function(e) {
			var payType = $(e.target).val();
			$('#pattern').text(_pattern_serials[payType]['PATTERN']);


			//xu ly chon hinh thuc thanh toan
			$("#paymentMethod").find('option').remove();
			let methods = _paymentMethods.filter(p => p.ACC_TYPE == payType);
			methods.map((p, i) => {
				$("#paymentMethod").append(`<option value="${p.ACC_CD}" >${p.ACC_NO}</option>`);
			});
			$("#paymentMethod").selectpicker('refresh');
		});

		$('#paymentType').trigger("change");

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

		$('#action-confirm').on('click', function() {
			var adjustType = $('input[name="adjust-type"]:checked').val();
			if (_results.length == 0) {
				toastr.warning('Chưa lấy thông tin hóa đơn cần điều chỉnh/thay thế!');
				return;
			}

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

			if (adjustType !== "4" && tblInv.DataTable().column(_colsPayment.indexOf("TAMOUNT"))
				.data().toArray()
				.filter(p => parseFloat(p) == 0).length > 0) {
				$('.toast').remove();
				toastr['warning']('Chưa nhập đủ chi tiết cước!');
				return;
			}

			var tdrequired = tblInv.find('tbody td.input-required');
			if (tdrequired.has_required()) {
				$('.toast').remove();
				toastr['error']('Vui lòng nhập đầy đủ thông tin!');
				return;
			}

			if (!$('#paymentType').val()) {
				toastr.error('Chưa chọn loại thanh toán!');
				$("#paymentType").addClass("error").selectpicker('refresh');
				return;
			}

			if (!$('#paymentMethod').val()) {
				toastr.error('Chưa chọn hình thức thanh toán!');
				$("#paymentMethod").addClass("error").selectpicker('refresh');
				return;
			}

			var adjust_name = $('input[name="adjust-type"]:checked').val() == '1' ? 'thay thế' : 'điều chỉnh';
			var btn = $(this);
			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: `Xác nhận ${adjust_name} hóa đơn?`,
				buttons: {
					ok: {
						text: 'Tiếp tục',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function() {
							$('.ibox.collapsible-box').blockUI();
							adjustInv(btn);
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

		$("#view-draft-inv").on("click", function() {
			var adjustType = $('input[name="adjust-type"]:checked').val();
			if (_results.length == 0) {
				toastr.warning('Chưa lấy thông tin hóa đơn cần điều chỉnh/thay thế!');
				return;
			}

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

			if (adjustType !== "4" && tblInv.DataTable().column(_colsPayment.indexOf("TAMOUNT"))
				.data().toArray()
				.filter(p => parseFloat(p) == 0).length > 0) {
				$('.toast').remove();
				toastr['warning']('Chưa nhập đủ chi tiết cước!');
				return;
			}

			var tdrequired = tblInv.find('tbody td.input-required');
			if (tdrequired.has_required()) {
				$('.toast').remove();
				toastr['error']('Vui lòng nhập đầy đủ thông tin!');
				return;
			}

			if (!$('#paymentType').val()) {
				toastr.error('Chưa chọn loại thanh toán!');
				$("#paymentType").addClass("error").selectpicker('refresh');
				return;
			}

			if (!$('#paymentMethod').val()) {
				toastr.error('Chưa chọn hình thức thanh !');
				$("#paymentMethod").addClass("error").selectpicker('refresh');
				return;
			}

			adjustInv($(this), true);
		});

		$('#print-inv-draft').on('click', function() {
			$('#view-inv-draft-content').print();
		})
		//------EVENTS

		//------FUNCTIONS

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

		function loadData(searchCol, searchVal) {
			var formdata = {
				'action': 'view',
				'act': 'load_data',
				'args': {
					'searchCol': searchCol,
					'searchVal': searchVal,
					'paymentType': $("#paymentType").val()
				}
			};

			tblInv.dataTable().fnClearTable();
			_results.length = 0;
			$(".ibox.collapsible-box").blockUI();

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlAdjustInvoice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					$(".ibox.collapsible-box").unblock();
					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.no_payer) {
						$(".toast").remove();
						toastr["error"](data.no_payer);
						return;
					}

					var rows = [];
					if (data.results && data.results.length > 0) {
						_results = data.results;
						let item = _results[0];
						$('#old_inv_no').val(item.INV_NO);
						$('#cusID').val(item.PAYER);
						fillPayer();

						$('#shipid').val('');
						if (item.ShipKey) {
							$('#shipid').val(`${item.ShipName}/${item.ImVoy}/${item.ExVoy}`);
							$('#shipid').removeClass('error');

							_selectShipKey = item.ShipKey;
						}

						$('#paymentMethod').val(item.ACC_CD).selectpicker('refresh');
						$('#inv-type').val(item.CURRENCYID).selectpicker('refresh');
						$("#ExchangeRate").val(parseFloat(item["RATE"] || 1));
						_results.map((v, i, s) => {
							var r = [];
							_colsPayment.map((col, indexCol) => {
								var val = "";
								switch (col) {
									case "STT":
										val = i + 1;
										break;
									default:
										val = v[col] ? v[col] : "";
										break;
								}
								r.push(val);
							});
							rows.push(r);
						})
					}

					// tblInv.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblInv.dataTable().fnAddData(rows);
					}

					extendSelectOnGrid();
					calcTotal();
				},
				error: function(err) {
					$(".toast").remove();
					toastr["error"]("ERROR!");
					$(".ibox.collapsible-box").unblock();
					console.log(err);
				}
			});
		}

		function loadTariffSTD(inv_temp) {
			var formdata = {
				'action': 'view',
				'act': 'load_tariff',
				'invTemp': inv_temp
			};

			_useTplts = _useTplts.concat(inv_temp);

			$(".ibox-grid").blockUI();
			$('#inv-temp').parent().blockUI();

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlAdjustInvoice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					$(".ibox-grid").unblock();
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
								lst[i].rowguid, (stt++), lst[i].TRF_CODE, lst[i].TRF_STD_DESC, '' //them remark
								, lst[i].INV_UNIT, lst[i].IX_CD, lst[i].CARGO_TYPE, '' //iso size
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
					$(".ibox-grid").unblock();
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

		function adjustInv(btn, isViewDraft = false) {

			var datas = getInvDraftDetail();
			if (datas.length == 0) {
				$.alert({
					title: "Thông báo",
					content: "Không thể xử lý (thiếu thông tin chi tiết hoá đơn)!",
					type: 'red'
				});
				return;
			}

			datas.map(p => p["CURRENCYID"] = $("#inv-temp option:checked").attr("data") ? $("#inv-temp option:checked").attr("data") : "VND");

			var drTotal = Object.assign({}, calcTotal());
			var formData = {
				cusTaxCode: $('#taxcode').val(),
				cusAddr: $('#p-payer-addr').text(),
				cusName: $('#p-payername').text(),
				sum_amount: drTotal.AMOUNT,
				vat_amount: drTotal.VAT,
				total_amount: drTotal.TAMOUNT,
				inv_type: $("#inv-type").val(),
				exchange_rate: $("#ExchangeRate").val(),
				had_exchange: 1,
				paymentMethod: $("#paymentMethod").val(),
				shipInfo: $('#shipid').val(),
				datas: datas,
				old_pincode: _results[0].PinCode,
				isCredit: _results[0].INV_TYPE == 'CRE' ? '1' : '0',
				adjust_type: $('input[name="adjust-type"]:checked').val(),
				note: $('#adjust_note').val(),
				isViewDraft: isViewDraft ? 1 : 0
			};

			if (parseInt(formData.adjust_type) === 4) {
				formData.sum_amount = formData.vat_amount = formData.total_amount = formData.had_exchange = 0;
				var newDatas = [];
				datas.map(v => {
					let item = Object.assign({}, v);
					item.QTY = item.standard_rate = item.UNIT_RATE = item.AMOUNT = item.VAT_RATE = item.VAT = item.TAMOUNT = 0;
					item["INV_UNIT"] = item["IX_CD"] = item["CARGO_TYPE"] = item["SZ"] = item["FE"] = item["IsLocal"] = '';
					newDatas.push(item);
				});
				formData.datas = newDatas;
			}

			btn.button("loading");
			$.ajax({
				url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('adjustInvoice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.error) {
						btn.button("reset");
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					if (isViewDraft) {
						btn.button("reset");
						$(".ibox").first().unblock();
						if (!data.success) {
							toastr["error"](data.message);
							return;
						}

						window.open(URL.createObjectURL(new Blob([data.html], { type: "text/html" })))

						// $('#view-inv-draft-content').attr("srcdoc", data.html);
							
						// $('#view-inv-draft-modal').modal('show');
						return;
					}

					saveData(data, {
						adjust_type: formData.adjust_type,
						old_pincode: formData.old_pincode
					});
				},
				error: function(err) {
					btn.button("reset");
					console.log(err);
				}
			});
		}

		function saveData(invInfo, adjustInfo) {
			var drDetail = getInvDraftDetail();

			if (drDetail.length == 0) {
				$.alert({
					title: "Thông báo",
					content: "Không thể xử lý (thiếu thông tin chi tiết hoá đơn)!",
					type: 'red'
				});
				return;
			}

			var drTotal = Object.assign({}, calcTotal());
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
			drTotal["PAYMENT_TYPE"] = $('#paymentType').val();
			drTotal["ACC_CD"] = $('#paymentMethod').val();
			drTotal["TPLT_NM"] = JSON.stringify(_useTplts);
			drTotal["CURRENCYID"] = $('#inv-type').val();
			drTotal["RATE"] = $("#ExchangeRate").val() ? $("#ExchangeRate").val() : 1;
			drTotal["PAYMENT_FOR"] = $('#paymentFor').val() === 'NULL' ? '' : $('#paymentFor').val();

			//adjust info
			drTotal["AdjustInvNo"] = _results.filter(p => p.PinCode == adjustInfo['old_pincode']).map(x => x.INV_NO)[0] || '';
			drTotal["AdjustType"] = adjustInfo['adjust_type'];
			drTotal["AdjustRemark"] = $('#adjust_note').val();

			var formData = {
				'action': 'save',
				'mailTo': $("#mail").val(),
				'args': {
					'pubType': 'e-inv',
					'draft_detail': drDetail,
					'draft_total': drTotal
				}
			};

			if (parseInt(adjustInfo.adjust_type) === 4) {
				drTotal.AMOUNT = drTotal.VAT = drTotal.TAMOUNT = drTotal.DIS_AMT = drTotal.RATE = 0;
				var newDatas = [];
				drDetail.map(v => {
					let item = Object.assign({}, v);
					item.QTY = item.standard_rate = item.UNIT_RATE = item.AMOUNT = item.VAT_RATE = item.VAT = item.TAMOUNT = 0;

					newDatas.push(item);
				});

				formData.args.draft_detail = newDatas;
				formData.args.draft_total = drTotal;
			}

			if (typeof invInfo !== "undefined" && invInfo !== null) {
				formData.args["invInfo"] = invInfo;
			}

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlAdjustInvoice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.deny) {
						$('.ibox.collapsible-box').unblock();
						$('#action-confirm').button("reset");
						toastr["error"](data.deny);
						return;
					}

					if (data.non_invInfo) {
						$('.ibox.collapsible-box').unblock();
						$('#action-confirm').button("reset");
						toastr["error"](data.non_invInfo);
						return;
					}

					if (data.isDup) {
						$('.ibox.collapsible-box').unblock();
						$('#action-confirm').button("reset");
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
					}
				},
				error: function(xhr, status, error) {
					$('.ibox.collapsible-box').unblock();
					console.log(xhr);
					$('.toast').remove();
					$('#action-confirm').button("reset");
					toastr['error']("Server Error at [saveData]");
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
			var py = $("#cusID").val() ? payers.filter(p => p.CusID == $("#cusID").val()) :
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

				if (!$('#taxcode').val()) {
					$('#taxcode').val(py[0].VAT_CD || '');
				}

				$("#taxcode").removeClass("error");
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
<script src="<?= base_url('assets/vendors/dataTables/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/xlsx.full.min.js'); ?>"></script>