<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">

<style>
	.nav-tabs{
		height: inherit!important;
	}
	.m-row-selected{
		background: violet;
	}
	.MT-toggle, .PY-toggle{
		display: none;
	}
	.MT-toggle button, .PY-toggle button {
		background-color: #fff!important;
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold!important;
		padding-right: 0 !important;
	}
	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
	}

	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		height: 100%;
		padding: 0;
		max-width: 100%!important;
	}

	.modal-dialog-mw-py .modal-body{
		width: 90%!important;
		margin: auto;
	}

	.unchecked-Salan{
		pointer-events: none;
	}
	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label{
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BIỂU CƯỚC LƯU BÃI</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
				<!-- <div class="ibox-tools">
					<a class="ibox-collapse"><i class="la la-angle-double-down dock-right"></i></a>
				</div> -->
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1">
					<div class="col-12 col-sm-12">
						<!-- ////////////////////////// -->
						<div class="ibox-body p-2">
							<div class="row">
								<div class="col-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Tên</label>
										<div class="col-sm-8">
											<input class="form-control form-control-sm input-required" id="newName" type="text" placeholder="Nhập tên...">
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">ĐTTT *</label>
										<div class="col-sm-8 input-group">
											<input class="form-control form-control-sm input-required" id="payer" placeholder="Đối tượng thanh toán" type="text" readonly>
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
												<i class="ti-search"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Hàng nội/ngoại</label>
										<div class="col-sm-8">
											<select id="isLocal" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
												<option disabled="true" selected>*</option>
												<option value="">Nội/Ngoại</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Hãng khai thác</label>
										<div class="col-sm-8">
											<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
												<option value="" selected>Hãng khai thác</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Ngày hiệu lực</label>
										<div class="col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm input-required" id="dateStart" type="text" placeholder="Ngày hiệu lực" readonly>
											</div>
										</div>
									</div>
								</div>
								<div class="col-6 col-sm-6 col-md-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Ngày hết hạn *</label>
										<div class="col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm input-required" id="dateEnd" type="text" placeholder="Ngày hết hạn">
												<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row ibox mb-0 border-e pb-1 mt-3 p-3">
					<div style="border-bottom: 1px solid #c0c0c0; display: block; width: 100%">
						<h6 class="text-muted">Thông tin lưu bãi</h6>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive px-0">
						<table id="tbl-class" class="table table-striped display nowrap" cellspacing="0" style="width: 99.9%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Hướng</th>
								<th>Hàng/Rỗng</th>
								<th>Phương thức vào</th>
								<th>Phương thức ra</th>
								<th>Thời gian bắt đầu</th>
								<th>Thời gian kết thúc</th>
								<th>Số Ngày miễn phí</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row ibox-footer border-top-0">
				<!-- detail table -->
				<div style="border-bottom: 1px solid #c0c0c0; display: block; width: 100%">
					<h6 class="text-muted">Thông tin cước</h6>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive px-0">
					<table id="tbl-detail" class="table table-striped display nowrap" cellspacing="0" style="width: 99.9%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Số ngày vượt mức</th>
							<th>Loại tiền</th>
							<th>Tiền 20 hàng</th>
							<th>Tiền 20 rỗng</th>
							<th>Tiền 40 hàng</th>
							<th>Tiền 40 rỗng</th>
							<th>Tiền 45 hàng</th>
							<th>Tiền 45 rỗng</th>
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
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body pt-0">
				<div class="row p-3">
					<div class="col-6">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Loại khách hàng</label>
							<div class="col-sm-8">
								<select id="payerType" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
									<option disabled="true" selected>*</option>
									<option value="">Loại khách hàng</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Tìm theo tên">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th>Mã khách hàng</th>
							<th>Tên khách hàng</th>
							<th>VAT</th>
							<th>Mã số thuế</th>
							<th>Địa chỉ</th>
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

<!--1.CntrClass
	2.OprID
	3.dttt
	4.isLocal
	5.APPLY_DATE
	6.EXPIRE_DATE
	7.FE
	8.DMethod_CD
	9.DMethod_OUT_CD
	10.SDATE
	11.EDATE
	12.IFREE_DAYS
	13.NICK_NAME
 -->

<script type="text/javascript">
	$(document).ready(function () {
		var _colClass = ["CntrClass", "Status", "DMethod_CD", "DMethod_OUT_CD", "Thời gian bắt đầu", "Thời gian kết thúc", "Số ngày miễn phí"];
		var _colDetail = [];
		var _result = [], _lstEir = [];
		var selected_cont = [];

		var tempService;
		var ctrlDown = false;

		var tblClass = $('#tbl-class');
		var tblDetail = $('#tbl-detail');

		var dataTblClass = tblClass.DataTable({
			scrollY: '10vh',
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			info: false,
			buttons:[],
			searching:false,
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});
		var dataTblDetail = tblDetail.DataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false,
			info: false,
			buttons:[],
			searching:false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});
		$('#tbl-ord').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '25vh'
		});

		var tblPayer = $('#search-payer').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '25vh'
		});

		//--------cancel modal-------
		$('#cancel-service').click(function(){
			$('#service-modal tbody').html(tempService);
		});

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
	        if (ctrlDown && e.keyCode == rKey){
	        	alert('reload filter');
	        	return false;
	        } 
	    });

	    //---------datepicker modified---------
	    $('#dateStart').val(moment().format('DD/MM/YYYY HH:mm:ss'));
	    $('#dateEnd').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});

		// ----------function button (add, delete, save)--------
		$('#addrow').on('click', function(){
            tbl.newRow();
        });

	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>