<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />

<style>
	.nav-tabs{
		height: inherit!important;
	}

	.m-row-selected{
		background: violet;
	}

	.MT-toggle, .PY-toggle{
		display: none;
	}

	.MT-toggle button, .PY-toggle button {
		background-color: #fff!important;
	}

	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold!important;
		padding-right: 0 !important;
	}
	
	.grid-hidden{
		display: none;
	}

	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		padding: 0;
		max-width: 100%!important;
	}

	.modal-dialog-mw-py .modal-body{
		width: 90%!important;
		margin: auto;
	}

	.unchecked-Salan{
		pointer-events: none;
	}
	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label{
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.dataTable th label.checkbox span.input-span,
    .dataTable td label.checkbox span.input-span{
    	height: 16px!important;
    	width: 16px!important;
    	left: 5px!important;
    	border-color: #000060!important;

    }
    .dataTable th label.checkbox span.input-span:after,
    .dataTable td label.checkbox span.input-span:after{
    	left: 5px!important;
    	top: 1px!important;
    }

    #payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}

	.success-head-icon {
        position: relative;
        height: 100px;
        width: 100px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        background-color: #fff;
        color: green;
        border-radius: 50%;
        transform: translateY(-25%);
        z-index: 2;
        border: solid 10px green;
    }

    #payment-success-modal ul{
    	list-style-image: url("<?=base_url('assets/img/icons/sqpurple.gif');?>");
    }

    #payment-success-modal ul li{
    	padding-bottom: 10px;
    }

    button:disabled{
    	color: #929394!important;
    	border-color: #929394;
    	cursor: not-allowed;
    }

    button:disabled:hover{
    	background-color: transparent!important;
    }

	.m-show-modal{
        position:fixed;top:0;left:0;width:100vw;height:100vh;display:none; z-index: 1002
    }
    .m-show-modal .m-modal-background{
        background-color:rgba(0,0,0,0.5);width:100%;height:100%;top:0;left:0;position:absolute;z-index:98
    }
    .m-show-modal .m-modal-content{
        position:absolute;top:0;left:0;width:100%;height:100%;z-index:99
    }
    .m-close-modal{
        position: fixed;
        z-index: 100;
        top: 8px;
        right: 12vw;
        color: #fff;
        cursor: pointer;
    }
    .m-close-modal i{
        padding: 5px;
        border-radius: 50%;
    }

    .m-close-modal i:hover{
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dropdown-item {
        padding: .95rem 3.5rem!important;
    }
    .btn.dropdown-arrow:after{
        left: .7rem!important;
    }

    .m-hidden{
        display: none;
    }
</style>

<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">PHÁT HÀNH HÓA ĐƠN</div>
				<div class="button-bar-group mr-3">
					<label class="checkbox checkbox-blue mr-3">
						<input type="checkbox" name="eport-inv">
						<span class="input-span"></span>
						Hoá đơn EPORT
					</label>
					<button type="button" id="load-data" title="Nạp dữ liệu"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-refresh"></i>
						Nạp dữ liệu
					</button>
					<button type="button" id="m-inv" title="Xuất hóa đơn giấy"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang xuất" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-edit"></i>
						Xuất hóa đơn giấy
					</button>
					<button type="button" id="e-inv" title="Xuất hóa đơn điện tử"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang xuất" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-internet-explorer"></i>
						Xuất hóa đơn điện tử
					</button>
					<button type="button" id="print-draft" title="In phiếu tính cước"
							data-loading-text="<i class='la la-spinner spinner'></i>Đang in" class="btn btn-sm btn-outline-primary mr-1">
						<i class="fa fa-print"></i>
						In phiếu tính cước
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row">
					<div class="col-3 ibox mb-0 border-e py-3 mb-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Khoảng ngày</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="fromDate" type="text" placeholder="Từ ngày">
								<span>&ensp;</span>
								<input class="form-control form-control-sm" id="toDate" type="text" placeholder="Đến ngày">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Hình thức</label>
							<div class="col-sm-8">
								<select id="paymentType" class="selectpicker" data-style="btn-default btn-sm" data-width="100%"
																			  title="Chọn hình thức thanh toán">
									<option value="CAS">Thu ngay</option>
									<option value="CRE">Thu sau</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Loại tiền</label>
							<div class="col-sm-8 input-group input-group-sm">
								<select id="moneyType" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" title="Chọn loại tiền">
									<option value="VND">VND</option>
									<option value="USD">USD</option>
								</select>
							</div>
						</div>
					</div>

					<!-- ///////////////////////////////// -->

					<div class="col-9 ibox mb-0 border-e pt-3 mb-3">
						<div class="ml-3">
							<div class="row">
								<div class="col-sm-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Hóa đơn giấy</label>
										<div class="col-sm-8">
											<div class="col-form-label text-danger font-bold">
												<?php if( isset( $ssInvInfo ) && count( $ssInvInfo ) > 0 ){ ?>
													<span id="ss-invNo">
														<?= $ssInvInfo['serial'].substr("00000000".$ssInvInfo['invno'], -8)?>
														<?php if( $isDup ) { ?>
															&ensp;
															[BỊ TRÙNG]
														<?php } ?>
													</span>
													&ensp;
													<button id="change-ssinvno"
															class="btn btn-outline-secondary btn-icon-only btn-sm"
															data-toggle="modal"
															data-target="#change-ssinv-modal"
															title="Thay đổi hóa đơn sử dụng tiếp theo"
															style="width: 45px; height: 18px">
														<i class="fa fa-pencil"></i>
													</button>
												<?php } else{ ?>
													<span id="ss-invNo">
														Chưa khai báo!
													</span>
													&ensp;
													<button id="change-ssinvno" class="btn btn-outline-secondary btn-icon-only btn-sm"
															data-toggle="modal"
															data-target="#change-ssinv-modal"
															title="Khai báo số hóa đơn sử dụng tiếp theo"
															style="width: 45px; height: 18px">
														<i class="fa fa-pencil"></i>
													</button>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Phương thức</label>
										<div class="col-sm-8 input-group input-group-sm">
											<select id="paymentMethod" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" title="Chọn phương thức">
												<option value="TM">Tiền mặt</option>
												<option value="CK">Chuyển khoản</option>
												<option value="TM/CK" selected>Tiền mặt/ Chuyển khoản</option>
												<option value="CK">MB Bank QR Payment</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Loại hóa đơn</label>
										<div class="col-sm-8 input-group input-group-sm">
											<select id="invType" class="selectpicker input-required" data-style="btn-default btn-sm"
																					  data-width="100%" title="Chọn loại hóa đơn">
												<option value="VND">Tiền VND</option>
												<option value="USD">Tiền USD</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label">Ngày lập HĐ</label>
										<div class="col-sm-8 input-group input-group-sm">
											<input class="form-control form-control-sm input-required" id="invDate" type="text" placeholder="Ngày lập" disabled>
										</div>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="row form-group">
										<label class="col-sm-2 col-form-label">Diễn giải</label>
										<div class="col-sm-10 input-group input-group-sm">
											<textarea class="form-control" rows="1" id="remark" style="height: 28px"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="row form-group">
										<label class="col-sm-4 col-form-label" title="Đối tượng thanh toán">ĐTTT *</label>
										<div class="col-sm-8 input-group">
											<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
											<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
													title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
												<i class="ti-search"></i>
											</span>
										</div>
										<input class="hiden-input" id="cusID" readonly>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="row form-group">
										<div class="col-sm-12 col-form-label" style="font-size:10px">
											<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name"> [Tên đối tượng thanh toán]</span>&emsp;
											<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr"> [Địa chỉ]</span>&emsp;
											<i class="fa fa-tags" style="font-size: 15px!important;"></i>-<span id="payment-type" data-value="C" style="text-transform: uppercase; font-weight: bold;"> [Hình thức thanh toán]</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-12 ibox mb-0 border-e pb-1 pt-3 mb-3">
						<table id="tbl-draft" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th>STT</th>
								<th>
									<label class="checkbox checkbox-outline-ebony">
										<input type="checkbox" name="select-all-draft" value="*" style="display: none;">
										<span class="input-span"></span>
									</label>
								</th>
								<th>Số Phiếu Tính Cước</th>
								<th>Ngày Lập Phiếu</th>
								<th>Số Lệnh</th>
								<th>Mã ĐTTT</th>
								<th>Tên ĐTTT</th>
								<th>Thành Tiền</th>
								<th>Tiền Thuế</th>
								<th>Tổng Tiền</th>
								<th>Loại Tiền</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12 ibox mb-0 border-e pb-1 pt-3">
						<table id="tbl-draft-details" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Số phiếu tính cước</th>
								<th>Mã biểu cước</th>
								<th>Diễn Giải</th>
								<th>ĐVT</th>
								<th>Loại hàng</th>
								<th>Kích cỡ</th>
								<th>Hàng/rỗng </th>
								<th>Nội/ngoại</th>
								<th>Số lượng</th>
								<th>Đơn giá</th>
								<th>CK (%)</th>
								<th>Đơn giá CK</th>
								<th>Đơn giá sau CK</th>
								<th>Thành tiền</th>
								<th>VAT (%)</th>
								<th>Tiền Thuế</th>
								<th>Tổng tiền</th>
								<th>Ghi Chú</th>
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

<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0"  style="width: 100%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Mã ĐT</th>
							<th>MST</th>
							<th>Tên</th>
							<th>Địa chỉ</th>
							<th>HTTT</th>
						</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" style="position: relative; padding: 22px 15px !important">
				<button type="button" id="select-payer" class="btn btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>

			</div>
		</div>
	</div>
</div>

<!--payment success modal-->
<div class="modal fade" id="payment-success-modal" tabindex="-1" 
						role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 550px">
		<div class="modal-content" style="border-radius: 20px!important;">
			<div class="modal-body" style="padding: 50px 50px 10px">
				<h1 class="text-center font-bold mb-5">HOÀN TẤT !</h1>
		        <div class="text-center">
		            <span class="success-head-icon"><i class="fa fa-check"></i></span>
		        </div>
		        <h5 class="mb-5 text-center">Hóa đơn đã được phát hành thành công!</h5>

		        <ul class="ml-5">
		        	<li>
				        <h5 >Số lệnh: <span id="inv-order-no" class="font-bold" style="font-size: 20px; color: #c5285e"></span></h5>
		        	</li>
		        	<li>
				        <h5 >Số PIN: <span id="inv-pin-code" class="font-bold" style="font-size: 20px; color: #c5285e"></span></h5>
		        	</li>
		        	<li>
		        		<h5>Số hóa đơn: <span id="inv-no" class="font-bold" style="font-size: 20px; color: #c5285e"></span></h5>
		        	</li>
		        	
		        	<li>
		        		<h5 >Số tiền: <span id="inv-tamount" class="font-bold" style="font-size: 20px; color: #c5285e"></span></h5>
		        	</li>
		        	<li>
		        		<h5 >Người đại diện: <span id="inv-payer-name" class="font-bold" style="font-size: 20px;"></span></h5>
		        	</li>
		        	<li>
						<div class="input-group">
							<label class="col-form-label font-normal" style="font-size: 20px">Email: &ensp;</label>
							<input id="inv-payer-email" class="form-control form-control-sm" type="text"> 
						</div>
						
		        	</li>
		        </ul>
		        
			</div>
			<div class="modal-footer" style="display: block!important">
				<div class="row">
		            <div class="col-sm-4">
		                <a class="btn btn-lg btn-default btn-rounded btn-block" data-dismiss="modal">Đóng lại</a>
		            </div>
		            <div class="col-sm-4">
		                <button class="btn btn-lg btn-outline-primary btn-rounded btn-block" id="view-inv">In hóa đơn</button>
		            </div>
		            <div class="col-sm-4">
		                <!-- <a class="btn btn-lg btn-outline-warning btn-rounded btn-block" id="send-email">Gởi email</a> -->
		                <button type="button" class="btn btn-lg btn-outline-warning btn-rounded btn-block" id="send-email"
								data-loading-text="<i class='la la-spinner spinner'></i>Đang gởi">
							Gởi email
						</button>
		            </div>
		        </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="change-ssinv-modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 300px">
		<div class="modal-content" style="border-radius: 5px">
			<div class="modal-header" style="border-radius: 5px;background-color: #fdf0cd;">
				<h4 class="modal-title text-primary font-bold" id="groups-modalLabel">Khai báo số hóa đơn</h4>
				<i class="btn fa fa-times text-primary" data-dismiss="modal"></i>
			</div>
			<div class="modal-body" style="margin:3px;border-radius: 5px;overflow-y: auto;max-height: 90vh">
				<div class="form-group pb-3">
					<label class="col-form-label">Mẫu hóa đơn</label>
					<input class="form-control form-control-sm" id="inv-prefix" type="text" placeholder="Mẫu hóa đơn">
				</div>
				<div class="form-group pb-3">
					<label class="col-form-label">Từ số - đến số</label>
					<div class="input-group">
						<input class="form-control form-control-sm" id="inv-no-from" maxlength="7" type="text" placeholder="Từ số">
						<input class="form-control form-control-sm ml-2" id="inv-no-to" maxlength="7" type="text" placeholder="Đến số">
					</div>
				</div>
				<div class="form-group">
					<p class="text-muted m-b-20">Số hóa đơn kế tiếp sẽ được sử dụng là giá trị <br> [Từ số] được nhập vào ở trên!</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="confirm-ssInvInfo" class="btn btn-sm btn-outline-warning">
					<i class="fa fa-check"></i>
					Xác nhận
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Hủy bỏ
				</button>
			</div>
		</div>
	</div>
</div>

<div class="m-show-modal">
    <div class="m-modal-background">
        
    </div>
    <div class="m-modal-content">
        <iframe id="file-show-content" width="100%" height="100%" type="application/pdf" style="border:none"></iframe>
    </div>
    <div class="m-close-modal" style="display: none;">
        <i class="la la-close" style="font-size: 21px;" title="Đóng"></i>
    </div>
</div>

<div id="Print-INV" class="m-hidden">
    
</div>

<script src="<?= base_url('assets/js/jsprint.js'); ?>"></script>
<script type="text/javascript">
	var tempINV = `<div class="INV-content" style="height:574px; position: relative;margin-top: 85px; left: 139px; font-size: 1em; font-family: 'Arial', 'Sans-serif'; page-break-after: always">
        <span style="position: absolute;z-index: 1;top: 0; left: 421px;" class="INV_DAY"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 496px;" class="INV_MONTH"></span>
        <span style="position: absolute;z-index: 1;top: 0; left: 561px;" class="INV_YEAR"></span>    
        <span style="position: absolute;z-index: 1;top: 99px; left: 19px;" class="CusName"></span>
        <span style="position: absolute;z-index: 1;top: 121px; left: 0px; font-size: 0.9em!important" class="Address"></span>
        <span style="position: absolute;z-index: 1;top: 141px; left: 19px;" class="PAYER"></span>
        <span style="position: absolute;z-index: 1;top: 141px; left: 617px;" class="HTTT">TM</span>
        <div id="inv-list" style="text-align: center;position: absolute;z-index: 1;top: 225px; left: -57px">
            <table>
                <tbody                                                                                              >
                    
                </tbody>
            </table>
        </div>
        <span style="position: absolute;z-index: 1;top: 348px; left: 605px; text-align: right; width:118px" class="SUB_AMOUNT"></span>
        <span style="position: absolute;z-index: 1;top: 368px; left: 76px;" class="VAT_RATE"></span>
        <span style="position: absolute;z-index: 1;top: 368px; left: 605px;text-align: right; width:118px" class="VAT"></span>
        <span style="position: absolute;z-index: 1;top: 394px; left: 605px;text-align: right; width:118px" class="TAMOUNT"></span>
        <span style="position: absolute;z-index: 1;top: 420px; left: 100px;" class="AmountInWords">hai trăm ngàn đồng</span>
        <span style="position: absolute;z-index: 1;top: 543px; left: 530px;" class="UserName"></span>
    </div>`;

    var tempRowINV = `<tr style="border: 1px solid #ddd">
        <td style="width: 32px;height: 18px; text-align: center;" class="STT"></td>
        <td style="width: 275px;height: 18px; text-align: left;" class="TRF_DESC"></td>
        <td style="width: 50px;height: 18px; text-align: center;" class="UNIT_NM"></td>
        <td style="width: 76px;height: 18px; text-align: right;" class="QTY"></td>
        <td style="width: 125px;height: 18px; text-align: right;" class="UNIT_RATE"></td>
        <td style="width: 200px;height: 18px; text-align: right;" class="AMOUNT"></td>
    </tr>`;
</script>

<script type="text/javascript">
	var allowConfirmAct = false;
	var modalQrPayment = null
	moment.tz.setDefault('Asia/Ho_Chi_Minh');
	$(document).ready(function () {
		$("#m-inv").prop("disabled", <?= !isset($isDup) || $isDup || !isset( $ssInvInfo ) || count( $ssInvInfo ) == 0; ?>);

	    var tblDraft = $( "#tbl-draft" ),
	    	tblDraftDetail = $( "#tbl-draft-details" ),
	    	tblPayer = $( "#search-payer" ),
	    	_colDraft = ["STT", "Select", "DRAFT_INV_NO", "DRAFT_INV_DATE", "REF_NO", "PAYER", "CusName", "AMOUNT", "VAT", "TAMOUNT", "CURRENCYID"],
	    	_colDraftDetail = ["STT", "DRAFT_INV_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "CARGO_TYPE", "SZ", "FE", "IsLocal", "QTY"
	    						, "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "Remark"],
	    	_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

	    var _draftDetails = [],
	    	_drafts = [],
	    	_payers = [];

		var _invData = [] , _amtwords;

	    //---------datepicker modified---------
	    $('#dateStart, #dateEnd').datepicker({
			format: "dd/mm/yyyy",
			startDate: moment().format('DD/MM/YYYY'),
			todayHighlight: true,
			autoclose: true
		});

		$('#dateStart + span').on('click', function(){
			$('#dateStart').val("*");
		});

        var dtPayer = tblPayer.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '25vh'
		});

		var dtDraft = tblDraft.DataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colDraft.indexOf('STT') },
				{ orderable: false, className: "text-center", targets: _colDraft.indexOf('Select') },
				{ className: "text-center", targets: _colDraft.getIndexs( ['DRAFT_INV_NO', 'DRAFT_INV_DATE', 'PAYER', 'CURRENCYID'] ) },
				{
					className: "text-right",
					targets: _colDraft.getIndexs( ["AMOUNT", "VAT", "TAMOUNT"] ),
					render: $.fn.dataTable.render.number( ',', '.', 2)
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _colDraft.indexOf("CusName")
				}
			],
			order: [[ _colDraft.indexOf('STT'), 'asc' ]],
			paging: false,
            rowReorder: false,
            buttons: [],
			select: {
				style: 'api'
			}
		});

		var dtDraftDetail = tblDraftDetail.DataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colDraftDetail.indexOf('STT') },
				{
					className: "text-right",
					targets: _colDraftDetail.getIndexs( ["QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT"
														, "VAT_RATE", "VAT", "TAMOUNT"] ),
					render: $.fn.dataTable.render.number( ',', '.', 2)
				}
			],
			searching:false,
			info: false,
			order: [[ _colDraft.indexOf('STT'), 'asc' ]],
			paging: false,
            rowReorder: false,
            buttons: []
		});

		tblPayer.DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [
				{
					 type: "num"
					,targets: [0]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colPayer.getIndexs(["CusName", "Address"])
				}
			],
			buttons: [],
			infor: false,
			scrollY: '45vh'
		});

	    load_payer();

