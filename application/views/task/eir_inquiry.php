<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/dataTables/extensions/buttons.dataTables.min.css'); ?>" rel="stylesheet" />

<style>
	.wrapok {
		white-space: normal !important;
	}

	.ui-menu.ui-autocomplete {
		height: auto;
		max-height: 200px;
		overflow-x: hidden;
	}

	.modal-dialog-mw-py {
		position: fixed;
		top: 20%;
		margin: 0;
		width: 100%;
		height: 100%;
		padding: 0;
		max-width: 100% !important;
	}

	.modal-dialog-mw-py .modal-body {
		width: 90% !important;
		margin: auto;
	}

	.form-group {
		margin-bottom: .5rem !important;
	}

	.grid-hidden {
		display: none;
	}

	.unchecked-Salan {
		pointer-events: none;
	}

	@media (min-width: 1024px) {
		.modal-dialog-mw {
			min-width: 960px !important;
		}
	}

	@media (min-width: 960px) and (max-width: 1024px) {
		.modal-dialog-mw {
			min-width: 720px !important;
		}
	}

	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label {
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.img-thumbnail-detail {
		width: 80px;
		height: 80px;
		min-width: 80px;
		min-height: 80px;
		position: relative;
	}

	.img-thumbnail-detail+i.load-img {
		font-size: 26px;
		color: #ddd;
		position: absolute;
		left: calc(100% - (1.8rem * 2));
		top: calc(100% - (1.8rem * 2));
	}

	.img-thumbnail-detail i:hover {
		color: #adacac;
	}

	div.img-thumbnail-detail:hover {
		cursor: pointer;
		border: 2px dashed #adacac !important;
	}

	div.img-contain {
		position: relative;
	}

	div.img-contain:hover img.img-thumbnail-detail {
		cursor: pointer;
		border: 2px solid #adacac !important;
		opacity: 0.5;
	}

	table.dataTable.tbl-sumary-style thead tr,
	table.dataTable.tbl-sumary-style td {
		background: none !important;
		border: 0 none !important;
		cursor: default !important;
	}

	table.dataTable.tbl-sumary-style thead tr th {
		border-bottom: 1px solid #ccc !important;
	}

	table.dataTable.tbl-sumary-style tbody tr.selected {
		background-color: rgba(255, 231, 112, 0.4) !important;
	}

	.link-cell:hover {
		text-decoration: underline;
	}

	.width-500 {
		width: 500px !important;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">TRUY VẤN THÔNG TIN LỆNH</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row bg-white border-e pb-1 pt-3">
					<div class="col-12">
						<div class="row">

							<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12" style="border-right: 1px solid #eee">
								<div class="row form-group">
									<label class="col-sm-3 col-form-label" for="orderNo">Tìm kiếm</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input autofocus class="form-control form-control-sm" id="searchValue" type="text" placeholder="Số lệnh, số PIN, số container, số vận đơn, số booking">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Tàu/chuyến</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Ngày tạo lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm mr-2" id="issueDateFrom" type="text" placeholder="Từ ngày" readonly>
										<input class="form-control form-control-sm" id="issueDateTo" type="text" placeholder="Đến ngày" readonly>
									</div>
								</div>

								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Người tạo</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input id="createdBy" name="CreatedBy" class="form-control form-control-sm" type="text" placeholder="Người tạo" autocomplete="on">
									</div>
								</div>

								<div class="row form-group" style="margin-bottom: 7px!important">
									<label class="col-sm-3 col-form-label">Hệ thống</label>
									<div class="col-sm-8 input-group input-group-sm col-form-label">
										<label class="radio radio-inline">
											<input type="radio" name="sys" value="BL" checked>
											<span class="input-span"></span>BILLING</label>
										<label class="radio radio-inline">
											<input type="radio" name="sys" value="VSL">
											<span class="input-span"></span>VSL</label>
									</div>
								</div>
							</div>

							<div class="col-xl-7 col-lg-7 col-md-6 col-sm-12 col-xs-12">

								<div class="row" style="border-bottom: 1px solid #eee">
									<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Tác nghiệp</label>
											<div class="col-sm-8 col-form-label">
												<label class="radio radio-ebony">
													<input type="radio" name="typeof" value="nh" checked>
													<span class="input-span"></span>
													NÂNG HẠ
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-8 col-form-label ml-sm-auto">
												<label class="radio radio-ebony">
													<input type="radio" name="typeof" value="dr">
													<span class="input-span"></span>
													ĐÓNG RÚT
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-8 col-form-label ml-sm-auto">
												<label class="radio radio-ebony">
													<input type="radio" name="typeof" value="dv">
													<span class="input-span"></span>
													DỊCH VỤ
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 typeof-nh">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="LAYN" value="0" checked="">
													<span class="input-span"></span>
													Giao container hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="CAPR" value="0" checked="">
													<span class="input-span"></span>
													Giao container vỏ
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 typeof-nh">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="HBAI" value="0" checked="">
													<span class="input-span"></span>
													Hạ container hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="TRAR" value="0" checked="">
													<span class="input-span"></span>
													Hạ container vỏ
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 hiden-input typeof-dr">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="DH" value="0" checked="">
													<span class="input-span"></span>
													Đóng hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="RH" value="0" checked="">
													<span class="input-span"></span>
													Rút hàng
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 hiden-input typeof-dv">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="OTHER" value="0" checked="">
													<span class="input-span"></span>
													Dịch vụ thông thường
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="NONCONT" value="0">
													<span class="input-span"></span>
													Dịch vụ ngoài cont
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-10" style="border-right: 1px solid #eee;">
										<div class="row pt-1" style="border-bottom: 1px solid #eee;">
											<div class="col-sm-12">
												<div class="row form-group">
													<label class="col-sm-2 col-form-label">Hình thức</label>
													<div class="col-sm-8 input-group input-group-sm col-form-label">
														<label class="radio radio-inline">
															<input type="radio" name="paymentType" value="" checked="">
															<span class="input-span"></span>Tất cả</label>
														<label class="radio radio-inline">
															<input type="radio" name="paymentType" value="M">
															<span class="input-span"></span>Thu ngay</label>
														<label class="radio radio-inline">
															<input type="radio" name="paymentType" value="C">
															<span class="input-span"></span>Thu sau</label>
													</div>
												</div>
											</div>
										</div>

										<div class="row pt-1">
											<div class="col-sm-12">
												<div class="row form-group">
													<label class="col-sm-2 col-form-label">Trạng thái</label>
													<div class="col-sm-8 input-group input-group-sm col-form-label">
														<label class="radio radio-inline">
															<input type="radio" name="isFinish" value="" checked="">
															<span class="input-span"></span>Tất cả</label>
														<label class="radio radio-inline">
															<input type="radio" name="isFinish" value="1">
															<span class="input-span"></span>Hoàn tất</label>
														<label class="radio radio-inline">
															<input type="radio" name="isFinish" value="0">
															<span class="input-span"></span>Chưa hoàn tất</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-2 px-2 my-sm-auto">
										<button type="button" id="loadData" data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-primary">
											<i class="fa fa-refresh"></i>
											Nạp dữ liệu
										</button>

										<button type="button" id="loadData2" style="display: none;" data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-sm btn-primary ml-2">
											<i class="fa fa-refresh"></i>
											Nạp dữ liệu 2
										</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="ibox-footer border-top-0 mt-3">
				<div class="row">
					<div class="col-sm-8 detail-expand">
						<table id="tbl-ord-detail" class="table table-striped display nowrap tableDetails" cellspacing="0">
							<thead>
								<tr>
									<th>STT</th>
									<th>Hoàn tất</th>
									<th>Tác nghiệp</th>
									<th>Số lệnh</th>
									<th>Số PIN</th>
									<th>Ngày lệnh</th>
									<th>Hạn lệnh</th>
									<th>Hạn điện</th>
									<th>Số container</th>
									<th>Hãng KT</th>
									<th>KC ISO</th>
									<th>F/E</th>
									<th>Hướng</th>
									<th>PTGN</th>
									<th>Loại hàng</th>
									<th>Hàng hoá</th>
									<th>Trọng lượng</th>
									<th>Niêm chì</th>
									<th>Nội/ngoại</th>
									<th>Tàu/Chuyến</th>
									<th>Số vận đơn</th>
									<th>Số booking</th>
									<th>HTTT</th>
									<th>Số hóa đơn</th>
									<th>Ngày hóa đơn</th>
									<th>Số phiếu tính cước</th>
									<th>Mã biểu cước</th>
									<th>Tên biểu cước</th>
									<th>Số tiền</th>
									<th>Người thanh toán</th>
									<th>Chủ hàng</th>
									<th>Người tạo</th>
									<th>Chuyển cảng</th>
									<th>Cảng giao nhận</th>
									<th>Nơi trả rỗng</th>
									<th>SĐT/CMND người đại diện</th>
									<th>Ghi chú</th>
								</tr>
							</thead>

							<tbody>
							</tbody>
						</table>
					</div>
					<div class="col-sm-4 sum-expand mt-5">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-sumary" class="table table-striped display nowrap tbl-sumary-style" cellspacing="0" style="width: 99.9%">
									<thead>
										<tr>
											<th class="editor-cancel">Tác nghiệp</th>
											<th class="editor-cancel">20</th>
											<th class="editor-cancel">40</th>
											<th class="editor-cancel">45</th>
											<th class="editor-cancel">Tổng</th>
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

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-header">
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
										<option value="2018" selected>2018</option>
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
			</div>
			<div class="modal-body" style="padding: 10px 0">
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
				<button type="button" id="select-ship" class="btn btn-sm btn-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>
			</div>
		</div>
	</div>
</div>

<!--upload picture-->
<div class="modal fade" id="picture-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content" style="border-radius: .25rem; min-width: 100%">
			<div class="modal-body">
				<div class="row">
					<div class="col-10 text-center">
						<img id="preview-img" src="" class="rounded" style="height: 420px; margin: auto;">
					</div>
					<div id="show-image-side" class="col-2" style="border-left: 1px solid #ddd">
						<div class="row form-group mx-auto">
							<div class="img-contain mx-auto">
								<img src="" alt class="img-thumbnail img-thumbnail-detail rounded">
								<i class='la la-spinner spinner load-img'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function() {
		var _colDetails = ["STT", "bXNVC", "CJModeName", "OrderNo", "PinCode", "IssueDate", "ExpDate", "ExpPluginDate", "CntrNo", "OprID", "ISO_SZTP", "Status", "CLASS_Name", "DMethod_CD", "CARGO_TYPE"
					, "CmdID", "CMDWeight", "SealNo", "IsLocal", "ShipInfo", "BLNo", "BookingNo", "PAYMENT_TYPE", "INV_NO", "INV_DATE", "DRAFT_INV_NO", "TRF_CODE", "TRF_DESC", "TAMOUNT"
					, "CusID", "SHIPPER_NAME", "CreatedBy", "Transist", "TERMINAL_CD", "RetLocation", "PersonalInfo", "Note"];

		var _colSumary = ["CJModeName", "SZ_20", "SZ_40", "SZ_45", "SumRow"];
		var _selectShipKey = '';
		var tblSumary = $("#tbl-sumary"),
			tblDetail = $("#tbl-ord-detail");

		// ------------binding shortcut key press------------
		var ctrlDown = false,
			ctrlKey = 17,
			cmdKey = 91,
			rKey = 82,
			qKey = 81,
			mKey = 77;

		$(document).keydown(function(e) {
			if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
		}).keyup(function(e) {
			if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
		});

		$(document).keydown(function(e) {
			if (ctrlDown && e.keyCode == qKey) {
				$("#loadData2").hide();
				return false;
			}

			if (ctrlDown && e.keyCode == mKey) {
				$("#loadData2").show();
				return false;
			}
		});

		var usid = <?= json_encode($userIds) ?>;
		$("#createdBy").autocomplete({
			source: usid.map(p => p.UserID),
			minLength: 3
		});

		$('#createdBy').mousedown(function() {
			if (document.activeElement == this) return;
			$(this).focus();
		});

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh',
			buttons: []
		});

		tblSumary.DataTable({
			language: {
				emptyTable: "",
				zeroRecords: ""
			},
			paging: false,
			searching: false,
			infor: false,
			ordering: false,
			scrollY: '60vh',
			buttons: [],
			columnDefs: [{
					type: "num",
					className: "text-right",
					targets: _colSumary.getIndexs(["SZ_20", "SZ_40", "SZ_45", "SumRow"])
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-200'>" + data + "</div>";
					},
					targets: _colSumary.indexOf("CJModeName")
				}
			]
		});

		$(".datatable-info-right").remove();

		var dtDetails = $("#tbl-ord-detail").DataTable({
			order: [
				[0, 'asc']
			],
			paging: true,
			infor: false,
			scrollY: '60vh',
			buttons: [],
			// rowGroup: {
			// 	dataSrc: [_colDetails.indexOf("PinCode"), _colDetails.indexOf("CntrNo")]
			// },
			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: _colDetails.indexOf('STT')
				},
				{
					className: "text-center",
					targets: _colDetails.getIndexs(['bXNVC', 'ISO_SZTP', 'InvNo', 'DRAFT_INV_NO', 'IssueDate', 'ExpDate', 'ExpPluginDate', 'INV_DATE'])
				},
				{
					className: "text-right",
					targets: _colDetails.getIndexs(["CMDWeight", "TAMOUNT"]),
					render: $.fn.dataTable.render.number(',', '.', 2)
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-300'>" + data + "</div>";
					},
					targets: _colDetails.getIndexs(["SHIPPER_NAME", "TRF_DESC", "CmdID"])
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-500'>" + data + "</div>";
					},
					targets: _colDetails.indexOf("Note")
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-200'>" + data + "</div>";
					},
					targets: _colDetails.indexOf("CJModeName")
				}
			],
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.5
			},
			buttons: [{
					extend: 'excel',
					text: '<i class="fa fa-files-o"></i> Xuất Excel',
					titleAttr: 'Xuất Excel'
				},
				{
					text: '<i class="la la-arrows-h"></i>',
					action: function(e, dt, node, conf) {
						$('.detail-expand').toggleClass("col-sm-8 col-sm-12");
						$('.sum-expand').toggleClass("col-sm-4 col-sm-12");
						$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
					}
				}
			]
		});


		var issueDateFrom = $('#issueDateFrom');
		var issueDateTo = $('#issueDateTo');
		setDateTimeRange(issueDateFrom, issueDateTo);
		issueDateFrom.val(moment().subtract(1, 'day').format('DD/MM/YYYY 00:00'));
		issueDateTo.val(moment().format('DD/MM/YYYY 23:59'));

		autoLoadYearCombo('cb-searh-year');

		///////// SEARCH SHIP
		search_ship();

		$('#btn-search-ship').on('click', function() {
			search_ship();
		});
		$('#reload-ship').on("click", function() {
			$('#search-ship-name').val("");
			search_ship();
		})
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
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

		});
		$('#unselect-ship').on('click', function() {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

			$('#ship-modal').modal("toggle");
		});
		///////// END SEARCH SHIP

		// READ IMAGE
		$("#preview-img").attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');

		$("#picture-modal").on("show.bs.modal", function(e) {
			var orderNo = $(e.relatedTarget).text();
			loadImage(orderNo);
		});

		$(document).on("click", "img.img-thumbnail-detail", function() {
			$("#preview-img").attr("src", $(this).attr("src"));
		});

		//END READ IMAGE

		$('#ship-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		$("input[id='ALL']").on("change", function() {
			$("input[name='cjmode']:not(#ALL)").prop("checked", $(this).is(":checked"));
		});

		$("input[name='cjmode']:not(#ALL)").on("change", function() {
			$("input#ALL").prop("checked", false);
		});

		$(document).on("change", "th input[type='checkbox']", function() {
			$("input[name='checkSync']").prop("checked", $(this).is(":checked"));
		});

		$("#loadData").on("click", function() {
			$(this).button("loading");
			search_order();
		});

		$("#loadData2").on("click", function() {
			search_order_2();
		});

		$("input[name='typeof']").on("change", function(e) {
			$(".typeof-nh, .typeof-dr, .typeof-dv").addClass("hiden-input");
			var tp = $(e.target).val();
			$(".typeof-" + $("input[name='typeof']:checked").val()).removeClass("hiden-input");
		});

		function search_order_2() {
			tblDetail.waitingLoad();

			var cjmodes = $(".typeof-" + $("input[name='typeof']:checked").val())
				.find("input[name='cjmode']:checked")
				.map(function() {
					return this.id;
				}).get(),
				issueFrom = $("#issueDateFrom").val(),
				issueTo = $("#issueDateTo").val(),
				searchVal = $("#searchValue").val().trim();

			var formData = {
				"action": "view",
				"act": "search_order_2",
				"args": {
					"CJMode_CDs": cjmodes,
					"ShipKey": _selectShipKey,
					"IssueDateFrom": issueFrom.trim(),
					"IssueDateTo": issueTo.trim(),
					"searchValue": searchVal,
					"sys": $("input[name='sys']:checked").val()
				}
			};

			tblDetail.DataTable({
				order: [
					[0, 'asc']
				],
				buttons: [],
				rowsGroup: [_colDetails.indexOf("OrderNo")],
				columnDefs: [{
						type: "num",
						className: "text-center",
						targets: _colDetails.indexOf('STT')
					},
					{
						className: "text-center",
						targets: _colDetails.getIndexs(['bXNVC', 'ISO_SZTP'])
					},
					{
						render: function(data, type, full, meta) {
							return "<div class='wrap-text width-200'>" + data + "</div>";
						},
						targets: _colDetails.getIndexs(["Note", "SHIPPER_NAME"])
					},
					{
						render: function(data, type, full, meta) {
							return "<div class='wrap-text width-150'>" + data + "</div>";
						},
						targets: _colDetails.indexOf("CJModeName")
					}
				],
				serverSide: true,
				ordering: false,
				paging: true,
				scrollY: '35vh',
				scroller: {
					loadingIndicator: true,
					displayBuffer: 12,
					boundaryScale: 0.25
				},
				deferRender: true,
				processing: true,
				scrollCollapse: true,
				ajax: {
					url: "<?= site_url(md5('Task') . '/' . md5('tskEirInquiry')); ?>",
					type: "POST",
					dataType: 'json',
					data: function(d) {
						return $.extend({}, d, formData);
					}
				}
			});

			tblSumary.dataTable().fnClearTable();

			formData["act"] = "count_order";

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskEirInquiry')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					var rowsCounter = [];
					if (data.countOrder && data.countOrder.length > 0) {
						$.each(data.countOrder, function(i, item) {
							rowsCounter.push(
								[
									item.CJModeName,
									item.SZ_20,
									item.SZ_40,
									item.SZ_45,
									item.SumRow
								]
							);
						});
					}

					if (rowsCounter.length > 0) {
						tblSumary.dataTable().fnAddData(rowsCounter);
					}
				},
				error: function(err) {
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
					console.log(err);
				}
			});
		}

		function search_order() {
			tblSumary.dataTable().fnClearTable();
			tblDetail.waitingLoad();

			var cjmodes = $(".typeof-" + $("input[name='typeof']:checked").val())
				.find("input[name='cjmode']:checked")
				.map(function() {
					return this.id;
				}).get(),
				issueFrom = $("#issueDateFrom").val(),
				issueTo = $("#issueDateTo").val(),
				searchVal = $("#searchValue").val().trim();

			var formData = {
				"action": "view",
				"act": "search_order",
				"args": {
					"CJMode_CDs": cjmodes,
					"ShipKey": _selectShipKey,
					"IssueDateFrom": issueFrom.trim(),
					"IssueDateTo": issueTo.trim(),
					"searchValue": searchVal,
					'createdBy': $("#createdBy").val(),
					"paymentType": $("input[name='paymentType']:checked").val(),
					"isFinish": $("input[name='isFinish']:checked").val(),
					"sys": $("input[name='sys']:checked").val()
				}
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskEirInquiry')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					$("#loadData").button("reset");
					var rows = [];

					if (data.results && data.results.length > 0) {

						var results = data.results.sort((a, b) => (a.OrderNo > b.OrderNo) ? 1 : ((b.OrderNo > a.OrderNo) ? -1 : 0));

						$.each(results, function(i, item) {
							var r = [];
							$.each(_colDetails, function(idx, colname) {
								var val = "";
								switch (colname) {
									case "STT":
										val = i + 1;
										break;
									case "bXNVC":
										val = '<label class="checkbox checkbox-primary disabled">' +
											'<input type="checkbox" disabled value="' + item[colname] + '" ' + (item[colname] == '1' ? "checked" : "") + '>' +
											'<span class="input-span"></span>' +
											'</label>';
										break;
									case "PinCode":
										if (item[colname]) {
											val = '<a target="_blank"' +
												' href="<?= site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF") . "?fkey="); ?>' + item[colname].split('-')[0] + '" class="link-cell" title="Xem hóa đơn">' +
												item[colname] +
												'</a>';
										} else {
											val = "";
										}

										break;
									case "OrderNo":
										if (item[colname]) {
											val = '<a href="#" class="link-cell" data-toggle="modal" data-target="#picture-modal" title="Xem chứng từ đính kèm">' +
												item[colname] +
												'</a>';
										} else {
											val = "";
										}

										break;
									case "ShipInfo":
										val = item['ShipName'] ? (item['ShipName'] + " / " + item['ImVoy'] + " / " + item['ExVoy']) : "";
										break;
									case "INV_DATE":
									case "IssueDate":
									case "ExpPluginDate":
									case "ExpDate":
										val = item[colname] ? getDateTime(item[colname]) : "";
										break;
									case "IsLocal":
										switch (item[colname]) {
											case "L":
												val = "Nội";
												break;
											case "F":
												val = "Ngoại";
												break;
											default:
												val = item[colname] ? item[colname] : "";
												break;
										}
										break;
									case "PAYMENT_TYPE":
										switch (item[colname]) {
											case "M":
												val = "Thu ngay";
												break;
											case "C":
												val = "Thu sau";
												break;
											default:
												val = item[colname] ? item[colname] : "";
												break;
										}
										break;
									default:
										val = item[colname] ? item[colname] : "";
										break;
								}
								// val = "<td>"+ val +"</td>";
								r.push(val);
							});

							// r = "<tr>"+ r +"</tr>";
							rows.push(r);

						});
					}

					tblDetail.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblDetail.dataTable().fnAddData(rows);
						// var clusterize = new Clusterize({
						// 	  rows: rows,
						// 	  scrollId: 'scrollArea',
						// 	  contentId: 'tbl-ord-detail'
						// });
					}

					var rowsCounter = [];
					if (data.countOrder && data.countOrder.length > 0) {
						$.each(data.countOrder, function(i, item) {
							rowsCounter.push(
								[
									item.CJModeName,
									item.SZ_20,
									item.SZ_40,
									item.SZ_45,
									item.SumRow
								]
							);
						});
					}

					if (rowsCounter.length > 0) {
						tblSumary.dataTable().fnAddData(rowsCounter);
						$(tblSumary.DataTable().rows(':last').nodes().to$()).addClass("row-total");
					}
				},
				error: function(err) {
					tblDetail.dataTable().fnClearTable();
					$("#loadData").button("reset");
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
					console.log(err);
				}
			});
		}

	});

	var contains = $("#show-image-side"),
		temp = contains.html();

	function loadImage(orderNo) {
		contains.html("").append(temp);
		$("#preview-img").attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');

		var formData = {
			'action': 'view',
			'act': 'load_img',
			'orderNo': orderNo
		};

		$.ajax({
			url: "<?= site_url(md5('Task') . '/' . md5('tskEirInquiry')); ?>",
			dataType: 'json',
			data: formData,
			type: 'POST',
			success: function(data) {
				if (data.imgs && data.imgs.length > 0) {
					$.each(data.imgs, function(index, fileName) {
						var testImg = new Image();
						testImg.onload = function() {

							var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

							img.next().css("display", "none");
							img.attr("src", this.src);

							$("#preview-img").attr("src", this.src);

							if (index < data.imgs.length - 1) {
								contains.append(temp);
							}
						};

						testImg.onerror = function(e) {
							var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

							img.next().css("display", "none");
							img.attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');
							$("#preview-img").attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');
						};

						testImg.src = '<?= base_url('assets/img/ct/'); ?>' + fileName;
					});
				} else {
					var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

					img.next().css("display", "none");
					img.attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');
					$("#preview-img").attr("src", '<?= base_url('assets/img/no-img.jpg'); ?>');
				}
			},
			error: function(err) {
				$('.toast').remove();
				toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				console.log(err);
			}
		});
	}

	function testImage(URL) {
		var tester = new Image();
		tester.onload = imageFound;
		tester.onerror = imageNotFound;
		tester.src = URL;
	}

	function imageFound() {
		alert('That image is found and loaded');
	}

	function imageNotFound() {
		alert('That image was not found.');
	}

	function getContSize(sztype) {
		switch (sztype.substring(0, 1)) {
			case "2":
				return 20;
			case "4":
				return 40;
			case "L":
			case "M":
			case "9":
				return 45;
		}
		return "0";
	}

	function search_ship() {
		$("#search-ship").waitingLoad();
		var formdata = {
			'action': 'view',
			'act': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-searh-year').val(),
			'shipname': $('#search-ship-name').val()
		};

		$.ajax({
			url: "<?= site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice')); ?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function(data) {
				var rows = [];
				if (data.vsls.length > 0) {
					for (i = 0; i < data.vsls.length; i++) {
						rows.push([
							data.vsls[i].ShipID, (i + 1), data.vsls[i].ShipName, data.vsls[i].ImVoy, data.vsls[i].ExVoy, getDateTime(data.vsls[i].ETB), data.vsls[i].ShipKey, getDateTime(data.vsls[i].BerthDate), data.vsls[i].ShipYear, data.vsls[i].ShipVoy
						]);
					}
				}
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
					searching: false,
					data: rows
				});
			},
			error: function(err) {
				console.log(err);
			}
		});
	}
</script>

<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js'); ?>"></script>

<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>

<script src="<?= base_url('assets/vendors/dataTables/datatables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/buttons.html5.min.js'); ?>"></script>