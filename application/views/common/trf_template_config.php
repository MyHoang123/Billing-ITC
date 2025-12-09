<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}

	table.dataTable.tbl-services-style thead tr,
	table.dataTable.tbl-services-style td{
		background: none!important;
		border: 0 none !important;
		cursor: default!important;
	}

	table.dataTable.tbl-services-style thead tr th{
		border-bottom: 1px solid #fff!important;
	}
	table.dataTable.tbl-services-style tbody tr.selected{
		background-color: rgba(255,231,112,0.4)!important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">CẤU HÌNH TÍNH CƯỚC</div>
				<div class="button-bar-group mr-3">
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
				</div>
			</div>
			
			<div class="ibox-footer border-top-0 mt-3">
				<div class="row">
					<div class="col-sm-6">
						<div class="row form-group" style="margin-bottom: .45rem!important">
							<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Loại lệnh</label>
							<div class="col-md-9 col-sm-9 col-xs-9 input-group input-group-sm">
								<select id="service-type" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Danh sách lệnh">
									<option value="" selected>-- [Tất cả] --</option>
									<option value="isLoLo" >Nâng hạ</option>
									<option value="ischkCFS" >Đóng rút</option>
									<option value="IsYardSRV" >DV Bãi</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-services" class="table table-striped display nowrap tbl-services-style" cellspacing="0" style="width: 99.9%">
									<thead>
									<tr>
										<th class="editor-cancel" style="max-width: 30px">STT</th>
										<th class="editor-cancel" style="max-width: 150px">Dịch vụ</th>
										<th class="editor-cancel">Diễn giải</th>
									</tr>
									</thead>

									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-attach-service" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
									<thead>
									<tr>
										<th class="editor-cancel data-type-checkbox" style="max-width: 30px">Chọn</th>
										<th class="editor-cancel" style="max-width: 150px">Mã Template</th>
										<th class="editor-status">Diễn giải</th>
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
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columnsServices = ["STT", "CJMode_CD", "CJModeName"];
		var _columnTemplate = ["Select", "TPLT_NM", "TPLT_DESC"];
		var _list = [];
		<?php if(isset($services) && count($services) > 0) {?>
			_list = <?=json_encode($services) ?>;
		<?php } ?>

		var _templateServices = [];

		var tblServices = $('#tbl-services'),
			tblTemplate = $('#tbl-attach-service');

		var dataTblService = tblServices.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columnsServices.indexOf('STT') }
			],
			order: [[ _columnsServices.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:false,
            info:false,
            searching:false,
            autoFill: {
                focus: 'focus'
            },
            buttons:[],
            rowReorder: false,
            arrayColumns: _columnsServices
		});

		var datatblTemplate = tblTemplate.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ className:"text-center", targets: _columnTemplate.getIndexs(['Select', 'chkPrint']) }
			],
			order: [],
			paging: false,
            keys:true,
            info:false,
            autoFill: {
                focus: 'focus'
            },
            rowReorder: false,
            arrayColumns: _columnTemplate
		});

		loadTemplateServices( false );
		loadServicesData();

        $('#service-type').on('change', function(){
        	var colname = $(this).val();
        	loadServicesData(colname);
        });

        $('#save').on('click', function(){
        	var srvSelected = tblServices.getSelectedData();
        	if(srvSelected.length == 0){
        		$('.toast').remove();
            	toastr["warning"]("Vui lòng chọn một [DỊCH VỤ] !");
            	return;
        	}
        	
        	var dt = tblTemplate.DataTable().rows( '.editing' )
        								  .data()
        								  .toArray()
        								  // .filter(p=>$(p[0]).find("input").first().val() == "1")
        								  .map(function(x){
        								  	return {
        								  				"IsChecked": $(x[_columnTemplate.indexOf("Select")]).find("input").first().val()
        								  				,"ORD_TYPE": srvSelected[0][_columnsServices.indexOf("CJMode_CD")]
	        								  			,"TPLT_NM": x[_columnTemplate.indexOf("TPLT_NM")]
        								  			}
        								  });

            if(dt.length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
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
		                    action: function(){
		                        saveData(dt);
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

        tblTemplate.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val(1);
        	}else{
        		inp.removeAttr("checked");
        		inp.val("");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tblTemplate.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	eTable.row(crRow).nodes().to$().addClass("editing");
        });

        tblServices.on('click', 'tr', function(e){
        	var tbl = $(this).closest('table').DataTable();
        	var dtRow = tbl.row($(this)).nodes().to$();
        	if(dtRow.hasClass("selected")){
        		return;
        	}

        	tbl.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
        	dtRow.addClass("selected");
        	loadTmpData();
        });

        function saveData(data){
        	var formData = {
        		"action": "edit",
        		"data": data
        	};

			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox-footer').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmTRFTemplateConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    toastr["success"]("Cập nhật thành công!");
                    tblTemplate.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");

                    saveBtn.button('reset');
        			$('.ibox-footer').unblock();

        			loadTemplateServices( true );
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox-footer').unblock();
                	console.log(err);
                }
            });
		}

		function loadTemplateServices( isloadGridTemplate ){
			if( typeof isloadGridTemplate === "undefined" || isloadGridTemplate === null ){
				isloadGridTemplate = false;
			}

			var formData = {
				action: 'view',
				act: 'load_temp_srv'
			};

			tblServices.blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmTRFTemplateConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	tblServices.unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    _templateServices = data;
                    if( isloadGridTemplate ){
                    	loadServicesData( $('#service-type').val() );
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	tblServices.unblock();
                	console.log(err);
                }
            });
		}

        function loadServicesData(colname){
        	if (typeof colname === "undefined" || colname === null) {
				colname = '';
			}

        	var i = 0;
        	var data = colname == '' ? _list : _list.filter(p=> p[colname] >= 1);
        	var n = data.map(function(x){
        		i++;
        		return [i, x.CJMode_CD, x.CJModeName];
        	});

        	tblServices.dataTable().fnClearTable();
        	tblServices.dataTable().fnAddData(n);
        }

        function loadTmpData(){
        	var i = 0;
        	var jobmodeSelected = tblServices.getSelectedData();
        	if(!jobmodeSelected || jobmodeSelected.length == 0) return;
        	var	jmode = jobmodeSelected[0][_columnsServices.indexOf("CJMode_CD")];

        	var n = _templateServices.map(function(x){
        		i++;
        		var isCheck = x.ORD_TYPE == jmode ? "checked" : "";

        		return [ 
	        				(isCheck == "checked" ? 1 : 0)
	        				,'<label class="checkbox checkbox-primary"><input type="checkbox" '+isCheck+' value="'+(isCheck=="checked"?1:0)+'"><span class="input-span"></span></label>'
	        				, x.TPLT_NM
	        				, x.TPLT_DESC
	        			];
        	})
        	.sort(function(a, b){
        		if (a[1] < b[1]) return 1;
				if (a[1] > b[1]) return -1;
				return 0;
        	})
        	.map(function(y){
        		return y.slice(1);
        	});

        	tblTemplate.dataTable().fnClearTable();
        	tblTemplate.dataTable().fnAddData(n);
        }
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>