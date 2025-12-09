<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'); ?>"
    rel="stylesheet" />
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />


<style>
   .content{
    padding-top: 14px;
   }
   .dataTables_scrollBody {
    padding-bottom: 20px;
    /* min-height: 680px; */
    height: 100%;
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
   /* Tùy biến thanh cuộn ngang của DataTable */
.dataTables_scrollBody::-webkit-scrollbar {
  height: 8px; /* Độ dày của thanh cuộn ngang */
  width: 8px;
}

.dataTables_scrollBody::-webkit-scrollbar-track {
  background: #f1f1f1; /* màu nền */
  border-radius: 6px;
}

.dataTables_scrollBody::-webkit-scrollbar-thumb {
  background: #c1c1c1ff; /* màu thanh cuộn */
  border-radius: 6px;
}

.dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
  background: #666; /* khi hover */
}
.pagination_container {
    margin-top: 6px;
    position: absolute;
    right: 0;
}
.pagination_container-item {
    font-size: 16px;
}
.box-title {
    margin-bottom: 16px;
}
.table_header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    
}
.Search_container {
    display: flex;
    align-items: center;
    height: 30px;
    margin-bottom: 6px;

}
.Search_container-icon {
    width: 45px;
    height: 100%;
    background-color: #00a2ff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.Search_container-icon--item {
    font-size: 14px;
    color: #fff;
}

.form-select {
    width: 110px;
    margin-left: 10px;
    padding: 6px 0px;
    border-radius: 6px;
    font-size: 12px;
    color: #333;
    border: none;
    background-color: #f3f3f3;
}
.filter {
    display: flex;
    align-items: center;
    margin-bottom: 6px;
}
.filter_title {
    margin-left: 10px;
    font-size: 14px;
    color: #666
}
#searchCntr {
    padding: 7px 8px;
    border: none;
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    background-color: #f3f3f3;
}
.filter_date {
    border: none;
    margin-left: 10px;
    text-align: center;
    padding: 6px 0px;
    border-radius: 6px;
    background-color: #f3f3f3;
}
.style_icon-datetime {
    margin-left: 10px;
}
.btn_loadata {
    width: 100px;
    padding: 7px 0;
    border: none;
    border-radius: 6px;
    background-color: #fff;
    margin-left: 10px;
    border: 1px solid #00a2ff;
    color: #00a2ff;
}
.btn_loadata:active {
    transform: scale(1.2);
}
</style>    
<div class="row" style="font-size: 12px!important;" id="Container_Await_Payment">
    <div class="col-xl-12">
        <div class="ibox collapsible-box box-title" id="parent-loading">
            <div class="ibox-head">
                <div class="ibox-title">LỆNH CHỜ THANH TOÁN</div>
            </div>
        </div>
        <div class="ibox collapsible-box content">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
                       <div class="table_header">
                            <div class="Search_container">
                                <span class="Search_container-icon"><i class="fa fa-search Search_container-icon--item"></i></span>
                                <input type="text" id="searchCntr" placeholder="Nhập số container, số lệnh, số booking..." class="form-control" style="width:260px;">
                            </div> 
                            <div class="filter">
                                 <span class="filter_title">Dịch vụ: </span>
                               <select id="service" class="form-select">
                                    <option value="">Tất cả</option>
                                    <option value="eir">Lệnh nâng hạ</option>
                                    <option value="odrs">Lệnh dịch vụ</option>
                                    <option value="invdft">Hoa đơn</option>
                            
                                </select>
                                <span class="filter_title">Hãng tàu: </span>
                               <select id="oprID" class="form-select">
                                    <option value="">Tất cả</option>
                                    <?php foreach($listOprID as $row): ?>
                                        <option value="<?= $row['OprID']; ?>"><?= $row['OprID']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="filter_title">Thời gian: </span>
                                     <input class="filter_date" type="text" id="fromDate" style="width:100px;">
                                     <i class="fa fa-exchange style_icon-datetime"></i>
                                     <input class="filter_date" type="text" id="toDate" style="width:100px;">
                                     <button id="btLoadata" class="btn_loadata">Nạp dữ liệu <i class="fa fa-search"></i></button>
                            </div>
                       </div>
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.9%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Thanh toán</th>
								<th>Thực hiện</th>
								<th>Số lệnh</th>
								<!-- <th>Số tiền</th> -->
								<!-- <th>Loại tiền</th> -->
								<th>Phương án</th>
								<th>Ngày tạo lệnh</th>
								<th>Hạn lệnh</th>
								<th>Số container</th>
								<th>Hãng tàu</th>
								<th>Số Booking</th>
								<th>Kích cỡ ISO</th>
								<th>TAX</th>
								<th>ĐTTT</th>
								<th>Loại</th>
								<!-- <th>Chủ hàng</th> -->
							</tr>
							</thead>
                                <tbody>
                                </tbody>
						</table>
					</div>
				</div>

                <!-- Phân trang đang đợi xử lý -->
                <!-- <ul class="pagination pagination-lg pagination_container">
                    <li class="page-item pagination_container-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul> -->
			</div>
    </div>
