<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css//ebilling.css'); ?>" rel="stylesheet" />

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

	.form-group {
		margin-bottom: .5rem !important;
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

	#payer-modal .dataTables_filter,
	#cargotype-modal .dataTables_filter {
		padding-left: 10px !important;
	}

	.dropdown-menu {
		max-height: 350px !important;
		overflow-y: auto;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title"> CẤU HÌNH LƯU BÃI </div>
				<div class="button-bar-group mr-3">
					<button type="button" class="btn btn-sm btn-outline-success mr-1" data-toggle="modal" data-target="#new-row-modal">
						<span class="btn-icon"><i class="fa fa-plus"></i></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" title="Lưu cấu hình">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu cấu hình</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" title="Xoá cấu hình">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xoá cấu hình</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-12 col-sm-12">
						<div class="p-2">
							<div class="row">
								<div class="col-12 col-xs-12 col-md-8">
									<div class="row form-group">
										<label class="col-sm-2 col-form-label">Mẫu</label>
										<select id="temp" class="selectpicker col-sm-10 input-group input-group-sm" data-style="btn-default btn-sm" data-live-search="true">
											<option value="">-- Chọn mẫu cấu hình --</option>
											<?php if (isset($temp) && count($temp) > 0) {
												foreach ($temp as $item) { ?>
													<option value="<?= $item ?>"><?= $item ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<div class="row form-group">
										<label class="col-sm-2 col-form-label">ĐTTT</label>
										<div class="col-sm-10 input-group">
											<input class="form-control form-control-sm" id="cus" placeholder="Đang nạp ..." type="text" readonly="">
											<span id="clear-cus" class="input-group-addon bg-white btn mobile-hiden text-danger" style="padding: 0 .5rem" title="Xoá">
												<i class="ti-close"></i>
											</span>
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
												<i class="ti-search"></i>
											</span>
										</div>
										<input class="hiden-input" id="taxcode" readonly>
										<input class="hiden-input" id="cusID" readonly>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-md-4">
									<div class="row form-group">
										<label class="col-sm-12 col-form-label text-muted">( Hãng KT__ĐTTT__Nội/Ngoại__Ngày hiệu lực__Ngày hết hạn__HTTT )</label>
									</div>
									<div class="row form-group">
										<label class="col-sm-12 col-form-label text-muted">( Mặc định: Tất cả [*] )</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-xs-12 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Hãng khai thác</label>
										<div class="col-sm-8">
											<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
												<option value="" selected>Hãng khai thác</option>
												<?php if (isset($oprs) && count($oprs) > 0) {
													foreach ($oprs as $item) { ?>
														<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] . ' : ' . $item['CusName'] ?></option>
												<?php }
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Ngày hiệu lực</label>
										<div class="col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm input-required text-center" id="dateStart" type="text" placeholder="Ngày hiệu lực" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Hàng nội/ngoại</label>
										<div class="col-sm-8">
											<select id="isLocal" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
												<option selected value="*">*</option>
												<option value="L">Nội</option>
												<option value="F">Ngoại</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Ngày hết hạn</label>
										<div class="col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm text-center" id="dateEnd" type="text" placeholder="Ngày hết hạn">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label" title="Hình thức thanh toán">HTTT</label>
										<div class="col-sm-8">
											<select id="paymentType" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
												<option value="M">Thu ngay</option>
												<option value="C">Thu sau</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-12 col-form-label text-muted" ><sup>*</sup> Áp dụng cho EPORT</label>
									</div>
								</div>

							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive px-0">
					<table id="tbl" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th col-name="STT" style="max-width: 50px" class="editor-cancel">STT</th>
								<th col-name="rowguid" class="editor-cancel">rowguid</th>
								<th col-name="CntrClass" class="editor-cancel">Hướng cont</th>
								<th col-name="FE" class="editor-cancel">F/E</th>
								<th col-name="CARGO_TYPE" class="autocomplete" show-target="#cargotype-modal">Loại hàng</th>
								<th col-name="SDATE" class="autocomplete">Bắt đầu</th>
								<th col-name="EDATE" class="autocomplete">Kết thúc</th>
								<th col-name="IFREE_DAYS" class="data-type-numeric text-center">Số ngày</th>
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

<!--cargo type modal-->
<div class="modal fade" id="cargotype-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
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
							if (array_search("*",  array_column($cargoTypes, "Code")) === FALSE) {
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

<!--add row modal-->
<div class="modal fade" id="new-row-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Thêm mới dòng</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-sm-12">
						<form id="new-row-form">
							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Hướng cont</label>
								<div class="col-sm-7 input-group">
									<select id="cntr-class" name="CntrClass" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
										<?php if (isset($cntr_class) && count($cntr_class) > 0) {
											foreach ($cntr_class as $item) {
												if ($item['CLASS_Code'] == '*') continue; ?>
												<option value="<?= $item['CLASS_Code'] ?>"><?= $item['CLASS_Name'] ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Full / Empty</label>
								<div class="col-sm-7 input-group">
									<select id="fe" name="FE" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
										<option value="F">Full</option>
										<option value="E">Empty</option>
									</select>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Loại hàng</label>
								<div class="col-sm-7 input-group">
									<select id="cargoType" name="CARGO_TYPE" class="selectpicker" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
									</select>
								</div>
							</div>
							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Bắt đầu</label>
								<div class="col-sm-7 input-group">
									<select id="start-date" name="SDATE" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
										<option value="" selected>--[chọn ngày bắt đầu]--</option>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Kết thúc</label>
								<div class="col-sm-7 input-group">
									<select id="end-date" name="EDATE" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
										<option value="" selected>--[chọn ngày kết thúc]--</option>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<label class="col-sm-5 col-form-label">Số ngày miễn lưu</label>
								<div class="col-sm-7 input-group">
									<input type="number" name="IFREE_DAYS" class="form-control form-control-sm" id="note" placeholder="Ghi chú" min="0" value="0">
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="add-new-row">
						<span class="btn-label"><i class="ti-plus"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var _cols = ["STT", 'rowguid', "CntrClass", "FE", "CARGO_TYPE", "SDATE", "EDATE", "IFREE_DAYS"];
	var _colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];
	var _colCargoType = ["STT", "Code", "Description"];
	var cargoTypeSource = [];
	var payers = [];
	var sdate = [{
			Code: "DIN",
			Name: "Date In"
		},
		{
			Code: "GIN",
			Name: "Gate In"
		},
		{
			Code: "ATB",
			Name: "ATB"
		}
	];
	var edate = [{
			Code: "DOT",
			Name: "Date Out"
		},
		{
			Code: "GOT",
			Name: "Gate Out"
		},
		{
			Code: "ATD",
			Name: "ATD"
		}
	];
	var tbl = $('#tbl');
	var tblCargoType = $('#tblCargoType');
	var basicData = [{
			STT: 1,
			rowguid: null,
			CntrClass: 1,
			FE: 'F',
			CARGO_TYPE: '*',
			SDATE: null,
			EDATE: null,
			IFREE_DAYS: 0
		},
		{
			STT: 2,
			rowguid: null,
			CntrClass: 1,
			FE: 'E',
			CARGO_TYPE: '*',
			SDATE: null,
			EDATE: null,
			IFREE_DAYS: 0
		},
		{
			STT: 3,
			rowguid: null,
			CntrClass: 2,
			FE: 'E',
			CARGO_TYPE: '*',
			SDATE: null,
			EDATE: null,
			IFREE_DAYS: 0
		},
		{
			STT: 4,
			rowguid: null,
			CntrClass: 3,
			FE: 'F',
			CARGO_TYPE: '*',
			SDATE: null,
			EDATE: null,
			IFREE_DAYS: 0
		},
		{
			STT: 5,
			rowguid: null,
			CntrClass: 3,
			FE: 'E',
			CARGO_TYPE: '*',
			SDATE: null,
			EDATE: null,
			IFREE_DAYS: 0
		},
	]

	$(document).ready(function() {
		<?php if (isset($cargoTypes) && count($cargoTypes) > 0) { ?>
			cargoTypeSource = <?= json_encode($cargoTypes); ?>;
		<?php } ?>

		if (cargoTypeSource.filter(p => p.Code == "*").length == 0) {
			cargoTypeSource.unshift({
				"Code": "*",
				"Description": "*"
			});
		}

		if (cargoTypeSource.length > 0) {
			let htmlCargo = cargoTypeSource.map(p => `<option value="${p.Code}">${p.Code} : ${p.Description}</option>`).join();
			$('#cargoType').html(htmlCargo).selectpicker('refresh');
		}

		let htmlsdate = sdate.map(p => `<option value="${p.Code}">${p.Code} : ${p.Name}</option>`).join();
		$('#start-date').html(htmlsdate).selectpicker('refresh');
		let htmledate = edate.map(p => `<option value="${p.Code}">${p.Code} : ${p.Name}</option>`).join();
		$('#end-date').html(htmledate).selectpicker('refresh');

		var ctrlDown = false;
		var dataTbl = tbl.DataTable({
			scrollY: '30vh',
			columnDefs: [{
					type: "num",
					className: 'text-center',
					targets: 0
				},
				{
					className: 'hiden-input',
					targets: _cols.getIndexs(["rowguid"])
				},
				{
					targets: _cols.indexOf('CntrClass'),
					render: function(data) {
						switch (parseInt(data)) {
							case 1:
								return "Import";
								break;
							case 2:
								return "Storage Empty";
								break;
							case 3:
								return "Export";
								break;
							default:
								return data;
								break;
						}
					}
				},
				{
					targets: _cols.indexOf('FE'),
					render: function(data) {
						switch (data) {
							case "F":
								return "Full";
								break;
							case "E":
								return "Empty";
								break;
							default:
								return data;
								break;
						}
					}
				},
				{
					className: "show-more",
					targets: _cols.getIndexs(["CARGO_TYPE"]),
					render: function(data) {
						return cargoTypeSource.filter(p => p.Code == data).length > 0 ?
							cargoTypeSource.filter(p => p.Code == data)[0].Description :
							data;
					}
				},
				{
					className: "show-dropdown",
					targets: _cols.getIndexs(["SDATE", "EDATE"]),
					render: function(data) {
						return [...sdate, ...edate].filter(p => p.Code == data).length > 0 ? [...sdate, ...edate].filter(p => p.Code == data)[0].Name :
							data;
					}
				},
				{
					type: "num",
					className: 'text-right',
					targets: _cols.indexOf('IFREE_DAYS')
				},
			],
			order: [
				[0, 'asc']
			],
			paging: false,
			keys: true,
			autoFill: {
				focus: 'focus'
			},
			select: false,
			buttons: [],
			rowReorder: false
		});

		tbl.editableTableWidget();

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

		load_payer();
		load_basicdata();

		//------SET AUTOCOMPLETE FOR COLUMN
		var tblHeader = tbl.parent().prev().find('table');
		tblHeader.find(' th:eq(' + _cols.indexOf('CARGO_TYPE') + ') ').setSelectSource(cargoTypeSource.map(p => p.Description));
		tblHeader.find(' th:eq(' + _cols.indexOf('SDATE') + ') ').setSelectSource(sdate.map(p => p.Name));
		tblHeader.find(' th:eq(' + _cols.indexOf('EDATE') + ') ').setSelectSource(edate.map(p => p.Name));
		//------SET AUTOCOMPLETE FOR COLUMN

		//------SET DROPDOWN BUTTON FOR COLUMN
		tbl.columnDropdownButton({
			data: [{
					colIndex: _cols.indexOf("SDATE"),
					source: sdate
				},
				{
					colIndex: _cols.indexOf("EDATE"),
					source: edate
				}
			],
			onSelected: function(cell, itemSelected) {
				var temp = "<input type='text' value='" + itemSelected.attr("code") + "' class='hiden-input'>" + itemSelected.text();

				tbl.DataTable().cell(cell).data(temp).draw(false);

				if (!cell.closest("tr").hasClass("addnew")) {
					tbl.DataTable().row(cell.closest("tr")).nodes().to$().addClass("editing");
				}
			}
		});
		//------SET DROPDOWN BUTTON FOR COLUMN

		//------SET MORE BUTTON FOR COLUMNS
		tbl.moreButton({
			columns: _cols.getIndexs(["CARGO_TYPE"]),
			onShow: function(cell) {
				var cellIdx = cell.parent().index();
				$("#apply-cargotype").val(cellIdx + "." + _cols.indexOf("CARGO_TYPE"));
			}
		});
		//------SET MORE BUTTON FOR COLUMNS

		//------APPLY CARGO_TYPE FROM MODAL
		tblCargoType.find("tbody tr").on("dblclick", function() {
			var applyBtn = $("#apply-cargotype"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq(" + _colCargoType.indexOf("Code") + ")").text(),
				cell = tbl.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tbl.DataTable();

			cell.removeClass("error");

			dtTbl.cell(cell).data(cgType).draw(false);

			var crRow = tbl.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}

			$('#cargotype-modal').modal("hide");
		});

		$("#apply-cargotype").on("click", function() {
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cgType = tblCargoType.getSelectedRows().data().toArray()[0][_colCargoType.indexOf("Code")],
				cell = tbl.find("tbody tr:eq(" + rIdx + ") td:eq(" + cIdx + ")").first(),
				dtTbl = tbl.DataTable();

			var temp = "<input type='text' value='" + cgType + "' class='hiden-input'>" +
				cargoTypeSource.filter(p => p.Code == cgType).map(x => x.Description)[0];

			cell.removeClass("error");

			dtTbl.cell(cell).data(temp).draw(false);
			var crRow = tbl.find("tbody tr:eq(" + rIdx + ")");
			if (!crRow.hasClass("addnew")) {
				dtTbl.row(crRow).nodes().to$().addClass("editing");
			}
		});
		//------APPLY CARGO_TYPE FROM MODAL

		// ------------binding shortcut key press------------
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
				alert('reload filter');
				return false;
			}
		});

		//---------datepicker modified---------
		setDateRange($('#dateStart'), $('#dateEnd'));

		$('#cargotype-modal, #payer-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});

		///////// SEARCH PAYER
		$(document).on('click', '#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-payer').on('click', function() {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();
			var taxCode = $(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text();
			var name = $(r).find('td:eq(' + _colPayer.indexOf("CusName") + ')').text();
			$('#cus').val(taxCode + ' : ' + name);
			$('#taxcode').val(taxCode);
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());
			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();

			var taxCode = $(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text();
			var name = $(r).find('td:eq(' + _colPayer.indexOf("CusName") + ')').text();
			$('#cus').val(taxCode + ' : ' + name);

			$('#taxcode').val(taxCode);
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});

		$('#clear-cus').on('click', function() {
			$('#cus, #cusID, #taxcode').val('');
		})
		///////// END SEARCH PAYER

		$('#add-new-row').on('click', function() {
			var currentData = tbl.getDataByColumns(_cols);

			var newObj = {};
			$('#new-row-form').serializeArray().map(p => {
				newObj[p.name] = p.value || '';
			});

			if (currentData.filter(p => p.CntrClass == newObj.CntrClass && p.FE == newObj.FE && p.CARGO_TYPE == newObj.CARGO_TYPE).length > 0) {
				toastr.error('Đã tồn tại thông tin theo HƯỚNG - FE - LOẠI HÀNG');
				return;
			}

			let rowData = _cols.map(c => c == 'STT' ? currentData.length + 1 : (newObj[c] || ''));
			var rowNodes = tbl.DataTable().row.add(rowData).draw(false).node();
			$(rowNodes).addClass("addnew").find('td').attr('tabindex', 1);
		})

		$('#temp').on('change', function() {
			if (!$(this).val()) {
				load_basicdata();
				return;
			}

			if (tbl.getAddNewData().length > 0 || tbl.getEditData().length > 0) {
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
							action: function() {
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
			} else {
				templateChanged();
			}
		});

		$('#save').on('click', function() {
			if ($('.input-required').has_required()) {
				$('.toast').remove();
				toastr["warning"]("Các trường bắt buộc không được để trống!");
				return;
			}

			var isChangeHeader = compareHeader();

			if (isChangeHeader) {
				$(tbl.DataTable().rows().nodes()).addClass("addnew");
			}

			if (tbl.DataTable().rows('.addnew, .editing').data().toArray().length == 0 && !isChangeHeader) {
				$('.toast').remove();
				toastr["info"]("Không có dữ liệu thay đổi!");
			} else {
				$.confirm({
					title: 'Thông báo!',
					type: 'orange',
					icon: 'fa fa-warning',
					content: '<div class="text-danger font-bold">Tất cả các thay đổi sẽ được lưu lại! Tiếp tục?</div>',
					buttons: {
						ok: {
							text: 'Xác nhận lưu',
							btnClass: 'btn-warning',
							keys: ['Enter'],
							action: function() {
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

		$('#delete').on('click', function() {
			if (!$('#temp').val()) {
				$('.toast').remove();
				toastr["warning"]("Chưa chọn mẫu!");
				return;
			}

			$.confirm({
				title: 'Thông báo!',
				type: 'red',
				icon: 'fa fa-warning',
				content: '<div class="text-danger font-bold h6">Tất cả các cấu hình của mẫu này sẽ bị xoá! Tiếp tục?</div>',
				buttons: {
					ok: {
						text: 'Xác nhận xoá',
						btnClass: 'btn-danger',
						keys: ['Enter'],
						action: function() {
							deleteConfig();
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC']
					}
				}
			});
		})
	});

	function templateChanged() {
		var data = $('#temp').val().split('__');
		if (data.length > 2) {
			$('#opr').val(data[0]).selectpicker('refresh');
			$('#taxcode, #cusID').val(data[1]);
			var cus = payers.filter(p => p.TaxCode == data[1]);
			if (cus.length > 0) {
				$('#cus').val(data[1] + ' : ' + cus[0].CusName);
			} else {
				$('#cus').val(data[1]);
			}

			$('#isLocal').val(data[2]).selectpicker('refresh');
			$('#dateStart').val(data[3]);
			$('#dateEnd').val(data[4]);
			$('#paymentType').val(data[5]).selectpicker('refresh');
		} else {
			$('#opr, #cus, #isLocal, #dateStart, #dateEnd, #taxcode, #cusID').val("");
		}

		if ($('#temp').val()) {
			loadFreeDayConfig();
		} else {
			load_basicdata();
		}
	}

	function load_payer() {
		var tblPayer = $('#search-payer');
		tblPayer.waitingLoad();

		$.ajax({
			url: "<?= site_url(md5('Task') . '/' . md5('tskImportPickup')); ?>",
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
				} else {
					load_basicdata();
				}

				$("#cus").prop("placeholder", "ĐT thanh toán");
			},
			error: function(err) {
				load_basicdata();
				console.log(err);
				toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
			}
		});
	};

	function load_basicdata() {
		tbl.dataTable().fnClearTable();
		tbl.dataTable().fnAddData(basicData.map(p => Object.values(p)));
	}

	function compareHeader() {
		var data = $('#temp').val();
		var compareData = [$('#opr').val(), $('#cusID').val(), $('#isLocal').val(), $('#dateStart').val(), $('#dateEnd').val(), $("#paymentType").val()]
			.join("__");

		return compareData != data;
	}

	function loadFreeDayConfig() {
		tbl.waitingLoad();
		var block = $('.page-content');
		block.blockUI();

		var formData = {
			'action': 'view',
			'temp': $('#temp').val()
		};

		$.ajax({
			url: "<?= site_url(md5('Common') . '/' . md5('cmFreeDays')); ?>",
			dataType: 'json',
			data: formData,
			type: 'POST',
			success: function(response) {
				var rows = [];
				if (response.list && response.list.length > 0) {
					var data = response.list;
					data.map((item, rIndx) => {
						rows.push(_cols.map((col, idx) => col == 'STT' ? (rIndx + 1) : (item[col] || '')));
					});
				}

				tbl.dataTable().fnClearTable();
				if (rows.length > 0) {
					tbl.dataTable().fnAddData(rows);
				} else {
					load_basicdata();
				}

				block.unblock();
			},
			error: function(err) {
				load_basicdata();
				console.log(err);
				block.unblock();
				toastr["error"]("Server Error At [Load Contract]");
			}
		});
	}

	function deleteConfig() {
		tbl.waitingLoad();
		var block = $('.page-content');
		block.blockUI();

		var formData = {
			'action': 'delete',
			'temp': $('#temp').val()
		};

		$.ajax({
			url: "<?= site_url(md5('Common') . '/' . md5('cmFreeDays')); ?>",
			dataType: 'json',
			data: formData,
			type: 'POST',
			success: function(response) {
				toastr.success('Đã xoá')
				location.reload(true);

			},
			error: function(err) {
				load_basicdata();
				console.log(err);
				block.unblock();
				toastr["error"]("Server Error At [Load Contract]");
			}
		});
	}

	function saveData() {
		var newData = tbl.getAddNewData();
		newData = newData.filter(p => p['IFREE_DAYS'] > 0);

		var cusID = $('#cusID').val() || $('#taxcode').val() || "*";
		var fData = {
			'PTNR_CODE': $('#opr').val(),
			'SHIPPER': cusID,
			'IsLocal': $('#isLocal').val(),
			'APPLY_DATE': $('#dateStart').val(),
			'EXPIRE_DATE': $('#dateEnd').val(),
			'PAYMENT_TYPE': $('#paymentType').val(),
		};

		if (newData.length > 0) {
			newData = mapDataAgain(newData);
			fData["action"] = "add";
			fData["data"] = newData;
			postSave(fData);
		}

		var editData = tbl.getEditData();

		if (editData.length > 0) {
			editData = mapDataAgain(editData);
			fData["action"] = "edit";
			fData["data"] = editData;
			postSave(fData);
		}
	}

	function postSave(formData) {
		var saveBtn = $('#save');
		saveBtn.button('loading');
		$('.ibox.collapsible-box').blockUI();

		$.ajax({
			url: "<?= site_url(md5('Common') . '/' . md5('cmFreeDays')); ?>",
			dataType: 'json',
			data: formData,
			type: 'POST',
			success: function(data) {
				if (data.deny) {
					toastr["error"](data.deny);
					return;
				}

				toastr["success"]("Lưu dữ liệu thành công!");
				location.reload(true);
			},
			error: function(err) {
				toastr["error"]("Error!");
				saveBtn.button('reset');
				$('.ibox.collapsible-box').unblock();
				console.log(err);
			}
		});
	}

	function mapDataAgain(data) {
		$.each(data, function() {
			if (cargoTypeSource.filter(p => p.Code == this["CARGO_TYPE"]).length == 0) {
				this["CARGO_TYPE"] = cargoTypeSource.filter(p => p.Description == this["CARGO_TYPE"]).map(x => x.Code)[0];
			}

			if (sdate.filter(p => p.Code == this["SDATE"]).length == 0) {
				this["SDATE"] = sdate.filter(p => p.Name == this["SDATE"]).map(x => x.Code)[0];
			}

			if (edate.filter(p => p.Code == this["EDATE"]).length == 0) {
				this["EDATE"] = edate.filter(p => p.Name == this["EDATE"]).map(x => x.Code)[0];
			}
		});

		return data;
	}
</script>

<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>