//set from date, to date
	    var fromDate = $('#fromDate');
		var toDate = $('#toDate');

		fromDate.datepicker({ 
			controlType: 'select',
			oneLine: true,
			// minDate: _maxDateDateIn,
			dateFormat: 'dd/mm/yy',
			timeInput: true,
			onClose: function(dateText, inst) {
				if (toDate.val() != '') {
					var testStartDate = fromDate.datetimepicker('getDate');
					var testEndDate = toDate.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						toDate.datetimepicker('setDate', testStartDate);
				}
				else {
					toDate.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				toDate.datetimepicker('option', 'minDate', fromDate.datetimepicker('getDate') );
			}
		});

		toDate.datepicker({ 
			controlType: 'select',
			oneLine: true,
			// minDate: _maxDateDateIn,
			dateFormat: 'dd/mm/yy',
			timeInput: true,
			onClose: function(dateText, inst) {
				if (fromDate.val() != '') {
					var testStartDate = fromDate.datetimepicker('getDate');
					var testEndDate = toDate.datetimepicker('getDate');
					if (testStartDate > testEndDate)
						fromDate.datetimepicker('setDate', testEndDate);
				}
				else {
					fromDate.val(dateText);
				}
			},
			onSelect: function (selectedDateTime){
				fromDate.datetimepicker('option', 'maxDate', toDate.datetimepicker('getDate') );
			}
		});

		fromDate.val( moment().subtract('month', 1).format('DD/MM/YYYY') );
		toDate.val( moment().format('DD/MM/YYYY') );
//end set fromdate, todate

		$("#invDate").datetimepicker({ 
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true
		});

		// $("#invDate").val( moment().format('DD/MM/YYYY HH:mm:ss') );
// StartRealtime
		startClock()
//////// SEARCH PAYER
		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
///////// END SEARCH PAYER
//------MBBANK QR GATEWAY
		$('#paymentMethod').on('change', function() {
         var methodText = $(this).find("option:selected").text(); 
			if (methodText === 'MB Bank QR Payment') {
			var datas = tblDraftDetail.getDataByColumns( _colDraftDetail );
			var draftNos = tblDraft.getData().filter( p => p[ _colDraft.indexOf("Select") ] == "1" ).map( x => x[ _colDraft.indexOf("DRAFT_INV_NO") ] );
			if(Object.keys(datas).length > 0) {
				const cusName = $('#payer-name').text()
				const cusTaxCode = $('#taxcode').val()
				if(cusName.length === 0 || cusTaxCode.length === 0) {
					return toastr["error"]("Vui lòng chọn ĐTTT!");
				}
				check_Draft().then((result) => {
					if(result.checkDraft) {
					$(".ibox").first().blockUI();
					const total_amount = datas.map( x => x.TAMOUNT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) )
					var dfTotal = _drafts.filter( p => draftNos.indexOf(p.DRAFT_INV_NO) != "-1" )
					dfTotal.map((data) => data['REMARK'] = $( "#remark" ).val())
						saveDraftInv(dfTotal,datas, cusTaxCode).then((data) => {
							if(data.DraftNoInDB.Status) {
								let baseUrl = '<?= site_url() ?>';
											if (!baseUrl.endsWith('/')) {
												baseUrl += '/';
											}
										//	Construct URL with parameters
										const paymentUrl = baseUrl + 'd171035a85cc2258e37d64e18505d78c/106a6c241b8797f52e1e77317b96a201?' +
											'&amount=' + encodeURIComponent(total_amount) +
											'&cusId=' + encodeURIComponent(cusTaxCode) +
											'&EirNo=' + encodeURIComponent(data.DraftNoInDB.DraftNo) +
											'&customer_name=' + encodeURIComponent(cusName);
										modalQrPayment = window.open(paymentUrl, '_blank', 'width=700,height=900,scrollbars=yes,resizable=yes');
											//handle tab close
										window.onPaymentSuccess = function(data) {
												if (data.EirNo) {
													toastr["success"]("Tiến hành xuất hóa đơn <br> Vui lòng không thao tác!");
													modalQrPayment.close();
													publishInv()
												}
												else {
													toastr["error"]("Không tìm thấy thông tin!");
													$('#paymentMethod').val('TM/CK').selectpicker('refresh');

												}
											};
										window.onPaymentClosed = function () {
										$(".ibox").first().unblock();
										$('#paymentMethod').val('TM/CK').selectpicker('refresh');
										};
										window.addEventListener('beforeunload', () => {
												if (modalQrPayment && !modalQrPayment.closed) {
													modalQrPayment.close();
												}
											});
							}
							else {
								toastr["error"](data.DraftNoInDB.Message);
								$(".ibox").first().unblock();
								$('#paymentMethod').val('TM/CK').selectpicker('refresh');

							}
						}).catch((err) => {
							toastr["error"]("Xảy ra lỗi vui lòng thử lại!");
							$(".ibox").first().unblock();
						})
					}
					else {
						toastr["error"]("Hóa đơn đang chờ thanh toán!");
						clearDraft(result.arr)
						$('#paymentMethod').val('TM/CK').selectpicker('refresh');
					}
					})
					}
					else {
						toastr["error"]("Vui lòng chọn hóa đơn!");
						$('#paymentMethod').val('TM/CK').selectpicker('refresh');
					}
			}
        });
