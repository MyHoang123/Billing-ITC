<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
<style>
	.hidden-filter{
		display: none;
	}
	.wrap-text{
		white-space: normal!important;
	}

	button[data-id="temp"] span.filter-option{
		padding-right: 15px;
	}

	#unitcodes-modal .dataTables_filter,
	#cargotype-modal .dataTables_filter
	{
		width: 200px;
	}
	#unitcodes-modal .dataTables_filter input[type="search"],
	#cargotype-modal .dataTables_filter input[type="search"]
	{
		width: 65%;
	}

	#unitcodes-modal .dataTables_filter > label::after,
	#cargotype-modal .dataTables_filter > label::after
	{
		right: 45px!important;
	}

	.readonly-temp input{
		border-top: none!important;
		border-left: none!important;
		border-right: none!important;
		border-bottom: 1px dotted #ccc !important;
		cursor: default!important;
	}

	span.sub-text{
		font-size: 75%;
	    color: #bbb;
	    font-style: italic;
	    padding-left: 10px;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BIỂU CƯỚC CHUẨN</div>
				<div class="button-bar-group mr-3">
					<a class="linked col-form-label text-primary" href="<?=site_url(md5('Contract_Tariff') . '/' . md5('downloadTariffStandardTemp'));?>" style="padding-right: 10px;" target="_blank">Tải tệp mẫu</a>
					<button id="import-file" class="btn btn-outline-secondary btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="ti-import"></i>Nạp file Excel</span>
					</button>
					<input type="file" id="input-file" style="display: none;">

					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" 
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-xl-1 col-lg-1 col-2 col-form-label">Mẫu</label>
							<select id="temp" class="selectpicker col-6" data-style="btn-default btn-sm" data-live-search="true">
								<option value="">-- Chọn mẫu biểu cước --</option>
								<?php if(isset($temp) && count($temp) > 0){ foreach ($temp as $item){ ?>
									<option value="<?= $item ?>"><?= $item ?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row border-e bg-white readonly-temp" id="temp_info" style="border-top: none!important;">
					<div class="col-12 mt-3">
						<div class="row">
							<div class="col-xl-4 col-lg-6">
								<div class="form-group">
									<div class="input-group">
										<label class="col-form-label mr-2" style="white-space: nowrap;">Hiệu lực</label>
										<input class="form-control form-control-sm input-required" id="fromDate" type="text" placeholder="Hiệu lực từ" style="min-width: 35%" readonly>
										<label class="col-form-label mx-2">đến</label>
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="toDate" type="text"  placeholder="Hiệu lực đến" readonly>
											<span class="input-group-addon bg-white btn text-success" title="Không xác định" style="padding: 0 .4rem">ALL</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-lg-6">
								<div class="form-group">
									<div class="input-group">
										<label class="col-form-label mr-2" style="white-space: nowrap;">Tham chiếu</label>
										<input class="form-control form-control-sm" id="ref_mrk" type="text" placeholder="Tham chiếu" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="padding: 16px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
							<thead>
							<tr>
								<th col-name="rowguid" class="hiden-input">rowguid</th>
								<th col-name="STT" class="editor-cancel">STT</th>
								<th col-name="TRF_CODE" class="autocomplete" show-target="#trfcodes-modal">Mã biểu cước</th>
								<th col-name="TRF_STD_DESC">Diễn giải</th>
								<th col-name="IX_CD" class="autocomplete">Hướng cont</th>
								<th col-name="CARGO_TYPE" class="autocomplete" show-target="#cargotype-modal">Loại hàng</th>
								<th col-name="JOB_KIND" class="editor-cancel" show-target="#alljob-modal">Loại CV</th>
								<th col-name="CNTR_JOB_TYPE" class="editor-cancel" show-target="#cjmode-modal" >Phương án</th>
								<th col-name="DMETHOD_CD" class="autocomplete" show-target="#dmethod-modal">PTGN</th>
								<th col-name="TRANSIT_CD" class="autocomplete">Loại hình</th>
								<th col-name="IsLocal" class="autocomplete">Nội/Ngoại</th>
								<th col-name="CURRENCYID" class="autocomplete">Loại tiền</th>
								<th col-name="AMT_F20" class="data-type-numeric">Tiền 20 Full</th>
								<th col-name="AMT_F40" class="data-type-numeric">Tiền 40 Full</th>
								<th col-name="AMT_F45" class="data-type-numeric">Tiền 45 Full</th>
								<th col-name="AMT_E20" class="data-type-numeric">Tiền 20 Empty</th>
								<th col-name="AMT_E40" class="data-type-numeric">Tiền 40 Empty</th>
								<th col-name="AMT_E45" class="data-type-numeric">Tiền 45 Empty</th>
								<th col-name="AMT_NCNTR" class="data-type-numeric">Tiền Non-Cont</th>
								<th col-name="INCLUDE_VAT" class="editor-cancel data-type-checkbox">Bao gồm thuế</th>
								<th col-name="VAT">VAT (%)</th>
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

<!--trfcodes modal-->
<div class="modal fade" id="trfcodes-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 600px; max-width: 600px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách [Mã Biểu Cước]</h5>
			</div>
			<div class="modal-body">
				<table id="tblTRFCode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="TRF_CODE">Mã</th>
							<th col-name="TRF_STD">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($trfCodes) > 0) {$i = 1; ?>
						<?php foreach($trfCodes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['TRF_CODE'];?></td>
								<td><?=$item['TRF_DESC'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-trfcode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--CJMODE modal-->
<div class="modal fade" id="cjmode-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 600px; max-width: 600px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách [Phương Án]</h5>
			</div>
			<div class="modal-body">
				<table id="tblCJMode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="CJMode_CD">Mã</th>
							<th col-name="CJModeName">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($cjModes) > 0) {$i = 1; ?>
						<?php
							if( !array_search("*",  array_column($cjModes, "Code")) ){
								array_unshift( $cjModes , array( "CJMode_CD" => "*", "CJModeName" => "*" ) );
							}
						?>
						<?php foreach($cjModes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['CJMode_CD'];?></td>
								<td><?=$item['CJModeName'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-cjmode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--alljob modal-->
<div class="modal fade" id="alljob-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 600px; max-width: 600px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách [Loại Công Việc]</h5>
			</div>
			<div class="modal-body">
				<table id="tbl-alljob" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="Code">Mã CV</th>
							<th col-name="Name">Tên CV Cổng / Bãi / Tàu</th>
						</tr>
					</thead>
					<tbody>
					<?php if(isset($alljob) && count($alljob) > 0) {$i = 1; ?>
						<?php foreach($alljob as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['Code'];?></td>
								<td><?=$item['Name'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-alljob" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--unicodes modal-->
<div class="modal fade" id="unitcodes-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách đơn vị tính</h5>
			</div>
			<div class="modal-body">
				<table id="tblUnitCode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="UNIT_CODE">Mã</th>
							<th col-name="UNIT_NM">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($unitCodes) > 0) {$i = 1; ?>
						<?php foreach($unitCodes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['UNIT_CODE'];?></td>
								<td><?=$item['UNIT_NM'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-unitcode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--cargo type modal-->
<div class="modal fade" id="cargotype-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
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
					<?php if(count($cargoTypes) > 0) {$i = 1; ?>
						<?php
							if( !array_search("*",  array_column($cargoTypes, "Code")) ){
								array_unshift( $cargoTypes , array( "Code" => "*", "Description" => "*" ) );
							}
						?>
						<?php foreach($cargoTypes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['Code'];?></td>
								<td><?=$item['Description'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-cargotype" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--dmethod modal-->
<div class="modal fade" id="dmethod-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="groups-modalLabel"
						aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách [Phương Thức]</h5>
			</div>
			<div class="modal-body">
				<table id="tbl-dmethod" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="DMethod_CD">Mã</th>
							<th col-name="DMethod_Name">Tên</th>
						</tr>
					</thead>
					<tbody>
					<?php if( isset( $dmethods ) && count($dmethods) > 0) {$i = 1; ?>
						<?php foreach($dmethods as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['DMethod_CD'];?></td>
								<td><?=$item['DMethod_Name'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-dmethod" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="cell-context1" class="btn-group cell-dropdown" style="display: none;">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
	  						aria-haspopup="true" aria-expanded="false">
	</button>
	<div class="dropdown-menu dropdown-menu-right">
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		// ------------binding shortcut key press------------
        var ctrlKey = 17,
	        cmdKey = 91,
	        rKey = 82,
	        ctrlDown = false;

	    $(document).keydown(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
	    }).keyup(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
	    });

	    $(document).keydown(function(e) {
	        if (ctrlDown && e.keyCode == rKey){
	        	alert('reload filter');
	        	return false;
	        } 
	    });

//------DECLARE VARIABLES
		var _columns = ["rowguid", "STT", "TRF_CODE", "TRF_STD_DESC", "IX_CD", "CARGO_TYPE", "JOB_KIND", "CNTR_JOB_TYPE", "DMETHOD_CD"
						, "TRANSIT_CD", "IsLocal", "CURRENCYID", "AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45"
						, "AMT_NCNTR", "INCLUDE_VAT", "VAT"],
			_colTRF = ["STT", "TRF_CODE", "TRF_DESC"],
			_colUnit = ["STT", "UNIT_CODE", "UNIT_NM"],
			_colCargoType = ["STT", "Code", "Description"],
			_colCJModes = ["STT", "CJMode_CD", "CJModeName"],
			_colAllJobs = ["STT", "Code", "Name"],
			_colDMethods = ["STT", "DMethod_CD", "DMethod_Name"],

			tbl = $('#contenttable'),
			tblUnitCode = $('#tblUnitCode'),
			tblTRFCode = $('#tblTRFCode'),
			tblCargoType = $('#tblCargoType'),
			tblCJMode = $('#tblCJMode'),
			tblAllJob = $('#tbl-alljob'),
			tblDmethod = $('#tbl-dmethod'),

			unicodeModal = $('#unitcodes-modal'),
			trfCodeModal = $('#trfcodes-modal'),
			cargoTypeModal = $('#cargotype-modal'),
			cjModeModal = $('#cjmode-modal'),
			alljobModal = $('#alljob-modal'),
			dmethodModal = $('#dmethod-modal'),

			unitSource = [],
			cntrClassSource = [],
			cargoTypeSource = [],
			dmethodSource = [],
			transitSource = [],
			trfSource = [],
			isLocalSource = [
				{
					Code : "*",
					Name : "*"
				},
				{
					Code : "L",
					Name : "Nội"
				},
				{
					Code : "F",
					Name : "Ngoại"
				}
			],
			currencySource = [
				{
					Code : "VND",
					Name : "VNĐ"
				},
				{
					Code : "USD",
					Name : "USD"
				}
			];
//------DECLARE VARIABLES

//------INIT TABLES
		var dataTbl = tbl.DataTable({
			scrollY: '70vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center", targets: _columns.indexOf("INCLUDE_VAT") },
				{ 
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 2),
					targets: _columns.getIndexs(["AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45", "VAT"])
				},
				{ 
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 5),
					targets: _columns.indexOf("AMT_NCNTR")
				},
				{ className: "hiden-input", targets: _columns.indexOf("rowguid") },
				{ className: "show-more", targets: _columns.getIndexs(["TRF_CODE", "CARGO_TYPE", "JOB_KIND","CNTR_JOB_TYPE", "DMETHOD_CD"]) },
				{ className: "show-dropdown", targets: _columns.getIndexs(["IX_CD", "TRANSIT_CD", "IsLocal", "CURRENCYID"]) },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _columns.indexOf("TRF_STD_DESC")
				}
			],
			order: [],
            keys:true,
            autoFill: {
                focus: 'focus'
            },
        	paging: true,
			scroller: {
				displayBuffer: 12,
				boundaryScale: 0.5
			},
            select: true,
            rowReorder: false
		});

		tblTRFCode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colTRF.indexOf("STT") },
				{ className: "text-center", targets: _colTRF.indexOf("TRF_CODE") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _colTRF.indexOf("TRF_DESC")
				}
			],
			order: [[ _colTRF.indexOf("STT"), 'asc' ]],
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

		tblCJMode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colCJModes.indexOf("STT") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _colCJModes.indexOf("CJModeName")
				}
			],
			order: [[ _colCJModes.indexOf("STT"), 'asc' ]],
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

		tblAllJob.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colAllJobs.indexOf("STT") },
				{ className: "text-center", targets: _colAllJobs.indexOf("Code") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colAllJobs.indexOf("Name")
				}
			],
			order: [[ _colTRF.indexOf("STT"), 'asc' ]],
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

		tblUnitCode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colUnit.indexOf("STT") }
			],
			order: [[ _colUnit.indexOf("STT"), 'asc' ]],
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
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colCargoType.indexOf("STT") }
			],
			order: [[ _colCargoType.indexOf("STT"), 'asc' ]],
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

		tblDmethod.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colDMethods.indexOf("STT") }
			],
			order: [[ _colDMethods.indexOf("STT"), 'asc' ]],
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
//------INIT TABLES

