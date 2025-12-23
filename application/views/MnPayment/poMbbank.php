<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css'); ?>"
    rel="stylesheet" />
<link href="<?= base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css'); ?>" rel="stylesheet" />
    <!-- CryptoJS for MAC signature -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

<style>
    .content{
    padding-top: 14px;
   }
   .dataTables_scrollBody {
    padding-bottom: 20px;
    /* min-height: 680px; */
    height: 100%;
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
#searchCntr {
    height: 100%;
    
}
.pagination_content {
    height: 50px;
}
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>    
<div class="row" style="font-size: 12px!important;">
    <div class="col-xl-12" id="main-content">
        <div class="ibox collapsible-box box-title" id="parent-loading">
            <div class="ibox-head">
                <div class="ibox-title">QUẢN LÝ QR THANH TOÁN</div>
            </div>
        </div>
        <div class="ibox collapsible-box content">
            <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                <div id="tablecontent">
                    <div class="table_header">
                        <div class="Search_container">
                            <span class="Search_container-icon"><i class="fa fa-search Search_container-icon--item"></i></span>
                            <input type="text" id="searchCntr" placeholder="Nhập số lệnh, số DR..." class="form-control" style="width:200px;">
                        </div> 
                    </div>

                    <table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.9%">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thanh toán</th>
                                <th>Số tiền</th>
                                <th>Hoàn trả</th>
                                <th>Mã FT</th>
                                <th>Trạng thái</th>
                                <th>Hết hạn</th>
                                <th>Thời gian khởi tạo</th>
                                <th>Khởi tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="pagination_content">
                <ul id="pagination" class="pagination pagination-lg pagination_container"></ul>
            </div>

            <div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="groups-modalLabel">Chọn dịch vụ hoàn trả</h5>
                        </div>

                        <div class="modal-body" style="padding: 10px 0">
                            <table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th style="display: none;">Id</th>
                                        <th>Số phiếu tính cước</th>
                                        <th>Mã biểu cước</th>
                                        <th>Tên biểu cước</th>
                                        <th>Loại công việc</th>
                                        <th>PTGN</th>
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
                                        <th>Ghi chú</th>
                                        <th style="display: none;">REMAINING</th>
                                        <th style="display: none;">VALUE</th>
                                        <th style="display: none;">ALLQTY</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <h5>Tổng tiền: <span id="total_tamount">0</span></h5>
                            <button data-target="#ship-modal" class="btn btn-success" onclick='handleClickSendRequest()'>Gửi yêu cầu</button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
        // Payment data from PHP
    const paymentData = {
        _lstPayment: <?= json_encode($litspayment) ?> ,
        totalPages: <?= json_encode($allItem) ?> ,
    };
    var PaymentActive = null
    //  var tblInv =  $('#tbl-inv');
    //  var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode",
    //             "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP", "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE",
    //             "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID", "IX_CD",
    //             "CNTR_JOB_TYPE", "VAT_CHK"
    //         ]
    const MBBankQRPage = {
                clientId: 'RKzfCQIZBosvPVSXbi4kL4LRg45njNjr',
                clientSecret: '6eV24s6QAysGlo8w',
                merchantId: '203156',
                accessCode: 'NFNAOPLJLD',
                secretKey: '9e5d9c509dd8a190e3f986d33bdc9820',
                apiBaseUrl: 'https://api-sandbox.mbbank.com.vn',
                tokenUrl: 'https://api-sandbox.mbbank.com.vn/oauth2/v1/token',
                createOrderUrl: 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/paygate/v2/create-order',
                statusCheckUrl: 'https://api-sandbox.mbbank.com.vn/private/ms/pg-paygate-authen/v2/paygate/detail'
    }
    var currentPage = 1
    var totalPages = 0
    var totalRefund = 0
        $(document).ready(function () {
            // renderTable(paymentData._lstPayment);()
            fetch_data(currentPage);
            });
        function renderTable(lstPayment) {
            // Nếu đã init DataTable thì hủy trước
            if ($.fn.DataTable.isDataTable('#contenttable')) {
                $('#contenttable').DataTable().destroy();
            }
            const tbody = $('#contenttable tbody');
            tbody.empty();

            if (!lstPayment || lstPayment.length === 0) {
                tbody.html('<tr><td colspan="14" class="text-center">Không có dữ liệu</td></tr>');
            } else {
                lstPayment.forEach((item, idx) => {
                const stt = (currentPage - 1) * 14 + idx + 1;
                const row = `
                    <tr data-booking="${item.booking_no}">
                    <td class="text-center">${stt}</td>
                    <td class="text-center">${item.booking_no ?? ''}</td>
                    <td class="text-center amount">${Number(item.amount).toLocaleString('vi-VN')} ₫</td>
                    <td class="text-center refund_amount">${Number(item.refund_amount).toLocaleString('vi-VN')} ₫</td>
                    <td class="text-center">${item.pg_issuer_txn_reference ?? ''}</td>
                    <td class="text-center">${item.status ?? ''}</td>
                    <td class="text-center">${item.expired_time ?? ''}</td>
                    <td class="text-center">${item.created_at ?? ''}</td>
                    <td class="text-center">${item.user_name ?? ''}</td>
                    <td class="text-center">${item.status === 'PAID' ? `<button data-target="#ship-modal" class="btn btn-success" onclick='getDetailInv(${JSON.stringify(item.booking_no)})'>YÊU CẦU HOÀN TIỀN</button>` : ''}</td>
                    </tr>`;
                tbody.append(row);
                });
            }

            // Khởi tạo lại DataTable
            $('#contenttable').DataTable({
                columnDefs: [{ type: 'num', targets: 0 }],
                scrollY: true,
                scrollCollapse: true,
                searching: false,
                paging: false,
                autoWidth: false,
                ordering: false,
                info: false,
            });
            $('.datatable-info-right').hide();
            }
            function renderTableInv(listInv) {
                if ($.fn.DataTable.isDataTable('#tbl-inv')) {
                    $('#tbl-inv').DataTable().destroy();
                }
                const tbody = $('#tbl-inv tbody');
                tbody.empty();
                if (!listInv || listInv.length === 0) {
                    tbody.html('<tr><td colspan="14" class="text-center">Không có dịch vụ hoàn tiền</td></tr>');
                } else {
                    listInv.forEach((item, idx) => {
                    const stt = (currentPage - 1) * 14 + idx + 1;
                    const QTYRefund = item.NOTE ? Number(item.NOTE.split('QTY:')[1].trim()) : 0;
                    const REMAINING = item.QTY - QTYRefund
                    for(let i = 1; i <= item.QTY; i++) {
                    const row = `
                        <tr>
                        <td class="text-center">${stt}</td>
                        <td class="text-center hidden">${item.rowguid ?? ''}</td>
                        <td class="text-center">${item.DRAFT_INV_NO ?? ''}</td>
                        <td class="text-center">${item.TRF_CODE ?? ''}</td>
                        <td class="text-center">${item.TRF_DESC ?? ''}</td>
                        <td class="text-center">${item.CNTR_JOB_TYPE ?? ''}</td>
                        <td class="text-center">${item.DMETHOD_CD ?? ''}</td>
                        <td class="text-center">${item.CARGO_TYPE ?? ''}</td>
                        <td class="text-center">${item.FE ?? ''}</td>
                        <td class="text-center">${item.IsLocal ?? ''}</td>
                        <td class="text-center">1</td>
                        <td class="text-center">${Number(item.standard_rate).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${Number(item.DIS_RATE).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${Number(item.extra_rate).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${Number(item.UNIT_RATE).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${(Number(item.AMOUNT) / Number(item.QTY)).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${Number(item.VAT_RATE).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${(Number(item.VAT) / Number(item.QTY)).toLocaleString('vi-VN') ?? ''}</td>
                        <td class="text-center">${(Number(item.TAMOUNT) / Number(item.QTY)).toLocaleString('vi-VN') ?? ''}</td>
                        <td style="color:red" class="text-center">${item.NOTE ?? ''}</td>
                        <td style="display: none;" class="text-center">${REMAINING}</td>
                        <td style="display: none;" class="text-center">${item.TAMOUNT ? item.TAMOUNT / item.QTY : ''}</td>
                        <td style="display: none;" class="text-center">${item.QTY}</td>
                        </tr>`;
                        tbody.append(row);
                    }
                    });
            }
            // Khởi tạo lại DataTable
            $('#tbl-inv').DataTable({
                scrollX: true,
                scrollCollapse: true,
                autoWidth: true,
                paging: false,
                searching: false,
                ordering: false,
                info: false,
            });
            setTimeout(() => {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            }, 200);
            }
          function updateAmountByBooking(bookingNo, newAmount) {
                const $row = $(`#contenttable tbody tr[data-booking="${bookingNo}"]`);

                if ($row.length === 0) {
                    console.warn('Không tìm thấy booking:', bookingNo);
                    return;
                }

                const $tdAmount = $row.find('td.refund_amount');

                $tdAmount.text(Number(newAmount).toLocaleString('vi-VN') + ' ₫');
            }
            function getDetailService() {
                   const keys = [
                        'stt', 'rowguid', 'DRAFT_INV_NO', 'TRF_CODE', 'TRF_DESC', 'CNTR_JOB_TYPE', 'DMETHOD_CD', 
                        'CARGO_TYPE', 'FE', 'IsLocal', 'QTY', 'standard_rate', 'DIS_RATE', 
                        'extra_rate', 'UNIT_RATE', 'AMOUNT', 'VAT_RATE', 'VAT', 'TAMOUNT', 'NOTE', 'REMAINING', 'VALUE', 'ALLQTY'
                    ];
                const selectedData = [];
              $('#tbl-inv tbody tr.selected').each(function () {
                    var row = {};
                    $(this).find('td').each(function (index) {
                        row[keys[index]] = $(this).text().trim();
                    });
                    selectedData.push(row);
                });
                return selectedData;
            }
            function CalculateSum(value) {
                const Sum = 0;
                const selectedData = {};
                   const keys = [
                        'stt', 'rowguid','DRAFT_INV_NO', 'TRF_CODE', 'TRF_DESC', 'CNTR_JOB_TYPE', 'DMETHOD_CD', 
                        'CARGO_TYPE', 'FE', 'IsLocal', 'QTY', 'standard_rate', 'DIS_RATE', 
                        'extra_rate', 'UNIT_RATE', 'AMOUNT', 'VAT_RATE', 'VAT', 'TAMOUNT', 'NOTE', 'REMAINING', 'VALUE', 'ALLQTY'
                    ];
                value.find('td').each(function (index) {
                      selectedData[keys[index]] = $(this).text().trim();
                });
                if(value.hasClass('selected')) {
                    totalRefund += parseFloat(selectedData['VALUE'] || 0);
                } else {
                    totalRefund -= parseFloat(selectedData['VALUE'] || 0);
                }
                $('#total_tamount').text(totalRefund.toLocaleString('vi-VN'));
            }
            function genarateMac(obj) {
                let keys = Object.keys(obj).sort();
                return keys
                    .filter(key => obj[key] !== "" && obj[key] !== null && obj[key] !== undefined && key !==
                        "mac_type")
                    .map(key => key + "=" + obj[key])
                    .join("&");
            }
            $('#tbl-inv tbody').on('click', 'tr', function () {
                $(this).toggleClass('selected');
                CalculateSum($(this))
            });
           function handleClickSendRequest() {
            const items = getDetailService()
            if(PaymentActive) {
                if(items.length > 0) {
                    const TotalRefund = parseInt($('#total_tamount').text().replace(/\./g, ""));
                    const DraftId = Object.values(
                    items.reduce((acc, item) => {
                        const key = item.rowguid;if (!acc[key]) {acc[key] = {rowid: key,SL: (item.ALLQTY - item.REMAINING) + 1 ,PICK: 1};} else {acc[key].SL += 1;acc[key].PICK += 1;}return acc;}, {}));
                      $.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: `Bạn có chắc chắn muốn hoàn trả giao dịch này!`,
						buttons: {
							ok: {
								text: 'Tiếp tục',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
                                    handleRefund(TotalRefund, DraftId)
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
                else {
                     $.alert({
                            title: "Thông báo",
                            content: "Vui lòng chọn dịch vụ hoàn trả.",
                            type: 'red'
                        });
                }
            }
            else {
                  $.alert({
                            title: "Cảnh báo",
                            content: "Vui lòng thử lại.",
                            type: 'red'
                        });
            }
          
           }
        function handleClickRefund(Eir) {
            $.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: `Bạn có chắc chắn muốn hoàn trả giao dịch này!`,
						buttons: {
							ok: {
								text: 'Tiếp tục',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
                                    getDetailInv(Eir)
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
           function handleRefund(total, DraftId){
            $('#main-content').blockUI();
            $('.modal-body').blockUI();
            const formData = {
                txn_amount: total,
                desc: 'Test thử thui',
                transaction_reference_id: PaymentActive.transaction_ref_number,
                trans_date: PaymentActive.updated_at,
                DraftId
            }
            $.ajax({
                url: "<?=site_url(md5('Mbbank') . '/' . md5('requireRefund'));?>",
                dataType: 'json',
                data: JSON.stringify(formData),
                type: 'POST',
                 headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                success: function(data) {
                    $('#main-content').unblock();
                    $('.modal-body').unblock();
                    if(data.Status){
                        $.alert({
                            title: "Thông báo",
                            content: `
                                Hoàn trả thành công!<br>
                                Đơn hàng: <b>${PaymentActive.booking_no}</b><br>
                                Số tiền: <b>${Number(total).toLocaleString('vi-VN')}</b> VND
                            `,
                            type: 'green'
                        });
                        const NewAmount = Math.round((parseFloat(PaymentActive.refund_amount || 0) + parseFloat(total || 0)) * 100) / 100;
                        PaymentActive.refund_amount = NewAmount
                        updateAmountByBooking(PaymentActive.booking_no, NewAmount)
                        PaymentActive = null
                        $('#ship-modal').modal("toggle");
                    } else {
                          $.alert({
                            title: "Thông báo",
                            content: `
                                Hoàn trả không thành công!<br>
                                Lý do: <b>${data.Message}</b><br>
                                Số tiền: <b>${Number(total).toLocaleString('vi-VN')}</b> VND
                            `,
                            type: 'red'
                        });
                    }
                },
                error: function(err) {  
                    $('#main-content').unblock();
                    $('.modal-body').unblock();
                    toastr["error"]("Lỗi yêu cầu hoàn trả.");
                    console.log(err);
                }
            });
           }
           function renderPagination(currentPage, totalPages) {
                const $pagination = $("#pagination");
                $pagination.empty();
                // Nút Previous
                const prevDisabled = currentPage === 1 ? "disabled" : "";
                $pagination.append(`
                    <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="#" aria-label="Previous" data-page="${currentPage - 1}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                `);

                // 🧠 Tính toán start & end (trang hiện tại luôn ở giữa nếu có thể)
                let start = currentPage - 1;
                let end = currentPage + 1;

                if (currentPage === 1) {
                    start = 1;
                    end = Math.min(3, totalPages);
                } else if (currentPage === 2) {
                    start = 1;
                    end = Math.min(3, totalPages);
                } else if (currentPage === totalPages) {
                    end = totalPages;
                    start = Math.max(1, totalPages - 2);
                } else if (currentPage === totalPages - 1) {
                    end = totalPages;
                    start = Math.max(1, totalPages - 2);
                }

                // Render các số trang
                for (let i = start; i <= end; i++) {
                    const active = i === currentPage ? "active" : "";
                    $pagination.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                    `);
                }

                // Nút Next
                const nextDisabled = currentPage === totalPages ? "disabled" : "";
                $pagination.append(`
                    <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="#" aria-label="Next" data-page="${currentPage + 1}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                `);
                }
            $(document).on("click", ".page-link", function (e) {
                e.preventDefault();
                const newPage = parseInt($(this).data("page"));
                if (!isNaN(newPage) && newPage >= 1 && newPage <= paymentData.totalPages) {
                    currentPage = newPage;
                    fetch_data(currentPage);
                }
            });
            function fetch_data(page) {
                $('#main-content').blockUI({ message: 'Đang tải dữ liệu...' });
                $.ajax({
                    url: "<?= site_url(md5('MnPayment') . '/' . md5('poMbbank')); ?>",
                    dataType: 'json',
                    data: {action: 'fetch_page', page: page},
                    type: 'POST',
                    success: function(data) {
                        $('#main-content').unblock();
                        if(data.status === 'success') {
                            renderTable(data.data);
                            renderPagination(currentPage, data.totalPages);
                        } else {
                            toastr["error"]("Lỗi tải dữ liệu trang.");
                        }
                    },
                    error: function(err) {
                        $('#main-content').unblock();
                        console.log(err);
                        toastr["error"]("Lỗi tải dữ liệu trang.");
                    }
                });
            }
            function getDetailInv(Eir) {
                PaymentActive = paymentData._lstPayment.find((data) => data.booking_no === Eir)
                $('#main-content').blockUI({ message: 'Đang tải dữ liệu...' });
                totalRefund = 0 // reset totalRefund
                $('#total_tamount').text('0');
                $.ajax({
                    url: "<?= site_url(md5('MnPayment') . '/' . md5('poMbbank')); ?>",
                    dataType: 'json',
                    data: {action: 'detail-eir', eir: Eir},
                    type: 'POST',
                    success: function(data) {
                        $('#main-content').unblock();
                        if(data.success) {
                            if(data.data.length === 0) {
                                toastr["error"]("Không có dữ liệu chi tiết.");
                                return;
                            }
                            renderTableInv(data.data);
                            $('#ship-modal').modal("toggle");
                            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                        } else {
                            renderTableInv([]);
                            toastr["error"]("Lỗi tải dữ liệu chi tiết.");
                        }
                    },
                    error: function(err) {
                        renderTableInv([]); 
                        $('#main-content').unblock();
                        console.log(err);
                        toastr["error"]("Lỗi tải dữ liệu trang.");
                    }
                });
            }
</script>

<script src="<?= base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js'); ?>"></script>
<!--format number-->
<script src="<?= base_url('assets/js/jshashtable-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.numberformatter-1.2.3.min.js'); ?>"></script>
<!-- Note: MB Bank now uses dedicated payment pages only -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
