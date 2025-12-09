<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
<style>
	.hidden-filter{
		display: none;
	}
	.wrap-text{
		white-space: normal!important;
	}

	button[data-id="temp"] span.filter-option{
		padding-right: 15px;
	}

	#unitcodes-modal .dataTables_filter,
	#cargotype-modal .dataTables_filter
	{
		width: 200px;
	}
	#unitcodes-modal .dataTables_filter input[type="search"],
	#cargotype-modal .dataTables_filter input[type="search"]
	{
		width: 65%;
	}

	#unitcodes-modal .dataTables_filter > label::after,
	#cargotype-modal .dataTables_filter > label::after
	{
		right: 45px!important;
	}

	.readonly-temp input{
		border-top: none!important;
		border-left: none!important;
		border-right: none!important;
		border-bottom: 1px dashed #ccc !important;
		cursor: default!important;
	}

	span.sub-text{
		font-size: 75%;
	    color: #bbb;
	    font-style: italic;
	    padding-left: 10px;
	}

	table.dataTable.tbl-template-style thead tr,
	table.dataTable.tbl-template-style td{
		background: none!important;
		border: 0 none !important;
		cursor: default!important;
	}

	table.dataTable.tbl-template-style thead tr th{
		border-bottom: 1px solid #fff!important;
	}

	table.dataTable.tbl-template-style tbody tr.selected{
		color: navy; font-weight: 500;
		/*background-color: rgba(117, 117, 117, 0.8)!important;*/
	}

