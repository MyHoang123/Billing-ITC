<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">
<link href="<?=base_url('assets/css/bootstrap-multiselect.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}

	.form-group{
		margin-bottom: 7px;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title" id="panel-title">TẬP HỢP DỊCH VỤ BÃI</div>
				<div class="button-bar-group mr-3">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>				

					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>

					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>

					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dòng"
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body p-3 bg-f9 border-e">
				<div class="row ibox mb-0 border-e p-3">
					<div class="col-12 pb-1">
						<h6>Tiêu chí lọc</h6>
					</div>
					<div class="col-7">
						<div class="row">
							<div class="col-8">
								<div class="row form-group">
									<div class="col-sm-12 input-group">
										<input class="form-control form-control-sm input-required" id="cusID" placeholder="Đối tượng thanh toán" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn đối tượng thanh toán" data-toggle="modal" data-target="#cusID-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-12 input-group">
										<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="bookingNo" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Số vận đơn">
											<option value="" disabled selected>-- [Số vận đơn] --</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="dMethod" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Chủ hàng">
											<option value="" disabled selected>-- [Chủ hàng] --</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="dMethod" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Chọn năm">
											<option value="" selected>-- [Phương thức] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="canggiaonhan" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Cảng giao nhận">
											<option value="" selected>-- [Cảng giao nhận] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="transit" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Chuyển cảng">
											<option value="" selected>-- [Chuyển cảng] --</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="isLocal" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hàng nội/ngoại">
											<option value="" selected>-- [nội/ngoại] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="FE" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hàng/Rỗng">
											<option value="" selected>-- [Hàng/Rỗng] --</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="row form-group">
									<div class="col-md-12 input-group input-group-sm">
										<select id="cntrClass" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hướng nhập/xuất">
											<option value="" selected>-- [Nhập/Xuất] --</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-5" style="border-left: 1px solid #cecece">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control form-control-sm input-required" id="dateStart" type="text" placeholder="Ngày bắt đầu" readonly>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<div class="input-group">
										<input class="form-control form-control-sm input-required" id="dateEnd" type="text" placeholder="Ngày kết thúc" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="OprID" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="multiStuff" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-12 input-group-sm input-group">
								<select class="selectpicker form-control" data-selected-text-format="count > 5" id="multiService" multiple>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
									<option>GMD</option>
									<option>AMG</option>
									<option>AAB</option>
									<option>GMR</option>
									<option>SSC</option>
									<option>SSA</option>
									<option>SSB</option>
									<option>SSS</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-5 table-responsive">
					<table id="tableCont" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel hiden-input">Rowguid</th>
							<th class="editor-cancel">STT</th>
							<th class="editor-cancel data-type-checkbox select-checkbox">
								<div class="form-group mb-0">
									<label class="checkbox check-outline-primary">
										<input type="checkbox" id="checkAll" name="">
										<span class="input-span"></span>
										Xác nhận
									</label>
								</div>
							</th>
							<th>Số container</th>
							<th>Kích cỡ ISO</th>
							<th>Hãng khai thác</th>
							<th>Hướng</th>
							<th>Hàng/Rỗng</th>
							<th>Phương án</th>
							<th>Phương thức</th>
							<th>Loại hàng</th>
							<th>Chủ hàng</th>
							<th>Nội/Ngoại</th>
							<th>Số vận đơn</th>
							<th>Số booking</th>
							<th>Cảng chuyển</th>
							<th>Cảng giao nhận</th>
							<th>Ghi chú</th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-7 table-responsive p-0">
					<table id="tableStatis" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th style="max-width: 70px">Hãng</th>
							<th style="max-width: 40px">Hướng</th>
							<th>Công việc</th>
							<th>20F</th>
							<th>40F</th>
							<th>45F</th>
							<th>20E</th>
							<th>40E</th>
							<th>45E</th>
						</tr>
						</thead>

						<tbody>
							<tr data-toggle='modal' data-target='#info-modal'>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal -->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-dialog-mw-py modal-lg" role="document" style="max-width: 80vw">
		<div class="modal-content p-3">
			<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-12 table-responsive">
						<table id="tableInfo" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th class="editor-cancel hiden-input">Rowguid</th>
								<th class="editor-cancel">STT</th>
								<th>Số container</th>
								<th>Kích cỡ</th>
								<th>Hàng/Rỗng</th>
								<th>Công việc</th>
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto">
					
				</div>
			</div>
		</div>
	</div>
</div>

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-5">
						<div class="row">
							<div class="form-group col-6">
								<label class="radio radio-primary">
									<input id="shipOut" type="radio" name="shipinout" checked="true">
									<span class="input-span"></span>
									Tàu đã rời cảng
								</label>
							</div>
							<div class="form-group col-6">
								<label class="radio radio-primary">
									<input id="shipIn" type="radio" name="shipinout">
									<span class="input-span"></span>
									Tàu đến cảng
								</label>
							</div>
						</div>
					</div>
					<div class="col-7 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-year" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Nhập tên tàu">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body pt-0">
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

<!--select customer-->
<div class="modal fade" id="cusID-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-cusType" title="Loại ĐTTT" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option>Chủ tàu</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-cus-name" type="text" placeholder="Nhập tên đối tượngt thanh toán">
									<img id="btn-search-cus" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body pt-0">
				<div class="table-responsive">
					<table id="search-cusID" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
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

<select id="status" style="display: none">
	<option value="0">Ngưng hoạt động</option>
	<option value="1">Hoạt động</option>
</select>

<select id="httt" style="display: none">
	<option value="0">Thu ngay</option>
	<option value="1">Thu sau</option>
</select>

<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-multiselect.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var _colCont = ["rowguid", "STT", "BILL_CHK", "CntrNo", "ISO_SZTP", "OprID", "cntrClass", "Status", "CJMode_CD", "DMethod_CD", "CARGO_TYPE", "SHIPPER", "isLocal"
							, "BLNo", "BookingNo", "Transit_CD", "GNRL_TYPE", "REMARK"];

		var _colInfo = ["rowguid", "STT", "CntrNo", "LocalSZPT", "Status", "congviec"];

		var _colStatis = ["STT", "OprID", "cntrClass", "cong viec", "20E", "40E", "45E", "20F", "40F", "45F"];

		//define table cont
		var tblCont = $('#tableCont');
		var dataTblCont = tblCont.newDataTable({
			scrollY: '30vh',
			order: [[ _colCont.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            info: false,
            columnDefs: [{
		      targets: 0,
		      width: 20,
		      orderable: false,
		      className: 'select-checkbox'
		    }
		  	],
            // buttons: [],
            searching: false,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            "dom": '<"contTool">frtip',
            rowReorder: false
		});
		$('div.contTool').html('<h6>Danh sách Container</h6>');
		$('#checkAll').on('click', function() {
			if ($('#checkAll').is(':checked')) {
		  		dataTblCont.rows().select();
		  	}
		  	else {
		  		dataTblCont.rows().deselect();
		  	}
		});


		//define table info
		var tblInfo = $('#tableInfo');
		var dataTblInfo = tblInfo.newDataTable({
			scrollY: '25vh',
			order: [[ _colInfo.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            info: false,
            buttons: [],
            searching: false,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});

		//define table statis
		var tblStatis = $('#tableStatis');
		var dataTblStatis = tblStatis.newDataTable({
			scrollY: '30vh',
			order: [[ _colStatis.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            info: false,
            searching: false,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            "dom": '<"statisTool">frtip',
            rowReorder: false
		});
		$('div.statisTool').html('<h6>Thống kê</h6>');

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		$('#search-cusID').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		// define selectpicker
		$('#OprID').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Chọn hãng khai thác'
		});
		$('#multiStuff').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Đóng/Rút hàng'
		});
		$('#multiService').selectpicker({
			actionsBox: true,
			liveSearch: true,
			size: '100%',
			selectAllText: 'Tất cả',
			deselectAllText: 'Hủy chọn',
			noneSelectedText: 'Chọn dịch vụ',
			virtualScroll: true
		});

		// define datetime
		$('#dateStart').val(moment().format('DD/MM/YYYY HH:mm:ss'));
	    $('#dateEnd').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});

	});
</script>
<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>