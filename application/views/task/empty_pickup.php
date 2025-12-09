<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />


<style>
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

	.un-pointer{
		pointer-events: none;
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
		/*background: #2c3e50; /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #2c3e50, #3498db); /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #2c3e50, #3498db);
		color: white;*/

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
 	#terminal-modal .dataTables_filter {
		width: 200px;
	}

	#terminal-modal .dataTables_filter input[type="search"] {
		width: 65%;
	}

	#terminal-modal .dataTables_filter>label::after {
		right: 45px !important;
	}
	#barge-modal .dataTables_filter,
	#payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}

</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box" id="parent-loading">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH CẤP CONTAINER RỖNG</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
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
											<input class="form-control form-control-sm" id="ref-date" type="text" placeholder="Ngày lệnh">
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text"  placeholder="Hạn lệnh">
											<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
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
										<div id="barge-ischecked" class="input-group un-pointer">
											<input class="form-control form-control-sm" id="barge-info" type="text" placeholder="Mã/Năm/Chuyến" readonly>
											<span class="input-group-addon bg-white btn text-warning" id="btn-search-barge" data-toggle="modal" data-target="#barge-modal" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
								
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Tàu/chuyến</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">D/O</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="do" type="text" placeholder="D/O">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label pr-0">Số booking *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="bookingno" type="text" placeholder="Số booking">
											<span class="input-group-addon bg-white btn text-warning hiden-input" title="Tìm booking" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
								<div class="row form-group show-non-cont hiden-input">
									<label class="col-sm-4 col-form-label">OPR/SzType</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input class="form-control form-control-sm" id="opr" type="text" placeholder="OPR" readonly>
											<select id="sizetype" class="selectpicker pl-1" data-style="btn-default btn-sm" data-width="50%">
												<option value="" selected>--</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row form-group hide-non-cont">
									<label class="col-sm-4 col-form-label">Số container</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No.">
											<span class="input-group-addon bg-white btn text-warning" data-toggle="modal" id="cntrno-search" data-target="" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
								<div class="row form-group hiden-input show-non-cont">
									<label class="col-sm-4 col-form-label">Số lượng cont</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="noncont" type="number" placeholder="Số lượng" value="0" min="0" max="999">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="attach-srv-chk-container" class="row form-group hiden-input" style="border-bottom: 1px solid #eee">
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
								<table id="tb-attach-srv" class="table table-striped display nowrap single-row-select" cellspacing="0"
														  style="width: 99.8%">
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
				<div class="row mt-2 pt-2 my-box">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1" title="Xóa những dòng đang chọn">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
							</button>
							<a class="col-form-label text-primary btn btn-outline-primary btn-sm"
									href="<?=site_url(md5('Task') . '/' . md5('tskBooking'));?>"
									style="padding-left: 10px;" target="_blank">
								<span class="btn-icon"><i class="fa fa-plus-circle"></i>Tạo Booking</span>
							</a>
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
					<table id="tbl-cont" class="table table-striped display nowrap" cellspacing="0"  style="min-width: 99.4%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Số cont</th>
							<th>Số booking</th>
							<th>Hướng</th>
							<th>Hãng khai thác</th>
							<th>Kích cỡ nội bộ</th>
							<th>Kích cỡ ISO</th>
							<th>Hàng/Rỗng</th>
							<th>Số chì</th>
							<th>Nội/ngoại</th>
							<th>Trọng lượng</th>
							<th>Loại hàng</th>
							<th col-name="Transist" class="autocomplete">Cảng chuyển</th>
							<th col-name="TERMINAL_CD" class="autocomplete" show-target="#terminal-modal">Cảng Giao Nhận</th>
							<th>Ghi chú</th>
							<th>TLHQ</th>
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
			<div class="row ibox-footer">

			</div>
		</div>
	</div>
</div>
<!--select barge-->
<div class="modal fade" id="barge-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn sà lan</h5>
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
										<option value="2015" >2015</option>
										<option value="2016" >2016</option>
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
										<option value="2021" >2021</option>
										<option value="2022" >2022</option>
										<option value="2023" >2023</option>
										<option value="2024" >2024</option>
										<option value="2025" >2025</option>
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
							<th>Ngày Rời</th>
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
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
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

