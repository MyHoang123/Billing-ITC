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
				<div class="ibox-title">THỜI GIAN LƯU BÃI MIỄN PHÍ</div>
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
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-12 col-sm-12 ibox">
						<!-- ////////////////////////// -->
						<div class="ibox-body p-2">
							<div class="row">
								<div class="col-12 col-xs-12 col-md-6">
									<div class="row form-group">
										<label class="col-sm-1 col-form-label">Tên</label>
										<div class="col-sm-11">
											<input class="form-control form-control-sm input-required" id="queryName" type="text" placeholder="Tìm theo tên">
										</div>
									</div>
								</div>
								<div class="col-12 col-xs-12 col-md-6">
									<div class="row form-group">
										<label class="col-sm-1 col-form-label">Mẫu</label>
										<div class="col-sm-11">
											<select class="form-control form-control-sm mr-0" placeholder="" name="" id="tempFilter">
												<option selected value="-1">
													*Đối tượng thanh toán*-*Hãng khai thác*-*Hành trình tàu*-*Loại hàng*-*Hàng Nội/Ngoại*-*Tàu*-*Ngày hiệu lực*
												</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row pt-3" style="border-top: 1px solid #eee">
								<div class="col-12 col-xs-12 col-md-8" style="border-bottom: 1px solid #eee">
									<div class="row form-group">
										<label class="col-sm-1 col-form-label">Tên</label>
										<div class="col-sm-11">
											<input class="form-control form-control-sm input-required" id="newName" type="text" placeholder="Nhập tên...">
										</div>
									</div>
								</div>
							</div>
							<div class="row pt-2">
								<div class="col-12 col-xs-12 col-md-8">
									<div class="row form-group">
										<label class="col-sm-2 col-form-label">ĐTTT</label>
										<div class="col-sm-10">
											<select id="taxcode" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
												<option value="" selected>Đối tượng thanh toán</option>
											</select>
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
			</div>
			<div class="col-12 ibox">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ibox-body p-0 pb-2 mt-3">
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
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
							<tr>
								<td>1</td>
								<td>
									<select>
										<option disabled="true">*</option>
										<option>Nhập</option>
										<option>Xuất</option>
										<option>Nhập kho</option>
										<option>Xuất kho</option>
										<option>Kho rỗng</option>
									</select>
								</td>
								<td>
									<select>
										<option>Hàng</option>
										<option>Rỗng</option>
									</select>
								</td>
								<td>
									<select class="DMethod_CD">
										<optgroup label="Quay">
											<option>TAU-BAI</option>
											<option>TAU-TAU</option>
											<option>TAU-SALAN</option>
											<option>TAU-XE</option>
										</optgroup>
										<optgroup label="Yard">
											<option>CONT-OTO</option>
											<option>CONT-KHO</option>
											<option>CONT-SALAN</option>
											<option>CONT-CONT</option>
											<option>BAI-BAI</option>
										</optgroup>
										<optgroup label="Gate">
											<option>BAI-XE</option>
											<option>BAI-SALAN</option>
											<option>SALAN-XE</option>
										</optgroup>
									</select>
								</td>
								<td>
									<select class="DMethod_OUT_CD">
										<optgroup label="Quay">
											<option>TAU-BAI</option>
											<option>TAU-TAU</option>
											<option>TAU-SALAN</option>
											<option>TAU-XE</option>
										</optgroup>
										<optgroup label="Yard">
											<option>CONT-OTO</option>
											<option>CONT-KHO</option>
											<option>CONT-SALAN</option>
											<option>CONT-CONT</option>
											<option>BAI-BAI</option>
										</optgroup>
										<optgroup label="Gate">
											<option>BAI-XE</option>
											<option>BAI-SALAN</option>
											<option>SALAN-XE</option>
										</optgroup>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
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
	var _eirforMTReturn = '';
	jQuery.expr[':'].regex = function(elem, index, match) {
		var matchParams = match[3].split(','),
			validLabels = /^(data|css):/,
			attr = {
				method: matchParams[0].match(validLabels) ?
					matchParams[0].split(':')[0] : 'attr',
				property: matchParams.shift().replace(validLabels,'')
			},
			regexFlags = 'ig',
			regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
		return regex.test(jQuery(elem)[attr.method](attr.property));
	};
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};

	window.onbeforeunload = PreUnloadJavaScript;
	function PreUnloadJavaScript() {
		var cName = $('#ref-no').val();
		if(cName){
			deleteCookie("eir__"+cName);
		}
		deleteCookie("eir__"+_eirforMTReturn);
	}

	$(document).ready(function () {
		var _cols = ["CntrClass", "Status", "DMethod_CD", "DMethod_OUT_CD", "Thời gian bắt đầu", "Thời gian kết thúc", "Số ngày miễn phí"];
		var _result = [], _lstEir = [];
		var selected_cont = [];

		var tempService;
		var ctrlDown = false;

		var tbl = $('#tbl-conts');

		var dataTbl = tbl.DataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false,
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