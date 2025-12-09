<?php
defined('BASEPATH') OR exit('');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet">

<style>
    .btn-modify {
        padding: 2px 7px 2px 7px;
        float: right;
        margin-left: 5px;
    }

</style>

<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="btn-group pull-right m-t-15">
            <button id="add" type="button" class="btn btn-custom waves-effect waves-light" data-toggle="modal" data-target="#user-modal" title="Thêm mới người dùng">Thêm</span></button>

        </div>
        <h4 class="page-title"><?=$title;?></h4>
    </div>
</div>

<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user-modalLabel">Thêm mới người dùng</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <fieldset class="form-group">
                        <img id="user-avatar" src="<?=base_url('assets/images/users/noavatar.png');?>" onerror="this.src='<?=base_url('assets/images/users/noavatar.png');?>';" style="width: 70px; height: 65px; border: solid wheat; margin: 0 20px">
                        <a onclick="change_ava()" class="linked">Đổi ảnh đại diện</a> <input type="file" id="change-ava" style="display: none;" accept="image/x-png,image/gif,image/jpeg, image/jpg">
                    </fieldset>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6">
                        <fieldset class="form-group">
                            <label for="Username">Tên đăng nhập</label>
                            <input type="text" class="form-control" require="" id="username" name="username" placeholder="Tên đăng nhập">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="FullName">Họ và Tên</label>
                            <input type="text" class="form-control" require="" id="fullname" name="fullname" placeholder="Họ và Tên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="Email">Email address</label>
                            <input type="email" class="form-control" require="" id="email" pattern=".{3,}" name="email" placeholder="Email">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" require="" id="password" name="password" placeholder="Mật khẩu" autocomplete="off" readonly
                                   onfocus="this.removeAttribute('readonly');">
                        </fieldset>
                        <button type="button" id="submit" class="btn btn-primary">Lưu</button>
                    </div><!-- end col -->

                    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-xl-6 m-t-sm-40">
                        <fieldset class="form-group">
                            <label for="Address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="FullName">Số điện thoại</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Số điện thoại">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="Email">Ngày sinh</label>
                            <input type="text" name="birthday" class="form-control" id="birthday" placeholder="mm/dd/yyyy">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="exampleSelect1">Nhóm</label>
                            <button id="delete-group" type="button" class="btn btn-danger waves-effect waves-light btn-modify" title="Xóa nhóm">
                                <i class="ion-android-close"></i>
                            </button>
                            <button id="edit-group" type="button" class="btn btn-warning waves-effect waves-light btn-modify" title="Sửa nhóm" data-toggle="modal" data-target="#groups-modal" data-whatever="edit">
                                <i class="ion-edit"></i>
                            </button>
                            <button id="add-group" type="button" class="btn btn-success waves-effect waves-light btn-modify" title="Thêm nhóm mới" data-toggle="modal" data-target="#groups-modal" data-whatever="add">
                                <i class="ion-android-add"></i>
                            </button>

                            <select class="form-control" id="group" require="">
                                <option value="0">---</option>
                                <?php foreach($groups as $group) { ?>
                                    <option value="<?=$group['GroupID'];?>"><?=$group['GroupName'];?></option>
                                <?php } ?>
                            </select>
                        </fieldset>

                        <input type="text" id="action" value="add" style="display: none;"/>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="groups-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="groups-modalLabel">Thêm mới nhóm</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-inline">
                        <label for="group-name" class="form-control-label">Tên Nhóm:</label>
                        <input type="text" class="form-control" id="group-id" style="display: none;">
                        <input type="text" class="form-control" id="act" style="display: none;">
                        <input type="text" class="form-control" id="group-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-group" onclick="save_group(id)" class="btn btn-primary" data-dismiss="modal">Lưu</button>
                <button type="button" id="save-new-group" onclick="save_group(id)" class="btn btn-primary">Lưu và Thêm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive" style="background-color: #FFFFFF">
            <table id="datatable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="border-collapse: collapse!important;width: 99.8%">
                <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ và Tên</th>
                    <th>Địa chỉ Email</th>
                    <th style="width: 70px;">Thuộc nhóm</th>
                    <th>Ngày sinh</th>
                    <th style="width: 70px;">Trạng thái</th>
                    <th style="width: 80px;"></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($users as $user) { ?>
                    <tr>
                        <td><?=$user['UserName'];?></td>
                        <td><?=$user['FullName'];?></td>
                        <td><?=$user['Email'];?></td>
                        <td><?=$user['GroupName'];?></td>
                        <td><?=substr($user['BirthDay'], 0, 10);?></td>
                        <td><input value="<?=$user['UserID'];?>" type="checkbox" <?=($user['IsActive'] == '1') ? 'checked="checked"' : '';?> data-plugin="switchery" data-color="#3db9dc"/></td>
                        <td>
                            <button type="button" onClick="edit(<?=$user['UserID'];?>)" class="btn btn-info btn-sm waves-effect waves-light" data-toggle="modal" data-target="#user-modal" title="Hiệu chỉnh người dùng">Sửa</button>&emsp;
                            <button type="button" onClick="del(<?=$user['UserID'];?>, '<?=$user['UserName'];?>')" class="btn btn-danger btn-sm waves-effect waves-light">Xoá</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- end row -->

<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script>

    $('#datatable').find('.switchery').click(function() {
        var tmp = $(this).parent().find('input');
        var formData = {
            'userid' : $(this).parent().find('input').val(),
            'isactive' : $(this).parent().find('input').is(':checked') ? 'true' : 'false',
            'action' : 'edit',
            'update' : 'status'
        };

        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.success) {
                    toastr["success"](data.success);
                    return;
                }
                if(data.deny) {
                    if(tmp[0].checked) {
                        tmp[0].checked = false;
                        onChange(tmp[0]);
                    } else {
                        tmp[0].checked = true;
                        onChange(tmp[0]);
                    }
                    toastr["error"](data.deny);
                }
            }
        });
    });

    function change_ava(){
        $('#change-ava').trigger("click");
    }
    $('#change-ava').on("change", function (e) {

        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#user-avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#user-avatar').attr('src', "<?=base_url('/assets/images/users/noavatar.png')?>");
        }
    });
