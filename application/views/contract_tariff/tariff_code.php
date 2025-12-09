
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
	#unitcodes-modal .dataTables_filter{
		width: 200px;
	}
	#unitcodes-modal .dataTables_filter input[type="search"] 
	{
		width: 65%;
	}
	#unitcodes-modal .dataTables_filter > label::after{
		right: 45px!important;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">MÃ BIỂU CƯỚC</div>
				<div class="button-bar-group">
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
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th col-name="STT" class="editor-cancel">STT</th>
								<th col-name="rowguid" class="hiden-input">Row Guid</th>
								<th col-name="TRF_CODE">Mã biểu cước</th>
								<th col-name="TRF_DESC">Diễn giải</th>
								<th col-name="INV_UNIT" class="autocomplete">ĐV hóa đơn</th>
								<th col-name="REVENUE_ACC">TK doanh thu</th>
								<th col-name="VAT_CHK" class="editor-cancel data-type-checkbox">VAT</th>
								<th col-name="DISCOUNT_CHK" class="editor-cancel data-type-checkbox">Giảm giá</th>
							</tr>
							</thead>
							<tbody>
								<?php if(count($trfCodes) > 0) {$i = 1; ?>
									<?php foreach($trfCodes as $item) {  ?>
										<tr>
											<td style="text-align: center"><?=$i;?></td>
											<td><?=$item['rowguid'];?></td>
											<td><?=$item['TRF_CODE'];?></td>
											<td><?=$item['TRF_DESC'];?></td>
											<td><?=$item['INV_UNIT'];?></td>
											<td><?=$item['REVENUE_ACC'];?></td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?=$item['VAT_CHK'];?>" <?=$item['VAT_CHK'] == 1 ? "checked" : "";?> >
													<span class="input-span"></span>
												</label>
											</td>
											<td>
												<label class="checkbox checkbox-primary">
													<input type="checkbox" value="<?=$item['DISCOUNT_CHK'];?>" <?=$item['DISCOUNT_CHK'] == 1 ? "checked" : "";?> >
													<span class="input-span"></span>
												</label>
											</td>
										</tr>
										<?php $i++; }  ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--unicodes modal-->
<div class="modal fade" id="unitcodes-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách đơn vị tính</h5>
			</div>
			<div class="modal-body">
				<table id="tblUnitCode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT" style="width: 15px">STT</th>
							<th col-name="UNIT_CODE">Mã</th>
							<th col-name="UNIT_NM">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($unitCodes) > 0) {$i = 1; ?>
						<?php foreach($unitCodes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['UNIT_CODE'];?></td>
								<td><?=$item['UNIT_NM'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-unitcode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<button class="additional-select-btn btn btn-sm btn-secondary" style="display: none; width: 30px">...</button>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns = ["STT", "rowguid", "TRF_CODE", "TRF_DESC", "INV_UNIT", "REVENUE_ACC", "VAT_CHK", "DISCOUNT_CHK"],
			_colUnit = ["STT", "UNIT_CODE", "UNIT_NM"],
			tbl = $('#contenttable'),
			tblUnitCode = $('#tblUnitCode'),
			unicodeModal = $('#unitcodes-modal');

		var dataTblUnitCode = tblUnitCode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "text-center", targets: _colUnit.indexOf("STT") }
			],
			order: [[ _colUnit.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});

		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "hiden-input", targets: _columns.indexOf("rowguid") },
				{ className: "text-center", targets: _columns.getIndexs(["VAT_CHK", "DISCOUNT_CHK"]) },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _columns.indexOf("TRF_DESC")
				}
			],
			order: [[ _columns.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});

		$('#unitcodes-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		var unitSource= {};
		<?php if(isset($unitCodes) && count($unitCodes) > 0){ ?>
			unitSource = <?= json_encode(array_column($unitCodes, "UNIT_CODE"));?>;
		<?php } ?>

		// tbl.find("th:eq("+_columns.indexOf('INV_UNIT')+")").setSelectSource(unitSource);
		$('#contenttable').parent().prev().find('table').find(' th:eq(' + _columns.indexOf( 'INV_UNIT' ) + ') ').setSelectSource(unitSource);

		tbl.setExtendSelect(_columns.indexOf("INV_UNIT"), function(rIdx, cIdx){
			$("#apply-unitcode").val(rIdx + "." + cIdx);
			unicodeModal.modal("show");
		});
		tbl.editableTableWidget();

		tblUnitCode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-unitcode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				unit = $(this).find("td:eq("+_colUnit.indexOf("UNIT_CODE")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			tbl.DataTable().cell(cell).data(unit).draw();
			unicodeModal.modal("hide");
		});

		$("#apply-unitcode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				unit = tblUnitCode.getSelectedRows().data().toArray()[0][_colUnit.indexOf("UNIT_CODE")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			dataTbl.cell(cell).data(unit).draw();
			var crRow = tbl.find("tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dataTbl.row(crRow).nodes().to$().addClass("editing");
        	}
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

        	var crCell = inp.closest('td'),
        		crRow = inp.closest('tr'),
        		eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html());
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

        $('#addrow').on('click', function(){
            tbl.newRow();
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
            		if(!data || data.length == 0){ return; }
            		postDel(data);
            	});
            }
        });

		//FUNCTION
		function saveData(){
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
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
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTRFCode'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
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
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    }

                    saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delRowguid = data.map(p=>p[_columns.indexOf("rowguid")]);

			var delBtn = $('#delete');
			delBtn.button('loading');

			var fdel = {
					'action': 'delete',
					'data': delRowguid
				};

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTRFCode'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
               		toastr["success"]("Xóa dữ liệu thành công!");
               		location.reload();
                },
                error: function(err){
                	delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}
	});
</script>
<script type="text/javascript">

</script>