//------GET SOURCE DATA
		<?php if(isset($unitCodes) && count($unitCodes) > 0){ ?>
			unitSource = <?= json_encode(array_column($unitCodes, "UNIT_CODE"));?>;
		<?php } ?>

		<?php if(isset($trfCodes) && count($trfCodes) > 0){ ?>
			trfSource = <?= json_encode($trfCodes);?>;
		<?php } ?>

		<?php if(isset($cargoTypes) && count($cargoTypes) > 0){ ?>
			cargoTypeSource = <?= json_encode( $cargoTypes );?>;
		<?php } ?>

		<?php if(isset($cntrClass) && count($cntrClass) > 0){ ?>
			cntrClassSource = <?= json_encode($cntrClass);?>;
		<?php } ?>

		<?php if(isset($dmethods) && count($dmethods) > 0){ ?>
			dmethodSource = <?= json_encode($dmethods);?>;
		<?php } ?>

		<?php if(isset($transits) && count($transits) > 0){ ?>
			transitSource = <?= json_encode($transits);?>;
		<?php } ?>

		if( dmethodSource.filter( p=>p.DMethod_CD == "*" ).length == 0 ){
			dmethodSource.unshift({"DMethod_CD": "*", "DMethod_Name": "*"});
		}

		if( cargoTypeSource.filter( p=>p.Code == "*" ).length == 0 ){
			cargoTypeSource.unshift({"Code": "*", "Description": "*"});
		}

		if( transitSource.filter( p=>p.Transit_CD == "*" ).length == 0 ){
			transitSource.unshift({"Transit_CD": "*", "Transit_Name": "*"});
		}

