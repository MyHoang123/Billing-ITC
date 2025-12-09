<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
<style>
	.hidden-filter{
		display: none;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BẢNG MAPPING KÍCH CỠ ISO</div>
			</div>
			<div class="ibox-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0">
						<div class="row form-group">
							<label class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-xs-3 col-form-label">Hãng khai thác</label>
							<div class="col-xl-4 col-lg-5 col-md-5 col-sm-9 col-xs-9">
								<div class="input-group input-group-sm">
									<select id="oprs" class="selectpicker" data-width="70%" data-live-search="true" mobile="true">
										<option value="" selected>-- [Hãng khai thác] --</option>
										<?php if(isset($oprs) && count($oprs) > 0){ foreach ($oprs as $item){ ?>
											<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
										<?php }} ?>
									</select>
									<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon ml-2 btn-sm">
										<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th style="width: 30px">STT</th>
								<th>Hãng Khai Thác</th>
								<th>Kích Cỡ Nội Bộ</th>
								<th>Kích Cỡ ISO</th>
								<th>Kích Cỡ</th>
								<th>Chiều Cao</th>
								<th>Tính Chất</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		if(isMobile.any()){
			$('#oprs').selectpicker('mobile');
		}
		$('#search').on('click', function () {
			if(!$('#oprs').val()){
				toastr['error']("Vui lòng chọn Hãng khai thác!"); return;
			}

			$("#contenttable tr:not(:first)").remove();
			$("#contenttable tbody:first").append('<tr>' +
				'<td colspan="7" align="center"><img src=<?=base_url('/assets/img/process-bar.gif');?>></td>' +
				'</tr>');

			var formData = {
				'action': 'view',
				'Oprs':$('#oprs').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmSizeTypeMap'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							rows.push([ (i+1)
								, data.list[i].OprID
								, data.list[i].LocalSZPT
								, data.list[i].ISO_SZTP
								, data.list[i].SZ_CD
								, data.list[i].Heigh_CD
								, data.list[i].CntrType_CD
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
							{ width: "30px", targets: 0 },
							{ className: "text-center", targets: 0 }
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 9,
							boundaryScale: 0.95
						}
					} );
				},
				error: function(err){console.log(err);}
			});
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>