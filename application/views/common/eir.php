<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	@media (orientation:landscape) {
		.mobile-hiden    {
			display: none!important;
		}
	}
	@media (orientation:portrait) {
		.mobile-pt-hiden   {
			display: none!important;
		}
	}
	@media (min-width: 1366px) and (orientation:landscape) {
		.mobile-pt-hiden    {
			display: none!important;
		}
		.mobile-hiden    {
			display: inherit!important;
		}
	}

	@media (max-width: 960px) {
		.mobile-pt-5   {
			padding-top: 15px!important;
		}
	}
	@media (min-width: 960px) {
		.modal-dialog-mw   {
			min-width: 750px!important;
		}
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
	}
	.e-pt-1{
		padding-top: 2px;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">DANH SÁCH LỆNH NÂNG HẠ</div>
			</div>
			<div class="ibox-body">
				<div class="row">
					<div class="col-xl-4 col-lg-6 col-md-7 col-sm-8 col-xs-8">
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label">Ngày lệnh</label>
							<div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-xs-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm text-center" id="eir_date" type="text" placeholder="Ngày lệnh">
									<span class="input-group-addon bg-white btn px-2 border-left-0" title="Bỏ chọn ngày"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label">Hãng KT</label>
							<div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<select id="opr" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" data-live-search="true">
									<option value="" selected>-- [Hãng KT] --</option>
									<?php if(isset($oprs) && count($oprs) > 0){ foreach ($oprs as $item){ ?>
										<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label">HTTT</label>
							<div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<select id="httt" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
									<option value="" selected>-- [HTTT] --</option>
									<option value="M" >Tiền mặt</option>
									<option value="C" >Trả sau</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-xs-4 col-form-label">Số Cont</label>
							<div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input class="form-control form-control-sm" id="cntrNo" placeholder="Số container" type="text">
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-5 col-sm-4 col-xs-4">
						<div class="row form-group mobile-pt-hiden">
							<div class="col-sm-12 btn-group">
								<div class="btn btn-outline-secondary btn-sm" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()"><i class="ti-search"></i></div>
								<div id="unselect-ship" class="btn btn-outline-secondary btn-sm" title="bỏ chọn"><i class="fa fa-times" title="bỏ chọn"></i></div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12 input-group">
								<input class="form-control form-control-sm" id="shipid" placeholder="Tên tàu" type="text" readonly>
								<span class="input-group-addon bg-white ml-1 border mobile-hiden" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()">
									<i class="ti-search"></i></span>
								<span id="unselect-ship-1" class="btn bg-white input-group-addon ml-1 border mobile-hiden" title="bỏ chọn"><i class="fa fa-times"></i></span>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12">
								<div class="input-group input-group-sm">
									<input class="form-control" id="shipyear" placeholder="Năm" type="text" readonly>
									<input class="form-control ml-1" id="voy" placeholder="Chuyến" type="text" readonly style="width: 53%!important">
								</div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12 e-pt-1">
								<input class="form-control form-control-sm" id="etb" placeholder="Ngày cập" type="text" readonly>
							</div>
						</div>
						<div class="input-hidden">
							<input type="text" id="shipkey">
							<input type="text" id="imvoy">
							<input type="text" id="exvoy">
						</div>
					</div>
					<div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-4 mobile-pt-5">
						<div class="col-sm-12 form-group mt-2" style="border-bottom: solid 1px #eee">
							<label class="radio radio-outline-primary" style="padding-right: 20px">
								<input name="xnvc-opt" type="radio" id="xnvc-all" value="" checked>
								<span class="input-span"></span>
								Tất cả
							</label>
							<label class="radio radio-outline-primary" style="padding-right: 20px">
								<input name="xnvc-opt" id="xnvc-finish" value="1" type="radio">
								<span class="input-span"></span>
								Hoàn thành
							</label>
							<label class="radio radio-outline-primary">
								<input name="xnvc-opt" id="xnvc-unfinish" value="0" type="radio">
								<span class="input-span"></span>
								Chưa hoàn thành
							</label>
						</div>
						<div class="col-sm-12 form-group mt-4" style="border-bottom: solid 1px #eee">
							<label class="checkbox checkbox-inline checkbox-blue">
								<input type="checkbox" name="method" id="laynguyen" value="LAYN">
								<span class="input-span"></span>Lấy nguyên</label>
							<label class="checkbox checkbox-inline checkbox-blue">
								<input type="checkbox" name="method" id="caprong" value="CAPR">
								<span class="input-span"></span>Cấp rỗng</label>
							<label class="checkbox checkbox-inline checkbox-blue">
								<input type="checkbox" name="method" id="habai" value="HBAI">
								<span class="input-span"></span>Hạ bãi</label>
							<label class="checkbox checkbox-inline checkbox-blue" >
								<input type="checkbox" name="method" id="trarong" value="TRAR">
								<span class="input-span"></span>Trả rỗng</label>
						</div>
						<div class="col-sm-2 form-group">
							<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon btn-sm">
								<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Số container</th>
								<th>Số lệnh</th>
								<th>Ngày lệnh</th>
								<th>Ngày hết hạn lệnh</th>
								<th>Hạn sử dụng điện</th>
								<th>Qua cổng</th>
								<th>Hãng khai thác</th>
								<th>Kích cỡ nội bộ</th>
								<th>Kích cỡ ISO</th>
								<th>Loại hàng</th>
								<th>F/E</th>
								<th>Mã tàu/ Năm/ Chuyến</th>
								<th>Phương án</th>
								<th>Phương thức giao nhận</th>
								<th>Phương tiện</th>
								<th>Trọng lượng</th>
								<th>Số vận đơn</th>
								<th>Số Booking</th>
								<th>Số niêm chì</th>
								<th>Số niêm chì 1</th>
								<th>Số niêm chì 2</th>
								<th>Nơi trả vỏ</th>
								<th>Hàng nội/ngoại</th>
								<th>Đối tượng thanh toán</th>
								<th>Ghi chú</th>
								<th>Người phát hành lệnh</th>
								<th>Số phiếu tính cước</th>
								<th>Số hóa đơn</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false
		});

		autoLoadYearCombo('cb-searh-year');

		$('#eir_date').daterangepicker({
			autoUpdateInput: true,
			startDate: moment().subtract(1, 'month'),
			endDate: moment(),
			locale: {
				cancelLabel: 'Xóa',
				applyLabel: 'Chọn',
				format: 'DD/MM/YYYY'
			}
		});
		$('#eir_date').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		});

		$('#eir_date').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		$('#eir_date + span').on('click', function () {
			$('#eir_date').val('');
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
		$('#unselect-ship-1, #unselect-ship').on('click', function () {
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

		$('#search').on('click', function () {

			$("#contenttable tr:not(:first)").remove();
			$("#contenttable tbody:first").append('<tr>' +
				'<td colspan="28" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
				'</tr>');
			var fromdate = $('#eir_date').val() ? $('#eir_date').val().split('-')[0].trim() : '';
			var todate = $('#eir_date').val() ? $('#eir_date').val().split('-')[1].trim() : '';
			var arr_method = [];
			$('input[name="method"]:checked').each(function () {
				arr_method.push($(this).val());
			});

			var formData = {
				'action': 'view',
				'fromdate':fromdate,
				'todate':todate,
				'opr': $('#opr').val(),
				'httt': $('#httt').val(),
				'cntrNo': $('#cntrNo').val(),
				'xnvc': $('input[name="xnvc-opt"]:checked').val(),
				'shipkey': $('#shipkey').val(),
				'method': arr_method
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmEir'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							rows.push([
								  (i+1)
								, data.list[i].CntrNo
								, data.list[i].EIRNo
								, getDateTime(data.list[i].IssueDate)
								, getDateTime(data.list[i].ExpDate)
								, getDateTime(data.list[i].ExpPluginDate)
								, data.list[i].bXNVC
								, data.list[i].OprID
								, data.list[i].LocalSZPT
								, data.list[i].ISO_SZTP
								, data.list[i].CARGO_TYPE
								, data.list[i].Status
								, data.list[i].ShipID+"/ "+(data.list[i].ImVoy?data.list[i].ImVoy:'')+"/ "+(data.list[i].ExVoy?data.list[i].ExVoy:'')
								, data.list[i].CJMode_CD
								, data.list[i].DMethod_CD
								, data.list[i].TruckNo
								, data.list[i].CMDWeight
								, data.list[i].BLNo
								, data.list[i].BookingNo
								, data.list[i].SealNo
								, data.list[i].SealNo1
								, data.list[i].SealNo2
								, data.list[i].RetLocation
								, data.list[i].IsLocal
								, data.list[i].CusName
								, data.list[i].Note
								, data.list[i].CreatedBy
								, data.list[i].DRAFT_INV_NO
								, data.list[i].InvNo
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
							{ width: "30px", targets: 0 },
							{ className: "text-center", targets: 0 }
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 9,
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
</script>
<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>