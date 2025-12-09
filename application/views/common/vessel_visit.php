<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	.hidden-filter{
		display: none;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">TÀU CẬP CẢNG</div>
			</div>
			<div class="ibox-body">
				<div class="row col-md-12 col-sm-12 col-xs-12 pb-2">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						<label class="radio radio-outline-primary" style="padding-right: 20px">
							<input name="filter-opt" type="radio" id="bydistance" value="1" checked>
							<span class="input-span"></span>
							Khoảng thời gian
						</label>
						<label class="radio radio-outline-primary">
							<input name="filter-opt" id="bymonthyear" value="2" type="radio">
							<span class="input-span"></span>
							Tháng/năm
						</label>
					</div>
				</div>
				<div class="row col-md-12 col-sm-12 col-xs-12">
					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-5 col-xs-5 form-group f-dist">
						<div class="input-group-icon input-group-icon-left">
							<span class="input-icon input-icon-left"><i class="ti-alarm-clock"></i></span>
							<input id="from-date" class="form-control form-control-sm form-control-air" placeholder="Từ ngày" type="text">
						</div>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-5 col-xs-5 form-group f-dist">
						<div class="input-group-icon input-group-icon-left">
							<span class="input-icon input-icon-left"><i class="ti-alarm-clock"></i></span>
							<input id="to-date" class="form-control form-control-sm form-control-air" placeholder="Đến ngày" type="text">
						</div>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-4 form-group f-my hidden-filter">
						<select id="fi-month" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-4 form-group f-my hidden-filter">
						<select id="fi-year" class="selectpicker" data-width="100%" data-style="btn-default btn-sm">
							<option value="2018" selected>2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
						</select>
					</div>
					<div class="col-md-1 col-sm-2 col-xs-2 form-group">
						<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon btn-sm">
							<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
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
								<th>Mã Tàu</th>
								<th>Năm</th>
								<th>Chuyến</th>
								<th>Tên Tàu</th>
								<th>Hãng Tàu</th>
								<th>CALL NO.</th>
								<th>ALONGSIDE</th>
								<th>IN-VOY NO.</th>
								<th>OUT-VOY NO.</th>
								<th>ETA</th>
								<th>ETB</th>
								<th>ETW</th>
								<th>ETD</th>
								<th>ATA</th>
								<th>ATW</th>
								<th>ATD</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		$('#from-date, #to-date').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			todayBtn: true,
			minuteStep: 0
		});

		if(isMobile.any()){
			$('#fi-year, #fi-month').selectpicker('mobile');
		}

		$('input[name="filter-opt"]').on('change', function () {
			$('.f-dist, .f-my').toggleClass('hidden-filter');
		});

		$('#search').on('click', function () {
			$("#contenttable").waitingLoad();
			var fromdate, todate;
			if($('input[name="filter-opt"]:checked').val() == "1"){
				fromdate = $('#from-date').val();
				todate = $('#to-date').val();
			}else{
				fromdate = fromDatetoDate($('#fi-month').val(), $('#fi-year').val())[0];
				todate = fromDatetoDate($('#fi-month').val(), $('#fi-year').val())[1];
			}
			var formData = {
				'action': 'view',
				'fromdate':fromdate,
				'todate':todate
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							rows.push([ (i+1)
								, data.list[i].ShipID
								, data.list[i].ShipYear
								, data.list[i].ShipVoy
								, data.list[i].ShipName
								, data.list[i].Opr_CD
								, data.list[i].CALL_NO
								, data.list[i].ALONGSIDE
								, data.list[i].ImVoy
								, data.list[i].ExVoy
								, getDateTime(data.list[i].ETA)
								, getDateTime(data.list[i].ETB)
								, getDateTime(data.list[i].ETW)
								, getDateTime(data.list[i].ETD)
								, getDateTime(data.list[i].ATA)
								, getDateTime(data.list[i].ATW)
								, getDateTime(data.list[i].ATD)
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						order: [[ 0, 'asc' ]],
						columnDefs: [
							{ className: "text-center", targets: [0] }
						],
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

<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>