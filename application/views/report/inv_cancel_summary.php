<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/dataTables/extensions/buttons.dataTables.min.css');?>" rel="stylesheet" />

<style>

	.ui-icon{
		margin-top: -0.9em!important;
		margin-left: -8px!important;
	}
	tfoot tr th {
		font-size: 13px!important;
		padding: 10px 8px!important;
	}
	#payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">THỐNG KÊ HOÁ ĐƠN HUỶ</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
						<div class="form-group">
							<label class="mb-0">Ngày hoá đơn</label>
						</div>
						<div class="form-group input-group">
							<input id="fromDate" name="fromDate" class="form-control form-control-sm mr-2" type="text" placeholder="Từ ngày">
							<input id="toDate" name="toDate" class="form-control form-control-sm" type="text" placeholder="Đến ">
						</div>
					</div>
					<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
						<div class="form-group">
							<label class="mb-0">Loại thanh toán</label>
						</div>
						<div class="form-group">
							<select id="payment-type" name="payment-type" class="selectpicker" data-style="btn-default btn-sm bg-white" data-width="100%">
								<option value="CAS" selected>Thu ngay</option>
								<option value="CRE">Thu sau</option>
							</select>
						</div>
					</div>
					<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
						<div class="form-group">
							<label class="mb-0">Hệ thống</label>
						</div>
						<div class="form-group col-form-label">
							<label class="radio radio-inline">
								<input type="radio" name="sys" value="BL" checked>
								<span class="input-span"></span>BILLING</label>
							<label class="radio radio-inline">
								<input type="radio" name="sys" value="EP">
								<span class="input-span"></span>EPORT</label>
						</div>
					</div>
					<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
						<div class="form-group">
							<label class="mb-0"></label>
						</div>
						<div class="form-group">
							<button id="search" class="btn btn-gradient-blue btn-fix btn-sm" type="button">
								<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.9%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Số hoá đơn</th>
								<th>Ngày lập hoá đơn</th>
								<th>Đối tượng thanh toán</th>
								<th>Thành Tiền</th>
								<th>Tiền Thuế</th>
								<th>Tổng Tiền</th>
								<th>Lập bởi</th>
								<th>Người huỷ</th>
								<th>Ngày huỷ</th>
								<th>Lý do huỷ</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
					            <tr style="color:red; font-size:13px">
					                <th colspan="4" style="font-weight: bold;">TỔNG CỘNG</th>
					                <th class="text-right">0</th>
					                <th class="text-right">0</th>
					                <th class="text-right">0</th>
					                <th colspan="4"></th>
					            </tr>
					        </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _cols = ["STT", "INV_NO", "INV_DATE", "CusName", "AMOUNT", "VAT", "TAMOUNT", "CreatedBy", "CancelBy", "CancelDate", "CancelRemark"];
		$('#contenttable').DataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", targets: _cols.indexOf("STT") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _cols.indexOf("CancelRemark")
				},
				{ className: "text-center", targets: _cols.getIndexs(["INV_NO", "INV_DATE", "CancelDate"]) },
				{ type: "num", className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 2)
					, targets: _cols.getIndexs(["AMOUNT", "VAT", "TAMOUNT"])
				}
			],
			order: [[ 0, 'asc' ]],
			paging: false,
			searching: true,
			buttons: [
				{
					extend:    'excel',
					text:      '<i class="fa fa-files-o"></i> Xuất Excel',
					titleAttr: 'Xuất Excel'
				}
			],
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api();
				if( data.length > 0 ){
					var amt = data.map(p=> p[_cols.indexOf("AMOUNT")]).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0),
						vat = data.map(p=> p[_cols.indexOf("VAT")]).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0),
						tamt = data.map(p=> p[_cols.indexOf("TAMOUNT")]).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0);
					$( api.column( 4 ).footer() ).html(  $.formatNumber( amt, { format: "#,###.00", locale: "us" } )  );
					$( api.column( 5 ).footer() ).html(  $.formatNumber( vat, { format: "#,###.00", locale: "us" } )  );
					$( api.column( 6 ).footer() ).html(  $.formatNumber( tamt, { format: "#,###.00", locale: "us" } )  );
				}else{
					$( api.column( 4 ).footer() ).html( 0 );
					$( api.column( 5 ).footer() ).html( 0 );
					$( api.column( 6 ).footer() ).html( 0 );
				}
			}
		});
	
		var fromDate = $('#fromDate');
		var toDate = $('#toDate');
		$.timepicker.datetimeRange(
			fromDate,
			toDate,
			{
				controlType: 'select',
				oneLine: true,
				dateFormat: 'dd/mm/yy',
				timeFormat: 'HH:mm:00',
				timeInput: true
			}
		);	

		fromDate.val(moment().subtract(1, 'day').format('DD/MM/YYYY HH:mm:ss'));
		toDate.val(moment().format('DD/MM/YYYY HH:mm:ss'));

		$('#search').on('click', function () {
			$("#contenttable").dataTable().fnClearTable();
			$("#contenttable").waitingLoad();

			// var jmode = $('#jmode').val();
			
			// var jdate = getFilterDate();
			var formData = {
				'action': 'view',
				'fromDate': $("#fromDate").val(),
				'toDate': $("#toDate").val(),
				'paymentType': $("#payment-type").val(),
				"sys": $("input[name='sys']:checked").val()
			};

			$.ajax({
				url: "<?=site_url(md5('Report') . '/' . md5('rptCancelInv'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [], sumAmt = 0, sumDis = 0, sumVat = 0, sumTamount = 0;

					if( data.results && data.results.length > 0 ) {
						$.each( data.results, function( i, item ) {
							var r = [];
							$.each( _cols, function( idx, colname ){
								var val = "";
								switch(colname){
									case "STT":
										val = i+1;
										break;
									case "INV_DATE":
									case "CancelDate":
										val = getDateTime( item[ colname ] );										
										break;
									default:
										val = item[ colname ] ? item[ colname ] : "";
										break;
								}
								r.push( val );
							} );
							rows.push( r );
						} );
					}

					$('#contenttable').dataTable().fnClearTable();
					if( rows.length > 0 ){
						$('#contenttable').dataTable().fnAddData(rows);
					}
				},
				error: function(err){console.log(err);}
			});
		});
	});

</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>

<script src="<?=base_url('assets/vendors/dataTables/datatables.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/dataTables.buttons.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/extensions/jszip.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/dataTables/extensions/buttons.html5.min.js');?>"></script>

