<?php
defined('BASEPATH') OR exit('');
?>

<!-- DataTables -->
<link href="<?=base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
<link href="<?=base_url('assets/plugins/datatables/buttons.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?=base_url('assets/plugins/datatables/responsive.bootstrap4.min.css');?>" rel="stylesheet" type="text/css" />
<!-- JQuery UI CSS-->
<link href="<?=base_url('assets/plugins/jquery-ui/jquery-ui.min.css');?>" rel="stylesheet" type="text/css" />
<!-- Switchery css -->
<link href="<?=base_url('assets/plugins/switchery/switchery.min.css');?>" rel="stylesheet" />
<!-- Notification css (Toastr) -->
<link href="<?=base_url('assets/plugins/toastr/toastr.min.css');?>" rel="stylesheet" type="text/css" />

<style>
    #permission {
        disable: none;
    }

    #adv_permission_popup {
        width: 300px;
        height: auto;
        display: none;
    }
</style>

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title"><?=$title;?></h4>
    </div>
</div>

<div class="row" id="add_edit">
    <div class="col-sm-12">
        <div class="card-box" style="background-color: #FFFFFF">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                    <fieldset class="form-group">
                        <label for="exampleSelect1">Nhóm</label>
                        <select class="form-control" id="groupid">
                            <option value="0">---</option>

                            <?php if( isset( $groups ) && count( $groups ) > 0 ){ ?>
                                <?php foreach($groups as $group) { ?>
                                    <option value="<?=$group['GroupID'];?>"><?=$group['GroupName'];?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </fieldset>
                    <fieldset class="form-group" id="show_cpl" style="display: none">
                        Chọn tất cả:&emsp;&emsp;&emsp;<input id="checkall" type="checkbox"/>&emsp;&emsp;&emsp;
                        <button type="button" id="submit" class="btn btn-primary">Hoàn tất</button>
                    </fieldset>
                </div><!-- end col -->

                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6 m-t-sm-40">
                    <fieldset class="form-group">
                        <label for="active">Người dùng</label>
                        <select class="form-control" id="userid">
                            <option value="0">---</option>
                        </select>
                    </fieldset>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

<?php foreach($menus as $menu) {  ?>
    <div class="row lv1" id="permission" style="display: none;">
        <div class="col-sm-12">
            <h4 class="page-title"><?=$menu['MenuName'];?></h4>
        </div>
    </div>
    <?php if($menu['MenuID'] == 'Message_exchange'){  ?>
        <div class="lv2" id="dt_permission" style="display: none">
            <?php foreach($menu['submenu'] as $sub) { ?>
                <div class="row lv3" id="dt_permission" style="display: none;">
                    <div class="col-sm-12">
<!--                        <h5 class="page-title">--><?//=$sub['MenuName'];?><!--</h5>-->
                        <input id="<?=$sub['MenuID'];?>" type="checkbox" data-plugin="switchery" data-color="#3db9dc"/>&emsp;<span class="page-title" id="<?=$sub['MenuID'];?>"><?=$sub['MenuName'];?></span>

                    </div>
                </div>
                <div class="row lv4" id="dt_permission" style="display: none">
                    <?php foreach($sub['subsubmenu'] as $submn) { ?>
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <input id="<?=$submn['MenuID'];?>" type="checkbox" data-plugin="switchery" data-color="#3db9dc"/>&emsp;<span class="text-muted show_advper" id="<?=$submn['MenuID'];?>"><?=$submn['MenuName'];?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php  } ?>
        </div>
    <?php } else { ?>
        <div class="row lv2" id="dt_permission" style="display: none">
            <?php foreach($menu['submenu'] as $submn) { ?>
                <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                    <div class="card-box tilebox-one">
                        <input id="<?=$submn['MenuID'];?>" type="checkbox" data-plugin="switchery" data-color="#3db9dc"/>&emsp;<span class="text-muted show_advper" id="<?=$submn['MenuID'];?>"><?=$submn['MenuName'];?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php } }?>

<div id="adv_permission_popup">
    <table width="100%" align="center" class="tbl_check">
        <tr>
            <td colspan="5"><label id="pd"></label></td>
        </tr>
        <tr align="center" style="font-weight: bold">
            <td></td>
            <td>Thêm</td>
            <td>Sửa</td>
            <td>Xoá</td>
            <td>Gởi thông điệp</td>
        </tr>
        <tr align="center">
            <td><input id="all" type="checkbox" /></td>
            <td><input value="add" id="add" type="checkbox" /></td>
            <td><input value="edit" id="edit" type="checkbox" /></td>
            <td><input value="delete" id="delete" type="checkbox" /></td>
            <td><input value="sendmsg" id="sendmsg" type="checkbox" /></td>
        </tr>
        <tr align="center">
           <td colspan="5" align="center"><button type="button" class="btn btn-primary" id="accept_one">Hoàn tất</button></td>
        </tr>
    </table>
</div>


<!-- end row -->

<script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>"></script>
<!-- Required datatable js -->
<script src="<?=base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?=base_url('assets/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
<!-- Switchery -->
<script src="<?=base_url('assets/plugins/switchery/switchery.min.js');?>"></script>
<!-- JQuery UI -->
<script src="<?=base_url('assets/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
<!-- Toastr js -->
<script src="<?=base_url('assets/plugins/toastr/toastr.min.js');?>"></script>

<script>
    var checkall = document.querySelector('[id="checkall"]');
    var switchery = new Switchery(checkall);

    var elems = Array.prototype.slice.call(document.querySelectorAll('[data-plugin="switchery"]'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html, {size : 'small'});
    });
</script>

<script>

    $(document).find('#show_cpl').find('.switchery').on('click', function(event) {
        checkall.onchange = function () {
            if (checkall.checked) {
                if(!event.altKey) {
                    elems.forEach(function (data) {
                        data.checked = true;
                        onChange(data);
                    })
                }
            } else {
                if(!event.altKey) {
                    elems.forEach(function (data) {
                        data.checked = false;
                        onChange(data);
                    })
                }
            }
        };

    })

    $(document).ready(function() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "swing",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    })

    $('#adv_permission_popup').dialog({
        autoOpen : false,
        modal : true,
        show : "blind",
        hide : "blind"
    })

    $('.show_advper').click(function(e) {
        if($(this).parent().find('input').is(':checked')) {
            $('#adv_permission_popup').find('input[type="checkbox"]').prop('checked', false);
            $( "#adv_permission_popup" ).dialog("option", "position", {
                my: "center",
                at: "center",
                of: e,
                offset: "5 70"
            });

            $( "#adv_permission_popup").find('#pd').text($(this).text() + '_' +$(this).attr('id'));

            var groupid = $('#groupid').val();
            var userid = $('#userid').val();
            var menuid = $(this).attr("id");

            var formData = {
                'menuid' : menuid,
                'userid' : userid,
                'groupid' : groupid,
                'actions' : 'selectpermiss'
            };

            $.ajax({
                url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data) {
                        var permis = JSON.parse(data.PerDetail);
                        console.log(permis);
                        $.each(permis, function(key, check) {
                            $('.tbl_check').find('input[id="' + check + '"]').prop('checked', true);
                        })
                    }
                }
            });
            $( "#adv_permission_popup" ).dialog( "open" );
        }
    })

    $('.tbl_check').find('input[id="all"]').click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    })

    $('#accept_one').click(function() {
        var per_detail = [];
        var inputs = $('.tbl_check').find('input[type="checkbox"]:not(:first)');
        $.each(inputs, function(key, input) {
            if(input.checked) {
                per_detail.push(input.id);
            }
        })

        var groupid = $('#groupid').val();
        var userid = $('#userid').val();
        var stmt = $( "#adv_permission_popup").find('#pd').text();
        stmt = stmt.split("_");
        var menuid = stmt[1];

        var formData = {
            'userid' : userid,
            'groupid' : groupid,
            'per_detail' : per_detail,
            'menuid' : menuid,
            'actions' : 'acceptPermiss'
        };

        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.success) {
                    toastr["success"](data.success);
                }
            }
        });
        $('.tbl_check').find('input[type="checkbox"]').prop('checked', false);
        $("#adv_permission_popup").dialog("close");
    });

    $('#groupid').change(function() {
        $('#userid option:not(:first-child)').remove();

        var groupid = $('#groupid').val();
        elems.forEach(function(data) {
            data.checked = false;
            onChange(data);
        })
        checkall.checked = false;
        onChange(checkall);

        if(groupid != '0') {
            $('#show_cpl').show();
            $('div[id^="permission"]').show(100);
            $('div[id^="dt_permission"]').show(100);
            var formData = {
                'groupid' : groupid,
                'actions' : 'searchUsers'
            };

            $.ajax({
                url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (datas) {
                    if(datas.length > 0) {
                        $.each(datas, function(key, data) {
                            $('#userid').append(
                                '<option value=' + data.UserID + '>' + data.UserName + '  --  ' + data.FullName + '</option>' + "\n"
                            );
                        })
                    }
                }
            });

            var formData = {
                'groupid' : groupid,
                'actions' : 'searchPermiss'
            };

            $.ajax({
                url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (datas) {
                    if(datas.length > 0) {
                        $.each(datas, function(key, data) {
                            $('input[id="' + data.MenuID + '"]').prop('checked', true);
                            var active = document.querySelector('input[id="' + data.MenuID + '"]');

                            active.checked = true;
                            onChange(active);
                        })
                    }
                }
            });
        } else {
            $('#show_cpl').hide();
            $('div[id^="dt_permission"]').hide(100);
            $('div[id^="permission"]').hide(100);
        }
    })

    $('#userid').change(function() {
        elems.forEach(function(data) {
            data.checked = false;
            onChange(data);
        })

        var userid = $('#userid').val();
        if(userid != '0') {
            var formData = {
                'userid' : userid,
                'actions' : 'searchPermiss'
            };

            $.ajax({
                url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (datas) {
                    console.log(datas);
                    if(datas.length > 0) {
                        $.each(datas, function(key, data) {
                            $('input[id="' + data.MenuID + '"]').prop('checked', true);
                            //var active = document.querySelector('input[id="' + data.MenuID + '"]');
                            var active = $.find('input[id="' + data.MenuID + '"]');
                            $.each(active, function (key, data) {
                                data.checked = true;
                                onChange(data);
                            });
                        })
                    }
                }
            });
        } else {
            $('#groupid').trigger('change');
        }
    });

    $('#submit').click(function() {
        if(!confirm("Bạn có chắc thực hiện phân quyền này không ?")) {
            return;
        }
        var groupid = $('#groupid').val();
        var userid = $('#userid').val();

        var permis = [];
        elems.forEach(function(elem) {
            if(elem.checked) {
                permis.push(elem.id);
            }
        })

        var formData = {
            'userid' : userid,
            'groupid' : groupid,
            'checkall' : checkall.checked ? 'checkall' : '',
            'permiss' : permis,
            'actions' : 'acceptAllPermiss'
        };

        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('permission'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.success) {
                    toastr["success"](data.success);
                }
                $('.row').find("select option[value='0']").prop('selected', true);
                $('#groupid').trigger('change');
            }
        });

    })

    function onChange(el) {
        $('#adv_permission_popup').find('input[type="checkbox"]').prop('checked', false);
        if (typeof Event === 'function' || !document.fireEvent) {
            var event = document.createEvent('HTMLEvents');
            event.initEvent('change', true, true);
            el.dispatchEvent(event);
        } else {
            el.fireEvent('onchange');
        }
    }
</script>