//------GET SOURCE DATA

//------SET AUTOCOMPLETE FOR COLUMN
		var tblHeader = $('#contenttable').parent().prev().find('table');
		tblHeader.find(' th:eq(' + _columns.indexOf( 'TRF_CODE' ) + ') ').setSelectSource( trfSource.map( p => p.TRF_CODE ) );
		tblHeader.find(' th:eq(' + _columns.indexOf( 'CARGO_TYPE' ) + ') ').setSelectSource( cargoTypeSource.map( p => p.Description ) );
		tblHeader.find(' th:eq(' + _columns.indexOf( 'IX_CD' ) + ') ').setSelectSource( cntrClassSource.map(p=>p.CLASS_Name) );
		tblHeader.find(' th:eq(' + _columns.indexOf( 'DMETHOD_CD' ) + ') ').setSelectSource( dmethodSource.map( p=>p.DMethod_CD ) );

		tblHeader.find(' th:eq(' + _columns.indexOf( 'TRANSIT_CD' ) + ') ').setSelectSource( transitSource.map( p=>p.Transit_Name ) );
		tblHeader.find(' th:eq(' + _columns.indexOf( 'IsLocal' ) + ') ').setSelectSource( isLocalSource.map( p=>p.Name ) );
		tblHeader.find(' th:eq(' + _columns.indexOf( 'CURRENCYID' ) + ') ').setSelectSource( currencySource.map( p=>p.Name ) );