</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">MẪU BIỂU CƯỚC</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" 
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>

			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-xl-1 col-lg-1 col-2 col-form-label">Mẫu</label>
							<select id="temp" class="selectpicker col-6" data-style="btn-default btn-sm" data-live-search="true">
								<option value="">-- Chọn mẫu biểu cước --</option>
								<?php if(isset($temp) && count($temp) > 0){ foreach ($temp as $item){ ?>
									<option value="<?= $item ?>"><?= $item ?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="padding: 16px 12px">
				<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
							<table id="tbl-template" class="table table-striped display nowrap tbl-template-style" cellspacing="0" style="width: 99.9%">
								<thead>
								<tr>
									<th class="hiden-input">rg</th>
									<th class="editor-cancel">STT</th>
									<th>Mã Template</th>
									<th>Diễn giải</th>
									<th class="autocomplete" default-value="VND">Loại Tiền</th>
								</tr>
								</thead>

								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th col-name="rowguid" class="hiden-input">rowguid</th>
							<th style="max-width: 30px">Chọn</th>
							<th col-name="TRF_CODE">Mã biểu cước</th>
							<th col-name="TRF_STD_DESC">Diễn giải</th>
							<th col-name="IX_CD">Hướng cont</th>
							<th col-name="CARGO_TYPE">Loại hàng</th>
							<th col-name="JOB_KIND">Loại CV</th>
							<th col-name="CNTR_JOB_TYPE">Phương án</th>
							<th col-name="DMETHOD_CD">PTGN</th>
							<th col-name="TRANSIT_CD">Loại hình</th>
							<th col-name="IsLocal">Nội/Ngoại</th>
							<th col-name="CURRENCYID" class="hiden-input">Loại Tiền</th>
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
	$.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
	{
	    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
	        return $('input', td).prop('checked') ? '1' : '0';
	    } );
	};

	$(document).ready(function () {

//------DECLARE VARIABLES
		var _columns = ["rowguid", "Select", "TRF_CODE", "TRF_STD_DESC", "IX_CD", "CARGO_TYPE", "JOB_KIND", "CNTR_JOB_TYPE", "DMETHOD_CD"
						, "TRANSIT_CD", "IsLocal", "CURRENCYID"],
			_columnTemplate = ["rowguid", "STT", "TPLT_NM", "TPLT_DESC", "CURRENCYID"],
			
			tblTemplate = $('#tbl-template'), tbl = $("#contenttable"),

			_lstTemplate = [], _lstTariff = [], _lstForSave = [],
			currencySource = [
				{
					Code : "VND",
					Name : "VND"
				},
				{
					Code : "USD",
					Name : "USD"
				}
			];
//------DECLARE VARIABLES

//------INIT TABLES
		var dataTbl = tbl.DataTable({
			scrollY: '67vh',
			columnDefs: [
				{ 
					className: "text-center"
					, orderDataType: 'dom-checkbox'
					, targets: _columns.indexOf("Select")
				},
				{ className: "hiden-input", targets: _columns.getIndexs(["rowguid", "CURRENCYID"]) },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _columns.indexOf("TRF_STD_DESC")
				}
			],
			language: {
				infoFiltered: '',
			},
			order: [], //_columns.indexOf('Select'), 'desc'
            keys: {
            	columns: ':eq('+ _columns.indexOf("Select") +')'
            },
            autoFill: {
                focus: 'focus'
            },
            buttons: [],
        	paging: true,
			scroller: {
				displayBuffer: 12,
				boundaryScale: 0.5
			},
            select: false,
            rowReorder: false
		});

		tblTemplate.newDataTable({
			scrollY: '67vh',
			columnDefs: [
				{ className: "hiden-input", targets: _columnTemplate.indexOf('rowguid') },
				{ className: "text-center", targets: _columnTemplate.indexOf('STT') },
				{ className: "show-dropdown", targets: _columnTemplate.indexOf('CURRENCYID') }
			],
			order: [[ _columnTemplate.indexOf('STT'), 'asc' ]],
			paging: false,
            keys: true,
            info:false,
            searching:false,
            autoFill: {
                focus: 'focus'
            },
            buttons:[],
            rowReorder: false,
            arrayColumns: _columnTemplate
		});
//------INIT TABLES

//------SET AUTOCOMPLETE FOR COLUMN
		var tblHeader = tblTemplate.parent().prev().find('table');
		tblHeader.find('th[col-name="CURRENCYID"]').setSelectSource( currencySource.map( p=>p.Name ) );
//------SET AUTOCOMPLETE FOR COLUMN

//------SET DROPDOWN BUTTON FOR COLUMN
		tblTemplate.columnDropdownButton({
			data:[
				{ colIndex: _columnTemplate.indexOf( "CURRENCYID" ), source: currencySource },
			],
			onSelected: function(cell, itemSelected){

				tblTemplate.DataTable().cell(cell).data(itemSelected.text()).draw(false);

				if(!cell.closest("tr").hasClass("addnew")){
		        	tblTemplate.DataTable().row( cell.closest("tr") ).nodes().to$().addClass("editing");
	        	}
			}
		});
//------SET DROPDOWN BUTTON FOR COLUMN

		loadInvTemp();

//------EVENTS
		
        $('#addrow').on('click', function () {
			$.confirm({
				columnClass: 'col-md-3 col-md-offset-3',
				titleClass: 'font-size-17',
                title: 'Thêm dòng mới',
                content: '<div class="input-group-icon input-group-icon-left">'
                          +'<span class="input-icon input-icon-left"><i class="fa fa-plus" style="color: green"></i></span>'
                          +'<input autofocus class="form-control form-control-sm" id="num-row" onfocus="this.select()" type="number" placeholder="Nhập số dòng" value="1">'
                        +'</div>',
             	onContentReady: function () {
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
                                tblTemplate.newRows( input.val() );
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

		tblTemplate.on("click", "td", function(e){
			var row = $(e.target).closest("tr");
        	var dtRow = tblTemplate.DataTable().row( row ).nodes().to$();
        	if( dtRow.hasClass("selected") ){
        		return;
        	}

        	tblTemplate.DataTable().rows( '.selected' ).nodes().to$().removeClass( 'selected' );
        	dtRow.addClass("selected");

        	if( tbl.DataTable().rows({filter: 'applied'}).count() == 0 ){
        		return;
        	}

        	window.setTimeout( function(){
        		loadTRFData();
        	}, 50 );
		});

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
			
        	var inp = $( e.target );
        	var checkReturn = false;
        	var rowTempSelected = tblTemplate.DataTable().row( '.selected' ).data();

        	if( !rowTempSelected || rowTempSelected.length == 0 ){

        		$(".toastr").remove();
        		toastr["error"]("Vui lòng chọn một TEMPLATE trước!");

        		checkReturn = true;
        	}

        	if( !rowTempSelected[ _columnTemplate.indexOf("TPLT_NM") ] || !rowTempSelected[ _columnTemplate.indexOf("TPLT_DESC") ] )
        	{
        		$(".toastr").remove();
        		toastr["error"]("Vui lòng nhập đầy đủ thông tin TEMPLATE được chọn!");

        		checkReturn = true;
        	}

        	if( checkReturn )
        	{
        		if(inp.is(":checked")){
	        		inp.removeAttr("checked");
	        		inp.val("");
	        	}else{
	        		inp.attr("checked", "");
	        		inp.val(1);
	        	}

	        	tbl.DataTable().cell( inp.closest("td") ).data( inp.closest("td").html() ).draw(false);

	        	return;
        	}

        	tbl.DataTable().rows( inp.closest("tr") ).nodes().to$().toggleClass("selected");

        	if( inp.is(":checked") )
        	{
        		inp.attr("checked", "");
        		inp.val(1);
        	}else
        	{
        		inp.removeAttr("checked");
        		inp.val("");
        	}

    		var selectedTariff = tbl.DataTable().row( inp.closest("tr") ).data();

    		var sTRFCode = selectedTariff[ _columns.indexOf("TRF_CODE") ],
    			sIX_CD = $( selectedTariff[ _columns.indexOf("IX_CD") ] ).val(),
    			sCARGO_TYPE = $( selectedTariff[ _columns.indexOf("CARGO_TYPE") ] ).val(),
    			sDMethod_CD = selectedTariff[ _columns.indexOf("DMETHOD_CD") ],
    			sCntrJobType = $( selectedTariff[ _columns.indexOf("CNTR_JOB_TYPE") ] ).val(),
    			sCURRENCYID = selectedTariff[ _columns.indexOf("CURRENCYID") ],
    			sJobKind = $( selectedTariff[ _columns.indexOf("JOB_KIND") ] ).val(),
    			sTemp_Rowguid = rowTempSelected[ _columnTemplate.indexOf("rowguid") ],
    			sTPLT_NM = rowTempSelected[ _columnTemplate.indexOf("TPLT_NM") ],
    			sTPLT_DESC = rowTempSelected[ _columnTemplate.indexOf("TPLT_DESC") ],
    			sIsLocal = $( selectedTariff[ _columns.indexOf("IsLocal") ] ).val(),
    			sTRF_STD_DESC = selectedTariff[ _columns.indexOf("TRF_STD_DESC") ],
    			sSTD_ROW_ID = selectedTariff[ _columns.indexOf("rowguid") ]

    		if( _lstForSave.length > 0 )
    		{
    			var findIdx = _lstForSave.findIndex( p=>p.rowguid == sTemp_Rowguid && p.STD_ROW_ID == sSTD_ROW_ID );
    			if( findIdx > -1 )
    			{
    				_lstForSave[findIdx].Select = inp.is(":checked") ? 1 : 0;
    			}else
    			{
    				_lstForSave.push({
        				Select: inp.is(":checked") ? 1 : 0,
        				rowguid: sTemp_Rowguid,
        				TPLT_NM: sTPLT_NM,
        				TRF_CODE: sTRFCode,
        				IX_CD: sIX_CD,
        				CARGO_TYPE: sCARGO_TYPE,
        				DMETHOD_CD: sDMethod_CD,
        				CNTR_JOB_TYPE: sCntrJobType,
        				CURRENCYID: sCURRENCYID,
        				JOB_KIND: sJobKind,
        				TPLT_DESC: sTPLT_DESC,
        				IsLocal: sIsLocal,
        				EQU_TYPE: '*',
        				TRF_STD_DESC: sTRF_STD_DESC,
        				STD_ROW_ID: sSTD_ROW_ID
        			});
    			}
    		}else
    		{
    			_lstForSave.push({
    				Select: inp.is(":checked") ? 1 : 0,
    				rowguid: sTemp_Rowguid,
    				TPLT_NM: sTPLT_NM,
    				TRF_CODE: sTRFCode,
    				IX_CD: sIX_CD,
    				CARGO_TYPE: sCARGO_TYPE,
    				DMETHOD_CD: sDMethod_CD,
    				CNTR_JOB_TYPE: sCntrJobType,
    				CURRENCYID: sCURRENCYID,
    				JOB_KIND: sJobKind,
    				TPLT_DESC: sTPLT_DESC,
    				IsLocal: sIsLocal,
    				EQU_TYPE: '*',
    				TRF_STD_DESC: sTRF_STD_DESC,
    				STD_ROW_ID: sSTD_ROW_ID
    			});
    		}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	eTable.row(crRow).nodes().to$().addClass("editing");

        	console.log(_lstForSave);
        });

        tbl.DataTable().on( 'autoFill', function ( e, datatable, cells ) {
        	var startRowIndex = cells[0][0].index.row,
        		endRowIndex = cells[cells.length - 1][0].index.row,
        		dtTbl = tbl.DataTable();

        	var rows = [];
        	$.each(cells, function(idx, item){
        		rows.push(item[0].index.row);
        	});

        	dtTbl.rows(rows).nodes().to$().addClass("editing").find("input[type='checkbox']").trigger("change");
		});

		$('#temp').on('change', function () {
			if( !$(this).val() ){
				tbl.dataTable().fnClearTable();
				return;
			}

			if( tbl.getAddNewData().length > 0 || tbl.getEditData().length > 0 ){
				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Các thay đổi sẽ KHÔNG được lưu lại!\nTiếp tục thao tác?',
		            buttons: {
		                ok: {
		                    text: 'Tiếp tục',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
		                    	$("#temp").data( "old", $("#temp").val() );
		                        templateChanged();
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC'],
		                    action: function(){
		                    	$("#temp").val( $("#temp").data("old") ).selectpicker("refresh");
		                    }
		                }
		            }
		        });
			}else
			{
				$("#temp").data( "old", $("#temp").val() );
				templateChanged();
			}
		});

		$('#save').on('click', function(){

            if( _lstForSave.length == 0 && tblTemplate.DataTable().rows('.editing').count() == 0 ){
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
            if(tblTemplate.DataTable().rows('.selected').count() == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tblTemplate.confirmDelete( function(data){
            		if( !data || data.length == 0){ return; }
            		postDel(data);
            	});
            }
        });
//------EVENTS

//------FUNCTION
		function mapDataAgain( data ){
        	$.each( data, function(){
				if ( cntrClassSource.filter( p => p.CLASS_Code == this["IX_CD"] ).length == 0 )
				{
					this["IX_CD"] = cntrClassSource.filter( p => p.CLASS_Name == this["IX_CD"] ).map( x => x.CLASS_Code )[0];
				}

				if ( cargoTypeSource.filter( p => p.Code == this["CARGO_TYPE"] ).length == 0 )
				{
					this["CARGO_TYPE"] = cargoTypeSource.filter( p => p.Description == this["CARGO_TYPE"] ).map( x => x.Code )[0];
				}

				if ( dmethodSource.filter( p => p.DMethod_CD == this["DMETHOD_CD"] ).length == 0 )
				{
					this["DMETHOD_CD"] = dmethodSource.filter( p => p.DMethod_Name == this["DMETHOD_CD"] ).map( x => x.DMethod_CD )[0];
				}

				if ( transitSource.filter( p => p.Transit_CD == this["TRANSIT_CD"] ).length == 0 )
				{
					this["TRANSIT_CD"] = transitSource.filter( p => p.Transit_Name == this["TRANSIT_CD"] ).map( x => x.Transit_CD )[0];
				}

				if ( isLocalSource.filter( p => p.Code == this["IsLocal"] ).length == 0 )
				{
					this["IsLocal"] = isLocalSource.filter( p => p.Name == this["IsLocal"] ).map( x => x.Code )[0];
				}

				if ( currencySource.filter( p => p.Code == this["CURRENCYID"] ).length == 0 )
				{
					this["CURRENCYID"] = currencySource.filter( p => p.Name == this["CURRENCYID"] ).map( x => x.Code )[0];
				}
			} );

			return data;
        }

		function saveData(){
			var dataTPLT_NM = tblTemplate.DataTable().column( _columnTemplate.indexOf("TPLT_NM") ).data().toArray();

			dataTPLT_NM = dataTPLT_NM.slice().sort();
			var dup = [];
			for( var i = 0; i < dataTPLT_NM.length - 1; i++ ){
				if ( dataTPLT_NM[i + 1] == dataTPLT_NM[i] ) {
			        dup.push( dataTPLT_NM[i] );
			    }
			}

			if( dup.length > 0 ){
				$(".toast").remove();
				toastr["error"]( "Các mã template ["+ dup.join(", ") +"] bị trùng!" );
				return;
			}

			_lstForSave = _lstForSave.filter( p=> p.Select == 1 || p.rowguid );

			//check if has edit on grid -> update _lstForSave
			var editTempData = tblTemplate.getEditData();

			if( editTempData.length > 0 ){
				$.each(_lstForSave, function(i, v){
					var item = editTempData.filter( p=>p.rowguid == v.rowguid );
					if( item.length > 0 ){
						_lstForSave[i].TPLT_NM = item[0].TPLT_NM;
						_lstForSave[i].TPLT_DESC = item[0].TPLT_DESC;
						_lstForSave[i].CURRENCYID = item[0].CURRENCYID;
					}

					_lstForSave[i]["hasUpdate"] = item.length > 0;
				});	
			}

        	var formData = {
        		"action": "edit",
        		"only_update": false,
        		"data": _lstForSave
        	};

        	if( editTempData.length > 0 && _lstForSave.length == 0 ){
        		formData.only_update = true;
        		formData.data = editTempData;
        	}

			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox-footer').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Template'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if( data.nothing ){
                    	alert( data.nothing );
                    }

                    if( data.error && data.error.length > 0 ){
                    	$.each( data.error, function(){
                    		toastr["error"](this);
                    	} );
                    }else
                    {
                    	toastr["success"]("Lưu dữ liệu thành công!");
                    }

                    _lstForSave = [];
                    tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");

                    loadInvTemp();

                    saveBtn.button('reset');
        			$('.ibox-footer').unblock();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox-footer').unblock();
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delRowguid = data.map(p=>p[_columnTemplate.indexOf("rowguid")])[0];

			var delBtn = $('#delete');
			delBtn.button('loading');

			$('.ibox.collapsible-box').blockUI();

			var fdel = {
				'action': 'delete',
				'data': delRowguid
			};

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Template'));?>",
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

                    if( !data.result ){
                    	toastr["error"]( data.error );
                    	return;
                    }

               		toastr["success"]("Xóa dữ liệu thành công!");

               		tblTemplate.DataTable().rows('.selected').remove().draw(false);
               		_lstForSave = _lstForSave.filter( p => p.rowguid != delRowguid );
               		// location.reload();
                },
                error: function(err){
                	delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

        function templateChanged()
        {
        	// reset list for save when change tariff
        	_lstForSave = [];

			if( $('#temp').val() ){
				loadTariff();
			}else{
				tbl.dataTable().fnClearTable();
			}
        }

        function loadInvTemp(){
        	tblTemplate.dataTable().fnClearTable();
        	tblTemplate.waitingLoad();

			var formData = {
				'action': 'view',
				'act': 'load_inv_tplt'
			};

			$.ajax({
				url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Template'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					if( response.deny ){
						toastr["error"] (response.deny);
						tblTemplate.dataTable().fnClearTable();
						return;
					}
					if(response.error){
						toastr["error"]( response.error );
						tblTemplate.dataTable().fnClearTable();
						return;
					}

					_lstTemplate = response.templates;

					var i = 0;
		  			var n = _lstTemplate.filter((obj, pos, arr) => {
						        return _lstTemplate.map(mapObj => mapObj.TPLT_NM).indexOf(obj.TPLT_NM) === pos;
						    })
		  					.map(function(x){
				        		i++;
				        		return [x.rowguid, i, x.TPLT_NM, x.TPLT_DESC, x.CURRENCYID];
				        	});

		        	tblTemplate.dataTable().fnClearTable();
		        	tblTemplate.dataTable().fnAddData(n);

					tblTemplate.editableTableWidget();
				},
				error: function(err){console.log(err); toastr["error"] ("Server Error: [loadInvTemp]"); tblTemplate.dataTable().fnClearTable(); }
			});
        }

		function loadTariff(){
			
			tbl.dataTable().fnClearTable();
			tbl.waitingLoad();

			var formData = {
				'action': 'view',
				'act': 'load_tariff',
				'temp':$('#temp').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Template'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					if( response.deny ){
						toastr["error"] (response.deny);
						tbl.dataTable().fnClearTable();
						return;
					}
					if(response.error){
						toastr["error"]( response.error );
						tbl.dataTable().fnClearTable();
						return;
					}

					_lstTariff = response.list;

		        	if( _lstTariff.length == 0 ){
		        		tbl.dataTable().fnClearTable();
		        		return;
		        	}

		        	var n2 = _lstTariff.map( function(x) {
		        		return [
		        			  x.rowguid
							, '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>'
							, x.TRF_CODE ? x.TRF_CODE : ''
							, x.TRF_STD_DESC ? x.TRF_STD_DESC : ''
							, '<input class="hiden-input" value="'+ x.IX_CD +'">' 
											+ ( x.CLASS_Name ? x.CLASS_Name : x.IX_CD )
							, '<input class="hiden-input" value="'+ x.CARGO_TYPE +'">'
											+ ( x.Description ? x.Description : x.CARGO_TYPE )
							, '<input class="hiden-input" value="' + x.JOB_KIND + '">'
											+ ( x.JobName ? x.JobName : x.JOB_KIND )
							, '<input class="hiden-input" value="'+x.CNTR_JOB_TYPE+'">'
											+ ( x.CJModeName ? x.CJModeName : x.CNTR_JOB_TYPE )
							, x.DMETHOD_CD ? x.DMETHOD_CD : ''
							, '<input class="hiden-input" value="'+ x.TRANSIT_CD +'">'
											+ ( x.Transit_Name ? x.Transit_Name : x.TRANSIT_CD )
							, '<input class="hiden-input" value="'+ x.IsLocal +'">'
											+ ( x.IsLocal == "F" ? "Ngoại" : ( x.IsLocal == "L" ? "Nội" : x.IsLocal ) )
							, x.CURRENCYID ? x.CURRENCYID : ''
						];
		        	});
		    //     	.sort(function(a, b){
		    //     		if (a[1] < b[1]) return 1;
						// if (a[1] > b[1]) return -1;
						// return 0;
		    //     	})
		    //     	.map(function(y){
		    //     		return y.slice( 1 );
		    //     	});

		        	tbl.dataTable().fnClearTable();
		        	if( n2.length > 0 ){
			        	tblTemplate.DataTable().rows( '.selected' ).nodes().to$().removeClass( 'selected' );
			        	tbl.dataTable().fnAddData(n2);
		        	}
				},
				error: function(err){console.log(err); toastr["error"] ("Server Error: [loadTariff]"); tbl.dataTable().fnClearTable(); }
			});
		}

		function loadTRFData(){
        	var tempSelected = tblTemplate.getSelectedData();
        	if(!tempSelected || tempSelected.length == 0) return;

        	var currencyID = tempSelected[0][ _columnTemplate.indexOf("CURRENCYID") ];
        	var	tpltCode = tempSelected[0][ _columnTemplate.indexOf("TPLT_NM") ];
        	var std_rowguids = _lstTemplate.filter( p => p.TPLT_NM == tpltCode ).map( x => x.STD_ROW_ID.trim().toUpperCase() );

        	tbl.DataTable().rows('.selected').nodes().to$().removeClass('selected');
        	tbl.DataTable().columns( _columns.indexOf("CURRENCYID") )
		        			.search('')
		        			.search( currencyID )
		        			.draw(false);

        	if( tbl.DataTable().rows({filter: 'applied'}).count() == 0 ){
        		return;
        	}

        	tbl.find("tbody tr")
	        			.find( 'td:eq('+ _columns.indexOf("Select") +') input[type="checkbox"]:checked' )
	        			.val( "0" )
	        			.prop('checked', false);

	        if( !std_rowguids || std_rowguids.length == 0 ){
	        	return;
	        }
	        else{
	        	$.each( tbl.find("tbody tr"), function(){
		        	var rowguid = $(this).find("td:eq(" + _columns.indexOf("rowguid") + ")").text();
		        	if( std_rowguids.indexOf( rowguid ) != -1 ){
		        		var cellSelect = $(this).find( 'td:eq('+ _columns.indexOf("Select") +')' );

		        		cellSelect.find( 'input[type="checkbox"]' )
			        				.val( "1" )
			        				.prop('checked', true);
		        	}
		        } );
	        }

	        if( _lstForSave.length > 0 ){
	        	var chkReorder = false;

	        	$.each( tbl.find("tbody tr"), function(){
		        	var rowguid = $(this).find("td:eq(" + _columns.indexOf("rowguid") + ")").text();

		        	var itemInSave = _lstForSave.filter( p=>p.STD_ROW_ID == rowguid );
		        	if( itemInSave && itemInSave.length > 0 ){
		        		var cellSelect = $(this).find( 'td:eq('+ _columns.indexOf("Select") +')' );

		        		cellSelect.find( 'input[type="checkbox"]' )
			        				.val( itemInSave[0].Select )
			        				.prop('checked', itemInSave[0].Select == 1 ? true : false );

			        	chkReorder = true;
		        	}
		        } );

	        	// if( chkReorder ){
	        	// 	tblAttach.DataTable()
						    // .order( [ _columnsAttach.indexOf( "Select" ), 'desc' ] )
						    // .draw( false );
	        	// }
	        }
        }
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/js/xlsx.full.min.js');?>"></script>