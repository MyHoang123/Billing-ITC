
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!--    datetime picker-->
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.css');?>">

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">TỶ GIÁ LOẠI TIỀN</div>
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
								<th col-name="CURRENCYID">Đơn vị tiền</th>
								<th col-name="DATEOFRATE" class="data-type-datetime">Ngày nhập tỷ giá</th>
								<th col-name="RATE" class="data-type-numeric" style="text-align: center!important">Tỷ giá</th>
							</tr>
							</thead>
							<tbody>
								<?php if(count($exchange_rates) > 0) {$i = 1; ?>
									<?php foreach($exchange_rates as $item) {  ?>
										<tr>
											<td style="text-align: center"><?=$i;?></td>
											<td><?=$item['CURRENCYID'];?></td>
											<td><?=$this->funcs->clientDateTime($item['DATEOFRATE']);?></td>
											<td><?=$item['RATE'];?></td>
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
		var _columns = ["STT", "CURRENCYID", "DATEOFRATE", "RATE"];
		var tbl = $('#contenttable');

		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className:"text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center", targets: _columns.getIndexs(["CURRENCYID", "DATEOFRATE"]) },
				{ className: "text-right", targets: _columns.indexOf("RATE") }
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
	    	$('.ibox-body').blockUI();

			$.ajax({
	            url: "<?=site_url(md5('Common') . '/' . md5('cmExchangeRate'));?>",
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
	    			$('.ibox-body').unblock();
	            },
	            error: function(err){
	            	toastr["error"]("Error!");
	            	saveBtn.button('reset');
	            	$('.ibox-body').unblock();
	            	console.log(err);
	            }
	        });
		}

		function postDel(rows){
			$('.ibox-body').blockUI();

			var delRateID = rows.map(p=>p[_columns.indexOf("CURRENCYID")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': delRateID
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmExchangeRate'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (output) {
					delBtn.button('reset');
					var data = output.result;
	                if(data.error && data.error.length > 0){
	                	for (var i = 0; i < data.error.length; i++) {
	                		toastr["error"](data.error[i]);
	                	}
	                }

	                if(data.success && data.success.length > 0){
	                	for (var i = 0; i < data.success.length; i++) {
	                		var deletedCurencyID = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "CURRENCYID" ), deletedCurencyID);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );
	                	}
	                }

					$('.ibox-body').unblock();
				},
				error: function(err){
					delBtn.button('reset');
					$('.ibox-body').unblock();
					console.log(err);
				}
			});
		}
	});
</script>

<script type="text/javascript" src="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.js');?>"></script>
