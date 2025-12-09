<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/dataTables/extensions/select.dataTables.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css//ebilling.css'); ?>" rel="stylesheet" />

<style>
	#tb-attach-srv .btn-sm {
		padding-top: 0.15rem !important;
		padding-bottom: 0.15rem !important;
	}

	.selected {
		background: violet;
	}

	.MT-toggle,
	.PY-toggle {
		display: none;
	}

	.MT-toggle button,
	.PY-toggle button {
		background-color: #fff !important;
	}

	.form-group {
		margin-bottom: .5rem !important;
	}

	.grid-hidden {
		display: none;
	}

	.match-content {
		width: auto !important;
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

	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.nav-tabs {
		margin-bottom: 0 !important;
		border-bottom: none !important;
	}

	.nav-tabs .nav-link.active {
		color: #5c6bc0 !important;
		font-weight: 400 !important;
		font-size: 16px !important;
	}

	.nav-tabs .nav-link {
		font-size: 15px !important;
	}

	.bootstrap-select.btn-group:not(.input-group-btn),
	.bootstrap-select.btn-group[class*="col-"] {
		float: left !important;
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

	#conts-modal .dataTables_filter,
	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}
	
	table.dataTable tr.selected td.select-checkbox::after {
		color: black !important;
		margin-top: -25px !important;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH RÚT HÀNG CONTAINER</div>
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
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ngày lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="ref-date" type="text" placeholder="Ngày lệnh" readonly>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text" placeholder="Hạn lệnh">
											<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương án *</label>
									<div class="col-sm-8">
										<select id="service_code" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
											<option value="" selected="">-- Chọn phương án --</option>
											<?php if (isset($services) && count($services) > 0) {
												foreach ($services as $item) { ?>
													<option value="<?= $item['CJMode_CD'] ?>"><?= $item['CJMode_CD'] . " : " . $item['CJModeName'] ?></option>
											<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">PTGN *</label>
									<div class="col-sm-8">
										<select id="dmethod" class="selectpicker input-required" data-style="btn-default btn-sm" data-width="100%">
											<option value="">-- Chọn phương thức --</option>
											<option value="CONT-CONT">CONT <==> CONT</option>
											<option value="CONT-SALAN">CONT <==> SALAN</option>
											<option value="CONT-OTO">CONT <==> OTO</option>
											<option value="CONT-KHO">CONT <==> KHO</option>
										</select>
									</div>
								</div>
							</div>
							<!-- //////////////////////////////// -->
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">

								<div class="row form-group">
									<label class="col-sm-4 col-form-label">D/O *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm input-required" id="do" type="text" placeholder="D/O">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label pr-0">Số vận đơn</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="billNo" type="text" placeholder="Số vận đơn" style="text-transform: uppercase">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Số container</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input autofocus class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No." style="text-transform: uppercase">
											<span class="input-group-addon bg-white btn text-warning" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>

								<!-- <div class="row form-group">
									<label class="col-sm-4 col-form-label">Hãng khai thác</label>
									<div class="col-sm-8">
										<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="" selected>--chọn--</option>
										</select>
									</div>
								</div> -->
							</div>
						</div>
					</div>
					<!-- ///////////////////////// -->
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
									<label class="col-sm-2 col-form-label" title="Chủ hàng">Chủ hàng *</label>
									<div class="col-sm-10">
										<input class="form-control form-control-sm input-required" id="shipper-name" type="text" placeholder="Chủ hàng">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Đại diện</label>

									<div class="col-sm-10 input-group">
										<input class="form-control form-control-sm mr-2" id="cmnd" user-input=0 type="text" placeholder="Số CMND /Số ĐT" maxlength="20">
										<input class="form-control form-control-sm mr-2" id="personal-name" user-input=0 type="text" placeholder="Tên người đại diện" maxlength="50">
										<input class="form-control form-control-sm" id="mail" user-input=0 type="text" placeholder="Địa chỉ Email" style="width: 140px" maxlength="100">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Ghi chú</label>
									<div class="col-sm-10 input-group input-group-sm">
										<input class="form-control form-control-sm" id="remark" type="text" placeholder="Ghi chú" maxlength="500">
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
									<div class="col-sm-8">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text">
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
												<i class="ti-search"></i>
											</span>
										</div>
									</div>
									<input class="hiden-input" id="cusID" readonly>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name"> [Tên đối tượng thanh toán]</span>&emsp;
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Hình thức thanh toán">HTTT *</label>
									<div class="col-sm-8">
										<select id="payment-type" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="M">THU NGAY</option>
											<option value="C">THU SAU</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr"> [Địa chỉ]</span>&emsp;
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 my-box">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
							</button>
							<button id="show-ps-notify" class="btn btn-outline-secondary btn-sm hiden-input" data-toggle="modal" data-target="#notify-modal">
								<span class="btn-icon"><i class="fa fa-info"></i>Chi tiết cước</span>
							</button>
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
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr>
								<th>STT</th>
								<th>Số container</th>
								<th>Số vận đơn</th>
								<th>Hãng khai thác</th>
								<th>Kích cỡ nội bộ</th>
								<th>Kích cỡ ISO</th>
								<th>Hàng/Rỗng</th>
								<th>Số chì</th>
								<th>Loại hàng</th>
								<th>Hàng hóa</th>
								<th>Trọng lượng</th>
								<th>VGM</th>
								<th>Hàng Nội/Ngoại</th>
								<th>Chuyển cảng</th>
								<th>TLHQ</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
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
								<th>Hàng/rỗng </th>
								<th>Nội/ngoại</th>
								<th>Số lượng</th>
								<th>Đơn giá</th>
								<th>CK (%)</th>
								<th>Đơn giá CK</th>
								<th>Đơn giá sau CK</th>
								<th>Thành tiền</th>
								<th>VAT (%)</th>
								<th>Tiền VAT</th>
								<th>Tổng tiền</th>
								<th>Loại tiền</th>
								<th>IX_CD</th>
								<th>CNTR_JOB_TYPE</th>
								<th>VAT_CHK</th>
								<th>Remark</th>
								<th>TRF_DESC_MORE</th>
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
<!--payment modal-->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" data-backdrop="static">
	<div class="modal-dialog modal-dialog-mw-py" role="document">
		<div class="modal-content p-3">
			<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
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
										<?= $ssInvInfo['serial'] . substr("0000000" . $ssInvInfo['invno'], -7) ?>
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
									<button id="change-ssinvno" class="btn btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#change-ssinv-modal" title="Khai báo số hóa đơn sử dụng tiếp theo">
										<span class="btn-icon"><i class="fa fa-pencil"></i>Khai báo</span>
									</button>
								<?php } ?>
							</div>
						</div>

					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4" id="INV_DRAFT_TOTAL">
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
						<span class="btn-icon"><i class="fa fa-id-card"></i>Xác nhận thanh toán</span>
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
<!--conts modal-->
<div class="modal fade" id="conts-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-lg centered" role="document">
		<div class="modal-content" style="width: 860px;">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách container</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="conts-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th style="max-width: 10px!important;">Chọn</th>
								<th>Số container</th>
								<th>Kích cỡ</th>
								<th>Kích cỡ ISO</th>
								<th>Full/Empty</th>
								<th>Hãng Khai Thác</th>
								<th>Trọng Lượng</th>
								<th>Vị trí bãi</th>
								<th>Số Niêm Chì</th>
								<th>Hướng</th>
								<th>Ghi Chú</th>
								<th>TLHQ</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-conts">
						<span class="btn-label"><i class="ti-check"></i></span>Xác Nhận</button>
					<button class="btn btn-sm btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 965px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.9%">
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

<!--notify modal-->
<div class="modal fade" id="notify-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content" style="border-radius: 5px">
			<div class="modal-header" style="border-radius: 5px;background-color: #cdfde0;">
				<h4 class="modal-title text-primary font-bold" id="groups-modalLabel">Chi tiết Lưu Bãi/ Điện Lạnh</h4>
				<i class="btn fa fa-times text-primary" data-dismiss="modal"></i>
			</div>
			<div class="modal-body" style="border: 2px outset #ccc;margin:3px;border-radius: 5px;overflow-y: auto;max-height: 90vh">
				<h4>

				</h4>
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
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK", "Remark", "TRF_DESC_MORE"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_cols = ["STT", "CntrNo", "BLNo", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "SealNo", "CARGO_TYPE", "CmdID", "CMDWeight", "VGM", "IsLocal", "Transist", "cTLHQ"],
			_colsAttachServices = ["Select", "CjMode_CD", "CJModeName", "Cont_Count"],
			_colsContList = ["Check", "CntrNo", "LocalSZPT", "ISO_SZTP", "Status", "OprID", "CMDWeight", "Location", "SealNo", "CntrClass", "Remark", "cTLHQ"];

		var _lstOrder = [],
			_attachServicesChecker = [],
			_lstAttachService = [],
			_lstExtraService = [],
			_lstContainer = [],
			selected_cont = [],
			tblConts = $('#tbl-conts'),
			tblInv = $('#tbl-inv'),
			tblAttach = $('#tb-attach-srv'),
			tblContList = $('#conts-list');

		var payers = {};
		<?php if (isset($payers) && count($payers) > 0) { ?>
			payers = <?= json_encode($payers); ?>;
		<?php } ?>

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

		tblConts.DataTable({
			info: false,
			paging: false,
			searching: false,
			select: true,
			buttons: [],
			scrollY: '30vh'
		});
		
		tblContList.DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: true,
			scrollY: '45vh',
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: 0
			}],
			select: {
				style: 'multi+shift',
				selector: 'td:first-child'
			},
			order: [
				[1, 'asc']
			],
		});

		tblInv.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			columnDefs: [{
					targets: _colsPayment.getIndexs(['STT', 'CURRENCYID']),
					className: "text-center"
				},
				{
					targets: _colsPayment.indexOf('QTY'),
					className: "text-right"
				},
				{
					targets: _colsPayment.getIndexs(["standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT"]),
					className: "text-right",
					render: $.fn.dataTable.render.number(',', '.', 2)
				},
				{
					targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK", "Remark", "TRF_DESC_MORE"]),
					className: "hiden-input"
				}
			],
			scrollY: '30vh',
			createdRow: function(row, data, dataIndex) {
				if (!data[_colsPayment.indexOf('TRF_CODE')]) {
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

		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [{
					type: "num",
					className: 'text-center',
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

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date, #MT-exp-date').datetimepicker({
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:ss',
			todayHighlight: true,
			oneLine: true,
			minDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			controlType: 'select',
			autoclose: true,
			timeInput: true
		});
		$('#ref-exp-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function() {
			$('#ref-exp-date').val('');
		});

		// getContList();
		load_payer();

		// ----- FOR ATTACH SERVICES
		$("#service_code").on("change", function() {
			//reset attach service when change
			_attachServicesChecker = [];
			_lstAttachService = [];
			if ($(this).val()) {
				load_attach_srv();
			} else {
				tblAttach.dataTable().fnClearTable();
			}
		});

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

		var storedOption = {
			applyAll: 0,
			data: ''
		};

		var specialIndx = 0;

		function confirmServices(currentTD, selectedConts, currentCjMode) {
			var iContNo = selectedConts[specialIndx];

			if (!iContNo) {
				storedOption.applyAll = 0;
				storedOption.data = '';
				specialIndx = 0;
				return;
			}

			if (storedOption.applyAll == 1) {
				var setItem = {
					Select: 1,
					CntrNo: iContNo,
					CJMode_CD: currentCjMode
				};

				setItem[currentCjMode == 'SDD' ? "ExpPluginDate" : "ExpDate"] = storedOption.data;

				if (_attachServicesChecker.length > 0) {
					var hasItemIdx = _attachServicesChecker.filter(p => p.CntrNo == iContNo).map(x => _attachServicesChecker.indexOf(x));
					if (hasItemIdx.length > 0) {
						_attachServicesChecker[hasItemIdx[0]].Select = 1;

						_attachServicesChecker[hasItemIdx[0]][currentCjMode == 'SDD' ? "ExpPluginDate" : "ExpDate"] = storedOption.data;
					} else {
						_attachServicesChecker.push(setItem);
					}
				} else {
					_attachServicesChecker.push(setItem);
				}

				if (iContNo == selectedConts[selectedConts.length - 1]) {
					if ($('#chk-view-inv').is(':checked')) {
						loadpayment();
					} else {
						$('#tbl-inv').dataTable().fnClearTable();
					}
				}

				var oldNumCell = currentTD.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("Cont_Count") + ")");
				var oldNum = tblAttach.DataTable().cell(oldNumCell).data();

				tblAttach.DataTable().cell(oldNumCell).data((oldNum ? parseInt(oldNum) : 0) + 1);

				specialIndx++;
				confirmServices(currentTD, selectedConts, currentCjMode);
			} else {
				$.confirm({
					columnClass: 'col-md-4 col-md-offset-4 mx-auto',
					titleClass: 'font-size-17',
					title: 'Chọn hạn tính ' + (currentCjMode == "SDD" ? 'Điện Lạnh' : 'Lưu bãi') + ' container [' + iContNo + ']',
					content: '<div class="input-group-icon input-group-icon-left">' +
						'<span class="input-icon input-icon-left"><i class="fa fa-calendar" style="color: blue"></i></span>' +
						'<input class="form-control form-control-sm" id="select-datetime" type="text" placeholder="Chọn thời gian">' +
						'</div>' +
						'<div class="form-inline" >' +
						'<div id="calendar-inline" style="margin: auto">' +
						'</div>',
					onContentReady: function() {
						$('#calendar-inline').datetimepicker({
							dateFormat: 'dd/mm/yy',
							timeFormat: 'HH:mm',
							controlType: 'select',
							altField: "#select-datetime",
							minDate: new Date(_lstContainer.filter(p => p.CntrNo == iContNo).map(x => x.DateIn)[0]),
							maxDate: new Date(convertDateTimeFormat($("#ref-exp-date").val(), 'y-m-d')),
							altFieldTimeOnly: false
						});

						$('#select-datetime').val($('#ref-exp-date').val());
					},
					buttons: {
						allApply: {
							text: 'Áp dụng hết',
							btnClass: 'btn-sm btn-warning btn-confirm',
							keys: ['Enter'],
							action: function() {
								var input = this.$content.find('input#select-datetime');
								var errorText = this.$content.find('.text-danger');
								if (!input.val().trim()) {
									$.alert({
										title: "Thông báo",
										content: "Vui lòng chọn thời gian!.",
										type: 'red'
									});
									return false;
								} else {
									storedOption.applyAll = 1;
									storedOption.data = input.val();
									confirmServices(currentTD, selectedConts, currentCjMode);
								}
							}
						},
						ok: {
							text: 'Xác nhận',
							btnClass: 'btn-sm btn-primary btn-confirm',
							keys: ['Enter'],
							action: function() {
								var input = this.$content.find('input#select-datetime');
								var errorText = this.$content.find('.text-danger');
								if (!input.val().trim()) {
									$.alert({
										title: "Thông báo",
										content: "Vui lòng chọn thời gian!.",
										type: 'red'
									});
									return false;
								} else {
									if (_attachServicesChecker.length > 0) {
										var findIdx = _attachServicesChecker.findIndex(p => p.CntrNo == iContNo &&
											p.CJMode_CD == currentCjMode);
										if (findIdx > -1) {
											_attachServicesChecker[findIdx].Select = 1;
										} else {
											var temp3 = {
												Select: 1,
												CntrNo: iContNo,
												CJMode_CD: currentCjMode
											};

											temp3[currentCjMode == 'SDD' ? "ExpPluginDate" : "ExpDate"] = input.val();

											_attachServicesChecker.push(temp3);
										}
									} else {
										var temp4 = {
											Select: 1,
											CntrNo: iContNo,
											CJMode_CD: currentCjMode
										};

										temp4[currentCjMode == 'SDD' ? "ExpPluginDate" : "ExpDate"] = input.val();

										_attachServicesChecker.push(temp4);
									}

									storedOption.applyAll = 0;
									storedOption.data = '';

									if (iContNo == selectedConts[selectedConts.length - 1]) {
										if ($('#chk-view-inv').is(':checked')) {
											loadpayment();
										} else {
											$('#tbl-inv').dataTable().fnClearTable();
										}
									}

									var oldNumCell = currentTD.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("Cont_Count") + ")");
									var oldNum = tblAttach.DataTable().cell(oldNumCell).data();

									tblAttach.DataTable().cell(oldNumCell).data((oldNum ? parseInt(oldNum) : 0) + 1);

									specialIndx++;
									confirmServices(currentTD, selectedConts, currentCjMode);
								}
							}
						},
						cancel: {
							text: 'Hủy',
							btnClass: 'btn-sm',
							keys: ['ESC'],
							action: function() {
								storedOption.applyAll = 0;
								storedOption.data = '';

								currentTD.find("input:first").removeAttr("checked").val("");
								specialIndx = 0;

								tblAttach.DataTable().cell(currentTD).data(currentTD.html()).draw(false);
							}
						}
					}
				});
			}
		}

		tblAttach.on('change', 'tbody tr td input[type="checkbox"]', function(e) {

			var inp = $(e.target);

			var rowcontSelected = tblConts.DataTable().rows('.selected').data()[0];

			if (!rowcontSelected || rowcontSelected.length == 0 || !rowcontSelected[_cols.indexOf("CntrNo")]) {
				$(".toastr").remove();
				toastr["error"]("Vui lòng chọn ít nhất một container để đính kèm dịch vụ!");

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

			if (inp.closest("td").index() == _colsAttachServices.indexOf("Select")) {
				var currentTD = inp.closest("td");

				var selectedConts = tblConts.DataTable()
					.rows('.selected')
					.data().toArray()
					.map(x => x[_cols.indexOf("CntrNo")]);

				var currentCjMode = inp.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("CjMode_CD") + ")").text();

				if (currentCjMode == 'SDD' || currentCjMode == 'LBC') {
					if (!inp.is(":checked")) {
						_attachServicesChecker = _attachServicesChecker.filter(p => selectedConts.indexOf(p.CntrNo) == -1 && p.CJMode_CD == currentCjMode);

						//giảm số lượng chọn khi uncheck
						var oldNumCell = currentTD.closest("tr").find("td:eq(" + _colsAttachServices.indexOf("Cont_Count") + ")");
						var oldNum = tblAttach.DataTable().cell(oldNumCell).data();
						var newNum = (oldNum ? parseInt(oldNum) : 0) - selectedConts.length

						tblAttach.DataTable().cell(oldNumCell).data(newNum > 0 ? newNum : 0);

						if ($('#chk-view-inv').is(':checked')) {
							loadpayment();
						} else {
							$('#tbl-inv').dataTable().fnClearTable();
						}
					} else {
						confirmServices(currentTD, selectedConts, currentCjMode);
					}
				} else {
					if (_attachServicesChecker.length > 0) {
						var contHasThisServices = _attachServicesChecker.filter(p => selectedConts.indexOf(p.CntrNo) != -1 && p.CJMode_CD == currentCjMode)
							.map(x => x.CntrNo);

						_attachServicesChecker.filter(p => contHasThisServices.indexOf(p.CntrNo) != -1 && p.CJMode_CD == currentCjMode)
							.map(x => x.Select = (inp.is(":checked") ? 1 : 0));

						var contNonService = selectedConts.filter(p => contHasThisServices.indexOf(p) == -1);
						$.each(contNonService, function(idx, iContNo) {
							_attachServicesChecker.push({
								Select: inp.is(":checked") ? 1 : 0,
								CntrNo: iContNo,
								CJMode_CD: currentCjMode
							});
						});
					} else {
						$.each(selectedConts, function(idx, iContNo) {
							_attachServicesChecker.push({
								Select: inp.is(":checked") ? 1 : 0,
								CntrNo: iContNo,
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
						tblInv.dataTable().fnClearTable();
					}
				}
			}

			if (inp.is(":checked")) {
				inp.attr("checked", "");
				inp.val(1);
			} else {
				inp.removeAttr("checked");
				inp.val("");
			}

			var crCell = inp.closest('td');
			var crRow = inp.closest('tr');
			var eTable = tblAttach.DataTable();

			eTable.cell(crCell).data(crCell.html()).draw(false);
			eTable.row(crRow).nodes().to$().addClass("editing");
		});
		// ----- FOR ATTACH SERVICES
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
				$("#t-mb").prop("disabled",false);
			} 
			else if($(e.target).val() == "dft") {
                $("#t-mb").prop("disabled", true);
            }
			else {
				$("#m-inv-container").addClass("hiden-input");
				$("#pay-atm").prop("disabled", false);
				$("#t-mb").prop("disabled",false);
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
								url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
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

		$('#payer-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});

		//THU SAU
		$('#payment-modal').on('hide.bs.modal', function(e) {
			$('#show-payment-modal').attr("data-target", "");
		});

		$('#payment-type').on('change', function() {
			if ($(this).val() == "M") {
				$('#chk-view-inv').closest('label').show(); //show option tinh cuoc
				$('#show-payment-modal')
					.removeClass('btn-primary')
					.addClass('btn-warning')
					.html('<i class="fa fa-print"></i>&ensp;Thanh toán'); //doi title button

				$('#p-money i').removeClass('fa-square').addClass('fa-check-square');
				$('#p-credit i').removeClass('fa-check-square').addClass('fa-square');
			} else {
				$('#chk-view-cont').trigger('click'); //chuyen qua tab list cont
				$('#chk-view-inv').closest('label').hide(); //an option tinh cuoc
				$('#show-payment-modal')
					.addClass('btn-primary')
					.removeClass('btn-warning')
					.html('<i class="fa fa-save"></i>&ensp;Lưu thu sau'); //doi title button

				$('#p-money i').removeClass('fa-check-square').addClass('fa-square');
				$('#p-credit i').removeClass('fa-square').addClass('fa-check-square');
			}

			//refill payment type
			_lstOrder.map(item => {
				item['PAYMENT_TYPE'] = $('#payment-type').val();
				item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";
			});
		});
		//THU SAU

		$('#show-payment-modal').on("click", function(e) {
			if (!$("#taxcode").val() || !$("#cusID").val()) {
				$('#taxcode').addClass("error");
				toastr["warning"]("Chưa chọn đối tượng thanh toán!");
				e.preventDefault();
				return;
			}

			var paymentType = $('#payment-type').val();
			if (paymentType == "M") {

				if (tblInv.DataTable().rows().data().toArray().length == 0) {
					toastr["warning"]("Không có gì để thanh toán!");
					e.preventDefault();
					return;
				}

				$("#dv-cash, #publish-type").removeClass("hiden-input");
				$("#dv-credit").addClass("hiden-input");

				if (!$("input[name='publish-opt']").is(":checked")) {
					$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
					$("#m-inv-container").addClass("hiden-input");
				}
				$(this).attr("data-target", "#payment-modal");

			} else {
				if (tblConts.DataTable().rows().data().toArray().length == 0) {
					toastr["warning"]("Không có gì để lưu!");
					e.preventDefault();
					return;
				}

				//kiem tra cac truong bat buoc truoc khi luu thu sau
				if ($('.input-required').has_required()) {
					$('.toast').remove();
					toastr['error']('Các trường bắt buộc (*) không được để trống!');
					return;
				}

				$("#dv-cash, #publish-type").addClass("hiden-input");
				$("#dv-credit").removeClass("hiden-input");
				$("input[name='publish-opt']").prop("checked", false);

				$.confirm({
					title: 'Cảnh báo!',
					type: 'orange',
					icon: 'fa fa-warning',
					content: 'Xác nhận lưu thu sau?',
					buttons: {
						ok: {
							text: 'Xác nhận',
							btnClass: 'btn-warning',
							keys: ['Enter'],
							action: function() {
								$('body').blockUI();
								saveData();
							}
						},
						cancel: {
							text: 'Hủy bỏ',
							btnClass: 'btn-default',
							keys: ['ESC']
						}
					}
				});
			}
		});

		$('#b-add-payer').on("click", function() {
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function() {
			$('.add-payer-container').removeClass("payer-show");
		});

		///////// SEARCH PAYER
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
		///////// END SEARCH PAYER

		//APPLY + SEARCH CONTAINER
		$('#cntrno + span').on('click', function() {
			if (!$('#billNo').val()) {
				$('.toast').remove();
				toastr['warning']('Vui lòng nhập số Vận Đơn trước!');
				$(this).attr('data-target', '');
				return;
			}
			
			if (_lstContainer.length > 0 && _lstContainer.filter(p => p.BLNo == $('#billNo').val()).length > 0) {
				$(this).attr('data-target', '#conts-modal');
			} else {
				$('.toast').remove();
				toastr['warning']('Không có container đủ điều kiện!');
				$(this).attr('data-target', '');
			}
			
		});

		$(document).on('click', '#conts-list tbody tr td', function() {
			var rowIdx = $(this).parent().index();
			var tblconts = $('#conts-list').DataTable();
			tblconts.cell(rowIdx, 0)
				.nodes()
				.to$()
				.toggleClass('ti-check');

			tblconts.rows(rowIdx)
				.nodes()
				.to$()
				.toggleClass('selected');
			// $(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			// $(this).parent().toggleClass('selected');
		});

		$(document).on('click', '.dt-buttons a.buttons-select-all[aria-controls="conts-list"]', function() {
			$('#conts-list').DataTable().columns(0)
				.nodes()
				.flatten() // Reduce to a 1D array
				.to$()
				.addClass('ti-check');
		});

		$(document).on('click', '.dt-buttons a.buttons-select-none[aria-controls="conts-list"]', function() {
			$('#conts-list').DataTable().columns(0)
				.nodes()
				.flatten() // Reduce to a 1D array
				.to$()
				.removeClass('ti-check');
		});

		$('#apply-conts').on('click', function() {
			// selected_cont = [];
			// _lstContainer

			var table = $('#conts-list').DataTable(),
				chkTLHQ_cntr = [],
				chkTerHold_cntr = [],
				chkPickupOrder_cntr = [],
				chkStuffUnstuff_cntr = [];
			var data = table
				.rows('.selected')
				.data()
				.to$();

			$.each(data, function(i, v) {
				var chkCntr = v[_colsContList.indexOf("CntrNo")];
				var cntr_input = _lstContainer.filter(p => p.CntrNo == chkCntr)[0];

				if (selected_cont.indexOf(chkCntr) < 0) {
					if (cntr_input.Ter_Hold_CHK == "1") {
						chkTerHold_cntr.push(chkCntr);
					} else if (cntr_input.EIRNo && cntr_input.bXNVC == '0') {
						chkPickupOrder_cntr.push(`${chkCntr} : ${cntr_input.EIRNo}`);
					} else if (cntr_input.SSOderNo && !cntr_input.FDATE) {
						chkStuffUnstuff_cntr.push(`${chkCntr} : ${cntr_input.SSOderNo}`);
					} else if (cntr_input.cTLHQ != "1" && cntr_input.IsLocal != 'L') { //ko check thanh ly doi voi cont noi(E)
						chkTLHQ_cntr.push(chkCntr);
					} else {
						selected_cont.push(chkCntr);
					}
				}
			});

			if (chkTerHold_cntr.length > 0) {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Container [' + chkTerHold_cntr.join(", ") + '] đang bị giữ tại Cảng!'
				});
				return;
			}

			if (chkPickupOrder_cntr.length > 0) {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Có container đang được làm lệnh [NÂNG/HẠ] [' + chkPickupOrder_cntr.join(", ") + ']'
				});
				return;
			}

			if (chkStuffUnstuff_cntr.length > 0) {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Có container đang được làm lệnh rút hàng [' + chkStuffUnstuff_cntr.join(", ") + ']'
				});
				return;
			}

			if (chkTLHQ_cntr.length > 0) {
				$('#bill-modal').attr("data-keyboard", "false");
				var confirmBtn = {
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default btn-sm lower-text',
						keys: ['ESC']
					}
				};

				/** [ISSUE 99] issue canh bao va ko cho lam lenh doi voi nhung cont chua thanh ly **/
				// confirmBtn["ok"] = {
				// 		text: 'Tiếp tục với những cont đã chọn',
				// 		btnClass: 'btn-primary btn-sm lower-text',
				// 		action: function() {
				// 			selected_cont = selected_cont.concat(chkTLHQ_cntr);

				// 			$('#conts-modal').modal("hide");

				// 			apply_cont();
				// 		}
				// 	};

				if (selected_cont.length > 0) {
					confirmBtn["need"] = {
						text: 'Chỉ chọn cont đã thanh lý',
						btnClass: 'btn-warning btn-sm lower-text',
						action: function() {
							$('#conts-list').find("tbody tr").each(function(k, v) {
								var cntrNoChk = $(v).find("td:eq(" + _colsContList.indexOf("CntrNo") + ")").text();
								if (chkTLHQ_cntr.indexOf(cntrNoChk) != "-1") {
									$(v).removeClass("selected");
									$(v).find("td:eq(" + _colsContList.indexOf("Check") + ")").removeClass("ti-check");
								}
							});

							$('#conts-modal').modal("hide");
							apply_cont();
						}
					}
				}
				/** [ISSUE 99] issue canh bao va ko cho lam lenh doi voi nhung cont chua thanh ly **/
				// else {
				// 	confirmBtn.ok.text = "Tiếp tục";
				// 	confirmBtn.ok["keys"] = ["Enter"];
				// }

				$.confirm({
					title: 'Cảnh báo!',
					type: 'orange',
					icon: 'fa fa-warning',
					content: 'Có container chưa được thanh lý HQ!',
					buttons: confirmBtn
				});

				return;
			}

			$('#conts-list').find("tbody tr").each(function(k, v) {
				var cntrNoChk = $(v).find("td:eq(" + _colsContList.indexOf("CntrNo") + ")").text();
				if (chkTLHQ_cntr.indexOf(cntrNoChk) != "-1") {
					$(v).removeClass("selected");
					$(v).find("td:eq(" + _colsContList.indexOf("Check") + ")").removeClass("ti-check");
				}
			});

			$('#conts-modal').modal("hide");

			apply_cont();
		});

		var cntrNoChange = "";

		$('#cntrno').on('keypress', function(e) {
			if (e.which == 13) {
				e.preventDefault();
				if ($(this).val() != cntrNoChange) {
					$(e.target).blur();
				} else {
					$(e.target).trigger("change");
				}
			}
		});

		$('#cntrno').on('change', async function(e) {
			var cntrno = $('#cntrno').val().trim();
			cntrNoChange = cntrno;

			if (!cntrno) {
				return;
			}

			cntrno = cntrno.toUpperCase();

			if (_lstContainer.length == 0 || _lstContainer.filter(p => p.CntrNo == cntrno).length == 0) {
				try {
					await getContList('', cntrno);
				}
				catch(err) {
					return;
				}
			}
			
			if( _lstContainer.length == 0){
				toastr['info']('Số container [' + cntrno + '] không đủ điều kiện làm lệnh!\nVui lòng kiểm tra lại!');
				return;
			}
			
			var cntr_input = _lstContainer.filter(p => p.CntrNo == cntrno)[0];
			if (cntr_input.Ter_Hold_CHK == "1") {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Container [' + cntrno + '] đang bị giữ tại Cảng!'
				});
				return;
			}

			if (cntr_input.EIRNo && cntr_input.bXNVC == '0') {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Container [' + cntrno + '] đang được làm lệnh [NÂNG/HẠ] số [' + cntr_input.EIRNo + ']!'
				});
				return;
			}

			if (cntr_input.SSOderNo && !cntr_input.FDATE) {
				$.alert({
					title: 'Cảnh báo!',
					icon: 'fa fa-warning',
					type: 'orange',
					content: 'Container [' + cntrno + '] đang được làm lệnh rút hàng số [' + cntr_input.SSOderNo + ']!'
				});
				return;
			}

			if (cntr_input.cTLHQ != "1" && cntr_input.IsLocal != 'L') { //ko check thanh ly doi voi cont noi(L)
				/** [ISSUE 99] issue canh bao va ko cho lam lenh doi voi nhung cont chua thanh ly **/

				$.alert({
					title: 'Cảnh báo!',
					content: 'Container chưa được thanh lý HQ!',
					type: 'red'
				});

				// $.confirm({
				// 	title: 'Cảnh báo!',
				// 	type: 'orange',
				// 	icon: 'fa fa-warning',
				// 	content: 'Container chưa được thanh lý HQ! <br/>Tiếp tục làm lệnh ?',
				// 	buttons: {
				// 		ok: {
				// 			text: 'Tiếp tục',
				// 			btnClass: 'btn-primary',
				// 			keys: ['Enter'],
				// 			action: function() {
				// 				if ($.inArray(cntrno, selected_cont) == "-1") {
				// 					$('.has-block-content').blockUI();
				// 					selected_cont.push(cntrno);

				// 					var table = $('#conts-list').DataTable();

				// 					table.rows().every(function(rowIdx, tableLoop, rowLoop) {
				// 						if (this.data()[_colsContList.indexOf("CntrNo")] == cntrno) {
				// 							table.rows(rowIdx)
				// 								.nodes()
				// 								.to$()
				// 								.addClass('selected');

				// 							table.cell(rowIdx, _colsContList.indexOf("Check"))
				// 								.nodes()
				// 								.to$()
				// 								.addClass('ti-check');
				// 						}
				// 					});
				// 					apply_cont();
				// 					$('#billNo').val(_lstContainer.filter(p => p.CntrNo == cntrno)[0]["BLNo"]);
				// 				}
				// 			}
				// 		},
				// 		cancel: {
				// 			text: 'Hủy bỏ',
				// 			btnClass: 'btn-default',
				// 			keys: ['ESC']
				// 		}
				// 	}
				// });
			} else {
				if ($.inArray(cntrno, selected_cont) == "-1") {
					$('.has-block-content').blockUI();
					selected_cont.push(cntrno);

					var table = $('#conts-list').DataTable();

					table.rows().every(function(rowIdx, tableLoop, rowLoop) {
						if (this.data()[_colsContList.indexOf("CntrNo")] == cntrno) {
							table.rows(rowIdx)
								.nodes()
								.to$()
								.addClass('selected');

							table.cell(rowIdx, _colsContList.indexOf("Check"))
								.nodes()
								.to$()
								.addClass('ti-check');
						}
					});
					apply_cont();
					$('#billNo').val(_lstContainer.filter(p => p.CntrNo == cntrno)[0]["BLNo"]);
				}
				else {
					toastr['info']('Số container [' + cntrno + '] đã được thêm vào danh sách!');
				}
			}
		});

		var _ktype = "";
		$('#billNo').on('keypress', async function(e) {
			var blNo = $(this).val();
			if (!blNo) return;
			if (e.keyCode == 13) {
				_ktype = "enter";
				$('#cntrno').val('');
				await loadContList(blNo);
			}
		});

		///////// INPUT TAX_CODE DIRECTLY
		$("#taxcode").on("keypress", function(e) {
			if (e.keyCode == 13) {
				$(e.target).trigger('change');
			}
		});
		///////// INPUT TAX_CODE DIRECTLY

		var typingTimer;
		$(document).on('change', 'input[type!="radio"], select', async function(e) {
			clearTimeout(typingTimer);
			if ($(e.target).val()) {
				$(e.target).removeClass('error');
				$(e.target).parent().removeClass('error');
			}
			if ($(e.target).attr('id') == 'taxcode') {
				var taxcode = $(e.target).val();
				if (!taxcode) {
					clearPayer();
					return;
				}

				var cusID = "";
				var ccc = $("#cusID").val();

				if (payers.length == 0 && !ccc) {
					findPayer(taxcode);
					return;
				}

				var tempSearchCus = payers.filter(p => p.VAT_CD.toString().includes(taxcode));
				if (ccc) {
					cusID = ccc;
				} else {
					if (tempSearchCus.length == 0) {
						$(".toast").remove();
						toastr.options.timeOut = "10000";
						toastr["warning"]("Đối tượng thanh toán này không tồn tại trong hệ thống! <br/> Vui lòng Thêm mới/ Chọn đối tượng khác!");
						toastr.options.timeOut = "5000";
						return;
					} else if (tempSearchCus.length > 1) {
						clearPayer();
						$('#search-payer').DataTable().search(taxcode).draw(false)
						$('#payer-modal').modal("show");
						return;
					}
					cusID = tempSearchCus[0].CusID;
				}

				$("#cusID").val(cusID);

				var pytype = getPayerType(cusID);
				$.each(_lstOrder, function(k, v) {
					_lstOrder[k].CusID = cusID;
					_lstOrder[k].PAYER_TYPE = pytype;
				});

				var checkPayerInput = fillPayer();
				if (!checkPayerInput) {
					clearPayer();

					$(".toast").remove();
					toastr.options.timeOut = "10000";
					toastr["warning"]("Đối tượng thanh toán này không tồn tại trong hệ thống! <br/> Vui lòng Thêm mới/ Chọn đối tượng khác!");
					toastr.options.timeOut = "5000";
					$('#payer-modal').modal("show");
					$("#add-payer-taxcode").val(taxcode);
					$("#b-add-payer").trigger("click");
					return;
				}
			}
			if ($(e.target).attr('id') == "billNo") {
				if (_ktype == "") {
					await loadContList($('#billNo').val());
				}
				return;
			}
			
			//reset list order
			_lstOrder = [];
			if ($('.input-required.error').length == 0 && _lstContainer.length > 0 && selected_cont.length > 0) {
				for (i = 0; i < _lstContainer.length; i++) {
					if (selected_cont.indexOf(_lstContainer[i].CntrNo) == '-1') continue;
					addCntrToSRV_ODR(_lstContainer[i]);
				}
			}

			typingTimer = window.setTimeout(function() {
				if ($('.input-required.error').length == 0 && $('#chk-view-inv').is(':checked') && $.inArray($(e.target).attr('id'), ['service_code', 'taxcode']) != "-1") {
					loadpayment();
				}
			}, 1500);
		});

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.draw();
		});

		$('input[name="view-opt"]').bind('change', function(e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			if ($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1) {

				//kiem tra cac truong bat buoc
				if ($('.input-required').has_required()) {
					$('.toast').remove();
					toastr['error']('Các trường bắt buộc (*) không được để trống!');
					tblInv.dataTable().fnClearTable();
					$('#chk-view-cont').trigger('click');
					return;
				}

				var hasRefeerCont = tblConts.DataTable().column(_cols.indexOf("ISO_SZTP"))
					.data().toArray()
					.filter(p => p.substr(2, 1) == "R").length > 0;

				var hasAttachSDD = _attachServicesChecker.filter(p => p.CJMode_CD == 'SDD' && p.Select == 1).length > 0;
				if (hasRefeerCont && !hasAttachSDD) {
					$.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: 'Có container lạnh chưa tính cước!',
						buttons: {
							ok: {
								text: 'Tiếp tục',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
									loadpayment();
								}
							},
							cancel: {
								text: 'Hủy bỏ',
								btnClass: 'btn-default',
								keys: ['ESC'],
								action: function() {
									$('#chk-view-cont').trigger('click');
								}
							}
						}
					});
				} else {
					loadpayment();
				}
			}

			if ($(this).val() == "inv") {
				tblInv.DataTable().columns.adjust();
			} else {
				tblConts.DataTable().columns.adjust();
			}
		});

		$("#save-payer").on("click", function() {
			var addTaxCode = $("#add-payer-taxcode").val();
			var addPayerName = $("#add-payer-name").val();
			var address = $("#add-payer-address").val();

			if (!addTaxCode) {
				$("#add-payer-taxcode").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập thông tin [Mã số thuế]!");
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
			//kiem tra cac truong bat buoc truoc khi luu thu sau
			if ($('.input-required').has_required()) {
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}
			saveData();
		});

		function addCntrToSRV_ODR(item) {
			//item["IS_ATTACH_SRV"] = 0;

			item['CJMode_CD'] = $('#service_code').val();

			item['PTI_Hour'] = 0;

			item['IssueDate'] = $('#ref-date').val(); //*
			item['ExpDate'] = $('#ref-exp-date').val(); //*
			// item['BLNo'] = $('#billNo').val(); //*
			item['NameDD'] = $('#personal-name').val();
			item['PersonalID'] = $('#cmnd').val();
			item['DMETHOD_CD'] = $('#dmethod').val();

			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*
			item['PAYER_TYPE'] = getPayerType($('#cusID').val());
			item['CusID'] = $('#cusID').val(); //*

			if ($('#mail').val()) {
				item['Mail'] = $('#mail').val();
			}

			item['DELIVERYORDER'] = $('#do').val();
			item['OPERATIONTYPE'] = $('#dmethod').val();
			// item['SSRMORE'] = $('#ref-no').val();

			item['PAYMENT_TYPE'] = $('#payment-type').val();
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['cBlock1'] = item['cBlock'];
			item['cBay1'] = item['cBay'];
			item['cRow1'] = item['cRow'];
			item['cTier1'] = item['cTier'];
			delete item['cBlock'];
			delete item['cBay'];
			delete item['cRow'];
			delete item['cTier'];

			_lstOrder.push(item);
		}

		// function
		function apply_cont() {
			$('#bill-modal').attr("data-keyboard", "true");

			var hasrequired = false;
			if ($('.input-required.error').length > 0) {
				hasrequired = true;
			} else {
				hasrequired = $('.input-required').has_required();
				if (hasrequired) {
					$('.toast').remove();
					toastr['error']('Các trường bắt buộc (*) không được để trống!');
				}
			}

			tblConts.waitingLoad();
			var rows = [];
			if (_lstContainer.length > 0 && selected_cont.length > 0) {
				var shipperName = '';
				var stt = 1;
				//reset list order
				_lstOrder = [];
				for (i = 0; i < _lstContainer.length; i++) {
					if (selected_cont.indexOf(_lstContainer[i].CntrNo) == '-1') continue;

					//add item cntr_details to _lst;
					if ($('.input-required.error').length == 0) {
						if (!hasrequired) {
							addCntrToSRV_ODR(_lstContainer[i]);
						}
					}

					if (_lstContainer[i].ShipperName) {
						shipperName = _lstContainer[i].ShipperName;
					}

					var cntrclass = _lstContainer[i].CntrClass == 1 ? "Nhập" : (_lstContainer[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
					var r = [];
					$.each(_cols, function(indx, item) {
						var value = "";
						switch (item) {
							case "STT":
								value = stt++;
								break;
							case "CARGO_TYPE":
								value = '<input class="hiden-input" value="' + _lstContainer[i].CARGO_TYPE + '"/>' + _lstContainer[i].Description;
								break;
							case "IsLocal":
								value = _lstContainer[i].IsLocal == "F" ? "Ngoại" : (_lstContainer[i].IsLocal == "L" ? "Nội" : "");
								break;
							case "Status":
								value = _lstContainer[i].Status == "F" ? "Hàng" : "Rỗng";
								break;
							case "cTLHQ":
								value = _lstContainer[i].cTLHQ == 1 ? "Đã thanh lý" : "Chưa thanh lý";
								break;
							default:
								value = _lstContainer[i][item] ? _lstContainer[i][item] : "";
								break;
						}
						r.push(value);
					});
					rows.push(r);
				}
			}

			if (shipperName) {
				$('#shipper-name').val(shipperName).removeClass('error');
			}

			$('#chk-view-cont').trigger('click');
			tblConts.DataTable({
				data: rows,
				info: false,
				paging: false,
				searching: false,
				scrollY: '30vh',
				select: true,
				rowReorder: false,
				buttons: []
			});

			tblConts.realign();
			tblInv.DataTable().clear().draw();
			$('.has-block-content').unblock();

			//focus lại ô số cont để nhập tiếp
			$('#cntrno').val('').focus();

			if ($("#tb-attach-srv").DataTable().rows().data().length > 0) {
				var selectPckCntr = $('#tb-attach-srv').find('.selectpicker').first();
				var sPVal = selectPckCntr.val();
				var compareVal = sPVal ? selected_cont.diff(sPVal) : [];

				if (compareVal && compareVal.length > 0) {
					$.each(compareVal, function(indx, item) {
						$('#tb-attach-srv').find('.selectpicker').append('<option value="' + item + '">' + item + '</option>');
					});
				}

				$('#tb-attach-srv').find('.selectpicker').selectpicker('refresh');
			} else {
				if ($('#service_code').val()) {
					load_attach_srv();
				}
			}
		}

		function load_attach_srv() {
			$('#col-attach-service').blockUI();
			$("#tb-attach-srv").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_attach_srv',
				'order_type': $("#service_code").val()
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
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

		function loadpayment() {
			if (_lstOrder.length == 0) {
				tblInv.dataTable().fnClearTable();
				return;
			}

			if ($('.input-required.error').length > 0) {
				tblInv.dataTable().fnClearTable();
				return;
			}

			if ($('.input-required').has_required()) {
				tblInv.dataTable().fnClearTable();
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#cusID').val(),
				'list': _lstOrder
			};

			if ($("#chkServiceAttach").is(":checked")) {
				addCntrToAttachSRV();

				var nonAttach = _lstAttachService.filter(p => p.CJMode_CD != "SDD" && p.CJMode_CD != "LBC");
				var sdd = _lstAttachService.filter(p => p.CJMode_CD == "SDD");
				var lbc = _lstAttachService.filter(p => p.CJMode_CD == "LBC");

				if (nonAttach && nonAttach.length > 0) {
					formdata['nonAttach'] = nonAttach;
				}

				if (sdd && sdd.length > 0) {
					formdata['sdd'] = sdd;
				}

				if (lbc && lbc.length > 0) {
					formdata['lbc'] = lbc;
				}
			}

			//reset list extra service
			_lstExtraService.length = 0;
			tblInv.waitingLoad();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					EirNo_Draft = null //reset EirDraft
					if (data.deny) {
						toastr["error"](data.deny);
						tblInv.dataTable().fnClearTable();
						return;
					}

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
						toastr["warning"]( data.no_tariff );
					}

					if (data.error_plugin && data.error_plugin.length > 0) {
						$(".toast").remove();
						$.each(data.error_plugin, function() {
							toastr["error"](this);
						});

						tblInv.dataTable().fnClearTable();
						// return;
					}

					if (!data.results || data.results.length == 0) {
						toastr["warning"]("Không tìm thấy biểu cước phù hợp! Vui lòng kiểm tra lại!");
						tblInv.dataTable().fnClearTable();
						return;
					}

					if (data.error && data.error.length > 0) {
						$(".toast").remove();
						$.each(data.error, function(idx, err) {
							toastr["error"](err);
						});

						tblInv.dataTable().fnClearTable();
						return;
					}

					if (data.ps_notify) {
						$("#notify-modal").find(".modal-body h4").html(data.ps_notify);
						$("#show-ps-notify").removeClass("hiden-input");
					} else {
						$("#notify-modal").find(".modal-body h4").html("");
						$("#show-ps-notify").addClass("hiden-input");
					}

					if (data.freeContInYard) {
						_lstAttachService = _lstAttachService.filter(p => data.freeContInYard.indexOf(p.CntrNo) == -1 && p.CJMode_CD == "LBC");
						toastr["warning"]("Container [" + data.freeContInYard.join(", ") + "] được miễn phí lưu bãi!");
					}

					//[BAC_THANG]
					//extra service order (like attach)
					if (data.extra_attach && data.extra_attach.length > 0) {
						_lstExtraService = data.extra_attach;
					}
					if (data.detachJobModes && data.detachJobModes.length > 0) {
						_lstAttachService = _lstAttachService.filter(p => data.detachJobModes.indexOf(p.CJMode_CD) < 0);
					}

					var rows = [];
					if (data.results && data.results.length > 0) {
						var lst = data.results,
							stt = 1;
						for (i = 0; i < lst.length; i++) {
							rows.push([
								(stt++), lst[i].DraftInvoice, lst[i].OrderNo ? lst[i].OrderNo : "", lst[i].TariffCode, lst[i].TariffDescription, lst[i].Unit, lst[i].JobMode == 'GO' ? "Nâng container" : (lst[i].JobMode == 'GF' ? "Hạ container" : "*"), lst[i].DeliveryMethod, lst[i].Cargotype, lst[i].ISO_SZTP, lst[i].FE, lst[i].IsLocal, lst[i].Quantity, lst[i].StandardTariff, 0, lst[i].DiscountTariff, lst[i].DiscountedTariff, lst[i].Amount, lst[i].VatRate, lst[i].VATAmount, lst[i].SubAmount, lst[i].Currency, lst[i].IX_CD, lst[i].CNTR_JOB_TYPE, lst[i].VAT_CHK, lst[i].Remark || '', lst[i].TRF_DESC_MORE || ''
							]);
						}
					}
					if (rows.length > 0) {
						var n = rows.length;
						rows.push([
							n, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', data.SUM_AMT, '', data.SUM_VAT_AMT, data.SUM_SUB_AMT, '', '', '', '', '', ''
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

					tblInv.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblInv.dataTable().fnAddData(rows);
					}
				},
				error: function(err) {
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

		async function loadContList(billNo) {
			if (typeof billNo === "undefined" || billNo === null) {
				toastr["warning"]("Vui lòng nhập số Vận đơn trước!");
				return;
			}
			
			try {
				await getContList(billNo, '');
			}
			catch(error) {
				$('.toast').remove();
				return;
			}

			billNo = billNo.toUpperCase();
			$('#conts-list').dataTable().fnClearTable();

			var lstByBillNo = _lstContainer.filter(p => p.BLNo == billNo);
			if (lstByBillNo.length == 0) {
				$('.toast').remove();
				toastr['info']('Số vận đơn [' + billNo + '] không có container nào đủ điều kiện làm lệnh!\nVui lòng kiểm tra lại!');
				return;
			}

			if (lstByBillNo.filter(p => p.Ter_Hold_CHK != '1').length == 0) {
				$('.toast').remove();
				toastr['info']('Số vận đơn [' + billNo + '] không có container nào đủ điều kiện làm lệnh!');
				return;
			}

			var rContList = [];
			$.each(lstByBillNo, function(idx, item) {
				if (item.Ter_Hold_CHK && item.Ter_Hold_CHK == "1") {
					return;
				}

				var r = [];
				$.each(_colsContList, function(i, t) {
					var vlue = "";
					switch (t) {
						case "cTLHQ":
							vlue = "<input type='text' class='hiden-input' value='" + item[t] + "'> " +
								(item[t] == "1" ? "Đã thanh lý" : "Chưa thanh lý");
							break;
						case "Status":
							vlue = item[t] == "F" ? "Full" : "Empty";
							break;
						case "Location":
							vlue = item["cBlock"] + "-" + item["cBay"] + "-" + item["cRow"] + "-" + item["cTier"];
							vlue = vlue.replaceAll("null-", "");
							if (!vlue || vlue == 'null') {
								vlue = item['cArea'];
							}
							break;
						case "CntrClass":
							vlue = "Import";
							break;
						default:
							vlue = item[t] ? item[t] : "";
					}
					r.push(vlue);
				})
				rContList.push(r);
			});
			
			tblContList.dataTable().fnClearTable();
			if(rContList.length > 0){
				tblContList.dataTable().fnAddData(rContList);
			}
			
			$('#cntrno + span').trigger('click');
			_ktype = "";
		}

		function getContList(billNo = '', cntrNo = '') {
			return new Promise(function(resolve, reject) {
				$('.ibox.collapsible-box').blockUI();
				_lstContainer.length = 0;
				$.ajax({
					url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
					dataType: 'json',
					data: {
						'action': 'view',
						'act': 'search_conts',
						'cntrNo': cntrNo,
						'blNo': billNo
					},
					type: 'POST',
					success: function(data) {
						$('.ibox.collapsible-box').unblock();
						if (data.contList && data.contList.length > 0) {
							_lstContainer = data.contList;
						}
						resolve(data.contList);
					},
					error: function(err) {
						$('.ibox.collapsible-box').unblock();
						console.log(err);
						toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
						reject();
					}
				});
			})
			
		}

		function load_payer() {
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
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

		$("#cmnd, #personal-name, #mail").on('input', function(e) {
			$(e.target).attr('user-input', $(e.target).val() ? 1 : 0);
		});

		function fillPayer() {
			var py = payers.filter(p => p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());
			if (py.length > 0) { //fa-check-square
				$('#p-taxcode').text(py[0].VAT_CD);
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);
				$('#payment-type').val(py[0].CusType).selectpicker('refresh').trigger('change');
				if (py[0].CusType == "M") {
					$('#p-money i').removeClass('fa-square').addClass('fa-check-square');
					$('#p-credit i').removeClass('fa-check-square').addClass('fa-square');
					$("#t-mb").prop("disabled",false)
				} else {
					$('#p-money i').removeClass('fa-check-square').addClass('fa-square');
					$('#p-credit i').removeClass('fa-square').addClass('fa-check-square');
                	$("#t-mb").prop("disabled", true);
				}

				$("#cmnd[user-input=0]").val(py[0].PersonalID);
				$("#personal-name[user-input=0]").val(py[0].NameDD);
				if (py[0].Email) {
					$("#mail[user-input=0]").val(py[0].Email);
				}

				if (py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email) {
					$("#mail").val($("#mail").val() + ',' + py[0].EMAIL_DD);
				}

				$("#taxcode").removeClass("error");
			}

			return py.length > 0;
		}

		function clearPayer() {
			$("#cusID").val('');
			$('#taxcode').val('');

			$("#payer-name").text(" [Tên đối tượng thanh toán]");
			$("#payer-addr").text(" [Địa chỉ]");
			$("#payment-type").val('M').selectpicker('refresh').trigger('change');

			$('#p-taxcode, #p-payername, #p-payer-addr').text('');
		}

		function findPayer(str) {
			$('#taxcode').parent().blockUI();
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
				dataType: 'json',
				data: {
					action: 'view',
					act: 'search_cus_by_tax',
					taxCode: str
				},
				type: 'POST',
				success: function(data) {
					$('#taxcode').parent().unblock();
					if (data.deny) {
						$('#payment-modal').find('.modal-content').unblock();
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					if (!data['cus']) {
						$(".toast").remove();
						toastr["error"]('Mã số thuế này không tồn tại trong hệ thống! Vui lòng nhập lại hoặc tạo mới');
						return;
					}

					if (payers.length == 0) {
						payers.push(data.cus);
					}

					$('#taxcode').val(data.cus.VAT_CD);
					$('#cusID').val(data.cus.CusID);
					$('#taxcode').trigger('change');

				},
				error: function(err) {
					$('#taxcode').parent().unblock();
					$(".toast").remove();
					toastr["error"]('Xảy ra lỗi');
					console.log(err);
				}
			});
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
								toastr["success"]("Tiến hành xuất hóa đơn <br> Vui lòng không thao tác!");
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
			var formData = {
				'action': draft ? 'save' : 'save_draft',
				'data': {
					'pubType': publish_opt_checked ? publish_opt_checked : "credit",
					'odr': _lstOrder,
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
			if(!draft) {
                _lstOrder.map(x => x.publishType = publish_opt_checked ? publish_opt_checked : "e-inv");
                _lstOrder.map(x => x.Type_Eir = 'Lệnh Rút Hàng Container');
				_lstOrder.map(x => x.Note = $('#remark').val());
				_lstOrder.map(x => x.SHIPPER_NAME = $('#shipper-name').val());
				_lstOrder.map(x => x.PersonalID = $('#cmnd').val());
				_lstOrder.map(x => x.NameDD = $('#personal-name').val());
				_lstOrder.map(x => x.Mail = $('#mail').val());
            }else {
				_lstOrder.map(x => {
						delete x.publishType;
						delete x.Type_Eir;
					});
			}
			//[BAC_THANG]
			//get attach service + extra service for save
			var odr = [..._lstOrder, ..._lstAttachService, ..._lstExtraService];
			if (odr.length > 0) {
				formData['data']['odr'] = odr;
			}

			if (typeof invInfo !== "undefined" && invInfo !== null) {
				formData.data["invInfo"] = invInfo;
			} else {
				//trg hop không phải xuất hóa đơn ddienj tử, block poup thanh toán
				$('#payment-modal').find('.modal-content').blockUI();
			}

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
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
					$('.toast').remove();
					$('#payment-modal').find('.modal-content').unblock();
					toastr['error'](error);
					console.log(xhr);
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
                            'Odrs': EirNo,
                        },
                    };
                    if (formData.data.pubType != 'credit' && (!drDetail || drDetail.length == 0)) {
                        $('#payment-modal').find('.modal-content').unblock();
                        $('.toast').remove();
                        toastr['warning']('Chưa có thông tin tính cước!');
                        return;
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
			tblInv.find('tbody tr:not(.row-total)').each(function() {
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
				// temp['Remark'] = $.unique(_lstOrder.map(p=> p.CntrNo)).toString();
				drd.push(temp);
			});
			return drd;
		}

		function addCntrToAttachSRV() {
			_lstAttachService = [];
			var attachSrvSelected = _attachServicesChecker.filter(p => p.Select == 1);

			if (attachSrvSelected.length > 0) {
				$.each(attachSrvSelected, function(index, elem) {
					var finds = _lstOrder.filter(p => p.CntrNo == elem["CntrNo"])[0];

					var item = $.extend({}, finds);

					item['CJMode_CD'] = elem["CJMode_CD"];

					item['PTI_Hour'] = 0;

					if (elem["ExpPluginDate"]) {
						item["ExpPluginDate"] = elem["ExpPluginDate"];
						finds["ExpPluginDate"] = elem["ExpPluginDate"];
					}

					if (elem["ExpDate"]) {
						item["ExpDate"] = elem["ExpDate"];
					}

					item['cBlock1'] = item['cBlock'];
					item['cBay1'] = item['cBay'];
					item['cRow1'] = item['cRow'];
					item['cTier1'] = item['cTier'];

					deleteItemInArray(item, ["cBlock", "cBay", "cRow", "cTier", "CJModeName", "CLASS", "UNNO", "TERMINAL_CD", "IsTruckBarge", "TruckNo"]);

					_lstAttachService.push(item);
				});
			}
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

		function deleteItemInArray(item, arrColName) {
			$.each(arrColName, function(idx, colname) {
				delete item[colname];
			});
		}

		function save_new_payer(formData) {
			$(".add-payer-container").blockUI();
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskUnstuffingOrder')); ?>",
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
	});
</script>
<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>