<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

<style>
	
	.dropdown-menu.dropdown-menu-column{
		max-height: 40vh;
		overflow-y: auto;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">CẤU HÌNH CẮM RÚT ĐIỆN LẠNH</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm mẫu mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm mới</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" title="Xóa mẫu">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row">
					<div class="col-sm-12 pr-0">
						<div class="mb-0 border-e pb-1 pt-3 table-responsive p-3 pl-3 pr-3">
							<table id="tbl-content" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
								<thead>
								<tr>
									<th col-name="STT" style="max-width: 20px">STT</th>
									<th col-name="PTNR_CODE" class="autocomplete">Hãng Khai Thác</th>
									<th col-name="ROUNDING" class="autocomplete">Giờ sử dụng điện</th>
									<th col-name="PAYMENT_TYPE" class="autocomplete">Thu ngay/ Thu sau</th>
								</tr>
								</thead>
								<tbody>
								<?php if(count($allconfigs) > 0) {$i = 1; ?>
									<?php foreach($allconfigs as $item) {  ?>
										<tr>
											<td style="text-align: center"><?=$i;?></td>
											<td><?=$item['PTNR_CODE'];?></td>
											<td>
												<input type='text' value='<?=$item['ROUNDING'];?>' class='hiden-input'>
												<?=$item['ROUNDING'] == "R1" ? "Làm tròn lên nửa (1/2) giờ" : "Làm tròn lên 1 giờ";?>
											</td>
											<td>
												<input type='text' value='<?= $item['PAYMENT_TYPE']; ?>' class='hiden-input'>
												<?= $item['PAYMENT_TYPE'] == "C" ? "Thu sau" : "Thu ngay"; ?>
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
</div>

<script type="text/javascript">
	$(document).ready( function () {
		var _columns = ["STT", "PTNR_CODE", "ROUNDING", "PAYMENT_TYPE"];
		
		var tbl = $('#tbl-content');
		var _oprs = <?= json_encode($oprs); ?>;
		//loadGrid(_defaultGridData);
		var roundingSource = [
			{ Code: "R1", Name: "Làm tròn lên nửa (1/2) giờ" },
			{ Code: "R2", Name: "Làm tròn lên 1 giờ" }
		];
		var paymentType = [{
				Code: "M",
				Name: "Thu ngay"
			},
			{
				Code: "C",
				Name: "Thu sau"
			}
		];

    	tbl.DataTable( {
			scrollY: '52vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center show-dropdown", targets: _columns.getIndexs(["PTNR_CODE", "ROUNDING", "PAYMENT_TYPE"]) }
			],
			order: [],
            keys:true,
            autoFill: {
                focus: 'focus'
            },
        	paging: false,
            select: true,
            rowReorder: false
		} );

//------SET AUTOCOMPLETE
			var tblHeader = tbl.parent().prev().find('table');

			tblHeader.find(' th:eq(' + _columns.indexOf( 'PTNR_CODE' ) + ') ').setSelectSource( _oprs.map(p=>p.CusID) );
			tblHeader.find(' th:eq(' + _columns.indexOf( 'ROUNDING' ) + ') ').setSelectSource( roundingSource.map(p=>p.Name) );
			tblHeader.find(' th:eq(' + _columns.indexOf('PAYMENT_TYPE') + ') ').setSelectSource(paymentType.map(p => p.Name));

//------SET AUTOCOMPLETE

		//------SET DROPDOWN BUTTON FOR COLUMN
		tbl.columnDropdownButton({
			data:[
				{ colIndex: _columns.indexOf( "PTNR_CODE" ), source: _oprs.map( p=>p.CusID ) },
				{ colIndex: _columns.indexOf( "ROUNDING" ), source: roundingSource },
				{
					colIndex: _columns.indexOf("PAYMENT_TYPE"),
					source: paymentType
				},
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

		// ----------function button (add, delete, save)--------
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
            	var ptnrCode = tbl.getData().map(p => p[ _columns.indexOf("PTNR_CODE") ]);
            	var checkDupArr = ptnrCode.filter( (item, index) => ptnrCode.indexOf(item) < index );
            	if( checkDupArr.length > 0 ){
            		toastr["error"]("Cấu hình các hãng khai thác: ["
            							+ checkDupArr.filter( (item, index) => checkDupArr.indexOf(item) == index ).join(", ") 
            							+"] bị trùng!");
            		return;
            	}

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
        	$('.ibox').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmPlugConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {

                	saveBtn.button('reset');
        			$('.ibox').unblock();

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
                	toastr["error"]("Server Error at [Save Config.]");
                	saveBtn.button('reset');
                	$('.ibox').unblock();
                	console.log(err);
                }
            });
		}

        function postDel(rows){
			$('.ibox').blockUI();

			var delCodes = rows.map(p=>p[_columns.indexOf("PTNR_CODE")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': delCodes
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmPlugConfig'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (output) {
					delBtn.button('reset');
					$('.ibox').unblock();

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
	                		var deletePTNR_code = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "PTNR_CODE" ), deletePTNR_code);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );
	                	}
	                }

				},
				error: function(err){
					toastr["error"]("Server Error at [Delete Config.]")
					delBtn.button('reset');
					$('.ibox').unblock();
					console.log(err);
				}
			});
		}

	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>