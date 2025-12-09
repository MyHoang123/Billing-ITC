<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<style>
	.m-row-selected{
		background: violet;
	}
	.MT-toggle, .PY-toggle{
		display: none;
	}
	.MT-toggle button, .PY-toggle button {
		background-color: #fff!important;
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

	.dropdown-menu.dropdown-menu-column {
		max-height: 250px;
		overflow-y: auto;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">CẬP NHẬT THÔNG TIN LỆNH</div>
				<div class="ibox-tools">
					<a class="ibox-collapse"><i class="la la-angle-double-down dock-right"></i></a>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-md-3 col-sm-12 col-12 ibox mb-1">
						<div class="ibox-head" style="min-height: 35px!important;">
							<div class="ibox-title"  style="font-size:14px!important">
								Truy vấn lệnh
							</div>
						</div>
						<div class="row pt-2">
							<!-- <div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<div class="col-sm-8 col-12 ml-sm-auto col-form-label">
										<label for="contOrder" class="checkbox checkbox-blue text-warning">
											<input type="checkbox" name="" id="contOrder" checked="">
											<span class="input-span"></span>
											Lệnh hạ
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<div class="col-sm-8 col-12 ml-sm-auto col-form-label">
										<label for="serviceOrder" class="checkbox checkbox-blue text-warning">
											<input type="checkbox" name="" id="serviceOrder">
											<span class="input-span"></span>
											Lệnh dịch vụ
										</label>
									</div>
								</div>								
							</div> -->
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Loại lệnh</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<select id="ord-type" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="">--</option>
											<option value="NH">Nâng Hạ</option>
											<option value="DV">Dịch Vụ</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Số lệnh</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<input class="form-control form-control-sm" id="ordNo" type="text" placeholder="Số lệnh">
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Số container</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No.">
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Số PIN</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<input class="form-control form-control-sm" id="pinCode" type="text" placeholder="Số PIN">
									</div>
								</div>
							</div>
							<div class="col-12 ibox-footer p-2">
								<div class="form-group text-center pt-3">
									<button id="reload" class="btn btn-warning btn-sm mr-1"
														data-loading-text="<i class='la la-spinner spinner'></i>Tìm kiếm" 
														title="Tìm kiếm">
										<span class="btn-icon"><i class="fa fa-search"></i>Tìm kiếm</span>
									</button>
									<button id="save" class="btn btn-primary btn-sm" 
																	data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu"
																	title="Lưu dữ liệu">
										<span class="btn-icon"><i class="fa fa-save"></i>Lưu dữ liệu</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- end truy vấn lệnh -->
					<!-- begin danh sách lệnh -->
					<div class="col-md-9 col-sm-12 col-12 ibox mb-1" >
						<div class="ibox-head"  style="min-height: 35px!important;">
							<div class="ibox-title" style="font-size:14px!important">
								Danh sách lệnh
							</div>
							<div class="ibox-tools">
								<a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ibox-body p-0">
							<table id="tbl-ord" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
								<thead>
								<tr>
									<th>STT</th>
									<th>Số Lệnh</th>
									<th>Ngày Lệnh</th>
									<th>Hạn Lệnh</th>
									<th>Tàu/Năm/Chuyến</th>
									<th>Số Vận Đơn</th>
									<th>Chủ Hàng</th>
									<th>ĐTTT</th>
									<th>HTTT</th>
									<th>Phương Án</th>
									<th>Số HĐ</th>
									<th>Số PTC</th>
								</tr>
								</thead>

								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 ibox">
				<div class="ibox-head mb-2">
					<div class="ibox-title">
						Chi tiết lệnh
						<button id="unlink-booking" class="btn btn-outline-secondary btn-sm btn-loading" data-loading-text="<i class='la la-spinner spinner'></i>Đang gỡ" title="Gỡ container được chọn ra khỏi Booking" style="display: none;">
							<span class="btn-icon"><i class="ti-unlink"></i>Huỷ lệnh</span>
						</button>
					</div>
					<div class="ibox-tools">
						<a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ibox-body p-0 pb-2">
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th col-name="rowguid" class="editor-cancel">STT</th>
							<th col-name="STT" class="editor-cancel">STT</th>
							<th col-name="BookingNo">Số Booking</th>
							<th col-name="DELIVERYORDER">Mã lệnh (EDO)</th>
							<th col-name="CntrNo">Số Container</th>
							<th col-name="LocalSZPT" class="editor-cancel autocomplete">Kích cỡ</th>
							<th col-name="ISO_SZTP" class="editor-cancel">Kích cỡ ISO</th>
							<th col-name="OprID" class="autocomplete">Hãng khai thác</th>
							<th col-name="ShipInfo" class="editor-cancel" show-target="#ship-modal">Tàu/Năm/Chuyến</th>
							<th col-name="POD" class="autocomplete">POD</th>
							<th col-name="FPOD" class="autocomplete">FPOD</th>
							<th col-name="CARGO_TYPE" class="editor-cancel" show-target="#cargotype-modal">Loại hàng</th>
							<th col-name="CmdID" maxLength="500">Hàng hoá</th>
							<th col-name="SealNo" >Số Niêm Chì</th>
							<th col-name="SealNo1">Số Niêm Chì 1</th>
							<th col-name="IsLocal" class="autocomplete">Nội/Ngoại</th>
							<th col-name="bXNVC" class="editor-cancel data-type-checkbox">Hoàn tất</th>
							<th col-name="FDate" class="data-type-datetime">Hoàn tất</th>
							<th col-name="Transist" class="autocomplete">Chuyển Cảng</th>
							<th col-name="TERMINAL_CD" class="autocomplete" show-target="#terminal-modal">Cảng Giao Nhận</th>
							
							<th col-name="NameDD">Tên Người Đại Diện</th>
							<th col-name="PersonalID">CMND/ĐT</th>
							<th col-name="Mail">Email</th>
							
							<th col-name="BargeInfo" class="editor-cancel" show-target="#barge-modal">Sà Lan/Năm/Chuyến</th>
							<th col-name="Note">Ghi Chú</th>

							<th col-name="CMDWeight" class="data-type-numeric">Trọng lượng</th>
							<th col-name="Temperature">Nhiệt độ</th>
							<th col-name="Vent" class="data-type-numeric">Thông gió</th>
							<th col-name="Vent_Unit">ĐV Thông gió</th>
							<th col-name="CLASS">CLASS</th>
							<th col-name="UNNO">UNNO</th>
							<th col-name="Retlocation">Nơi trả rỗng</th>
							<th col-name="FreeDays">Miễn lưu bãi</th>
							<th col-name="ShipEditedInfo">ShipEditedInfo</th>
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

<!--terminal modal-->
<div class="modal fade" id="terminal-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 450px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách Cảng chuyển</h5>
			</div>
			<div class="modal-body">
				<table id="tbl-terminal" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="GNRL_CODE">Mã</th>
							<th col-name="GNRL_NM">Tên</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($terminals) > 0) {$i = 1; ?>
						<?php foreach($terminals as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['GNRL_CODE'];?></td>
								<td><?=$item['GNRL_NM'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-terminal" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--select barge-->
<div class="modal fade" id="barge-modal" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn sà lan</h5>
			</div>
			<div class="modal-body">
				<table id="tbl-barge" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
					<tr>
						<th style="max-width: 15px">STT</th>
						<th>Mã sà lan</th>
						<th>Tên sà lan</th>
						<th>Năm</th>
						<th>Chuyến</th>
					</tr>
					</thead>
					<tbody>
					<?php if(count($barges) > 0) {$i = 1; ?>
						<?php foreach($barges as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['ShipID'];?></td>
								<td><?=$item['ShipName'];?></td>
								<td><?=$item['ShipYear'];?></td>
								<td><?=$item['ShipVoy'];?></td>
							</tr>
						<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-barge" data-dismiss="modal">
					<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
				<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
					<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
			</div>
		</div>
	</div>
</div>

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="groups-modalLabel" aria-hidden="true">
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
										<option value="2018" >2018</option>
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
							<th>YARD_CLOSE</th>
							<th>LaneID</th>
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
<div class="modal fade" id="cargotype-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
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
							<?php
							if (array_search("*",  array_column($cargoTypes, "Code")) === false) {
								array_unshift($cargoTypes, array("Code" => "*", "Description" => "*"));
							}
							?>
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

<script type="text/javascript">
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function (){
		var _colsOrder = ["STT", "OrderNo", "IssueDate", "ExpDate", "ShipInfo", "BLNo", "SHIPPER_NAME", "CusID", "PAYMENT_TYPE"
							, "CJModeName", "InvNo", "DRAFT_INV_NO", "BookingUnlinkable"];

		var _colsCont = ["rowguid", "STT", "BookingNo", "DELIVERYORDER", "CntrNo", "LocalSZPT", "ISO_SZTP", "OprID", "ShipInfo"
							, "POD", "FPOD", "CARGO_TYPE", "CmdID", "SealNo", "SealNo1", "IsLocal", "bXNVC", "FDate", "Transist", "TERMINAL_CD", "NameDD"
							, "PersonalID", "Email", "BargeInfo", "Note", "CMDWeight", "Temperature", "Vent", "Vent_Unit", "CLASS"
							, "UNNO", "Retlocation", "FreeDays", "ShipEditedInfo"];
		var _colCargoType = ["STT", "Code", "Description"];

							//ShipEditedInfo: shipkey;shipid;imvoy;exvoy

		var _result = [], tblOrder = $("#tbl-ord"), tblConts = $("#tbl-conts"), tblTerminal = $("#tbl-terminal"), tblBarge = $("#tbl-barge"),
			tblShips = $("#search-ship"), tblCargoType = $('#tblCargoType'),
			cargoTypeModal = $('#cargotype-modal'),
			cargoTypeSource = [];;
		var ordType = '';
		var _transists = <?= $transists; ?>,
			_oprs = [], _ports = [],
			_terminals = <?= json_encode($terminals); ?>,
			_localForeign = [
				{ "Code": "L", "Name": "Nội" },
				{ "Code": "F", "Name": "Ngoại" }
			];

		<?php if (isset($cargoTypes) && count($cargoTypes) > 0) { ?> cargoTypeSource = <?= json_encode($cargoTypes); ?>;
		<?php } ?>

        var oldNote4bXNVC = "";
        search_ship();

		tblTerminal.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false,
            keys:true,
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

		tblBarge.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false,
            keys:true,
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

		tblConts.DataTable({
			columnDefs: [
				{ type: "num", className: "text-center" , targets: _colsCont.indexOf("STT") },
				{ className: "hiden-input", targets: _colsCont.getIndexs(["rowguid", "ShipEditedInfo"]) },
				{ className: "show-more", targets: _colsCont.getIndexs(["TERMINAL_CD", "BargeInfo", "ShipInfo"]) },
				{ className: "show-dropdown", targets: _colsCont.indexOf("Transist") },
				{ className: "text-center", targets: _colsCont.getIndexs(["ISO_SZTP", "bXNVC"]) },
				{
					 className: "text-center show-dropdown"
					,targets: _colsCont.getIndexs(["LocalSZPT", "OprID", "POD", "FPOD", "IsLocal"])
				},
				{ className: "text-center hiden-input", targets: _colsCont.indexOf("FDate") },
				{ 
					className: "text-right"
					, render: $.fn.dataTable.render.number( ',', '.', 2)
					, targets: _colsCont.getIndexs(["CMDWeight", "Vent"])
				},
				{
					className: "text-center show-more",
					targets: _colsCont.indexOf("CARGO_TYPE"),
					render: function(data, type, full, meta) {
						let desc = cargoTypeSource.filter(p => p.Code.trim().toUpperCase() == String(data).trim().toUpperCase()).map(x => x.Description)[0];
						return desc || data;
					}
				},
				{
					targets: _colsCont.getIndexs(["CmdID"]),
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					}
				}
			],
			info: false,
			paging: false,
			searching: false,
			keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: {
				style: 'multi+shift',
				info: false
			},
			buttons: [],
			scrollY: '27vh',
			createdRow: function( row, data, dataIndex ){
				if( ordType == "NH" ){
					$(tblConts.DataTable().tables().header().to$())
						.find("th:eq("+ _colsCont.indexOf("bXNVC") +"), th:eq("+ _colsCont.indexOf("CLASS") +"), th:eq("+ _colsCont.indexOf("UNNO") +")")
						.removeClass("hiden-input");
					$(tblConts.DataTable().tables().header().to$())
						.find("th:eq("+ _colsCont.indexOf("FDate") +")")
						.addClass("hiden-input");
					$(tblConts.DataTable().cells(null, _colsCont.getIndexs(["bXNVC", "CLASS", "UNNO"]) ).nodes().to$()).removeClass("hiden-input");
					$(tblConts.DataTable().cells(null, _colsCont.indexOf("FDate") ).nodes().to$() ).addClass('hiden-input');
				}else{
					$(tblConts.DataTable().tables().header().to$())
						.find("th:eq("+ _colsCont.indexOf("bXNVC") +"), th:eq("+ _colsCont.indexOf("CLASS") +"), th:eq("+ _colsCont.indexOf("UNNO") +")")
						.addClass("hiden-input");
					$(tblConts.DataTable().tables().header().to$())
						.find("th:eq("+ _colsCont.indexOf("FDate") +")")
						.removeClass("hiden-input");

					$(tblConts.DataTable().cells(null, _colsCont.getIndexs(["bXNVC", "CLASS", "UNNO"]) ).nodes().to$()).addClass("hiden-input");
					$(tblConts.DataTable().cells(null, _colsCont.indexOf("FDate") ).nodes().to$() ).removeClass('hiden-input');
				}
			}
		});

		tblOrder.DataTable({
			columnDefs: [
				{
					 type: "num", className: "text-center"
					,targets: _colsOrder.indexOf("STT")
				},
				{
					className: "text-center",
					render: function(data, type, full, meta) {
						return data == "M" ? "Thu ngay" : (data == "C" ? "Thu sau" : "");
					},
					targets: _colsOrder.indexOf("PAYMENT_TYPE")
				},
				{
					visible: false, targets: _colsOrder.indexOf("BookingUnlinkable")
				},
			],
			// rowsGroup: _colsOrder.getIndexs(["STT", "EIRNo", "IssueDate", "ExpDate"
			// 									, "ShipInfo", "BLNo", "SHIPPER_NAME", "CusID", "PAYMENT_TYPE", "CJModeName"]),
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '19vh'
		});

		tblOrder.on('click', 'tbody tr', function(e){
        	var dtRow = tblOrder.DataTable().row($(this)).nodes().to$();

        	if( dtRow.hasClass("selected") ){
        		return;
        	}

        	tblOrder.DataTable().rows().nodes().to$().removeClass("selected");
        	dtRow.addClass("selected");

        	var selectedData = tblOrder.DataTable().rows(".selected").data().toArray();
        	var ordNo = selectedData.map(p=>p[_colsOrder.indexOf("OrderNo")])[0];
        	var expDate = selectedData.map(p=>p[_colsOrder.indexOf("ExpDate")])[0];
        	var paymentType = selectedData.map(p=>p[_colsOrder.indexOf("PAYMENT_TYPE")])[0];
        	var isBookingUnlinkable = selectedData.map(p=>p[_colsOrder.indexOf("BookingUnlinkable")])[0];

        	if( isBookingUnlinkable == '1' ){
        		$('#unlink-booking').show();
        	}
        	else {
        		$('#unlink-booking').hide();
        	}

        	var shipKey = _result.detail.filter( p=>p.OrderNo == ordNo ).map( x => x.ShipKey )[0];
        	getLane( shipKey );
        	loadGridDetail(ordNo, expDate);
        });

        tblConts.on('change', 'tbody tr td input[type="checkbox"]', function(e){
			var inp = $(e.target);

        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	if( inp.attr("name") == "bXNVC" ){
        		if( inp.is(':checked') ){
        			$.confirm({
						columnClass: 'col-md-5 col-md-offset-5',
		                title: 'Lý do hủy lệnh',
		                content: '<div class="form-group">'
		                            +'<textarea autofocus class="form-control form-control-sm font-size-14" id="cremark" placeholder="Nhập lý do hủy" rows=5></textarea>'
		                        +'</div>',
		                buttons: {
		                    ok: {
		                        text: 'Xác nhận hủy',
		                        btnClass: 'btn-sm btn-primary btn-confirm',
		                        keys: ['Enter'],
		                        action: function(){
		                            var input = this.$content.find('textarea#cremark');
		                            var errorText = this.$content.find('.text-danger');
		                            if(!input.val().trim()){
		                                $.alert({
		                                	title: "Thông báo",
		                                    content: "Vui lòng nhập lý do hủy lệnh!.",
		                                    type: 'red'
		                                });
		                                return false;
		                            }else{
		                            	var crCell = inp.closest('td'),
									        		 crRow = inp.closest('tr'),
									        		 cellNote = crRow.find("td:eq("+ _colsCont.indexOf("Note") +")"),
									        		 oldNote4bXNVC = cellNote.text(),
									        		 eTable = tblConts.DataTable();

							        	eTable.cell(crCell).data(crCell.html());
		                            	eTable.cell( cellNote ).data( input.val() );

							        	eTable.row(crRow).nodes().to$().addClass("editing");

		                            	// $(e.target).closest("tr").find("td:eq("+ _colsCont.indexOf("Note") +")").text( input.val() );
		                            }
		                        }
		                    },
		                    later: {
		                    	text: 'Quay lại',
		                    	btnClass: 'btn-sm',
		                    	keys: ['ESC'],
		                    	action: function(){
		                    		inp.prop("checked", false);
        							inp.val("0");
		                    	}
		                    }
		                }
		            });
        		}else{
        			var crCell = inp.closest('td'),
				        		 crRow = inp.closest('tr'),
				        		 cellNote = crRow.find("td:eq("+ _colsCont.indexOf("Note") +")"),
				        		 eTable = tblConts.DataTable();

		        	eTable.cell(crCell).data(crCell.html());
                	eTable.cell( cellNote ).data( oldNote4bXNVC );

		        	eTable.row(crRow).nodes().to$().addClass("editing");
        		}
        	}else{
        		var crCell = inp.closest('td'),
	        		crRow = inp.closest('tr'),
	        		eTable = tblConts.DataTable();

	        	eTable.cell(crCell).data(crCell.html());
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
		});
		
		tblConts.on('change', 'td', function(e)
		{
			var colidx = $(this).index();
			var colname = $(tblConts.DataTable().tables().header().to$()).find("th:eq(" + colidx + ")").attr("col-name");
	
		    if( colname == "CLASS" ){
		    	if( tblConts.DataTable().cell( $(e.target) ).data().length > 3 ){
					toastr["error"]("CLASS không vượt quá 3 ký tự!");
					tblConts.DataTable().cell( $(e.target) ).data('');
				}
			}

			if( colname == "UNNO" ){
		    	if( tblConts.DataTable().cell( $(e.target) ).data().length > 4 ){
					toastr["error"]("UNNO không vượt quá 4 ký tự!");
					tblConts.DataTable().cell( $(e.target) ).data('');
				}
			}
		});

        $('#ship-modal, #barge-modal, #terminal-modal, #cargotype-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

//------APPLY CARGO_TYPE FROM MODAL
		tblCargoType.find("tbody tr").on("dblclick", function() {
			var applyBtn = $("#apply-cargotype"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq(" + _colCargoType.indexOf("Code") + ")").text(),
				cell = tblConts.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblConts.DataTable();

			cell.removeClass("error");
			dtTbl.cell(cell).data(String(cgType).trim()).draw(false);

			var crRow = tblConts.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}

			cargoTypeModal.modal("hide");
		});

		$("#apply-cargotype").on("click", function() {
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cgType = tblCargoType.getSelectedRows().data().toArray()[0][_colCargoType.indexOf("Code")],
				cell = tblConts.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tblConts.DataTable();

			cell.removeClass("error");

			dtTbl.cell(cell).data(String(cgType).trim()).draw(false);
			var crRow = tblConts.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}
		});
//------APPLY CARGO_TYPE FROM MODAL

//------APPLY TERMINAL FROM MODAL
		tblTerminal.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-terminal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				terCode = $(this).find("td:eq(1)").text(),
				cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tblConts.DataTable();

			var temp = "<input type='text' value='"+ terCode +"' class='hiden-input'>"
							+ _terminals.filter( p=>p.GNRL_CODE == terCode ).map( x=>x.GNRL_NM )[0];

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			$("#terminal-modal").modal("hide");
		});

		$("#apply-terminal").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				terCode = tblTerminal.getSelectedRows().data().toArray()[0][1],
				cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tblConts.DataTable();

			var temp = "<input type='text' value='"+ terCode +"' class='hiden-input'>" 
							+ _terminals.filter( p=>p.GNRL_CODE == terCode ).map( x=>x.GNRL_NM )[0];

			cell.removeClass( "error" );
			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
//------APPLY TERMINAL FROM MODAL

//------APPLY BARGE FROM MODAL
		tblBarge.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-barge"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				bargeCode = $(this).find("td:eq(1)").text(),
				bargeYear = $(this).find("td:eq(3)").text(),
				bargeCallSeq = $(this).find("td:eq(4)").text(),
				cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tblConts.DataTable();

			var temp = bargeCode + "/" + bargeYear + "/" + bargeCallSeq;

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);
			
			var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			$("#barge-modal").modal("hide");
		});

		$("#apply-barge").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				bargeSelected = tblBarge.getSelectedRows().data().toArray()[0];
				bargeCode = bargeSelected[1],
				bargeYear = bargeSelected[3],
				bargeCallSeq = bargeSelected[4],
				cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tblConts.DataTable();

			var temp = bargeCode + "/" + bargeYear + "/" + bargeCallSeq;

			cell.removeClass( "error" );
			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
//------APPLY BARGE FROM MODAL

		// ------------button function-------------

		$('#reload').click(function(){
			if( !$("#ord-type").val() ){
				toastr["warning"]("Chưa chọn loại lệnh!");
				$("#ord-type").selectpicker('toggle');
				return;
			}

			if( !$("#ordNo").val() && !$("#cntrno").val() && !$("#pinCode").val() ){
				$(".toast").remove();
				toastr["error"]("Vui lòng nhập ít nhất 1 điều kiện để tìm kiếm!");
				if( !$("#ordNo").val() ){
					$("#ordNo").focus();
				}else{
					$("#cntrno").focus();
				}
				return;
			}

			var formData = {
				"action": "view",
				"act": "search",
				"ordNo": $("#ordNo").val(),
				"cntrNo": $("#cntrno").val(),
				"pinCode": $("#pinCode").val(),
				"ordType": $("#ord-type").val()
			};

			var btn = $(this);
			btn.button("loading");

			tblConts.dataTable().fnClearTable();
			tblOrder.waitingLoad();
			_result = [];

			$('#unlink-booking').hide();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskUpdateOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					btn.button("reset");

					if( data.deny ){
						toastr["error"](data.deny);
						return;
					}

					ordType = formData.ordType;

					tblConts.DataTable().columns.adjust();

					var rows = [];
		        	if( data.list )
		        	{
						_result = data.list;

						if( _result.header ){
							var i = 0;
				        	$.each( _result.header, function(index, rData){
				        		var r = [];
								$.each( _colsOrder, function(idx, colname){
									var val = "";
									switch( colname ){
										case "STT":
											if( rows.map( p=>p[ _colsOrder.indexOf("OrderNo") ] ).indexOf( rData['OrderNo'] ) == -1 ){
												i++;
											}
											val = i;
											break;
										case "ExpDate":
										case "IssueDate":
											val = rData[ colname ] ? getDateTime( rData[ colname ] ) : "";
											break;
										case "ShipInfo":
											val = ( rData[ "ShipName" ] ? rData[ "ShipName" ] : "")
													+ "/" + (rData[ "ImVoy" ] ? rData[ "ImVoy" ] : "")
													+ "/" + (rData[ "ExVoy" ] ? rData[ "ExVoy" ] : "");
											break;
										default:
											val = rData[colname] ? rData[colname] : "";
											break;
									}

									r.push(val);
								});

								rows.push(r);
				        	});
						}
		        	}

		        	tblOrder.dataTable().fnClearTable();

		        	if(rows.length > 0){
						tblOrder.dataTable().fnAddData(rows);
					}
				},
				error: function(err){
					btn.button("reset");

					tblOrder.dataTable().fnClearTable();

					console.log(err);
				}
			});
		});

		$('#unlink-booking').on('click', function(){
			var selectedData = tblConts.getSelectedData();
			if( selectedData.length == 0 ){
				toastr.warning('Chọn ít nhất 1 dòng dữ liệu để thực hiện thao tác');
				return;
			}

			$.confirm({
	            title: 'Thông báo!',
	            type: 'orange',
	            icon: 'fa fa-warning',
	            content: 'Xác nhận thao tác huỷ lệnh của container đang được chọn?',
	            buttons: {
	                ok: {
	                    text: 'Xác nhận lưu',
	                    btnClass: 'btn-warning',
	                    keys: ['Enter'],
	                    action: function(){
	                        unlinkBooking(selectedData);
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

		$("#save").click(function(){
			if( tblConts.DataTable().rows( '.editing' ).data().toArray().length == 0 ){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
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
            }
		});

		function saveData()
		{
			var editData = mapDataAgain( tblConts.getEditData() );
			var CntrNos = editData.filter( p=>p.bXNVC == "1" ).map( x => x.CntrNo );
			var CntrNo = "";

			// CntrNos.forEach(function (item, key) {
			// 	CntrNo += item + ', ';
			// 	removeByAttr(editData, 'CntrNo', item);					
			// })

			// if(CntrNo.length > 10) {
			// 	toastr["error"]("Containers " + CntrNo + "không được phép sửa đổi vì đã hoàn tất.");
			// }			

			if(editData.length == 0) {
				return;
			}

			var formData = {
				'action': 'edit',
				'data': editData,
				'ordType': ordType
			};

			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Task') . '/' . md5('tskUpdateOrder'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(data.error) {
                        toastr["error"](data.error);
                        return;
					}
					
					if( data.no_ordType ){
						toastr["error"](data.no_ordType);
                        return;
					}

                    toastr["success"]("Cập nhật thành công!");
                    tblConts.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");

                    tblConts.DataTable().cells('.error').nodes().to$().removeClass("error");
                },
                error: function(err){
                	toastr["error"]("What happen!");
                	saveBtn.button('reset');
                	$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		function unlinkBooking(data)
		{
			var dt = data.map( p => {
				return {
					rowguid: p[ _colsCont.indexOf("rowguid") ],
					BookingNo: p[ _colsCont.indexOf("BookingNo") ],
					OprID: p[ _colsCont.indexOf("OprID") ],
					LocalSZPT: p[ _colsCont.indexOf("LocalSZPT") ],
					ISO_SZTP: p[ _colsCont.indexOf("ISO_SZTP") ],
					CntrNo: p[ _colsCont.indexOf("CntrNo") ],
				}
			});
			
			var formData = {
				'action': 'edit',
				'act': 'unlink-booking',
				'data': dt,
				'ordType': ordType
			};

			var btn = $('#unlink-booking');
			btn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Task') . '/' . md5('tskUpdateOrder'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    btn.button('reset');
        			$('.ibox.collapsible-box').unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(!data.success) {
                        toastr["error"]('Thao tác thất bại');
                        return;
					}

                    toastr["success"]("Hoàn tất gỡ!");
                },
                error: function(err){
                	toastr["error"]("What happen!");
                	btn.button('reset');
                	$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		function loadGridDetail( ordNo, expDate ){
			var detailData = _result.detail.filter( p=>p.OrderNo == ordNo && getDateTime(p.ExpDate) == expDate );
			var rows = [];

			if( detailData.length > 0 )
        	{
				var i = 1;
	        	$.each( detailData, function(index, rData){
	        		var r = [];
					$.each( _colsCont, function(idx, colname){
						var val = "";
						switch( colname ){
							case "STT":
								val = i++;
								break;
							case "IsLocal":
								val = rData[ colname ] == "F" ? "Ngoại" : "Nội";
								break;
							case "bXNVC":
								val= '<label class="checkbox checkbox-primary">'
										+'<input type="checkbox" name="bXNVC" value="'+ rData[colname] +'" '+ (rData[colname]==1?"checked":"") +'>'
										+'<span class="input-span"></span>'
									+'</label>';
								break;
							case "ShipInfo":
								val = ( rData[ "ShipName" ] ? rData[ "ShipName" ] : "")
										+ "/" + (rData[ "ImVoy" ] ? rData[ "ImVoy" ] : "")
										+ "/" + (rData[ "ExVoy" ] ? rData[ "ExVoy" ] : "");
								break;
							case "FDate":
								val = rData[ colname ] ? getDateTime(rData[ colname ]) : "";
								break;
							default:
								val = rData[colname] ? rData[colname] : "";
								break;
						}

						r.push(val);
					});

					rows.push(r);
	        	});
        	}

        	tblConts.dataTable().fnClearTable();

        	if(rows.length > 0){
        		tblConts.dataTable().fnAddData( rows );
        	}
		}

		function getLane(shipkey){
			
			$('.ibox.collapsible-box').blockUI();

			var formdata = {
				'action': 'view',
				'act': 'getLane',
				'shipkey': shipkey
			};
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskUpdateOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					_oprs = data.oprs;
					_ports = data.ports;

					extendSelectOnGrid();

					$('.ibox.collapsible-box').unblock();
				},
				error: function(err){console.log(err);}
			});
		}

		function extendSelectOnGrid(){

			//------SET AUTOCOMPLETE
				var tblContsHeader = tblConts.parent().prev().find('table');

				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'OprID' ) + ') ').setSelectSource( _oprs.map(p=>p.CusID) );
				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'IsLocal' ) + ') ').setSelectSource( _localForeign.map(p=>p.Name) );
				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'LocalSZPT' ) + ') ').setSelectSource( _result.sizeTypes.map(p=>p.LocalSZPT) );

				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'POD' ) + ') ').setSelectSource( _ports.map(p=>p.Port_CD) );
				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'FPOD' ) + ') ').setSelectSource( _ports.map(p=>p.Port_CD) );
				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'Transist' ) + ') ').setSelectSource( _transists.map(p=>p.Transit_Name) );
				tblContsHeader.find(' th:eq(' + _colsCont.indexOf( 'TERMINAL_CD' ) + ') ').setSelectSource( _terminals.map(p=>p.GNRL_NM) );
			//------SET AUTOCOMPLETE

			//------SET MORE BUTTON FOR COLUMNS
				tblConts.moreButton({
					columns: _colsCont.getIndexs(["ShipInfo", "TERMINAL_CD", "BargeInfo", "CARGO_TYPE"]),
					onShow: function( cell ){
						var cellIdx = cell.parent().index();
						$("#select-ship").val( cellIdx + "." + _colsCont.indexOf( "ShipInfo" ) );
						$("#apply-terminal").val( cellIdx + "." + _colsCont.indexOf( "TERMINAL_CD" ) );
						$("#apply-barge").val( cellIdx + "." + _colsCont.indexOf( "BargeInfo" ) );
						$("#apply-cargotype").val(cellIdx + "." + _colsCont.indexOf("CARGO_TYPE"));
					}
				});
			//------SET MORE BUTTON FOR COLUMNS

			//------SET DROPDOWN BUTTON FOR COLUMN
			tblConts.columnDropdownButton({
				data:[
					{ colIndex: _colsCont.indexOf( "OprID" ), source: _oprs.map( p=>p.CusID ) },
					{ colIndex: _colsCont.indexOf( "IsLocal" ), source: _localForeign },
					{ colIndex: _colsCont.indexOf( "LocalSZPT" ), source: _result.sizeTypes.map(p=>p.LocalSZPT) },
					{ colIndex: _colsCont.indexOf( "POD" ), source: _ports.map( p => p.Port_CD ) },
					{ colIndex: _colsCont.indexOf( "FPOD" ), source: _ports.map( p => p.Port_CD ) },
					{ colIndex: _colsCont.indexOf( "Transist" ), source: _transists.map( p => p.Transit_Name ) },
				],
				onSelected: function(cell, itemSelected){
					var temp = "<input type='text' value='"+ itemSelected.attr("code") +"' class='hiden-input'>" + itemSelected.text();
					tblConts.DataTable().cell(cell).data(temp).draw(false);
					if(tblConts.DataTable().cell( cell).index().column == _colsCont.indexOf("LocalSZPT")) {
						tblConts.DataTable().cell( cell.parent().index(), cell.next() ).data(_result.sizeTypes.filter( p=>p.LocalSZPT == itemSelected.text() ).map( x => x.ISO_SZTP )).draw(false);
					}					
					tblConts.DataTable().cell( cell.parent().index(), cell.next() ).focus();
					if(!cell.parent().hasClass("addnew")){
						cell.parent().addClass("editing");
					}					
				}
			});
			//------SET DROPDOWN BUTTON FOR COLUMN

			tblConts.editableTableWidget();
		}

		//------FUNCTION
		function mapDataAgain( data ){
        	$.each( data, function(){
				if ( _transists.filter( p => p.Transit_CD == this["Transist"] ).length == 0 )
				{
					this["Transist"] = _transists.filter( p => p.Transit_Name == this["Transist"] ).map( x => x.Transit_CD )[0];
				}

				if ( _terminals.filter( p => p.GNRL_CODE == this["TERMINAL_CD"] ).length == 0 )
				{
					this["TERMINAL_CD"] = _terminals.filter( p => p.GNRL_NM == this["TERMINAL_CD"] ).map( x => x.GNRL_CODE )[0];
				}

				if ( _localForeign.filter( p => p.Code == this["IsLocal"] ).length == 0 )
				{
					this["IsLocal"] = _localForeign.filter( p => p.Name == this["IsLocal"] ).map( x => x.Code )[0];
				}
			} );

			return data;
		}
		
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
			var that = $(this);
			var yardClosingTime = $(r).find('td:eq(10)').text();
			if( yardClosingTime && ( new Date().getTime() > new Date(yardClosingTime).getTime() ) ){
				$.confirm({
		            title: 'Cảnh báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Container quá thời gian Closing time, bạn có muốn tiếp tục ?',
		            buttons: {
		                ok: {
		                    text: 'Tiếp tục',
		                    btnClass: 'btn-primary',
		                    keys: ['Enter'],
		                    action: function(){
		                    	var rIdx = that.val().split(".")[0],
									cIdx = that.val().split(".")[1],
									cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
									dtTbl = tblConts.DataTable();

								var temp = $(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text();

								cell.removeClass( "error" );
								dtTbl.cell(cell).data(temp).draw(false);

								var shipEditedInfor = $(r).find('td:eq(6)').text() + ';' + $(r).find('td:eq(0)').text() + ';' + $(r).find('td:eq(3)').text() + ';' + $(r).find('td:eq(4)').text();
														//ShipEditedInfo: shipkey;shipid;imvoy;exvoy
								var shipEditedInfoCell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+ _colsCont.indexOf('ShipEditedInfo') +")").first();
								dtTbl.cell(shipEditedInfoCell).data( shipEditedInfor ).draw(false);

								var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
								if(!crRow.hasClass("addnew")){
									dtTbl.row(crRow).nodes().to$().addClass("editing");
								}
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC'],
		                    action: function(){
		                    	$('#ship-modal').modal("show");
		                    }
		                }
		            }
		        });
			}
			else{
				var rIdx = $(this).val().split(".")[0],
					cIdx = $(this).val().split(".")[1],
					cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tblConts.DataTable();

				var temp = $(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text();

				cell.removeClass( "error" );
				dtTbl.cell(cell).data(temp).draw(false);

				var shipEditedInfor = $(r).find('td:eq(6)').text() + ';' + $(r).find('td:eq(0)').text() + ';' + $(r).find('td:eq(3)').text() + ';' + $(r).find('td:eq(4)').text();
										//ShipEditedInfo: shipkey;shipid;imvoy;exvoy
				var shipEditedInfoCell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+ _colsCont.indexOf('ShipEditedInfo') +")").first();
				dtTbl.cell(shipEditedInfoCell).data( shipEditedInfor ).draw(false);

				var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
				if(!crRow.hasClass("addnew")){
					dtTbl.row(crRow).nodes().to$().addClass("editing");
				}
			}
		});

		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			var applyBtn = $("#select-ship");
			var yardClosingTime = $(r).find('td:eq(10)').text();

			if( yardClosingTime && ( new Date().getTime() > new Date(yardClosingTime).getTime() ) ){
				$.confirm({
		            title: 'Cảnh báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Container quá thời gian Closing time, bạn có muốn tiếp tục ?',
		            buttons: {
		                ok: {
		                    text: 'Tiếp tục',
		                    btnClass: 'btn-primary',
		                    keys: ['Enter'],
		                    action: function(){
		                    	var rIdx = $(applyBtn).val().split(".")[0],
									cIdx = $(applyBtn).val().split(".")[1],
									cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
									dtTbl = tblConts.DataTable();

								var temp = $(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text();

								cell.removeClass( "error" );
								dtTbl.cell(cell).data(temp).draw(false);

								var shipEditedInfor = $(r).find('td:eq(6)').text() + ';' + $(r).find('td:eq(0)').text() + ';' + $(r).find('td:eq(3)').text() + ';' + $(r).find('td:eq(4)').text();
														//ShipEditedInfo: shipkey;shipid;imvoy;exvoy
								var shipEditedInfoCell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+ _colsCont.indexOf('ShipEditedInfo') +")").first();
								dtTbl.cell(shipEditedInfoCell).data( shipEditedInfor ).draw(false);

								var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
								if(!crRow.hasClass("addnew")){
									dtTbl.row(crRow).nodes().to$().addClass("editing");
								}
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC'],
		                    action: function(){
								$('#ship-modal').modal("show");
		                    }
		                }
		            }
		        });
			}
			else{
				var rIdx = $(applyBtn).val().split(".")[0],
					cIdx = $(applyBtn).val().split(".")[1],
					cell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tblConts.DataTable();

				var temp = $(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text();

				cell.removeClass( "error" );
				dtTbl.cell(cell).data(temp).draw(false);

				var shipEditedInfor = $(r).find('td:eq(6)').text() + ';' + $(r).find('td:eq(0)').text() + ';' + $(r).find('td:eq(3)').text() + ';' + $(r).find('td:eq(4)').text();
										//ShipEditedInfo: shipkey;shipid;imvoy;exvoy
				var shipEditedInfoCell = tblConts.find("tbody tr:eq("+rIdx+") td:eq("+ _colsCont.indexOf('ShipEditedInfo') +")").first();
				dtTbl.cell(shipEditedInfoCell).data( shipEditedInfor ).draw(false);

				var crRow = tblConts.find("tbody tr:eq("+rIdx+")");
				if(!crRow.hasClass("addnew")){
					dtTbl.row(crRow).nodes().to$().addClass("editing");
				}				
			}

			$('#ship-modal').modal("hide");
		});

		$('#unselect-ship').on('click', function () {
			$('#shipid').val('');
		});

		$('#reload-ship').on("click", function(){
			$('#search-ship-name').val("");
			search_ship();
		});

		$("#cb-searh-year").val( (new Date()).getFullYear() ).selectpicker("refresh");

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
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
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
								, data.vsls[i].YARD_CLOSE ? data.vsls[i].YARD_CLOSE : ""
								, data.vsls[i].LaneID
							]);
						}
					}
					$('#search-ship').DataTable( {
						scrollY: '35vh',
						paging: false,
						order: [[ 1, 'asc' ]],
						columnDefs: [
							{ className: "input-hidden", targets: [0, 6, 7, 10, 11] },
							{ className: "text-center", targets: [1] }
						],
						buttons: [],
						info: false,
						searching: false,
						data: rows
					} );
				},
				error: function(err){console.log(err);}
			});
		}
///////// END SEARCH SHIP

		var removeByAttr = function(arr, attr, value){
			var i = arr.length;
			while(i--){
				if( arr[i]
					&& arr[i].hasOwnProperty(attr)
					&& (arguments.length > 2 && arr[i][attr] === value ) ){

					arr.splice(i,1);

				}
			}
			return arr;
		}
		
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>