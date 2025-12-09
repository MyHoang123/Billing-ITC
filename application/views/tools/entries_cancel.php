<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css//ebilling.css'); ?>" rel="stylesheet" />

<style>
	.m-row-selected {
		background: violet;
	}

	.modal-dialog-mw-py {
		position: fixed;
		top: 20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100% !important;
	}

	.modal-dialog-mw-py .modal-body {
		width: 90% !important;
		margin: auto;
	}

	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#payer-modal .dataTables_filter {
		padding-left: 10px !important;
	}

	.font-size-14 {
		font-size: 14px !important;
	}

	.box-group {
		border: 1px solid #ccc !important;
		margin-left: -10px;
		padding-top: 10px !important;
		border-radius: 3px !important;
	}
</style>

<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">HỦY PHIẾU TÍNH CƯỚC</div>
				<div class="button-bar-group mr-3">
					<button type="button" id="load-data" title="Nạp dữ liệu" data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-refresh"></i>
						Nạp dữ liệu
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row my-box pb-1">
					<div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group box-group" style="padding: 0 !important; ">
							<div class=" col-sm-12">
								<div class="py-2" style="display: flex; align-items: center;">
									<div class="input-group">
										<label class="radio">
											<input type="radio" name="dateOf" value="PTC" checked>
											<span class="input-span"></span>
											PHIẾU TÍNH CƯỚC
										</label>
									</div>
									<div class="input-group">
										<input class="form-control form-control-sm text-center" id="issueDateFrom" type="text" placeholder="Từ ngày">
										<span>&ensp;</span>
										<input class="form-control form-control-sm text-center" id="issueDateTo" type="text" placeholder="Đến ngày">
									</div>
								</div>
							</div>

						</div>

						<div class="row form-group">
							<label class="col-lg-4 col-sm-4 col-form-label">Trạng thái HĐ</label>
							<div class="col-lg-8 col-sm-8 input-group input-group-sm">
								<div class="mb-2">
									<label class="checkbox checkbox-inline">
										<input type="checkbox" name="payment-status" value="U" checked="">
										<span class="input-span"></span>Chưa thanh toán</label>
									<label class="checkbox checkbox-inline">
										<input type="checkbox" name="payment-status" value="Y" checked="">
										<span class="input-span"></span>Đã thanh toán</label>
									<label class="checkbox checkbox-inline">
										<input type="checkbox" name="payment-status" value="C">
										<span class="input-span"></span>Đã hủy</label>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-lg-4 col-sm-4 col-form-label">Hình thức</label>
							<div class="col-lg-8 col-sm-8 input-group input-group-sm">
								<div class="mb-2">
									<label class="checkbox checkbox-inline">
										<input type="checkbox" name="payment-type" value="CAS">
										<span class="input-span"></span>Thu ngay</label>
									<label class="checkbox checkbox-inline">
										<input type="checkbox" name="payment-type" value="CRE">
										<span class="input-span"></span>Thu sau</label>
								</div>
							</div>
						</div>

					</div>
					<div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-lg-3 col-sm-4 col-form-label" title="Đối tượng thanh toán">Đối tượng TT</label>
							<div class="col-lg-8 col-sm-8 input-group">
								<input class="form-control form-control-sm" id="taxcode" placeholder="Đối tượng thanh toán" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
									<i class="ti-search"></i>
								</span>
							</div>
							<input class="hiden-input" id="cusID" readonly>
						</div>
						<div class="row form-group" style="margin-bottom: 12px!important">
							<label class="col-lg-3 col-sm-4 col-form-label" for="searchValue">Tìm kiếm</label>
							<div class="col-lg-8 col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="searchValue" type="text" placeholder="Số lệnh, số PIN, số hoá đơn, số PTC">
							</div>
						</div>
						<div class="row form-group mt-4 pt-1">
							<label class="col-lg-2 col-sm-3 col-form-label">Hệ thống</label>
							<div class="col-lg-8 col-sm-9 input-group input-group-sm col-form-label">
								<label class="radio radio-inline">
									<input type="radio" name="sys" value="BL" checked>
									<span class="input-span"></span>BILLING</label>
								<label class="radio radio-inline">
									<input type="radio" name="sys" value="VSL">
									<span class="input-span"></span>VSL</label>
							</div>
						</div>
					</div>
					<!-- ///////////////////////////////// -->
				</div>
				<div class="row mt-2 pt-2">
					<div class="col-12 ibox mb-0 border-e pb-1 pt-3">
						<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
								<tr>
									<th>STT</th>
									<th>Chức Năng</th>
									<th>Số PTC</th>
									<th>Số HĐ</th>
									<th>Trạng Thái PTC</th>
									<th>Trạng Thái HĐ</th>
									<th>Hãng KT</th>
									<th>Mã KH</th>
									<th>Tên KH</th>
									<th>Thành Tiền</th>
									<th>Tiền Thuế</th>
									<th>Tổng Tiền</th>
									<th>Loại Tiền</th>
									<th>Người huỷ</th>
									<th>Ngày Huỷ</th>
									<th>Lý Do Huỷ</th>
									<th>OrderNo</th>
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