<!--booking modal-->
<div class="modal fade" id="booking-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 700px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Chi tiết booking</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="booking-detail" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.5%">
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
					<button class="btn btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-booking" data-dismiss="modal">
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
<script type="text/javascript">
	var EirNo_Draft = null
    var modalQrPayment = null
	$(document).ready(function () {
		moment.tz.setDefault('Asia/Ho_Chi_Minh');
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE"
							, "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT"
							, "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],
			_colsAttachServices = ["Select", "CjMode_CD", "CJModeName", "Cont_Count"],
			_colCont = ["STT", "CntrNo", "BookingNo", "CntrClass", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "SealNo", "IsLocal"
							, "CMDWeight", "CARGO_TYPE", "Transist", "TERMINAL_CD", "Note", "cTLHQ"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

        var _bookingList = [],
            _bookingFiltered = [],
            selected_cont = [],
            _lstEir = [];
        var tblCont = $("#tbl-cont"),
            tblInv = $("#tbl-inv"),
            tblAttach = $('#tb-attach-srv'),
 	        _transists = <?= $transists; ?>,
			_terminals = <?= json_encode($terminals); ?>;
            
		var payers= [], _attachServicesChecker = [], _lstAttachService = [];

		<?php if(isset($payers) && count($payers) > 0){ ?>
			payers = <?= json_encode($payers);?>;
		<?php } ?>

		var maxContNum = 0;

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			buttons: [],
			scrollY: '20vh'
		});
		$('#booking-detail').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '20vh'
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
		tblCont.DataTable({
			info: false,
			paging: false,
			searching: false,
			select: true,
			buttons: [],
			scrollY: '30vh',
			columnDefs: [
				{
					className: "show-more",
					targets: _colCont.indexOf("TERMINAL_CD")
				},
				{
					className: "show-dropdown",
					targets: _colCont.indexOf("Transist")
				}
			],
		});

		tblInv.DataTable({
			columnDefs: [
				{ className: 'hiden-input', targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"]) }
			],
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});

		tblAttach.DataTable({
			paging: false,
			columnDefs: [
				{
					  className: 'text-center'
					, orderDataType: 'dom-text'
					, type: 'string'
					, targets: _colsAttachServices.indexOf("Select")
				}
			],
			order: [],
			buttons: [],
			info: false,
			searching: false,
			scrollY: '16vh'
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

		$('#search-barge').DataTable( {
			paging: false,
			infor: false,
			scrollY: '25vh',
			buttons: []
		} );

		autoLoadYearCombo('cb-searh-year');
		load_payer();
 		//------SET MORE BUTTON FOR COLUMNS
        tblCont.moreButton({
            columns: [_colCont.indexOf("TERMINAL_CD")],
            onShow: function(cell) {
                var cellIdx = cell.parent().index();
                $("#apply-terminal").val(cellIdx + "." + _colCont.indexOf("TERMINAL_CD"));
            }
        });
		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});
		
		$('#ref-exp-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function () {
			$('#ref-exp-date').val('');
		});

		$('#barge-modal, #booking-modal, #payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

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

		$('#b-add-payer').on("click", function(){
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function(){
			$('.add-payer-container').removeClass("payer-show");
		});

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			$('#tbl-cont, #tbl-inv').realign();
			if( $('#chk-view-inv').is(':checked') &&  tblInv.DataTable().rows().count() == 0 ){

				_lstEir = [];
				
				if( _bookingFiltered.length > 0 && selected_cont.length > 0 ){
					for (i = 0; i < _bookingFiltered.length; i++) {
						if (selected_cont.indexOf(_bookingFiltered[i].CntrNo) == '-1') continue;
						addCntrToEir(_bookingFiltered[i]);
					}
				}

				loadpayment();
			}
            else {
                	_lstEir = [];
				
				if( _bookingFiltered.length > 0 && selected_cont.length > 0 ){
					for (i = 0; i < _bookingFiltered.length; i++) {
						if (selected_cont.indexOf(_bookingFiltered[i].CntrNo) == '-1') continue;
						addCntrToEir(_bookingFiltered[i]);
					}
				}
            }
		});

		$('input[name="chkSalan"]').on('change', function () {
			$('#barge-ischecked').toggleClass('un-pointer');
			if(!$(this).is(':checked')) {
				$('#barge-info').val('');
				$('#barge-info').trigger('change');
			}
		});

		$(document).on('click','#booking-detail tbody tr td', function () {
			$(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			$(this).parent().toggleClass('m-row-selected');
		});
	//------MBBANK QR GATEWAY
    $('#payment-method-select').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var accType = selectedOption.val();
                if (accType === 'QR_MB') {
					$('#payment-modal').find('.modal-content').blockUI();
                    checkAmountStacking().then((data) => {
                        if(data.status) {
                            data['bookingNew'].forEach(d => {
                                _bookingList.forEach(item => {
                                    if (item.LocalSZPT === d.LocalSZPT) {
                                        item.StackingAmount = parseInt(d.StackingAmount);
                                    }
                                });
                            });
                            $('#payment-modal').find('.modal-content').blockUI();
                            //Check EIR_Draft
                            if(EirNo_Draft) {
                                return handleClickPayQrMb(EirNo_Draft)
                            }
                            saveData([],false);
                            return;
                        }
                        else {
                            toastr['error'](data.message);
                        }
                    }).catch((err) => {
                        console.log(err)
						$('#payment-modal').find('.modal-content').unblock();
                        toastr['error']('Lỗi khi kiểm tra số booking. Vui lòng liên hệ quản trị viên !');
                    })
                } 
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

///////// SEARCH BARGE
		$('#btn-search-barge').on('click', function () {
			search_barge();
		});
		$(document).on('click','#search-barge tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-barge').on('click', function () {
			var r = $('#search-barge tbody').find('tr.m-row-selected').first();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
		});
		$('#search-barge').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#barge-modal').modal("toggle");
		});
///////// END SEARCH BARGE

///////// SEARCH SHIP
		$('#btn-search-ship').on('click', function () {
			search_ship();
		});
		$(document).on('click','#search-ship tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#search-ship-name').on('keypress', function (e) {
			if(e.which == 13) {
				search_ship();
			}
		});
		$('#select-ship').on('click', function () {
			var r = $('#search-ship tbody').find('tr.m-row-selected').first();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
		});
		$('#unselect-ship').on('click', function () {
			$('#shipkey').val('');
			$('#shipid').val('');
			$('#shipyear').val('');
			$('#voy').val('');
			$('#etb').val('');
			$('#etd').val('');
			$('#imvoy').val('');
			$('#exvoy').val('');
		});
		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#ship-modal').modal("toggle");
		});
///////// END SEARCH SHIP

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
				                url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
