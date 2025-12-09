<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">LOẠI HÀNG</div>
			</div>
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th style="width: 20px">STT</th>
								<th>Mã</th>
								<th>Diễn Giải</th>
							</tr>
							</thead>
							<tbody>
							<?php if(count($cargotypes) > 0) {$i = 1; ?>
								<?php foreach($cargotypes as $item) {  ?>
									<tr>
										<td style="text-align: center"><?=$i;?></td>
										<td><?=$item['Code'];?></td>
										<td><?=$item['Description'];?></td>
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
		$('#contenttable').DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false});
	});
</script>