<!-- style="display: none" -->
     <div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden"  style="display: none"> 
                    <table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Số phiếu tính cước</th>
                                <th>Số lệnh</th>
                                <th>Mã biểu cước</th>
                                <th>Tên biểu cước</th>
                                <th>ĐVT</th>
                                <th>Loại công việc</th>
                                <th>PTGN</th>
                                <th>Loại hàng</th>
                                <th>Kích cỡ ISO</th>
                                <th>Hàng/rỗng</th>
                                <th>Nội/ngoại</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Chiết khấu (%)</th>
                                <th>Đơn giá CK</th>
                                <th>Đơn giá sau CK</th>
                                <th>Thành tiền</th>
                                <th>Thuế (%)</th>
                                <th>Tiền thuế</th>
                                <th>Tổng tiền</th>
                                <th>Loại tiền</th>
                                <th>IX_CD</th>
                                <th>CNTR_JOB_TYPE</th>
                                <th>VAT_CHK</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
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
    // Payment data from PHP
    const paymentData = {
        _lstEir: <?= json_encode($eir) ?> ,
        _lstOrders: <?= json_encode($odrs) ?> ,
        _lstInvDraft: <?= json_encode($invDraft) ?> ,
    };
    var _invData = [] , _amtwords;
    var modalQrPayment = null
    var tblInv =  $('#tbl-inv');
     var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode",
                "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE",
                "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD",
                "CNTR_JOB_TYPE", "VAT_CHK"
            ]
        $(document).ready(function () {
            // Lấy current date
            let dateNow = new Date();

            // Clone ra biến mới để lùi 1 tháng
            let dateFrom = new Date(dateNow);
            dateFrom.setMonth(dateFrom.getMonth() - 1);

            $("#fromDate").datetimepicker({
                dateFormat: "dd/mm/yy",
                timeFormat: "HH:mm",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                controlType: 'select',
                oneLine: true
            });

            $("#toDate").datetimepicker({
                dateFormat: "dd/mm/yy",
                timeFormat: "HH:mm",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                controlType: 'select',
                oneLine: true
            });
            // Set default value vào input
            $("#fromDate").datetimepicker("setDate", dateFrom);
            $("#toDate").datetimepicker("setDate", dateNow);
            renderTable(paymentData._lstEir, paymentData._lstOrders, paymentData._lstInvDraft)
         // Khởi tạo DataTable và gán vào tblInv
         tblInv.DataTable({
            scrollX: true,
            columnDefs: [
                { type: "num", targets: 0 },
                {
                    className: 'hiden-input',
                    targets: _colsPayment.getIndexs(["IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"])
                }
            ],
            order: [[0, 'asc']],
            info: false,
            paging: false,
            searching: false,
            buttons: [],
            scrollY: '30vh',
        });
        $("#send-email").on("click", function(){
			sendMail();
		});
        $('#btLoadata').on('click', function() {
            loadData()
        })
        $('#searchCntr').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        const CNTRNO = /^[A-Z]{4}\d{7}$/i;
        // const OprId = /^[A-Za-z]{1,5}$/;
        if(CNTRNO.test(value.trim())) {
                let matchedEIR = null;
                $('#contenttable tbody tr').each(function() {
                    const cntrNo = $(this).find('td[data-col="CNTRNO"]').text().toLowerCase();
                    if (cntrNo.indexOf(value) > -1) {
                        matchedEIR = $(this).find('td[data-col="EIRNo"]').text().trim().toLowerCase();
                        return false; 
                    }
                });

                $('#contenttable tbody tr').each(function() {
                    const eirNo = $(this).find('td[data-col="EIRNo"]').text().trim().toLowerCase();
                    $(this).toggle(eirNo === matchedEIR);
                });
        }
        else  {
                $('#contenttable tbody tr').filter(function() {
                    const eirNo = $(this).find('td[data-col="EIRNo"]').text().toLowerCase();
                    const bookingNo = $(this).find('td[data-col="BookingNo"]').text().toLowerCase();
                    $(this).toggle(
                        eirNo.includes(value) || bookingNo.includes(value)
                    );
                });
        }
        });
        });
        const keysToKeepEir = [
            "ShipKey",
            "BerthDate",
            "ShipID",
            "ShipYear",
            "ShipVoy",
            "CntrNo",
            "BLNo",
            "BookingNo",
            "CntrClass",
            "OprID",
            "LocalSZPT",
            "ISO_SZTP",
            "Status",
            "DateIn",
            "VGM",
            "Ter_Hold_CHK",
            "SealNo",
            "SealNo1",
            "SealNo2",
            "IsLocal",
            "CMDWeight",
            "CARGO_TYPE",
            "Temperature",
            "CJMode_CD",
            "CJModeName",
            "ImVoy",
            "ExVoy",
            "CmdID",
            "POD",
            "FPOD",
            "Port_CD",
            "OOG_TOP",
            "OOG_LEFT",
            "OOG_RIGHT",
            "OOG_BACK",
            "OOG_FRONT",
            "cBlock",
            "cBay",
            "cRow",
            "cTier",
            "cArea",
            "CLASS",
            "UNNO",
            "Note",
            "cTLHQ",
            "Description",
            "IssueDate",
            "ExpDate",
            "NameDD",
            "IsTruckBarge",
            "BARGE_CODE",
            "BARGE_YEAR",
            "BARGE_CALL_SEQ",
            "DMethod_CD",
            "TruckNo",
            "PersonalID",
            "SHIPPER_NAME",
            "PAYER_TYPE",
            "CusID",
            "PAYMENT_TYPE",
            "PAYMENT_CHK",
            "DELIVERYORDER",
            "Mail"
        ];
        const keysToKeepSrv = [
            "RowguidCntrDetails",
            "ShipKey",
            "BerthDate",
            "ShipID",
            "ShipYear",
            "ShipVoy",
            "CntrNo",
            "BookingNo",
            "BLNo",
            "CntrClass",
            "OprID",
            "LocalSZPT",
            "ISO_SZTP",
            "Status",
            "DateIn",
            "VGM",
            "Vent",
            "Vent_Unit",
            "Ter_Hold_CHK",
            "SealNo",
            "SealNo1",
            "SealNo2",
            "isLocal",
            "CWeight",
            "CMDWeight",
            "CARGO_TYPE",
            "Temperature",
            "DG_CD",
            "CJMode_CD",
            "CJModeName",
            "ImVoy",
            "ExVoy",
            "CmdID",
            "POD",
            "FPOD",
            "Port_CD",
            "OOG_TOP",
            "OOG_LEFT",
            "OOG_RIGHT",
            "OOG_BACK",
            "OOG_FRONT",
            "Transist",
            "cArea",
            "Note",
            "cTLHQ",
            "Description",
            "SSOderNo",
            "EIRNo",
            "ShipperName",
            "bXNVC",
            "FDATE",
            "PTI_Hour",
            "IssueDate",
            "ExpDate",
            "NameDD",
            "PersonalID",
            "DMethod_CD",
            "SHIPPER_NAME",
            "PAYER_TYPE",
            "CusID",
            "DELIVERYORDER",
            "OPERATIONTYPE",
            "PAYMENT_TYPE",
            "PAYMENT_CHK",
            "cBlock1",
            "cBay1",
            "cRow1",
            "cTier1",
            "cBlock",
            "cBay",
            "cRow",
            "cTier",
            ];

        // Hàm format ngày từ "2025-10-01 23:59:59.000" -> "01/10/2025 23:59:59"
        function formatDate(dateStr) {
        if (!dateStr) return null;
        const d = new Date(dateStr);
        if (isNaN(d)) return null;
        const pad = n => n.toString().padStart(2, '0');
        return `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        }

    function renderTable(Eir, Orders, InvDraft) {
    // Khởi tạo DataTable
        $('#contenttable').DataTable({
                ordering: false,         
                scrollY: true,
                scrollCollapse: true,
                searching: false,
                paging: false,
                autoWidth: false,
                info: false,
                
            });
        if (
        (!Eir || Eir.length === 0) &&
        (!Orders || Orders.length === 0) &&
        (!InvDraft || InvDraft.length === 0)
        ) {
            $('#contenttable tbody').html('<tr><td colspan="14" class="text-center">Không có dữ liệu</td></tr>');
            return;
        }

    // Nhóm theo EIRNo
    const grouped = {};
    Eir.forEach(row => {
        if (!grouped[`${row.EIRNo_Draft}.`]) grouped[`${row.EIRNo_Draft}.`] = [];
        grouped[`${row.EIRNo_Draft}.`].push(row);
    });
      // Nhóm theo Order
    const groupedOrder = {};
    Orders.forEach(row => {
        if (!groupedOrder[`${row.SSOderNo}.`]) groupedOrder[`${row.SSOderNo}.`] = [];
        groupedOrder[`${row.SSOderNo}.`].push(row);
    });
    // Nhóm theo Order
    const groupedInv = {};
    InvDraft.forEach(row => {
        if (!groupedInv[row.DRAFT_INV_NO]) groupedInv[row.DRAFT_INV_NO] = [];
        groupedInv[row.DRAFT_INV_NO].push(row); 
    });
    let html = '';
    let index = 1;
    Object.keys(grouped).forEach(EIRNo_Draft => {
        const rows = grouped[EIRNo_Draft];
        const hasSrv = rows[0]?.SRV_ORDER && rows[0].SRV_ORDER.length > 0;
        const srvCount = hasSrv ? rows[0].SRV_ORDER.length : 0;
        const rowspan = rows.length + srvCount;
        rows.forEach((row, idx) => {
            html += '<tr>';
            if (idx === 0) {
                html += `
                    <td align="center" rowspan="${rowspan}">${index++}</td>
                    <td rowspan="${rowspan}">
                        <button class="btn btn-success" onclick="handleClickPay('${EIRNo_Draft.replace(/\./g, '')}', '${row.Type_Eir}','eir')">Thanh toán</button>
                    </td>
                    <td rowspan="${rowspan}" align="center">
                        <button class="btn btn-danger" onclick="handleClickDelete('${EIRNo_Draft.replace(/\./g, '')}','eir')">Xóa</button>
                    </td>
                `;
            }

            html += `
                <td data-col="EIRNo">${row.EIRNo.replace(/\./g, '')}</td>
                <td>${row.CJModeName}</td>
                <td>${row.IssueDate}</td>
                <td>${row.ExpDate ?? '---'}</td>
                <td data-col="CNTRNO" align="center">${row.CntrNo}</td>
                <td data-col="OprID">${row.OprID}</td>
                <td data-col="BookingNo">${row.BookingNo ?? '---'}</td>
                <td align="center">${row.ISO_SZTP}</td>
                <td>${row.CusID}</td>
                <td>${row.CusName}</td>
                <td>${row.Type_Eir}</td>
            `;
            html += '</tr>';
        });

        // Render SRV_ORDER nếu có
        if (hasSrv) {
            rows[0].SRV_ORDER.forEach(srv => {
                html += `
                    <tr class="table-warning">
                        <td>${srv.SSOderNo ?? SSOderNo}</td>
                        <td>${srv.CJModeName ?? '---'}</td>
                        <td>${srv.IssueDate ?? '---'}</td>
                        <td>${srv.ExpDate ?? '---'}</td>
                        <td data-col="CNTRNO" align="center">${srv.CntrNo ?? '---'}</td>
                        <td data-col="OprID">${srv.OprID ?? '---'}</td>
                        <td data-col="BookingNo">${srv.BookingNo ?? '---'}</td>
                        <td align="center">${srv.ISO_SZTP ?? '---'}</td>
                        <td>${srv.CusID ?? '---'}</td>
                        <td>${srv.CusName ?? '---'}</td>
                        <td data-col="EIRNo" style="display: none">${srv.SSRMORE ?? '---'}</td>
                        <td>Dịch vụ đính kèm</td>
                    </tr>
                `;
            });
        }
    });
    Object.keys(groupedOrder).forEach(SSOderNo => {
        const rows = groupedOrder[SSOderNo];
        const hasSrv = rows[0]?.SRV_ORDER && rows[0].SRV_ORDER.length > 0;
        const srvCount = hasSrv ? rows[0].SRV_ORDER.length : 0;
        const rowspan = rows.length + srvCount;
        rows.forEach((row, idx) => {
            html += '<tr>';
            if (idx === 0) {
                html += `
                    <td align="center" rowspan="${rowspan}">${index++}</td>
                    <td rowspan="${rowspan}">
                        <button class="btn btn-success" onclick="handleClickPay('${SSOderNo.replace(/\./g, '')}', '${row.Type_Eir}', 'odrs')">Thanh toán</button>
                    </td>
                    <td rowspan="${rowspan}" align="center">
                        <button class="btn btn-danger" onclick="handleClickDelete('${SSOderNo.replace(/\./g, '')}','odrs')">Xóa</button>
                    </td>
                `;
            }

            html += `
                <td data-col="EIRNo">${row.SSOderNo.replace(/\./g, '')}</td>
                <td>${row.CJModeName}</td>
                <td>${row.IssueDate}</td>
                <td>${row.ExpDate ?? '---'}</td>
                <td data-col="CNTRNO" align="center">${row.CntrNo}</td>
                <td data-col="OprID">${row.OprID}</td>
                <td data-col="BookingNo">${row.BookingNo ?? '---'}</td>
                <td align="center">${row.ISO_SZTP}</td>
                <td>${row.CusID}</td>
                <td>${row.CusName}</td>
                <td>${row.Type_Eir}</td>
            `;
            html += '</tr>';
        });
        // Render SRV_ORDER nếu có
        if (hasSrv) {
            rows[0].SRV_ORDER.forEach(srv => {
                html += `
                    <tr class="table-warning">
                        <td>${srv.SSOderNo ?? SSOderNo}</td>
                        <td>${srv.CJModeName ?? '---'}</td>
                        <td>${srv.IssueDate ?? '---'}</td>
                        <td>${srv.ExpDate ?? '---'}</td>
                        <td data-col="CNTRNO" align="center">${srv.CntrNo ?? '---'}</td>
                        <td data-col="OprID">${srv.OprID ?? '---'}</td>
                        <td data-col="BookingNo">${srv.BookingNo ?? '---'}</td>
                        <td align="center">${srv.ISO_SZTP ?? '---'}</td>
                        <td>${srv.CusID ?? '---'}</td>
                        <td>${srv.CusName ?? '---'}</td>
                        <td data-col="EIRNo" style="display: none">---</td>
                        <td>Dịch vụ đính kèm</td>
                    </tr>
                `;
            });
        }
        
    });
    Object.keys(groupedInv).forEach(EIRNo => {
        const rows = groupedInv[EIRNo];
        const hasSrv = rows[0]?.SRV_ORDER && rows[0].SRV_ORDER.length > 0;
        const srvCount = hasSrv ? rows[0].SRV_ORDER.length : 0;
        const rowspan = rows.length + srvCount;
        rows.forEach((row, idx) => {
            html += '<tr>';
            if (idx === 0) {
                html += `
                    <td align="center" rowspan="${rowspan}">${index++}</td>
                    <td rowspan="${rowspan}">
                        <button class="btn btn-success" onclick="handleClickPay('${EIRNo}', 'Hóa đơn tay','invDraft')">Thanh toán</button>
                    </td>
                    <td rowspan="${rowspan}" align="center">
                        <button class="btn btn-danger" onclick="handleClickDelete('${EIRNo}','InvDraft')">Xóa</button>
                    </td>
                `;
            }

            html += `
                <td data-col="EIRNo">${row.DRAFT_INV_NO_PRO ?? row.DRAFT_INV_NO}</td>
                <td>${row.TPLT_NM ?? 'Xuất hóa đơn'}</td>
                <td>${row.insert_time}</td>
                <td>${row.DRAFT_INV_DATE ?? '---'}</td>
                <td data-col="CNTRNO" align="center">---</td>
                <td>---</td>
                <td>---</td>
                <td align="center">---</td>
                <td>${row.CusID}</td>
                <td>${row.CusName}</td>
                <td>${row.DRAFT_INV_NO_PRO ? 'Xuất hóa đơn' : 'Hóa đơn tay'}</td>
            `;
            html += '</tr>';
        });

       // Render SRV_ORDER nếu có
        if (hasSrv) {
            rows[0].SRV_ORDER.forEach((srv,idx) => {
               html += '<tr class="table-warning">';
                    //   if (idx === 0) {
                    //     html += `
                    //         <td align="center" rowspan="${rowspan}">${index++}</td>Ư
                    //         <td rowspan="${rowspan}">
                    //             <button class="btn btn-success" onclick="handleClickPay('${srv.DRAFT_INV_NO}', 'Hóa đơn tay','invDraft')">Thanh toán</button>
                    //         </td>
                    //         <td rowspan="${rowspan}" align="center">
                    //             <button class="btn btn-danger" onclick="handleClickDelete('${EIRNo}','InvDraft')">Xóa</button>
                    //         </td>
                    //     `;
                    // }
                     html += `
                        <td data-col="EIRNo">${srv.DRAFT_INV_NO ?? '---'}</td>
                        <td>${srv.TRF_DESC ?? '---'}</td>
                        <td>${srv.insert_time ?? '---'}</td>
                        <td>${srv.ExpDate ?? '---'}</td>
                        <td data-col="CNTRNO" align="center">${srv.CntrNo ?? '---'}</td>
                        <td data-col="OprID">${rows[0].OprID ?? '---'}</td>
                        <td>${rows[0].BookingNo ?? '---'}</td>
                        <td align="center">${srv.ISO_SZTP ?? '---'}</td>
                        <td>${rows[0].CusID ?? '---'}</td>
                        <td>${rows[0].CusName ?? '---'}</td>
                        <td data-col="EIRNo" style="display: none">${srv.SSRMORE ?? '---'}</td>
                        <td>Chi tiết</td>
                    </tr>
                `;
            });
        }
    });
        $('#count').text(Object.keys(grouped).length + Object.keys(groupedOrder).length)
        $('.datatable-info-right').hide();
        $('#contenttable tbody').html(html);
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            // Bổ sung td ẩn cho đủ cột
            $('#contenttable tbody tr').each(function() {
                const colHead = $('#contenttable thead th').length;
                const colBody = $(this).find('td').length;
                if (colBody < colHead) {
                    const diff = colHead - colBody;
                    for (let i = 0; i < diff; i++) {
                        $(this).append('<td style="display:none"></td>');
                    }
                }
            });
        }

        function handleClickDelete(EIRNo, Type) {
            	$.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: `Bạn có chắc chắn muốn xóa lệnh ${EIRNo}!`,
						buttons: {
							ok: {
								text: 'Tiếp tục',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
                                    deleteEirDraft(EIRNo,Type)
                                    // alert('Đố anh bắt được em !')
								}
							},
							cancel: {
								text: 'Hủy bỏ',
								btnClass: 'btn-default',
								keys: ['ESC'],
								// action: function() {
								// 	$('#chk-view-cont').trigger('click');
								// }
							}
						}
					});
        }
        function deleteEirDraft(EirNo,Type) {

            $('#Container_Await_Payment').blockUI();
            let stackingService = []
            let attachService = []
            var formData = {}
            if(Type === 'eir') {
                 stackingService = paymentData._lstEir.filter(x => x.EIRNo_Draft === EirNo);
                 attachService = stackingService[0].SRV_ORDER ?? []
                 formData = {
                 'EIRNo': EirNo
                 }

            }
            else if(Type ==='InvDraft') {
            formData = {
                 'InvDraftNo': EirNo
                 }
            }
            else {
                 stackingService = paymentData._lstOrders.filter(x => x.SSOderNo === EirNo);
                 attachService = stackingService[0].SRV_ORDER ?? []
                 formData = {
                 'Odrs': EirNo
                 }
            }
            if(attachService.length > 0) {
                formData['SRV'] = true
            }
            $.ajax({
            url: "<?= site_url(md5('Task') . '/' . md5('deleteEirDraft')); ?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function(data) {
            $('#Container_Await_Payment').unblock();
                toastr[`${data.Status}`](`${data.message}`);
                if(data.Status === 'success') {
                    if ($.fn.DataTable.isDataTable('#contenttable')) {
                            $('#contenttable').DataTable().clear().destroy();
                        }
                            paymentData._lstEir = paymentData._lstEir.filter(x => x.EIRNo_Draft !== EirNo);
                            paymentData._lstOrders = paymentData._lstOrders.filter(x => x.SSOderNo !== EirNo);
                            paymentData._lstInvDraft = paymentData._lstInvDraft.filter(x => x.DRAFT_INV_NO !== EirNo);
                            renderTable(paymentData._lstEir,paymentData._lstOrders,paymentData._lstInvDraft);
                            }
                        },
            error: function(err) {
                $(".toast").remove();
                $('#Container_Await_Payment').unblock();    
                toastr["error"]("ERROR!");
            }
        });
        }

        function handleClickPay(EIRNo, Type_Eir, Type) {
            $('#Container_Await_Payment').blockUI();
            let stackingService = []
            let attachService = []
            let cleanedData = []
            if(Type === 'invDraft') {
                stackingService = paymentData._lstInvDraft.filter(x => x.DRAFT_INV_NO === EIRNo);
                return handleClickPayQrMbForInv(stackingService);
                // attachService = stackingService[0].SRV_ORDER;
                // cleanedData = stackingService.map(item => keepOnlyKeys(item, keysToKeepSrv));
            }
           else if(Type === 'eir') {
                stackingService = paymentData._lstEir.filter(x => x.EIRNo_Draft === EIRNo);
                attachService = stackingService[0].SRV_ORDER;
                cleanedData = stackingService.map(item => keepOnlyKeys(item, keysToKeepEir));
            }
            else {
                stackingService = paymentData._lstOrders.filter(x => x.SSOderNo === EIRNo);
                attachService = stackingService[0].SRV_ORDER;
                cleanedData = stackingService.map(item => keepOnlyKeys(item, keysToKeepSrv));
            }
             const countBySize = {};
                stackingService.forEach(item => {
                    const key = item.LocalSZPT;
                    countBySize[key] = (countBySize[key] || 0) + 1;
                });
                Object.keys(countBySize).forEach((value) => {
                    $Sum = stackingService.find((e) => e.LocalSZPT === value).StackingAmount
                    countBySize[value] += parseInt($Sum)
                })
             const resuilt = transformData(cleanedData,Type)
             const resuilt1 = transformData(attachService,Type)
             loadpayment(countBySize,EIRNo,resuilt,resuilt1,stackingService[0].CusID,stackingService[0].CusName,stackingService[0].publishType,stackingService[0].Address,Type_Eir,Type)
        }
        
        // Hàm lọc và format
        function transformData(inputArr, Type ) {
        return inputArr.map(item => {
            const obj = {};
            const keyKeep = Type === 'eir' ? keysToKeepEir : keysToKeepSrv
            keyKeep.forEach(k => {   
            // special case: chuẩn hóa "DMethod_CD"
            if (k === "DMethod_CD") {
                obj["DMETHOD_CD"] = item["DMethod_CD"] ?? "";
            }
            else if (k === "isLocal") {
                obj['IsLocal'] = item["isLocal"] ?? "";
            }
             else if (k === "IssueDate" || k === "ExpDate") {
                obj[k] = formatDate(item[k]);
            } else {
                obj[k] = item[k] ?? "";
            }
            });
            return obj;
        });
        }
    function loadpayment(countBySize, EirNo, EirList, attachService, CusID, CusName, pubType, Address,Type_Eir,Type) {
        const formData = handleFormData(Type_Eir, attachService, EirList, CusID)
        if(formData) {
            const task = CryptoJS.MD5(formData[1]).toString();
            $.ajax({ 
                    url: "<?= site_url(md5('Task')) ?>/" + task,
                    dataType: 'json',
                    data: formData[0],
                    type: 'POST',
                    success: function(data) {
                        if(data.results) {
                                var rows = [];
                            if (data.results && data.results.length > 0) {
                                var lst = data.results,
                                    stt = 1;
                                for (i = 0; i < lst.length; i++) {
                                    var cntrclass = lst[i].CntrClass == 1 ? "Nhập" : (lst[i].CntrClass == 4 ?
                                        "Nhập chuyển cảng" : "");
                                    var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
                                    var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ?
                                        "Nội" : "");
                                    rows.push([
                                        (stt++), lst[i].DraftInvoice, lst[i].OrderNo ? lst[i].OrderNo :
                                        "", lst[i].TariffCode, lst[i].TariffDescription, lst[i].Unit,
                                        lst[i].JobMode, lst[i].DeliveryMethod, lst[i].Cargotype, lst[i]
                                        .ISO_SZTP, lst[i].FE, lst[i].IsLocal, lst[i].Quantity, lst[i]
                                        .StandardTariff, 0, lst[i].DiscountTariff, lst[i]
                                        .DiscountedTariff, lst[i].Amount, lst[i].VatRate, lst[i]
                                        .VATAmount, lst[i].SubAmount, lst[i].Currency, lst[i].IX_CD,
                                        lst[i].CNTR_JOB_TYPE, lst[i].VAT_CHK
                                    ]);
                                }
                            }
                            if (rows.length > 0) {
                                var n = rows.length;
                                rows.push([
                                    n, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
                                    data.SUM_AMT, '', data.SUM_VAT_AMT, data.SUM_SUB_AMT, '', '', '', ''
                                ]);
                                tblInv.DataTable({
                                data: rows,
                                info: false,
                                paging: false,
                                searching: false,
                                buttons: [],
                                columnDefs: [{
                                        targets: [0, 21],
                                        className: "text-center"
                                    },
                                    {
                                        targets: [12],
                                        className: "text-right"
                                    },
                                    {
                                        targets: [13, 14, 15, 16, 17, 18, 19, 20],
                                        className: "text-right",
                                        render: $.fn.dataTable.render.number(',', '.', 2)
                                    },
                                    {
                                        targets: [22, 23, 24],
                                        className: "hiden-input"
                                    }
                                ],
                                scrollY: '30vh',
                                createdRow: function(row, data, dataIndex) {
                                    if (dataIndex == rows.length - 1) {
                                        $(row).addClass('row-total');

                                        $('td:eq(0)', row).attr('colspan', 17);
                                        $('td:eq(0)', row).addClass('text-center');
                                        for (var i = 1; i <= 16; i++) {
                                            $('td:eq(' + i + ')', row).css('display', 'none');
                                        }

                                        this.api().cell($('td:eq(0)', row)).data('TỔNG CỘNG');
                                    }
                                }
                            });
                            }
                        handleClickPayQrMb(countBySize,EirNo, attachService, data.SUM_SUB_AMT, data.SUM_AMT, data.SUM_DIS_AMT, data.SUM_VAT_AMT, CusName, CusID, pubType, Address,Type_Eir, Type)
                        }
                    },
                    error: function(err) {
                        $(".toast").remove();
                        toastr["error"]("ERROR!");
                    }
                });
                }
                else {
                        toastr["error"]("ERROR!");
                    }
            }

    function handleFormData(Type_Eir, attachService, EirList, CusID) {
        let formdata = {};
        let direction = '';
           switch (Type_Eir) {
                    case 'Lệnh Giao Cont Rỗng': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: JSON.stringify(EirList),
                        };

                        if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            const sdd = attachService.filter(p => p.CJMode_CD === "SDD");
                            const lbc = attachService.filter(p => p.CJMode_CD === "LBC");

                            if (nonAttach.length > 0) formdata.nonAttach = JSON.stringify(nonAttach);
                            if (sdd.length > 0) formdata.sdd = JSON.stringify(sdd);
                            if (lbc.length > 0) formdata.lbc = JSON.stringify(lbc);
                        }
                        direction = 'tskEmptyPickup';
                        break;
                    }

                    case 'Lệnh Giao Cont Hàng': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: EirList,
                        };

                         if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            const sdd = attachService.filter(p => p.CJMode_CD === "SDD");
                            const lbc = attachService.filter(p => p.CJMode_CD === "LBC");

                            if (nonAttach.length > 0) formdata.nonAttach = nonAttach;
                            if (sdd.length > 0) formdata.sdd = sdd;
                            if (lbc.length > 0) formdata.lbc = lbc;
                        }
                        direction = 'tskImportPickup';
                        break;
                    }

                    case 'Lệnh Hạ Cont Hàng': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: JSON.stringify(EirList),
                        };
                            if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            const sdd = attachService.filter(p => p.CJMode_CD === "SDD");
                            const lbc = attachService.filter(p => p.CJMode_CD === "LBC");

                            if (nonAttach.length > 0) formdata.nonAttach = JSON.stringify(nonAttach);
                            if (sdd.length > 0) formdata.sdd = JSON.stringify(sdd);
                            if (lbc.length > 0) formdata.lbc = JSON.stringify(lbc);
                        }
                        direction = 'tskFCL_Pre_Advice';
                        break;
                    }
                    case 'Lệnh Hạ Cont Rỗng': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: JSON.stringify(EirList),
                        };
                            if (attachService && attachService.length > 0) {
                            if (attachService.length > 0) formdata.nonAttach = JSON.stringify(attachService);
                        }
                        direction = 'tskPre_Advice';
                        break;
                    }
                    case 'Lệnh Dịch Vụ': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: EirList,
                        };
                        direction = 'tskServiceOrder';
                        break;
                    }
                    case 'Lệnh Rút Hàng Container': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: EirList,
                        };
                            if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            const sdd = attachService.filter(p => p.CJMode_CD === "SDD");
                            const lbc = attachService.filter(p => p.CJMode_CD === "LBC");

                            if (nonAttach.length > 0) formdata.nonAttach = nonAttach;
                            if (sdd.length > 0) formdata.sdd = sdd;
                            if (lbc.length > 0) formdata.lbc = lbc;
                        }
                        direction = 'tskUnstuffingOrder';
                        break;
                    }
                    case 'Lệnh Đống Hàng Container': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: EirList,
                        };
                            if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            if (nonAttach.length > 0) formdata.nonAttach = nonAttach;
                        }
                        direction = 'tskStuffingOrder';
                        break;
                    }
                    case 'Lệnh Đống Rút Sang Cont': {
                        formdata = {
                            action: 'view',
                            act: 'load_payment',
                            cusID: CusID,
                            list: EirList,
                        };
                            if (attachService && attachService.length > 0) {
                            const nonAttach = attachService.filter(p => p.CJMode_CD !== "SDD" && p.CJMode_CD !== "LBC");
                            if (nonAttach.length > 0) formdata.nonAttach = nonAttach;
                        }
                        direction = 'tskTransStuffOrder';
                        break;
                    }
                    default: {
                        console.warn(`Không có loại EIR phù hợp: ${Type_Eir}`);
                        break;
                    }
                }
            return [formdata, direction];
        }
    // hàm chỉ giữ lại các key cần thiết
    function keepOnlyKeys(item, keysToKeep) {
        const newItem = {};
        keysToKeep.forEach(k => {
            if (item.hasOwnProperty(k)) {
                newItem[k] = item[k];
            }
        });
        return newItem;
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
    function getInvDraftDetail() {
            var rows = [];
            tblInv.find('tbody tr:not(.row-total)').each(function() {
                var nrows = [];
                var ntds = $(this).find('td:not(.dataTables_empty)');
                if (ntds.length > 0) {
                    ntds.each(function(td) {
                        nrows.push($(this).text() == "null" ? "" : $(this).text());
                    });
                    rows.push(nrows);
                }
            });

            var drd = [];
            if (rows.length == 0) return [];
            $.each(rows, function(idx, item) {
                var temp = {};
                for (var i = 1; i <= _colsPayment.length - 1; i++) {
                    temp[_colsPayment[i]] = item[i];
                }
                // temp['Remark'] = selected_cont.toString();
                drd.push(temp);
            });
            return drd;
        }
     function handleClickPayQrMbForInv(InvDraft) {
                const SUM = InvDraft.reduce((acc, arr) => {
                    acc.TAMOUNT += Number(arr.TAMOUNT || 0);
                    acc.AMOUNT += Number(arr.AMOUNT || 0);
                    acc.VAT += Number(arr.VAT || 0);
                    acc.DIS_AMT += Number(arr.DIS_AMT || 0);
                    return acc;
                }, {
                    TAMOUNT: 0,
                    AMOUNT: 0,
                    VAT: 0,
                    DIS_AMT: 0
                });
                const totalAmount = SUM['TAMOUNT'] || '0';
                const customerName = InvDraft[0].CusName || 'Customer';
                const customerTaxCode = InvDraft[0].CusID || '';
                // Ensure base_url has trailing slash for proper URL construction
                let baseUrl = window.base_url || '<?= site_url() ?>';
                if (!baseUrl.endsWith('/')) {
                    baseUrl += '/';
                }
                // Construct URL with parameters
                const paymentUrl = baseUrl + 'd171035a85cc2258e37d64e18505d78c/106a6c241b8797f52e1e77317b96a201?' +
                    '&amount=' + encodeURIComponent(totalAmount) +
                    '&cusId=' + encodeURIComponent(customerTaxCode) +
                    '&EirNo=' + encodeURIComponent(InvDraft[0].DRAFT_INV_NO) +
                    '&customer_name=' + encodeURIComponent(customerName);
                const Action = InvDraft[0].DRAFT_INV_NO_PRO !== null ? 'ExportInvoice' : 'InvDraft'
                //Xử lý sau
                modalQrPayment = window.open(paymentUrl, '_blank', 'width=700,height=900,scrollbars=yes,resizable=yes');
                  window.onPaymentSuccess = function(data) {
                  if (data.EirNo) {
                      modalQrPayment.close();
                      $('#Container_Await_Payment').blockUI();
                      toastr["success"]("Đang tiến hành xuất hóa đơn <br> Vui lòng không thao tác !");
                            publishInvQRForInvDraft(InvDraft[0].CusID, InvDraft[0].Address, InvDraft[0].CusName, SUM, InvDraft[0].ShipKey, data.EirNo, InvDraft[0].SRV_ORDER, InvDraft[0].REMARK, Action, InvDraft)
                        }
                        else {
                            toastr["error"]("Không tìm thấy thông tin!");
                        }
                    };
                	  //handle tab close
                    window.onPaymentClosed = function () {
                          $('#Container_Await_Payment').unblock();
                    };
                // Đóng tab con khi tab cha đóng hoặc reload
                    window.addEventListener('beforeunload', () => {
                        if (modalQrPayment && !modalQrPayment.closed) {
                            modalQrPayment.close();
                        }
                    });
                return
        }
      function handleClickPayQrMb(countBySize, EIR, attachService, SUM_SUB_AMT, SUM_AMT, SUM_DIS_AMT, SUM_VAT_AMT, CUSNAME, CUSID, PUBTYPE, Address, Type_Eir, Type) {
                const totalAmount = SUM_SUB_AMT || '0';
                const customerName = CUSNAME || 'Customer';
                const customerTaxCode = CUSID || '';
                // Ensure base_url has trailing slash for proper URL construction
                let baseUrl = window.base_url || '<?= site_url() ?>';
                if (!baseUrl.endsWith('/')) {
                    baseUrl += '/';
                }
                // Construct URL with parameters
                const paymentUrl = baseUrl + 'd171035a85cc2258e37d64e18505d78c/106a6c241b8797f52e1e77317b96a201?' +
                    '&amount=' + encodeURIComponent(totalAmount) +
                    '&cusId=' + encodeURIComponent(customerTaxCode) +
                    '&EirNo=' + encodeURIComponent(EIR) +
                    '&customer_name=' + encodeURIComponent(customerName);
                const drTotal = {
                    AMOUNT: SUM_AMT,
                    DIS_AMT: SUM_DIS_AMT,
                    TAMOUNT: SUM_SUB_AMT,
                    VAT: SUM_VAT_AMT
                }
                  window.onPaymentSuccess = function(data) {
                      if (data.EirNo) {
                          modalQrPayment.close();
                          $('#Container_Await_Payment').blockUI();
                          toastr["success"]("Đang tiến hành In lệnh <br> Vui lòng không thao tác!");
                               if (PUBTYPE === 'e-inv') {
                                    publishInvQR(countBySize, attachService, CUSID, Address, CUSNAME, SUM_AMT, SUM_VAT_AMT, SUM_SUB_AMT, data.EirNo, drTotal, PUBTYPE, Type_Eir, Type)
                                } else {
                                    handlePaymentSuccess(countBySize,null, data.EirNo, attachService, drTotal, PUBTYPE, Type_Eir, Type)
                                }
                        }
                        else {
                            toastr["error"]("Không tìm thấy thông tin!");
                        }
                    };
                modalQrPayment = window.open(paymentUrl, '_blank', 'width=700,height=900,scrollbars=yes,resizable=yes');
                	  //handle tab close
                window.onPaymentClosed = function () {
                          $('#Container_Await_Payment').unblock();
                    };
                // Đóng tab con khi tab cha đóng hoặc reload
                    window.addEventListener('beforeunload', () => {
                        if (modalQrPayment && !modalQrPayment.closed) {
                            modalQrPayment.close();
                        }
                    });
                return
        }
        //PUBLISH INV QR PAYMENT
        function publishInvQR(countBySize,attachService, CUSID, Address, CUSNAME, SUM_AMT, SUM_VAT_AMT, SUM_SUB_AMT, EirNo, drTotal, PUBTYPE, Type_Eir, Type) {
            var datas = getInvDraftDetail();
            var formData = {
                cusTaxCode: CUSID,
                cusAddr: Address,
                cusName: CUSNAME,
                sum_amount: SUM_AMT,
                vat_amount: SUM_VAT_AMT,
                total_amount: SUM_SUB_AMT,
                paymentMethod: 'CK',
                datas: datas
            };  
            $.ajax({
                url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function(data) {
                    if (data.error) {
                        $(".toast").remove();
                        toastr["error"](data.error);
                        return;
                    }
                    handlePaymentSuccess(countBySize, data, EirNo, attachService, drTotal, PUBTYPE, Type_Eir, Type);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
          //PUBLISH INV QR PAYMENT
        function publishInvQRForInvDraft(CUSID, Address, CUSNAME, SUM, ShipKey, InvDraftNo, Datas, REMARK, Action, draftData) {
            var formData = {
                cusTaxCode: CUSID,
                cusAddr: Address,
                cusName: CUSNAME,
                sum_amount: SUM['AMOUNT'],
                vat_amount: SUM['VAT'],
                inv_type: "VND",
                exchange_rate: "1",
                isCredit: "0",
                paymentMethod: 'CK',
                total_amount: SUM['TAMOUNT'],
                shipInfo: ShipKey,
                is_eport: draftData[0].is_eport,
                datas: Datas
            };  
            $.ajax({
                url: "<?= site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish')); ?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function(data) {
                    if (data.error) {
                        $(".toast").remove();
                        toastr["error"](data.error);
                        return;
                    }
                    if(Action === 'ExportInvoice') {
                        saveDataForExportInv(SUM, data, draftData,  CUSID, REMARK)
                    }
                    else {
                        saveDataForInvDraft(data, InvDraftNo);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
        function handlePaymentSuccess(countBySize, invInfo, EirNo, attachService, drTotal, PUBTYPE, Type_Eir, Type) {
            // Validate payment method selection
                var drDetail = getInvDraftDetail();
                // var drTotal = {};
                var formData = {
                    'data': {
                        'pubType': PUBTYPE,
                        'draft_detail': drDetail,
                        'draft_total': drTotal,
                        // 'EirNo': EirNo,
                    },
                };
                if(Type === 'eir') {
                     formData['data']['EirNo'] = EirNo; 
                }
                else {
                     formData['data']['Odrs'] = EirNo; 
                }
                if(Type_Eir === 'Lệnh Giao Cont Rỗng' || Type_Eir === 'Lệnh Đống Hàng Container') {
                    formData['data']['stackingAmount'] = countBySize; 
                }
                if (formData.data.pubType != 'credit' && (!drDetail || drDetail.length == 0)) {
                    $('.toast').remove();
                    toastr['warning']('Chưa có thông tin tính cước!');
                    return;
                }

                //get attach service for save
                if (attachService.length > 0) {
                    formData['data']['odr'] = true; //JSON.stringify();
                }
                //get attach service for save
                if (typeof invInfo !== "undefined" && invInfo !== null) {
                    formData.data["invInfo"] = invInfo;
                } else {
                    //trg hop không phải xuất hóa đơn điện tử, block popup ở đây
                    // $('#payment-modal').find('.modal-content').blockUI();
                }
                $.ajax({
                    url: "<?= site_url(md5('Task') . '/' . md5('paymentSuccess')); ?>",
                    dataType: 'json',
                    data: formData,
                    type: 'POST',
                    success: function(data) {
                        if (data.deny) {
                                // $('#payment-modal').find('.modal-content').unblock();
                                toastr["error"](data.deny);
                                return;
                            }

                            if (data.non_invInfo) {
                                // $('#payment-modal').find('.modal-content').unblock();
                                toastr["error"](data.non_invInfo);
                                return;
                            }

                            if (data.isDup) {
                                // $('#payment-modal').find('.modal-content').unblock();
                                toastr["error"]("Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!");
                                return;
                            }
                            if (data.invInfo) {
                                var form = document.createElement("form");
                                form.setAttribute("method", "post");
                                form.setAttribute("action",
                                    "<?= site_url(md5('Task') . '/' . md5('payment_success')); ?>");

                                var input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = "invInfo";
                                input.value = JSON.stringify(data.invInfo);
                                form.appendChild(input);

                                document.body.appendChild(form);
                                form.submit();
                                document.body.removeChild(form);
                            } else if (data.dftInfo) {
                                var form = document.createElement("form");
                                form.setAttribute("method", "post");
                                form.setAttribute("action",
                                    "<?= site_url(md5('Task') . '/' . md5('draft_success')); ?>");

                                var input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = "dftInfo";
                                input.value = JSON.stringify(data.dftInfo);
                                form.appendChild(input);

                                document.body.appendChild(form);
                                form.submit();
                                document.body.removeChild(form);
                            } else {
                                toastr["success"]("Lưu dữ liệu thành công!");
                                location.reload(true);
                            }
                    },  
                    error: function(err) {
                        console.log(err);
                        // $("#bookingno, #cntrno").parent().unblock();
                        toastr["error"]("Server error at [load_booking]");
                    }
                });
        }
        function saveDataForInvDraft(invInfo, DraftNo) {
			var formData = {
				'action': 'save',
                'act': 'save_qr_payment',
				'mailTo': [],
                'invInfo': invInfo,
                'draftNo': DraftNo
			};
			$.ajax({
				url: "<?= site_url(md5('Tools') . '/' . md5('tlManualInvoice')); ?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function(data) {
					if (data.deny) {
						$('#pay-confirm').button("reset");
						toastr["error"](data.deny);
						return;
					}

					if (data.non_invInfo) {
						$('#pay-confirm').button("reset");
						toastr["error"](data.non_invInfo);
						return;
					}

					if (data.isDup) {
						$('#pay-confirm').button("reset");
						toastr["error"]("Hóa đơn hiện tại đã tồn tại trong hệ thống! Kiểm tra lại!");
						return;
					}

					if (data.invInfo) {
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?= site_url(md5('Task') . '/' . md5('payment_success')); ?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "invInfo";
						input.value = JSON.stringify(data.invInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					} else if (data.dftInfo) {
						$.confirm({
							columnClass: 'col-md-5 col-md-offset-5',
							titleClass: 'font-size-17',
							type: 'green',
							typeAnimated: true,
							title: 'XUẤT PHIẾU THU THÀNH CÔNG',
							content: '<div style="color:red; font-size:30px">' +
								data.dftInfo.DRAFT_NO +
								'</div>',
							buttons: {
								ok: {
									text: 'Tiếp tục',
									btnClass: 'btn-sm btn-primary btn-confirm',
									keys: ['Enter'],
									action: function() {
										location.reload(true);
									}
								},
								print: {
									text: 'IN PHIẾU',
									btnClass: 'btn-sm btn-default btn-confirm',
									keys: ['Enter'],
									action: function() {
										printDraft(data.dftInfo.DRAFT_NO);
										return false;
									}
								}
							}
						});
					} else {
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error) {
					$('.ibox.collapsible-box').unblock();
					console.log(xhr);
					$('.toast').remove();
					$('#pay-confirm').button("reset");
					toastr['error']("Server Error at [saveData]");
				}
			});
		}
        function saveDataForExportInv( draftTotal , invInfo, draftData, CusID, REMARK )
		{
            const draftDataNew = draftData.map(arr => ({
                    DRAFT_INV_NO: arr.DRAFT_INV_NO_PRO,
                    REF_NO: arr.REF_NO,
                    ShipKey: arr.ShipKey,
                    ShipID: arr.ShipID,
                    ShipYear: arr.ShipYear,
                    ShipVoy: arr.ShipVoy,
                    OPR: arr.OPR,
                    PAYER_TYPE: arr.PAYER_TYPE,
                    INV_TYPE: arr.INV_TYPE,
                    ACC_CD: arr.ACC_CD
                }));
            const dateVN = new Date().toLocaleString("sv-SE", {
                timeZone: "Asia/Ho_Chi_Minh"
            }).replace("T", " ").replace(/\.\d+/, "");
            invInfo['INV_DATE'] = dateVN;
            invInfo['REMARK'] = REMARK;
			var formData = {
				'action': 'add',
				'data': {
					'pubType': 'e-inv',
					'invInfo': invInfo,
					'draftData': draftDataNew,
					'draftTotal': draftTotal,
					'payer': CusID,
					'currencyId': 'VND'
				}
			};
			$.ajax({
				url: "<?=site_url(md5('Invoice') . '/' . md5('invPublishInvoice'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
                    $('#Container_Await_Payment').unblock();    
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
													+ " " + 'VND' ); //HARD CODE CURRENTID
						$( "#payment-success-modal" ).modal("show");
                        toastr["success"]("Thành công!");
                        const listInvDraftNew = paymentData._lstInvDraft.filter((data) => data.DRAFT_INV_NO !== draftData[0].DRAFT_INV_NO)
                        // paymentData._lstInvDraft = data.invDraft;
                        renderTable(paymentData._lstEir, paymentData._lstOrders, listInvDraftNew)
                    if( data.invdata && data.invdata.length > 0 ){
							_invData = data.invdata;
							_amtwords = data.amtwords;
						}
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
        function loadData() {
            let fromDate = $("#fromDate").val();
            let toDate = $("#toDate").val();
            let OprId = $("#oprID").val();
            const condition = {
                fromDate,
                toDate
            }
            if(OprId.length > 1) {
                condition['OprID'] = OprId
            } 
           	const formData = {
				'action': 'loadData',
				'condition': condition
			};
                $('#Container_Await_Payment').blockUI();
            	$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('EirWaitPayment'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
                    $('#service').val('')
                    paymentData._lstEir = data.eir;
                    paymentData._lstOrders = data.odrs;
                    paymentData._lstInvDraft = data.invDraft;
                    renderTable(data.eir, data.odrs, data.invDraft)
                    $('#Container_Await_Payment').unblock();
				},
				error: function(xhr, status, error){
					console.log(xhr);
                    $('#service').val('')
                    $('#Container_Await_Payment').unblock();
					toastr['error']("Có lỗi xảy ra khi lưu dữ liệu! Vui lòng liên hệ KTV! ");
				}
			});
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
        $('.m-modal-background').click(function(){
            $('.m-show-modal').hide('fade');
        });

        $('.m-close-modal').click(function(){
            $(this).hide();
            $('.m-show-modal').hide('fade');
        });
        $('#service').on('change', function(e) {
            if(e.target.value === 'eir') {
                    renderTable(paymentData._lstEir, [], [])
            }
            else if(e.target.value === 'odrs') {
                    renderTable([], paymentData._lstOrders, [])
            }
            else if (e.target.value === 'invdft') {
                    renderTable([], [], paymentData._lstInvDraft)
            }
            else {
                    renderTable(paymentData._lstEir,  paymentData._lstOrders, paymentData._lstInvDraft)
            }
        })
        $(document).on("keydown", function(e){
            if( e.keyCode == 27 ){
                $('.m-close-modal').trigger("click");;
            }
        });
</script>


<script src="<?= base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>
<!-- Note: MB Bank now uses dedicated payment pages only -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
