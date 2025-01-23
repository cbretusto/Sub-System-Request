const UserManagementGetRapidxUserActiveInSystemOne = (element) => {
    let result = '';
    const ajaxGetRapidxUser = {
        url: 'get_rapidx_user_active_in_systemone',
        method: 'GET',
        successCallback: (response) => {
            let rapidxNameActiveInSystemone = response['rapidxNameActiveInSystemone']

            if(rapidxNameActiveInSystemone.length > 0){
                result += '<option value="" disabled selected>Select Employee Name</option>';
                for(let index = 0; index < rapidxNameActiveInSystemone.length; index++){
                    if(rapidxNameActiveInSystemone[index].rapidx_systemone_employee_info != null || rapidxNameActiveInSystemone[index].rapidx_systemone_subcon_info != null){
                        result += '<option value="' + rapidxNameActiveInSystemone[index].id + '">' + rapidxNameActiveInSystemone[index].name + '</option>';
                    }
                }
            }
            else{
                result += '<option value="" disabled>Not found</option>';
            }
            element.html(result);
        },
        errorCallback: () => {
            result = '<option value="" disabled>Reload Again</option>';
        }
    };
    ajaxRequest(ajaxGetRapidxUser);
}

const UserManagementGetSystemOneDepartment = (element) => {
    let result = '';
    const ajaxGetSystemOneDepartment = {
        url: 'get_systemone_department',
        method: 'GET',
        successCallback: (response) => {
            let systemoneDepartment = response['systemoneDepartment']
            if(systemoneDepartment.length > 0){
                result += '<option value="" disabled selected>----</option>';
                for(let index = 0; index < systemoneDepartment.length; index++){
                    result += '<option value="' + systemoneDepartment[index].pkid + '">' + systemoneDepartment[index].Department + '</option>';
                }
            }
            else{
                result += '<option value="" disabled>Not found</option>';
            }
            element.html(result);
        },
        errorCallback: () => {
            result = '<option value="" disabled>Reload Again</option>';
        }
    };
    ajaxRequest(ajaxGetSystemOneDepartment);
}

const UserManagementGetSystemOnePosition = (element) => {
    let result = '';
    const ajaxGetSystemOnePosition = {
        url: 'get_systemone_position',
        method: 'GET',
        successCallback: (response) => {
            
            if(response['systemonePosition'].length > 0){
                result += '<option value="" disabled selected>----</option>';
                for(let index = 0; index < response['systemonePosition'].length; index++){
                    result += '<option value="' + response['systemonePosition'][index].pkid + '">' + response['systemonePosition'][index].Position + '</option>';
                }
            }
            else{
                result += '<option value="" disabled>Not found</option>';
            }
            element.html(result);
        },
        errorCallback: () => {
            result = '<option value="" disabled>Reload Again</option>';
        }
    };
    ajaxRequest(ajaxGetSystemOnePosition);
}

function UserManagementUserCreateUpdate() {
    const ajaxUserCreateUpdate = {
        url: "user_create_update",
        method: "POST",
        data: $('#formUserManagement').serialize(),
        dataType: "json",
        beforeSendCallback: function(xhr) {
            $("#iBtnUserManagementIcon").addClass('spinner-border spinner-border-sm');
            $("#btnUserManagement").addClass('disabled');
            $("#iBtnUserManagementIcon").removeClass('fa fa-check');
        },
        successCallback: (response) => {
            if (response['validationHasError'] == 1) {
                toastr.error('Saving user failed!');
            }else if(response['hasError'] == 0) {
                $('#modalUserManagementCreateUpdate').modal('hide');
                toastr.success('Successfully saved!');
                dataTableUser.draw();
            }else{
                toastr.error('User already exist!');
                $('#modalUserManagementCreateUpdate').modal('hide');
            }
            $("#iBtnUserManagementIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnUserManagement").removeClass('disabled');
            $("#iBtnUserManagementIcon").addClass('fa fa-check');
        },
        errorCallback: () => {
            toastr.error('An error occurred while processing your request.');
        }
    };

    ajaxRequest(ajaxUserCreateUpdate);
}

function UserManagementGetUserInfoByIdToEdit(UserId){
    const ajaxGetUserByIdToEdit = {
        url: 'get_user_info_by_id',
        method: 'GET',
        data: {
            UserId: UserId
        },
        successCallback: (response) => {
            let subsystemRequestUserInfo = response['subsystemRequestUserInfo']
            if(subsystemRequestUserInfo.length > 0){
                $("#slctEmployeeName").val(subsystemRequestUserInfo[0].rapidx_user_id).trigger('change');
                $("#slctUserLevel").val(subsystemRequestUserInfo[0].user_level).trigger('change');
                $("#slctEmployeeDepartment").val(subsystemRequestUserInfo[0].department).trigger('change');
                $("#slctEmployeePosition").val(subsystemRequestUserInfo[0].position).trigger('change');
            }        
        },
        errorCallback: () => {
            
        }
    };
    ajaxRequest(ajaxGetUserByIdToEdit);
}

function UserManagementChangeUserStatus(){
    const ajaxChangeUserStatus = {
        url: 'change_user_status',
        method: "POST",
        data: $('#formUserManagementChangeUserStatus').serialize(),
        dataType: "json",
        beforeSendCallback: function(xhr) {
            $("#iBtnUserManagementChangeUserStatusIcon").addClass('spinner-border spinner-border-sm');
            $("#btnUserManagementChangeUserStatus").addClass('disabled');
            $("#iBtnUserManagementChangeUserStatusIcon").removeClass('fa fa-check');
        },
        successCallback: (response) => {
            if(response['hasError'] == 0){
                if($("#txtUserManagementChangeUserStatus").val() == 0){
                    toastr.success('User activation success!');
                    $("#txtUserManagementChangeUserStatus").val() == 1;
                }
                else{
                    toastr.success('User deactivation success!');
                    $("#txtUserManagementChangeUserStatus").val() == 0;
                }
                $('#modalUserManagementChangeUserStatus').modal('hide');
                resetModalFormValues('modalUserManagementChangeUserStatus', 'formUserManagementChangeUserStatus');
                dataTableUser.draw();
            }
            $("#iBtnUserManagementChangeUserStatusIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnUserManagementChangeUserStatus").removeClass('disabled');
            $("#iBtnUserManagementChangeUserStatusIcon").addClass('fa fa-check');
        },
        errorCallback: () => {
            toastr.error('An error occurred while processing your request.');
        }
    };
    ajaxRequest(ajaxChangeUserStatus);
}

function VerifyUser(loginEmployeeId){
    const ajaxGetUserLog = {
        url: 'get_user_log',
        method: 'GET',
        data: {
            loginEmployeeId: loginEmployeeId
        },
        successCallback: (response) => {
            let getUserLogInfo = response['getUserLogInfo']
            console.log('getUserLogInfo: ', getUserLogInfo);
            if(getUserLogInfo.length > 0){
                if(getUserLogInfo[0].subsystem_user_info != null){
                    console.log('SUBSYSTEM USER:');
                    $('.button-hide').removeClass('d-none');
                }
            }        
        },
        errorCallback: () => {

        }
    };
    ajaxRequest(ajaxGetUserLog);
}

