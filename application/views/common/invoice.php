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
	@media (min-width: 960px) {
		.modal-dialog-mw   {
			min-width: 750px!important;
		}
	}
	@media (min-width: 800px) {
		.modal-dialog-mw-py   {
			min-width: 650px!important;
		}
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">DANH SÁCH HÓA ĐƠN</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-xl-5 col-lg-7 col-md-7 col-sm-7 col-xs-12 pt-3">
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Ngày lệnh</label>
							<div class="col-sm-9 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm" id="inv_date" type="text">
									<span class="input-group-addon bg-white btn" title="Bỏ chọn ngày" style="padding: 0 .6rem"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">ĐTTT</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" id="payer" style="display: none;">
									<input class="form-control form-control-sm" id="payer-name" placeholder="Đối tượng thanh toán" type="text" readonly>
									<span class="dropdown input-group-addon bg-white px-2">
										<a class="messenger-more dropdown-toggle" data-toggle="dropdown">
											<span class="la la-angle-down"></span>
										</a>
										<div class="dropdown-menu dropdown-menu-left">
											<a class="dropdown-item" id="search-payer" data-toggle="modal" data-target="#payer-tariff-modal" onclick="search_payer_tariff(this.id)" >
												<span class="fa fa-search mr-2"></span>Tìm</a>
											<a class="dropdown-item" id="unselect-payer">
												<span class="fa fa-times mr-2"></span>Bỏ chọn</a>
										</div>
									</span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Biểu cước</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" id="tariff" style="display: none;">
									<input class="form-control form-control-sm" id="tariff-name" placeholder="Biểu cước" type="text" readonly>
									<span class="dropdown input-group-addon bg-white px-2">
										<a class="messenger-more dropdown-toggle" data-toggle="dropdown">
											<span class="la la-angle-down"></span>
										</a>
										<div class="dropdown-menu dropdown-menu-left">
											<a class="dropdown-item" id="search-tariff" data-toggle="modal" data-target="#payer-tariff-modal" onclick="search_payer_tariff(this.id)" >
												<span class="fa fa-search mr-2"></span>Tìm</a>
											<a class="dropdown-item" id="unselect-tariff">
												<span class="fa fa-times mr-2"></span>Bỏ chọn</a>
										</div>
									</span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Lập bởi</label>
							<div class="col-sm-9 input-group input-group-sm">
								<input class="form-control form-control-sm" id="createdBy" type="text" placeholder="Lập bởi">
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-5 col-md-5 col-sm-5 col-xs-12 pt-3">
						<div class="row form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 1px">
								<div class="input-group">
									<input class="form-control form-control-sm" id="shipid" placeholder="Tên tàu" type="text" readonly>
									<span class="input-group-addon bg-white ml-1 border mobile-hiden" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()">
										<i class="ti-search"></i></span>
									<span id="unselect-ship" class="btn bg-white input-group-addon ml-1 border mobile-hiden" title="bỏ chọn"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 1px">
								<div class="input-group">
									<input class="form-control form-control-sm gr-lc-size" id="shipyear" placeholder="Năm" type="text" readonly style="width: 32%!important">
									<input class="form-control form-control-sm ml-1 gr-lc-size" id="voy" placeholder="Chuyến" type="text" readonly style="width: 68%!important">
								</div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<input class="form-control form-control-sm" id="etb" placeholder="Ngày cập" type="text" readonly>
							</div>
						</div>
						<div class="input-hidden">
							<input type="text" id="shipkey">
							<input type="text" id="imvoy">
							<input type="text" id="exvoy">
						</div>
						<div class="row form-group">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label class="checkbox checkbox-blue mr-3  mt-2">
									<input type="checkbox" name="CURRENCYID" value="VND" checked>
									<span class="input-span"></span>
									VNĐ
								</label>
								<label class="checkbox checkbox-blue mt-2">
									<input type="checkbox" name="CURRENCYID" value="USD">
									<span class="input-span"></span>
									USD
								</label>
								<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon btn-sm" style="float: right">
									<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>STT</th>
							<th>Ngày lập</th>
							<th>Số hóa đơn</th>
							<th>Số phiếu tính cước</th>
							<th>Số lệnh</th>
							<th style="max-width: 250px;">Diễn giải</th>
							<th style="max-width: 250px;">Đối tượng TT</th>
							<th>Mã số thuế</th>
							<th>Thành tiền</th>
							<th>CK tiền phạt</th>
							<th>VAT(%)</th>
							<th>VAT (Tiền thuế)</th>
							<th>Tổng tiền</th>
							<th>Lập bởi</th>
							<th style="max-width: 150px;">Ghi chú</th>
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
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-1">
						<div class="form-group">
							<label class="radio radio-outline-primary" style="padding-right: 20px">
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
			<div class="modal-body">
				<div class="table-responsive">
					<table id="search-ship" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
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
<!--payer modal-->
<div class="modal fade" id="payer-tariff-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-dialog-mw-py" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn Đối tượng TT</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="tbl-search-payer-tariff" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
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
				<button type="button" id="select-payer-tariff" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false
		});
		$('#tbl-search-payer-tariff').DataTable({
			infor: false
		});

		autoLoadYearCombo('cb-searh-year');

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

		//select vessel
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

			$('#shipkey').val($(r).closest("tr").find('td:first').text());
			$('#shipid').val($(r).closest("tr").find('td:eq(2)').text());
			$('#shipyear').val($('#cb-searh-year').val());
			$('#voy').val($(r).closest("tr").find('td:eq(3)').text() +' / '+ $(r).closest("tr").find('td:eq(4)').text());  //.val(rows[3] +' / ' + rows[4]);
			$('#etb').val($(r).closest("tr").find('td:eq(5)').text());
			$('#etd').val($(r).closest("tr").find('td:eq(6)').text());
			$('#imvoy').val($(r).closest("tr").find('td:eq(3)').text());
			$('#exvoy').val($(r).closest("tr").find('td:eq(4)').text());
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
			$('#shipkey').val($(this).closest("tr").find('td:first').text());
			$('#shipid').val($(this).closest("tr").find('td:eq(2)').text());
			$('#shipyear').val($('#cb-searh-year').val());
			$('#voy').val($(this).closest("tr").find('td:eq(3)').text() +' / '+ $(this).closest("tr").find('td:eq(4)').text());  //.val(rows[3] +' / ' + rows[4]);
			$('#etb').val($(this).closest("tr").find('td:eq(5)').text());
			$('#etd').val($(this).closest("tr").find('td:eq(6)').text());
			$('#imvoy').val($(this).closest("tr").find('td:eq(3)').text());
			$('#exvoy').val($(this).closest("tr").find('td:eq(4)').text());
			$('#ship-modal').modal("toggle");
		});

		//select payer
		$(document).on('click','#tbl-search-payer-tariff tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-payer-tariff').on('click', function () {
			var r = $('#tbl-search-payer-tariff tbody').find('tr.m-row-selected').first();
			if($('#payer-tariff-modal').attr('data-whatever') == 'search-payer'){
				$('#payer').val($(r).closest("tr").find('td:eq(1)').text());
				$('#payer-name').val($(r).closest("tr").find('td:eq(2)').text());
			}
			if($('#payer-tariff-modal').attr('data-whatever') == 'search-tariff'){
				$('#tariff').val($(r).closest("tr").find('td:eq(1)').text());
				$('#tariff-name').val($(r).closest("tr").find('td:eq(2)').text());
			}
		});
		$('#unselect-payer').on('click', function () {
			$('#payer').val('');
			$('#payer-name').val('');
		});
		$('#unselect-tariff').on('click', function () {
			$('#tariff').val('');
			$('#tariff-name').val('');
		});
		$('#tbl-search-payer-tariff').on('dblclick','tbody tr td:not(.dataTables_empty)', function() {
			if($('#payer-tariff-modal').attr('data-whatever') == 'search-payer'){
				$('#payer').val($(this).closest("tr").find('td:eq(1)').text());
				$('#payer-name').val($(this).closest("tr").find('td:eq(2)').text());
			}
			if($('#payer-tariff-modal').attr('data-whatever') == 'search-tariff'){
				$('#tariff').val($(this).closest("tr").find('td:eq(1)').text());
				$('#tariff-name').val($(this).closest("tr").find('td:eq(2)').text());
			}
			$('#payer-tariff-modal').modal("toggle");
		});

		$('#search').on('click', function () {
			$("#contenttable tr:not(:first)").remove();
			$("#contenttable tbody:first").append('<tr>' +
				'<td colspan="15" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
				'</tr>');
			var fromdate = $('#inv_date').val() ? $('#inv_date').val().split('-')[0].trim() : '';
			var todate = $('#inv_date').val() ? $('#inv_date').val().split('-')[1].trim() : '';
			var arr_currency = [];
			$('input[name="CURRENCYID"]:checked').each(function () {
				arr_currency.push($(this).val());
			});

			var formData = {
				'action': 'view',
				'fromdate':fromdate,
				'todate':todate,
				'payer': $('#payer').val(),
				'tariff': $('#tariff').val(),
				'createdBy': $('#createdBy').val(),
				'shipkey': $('#shipkey').val(),
				'CURRENCYID': arr_currency
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmInv'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							rows.push([
								  (i+1)
								, getDateTime(data.list[i].inv_date)
								, data.list[i].inv_no
								, data.list[i].draft_inv_no
								, data.list[i].REF_NO
								, data.list[i].TRF_DESC
								, data.list[i].CusName
								, data.list[i].VAT_CD
								, data.list[i].amount
								, data.list[i].dis_amt
								, data.list[i].VAT_RATE
								, data.list[i].vat
								, data.list[i].tamount
								, data.list[i].createdby
								, data.list[i].Remark
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
							{ className: "wrapok", targets: [5, 6, 14] },
							{ className: "text-right", targets: [8, 9, 10, 11, 12] },
							{ className: "text-center", targets: [0, 1] },
							{
								targets: [8, 9, 10, 11, 12],
								render: $.fn.dataTable.render.number( ',', '.', 2)
							}
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 7,
							boundaryScale: 0.95
						}
					} );
				},
				error: function(err){console.log(err);}
			});
		});
	});
