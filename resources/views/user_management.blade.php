@php
    session_start();
    $layout = 'layouts.layout';
    if(isset($_SESSION['subsystem_request_id'])){
        $layout = 'layouts.layout';
    }else{
        $layout = 'layouts.no_access';
    }
@endphp
@extends($layout)
@section('title', 'User Managemnet')
@section('content_page')
    <style type="text/css">
        table.table thead th{
            text-align: center;
            vertical-align: middle;
        }

        table.table tbody td{
            vertical-align: middle;
        }

        .input_hidden {
            position: absolute;
            opacity: 0;
        }

        .class-disabled{
            pointer-events: none;
        }
    </style>
    @php
        date_default_timezone_set('Asia/Manila');
    @endphp
    <div class="content-wrapper layout-fixed">
        <section class="content p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="margin-top: 8px;">User Management</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-dark button-hide d-none" id="buttonAddUser" data-bs-toggle="modal" data-bs-target="#modalUserManagementCreateUpdate">
                                        <i class="fa fa-plus fa-md"></i> New User
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table id="tableUserManagemnet" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Employee No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>User level</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add User Modal Start -->
    <div class="modal fade" id="modalUserManagementCreateUpdate" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;User information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formUserManagement" autocomplete="off">
                    @csrf
                    <div class="card-body p-3">
                        <input type="text" class="input_hidden" id="textUserId" name="user_id" placeholder="╭∩╮( •̀_•́ )╭∩╮" readonly>

                        <div class="row">
                            <div class="col-md-6 d-flex flex-column mb-3"> 
                                <label for="" class="form-label"><strong>Name</strong></label> 
                                <select class="form-select select2bs5 get-rapidx-user" id="slctEmployeeName"  name="name" required>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex flex-column mb-3">
                                <label for="" class="form-label"><strong>User Level</strong></label> 
                                <select class="form-select" id="slctUserLevel"  name="user_level" required>
                                    <option value="" selected disabled> Select User Level </option>
                                    <option value="0"> Admin </option>
                                    <option value="1"> User </option>
                                </select>
                            </div>

                            <div class="col-md-6 d-flex flex-column mb-3"> 
                                <label for="" class="form-label"><strong>Employee No.</strong></label> 
                                <input type="text" class="form-control class-disabled" id="txtEmployeeNo"  name="employee_no" placeholder="----" readonly required>
                            </div>

                            <div class="col-md-6 d-flex flex-column mb-3"> 
                                <label for="" class="form-label"><strong>Email</strong></label> 
                                <input type="text" class="form-control class-disabled" id="txtEmployeeEmail"  name="email" placeholder="----" readonly required>
                            </div>

                            <div class="col-md-6 d-flex flex-column mb-3"> 
                                <label for="" class="form-label"><strong>Department</strong></label> 
                                <select class="form-select get-systemone-department class-disabled" id="slctEmployeeDepartment"  name="department" required>
                                </select>
                            </div>

                            <div class="col-md-6 d-flex flex-column mb-3"> 
                                <label for="" class="form-label"><strong>Position</strong></label> 
                                <select class="form-select get-systemone-position class-disabled" id="slctEmployeePosition"  name="position" required>
                                </select>
                            </div>
                        </div> 
                    </div> 
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnUserManagement" class="btn btn-dark button-hide d-none"><i id="iBtnUserManagementIcon"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add User Modal End -->

    <!-- User Status Modal Start -->
    <div class="modal fade" id="modalUserManagementChangeUserStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="h4UserManagementChangeUserStatusTitle"><i class="fa fa-user"></i> Change Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formUserManagementChangeUserStatus" autocomplete="off">
                    @csrf
                    <div class="card-body p-3">
                        <label id="lblUserManagementChangeUserStatusLabel"></label>
                        <input type="text" class="input_hidden" name="user_id" placeholder="User Id" id="txtUserManagementChangeUserStatusId">
                        <input type="text" class="input_hidden" name="status" placeholder="Status" id="txtUserManagementChangeUserStatus">

                    </div> 
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnUserManagementChangeUserStatus" class="btn btn-dark button-hide d-none"><i id="iBtnUserManagementChangeUserStatusIcon"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- User Status Modal End -->
@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        let dataTableUser

        $(document).ready(function () {
            $('.select2bs5').select2({
                theme: 'bootstrap-5',
                dropdownAutoWidth: true,
                dropdownParent: $('#modalUserManagementCreateUpdate')
            })          
            
            UserManagementGetRapidxUserActiveInSystemOne($('.get-rapidx-user'));
            UserManagementGetSystemOneDepartment($('.get-systemone-department'));
            UserManagementGetSystemOnePosition($('.get-systemone-position'));

            dataTableUser = $("#tableUserManagemnet").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                "order": [[1,'desc'],[3, "asc"]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ User Record",
                    "lengthMenu": "Show _MENU_ User Record",
                },
                "ajax" : {
                    url: "view_user",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "status"},
                    { "data" : "user_management_rapidx_user_info.employee_number"},
                    { "data" : "user_management_rapidx_user_info.name"},
                    { "data" : "user_management_rapidx_user_info.email"},
                    { "data" : "user_management_systemone_department_info.Department"},
                    { "data" : "user_management_systemone_position_info.Position"},
                    { "data" : "user_level",
                        "defaultContent": 'N/A',
                        "name": 'user_level',
                        "orderable": true,
                        "searchable": true,
                        "render": function (data, type, row) {
                            if(row.user_level == 0){
                                return "Admin";
                            }else{
                                return "User";
                            }
                        },
                        // "createdCell": function (td, cellData, rowData, row, col) {
                        //     $(td).addClass('text-center');
                        // }
                    }
                ],
            });

            $('#slctEmployeeName').change(function (e) { 
                e.preventDefault();
                const ajaxSelectName = {
                    url: 'get_rapidx_user_active_in_systemone',
                    method: 'GET',
                    successCallback: (response) => {
                        let getDataById     = $(this).val()
                        let getDataByName   = response['rapidxNameActiveInSystemone']
                        let department      = ''
                        let position        = ''

                        if(getDataByName.length > 0){
                            for(let index = 0; index < getDataByName.length; index++){
                                if(getDataByName[index].id == getDataById){
                                    $('#txtEmployeeNo').val(getDataByName[index].employee_number)
                                    if(getDataByName[index].email != null){
                                        $('#txtEmployeeEmail').val(getDataByName[index].email)
                                    }else{
                                        $('#txtEmployeeEmail').val('N/A')
                                    }

                                    if(getDataByName[index].rapidx_systemone_employee_info != null){
                                        department  = getDataByName[index].rapidx_systemone_employee_info.fkDepartment
                                        position    = getDataByName[index].rapidx_systemone_employee_info.fkPosition
                                    }

                                    if(getDataByName[index].rapidx_systemone_subcon_info != null){
                                        department  = getDataByName[index].rapidx_systemone_subcon_info.fkDepartment
                                        position    = getDataByName[index].rapidx_systemone_subcon_info.fkPosition
                                    }

                                    $('#slctEmployeeDepartment').val(department).trigger('change')
                                    $('#slctEmployeePosition').val(position).trigger('change')
                                }
                            }
                        }
                    },
                    errorCallback: () => {

                    }
                };
                ajaxRequest(ajaxSelectName);
            });

            $("#formUserManagement").submit(function(event){
                event.preventDefault();
                UserManagementUserCreateUpdate();
            });

            $(document).on('click', '.actionUserManagementEdit', function(e){
                e.preventDefault();
                let UserId = $(this).attr('user-id'); 
                    $("#textUserId").val(UserId);
                    UserManagementGetUserInfoByIdToEdit(UserId); 
            });

            $(document).on('click', '.actionUserManagementChangeUserStatus', function(){
                let userStatus = $(this).attr('status');
                let userId = $(this).attr('user-id'); 
                $("#txtUserManagementChangeUserStatus").val(userStatus); 
                $("#txtUserManagementChangeUserStatusId").val(userId); 

                if(userStatus == 0){
                    $("#lblUserManagementChangeUserStatusLabel").text('Are you sure to activate?'); 
                    $("#h4UserManagementChangeUserStatusTitle").html('<i class="fa fa-user"></i> Activate User');
                }
                else{
                    $("#lblUserManagementChangeUserStatusLabel").text('Are you sure to deactivate?');
                    $("#h4UserManagementChangeUserStatusTitle").html('<i class="fa fa-user"></i> Deactivate User');
                }
            });

            $("#formUserManagementChangeUserStatus").submit(function(event){
                event.preventDefault();
                UserManagementChangeUserStatus();
            });

            resetModalFormValues('modalUserManagementCreateUpdate', 'formUserManagement');
        });
    </script>
@endsection