<script type="text/javascript">
	$(document).ready(function() {

		var tblInv = $("#tbl-inv"),
			tblPayer = $("#search-payer"),
			_colInv = ["STT", "Action", "DRAFT_INV_NO", "INV_NO", "DRAFT_PAY_STATUS", "INV_PAY_STATUS", "OPR", "PAYER", "CusName", "AMOUNT", "VAT", "TAMOUNT", "CURRENCYID", "CancelBy", "CancelDate", "CancelRemark", 'ORD_NO'],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

		var _draftDetails = [],
			_invs = [],
			_payers = [];

		var dtInv = tblInv.DataTable({
			scrollY: '37vh',
			columnDefs: [{
					type: "num",
					className: "text-center",
					targets: _colInv.indexOf('STT')
				},
				{
					orderable: false,
					className: "text-center",
					targets: _colInv.indexOf('Action')
				},
				{
					className: "text-center",
					targets: _colInv.getIndexs(['DRAFT_INV_NO', 'INV_NO', "OPR", 'CURRENCYID'])
				},
				{
					className: "text-right",
					targets: _colInv.getIndexs(["AMOUNT", "VAT", "TAMOUNT"]),
					render: $.fn.dataTable.render.number(',', '.', 2)
				},
				{
					render: function(data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colInv.getIndexs(["CusName", "CancelRemark"])
				},
				{
					visible: false,
					targets: _colInv.indexOf('ORD_NO')
				}
			],
			order: [
				[_colInv.indexOf('STT'), 'asc']
			],
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			rowReorder: false,
			buttons: []
		});

		tblPayer.DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [{
					type: "num",
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

		//set from date, to date
		var issueDateFrom = $('#issueDateFrom');
		var issueDateTo = $('#issueDateTo');
		setDateTimeRange(issueDateFrom, issueDateTo); //, 'yy-mm-dd', 'HH:mm:ss'

		issueDateFrom.val(moment().subtract(1, 'day').format('DD/MM/YYYY 00:00'));
		issueDateTo.val(moment().format('DD/MM/YYYY 23:59'));
		//end set fromdate, todate

		//////// SEARCH PAYER
		$(document).on('click', '#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function() {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			fillPayer();

			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick', 'tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq(' + _colPayer.indexOf("VAT_CD") + ')').text());
			$('#cusID').val($(r).find('td:eq(' + _colPayer.indexOf("CusID") + ')').text());

			fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
		///////// END SEARCH PAYER

		$("#load-data").on("click", function() {
			loadInv();
		});

		$('#payer-modal').on('shown.bs.modal', function(e) {
			$($.fn.dataTable.tables(true)).DataTable()
				.columns
				.adjust();
		});

		tblInv.on("click", '.cancel-inv', function(e) {
			var selectRow = $(e.target).closest("tr"),
				rowData = tblInv.DataTable().rows(selectRow).data().toArray()[0],
				invNo = rowData[_colInv.indexOf("INV_NO")],
				pinCode = _invs.filter(p => p.INV_NO == invNo).map(x => x.PinCode)[0];

			$.confirm({
				columnClass: 'col-md-5 col-md-offset-5',
				title: 'Lý do hủy hóa đơn',
				content: '<div class="form-group">' +
					'<textarea autofocus class="form-control form-control-sm font-size-14" id="cremark" placeholder="Nhập lý do hủy" rows=5></textarea>' +
					'</div>',
				buttons: {
					ok: {
						text: 'Xác nhận hủy',
						btnClass: 'btn-sm btn-primary btn-confirm',
						keys: ['Enter'],
						action: function() {
							var input = this.$content.find('textarea#cremark');
							var errorText = this.$content.find('.text-danger');
							if (!input.val().trim()) {
								$.alert({
									title: "Thông báo",
									content: "Vui lòng nhập lý do hủy hóa đơn!.",
									type: 'red'
								});
								return false;
							} else {
								cancelEInv($(e.target).closest("td"), pinCode, invNo, input.val(), false);
							}
						}
					},
					later: {
						text: 'Quay lại',
						btnClass: 'btn-sm',
						keys: ['ESC']
					}
				}
			});
		});

		tblInv.on("click", '.cancel-draft', function(e) {
			var selectRow = $(e.target).closest("tr"),
				rowData = tblInv.DataTable().rows(selectRow).data().toArray()[0],
				draftNo = rowData[_colInv.indexOf("DRAFT_INV_NO")],
				invNo = rowData[_colInv.indexOf("INV_NO")],
				pinCode = _invs.filter(p => p.INV_NO == invNo).map(x => x.PinCode)[0],
				ordNo = rowData[_colInv.indexOf("ORD_NO")],
				invPayStatus = _invs.filter(p => p.INV_NO == invNo).map(x => x.INV_PAY_STATUS)[0];

			// if( invPayStatus == "Y" ){
			// 	$(".toast").remove();
			// 	toastr["info"]("<b>Không thể hủy!<b><br><br>Phiếu tính cước này đã được xác nhận thanh toán!");
			// 	return;
			// }

			if (!invNo && !invPayStatus) { // truong hop ko co so hd + ko co trang thai thanh toan -> set = C de huy PTC
				invPayStatus = 'C';
			}

			var contentRemoveOrder = !ordNo ?
				`` :
				'<span class="text-muted font-italic font-bold">Lệnh này đã được thực hiện</span>';

			$.confirm({
				columnClass: 'col-md-6 col-md-offset-3',
				type: 'red',
				title: invPayStatus != "C" ? 'Đã có Hóa Đơn, không thể hủy phiếu tính cước!' : "Hủy phiếu tính cước",
				content: `<div class="px-2 pt-2">` + (invPayStatus != "C" ?
					`` :
					`<div class="form-group">
						<label class="checkbox checkbox-blue"><input type="checkbox" id="applyRemoveOrder" value="">
							<span class="input-span"></span>Đồng thời xoá các lệnh liên quan
						</label>
					</div>
					<div class="form-group">
						<textarea autofocus class="form-control form-control-sm font-size-14" id="cremark" placeholder="Nhập lý do hủy" rows=5 ></textarea>
					</div>`) + '</div>',
				onContentReady: function() {
					if (invPayStatus != "C") {
						$(".draft-confirm-cancel").addClass("hiden-input");
						$("#applyCancelInv").on("change", function(e) {
							$("#cremark, .draft-confirm-cancel").toggleClass("hiden-input");
						});
					}
				},
				buttons: {
					ok: {
						text: 'Xác nhận hủy',
						btnClass: 'btn-sm btn-primary btn-confirm draft-confirm-cancel',
						keys: ['Enter'],
						action: function() {
							var input = this.$content.find('textarea#cremark');
							var errorText = this.$content.find('.text-danger');
							if (!input.val().trim()) {
								$.alert({
									title: "Thông báo",
									content: "Vui lòng nhập lý do phiếu tính cước!.",
									type: 'red'
								});
								return false;
							} else {
								if (invPayStatus != "C") {
									cancelEInv($(e.target).closest("td"), pinCode, invNo, input.val(), true);
								} else {
									cancelDraft($(e.target).closest("td"), draftNo, input.val());
								}
							}
						}
					},
					later: {
						text: 'Quay lại',
						btnClass: 'btn-sm',
						keys: ['ESC']
					}
				}
			});
		});

		function loadInv() {
			tblInv.dataTable().fnClearTable();
			tblInv.waitingLoad();

			var btn = $("#load-data");
			btn.button("loading");

			var formData = {
				"action": "view",
				"act": "search_inv",
				"fromDate": $("#issueDateFrom").val(),
				"toDate": $("#issueDateTo").val(),
				"typeOfDate": $("input[name='dateOf']:checked").val(),
				"cusID": $('#cusID').val(),
				"searchVal": $('#searchValue').val(),
				"paymentStatus": $("input[name='payment-status']:checked").map(function(_, el) {
					return $(el).val();
				}).get(),
				"paymentType": $("input[name='payment-type']:checked").map(function(_, el) {
					return $(el).val();
				}).get(),
				"sys": $("input[name='sys']:checked").val()
			};

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlCancelEntries')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					btn.button("reset");

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					var rows = [];

					if (data.invs && data.invs.length > 0) {
						_invs = data.invs;

						$.each(data.invs, function(i, item) {
							var r = [];
							$.each(_colInv, function(idx, colname) {
								var val = "";
								switch (colname) {
									case "STT":
										val = i + 1;
										break;
									case "Action":
										if (item["DRAFT_PAY_STATUS"] && item["DRAFT_PAY_STATUS"] != "C") {
											val = `<button type="button" title="Hủy phiếu tính cước" class="btn btn-xs btn-outline-secondary cancel-draft"
														data-loading-text="<i class='la la-spinner spinner'></i>">
														Hủy PTC
													</button>`;
										}

										// if (item["INV_NO"] && ["U", "Y"].indexOf(item["INV_PAY_STATUS"]) != -1) {
										// 	val += ` <button type="button" title="Hủy hóa đơn" class="btn btn-xs btn-outline-secondary cancel-inv"
										// 				data-loading-text="<i class='la la-spinner spinner'></i>">
										// 				Hủy HĐ
										// 			</button>`;
										// }
										break;
									case "DRAFT_PAY_STATUS":
									case "INV_PAY_STATUS":
										val = item[colname] == "Y" ?
											"Đã thanh toán" :
											(item[colname] == "U" ? "Chưa thanh toán" :
												(item[colname] == "C" ? "Đã hủy" : ""));
										break;
									case "CancelDate":
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

					tblInv.dataTable().fnClearTable();
					if (rows.length > 0) {
						tblInv.dataTable().fnAddData(rows);
					}
				},
				error: function(err) {
					tblInv.dataTable().fnClearTable();
					btn.button("reset");
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
					console.log(err);
				}
			});
		}

		function load_payer() {
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlCancelEntries')); ?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function(data) {

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					var rows = [];

					if (data.payers && data.payers.length > 0) {
						_payers = data.payers;
						var i = 0;
						$.each(_payers, function(index, rData) {
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
					}
				},
				error: function(err) {
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		};

		function fillPayer() {
			var py = _payers.filter(p => p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());

			if (py.length > 0) { //fa-check-square
				$('#payer-name').text(py[0].CusName);
				$('#payer-addr').text(py[0].Address);
				$('#payment-type').attr('data', py[0].CusType);
				$('#payment-type').text(py[0].CusType == 'M' ? "Thu ngay" : "Thu sau");

				// if( py[0].Email ){
				// 	$("#mail").val( py[0].Email );
				// }

				// if( py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email ){
				// 	$("#mail").val( $("#mail").val() + ',' + py[0].EMAIL_DD );
				// }

				$("#taxcode").removeClass("error");
			}
		}

		function clearPayer() {
			$('#taxcode').val("");
			$("#cusID").val("");
			$('#payer-name').text(" [Tên đối tượng thanh toán]");
			$('#payer-addr').text(" [Địa chỉ]");
			$('#payment-type').attr('data', "");
			$('#payment-type').text(" [Hình thức thanh toán]");
		}

		function cancelEInv(actionCell, pinCode, invNo, cancelReason, isCancelDraft) {}

		function cancelLocalInv(actionCell, invNo, cancelReason, isCancelDraft, removeOrder) {
			var formData = {
				action: "edit",
				act: "cancelLocalInv",
				invNo: invNo,
				cancelReason: cancelReason
			};

			if (isCancelDraft) {
				var draftNo = actionCell.parent().find("td:eq(" + _colInv.indexOf("DRAFT_INV_NO") + ")").text();
				formData["draftNo"] = draftNo;
				formData['removeOrder'] = removeOrder ? removeOrder : ($('#applyRemoveOrder').is(':checked') ? 1 : 0);
			}

			actionCell.blockUI();

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlCancelEntries')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					actionCell.unblock();

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					actionCell.parent().find("td:eq(" + _colInv.indexOf("INV_PAY_STATUS") + ")").text("Đã hủy");
					actionCell.parent().find("td:eq(" + _colInv.indexOf("Action") + ")").find("button.cancel-inv").remove();
					_invs.filter(p => p.INV_NO == invNo).map(x => x.INV_PAY_STATUS = 'C');

					if (isCancelDraft) {
						actionCell.parent().find("td:eq(" + _colInv.indexOf("DRAFT_PAY_STATUS") + ")").text("Đã hủy");
						actionCell.parent().find("td:eq(" + _colInv.indexOf("Action") + ")").find("button.cancel-draft").remove();
						_invs.filter(p => p.DRAFT_INV_NO == formData.draftNo).map(x => x.DRAFT_PAY_STATUS = 'C');
					}

					tblInv.DataTable().columns.adjust();

					toastr["success"]("Hủy thành công Hóa đơn [" + formData.invNo + "]!");

					if (formData.draftNo) {
						toastr["success"]("Hủy thành công PTC [" + formData.draftNo + "]!");
					}
				},
				error: function(err) {
					actionCell.unblock();
					toastr["error"]("Server Error: [Cancel Invoice(2)]");
					console.log(err);
				}
			});
		}

		function cancelDraft(actionCell, draftNo, cancelReason, removeOrder) {
			var formData = {
				action: "edit",
				act: "cancelDraft",
				draftNo: draftNo,
				cancelReason: cancelReason
			}

			formData['removeOrder'] = removeOrder ? removeOrder : ($('#applyRemoveOrder').is(':checked') ? 1 : 0);

			var isBlock = false;
			if (actionCell.find("div.blockUI").length == 0) {
				actionCell.blockUI();
				isBlock = true;
			}

			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlCancelEntries')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {

					if (isBlock) {
						actionCell.unblock();
					}

					if (data.deny) {
						toastr["error"](data.deny);
						return;
					}

					if (data.error) {
						$(".toast").remove();
						toastr["error"](data.error);
						return;
					}

					actionCell.parent().find("td:eq(" + _colInv.indexOf("DRAFT_PAY_STATUS") + ")").text("Đã hủy");
					actionCell.parent().find("td:eq(" + _colInv.indexOf("Action") + ")").find("button.cancel-draft").remove();
					_invs.filter(p => p.DRAFT_INV_NO == formData.draftNo).map(x => x.DRAFT_PAY_STATUS = 'C');

					toastr["success"]("Hủy thành công PTC [" + formData.draftNo + "]!");
				},
				error: function(err) {
					if (isBlock) {
						actionCell.unblock();
					}
					toastr["error"]("Server Error: [cancelDraft]");
					console.log(err);
				}
			});
		}

	});
</script>

<script src="<?= base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>