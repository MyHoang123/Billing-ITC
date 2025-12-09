<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

<style>
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
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">TẬP HỢP CONTAINER LƯU BÃI</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h6>Tiêu chí lọc</h6>
					</div>
				</div>
				<div class="row border-e bg-white pb-1 pt-2">
					<div class="col-12">
						<div class="row">
							<div class="col-7">
								<div class="row">
									<div class="col-6">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Từ ngày</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="ref-date" type="text" placeholder="Từ ngày" readonly>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Đến ngày</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text" placeholder="Đến ngày">
													<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-6">
										<div class="row form-group">
											<label class="col-4 col-form-label pl-0">Hãng khai thác</label>
											<div class="col-md-8 input-group input-group-sm">
												<select id="oprId" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hãng khai thác">
													<option value="" disabled selected>--[hãng khai thác]--</option>
												</select>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-4 col-form-label pl-0">Kích cỡ</label>
											<div class="col-md-8 input-group input-group-sm">
												<select id="oprId" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Kích cỡ">
													<option value="" disabled selected>--[Kích cỡ]--</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-5">
								<div class="row form-group">
									<label class="col-2 col-form-label pl-0">Hướng cắm</label>
									<div class="col-10 input-group-sm input-group">
										<select class="selectpicker form-control" data-selected-text-format="count > 5" id="OprID" multiple>
											<option data-subtext="Hạ container">HC</option>
											<option data-subtext="Vào cổng">VC</option>
											<option data-subtext="Dỡ tàu">DT</option>
											<option data-subtext="Cắm để đóng hàng">ĐH</option>
										</select>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="row form-group">
											<label class="col-4 col-form-label pl-0">F/E</label>
											<div class="col-md-8 input-group input-group-sm">
												<select id="oprId" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hàng/Rỗng">
													<option value="" disabled selected>--[F/E]--</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-6">
										<div class="row form-group">
											<label class="col-4 col-form-label">Hướng</label>
											<div class="col-md-8 input-group input-group-sm">
												<select id="oprId" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hướng">
													<option value="" disabled selected>--[Hướng]--</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row MT-toggle mt-2 border-e bg-white">
					<div class="col-sm-12 pt-2">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Nơi trả *</label>
											<div class="col-sm-8">
												<div class="input-group">
													<select id="MT-retlocation" class="selectpicker MT-change-required" data-style="btn-default btn-sm" data-width="100%" data-live-search="true">
														<option value="" selected>--[Nơi trả rỗng]--</option>
														<?php if(isset($relocation) && count($relocation) > 0){ foreach ($relocation as $item){ ?>
															<option value="<?= $item['GNRL_CODE'] ?>"><?= $item['GNRL_NM'] ?></option>
														<?php }} ?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Hạn trả *</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm MT-change-required" id="MT-exp-date" type="text" placeholder="Hạn trả">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Ghi chú</label>
									<div class="col-sm-10 input-group input-group-sm">
										<input class="form-control form-control-sm" id="MT-remark" type="text" placeholder="Ghi chú trả rỗng">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							
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
							<button class="btn btn-warning btn-sm" title="Thông tin thanh toán" data-toggle="modal" data-target="#payment-modal">
								<i class="fa fa-print"></i>
								Thanh toán
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row grid-toggle" style="padding: 10px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive pb-2">
					<h6>Danh sách Container</h6>
					<table id="tbl-conts" class="table table-striped display table-bordered nowrap pb-2" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel hiden-input">Rowguid</th>
							<th class="editor-cancel">STT</th>
							<th class="editor-cancel data-type-checkbox select-checkbox">
								<div class="form-group mb-0">
									<label class="checkbox check-outline-primary">
										<input type="checkbox" id="checkAll" name="">
										<span class="input-span"></span>
										Chọn
									</label>
								</div>
							</th>
							<th>Số container</th>
							<th>Hãng KT</th>
							<th>Kích cỡ</th>
							<th>F/E</th>
							<th>Hướng</th>
							<th>Mã tàu</th>
							<th>Năm</th>
							<th>Chuyến</th>
							<th>Phương thức vào</th>
							<th>Phương thức ra</th>
							<th>Số vận đơn</th>
							<th>Số booking</th>
							<th>Chủ hàng</th>
							<th>Nội/Ngoại</th>
							<th>Trạng thái cont</th>
							<th>Ngày nhập bãi</th>
							<th>Ngày ra bãi</th>
							<th>Bắt đầu lưu bãi</th>
							<th>Kết thúc lưu bãi</th>
							<th>Số ngày lưu bãi</th>
							<th>Số ngày miễn phí</th>
							<th>Số ngày tính phí</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

					<h6 class="mt-2">Thống kê</h6>
					<table id="tbl-statis" class="table table-striped display table-bordered nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>Hãng khai thác</th>
							<th>Hướng</th>
							<th>Kích cỡ</th>
							<th>F/E</th>
							<th>Loại hàng</th>
							<th>Phương thức vào</th>
							<th>Phương thức ra</th>
							<th>Nội/Ngoại</th>
							<th>Số ngày</th>
							<th>Số lượng</th>
							<th>Tổng số ngày</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
					<div class="row">
						<div class="col-3 pt-1" style="border-right: 1px solid #cecece">
							<h6>Thông tin hóa đơn</h6>
							<div class="row form-group">
								<div class="col-md-12 input-group input-group-sm">
									<select id="invType" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Biểu cước">
										<option value="" disabled selected>--[Biểu cước]--</option>
									</select>
									<span data-toggle="tooltip" data-placement="right" data-original-title="Biểu cước" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-list-ul"></i></span>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-12 input-group input-group-sm">
									<input class="form-control form-control-sm" disabled id="invNo" type="text" placeholder="Số phiếu tính cước">
									<span data-toggle="tooltip" data-placement="right" data-original-title="Số phiếu tính cước" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-file-text"></i></span>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-12 input-group">
									<input class="form-control form-control-sm input-required" id="cusID" placeholder="Đối tượng thanh toán" type="text" data-toggle="modal" data-target="#cusID-modal" readonly>
									<span data-toggle="tooltip" data-placement="right" data-original-title="Đối tượng thanh toán" class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn đối tượng thanh toán">
										<i class="la la-search"></i>
									</span>
								</div>
							</div>
							<div class="row form-group">
								<div class="col-sm-12 input-group input-group-sm">
									<input class="form-control form-control-sm" disabled id="invNo" type="text" placeholder="Mã số thuế">
									<span data-toggle="tooltip" data-placement="right" data-original-title="Mã số thuế" class="input-group-addon bg-white btn text-primary" style="padding: 0 .5rem"><i class="la la-credit-card"></i></span>
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
									<select id="cashType" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Loại tiền">
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
							<h6>Thông tin tính cước</h6>
							<table id="tbl-inv" class="table table-striped display table-bordered nowrap" cellspacing="0">
								<thead>
								<tr>
									<th>Số phiếu</th>
									<th>Mã biểu cước</th>
									<th>Diễn giải</th>
									<th>ĐVT</th>
									<th>Hãng KT</th>
									<th>Hướng</th>
									<th>F/E</th>
									<th>Kích cỡ</th>
									<th>Cước bậc thang</th>
									<th>Số ngày lưu bãi</th>
									<th>Đơn giá</th>
									<th>Thành tiền</th>
									<th>Thuế</th>
									<th>Tiền thuế</th>
									<th>Tổng cộng</th>
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

