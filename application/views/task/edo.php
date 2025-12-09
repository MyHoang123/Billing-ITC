<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">
<link href="<?= base_url('assets/vendors/dataTables/extensions/buttons.dataTables.min.css'); ?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right {
			text-align: right;
		}
	}

	.modal-dialog-mw-py {
		position: fixed;
		top: 20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100% !important;
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
		width: 90% !important;
		margin: auto;
	}

	.vertical-alignment-helper {
		display: table;
	}

	.modal-content {
		/* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
		width: inherit;
		height: inherit;
		/* To center horizontally */
		margin: 0 auto;
	}

	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold !important;
		padding-right: 0 !important;
	}

	#INV_DRAFT_TOTAL span.col-form-label {
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">Quản lý EDI Delivery Order (EDO)</div>
			</div>
			<div class="ibox-body p-3 bg-f9 border-e">
				<div class="row">
					<div class="col-sm-12">
						<div class="my-box p-3">
							<div class="row">
								<div class="col-sm-5">
									<div class="row form-group">
										<label class="col-md-3 col-sm-4 col-form-label">Ngày nhận EDO</label>
										<div class="col-md-9 col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm input-required mr-2" id="fromDate" type="text" placeholder="Từ ngày" readonly>
												<input class="form-control form-control-sm input-required" id="toDate" type="text" placeholder="Đến ngày" readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-7">
									<div class="row form-group">
										<label class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-form-label">Hãng khai thác</label>
										<div class="col-xl-10 col-l-9 col-md-8 col-sm-7 input-group input-group-sm">
											<select id="oprID" class="selectpicker form-control" title="-- [Hãng khai thác] --" data-live-search="true" multiple>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-5">
									<div class="row form-group">
										<label class="col-md-3 col-sm-4 col-form-label">Tìm kiếm</label>
										<div class="col-md-9 col-sm-8 input-group input-group-sm">
											<input class="form-control form-control-sm input-required" id="search-val" type="text" placeholder="Số DO / Số BL / Số Cont">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="my-box mt-2 py-2 pl-3">
							<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" title="Nạp dữ liệu">
								<span class="btn-icon"><i class="ti-search"></i>Nạp Dữ Liệu</span>
							</button>
							<button id="to-eir" class="btn btn-outline-primary btn-sm">
								<span class="btn-icon"><i class="la la-calculator"></i>Chuyển Làm Lệnh</span>
							</button>
							<button id="save" class="btn btn-outline-primary btn-sm" data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu">
								<span class="btn-icon"><i class="la la-save"></i>Lưu</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0" style="padding: 10px 12px">
				<div class="col-12 table-responsive">
					<table id="tbl" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
							<tr>
								<th>EdoRowguid</th>
								<th class="editor-cancel hiden-input">rowguid</th>
								<th class="editor-cancel">STT</th>
								<th class="editor-cancel data-type-checkbox">
									<label class="checkbox checkbox-outline-ebony">
										<input type="checkbox" name="check-cont-all" value="*" style="display: none;">
										<span class="input-span"></span>
									</label>
								</th>
								<th class="editor-cancel">Trạng Thái</th>
								<th class="editor-cancel">Số Container</th>
								<th class="editor-cancel">Số Vận Đơn</th>
								<th class="editor-cancel">Hãng Khai Thác</th>
								<th class="editor-cancel">KC Nội Bộ</th>
								<th class="editor-cancel">KC ISO</th>
								<th class="editor-cancel">F/E</th>
								<th class="editor-cancel">Hướng</th>
								<th class="editor-cancel">Số DO</th>
								<th class="editor-cancel">Ngày Nhận EDO</th>
								<th class="data-type-date">Ngày Hết Hạn</th>
								<th class="editor-cancel">Chủ Hàng</th>
								<th class="editor-cancel">Tên Tàu</th>
								<th class="editor-cancel">Chuyến Nhập</th>
								<th class="editor-cancel">Chuyến Xuất</th>
								<th class="editor-cancel">POD</th>
								<th class="editor-cancel">FPOD</th>
								<th class="">Nơi Trả Rỗng</th>
								<th class="data-type-numeric">Số ngày miễn lưu</th>
								<th class="editor-cancel">Ghi chú</th>
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

