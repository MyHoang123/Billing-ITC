
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">ĐƠN VỊ TÍNH</div>
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
								<th col-name="STT" style="width: 20px">STT</th>
								<th col-name="UNIT_CODE">Mã</th>
								<th col-name="UNIT_NM">Diễn Giải</th>
							</tr>
							</thead>
							<tbody>
							<?php if(count($unitcodes) > 0) {$i = 1; ?>
								<?php foreach($unitcodes as $item) {  ?>
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
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns = ["STT", "UNIT_CODE", "UNIT_NM"];
		var tbl = $('#contenttable');

		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") }
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

		tbl.editableTableWidget();

        $('#addrow').on('click', function(){
            tbl.newRow();
        });

        $('#delete').on('click', function () {
        	if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(selectedData){
            		postDel(selectedData);
            	});
            }
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


        //save functions
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
                url: "<?=site_url(md5('Common') . '/' . md5('cmUnitCode'));?>",
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
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

        function postDel(rows){
			$('.ibox.collapsible-box').blockUI();

			var delUnits = rows.map(p=>p[_columns.indexOf("UNIT_CODE")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': delUnits
			};
			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmUnitCode'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (output) {
					delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

					if( output.deny ) {
                        toastr["error"](output.deny);
                        return;
                    }

					var data = output.result;

					if( !data ){
						toastr["warning"]( "Không có gì để xóa!" );
						return;
					}

	                if( data.error && data.error.length > 0 ){
	                	for (var i = 0; i < data.error.length; i++) {
	                		toastr["error"](data.error[i]);
	                	}
	                }

	                if( data.success && data.success.length > 0 ){
	                	for (var i = 0; i < data.success.length; i++) {
	                		var deletedUnitCode = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "UNIT_CODE" ), deletedUnitCode);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );
	                	}
	                }

				},
				error: function(err){
					delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();
					console.log(err);
				}
			});
		}
	});
</script>