<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/css/bootstrap-multiselect.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}

	.form-group{
		margin-bottom: 7px;
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
	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
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

	/*.m-form-group{
		border: 1px solid blue;
		border-radius: 50%;
		padding: 5px;
		border-top: none;
	}*/
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">TÍNH CƯỚC THU SAU</div>
				<div class="button-bar-group mr-3">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
				</div>
			</div>
			<div class="ibox-body p-3 bg-f9 border-e">
				<div class="row ibox mb-0 border-e p-3">
					<div class="col-12 pb-1">
						<h6>Tiêu chí lọc</h6>
					</div>
					<div class="col-7">
						<div class="row form-group p-1">
							<div class="col-3">
								<label class="radio radio-grey radio-primary">
									<input type="radio" checked id="quayJobChk" name="filterType">
									<span class="input-span"></span>
									Công việc tàu
								</label>
							</div>
							<div class="col-3">
								<label class="radio radio-grey radio-primary">
									<input type="radio" id="yardJobChk" name="filterType">
									<span class="input-span"></span>
									Công việc bãi
								</label>
							</div>
							<div class="col-3">
								<label class="radio radio-grey radio-primary">
									<input type="radio" id="serviceChk" name="filterType">
									<span class="input-span"></span>
									Dịch vụ
								</label>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="row form-group">
									<div class="col-sm-12 input-group">
										<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="transit" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Chuyển cảng">
											<option value="" selected>-- [Chuyển cảng] --</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="dateStart" type="text" placeholder="Ngày bắt đầu" readonly>
								</div>
							</div>
							<div class="col-4">
									<div class="input-group">
										<input class="form-control form-control-sm input-required" id="dateEnd" type="text" placeholder="Ngày kết thúc" readonly>
									</div>
								</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="canggiaonhan" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Cảng giao nhận">
											<option value="" selected>-- [Cảng giao nhận] --</option>
										</select>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="isLocal" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hàng nội/ngoại">
											<option value="" selected>-- [nội/ngoại] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="FE" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hàng/Rỗng">
											<option value="" selected>-- [Hàng/Rỗng] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="cntrClass" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hướng nhập/xuất">
											<option value="" selected>-- [Nhập/Xuất] --</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-5" style="border-left: 1px solid #cecece">
						<div class="row form-group p-1" style="visibility: hidden;">
							<div class="col-12">
								<label class="radio radio-grey radio-primary">
									<input type="radio" name="">
									<span class="input-span"></span>
									Công việc tàu
								</label>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="OprID" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="cjMode" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="jobType" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-3 pt-1" style="border-right: 1px solid #cecece">
					<h6>Thông tin hóa đơn</h6>
					<div class="row form-group">
						<div class="col-sm-12 input-group">
							<input class="form-control form-control-sm input-required" id="cusID" placeholder="Đối tượng thanh toán" type="text" data-toggle="modal" data-target="#cusID-modal" readonly>
							<span data-toggle="tooltip" data-placement="right" data-original-title="Đối tượng thanh toán" class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn đối tượng thanh toán">
								<i class="la la-search"></i>
							</span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12 input-group input-group-sm">
							<select id="creditType" class="selectpicker form-control" data-width="100%" data-style="btn-default btn-sm" title="Biểu cước">
								<option value="" disabled selected>--[Biểu cước]--</option>
							</select>
							<span data-toggle="tooltip" data-placement="right" data-original-title="Biểu cước" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-list-ul"></i></span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-12 input-group input-group-sm">
							<input class="form-control form-control-sm" disabled id="Credit" type="text" placeholder="Số phiếu tính cước">
							<span data-toggle="tooltip" data-placement="right" data-original-title="Số phiếu tính cước" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-file-text"></i></span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-12 input-group input-group-sm">
							<div class="input-group">
								<input class="form-control form-control-sm input-required" id="creditDate" type="text" placeholder="Ngày lập">
								<span data-toggle="tooltip" data-placement="right" data-original-title="Ngày lập" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-calendar"></i></span>
							</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-9 input-group input-group-sm">
							<input class="form-control form-control-sm" disabled id="taxNo" type="text" placeholder="Mã số thuế">
							<span data-toggle="tooltip" data-placement="right" data-original-title="Mã số thuế" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-credit-card"></i></span>
						</div>
						<div class="col-3 pl-0">
							<button class="btn btn-primary btn-sm" id="VAT" data-toggle="modal" data-target="#VAT-modal" style="width: 100%;">
									VAT
							</button>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-12 input-group input-group-sm">
							<input class="form-control form-control-sm" id="address" type="text" placeholder="Địa chỉ">
							<span data-toggle="tooltip" data-placement="right" data-original-title="Địa chỉ" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-map-o"></i></span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-5 input-group input-group-sm pr-0">
							<select id="cashType" class="selectpicker form-control" data-width="100%" data-style="btn-default btn-sm" title="Loại tiền">
								<option value="VND" selected>VND</option>
							</select>
							<span data-toggle="tooltip" data-placement="right" data-original-title="Loại tiền" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-money"></i></span>
						</div>
						<div class="col-sm-7 input-group input-group-sm">
							<input class="form-control form-control-sm" id="cash" disabled type="text" placeholder="Số tiền">
							<span data-toggle="tooltip" data-placement="right" data-original-title="Số tiền" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-dollar"></i></span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-12 input-group input-group-sm">
							<input class="form-control form-control-sm" id="remark" type="text" placeholder="Ghi chú">
							<span data-toggle="tooltip" data-placement="right" data-original-title="Ghi chú" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-sticky-note"></i></span>
						</div>
					</div>
				</div>
				<div class="col-9">
					<div class="row">
						<div class="col-5">
							<h6 class="pt-1">Thông tin tính cước</h6>
						</div>
						<div class="col-7">
							<button style="float: right;" class="btn btn-warning btn-sm" title="Thông tin thanh toán" data-toggle="modal" data-target="#payment-modal">
								<i class="fa fa-print"></i>
								Thanh toán
							</button>
						</div>
					</div>
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>Mã biểu cước</th>
							<th style="min-width: 200px">Diễn giải</th>
							<th>ĐVT</th>
							<th>Hướng</th>
							<th>Phương án</th>
							<th>Công việc</th>
							<th>PTGN</th>
							<th>Nội/Ngoại</th>
							<th>Loại hàng</th>
							<th>Kích cỡ</th>
							<th>Hàng/Rỗng</th>
							<th>SL</th>
							<th>Đơn giá</th>
							<th>CK(%)</th>
							<th>Đơn giá CK</th>
							<th>Đơn giá sau CK</th>
							<th>Thành tiền</th>
							<th>Thuế(%)</th>
							<th>Tiền thuế</th>
							<th>Loại tiền</th>
							<th>Tổng tiền</th>
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

<!-- modal -->
<div class="modal fade" id="VAT-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-dialog-mw-py" role="document" style="max-width: 80vw">
		<div class="modal-content p-3">
			<div class="modal-header">
				<h5>Phát hành hóa đơn VAT</h5>
				<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-5">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Số hóa đơn</label>
							<div class="col-sm-3 input-group input-group-sm">
								<input class="form-control form-control-sm" id="VatInvPre" type="text" placeholder="---">
							</div>
							<div class="col-sm-5 input-group input-group-sm">
								<input class="form-control form-control-sm" id="VatInvNo" type="text" placeholder="Số hóa đơn">
								<span data-toggle="tooltip" data-placement="right" id="checkVatInvNo" data-original-title="Kiểm tra hóa đơn" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-check-square"></i></span>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Phiếu tính cước</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatCredit" type="text" placeholder="---">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Ngày lập</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="creDate" type="text" placeholder="Ngày lập" readonly>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Ngày hết hạn</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="expDate" type="text" placeholder="Ngày hết hạn">
									<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-4 col-form-label">HT Thanh toán</label>
							<div class="col-md-8 input-group input-group-sm">
								<select id="paymentType" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hình thức thanh toán">
									<option value="" disabled selected>--[Hình thức thanh toán]--</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Mã số thuế</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatTaxNo" type="text" placeholder="Mã số thuế">
							</div>
						</div>
					</div>
					<div class="col-7">
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">ĐT Thanh toán</label>
							<div class="col-sm-9 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatPayer" type="text" placeholder="Đối tượng thanh toán">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Địa chỉ</label>
							<div class="col-sm-9 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatAddress" type="text" placeholder="Địa chỉ">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Ghi chú</label>
							<div class="col-sm-9 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatRemark" type="text" placeholder="Ghi chú">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Diễn giải</label>
							<div class="col-sm-9 input-group input-group-sm">
								<input class="form-control form-control-sm" disabled id="VatDescript" type="text" placeholder="Diễn giải">
							</div>
						</div>
						<div class="row form-group m-form-group mt-3">
							<div class="col-3">
								<h6>In hóa đơn theo</h6>
							</div>
							<div class="col-2">
								<label class="radio radio-grey radio-primary">
									<input type="radio" checked id="VATUsd" name="VATMoneyType">
									<span class="input-span"></span>
									USD
								</label>
							</div>
							<div class="col-2">
								<label class="radio radio-grey radio-primary">
									<input type="radio" id="VATVnd" name="VATMoneyType">
									<span class="input-span"></span>
									VND
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button style="float: right;" class="btn btn-success btn-sm" title="Xác nhận">
					<i class="la la-check"></i>
					Xác nhận
				</button>
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
							<a class="col-form-label pr-5" id="p-money" style="pointer-events: none;"><i class="fa fa-square"></i> Chuyển khoản</a>
							<a class="col-form-label" id="p-credit" style="pointer-events: none;"><i class="fa fa-check-square"></i> Thu sau</a>
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
				<div style="margin: 0 auto">
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ ATM</span>
					</button>
					<button class="btn btn-rounded btn-rounded btn-gradient-lime">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ MASTER, VISA</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="groups-modalLabel">Chọn tàu</h6>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-5">
						<div class="row">
							<div class="form-group col-6">
								<label class="radio radio-primary">
									<input id="shipOut" type="radio" name="shipinout" checked="true">
									<span class="input-span"></span>
									Tàu đã rời cảng
								</label>
							</div>
							<div class="form-group col-6">
								<label class="radio radio-primary">
									<input id="shipIn" type="radio" name="shipinout">
									<span class="input-span"></span>
									Tàu đến cảng
								</label>
							</div>
						</div>
					</div>
					<div class="col-7 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-year" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Nhập tên tàu">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body pt-0">
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
				<button type="button" id="select-ship" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>

<!--select customer-->
<div class="modal fade" id="cusID-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h6>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-cusType" title="Loại ĐTTT" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option>Chủ tàu</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-cus-name" type="text" placeholder="Nhập tên đối tượngt thanh toán">
									<img id="btn-search-cus" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body pt-0">
				<div class="table-responsive">
					<table id="search-cusID" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
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
				<button type="button" id="select-ship" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>

<select id="status" style="display: none">
	<option value="0">Ngưng hoạt động</option>
	<option value="1">Hoạt động</option>
</select>

<select id="httt" style="display: none">
	<option value="0">Thu ngay</option>
	<option value="1">Thu sau</option>
</select>

<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var _colCont = ["rowguid", "STT", "BILL_CHK", "CntrNo", "ISO_SZTP", "OprID", "cntrClass", "Status", "CJMode_CD", "DMethod_CD", "CARGO_TYPE", "SHIPPER", "isLocal"
							, "BLNo", "BookingNo", "Transit_CD", "GNRL_TYPE", "REMARK"];

		var _colInfo = ["rowguid", "STT", "CntrNo", "LocalSZPT", "Status", "congviec"];

		var _colStatis = ["STT", "OprID", "cntrClass", "cong viec", "20E", "40E", "45E", "20F", "40F", "45F"];

		//define table cont
		var tblCont = $('#tableCont');
		var dataTblCont = tblCont.newDataTable({
			scrollY: '30vh',
			order: [[ _colCont.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            info: false,
            columnDefs: [{
		      targets: 0,
		      width: 20,
		      orderable: false,
		      className: 'select-checkbox'
		    }
		  	],
            // buttons: [],
            searching: false,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            "dom": '<"contTool">frtip',
            rowReorder: false
		});
		$('div.contTool').html('<h6>Danh sách Container</h6>');
		$('#checkAll').on('click', function() {
			if ($('#checkAll').is(':checked')) {
		  		dataTblCont.rows().select();
		  	}
		  	else {
		  		dataTblCont.rows().deselect();
		  	}
		});

		//define table info
		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			buttons: [],
			searching: false,
			scrollY: '38vh'
		});

		//define table statis
		var tblStatis = $('#tableStatis');
		var dataTblStatis = tblStatis.newDataTable({
			scrollY: '30vh',
			order: [[ _colStatis.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            info: false,
            searching: false,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            "dom": '<"statisTool">frtip',
            rowReorder: false
		});
		$('div.statisTool').html('<h6>Thống kê</h6>');

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		$('#search-cusID').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		// define selectpicker
		$('#OprID').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Chọn hãng khai thác'
		});
		$('#jobType').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Chọn công việc'
		});
		$('#cjMode').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Chọn phương án',
			virtualScroll: true
		});

		// define datetime
		$('#dateStart').val(moment().format('DD/MM/YYYY HH:mm:ss'));
	    $('#dateEnd').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});

	});
</script>
<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>