<script type="text/javascript">
	var _eirforMTReturn = '';
	jQuery.expr[':'].regex = function(elem, index, match) {
		var matchParams = match[3].split(','),
			validLabels = /^(data|css):/,
			attr = {
				method: matchParams[0].match(validLabels) ?
					matchParams[0].split(':')[0] : 'attr',
				property: matchParams.shift().replace(validLabels,'')
			},
			regexFlags = 'ig',
			regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
		return regex.test(jQuery(elem)[attr.method](attr.property));
	};
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};

	window.onbeforeunload = PreUnloadJavaScript;
	function PreUnloadJavaScript() {
		var cName = $('#ref-no').val();
		if(cName){
			deleteCookie("eir__"+cName);
		}
		deleteCookie("eir__"+_eirforMTReturn);
	}

	$(document).ready(function () {

		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMethod_CD", "CARGO_TYPE", "ISO_SZTP"
			, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
			, "IX_CD", "CntrJobType", "VAT_CHK"];
		var _result = [], _lstEir = [];
		var selected_cont = [];

		var payers= {};

		$('#search-barge').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		$('#tbl-conts').DataTable({
			info: false,
			paging: false,
			buttons: [],
			searching: false,
			scrollY: '25vh'
		});

		$('#tbl-statis').DataTable({
			info: false,
			paging: false,
			buttons: [],
			searching: false,
			scrollY: '25vh'
		});

		$('#checkAll').on('click', function() {
			if ($('#checkAll').is(':checked')) {
		  		dataTblCont.rows().select();
		  	}
		  	else {
		  		dataTblCont.rows().deselect();
		  	}
		});

		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			buttons: [],
			searching: false,
			scrollY: '38vh'
		});

		$('#bill-detail').DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: false,
			scrollY: '30vh'
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
			noneSelectedText: 'Chọn hướng cắm'
		});

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				// loadpayment();
			}
			if($(this).val() == "inv"){
				$('#tbl-inv').DataTable().columns.adjust();
			}else{
				$('#tbl-conts').DataTable().columns.adjust();
			}
		});

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date, #MT-exp-date').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});
		$('#ref-exp-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function () {
			$('#ref-exp-date').val('');
		});
		$('#invDate').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});

	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>