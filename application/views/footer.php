<?php
defined('BASEPATH') OR exit('');
?>
        </div>
			<!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13" style="width: 100%; text-align:right">2018 © <b>C.E.H Software</b></div>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
    <input style="display: none" id="editor-input" />
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    
	<!-- CORE SCRIPTS-->
    <script src="<?=base_url('assets/js/app.min.js');?>"></script>

<script>
    var resizefunc = [];

    $.extend( true, $.fn.dataTable.defaults, {
        language: {
            info: "Số dòng: _TOTAL_",
            emptyTable: "------------ Không có dữ liệu hiển thị ------------",
            infoFiltered: "(trên _MAX_ dòng)",
            infoEmpty: "Số dòng: 0",
            search: '<span>Tìm:</span> _INPUT_',
            zeroRecords:    "------------ Không có dữ liệu được tìm thấy ------------",
            sThousands: ",",
            sDecimal: ".",
            // autoFill: {
            //     // fillHorizontal: 'Đổ dữ liệu theo dòng',
            //     // fillVertical: 'Đổ dữ liệu theo cột',
            //     // fill: b[0][0].label,
            //     // increment: 'Thay đổi tất cả các ô theo giá trị: <input type="number" value="1">',
            //     // cancel: 'Hủy bỏ',
            //     // button:'Go!'
            // },
            select: {
                rows: {
                    _: "Đã chọn %d dòng",
                    0: ""
                }
            }
        },
        search: {
            regex: true
        },
        info: true,
        orderClasses: false,
        paging: false,
        scrollY: 419,
        scrollX: true,
        lengthChange: false,
        scrollCollapse: false,
        deferRender: true,
        processing: true,
        autoWidth: true,
        dom: '<"datatable-header"fl<"datatable-info-right"Bip>><"datatable-scroll-wrap"t>',
        buttons: [{
                extend: 'selectAll',
                text: '<i class="fa fa-check-circle"></i>&ensp;Chọn tất cả',
                className: 'btn btn-sm btn-outline-secondary'
            },
            {
                extend: 'selectNone',
                text: '<i class="fa fa-ban"></i>&ensp;Bỏ chọn',
                className: 'btn btn-sm btn-outline-secondary'
            }
        ],
        destroy: true
    });

    $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
        return this.api().column(col, {
            order: 'index'
        }).nodes().map(function(td, i) {
            if( $(td).find('input[type="checkbox"]').length > 0 ){
                return $('input[type="checkbox"]', td).prop('checked') ? '1' : '0';
            }
            else {
                return $(td).closest('tr').hasClass('selected') ? '1' : '0';
            }
        });
    };
</script>
<script>
    $(document).ready(function () {
//        $('body').addClass('drawer-sidebar');

        $("a[href='"+ location.href +"']").addClass("active");
        $("a[href='"+ location.href +"']").parent().parent().parent().addClass("active");
        $("a[href='"+ location.href +"']").closest("ul.nav-2-level").addClass("collapse in");

        $('#sidebar-collapse').slimScroll({height:"100%",railOpacity:"0.9", color: '#fff'});
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "swing",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('a.nav-link.sidebar-toggler.js-sidebar-toggler').on('click', function () {
            setTimeout(function () {
                $('.dataTable tbody').closest('table').each(function (k, v) {
                    $(v).realign();
                });
            }, 250);
        });

        //remove class error when change value
        $(document).on('input', '.error input', function () {
            $(this).parent().removeClass('error');
        });

        $('[data-action="reloadUI"]').on('click', function (e) {
            var block = $(this).attr('data-reload-target');
            $(block).block({ 
                message: '<i class="la la-spinner spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait',
                    'box-shadow': '0 0 0 1px #ddd'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });

        // $(window).on("resize",function(){
        //     $('.dataTable tbody').closest('table').each(function (k, v) {
        //         $(v).realign();
        //     });
        // });
    });

    function autoLoadYearCombo(id){
        $("#"+id).find('option').remove();
        $("#"+id).selectpicker('refresh');
        var currentYear = (new Date()).getFullYear();
        for( let y = currentYear - 2; y <= currentYear + 4; y++ ) {
            $("#"+id).append('<option value="'+y+'">'+y+'</option>');
        }
        $("#"+id).val(currentYear);
        $("#"+id).selectpicker("refresh");
    }

    // $(function () {
    //     var ctrlIsPressed = false;
    //     $(document).keydown(function(event){
    //         if(event.which=="17")
    //             ctrlIsPressed = true;
    //     });

    //     $(document).keyup(function(){
    //         ctrlIsPressed = false;
    //     });

    //     var isMouseDown = false;
    //     var rIdx = -1;
    //     $('table').on('mousedown','tbody td',function (e) {
    //         if($(this).closest('table').hasClass('single-row-select') && e.which == 3){
    //             e.preventDefault();
    //             return;
    //         }
    //         if(e.which == 3) {
    //             isMouseDown = true;
    //             var a = $(this).parent().find("input[class='is-row-select'][type='checkbox']").first();
    //             if(a.length > 0){
    //                 a.trigger('click');
    //                 a.is(':checked') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }else{
    //                 if(!ctrlIsPressed && rIdx != $(this).parent().index()){
    //                     $(this).closest('table').find('tr').removeClass('m-row-selected');
    //                 }
    //                 !$(this).parent().hasClass('m-row-selected') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //                 rIdx = $(this).parent().index();
    //             }
    //         }
    //     }).on('mouseover','tbody td',function (e) {
    //         if($(this).closest('table').hasClass('single-row-select')){
    //             e.preventDefault();
    //             return;
    //         }
    //         if(isMouseDown) {
    //             var a = $(this).parent().find("input[class='is-row-select'][type='checkbox']").first();
    //             if(a.length > 0){
    //                 a.trigger('click');
    //                 a.is(':checked') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }else{
    //                 !$(this).parent().hasClass('m-row-selected') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }
    //         }
    //     });

    //     $(document).mouseup(function () {
    //         isMouseDown = false;
    //     });

    //     $("table").on('contextmenu', function (e) {
    //         e.preventDefault();
    //     });
    // });
</script>

<script>
    $.blockUI.defaults.fadeIn = 0;
    $.blockUI.defaults.onBlock = function() {
        let blockEl = $('.blockUI:first').parent();
        if(blockEl && blockEl.find('button').length > 0) {
            blockEl.find('button').prop('disabled', true);
        }
    }

    $.blockUI.defaults.onUnblock = function(element, options) {
        if(element && $(element).find('button').length > 0) {
            $(element).find('button').prop('disabled', false);
        }
    }
    
</script>

</body>
</html>