<script type="text/javascript">
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function() {
		var _cols = ["EdoRowguid", "rowguid", "STT", "Select", "ComparedStatus", "CntrNo", "BLNo", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "CLASS_Name", "DELIVERYORDER", "EdoDate", "ExpDate", "Shipper_Name", "ShipName", "ImVoy", "ExVoy", "POD", "FPOD", "RetLocation", "Haulage_Instruction", "Note"];

		//------define table
		//define table cont
		var tbl = $('#tbl');
		var datatbl = tbl.DataTable({
			scrollY: '43vh',
			order: [
				[_cols.indexOf('STT'), 'asc']
			],
			paging: false,
			columnDefs: [{
					className: "hiden-input",
					targets: _cols.getIndexs(["rowguid", 'EdoRowguid'])
				},
				{
					type: 'num',
					className: "text-center",
					targets: _cols.indexOf("STT")
				},
				{
					className: "text-center",
					targets: _cols.getIndexs(["ComparedStatus", "OprID", "CntrNo", "LocalSZPT", "ISO_SZTP", "Status", , "CntrClass", "DELIVERYORDER", "EdoDate"])
				},
				{
					className: "text-center",
					orderDataType: 'dom-checkbox',
					targets: _cols.indexOf("Select")
				},
				{
					className: 'text-center',
					width: "150px",
					targets: _cols.indexOf("ExpDate"),
					render: function(data, type, full, meta) {
						var temp = Array.isArray(data) ? data[0] : data;
						return temp ? temp.split(" ")[0] + " 23:59:00" : "";
					}
				}
			],
			buttons: [{
				extend: 'excel',
				text: '<i class="fa fa-files-o"></i> Xuất Excel',
				titleAttr: 'Xuất Excel',
				exportOptions: {
					columns: 'th:not(:eq(' + _cols.indexOf("rowguid") + '))'
				}
			}],
			keys: true,
			select: false,
			rowReorder: false,
			createdRow: function(row, data, dataIndex) {
				if (!data[_cols.indexOf("rowguid")]) {
					$(row).addClass("row-disabled");
				}
			}
		});

		tbl.editableTableWidget();
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
		//------define selectpicker

		//set from date, to date
		var fromDate = $('#fromDate');
		var toDate = $('#toDate');

		$.timepicker.dateRange(
			fromDate,
			toDate, {
				dateFormat: 'dd/mm/yy',
				start: {}, // start picker options
				end: {} // end picker options
			}
		);

		fromDate.val(moment().subtract(1, 'month').format('DD/MM/YYYY'));
		toDate.val(moment().format('DD/MM/YYYY'));
		//end set fromdate, todate

		load_opr();

		//------EVENTS
		$(document).on("change", "th input[type='checkbox'][name='check-cont-all']", function(e) {
			var isChecked = $(e.target).is(":checked");

			var tempChange = '<label class="checkbox checkbox-outline-ebony">' +
				'<input type="checkbox" name="check-cont" value="' +
				(isChecked ? "1" : 0) + '" style="display: none;" ' + (isChecked ? "checked" : "") + '>' +
				'<span class="input-span"></span>'; +
			'</label>';

			var rowEditing = [];
			tbl.DataTable().cells(':not(.row-disabled)', _cols.indexOf("Select"))
				.every(function() {
					this.data(tempChange);
					rowEditing.push(this.index().row);
				});

			// tbl.DataTable().rows().select();
		});

		tbl.on('change', 'tbody tr td input[name="check-cont"]', function(e) {
			var inp = $(e.target);
			if (inp.is(":checked")) {
				inp.attr("checked", "");
				inp.val("1");
				// tbl.DataTable().rows( inp.closest("tr") ).select();
			} else {
				inp.removeAttr("checked");
				inp.val("0");
				// tbl.DataTable().rows( inp.closest("tr") ).deselect();
			}

			var crCell = inp.closest('td');
			var crRow = inp.closest('tr');
			var eTable = tbl.DataTable();

			eTable.cell(crCell).data(crCell.html()).draw(false);
		});

		$("#search").on("click", function() {
			if (!$("#oprID").val()) {
				toastr["error"]("Chọn ít nhất một [Hãng Khai Thác] để nạp dữ liệu!");
				return;
			}

			$(this).button("loading");
			search_do();
		});

		$("#save").on('click', function() {
			var editedDatas = tbl.getEditData()
			if (editedDatas.length == 0) {
				return;
			}

			var data = editedDatas.map(p => {
				return {
					rowguid: p[_cols.indexOf('EdoRowguid')],
					ExpDate: p[_cols.indexOf('ExpDate')],
					RetLocation: p[_cols.indexOf('RetLocation')],
					Haulage_Instruction: p[_cols.indexOf('Haulage_Instruction')]
				}
			})

			$.confirm({
				columnClass: 'col-md-4 col-md-offset-4 mx-auto',
				titleClass: 'font-size-17',
				title: 'Xác nhận',
				content: 'Lưu thay đổi thông tin?',
				buttons: {
					ok: {
						text: 'OK',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
							saveData(data)
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

		function saveData(editData) {
			var formData = {
				'action': 'edit',
				'data': editData
			};

			var saveBtn = $('#save');
			saveBtn.button('loading');
			$('.ibox.collapsible-box').blockUI();

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskEDO')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					saveBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						toastr["error"](data.error);
						return;
					}

					if (data.no_ordType) {
						toastr["error"](data.no_ordType);
						return;
					}

					toastr["success"]("Cập nhật thành công!");
					tbl.DataTable().rows('.editing').nodes().to$().removeClass("editing");
					tbl.DataTable().cells('.error').nodes().to$().removeClass("error");
				},
				error: function(err) {
					toastr["error"]("What happen!");
					saveBtn.button('reset');
					$('.ibox.collapsible-box').unblock();
					console.log(err);
				}
			});
		}


		$("#to-eir").on("click", function() {
			var rowguids = tbl.getData().filter(p => p[_cols.indexOf("Select")] == "1" && p[_cols.indexOf("rowguid")]);
			if (rowguids.length == 0) {
				toastr["error"]("Vui lòng chọn container đủ điều kiện làm lệnh!");
				return;
			}

			rowguids = rowguids.map(x => x[_cols.indexOf("rowguid")]);

			var form = document.createElement("form");
			form.setAttribute("method", "post");
			form.setAttribute("target", "_blank");
			form.setAttribute("action", "<?= site_url(md5('Task') . '/' . md5('tskImportPickup')); ?>");

			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = "rowguidsFromEDO";
			input.value = JSON.stringify(rowguids);
			form.appendChild(input);

			var input2 = document.createElement('input');
			input2.type = 'hidden';
			input2.name = "payerName";
			input2.value = $("#payer-name").val();
			form.appendChild(input2);

			document.body.appendChild(form);
			form.submit();
			document.body.removeChild(form);
		});
		//------EVENTS

		//------FUNCTIONS

		function search_do() {
			tbl.waitingLoad();

			var formData = {
				action: "view",
				act: "load_data",
				oprs: $("#oprID").val(),
				fromDate: $("#fromDate").val(),
				toDate: $("#toDate").val(),
				searchVal: $("#search-val").val()
			};

			$.ajax({
				url: "<?= site_url(md5('Task') . '/' . md5('tskEDO')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					$("#search").button("reset");
					var rows = [];
					if (data.results && data.results.length > 0) {
						$.each(data.results, function(i, item) {
							var r = [];
							$.each(_cols, function(idx, colname) {
								var val = "";
								switch (colname) {
									case "STT":
										val = i + 1;
										break;
									case "Select":
										var isDisabled = !item["rowguid"] ? "disabled" : "";
										val = '<label class="checkbox checkbox-outline-ebony ' + isDisabled + '">' +
											'<input type="checkbox" name="check-cont" ' + isDisabled + ' value="" style="display: none;">' +
											'<span class="input-span"></span>'; +
										'</label>';
										break;
									case "EdoDate":
									case "ExpDate":
										val = getDateTime(item[colname]);
										break;
									default:
										val = item[colname] ? item[colname] : "";
										break;
								}
								r.push(val);
							});

							rows.push(r);

						});
					}

					tbl.dataTable().fnClearTable();
					if (rows.length > 0) {
						tbl.dataTable().fnAddData(rows);
					}
				},
				error: function(err) {
					tbl.dataTable().fnClearTable();
					$("#search").button("reset");
					$('.toast').remove();
					toastr['error']("Server Error at [search_do]");
					console.log(err);
				}
			});
		}

		function load_opr() {
			var formdata = {
				'action': 'view',
				'act': 'load_opr'
			};

			$.ajax({
				url: "<?= site_url(md5('Credit') . '/' . md5('creContPlugTotal')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(data) {
					if (data.oprs && data.oprs.length > 0) {
						var innerOprHtml = "";
						$.each(data.oprs, function() {
							innerOprHtml += '<option value="' + this["CusID"] + '">' + this["CusID"] + " : " + this["CusName"] + '</option>';
						});
						$("#oprID").append(innerOprHtml).selectpicker('refresh');
					}

				},
				error: function(err) {
					console.log(err);
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				}
			});
		}

		function getContSize(sztype) {
			switch (sztype.substring(0, 1)) {
				case "2":
					return 20;
				case "4":
					return 40;
				case "L":
				case "M":
				case "9":
					return 45;
			}

			return sztype.substring(0, 2);
		}

		function isFloat(n) {
			return Number(n) === n && n % 1 !== 0;
		}

		//------FUNCTIONS
	});
</script>
<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>

<script src="<?= base_url('assets/vendors/dataTables/datatables.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/jszip.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/dataTables/extensions/buttons.html5.min.js'); ?>"></script>