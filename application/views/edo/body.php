<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-xl-12">
        <div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">EDO Manager</div>
				<div class="button-bar-group mr-3">
					<button id="search" class="btn btn-gradient-blue btn-fix btn-sm" type="button">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
                <div class="row">
                    <table class="table display nowrap" id="contenttable" cellspacing="0" style="width: 99.9%">
                        <thead class="thead-default thead-lg">
                            <tr>
                                <th>STT</th>
                                <th>Số Container</th>
                                <th>Hảng khai thác</th>
                                <th>LocalSZPT</th>
                                <th>ISO_SZTP</th>
                                <th>CntrClass</th>
                                <th>Status</th>
                                <th>DELIVERYORDER</th>
                                <th>BLNo</th>
                                <th>EdoDate</th>
                                <th>PickedUpDate</th>
                                <th>ExpDate</th>
                                <th>Shipper_Name</th>
                                <th>ShipName</th>
                                <th>ShipID</th>
                                <th>ImVoy</th>
                                <th>ExVoy</th>
                                <th>POL</th>
                                <th>POD</th>
                                <th>FPOD</th>
                                <th>CJMODE_CD</th>
                                <th>DMETHOD_CD</th>
                                <th>RetLocation</th>
                                <th>Haulage_Instruction</th>
                                <th>Note</th>
                                <th class="no-sort"></th>
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

<script>
    $(document).ready(function () {
		$('#contenttable').DataTable({
			scrollY: '45vh',
            scrollX: true,
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			buttons: [],
			paging: false
		});
    });
</script>