//------SET AUTOCOMPLETE FOR COLUMN

//------SET DROPDOWN BUTTON FOR COLUMN
		tbl.columnDropdownButton({
			data:[
				{ colIndex: _columns.indexOf( "IX_CD" ), source: cntrClassSource },
				{ colIndex: _columns.indexOf( "TRANSIT_CD" ), source: transitSource },
				{ colIndex: _columns.indexOf( "IsLocal" ), source: isLocalSource },
				{ colIndex: _columns.indexOf( "CURRENCYID" ), source: currencySource },
			],
			onSelected: function(cell, itemSelected){
				var temp = "<input type='text' value='"+ itemSelected.attr("code") +"' class='hiden-input'>" + itemSelected.text();

				tbl.DataTable().cell(cell).data(temp).draw(false);

				if(!cell.closest("tr").hasClass("addnew")){
		        	tbl.DataTable().row( cell.closest("tr") ).nodes().to$().addClass("editing");
	        	}
			}
		});
//------SET DROPDOWN BUTTON FOR COLUMN

//------SET MORE BUTTON FOR COLUMNS
		tbl.moreButton({
			columns: _columns.getIndexs( ["TRF_CODE", "CARGO_TYPE", "JOB_KIND", "CNTR_JOB_TYPE", "DMETHOD_CD"] ),
			onShow: function( cell ){
				var cellIdx = cell.parent().index();
				$("#apply-trfcode").val( cellIdx + "." + _columns.indexOf( "TRF_CODE" ) );
				$("#apply-cargotype").val( cellIdx + "." + _columns.indexOf( "CARGO_TYPE" ) );
				$("#apply-alljob").val( cellIdx + "." + _columns.indexOf( "JOB_KIND" ) );
				$("#apply-cjmode").val( cellIdx + "." + _columns.indexOf( "CNTR_JOB_TYPE" ) );
				$("#apply-dmethod").val( cellIdx + "." + _columns.indexOf( "DMETHOD_CD" ) );
			}
		});
//------SET MORE BUTTON FOR COLUMNS

		tbl.editableTableWidget();

