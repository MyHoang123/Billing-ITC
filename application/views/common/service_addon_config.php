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
				<div class="ibox-title">CẤU HÌNH DỊCH VỤ ĐÍNH KÈM</div>
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
									<option value="isLoLo" db-data="1" >Nâng hạ</option>
									<option value="ischkCFS" db-data="1" >Đóng container</option>
									<option value="ischkCFS" db-data="2" >Rút container</option>
									<option value="ischkCFS" db-data="3" >Sang container</option>
									<option value="IsYardSRV" db-data="1" >Dịch vụ bãi</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-services" class="table table-striped display nowrap tbl-services-style" cellspacing="0" style="width: 99.9%">
									<thead>
									<tr>
										<th class="editor-cancel" style="max-width: 30px">STT</th>
										<th class="editor-cancel" col-name="CJMode_CD" style="max-width: 150px">Mã</th>
										<th class="editor-cancel" col-name="CJModeName">Diễn giải</th>
										<th class="editor-cancel" col-name="isLoLo">LoLo</th>
										<th class="editor-cancel" col-name="ischkCFS">CV Đóng Rút</th>
										<th class="editor-cancel" col-name="IsYardSRV">CV Bãi</th>
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
										<th class="editor-cancel" style="max-width: 150px">Mã dịch vụ</th>
										<th class="editor-status">Tên dịch vụ</th>
										<th class="editor-cancel data-type-checkbox">In</th>
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
		var _columnsServices = ["STT", "CJMode_CD", "CJModeName", "isLoLo", "ischkCFS", "IsYardSRV"];
		var _columnsAttach = ["Select", "CjMode_CD", "CJModeName", "chkPrint"];
		var _list = [], _attach_temp = [], _lstForSave = []; 

		var _attachServices = [];
		<?php if(isset($attach_services) && count($attach_services) > 0) {?>
			_attachServices = <?=json_encode($attach_services) ?>;
		<?php } ?>

		var tblServices = $('#tbl-services'),
			tblAttach = $('#tbl-attach-service');

		var dataTblService = tblServices.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columnsServices.indexOf('STT') },
				{ className: "hiden-input", targets: _columnsServices.getIndexs( ["isLoLo", "ischkCFS", "IsYardSRV"] ) }
			],
			order: [[ _columnsServices.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:false,
            info:false,
            searching: true,
            autoFill: {
                focus: 'focus'
            },
            buttons:[],
            rowReorder: false,
            dom: '<"datatable-header"l<"datatable-info-right"Bip>><"datatable-scroll-wrap"t>',
            arrColumns: _columnsServices
		});

		var dataTblAttach = tblAttach.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ className:"text-center", targets: _columnsAttach.getIndexs(['Select', 'chkPrint']) }
			],
			order: [],
			paging: false,
            keys:true,
            info:false,
            autoFill: {
                focus: 'focus'
            },
            buttons: [],
            rowReorder: false,
            arrColumns: _columnsAttach
		});

		loadServicesData();

		loadGridAttach();

        $('#service-type').on('change', function(){
        	var colName = $(this).val();
        	var data =$(this).find("option:checked").attr("db-data");

        	var filterData = _list.filter( p=> p[colName] == data );
        	
        	tblServices.dataTable().fnClearTable();
        	if( filterData.length > 0 ){
        		var i=1;
        		var n = filterData.map( function(item){
        			return [i++, item["CJMode_CD"], item["CJModeName"], item["isLoLo"], item["ischkCFS"], item["IsYardSRV"] ];
        		});

        		tblServices.dataTable().fnAddData(n);
        	}
        });

        $('#save').on('click', function(){

            if(tblAttach.DataTable().rows( '.editing' ).data().length == 0){
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
		                        saveData();
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

        tblAttach.on('change', 'tbody tr td input[type="checkbox"]', function(e){

        	var inp = $(e.target);
        	
        	if( tblServices.DataTable().rows( '.selected' ).data().length == 0 ){

        		$(".toastr").remove();
        		toastr["error"]("Vui lòng chọn một dịch vụ trước!");

        		if(inp.is(":checked")){
	        		inp.removeAttr("checked");
	        		inp.val("");
	        	}else{
	        		inp.attr("checked", "");
	        		inp.val(1);
	        	}

	        	tblAttach.DataTable().cell( inp.closest("td") ).data( inp.closest("td").html() ).draw(false);

	        	return;
        	}

        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val(1);
        	}else{
        		inp.removeAttr("checked");
        		inp.val("");
        	}

        	if( inp.closest("td").index() == _columnsAttach.indexOf( "Select" ) ){
        		var currentODR_TYPE = tblServices.DataTable()
        											.rows( '.selected' )
        											.data().toArray()
        											.map( x => x[ _columnsServices.indexOf("CJMode_CD") ] )[0];

        		var currentCjMode = inp.closest("tr").find( "td:eq("+ _columnsAttach.indexOf("CjMode_CD") +")" ).text();
        		var chkPrintAble = inp.closest("tr")
	        									.find( 'td:eq('+ _columnsAttach.indexOf("chkPrint") +') input[type="checkbox"]' )
	        									.prop("checked") ? 1 : 0;
        		if( _lstForSave.length > 0 ){

        			var findIdx = _lstForSave.findIndex( p=>p.ORD_TYPE == currentODR_TYPE && p.CjMode_CD == currentCjMode );
        			if( findIdx > -1 ){
        				_lstForSave[findIdx].Select = inp.is(":checked") ? 1 : 0;
	        			_lstForSave[findIdx].chkPrint = chkPrintAble;
        			}else{
        				_lstForSave.push({
	        				Select: inp.is(":checked") ? 1 : 0,
	        				ORD_TYPE: currentODR_TYPE,
	        				CjMode_CD: currentCjMode,
	        				chkPrint: chkPrintAble
	        			});
        			}
        		}else{
        			_lstForSave.push({
        				Select: inp.is(":checked") ? 1 : 0,
        				ORD_TYPE: currentODR_TYPE,
        				CjMode_CD: currentCjMode,
        				chkPrint: chkPrintAble
        			});
        		}
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tblAttach.DataTable();

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

        	loadAttachData( $(this).find("td:eq("+ _columnsServices.indexOf("CJMode_CD") +")").text() );
        });

        function saveData(){
        	var formData = {
        		"action": "edit",
        		"data": _lstForSave
        	};

			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox-footer').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServiceAddonConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	saveBtn.button('reset');
        			$('.ibox-footer').unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if( data.nothing ){
                    	alert(data.nothing);
                    }

                    toastr["success"]("Cập nhật thành công!");
                    tblAttach.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox-footer').unblock();
                	console.log(err);
                }
            });
		}

        function loadServicesData(colname){
        	var blockServiceType = $('#service-type').parent();
        	blockServiceType.blockUI();

        	tblServices.waitingLoad();
			var formData = {
        		"action": "view",
        		"act": "load_service_data"
        	};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServiceAddonConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	blockServiceType.unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                		tblServices.dataTable().fnClearTable();
                        return;
                    }

                    _list = data.services;

                    var i = 0;
		        	var n = _list.map(function(x){
		        		i++;
		        		return [i, x.CJMode_CD, x.CJModeName, x.isLoLo, x.ischkCFS, x.IsYardSRV];
		        	});

		        	tblServices.dataTable().fnClearTable();
		        	tblServices.dataTable().fnAddData(n);
                },
                error: function(err){
                	blockServiceType.unblock();

                	tblServices.dataTable().fnClearTable();
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
        }

        function loadGridAttach(){
        	// attach_temp

        	tblAttach.waitingLoad();
			var formData = {
        		"action": "view",
        		"act": "load_attach_temp"
        	};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServiceAddonConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                    	tblAttach.dataTable().fnClearTable();
                        toastr["error"](data.deny);
                        return;
                    }

                    _attach_temp = data.attach_temp;

		        	tblAttach.dataTable().fnClearTable();
		        	if( _attach_temp && _attach_temp.length > 0 ){
		        		var i = 1;
			        	var n = _attach_temp.map(function(x){
			        		return [
			        					'<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>'
			        					, x.CJMode_CD
			        					, x.CJModeName
			        					, '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>'
			        				];
			        	});

		        		tblAttach.dataTable().fnAddData(n);
		        	}
                },
                error: function(err){
                	tblServices.dataTable().fnClearTable();
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
        }

        function loadAttachData( cjModeSelected ){

        	tblAttach.find("tbody tr")
	        			.find( 'td:eq('+ _columnsAttach.indexOf("Select") +') input[type="checkbox"]:checked' )
	        			.val( "0" )
	        			.prop('checked', false);

        	var checkedAttachCjMode = _attachServices.filter( p => p.ORD_TYPE == cjModeSelected ).map( x => x.CjMode_CD );

	        if( checkedAttachCjMode && checkedAttachCjMode.length > 0 ){
	        	 $.each( tblAttach.find("tbody tr"), function(){
		        	var cjmode = $(this).find("td:eq(" + _columnsAttach.indexOf("CjMode_CD") + ")").text();
		        	if( checkedAttachCjMode.indexOf( cjmode ) != -1 ){
		        		var cellSelect = $(this).find( 'td:eq('+ _columnsAttach.indexOf("Select") +')' );

		        		cellSelect.find( 'input[type="checkbox"]' )
			        				.val( "1" )
			        				.prop('checked', true);

		        		var chkPrintAble = _attachServices.filter( p=>p.CjMode_CD == cjmode ).map( x => x.chkPrint )[0];

		        		var cellChkPrint = $(this).find( 'td:eq('+ _columnsAttach.indexOf("chkPrint") +')' );

		        		cellChkPrint.find( 'input[type="checkbox"]' )
			        				.val( chkPrintAble == 'Y' ? "1" : "0" )
			        				.prop('checked', chkPrintAble == 'Y' ? true : false );
		        	}
		        } );
	        }

	        if( _lstForSave.length > 0 ){
	        	var chkReorder = false;

	        	$.each( tblAttach.find("tbody tr"), function(){
		        	var cjmode = $(this).find("td:eq(" + _columnsAttach.indexOf("CjMode_CD") + ")").text();

		        	var itemInSave = _lstForSave.filter( p=>p.ORD_TYPE == cjModeSelected && p.CjMode_CD == cjmode );
		        	if( itemInSave && itemInSave.length > 0 ){
		        		var cellSelect = $(this).find( 'td:eq('+ _columnsAttach.indexOf("Select") +')' );

		        		cellSelect.find( 'input[type="checkbox"]' )
			        				.val( itemInSave[0].Select )
			        				.prop('checked', itemInSave[0].Select == 1 ? true : false );

			        	var cellChkPrint = $(this).find( 'td:eq('+ _columnsAttach.indexOf("chkPrint") +')' );

		        		cellChkPrint.find( 'input[type="checkbox"]' )
			        				.val( itemInSave[0].chkPrint )
			        				.prop('checked', itemInSave[0].chkPrint == 1 ? true : false );

			        	chkReorder = true;
		        	}
		        } );

	        	// if( chkReorder ){
	        	// 	tblAttach.DataTable()
						    // .order( [ _columnsAttach.indexOf( "Select" ), 'desc' ] )
						    // .draw( false );
	        	// }
	        }

	        

        	// var n = data.map(function(x){
        	// 	i++;
        		
        	// 	var isCheck = checkedDatas.indexOf(x.CJMode_CD) != -1 ? "checked" : "";
        	// 	var isPrint = "";

        	// 	if(isCheck == "checked"){
        	// 		var temp = checkedFilter.filter(n=>n["CjMode_CD"] == x.CJMode_CD);
        	// 		if(temp.length > 0){
        	// 			isPrint = temp[0]["chkPrint"] == "Y" ? "checked" : "";
        	// 		}
        	// 	}

        	// 	return [ 
	        // 				(isCheck == "checked" ? 1 : 0)
	        // 				,'<label class="checkbox checkbox-primary"><input type="checkbox" '+isCheck+' value="'+(isCheck=="checked"?1:0)+'"><span class="input-span"></span></label>'
	        // 				, x.CJMode_CD
	        // 				, x.CJModeName
	        // 				, '<label class="checkbox checkbox-primary"><input type="checkbox" '+isPrint+' value="'+(isPrint=="checked"?1:0)+'"><span class="input-span"></span></label>'
	        // 			];
        	// })
        	// .sort(Comparator)
        	// .map(function(y){
        	// 	return y.slice(1);
        	// });

        	// tblAttach.dataTable().fnClearTable();
        	// tblAttach.dataTable().fnAddData(n);
        }

        function Comparator(a, b) {
		   if (a[1] < b[1]) return 1;
		   if (a[1] > b[1]) return -1;
		   return 0;
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>