//------APPLY TERMINAL FROM MODAL
		$("#tbl-terminal").find("tbody tr").on("dblclick", function() {
			var applyBtn = $("#apply-terminal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				terCode = $(this).find("td:eq(1)").text(),
				cell = tblCont.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblCont.DataTable();
            var temp = "<input type='text' value='" + terCode + "' class='hiden-input'>" +
				_terminals.filter(p => p.GNRL_CODE == terCode).map(x => x.GNRL_NM)[0];
			cell.removeClass("error");
            _bookingFiltered[rIdx].TERMINAL_CD = terCode
			dtTbl.cell(cell).data(temp).draw(false);
			$("#terminal-modal").modal("hide");
		});

		$("#apply-terminal").on("click", function() {
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				terCode = $("#tbl-terminal").getSelectedRows().data().toArray()[0][1],
				cell = tblCont.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblCont.DataTable();
            var temp = "<input type='text' value='" + terCode + "' class='hiden-input'>" +
				_terminals.filter(p => p.GNRL_CODE == terCode).map(x => x.GNRL_NM)[0];
			cell.removeClass("error");
            _bookingFiltered[rIdx].TERMINAL_CD = terCode
			dtTbl.cell(cell).data(temp).draw(false);
		});
		//------APPLY TERMINAL FROM MODAL
		$('#ship-modal, #barge-modal, #payer-modal, #terminal-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});
//------USING MANUAL INVOICE

		var _ktype = "";
		$('#bookingno').on('keypress', function (e) {
			if(!$(this).val()) return;
			if(e.which == 13){
				_ktype = "enter";
				$('#cntrno-search').trigger('click');
			}
		});

		var _ktypecntr = "";
		$('#cntrno').on('change keypress', function (e) {
			if((e.which == 13 || e.type == "change") && _ktypecntr == ""){
				load_booking(e);
				_ktypecntr = e.type;
				return;
			}
			_ktypecntr = "";
		});

		$('#cntrno-search').on('click', function (e) {
			var rl = $('#booking-detail').DataTable().rows().to$();
			if(rl.length == 1 && rl[0].length > 0){
				$(this).attr('data-target', '#booking-modal');
			}else{
				load_booking(e);
			}
		});

		$('#apply-booking').on('click', function () {
			$.each( $('#booking-detail').find('tr:visible').find('td.ti-check'), function (k,v) {
				var cntrNo = $(v).parent().find('td:eq(1)').first().text();
				if($.inArray(cntrNo, selected_cont) == "-1"){
					selected_cont.push(cntrNo);
				}
			});
			apply_booking();
		});

		$("#sizetype").on("change", function(){

			var temp = _bookingList.filter( p=>p.LocalSZPT == $("#sizetype").val() )[0];
			if( new Date(temp.ExpDate) < new Date() ){
				$('.toast').remove();
				toastr["info"]("Booking / Kích cỡ ["+ temp.BookingNo + " / " + temp.LocalSZPT +"] đã hết hạn!");
				return;
			}

			var bookAmt = temp.BookAmount ? parseInt( temp.BookAmount ) : 0;
			var stackAmt = temp.StackingAmount ? parseInt( temp.StackingAmount ) : 0;
			if( bookAmt <= stackAmt ){
				$('.toast').remove();
				toastr["info"]("Booking / Kích cỡ ["+ temp.BookingNo + " / " + temp.LocalSZPT +"] đã hết số lượng đặt chỗ!");
				return;
			}


			var countrowBySize = tblCont.DataTable().rows( function ( idx, data, node ) {
												        return data[ _colCont.indexOf("LocalSZPT") ] === $("#sizetype").val();
												    } ).count();
			
			$('#noncont').data("old", countrowBySize);
			$('#noncont').val(countrowBySize);
			
			maxContNum = bookAmt - stackAmt;

		});

		$('#noncont').data("old", 0);
		$('#noncont').on("click", function(){
			if( parseInt( $(this).data("old") ) != parseInt( $(this).val() ) ){
				$(this).trigger("change");
			}
		});
		$('#noncont').on('change', function () {
			
			if( !$("#sizetype").val() ){
				$('#noncont').val(0);
				$('.toast').remove();
				toastr["error"]("Chưa chọn kích cỡ!");
				return;
			}

			var currentContInput = parseInt( $( this ).val() );

			if( currentContInput > maxContNum ){
				$(this).val( $( this ).data("old") );
				$('.toast').remove();
				toastr["error"]("Quá số lượng đặt chỗ!");
				return;
			}

			$(this).data("old", $(this).val());

			//loại những cont cũ theo size type ra, để add cont mới, ví dụ: lúc trước nhập 3 cont, sau đó nhập 2 cont
			// thì xóa 3 cont cũ. add 2 cont mới
			_bookingFiltered = _bookingFiltered.filter( p => p.LocalSZPT !== $("#sizetype").val() );
			
			selected_cont = ['*'];
			var temp = _bookingList.filter( p=>p.LocalSZPT == $("#sizetype").val() )[0];
			temp.CntrNo = "*";
			  if (temp) {
                for (i = 1; i <= parseInt($(this).val()); i++) {
                    _bookingFiltered.push({ ...temp });
                }
            }

			apply_booking();
		});

		$('#noncont').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode >= 35 && e.keyCode <= 40) || e.keyCode >= 112) {
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		//for number ,space, / and :
		$('#ref-exp-date').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [32, 46, 8, 9, 27, 13, 191]) !== -1 ||
				((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 112 && e.keyCode <= 123) || (e.shiftKey && e.keyCode == 59)) {
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});

