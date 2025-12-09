<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/vendors/dataTables/extensions/buttons.dataTables.min.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100%!important;
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
	    width: 90%!important;
	    margin: auto;
	}

	.vertical-alignment-helper {
	    display:table;
	}

	.modal-content {
	    /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
	    width:inherit;
	    height:inherit;
	    /* To center horizontally */
	    margin: 0 auto;
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

	#INV_DRAFT_TOTAL span.col-form-label{
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">TẬP HỢP NÂNG HẠ CONTAINER</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-5 pl-0">
						<div class="my-box p-3">
							<h6 class="pb-1">Tiêu chí lọc</h6>
							<div class="row">
								<div class="col-7">
									<div class="input-group">
										<input class="form-control form-control-sm input-required mr-2" id="fromDate" type="text"
												placeholder="Ngày bắt đầu" readonly>
										<input class="form-control form-control-sm input-required" id="toDate" type="text" placeholder="Ngày kết thúc" readonly>
									</div>
								</div>
								<div class="col-5">
									<div class="row form-group">
										<div class="col-md-12 input-group input-group-sm">
											<select id="dMethod" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
												<option value="" >-- [Phương thức] --</option>
												<?php if(isset($dmethods) && count($dmethods) > 0){ foreach ($dmethods as $item){ ?>
													<option value="<?= $item['DMethod_CD'] ?>"><?= $item['DMethod_Name'] ?></option>
												<?php }} ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="row form-group">
										<div class="col-sm-12 input-group">
											<input class="form-control form-control-sm" id="search-taxcode" placeholder="Đang nạp..." type="text" readonly>
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
												<i class="ti-search"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-5">
									<div class="row form-group">
										<div class="col-md-12 input-group input-group-sm">
											<select id="transit" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
												<option value="" >-- [Chuyển cảng] --</option>
												<?php if(isset($transits) && count($transits) > 0){ foreach ($transits as $item){ ?>
													<option value="<?= $item['Transit_CD'] ?>"><?= $item['Transit_Name'] ?></option>
												<?php }} ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="row form-group">
										<div class="col-sm-12 input-group">
											<input class="form-control form-control-sm" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
												<i class="ti-search"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-5">
									<div class="row form-group">
										<div class="col-md-12 input-group input-group-sm">
											<select id="FE" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
												<option value="" >-- [Hàng/Rỗng] --</option>
												<option value="F">Hàng</option>
												<option value="E">Rỗng</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="row form-group">
										<div class="col-12 input-group-sm input-group">
											<select id="oprID" class="selectpicker form-control" title="" data-live-search="true">
		                                		<option value="" >-- [Hãng khai thác] --</option>
		                                    </select>
										</div>
									</div>
								</div>
								<div class="col-5">
									<div class="row form-group">
										<div class="col-md-12 input-group input-group-sm">
											<select id="isLocal" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
												<option value="" >-- [Nội/Ngoại] --</option>
												<option value="L">Nội</option>
												<option value="F">Ngoại</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-7">
									<div class="row form-group">
										<div class="col-12 input-group-sm input-group">
											<select id="cjMode" class="selectpicker form-control" multiple="" title="-- [Phương án] --">
		                                        <option value="LAYN">Lấy nguyên</option>
		                                        <option value="CAPR">Cấp rỗng</option>
		                                        <option value="HBAI">Hạ bãi</option>
		                                        <option value="TRAR">Trả rỗng</option>
		                                    </select>
										</div>
									</div>
								</div>
								<div class="col-5">
									<div class="row form-group">
										<div class="col-md-12 input-group input-group-sm">
											<select id="cntrClass" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
												<option value="" >-- [Hướng nhập/Xuất] --</option>
												<option value="1">Nhập</option>
												<option value="3">Xuất</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="row">
								<div class="col-7">
									<div class="row form-group">
										<div class="col-12 input-group-sm input-group">
											<select class="selectpicker form-control"  id="jobType" multiple>
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
							</div> -->
						</div>

					</div>
					<div class="col-7 my-box table-responsive p-3">
						<table id="tableStatis" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th style="max-width: 70px">Hãng</th>
								<th style="max-width: 40px">Hướng</th>
								<th>Công việc</th>
								<th>20F</th>
								<th>40F</th>
								<th>45F</th>
								<th>20E</th>
								<th>40E</th>
								<th>45E</th>
							</tr>
							</thead>

							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row my-box mt-2 py-2 pl-3">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
					<button id="show-payment-modal" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#payment-modal">
						<span class="btn-icon"><i class="la la-calculator"></i>Tính cước</span>
					</button>
				</div>
			</div>
			<div class="row ibox-footer border-top-0" style="padding: 10px 12px">
				<div class="col-12 table-responsive">
					<table id="tableCont" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th class="editor-cancel hiden-input">Rowguid</th>
								<th class="editor-cancel">STT</th>
								<th class="editor-cancel data-type-checkbox select-checkbox">
									<div class="form-group mb-0">
										<label class="checkbox check-outline-primary">
											<input type="checkbox" name="check-bill-all" style="display: none;">
											<span class="input-span"></span>
										</label>
									</div>
								</th>
								<th>Số Lệnh</th>
								<th>Số Container</th>
								<th>Hãng KT</th>
								<th>Kích cỡ ISO</th>
								<th>Hướng</th>
								<th>Hàng/Rỗng</th>
								<th>Loại hàng</th>
								<th>CV Cổng</th>
								<th>Phương án</th>
								<th>Phương thức</th>
								<th>Nội/Ngoại</th>
								<th>ĐT Thanh Toán</th>
								<th>Chuyển Cảng</th>
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
										<option value="2017" >2017</option>
										<option value="2018" >2018</option>
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

<!--payment modal-->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-dialog-mw-py" role="document">
			<div class="modal-content">
				<button type="button" class="close text-right pt-2 pr-2" data-dismiss="modal">&times;</button>
				<div class="modal-body p-3">
					<div class="row">
						<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pb-1">
								<h5 class="text-primary" style="border-bottom: 1px solid #eee">Thông tin thanh toán</h5>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 col-form-label" title="Đối tượng thanh toán">Mã KH/ MST</label>
								<div class="col-sm-5 input-group">
									<input class="form-control form-control-sm input-required" id="taxcode" placeholder="Đang nạp ..." type="text" readonly="">
									<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
											title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
										<i class="ti-search"></i>
									</span>
								</div>
								<input class="hiden-input" id="cusID" readonly>
								<label class="col-sm-4 col-form-label hiden-input" id="p-money-credit">
									<i class="fa fa-check-square"></i> <span>THU NGAY</span>
								</label>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 col-form-label">Tên</label>
								<div class="col-sm-9">
									<span class="col-form-label" id="p-payername">&nbsp;</span>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-3 col-form-label">Địa chỉ</label>
								<div class="col-sm-9">
									<span class="col-form-label" id="p-payer-addr">&nbsp;</span>
								</div>
							</div>

							<div class="row form-group">
								<label class="col-sm-3 col-form-label" title="Đối tượng thanh toán">Mẫu cước</label>
								<div class="col-sm-5">
									<select id="inv-temp" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
										<option value="" selected="">-- Chọn Mẫu cước --</option>
										<?php if(isset($invTemps) && count($invTemps) > 0){ foreach ($invTemps as $item){ ?>
											<option value="<?= $item['TPLT_NM'] ?>"><?= $item['TPLT_NM']." : ".$item['TPLT_DESC'] ?></option>
										<?php }} ?>
									</select>
								</div>
								<div class="col-sm-4">
									<button id="apply-inv-temp" class="btn btn-outline-warning btn-sm btn-block">
										<span class="btn-icon"><i class="fa fa-arrow-down"></i></i>Áp dụng</span>
									</button>
								</div>
							</div>
						</div>

						<div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12" id="INV_DRAFT_TOTAL">
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
						<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pb-1">
								<h5 class="text-primary" style="border-bottom: 1px solid #eee">Hình thức thanh toán</h5>
							</div>
							<div class="form-group">
								<div class="btn-group" data-toggle="buttons" style="width: 100%; display: inline-flex;">
		                            <label class="btn btn-outline-primary" style="flex:1"><i class="ti-check active-visible"></i> Phiếu thu
		                                <input name="publish-opt" type="radio" value="dft" >
		                            </label>
		                            <label class="btn btn-outline-primary" style="flex:1"><i class="ti-check active-visible"></i> Hóa đơn giấy
		                                <input name="publish-opt" value="m-inv" type="radio">
		                            </label>
		                            <label class="btn btn-outline-primary active" style="flex:1"><i class="ti-check active-visible"></i> Hóa đơn điện tử
		                                <input name="publish-opt" value="e-inv" type="radio" checked>
		                            </label>
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
							<div class="row form-group mt-3" id="inv-type-container">
								<div class="col-sm-12 input-group">
									<label class="col-form-label" title="Loại hóa đơn">Loại HĐ</label>
									<select id="inv-type" class="col-sm-5 selectpicker" data-style="btn-default btn-sm" data-width="100%">
										<option value="VND" selected=""> Hóa đơn VND </option>
										<option value="USD"> Hóa đơn USD </option>
									</select>
									<label class="col-sm-2 col-form-label" title="Tỉ giá">Tỉ giá</label>
									<input id="ExchangeRate" class="form-control form-control-sm text-right" value="1" placeholder="Tỉ giá" type="text">
								</div>
							</div>
							<div class="row form-group mt-4">
								<div id="dv-cash" style="margin: 0 auto">
									<button class="btn btn-rounded btn-gradient-lime" id="pay-confirm">
										<span class="btn-icon"><i class="fa fa-id-card"></i> Xác nhận thanh toán</span>
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
				<div class="modal-footer p-0">
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden" style="padding: 0 5px">
						<table id="tbl-inv" class="table table-striped display" cellspacing="0" style="min-width: 99.5%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Mã BC</th>
								<th>Tên biểu cước</th>
								<th>ĐVT</th>
								<th>Loại CV</th>
								<th>PTGN</th>
								<th>Loại hàng</th>
								<th>KC ISO</th>
								<th>FE</th>
								<th>Nội/ Ngoại</th>
								<th>Số Lượng</th>
								<th>Đơn giá</th>
								<th>CK (%)</th>
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
	$(document).ready(function () {
		var _colCont = ["rowguid", "STT", "BILL_CHK", "EIRNo", "CntrNo", "OprID", "ISO_SZTP", "CLASS_Name", "Status", "Description", "JobName"
						, "CJMode_CD", "DMethod_CD", "IsLocal", "CusID", "Transit_Name"],
			_colStatis = ["OprID", "CLASS_Name", "JobName", "20E", "40E", "45E", "20F", "40F", "45F"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_colsPayment = ["STT", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE"
							, "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT"
							, "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"];

		var _results = [], _selectShipKey = '', tblInv = $("#tbl-inv"), _listCalc = [], selected_cont = [];

//------define table
		//define table cont
		var tblCont = $('#tableCont');
		var dataTblCont = tblCont.newDataTable({
			scrollY: '30vh',
			order: [[ _colCont.indexOf('STT'), 'asc' ]],
			paging: false,
            columnDefs: [
				{ 
					className: "hiden-input", targets: _colCont.indexOf( "rowguid" )
				},
				{ 
					className: "text-center", targets: _colCont.getIndexs(["STT", "BILL_CHK"])
				},
			],
			buttons: [
				{
					extend:    'excel',
					text:      '<i class="fa fa-files-o"></i> Xuất Excel',
					titleAttr: 'Xuất Excel',
					exportOptions: {
						columns: 'th:not(:eq('+ _colCont.indexOf("rowguid") +'))'
					}
				}
			],
            select: true,
            rowReorder: false,
            createdRow: function(row, data, dataIndex){
    			if( $( data[ _colCont.indexOf("BILL_CHK") ] ).find('input[name="check-bill"]').is(":disabled") ){
    				$( row ).addClass("row-disabled");
    			}
			}
		});

		//define table statis
		var tblStatis = $('#tableStatis');
		tblStatis.DataTable({
			scrollY: '21vh',
			columnDefs: [
				{
					className: "text-center", targets: _colStatis.getIndexs(["OprID", "CLASS_Name"])
				},
				{
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 0),
					targets: _colStatis.getIndexs(["20E" ,"40E", "45E", "20F", "40F", "45F"])
				}
			],
			order: [[ _colStatis.indexOf('OprID'), 'asc' ]],
			paging: false,
            info: false,
            searching: false,
            buttons: [],
            select: true,
            dom: '<"statisTool">frtip',
		});
		$('div.statisTool').html('<h6>Thống kê</h6>');

		$('#search-ship').DataTable( {
			scrollY: '35vh',
			paging: false,
			order: [[ 1, 'asc' ]],
			columnDefs: [
				{ className: "input-hidden", targets: [0, 6, 7] },
				{ className: "text-center", targets: [1] }
			],
			buttons: [],
			info: false,
			searching: false
		} );

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

		tblInv.DataTable({
			columnDefs: [
				{ className: "hiden-input", targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"]) }
			],
			info: false,
			paging: false,
			searching: false,
			ordering: false,
			buttons: [],
			scrollY: '15vh'
		});

//------define table

//------define selectpicker
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
//------define selectpicker

//set from date, to date
		var fromDate = $('#fromDate');
		var toDate = $('#toDate');

		$.timepicker.dateRange(
			fromDate,
			toDate,
			{
				dateFormat: 'dd/mm/yy',
				start: {}, // start picker options
				end: {} // end picker options					
			}
		);

		fromDate.val(moment().subtract(7, 'day').format('DD/MM/YYYY'));
		toDate.val(moment().format('DD/MM/YYYY'));
//end set fromdate, todate

//------SEARCH SHIP
		autoLoadYearCombo('cb-searh-year');
		search_ship();
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
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
		});
		$('#unselect-ship').on('click', function () {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

			$('#ship-modal').modal("toggle");
		});

		$('#reload-ship').on("click", function(){
			$('#search-ship-name').val("");
			search_ship();
		})

		$("#remove-ship-selected").on("click", function(){
			_selectShipKey = "";
			$("#shipid").val("");
		});
//------END SEARCH SHIP

		load_opr();
		load_payer();

//------SEARCH PAYER

		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first(),
				relatedId = $('#payer-modal').attr("data-whatever");

			if( relatedId == "taxcode" ){
				$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
				$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());
				// fillPayer();
				$('#taxcode').trigger("change");
			}else{
				$('#search-taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());
			}
		});

		$('#search-payer').on('dblclick','tbody tr td', function(e) {
			var r = $(this).parent(), relatedId = $('#payer-modal').attr("data-whatever");

			if( relatedId == "taxcode" ){
				$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
				$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());
				fillPayer();
			}else{
				$('#search-taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());
			}
			
			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
//------END SEARCH PAYER
		
///////// ON PAYMENT MODAL
		$('#ExchangeRate')
		.on('keydown', function (e) {
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
		.on("change", function(e){
			var tempExc = $(e.target).val();
			if( isNaN( parseFloat( tempExc ) ) ){
				$(e.target).val(1);
			}else{
				var n = $.formatNumber( tempExc, { format: "#,###.##", locale: "us" });
				if( n.substring(0, 1) == '.' ){
					n = "0" + n;
				}
				$(e.target).val( n );
			}
		});

		$("input[name='publish-opt']").on("change", function(e){
			if( $(e.target).val() == 'dft' )
			{
				$("#inv-type-container").addClass("hiden-input");
			}else
			{
				$("#inv-type-container").removeClass("hiden-input");
			}
		});

///////// ON PAYMEMT MODAL

//------USING MANUAL INVOICE

		$("input[name='publish-opt']").on("change", function(e){
			if( $(e.target).val() == "m-inv" ){
				$("#m-inv-container").removeClass("hiden-input");
				$("#pay-confirm").prop("disabled", <?= $isDup || !isset( $ssInvInfo ) || count( $ssInvInfo ) == 0; ?>);
			}else{
				$("#m-inv-container").addClass("hiden-input");
				$("#pay-confirm").prop("disabled", false);
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
				                url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
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

				                    $("#pay-confirm").prop("disabled", false);
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

//------EVENTS
		$('#ship-modal, #payer-modal, #payment-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable()
											.columns
											.adjust();
			//search-taxcode
			$(e.currentTarget).attr("data-whatever", $(e.relatedTarget).prev().attr("id"));
		});

		$(document).on("change", "th input[type='checkbox'][name='check-bill-all']", function(e) {
			var isChecked = $( e.target ).is(":checked");

			var tempChange = '<label class="checkbox checkbox-outline-ebony">'
								+ '<input type="checkbox" name="check-bill" value="'
											+ ( isChecked ? "1" : 0 ) +'" style="display: none;" '+ ( isChecked ? "checked" : "" ) +'>'
								+ '<span class="input-span"></span>';
							+ '</label>';

			var rowEditing = [];
			tblCont.DataTable().cells( ':not(.row-disabled)', _colCont.indexOf("BILL_CHK") )
								.every( function(){
									this.data(tempChange);
									rowEditing.push( this.index().row );
								} );

			if( isChecked ){
				tblCont.DataTable().rows( rowEditing ).nodes().to$().addClass("editing");
			}else{
				tblCont.DataTable().rows( rowEditing ).nodes().to$().removeClass("editing");
			}
		});

		tblCont.on('change', 'tbody tr td input[name="check-bill"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tblCont.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	eTable.row(crRow).nodes().to$().toggleClass("editing");
        });

        $("#search").on("click", function(){
			$( this ).button("loading");
			search_cont_total();
		});

		$("#apply-inv-temp").on("click", function(){
        	var changeData = tblCont.getEditedRows().map(function(item){
								 return {"rowguid": item[0], "BILL_CHK": item[2]};
							 });

        	var changeRowguid = changeData.filter( p=>p.BILL_CHK == 1 ).map( x => x.rowguid );

        	var n = _results.filter( p => changeRowguid.indexOf( p.rowguid ) != -1 );

        	selected_cont = n.map( x => x.CntrNo );
        	_listCalc = [];
        	$.each( n, function(idx, item){
        		addCntrToEir( item );
        	} );
        	
        	loadpayment();
        });

		$("#save").on("click", function(){
			if ( tblCont.DataTable().rows().count() == 0 ){
				$(".toast").remove();
				toastr["warning"]("Không có gì để lưu!");
				return;
			}

			var updateData = tblCont.getEditedRows().map(function(item){
								 return {"rowguid": item[0], "BILL_CHK": item[2]};
							 });

			if ( updateData.length == 0 ){
				$(".toast").remove();
				toastr["warning"]("Không có thay đổi!");
				return;
			}

			$.confirm({
	            title: 'Thông báo!',
	            type: 'orange',
	            icon: 'fa fa-warning',
	            content: 'Dữ liệu được chọn sẽ không được hiệu chỉnh sau khi đã xác nhận tập hợp!',
	            buttons: {
	                ok: {
	                    text: 'Xác nhận',
	                    btnClass: 'btn-warning',
	                    keys: ['Enter'],
	                    action: function(){
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
		});

		$('#pay-confirm').on('click', function () {
			if( $("input[name='publish-opt']:checked").val() == "e-inv" ){
				publishInv();
			}else{
				saveData();
			}
		});
//------EVENTS

//------FUNCTIONS

		function search_cont_total(){
			tblStatis.dataTable().fnClearTable();
			tblCont.waitingLoad();

			var formData = {
				"action": "view",
				"act": "load_data",
				"args" : {
					shipKey: _selectShipKey,
					cjmode: $("#cjMode").val(),
					oprs: $("#oprID").val(),
					cntrClass: $("#cntrClass").val(),
					dmethod: $("#dMethod").val(),
					isLocal: $("#isLocal").val(),
					transit: $("#transit").val(),
					status: $("#FE").val(),
					formDate: $("#fromDate").val(),
					toDate: $("#toDate").val(),
					cusID: $("#search-taxcode").val()
				}
			};

			_listCalc = [];

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					$( "#search" ).button("reset");
					var rows = [];
					_results = [];
					if(data.results && data.results.length > 0) {
						_results = data.results;
						
						$.each( _results, function( i, item ) {
							var r = [];
							$.each( _colCont, function( idx, colname ){
								var val = "";
								switch(colname){
									case "STT":
										val = i+1;
										break;
									case "IsLocal":
										val = item[colname] == "F" ? "Ngoại" : ( item[colname] == "L" ? "Nội" : item[colname] );
										break;
									case "BILL_CHK":
										var isDisabled = item[colname] == "1" ? "disabled" : "";
										val = '<label class="checkbox checkbox-outline-ebony '+ isDisabled +'">'
												+ '<input type="checkbox" name="check-bill" '+ isDisabled +' value="'
															+ item[colname] +'" style="display: none;" '+ (item[colname] == "1" ? "checked" : "") +'>'
												+ '<span class="input-span"></span>';
											+ '</label>';
										break;
									default:
										val = item[ colname ] ? item[ colname ] : "";
										break;
								}
								r.push( val );
							} );

							rows.push( r );

						} );
					}

					tblCont.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblCont.dataTable().fnAddData(rows);
		        	}

		        	var rowsStatis = [];
		        	if( data.totals && data.totals.length > 0 ){
		        		$.each( data.totals, function(i, item) {
		        			rowsStatis.push(
			        				[
			        					item.OprID,
			        					item.CLASS_Name,
			        					item.JobName,
			        					item.SZ_20F > 0 ? item.SZ_20F : "",
			        					item.SZ_40F > 0 ? item.SZ_40F : "",
			        					item.SZ_45F > 0 ? item.SZ_45F : "",
			        					item.SZ_20E > 0 ? item.SZ_20E : "",
			        					item.SZ_40E > 0 ? item.SZ_40E : "",
			        					item.SZ_45E > 0 ? item.SZ_45E : ""
			        				]
		        			);
		        		});
		        	}

		        	if(rowsStatis.length > 0){
						tblStatis.dataTable().fnAddData(rowsStatis);
		        	}
				},
				error: function(err){
					tblStatis.dataTable().fnClearTable();
					tblCont.dataTable().fnClearTable();
					$( "#search" ).button("reset");
					$('.toast').remove();
					toastr['error']("Server Error at [search_cont_total]");
					console.log(err);
				}
			});
		}

		function loadpayment(){

			if( _listCalc.length == 0 || $('.input-required').has_required() || !$("#inv-temp").val() ) {
				tblInv.dataTable().fnClearTable();
				return;
			}

			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'invTemp': $("#inv-temp").val(),
				'cusID': $('#cusID').val(),
				'list': _listCalc
			};

			tblInv.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					if( data.deny ){
						toastr["error"]( data.deny );
						return;
					}

					if( data.no_payer ){
						$(".toast").remove();
						toastr["error"](data.no_payer);

						tblInv.dataTable().fnClearTable();
						return;
					}

					if( data.error_plugin && data.error_plugin.length > 0 ){
						$(".toast").remove();
						$.each( data.error_plugin, function(){
							toastr["error"](this);
						} );

						tblInv.dataTable().fnClearTable();
						// return;
					}

					if( data.error && data.error.length > 0 ){
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
							var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
							var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ? "Nội" : "");
							rows.push([
								(stt++)
								, lst[i].TariffCode
								, lst[i].TariffDescription
								, lst[i].Unit
								, lst[i].JobMode == 'GO' ? "Nâng container" : ( lst[i].JobMode == 'GF' ? "Hạ container" : lst[i].JobMode )
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
						ordering: false,
						buttons: [],
						columnDefs: [
							{ targets: _colsPayment.getIndexs(["STT", "CURRENCYID"]), className: "text-center" },
							{ targets: _colsPayment.indexOf("QTY"), className: "text-right" },
							{ 
								targets: _colsPayment.getIndexs(["standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT"
																	, "VAT_RATE", "VAT", "TAMOUNT"])
								, className: "text-right"
								, render: $.fn.dataTable.render.number( ',', '.', 2)
							},
							{ targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"]), className: "hiden-input" }
						],
						scrollY: '16vh',
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

		function addCntrToEir(item){

			item['PAYER_TYPE'] = getPayerType( $('#cusID').val() );
			item['CusID'] = $('#cusID').val(); //*

			item["Port_CD"] = "VN<?=$this->config->item("YARD_ID");?>";

			if(item.EIR_SEQ == 0){
				item['EIR_SEQ'] = 1;
			}
			
			_listCalc.push(item);
		}

		function publishInv()
		{
			$('#payment-modal').find('.modal-content').blockUI();
			var datas = getInvDraftDetail();
			var formData = {
				cusTaxCode : $('#taxcode').val(),
				cusAddr : $('#p-payer-addr').text(),
				cusName : $('#p-payername').text(),
				sum_amount : $('#AMOUNT').text(),
				vat_amount : $('#VAT').text(),
				total_amount : $('#TAMOUNT').text(),
				inv_type : $("#inv-type").val(),
				exchange_rate : $("#ExchangeRate").val(),
				datas : datas
			};

			$.ajax({
				url: "<?=site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {

					if( data.error ){
						$('#payment-modal').find('.modal-content').unblock();
						$(".toast").remove();
						toastr["error"]( data.error );
						return;
					}
					
					saveData( data );
				},
				error: function(err){
					$('#payment-modal').find('.modal-content').unblock();
					console.log(err);
				}
			});
		}

		function saveData( invInfo )
		{
			var drDetail = getInvDraftDetail();
			var drTotal = {};
			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});

			if(drDetail.length == 0) {
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin thanh toán!');
				return;
			}

			var formData = {
				'action': 'save',
				'args': {
					'pubType': $("input[name='publish-opt']:checked").val(),
					'datas': _listCalc,
					'draft_detail': drDetail,
					'draft_total': drTotal
				}
			};

			if (typeof invInfo !== "undefined" && invInfo !== null)
			{
				formData.args["invInfo"] = invInfo;
			}else{
				//trg hop không phải xuất hóa đơn điện tử, block popup thanh toán ở đây
				$('#payment-modal').find('.modal-content').blockUI();
			}

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
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

					if( data.sendMailInfo ){
						sendMail( data.sendMailInfo );
					}

					if( data.invInfo ){
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?=site_url(md5('Credit') . '/' . md5('payment_success'));?>");

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
						form.setAttribute("action", "<?=site_url(md5('Credit') . '/' . md5('draft_success'));?>");

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
					toastr['error']("Server Error at [saveData]");
				}
			});
		}

		function getInvDraftDetail(){
			var rows = [];
			var tmprow = tblInv.find('tbody tr:not(.row-total)');
			$.each(tmprow, function() {
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

		function search_ship(){
			var tblSearchShip = $("#search-ship");

		    tblSearchShip.dataTable().fnClearTable();
			tblSearchShip.waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_ship',
				'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
				'shipyear': $('#cb-searh-year').val(),
				'shipname': $('#search-ship-name').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
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
								, data.vsls[i].ShipKey
								, getDateTime(data.vsls[i].BerthDate)
								, data.vsls[i].ShipYear
								, data.vsls[i].ShipVoy
							]);
						}
					}

					tblSearchShip.dataTable().fnClearTable();
					if(rows.length > 0){
						tblSearchShip.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tblSearchShip.dataTable().fnClearTable();
					console.log(err);
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				}
			});
		}

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
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

		        	$("#taxcode").prop("readonly", false);
		        	$("#taxcode, #search-taxcode").prop("placeholder", "ĐT thanh toán");
				},
				error: function(err){
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Server Error at [load_payer]!");
				}
			});
		};

		function fillPayer(){
			var py = $("#cusID").val() ? payers.filter(p=> p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val())
									   : payers.filter(p=> p.VAT_CD == $('#taxcode').val());

			if(py.length > 0){ //fa-check-square
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);

				$("#p-money-credit").removeClass("hiden-input").find("span").text( py[0].CusType == "M" ? "THU NGAY" : "THU SAU" );
				
				$("#taxcode").removeClass("error");
			}

			return py.length > 0;
		}

		function load_opr(){
			var formdata = {
				'action': 'view',
				'act': 'load_opr'
			};

			$.ajax({
				url: "<?=site_url(md5('Credit') . '/' . md5('creContLiftTotal'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					if( data.oprs && data.oprs.length > 0 ){
						var innerOprHtml = "";
						$.each( data.oprs, function(){
							innerOprHtml += '<option value="'+ this["CusID"] +'">'+this["CusID"] + " : " + this["CusName"]+'</option>';
						} );
						$("#oprID").append(innerOprHtml).selectpicker('refresh');
					}
					
				},
				error: function(err){
					console.log(err);
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				}
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

//------FUNCTIONS
	});

</script>
<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>

<script src="<?=base_url('assets/vendors/dataTables/datatables.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/dataTables.buttons.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/extensions/jszip.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/extensions/buttons.html5.min.js');?>"></script>