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
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">KHAI BÁO QUYỂN HÓA ĐƠN</div>
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
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
						<div class="row form-group">
							<label class="col-md-3 col-sm-4 col-xs-4 col-form-label">Từ ngày</label>
							<div class="col-md-8 col-sm-8 col-xs-8">
								<input id="fromDate" class="form-control form-control-sm" placeholder="Từ ngày" type="text">
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
						<div class="row form-group">
							<label class="col-md-3 col-sm-4 col-xs-4 col-form-label">Đến ngày</label>
							<div class="col-md-8 col-sm-8 col-xs-8">
								<input id="toDate" class="form-control form-control-sm" placeholder="Đến ngày" type="text">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 100%">
						<thead>
						<tr>
							<th class="editor-cancel hiden-input">Rowguid</th>
							<th class="editor-cancel">STT</th>
							<th class="data-type-button editor-cancel" button-text="Sử dụng"></th>
							<th class="autocomplete">Loại CT</th>
							<th>Mã Thùng</th>
							<th>Ký Hiệu</th>
							<th>Từ Số</th>
							<th>Đến Số</th>
							<th class="data-type-datetime">Ngày Tạo</th>
							<th>Số Kế Tiếp</th>
							<th>Khổ Giấy</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		var _columns = ["rowguid", "STT", "USEAGE", "PTYPE", "PCODE", "INV_PREFIX", "FROM_INV_NO", "TO_INV_NO", "DATE_INVOICE", "INV_NO", "INV_PAGE_SIZE"];

		var tbl = $('#contenttable');
		var dataTbl = tbl.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", orderable: false, targets: _columns.indexOf('USEAGE') },
				{ className: "hiden-input", targets: _columns.indexOf('rowguid') },
				{ className: "show-dropdown", targets: _columns.indexOf('PTYPE') },
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns
		});

		var fromDate = $('#fromDate');
		var toDate = $('#toDate');

		fromDate.datepicker({ 
			controlType: 'select',
			oneLine: true,
			// minDate: _maxDateDateIn,
			dateFormat: 'dd/mm/yy',
			timeInput: true,
			onClose: function(dateText, inst) {
				if (toDate.val() != '') {
					var testStartDate = fromDate.datetimepicker('getDate');
					var testEndDate = toDate.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						toDate.datetimepicker('setDate', testStartDate);
				}
				else {
					toDate.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				toDate.datetimepicker('option', 'minDate', fromDate.datetimepicker('getDate') );
			}
		});

		toDate.datepicker({ 
			controlType: 'select',
			oneLine: true,
			// minDate: _maxDateDateIn,
			dateFormat: 'dd/mm/yy',
			timeInput: true,
			onClose: function(dateText, inst) {
				if (fromDate.val() != '') {
					var testStartDate = fromDate.datetimepicker('getDate');
					var testEndDate = toDate.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						fromDate.datetimepicker('setDate', testEndDate);
				}
				else {
					fromDate.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				fromDate.datetimepicker('option', 'maxDate', toDate.datetimepicker('getDate') );
			}
		});

		// $( "#fromDate, #toDate" ).datetimepicker({
		// 	controlType: 'select',
		// 	oneLine: true,
		// 	// minDate: _maxDateDateIn,
		// 	dateFormat: 'dd/mm/yy',
		// 	timeFormat: 'HH:mm:ss',
		// 	timeInput: true
		// });

		$("#fromDate").val( moment().subtract('month', 1).format('DD/MM/YYYY') );
		$("#toDate").val( moment().format('DD/MM/YYYY') );

		var _ptype = [
			{
                Code: "VAT",
                Name: "Hóa đơn"
            },
            {
                Code: "REC",
                Name: "Phiếu thu"
            }
        ];

        var tblHeader = tbl.parent().prev().find('table');
		tblHeader.find('th:eq('+_columns.indexOf("PTYPE")+')').setSelectSource(_ptype.map(p=>p.Name));

		//------SET DROPDOWN BUTTON FOR COLUMN
		tbl.columnDropdownButton({
			data:[
				{ colIndex: _columns.indexOf( "PTYPE" ), source: _ptype },
			],
			onSelected: function(cell, itemSelected){
				var temp = "<input type='text' value='"+ itemSelected.attr("code") +"' class='hiden-input'>" + itemSelected.text();

				tbl.DataTable().cell(cell).data(temp).draw(false);

				if(!cell.closest("tr").hasClass("addnew")){
		        	tbl.DataTable().row( cell.closest("tr") ).nodes().to$().addClass("editing");
	        	}
			}
		});
//------SET DROPDOWN BUTTON FOR COLUMN

        tbl.editableTableWidget();

        $('#addrow').on('click', function(){
        	$.confirm({
				columnClass: 'col-md-3 col-md-offset-3',
				titleClass: 'font-size-17',
                title: 'Thêm dòng mới',
                content: '<div class="input-group-icon input-group-icon-left">'
                            +'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>'
                            +'<input autofocus class="form-control form-control-sm" id="num-row" type="number" placeholder="Nhập số dòng" value="1">'
                        +'</div>',
                onContentReady: function(){
                	$("#num-row").on("keypress", function(e){
						if( e.which == 13 ){
							$(document).find("div.jconfirm-buttons").find("button.btn-confirm").trigger("click");
						}
					});
                },
                buttons: {
                    ok: {
                        text: 'Xác nhận',
                        btnClass: 'btn-sm btn-primary btn-confirm',
                        keys: ['Enter'],
                        action: function(){
                            var input = this.$content.find('input#num-row');
                            var errorText = this.$content.find('.text-danger');
                            if(!input.val().trim()){
                                $.alert({
                                	title: "Thông báo",
                                    content: "Vui lòng nhập số dòng!.",
                                    type: 'red'
                                });
                                return false;
                            }else{
                                tbl.newRows( input.val() );
                            }
                        }
                    },
                    later: {
                    	text: 'Hủy',
                    	btnClass: 'btn-sm',
                    	keys: ['ESC']
                    }
                }
            });
        });

        tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		if(isMobile.any()){
			$('#customer-type').selectpicker('mobile');
		}

		$('#search').on('click', function () {
			tbl.waitingLoad();
			var btn = $(this);
			btn.button('loading');

			var formData = {
				'action': 'view',
				'fromDate':$('#fromDate').val(),
				'toDate':$('#toDate').val(),
			};

			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPrefix'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					var invInfo = data.invInfo ? JSON.parse(data.invInfo) : [];

					if( data.list.length > 0 ) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "PTYPE":
										val= (rData[colname] == "VAT" ? "Hóa đơn" : "Phiếu thu");
										break;
									case "DATE_INVOICE":
										val=getDateTime( rData[colname] );
										break;
									case "USEAGE":
										if( rData["INV_PREFIX"] == invInfo.serial 
													&& rData["FROM_INV_NO"] == invInfo.fromNo && rData["TO_INV_NO"] == invInfo.toNo )
										{
											val = "Đang sử dụng";
										}else{
											val="<button class='btn btn-xs btn-default'>Sử dụng</button>";
										}
										break;
									case "INV_NO":
										if( rData["INV_PREFIX"] == invInfo.serial 
													&& rData["FROM_INV_NO"] == invInfo.fromNo && rData["TO_INV_NO"] == invInfo.toNo )
										{
											val = invInfo.invno;
										}else{
											val = rData[colname];
										}
										break;
									default:
										val = rData[colname] ? rData[colname] : "";
										break;
								}
								r.push(val);
							});
							rows.push(r);
						}
					}
					
					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}

					tbl.realign();

					btn.button('reset');
				},
				error: function(err){
					btn.button('reset');
					console.log(err);
				}
			});
		});

		$(document).on("click", "#contenttable tbody tr td button", function(e){
			var btn = $( e.target ),
				row = btn.parent().parent(),
				hasChange = row.hasClass("editing") || row.hasClass("addnew");

			var rowData = tbl.DataTable().rows(row).data().toArray()[0];
			if( rowData.filter(p=>!p).length > 1){
				$(".toast").remove()
				toastr["error"]("Vui lòng nhập đầy đủ thông tin!");
				return;
			}

			$.confirm({
	            title: hasChange ? 'Hóa đơn này chưa được lưu lại!' : 'Xác nhận sử dụng hóa đơn!',
	            type: 'orange',
	            icon: 'fa fa-warning',
	            content: hasChange ? 'Lưu lại và Áp dụng hóa đơn này ?' : 'Áp dụng hóa đơn này ?',
	            buttons: {
	                ok: {
	                    text: 'Xác nhận',
	                    btnClass: 'btn-warning',
	                    keys: ['Enter'],
	                    action: function(){
	                    	if( hasChange ){
	                    		var data = {
									invno: rowData[ _columns.indexOf("INV_NO") ],
									serial: rowData[ _columns.indexOf("INV_PREFIX") ],
									fromNo: rowData[ _columns.indexOf("FROM_INV_NO") ],
									toNo: rowData[ _columns.indexOf("TO_INV_NO") ]
								};
		                        saveData(data);
	                    	}else{
	                    		useInvConfirm( btn, rowData );
	                    	}
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

		$('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
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

        $('#delete').on('click', function(){
            if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(data){
            		postDel(data);
            	});
            }
        });

		//FUNCTION

		function useInvConfirm( btn, rowData ){
			var data = {
				invno: rowData[ _columns.indexOf("INV_NO") ],
				serial: rowData[ _columns.indexOf("INV_PREFIX") ],
				fromNo: rowData[ _columns.indexOf("FROM_INV_NO") ],
				toNo: rowData[ _columns.indexOf("TO_INV_NO") ]
			};	

			var formData = {
				'action': 'edit',
				'act': 'useInv',
				'useInvData': data
			};

			btn.parent().blockUI();

			$.ajax({
                url: "<?=site_url(md5('Invoice') . '/' . md5('invPrefix'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {

                	btn.parent().unblock();

                    if( data.deny ) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if( data.isDup ){
                    	toastr["error"]( "Số HĐ khai báo sử dụng tiếp theo đã tồn tại trong hệ thống!" );
                        return;
                    }

                    toastr["success"]("Xác nhận sử dụng hóa đơn ["+ formData.useInvData.serail + formData.useInvData.invno +"] thành công!");
                },
                error: function(err){
                	btn.parent().unblock();
                	toastr["error"]("Server Error at [useInvConfirm]!");
                	console.log(err);
                }
            });
		}

		function saveData( useInvData ){
			if (typeof useInvData === "undefined" || useInvData === null) {
				useInvData = {};
			}
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				$.each( newData, function(){
					if ( _ptype.filter( p => p.Code == this["PTYPE"] ).length == 0 )
					{
						this["PTYPE"] = _ptype.filter( p => p.Name == this["PTYPE"] ).map( x => x.Code )[0];
					}
					delete this["rowguid"];
				} );

				var fnew = {
					'action': 'add',
					'useInvData': useInvData,
					'data': newData
				};

				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				$.each( editData, function(){
					if ( _ptype.filter( p => p.Code == this["PTYPE"] ).length == 0 )
					{
						this["PTYPE"] = _ptype.filter( p => p.Name == this["PTYPE"] ).map( x => x.Code )[0];
					}
				} );

				var fedit = {
					'action': 'edit',
					'useInvData': useInvData,
					'data': editData
				};

				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();
        	
			$.ajax({
                url: "<?=site_url(md5('Invoice') . '/' . md5('invPrefix'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {

                	saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if( formData.action == 'edit' ){
                    	toastr["success"]("Cập nhật thành công!");
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                    }

                    if( formData.action == 'add' ){
                    	toastr["success"]("Thêm mới thành công!");
                    	$('#search').trigger('click');
                    }

                    if( Object.keys( formData.useInvData ).length > 0 ){

                    	if( data.isDup ){
	                    	toastr["error"]( "Số HĐ khai báo sử dụng tiếp theo đã tồn tại trong hệ thống!" );
	                    }else{
                    		toastr["success"]("Sử dụng hóa đơn ["+ formData.useInvData.invno +"] thành công!");
	                    }

                    	$('#search').trigger('click');
                    }
                },
                error: function(err){
                	saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delRowguid = data.map(p=>p[_columns.indexOf("rowguid")]);

			var fdel = {
					'action': 'delete',
					'data': delRowguid
				};

			$.ajax({
                url: "<?=site_url(md5('Invoice') . '/' . md5('invPrefix'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    tbl.DataTable().rows('.selected').remove().draw(false);
                	tbl.updateSTT(_columns.indexOf("STT"));
               		toastr["success"]("Xóa dữ liệu thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>