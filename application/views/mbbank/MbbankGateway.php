
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MB Bank QR Payment' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <!-- CryptoJS for MAC signature -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .payment-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideInUp 0.5s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .payment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .payment-header h2 {
            margin: 0;
            font-weight: 300;
            font-size: 2rem;
        }

        .payment-header .subtitle {
            opacity: 0.9;
            margin-top: 10px;
        }

        .payment-body {
            padding: 40px;
        }

        .qr-section {
            text-align: center;
            margin: 30px 0;
        }
        .icon-success {
            color: #33ef06;
            font-size: 40px;
        }
        .qr-code-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            border: 2px dashed #dee2e6;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .qr-code-img {
            max-width: 250px;
            max-height: 250px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .loading-spinner {
            font-size: 2rem;
            color: #667eea;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .payment-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            font-weight: 700;
            color: #212529;
        }

        .amount-value {
            color: #28a745;
            font-size: 1.2rem;
        }

        .countdown-timer {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .countdown-timer.warning {
            background: linear-gradient(45deg, #fd7e14, #dc3545);
        }

        .countdown-timer.danger {
            background: linear-gradient(45deg, #dc3545, #6f42c1);
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        .status-indicator {
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .control-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .dev-notice {
            background: linear-gradient(45deg, #17a2b8, #6610f2);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
        }

        .error-container {
            text-align: center;
            color: #dc3545;
        }

        .footer-links {
            text-align: center;
            margin-top: 30px;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 15px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .payment-container {
                margin: 20px auto;
                padding: 0 10px;
            }

            .payment-body {
                padding: 20px;
            }

            .control-buttons {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                margin: 5px 0;
            }
        }
        span.info-value.time-expired {
            color: #696969;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 500;
            background-color: #d9d9d9;
        }
        .modal_device {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, .3);
            display: flex;
            pointer-events: none;
            opacity: 0;
            justify-content: center;
            align-items: center;
        }
        .modal_device.open {
            opacity: 1;
            pointer-events: auto;
        }
        .modal_device.open .modal_device_container{
            transform: scale(1);
            transition: all 0.3s ease;
        }
        .modal_device_container {
            background-color: #fff;
            padding: 8px 10px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 350px;
            justify-content: space-between;
            min-height: 184px;
            transform: scale(.7);
        }
        .modal_device_container-header {
            text-align: center;
        }   
        .modal_device_container-subtitle {
            color: ##6d6d6d;
            font-size: 14px;
        }
        .modal_device_container-title {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="payment-card">
            <!-- Header -->
            <div class="payment-header">
                <h2><i class="fa fa-qrcode"></i> MB Bank QR Payment</h2>
                <div class="subtitle">Thanh toán bằng QR Code</div>
            </div>

            <!-- Body -->
            <div class="payment-body">
                <!-- Payment Information -->
                <div class="payment-info">
                    <div class="info-row">
                        <span class="info-label">EIR Number:</span>
                        <span class="info-value" id="booking-number"><?= htmlspecialchars($EirNo) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Customer:</span>
                        <span class="info-value" id="customer-name"><?= htmlspecialchars($customer_name) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Amount:</span>
                        <span class="info-value amount-value"
                            id="payment-amount"><?= number_format($amount, 0, '.', ',') ?> VND</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Bank:</span>
                        <span class="info-value">MB Bank (QR Payment)</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Time:</span>
                        <span id="expired-val" class="info-value time-expired">00:00</span>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="qr-section">
                    <!-- Loading State -->
                    <div id="qr-loading" class="qr-code-container">
                        <i class="fa fa-spinner loading-spinner"></i>
                        <h5 class="mt-3">Đang tạo mã QR...</h5>
                        <p class="text-muted">Vui lòng đợi trong giây lát</p>
                    </div>
                    <!-- Qr was paid -->
                    <div id="qr-was-paid" class="qr-code-container" style="display: none;">
                        <i class="icon-success fas fa-check-circle"></i>
                        <h5 class="mt-3">Đơn hàng đã được thanh toán</h5>
                        <button type="button" class="btn btn-success">In hóa đơn</button>
                    </div>
                    <!-- QR Code Display -->
                    <div id="qr-content" class="qr-code-container" style="display: none;">
                        <img id="qr-image" src="" alt="QR Code" class="qr-code-img">
                        <p class="mt-3 mb-0"><strong>Quét mã QR để thanh toán</strong></p>
                        <small class="text-muted">Sử dụng app MB Bank để quét mã</small>
                        <!-- <div class="mt-3">
                            <button type="button" class="btn btn-success" id="print-qr">
                                In QR
                            </button>
                            <button type="button" class="btn btn-danger" id="cancel-payment">
                                <i class="fa fa-times"></i> Thoát
                            </button>
                        </div> -->
                    </div>
                    <!-- Error State -->
                    <div id="qr-error" class="qr-code-container error-container" style="display: none;">
                        <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                        <h5 class="mt-3">Không thể tạo mã QR</h5>
                        <p class="text-muted">Vui lòng thử lại sau</p>
                    </div>

                    <!-- Development Notice -->
                    <div id="dev-notice" class="dev-notice" style="display: none;">
                        <i class="fa fa-info-circle fa-2x"></i>
                        <h5 class="mt-2">Development Mode</h5>
                        <p class="mb-0">Running in development environment. Showing demo QR code.</p>
                    </div>
                </div>

                <!-- Account Information -->
                <div id="account-info" class="payment-info" style="display: none;">
                    <h6 class="mb-3"><i class="fa fa-bank"></i> Thông tin tài khoản</h6>
                    <div class="info-row">
                        <span class="info-label">Số tài khoản:</span>
                        <span class="info-value" id="account-no">3101928274</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tên tài khoản:</span>
                        <span class="info-value" id="account-name">DUONG THANH BINH</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nội dung:</span>
                        <span class="info-value" id="transfer-content">Thanh toan
                            <?= htmlspecialchars($EirNo) ?></span>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div id="countdown" class="countdown-timer" style="display: none;">
                    <i class="fa fa-clock-o"></i> Thời gian còn lại: <span id="time-remaining">15:00</span>
                </div>

                <!-- Payment Status -->
                <div id="payment-status" class="status-indicator status-pending" style="display: none;">
                    <i class="fa fa-clock-o"></i> Đang chờ thanh toán...
                </div>

                <!-- Control Buttons -->
                <div id="control-buttons" class="control-buttons" style="display: none;">
                    <button type="button" class="btn btn-primary btn-custom" id="check-payment">
                        <i class="fa fa-search"></i> Kiểm tra
                    </button>
                    <!-- <button type="button" class="btn btn-success btn-custom" id="mark-paid">
                        <i class="fa fa-check"></i> Xác nhận đã trả
                    </button> -->
                    <button type="button" class="btn btn-danger btn-custom" id="cancel-payment">
                        <i class="fa fa-times"></i> Thoát
                    </button>
                </div>
                <div id="modal_device" class="modal_device">
                    <div id="modal_device-content" class="modal_device_container">
                        <div class="modal_device_container-header">
                            <i class="fa fa-check-circle fa-3x text-success"></i>
                            <h5 class="modal_device_container-title">Thành công</h5>
                            <span class="modal_device_container-subtitle">In mã thanh toán ra thiết bị !</span>
                            <h6>👇</h6>
                        </div>
                        <div class="modal_device_container-footer">
                          <div class="mt-3">
                            <button type="button" class="btn btn-success" id="print-qr">
                                In QR
                            </button>
                            <button type="button" class="btn btn-danger" id="cancel-QR">
                                <i class="fa fa-times"></i> Thoát
                            </button>
                        </div>
                        </div>
                    </div>    
                <div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <!-- Toastr for notifications -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- CryptoJS for proper MD5 hashing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>

    <script>
        // Configure toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        var ws = null
        var Timmer = null;
        var port = null;
        var PortNumber = localStorage.getItem("PortNumber") || 115200;
        var QR_CODE = null;
        // Payment data from PHP
        const paymentData = {
            amount: <?= $amount ?>,
            cusId: '<?= htmlspecialchars($cusId) ?>',
            EirNo: '<?= preg_replace("/[^a-zA-Z0-9]/", "", $EirNo) ?>',
            customer_name: '<?= htmlspecialchars($customer_name) ?>',
            orderReferenceId: null
        };
        $('#modal_device').on('click',() => {
            $('#modal_device').removeClass('open');
        });
        $('#modal_device-content').on('click',(e) => {
            e.stopPropagation()
        });
        // MB Bank QR Payment Module for dedicated page
        const MBBankQRPage = {
            init: function() {
                this.bindEvents();
                this.checkPaymentQR(paymentData.EirNo).then((QrCode) => {
                    if(QrCode.data.status === 'PAID') {
                       this.checkStatusWithMBBank(QrCode.data.transaction_ref_id, true)
                    }
                    else { 
                        if (new Date(QrCode.data.expired_time).getTime() <= Date.now()) {
                                this.startCountdownExpire(this.formatDateTime(QrCode.data.expired_time))
                            } else {
                                $('#qr-image').attr('src', QrCode.data.qr_code);   
                                QR_CODE = QrCode.data.qr_info
                                $('#qr-loading').hide();
                                $('#qr-content').show();
                                paymentData.orderReferenceId = QrCode.data.transaction_ref_id
                                $('#account-info').show();
                                $('#account-no').text('899977799979');
                                $('#account-name').text('CANG SP ITC');
                                $('#transfer-content').text(`PAY ${paymentData.EirNo}`);
                                $('#control-buttons').show();
                                $('#payment-status').show();
                                this.startCountdownExpire(this.formatDateTime(QrCode.data.expired_time))
                                this.connectSocket();
                                if(port) {
                                    $('#modal_device').addClass('open');
                                }
                            }
                    }
                }).catch((err) => {
                    this.generateQRCode();
                })
            },
            bindEvents: function() {
                $('#check-payment').on('click', () => this.checkPaymentStatus());
                $('#cancel-payment').on('click', () => this.cancelPayment());
                $('#cancel-QR').on('click', () => this.cancelPayment());
                $('#print-qr').on('click', () => this.sendCommand('JUMP(1);').then((status) => {
                    if(status === 'Success') {
                         setTimeout(() => {
                            const formatted = new Intl.NumberFormat('vi-VN').format(paymentData.amount);
                                MBBankQRPage.sendCommand(`QBAR(0,${QR_CODE});SET_TXT(0,MBBANK);SET_TXT(1,STK: 84593827363);SET_TXT(2,${formatted});`).then((status) => {
                                    if(status === 'Success') {
                                        toastr.success('Thành công !');
                                        $('#modal_device').removeClass('open');
                                    }
                                }).catch((err) => {
                                    $('#modal_device').removeClass('open');
                                    this.handleError({title: 'Không thể kết nối tới thiết bị !', message: 'Vui lòng tải lại trang thanh toán'}, false)
                                })
                         }, 500);
                    }
                }).catch((err) => {
                    this.handleError({title: 'Không thể kết nối tới thiết bị !', message: 'Vui lòng tải lại trang thanh toán'}, false)
                }));
            },
            generateQRCode: function() {
                // Show loading state
                $('#qr-loading').show();
                // Step 1: Get access token directly from MB Bank API
                this.createPaymentOrderWithMBBank()
                    .then(orderResponse => {
                        this.handleOrderResponse(orderResponse);
                    })
                    .catch(error => {
                        this.handleError(error);
                    });
            },
            startCountdownExpire: function(expireTime) {
                const [date, time] = expireTime.split(" ");
                const [day, month, year] = date.split("-");
                const [hour, minute, second] = time.split(":");

                const expireDate = new Date(year, month - 1, day, hour, minute, second);
                expireDate.setSeconds(expireDate.getSeconds() - 1);

                function update() {
                    const now = new Date();
                    let diff = Math.floor((expireDate - now) / 1000); 

                    if (diff <= 0) {
                        this.handleError({title: 'QR hết hạn thanh toán !', message: 'Vui lòng thử lại'})
                        this.disconnected()
                        clearInterval(Timmer);
                        $('#expired-val').text("00:00");
                        return;
                    }
                    const minutes = Math.floor(diff / 60);
                    const seconds = diff % 60;
                    $('#expired-val').text(
                        `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`
                    );
                }
                update = update.bind(this);
                // update();
                Timmer = setInterval(update, 1000); 
            },
            clearSpecialChars: function(str) {
                return str.replace(/[^a-zA-Z0-9]/g, '')
            },
            createPaymentOrderWithMBBank: function() {
                return new Promise((resolve, reject) => {
                    // Get user's IP address
                    const formatchEir = this.clearSpecialChars(paymentData.EirNo);
                    const requestData = {
                        "amount": paymentData.amount.toString(),
                        "order_info": `PAY ${formatchEir}`,
                        "return_url": "",
                    };
                    $.ajax({
                        url: "<?= site_url(md5('Mbbank') . '/' . md5('createOrder')); ?>",
                        method: 'POST',
                        data: JSON.stringify(requestData),
                        timeout: 30000,
                        success: (response) => {
                            if(response.Status) {
                                resolve(response.Data)
                            }
                            else {
                                reject(response.error)
                            }
                        },
                        error: (xhr, status, error) => {
                            this.handleError({title: 'Lỗi đường truyền từ Mbbank !', message: 'Vui lòng liên hệ quản trị viên'})
                        }
                    });
                });
            },

            handleOrderResponse: function(Data) {
                    $('#qr-loading').hide();
                    $('#qr-image').attr('src', Data.qr_url);
                    QR_CODE = Data.qr_info
                    $('#qr-content').show();
                    paymentData.orderReferenceId = Data.order_reference
                    // Update account info
                    $('#account-info').show();
                    $('#account-info').show();
                    $('#account-no').text('899977799979');
                    $('#account-name').text('CANG SP ITC');
                    $('#transfer-content').text(`PAY ${paymentData.EirNo}`);
                    $('#control-buttons').show();
                    $('#payment-status').show();
                    this.connectSocket();
                    if(port) {
                        $('#modal_device').addClass('open');
                        }
                    this.startCountdownExpire(Data.expire_time)
                    toastr.success(
                        'QR Code generated successfully! Please scan with MB Bank app or click "Mở trang thanh toán" to open payment page.'
                    );
            },
            handleError: function(error, refresh = true) {
                $('#modal_device').removeClass('open');
                $('#qr-loading').hide();
                $('#qr-content').hide();
                $('#control-buttons').hide();
                $('#payment-status').hide();
                let errorMsg = error.message || 'Unknown error occurred';
                let errorTitle = error.title || 'Unknown error occurred';
                let errorDetails = '';
                $('#qr-error').html(`
                <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                <h5 class="mt-3">${errorTitle}</h5>
                <p class="text-muted">${errorMsg}</p>
                ${errorDetails}
                <div class="mt-3" style="display: ${refresh ? 'block' : 'none'};">
                    <button type="button" class="btn btn-warning btn-custom" onclick="MBBankQRPage.refreshQRCode()">
                        <i class="fa fa-refresh"></i> Thử lại
                    </button>
                </div>
            `).show();
                toastr.error(`QR Generation Failed: ${errorTitle}`);
            },
            handleSucess: function() {
                clearInterval(Timmer);
                $('#qr-loading').hide();
                $('#qr-content').hide();
                $('#control-buttons').hide();
                $('#payment-status').hide();
                $('#qr-error').html(`
                <i class="fa fa-check-circle fa-3x text-success"></i>
                <h5 class="mt-3" style="color: #00ab3e;">Thành công</h5>
                    <p class="text-muted">Đơn hàng đã được thanh toán</p>
                <div class="mt-3">
                    <button type="button" class="btn btn-success" onclick="MBBankQRPage.handleClickPaySuccess()">
                        Tiếp tục
                    </button>
                    <button type="button" class="btn btn-danger" onclick="MBBankQRPage.cancelPayment()">
                        Thoát
                    </button>
                </div>
            `).show();
            },
            formatDateTime: function(dateString) {
                 const d = new Date(dateString);
                    const pad = (n) => n.toString().padStart(2, '0');
                    const day = pad(d.getDate());
                    const month = pad(d.getMonth() + 1); // tháng tính từ 0
                    const year = d.getFullYear();
                    const hours = pad(d.getHours());
                    const minutes = pad(d.getMinutes());
                    const seconds = pad(d.getSeconds());
                    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
            },
            refreshQRCode: function() {
                $('#qr-content').hide();
                $('#qr-error').hide();
                $('#qr-loading').show();
                // this.connectSocket();
                this.generateQRCode();
            },
            
            checkPaymentStatus: function() {
                const orderReference = paymentData.orderReferenceId;
                if (!orderReference) {
                    toastr.error('No transaction information available');
                    return;
                }
                this.checkStatusWithMBBank(orderReference);
            },
            checkStatusWithMBBank: async function(orderReference, silentMode = false) {
                try {
                    // Prepare the status check request data
                    const requestData = {
                        order_reference: orderReference,
                    };
                    // Call MB Bank status check API
                    const response = await $.ajax({
                        url: "<?= site_url(md5('Mbbank') . '/' . md5('checkStatusWithMbbank')); ?>",
                        method: 'POST',
                        data: JSON.stringify(requestData),
                        timeout: 30000
                    });
                    if(response.Status === 'PAID') {
                        this.handleSucess();
                            toastr.success('Thanh toán thành công !', {
                                timeOut: 3000
                            });
                            if(port) {
                            this.sendCommand('JUMP(2);').then((status) => {}).catch((err) => {
                                    toastr.error('Thỗi khi thông báo trên thiết bị !', {
                                        timeOut: 3000
                                    });
                                })
                            }
                                return;
                    }
                    else if(response.Status === 'ERROR') {
                            clearInterval(Timmer);
                            this.handleError({title: 'Hệ thống Mbbank không phản hồi !', message: 'Vui lòng liên hệ quản trị viên'}, false)
                    }
                    else {
                        toastr.success('Đang chờ thanh toán !', {
                                timeOut: 3000
                        });
                        if(silentMode) {
                            this.handleError({title: 'Dữ liệu không hợp lệ !', message: 'Vui lòng liên hệ quản trị viên'}, false)
                        }
                        return
                    }
                } 
                catch (error) {
                 this.handleError({title: 'Lỗi khi kiểm tra đơn hàng !', message:'Vui lòng liên hệ quản trị viên'}, false)
                }
            },
            handleClickPaySuccess: function() {
                if (window.opener.onPaymentSuccess) {
                        window.opener.onPaymentSuccess({
                                EirNo: paymentData.EirNo,
                            });
                        }
                        },
            cancelPayment: function() {
                $.confirm({
						title: 'Cảnh báo!',
						type: 'orange',
						icon: 'fa fa-warning',
						content: `Bạn có chắc chắn muốn thoát trang này!`,
						buttons: {
							ok: {
								text: 'Tiếp tục',
								btnClass: 'btn-primary',
								keys: ['Enter'],
								action: function() {
                                    if(port) {
                                        MBBankQRPage.sendCommand('JUMP(0);').then((status) => {}).catch((err) => {console.log(err)})
                                    }
                                    window.close();
								}
							},
							cancel: {
								text: 'Hủy bỏ',
								btnClass: 'btn-default',
								keys: ['ESC'],
							}
						}
					});
            },
            checkPaymentQR: function(EirNo) {
                return new Promise((resolve, reject) => {
                $.ajax({
                    url: "<?= site_url(md5('Mbbank') . '/' . md5('checkPayment')); ?>",
                    type: 'GET',
                    contentType: 'application/json',
                    data: {
                        EirNo: EirNo
                    },
                    dataType: 'json',
                    timeout: 10000,
                    success: (response) => {
                         if (response.success) {
                           resolve(response)
                        }
                        else {
                        reject('Fail')
                        }
                    },
                    error: (xhr, status, error) => {
                        reject('Fail',error)
                    }
                });
                })
            },
            connectDevice: function() {
                return new Promise(async (resolve, reject) => {
            try {
            // Nếu đã có port thì dùng lại (không cần request lại)
            if (!port) {
                const existingPorts = await navigator.serial.getPorts();
                if (existingPorts.length > 0) {
                    port = existingPorts[0];
                } else {
                    // Nếu chưa có port nào → yêu cầu user chọn
                    port = await navigator.serial.requestPort();
                }
            }
            await port.open({ baudRate: PortNumber });
            resolve("Success");
                } catch (error) {
                    reject(error);
                }
            });
            },
            sendCommand: function(command) {
                return new Promise( async (resolve, reject) => {
                      if (!command) {
                        return;
                        }
                        try {
                            const encoder = new TextEncoder();
                            const writer = port.writable.getWriter();
                            await writer.write(encoder.encode(command + '\r\n'));
                            writer.releaseLock();
                            resolve('Success')
                        } catch (error) {
                            reject(error)
                        }
                        })
            },
            checkConnectDevice: async function() {
                return new Promise((resolve, reject) => {
                        $.confirm({
						title: 'Thông báo!',
						type: 'green',
						icon: 'fa fa-success',
						content: `Vui lòng chọn thiết bị !`,
						buttons: {
							ok: {
								text: 'Chọn thiết bị',
								btnClass: 'btn-success',
								keys: ['Enter'],
								action: async function() {
                                    MBBankQRPage.connectDevice().then((status) => {
                                        if(status === 'Success') {
                                              toastr.success('Kết nối tới thiết bị thành công !', {
                                                        timeOut: 3000
                                                    });
                                                    resolve('Success')
                                        }
                                    }).catch((error) => {
                                        reject(error)
                                    })
								}
							},
							cancel: {
								text: 'Hủy bỏ',
								btnClass: 'btn-default',
								keys: ['ESC'],
                                action: function() {
                                        reject('Cancel')
                                }
							}
						}
					});
                })
            },
            connectSocket: function() {
            ws = new WebSocket("wss://billingtest.sp-itc.com.vn/ws"); //Production
            //  ws = new WebSocket("ws://localhost:8081/ws"); //DEV
                ws.onmessage = function(event) {
                    var data = JSON.parse(event.data);
                    if(data.Status === 'PAID') {
                        $(function(){
                            MBBankQRPage.handleSucess();
                            toastr.success('Thanh toán thành công !', {
                                timeOut: 3000
                            });      if(port) {
                                        MBBankQRPage.sendCommand('JUMP(2);').then((status) => {}).catch((err) => {
                                        toastr.error('Thỗi khi thông báo trên thiết bị !', {
                                        timeOut: 3000
                                    });
                                })
                            }
                            return;
                        });
                    }
                    else if (data.init === 'ConnectFail') {
                        MBBankQRPage.handleError({title: 'Đơn hàng đang được xử lý bởi người dùng khác !', message:'Vui lòng chọn đơn hàng mới'}, false)
                    }
                    else if (data.init === 'ConnectSuccess') {
                        console.log("WebSocket connected");
                    }
                    else if (data.init === 'Default') {
                        localStorage.setItem("PortNumber", 115200);
                    }
                    else if (data.init === 'Voice') {
                        localStorage.setItem("PortNumber", 9600);
                    }
                };
                ws.onopen = function(){
                    ws.send(JSON.stringify({
                        event: "init",
                        EirNo: paymentData.EirNo
                    }));
                };
            },
            disconnected: function() {
                if(ws) {
                    ws.send(JSON.stringify({
                        event: "logout",
                        EirNo: paymentData.EirNo
                    }));
                }
            }
        };

        // Initialize when document ready
        $(document).ready(function() {
        if (window.opener) {
            if(paymentData.amount === 0) {
                MBBankQRPage.handleError({title: 'Số tiền thanh toán không hợp lệ !', message:'Vui lòng thử lại'}, false)
                return;
            }
             MBBankQRPage.connectDevice().then((status) => {
                                        MBBankQRPage.init();
                        }).catch((err) => {
                            port = null
                            MBBankQRPage.checkConnectDevice().then(() => {
                                        MBBankQRPage.init();
                            }).catch(() => {
                                        MBBankQRPage.init();
                                        toastr.error('Không tìm thấy thiết bị !', {
                                        timeOut: 3000
                                    });
                            })
                        });
              window.onbeforeunload = function () {
                        MBBankQRPage.sendCommand('JUMP(0);').then((status) => {
                                        if(status === 'Success') {
                                            window.close();
                                        }
                                    }).catch((err) => {
                                        console.log(err)
                                    })
                        MBBankQRPage.disconnected();
            if (window.opener && !window.opener.closed) {
                                window.opener.onPaymentClosed();
            }
                        };
                            }
                            else {
                                alert('Truy cập không hợp lệ !')
                                MBBankQRPage.handleError({title: 'Truy cập không hợp lệ !', message:'Vui lòng thử lại'}, false)
                            }
        });
    </script>
</body>

</html>