//------EVENTS
		$('#toDate + span').hide();
		$('#toDate + span').on('click', function(){
			$('#toDate').val("*");
		});

        $('#addrow').on('click', function () {
        	$('#toDate + span').show();
	        $('#temp_info').removeClass("readonly-temp");
	        $('#temp_info').find("input").attr("readonly", false);
	        	//---------datepicker modified---------
		    $('#fromDate, #toDate').datepicker({
				format: "dd/mm/yyyy",
					// startDate: moment().format('DD/MM/YYYY'),
					todayHighlight: true,
					autoclose: true
			});

			$.confirm({
				columnClass: 'col-md-3 col-md-offset-3',
				titleClass: 'font-size-17',
                title: 'Thêm dòng mới',
                content: '<div class="input-group-icon input-group-icon-left">'
                          +'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>'
                          +'<input autofocus class="form-control form-control-sm" id="num-row" onfocus="this.select()" type="number" placeholder="Nhập số dòng" value="1">'
                        +'</div>',
                buttons: {
                    ok: {
                        text: 'Xác nhận',
                        btnClass: 'btn-sm btn-primary btn-confirm',
                        keys: ['Enter'],
                        action: function(){
                            var input = this.$content.find('input#num-row');
                            var errorText = this.$content.find('.text-danger');
                            if(!input.val().trim()){
                                $.alert({
                                	title: "Thông báo",
                                    content: "Vui lòng nhập số dòng!.",
                                    type: 'red'
                                });
                                return false;
                            }else{
                                tbl.newRows( input.val() );
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

		$(document).on("keypress", "#num-row", function(e){
			if( e.which == 13 ){
				$(document).find("div.jconfirm-buttons").find("button.btn-confirm").trigger("click");
			}
		});

        $('#unitcodes-modal, #trfcodes-modal, #cargotype-modal, #cjmode-modal, #alljob-modal, #dmethod-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

    //------APPLY TRF_CODE FROM MODAL
		$("#apply-trfcode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				selectRow = tblTRFCode.getSelectedRows().data().toArray()[0],
				trfCode = selectRow[ _colTRF.indexOf("TRF_CODE") ],
				trfDesc = selectRow[ _colTRF.indexOf("TRF_DESC") ],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			cell.removeClass( "error" );

			dataTbl.cell( cell ).data( trfCode ).draw(false);
			dataTbl.cell( cell.next() ).data( trfDesc ).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dataTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblTRFCode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-trfcode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				trfcode = $(this).find("td:eq("+_colTRF.indexOf("TRF_CODE")+")").text(),
				trfdesc = $(this).find("td:eq("+_colTRF.indexOf( "TRF_DESC" ) +")").text(),
				cellcode = tbl.find( "tbody tr:eq( "+rIdx+" ) td:eq( " + cIdx + " )" ).first();

			cellcode.removeClass( "error" );

			tbl.DataTable().cell( cellcode ).data(trfcode);
			tbl.DataTable().cell( cellcode.next() ).data(trfdesc).draw(false);
			trfCodeModal.modal("hide");
		});
    //------APPLY TRF_CODE FROM MODAL

    //------APPLY UNIT_CODE FROM MODAL
		tblUnitCode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-unitcode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				unit = $(this).find("td:eq("+_colUnit.indexOf("UNIT_CODE")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			cell.removeClass( "error" );

			tbl.DataTable().cell(cell).data(unit).draw(false);
			unicodeModal.modal("hide");
		});

		$("#apply-unitcode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				unit = tblUnitCode.getSelectedRows().data().toArray()[0][_colUnit.indexOf("UNIT_CODE")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			cell.removeClass( "error" );

			dataTbl.cell(cell).data(unit).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dataTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
    //------APPLY UNIT_CODE FROM MODAL

    //------APPLY CARGO_TYPE FROM MODAL
		tblCargoType.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-cargotype"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq("+ _colCargoType.indexOf("Code")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ cgType +"' class='hiden-input'>"
							+ cargoTypeSource.filter( p=>p.Code == cgType ).map( x=>x.Description )[0];

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			cargoTypeModal.modal("hide");
		});

		$("#apply-cargotype").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cgType = tblCargoType.getSelectedRows().data().toArray()[0][ _colCargoType.indexOf("Code") ],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ cgType +"' class='hiden-input'>" 
							+ cargoTypeSource.filter( p=>p.Code == cgType ).map( x=>x.Description )[0];

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
    //------APPLY CARGO_TYPE FROM MODAL

    //------APPLY CJMODEs FROM MODAL
		$("#apply-cjmode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				selectRow = tblCJMode.getSelectedRows().data().toArray()[0],
				cjModeCD = selectRow[ _colCJModes.indexOf("CJMode_CD") ],
				cjModeName = selectRow[ _colCJModes.indexOf("CJModeName") ],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ cjModeCD +"' class='hiden-input'>" + cjModeName;

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblCJMode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-cjmode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cjModeCD = $(this).find("td:eq("+ _colCJModes.indexOf("CJMode_CD")+")").text(),
				cjModeName = $(this).find("td:eq("+ _colCJModes.indexOf("CJModeName")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ cjModeCD +"' class='hiden-input'>" + cjModeName;

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			cjModeModal.modal("hide");
		});
    //------APPLY CJMODEs FROM MODAL

    //------APPLY ALL_JOB FROM MODAL
		$("#apply-alljob").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				selectRow = tblAllJob.getSelectedRows().data().toArray()[0],
				code = selectRow[ _colAllJobs.indexOf("Code") ],
				name = selectRow[ _colAllJobs.indexOf("Name") ],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ code +"' class='hiden-input'>" + name;

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblAllJob.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-alljob"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				code = $(this).find("td:eq("+ _colAllJobs.indexOf("Code")+")").text(),
				name = $(this).find("td:eq("+ _colAllJobs.indexOf("Name")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='"+ code +"' class='hiden-input'>" + name;

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(temp).draw(false);

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			alljobModal.modal("hide");
		});
    //------APPLY ALL_JOB FROM MODAL

    //------APPLY DMETHOD CD FROM MODAL
		$("#apply-dmethod").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				selectRow = tblDmethod.getSelectedRows().data().toArray()[0],
				code = selectRow[ _colDMethods.indexOf("DMethod_CD") ],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(code).draw(false);
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblDmethod.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-dmethod"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				code = $(this).find("td:eq("+ _colDMethods.indexOf("Code")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			cell.removeClass( "error" );

			dtTbl.cell(cell).data(code).draw(false);

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			dmethodModal.modal("hide");
		});
    //------APPLY DMETHOD CD FROM MODAL

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
			var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td'),
        		crRow = inp.closest('tr'),
        		eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html());
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

        tbl.DataTable().on( 'autoFill', function ( e, datatable, cells ) {
        	var startRowIndex = cells[0][0].index.row,
        		endRowIndex = cells[cells.length - 1][0].index.row,
        		dtTbl = tbl.DataTable();

        	var rows = [];
        	$.each(cells, function(idx, item){
        		rows.push(item[0].index.row);
        	});

        	$.each(rows, function(){
        		var crRow = tbl.find("tbody tr:eq("+this+")");
				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
        	});

        	var fillTRFCode = cells[0].filter( p => p.index.column == _columns.indexOf("TRF_CODE") );

			if( fillTRFCode && fillTRFCode.length > 0 )
			{
				var startRowIndex = cells[0][0].index.row;
				var trfCode = dtTbl.cell( startRowIndex, _columns.indexOf( "TRF_CODE" ) ).data();
				var trfDesc = trfSource.filter( p => p.TRF_CODE == trfCode ).map( x => x.TRF_DESC )[0];
				$.each(cells, function(idx, item){
					dtTbl.cell( item[0].index.row, _columns.indexOf( "TRF_STD_DESC" ) ).data(trfDesc);
				});

				dtTbl.draw(false);
			}
		});

		$('#temp').on('change', function () {
			if(!$(this).val()){
				tbl.dataTable().fnClearTable();
				return;
			}

			if(tbl.getAddNewData().length > 0 || tbl.getEditData().length > 0){
				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Các thay đổi sẽ [KHÔNG] được lưu lại!',
		            buttons: {
		                ok: {
		                    text: 'Tiếp tục thao tác',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
		                        templateChanged();
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC']
		                }
		            }
		        });
			}else{
				templateChanged();
			}
		});

		$("#fromDate, #toDate").on("change", function(){
			$(this).clear_error();
		});

		$('#save').on('click', function(){
			if($('.input-required').has_required()){
				$('.toast').remove();
            	toastr["warning"]("Các trường bắt buộc không được để trống!");
            	return;
			}
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
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

        $('#delete').on('click', function(){
            if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(data){
            		if(!data || data.length == 0){ return; }
            		postDel(data);
            	});
            }
        });
//------EVENTS

//IMPORT FILES
		$("#import-file").on("click", function(){
			$("input#input-file").trigger("click");
		});

		//function read excel file
        var oFileIn;
        $("input#input-file").on('click', function () {
            oFileIn = document.getElementById('input-file');
            if(oFileIn === null) return;
            if(oFileIn.addEventListener) {
                oFileIn.addEventListener('change', filePicked, false);
                $(this).val('');
            }
        });

        function filePicked(oEvent) {
	        // Get The File From The Input
	        var oFile = oEvent.target.files[0];
	        var sFilename = oFile.name;
	        // Create A File Reader HTML5
	        var reader = new FileReader();

	        // Ready The Event For When A File Gets Selected
	        reader.onload = function(e) {
	            var data = e.target.result;
	            var workbook = XLSX.read(data, {type: 'binary'});
	            // Loop Over Each Sheet

	            // workbook.SheetNames.forEach(function(sheetName) {
	                
	            // });
	            // read first sheet
	            // Here is your object
	            var sheetName = workbook.SheetNames[0];
	            var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
	            importfileExcel(XL_row_object ? XL_row_object : []);
	        };

	        reader.onerror = function(ex) {
	            toastr['error']("Không thể đọc được tệp này!");
	            console.log(ex);
	        };

	        reader.readAsBinaryString(oFile);
	    }

	    function importfileExcel(importData){
			tbl.waitingLoad();
			var rows=[];

			if(importData.length > 1) {
				var data = importData.filter((a, index) => index !== 0 && a["TRF_CODE"] ); // filter loại bỏ dòng tiêu đề và các row không có mã biểu cước
				var i = 0;
	        	$.each( data, function(index, rData){
	        		var r = [];
	        		$.each( Object.keys(rData).filter( p => p.includes("EMPTY") ), function(){
	        			delete rData[this];
	        		} );

					$.each( _columns, function( idx, colname ){
						var val = "";
						switch( colname ){
							case "STT": val = i+1; break;
							case "TRF_STD_DESC":
								val = trfSource.filter( p => p.TRF_CODE == rData["TRF_CODE"] ).map( x => x.TRF_DESC )[0];
								break;
							case "AMT_F20":
							case "AMT_F40":
							case "AMT_F45":
							case "AMT_E20":
							case "AMT_E40":
							case "AMT_E45":
							case "AMT_NCNTR":
							case "VAT":
								val = rData[colname] ? rData[colname] : 0;
								break;
							case "INCLUDE_VAT":
								val= '<label class="checkbox checkbox-primary">'
										+'<input type="checkbox" value="'+ rData[colname] +'" '+ (rData[colname]==1?"checked":"") +'>'
										+'<span class="input-span"></span>'
									+'</label>';
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

        	tbl.dataTable().fnClearTable();
        	if(rows.length > 0){
				tbl.dataTable().fnAddData( rows );
				$( tbl.DataTable().rows().nodes() ).addClass("addnew");
        	}
		}
//END IMPORT FILES

//------FUNCTION
		function mapDataAgain( data ){
        	$.each( data, function(){
				if ( cntrClassSource.filter( p => p.CLASS_Code == this["IX_CD"] ).length == 0 )
				{
					this["IX_CD"] = cntrClassSource.filter( p => p.CLASS_Name == this["IX_CD"] ).map( x => x.CLASS_Code )[0];
				}

				if ( cargoTypeSource.filter( p => p.Code == this["CARGO_TYPE"] ).length == 0 )
				{
					this["CARGO_TYPE"] = cargoTypeSource.filter( p => p.Description == this["CARGO_TYPE"] ).map( x => x.Code )[0];
				}

				if ( dmethodSource.filter( p => p.DMethod_CD == this["DMETHOD_CD"] ).length == 0 )
				{
					this["DMETHOD_CD"] = dmethodSource.filter( p => p.DMethod_Name == this["DMETHOD_CD"] ).map( x => x.DMethod_CD )[0];
				}

				if ( transitSource.filter( p => p.Transit_CD == this["TRANSIT_CD"] ).length == 0 )
				{
					this["TRANSIT_CD"] = transitSource.filter( p => p.Transit_Name == this["TRANSIT_CD"] ).map( x => x.Transit_CD )[0];
				}

				if ( isLocalSource.filter( p => p.Code == this["IsLocal"] ).length == 0 )
				{
					this["IsLocal"] = isLocalSource.filter( p => p.Name == this["IsLocal"] ).map( x => x.Code )[0];
				}

				if ( currencySource.filter( p => p.Code == this["CURRENCYID"] ).length == 0 )
				{
					this["CURRENCYID"] = currencySource.filter( p => p.Name == this["CURRENCYID"] ).map( x => x.Code )[0];
				}
			} );

			return data;
        }

		function saveData(){
			var newData = tbl.getAddNewData();

			var fData = {
					'applyDate': $('#fromDate').val(),
					'expireDate': $('#toDate').val(),
					'ref_mrk': $('#ref_mrk').val()
				};

			if(newData.length > 0){
				newData = mapDataAgain( newData );
				fData["action"] = "add";
				fData["data"] = newData;
				postSave(fData);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				editData = mapDataAgain( editData );
				fData["action"] = "edit";
				fData["data"] = editData;
				postSave(fData);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    toastr["success"]("Lưu dữ liệu thành công!");
               		location.reload();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delRowguid = data.map(p=>p[_columns.indexOf("rowguid")]);

			var delBtn = $('#delete');
			delBtn.button('loading');

			var fdel = {
					'action': 'delete',
					'data': delRowguid
				};

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
               		toastr["success"]("Xóa dữ liệu thành công!");
               		location.reload();
                },
                error: function(err){
                	delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

        function templateChanged(){
        	$('#fromDate, #toDate').datepicker("destroy");
        	$('#toDate + span').hide();
        	$('#temp_info').addClass("readonly-temp");
        	$('#temp_info').find("input").attr("readonly", true);

        	var data = $('#temp').val().split('-');
			if(data.length > 2){
				$('#fromDate').val(data[0]);
				$('#toDate').val(data[1]);
				$('#ref_mrk').val(data[2]);
			}else{
				$('#fromDate, #toDate, #ref_mrk').val("");
			}

			if($('#temp').val()){
				loadTariff();
			}else{
				tbl.DataTable().rows().clear();
			}
        }

		function loadTariff(){
			$("#contenttable").waitingLoad();
			var block = $('#tablecontent');
			block.blockUI();

			var formData = {
				'action': 'view',
				'temp':$('#temp').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					var rows = [];

		        	if(response.list && response.list.length > 0){
						var data = response.list;

		        		var i = 0;
			        	$.each(data, function(index, rData){
			        		var r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "IX_CD":
										val='<input class="hiden-input" value="'+rData[colname]+'">' 
												+ ( rData["CLASS_Name"] ? rData["CLASS_Name"] : rData[colname] );
										break;
									case "CARGO_TYPE":
										val='<input class="hiden-input" value="'+rData[colname]+'">'
												+ ( rData["Description"] ? rData["Description"] : rData[colname] );
										break;
									case "JOB_KIND":
										val='<input class="hiden-input" value="'+rData[colname]+'">'
												+ ( rData["JobName"] ? rData["JobName"] : rData[colname] );
										break;
									case "CNTR_JOB_TYPE":
										val='<input class="hiden-input" value="'+rData[colname]+'">'
												+ ( rData["CJModeName"] ? rData["CJModeName"] : rData[colname] );
										break;
									case "TRANSIT_CD":
										val='<input class="hiden-input" value="'+rData[colname]+'">'
												+ ( rData["Transit_Name"] ? rData["Transit_Name"] : rData[colname] );
										break;
									case "IsLocal":
										val='<input class="hiden-input" value="'+rData[colname]+'">'
												+ ( rData[colname] == "F" ? "Ngoại" : ( rData[colname] == "L" ? "Nội" : rData[colname] ) );
										break;
									case "INCLUDE_VAT":
										val= '<label class="checkbox checkbox-primary">'
												+'<input type="checkbox" value="'+ rData[colname] +'" '+ (rData[colname]==1?"checked":"") +'>'
												+'<span class="input-span"></span>'
											+'</label>';
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

		        	tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}

					// tbl.DataTable( {
					// 	data: rows,
					// 	columnDefs: [
					// 		{ className: "hiden-input", targets: _columns.indexOf("rowguid") },
					// 		{ className: "text-center", targets: _columns.getIndexs(["STT", "TRF_CODE", "INV_UNIT", "INCLUDE_VAT"]) },
					// 		{
					// 			className: "text-right",
					// 			type: "num",
					// 			targets: _columns.getIndexs(["AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45", "AMT_NCNTR", "VAT"]),
					// 			render: $.fn.dataTable.render.number( ',', '.', 2)
					// 		},
					// 		{
					// 			render: function (data, type, full, meta) {
					// 				return "<div class='wrap-text width-300'>" + data + "</div>";
					// 			},
					// 			targets: _columns.indexOf("TRF_STD_DESC")
					// 		}
					// 	],
					// 	order: [],
					// 	paging: true,
					// 	scroller: {
					// 		displayBuffer: 12,
					// 		boundaryScale: 0.5
					// 	},
					// 	keys:true,
			  //           autoFill: {
			  //               focus: 'focus'
			  //           },
			  //           select: true,
			  //           rowReorder: false
					// } );

					block.unblock();
				},
				error: function(err){console.log(err); block.unblock();}
			});
		}
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/js/xlsx.full.min.js');?>"></script>