</script>

<script>
	function search_ship(){
		$("#search-ship tr:not(:first)").remove();
		$("#search-ship tbody:first").append('<tr>' +
			'<td colspan="7" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
			'</tr>');
		var formdata = {
			'actions': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-search-ship').val(),
			'shipname': $('#search-ship-name').val()
		};
		$.ajax({
			url: "<?=site_url(md5('Common') . '/' . md5('cmEir'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				$('#search-ship').dataTable().fnDestroy();
				var rows = [];
				if(data.vsls.length > 0) {
					for (i = 0; i < data.vsls.length; i++) {
						rows.push([
							data.vsls[i].ShipKey
							, (i+1)
							, data.vsls[i].ShipID
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

	function search_payer_tariff(id){
		$('#payer-tariff-modal').attr('data-whatever', id);
		$('#payer-tariff-modal').find('.modal-header .modal-title').first().text(id=='search-payer'? 'Chọn Đối tượng TT' : 'Chọn biểu cước');
		$("#tbl-search-payer-tariff tr:not(:first)").remove();
		$("#tbl-search-payer-tariff tbody:first").append('<tr>' +
			'<td colspan="3" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
			'</tr>');
		var formdata = {
			'actions': id
		};
		$.ajax({
			url: "<?=site_url(md5('Common') . '/' . md5('cmInv'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				$('#tbl-search-payer-tariff').dataTable().fnDestroy();
				var rows = [];
				if(data.results.length > 0) {
					for (i = 0; i < data.results.length; i++) {
						rows.push([ (i+1)
							, data.results[i].ID
							, data.results[i].NAME
						]);
					}
				}
				$('#tbl-search-payer-tariff').DataTable( {
					data: rows,
					columnDefs: [
						{ className: "wrapok", targets: [2] },
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