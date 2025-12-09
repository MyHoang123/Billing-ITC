<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">Vessel Schedule</div>
			</div>
			<div class="ibox-body">
				<div class="row col-sm-12">
					<div class="col-sm-4 form-group mb-4">
						<div class="input-group-icon input-group-icon-left">
							<span class="input-icon input-icon-left"><i class="ti-alarm-clock"></i></span>
							<input id="from_date" class="form-control form-control-air" placeholder="From date" type="text">
						</div>
					</div>
					<div class="col-sm-4 form-group mb-4">
						<div class="input-group-icon input-group-icon-left">
							<span class="input-icon input-icon-left"><i class="ti-alarm-clock"></i></span>
							<input id="to_date" class="form-control form-control-air" placeholder="To date" type="text">
						</div>
					</div>
					<div class="col-sm-4 form-group mb-4">
						<img class="pointer" src="https://eport.sp-itc.com.vn/assets/img/Search.ico" style="height:30px; width:30px; margin-top: 5px;" onclick="javascript:exec()" />
					</div>
				</div>
				<div class="gantt"></div>
			</div>
		</div>
	</div>
</div>