</script>

<script>
    $(document).ready(function () {
        // Date Picker
        jQuery('#birthday').datepicker({
            autoclose: true
        });

        var table = $('#datatable').DataTable({scrollY: '51vh'});
        table.columns.adjust();

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
    });

    $('#delete-group').on('click', function () {
        if($('select#group').val() == "0"){
            return;
        }
        var formData = {
            'groupid' : $('select#group').val(),
            'type' : 'delGrp'
        };
        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.deny) {
                    toastr["error"](data.deny);
                    return;
                }
                if(data.message) {
                    $("select#group option[value='" + formData.groupid + "']").remove();
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
    $('#groups-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        var act = button.data('whatever');
        if(act == 'edit'){
            if($('select#group').val() == "0"){
                event.preventDefault();
                return;
            }
            modal.find('.modal-body #group-name').val($('select#group').find('option:selected').text());
            modal.find('.modal-body #group-id').val($('select#group').val());
        }else{
            modal.find('.modal-body #group-name').val('');
            modal.find('.modal-body #group-id').val('');
        }

        modal.find('.modal-title').text(button.attr('title'));
        modal.find('.modal-body #act').val(act);
    });

    $('#user-modal').on('show.bs.modal', function (event) {
        $(this).find('.modal-title').text($(event.relatedTarget).attr('title'));

        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    $('#add').click(function() {
        clearValidate();
        $('#user-avatar').attr('src', '');
        $('input.form-control').val('');
        $('#password').attr('require', "");
        $("#group option[value='0']").prop('selected', true);
        $('#username').prop('readOnly', false);
        var action = $('#action').val('add');
    });

    $('#username').on('input', function () {
        $(this).removeClass('error');
    });

    $('#submit').click(function() {
        var checkError = validate();

        if(checkError.length > 0) {
            return;
        }

        var username = $('#username').val();
        var password = $('#password').val();
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var telephone = $('#telephone').val();
        var birthday = $('#birthday').val();
        var groupid = $('#group').val();
        var userava = $('#user-avatar').attr("src");

        var action = $('#action').val();

        var formData = {
            'username' : username,
            'password' : password,
            'fullname' : fullname,
            'email' : email,
            'address' : address,
            'telephone' : telephone,
            'birthday' : birthday,
            'groupid' : groupid,
            'userava' : userava,
            'action' : action
        };

        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.deny) {
                    toastr["error"](data.deny);
                    return;
                }
                if(data.duplicated){
                    toastr["error"](data.duplicated);
                    $('#username').addClass('error');
                    return;
                }
                if(data.message) {
                    alert(data.message);
                    location.reload();
                }
            }
        });

        $('#action').val('add');
    });

    function edit(id) {
        clearValidate();
        $('input#action').val('edit');
        $('#password').removeAttr('require');
        $('#username').prop('readOnly', true);
        var formData = {
            'userid' : id,
            'action': 'edit'
        };

        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.deny) {
                    toastr["error"](data.deny);
                }
                if(!data.deny) {
                    $('#username').val(data.UserName);
                    $('#fullname').val(data.FullName);
                    $('#telephone').val(data.Telephone);
                    $('#address').val(data.Address);
                    $('#email').val(data.Email);
                    $('#birthday').val(getDateTime(data.BirthDay));
                    $('#user-avatar').attr("src", '<?= base_url("assets/images/users/")?>'+ data.UserName + '.jpg');
                    $("#group option[value='" + data.GroupID + "']").prop('selected', true);
                }
            }
        });
    }

    function del(userid, username) {
        var formData = {
            'userid' : userid,
            'username' : username,
            'action': 'delete'
        };

        if(confirm("Bạn có chắc xoá người dùng ngày không ?")) {
            $.ajax({
                url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    if(data.message) {
                        toastr["success"](data.message);
                        location.reload();
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }
    }

    function validate() {
        var checkError = [];
        var datas = $('[require=""]');
        $.each(datas, function(key, data) {
            $(data).removeClass('error');
            if(data.attributes['require'] && (!data.value || data.value == '0')) {
                $(data).addClass('error');
                checkError.push('error');
            }
        });
        return checkError;
    }

    function clearValidate() {
        var datas = $('[require=""]');
        $.each(datas, function(key, data) {
            $(data).removeClass('error');
        });
    }

    function onChange(el) {
        if (typeof Event === 'function' || !document.fireEvent) {
            var event = document.createEvent('HTMLEvents');
            event.initEvent('change', true, true);
            el.dispatchEvent(event);
        } else {
            el.fireEvent('onchange');
        }
    }

    function save_group(id) {
        var formData = {
            'groupname' :  $('#group-name').val(),
            'groupid' :  $('#group-id').val(),
            'action' : $('#act').val(),
            'type' : 'grp'
        };
        $.ajax({
            url: "<?=site_url(md5('user') . '/' . md5('users'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                if(data.deny) {
                    toastr["error"](data.deny);
                    return;
                }
                if(data.message) {
                    $('#groups-modal').find('.modal-body #group-name').val('');
                    $('#groups-modal').find('.modal-body #group-id').val('');
                    if(formData.action == 'add'){
                        $('select#group').append("<option selected value='"+ formData.groupid +"'>" + formData.groupname +"</option>");
                    }else{
                        $("select#group option[value='" + formData.groupid + "']").text(formData.groupname);
                    }

                    if(id == "save-new-group"){
                        $('#groups-modal').find('.modal-body #act').val('add');
                    }
                }
            },
            error: function (err) {
                console.log(err);
            }
        });
    }


</script>