// ----- FOR ATTACH SERVICES
		load_attach_srv();
		$("#chkServiceAttach").on("change", function(){
			var content = $("#col-transfer")[0];

			$("#col-transfer").remove();

			if( $(this).is(":checked") ){
				$("#row-transfer-left").append( content );
			}else{
				$("#row-transfer-right").append( content );
			}
			
			$("#col-attach-service").toggle(800, function(){
				$($.fn.dataTable.tables(true)).DataTable()
											.columns
											.adjust();
			});

		});
		 //------SET DROPDOWN BUTTON FOR COLUMN
        tblCont.columnDropdownButton({
				data: [
					{
						colIndex: _colCont.indexOf("Transist"),
                        source: _transists.map(p => ({ Id: p.Transit_CD, name: p.Transit_Name }))
					},
				],
				onSelected: function(cell, itemSelected) {
                    _bookingFiltered[cell['context']['_DT_CellIndex'].row].Transist = itemSelected.attr("code");
					var temp = "<input type='text' value='" + itemSelected.attr("code") + "' class='hiden-input'>" + itemSelected.text();

                    console.log(_bookingFiltered)
                    console.log(cell['context']['_DT_CellIndex'].row)
					tblCont.DataTable().cell(cell).data(temp).draw(false);
					tblCont.DataTable().cell(cell.parent().index(), cell.next()).focus();
				}
			});

		//setup before functions
        var typingTimer;
        var doneInterval = 500;

		tblCont.DataTable().on("select deselect", function( e, dt, type, indexes ){
			clearTimeout( typingTimer );
            typingTimer = setTimeout( loadAttachData(indexes) , doneInterval );
		});

		tblAttach.on('change', 'tbody tr td input[type="checkbox"]', function(e){

        	var inp = $(e.target);
        	
        	if( tblCont.DataTable().rows( '.selected' ).data().length == 0 ){

        		$(".toastr").remove();
        		toastr["error"]("Vui lòng chọn một container trước!");

        		if(inp.is(":checked")){
	        		inp.removeAttr("checked");
	        		inp.val("");
	        	}else{
	        		inp.attr("checked", "");
	        		inp.val(1);
	        	}

	        	tblAttach.DataTable().cell( inp.closest("td") ).data( inp.closest("td").html() ).draw(false);

	        	return;
        	}

        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val(1);
        	}else{
        		inp.removeAttr("checked");
        		inp.val("");
        	}

        	if( inp.closest("td").index() == _colsAttachServices.indexOf( "Select" ) ){
        		var currentTD = inp.closest("td");

        		var selectedConts = tblCont.DataTable()
        											.rows( '.selected' )
        											.data().toArray()
        											.map( x => x[ _colCont.indexOf("CntrNo") ] );

        		var currentCjMode = inp.closest("tr").find( "td:eq("+ _colsAttachServices.indexOf("CjMode_CD") +")" ).text();

        		if( _attachServicesChecker.length > 0 )
        		{
        			var contHasThisServices = _attachServicesChecker.filter(p=>selectedConts.indexOf(p.CntrNo) != -1 && p.CJMode_CD == currentCjMode)
        															.map( x=>x.CntrNo );

        			_attachServicesChecker.filter( p => contHasThisServices.indexOf( p.CntrNo ) != -1 && p.CJMode_CD == currentCjMode )
        									.map( x => x.Select = (inp.is(":checked") ? 1 : 0) );

        			var contNonService = selectedConts.filter( p => contHasThisServices.indexOf(p) == -1 );
        			$.each( contNonService, function(idx, iContNo){
        				_attachServicesChecker.push({
	        				Select: inp.is(":checked") ? 1 : 0,
	        				CntrNo: iContNo,
	        				CJMode_CD: currentCjMode
	        			});
        			} );
        		}else{
        			$.each( selectedConts, function(idx, iContNo){
        				_attachServicesChecker.push({
	        				Select: inp.is(":checked") ? 1 : 0,
	        				CntrNo: iContNo,
	        				CJMode_CD: currentCjMode
	        			});
        			} );
        		}

        		//thay đổi số lượng chọn khi check/uncheck
        		var plusOrSubtract = inp.is(":checked") ? 1 : -1;

				var oldNumCell = currentTD.closest("tr").find("td:eq("+ _colsAttachServices.indexOf("Cont_Count") +")");
				var oldNum = tblAttach.DataTable().cell( oldNumCell ).data();
				var newNum = (oldNum ? parseInt(oldNum) : 0) + (selectedConts.length*plusOrSubtract);

				tblAttach.DataTable().cell( oldNumCell ).data( newNum > 0 ? newNum : "" );

        		if( $('#chk-view-inv').is(':checked') ){
        			loadpayment();
        		}else{
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

		$('#remove').on('click', function () {
			if($('#chk-view-inv').is(':checked')) return;
			if( tblCont.DataTable().rows().count() == 0 ){
				return;
			}

			if( tblCont.DataTable().rows('.selected').count() == 0 ){
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
							var removedRows = tblCont.DataTable().rows('.selected').data().toArray();
							var removedCont = removedRows.map(x=>x[_colCont.indexOf("CtnrNo")]);
							selected_cont = selected_cont.filter( p => p == "*" || removedCont.indexOf(p) == "-1" );

							var temp = [];
							$.each( removedRows, function(i, c){
								var x = _bookingFiltered.filter( p => p.CntrNo == c[_colCont.indexOf("CntrNo")]
															&& p.BookingNo == c[_colCont.indexOf("BookingNo")]
															&& p.LocalSZPT == c[_colCont.indexOf("LocalSZPT")] );
								if( x.length > 0 ){
									temp.push( _bookingFiltered.indexOf(x[0]) );
								}
							} );

							$.each(temp, function(){
								_bookingFiltered.splice( this, 1 );
							});

							tblCont.DataTable().rows(".selected").remove().draw(false);
							tblCont.updateSTT();

							$.each($('#booking-detail tbody ').find('tr').find('td:eq(1)'), function (idx, td) {
								if( removedCont.indexOf($(td).text()) != "-1"){
									$(td).parent().removeClass('m-row-selected');
									$(td).parent().find('td:eq(0)').removeClass('ti-check');
								}
							}) ;

							//remove all row to recalculate
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
			$('#payment-modal').find('.modal-content').blockUI();
			checkAmountStacking().then((data) => {
                if(data.status) {
                    data['bookingNew'].forEach(d => {
                        _bookingList.forEach(item => {
                            if (item.LocalSZPT === d.LocalSZPT) {
                                item.StackingAmount = parseInt(d.StackingAmount);
                            }
                        });
                    });
                    if ($("input[name='publish-opt']:checked").val() == "e-inv") {
                        publishInv();
                    } else {
                        saveData();
                    }
                }
                else {
                toastr['error'](data.message);
                }
            }).catch((err) => {
                console.log(err)
                toastr['error']('Lỗi khi kiểm tra số booking. Vui lòng liên hệ quản trị viên !');
            })
		});


		$('#save-credit').on("click", function(){
			saveData();
		});

		var iptimee;
		$('.input-required').on('input', function (e) {
			clearTimeout(iptimee);
			iptimee = window.setTimeout(function () {
				$(e.target).blur();
			}, 2000);
		});

		var typingTimer;

		$(document).on('change', 'input, select', function (e) {
			clearTimeout(typingTimer);
			var cr = e.target;
			if($(cr).val()){
				$(cr).removeClass('error');
				$(cr).parent().removeClass('error');
			}

			if($(cr).attr('id') == 'taxcode'){
				var cusID = $("#cusID").val();
				var pytype = getPayerType( cusID );
				
				$.each( _lstEir, function (k, v) {
					_lstEir[k].CusID = cusID;
					_lstEir[k].PAYER_TYPE = pytype;
				});

				fillPayer();
			}

			if($(cr).attr('id') == "bookingno"){
				$('#cntrno-search').attr('data-target', '');
				if(e.type == 'change' && _ktype == ""){
					$('#cntrno-search').trigger('click');
				}
				//reset list eir
				_lstEir = [];
				if(tblCont.find('tr').length > 1){
					tblCont.dataTable().fnClearTable();
				}
				if(tblInv.find('tr').length > 1){
					tblInv.dataTable().fnClearTable();
				}
				if($('#booking-detail').find('tr').length > 1){
					$('#booking-detail').dataTable().fnClearTable();
				}
				return;
			}

			if( _lstEir.length > 0){
				$.each( _lstEir, function (idx, item) {
					eir_base(item);
				});
			}

			typingTimer = window.setTimeout(function () {
				//reset list eir
				// _lstEir = [];
				if( $('.input-required.error').length == 0
								&& ( $(cr).attr('id') == "taxcode" || $(cr).attr('id') == "cntrclass" || $(cr).attr('id') == 'barge-info' )
								&& ( $(cr).val() || $(cr).attr('id') == 'barge-info' )
								&& $('#chk-view-inv').is(':checked') ){
					loadpayment();
				}

			}, 1000);
		});

		//function
		function search_barge(){
			$("#search-barge").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_barge'
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.barges.length > 0) {
						for (i = 0; i < data.barges.length; i++) {
							rows.push([
								(i+1)
								, data.barges[i].ShipID
								, data.barges[i].ShipName
								, data.barges[i].ShipYear
								, data.barges[i].ShipVoy
							]);
						}
					}
					$('#search-barge').DataTable( {
						paging: false,
						infor: false,
						scrollY: '25vh',
						buttons: [],
						data: rows
					} );
				},
				error: function(err){console.log(err);}
			});
		}

		function load_booking(e){
			// neu tim kim bang so cont
			if( $(e.target).attr('id') == 'cntrno' ){

				$("#cntrno").parent().blockUI();
				//loc so cont trong list _bookinglist
				filtercontainer();
				// neu tim duoc so cont trong bookinglist, apply so cont nay va return
				if(_bookingFiltered.length > 0){
					$("#cntrno").parent().unblock();
					apply_container(true);
					return;
				}
			}else{
				$("#bookingno").parent().blockUI();
			}

			var formdata = {
				'action': 'view',
				'act': 'load_booking',
				'bkno': $('#bookingno').val().trim(),
				'cntrno': $('#cntrno').val().trim()
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					$("#bookingno, #cntrno").parent().unblock();
					
					if(data.bookinglist.error){
						toastr["error"](data.bookinglist.error);
						return;
					}

					_bookingList = data.bookinglist;

					if( $(e.target).attr('id') == 'cntrno-search' ){
						_ktype = "";
						check_booking();
					}

					if($(e.target).attr('id') == 'cntrno'){
						apply_container(false);
					}
				},
				error: function(err){ 
					console.log(err);
					$("#bookingno, #cntrno").parent().unblock();
					toastr["error"]( "Server error at [load_booking]" );
				}
			});
		}
		function check_booking(){
			$('#opr').val('');
			$('#sizetype option:not(:eq(0))').remove();
			$('#sizetype option:selected').prop('selected', false);
			$('#sizetype').selectpicker('refresh');
			$('#cntrno-search').attr('data-target', '');

			//add 05-04-2019
			$("#noncont").val(0);
			var bkNo = $('#bookingno').val(); if(!bkNo) {
				return;
			}

			if( _bookingList.length == 0 ){
				$('.toast').remove();
				toastr['info']('Số booking này không đúng!\nVui lòng kiểm tra lại!');
				return;
			}

			if( _bookingList.filter( p => p.Ter_Hold_CHK != '1' ).length == 0 ){
				$.confirm({
		            title: 'Cảnh báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Tất cả container thuộc booking ['+ bkNo +'] đang được giữ tại Cảng!',
		            buttons: {
		                ok: {
		                    text: 'Ok',
		                    btnClass: 'btn-primary',
		                    keys: ['Enter'],
		                    action: function(){
		                    }
		                }
		            }
		        });
		        return;
			}
			
			//check số lượng booking : các số booking giống nhau, đều hết số lượng đặt chỗ
			if( _bookingList.filter( p=>p.BookAmount - p.StackingAmount == 0 ).length == _bookingList.length ){
				toastr['info']('Booking này đã hết số lượng đặt chỗ!');
				return;
			}

			//check hạn booking, nếu mọi booking giống nhau, nhưng khác size type đều hết hạn
			if( _bookingList.filter( p=> new Date(p.ExpDate) < new Date() ).length == _bookingList.length ){
				toastr['info']('Booking này đã hết hạn!');
				return;
			}
			
			if( _bookingList.filter( p=> p.BOOK_STATUS == 'C' ).length >= 1 ){
				toastr['info']('Booking này đã huỷ!');
				return;
			}
			
			$('#opr').val( _bookingList[0].OprID );
			$('#remark').val( _bookingList[0].Note || "" );
			$('#shipper-name').val( _bookingList[0].ShipName || "" );

			var lcSize = $.unique( _bookingList.map( p=> p.LocalSZPT ) );
			
			$.each(lcSize, function (idx, val) {
				$('#sizetype').append($("<option></option>").attr("value", val).text(val));
			});

			$('#sizetype option:eq(0)').prop('selected', true);
			$('#sizetype').selectpicker('refresh');

			//CHECK NON CONT///
			if(_bookingList.filter(item => item.CntrNo).length > 0){
				_bookingFiltered = _bookingList;
				//if is not non cont -> show input cont /hide input noncont
				$('.show-non-cont').addClass('hiden-input');
				$('.hide-non-cont').removeClass('hiden-input');

				//if not non cont -> show check attach service
				$("#attach-srv-chk-container").removeClass("hiden-input");

				$('#cntrno-search').attr('data-target', '#booking-modal');
				$('#booking-detail').waitingLoad();
				var rows = [];
				$.each( _bookingList, function (idx, item) {
//					if(item.LocalSZPT != $('#sizetype').val()) return;
					
					//CHECK NẾU TỒN TẠI LỆNH ĐÓNG RÚT
					if( item.CJMode_OUT_CD && ["1", "2", "3"].indexOf( item.ischkCFS ) != "-1" ){ return; }

					//CHECK NẾU TỒN TẠI LỆNH NÂNG HẠ
					if( item.EIRNo && item.bXNVC != '1' ){ return; }

					//check nếu container bị giữ tại cảng
					if( item.Ter_Hold_CHK == '1' ){ return; }

					rows.push([
						''
						, item.CntrNo
						, item.OprID
						, item.LocalSZPT
						, item.cTier ? (item.cBlock + "-" + item.cBay + "-" + item.cRow + "-" + item.cTier) : item.cArea
					]);
				});

				var applied_cntr = tblCont.DataTable().columns(1).data().to$()[0];
				$('#booking-detail').DataTable({
					paging: false,
					searching: false,
					infor: false,
					scrollY: '20vh',
					data: rows,
					createdRow: function(row, items, dataIndex){
						if(applied_cntr.length > 0){
							if($.inArray(items[1] , applied_cntr) != "-1"){
								$('td:eq(0)', row).addClass("ti-check");
								$(row).addClass('m-row-selected');
							}
//							if(items[3] != $('#sizetype').val()){
//								$(row).hide();
//							}
						}else{
							$('td:eq(0)', row).addClass("ti-check");
							$(row).addClass('m-row-selected');
//							if(items[3] != $('#sizetype').val()){
//								$(row).hide();
//							}
						}
					}
				});
				$('#booking-modal').modal("show");
			}else{
				// $('#noncont').attr('max', _bookingFiltered[0].BookAmount - _bookingFiltered[0].StackingAmount);
				maxContNum = _bookingList[0].BookAmount - _bookingList[0].StackingAmount;
				//if is non cont -> show input noncont /hide input cont
				$('.show-non-cont').removeClass('hiden-input');
				$('.hide-non-cont').addClass('hiden-input');

				//if is non cont -> hide checkbox attach service
				$("#attach-srv-chk-container").addClass("hiden-input");
				$("#chkServiceAttach").prop("checked", false);
			}
		}

		function filtercontainer(){
			var cntrNo = $('#cntrno').val();
			if( _bookingFiltered.length > 0 ){
				if( _bookingFiltered.filter( item => item.CntrNo == cntrNo ).length == 0){
					var temp = _bookingList.filter(item => item.CntrNo == cntrNo && item.BookingNo == _bookingFiltered[0].BookingNo);
					if(temp.length > 0){
						$.each(temp, function (m,n) {
							_bookingFiltered.push(n);
						});
					}else{
						_bookingFiltered = _bookingList.filter(item => item.CntrNo == cntrNo);
					}
				}
			}else{
				_bookingFiltered = _bookingList.filter(item => item.CntrNo == cntrNo);
			}
		}

		function apply_container(isfiltered){
			$('#bookingno').val('');
			$('#opr').val('');
			$('#sizetype option:not(:eq(0))').remove();
			$('#sizetype option:selected').prop('selected', false);

			var cntrNo = $('#cntrno').val(); if(!cntrNo) return;
			
			if( _bookingList.length == 0 ) {
				$('.toast').remove();
				toastr['warning']('Số container chưa được đăng ký booking!');
				return;
			}

			if(!isfiltered){
				filtercontainer();
			}

			if( _bookingFiltered.length == 0 ){
				$('.toast').remove();
				toastr['warning']('Số container chưa được đăng ký booking!');
				return;
			}

			if( _bookingFiltered.filter( p => p.CntrNo == cntrNo )[0].Ter_Hold_CHK == '1' ){
				$.confirm({
		            title: 'Cảnh báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Container ['+ cntrNo +'] đang bị giữ tại Cảng!',
		            buttons: {
		                ok: {
		                    text: 'Ok',
		                    btnClass: 'btn-primary',
		                    keys: ['Enter'],
		                    action: function(){
		                    	_bookingFiltered = _bookingFiltered.filter( p => p.CntrNo != cntrNo );
		                    }
		                }
		            }
		        });
		        return;
			}

			if(_bookingFiltered[0].BookAmount - _bookingFiltered[0].StackingAmount == 0){
				$('.toast').remove();
				toastr['warning']('Booking này đã hết số lượng đặt chỗ!');
				return;
			}

			var item = _bookingList.filter(item => item.CntrNo == cntrNo)[0];
			if( item.CJMode_OUT_CD && ["1", "2", "3"].indexOf( item.ischkCFS ) != "-1" ){ 
				$('.toast').remove();
				toastr['error']('Container đã được cấp lệnh đóng/rút/sang cont số ['+ item.SSOderNo +']');
				return;
			}

			if( item.EIRNo && item.bXNVC != '1' ){ 
				$('.toast').remove();
				toastr['error']('Container đã được cấp lệnh nâng/hạ số ['+ item.EIRNo +']');
				return;
			}

			$('#sizetype').append($("<option></option>").attr("value", item.LocalSZPT)
															.prop("selected", item.CntrNo == cntrNo)
															.text(item.LocalSZPT));

			$('#bookingno').val(_bookingFiltered[0].BookingNo);
			$('#opr').val(_bookingFiltered[0].OprID);
			$('#sizetype').selectpicker('refresh');

			if($.inArray(cntrNo, selected_cont) == "-1"){
				selected_cont.push(cntrNo);
			}

			apply_booking();
		}

		function apply_booking(){
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

			tblCont.waitingLoad();
			var rows = [];
			if( _bookingFiltered.length > 0 && selected_cont.length > 0){
				var stt = 1;
				//reset list eir
				_lstEir = [];
				for (i = 0; i < _bookingFiltered.length; i++) {
					var item = _bookingFiltered[i];
					if( selected_cont.indexOf(item.CntrNo) == '-1' ) continue;

					//add item cntr_details to _lst;
					if($('.input-required.error').length == 0){
						if(!hasrequired){
							addCntrToEir(item);
						}
					}
					var status = item.Status == "F" ? "Hàng" : "Rỗng";
					var isLocal = item.IsLocal ? (item.IsLocal == "F" ? "Ngoại" : "Nội") : "";
					rows.push([
						(stt++)
						, item.CntrNo ? item.CntrNo : ""
						, item.BookingNo ? item.BookingNo : ""
						, "Empty Storage"
						, item.OprID ? item.OprID : ""
						, item.LocalSZPT ? item.LocalSZPT : ""
						, item.ISO_SZTP ? item.ISO_SZTP : ""
						, status
						, item.SealNo ? item.SealNo : ""
						, isLocal
						, item.CMDWeight ? item.CMDWeight : ""
						, item.CARGO_TYPE ? item.CARGO_TYPE : ""
                        , item.Transist ? item.Transist : ""
                        , item.TERMINAL_CD ? item.TERMINAL_CD : ""
						, item.Note ? item.Note : ""
						, item.cTLHQ ? item.cTLHQ : ""
					]);
				}
			}
			$('#chk-view-cont').trigger('click');

			tblCont.dataTable().fnClearTable();
			if( rows.length > 0 ){
				tblCont.dataTable().fnAddData( rows );
			}

			tblInv.dataTable().fnClearTable();
		}

		function eir_base( item )
		{
			item['IssueDate'] =  $('#ref-date').val(); //*
			item['ExpDate'] =  $('#ref-exp-date').val(); //*
			item['NameDD'] =  $('#personal-name').val();

			item['IsTruckBarge'] =  $('input[name="chkSalan"]').is(':checked') ? "B" : "T";
			item['BARGE_CODE'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[0] : "";
			item['BARGE_YEAR'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[1] : "";
			item['BARGE_CALL_SEQ'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[2] : "";

			item['DMETHOD_CD'] = $('input[name="chkSalan"]').is(':checked') ?  "BAI-SALAN" : "BAI-XE";
			item['TruckNo'] = '';

			item['PersonalID'] =  $('#cmnd').val();
			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*

			if( $('#mail').val() ){
				item['Mail'] = $('#mail').val();
			}

			if( $("#transist").val() ){
				item["Transist"] = $("#transist").val();
			}

			item['PAYER_TYPE'] = getPayerType( $('#cusID').val() );
			item['CusID'] = $('#cusID').val(); //*

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['DELIVERYORDER'] = $("#do").val(); //*
			item['CJMode_CD'] = 'CAPR'; //*
			item['CJModeName'] = 'Cấp rỗng'; //*
			item['Status'] = 'E'; //*

			if(!item['ShipKey']){
				item['ShipKey'] = 'STORE';
				item['ShipID'] = 'STORAGE';
				item['ShipYear'] = '0000';
				item['ShipVoy'] = '0000';
			}

			if(!item['CARGO_TYPE']) {
				item['CARGO_TYPE'] = item["ISO_SZTP"].charAt(2) == "R" ? "ER" : "MT";
			}

			if(!item['CntrClass']) {
				item['CntrClass'] = "2";
			}

			if(!item['IsLocal']) {
				item['IsLocal'] = "*";
			}

			if(item.EIR_SEQ == 0){
				item['EIR_SEQ'] = 1;
			}
		}

		function addCntrToEir(inputItem){

			var item = $.extend( {}, inputItem );
			
			eir_base( item );

			deleteItemInArray( item, ["ContCondition", "isAssignCntr", "EIRNo", "RowguidCntrDetails", "ischkCFS", "CJMode_OUT_CD", "SSOderNo"
										, "DateOut", "BookingDate", "BookAmount", "StackingAmount", "bXNVC"] );

			_lstEir.push(item);
		}

		function getPayerType(id){
			if(payers.length == 0 ) return "";
			var py =payers.filter(p=> p.CusID == id );
			if(py.length == 0) return "";
			if(py[0].IsOpr == "1") return "SHP";
			if(py[0].IsAgency == "1") return "SHA";
			if(py[0].IsOwner == "1") return "CNS";
			if(py[0].IsLogis == "1") return "FWD";
			if(py[0].IsTrans == "1") return "TRK";
			if(py[0].IsOther == "1") return "DIF";
			return "";
		}
		function loadpayment(){
			if(_lstEir.length == 0) {
				tblInv.dataTable().fnClearTable();
				return;
			}
			if($('.input-required.error').length > 0) {
				tblInv.dataTable().fnClearTable();
				return;
			}
			if($('.input-required').has_required()){
				tblInv.dataTable().fnClearTable();
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#taxcode').val(),
				'list': JSON.stringify(_lstEir)
			};

			if( $("#chkServiceAttach").is(":checked") ){
				addCntrToAttachSRV();

				var nonAttach = _lstAttachService.filter( p=>p.CJMode_CD != "SDD" && p.CJMode_CD != "LBC" );
				var sdd = _lstAttachService.filter( p=>p.CJMode_CD == "SDD" )[0];
				var lbc = _lstAttachService.filter( p=>p.CJMode_CD == "LBC" );

				if( nonAttach && nonAttach.length > 0 ){
					formdata['nonAttach'] = JSON.stringify(nonAttach);
				}

				if( sdd && sdd.length > 0 ){
					formdata['sdd'] = JSON.stringify(sdd);
				}

				if( lbc && lbc.length > 0 ){
					formdata['lbc'] = JSON.stringify(lbc);
				}
			}

			tblInv.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					 EirNo_Draft = null //reset EirDraft
					if( data.no_payer ){
						$(".toast").remove();
						toastr["error"](data.no_payer);

						tblInv.dataTable().fnClearTable();
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

					if(data.error && data.error.length > 0){
						$(".toast").remove();
						$.each(data.error, function(idx, err){
							toastr["error"](err);
						});

						tblInv.dataTable().fnClearTable();
						return;
					}

					var rows = [];

					if(data.results && data.results.length > 0){
						var lst = data.results, stt = 1;
						for (i = 0; i < lst.length; i++) {
							var cntrclass = lst[i].CntrClass == 1 ? "Nhập" : (lst[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
							var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
							var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ? "Nội" : "");
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
				},
				error: function(err){
					$(".toast").remove();
					toastr["error"]("ERROR!");

					tblInv.dataTable().fnClearTable();
					console.log(err);
				}
			});
		}

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
				$('#p-taxcode').text( $('#taxcode').val() );
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
					$("#t-mb").prop("disabled",true)
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
								toastr["success"]("Tiến hành xuất hóa đơn !");
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
		//SAVE DATA
		function saveData(invInfo, draft = true){
			var drDetail = getInvDraftDetail();
			var drTotal = {};
			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});

			var countBySize = {};
			tblCont.DataTable().rows( function ( idx, data, node ) {
		        return countBySize[ data[ _colCont.indexOf("LocalSZPT") ] ] = countBySize[ data[ _colCont.indexOf("LocalSZPT") ] ] 
        																	? countBySize[ data[ _colCont.indexOf("LocalSZPT") ] ] + 1
        																	: 1;
		    } );

		    $.each( Object.keys( countBySize ), function(idx, sz){
		    	countBySize[ sz ] += parseInt( _bookingList.filter( p=> p.LocalSZPT ==  sz ).map( x => x.StackingAmount )[0] );
		    });

			_lstEir.map( x => x.Note = $('#remark').val() );
			_lstEir.map( x => x.SHIPPER_NAME = $('#shipper-name').val() );
			_lstEir.map( x => x.PersonalID = $('#cmnd').val() );
			_lstEir.map( x => x.NameDD = $('#personal-name').val() );
			_lstEir.map( x => x.Mail = $('#mail').val() );
		    var publish_opt_checked = $("input[name='publish-opt']:checked").val();

			if(!draft) {
                _lstEir.map(x => x.publishType = publish_opt_checked ? publish_opt_checked : "e-inv");
                _lstEir.map(x => x.Type_Eir = 'Lệnh Giao Cont Rỗng');
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
					'stackingAmount': countBySize,
					'eir': _lstEir,
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

			//get attach service for save
			if( _lstAttachService.length > 0 ){
				formData['data']['odr'] = _lstAttachService; //JSON.stringify();
			}
			//get attach service for save

			if (typeof invInfo !== "undefined" && invInfo !== null)
			{
				formData.data["invInfo"] = invInfo;
			}else{
				//trg hop không phải xuất hóa đơn điện tử, block popup ở đây
				$('#payment-modal').find('.modal-content').blockUI();
			}
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
					toastr['error'](error);
				}
			});
		}
		function handlePaymentSuccess(invInfo, EirNo) {
				// Validate payment method selectio
                    var drDetail = getInvDraftDetail();
                    var drTotal = {};
                    $.each($('#INV_DRAFT_TOTAL').find('span'), function(idx, item) {
                        drTotal[$(item).attr('id')] = $(item).text();
                    });

                    var countBySize = {};
                    tblCont.DataTable().rows(function(idx, data, node) {
                        return countBySize[data[_colCont.indexOf("LocalSZPT")]] = countBySize[data[_colCont.indexOf(
                                "LocalSZPT")]] ?
                            countBySize[data[_colCont.indexOf("LocalSZPT")]] + 1 :
                            1;
                    });

                    $.each(Object.keys(countBySize), function(idx, sz) {
                        countBySize[sz] += parseInt(_bookingList.filter(p => p.LocalSZPT == sz).map(x => x
                            .StackingAmount)[0]);
                    });
                    var publish_opt_checked = $("input[name='publish-opt']:checked").val();
                    var formData = {
                        'data': {
                            'pubType': publish_opt_checked ? publish_opt_checked : "credit",
                            'stackingAmount': countBySize,
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
	 function checkAmountStacking() {
            return new Promise((resolve, reject) => {
                var countBySize = {};
                tblCont.DataTable().rows(function(idx, data, node) {
                    return countBySize[data[_colCont.indexOf("LocalSZPT")]] = countBySize[data[_colCont.indexOf(
                            "LocalSZPT")]] ?
                        countBySize[data[_colCont.indexOf("LocalSZPT")]] + 1 :
                        1;
                });
                $.each(Object.keys(countBySize), function(idx, sz) {
                    countBySize[sz] += parseInt(_bookingList.filter(p => p.LocalSZPT == sz).map(x => x
                        .StackingAmount)[0]);
                });
                _lstEir.map(x => x.Note = $('#remark').val());
                _lstEir.map(x => x.SHIPPER_NAME = $('#shipper-name').val());
                _lstEir.map(x => x.PersonalID = $('#cmnd').val());
                _lstEir.map(x => x.NameDD = $('#personal-name').val());
                _lstEir.map(x => x.Mail = $('#mail').val());
                var formData = {
                'action': 'view',
                'act': 'checkAmount',
                'data': {
                    'stackingAmount': countBySize,
                    'eir': _lstEir,
                	},
           	 	};
             $.ajax({
                    url: "<?= site_url(md5('Task') . '/' . md5('tskEmptyPickup')); ?>",
                    dataType: 'json',
                    data: formData,
                    type: 'POST',
                    success: function(data) {
                        resolve(data)
                    },
                    error: function(xhr, status, error) {
                       reject(error)
                    }
                });
            })
        }
		function getInvDraftDetail(){
			var rows = [];
			tblInv.find('tbody tr:not(.row-total)').each(function() {
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
				temp['Remark'] = selected_cont.toString();
				drd.push(temp);
			});
			return drd;
		}

		function addCntrToAttachSRV(){
			_lstAttachService = [];
			var attachSrvSelected = _attachServicesChecker.filter( p=>p.Select == 1 );

			if( attachSrvSelected.length > 0 ){
				$.each( attachSrvSelected, function(index, elem){
					var finds = _lstEir.filter( p => p.CntrNo == elem["CntrNo"] )[0];

					var item = $.extend( {}, finds );

					item['CJMode_CD'] =  elem["CJMode_CD"];
					
					item['PTI_Hour'] = 0;
					
					item['cBlock1'] = item['cBlock'];
					item['cBay1'] = item['cBay'];
					item['cRow1'] = item['cRow'];
					item['cTier1'] = item['cTier'];

					deleteItemInArray( item, ["cBlock", "cBay", "cRow", "cTier", "CJModeName", "CLASS", "ContCondition", "isAssignCntr", "EIRNo"
												, "DateOut", "UNNO", "TERMINAL_CD", "IsTruckBarge", "TruckNo", "BookingDate", "BookAmount", "StackingAmount"] );

					_lstAttachService.push( item );
				});
			}
		}

		function deleteItemInArray( item, arrColName ){
			$.each(arrColName, function(idx, colname){
				delete item[colname];
			}); 
		}

		function load_attach_srv(){
			$('#col-attach-service').blockUI();
			tblAttach.waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_attach_srv',
				'order_type': 'CAPR'
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					$('#col-attach-service').unblock();

					var rows = [];
					if(data.lists && data.lists.length > 0) {
						for (i = 0; i < data.lists.length; i++) {
							var r = [];
							
							$.each( _colsAttachServices, function(indx, colname){
								if(colname == "Select"){
									var xxx = '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>';
									r.push(xxx);
								}else if( colname == "Checker" ){
									r.push(0);
								}
								else{
									r.push(data.lists[i][colname] ? data.lists[i][colname] : "");
								}
							});
							rows.push(r);
						}
					}

					tblAttach.dataTable().fnClearTable();
					if( rows.length > 0 ){
						tblAttach.dataTable().fnAddData( rows );
					}
					
				},
				error: function(err){
					$('#col-attach-service').unblock();
					tblAttach.dataTable().fnClearTable();
					console.log(err);
				}
			});
		}

		function loadAttachData(rowIndexes){

        	var cellCheked = tblAttach.find("tbody tr")
					        			.find( 'input[type="checkbox"]:checked' ).closest("td");

			$.each( cellCheked, function(idx, cell){
				tblAttach.DataTable().cell( cell ).data( '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>' );
			} );

	        tblAttach.DataTable().draw( false );

	        if( !rowIndexes || rowIndexes.length == 0 ){
	        	return;
	        }

			var allCntrNoSelected = tblCont.DataTable().rows(rowIndexes).data().toArray().map(p=>p[_colCont.indexOf("CntrNo")]);

	        if( _attachServicesChecker.length > 0 ){
	        	// var indexCells = [];
	        	$.each( tblAttach.find("tbody tr"), function(){
		        	var cjmode = $(this).find("td:eq(" + _colsAttachServices.indexOf("CjMode_CD") + ")").text();

		        	var itemChecked = _attachServicesChecker.filter( p=> allCntrNoSelected.indexOf(p.CntrNo) != -1 && p.CJMode_CD == cjmode );
		        	if( itemChecked && itemChecked.length == allCntrNoSelected.length ){
		        		var cellSelect = $(this).find( 'td:eq('+ _colsAttachServices.indexOf("Select") +')' );

		        		cellSelect.find( 'input[type="checkbox"]' )
			        				.val( itemChecked[0].Select )
			        				.prop('checked', itemChecked[0].Select == 1 ? true : false );
		        	}
		        } );
	        }
        }

	});
	function search_ship(){
		$("#search-ship").waitingLoad();
		var formdata = {
			'action': 'view',
			'act': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-searh-year').val(),
			'shipname': $('#search-ship-name').val()
		};
		$.ajax({
			url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				var rows = [];
				if(data.vsls.length > 0) {
					for (i = 0; i < data.vsls.length; i++) {
						rows.push([
							data.vsls[i].ShipID
							, (i+1)
							, data.vsls[i].ShipName
							, data.vsls[i].ImVoy
							, data.vsls[i].ExVoy
							, getDateTime(data.vsls[i].ETB)
							, getDateTime(data.vsls[i].ETD)
						]);
					}
					$('#search-ship').DataTable( {
						scrollY: '35vh',
						paging: false,
						order: [[ 1, 'asc' ]],
						columnDefs: [
							{ className: "input-hidden", targets: [0] },
							{ className: "text-center", targets: [0] }
						],
						info: false,
						searching: false,
						data: rows
					} );
				}
			},
			error: function(err){console.log(err);}
		});
	}

	function save_new_payer( formData ){
		$(".add-payer-container").blockUI();
		$.ajax({
			url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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

</script>

<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>