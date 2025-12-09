<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<style>
	.wrapok {
		white-space:normal!important;
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold;
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

	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
	}
	.unchecked-Salan{
		pointer-events: none;
	}

	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}
	#INV_DRAFT_TOTAL span.col-form-label{
		width: 64%;
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

	.ui-datepicker{
		z-index: 1055!important;
	}

	.dropdown-menu.open { max-height: none !important; }
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH DỊCH VỤ</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row bg-white border-e pb-1" id="has-block-content">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
											<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text" placeholder="Hạn lệnh">
											<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Dịch vụ *</label>
									<div class="col-sm-8">
										<select id="service_code" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
												<option value="" selected="">-- Chọn dịch vụ --</option>
											<?php if(isset($services) && count($services) > 0){ foreach ($services as $item){ ?>
												<option value="<?= $item['CJMode_CD'] ?>"><?= $item['CJMode_CD']." : ".$item['CJModeName'] ?></option>
											<?php }} ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" for="billno">Số vận đơn</label>
									<div class="col-sm-8 input-group input-group-sm">
                                        <input class="form-control form-control-sm" id="billno" type="text" placeholder="Số vận đơn" style="text-transform: uppercase;">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Số container</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No." style="text-transform: uppercase;">
											<span class="input-group-addon bg-white btn text-warning" title="Chọn"
															data-toggle="modal" data-target="" style="padding: 0 .6rem">
												<i class="fa fa-search"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Hạn điện lạnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="exp-plug-date" type="text" placeholder="Hạn điện lạnh">
											<span class="input-group-addon bg-white btn" title="Nhập chi tiết hạn điện lạnh cho từng cont" data-toggle="modal" data-target="#plug-date-modal" style="padding: 0 .5rem"><i class="la la-ellipsis-h"></i></span>
										</div>
									</div>
								</div>
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Hạn lưu bãi</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="exp-storage-date" type="text" placeholder="Hạn lưu bãi">
											<span class="input-group-addon bg-white btn" title="Nhập chi tiết hạn lưu bãi cho từng cont" data-toggle="modal" data-target="#storage-date-modal" style="padding: 0 .5rem"><i class="la la-ellipsis-h"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-2 col-form-label" title="Chủ hàng">Chủ hàng *</label>
							<div class="col-sm-10">
								<input class="form-control form-control-sm input-required" id="shipper-name" type="text" placeholder="Chủ hàng">
							</div>
						</div>
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
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Đối tượng thanh toán">ĐTTT *</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
												title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
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
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
							</button>
							<button id="show-ps-notify" class="btn btn-outline-secondary btn-sm hiden-input" data-toggle="modal" data-target="#notify-modal">
								<span class="btn-icon"><i class="fa fa-info"></i>Chi tiết cước</span>
							</button>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" >
						<div class="row form-group" style="display: inline-block; float: right; margin: 0 auto">
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
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>STT</th>
							<th>Số contaier</th>
							<th>Số vận đơn</th>
							<th>Hãng khai thác</th>
							<th>Kích cỡ nội bộ</th>
							<th>Kích cỡ ISO</th>
							<th>Hàng/rỗng</th>
							<th>Cảng dỡ</th>
							<th>Cảng đích</th>
							<th>Loại hàng</th>
							<th>Hàng hóa</th>
							<th>VGM</th>
							<th>Trọng lượng</th>
							<th>Nhiệt độ</th>
							<th>Mã nguy hiểm</th>
							<th>Chuyển cảng</th>
							<th>TLHQ</th>
							<th>Seal H/Tàu</th>
							<th>Seal H/Quan</th>
							<th>Nội/ngoại</th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
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
<!--payment modal-->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
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
										<input name="publish-opt" type="radio" value="dft" >
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
					<button id="pay-atm" class="btn btn-rounded btn-gradient-purple">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ ATM</span>
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

<!--bill modal-->
<div class="modal fade" id="bill-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 700px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Thông tin vận đơn</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="bill-detail" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">Chọn</th>
							<th>Số container</th>
							<th>Hãng tàu</th>
							<th>Kích cỡ</th>
							<th>Vị trí bãi</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-bill" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Chuyển tính tiền</button>
					<button class="btn btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
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

