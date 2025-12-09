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
				<div class="ibox-title">KHÁCH HÀNG</div>
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
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Loại</label>
									<div class="col-md-8 col-sm-10 col-xs-10 input-group input-group-sm">
										<select id="customer-type" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Loại khách hàng">
											<option value="" selected>-- [Loại KH] --</option>
											<option value="IsOpr" >Hãng khai thác</option>
											<option value="IsOwner" >Chủ hàng</option>
											<option value="IsAgency" >Đại lý</option>
											<option value="IsLogis" >Giao nhận</option>
											<option value="IsTrans" >Vận chuyển</option>
											<option value="IsOther" >Khác</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Mã</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="cusID" class="form-control form-control-sm" placeholder="Mã khách hàng" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Tên</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="cusName" class="form-control form-control-sm" placeholder="Tên khách hàng" type="text">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">MST</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="cusTaxCode" class="form-control form-control-sm" placeholder="Mã số thuế" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
							<tr>
								<th class="editor-cancel hiden-input">Rowguid</th>
								<th class="editor-cancel">STT</th>
								<th>Mã Khách Hàng</th>
								<th>Tên khách hàng</th>
								<th>Tên viết tắt</th>
								<th>Địa chỉ</th>
								<th>Mã số thuế</th>
								<th>Điện thoại</th>
								<th>Fax</th>
								<th>Email (ĐTTT)</th>
								<th>Email (FWD)</th>
								<th class="editor-cancel data-type-checkbox">Dùng EDO</th>
								<th class="editor-cancel data-type-checkbox">Hãng khai thác</th>
								<th class="editor-cancel data-type-checkbox">Chủ hàng</th>
								<th class="editor-cancel data-type-checkbox">Đại lý</th>
								<th class="editor-cancel data-type-checkbox">Công ty giao nhận</th>
								<th class="editor-cancel data-type-checkbox">Công ty vận tải</th>
								<th class="editor-cancel data-type-checkbox">Khác</th>
								<th class="autocomplete" default-value="Hoạt động">Trạng Thái</th>
								<th class="autocomplete" default-value="Thu ngay">HTTT</th>
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
		var _columns = ["rowguid", "STT", "CusID", "CusName", "SHORT_NAME", "Address", "VAT_CD", "Tel", "Fax", "Email", "EMAIL_DD"
							, "CusStatus", "IsOpr", "IsOwner", "IsAgency", "IsLogis", "IsTrans", "IsOther", "IsActive", "CusType"];

		var tbl = $('#contenttable');
		var dataTbl = tbl.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{
					className: "show-dropdown",
					targets: _columns.getIndexs(["IsActive", "CusType"])
				}
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

		var _status = [
				{ "Code": "0", "Name": "Ngưng hoạt động" },
				{ "Code": "1", "Name": "Hoạt động" }
			],
			_httt = [
				{ "Code": "M", "Name": "Thu ngay" },
				{ "Code": "C", "Name": "Thu sau" }
			];

		var tblHeader = tbl.parent().prev().find('table');
		tblHeader.find('th:eq('+_columns.indexOf("IsActive")+')').setSelectSource( _status.map(p=>p.Name) );
		tblHeader.find('th:eq('+_columns.indexOf("CusType")+')').setSelectSource( _httt.map(p=>p.Name) );
		
		tbl.columnDropdownButton({
			data:[
				{ colIndex: _columns.indexOf( "IsActive" ), source: _status.map( p=>p.Name ) },
				{ colIndex: _columns.indexOf( "CusType" ), source: _httt.map( x => x.Name ) },
			],
			onSelected: function(cell, itemSelected){
				// var temp = "<input type='text' value='"+ itemSelected.attr("code") +"' class='hiden-input'>" + itemSelected.text();

				tbl.DataTable().cell(cell).data(itemSelected.text()).draw(false);

				if(!cell.closest("tr").hasClass("addnew")){
		        	tbl.DataTable().row( cell.closest("tr") ).nodes().to$().addClass("editing");
	        	}

				tbl.DataTable().cell( cell.parent().index(), cell.next() ).focus();
			}
		});

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
								$($.fn.dataTable.tables(true)).DataTable()
																.columns
																.adjust();
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
			$("#contenttable").waitingLoad();
			var btn = $(this);
			btn.button('loading');

			var formData = {
				'action': 'view',
				'cusType':$('#customer-type').val(),
				'cusID':$('#cusID').val(),
				'cusName':$('#cusName').val(),
				'cusTaxCode':$('#cusTaxCode').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "IsActive":
										val='<input class="hiden-input" value="'+rData[colname]+'">' + (rData[colname] ? "Hoạt động" : "Ngưng hoạt động");
										break;
									case "CusType":
										val='<input class="hiden-input" value="'+rData[colname]+'">' 
													+ ( rData[colname] == "C" ? "Thu sau" : ( rData[colname] == "M" ? "Thu ngay" : "") );
										break;
									case "IsOpr":
									case "CusStatus":
									case "IsOwner":
									case "IsAgency":
									case "IsLogis":
									case "IsTrans":
									case "IsOther":
										val='<label class="checkbox checkbox-primary"><input type="checkbox" '+ (parseInt(rData[colname])==1?"checked":"")  +'><span class="input-span"></span></label>';
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
					
					$('#contenttable').DataTable( {
						data: rows,
						paging: true,
						columnDefs: [
							{
								 className: "hiden-input"
								,targets: [_columns.indexOf("rowguid")]
							},
							{
								render: function (data, type, full, meta) {
									return "<div class='wrap-text width-"+(meta.col==_columns.indexOf("Address")?350:250)+"'>" + data + "</div>";
								},
								targets: _columns.getIndexs(["CusName", "SHORT_NAME", "Address"])
							},
							{ 
								 className: "text-center"
								,targets: _columns.getIndexs(["STT", "CusID", "IsOpr", "CusStatus", "IsOwner", "IsAgency", "IsLogis"
																							, "IsTrans", "IsOther", "IsActive", "cHTTT_CHK"])
							}
						],
						order: [[ _columns.indexOf("STT"), 'asc' ]],
						keys:true,
			            autoFill: {
			                focus: 'focus'
			            },
			            select: true,
			            rowReorder: false,
						scroller: {
							displayBuffer: 9,
							boundaryScale: 0.95
						}
					} );

					tbl.realign();
			        tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

					btn.button('reset');
				},
				error: function(err){
					btn.button('reset');
					console.log(err);
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
		function saveData(){
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				newData = mapDataAgain( newData );
				var lostData = newData.filter( p => !p.CusID || !p.CusName || !p.VAT_CD );
				if( lostData.length > 0 ){
					toastr["error"]( "Nhập đầy đủ thông tin bắt buộc [Mã Khách Hàng | Tên Khách Hàng | Mã Số Thuế]" );
					return;
				}

				var checkWrong = newData.filter( p => p.IsAgency == "0" && p.IsLogis == "0" 
														&& p.IsOpr == "0" && p.IsOther == "0" && p.IsOwner == "0" && p.IsTrans == "0");
				if(checkWrong.length > 0){
					toastr["error"]( "Khách hàng ["+ checkWrong.map(p=>p.CusID).join(", ") +"] chưa chọn loại!" );
					return;
				}
				
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				editData = mapDataAgain( editData );

				var lostData = editData.filter( p => !p.CusID || !p.CusName || !p.VAT_CD );
				if( lostData.length > 0 ){
					toastr["error"]( "Nhập đầy đủ thông tin bắt buộc [Mã Khách Hàng | Tên Khách Hàng | Mã Số Thuế]" );
					return;
				}

				var checkWrong = editData.filter( p => p.IsAgency == "0" && p.IsLogis == "0" 
														&& p.IsOpr == "0" && p.IsOther == "0" && p.IsOwner == "0" && p.IsTrans == "0");
				if(checkWrong.length > 0){
					toastr["error"]( "Khách hàng ["+ checkWrong.map(p=>p.CusID).join(", ") +"] chưa chọn loại!" );
					return;
				}

				var fedit = {
					'action': 'edit',
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
                url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
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

                    if(formData.action == 'edit'){
                    	toastr["success"]("Cập nhật thành công!");
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
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

			var delBtn = $('#delete');

			delBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                	delBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    tbl.DataTable().rows('.selected').remove().draw(false);
                	tbl.updateSTT(_columns.indexOf("STT"));
               		toastr["success"]("Xóa dữ liệu thành công!");
                },
                error: function(err){
                	delBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		function mapDataAgain( data ){
        	$.each( data, function(){
        		if ( _status.filter( p => p.Code == this["IsActive"] ).length == 0 && this["IsActive"] )
				{
					this["IsActive"] = _status.filter( p => p.Name.toUpperCase() == this["IsActive"].toUpperCase() ).map( x => x.Code )[0];
				}

				if ( _httt.filter( p => p.Code == this["CusType"] ).length == 0 && this["CusType"] )
				{
					this["CusType"] = _httt.filter( p => p.Name.toUpperCase() == this["CusType"].toUpperCase() )
													.map( x => x.Code )[0];
				}
			} );
			return data;
        }
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>