//------USING MANUAL INVOICE

		$("#confirm-ssInvInfo").on("click", function(){
			if( !$("#inv-prefix").val() ){
				toastr["error"]("Vui lòng nhập mẫu hóa đơn!");
				return;
			}

			if( !$("#inv-no-from").val() ){
				toastr["error"]("Vui lòng nhập số hóa đơn [Từ số]!");
				return;
			}

			if( !$("#inv-no-to").val() ){
				toastr["error"]("Vui lòng nhập số hóa đơn [Đến số]!");
				return;
			}

			$.confirm({
				columnClass: 'col-md-4 col-md-offset-4 mx-auto',
				titleClass: 'font-size-17',
                title: 'Xác nhận',
                content: 'Xác nhận thông tin khai báo hóa đơn này!?',
                onOpen: function(){
                	allowConfirmAct = true;
                },
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-sm btn-primary btn-confirm',
                        keys: ['Enter'],
                        action: function(){
                        	if( !allowConfirmAct ) return false;

                        	var data = {
								invno: $("#inv-no-from").val(),
								serial: $("#inv-prefix").val(),
								fromNo: $("#inv-no-from").val(),
								toNo: $("#inv-no-to").val()
							}

							var formData = {
								'action': 'edit',
								'act': 'use_manual_Inv',
								'useInvData': data
							};

							$("#change-ssinv-modal .modal-content").blockUI();

							$.ajax({
				                url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				                dataType: 'json',
				                data: formData,
				                type: 'POST',
				                success: function (data) {

				                	$("#change-ssinv-modal .modal-content").unblock();

				                    if( data.deny ) {
				                        toastr["error"](data.deny);
				                        return;
				                    }

				                	var invNo = formData.useInvData.serial + formData.useInvData.invno;

				                    if( data.isDup ){

				                    	$("#m-inv").prop("disabled", true);

				                    	toastr["error"]("Số hóa đơn bắt đầu ["+ invNo +"] đã tồn tại trong hệ thống!");
				                    	return;
				                    }

				                	$("#change-ssinv-modal").modal('hide');
				                    toastr["success"]("Xác nhận sử dụng Số HĐ ["+ invNo +"] thành công!");
				                    $("#ss-invNo").text(invNo);
				                    $("#change-ssinvno").attr("title", "Thay đổi hóa đơn sử dụng tiếp theo");
				                    $("#m-inv").prop("disabled", false);
				                },
				                error: function(err){
				                	$("#change-ssinv-modal .modal-content").unblock();
				                	toastr["error"]("Server Error at [confirm-ssInvInfo]!");
				                	console.log(err);
				                }
				            });

				            allowConfirmAct = false;
                        }
                    },
                    cancel: {
                    	text: 'Hủy',
                    	btnClass: 'btn-sm',
                    	keys: ['ESC'],
                    	action: function() {

                    	}
                    }
                }
            });
		});

