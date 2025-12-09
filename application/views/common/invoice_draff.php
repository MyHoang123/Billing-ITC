<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	.wrapok {
		white-space:normal!important;
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
	}
	@media (max-width: 768px) {
		label[id="ph"]::after  {
			content: 'P. hành';
		}
		label[id="hb"]::after  {
			content: 'Hủy';
		}
		label[id="xn"]::after  {
			content: 'X. nhận';
		}
	}
	@media (min-width: 800px) {
		label[id="ph"]::after  {
			content: 'Phát hành';
		}
		label[id="hb"]::after  {
			content: 'Hủy bỏ';
		}
		label[id="xn"]::after  {
			content: 'Xác nhận';
		}
		.modal-dialog-mw   {
			min-width: 650px!important;
		}

	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">DANH SÁCH PHIẾU TÍNH CƯỚC</div>
			</div>
			<div class="ibox-body">
				<div class="row">
					<div class="col-xl-4 col-lg-6 col-md-7 col-sm-7 col-xs-12">
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-form-label mr-0">Ngày lệnh</label>
							<div class="row col-xl-9 col-lg-8 col-md-8 col-sm-8">
								<div class="input-group">
									<input class="form-control form-control-sm" id="inv_date" type="text">
									<span class="input-group-addon bg-white btn" title="Bỏ chọn ngày" style="padding: 0 .6rem"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-form-label">Hãng KT</label>
							<div class="row col-xl-9 col-lg-8 col-md-8 col-sm-8">
								<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" data-live-search="true">
									<option value="" selected>-- [Hãng KT] --</option>
									<?php if(isset($oprs) && count($oprs) > 0){ foreach ($oprs as $item){ ?>
										<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-form-label">ĐTTT</label>
							<div class="row col-xl-9 col-lg-8 col-md-8 col-sm-8">
								<div class="input-group">
									<input type="text" id="dttt" style="display: none;">
									<input class="form-control form-control-sm" id="payer-name" placeholder="Đối tượng thanh toán" type="text" readonly>
									<span class="dropdown input-group-addon bg-white px-2">
										<a class="messenger-more dropdown-toggle" data-toggle="dropdown">
											<span class="la la-angle-down"></span>
										</a>
										<div class="dropdown-menu dropdown-menu-left">
											<a class="dropdown-item" id="search-payer" data-toggle="modal" data-target="#payer-modal" onclick="search_payer()" >
												<span class="fa fa-search mr-2"></span>Tìm</a>
											<a class="dropdown-item" id="unselect-payer">
												<span class="fa fa-times mr-2"></span>Bỏ chọn</a>
										</div>
									</span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-form-label">Lập bởi</label>
							<div class="row col-xl-9 col-lg-8 col-md-8 col-sm-8">
								<div class="input-group">
									<input class="form-control form-control-sm" id="createdBy" type="text">
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6 col-md-5 col-sm-5 col-xs-12 mt-1">
						<div class="row form-group mb-4">
							<div style="border-bottom: 1px solid #eee;">
								<label class="checkbox checkbox-blue mr-4">
									<input type="checkbox" name="INV_TYPE" value="CAS" checked>
									<span class="input-span"></span>
									Thu ngay
								</label>
								<label class="checkbox checkbox-blue">
									<input type="checkbox" name="INV_TYPE" value="CRE">
									<span class="input-span"></span>
									Thu sau
								</label>
							</div>
						</div>
						<div class="row form-group mb-4">
							<div style="border-bottom: 1px solid #eee;">
								<label class="checkbox checkbox-blue mr-4" id="ph">
									<input type="checkbox" name="PAYMENT_STATUS" value="U">
									<span class="input-span"></span>
								</label>
								<label class="checkbox checkbox-blue mr-4" id="hb">
									<input type="checkbox" name="PAYMENT_STATUS" value="C">
									<span class="input-span"></span>
								</label>
								<label class="checkbox checkbox-blue" id="xn">
									<input type="checkbox" name="PAYMENT_STATUS" value="Y" checked>
									<span class="input-span"></span>
								</label>
							</div>
						</div>
						<div class="row form-group mb-4">
							<div style="border-bottom: 1px solid #eee;">
								<label class="checkbox checkbox-blue mr-4">
									<input type="checkbox" name="CURRENCYID" value="VND" checked>
									<span class="input-span"></span>
									VNĐ
								</label>
								<label class="checkbox checkbox-blue">
									<input type="checkbox" name="CURRENCYID" value="USD">
									<span class="input-span"></span>
									USD
								</label>
							</div>
						</div>
						<div class="row form-group">
							<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon btn-sm">
								<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0">
							<thead>
							<tr>
								<th>STT</th>
								<th>Số phiếu</th>
								<th>Ngày lập</th>
								<th>Số lệnh </th>
								<th>Đối tượng TT</th>
								<th>Diễn giải</th>
								<th>Loại hàng</th>
								<th>F/E</th>
								<th>SZ (Kích cỡ)</th>
								<th>Qty (Số lượng)</th>
								<th>Thành tiền</th>
								<th>VAT (10%)</th>
								<th>VAT (Tiền thuế)</th>
								<th>Chiết khấu HĐ</th>
								<th>Tổng tiền</th>
								<th>Ghi chú</th>
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
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn Đối tượng TT</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tbl-search-payer" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th style="width: 20px">STT</th>
							<th>Mã</th>
							<th>Tên</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="select-payer" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		$('#tbl-search-payer').DataTable({
			infor: false
		});

		$('#inv_date').daterangepicker({
			autoUpdateInput: true,
			startDate: moment().subtract(1, 'month'),
			endDate: moment(),
			locale: {
				cancelLabel: 'Xóa',
				applyLabel: 'Chọn',
				format: 'DD/MM/YYYY'
			}
		});
		$('#inv_date').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		});
		$('#inv_date').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});
		$('#inv_date + span').on('click', function () {
			$('#inv_date').val('');
		});

		//select payer
		$(document).on('click','#tbl-search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-payer').on('click', function () {
			var r = $('#tbl-search-payer tbody').find('tr.m-row-selected').first();
			$('#dttt').val($(r).closest("tr").find('td:eq(1)').text());
			$('#payer-name').val($(r).closest("tr").find('td:eq(2)').text());
		});
		$('#unselect-payer').on('click', function () {
			$('#dttt').val('');
			$('#payer-name').val('');
		});
		$('#tbl-search-payer').on('dblclick','tbody tr td:not(.dataTables_empty)', function() {
			$('#dttt').val($(this).closest("tr").find('td:eq(1)').text());
			$('#payer-name').val($(this).closest("tr").find('td:eq(2)').text());
			$('#payer-modal').modal("toggle");
		});

		$('#search').on('click', function () {
			$("#contenttable tr:not(:first)").remove();
			$("#contenttable tbody:first").append('<tr>' +
				'<td colspan="16" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
				'</tr>');
			var fromdate = $('#inv_date').val() ? $('#inv_date').val().split('-')[0].trim() : '';
			var todate = $('#inv_date').val() ? $('#inv_date').val().split('-')[1].trim() : '';
			var inv_type = [];
			var payment_stt = [];
			var currencyid = [];
			$('input[name="INV_TYPE"]:checked').each(function () {
				inv_type.push($(this).val());
			});
			$('input[name="PAYMENT_STATUS"]:checked').each(function () {
				payment_stt.push($(this).val());
			});
			$('input[name="CURRENCYID"]:checked').each(function () {
				currencyid.push($(this).val());
			});

			var formData = {
				'action': 'view',
				'fromdate':fromdate,
				'todate':todate,
				'payment_status': payment_stt,
				'inv_type': inv_type,
				'currencyid': currencyid,
				'opr': $('#opr').val(),
				'cusid': $('#dttt').val(),
				'createdby': $('#createdBy').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmInvDraff'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							rows.push([
								  (i+1)
								, data.list[i].DRAFT_INV_NO
								, getDateTime(data.list[i].INV_DATE)
								, data.list[i].REF_NO
								, data.list[i].CusName
								, data.list[i].TRF_DESC
								, data.list[i].CARGO_TYPE
								, data.list[i].FE
								, data.list[i].SZ
								, data.list[i].QTY
								, data.list[i].AMOUNT
								, data.list[i].VAT_RATE
								, data.list[i].DISCOUNT_VAT
								, data.list[i].DISCOUNT_AMT
								, data.list[i].TAMOUNT
								, data.list[i].Remark
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
//							{ className: "wrapok", targets: [4, 5, 15] },
//							{ className: "text-right", targets: [9, 10, 11, 12, 13, 14] },
//							{ className: "text-center", targets: [0, 2] },
							{
								targets: [9, 10, 11, 12, 13, 14],
								render: $.fn.dataTable.render.number( ',', '.', 2)
							}
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 12,
							boundaryScale: 0.85
						}
					} );
				},
				error: function(err){console.log(err);}
			});
		});
	});
</script>

<script>
	function search_payer(){
		$("#tbl-search-payer tr:not(:first)").remove();
		$("#tbl-search-payer tbody:first").append('<tr>' +
			'<td colspan="3" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
			'</tr>');
		var formdata = {
			'actions': 'searh_payer'
		};
		$.ajax({
			url: "<?=site_url(md5('Common') . '/' . md5('cmInvDraff'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				$('#tbl-search-payer').dataTable().fnDestroy();
				var rows = [];
				if(data.payers.length > 0) {
					for (i = 0; i < data.payers.length; i++) {
						rows.push([ (i+1)
							, data.payers[i].PAYER
							, data.payers[i].CusName
						]);
					}
				}
				$('#tbl-search-payer').DataTable( {
					data: rows,
					columnDefs: [
						{ className: "wrapok", targets: [2] },
						{ width: "20px", targets: 0 },
						{ className: "text-center", targets: 0 }
					],
					order: [[ 0, 'asc' ]],
					scroller: {
						displayBuffer: 9,
						boundaryScale: 0.2
					}
				} );
			},
			error: function(err){console.log(err);}
		});
	}
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
