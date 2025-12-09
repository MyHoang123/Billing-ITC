<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />

<style>
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold !important;
		padding-right: 0 !important;
	}

	.modal-dialog-mw-py {
		position: fixed;
		top: 20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100% !important;
	}

	.modal-dialog-mw-py .modal-body {
		width: 90% !important;
		margin: auto;
	}

	@media (max-width: 780px) {
		.modal-dialog-mw-py .modal-body {
			width: 100% !important;
			margin: auto;
		}

		#INV_DRAFT_TOTAL span.col-form-label {
			width: 100%;
			border-bottom: dotted 1px;
			display: inline-block;
			word-wrap: break-word;
		}

		span.col-form-label {
			width: 100%;
			border-bottom: dotted 1px;
			display: inline-block;
			word-wrap: break-word;
		}
	}

	.form-group {
		margin-bottom: .5rem !important;
	}

	.grid-hidden {
		display: none;
	}
	#terminal-modal .dataTables_filter {
		width: 200px;
	}

	#terminal-modal .dataTables_filter input[type="search"] {
		width: 65%;
	}

	#terminal-modal .dataTables_filter>label::after {
		right: 45px !important;
	}
	.unchecked-Salan {
		pointer-events: none;
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

	.add-payer {
		flex: 1;
		/* shorthand for: flex-grow: 1, flex-shrink: 1, flex-basis: 0 */
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

		background: #8e9eab;
		/* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #8e9eab, #eef2f3);
		/* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #8e9eab, #eef2f3);

		-webkit-transition: transform 1s linear;
		/* For Safari 3.1 to 6.0 */
		transition: transform 1s linear;
		transform-origin: left center;
		z-index: 1;
		padding: 7px 0 7px 20px;
	}

	.payer-show {
		transform: scaleX(1);
	}

	#barge-modal .dataTables_filter,
	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}

	.scrollable-menu {
		height: auto;
		max-height: 200px;
		overflow-x: hidden;
	}

	span.sub-text {
		padding-left: 10px;
		font-size: 75%;
		color: #bbb;
		font-style: italic;
	}

	.dropdown-menu.dropdown-menu-column {
		max-height: 40vh;
		overflow-y: auto;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH HẠ CONTAINER RỖNG</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row my-box pb-1">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group" hidden>
									<label class="col-sm-4 col-form-label">Phương án</label>
									<div class="col-sm-8">
										<select id="cjmode" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="TRAR" selected>Trả rỗng</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ngày lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="ref-date" type="text" placeholder="Ngày lệnh" readonly>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text" placeholder="Hạn lệnh" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-4 col-form-label">
										<label class="checkbox checkbox-blue">
											<input type="checkbox" name="chkSalan" id="chkSalan">
											<span class="input-span"></span>
											Sà lan
										</label>
									</div>
									<div class="col-sm-8 input-group input-group-sm">
										<div id="barge-ischecked" class="input-group unchecked-Salan">
											<input class="form-control form-control-sm" id="barge-info" type="text" placeholder="Mã/Năm/Chuyến" readonly>
											<span class="input-group-addon bg-white btn text-warning" id="btn-search-barge" data-toggle="modal" data-target="#barge-modal" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">D/O</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm" id="do" placeholder="D/O" type="text">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Số vận đơn</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="blno" type="text" placeholder="Số vận đơn">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Chủ hàng">Chủ hàng *</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm input-required" id="shipper-name" type="text" placeholder="Chủ hàng">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group" style="border-bottom: 1px solid #eee">
									<div class="col-12 col-form-label">
										<label class="checkbox checkbox-blue">
											<input type="checkbox" name="chkServiceAttach" id="chkServiceAttach">
											<span class="input-span"></span>
											Đính kèm dịch vụ
										</label>
									</div>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="col-attach-service" style="display: none;">
								<table id="tb-attach-srv" class="table table-striped display nowrap single-row-select" cellspacing="0" style="width: 99.8%">
									<thead>
										<tr>
											<th class="editor-cancel data-type-checkbox" style="max-width: 30px">Chọn</th>
											<th col-name="CJMode_CD">Mã phương án</th>
											<th col-name="CJModeName">Tên phương án</th>
											<th col-name="Cont_Count">Số lượng Cont</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row" id="row-transfer-right">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-1" id="col-transfer">

								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Người đại diện</label>

									<div class="col-sm-10 input-group">
										<input class="form-control form-control-sm mr-2" id="cmnd" type="text" placeholder="Số CMND /Số ĐT" maxlength="20">
										<input class="form-control form-control-sm mr-2" id="personal-name" type="text" placeholder="Tên người đại diện" maxlength="50">
										<input class="form-control form-control-sm" id="mail" type="text" placeholder="Địa chỉ Email" style="width: 140px" maxlength="100">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Ghi chú</label>
									<div class="col-sm-10 input-group input-group-sm">
										<input class="form-control form-control-sm" id="remark" type="text" placeholder="Ghi chú">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 my-box">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Đối tượng thanh toán">ĐTTT *</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
											<i class="ti-search"></i>
										</span>
									</div>
									<input class="hiden-input" id="cusID" readonly>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name"> [Tên đối tượng thanh toán]</span>&emsp;
								<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr"> [Địa chỉ]</span>&emsp;
								<i class="fa fa-tags" style="font-size: 15px!important;"></i>-<span id="payment-type" class="font-bold" data-value="C"> [Hình thức thanh toán]</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 my-box">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="addnew" class="btn btn-outline-success btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
							</button>
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
							</button>
							<button id="import-file" class="btn btn-outline-warning btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-share-square"></i>Import File</span>
							</button>
							<a class="linked col-form-label text-primary" href="<?= base_url('download/lenh-ha-cont-rong.xlsx'); ?>" style="padding-left: 10px;">Tải tệp mẫu</a>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
						<div class="row form-group" style="display: inline-block; margin: 0 auto">
							<label class="radio radio-outline-success pr-4">
								<input name="view-opt" type="radio" id="chk-view-cont" value="cont" checked>
								<span class="input-span"></span>
								Danh sách container
							</label>
							<label class="radio radio-outline-success pr-4">
								<input name="view-opt" id="chk-view-inv" value="inv" type="radio">
								<span class="input-span"></span>
								Tính cước
							</label>
							<button id="show-payment-modal" class="btn btn-warning btn-sm" title="Thông tin thanh toán" data-toggle="modal">
								<i class="fa fa-print"></i>
								Thanh toán
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row grid-toggle" style="padding: 10px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="tbl-cont" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th col-name="STT">STT</th>
								<th col-name="CntrNo">Số Container</th>
								<th col-name="OprID" class="autocomplete">Hãng Khai Thác</th>
								<th col-name="LocalSZPT" class="autocomplete">Kích Cỡ Nội Bộ</th>
								<th col-name="ISO_SZTP" class="editor-cancel">Kích Cỡ ISO</th>
								<th col-name="CARGO_TYPE" class="autocomplete">Loại Hàng</th>
								<th col-name="CMDWeight" class="data-type-numeric">Trọng Lượng</th>
								<th col-name="IsLocal" class="autocomplete">Nội/ Ngoại</th>
								<th col-name="Transist" class="autocomplete">Cảng chuyển</th>
								<th col-name="TERMINAL_CD" class="autocomplete" show-target="#terminal-modal">Cảng Giao Nhận</th>
							</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
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
<!--select barge-->
<div class="modal fade" id="barge-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn xà lan</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="search-barge" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th style="max-width: 15px">STT</th>
								<th>Mã xà lan</th>
								<th>Tên xà lan</th>
								<th>Năm</th>
								<th>Chuyến</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="select-barge" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
<!--payment modal-->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-dialog-mw-py" role="document">
		<div class="modal-content p-3">
			<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Thông tin thanh toán</h5>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-form-label" title="Mã KH/ MST">Mã KH/ MST</label>
							<span class="col-form-label" id="p-taxcode"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tên</label>
							<span class="col-form-label" id="p-payername"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Địa chỉ</label>
							<span class="col-form-label" id="p-payer-addr"></span>
						</div>

						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Thanh toán</label>
							<div class="col-sm-9">
								<div class="row">
								<select id="payment-method-select" class="form-control form-control-sm">
                                    <option value="">Tiền mặt / Chuyển khoản</option>
                                    <optgroup label="Thanh toán QR Code">
                                        <option id="t-mb" value="QR_MB" data-acc-cd="QR_MB" data-acc-no="MB Bank"
                                            data-acc-name="MB Bank QR Payment">
                                            MB Bank QR Payment
                                        </option>
                                    </optgroup>
                                </select>
									<a class="col-form-label pr-5" id="p-money" style="pointer-events: none;">
										<i class="fa fa-check-square"></i> THU NGAY
									</a>
									<a class="col-form-label" id="p-credit" style="pointer-events: none;">
										<i class="fa fa-square"></i> THU SAU
									</a>
								</div>
							</div>
						</div>

						<div class="row form-group mt-3" id="publish-type">
							<div class="col-9 ml-sm-auto">
								<div class="row input-group">
									<label class="col-form-label radio radio-outline-blue text-blue mr-4 mx-auto">
										<input name="publish-opt" type="radio" value="dft">
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span> PHIẾU TẠM THU
									</label>
									<label class="col-form-label radio radio-outline-danger text-danger mr-4 mx-auto">
										<input name="publish-opt" value="m-inv" type="radio">
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
										HÓA ĐƠN GIẤY
									</label>
									<label class="col-form-label radio radio-outline-warning text-warning mx-auto">
										<input name="publish-opt" value="e-inv" type="radio" checked>
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
										HÓA ĐƠN ĐIỆN TỬ
									</label>
								</div>
							</div>
						</div>

						<div id="m-inv-container" class="row form-group hiden-input">
							<label class="col-sm-3 col-form-label">Số HĐ kế tiếp</label>
							<div class="col-form-label text-danger font-bold">
								<?php if (isset($ssInvInfo) && count($ssInvInfo) > 0) { ?>
									<span id="ss-invNo">
										<?= $ssInvInfo['serial'] . substr("00000000" . $ssInvInfo['invno'], -8) ?>
										<?php if ($isDup) { ?>
											&ensp;
											[BỊ TRÙNG]
										<?php } ?>
									</span>
									&ensp;
									<button id="change-ssinvno" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#change-ssinv-modal" title="Thay đổi hóa đơn sử dụng tiếp theo">
										<span class="btn-icon"><i class="fa fa-pencil"></i>Thay đổi</span>
									</button>
								<?php } else { ?>
									<span id="ss-invNo">
										Chưa khai báo hóa đơn tiếp theo!
									</span>
									&ensp;
									<button id="change-ssinvno" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal" data-target="#change-ssinv-modal" title="Khai báo số hóa đơn sử dụng tiếp theo">
										<span class="btn-icon"><i class="fa fa-pencil"></i>Khai báo</span>
									</button>
								<?php } ?>
							</div>
						</div>

					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12" id="INV_DRAFT_TOTAL">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tổng tiền thanh toán</h5>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Thành tiền</label>
							<span class="col-form-label text-right font-bold text-blue" id="AMOUNT"></span>
						</div>
						<div class="row form-group hiden-input">
							<label class="col-sm-4 col-form-label">Giảm trừ</label>
							<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Tiền thuế</label>
							<span class="col-form-label text-right font-bold text-blue" id="VAT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Tổng tiền</label>
							<span class="col-form-label text-right font-bold text-danger" id="TAMOUNT"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div id="dv-cash" style="margin: 0 auto">
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Xác nhận thanh toán</span>
					</button>
					<button class="btn btn-rounded btn-rounded btn-gradient-lime hiden-input">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ MASTER, VISA</span>
					</button>
				</div>
				<div id="dv-credit" class="hiden-input" style="margin: 0 auto">
					<button id="save-credit" class="btn btn-rounded btn-rounded btn-gradient-lime btn-fix">
						<span class="btn-icon"><i class="fa fa-save"></i> Lưu dữ liệu </span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
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
<!--terminal modal-->
<div class="modal fade" id="terminal-modal" tabindex="-1" data-backdrop="false" role="dialog"
	aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 450px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách Cảng chuyển</h5>
			</div>
			<div class="modal-body">
				<table id="tbl-terminal" class="table table-striped display nowrap" cellspacing="0"
					style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="GNRL_CODE">Mã</th>
							<th col-name="GNRL_NM">Tên</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($terminals) > 0) {
							$i = 1; ?>
							<?php foreach ($terminals as $item) {  ?>
								<tr>
									<td style="text-align: center"><?= $i; ?></td>
									<td><?= $item['GNRL_CODE']; ?></td>
									<td><?= $item['GNRL_NM']; ?></td>
								</tr>
							<?php $i++;
							}  ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon"
						id="apply-terminal" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon"
						data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
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
	var EirNo_Draft = null
    var modalQrPayment = null
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function() {
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_cols = ["STT", "CntrNo", "OprID", "LocalSZPT", "ISO_SZTP", "CARGO_TYPE", "CMDWeight", "IsLocal", "Transist", "TERMINAL_CD"],
			_colsAttachServices = ["Select", "CjMode_CD", "CJModeName", "Cont_Count"];

		var _oprs = <?= $oprs; ?>,
			_sztp = <?= $sizeTypes; ?>,
			_cargoTypes = <?= $cargoTypes; ?>,
			_lstEir = [],
			_transists = <?= $transists; ?>,
			_terminals = <?= json_encode($terminals); ?>,
			tblConts = $("#tbl-cont"),
			tblInv = $("#tbl-inv"),
			tblAttach = $('#tb-attach-srv');

		var _localForeign = [{
				"Code": "L",
				"Name": "Nội"
			},
			{
				"Code": "F",
				"Name": "Ngoại"
			}
		];

		var payers = [],
			_attachServicesChecker = [],
			_lstAttachService = [];

		//INIT TABLES		
		$('#search-barge').DataTable({
			paging: false,
			infor: false,
			scrollY: '20vh',
			buttons: [],
		});

		tblConts.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh',

			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: _cols.indexOf("STT")
				},
				{
					className: "text-right",
					render: $.fn.dataTable.render.number(',', '.', 2),
					targets: _cols.indexOf("CMDWeight")
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						return temp ? temp.trim().toUpperCase() : "";
					},
					className: "text-center",
					targets: _cols.getIndexs(["CntrNo", "OprID", "ISO_SZTP"])
				},
					{
					className: "show-more",
					targets: _cols.indexOf("TERMINAL_CD")
				},
				{
					className: "show-dropdown",
					targets: _cols.indexOf("Transist")
				},
				{
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						return temp ? temp.trim() : "";
					},
					className: "text-center show-dropdown",
					targets: _cols.getIndexs(["OprID", "LocalSZPT", "CARGO_TYPE", "IsLocal"])
				}
			],
			order: [],
			keys: true,
			autoFill: {
				focus: 'focus'
			},
			select: true,
			rowReorder: false
		});

		tblInv.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});

		tblAttach.DataTable({
			paging: false,
			columnDefs: [{
				className: 'text-center',
				orderDataType: 'dom-text',
				type: 'string',
				targets: _colsAttachServices.indexOf("Select")
			}],
			order: [],
			buttons: [],
			info: false,
			searching: false,
			scrollY: '16vh'
		});
		$("#tbl-terminal").DataTable({
			scrollY: '40vh',
			columnDefs: [{
				type: "num",
				className: "text-center",
				targets: 0
			}],
			order: [
				[0, 'asc']
			],
			paging: false,
			keys: true,
			autoFill: {
				focus: 'focus'
			},
			select: {
				style: 'single',
				info: false
			},
			buttons: [],
			rowReorder: false
		});
		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [{
					type: "num",
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
		// END INIT TABLES

		extendSelectOnGrid();

		load_payer();

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date').datetimepicker({
			dateFormat: 'dd/mm/yy',
			//timeFormat: 'HH:mm:ss',
			timeFormat: '23:59:59',
			todayHighlight: true,
			oneLine: true,
			minDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			controlType: 'select',
			autoclose: true,
			timeInput: true
		});

		$('input[name="chkSalan"]').on('change', function() {
			$('#barge-ischecked').toggleClass('unchecked-Salan');
			if (!$(this).is(':checked')) {
				$('#barge-info').val('');
				$('#barge-info').trigger('change');
			}
		});

		$('#barge-modal, #bill-modal, #payer-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		//SELECT BARGE
		$('#btn-search-barge').on('click', function() {
			search_barge();
		});
		$(document).on('click', '#search-barge tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-barge').on('click', function() {
			var r = $('#search-barge tbody').find('tr.m-row-selected').first();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
		});
		$('#search-barge').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#barge-modal').modal("toggle");
		});
		//END SELECT BARGE

		// SEARCH PAYER
		$(document).on('click', '#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function() {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			fillPayer();

			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
		// END SEARCH PAYER

		$('#b-add-payer').on("click", function() {
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function() {
			$('.add-payer-container').removeClass("payer-show");
		});

		$('#show-payment-modal').on("click", function(e) {
			if (!$("#taxcode").val()) {
				$('#taxcode').addClass("error");
				toastr["warning"]("Chưa chọn đối tượng thanh toán!");
				e.preventDefault();
				return;
			}

			var paymentType = $('#payment-type').attr('data-value');
			if (paymentType == "M") {
				$("#dv-cash").removeClass("hiden-input");
				$("#dv-credit").addClass("hiden-input");
				//
				$("#publish-type").removeClass("hiden-input");

				if (!$("input[name='publish-opt']").is(":checked")) {
					$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
					$("#m-inv-container").addClass("hiden-input");
				}

			} else {
				$("#dv-cash").addClass("hiden-input");
				$("#dv-credit").removeClass("hiden-input");
				//
				$("#publish-type").addClass("hiden-input");
				$("input[name='publish-opt']").prop("checked", false);
			}

			$(this).attr("data-target", "#payment-modal");
		});
	//------APPLY TERMINAL FROM MODAL
		$("#tbl-terminal").find("tbody tr").on("dblclick", function() {
			var applyBtn = $("#apply-terminal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				terCode = $(this).find("td:eq(1)").text(),
				cell = tblConts.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblConts.DataTable();

			var temp = "<input type='text' value='" + terCode + "' class='hiden-input'>" +
				_terminals.filter(p => p.GNRL_CODE == terCode).map(x => x.GNRL_NM)[0];

			cell.removeClass("error");

			dtTbl.cell(cell).data(temp).draw(false);
			$("#terminal-modal").modal("hide");
		});

		$("#apply-terminal").on("click", function() {
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				terCode = $("#tbl-terminal").getSelectedRows().data().toArray()[0][1],
				cell = tblConts.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblConts.DataTable();

			var temp = "<input type='text' value='" + terCode + "' class='hiden-input'>" +
				_terminals.filter(p => p.GNRL_CODE == terCode).map(x => x.GNRL_NM)[0];

			cell.removeClass("error");
			dtTbl.cell(cell).data(temp).draw(false);
		});
		//------APPLY TERMINAL FROM MODAL

		$('#ship-modal, #barge-modal, #payer-modal, #terminal-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});
		//------MBBANK QR GATEWAY
		$('#payment-method-select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var accType = selectedOption.val();
                if (accType === 'QR_MB') {
					$('#payment-modal').find('.modal-content').blockUI();
					//Check EIR_Draft
					if(EirNo_Draft) {
						return handleClickPayQrMb(EirNo_Draft)
					}
					saveData([],false);
					return;
                } 
        });
		//------USING MANUAL INVOICE

		$("input[name='publish-opt']").on("change", function(e) {
			if ($(e.target).val() == "m-inv") {
				$("#m-inv-container").removeClass("hiden-input");
				$("#pay-atm").prop("disabled", <?= $isDup || !isset($ssInvInfo) || count($ssInvInfo) == 0; ?>);
				$("#t-mb").prop("disabled",false)
			} 
			else if($(e.target).val() == "dft") {
                $("#t-mb").prop("disabled", true);
            }
			else {
				$("#m-inv-container").addClass("hiden-input");
				$("#pay-atm").prop("disabled", false);
				$("#t-mb").prop("disabled",false)
			}
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
				buttons: {
					ok: {
						text: 'OK',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
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
								url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
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
										.html('<span class="btn-icon"><i class="fa fa-pencil"></i>Thay đổi');

									$("#pay-atm").prop("disabled", false);
								},
								error: function(err) {
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

		$('input[name="view-opt"]').bind('change', function(e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			$('#tbl-cont, #tbl-inv').realign();
			if ($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1) {
				if ($('td.input-required').has_required()) {
					$('.toast').remove();
					toastr['error']('Vui lòng nhập đầy đủ thông tin!');
					$('#chk-view-cont').trigger('click');
					return;
				}
				var newrows = $('#tbl-cont').getNewRows();
				_lstEir = [];
				if (newrows.length == 0) return;
				$.each(newrows, function(idx, item) {
					addCntrToEir(item);
				});
				loadpayment();
			}
			else {
				if ($('td.input-required').has_required()) {
					$('.toast').remove();
					toastr['error']('Vui lòng nhập đầy đủ thông tin!');
					$('#chk-view-cont').trigger('click');
					return;
				}
				var newrows = $('#tbl-cont').getNewRows();
				_lstEir = [];
				if (newrows.length == 0) return;
				console.log(newrows)
				$.each(newrows, function(idx, item) {
					addCntrToEir(item);
				});
			}
		});

		$('#addnew').on('click', function() {
			if ($('#chk-view-inv').is(':checked')) return;
			if ($('.input-required').has_required()) {
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			if (_oprs.length == 0) {
				$('.toast').remove();
				toastr['error']('Không có hãng khai thác nào phù hợp với lịch trình tàu!');
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
								tblInv.DataTable().clear().draw();
								tblConts.newRows(input.val());
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

		$(document).on("keypress", "#num-row", function(e) {
			if (e.which == 13) {
				$(document).find("div.jconfirm-buttons").find("button.btn-confirm").trigger("click");
			}
		});

		// ----- FOR ATTACH SERVICES
		load_attach_srv();
		$("#chkServiceAttach").on("change", function() {
			var content = $("#col-transfer")[0];

			$("#col-transfer").remove();

			if ($(this).is(":checked")) {
				$("#row-transfer-left").append(content);
			} else {
				$("#row-transfer-right").append(content);
			}

			$("#col-attach-service").toggle(800, function() {
				$($.fn.dataTable.tables(true)).DataTable()
					.columns
					.adjust();
			});

		});

		//setup before functions
		var typingTimer;
		var doneInterval = 500;

		tblConts.DataTable().on("select deselect", function(e, dt, type, indexes) {
			clearTimeout(typingTimer);
			typingTimer = setTimeout(loadAttachData(indexes), doneInterval);
		});

		tblAttach.on('change', 'tbody tr td input[type="checkbox"]', function(e) {

			var inp = $(e.target);

			var rowcontSelected = tblConts.DataTable().rows('.selected').data()[0];

			if (!rowcontSelected || rowcontSelected.length == 0 || !rowcontSelected[_cols.indexOf("CntrNo")]) {
				$(".toastr").remove();
				toastr["error"]("Vui lòng chọn một ít nhất container để đính kèm dịch vụ!");

				if (inp.is(":checked")) {
					inp.removeAttr("checked");
					inp.val("");
				} else {
					inp.attr("checked", "");
					inp.val(1);
				}

				tblAttach.DataTable().cell(inp.closest("td")).data(inp.closest("td").html()).draw(false);

				return;
			}

			if (inp.is(":checked")) {
				inp.attr("checked", "");
				inp.val(1);
			} else {
				inp.removeAttr("checked");
				inp.val("");
			}

			if (inp.closest("td").index() == _colsAttachServices.indexOf("Select")) {
				var currentTD = inp.closest("td");

				var selectedConts = tblConts.DataTable()
					.rows('.selected')
					.data().toArray()
					.map(x => x[_cols.indexOf("CntrNo")]);

				var currentCjMode = inp.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("CjMode_CD") + ")").text();
				if (_attachServicesChecker.length > 0) {
					var contHasThisServices = _attachServicesChecker.filter(p => selectedConts.indexOf(p.CntrNo) != -1 && p.CJMode_CD == currentCjMode)
						.map(x => x.CntrNo);

					_attachServicesChecker.filter(p => contHasThisServices.indexOf(p.CntrNo) != -1 && p.CJMode_CD == currentCjMode)
						.map(x => x.Select = (inp.is(":checked") ? 1 : 0));

					var contNonService = selectedConts.filter(p => contHasThisServices.indexOf(p) == -1);
					$.each(contNonService, function(idx, iContNo) {
						_attachServicesChecker.push({
							Select: inp.is(":checked") ? 1 : 0,
							CntrNo: iContNo.toUpperCase(),
							CJMode_CD: currentCjMode
						});
					});
				} else {
					$.each(selectedConts, function(idx, iContNo) {
						_attachServicesChecker.push({
							Select: inp.is(":checked") ? 1 : 0,
							CntrNo: iContNo.toUpperCase(),
							CJMode_CD: currentCjMode
						});
					});
				}

				//thay đổi số lượng chọn khi check/uncheck
				var plusOrSubtract = inp.is(":checked") ? 1 : -1;

				var oldNumCell = currentTD.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("Cont_Count") + ")");
				var oldNum = tblAttach.DataTable().cell(oldNumCell).data();
				var newNum = (oldNum ? parseInt(oldNum) : 0) + (selectedConts.length * plusOrSubtract);

				tblAttach.DataTable().cell(oldNumCell).data(newNum > 0 ? newNum : "");

				if ($('#chk-view-inv').is(':checked')) {
					loadpayment();
				} else {
					$('#tbl-inv').dataTable().fnClearTable();
				}
			}

			var crCell = inp.closest('td');
			var crRow = inp.closest('tr');
			var eTable = tblAttach.DataTable();

			eTable.cell(crCell).data(crCell.html()).draw(false);
			eTable.row(crRow).nodes().to$().addClass("editing");
		});

		// ----- FOR ATTACH SERVICES

		$('#remove').on('click', function() {
			if ($('#chk-view-inv').is(':checked')) return;

			if (tblConts.DataTable().rows().count() == 0) {
				return;
			}

			if (tblConts.DataTable().rows('.selected').count() == 0) {
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

							tblConts.DataTable().rows('.selected').remove().draw(false);
							tblConts.updateSTT();

							tblInv.DataTable().clear().draw();
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

		tblConts.DataTable().on('autoFill', function(e, datatable, cells) {
			var startRowIndex = cells[0][0].index.row,
				dtTbl = tblConts.DataTable();

			var fillCntrNo = cells[0].filter(p => p.index.column == _cols.indexOf("CntrNo"));
			if (fillCntrNo && fillCntrNo.length > 0) {
				var cntrNoCell = dtTbl.cell(startRowIndex, _cols.indexOf("CntrNo")).nodes().to$();
				onChangeCntrNo(cntrNoCell);
			}

			// if autofill not contain Local SZTP column -> return;
			var fillLocalSZTPCol = cells[0].filter(p => p.index.column == _cols.indexOf("LocalSZPT"));

			if (!fillLocalSZTPCol || fillLocalSZTPCol.length == 0) {
				return;
			}

			var localSZ = dtTbl.cell(startRowIndex, _cols.indexOf("LocalSZPT")).data(),
				opr = dtTbl.cell(startRowIndex, _cols.indexOf("OprID")).data(),
				iso = "";

			if (localSZ && opr) {
				iso = _sztp.filter(p => p.OprID == opr && p.LocalSZPT == localSZ).map(x => x.ISO_SZTP);
			}

			$.each(cells, function(idx, item) {
				var checkOpr = dtTbl.cell(item[0].index.row, _cols.indexOf("OprID")).data();

				if (checkOpr.includes("input")) {
					checkOpr = $(checkOpr).val();
				}

				if (!checkOpr) {
					toastr["error"]("Chưa chọn hãng khai thác!");
					dtTbl.cell(item[0].index.row, _cols.indexOf("LocalSZPT")).data("");
					return;
				}

				var checkISO = _sztp.filter(p => p.OprID == checkOpr && p.LocalSZPT == localSZ).map(x => x.ISO_SZTP)[0];

				if (!checkISO) {
					toastr["error"]("Kích cỡ không phù hợp với hãng khai thác đã chọn!");
					dtTbl.cell(item[0].index.row, _cols.indexOf("LocalSZPT")).data("");
					return;
				}

				dtTbl.cell(item[0].index.row, _cols.indexOf("ISO_SZTP")).data(iso);
			});
		});

		tblConts.on('change', 'td', function(e) {
			var colidx = $(e.target).index();

			if (colidx == _cols.indexOf("CntrNo")) {
				onChangeCntrNo($(e.target));
			}

			if (colidx == _cols.indexOf("OprID")) {
				onChangeOpr($(e.target))
			}

			if (colidx == _cols.indexOf("LocalSZPT")) {
				onChangeLocalSZTP($(e.target));
			}

			var ridx = $(e.target).closest('tr').index();
			if (_lstEir.length > 0) {
				var celldata = tblConts.DataTable().cell($(e.target)).data();
				_lstEir[ridx][_cols[colidx]] = celldata.includes("input") ? $(celldata).val() : celldata;
			}

			if ($.inArray(colidx, _cols.getIndexs(["OprID", "LocalSZPT", "ISO_SZTP", "CARGO_TYPE"])) != "-1") {
				$('#tbl-inv').DataTable().clear().draw();
			}
		});

		$("#save-payer").on("click", function() {
			var addTaxCode = $("#add-payer-taxcode").val();
			var addPayerName = $("#add-payer-name").val();
			var address = $("#add-payer-address").val();

			if (!addTaxCode) {
				$("#add-payer-taxcode").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập thông tin [Mã số thuê]!");
				return;
			}

			var checkTaxCode = addTaxCode;
			checkTaxCode = checkTaxCode.replace("-", "");

			if ([10, 13].indexOf(checkTaxCode.length) == "-1" || isNaN(checkTaxCode)) {
				$("#add-payer-taxcode").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập đúng định dạng [Mã số thuế]!");
				return;
			}

			if (!addPayerName) {
				$("#add-payer-name").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập thông tin [Tên]!");
				return;
			}

			var formData = {
				'action': 'save',
				'act': 'save_new_payer',
				'taxCode': addTaxCode,
				'cusName': addPayerName,
				'address': address
			};

			save_new_payer(formData);
		});

		$('#pay-atm').on('click', function() {
			if ($("input[name='publish-opt']:checked").val() == "e-inv") {
				publishInv();
			} else {
				saveData();
			}
		});

		$('#save-credit').on("click", function() {
			saveData();
		});

		$(document).on('change', 'input, select', function(e) {
			if ($(this).parent().is('td')) {
				if (_lstEir.length > 0) {
					var colidx = $(this).closest('tr').children().index($(this).parent());
					var ridx = $(this).closest('tr').index();
					_lstEir[ridx][_cols[colidx]] = $(this).val();
				}
				if ($.inArray(colidx, [2, 4, 5, 8, 17]) != "-1") {
					$('#tbl-inv').DataTable().clear().draw();
				}
			} else {
				changed(e);
			}
		});

		//function
		var typingTimer;

		function changed(e) {
			var cr = e.target;
			if ($(cr).attr('id') == "taxcode") {
				fillPayer();
				clearTimeout(typingTimer);
			}
			if ($(cr).val()) {
				$(cr).removeClass('error');
				$(cr).parent().removeClass('error');
			}
			if (_lstEir.length > 0) {
				$.each(_lstEir, function(idx, item) {
					eir_base(item);
				});
			}
			typingTimer = window.setTimeout(function() {
				//reset list eir
				if ($('.input-required.error').length == 0 && $(cr).attr('id') == "taxcode" && $(cr).val() && $('#chk-view-inv').is(':checked')) {
					loadpayment();
				}
			}, 1000);
		}

		function eir_base(item) {
			item['ShipKey'] = 'STORE';
			item['ShipID'] = 'STORAGE';
			item['ShipYear'] = '0000';
			item['ShipVoy'] = '0000';
			item['IssueDate'] = $('#ref-date').val(); //*
			item['ExpDate'] = $('#ref-exp-date').val(); //*
			item['NameDD'] = $('#personal-name').val();

			item['IsTruckBarge'] = $('input[name="chkSalan"]').is(':checked') ? "B" : "T";
			item['BARGE_CODE'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[0] : "";
			item['BARGE_YEAR'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[1] : "";
			item['BARGE_CALL_SEQ'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[2] : "";

			item['DMETHOD_CD'] = $('input[name="chkSalan"]').is(':checked') ? "BAI-SALAN" : "BAI-XE";
			item['TruckNo'] = '';

			item['PersonalID'] = $('#cmnd').val();
			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*

			if ($('#mail').val()) {
				item['Mail'] = $('#mail').val();
			}

			item['PAYER_TYPE'] = getPayerType($('#cusID').val());
			item['CusID'] = $('#cusID').val(); //*

			item['CntrClass'] = 2; //*
			item['Status'] = 'E'; //*

			if( $('#blno').val() ){
				item['BLNo'] = $('#blno').val(); //*
			}

			item['DELIVERYORDER'] = $('#do').val(); //*

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['CJMode_CD'] = 'TRAR'; //*
			item['CJModeName'] = 'Trả rỗng'; //*
		}

		function addCntrToEir(row) {
			var item = {};
			eir_base(item);
			for (var i = 1; i <= 9; i++) {
				if (i == 3) {
					item[_cols[i]] = row[i].toUpperCase();
				} else {
					item[_cols[i]] = row[i];
				}
			}

			if (item.EIR_SEQ == 0) {
				item['EIR_SEQ'] = 1;
			}
			_lstEir.push(item);
			mapDataAgain(_lstEir);
		}

		//------FUNCTION
		function mapDataAgain(data) {
			$.each(data, function() {
				if (_cargoTypes.filter(p => p.Code == this["CARGO_TYPE"]).length == 0) {
					this["CARGO_TYPE"] = _cargoTypes.filter(p => p.Description == this["CARGO_TYPE"]).map(x => x.Code)[0];
				}

				if (_localForeign.filter(p => p.Code == this["IsLocal"]).length == 0) {
					var lc = _localForeign.filter(p => p.Name == this["IsLocal"]).map(x => x.Code)[0];
					this["IsLocal"] = lc ? lc : "";
				}
				if (_transists.filter(p => p.Transit_CD == this["Transist"]).length == 0 && this[
						"Transist"]) {
					this["Transist"] = _transists.filter(p => p.Transit_Name.toUpperCase() == this[
							"Transist"].toUpperCase())
						.map(x => x.Transit_CD)[0] || "";
				}
				if (_terminals.filter(p => p.GNRL_CODE == this["TERMINAL_CD"]).length == 0 && this[
						"TERMINAL_CD"]) {
					this["TERMINAL_CD"] = _terminals.filter(p => p.GNRL_NM.toUpperCase() == this[
							"TERMINAL_CD"].toUpperCase())
						.map(x => x.GNRL_CODE)[0] || "";
				}
			});

			return data;
		}

		function loadpayment() {
			if (_lstEir.length == 0) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if ($('.input-required.error').length > 0) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if ($('.input-required').has_required()) {
				$('#tbl-inv').DataTable().clear().draw();
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#cusID').val(),
				'list': JSON.stringify(_lstEir)
			};

			if ($("#chkServiceAttach").is(":checked")) {
				addCntrToAttachSRV();

				if (_lstAttachService && _lstAttachService.length > 0) {
					formdata['nonAttach'] = JSON.stringify(_lstAttachService);
				}
			}

			$('#tbl-inv').waitingLoad();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					EirNo_Draft = null //reset EirDraft
					if (data.no_payer) {
						$(".toast").remove();
						toastr["error"](data.no_payer);

						tblInv.dataTable().fnClearTable();
						return;
					}

					if (data.no_tariff_end) {
						$(".toast").remove();
						toastr["error"](data.no_tariff_end);
						tblInv.dataTable().fnClearTable();
						return;
					}

					if (data.no_tariff) {
						$(".toast").remove();
						toastr["warning"](data.no_tariff);
					}

					if (data.error && data.error.length > 0) {
						$(".toast").remove();
						$.each(data.error, function(idx, err) {
							toastr["error"](err);
						});

						tblInv.dataTable().fnClearTable();
						return;
					}

					var rows = [];
					if (data.results && data.results.length > 0) {
						var lst = data.results,
							stt = 1;
						for (i = 0; i < lst.length; i++) {

							rows.push([
								(stt++), lst[i].DraftInvoice, lst[i].OrderNo ? lst[i].OrderNo : "", lst[i].TariffCode, lst[i].TariffDescription, lst[i].Unit, lst[i].JobMode == 'GO' ? "Nâng vỏ" : "Hạ vỏ", lst[i].DeliveryMethod, lst[i].Cargotype, lst[i].ISO_SZTP, lst[i].FE, lst[i].IsLocal, lst[i].Quantity, lst[i].StandardTariff, 0, lst[i].DiscountTariff, lst[i].DiscountedTariff, lst[i].Amount, lst[i].VatRate, lst[i].VATAmount, lst[i].SubAmount, lst[i].Currency, lst[i].IX_CD, lst[i].CNTR_JOB_TYPE, lst[i].VAT_CHK
							]);
						}
					}
					if (rows.length > 0) {
						var n = rows.length;
						rows.push([
							n, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', data.SUM_AMT, '', data.SUM_VAT_AMT, data.SUM_SUB_AMT, '', '', '', ''
						]);
						$('#AMOUNT').text($.formatNumber(data.SUM_AMT, {
							format: "#,###",
							locale: "us"
						}));
						$('#DIS_AMT').text($.formatNumber(data.SUM_DIS_AMT, {
							format: "#,###",
							locale: "us"
						}));
						$('#VAT').text($.formatNumber(data.SUM_VAT_AMT, {
							format: "#,###",
							locale: "us"
						}));
						$('#TAMOUNT').text($.formatNumber(data.SUM_SUB_AMT, {
							format: "#,###",
							locale: "us"
						}));
					}
					$('#tbl-inv').DataTable({
						data: rows,
						info: false,
						paging: false,
						searching: false,
						buttons: [],
						columnDefs: [{
								targets: [0],
								className: "text-center"
							},
							{
								targets: [12, 21],
								className: "text-right"
							},
							{
								targets: [13, 14, 15, 16, 17, 18, 19, 20],
								className: "text-right",
								render: $.fn.dataTable.render.number(',', '.', 2)
							},
							{
								targets: [22, 23, 24],
								className: "hiden-input"
							}
						],
						scrollY: '30vh',
						createdRow: function(row, data, dataIndex) {
							if (dataIndex == rows.length - 1) {
								$(row).addClass('row-total');

								$('td:eq(0)', row).attr('colspan', 17);
								$('td:eq(0)', row).addClass('text-center');
								for (var i = 1; i <= 16; i++) {
									$('td:eq(' + i + ')', row).css('display', 'none');
								}

								this.api().cell($('td:eq(0)', row)).data('TỔNG CỘNG');
							}
						}
					});
				},
				error: function(err) {
					$(".toast").remove();
					toastr["error"]("ERROR!");

					tblInv.dataTable().fnClearTable();
					console.log(err);
				}
			});
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

		function extendSelectOnGrid() {

			//------SET AUTOCOMPLETE
			var tblContsHeader = tblConts.parent().prev().find('table');

			tblContsHeader.find(' th:eq(' + _cols.indexOf('LocalSZPT') + ') ').setSelectSource(_sztp.map(x => x.LocalSZPT)
				.filter((el, i, a) => i === a.indexOf(el)));
			tblContsHeader.find(' th:eq(' + _cols.indexOf('OprID') + ') ').setSelectSource(_oprs.map(p => p.CusID));
			tblContsHeader.find(' th:eq(' + _cols.indexOf('CARGO_TYPE') + ') ').setSelectSource(_cargoTypes.map(p => p.Description));
			tblContsHeader.find(' th:eq(' + _cols.indexOf('IsLocal') + ') ').setSelectSource(_localForeign.map(p => p.Name));
			tblContsHeader.find(' th:eq(' + _cols.indexOf('Transist') + ') ').setSelectSource(_transists.map(p => p
				.Transit_Name));
			tblContsHeader.find(' th:eq(' + _cols.indexOf('TERMINAL_CD') + ') ').setSelectSource(_terminals.map(p =>
				p.GNRL_NM));
			//------SET AUTOCOMPLETE
			//------SET MORE BUTTON FOR COLUMNS
			tblConts.moreButton({
				columns: [_cols.indexOf("TERMINAL_CD")],
				onShow: function(cell) {
					var cellIdx = cell.parent().index();
					$("#apply-terminal").val(cellIdx + "." + _cols.indexOf("TERMINAL_CD"));
				}
			});
			//------SET DROPDOWN BUTTON FOR COLUMN
			tblConts.columnDropdownButton({
				data: [{
						colIndex: _cols.indexOf("OprID"),
						source: _oprs.map(p => p.CusID)
					},
					{
						colIndex: _cols.indexOf("LocalSZPT"),
						source: _sztp.map(x => x.LocalSZPT).filter((el, i, a) => i === a.indexOf(el))
					},
					{
						colIndex: _cols.indexOf("IsLocal"),
						source: _localForeign
					},
					{
						colIndex: _cols.indexOf("CARGO_TYPE"),
						source: _cargoTypes
					},
					{
						colIndex: _cols.indexOf("Transist"),
						source: _transists.map(p => p.Transit_Name)
					},
				],
				onSelected: function(cell, itemSelected) {
					var temp = "<input type='text' value='" + itemSelected.attr("code") + "' class='hiden-input'>" + itemSelected.text();

					tblConts.DataTable().cell(cell).data(temp).draw(false);

					tblConts.DataTable().cell(cell.parent().index(), cell.next()).focus();

					if( cell.index() == _cols.indexOf("OprID") ){
						onChangeOpr( cell );
						tblInv.dataTable().fnClearTable();
					}

					if (cell.index() == _cols.indexOf("LocalSZPT")) {
						onChangeLocalSZTP(cell);
						tblInv.dataTable().fnClearTable();
					}
				}
			});
			//------SET DROPDOWN BUTTON FOR COLUMN

			tblConts.editableTableWidget();
		}

		function onChangeLocalSZTP(cell) {
			var localSZ = cell.text(),
				dtC = tblConts.DataTable(),
				rowIdx = dtC.cell(cell).index().row,
				opr = dtC.cell(rowIdx, _cols.indexOf("OprID")).data(),
				iso = "",
				cargoType = "",
				cargoWeight = 0;

			if (opr.includes("input")) {
				opr = $(opr).val();
			}

			if (!localSZ) {
				dtC.cell(rowIdx, _cols.indexOf("ISO_SZTP")).data("");
				return;
			}

			if (!opr) {
				$(".toast").remove();
				toastr["warning"]("Chưa chọn hãng khai thác!");
				localSZ = "";
			} else {
				iso = _sztp.filter(p => p.LocalSZPT.trim().toUpperCase() == localSZ.trim().toUpperCase() &&
						p.OprID.trim().toUpperCase() == opr.trim().toUpperCase())
					.map(x => x.ISO_SZTP)[0];

				if (!iso) {
					$(".toast").remove();
					toastr["error"]("Kích cỡ nội bộ không đúng hoặc không phù hợp với hãng khai thác đã chọn!");
					localSZ = "";
					iso = "";
				} else {
					cargoType = iso.substr(2, 1) == "R" ? "<input class='hiden-input' value='ER'> Empty Reefer" :
						"<input class='hiden-input' value='MT'> Empty";
					cargoWeight = getContWeight(iso);
				}
			}

			if (localSZ == "") {
				dtC.cell(cell).data("");
			}

			dtC.cell(rowIdx, _cols.indexOf("ISO_SZTP")).data(iso ? iso.trim().toUpperCase() : "");
			dtC.cell(rowIdx, _cols.indexOf("CARGO_TYPE")).data(cargoType);
			dtC.cell(rowIdx, _cols.indexOf("CMDWeight")).data(cargoWeight);

			dtC.cell(rowIdx, _cols.indexOf("ISO_SZTP") + 1).focus();
		}

		var oldCntrNoCheck = '';

		function onChangeCntrNo(cell) {
			var arrConts = tblConts.DataTable().columns(_cols.indexOf("CntrNo")).data().toArray()[0];
			if (arrConts.filter(p => p == cell.text()).length > 1) {
				$.alert({
					title: 'Cảnh báo!',
					content: 'Container [' + cell.text() + '] bị trùng!',
					type: 'red'
				});
				oldCntrNoCheck = "";
				return;
			}

			if (oldCntrNoCheck == cell.text()) {
				oldCntrNoCheck = "";
				return;
			}

			oldCntrNoCheck = cell.text();
			var formData = {
				'action': 'view',
				'act': 'check_cntr_no',
				'cntrNo': cell.text()
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.error) {
						oldCntrNoCheck = "";
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					if (data.cntr_hold_by_config) {
						oldCntrNoCheck = '';
						$.confirm({
							title: 'Cảnh báo!',
							type: 'orange',
							icon: 'fa fa-warning',
							columnClass: 'col-md-5 col-md-offset-3',
							content: `<strong style="font-size: 20px;color: red;">Container [${formData.cntrNo}] ${data.hold_content} </strong> <br> Tiếp tục làm lệnh?`,
							buttons: {
								ok: {
									text: 'YES',
									btnClass: 'btn-primary',
									keys: ['Enter'],
									action: function() {
										var nextCell = cell.next('td').focus();
										tblConts.DataTable().cell(nextCell).focus();
									}
								},
								cancel: {
									text: 'NO',
									btnClass: 'btn-default',
									keys: ['ESC'],
									action: function() {
										_lstAttachService = _lstAttachService.filter(p => p.CntrNo != formData.cntrNo);
										_attachServicesChecker = _attachServicesChecker.filter(p => p.CntrNo != formData.cntrNo);

										tblConts.DataTable().rows('.selected').nodes().to$().removeClass("selected");
										tblConts.DataTable().cell(cell).data("");

										var cellCheked = tblAttach.find("tbody tr")
											.find('input[type="checkbox"]:checked').closest("td");

										$.each(cellCheked, function(idx, cell) {
											tblAttach.DataTable().cell(cell).data('<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>');
										});

										tblInv.dataTable().fnClearTable();

										tblConts.DataTable().cell(cell).focus();
										cell.focus();
									}
								}
							}
						});
					}

					if (data.cont_not_allow || data.is_stacking) {
						oldCntrNoCheck = '';
						$(".toast").remove();

						toastr.options.timeOut = "0";

						var txt = data.cont_not_allow ? "đã được làm lệnh" : "đang tồn trên bãi";

						toastr["error"]("Container [" + formData.cntrNo + "] " + txt + "! <br> Vui lòng kiểm tra lại!");
						toastr.options.timeOut = "5000";

						_lstAttachService = _lstAttachService.filter(p => p.CntrNo != formData.cntrNo);
						_attachServicesChecker = _attachServicesChecker.filter(p => p.CntrNo != formData.cntrNo);

						tblConts.DataTable().rows('.selected').nodes().to$().removeClass("selected");
						tblConts.DataTable().cell(cell).data("");

						var cellCheked = tblAttach.find("tbody tr")
							.find('input[type="checkbox"]:checked').closest("td");

						$.each(cellCheked, function(idx, cell) {
							tblAttach.DataTable().cell(cell).data('<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>');
						});

						tblInv.dataTable().fnClearTable();
						return;
					}

				},
				error: function(err) {
					oldCntrNoCheck = '';
					$('#payment-modal').find('.modal-content').unblock();
					console.log(err);
				}
			});
		}

		function onChangeOpr(cell) {
			var dtC = tblConts.DataTable(),
				rowIdx = dtC.cell(cell).index().row,
				opr = dtC.cell(cell).data(),
				localSz = dtC.cell(rowIdx, _cols.indexOf("LocalSZPT")).data();

			if (opr.includes("input")) {
				opr = $(opr).val();
			}

			if (localSz.includes("input")) {
				localSz = $(localSz).val();
			}

			if (opr) {
				var lcSzSource = _sztp.filter(p => p.OprID.trim().toUpperCase() == opr.trim().toUpperCase()).map(x => x.LocalSZPT)
				tblConts.setDropdownSource(_cols.indexOf("LocalSZPT"), lcSzSource);

				tblConts.parent().prev().find('table')
					.find(' th:eq(' + _cols.indexOf('LocalSZPT') + ') ')
					.setSelectSource(lcSzSource);

				if (lcSzSource.indexOf(localSz) == -1) {
					dtC.cell(rowIdx, _cols.indexOf("LocalSZPT")).data("");
					dtC.cell(rowIdx, _cols.indexOf("ISO_SZTP")).data("");
				}
			} else {
				dtC.cell(rowIdx, _cols.indexOf("LocalSZPT")).data("");
				dtC.cell(rowIdx, _cols.indexOf("ISO_SZTP")).data("");
			}
		}

		function load_payer() {
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
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
				},
				error: function(err) {
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		};

		function getContWeight($sztype) {
			switch ($sztype.substr(0, 1)) {
				case "2":
					return "2.00";
				default:
					return "3.50";
			}
		}

		function search_barge() {
			$("#search-barge").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_barge'
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					var rows = [];
					$('#search-barge').dataTable().fnClearTable();
					if (data.barges.length > 0) {
						for (i = 0; i < data.barges.length; i++) {
							rows.push([
								(i + 1), data.barges[i].ShipID, data.barges[i].ShipName, data.barges[i].ShipYear, data.barges[i].ShipVoy
							]);
						}
						$('#search-barge').DataTable({
							paging: false,
							infor: false,
							scrollY: '25vh',
							buttons: [],
							data: rows,
						});
					}
				},
				error: function(err) {
					$('#search-barge').dataTable().fnClearTable();
					console.log(err);
				}
			});
		}

		function fillPayer() {
			if (payers.length == 0) {
				return;
			}

			var py = payers.filter(p => p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());
			if (py.length > 0) { //fa-check-square
				$('#p-taxcode').text($('#taxcode').val());
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);
				$('#payment-type').attr('data-value', py[0].CusType);
				$('#payment-type').text(py[0].CusType == 'M' ? "THU NGAY" : "THU SAU");
				if (py[0].CusType == "M") {
					$('#p-money i').removeClass('fa-square').addClass('fa-check-square');
					$('#p-credit i').removeClass('fa-check-square').addClass('fa-square');
					$("#t-mb").prop("disabled",false)
				} else {
					$('#p-money i').removeClass('fa-check-square').addClass('fa-square');
					$('#p-credit i').removeClass('fa-square').addClass('fa-check-square');
					$("#t-mb").prop("disabled",true)
				}

				$("#cmnd").val(py[0].PersonalID);
				$("#personal-name").val(py[0].NameDD);
				if (py[0].Email) {
					$("#mail").val(py[0].Email);
				}
				if (py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email) {
					$("#mail").val($("#mail").val() + ',' + py[0].EMAIL_DD);
				}

				$("#taxcode").removeClass("error");
			}
		}
				function handleClickPayQrMb(EirNo) {
				const totalAmount = $('#TAMOUNT').text() || '0';
				const numericAmount = totalAmount.replace(/[^\d]/g, '');
				const amount = parseInt(numericAmount) || 1000;
				const customerName = $('#p-payername').text();
				const customerTaxCode = $('#p-taxcode').text();
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
							if ($("input[name='publish-opt']:checked").val() == "e-inv") {
								toastr["success"]("Tiến hành xuất hóa đơn <br> Vui lòng không thao tác !");
								publishInvQR(data.EirNo)
							} else {
								handlePaymentSuccess(null,data.EirNo)
							}
					}
					else {
						toastr["error"]("Không tìm thấy thông tin!");
					}
				};
				//handle tab close
				window.onPaymentClosed = function () {
					$('#payment-modal').find('.modal-content').unblock();
					$('#payment-method-select').val("")
				};
					// Đóng tab con khi tab cha đóng hoặc reload
				window.addEventListener('beforeunload', () => {
					if (modalQrPayment && !modalQrPayment.closed) {
						modalQrPayment.close();
					}
				});
        }
//PUBLISH INV QR PAYMENT
        function publishInvQR(EirNo) {
            $('#payment-modal').find('.modal-content').blockUI();
            var datas = getInvDraftDetail();
            var formData = {
                cusTaxCode: $('#p-taxcode').text(),
                cusAddr: $('#p-payer-addr').text(),
                cusName: $('#p-payername').text(),
                sum_amount: $('#AMOUNT').text(),
                vat_amount: $('#VAT').text(),
                total_amount: $('#TAMOUNT').text(),
                paymentMethod: 'CK',
                datas: datas
            };

            $.ajax({
                url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function(data) {
                    if (data.error) {
                        $(".toast").remove();
                        toastr["error"](data.error);
                        return;
                    }
                    handlePaymentSuccess(data,EirNo);
                },
                error: function(err) {
                    $('#payment-modal').find('.modal-content').unblock();
                    console.log(err);
                }
            });
        }
		//PUBLISH INV
		function publishInv() {
			$('#payment-modal').find('.modal-content').blockUI();
			var datas = getInvDraftDetail();
			var formData = {
				cusTaxCode: $('#p-taxcode').text(),
				cusAddr: $('#p-payer-addr').text(),
				cusName: $('#p-payername').text(),
				sum_amount: $('#AMOUNT').text(),
				vat_amount: $('#VAT').text(),
				total_amount: $('#TAMOUNT').text(),
				datas: datas
			};

			$.ajax({
				url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.error) {
						$(".toast").remove();
						toastr["error"](data.error);
						$('#payment-modal').find('.modal-content').unblock();
						return;
					}

					saveData(data);
				},
				error: function(err) {
					$('#payment-modal').find('.modal-content').unblock();
					console.log(err);
				}
			});
		}

		//SAVE DATA
		function saveData(invInfo, draft = true) {
			var drDetail = getInvDraftDetail();
			var drTotal = {};
			$.each($('#INV_DRAFT_TOTAL').find('span'), function(idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});
			var publish_opt_checked = $("input[name='publish-opt']:checked").val();
			if(!draft) {
                _lstEir.map(x => x.publishType = publish_opt_checked ? publish_opt_checked : "e-inv");
                _lstEir.map(x => x.Type_Eir = 'Lệnh Hạ Cont Rỗng');
				_lstEir.map(x => x.Note = $('#remark').val());
				_lstEir.map(x => x.SHIPPER_NAME = $('#shipper-name').val());
				_lstEir.map(x => x.PersonalID = $('#cmnd').val());
				_lstEir.map(x => x.NameDD = $('#personal-name').val());
				_lstEir.map(x => x.Mail = $('#mail').val());
            }
			else {
				_lstEir.map(x => {
						delete x.publishType;
						delete x.Type_Eir;
					});
			}
			var formData = {
				'action': draft ? 'save' : 'save_draft',
				'data': {
					'pubType': publish_opt_checked ? publish_opt_checked : "credit",
					'eir': _lstEir,
					'draft_detail': drDetail,
					'draft_total': drTotal
				}
			};

			if (formData.data.pubType != 'credit' && (!drDetail || drDetail.length == 0)) {
				$('#payment-modal').find('.modal-content').unblock();
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin tính cước!');
				return;
			}

			//get attach service for save
			if (_lstAttachService.length > 0) {
				formData['data']['odr'] = _lstAttachService; //JSON.stringify();
			}
			//get attach service for save

			if (typeof invInfo !== "undefined" && invInfo !== null) {
				formData.data["invInfo"] = invInfo;
			} else {
				//trg hop không phải xuất hóa đơn điện tử, block popup thanh toán ở đây
				$('#payment-modal').find('.modal-content').blockUI();
			}
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if(data.EIR_Draft) {
						EirNo_Draft = data.EIR
						return handleClickPayQrMb(data.EIR)
					}
					if (data.deny) {
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"](data.deny);
						return;
					}

					if (data.non_invInfo) {
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"](data.non_invInfo);
						return;
					}

					if (data.isDup) {
						$('#payment-modal').find('.modal-content').unblock();
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
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?= site_url(md5('Task') . '/' . md5('draft_success')); ?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "dftInfo";
						input.value = JSON.stringify(data.dftInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					} else {
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error) {
					console.log(xhr);
					$('.toast').remove();
					$('#payment-modal').find('.modal-content').unblock();
					toastr['error'](error);
				}
			});
		}
			function handlePaymentSuccess(invInfo,EirNo) {
                    var drDetail = getInvDraftDetail();
					var drTotal = {};
					$.each($('#INV_DRAFT_TOTAL').find('span'), function(idx, item) {
						drTotal[$(item).attr('id')] = $(item).text();
					});
					var publish_opt_checked = $("input[name='publish-opt']:checked").val();
                    var formData = {
                        'data': {
                            'pubType': publish_opt_checked ? publish_opt_checked : "credit",
                            'draft_detail': drDetail,
                            'draft_total': drTotal,
                            'EirNo': EirNo,
                        },
                    };
                    if (formData.data.pubType != 'credit' && (!drDetail || drDetail.length == 0)) {
                        $('#payment-modal').find('.modal-content').unblock();
                        $('.toast').remove();
                        toastr['warning']('Chưa có thông tin tính cước!');
                        return;
                    }
                    //get attach service for save
                    if (_lstAttachService.length > 0) {
                        formData['data']['odr'] = _lstAttachService; //JSON.stringify();
                    }
                    //get attach service for save
                    if (typeof invInfo !== "undefined" && invInfo !== null) {
                        formData.data["invInfo"] = invInfo;
                    } else {
                        //trg hop không phải xuất hóa đơn điện tử, block popup ở đây
                        $('#payment-modal').find('.modal-content').blockUI();
                    }
                    $.ajax({
                        url: "<?= site_url(md5('Task') . '/' . md5('paymentSuccess')); ?>",
                        dataType: 'json',
                        data: formData,
                        type: 'POST',
                        success: function(data) {
                            if (data.deny) {
                                    $('#payment-modal').find('.modal-content').unblock();
                                    toastr["error"](data.deny);
                                    return;
                                }

                                if (data.non_invInfo) {
                                    $('#payment-modal').find('.modal-content').unblock();
                                    toastr["error"](data.non_invInfo);
                                    return;
                                }

                                if (data.isDup) {
                                    $('#payment-modal').find('.modal-content').unblock();
                                    toastr["error"]("Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!");
                                    return;
                                }
                                
                                if (data.invInfo) {
                                    var form = document.createElement("form");
                                    form.setAttribute("method", "post");
                                    form.setAttribute("action",
                                        "<?= site_url(md5('Task') . '/' . md5('payment_success')); ?>");

                                    var input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = "invInfo";
                                    input.value = JSON.stringify(data.invInfo);
                                    form.appendChild(input);

                                    document.body.appendChild(form);
                                    form.submit();
                                    document.body.removeChild(form);
                                } else if (data.dftInfo) {
                                    var form = document.createElement("form");
                                    form.setAttribute("method", "post");
                                    form.setAttribute("action",
                                        "<?= site_url(md5('Task') . '/' . md5('draft_success')); ?>");

                                    var input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = "dftInfo";
                                    input.value = JSON.stringify(data.dftInfo);
                                    form.appendChild(input);

                                    document.body.appendChild(form);
                                    form.submit();
                                    document.body.removeChild(form);
                                } else {
                                    toastr["success"]("Lưu dữ liệu thành công!");
                                    location.reload(true);
                                }
                        },  
                        error: function(err) {
                            console.log(err);
                            $("#bookingno, #cntrno").parent().unblock();
                            toastr["error"]("Server error at [load_booking]");
                        }
                    });
            }
		function getInvDraftDetail() {
			var rows = [];
			$('#tbl-inv').find('tbody tr:not(.row-total)').each(function() {
				var nrows = [];
				var ntds = $(this).find('td:not(.dataTables_empty)');
				if (ntds.length > 0) {
					ntds.each(function(td) {
						nrows.push($(this).text() == "null" ? "" : $(this).text());
					});
					rows.push(nrows);
				}
			});

			var drd = [];
			if (rows.length == 0) return [];
			$.each(rows, function(idx, item) {
				var temp = {};
				for (var i = 1; i <= _colsPayment.length - 1; i++) {
					temp[_colsPayment[i]] = item[i];
				}
				temp['Remark'] = $.unique(_lstEir.map(p => p.CntrNo)).toString();
				temp['CARGO_TYPE']
				drd.push(temp);
			});
			return drd;
		}

		function save_new_payer(formData) {
			$(".add-payer-container").blockUI();
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {

					$(".add-payer-container").unblock();

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						toastr["error"](data.error);
						return;
					}

					toastr["success"]("Thêm mới thành công!");
					$(".add-payer-container").find("input").val("");

					var tblPayer = $('#search-payer');

					var dtTblPayer = tblPayer.DataTable();
					if (data.saveType == "add") {
						toastr["success"]("Thêm mới thành công!");

						var rowcount = dtTblPayer.rows().count();
						var row = [
							rowcount + 1, formData.taxCode, formData.taxCode, formData.cusName, formData.address, 'Thu ngay'
						];

						tblPayer.dataTable().fnAddData(row);

						dtTblPayer.page("last").draw("page");

						var lastRow = dtTblPayer.row(':last', {
							order: 'applied'
						});

						dtTblPayer.rows('.m-row-selected').nodes().to$().removeClass("m-row-selected");

						$(lastRow.node()).addClass("m-row-selected");

						dtTblPayer.search(formData.taxCode).draw(false);

						payers.push({
							Address: formData.address,
							CusID: formData.taxCode,
							CusName: formData.cusName,
							CusType: "M",
							IsAgency: "0",
							IsLogis: "0",
							IsOpr: "0",
							IsOther: "0",
							IsOwner: "1",
							IsTrans: "0",
							VAT_CD: formData.taxCode
						});
					}

					if (data.saveType == "edit") {
						toastr["success"]("Cập nhật thành công!");
						var indx = payers.findIndex(x => x.VAT_CD == formData.taxCode && x.CusType == 'M');
						payers[indx]["CusName"] = formData.cusName;
						payers[indx]["Address"] = formData.address;

						var indexes = dtTblPayer.rows().eq(0).filter(function(rowIdx) {
							return dtTblPayer.cell(rowIdx, 2).data() === formData.taxCode &&
								dtTblPayer.cell(rowIdx, 5).data() === 'Thu ngay';
						});

						if (indexes.toArray().length > 0) {
							var firstIdx = indexes.toArray()[0];

							dtTblPayer.rows('.m-row-selected').nodes().to$().removeClass("m-row-selected");
							dtTblPayer.rows(firstIdx).nodes().to$().addClass("m-row-selected");

							dtTblPayer.cell(firstIdx, 3).data(formData.cusName);
							dtTblPayer.cell(firstIdx, 4).data(formData.address);
							dtTblPayer.search(formData.taxCode);
							dtTblPayer.draw(false);
						}
					}

				},
				error: function(xhr, status, error) {
					console.log(xhr);

					$(".add-payer-container").unblock();
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra khi lưu dữ liệu! Vui lòng liên hệ KTV! ");
				}
			});
		}

		function addCntrToAttachSRV() {
			_lstAttachService = [];
			var attachSrvSelected = _attachServicesChecker.filter(p => p.Select == 1);

			if (attachSrvSelected.length > 0) {
				$.each(attachSrvSelected, function(index, elem) {
					var finds = _lstEir.filter(p => p.CntrNo == elem["CntrNo"])[0];

					var item = $.extend({}, finds);

					item['CJMode_CD'] = elem["CJMode_CD"];

					item['PTI_Hour'] = 0;

					item['cBlock1'] = item['cBlock'];
					item['cBay1'] = item['cBay'];
					item['cRow1'] = item['cRow'];
					item['cTier1'] = item['cTier'];

					deleteItemInArray(item, ["cBlock", "cBay", "cRow", "cTier", "CJModeName", "CLASS", "UNNO", "TERMINAL_CD", "IsTruckBarge", "TruckNo", "BookNo"]);

					_lstAttachService.push(item);
				});
			}
		}

		function deleteItemInArray(item, arrColName) {
			$.each(arrColName, function(idx, colname) {
				delete item[colname];
			});
		}

		function load_attach_srv() {
			$('#col-attach-service').blockUI();
			tblAttach.waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_attach_srv',
				'order_type': $("#cjmode").val()
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskPre_Advice')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					$('#col-attach-service').unblock();

					var rows = [];
					if (data.lists && data.lists.length > 0) {
						for (i = 0; i < data.lists.length; i++) {
							var r = [];

							$.each(_colsAttachServices, function(indx, colname) {
								if (colname == "Select") {
									var xxx = '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>';
									r.push(xxx);
								} else if (colname == "Checker") {
									r.push(0);
								} else {
									r.push(data.lists[i][colname] ? data.lists[i][colname] : "");
								}
							});
							rows.push(r);
						}
					}

					tblAttach.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblAttach.dataTable().fnAddData(rows);
					}

				},
				error: function(err) {
					$('#col-attach-service').unblock();
					console.log(err);
				}
			});
		}

		function loadAttachData(rowIndexes) {
			var cellCheked = tblAttach.find("tbody tr")
				.find('input[type="checkbox"]:checked').closest("td");

			$.each(cellCheked, function(idx, cell) {
				tblAttach.DataTable().cell(cell).data('<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>');
			});

			tblAttach.DataTable().draw(false);

			if (!rowIndexes || rowIndexes.length == 0) {
				return;
			}

			var allCntrNoSelected = tblConts.DataTable().rows(rowIndexes).data().toArray().map(p => p[_cols.indexOf("CntrNo")]);

			if (_attachServicesChecker.length > 0) {
				// var indexCells = [];
				$.each(tblAttach.find("tbody tr"), function() {
					var cjmode = $(this).find("td:eq(" + _colsAttachServices.indexOf("CjMode_CD") + ")").text();

					var itemChecked = _attachServicesChecker.filter(p => allCntrNoSelected.indexOf(p.CntrNo) != -1 && p.CJMode_CD == cjmode);
					if (itemChecked && itemChecked.length == allCntrNoSelected.length) {
						var cellSelect = $(this).find('td:eq(' + _colsAttachServices.indexOf("Select") + ')');

						cellSelect.find('input[type="checkbox"]')
							.val(itemChecked[0].Select)
							.prop('checked', itemChecked[0].Select == 1 ? true : false);

						// indexCells.push( cellSelect.index() );
					}
				});
			}
		}
	});
</script>
<script language="javascript" type="text/javascript">
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};
</script>

<!-- <script src="<?= base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script> -->
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>