//------USING MANUAL INVOICE

		$( "#load-data" ).on("click", function(){
			loadDraft();
		});

		$('#payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable()
											.columns
											.adjust();
		});

		$(".input-required").on("input change", function(e){
			$(e.target).removeClass("error");
			$(e.target).parent().removeClass("error");
		});

		$("#e-inv").on("click", function(){
			if( $(".input-required").has_required() ){
				toastr["error"]("Các thông tin bắt buộc không được để trống!");
				return;
			}

			if( tblDraft.find("input[name='select-draft']:checked").length == 0 ){
				toastr["error"]("Chưa có phiếu tính cước nào được chọn!");
				return;
			}

			// $.confirm({
			// 	columnClass: 'col-md-5 col-md-offset-5',
			// 	title: 'Lý do hủy lệnh',
			// 	type: 'orange',
	        //     icon: 'fa fa-warning',
	        //     content: 'Xác nhận xuất hóa đơn điện tử?',
			// 	content: '<div class="form-group"><span class="text-primary">Địa chỉ email (dùng dấu phẩy <,> để phân cách các mail)</span></div>'
			// 			+'<div class="form-group">'
			// 				+'<input autofocus class="form-control form-control-sm font-size-14" id="mail" placeholder="Nhập địa chỉ mail nhận HĐĐT" rows=5></input>'
			// 			+'</div>',
			// 	buttons: {
			// 		ok: {
			// 			text: 'Tiếp tục',
			// 			btnClass: 'btn-sm btn-primary btn-confirm',
			// 			keys: ['Enter'],
			// 			action: function(){
			// 				var input = this.$content.find('input#mail');
			// 				var errorText = this.$content.find('.text-danger');
			// 				if(!input.val().trim()){
			// 					$.alert({
			// 						title: "Thông báo",
			// 						content: "Vui lòng nhập địa chỉ mail nhận HĐĐT!.",
			// 						type: 'red'
			// 					});
			// 					return false;
			// 				}else{
			// 					publishInv();
			// 				}
			// 			}
			// 		},
	        //         cancel: {
	        //             text: 'Hủy bỏ',
	        //             btnClass: 'btn-default',
	        //             keys: ['ESC']
	        //         }
			// 	}
			// });

			$.confirm({
	            title: 'Thông báo!',
	            type: 'orange',
	            icon: 'fa fa-warning',
	            content: 'Xác nhận xuất hóa đơn điện tử?',
	            onOpen: function(){
	            	allowConfirmAct = true;
	            },
	            buttons: {
	                ok: {
	                    text: 'Tiếp tục',
	                    btnClass: 'btn-warning',
	                    keys: ['Enter'],
	                    action: function(){
	                    	if( !allowConfirmAct ) return false;
	                       check_Draft().then((result) => {
								if(result.checkDraft) {
									publishInv();
								}
								else {
									toastr["error"]("Hóa đơn đang chờ thanh toán!");
									clearDraft(result.arr)
								}
								})

	                        allowConfirmAct = false;
	                    }
	                },
	                cancel: {
	                    text: 'Hủy bỏ',
	                    btnClass: 'btn-default',
	                    keys: ['ESC']
	                }
	            }
	        });
		});

		$("#m-inv").on("click", function(){
			if( $(".input-required").has_required() ){
				toastr["error"]("Các thông tin bắt buộc không được để trống!");
				return;
			}

			$.confirm({
	            title: 'Thông báo!',
	            type: 'orange',
	            icon: 'fa fa-warning',
	            content: 'Xác nhận xuất hóa đơn giấy?',
	            onOpen: function(){
	            	allowConfirmAct = true;
	            },
	            buttons: {
	                ok: {
	                    text: 'Tiếp tục',
	                    btnClass: 'btn-warning',
	                    keys: ['Enter'],
	                    action: function(){
	                    	if( !allowConfirmAct ) return false;

	                    	var invInfo = {
	                    		INV_DATE: $( "#invDate" ).val(),
								REMARK: $( "#remark" ).val()
	                    	};

	                    	$(".ibox").first().blockUI();
							check_Draft().then((result) => {
								if(result.checkDraft) {
									saveData(invInfo, 'm-inv');
								}
								else {
									toastr["error"]("Hóa đơn đang chờ thanh toán!");
									clearDraft(result.arr)
								}
								})

	                        allowConfirmAct = false;
	                    }
	                },
	                cancel: {
	                    text: 'Hủy bỏ',
	                    btnClass: 'btn-default',
	                    keys: ['ESC']
	                }
	            }
	        });
		});

		$( document ).on("click", "#view-inv", function(){
			if( _invData && _invData.length > 0 ){
				printInv( _invData , _amtwords);
				return;
			}

			$('#file-show-content').attr('src'
				, '<?= isset($invInfo["fkey"]) ? site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=".$invInfo["fkey"]) : "";?>');

			$('.m-show-modal').show('fade', function(){
				window.setTimeout( function(){
					$(".m-close-modal").show( "slide", {direction: "up" }, 300 );
				}, 3000 );
			});
		});

		$("#send-email").on("click", function(){
			sendMail();
		});

		$("#print-draft").on("click", function(){
			var draftNos = tblDraft.find("input[name='select-draft']:checked")
									.closest("tr")
									.find("td:eq("+ _colDraft.indexOf("DRAFT_INV_NO") +")")
									.map( function(){
										return $(this).text();
									} )
									.get();

			var draftDetails = _draftDetails
										.filter( p=> draftNos.indexOf( p.DRAFT_INV_NO ) != -1 )
									  	.map( function( item ){
									  			var cusID = _drafts.filter( x => x.DRAFT_INV_NO == item["DRAFT_INV_NO"] )
																   .map( c => c.PAYER )[0];
												var taxCode = _payers.filter( p => p.CusID == cusID )
																	 .map( c => c.VAT_CD )[0];
												var payerName = _payers.filter( p => p.CusID == cusID && p.VAT_CD == taxCode )
																	 .map( c => c.CusName )[0];

												return {
													"DRAFT_INV_NO": item["DRAFT_INV_NO"],
													"DRAFT_INV_DATE": _drafts.filter( x => x.DRAFT_INV_NO == item["DRAFT_INV_NO"] )
																			 .map( c => c.DRAFT_INV_DATE )[0],
													"TRF_DESC": item["TRF_DESC"],
													"INV_UNIT": item["INV_UNIT"],
													"QTY": item["QTY"],
													"standard_rate": item["standard_rate"],
													"TAMOUNT": item["TAMOUNT"],
													"TAX_CODE": taxCode,
													"PAYER_NAME": payerName
												};
											}
									  	);

			var form = document.createElement("form");
			form.setAttribute("method", "post");
			form.setAttribute("target", "_blank");
			form.setAttribute("action", "<?=site_url(md5('ExportRPT') . '/' . md5('viewDraftPDF'));?>");

			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = "draftDetails";
			input.value = JSON.stringify( draftDetails );
			form.appendChild(input);

			var input2 = document.createElement('input');
			input2.type = 'hidden';
			input2.name = "payerName";
			input2.value = $("#payer-name").val();
			form.appendChild(input2);

			document.body.appendChild(form);
			form.submit();
			document.body.removeChild(form);
		});

		tblDraft.on("change", "input[name='select-draft']", function(e){
			var chk = $(e.target);
			var isChecked = chk.is(":checked");
			var dtDetails = tblDraftDetail.DataTable();

			var invDraftNo = chk.closest('tr').find('td:eq(' + _colDraft.indexOf( "DRAFT_INV_NO" ) + ')').text();

			if( isChecked ){

				chk.attr("checked", "");
        		chk.val("1");
				tblDraft.DataTable().rows( chk.closest("tr") ).select();

				var drDetails = _draftDetails.filter( p => p["DRAFT_INV_NO"] == invDraftNo );
				addRowToDraftDetail( drDetails );
			}
			else{

				chk.removeAttr("checked");
        		chk.val("0");
				tblDraft.DataTable().rows( chk.closest("tr") ).deselect();

				var delrowIdxes = dtDetails.rows( function ( idx, data, node ) {
															        return data[ _colDraftDetail.indexOf( "DRAFT_INV_NO" ) ] == invDraftNo 
															        		? true : false;
															    } )
															.indexes().toArray();
				dtDetails.rows( delrowIdxes ).remove().draw();
				tblDraftDetail.updateSTT();
			}

			checkDraft = tblDraft.find("input[name='select-draft']:checked");
			if( checkDraft.length == 1 )
			{
				var cusid = checkDraft.closest("tr").find("td:eq("+ _colDraft.indexOf("PAYER") +")").text();
				var payerSelected = _payers.filter( p=>p.CusID == cusid );
				
				$('#taxcode').val( payerSelected.map( x=>x.VAT_CD ) );
				$("#cusID").val( cusid );

				var draftNo = checkDraft.closest("tr").find("td:eq("+ _colDraft.indexOf("DRAFT_INV_NO") +")").text();
				var currencyId = _drafts.filter( p=>p.DRAFT_INV_NO == draftNo ).map( x=>x.CURRENCYID )[0];
				$("#invType").val( currencyId ).selectpicker( "refresh" );

				fillPayer();
			} else
			{
				if ( $('#taxcode').val() ){
					clearPayer();
				}

				$("#invType").val( "" ).selectpicker( "refresh" );
			}

			var crCell = chk.closest('td');
        	tblDraft.DataTable().cell( crCell ).data( crCell.html() );
		});

		function startClock() {
			function updateClock() {
				$("#invDate").val(moment().format('DD/MM/YYYY HH:mm:ss'));
			}

			// Gọi 1 lần ban đầu để hiển thị ngay
			updateClock();

			// Sau đó cứ mỗi giây cập nhật lại
			setInterval(updateClock, 1000);
		}

		function loadDraft()
		{
			tblDraft.dataTable().fnClearTable();
			tblDraftDetail.dataTable().fnClearTable();
			tblDraft.waitingLoad();

			var btn = $( "#load-data" );
			btn.button("loading");

			var formData = {
				"action": "view",
				"act": "search_draft",
				"fromDate": $( "#fromDate" ).val(),
				"toDate": $( "#toDate" ).val(),
				"paymentType": $( "#paymentType" ).val(),
				"currency": $("#moneyType").val(),
				"createdBy": $("#createdBy").val()
			};

			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					btn.button("reset");

					if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

					var rows = [];
					_draftDetails = [];
					_drafts = [];

					if( data.drafts && data.drafts.length > 0 )
					{
						_drafts = data.drafts;
						_draftDetails = data.draftdetails;
						// var drafts = data.drafts.sort((a,b) => (a.OrderNo > b.OrderNo) ? 1 : ((b.OrderNo > a.OrderNo) ? -1 : 0));
						
						$.each( data.drafts, function( i, item ) {
							var r = [];
							$.each( _colDraft, function( idx, colname ){
								var val = "";
								switch(colname){
									case "STT":
										val = i+1;
										break;
									case "Select":
										val = '<label class="checkbox checkbox-outline-ebony">'
													+ '<input type="checkbox" name="select-draft" value="0" style="display: none;">'
													+ '<span class="input-span"></span>';
												+ '</label>';
										break;
									case "DRAFT_INV_DATE":
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

					tblDraft.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblDraft.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tblDraft.dataTable().fnClearTable();
					btn.button("reset");
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
					console.log(err);
				}
			});
		}

		function addRowToDraftDetail( item )
		{
			var rows = [];
			var currentSTT = tblDraftDetail.DataTable().rows().count();
			$.each( item, function( i, item ) {
				var r = [];
				$.each( _colDraftDetail, function( idx, colname ){
					var val = "";
					switch( colname ){
						case "STT":
							val = currentSTT + i+1;
							break;
						case "FE":
							val = "<input class='hiden-input' value='" + item[ colname ] + "'>"
									+ ( item[ colname ] == "F" ? "Hàng" : ( item[ colname ] == "E" ? "Rỗng" : item[ colname ] ) );
							break;
						case "IsLocal":
							val = "<input class='hiden-input' value='" + item[ colname ] + "'>"
									+ ( item[ colname ] == "F" ? "Ngoại" : ( item[ colname ] == "L" ? "Nội" : item[ colname ] ) );
							break;
						default:
							val = item[ colname ] ? item[ colname ] : "";
							break;
					}
					r.push( val );
				} );

				rows.push( r );

			} );

        	if(rows.length > 0){
				tblDraftDetail.dataTable().fnAddData(rows);
        	}
		}

		function sendMail(){
			$("#send-email").button("loading");
			var formData = {
				"action": "view",
				"act": "send_mail",
				"args": {
					"inv": $("#inv-no").text(),
					"orderNo": $("#inv-order-no").text(),
					"pinCode": $("#inv-pin-code").text(),
					"amount": $("#inv-tamount").text(),
					"mailTo": $("#inv-payer-email").val()
				}
			};

			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					$("#send-email").button("reset");
					if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    $(".toast").remove();
                    if( data.result == "sent" ){
                    	toastr["success"]("Mail đã được gởi thành công!");
                    }else{
                    	toastr["error"](data.result);
                    }
				},
				error: function(err){
					$("#send-email").button("reset");
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		}

		function load_payer()
		{
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function (data) {

					if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

					var rows = [];

					if(data.payers && data.payers.length > 0){
						_payers = data.payers;
		        		var i = 0;
			        	$.each(_payers, function(index, rData){
			        		var r = [];
							$.each(_colPayer, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "CusType":
										val = !rData[colname] ? "" : (rData[colname] == "M" ? "Thu ngay" : "Thu sau");
										break;
									default:
										val = rData[colname] ? rData[colname] : "";
										break;
								}
								r.push(val);
							});
							i++;
							rows.push(r);
			        	});
		        	}

		        	tblPayer.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblPayer.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		};

		function fillPayer()
		{
			var py = _payers.filter(p=> p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());

			if(py.length > 0){ //fa-check-square
				$('#payer-name').text(py[0].CusName);
				$('#payer-addr').text(py[0].Address);
				$('#payment-type').attr('data', py[0].CusType);
				$('#payment-type').text(py[0].CusType == 'M' ? "Thu ngay" : "Thu sau");

				if( py[0].Email ){
					$("#inv-payer-email").val( py[0].Email );
				}

				if( py[0].EMAIL_DD && py[0].EMAIL_DD != py[0].Email ){
					$("#inv-payer-email").val( $("#mail").val() + ',' + py[0].EMAIL_DD );
				}
				
				$("#taxcode").removeClass("error");
			}
		}

		function clearPayer()
		{
			$('#taxcode').val("");
			$("#cusID").val("");
			$('#payer-name').text( " [Tên đối tượng thanh toán]" );
			$('#payer-addr').text( " [Địa chỉ]");
			$('#payment-type').attr('data', "");
			$('#payment-type').text( " [Hình thức thanh toán]" );
		}

		function getPayerType(py){
			if(py.IsOpr == "1") return "SHP";
			if(py.IsAgency == "1") return "SHA";
			if(py.IsOwner == "1") return "CNS";
			if(py.IsLogis == "1") return "FWD";
			if(py.IsTrans == "1") return "TRK";
			if(py.IsOther == "1") return "DIF";
			return "";
		}
		function clearDraft(arr){
				_drafts = _drafts.filter(p => !arr.includes(p.DRAFT_INV_NO))
				var rows = [];
				if (_drafts && _drafts.length > 0) 
				{
					$.each(_drafts, function(i, item) {

						var r = [];
						$.each(_colDraft, function(idx, colname){
							var val = "";
							switch(colname){
								case "STT":
									val = i+1;
									break;
								case "Select":
									val = '<label class="checkbox checkbox-outline-ebony">'
										+ '<input type="checkbox" name="select-draft" value="0" style="display: none;">'
										+ '<span class="input-span"></span>';
									+ '</label>';
									break;
								case "DRAFT_INV_DATE":
									val = getDateTime( item[ colname ] );										
									break;
								default:
									val = item[colname] ? item[colname] : "";
									break;
							}
							r.push(val);
						});
						rows.push(r);
					});
				}
				tblDraft.dataTable().fnClearTable();
				tblDraftDetail.dataTable().fnClearTable();
				dtDraftDetail
				if(rows.length > 0){
					tblDraft.dataTable().fnAddData(rows);
				}
		}
		function check_Draft(){
			return new Promise((resolve, reject) => {
			$(".ibox").first().blockUI();
			var draftNos = tblDraft.getData().filter( p => p[ _colDraft.indexOf("Select") ] == "1" ).map( x => x[ _colDraft.indexOf("DRAFT_INV_NO") ] );
			if(draftNos) {
				const formData = {
					'action': 'view',
					'act': 'check_draft',
					'draftNos': draftNos
					}
				$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					resolve(data)
					$(".ibox").first().unblock();
				},
				error: function(err){
					$(".ibox").first().unblock();
					reject(err)
					console.log(err);
				}
			});
			}
			})
		}
		function publishInv()
		{
			var datas = tblDraftDetail.getDataByColumns( _colDraftDetail );

			if( datas.length == 0 ) {
				$(".ibox").first().unblock();
				$('.toast').remove();
				toastr['warning']('Chọn phiếu tính cước để phát hành hóa đơn!');
				return;
			}

			var formData = {
				cusTaxCode : $('#taxcode').val(),
				cusAddr : $('#payer-addr').text(),
				cusName : $('#payer-name').text(),
				sum_amount : datas.map( x => x.AMOUNT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				vat_amount : datas.map( x => x.VAT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				total_amount : datas.map( x => x.TAMOUNT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				is_eport : $("input[name='eport-inv']").is(":checked") ? "1" : "0" ,
				datas : datas
			};

			$(".ibox").first().blockUI();

			$.ajax({
				url: "<?=site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if(data.deny) {
						$(".ibox").first().unblock();
                        toastr["error"](data.deny);
                        return;
                    }

     				if( data.error ){
     					$(".ibox").first().unblock();
						$( ".toast" ).remove();
						toastr["error"]( data.error );
						return;
					}

					data["INV_DATE"] = $( "#invDate" ).val();
					data["REMARK"] = $( "#remark" ).val();

					saveData(data, 'e-inv');
				},
				error: function(err){
					$(".ibox").first().unblock();
					console.log(err);
				}
			});
		}

		function saveData( invInfo , pubType )
		{
			var draftNos = tblDraft.getData().filter( p => p[ _colDraft.indexOf("Select") ] == "1" ).map( x => x[ _colDraft.indexOf("DRAFT_INV_NO") ] );

			if( draftNos.length == 0 ){
				$(".ibox").first().unblock();
				$('.toast').remove();
				toastr['warning']('Chọn phiếu tính cước để phát hành hóa đơn!');
				return;
			}

			var draftData = _drafts.filter( p => draftNos.indexOf(p.DRAFT_INV_NO) != "-1" )
									.map( function( item ){
											return {
														"DRAFT_INV_NO": item["DRAFT_INV_NO"],
														"REF_NO": item["REF_NO"],
														"ShipKey": item["ShipKey"],
														"ShipID": item["ShipID"],
														"ShipYear": item["ShipYear"],
														"ShipVoy": item["ShipVoy"],
														"OPR": item["OPR"],
														"PAYER_TYPE": item["PAYER_TYPE"],
														"INV_TYPE": item["INV_TYPE"],
														"ACC_CD": $("#paymentMethod").val()
													};
										}
									);

			var allDraftDetail = _draftDetails.filter( p=> draftNos.indexOf( p.DRAFT_INV_NO ) != -1 );

			if( allDraftDetail.length == 0 ){
				$(".ibox").first().unblock();
				$('.toast').remove();
				toastr['warning']('Không thể xuất hoá đơn cho các Phiếu tính cước này!');
				return;
			}
			var draftTotal = {
				AMOUNT : allDraftDetail.map( x => x.AMOUNT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				VAT : allDraftDetail.map( x => x.VAT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				DIS_AMT : allDraftDetail.map( x => x.DIS_AMT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) ,
				TAMOUNT : allDraftDetail.map( x => x.TAMOUNT ).reduce( (a, b) => parseFloat(a)+parseFloat(b) ) 
			};
			var formData = {
				'action': 'add',
				'data': {
					'pubType': pubType,
					'invInfo': invInfo,
					'draftData': draftData,
					'draftTotal': draftTotal,
					'payer': $("#cusID").val(),
					'currencyId': $("#invType").val()
				}
			};

			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					$(".ibox").first().unblock();

					if( data.error ){
						$( ".toast" ).remove();
						toastr["error"]( data.error );
						return;
					}

					if( data.isDup ){
						toastr["error"] ( "Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!" );
						return;
					}

					if( data.outInfo ){
						$( "#inv-order-no" ).text( data.outInfo.OrderNo );
						$( "#inv-payer-name" ).text( data.outInfo.NameDD );
						$( "#inv-payer-email" ).val( data.outInfo.Mail );
					}

					if( data.ssInvInfo ){
						$("#ss-invNo").text( data.ssInvInfo.serial + ("00000000" + data.ssInvInfo.invno).slice(-8) );
						if( data.hasDup ){
							$("#ss-invNo").text( $("#ss-invNo").text() + " [BỊ TRÙNG]" );
							$("#m-inv").prop("disabled", data.hasDup);
						}
					}else{
						$("#ss-invNo").text("Chưa khai báo!");
						$("#change-ssinvno").attr("title", "Khai báo số hóa đơn sử dụng tiếp theo");
						$("#m-inv").prop("disabled", true );
					}

					if( data.invInfo ){
						// $( "#inv-prefix" ).text( data.invInfo.serial );
						$( "#inv-no" ).text( data.invInfo.serial + ("00000000" + data.invInfo.invno).slice(-8) );
						$( "#inv-pin-code" ).text( data.invInfo.fkey );
						$( "#inv-tamount" ).text( $.formatNumber( formData.data.draftTotal.TAMOUNT, { format: "#,###", locale: "us" } ) 
													+ " " + $("#invType").val() );
						
						if( data.invdata && data.invdata.length > 0 ){
							_invData = data.invdata;
							_amtwords = data.amtwords;
						}

						//clear selected row on draft table
						var selectedRows = tblDraft.find("input[name='select-draft']:checked")
													  .closest("tr");
						tblDraft.DataTable().rows( selectedRows ).remove().draw(false);
						tblDraft.updateSTT();
						
						//clear table draft details
						tblDraftDetail.dataTable().fnClearTable();
						if(modalQrPayment) {
							modalQrPayment.close();
						}
						$( "#payment-success-modal" ).modal("show");

					}else{
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error){
					console.log(xhr);
					$('.toast').remove();
					$(".ibox").first().unblock();
					toastr['error']("Có lỗi xảy ra khi lưu dữ liệu! Vui lòng liên hệ KTV! ");
				}
			});
		}
		function saveDraftInv( drTotal , drDetail, CusID )
		{
			return new Promise((resolve, reject) => {
			const IsEport = $("input[name='eport-inv']").is(":checked") ? "1" : "0"
			drTotal.map((dt) => dt['INV_DATE'] = dt['DRAFT_INV_DATE'])
			drTotal.map((dt) => dt['CusID'] = CusID)
			drTotal.map((dt) => dt['is_eport'] = IsEport)
			var formData = {
				'action': 'save_draft',
				'args': {
					'draft_detail': drDetail,
					'draft_total': drTotal
				}
			};
			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					resolve(data)
				},
				error: function(xhr, status, error){
					 reject(error || status);
				}
			});
			})
		}
		function printInv( data, amtwords ){
            if( data && data.length > 0 )
            {
                var invContent = $("#Print-INV");
                invContent.html( tempINV );
                if( localStorage.getItem("margin_hd") ){
                    invContent.find('.INV-content:last').css("margin-top",  localStorage.getItem("margin_hd") );
                }
                //set data for header
                var headerData = data[0];
                $.each( Object.keys( headerData ), function(idx, key){
                    if( ['INV_DATE'].indexOf(key) != -1 ){
                        var d = new Date( headerData[key] );
                        var dd = d.getDate();
                        var mm = d.getMonth() + 1;

                        invContent.find('.INV-content:last').find('span.INV_DAY').text( dd > 9 ? dd : "0" + dd );
                        invContent.find('.INV-content:last').find('span.INV_MONTH').text( mm > 9 ? mm : "0" + mm );
                        invContent.find('.INV-content:last').find('span.INV_YEAR').text( d.getFullYear() );
                    }
                    else if ( ['VAT_RATE', 'SUB_AMOUNT', 'TAMOUNT', 'VAT'].indexOf(key) != -1 ){
                        var n = $.formatNumber( headerData[key], { format: "#,###", locale: "vn" });
                        invContent.find('.INV-content:last')
                                        .find('span.' + key)
                                        .text( n + (headerData["CURRENCYID"] == "VND" && key != "VAT_RATE" ? " VNĐ" : "") );
                    }
                    else
                    {
                        invContent.find('.INV-content:last').find('span.' + key).text( headerData[key] );
                    }
                });

                //tiền = chữ
                var uu = amtwords;
                invContent.find('.INV-content:last').find('span.AmountInWords').text( uu ? uu.toUpperCase() : "" );

                //set data for each row and append to table
                var i=1;
                $.each( data, function(idx, item){
                    invContent.find('.INV-content:last').find( "table tbody" ).append( tempRowINV );
                    var lastRow = invContent.find( "table tbody tr:last" );
                    lastRow.find('td.STT').text( i++ );
                    $.each(Object.keys( item ), function(ix, key){
                        if( ['UNIT_RATE', 'AMOUNT'].indexOf(key) != -1 ){
                            var n = $.formatNumber( item[key], { format: "#,###", locale: "vn" });
                            lastRow.find('td.' + key).text( n );
                        }else{
                            lastRow.find('td.' + key).text( item[key] );
                        }
                    });
                } );
                
                invContent.print();
                invContent.html('');
                // var win = window.open("", "_blank");
                //     $(win.document.body).append(invContent);
            }else{
                toastr["warning"]( "Không thể in!<br> Vui lòng kiểm tra lại!" )
            }
		}
		
		$('.m-modal-background').click(function(){
            $('.m-show-modal').hide('fade');
        });

        $('.m-close-modal').click(function(){
            $(this).hide();
            $('.m-show-modal').hide('fade');
        });

        $(document).on("keydown", function(e){
            if( e.keyCode == 27 ){
                $('.m-close-modal').trigger("click");;
            }
        });
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>