<div class="modal fade" id="plug-date-modal"
						data-backdrop="static" data-keyboard="false"
						tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true"
						data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 500px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Chi tiết hạn điện lạnh</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="plugin-cont-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 100%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">STT</th>
							<th>Số container</th>
							<th class="data-type-datetime">Hạn điện lạnh</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-outline-primary" id="apply-plug-date">
					<i class="fa fa-check"></i>
					Xác nhận
				</button>

				<button class="btn btn-sm btn-outline-secondary" id="default-plug-date">
					<i class="fa fa-undo"></i>
					Đặt lại mặc định
				</button>

				<button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng lại
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="storage-date-modal"
						data-backdrop="static" data-keyboard="false"
						tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true"
						data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 500px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Chi tiết hạn lưu bãi</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="storage-cont-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 100%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">STT</th>
							<th>Số container</th>
							<th class="data-type-datetime">Hạn lưu bãi</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-outline-primary" id="apply-storage-date">
					<i class="fa fa-check"></i>
					Xác nhận
				</button>

				<button class="btn btn-sm btn-outline-secondary" id="default-storage-date">
					<i class="fa fa-undo"></i>
					Đặt lại mặc định
				</button>

				<button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng lại
				</button>
			</div>
		</div>
	</div>
</div>

<!--notify modal-->
<div class="modal fade" id="notify-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content" style="border-radius: 5px" >
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

<script type="text/javascript">
	var EirNo_Draft = null
    var modalQrPayment = null
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function () {
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
						, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT"
						, "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],

			_cols = ["CntrNo", "BLNo", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "POD", "FPOD", "CARGO_TYPE", "CmdID", "VGM"
					, "CMDWeight", "Temperature", "UNNO", "Transist", "cTLHQ", "SealNo", "SealNo1", "IsLocal"],

			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];
		
		var _result = [], _lstODR = [], selected_cont = [], _pluginDates = [], _storageDates;

		var payers= {};
		<?php if(isset($payers) && count($payers) > 0){ ?>
			payers = <?= json_encode($payers);?>;
		<?php } ?>

		$('#tbl-conts').DataTable({
			columnDefs: [
				{
					className: 'text-center' ,targets: [0]
				}
			],
			info: false,
			paging: false,
			searching: false,
			scrollY: '65vh',
			buttons: [],
			select: true
		});

		$('#tbl-inv').DataTable({
			columnDefs: [
				{ className: 'hiden-input', targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"]) }
			],
			info: false,
			paging: false,
			searching: false,
			scrollY: '30vh',
			buttons: []
		});

		$('#bill-detail').DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: false,
			scrollY: '30vh',
			buttons: []
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

		$("#plugin-cont-list, #storage-cont-list").DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: false,
			scrollY: '30vh',
			buttons: [],
			keys:{
		        columns: [2]
		    },
            autoFill: {
                focus: 'focus',
                columns: [2]
            },
		});

		$('#plugin-cont-list').editableTableWidget();
		$('#storage-cont-list').editableTableWidget();

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date').datepicker({
			dateFormat: 'dd/mm/yy 23:59:59',
			todayHighlight: true,
			autoclose: true
		});

		$('#exp-plug-date, #exp-storage-date').datetimepicker({
			dateFormat: 'dd/mm/yy',
			timeFormat: 'H:mm:00',
			todayHighlight: true,
			autoclose: true,	
			controlType: 'select',
			oneLine: true,
			timeInput: true
		});

		$('#ref-exp-date, #exp-plug-date, #exp-storage-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function () {
			$('#ref-exp-date').val('');
		});

		load_payer();

