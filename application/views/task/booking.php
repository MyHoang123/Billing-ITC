<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<link href="<?= base_url('assets/vendors/dataTables/extensions/select.dataTables.min.css'); ?>" rel="stylesheet" />

<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css//ebilling.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'); ?>" rel="stylesheet" />

<style>
	.nav-tabs {
		height: inherit !important;
	}

	.m-row-selected {
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

	.grid-hidden {
		display: none;
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

	.unchecked-Salan {
		pointer-events: none;
	}

	span.col-form-label {
		width: 100%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label {
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

	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}

	.inputGroup label {
		padding: 12px 15px;
		width: 100%;
		display: block;
		text-align: left;
		color: #949393;
		cursor: pointer;
		position: relative;
		z-index: 2;
		transition: color 200ms ease-in;
		overflow: hidden;

		border: 1px inset;
		box-shadow: inset 0 1px 4px #cecece !important;
	}

	table.dataTable tr td.select-checkbox::before {
		top: auto;
	}

	table.dataTable tr.selected td.select-checkbox::after {
		color: black !important;
		top: 50%;
	}

	.inputGroup label:before {
		width: 10px;
		height: 10px;
		border-radius: 50%;
		content: '';
		background-color: #2f8db1;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%) scale3d(1, 1, 1);
		transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
		opacity: 0;
		z-index: -1;
	}

	.inputGroup label:after {
		width: 32px;
		height: 32px;
		content: '';
		border: 2px solid #D1D7DC;
		background-color: #fff;
		background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
		background-repeat: no-repeat;
		background-position: 2px 3px;
		border-radius: 50%;
		z-index: 2;
		position: absolute;
		right: 7px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		transition: all 200ms ease-in;
	}

	.inputGroup input:checked~label {
		color: #fff;
	}

	.inputGroup input:checked~label:before {
		transform: translate(-50%, -50%) scale3d(56, 56, 1);
		opacity: 1;
	}

	.inputGroup input:checked~label:after {
		background-color: #28a745;
		border-color: #fff;
	}

	.inputGroup input {
		width: 32px;
		height: 32px;
		order: 1;
		z-index: 2;
		position: absolute;
		right: 5px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		visibility: hidden;
	}

	.inputGroup {
		background-color: #fff;
		display: block;
		margin-top: 7px;
		position: relative;
		min-width: 142px;
	}

	.new-booking {
		padding: 10px 20px !important;
		font-size: 13px !important;
	}

	.new-booking .form-group {
		margin-bottom: 1rem !important;
	}

	.transition-width {
		-webkit-transition: width 1s, height 2s;
		/* For Safari 3.1 to 6.0 */
		transition: width 1s, height 2s;
	}

	#conts-modal .dataTables_filter {
		padding-left: 15px;
	}

	#conts-modal .dt-buttons {
		padding-right: 15px;
	}

	.fleft {
		flex: 1;
		/* shorthand for: flex-grow: 1, flex-shrink: 1, flex-basis: 0 */
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}

	.dropdown-menu.dropdown-menu-column {
		max-height: 40vh;
		overflow-y: auto;
	}

	.toast-bottom-right .toast {
		width: 385px !important;
	}

	.link-cell {
		font-style: italic;
		color: navy;
		text-decoration: underline;
	}

	.link-cell {
		text-decoration: underline;
	}

	ul.list-group {
		columns: 2;
		-webkit-columns: 2;
		-moz-columns: 2;
		display: block !important;
		margin-right: 13px !important;
	}

	.list-group .list-group-item {
		border-color: rgba(0, 0, 0, .125) !important;
		border: 0;
		border-bottom: 1px solid rgba(0, 0, 0, .125);
		margin-right: -13px !important;
	}

	.dropdown-menu.open {
		max-height: none !important;
	}

	.modal-footer .fleft> :not(:first-child) {
		margin-left: .25rem;
	}

	.text-ellipsis {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
</style>

<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title mr-4">BOOKING</div>
				<div class="button-bar-group mr-3">
					<button id="find-booking" class="btn btn-outline-warning btn-sm mr-1" title="Tìm booking">
						<span class="btn-icon"><i class="fa fa-search"></i>Tìm Booking</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row pl-1">
					<div id="editbooking" class="col-xl-4 col-lg-5 ibox border-e new-booking mx-auto mb-1">
						<div class="row form-group" style="border-bottom: 1px solid #eee;">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<div class="inputGroup">
									<input id="notAssignCntr" name="isAssignCntr" value="N" type="radio" checked="" />
									<label for="notAssignCntr">Không chỉ định</label>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
								<div class="inputGroup">
									<input id="assignCntr" name="isAssignCntr" value="Y" type="radio" />
									<label for="assignCntr">Chỉ định</label>
								</div>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Ngày tạo</label>
							<div class="col-sm-7 input-group input-group-sm">
								<input class="form-control form-control-sm text-center" id="fromDate" type="text" placeholder="Ngày tạo" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Hiệu lực đến</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm text-center input-required" id="toDate" placeholder="Hiệu lực đến" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số Booking</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="bookingNo" placeholder="Số Booking" type="text" style="text-transform: uppercase;">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Hãng KT</label>
							<div class="col-sm-7 input-group">
								<select id="opr" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
									<option value="" selected>--[chọn hãng khai thác]--</option>
									<?php if (isset($oprs) && count($oprs) > 0) {
										foreach ($oprs as $item) { ?>
											<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
									<?php }
									} ?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Kích cỡ</label>
							<div class="col-sm-7 input-group">
								<select id="sizetype" class="selectpicker input-required" data-live-search="true" data-style="btn-default btn-sm" data-width="100%">
									<option value="" selected>--[chọn kích cỡ]--</option>
								</select>
							</div>
						</div>

						<div id="opt-qty" class="row form-group">
							<label class="col-sm-5 col-form-label">Số lượng</label>
							<div class="col-sm-7 input-group">
								<input type="number" min="1" value="1" class="form-control form-control-sm input-required" id="cntrQty" placeholder="Số lượng" type="text">
							</div>
						</div>

						<div id="opt-cont" class="row form-group hiden-input">
							<label class="col-sm-5 col-form-label">Số container</label>
							<div class="col-sm-7 input-group">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="cntrNo" type="text" placeholder="Container No.">
									<span id="cntrno-search" class="input-group-addon bg-white btn text-warning" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem">
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Tàu / chuyến</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm" id="shipid" placeholder="Tàu / chuyến" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
									<i class="ti-search"></i>
								</span>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">POL / POD</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm mr-2" id="POL" placeholder="POL" maxlength="5" type="text" style="text-transform: uppercase;">
								<input class="form-control form-control-sm" id="POD" placeholder="POD" maxlength="5" type="text" style="text-transform: uppercase;">
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Chủ hàng</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm" id="shipperName" placeholder="Chủ hàng" type="text">
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Loại hàng</label>
							<div class="col-sm-7 input-group">
								<select id="cargoType" class="selectpicker" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
									<option value="" selected>--[chọn loại hàng]--</option>
									<?php if (isset($cargoTypes) && count($cargoTypes) > 0) {
										foreach ($cargoTypes as $item) { ?>
											<option value="<?= $item['Code'] ?>"><?= $item['Description'] ?></option>
									<?php }
									} ?>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Ghi chú</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm" id="note" placeholder="Ghi chú" type="text">
							</div>
						</div>

						<span class="row" style="border-bottom: 1px solid #ddd"></span>

						<div class="row form-group mt-3" style="margin-bottom: 0px!important">
							<div class="col-sm-7 ml-sm-auto">
								<button id="save-booking" class="btn btn-primary btn-sm btn-block" data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu" title="Lưu dữ liệu">

									<span class="btn-icon"><i class="fa fa-save"></i>Lưu Booking</span>
								</button>
								<button id="search" class="btn btn-warning btn-sm btn-block hiden-input" data-loading-text="<i class='la la-spinner spinner'></i>Đang tìm kiếm" title="Tìm kiếm">

									<span class="btn-icon"><i class="fa fa-search"></i>Tìm kiếm</span>
								</button>
							</div>

						</div>
					</div>
					<!-- ///////////////////////////////// -->
					<div id="gridbooking" class="col-8 pl-3 pr-0" style="display: none;">
						<div class="ibox mb-0 border-e p-3 content-group">
							<div class="table-responsive">
								<table id="tbl-content" class="table table-striped display nowrap" cellspacing="0" style="width: 100%">
									<thead>
										<tr>
											<th col-name="STT">STT</th>
											<th col-name="rowguid">RowGuid</th>
											<th col-name="BOOK_STATUS" class="editor-cancel">Trạng thái</th>
											<th col-name="BookingNo" class="editor-cancel">Số Booking</th>
											<th col-name="ExpDate" class="data-type-date">Ngày Hết Hạn</th>
											<th col-name="OprID" class="autocomplete">Hãng KT</th>
											<th col-name="LocalSZPT" class="autocomplete">KC Nội Bộ</th>
											<th col-name="ISO_SZTP" class="editor-cancel">KC ISO</th>
											<th col-name="BookAmount" class="data-type-numeric">SL Đăng Ký</th>
											<th col-name="StackingAmount" class="editor-cancel" class="data-type-numeric">SL Đã Cấp</th>
											<th col-name="AssignedCont" class="editor-cancel">Cont Đăng Ký</th>
											<th col-name="CARGO_TYPE" class="autocomplete" show-target="#cargotype-modal">Loại Hàng</th>
											<th col-name="ShipName">Chủ Hàng</th>
											<th col-name="AttachCont" class="editor-cancel"></th>
											<th col-name="Note">Ghi Chú</th>
											<th col-name="VesselName">Tên Tàu</th>
											<th col-name="VoyAge">Chuyến Tàu</th>
											<th col-name="POL">Cảng Xếp</th>
											<th col-name="POD">Cảng Dỡ</th>
											<th col-name="FPOD">Cảng Đích</th>
											<th col-name="CmdID">Hàng Hoá</th>
											<th col-name="Temperature">Nhiệt Độ</th>
											<th col-name="DG_CD">Mã Nguy Hiểm</th>

											<th col-name="VentSet">VentSet</th>
											<th col-name="CLASS">CLASS</th>
											<th col-name="UNNO">UNNO</th>
											<th col-name="OOG_TOP">OOG TOP</th>
											<th col-name="OOG_LEFT">OOG LEFT</th>
											<th col-name="OOG_RIGHT">OOG RIGHT</th>
											<th col-name="OOG_BACK">OOG BACK</th>
											<th col-name="OOG_FRONT">OOG FRONT</th>
											<th col-name="Humidity">Humidity</th>
											<th col-name="O2">O2</th>
											<th col-name="CO2">CO2</th>

											<th col-name="CreatedBy">Người tạo</th>
											<th col-name="isAssignCntr"></th>
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

<!--conts modal-->
<div class="modal fade" id="conts-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" data-backdrop="static" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog" role="document" style="min-width: 900px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách container</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="conts-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th style="max-width: 20px!important;">Chọn</th>
								<th>Số container</th>
								<th>Vị trí bãi</th>
								<th>Số Niêm Chì</th>
								<th>Tình Trạng</th>
								<th>TLHQ</th>
								<th>Ghi Chú</th>
								<th>Selector</th>
								<th>rowguid</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div class="fleft">
					<button id="search-cont-by-list" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#modal-conts-filter" title="Tìm theo danh sách container">
						<i class="la la-search-plus"></i>
						Tìm list cont
					</button>
				</div>

				<button id="apply-selected-cont" class="btn btn-sm btn-outline-primary">
					<i class="fa fa-plus-circle"></i>
					Xác nhận
				</button>

				<button id='cancel-select-cont' class="btn btn-sm btn-outline-danger">
					<i class="fa fa-close"></i>
					Đóng
				</button>
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
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2020">2021</option>
										<option value="2020">2022</option>
										<option value="2020">2023</option>
										<option value="2020">2024</option>
										<option value="2020">2025</option>
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

<!--cargo type modal-->
<div class="modal fade" id="cargotype-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách loại hàng</h5>
			</div>
			<div class="modal-body">
				<table id="tblCargoType" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="Code">Mã</th>
							<th col-name="Description">Tên</th>
						</tr>
					</thead>
					<tbody>
						<?php if (count($cargoTypes) > 0) {
							$i = 1; ?>
							<?php foreach ($cargoTypes as $item) {  ?>
								<tr>
									<td style="text-align: center"><?= $i; ?></td>
									<td><?= $item['Code']; ?></td>
									<td><?= $item['Description']; ?></td>
								</tr>
							<?php $i++;
							}  ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-cargotype" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--cargo type modal-->
<div class="modal fade" id="assigned-cont-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách Container đã đăng ký</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul id="list-assigned-cont" class="list-group list-group-divider">
				</ul>
			</div>
			<div class="modal-footer" style="border:0">
				<div style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-draggable ui-draggable in" id="modal-conts-filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog" style="min-width: 590px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title">Tìm theo danh sách cont</h5>
			</div>
			<div class="modal-body clearfix" style="overflow-x: auto; max-height: 500px;">
				<p class="text-muted m-b-20 font-13">Nhập từng số cont, sau đó nhấn enter! Hoặc sao chép + dán vào 1 danh sách cont (được phân cách bởi những khoảng trắng [ ]/ dấu phẩy [,]/ enter [⏎]).</p>
				<select id="f-conts" multiple data-role="tagsinput" style="min-height: 100px">
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" id="submit-f-conts" class="btn btn-sm btn-primary-outline waves-effect waves-light" value="" data-dismiss="modal">Áp dụng</button>
				<button type="button" id="remove-f-conts" class="btn btn-sm btn-danger-outline waves-effect waves-light" style="float: left">Xóa</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function() {

		var _colContent = ["STT", "rowguid", "BOOK_STATUS", "BookingNo", "ExpDate", "OprID", "LocalSZPT", "ISO_SZTP", "BookAmount", "StackingAmount", "AssignedCont", "CARGO_TYPE", "ShipName", "AttachCont", "Note", "VesselName", "VoyAge", "POL", "POD", "FPOD", "CmdID", "Temperature", "DG_CD"
			, "VentSet", "CLASS", "UNNO",  "OOG_TOP", "OOG_LEFT", "OOG_RIGHT", "OOG_BACK", "OOG_FRONT", "Humidity", "O2", "CO2"
			, "CreatedBy", "isAssignCntr"],
			_colCargoType = ["STT", "Code", "Description"],
			_colsContList = ["Check", "CntrNo", "Location", "SealNo", "ContCondition", "cTLHQ", "Note", "Selector", "rowguid"];

		var tblContent = $('#tbl-content'),
			tblConts = $("#conts-list"),
			cargoTypeModal = $("#cargotype-modal"),
			tblCargoType = $("#tblCargoType");

		var payers = {},
			_lstOrder = {},
			_sizetypes = [],
			_conts = [],
			_ports = [],
			_bookingData = [],
			_oprs, cargoTypeSource;
		var _selectShipKey = '',
			_shipid = '',
			_shipYear = '',
			_shipVoy = '',
			_loadingcontbefore = false;

		loadCntrBefore();

		<?php if (isset($sztps) && count($sztps) > 0) { ?>
			_sizetypes = <?= json_encode($sztps) ?>;
		<?php } ?>

		<?php if (isset($oprs) && count($oprs) > 0) { ?>
			_oprs = <?= json_encode($oprs) ?>;
		<?php } ?>

		<?php if (isset($cargoTypes) && count($cargoTypes) > 0) { ?>
			cargoTypeSource = <?= json_encode($cargoTypes) ?>;
		<?php } ?>

		if (cargoTypeSource.filter(p => p.Code == "").length == 0) {
			cargoTypeSource.unshift({
				"Code": "",
				"Description": ""
			});
		}

		$("#cargoType").val("MT").selectpicker("refresh");

		// ------------binding shortcut key press------------
		ctrlDown = false,
			ctrlKey = 17,
			cmdKey = 91,
			rKey = 82,

			$(document).keydown(function(e) {
				if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
			}).keyup(function(e) {
				if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
			});

		$(document).keydown(function(e) {
			if (ctrlDown && e.keyCode == rKey) {
				location.reload(true);
				return false;
			}
		});

		// -----INIT TABLES
		var dtContent = tblContent.DataTable({
			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: _colContent.indexOf("STT")
				},
				{
					render: function(data, type, row, meta) {
						var val = "";
						var morebtn = "";

						if (data) {
							if (data.split(", ").filter(p => p).length > 3 && row[_colContent.indexOf('isAssignCntr')] != "Y") {
								morebtn = `<a href="#" class="link-cell" data-toggle="modal"
															data-target="#assigned-cont-modal" title="Xem chi tiết danh sách container">Xem thêm</a>`;
							}
						}

						if (row[_colContent.indexOf('isAssignCntr')] == "Y") {
							morebtn = `<a href="#" class="link-cell attach-conts" data-toggle="modal" data-target=""
											title="Thêm container">Thêm cont</a>`;
						}

						return `<div class='text-ellipsis width-300'>${data.split(", ").filter(p => p).join(', ')}</div>${morebtn}`;
					},
					targets: _colContent.indexOf("AssignedCont")
				},
				{
					className: "hiden-input",
					targets: _colContent.getIndexs(["rowguid", "AttachCont", "isAssignCntr"])
				},
				{
					className: 'text-center',
					width: "150px",
					targets: _colContent.indexOf("ExpDate"),
					render: function(data, type, full, meta) {
						return data ? getDateTime(data).split(' ')[0] + ' 23:59:59' : '';
					}
				},
				{
					className: 'text-center',
					targets: _colContent.getIndexs(["BOOK_STATUS", "BookingNo", "ISO_SZTP"])
				},
				{
					className: 'text-right',
					type: 'num',
					targets: _colContent.getIndexs(["BookAmount", "StackingAmount"])
				},
				{
					className: 'text-center show-dropdown',
					targets: _colContent.getIndexs(["OprID", "LocalSZPT"])
				},
				{
					className: 'show-more',
					targets: _colContent.getIndexs(["CARGO_TYPE"]),
					render: function(data, type, full, meta) {
						if (cargoTypeSource.filter(p => p.Code == data).length > 0) {
							return cargoTypeSource.filter(p => p.Code == data).map(x => x.Description)[0];
						} else {
							return data;
						}
					}
				}
			],
			buttons: [],
			infor: false,
			scrollY: '56vh',
			paging: false,
			keys: true,
			autoFill: {
				focus: 'focus',
				columns: _colContent.getIndexs(["ExpDate", "OprID", "LocalSZPT", "BookAmount", "ShipName", "CARGO_TYPE"])
			},
			select: true,
			rowReorder: false,
			arrayColumns: _colContent
		});

		$('#search-ship').DataTable({
			paging: false,
			infor: false,
			searching: false,
			buttons: [],
			scrollY: '35vh'
		});

		tblCargoType.DataTable({
			scrollY: '40vh',
			columnDefs: [{
				type: "num",
				className: "text-center",
				targets: _colCargoType.indexOf("STT")
			}],
			order: [
				[_colCargoType.indexOf("STT"), 'asc']
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

		var dtContList = tblConts.DataTable({
			columnDefs: [{
				className: 'hiden-input',
				targets: _colsContList.getIndexs(["Selector", "rowguid"])
			}, {
				orderDataType: 'dom-checkbox',
				className: 'select-checkbox',
				targets: _colsContList.indexOf("Check")
			}, {
				className: 'text-center',
				targets: _colsContList.indexOf("ContCondition")
			},{
				targets: _colsContList.getIndexs(["Note"]),
				render: function(data, type, full, meta) {
					return "<div class='wrap-text' style='max-width: 200px'>" + data + "</div>";
				}
			}],
			select: {
				style: 'multi+shift',
				selector: 'td:first-child'
			},
			search: {
				regex: true
			},
			info: true,
			paging: false,
			scrollY: '300px',
			buttons: [{
					extend: 'selectAll',
					text: '<i class="fa fa-check-circle"></i>&ensp;Chọn tất cả',
					className: 'btn btn-sm btn-outline-secondary',
					action: function(e, dt, button, config) {
						e.preventDefault();
						dt.rows({
							search: 'applied'
						}).select()
					}
				},
				{
					extend: 'selectNone',
					text: '<i class="fa fa-ban"></i>&ensp;Bỏ chọn',
					className: 'btn btn-sm btn-outline-secondary'
				}
			],
			createdRow: function(row, data, dataIndex) {
				if (data[_colsContList.indexOf('Selector')] >= 1) {
					this.DataTable().rows(dataIndex).select();
				}
				if (data[_colsContList.indexOf('Selector')] == 2) {
					$(row).addClass('unselectable');
				}
			}
		});

		dtContList.buttons(0, null).container().prependTo(
			dtContList.table().container()
		);
		// -----INIT TABLES

		var tblHeader = tblContent.parent().prev().find('table');
		tblHeader.find(' th:eq(' + _colContent.indexOf('CARGO_TYPE') + ') ').setSelectSource(cargoTypeSource.map(p => p.Description));
		tblHeader.find(' th:eq(' + _colContent.indexOf('OprID') + ') ').setSelectSource(_oprs.map(p => p.CusID));
		tblHeader.find(' th:eq(' + _colContent.indexOf('LocalSZPT') + ') ').setSelectSource($.unique(_sizetypes.map(p => p.LocalSZPT)));

		//------SET DROPDOWN BUTTON FOR COLUMN
		tblContent.columnDropdownButton({
			data: [{
					colIndex: _colContent.indexOf("OprID"),
					source: _oprs.map(p => p.CusID)
				},
				{
					colIndex: _colContent.indexOf("LocalSZPT"),
					source: _sizetypes.map(p => ({
						'ref': p.OprID,
						'value': p.LocalSZPT
					})),
					refColIndex: _colContent.indexOf('OprID')
				},
			],
			onSelected: function(cell, itemSelected) {
				if (cell.index() == _colContent.indexOf("LocalSZPT")) {
					var oprID = cell.prev().text();
					if (_sizetypes.filter(p => p.OprID == oprID).map(x => x.LocalSZPT).indexOf(itemSelected.attr("code")) == -1) {
						toastr.options.timeOut = "10000";
						toastr["error"]("Kích cỡ này không phù hợp với hãng khai thác đã chọn !<br/> Vui lòng chọn hãng kích cỡ khác!");
						toastr.options.timeOut = "5000";
						return;
					}
				}

				var oldData = tblContent.DataTable().cell(cell).data();

				tblContent.DataTable().cell(cell).data(itemSelected.attr("code")).draw(false);

				if (cell.index() == _colContent.indexOf("LocalSZPT")) {
					onChangeLocalSZTP(cell);
				}

				if (!cell.closest("tr").hasClass("addnew")) {
					if (itemSelected.attr("code") != oldData) {
						tblContent.DataTable().row(cell.closest("tr")).nodes().to$().addClass("editing");

					}
				}
			}
		});
		//------SET DROPDOWN BUTTON FOR COLUMN

		//------SET MORE BUTTON FOR COLUMNS
		tblContent.moreButton({
			columns: _colContent.getIndexs(["CARGO_TYPE"]),
			onShow: function(cell) {
				var cellIdx = cell.parent().index();
				$("#apply-cargotype").val(cellIdx + "." + _colContent.indexOf("CARGO_TYPE"));
			}
		});
		//------SET MORE BUTTON FOR COLUMNS

		//------APPLY CARGO_TYPE FROM MODAL
		tblCargoType.find("tbody tr").on("dblclick", function() {
			var applyBtn = $("#apply-cargotype"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq(" + _colCargoType.indexOf("Code") + ")").text(),
				cell = tblContent.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblContent.DataTable();

			cell.removeClass("error");
			dtTbl.cell(cell).data(cgType).draw(false);
			var crRow = tblContent.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}

			cargoTypeModal.modal("hide");
		});

		$("#apply-cargotype").on("click", function() {
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cgType = tblCargoType.getSelectedRows().data().toArray()[0][_colCargoType.indexOf("Code")],
				cell = tblContent.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblContent.DataTable();

			cell.removeClass("error");

			dtTbl.cell(cell).data(cgType).draw(false);
			var crRow = tblContent.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}
		});
		//------APPLY CARGO_TYPE FROM MODAL

		//---------datepicker modified---------
		$('#toDate').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:ss',
			minDate: new Date(moment()),
			timeInput: true
		});

		$('#fromDate').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#toDate').val(moment().format('DD/MM/YYYY 23:59:59'));


		///////// SEARCH SHIP
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
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
			_shipid = $(r).find('td:eq(0)').text();
			_shipYear = $(r).find('td:eq(8)').text();
			_shipVoy = $(r).find('td:eq(9)').text();

			getLane(_selectShipKey);
		});
		$('#unselect-ship').on('click', function() {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
			_shipid = $(r).find('td:eq(0)').text();
			_shipYear = $(r).find('td:eq(8)').text();
			_shipVoy = $(r).find('td:eq(9)').text();

			getLane(_selectShipKey);
			$('#ship-modal').modal("toggle");
		});
		$('#reload-ship').on("click", function() {
			$('#search-ship-name').val("");
			search_ship();
		})
		///////// END SEARCH SHIP

		$('#ship-modal, #cargotype-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});

		$("#assigned-cont-modal").on("show.bs.modal", function(e) {
			var aTag = $(e.relatedTarget);

			var assignedConts = String(tblContent.DataTable().cell(aTag.closest("td")).data() || "").split(",").filter(p => p);

			$("#list-assigned-cont").html("");

			var liCont = "";
			$.each(assignedConts, function(idx, contNo) {
				liCont += '<li class="list-group-item">' + contNo + '</li>';
			});

			$("#list-assigned-cont").html(liCont);
		});

		//------SEARCH BY LIST CONT FOR SELECT CONT TO ASSIGN TO BOOKING 
		$('#f-conts').tagsinput();
		$('.bootstrap-tagsinput').css('min-height', '200px');
		$('.bootstrap-tagsinput').bind('paste', function(e) {
			e.preventDefault();
			var content = e.originalEvent.clipboardData.getData('Text');
			if (content != null && content.length > 0) {
				var data = content.trim();
				var arr_conts = data.split(/[\t\r\n\s,]+/g);
				if (arr_conts.length > 0) {
					var distinctArr = $.unique(arr_conts);
					$.each(distinctArr, function(key, val) {
						$('#f-conts').tagsinput('add', val);
					});
				} else {
					$('#f-conts').tagsinput('add', data);
				}
			}
		});

		$('#remove-f-conts').click(function() {
			$('#f-conts').tagsinput('removeAll');
		});

		$('#submit-f-conts').click(function(e) {
			var input = $('#f-conts');
			if (!input.val()) {
				$('#conts-list').DataTable().column(_colsContList.indexOf("CntrNo"))
					.search('', true, false)
					.draw(false);
			} else {
				var searchval = input.val().join("|");
				$('#conts-list').DataTable().column(_colsContList.indexOf("CntrNo"))
					.search(searchval, true, false)
					.draw(false);
			}
		});
		//------SEARCH BY LIST CONT FOR SELECT CONT TO ASSIGN TO BOOKING 

		//------UPDATE container for assigned booking
		$('#conts-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();

		});

		$('#cancel-select-cont').on('click', function() {
			var relatedRowIndexClick = $('#conts-modal').attr("data-whatever");
			var isAddNew = isNaN(relatedRowIndexClick);

			if (isAddNew) {
				$('#cntrQty').val('');
				dtContList.rows('.selected').deselect();
			} else {
				let clickedRowData = dtContent.rows(relatedRowIndexClick).data().toArray()[0] || [];
				let attachConts = JSON.parse(clickedRowData[_colContent.indexOf('AttachCont')]);
				let attachRowguids = [...(attachConts.OldSelected || []), ...(attachConts.NewSelected || [])].filter((v, i, s) => s.indexOf(v) === i);

				let idx0s = tblConts.filterRowIndexes(_colsContList.indexOf('rowguid'), attachRowguids);
				if (idx0s.length > 0) {
					dtContList.rows('.selected:not(.unselectable)').deselect();
					dtContList.rows(idx0s).select();
				}
			}

			$('#conts-modal').modal('hide');
		});

		$('#apply-selected-cont').on('click', function(e) {
			var relatedRowIndexClick = $('#conts-modal').attr("data-whatever");
			var isAddNew = isNaN(relatedRowIndexClick); //khi modal chọn container đc gọi = button cntrno-search luc them moi, thì mới thay đổi giá trị của cntrNo
			var maxQty = 0;
			var selectedRows = tblConts.DataTable().rows(".selected").data().toArray();
			var selectedRowguids = selectedRows.map(p => p[_colsContList.indexOf("rowguid")]);
			var selectedConts = selectedRows.map(p => p[_colsContList.indexOf("CntrNo")]);

			var cdata = tblConts.DataTable().rows().data().toArray();
			var notAllowDeselectRowguids = cdata.filter(p => p[_colsContList.indexOf('Selector')] == 2).map(p => p[_colsContList.indexOf('rowguid')]);
			var allowDeselectRowguids = cdata.filter(p => p[_colsContList.indexOf('Selector')] == 1).map(p => p[_colsContList.indexOf('rowguid')]);

			if (isAddNew && selectedRowguids.length == 0) {
				$("#cntrNo").val('');
				$.alert({
					type: 'red',
					title: 'Cảnh báo số lượng!',
					content: 'Chưa có container nào được chọn!',
				});
				return;
			}

			if (isAddNew) {
				maxQty = parseInt($('#cntrQty').val());
			} else {
				let clickedRowData = tblContent.DataTable().rows(relatedRowIndexClick).data().toArray()[0] || [];
				maxQty = parseInt(clickedRowData[_colContent.indexOf('BookAmount')] || 0);
			}

			if (!maxQty || maxQty <= 0) {
				$("#cntrNo").val('');
				$.alert({
					type: 'red',
					title: 'Cảnh báo số lượng!',
					content: isAddNew ? 'Kiểm tra lại số lượng đăng ký' : 'Booking này đã hết số lượng đăng ký',
				});
				return;
			}

			if (selectedRowguids.length > maxQty) {
				$("#cntrNo").val('');
				$.alert({
					type: 'red',
					title: 'Cảnh báo số lượng!',
					content: 'Số lượng container vượt quá số lượng đã đăng ký [' + maxQty + ']!',
				});
				return;
			}

			if (isAddNew) {
				$("#cntrNo").val(selectedRowguids.length + " cont được chọn");
				toastr.success(selectedRowguids.length + " cont được chọn");
				$('#conts-modal').modal('hide');
			} else {
				var deselect_rg = allowDeselectRowguids.filter(p => selectedRowguids.indexOf(p) < 0);
				if (deselect_rg.length > 0) {
					var cnts = cdata.filter(p => deselect_rg.indexOf(p[_colsContList.indexOf('rowguid')]) >= 0).map(x => x[_colsContList.indexOf('CntrNo')]).join(', ');
					$.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: `Các container được gỡ khỏi booking: [${ cnts }]`,
						buttons: {
							ok: {
								text: 'Xác nhận',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
									tblContent.DataTable().row(relatedRowIndexClick).nodes().to$().addClass("editing");
									let jsonObj = tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AttachCont")).data();
									let obj = jsonObj ? JSON.parse(jsonObj) : {};
									obj['NewSelected'] = [...selectedRowguids, ...notAllowDeselectRowguids].filter((v, i, s) => s.indexOf(v) === i);
									tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AttachCont")).data(JSON.stringify(obj));
									tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AssignedCont")).data(selectedConts.join(', '));
									$('#conts-modal').modal('hide');
								}
							},
							cancel: {
								text: 'Hủy bỏ',
								btnClass: 'btn-default',
								keys: ['ESC'],
								action: function() {}
							}
						}
					});
				} else {
					tblContent.DataTable().row(relatedRowIndexClick).nodes().to$().addClass("editing");
					let jsonObj = tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AttachCont")).data();
					let obj = jsonObj ? JSON.parse(jsonObj) : {};
					obj['NewSelected'] = [...selectedRowguids, ...notAllowDeselectRowguids].filter((v, i, s) => s.indexOf(v) === i);
					tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AttachCont")).data(JSON.stringify(obj));
					tblContent.DataTable().cell(relatedRowIndexClick, _colContent.indexOf("AssignedCont")).data(selectedConts.join(', '));
					$('#conts-modal').modal('hide');
				}
			}
		});

		var _checkChangeCellClickForAttachConts = "";
		$(document).on("click", "a.attach-conts", function(e) {
			var rIdx = tblConts.DataTable().row($(e.target).closest("tr")).index();
			$("#conts-modal").attr("data-whatever", rIdx);

			if (_checkChangeCellClickForAttachConts !== rIdx) {
				tblConts.dataTable().fnClearTable();
				tblConts.waitingLoad();
				_checkChangeCellClickForAttachConts = rIdx;
			} else {
				$(e.target).attr('data-target', '#conts-modal');
				$($(e.target).attr('data-target')).modal("show");
				return;
			}

			var currentRow = dtContent.rows($(e.target).closest('tr')).data().toArray()[0];
			var bkNo = currentRow[_colContent.indexOf('BookingNo')];
			var oprId = currentRow[_colContent.indexOf('OprID')];
			var localSize = currentRow[_colContent.indexOf('LocalSZPT')];

			if (!oprId) {
				$(".toast").remove();
				toastr["warning"]("Hãng khai thác không xác định!");
				return;
			}

			if (!localSize) {
				$(".toast").remove();
				toastr["warning"]("Kích cỡ không xác định!");
				return;
			}

			$(e.target).attr('data-target', '#conts-modal');
			$($(e.target).attr('data-target')).modal("show");

			var formData = {
				action: 'view',
				act: 'load_cntr_for_edit',
				args: {
					BookingNo: bkNo,
					OprID: oprId,
					LocalSZPT: localSize
				}
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.deny) {
						toastr.error(data.deny);
						return;
					}

					if (!data.conts || data.conts.length == 0) {
						$(".toast").remove();
						toastr["warning"]("Không có container nào đủ điều kiện cập nhật!");
						tblConts.dataTable().fnClearTable();
						return;
					}

					data.conts.sort((a, b) => (a.Selector > b.Selector) ? -1 : ((b.Selector > a.Selector) ? 1 : 0));

					var oldSelectedRowguids = JSON.parse(currentRow[_colContent.indexOf('AttachCont')]).OldSelected;
					var checkRowguids = data.conts.map(p => p.rowguid).filter((v, i, s) => s.indexOf(v) === i);
					var n = oldSelectedRowguids.filter(p => checkRowguids.indexOf(p) < 0);
					if (n.length > 0) {
						$.alert({
							type: 'red',
							title: 'Cảnh báo!',
							content: 'Có dữ liệu cont không đúng!',
						});
						return;
					}
					loadGridConts(data.conts);
				},
				error: function(err) {
					_checkChangeCellClickForAttachConts = "";
					tblConts.dataTable().fnClearTable();
					console.log(err);
					toastr.error('Sự cố phát sinh khi nạp dữ liệu!');
				}
			})
		});

		dtContList.on('user-select', function(e, dt, type, cell, originalEvent) {
			if (dt.cell(cell.index().row, _colsContList.indexOf('Selector')).data() === 2) {
				e.preventDefault();
			}
		});

		dtContList.on('deselect', function(e, dt, type, indexes) {
			if (type === 'row') {
				var rows = dt.rows(indexes).nodes().toArray();
				$.each(rows, function() {
					if ($(this).hasClass('unselectable')) dt.row($(this)).select();
				})
			}
		})

		//------UPDATE container for assigned booking

		$("#search").on("click", function() {
			tblContent.waitingLoad();
			tblContent.dataTable().fnClearTable();
			_checkChangeCellClickForAttachConts = "";
			var btnSearch = $(this);
			btnSearch.button("loading");

			var formData = {
				args: {
					isAssignCntr: $('input[name="isAssignCntr"]:checked').val(),
					FromDate: $('#fromDate').val(),
					ToDate: $('#toDate').val(),
					BookingNo: $('#bookingNo').val(),
					OprID: $('#opr').val(),
					ISO_SZTP: $('#sizetype').val(),
					LocalSZPT: $('#sizetype').val() ? $('#sizetype option:selected').text() : "",
					ShipName: $("#shipperName").val(),
					ShipID: _shipid,
					ShipYear: _shipYear,
					ShipVoy: _shipVoy,
					POL: $("#POL").val().trim().toUpperCase(),
					POD: $("#POD").val().trim().toUpperCase(),
					CARGO_TYPE: $("#cargoType").val()
				},
				action: "view",
				act: "load_booking"
			};

			_bookingData = [];

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(response) {
					btnSearch.button("reset");
					var rows = [];
					if (response.list && response.list.length > 0) {
						_bookingData = response.list;
						var i = 0;
						$.each(response.list, function(index, rData) {
							var r = [];
							$.each(_colContent, function(idx, colname) {
								var val = "";
								switch (colname) {
									case "STT":
										val = i + 1;
										break;
									case "AttachCont":
										let attachs = rData[colname] ? rData[colname].split(',').filter(p => p).map(p => p.trim()) : [];
										val = JSON.stringify({
											OldSelected: attachs
										});
										break;
									case "BOOK_STATUS":
										val = rData[colname] ? (rData[colname] == "A" ? "Tạo mới" : (rData[colname] == "U" ? "Cập nhật" : "Đã huỷ")) : "";
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

					tblContent.dataTable().fnClearTable();

					if (rows.length > 0) {
						tblContent.dataTable().fnAddData(rows);
					}

					tblContent.editableTableWidget().find("td.focus").focus();
				},
				error: function(err) {
					btnSearch.button("reset");
					tblContent.dataTable().fnClearTable();
					toastr["error"]("Có lỗi xảy ra khi nạp dữ liệu!")
					console.log(err);
				}
			});
		});

		$("input[name='isAssignCntr']").on("change", function(e) {
			// $( "#opt-cont" ).
			if ($(e.target).val() == "Y") {
				$("#cntrNo").addClass("input-required");
				$("#opt-cont").removeClass("hiden-input");
				// $("#cntrQty").removeClass("input-required");
				// $("#opt-qty").addClass("hiden-input");
			} else {
				$("#cntrNo").removeClass("input-required");
				$("#opt-cont").addClass("hiden-input");
				// $("#cntrQty").addClass("input-required");
				// $("#opt-qty").removeClass("hiden-input");
			}
		});

		$("#opr").on("change", function() {
			$("#sizetype").find("option[value != '']").remove();
			$("#sizetype").selectpicker("refresh");

			tblConts.dataTable().fnClearTable();

			load_size_type($(this).val());
		});

		$("#find-booking").on("click", function() {
			tblConts.dataTable().fnClearTable();
			var btn = $(this);
			$("#search, #save-booking").toggleClass("hiden-input");
			if ($("#gridbooking").is(":hidden")) {
				$('#editbooking').removeClass('mx-auto');
			}
			$("#gridbooking").toggle("slide", {
				direction: "right"
			}, 1000, function() {

				// reset value in filter
				$(".new-booking").find("select,input:not([name='isAssignCntr'])").val("").selectpicker("refresh");
				cntrSelected = [];

				if ($("#gridbooking").is(":visible")) {
					// tìm booking

					//set text for fromDate label
					$('#fromDate').parent().prev().text("Ngày tạo từ");
					$('#toDate').parent().prev().text("Ngày tạo đến");

					//ẩn điều kiện lọc theo số cont đối với chỉ định /. số lượng đối với k chỉ định
					$("#opt-qty, #opt-cont").css("display", "none");

					//set default for fromDate, toDate
					setDefaultFilterDate();

					$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
					btn.html('<span class="btn-icon"><i class="fa fa-plus"></i>Tạo Booking</span>');
				} else {

					$('#editbooking').addClass('mx-auto');
					//thêm mới booking
					//set text for fromDate label
					$('#fromDate').parent().prev().text("Ngày tạo");
					$('#toDate').parent().prev().text("Hiệu lực đến");

					//set default value for fromDate
					$('#fromDate').val(moment().format('DD/MM/YYYY HH:mm:ss')).datepicker("destroy");

					//hiện điều kiện lọc theo số cont đối với chỉ định /. số lượng đối với k chỉ định
					$("#opt-qty, #opt-cont").css("display", "");

					$('#toDate').datepicker("destroy");

					$('#toDate').datetimepicker({
						controlType: 'select',
						oneLine: true,
						dateFormat: 'dd/mm/yy',
						timeFormat: 'HH:mm:ss',
						minDate: new Date(moment()),
						timeInput: true
					});

					$('#toDate').val(moment().format('DD/MM/YYYY 23:59:59'));

					btn.html('<span class="btn-icon"><i class="fa fa-search"></i>Tìm Booking</span>');
				}

				btn.toggleClass("btn-outline-warning btn-outline-success");

			});
		});

		$('#cntrno-search').on('click', function(e) {
			// #conts-modal
			if (_loadingcontbefore) {
				$(".toast").remove();
				toastr["warning"]("Đợi 1 lát! Dữ liệu đang được cập nhật");
				$(e.target).attr('data-target', '');
				return;
			}

			$("#conts-modal").attr("data-whatever", $(e.target).attr("id"));
			if (tblConts.DataTable().rows().count() > 0) {
				$(e.target).attr('data-target', '#conts-modal');
				return;
			} else {
				$(e.target).attr('data-target', '');
			}

			tblConts.dataTable().fnClearTable();
			var oprSelected = $("#opr").val(),
				sztpSelected = $("#sizetype").val();

			if (!oprSelected) {
				$(".toast").remove();
				toastr["warning"]("Chưa chọn hãng khai thác!");
				return;
			}

			if (!sztpSelected) {
				$(".toast").remove();
				toastr["warning"]("Chưa chọn hãng kích cỡ container!");
				return;
			}

			var findConts = _conts.filter(p => p.OprID == oprSelected && p.ISO_SZTP == sztpSelected);

			if (!findConts || findConts.length == 0) {
				$(".toast").remove();
				toastr["warning"]("Không có container nào đủ điều kiện làm lệnh!");
				return;
			}

			loadGridConts(findConts, $(e.target));

			$($(e.target).attr('data-target')).modal("show");
		});

		$('#save-booking').on('click', function() {
			$.confirm({
				title: 'Cảnh báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Xác nhận tạo Booking này!',
				buttons: {
					ok: {
						text: 'Tiếp tục',
						btnClass: 'btn-primary',
						keys: ['Enter'],
						action: function() {
							saveBooking();
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC'],
						action: function() {}
					}
				}
			});
		});

		$("#save").on("click", function() {
			var editData = tblContent.getEditData();

			if (editData.length == 0) {
				$('.toast').remove();
				toastr["info"]("Không có dữ liệu thay đổi!");
				return;
			}

			$.each(editData, function() {
				if (cargoTypeSource.filter(p => p.Code == this["CARGO_TYPE"]).length == 0) {
					this["CARGO_TYPE"] = cargoTypeSource.filter(p => p.Description == this["CARGO_TYPE"]).map(x => x.Code)[0];
				}
			});

			var editReal = [];
			var checkQty = 0;
			$.each(editData, function(idx, item) {
				var checkItem = _bookingData.filter(p => p.rowguid == item.rowguid)[0];
				var isChanged = false;
				var checkKeys = Object.keys(item)
					.filter(p => ["rowguid", "BookingNo", "BookAmount", "StackingAmount", "AssignedCont"].indexOf(p) == -1);

				if (checkItem.isAssignCntr == "N") {
					checkKeys.push("BookAmount");
				}

				if (parseInt(item.BookAmount) < JSON.parse(item.AttachCont || '[]').length) {
					toastr.error('Số lượng container đã đăng ký vượt quá số lượng đăng ký của [booking ' + item.BookingNo + ']');
					checkQty += 1;
					return;
				}

				$.each(checkKeys, function(i, k) {
					var t1 = checkItem[k] ? checkItem[k] : "",
						t2 = item[k] ? item[k] : "";

					if (k == "ExpDate") {
						if (getDateTime(t1) != t2) {
							isChanged = true;
						}
					} else {
						if (t1 != t2) {
							isChanged = true;
						}
					}
				});
				if (isChanged) {
					editReal.push(item);
				}
			});

			if (checkQty > 0) {
				return;
			}

			if (editReal.length == 0) {
				tblContent.DataTable().rows('.editing').nodes().to$().removeClass("editing");
				$('.toast').remove();
				toastr["info"]("Không có dữ liệu thay đổi!");
				return;
			}

			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Tất cả các thay đổi sẽ được lưu lại!\nTiếp tục?',
				buttons: {
					ok: {
						text: 'Xác nhận lưu',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function() {
							editBooking(editReal);
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

		$("#delete").on("click", function() {
			if (tblContent.getSelectedRows().length == 0) {
				$('.toast').remove();
				toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
			} else {
				var hasAssignedConts = false;

				$.each(tblContent.getSelectedData(), function(idx, item) {
					if (item[_colContent.indexOf("StackingAmount")] && parseInt(item[_colContent.indexOf("StackingAmount")]) > 0) {
						toastr["error"]("Booking [" + item[_colContent.indexOf("BookingNo")] + "] đã được cấp lệnh!");
						hasAssignedConts = true;
					}
				});

				if (hasAssignedConts) return;

				tblContent.confirmDelete(function(data) {
					postDel(data);
				}, 'Booking được chọn sẽ bị xoá? <br> LƯU Ý: Thao tác sẽ tự động gỡ các container ra khỏi booking này!');
			}
		});

		function load_size_type(opr) {
			if (!_sizetypes || _sizetypes.length == 0) {
				return;
			}

			var sztpByOpr = _sizetypes.filter(p => p.OprID == opr);
			var sz = $("#sizetype");

			if (sztpByOpr.length > 0) {
				$.each(sztpByOpr, function(idx, item) {
					sz.append("<option value='" + item.ISO_SZTP + "'>" + item.LocalSZPT + "</option>");
				});

				sz.attr("data-size", sztpByOpr.length + 1);
				sz.selectpicker("refresh");
			}
		}

		function loadGridConts(findConts, target) {
			var rows = [];
			$.each(findConts, function(idx, item) {
				var r = [];
				$.each(_colsContList, function(i, t) {
					var vlue = "";
					switch (t) {
						case "Check":
							vlue = '';
							break;
						case "cTLHQ":
							vlue = (item[t] == "1" ? "Đã thanh lý" : "Chưa thanh lý");
							break;
						case "Location":
							vlue = item["cTier"] ? (item["cBlock"] + "-" + item["cBay"] + "-" + item["cRow"] + "-" + item["cTier"]) : item["cArea"];
							break;
						default:
							vlue = item[t] ? item[t] : "";
					}
					r.push(vlue);
				})
				rows.push(r);
			});

			tblConts.dataTable().fnClearTable();
			if (rows.length > 0) {
				tblConts.dataTable().fnAddData(rows);
			}

			if (target) {
				$(target).attr('data-target', '#conts-modal');
			}
		}

		tblContent.on('change', 'td', function(e) {
			var colidx = $(this).index();

			if (colidx == _colContent.indexOf("LocalSZPT")) {
				onChangeLocalSZTP($(e.target));
			}
			if (colidx == _colContent.indexOf("BookAmount")) {
				onChangeQty($(e.target));
			}
		})

		function onChangeLocalSZTP(cell) {
			var localSZ = cell.text(),
				dtC = tblContent.DataTable(),
				rowIdx = dtC.cell(cell).index().row,
				opr = dtC.cell(rowIdx, _colContent.indexOf("OprID")).data(),
				iso = "";

			if (opr.includes("input")) {
				opr = $(opr).val();
			}

			if (!localSZ) {
				dtC.cell(rowIdx, _colContent.indexOf("ISO_SZTP")).data("");
				return;
			}

			if (!opr) {
				$(".toast").remove();
				toastr["warning"]("Chưa chọn hãng khai thác!");
				localSZ = "";
			} else {
				iso = _sizetypes.filter(p => p.LocalSZPT.trim().toUpperCase() == localSZ.trim().toUpperCase() &&
						p.OprID.trim().toUpperCase() == opr.trim().toUpperCase())
					.map(x => x.ISO_SZTP)[0];

				if (!iso) {
					$(".toast").remove();
					toastr["error"]("Kích cỡ nội bộ không đúng hoặc không phù hợp với hãng khai thác đã chọn!");
					localSZ = "";
					iso = "";
				}
			}

			if (localSZ == "") {
				dtC.cell(cell).data("");
			}

			dtC.cell(rowIdx, _colContent.indexOf("ISO_SZTP")).data(iso ? iso.trim().toUpperCase() : "");
			dtC.cell(rowIdx, _colContent.indexOf("ISO_SZTP") + 1).focus();
		}

		var timedj = 1;
		var oldQty;

		function onChangeQty(cell) {
			timedj *= -1;
			var rowIdx = dtContent.cell(cell).index().row,
				assignedConts = dtContent.cell(rowIdx, _colContent.indexOf("AssignedCont")).data();

			let countCont = assignedConts ? assignedConts.split(",").filter(p => p).length : 0;
			let qty = parseInt(dtContent.cell(cell).data() || 0);

			if (timedj < 0) { // lan dau tien
				oldQty = qty;
				return;
			}

			if (countCont > qty) {
				$.confirm({
					type: 'red',
					title: 'Cảnh báo số lượng!',
					content: 'Số container được đăng ký đang lớn hơn số lượng điều chỉnh!',
					buttons: {
						OK: {
							keys: ['enter'],
							escapeKey: true,
							action: function() {
								dtContent.cell(cell).focus();
							}
						}
					}
				});

				dtContent.cell(cell).data(oldQty);
				timedj = 1;
			}
		}

		function loadCntrBefore() {
			_conts = [];
			_loadingcontbefore = true;
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_cntr_for_booking'
				},
				type: 'POST',
				success: function(data) {
					_loadingcontbefore = false;
					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.conts && data.conts.length > 0) {
						_conts = data.conts;
					}
				},
				error: function(err) {
					console.log(err);
					toastr["error"]("Server Error At [Load Container For Booking]!");
					_loadingcontbefore = false;
				}
			});
		}

		function saveBooking() {

			var isAssignCntr = $('input[name="isAssignCntr"]:checked').val();
			var temp = isAssignCntr == 'N' ? $(".input-required:not(#cntrNo):not(div)") : $(".input-required:not(div)");

			if (temp.has_required()) {
				$(".toast").remove();
				toastr["error"]("Các trường bắt buộc (*) không được để trống!");
				return;
			}

			if (!$("#cntrQty").val() || parseInt($("#cntrQty").val()) <= 0) {
				$(".toast").remove();
				toastr["error"]("Số lượng không phù hợp!");
				return;
			}

			var cntrSelected = tblConts.DataTable().rows(".selected");

			if (isAssignCntr == "Y" && cntrSelected.count() == 0) {
				$("toast").remove();
				toastr["error"]("Chưa chọn container để làm booking chỉ định!");
				return;
			}

			var btnSaveBK = $("#save-booking");
			btnSaveBK.button("loading");

			var formData = {
				args: {
					isAssignCntr: isAssignCntr,
					BookingDate: $('#fromDate').val(),
					ExpDate: $('#toDate').val(),
					BookingNo: $('#bookingNo').val(),
					BookAmount: $("#cntrQty").val(),
					OprID: $('#opr').val(),
					ISO_SZTP: $('#sizetype').val(),
					LocalSZPT: $('#sizetype option:selected').text(),
					ShipName: $("#shipperName").val(),
					Note: $("#note").val(),
					ShipID: _shipid,
					ShipYear: _shipYear,
					ShipVoy: _shipVoy,
					POL: $("#POL").val().trim().toUpperCase(),
					POD: $("#POD").val().trim().toUpperCase(),
					CARGO_TYPE: $("#cargoType").val(),
					StackingAmount: 0,
					CJMode_CD: "CAPR"
				},
				action: "add"
			};

			if (isAssignCntr == "Y") {
				formData["args"]["rowguids"] = cntrSelected.data().toArray().map(p => p[_colsContList.indexOf("rowguid")]);
				formData["args"]["AssignedCont"] = cntrSelected.data().toArray().map(p => p[_colsContList.indexOf("CntrNo")]);
			}

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					btnSaveBK.button("reset");
					$("toast").remove();

					if (data.message) {
						var msg = data.message.split(":");
						if (msg && msg.length > 1) {
							if (msg[0] == "success") {
								dtContList.rows('.selected').remove().draw(false);
								$(".all-cont").trigger("click");
							}

							toastr[msg[0]](msg[1]);
							return;
						}
					}

					toastr.options.newestOnTop = true;
					toastr.options.positionClass = "toast-bottom-right";
					toastr.options.timeOut = "0";
					toastr.options.extendedTimeOut = "0";

					toastr["success"]("Vừa tạo [Số Booking / Hãng Khai Thác / Size Type] <br> " +
						" [" + formData.args.BookingNo + " / " + formData.args.OprID + " / " + formData.args.LocalSZPT + "]");

					toastr.options.newestOnTop = false;
					toastr.options.positionClass = "toast-top-right";
					toastr.options.timeOut = "5000";
					toastr.options.extendedTimeOut = "1000";

					$('#bookingNo').val('');
					$('#opr, #sizetype, #cntrNo').val('');
					$('#opr, #sizetype').selectpicker('refresh');
					tblConts.dataTable().fnClearTable();
					loadCntrBefore();
				},
				error: function(err) {
					btnSaveBK.button("reset");
					$("toast").remove();
					toastr["error"]("Phát sinh lỗi khi lưu mới booking! <br/>Vui lòng liên hệ quản trị viên");

					console.log(err);
				}
			});
		}

		function editBooking(editReal) {
			var formData = {
				"action": "edit",
				"data": editReal
			};

			var saveBtn = $('#save');
			saveBtn.button('loading');

			$('#gridbooking').blockUI();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					saveBtn.button("reset");
					$('#gridbooking').unblock();

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					toastr["success"]("Cập nhật thành công!");
					$(".all-cont").trigger("click");
					$("#search").trigger("click");

					tblConts.dataTable().fnClearTable();
					_checkChangeCellClickForAttachConts = "";
					loadCntrBefore();
				},
				error: function(err) {
					toastr["error"]("Error!");
					saveBtn.button('reset');
					$('#gridbooking').unblock();
					console.log(err);
				}
			});
		}

		function postDel(data) {
			var delRowguids = data.map(p => p[_colContent.indexOf("rowguid")]);
			var delCntrRowguids = data.map(p => JSON.parse(p[_colContent.indexOf('AttachCont')]).OldSelected).flat();

			var delBtn = $('#delete');
			delBtn.button('loading');

			$('.ibox.collapsible-box').blockUI();
			var fdel = {
				'action': 'delete',
				'data': {
					delRowguids: delRowguids,
					delCntrRowguids: delCntrRowguids
				}
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: fdel,
				type: 'POST',
				success: function(data) {
					$('.ibox.collapsible-box').unblock();
					delBtn.button('reset');

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						toastr["error"](data.error);
						return;
					}

					tblContent.DataTable().rows('.selected').remove().draw(false);
					tblContent.updateSTT(_colContent.indexOf("STT"));
					toastr["success"]("Xóa dữ liệu thành công!");
				},
				error: function(err) {
					delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

					toastr["error"]("Error!");
					console.log(err);
				}
			});
		}

		function getLane(shipkey) {
			$("#POL, #POD").attr("placeholder", "Đang nạp ...");
			var formdata = {
				'action': 'view',
				'act': 'getLane',
				'shipkey': shipkey
			};
			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					_ports = data.ports;

					$("#POL").attr("placeholder", "POL").autocomplete({
						source: _ports.map(x => x.Port_CD),
						minLength: 1
					});

					$("#POD").attr("placeholder", "POD").autocomplete({
						source: _ports.map(x => x.Port_CD),
						minLength: 1
					});
				},
				error: function(err) {
					console.log(err);
				}
			});
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
				url: "<?= site_url(md5('Task') . '/' . md5('tskBooking')); ?>",
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

		function setDefaultFilterDate() {
			$('#fromDate').prop("readonly", false);

			var fromDate = $('#fromDate');
			var toDate = $('#toDate');

			toDate.datetimepicker('destroy');

			fromDate.datepicker({
				controlType: 'select',
				oneLine: true,
				// minDate: _maxDateDateIn,
				dateFormat: 'dd/mm/yy',
				timeInput: true,
				onClose: function(dateText, inst) {
					if (toDate.val() != '') {
						var testStartDate = fromDate.datepicker('getDate');
						var testEndDate = toDate.datepicker('getDate');
						if (testStartDate > testEndDate)
							toDate.datepicker('setDate', testStartDate);
					} else {
						toDate.val(dateText);
					}
				},
				onSelect: function(selectedDateTime) {
					toDate.datepicker('option', 'minDate', fromDate.datetimepicker('getDate'));
				}
			});

			toDate.datepicker({
				controlType: 'select',
				oneLine: true,
				// minDate: _maxDateDateIn,
				dateFormat: 'dd/mm/yy',
				timeInput: true,
				onClose: function(dateText, inst) {
					if (fromDate.val() != '') {
						var testStartDate = fromDate.datepicker('getDate');
						var testEndDate = toDate.datepicker('getDate');
						if (testStartDate > testEndDate)
							fromDate.datepicker('setDate', testEndDate);
					} else {
						fromDate.val(dateText);
					}
				},
				onSelect: function(selectedDateTime) {
					fromDate.datepicker('option', 'maxDate', toDate.datepicker('getDate'));
				}
			});

			fromDate.val(moment().subtract('month', 1).format('DD/MM/YYYY'));
			toDate.val(moment().format('DD/MM/YYYY'));
		}

	});
</script>

<script src="<?= base_url('assets/vendors/dataTables/extensions/select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'); ?>"></script>