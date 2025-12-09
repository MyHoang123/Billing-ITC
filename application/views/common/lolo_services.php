<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">DỊCH VỤ</div>
				<div class="button-bar-group">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
								<tr>
									<th col-name="STT" class="editor-cancel" style="width: 20px">STT</th>
									<th col-name="CJMode_CD">Mã Dịch Vụ</th>
									<th col-name="CJModeName">Tên Dịch Vụ</th>
									<th col-name="CntrClass" class="text-center">Hướng</th>
									<th col-name="isLoLo" class="editor-cancel data-type-checkbox">Nâng Hạ</th>
									<th col-name="IsShipSRV" class="editor-cancel data-type-checkbox">Tàu</th>
									<th col-name="IsYardSRV" class="editor-cancel data-type-checkbox">Bãi</th>
									<th col-name="ischkCFS" class="editor-cancel">CFS</th>
									<th col-name="IsNonContSRV" class="editor-cancel data-type-checkbox">Ngoài Cont</th>
									<th col-name="isClean" class="editor-cancel data-type-checkbox">Vệ Sinh</th>
									<th col-name="ExtraMode">Phụ phí</th>
								</tr>
							</thead>
							<tbody>
								<?php if (count($services) > 0) {
									$i = 1; ?>
									<?php foreach ($services as $item) {  ?>
										<tr>
											<td style="text-align: center"><?= intval($i); ?></td>
											<td><?= $item['CJMode_CD']; ?></td>
											<td><?= $item['CJModeName']; ?></td>
											<td>
												<?= $item['CntrClass']; ?>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?= $item['isLoLo'] == 1 ? 1 : 0; ?>" <?= $item['isLoLo'] == 1 ? "checked" : ""; ?>>
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?= $item['IsShipSRV'] == 1 ? 1 : 0; ?>" <?= $item['IsShipSRV'] == 1 ? "checked" : ""; ?>>
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?= $item['IsYardSRV'] == 1 ? 1 : 0; ?>" <?= $item['IsYardSRV'] == 1 ? "checked" : ""; ?>>
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<?= $item['ischkCFS']; ?>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?= $item['IsNonContSRV'] == 1 ? 1 : 0; ?>" <?= $item['IsNonContSRV'] == 1 ? "checked" : ""; ?>>
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?= $item['isClean'] == 1 ? 1 : 0; ?>" <?= $item['isClean'] == 1 ? "checked" : ""; ?>>
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<?= $item['ExtraMode'] ?? ""; ?>
											</td>
										</tr>
									<?php $i++;
									}  ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var _columns = ["STT", "CJMode_CD", "CJModeName", "CntrClass", "isLoLo", "IsShipSRV", "IsYardSRV", "ischkCFS", "IsNonContSRV", "isClean", "ExtraMode"];
		var tbl = $('#contenttable');
		var cntr_class = <?= json_encode($cntr_class); ?>;
		var cfsSource = [{
				Code: "1",
				Name: "Đóng"
			},
			{
				Code: "2",
				Name: "Rút"
			},
			{
				Code: "3",
				Name: "Sang Cont"
			}
		];
		var extraModeSource = [{
				Code: "1",
				Name: "Phụ phí nâng hàng"
			},
			{
				Code: "2",
				Name: "Phụ phí rút hàng"
			},
			{
				Code: "3",
				Name: "Phụ phí lưu bãi"
			}
		];

		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: _columns.indexOf("STT")
				},
				{
					className: "text-center",
					targets: _columns.getIndexs(["isLoLo", "IsShipSRV", "IsYardSRV", "IsNonContSRV", "isClean"])
				},
				{
					className: "show-dropdown text-center",
					targets: _columns.getIndexs(["CntrClass"]),
					render: function(data, type, full, meta) {
						//CLASS_Code":"*","CLASS_Name
						return cntr_class.filter(p => p.CLASS_Code == data).map(x => x.CLASS_Name)[0] || "";
					}
				},
				{
					className: "show-dropdown text-center",
					targets: _columns.getIndexs(["ischkCFS"]),
					render: function(data, type, full, meta) {
						return cfsSource.filter(p => p.Code == data).map(x => x.Name)[0] || "";
					}
				},
				{
					className: "show-dropdown text-center",
					targets: _columns.getIndexs(["ExtraMode"]),
					render: function(data, type, full, meta) {
						return extraModeSource.filter(p => p.Code == data).map(x => x.Name)[0] || "";
					}
				}
			],
			order: [
				[_columns.indexOf("STT"), 'asc']
			],
			paging: false,
			keys: {
				columns: ':not(:eq(0))'
			},
			autoFill: {
				focus: 'focus'
			},
			select: true,
			rowReorder: false
		});

		//------SET DROPDOWN BUTTON FOR COLUMN
		tbl.columnDropdownButton({
			data: [{
					colIndex: _columns.indexOf("CntrClass"),
					source: cntr_class
				},
				{
					colIndex: _columns.indexOf("ischkCFS"),
					source: cfsSource
				},
				{
					colIndex: _columns.indexOf("ExtraMode"),
					source: extraModeSource
				}
			],
			onSelected: function(cell, itemSelected) {
				var temp = "<input type='text' value='" + itemSelected.attr("code") + "' class='hiden-input'>" + itemSelected.text();

				tbl.DataTable().cell(cell).data(itemSelected.attr("code")).draw(false);
				if (!cell.closest("tr").hasClass("addnew")) {
					tbl.DataTable().row(cell.closest("tr")).nodes().to$().addClass("editing");
				}
			}
		});
		//------SET DROPDOWN BUTTON FOR COLUMN

		tbl.editableTableWidget();

		$('#addrow').on('click', function() {
			$.confirm({
				columnClass: 'col-md-3 col-md-offset-3',
				titleClass: 'font-size-17',
				title: 'Thêm dòng mới',
				content: '<div class="input-group-icon input-group-icon-left">' +
					'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>' +
					'<input autofocus class="form-control form-control-sm" id="num-row" type="number" placeholder="Nhập số dòng" value="1">' +
					'</div>',
				onContentReady: function() {
					$("#num-row").on("keypress", function(e) {
						if (e.which == 13) {
							$(document).find("div.jconfirm-buttons").find("button.btn-confirm").trigger("click");
						}
					});
				},
				buttons: {
					ok: {
						text: 'Xác nhận',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
							var input = this.$content.find('input#num-row');
							var errorText = this.$content.find('.text-danger');
							if (!input.val().trim()) {
								$.alert({
									title: "Thông báo",
									content: "Vui lòng nhập số dòng!.",
									type: 'red'
								});
								return false;
							} else {
								tbl.newRows(input.val());
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

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e) {
			var inp = $(e.target);
			if (inp.is(":checked")) {
				inp.attr("checked", "");
				inp.val("1");
			} else {
				inp.removeAttr("checked");
				inp.val("0");
			}

			var crCell = inp.closest('td'),
				crRow = inp.closest('tr'),
				eTable = tbl.DataTable();

			eTable.cell(crCell).data(crCell.html());
			if (!crRow.hasClass("addnew")) {
				eTable.row(crRow).nodes().to$().addClass("editing");
			}
		});

		$('#delete').on('click', function() {
			if (tbl.getSelectedRows().length == 0) {
				$('.toast').remove();
				toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
			} else {
				tbl.confirmDelete(function(selectedData) {
					postDel(selectedData);
				});
			}
		});

		$('#save').on('click', function() {
			if (tbl.DataTable().rows('.addnew, .editing').data().toArray().length == 0) {
				$('.toast').remove();
				toastr["info"]("Không có dữ liệu thay đổi!");
			} else {
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


		//save functions
		function saveData() {
			var newData = tbl.getAddNewData();

			if (newData.length > 0) {
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if (editData.length > 0) {
				var fedit = {
					'action': 'edit',
					'data': editData
				};
				postSave(fedit);
			}
		}

		function postSave(formData) {
			var saveBtn = $('#save');
			saveBtn.button('loading');
			$('.ibox').blockUI();

			$.ajax({
				url: "<?= site_url(md5('Common') . '/' . md5('cmLoLoService')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (formData.action == 'edit') {
						toastr["success"]("Cập nhật thành công!");
						tbl.DataTable().rows('.editing').nodes().to$().removeClass("editing");
					}

					if (formData.action == 'add') {
						toastr["success"]("Thêm mới thành công!");
						tbl.DataTable().rows('.addnew').nodes().to$().removeClass("addnew");
						tbl.updateSTT(_columns.indexOf("STT"));
					}

					saveBtn.button('reset');
					$('.ibox').unblock();
				},
				error: function(err) {
					toastr["error"]("Error!");
					saveBtn.button('reset');
					$('.ibox').unblock();
					console.log(err);
				}
			});
		}

		function postDel(rows) {
			$('.ibox').blockUI();

			var delUnits = rows.map(p => p[_columns.indexOf("CJMode_CD")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': delUnits
			};
			$.ajax({
				url: "<?= site_url(md5('Common') . '/' . md5('cmLoLoService')); ?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function(output) {
					delBtn.button('reset');
					var data = output.result;
					if (data.error && data.error.length > 0) {
						for (var i = 0; i < data.error.length; i++) {
							toastr["error"](data.error[i]);
						}
					}

					if (data.success && data.success.length > 0) {
						for (var i = 0; i < data.success.length; i++) {
							var deletedUnitCode = data.success[i].split(':')[1].trim();
							var indexes = tbl.filterRowIndexes(_columns.indexOf("CJMode_CD"), deletedUnitCode);
							tbl.DataTable().rows(indexes).remove().draw(false);
							tbl.updateSTT(_columns.indexOf("STT"));
							toastr["success"](data.success[i]);
						}
					}

					$('.ibox').unblock();
				},
				error: function(err) {
					delBtn.button('reset');
					$('.ibox').unblock();
					console.log(err);
				}
			});
		}
	});
</script>