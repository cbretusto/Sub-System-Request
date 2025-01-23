function SubSystemPoReceivedCategoryCreateUpdate() {
    const ajaxCreateUpdateSubSystemPoReceivedCategory = {
        url: "create_update_subsystem_po_received_category",
        method: "POST",
        data: $('#formCreateUpdateSubSystemPoReceivedCategory').serialize(),
        dataType: "json",
        beforeSendCallback: function(xhr) {
            $("#iBtnCreateUpdateDataIcon").addClass('spinner-border spinner-border-sm');
            $("#btnCreateUpdateData").addClass('disabled');
            $("#iBtnCreateUpdateDataIcon").removeClass('fa fa-check');
        },
        successCallback: (response) => {
            if (response['validationHasError'] == 1) {
                toastr.error('Saving failed!');
            }else if(response['hasError'] == 0) {
                $('#modalCreateUpdateSubSystemPoReceivedCategory').modal('hide');
                toastr.success('Successfully saved!');
                dataTableSubSystemPoReceivedCategory.draw();
            }else{
                toastr.error('Category already exist!');
                $('#modalCreateUpdateSubSystemPoReceivedCategory').modal('hide');
            }
            $("#iBtnCreateUpdateDataIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnCreateUpdateData").removeClass('disabled');
            $("#iBtnCreateUpdateDataIcon").addClass('fa fa-check');
        },
        errorCallback: () => {
            toastr.error('An error occurred while processing your request.');
        }
    };

    ajaxRequest(ajaxCreateUpdateSubSystemPoReceivedCategory);
}

function SubSystemPoReceivedCategoryGetInfoByIdToEdit(subSystemPoReceivedCategoryId){
    const ajaxGetSubSystemPoReceivedCategoryByIdToEdit = {
        url: 'get_subsystem_po_received_category_info_by_id',
        method: 'GET',
        data: {
            subSystemPoReceivedCategoryId: subSystemPoReceivedCategoryId
        },
        successCallback: (response) => {
            let subsystemPoReceivedCategoryInfo = response['subsystemPoReceivedCategoryInfo']
            if(subsystemPoReceivedCategoryInfo.length > 0){
                    $("#txtCategory").val(subsystemPoReceivedCategoryInfo[0].category);
            }        
        },
        errorCallback: () => {

        }
    };
    ajaxRequest(ajaxGetSubSystemPoReceivedCategoryByIdToEdit);
}

function SubSystemPoReceivedCategoryChangeStatus(){
    const ajaxChangeUserStatus = {
        url: 'change_category_status',
        method: "POST",
        data: $('#formSubSystemPoReceivedCategoryStatus').serialize(),
        dataType: "json",
        beforeSendCallback: function(xhr) {
            $("#iBtnSubSystemPoReceivedCategoryStatusIcon").addClass('spinner-border spinner-border-sm');
            $("#btnSubSystemPoReceivedCategoryStatus").addClass('disabled');
            $("#iBtnSubSystemPoReceivedCategoryStatusIcon").removeClass('fa fa-check');
        },
        successCallback: (response) => {
            if(response['hasError'] == 0){
                if($("#txtSubSystemPoReceivedCategoryStatus").val() == 0){
                    toastr.success('Category activation success!');
                    $("#txtSubSystemPoReceivedCategoryStatus").val() == 1;
                }
                else{
                    toastr.success('Category deactivation success!');
                    $("#txtSubSystemPoReceivedCategoryStatus").val() == 0;
                }
                $('#modalChangeSubSystemPoReceivedCategoryStatus').modal('hide');
                resetModalFormValues('modalChangeSubSystemPoReceivedCategoryStatus', 'formSubSystemPoReceivedCategoryStatus');
                dataTableSubSystemPoReceivedCategory.draw();
            }
            $("#iBtnSubSystemPoReceivedCategoryStatusIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnSubSystemPoReceivedCategoryStatus").removeClass('disabled');
            $("#iBtnSubSystemPoReceivedCategoryStatusIcon").addClass('fa fa-check');
        },
        errorCallback: () => {
            toastr.error('An error occurred while processing your request.');
        }
    };
    ajaxRequest(ajaxChangeUserStatus);
}