//CONTAINER AND BILL NO PROCESS
		$('#apply-bill').on('click', function () {
			// selected_cont = [];
			$.each( $('#bill-detail').find('td.ti-check'), function (k,v) {
				var cntrNoSelected = $(v).parent().find('td:eq(1)').first().text();
				
				if( $.inArray(cntrNoSelected, selected_cont) == "-1" ){
					selected_cont.push( cntrNoSelected );
				}
			});

			apply_bill();
		});

		$('#bill-modal, #payer-modal, #plug-date-modal, #storage-date-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		var _ktype = "";
		$('#billno').on('keypress', function (e) {
			if(!$(this).val()) return;
			if(e.keyCode == 13){
				_ktype = "enter";
				search_bill($(this).val() ,'');
			}
		});

		$('#cntrno + span').on('click', function () {
			var rl = $('#bill-detail').DataTable().rows().to$();
			if(rl.length == 1 && rl[0].length > 0){
				$(this).attr('data-target', '#bill-modal');
			}else{
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin vận đơn!');
				$(this).attr('data-target', '');
			}
		});

		var _tp = "";
		$('#cntrno').on('change keypress', function (e) {
			if((e.type == 'change' || e.which == 13) && _tp==""){
				apply_cont();
				_tp = e.type;
				return;
			}
			_tp = "";
		});

		$(document).on('click','#bill-detail tbody tr td', function () {
			$(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			$(this).parent().toggleClass('m-row-selected');
		});

//CONTAINER AND BILL NO PROCESS

		$('#b-add-payer').on("click", function(){
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function(){
			$('.add-payer-container').removeClass("payer-show");
		});

///////// SEARCH PAYER
		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#taxcode').trigger("change");
		});
		$('#search-payer').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
///////// END SEARCH PAYER
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

		$("input[name='publish-opt']").on("change", function(e){
			if( $(e.target).val() == "m-inv" ){
				$("#m-inv-container").removeClass("hiden-input");
				$("#pay-atm").prop("disabled", <?= $isDup || !isset( $ssInvInfo ) || count( $ssInvInfo ) == 0; ?>);
				$("#t-mb").prop("disabled",false)
			}
			else if($(e.target).val() == "dft") {
                $("#t-mb").prop("disabled", true);
            }
			else{
				$("#m-inv-container").addClass("hiden-input");
				$("#pay-atm").prop("disabled", false);
				$("#t-mb").prop("disabled",false)
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
				                url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
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

				                    $("#pay-atm").prop("disabled", false);
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

		$('#show-payment-modal').on("click", function(e){
			if(!$("#taxcode").val()){
				$('#taxcode').addClass("error");
				toastr["warning"]("Chưa chọn đối tượng thanh toán!");
				e.preventDefault();
				return;
			}

			var paymentType = $('#payment-type').attr('data-value');
			if( paymentType == "M" ){
				$("#dv-cash").removeClass("hiden-input");
				$("#dv-credit").addClass("hiden-input");
				//
				$("#publish-type").removeClass("hiden-input");

				if( !$("input[name='publish-opt']").is(":checked") ){
					$("input[name='publish-opt'][value='e-inv']").prop("checked", true);
					$("#m-inv-container").addClass("hiden-input");
				}
				
			}else{
				$("#dv-cash").addClass("hiden-input");
				$("#dv-credit").removeClass("hiden-input");
				//
				$("#publish-type").addClass("hiden-input");
				$("input[name='publish-opt']").prop("checked", false);
			}

			$(this).attr("data-target", "#payment-modal");
		});

		$('#service_code').on("change", function(e){
			$("#exp-plug-date, #exp-storage-date").closest(".row").addClass("hiden-input");

			if ( $(e.target).val() == "SDD" ) {
				$("#exp-plug-date").closest(".row").removeClass("hiden-input");
			}
			
			if( $(e.target).val() == "LBC" ){
				$("#exp-storage-date").closest(".row").removeClass("hiden-input");
			}
		});

//CONFIRM SDD
		$("#apply-plug-date").on("click", function(){
			_pluginDates = $("#plugin-cont-list").DataTable()
													.rows()
													.data()
													.toArray().map( p => [ p[1], p[2] ] );
			var temp = _pluginDates.filter( p => !p[1] );
			if( temp.length > 0 ) {
				_pluginDates = [];
				toastr["error"] ( "Vui lòng nhập thời gian cho cont: ["+ temp.map(x=>x[0]).join(", ") +"]" );
				return;
			}

			$("span[data-target='#plug-date-modal'] i").removeClass().addClass("fa fa-check");
			$("#exp-plug-date").val('').trigger('change')

			$("#plug-date-modal").modal("hide");
		});

		$("#default-plug-date").on("click", function(){
			_pluginDates = [];
			$("#plugin-cont-list").DataTable().cells(null, 2)
											  .every( function(){
											  		this.data(moment().format('DD/MM/YYYY 23:59:59'));
											  });
			$('#exp-plug-date').val(moment().format('DD/MM/YYYY 23:59:59')).trigger('change');

			$("span[data-target='#plug-date-modal'] i").removeClass().addClass("la la-ellipsis-h");
		});

		$("#exp-plug-date").on("change", function(e){
			if( $(e.target).val() ){
				_pluginDates = [];
				$("#plugin-cont-list").DataTable().cells(null, 2)
												  .every( function(){
												  		this.data( $(e.target).val() );
												  });

				$("span[data-target='#plug-date-modal'] i").removeClass().addClass("la la-ellipsis-h");
			}
		});
//CONFIRM SDD

//CONFIRM LBC
		$("#apply-storage-date").on("click", function(){
			_storageDates = $("#storage-cont-list").DataTable()
													.rows()
													.data()
													.toArray().map( p => [ p[1], p[2] ] );
			var temp = _storageDates.filter( p => !p[1] );
			if( temp.length > 0 ) {
				_storageDates = [];
				toastr["error"] ( "Vui lòng nhập thời gian cho cont: ["+ temp.map(x=>x[0]).join(", ") +"]" );
				return;
			}

			$("span[data-target='#storage-date-modal'] i").removeClass().addClass("fa fa-check");
			$("#exp-storage-date").val('').trigger('change');

			$("#storage-date-modal").modal("hide");
		});

		$("#default-storage-date").on("click", function(){
			_storageDates = [];
			$("#storage-cont-list").DataTable().cells(null, 2)
											  .every( function(){
											  		this.data(moment().format('DD/MM/YYYY 23:59:59'));
											  });
			$('#exp-storage-date').val(moment().format('DD/MM/YYYY 23:59:59')).trigger('change');

			$("span[data-target='#storage-date-modal'] i").removeClass().addClass("la la-ellipsis-h");
		});

		$("#exp-storage-date").on("change", function(e){
			if( $(e.target).val() ){
				_storageDates = [];
				$("#storage-cont-list").DataTable().cells(null, 2)
												  .every( function(){
												  		this.data( $(e.target).val() );
												  });

				$("span[data-target='#storage-date-modal'] i").removeClass().addClass("la la-ellipsis-h");
			}
		});
//CONFIRM LBC

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				loadpayment();
			}
			if($(this).val() == "inv"){
				$('#tbl-inv').DataTable().columns.adjust();
			}else{
				$('#tbl-conts').DataTable().columns.adjust();
			}
		});

		$('#remove').on('click', function () {
			if($('#chk-view-inv').is(':checked')) return;
			
			var tbl = $('#tbl-conts');

			if( tbl.DataTable().rows().count() == 0 ){
				return;
			}

			if( tbl.DataTable().rows('.selected').count() == 0 ){
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
						action: function(){
							var selectContNos = tbl.DataTable().rows(".selected")
																.data().toArray()
																.map( p => p[ _cols.indexOf("CntrNo") + 1 ] );
							tbl.DataTable().rows(".selected").remove().draw(false);
							tbl.updateSTT();

							selected_cont = selected_cont.filter( p=> selectContNos.indexOf( p ) == "-1" );
							_lstODR = _lstODR.filter( p=> selectContNos.indexOf( p.CntrNo ) == "-1" );

							//remove container in plugin date detail table
							$.each( $('#plugin-cont-list tbody, #storage-cont-list tbody').find('tr').find('td:eq(1)'), function (idx, td) {
								if( selectContNos.indexOf($(td).text()) != "-1" ){
									$('#plugin-cont-list, #storage-cont-list').DataTable().rows( $(td).closest("tr") ).remove().draw(false);
								}
							});
							
							$('#tbl-inv').DataTable().clear().draw();
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

		var iptimee;
		$('input').on('input', function (e) {
            var id = $(e.target).attr("id");
            if( id == "cntrno" || id == "billno" ){
                e.preventDefault();
                return;
            }
                      
			clearTimeout(iptimee);
			iptimee = window.setTimeout(function () {
				$(e.target).blur();
			}, 2000);
		});

		var typingTimer;
		$(document).on('change','input[type!="radio"], select', function (e) {
			clearTimeout(typingTimer);
			if($(this).val()){
				$(this).removeClass('error');
				$(this).parent().removeClass('error');
			}
			if($(e.target).attr('id') == 'taxcode'){
				var cusID = $("#cusID").val(); var pytype = getPayerType(cusID);
				$.each(_lstODR, function (k, v) {
					_lstODR[k].CusID = cusID;
					_lstODR[k].PAYER_TYPE = pytype;
				});
				fillPayer();
			}
			if($(e.target).attr('id') == "billno"){
				if(e.type == 'change' && _ktype == ""){
					search_bill($('#billno').val(), '');
				}
				// //reset list eir
				_lstODR = [];
				// if($('#tbl-conts').find('tr').length > 1){
				// 	$('#tbl-conts').DataTable().clear().draw();
				// }
				// if($('#tbl-inv').find('tr').length > 1){
				// 	$('#tbl-inv').DataTable().clear().draw();
				// }

				$('#tbl-inv').dataTable().fnClearTable();

				return;
			}

			typingTimer = window.setTimeout(function () {
				//reset list eir
				_lstODR = [];
				if($('.input-required.error').length == 0){
					if(_result.length > 0 && selected_cont.length > 0){
						for (i = 0; i < _result.length; i++) {
							if (selected_cont.indexOf(_result[i].CntrNo) == '-1') continue;
							addCntrToSRV_ODR(_result[i]);
						}
					}

					if($('#chk-view-inv').is(':checked') 
							&& $.inArray($(e.target).attr('id'), ['shipper-name', 'taxcode', 'billno', 'exp-plug-date', 'exp-storage-date', 'service_code']) != "-1"){
						loadpayment();
					}
				}
			}, 1000);
		});

		$("#save-payer").on("click", function(){
			var addTaxCode = $("#add-payer-taxcode").val();
			var addPayerName = $("#add-payer-name").val();
			var address = $("#add-payer-address").val();

			if( !addTaxCode ){
				$("#add-payer-taxcode").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập thông tin [Mã số thuế]!");
				return;
			}

			var checkTaxCode = addTaxCode;
			checkTaxCode = checkTaxCode.replace("-", "");
			
			if( [10, 13].indexOf( checkTaxCode.length ) == "-1" || isNaN( checkTaxCode ) ){
				$("#add-payer-taxcode").addClass("error");
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập đúng định dạng [Mã số thuế]!");
				return;
			}

			if( !addPayerName ){
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

			save_new_payer( formData );
		});

		$('#pay-atm').on('click', function () {
			if( $("input[name='publish-opt']:checked").val() == "e-inv" ){
				publishInv();
			}else{
				saveData();
			}
		});

		$('#save-credit').on("click", function(){
			saveData();
		});

		function addCntrToSRV_ODR(item){
			item['CJMode_CD'] = $('#service_code').val();
			item['CJModeName'] = $('#service_code option:selected').text().split(":")[1].trim();
			
			if( item['CJMode_CD'] == 'SDD' ){
				item['ExpPluginDate'] = $('#exp-plug-date').val() ? $('#exp-plug-date').val() :  _pluginDates.filter( p => p[0] == item['CntrNo'] )[0][1];
			}

			if( item['CJMode_CD'] == 'LBC' ){
				item['ExpDate'] = $('#exp-storage-date').val() 	? $('#exp-storage-date').val()
																:  _storageDates.filter( p => p[0] == item['CntrNo'] )[0][1];
			}else{
				item['ExpDate'] =  $('#ref-exp-date').val(); //*
			}

			item['PTI_Hour'] = 0;

			item['IssueDate'] =  $('#ref-date').val(); //*
			
			item['NameDD'] =  $('#personal-name').val();
			item['PersonalID'] =  $('#cmnd').val();
			item['DMETHOD_CD'] = 'NULL';

			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*
			item['PAYER_TYPE'] = getPayerType($('#cusID').val());
			item['CusID'] = $('#cusID').val(); //*

			item['OPERATIONTYPE'] = 'NULL';

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['Mail'] = $("#mail").val();

			item['cBlock1'] = item['cBlock'];
			item['cBay1'] = item['cBay'];
			item['cRow1'] = item['cRow'];
			item['cTier1'] = item['cTier'];
			delete item['cBlock'];
			delete item['cBay'];
			delete item['cRow'];
			delete item['cTier'];

			_lstODR.push(item);
		}

		function search_bill(billno, cntrNo){
			$('#bill-detail').waitingLoad();
            var billno = billno.toUpperCase();
            var cntrNo = cntrNo.toUpperCase();
                      
			var formData = {
				'action': 'view',
				'act': 'search_bill',
				'billNo': billno,
				'cntrNo': cntrNo
			};

			$('#has-block-content').blockUI();
                      
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					$('#has-block-content').unblock();

					if( data.deny ){
						toastr["error"](data.deny);
						return;
					}

					if( data.error ){
						toastr["error"]( data.error );
						return;
					}

					var rows = []; var blNo = '';
                   
					if(  !data.list || data.list.length == 0  ){
						$('#bill-detail').DataTable().clear().draw();
						$('.toast').remove();
						var errNotify = formData.billNo != "" ? 'Số vận đơn ['+ formData.billNo +']' : 'Số Cont ['+ formData.cntrNo +']';
						toastr['error']( errNotify + ' không đủ điều kiện làm lệnh!<br/>Vui lòng kiểm tra lại!');

						return;
					}else{

						if (data.list[0].Ter_Hold_CHK == '1') {
							$.alert({
								title: 'Cảnh báo!',
								content: 'Container [' + data.list[0].CntrNo + '] đang bị giữ tại Cảng!',
								type: 'red'
							});
							return;
						}
						
						var avaiCont = _result.map( x=>x.CntrNo );
						var avaiShipKey = _result.map( x=>x.ShipKey );
						var avaiBLNo = _result.map( x=>x.BLNo );
                   
                        if( formData.cntrNo != '' ) {
                           data.list.filter( p => avaiCont.indexOf(p.CntrNo) == -1 )
                                    .map( item => _result.push(item) );
                        }else{
                            data.list.filter( p => avaiCont.indexOf(p.CntrNo) == -1 && avaiBLNo.indexOf(p.BLNo) == -1 )
                                     .map( item => _result.push(item) );
                        }

						blNo = _result[0].BLNo;

						for (i = 0; i < data.list.length; i++) {
							rows.push([
								''
								, data.list[i].CntrNo
								, data.list[i].OprID
								, data.list[i].ISO_SZTP
								, data.list[i].cBlock + "-" + data.list[i].cBay + "-" + data.list[i].cRow + "-" + data.list[i].cTier
							]);
						}
                   
						$('#bill-detail').DataTable( {
                            data: rows,
							info: true,
							paging: false,
							ordering: false,
							searching: true,
							scrollY: '51vh',
							createdRow: function(row, data, dataIndex){
								if(formData.cntrNo != '') {
									if( data[1] == formData.cntrNo){
										$('td:eq(0)', row).addClass("ti-check");
										$(row).addClass('m-row-selected');
									}
								}else{
									$('td:eq(0)', row).addClass("ti-check");
									$(row).addClass('m-row-selected');
								}
							}
						} );
					}

					if(formData.cntrNo != '' && blNo != ''){
						$('#cntrno').val('');
						$('#billno').val(blNo);

						// selected_cont = [cntrNo];
						if($.inArray(cntrNo, selected_cont) == "-1"){
							selected_cont.push(cntrNo);
						}

						apply_bill();
					}else{
						$('#cntrno + span').trigger('click');
					}

					_ktype = "";
				},
				error: function(err){
					$('#has-block-content').unblock();
					console.log(err);
				}
			});
		}

		function apply_cont(){
			var cntrno = $('#cntrno').val().trim();
			if(!cntrno) return;
            
            cntrno = cntrno.toUpperCase();
			if(_result.length == 0 || _result.filter(p=> p.CntrNo == cntrno).length == 0 || $('#bill-detail').DataTable().rows().to$().length == 0) {
				search_bill('', cntrno);
				return;
			}
            
			if( $.inArray(cntrno, selected_cont) == "-1" ){
				
				selected_cont.push(cntrno);
                      
                $('#bill-detail').DataTable().cells(null, 1).every( function(){
                    if( this.data() == cntrno ) {
                        var r = $('#bill-detail').DataTable().row( this.index().row )
                                                             .nodes().to$().addClass("m-row-selected");
                        $('#bill-detail').DataTable().cell( this.index().row, 0 ).nodes().to$().addClass("ti-check");
                    }
                })

				apply_bill();
			}
		}

		function apply_bill(){
			var hasrequired = false;
			if($('.input-required.error').length > 0){
				hasrequired = true;
			}else{
				hasrequired = $('.input-required').has_required();
				if(hasrequired){
					$('.toast').remove();
					toastr['error']('Các trường bắt buộc (*) không được để trống!');
				}
			}

			$("#tbl-conts").waitingLoad();

			var rows = [];
			if(_result.length > 0 && selected_cont.length > 0){
				var stt = 1;
				//reset list order
				_lstODR = [];
				for (i = 0; i < _result.length; i++) {
					if( selected_cont.indexOf( _result[i].CntrNo) == '-1') continue;

					//add item cntr_details to _lst;
					if($('.input-required.error').length == 0){
						if(!hasrequired){
							addCntrToSRV_ODR(_result[i]);
						}
					}
					var cntrclass = _result[i].CntrClass == 1 ? "Nhập" : (_result[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
					var r = [];

					if( _result[i].EIRNo )
					{
						toastr['error']("Container [" + _result[i].CntrNo + "] đã làm lệnh [nâng/hạ] số ["+ _result[i].EIRNo +"]");
					}

					if( _result[i].SSOderNo )
					{
						toastr['error']("Container [" + _result[i].CntrNo + "] đã làm lệnh [đóng rút/dịch vụ] số ["+ _result[i].SSOderNo +"]");
					}

					r.push((stt++));
					$.each(_cols, function(indx, item){
						var value = "";
						switch(item){
							case "CARGO_TYPE":
								value = '<input class="hiden-input" value="'+ _result[i].CARGO_TYPE +'"/>' + _result[i].Description;
								break;
							case "IsLocal":
								value = _result[i].IsLocal == "F" ? "Ngoại" : (_result[i].IsLocal == "L" ? "Nội" : "");
								break;
							case "Status":
								value = _result[i].Status == "F" ? "Hàng" : "Rỗng";
								break;
							case "cTLHQ":
								value = _result[i].cTLHQ == 1 ? "Đã thanh lý" : "Chưa thanh lý";
								break;
							default:
								value = _result[i][item] ? _result[i][item] : "";
								break;
						}
						r.push(value);
					});

					rows.push(r);
				}
			}

			$('#chk-view-cont').trigger('click');

			$('#tbl-conts').dataTable().fnClearTable();
			$('#plugin-cont-list').dataTable().fnClearTable();
			$('#storage-cont-list').dataTable().fnClearTable();

			if( rows.length > 0 ){
				$('#tbl-conts').dataTable().fnAddData(rows);

				$("#plugin-cont-list").dataTable().fnAddData(rows.map( x => [x[0], x[1], $("#exp-plug-date").val()] ));
				$("#storage-cont-list").dataTable().fnAddData(rows.map( x => [x[0], x[1], $("#exp-storage-date").val()] ));
			}

			$('#tbl-inv').dataTable().fnClearTable();
		}

		function loadpayment()
		{
			if( _lstODR.length == 0 ) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if($('.input-required.error').length > 0) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if($('.input-required').has_required()){
				$('#tbl-inv').DataTable().clear().draw();
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			$('#tbl-inv').waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#cusID').val(),
				'list': _lstODR
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
                    EirNo_Draft = null //reset EirDraft
					if(data.deny){
						toastr["error"](data.deny);
						return;
					}

					if( data.no_payer ){
						$(".toast").remove();
						toastr["error"](data.no_payer);

						$('#tbl-inv').dataTable().fnClearTable();
						return;
					}

					if( data.no_tariff_end ){
						$(".toast").remove();
						toastr["error"]( data.no_tariff_end );
						tblInv.dataTable().fnClearTable();
						return;
					}

					if( data.no_tariff ){
						$(".toast").remove();
						toastr["warning"]( data.no_tariff );
					}

					if( data.freeContInYard ){
						toastr["warning"]("Container [" + data.freeContInYard.join(", ") + "] được miễn phí lưu bãi!" );
					}

					if( data.ps_notify ){
						$("#notify-modal").find( ".modal-body h4" ).html(data.ps_notify);
						$("#show-ps-notify").removeClass("hiden-input");
					}else{
						$("#notify-modal").find( ".modal-body h4" ).html("");
						$("#show-ps-notify").addClass("hiden-input");
					}

					if( data.error_plugin && data.error_plugin.length > 0 ){
						$(".toast").remove();
						$.each( data.error_plugin, function(){
							toastr["error"](this);
						} );

						$('#tbl-inv').dataTable().fnClearTable();
						return;
					}

					if(!data.results || data.results.length == 0 && !data.freeContInYard ){
						toastr["warning"]("Không tìm thấy biểu cước phù hợp! Vui lòng kiểm tra lại!");
						$('#tbl-inv').DataTable().clear().draw();
						return;
					}

					if(data.error && data.error.length > 0){
						$.each(data.error, function(){
							toastr["warning"](this);
						});
					}

					var rows = [];
					if(data.results && data.results.length > 0){
						var lst = data.results, stt = 1;
						for (i = 0; i < lst.length; i++) {
							rows.push([
								(stt++)
								, lst[i].DraftInvoice
								, lst[i].OrderNo ? lst[i].OrderNo : ""
								, lst[i].TariffCode
								, lst[i].TariffDescription
								, lst[i].Unit
								, lst[i].JobMode == 'GO' ? "Nâng container" : "Hạ container"
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
					$('#tbl-inv').DataTable( {
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
				},
				error: function(err){console.log(err);}
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

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function (data) {
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
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		};

		function fillPayer(){
			var py = payers.filter(p=> p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());
			if(py.length > 0){ //fa-check-square
				$('#p-taxcode').text(py[0].VAT_CD);
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);
				$('#payment-type').attr('data-value', py[0].CusType);
				$('#payment-type').text(py[0].CusType == 'M' ? "THU NGAY" : "THU SAU");
				if(py[0].CusType == "M"){
					$('#p-money i').removeClass('fa-square').addClass('fa-check-square');
					$('#p-credit i').removeClass('fa-check-square').addClass('fa-square');
					$("#t-mb").prop("disabled",false)
				}else{
					$('#p-money i').removeClass('fa-check-square').addClass('fa-square');
					$('#p-credit i').removeClass('fa-square').addClass('fa-check-square');
                	$("#t-mb").prop("disabled", true);
				}

				$("#cmnd").val( py[0].PersonalID );
				$("#personal-name").val( py[0].NameDD );
				if( py[0].Email ){
					$("#mail").val( py[0].Email );
				}

				if( py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email ){
					$("#mail").val( $("#mail").val() + ',' + py[0].EMAIL_DD );
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
		function publishInv(){
			$('#payment-modal').find('.modal-content').blockUI();
			var datas = getInvDraftDetail();
			var formData = {
				cusTaxCode : $('#p-taxcode').text(),
				cusAddr : $('#p-payer-addr').text(),
				cusName : $('#p-payername').text(),
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

					if( data.error ){
						$(".toast").remove();
						toastr["error"]( data.error );
						return;
					}
					
					saveData(data);
				},
				error: function(err){
					$('#payment-modal').find('.modal-content').unblock();
					console.log(err);
				}
			});
		}

		//SAVE DATA
		function saveData(invInfo, draft = true){
			var drDetail = getInvDraftDetail();
			var drTotal = {};
			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});

			var publish_opt_checked = $("input[name='publish-opt']:checked").val();

			_lstODR.map( x => x.Note = $('#remark').val() );
			_lstODR.map( x => x.SHIPPER_NAME = $('#shipper-name').val() );
			_lstODR.map( x => x.PersonalID = $('#cmnd').val() );
			_lstODR.map( x => x.NameDD = $('#personal-name').val() );
			_lstODR.map( x => x.Mail = $('#mail').val() );
			if(!draft) {
                _lstODR.map(x => x.publishType = publish_opt_checked ? publish_opt_checked : "e-inv");
                _lstODR.map(x => x.Type_Eir = 'Lệnh Dịch Vụ');
            }
			else {
				_lstODR.map(x => {
						delete x.publishType;
						delete x.Type_Eir;
					});
			}
			var formData = {
				'action': draft ? 'save' : 'save_draft',
				'data': {
					'pubType': publish_opt_checked ? publish_opt_checked : "credit",
					'odr': _lstODR,
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
				//trg hop không phải xuất hóa đơn ddienj tử, block popup thanh toán
				$('#payment-modal').find('.modal-content').blockUI();
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if(data.EIR_Draft) {
						EirNo_Draft = data.EIR
						return handleClickPayQrMb(data.EIR)
					}
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
					$('.toast').remove();
					$('#payment-modal').find('.modal-content').unblock();
					toastr['error']("Internal Error!");
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
			if(rows.length == 0 ) return [];
			$.each(rows, function (idx, item) {
				var temp = {};
				for(var i = 1; i <= _colsPayment.length - 1; i++){
					temp[_colsPayment[i]] = item[i];
				}
				temp['Remark'] = $.unique(_lstODR.map(p=> p.CntrNo)).toString();
				drd.push(temp);
			});
			return drd;
		}

		function save_new_payer( formData ){
			$(".add-payer-container").blockUI();
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {

					$(".add-payer-container").unblock();

					if( data.deny ){
						toastr["error"]( data.deny );
						return;
					}

					if( data.error ){
						toastr["error"]( data.error );
						return;
					}

					toastr["success"]("Thêm mới thành công!");
					$(".add-payer-container").find("input").val("");

					var tblPayer = $('#search-payer');
					var dtTblPayer = tblPayer.DataTable();
					if( data.saveType == "add" ){
						toastr["success"]("Thêm mới thành công!");

						var rowcount = dtTblPayer.rows().count();
						var row = [
							rowcount + 1, formData.taxCode, formData.taxCode, formData.cusName, formData.address, 'Thu ngay'
						];

						tblPayer.dataTable().fnAddData(row);

						dtTblPayer.page("last").draw("page");

						var lastRow = dtTblPayer.row( ':last', { order: 'applied' } );

						dtTblPayer.rows( '.m-row-selected' ).nodes().to$().removeClass("m-row-selected");

						$( lastRow.node() ).addClass("m-row-selected");

						dtTblPayer.search( formData.taxCode ).draw(false);

						payers.push({
							  Address: formData.address
							, CusID: formData.taxCode
							, CusName: formData.cusName
							, CusType: "M"
							, IsAgency: "0"
							, IsLogis: "0"
							, IsOpr: "0"
							, IsOther: "0"
							, IsOwner: "1"
							, IsTrans: "0"
							, VAT_CD: formData.taxCode
						});
					}

					if( data.saveType == "edit" ){
						toastr["success"]("Cập nhật thành công!");
						var indx = payers.findIndex(x => x.VAT_CD == formData.taxCode && x.CusType == 'M' );
						payers[indx]["CusName"] = formData.cusName; payers[indx]["Address"] = formData.address;

						var indexes = dtTblPayer.rows().eq( 0 ).filter( function (rowIdx) {
						    return dtTblPayer.cell( rowIdx, 2 ).data() === formData.taxCode
						    			&& dtTblPayer.cell( rowIdx, 5 ).data() === 'Thu ngay';
						} );

						if( indexes.toArray().length > 0 ){
							var firstIdx = indexes.toArray()[0];

							dtTblPayer.rows( '.m-row-selected' ).nodes().to$().removeClass("m-row-selected");
							dtTblPayer.rows( firstIdx ).nodes().to$().addClass("m-row-selected");

							dtTblPayer.cell( firstIdx, 3 ).data(formData.cusName);
							dtTblPayer.cell( firstIdx, 4 ).data(formData.address);
							dtTblPayer.search( formData.taxCode );
							dtTblPayer.draw(false);
						}
					}

				},
				error: function(xhr, status, error){
					console.log(xhr);

					$(".add-payer-container").unblock();
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra khi lưu dữ liệu! Vui lòng liên hệ KTV! ");
				}
			});
		}
	});

</script>
<script language = "javascript" type = "text/javascript" >
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};

</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
