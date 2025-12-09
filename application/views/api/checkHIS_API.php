<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?=base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>
<style>
    .input{
		height: 28px; 
		font-size: 12px; 
		padding-left: 11px; 
		border-radius: 5px;
		max-width: 15rem;
		border: 1px solid rgba(0,0,0,.15);
	}
    .width-250 {
        width: 250px!important;
    }
    .wrap-text {
        white-space:normal!important;
    }
	.select2-selection__arrow {
		top: 13px!important;
	}
	.select2-selection__rendered {
		padding: 0rem 0.7rem!important;
	}
</style>

<div class="row">
    <div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">LỊCH SỬ GỬI LẠI API VTOS</div>
				<div class="button-bar-group">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
                    <!-- <button id="save" class="btn btn-outline-primary btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button> -->
				</div>
			</div>

            <form class="ibox-body mt-0 pt-0 pb-0 bg-f9 border-e" id="inputForm">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0">
                        <div class="row ibox mb-0 border-e">								
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2 mt-2">
								<div class="row">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Từ ngày đến ngày</label>		
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="txtFormDate" class="input" attrX="FormDate" placeholder="Từ ngày" type="text" maxlength="19">
										<input id="txtToDate" class="input" attrX="ToDate" placeholder="Đến ngày" type="text" maxlength="19">
									</div>
									<div class="form-group col-md-4 col-sm-4 col-xs-4">
										<div class="col-sm-12 input-group input-group-sm col-form-label">
											<label class="radio radio-inline">
												<input type="radio" name="sys" value="HIS_API" checked="">
												<span class="input-span"></span>VSL</label>
											<label class="radio radio-inline">
												<input type="radio" name="sys" value="MNR_API">
												<span class="input-span"></span>MNR</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row ibox mb-0 border-e">		
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-2">
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Tên nguồn</label>		
									<div class="col-md-8 col-sm-8 col-xs-8">
										<select id="txtTableName" attrX="TableName" style="max-width: 11.4rem;" data-width="100%" data-style="btn-default btn-sm">
											<option value="*" selected>*</option>
											<option value="CNTR_DETAILS">Container</option>
											<option value="CNTR_SZTP_MAP">Kích cỡ</option>
											<option value="CUSTOMERS">Khách hàng/ Hãng khai thác</option>
											<option value="EDI_EDO">EDO</option>
											<option value="EIR">Lệnh giao nhận</option>
											<option value="EMP_BOOK">Booking</option>
											<option value="EXCHANGE_RATE">Tỉ giá</option>
											<option value="GATE_MONITOR">Công việc cổng</option>
											<option value="INV_DFT">Phiếu tính cước</option>
											<option value="INV_DFT_DTL">Chi tiết phiếu tính cước</option>
											<option value="INV_VAT">Hóa đơn</option>
											<option value="LANE">Lịch trình tàu</option>
											<option value="LANE_FPOD">Cảng xếp dỡ</option>
											<!-- <option value="LANE_OPR">Hóa đơn</option> -->
											<option value="SRV_ODR">Lệnh dịch vụ</option>
											<option value="RF_ONOFF">ContainerReefer</option>
											<option value="TRF_STD">Biểu cước chuẩn</option>
											<option value="QUAYJOB">Công việc cẩu tàu</option>
											<option value="UNIT_CODES">Đơn vị tính</option>
											<option value="VESSELS">Tàu</option>
											<option value="VESSEL_SCHEDULE">Lịch tàu</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-2">
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Chức năng</label>		
									<div class="col-md-8 col-sm-8 col-xs-8">
										<select id="txtMethod" attrX="Method" style="max-width: 11.4rem;" data-width="100%" data-style="btn-default btn-sm">
											<option value="*" selected>*</option>
											<option value="INSERT">INSERT</option>
											<option value="UPDATE">UPDATE</option>
											<option value="DELETE">DELETE</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-2">
								<div class="row">
									<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Kết quả</label>		
									<div class="col-md-8 col-sm-8 col-xs-8">
										<select id="txtisSuccess" attrX="isSuccess" style="max-width: 11.4rem;" data-width="100%" data-style="btn-default btn-sm">
											<option value="*" selected>*</option>
											<option value="Y">Thành công</option>
											<option value="N">Thất bại</option>
											<option value="C">Đã gửi lại</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
								<div class="row">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Tìm kiếm dữ liệu gửi</label>		
									<div class="col-md-10 col-sm-10 col-xs-10">
										<input id="txtSearchText" style="max-width: 30rem" attrX="SearchText" class="form-control input" placeholder="Tìm kiếm" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </form>

			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent" class="mt-2">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="max-width: 99.7%; width: 99.7%">
							<thead>
                                <th col-name="STT" style="width: 20px" class="editor-cancel">STT</th>
                                <th col-name="insert_time" class="editor-cancel">Ngày gửi</th>
								<th col-name="TableName" class="editor-cancel">Tên nguồn</th>
								<th col-name="Method" class="editor-cancel">Chức năng</th>
								<th col-name="JsonString" class="editor-cancel">Dữ liệu gửi</th>
								<th col-name="ResponseString" class="editor-cancel">Kết quả</th>
								<!-- <th col-name="SoLanGui">Số lần gửi</th> -->
								<th col-name="isSuccess" class="editor-cancel">Tình trạng</th>
                                <th col-name="rowguid" class="editor-cancel">Action</th>
							</thead>
							<tbody id="tablecontentTBody">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chuỗi Json</h5>
			</div>
			<div class="modal-body pt-0">
				<pre id="jsonContent"></pre>
				<!-- <div class="form-group" style="height: 50vh">
					<label for="jsonTextArea">Edit Json</label>
					<textarea class="form-control" id="jsonTextArea" style="height: 50vh"></textarea>
				</div> -->
			</div>
			<div class="modal-footer">
				<!-- <button type="button" id="btnCustomSave" class="btn btn-success" data-dismiss="modal">Gửi lại</button> -->
				<button type="button" style="display: none" id="btnCustomSave" class="btn btn-success" >Gửi lại</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function () {  
        var _columns 	= ["STT", "insert_time", "TableName", "Method", "JsonString", "ResponseString", "isSuccess", "rowguid"],
			tbl 		= $('#contenttable');

        var dataTbl = tbl.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center", targets: _columns.getIndexs(["insert_time", "TableName", "Method", "isSuccess", "rowguid"])},
				{ className: "text-center", targets: _columns.indexOf("JsonString") },
                // {   
                //     targets: _columns.indexOf("JsonString"),
                //     render: function(data, type, full, meta) {
                //         var a = data.replace('{','{<br/>').replaceAll(',"',',<br/>"').replace('}','<br/>}');
                //         return '<div class="wrap-text width-300">' + a + '</div>';
                //     },
                // },
				// { className: "text-left", targets: _columns.indexOf("ResponseString") },
				{   
                    targets: _columns.indexOf("ResponseString"),
                    render: function(data, type, full, meta) {
						if (data && data.includes('{')) {
							var a = data.replace('{','{<br/>').replaceAll(',"',',<br/>"').replace('}','<br/>}');
							if (a.includes('"data":[{"')) a = a.replace('"data":[{"', '"data":[{<br/>"');
							return '<div class="wrap-text width-300">' + a + '</div>';
						}
                        return '<div class="wrap-text width-300">' + data + '</div>';
                    },
                },
				// { className: "hiden-input", targets: _columns.getIndexs(["rowguid"])},
			],
			order: false,
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});
       
		// tbl.editableTableWidget();
        $('#tbl').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});
       
        
        $("#txtFormDate, #txtToDate").datetimepicker({
			controlType: 'select',
			oneLine: true,
			// dateFormat: 'dd/mm/yy',
			dateFormat: 'yy-mm-dd',
			timeFormat: 'HH:mm:00',
			timeInput: true,
			onSelect: function () {
				/* Do nothing */
			}	
		});
		$('#txtFormDate').val(moment().subtract(1, 'day').format('YYYY-MM-DD HH:mm:ss'));
		$('#txtToDate').val(moment().format('YYYY-MM-DD 23:59:59'));
		$('#txtMethod, #txtTableName, #txtisSuccess').select2();

        $('#search').on('click', function(){ 
			tbl.dataTable().fnClearTable();
			var actBtn = $( this );
			actBtn.button('loading');
            var dataForm = GET_ALL_DATA_INPUT('#inputForm', 'attrX');
			console.log(dataForm);
            var fData = {
				DATA_FORM: dataForm,
				iAction: 'loadData',
				searchTable: $("input[name='sys']:checked").val()
			};
			$.ajax ({ 
				url: "<?=site_url(md5('Api') . '/' . md5('tHIS_API'));?>",
				dataType: 'json',
                data: fData,
                type: 'POST',
                success: function (dataRes) {  
                	loadData(dataRes);
                    actBtn.button('reset');
        			return;
                },
                error: function(err){
                	toastr["error"]("Error!");
                	actBtn.button('reset');
                	console.log(err);
                }
			})
		});
		
		$("input[name='sys']").change( function(){
			tbl.dataTable().fnClearTable();
		});


        function loadData(dataX){
            if (dataX.length <= 0) return;
            var rows = [];
            for ( var i = 0; i < dataX.length; i++) {
                var rData = dataX[i], r = [];
                r.push( i + 1);
                r.push(rData['insert_time'] ? rData['insert_time'].split('.')[0] : "");
                r.push(rData['TableName']);
                r.push(rData['Method']);
              
                // var tempJson = JSON.parse(rData['JsonString']);
                // var tempJsonString = JSON.stringify(tempJson, null, 4);
                // console.log(tempJsonString);
                // r.push(tempJsonString);
				
				//r.push(rData['JsonString']);
				var tempBtnShow = "<button jsonData='" + rData['JsonString'] + "' class='btnShow btn btn-outline-info' data-toggle='modal' data-target='#myModal'>Show</button>";
				r.push(tempBtnShow);
                r.push(rData['ResponseString'] == null ? "" : rData['ResponseString']);
				var tempIsSuccess = "";
				switch(rData['isSuccess']) {
					case "Y": tempIsSuccess = "Thành công"; break;
					case "N": tempIsSuccess = "Thất bại"; break;
					case "C": tempIsSuccess = "Đã gửi lại"; break;
					default: break;
				}
                r.push(tempIsSuccess);
				var tempBtnSend = '<button id="' + rData['rowguid'] + '" class="btnSend btn btn-outline-success">Resend</button>';
				r.push(tempBtnSend);
                rows.push(r);
            }

			if (rows.length > 0) {
				$('#contenttable').dataTable().fnAddData(rows);
			};
        }

     
       

        function postSave(formData){
			$('.page-content.fade-in-up').blockUI();
			$.ajax({ 
				url: "<?=site_url(md5('Api') . '/' . md5('tHIS_API'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
                    console.log(data);
					$('.page-content.fade-in-up').unblock();
					if (data.iStatus == 'Success') {
						//toastr["success"](data.iMess);
						toastr["success"]('Tạo mới chuỗi dữ liệu API thành công');
						
					}
					if (data.iStatus == 'Fail') {
						toastr["error"](data.iMess);
					}
					if(data.deny) {
						toastr["error"](data.deny);
						return;
					};
				},
				error: function(err){
					toastr["error"]("Error!");
					$('.page-content.fade-in-up').unblock();
					console.log(err);
				}
			});
		}
		
		$(document).on('click', '.btnSend' , function(){
			if ($("input[name='sys']:checked").val() == "MNR_API") {
				toastr["warning"]("Chưa có chức năng gửi lại dành cho MNR!");
				return;
			}
			var rowguidTemp = $(this).attr('id');
			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Bạn muốn gửi lại thông tin API?\nTiếp tục?',
				buttons: {
					ok: {
						text: 'Xác nhận',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function(){
							var fData = {
								rowguid: rowguidTemp,
								iAction: 'saveDATA'
							};
							postSave(fData);
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC']
					}
				}
			});
		});
		
		function jsonEscape(str)  {
			return str.replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/\t/g, "\\t");
		}
		
		$(document).on('click', '.btnShow' , function(){
			// console.log($(this).attr('jsonData'));
			// console.log(jsonEscape($(this).attr('jsonData')));
			var tempJson = JSON.parse(jsonEscape($(this).attr('jsonData')));
			// console.log(tempJson);
            var tempJsonString = JSON.stringify(tempJson, null, 4);
			// console.log(tempJsonString);
			$('#jsonContent').text(tempJsonString);
			// $('#jsonTextArea').val(tempJsonString);
			return;
		});
		
		$('#btnCustomSave').on('click', function(e){
			e.preventDefault();
			console.log('HIHIHI');
		});
    });
</script>
