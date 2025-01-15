function GetDeviceCode(element,check){
    let result = '';
    const ajaxGetPPSPoReceivedItemCode = {
        url: 'search_po_received_details',
        method: 'GET',
        successCallback: (response) => {
            let getSearchPoReceivedDetails = response['getSearchPoReceivedDetails']

            if(getSearchPoReceivedDetails.length > 0){
                result += '<option value="" disabled selected>Select Item Code</option>';
                for(let index = 0; index < getSearchPoReceivedDetails.length; index++){
                    result += '<option value="' + getSearchPoReceivedDetails[index].ItemCode + '">' + getSearchPoReceivedDetails[index].ItemCode + '</option>';
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
    ajaxRequest(ajaxGetPPSPoReceivedItemCode);
}

function CreateUpdateSubSystemRequest() {
    const ajaxCreateUpdateSubSystemRequest = {
        url: "create_update_subsystem_request",
        method: "POST",
        data: $('#formCreateUpdateSubSystemRequest').serialize(),
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
                $('#modalCreateUpdateSubSystemRequest').modal('hide');
                toastr.success('Successfully saved!');
                dataTableSubSystemRequestHistory.draw();
            }else{
                toastr.error('Data already exist!');
                $('#modalCreateUpdateSubSystemRequest').modal('hide');
            }
            $("#iBtnCreateUpdateDataIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnCreateUpdateData").removeClass('disabled');
            $("#iBtnCreateUpdateDataIcon").addClass('fa fa-check');
        },
        errorCallback: () => {
            toastr.error('An error occurred while processing your request.');
        }
    };

    ajaxRequest(ajaxCreateUpdateSubSystemRequest);
}

function SubSystemRequestGetInfoByIdToEdit(subSystemRequestId){
    const ajaxGetSubSystemRequestByIdToEdit = {
        url: 'get_subsystem_request_info_by_id',
        method: 'GET',
        data: {
            subSystemRequestId: subSystemRequestId
        },
        successCallback: (response) => {
            let subsystemRequestInfo = response['subsystemRequestInfo']
            if(subsystemRequestInfo.length > 0){
                setTimeout(() => {     
                    $("#txtOrderNo").val(subsystemRequestInfo[0].order_no);
                    $("#slctItemCode").val(subsystemRequestInfo[0].item_code).trigger('change');
                    $("#txtMaterialCost").val(subsystemRequestInfo[0].material_cost);
                    $("#txtLocation").val(subsystemRequestInfo[0].location);
                    $("#dateCreatedAt").val(new Date(subsystemRequestInfo[0].created_at).toISOString().split('T')[0]);
                }, 500);
            }        
        },
        errorCallback: () => {

        }
    };
    ajaxRequest(ajaxGetSubSystemRequestByIdToEdit);
}

function ViewPoReceivedDetails(subSystemRequestOrderNo){
    const ajaxGetSubSystemRequestPoReceivedDetails = {
        url: 'get_po_received_details',
        method: 'GET',
        data: {
            subSystemRequestOrderNo: subSystemRequestOrderNo
        },
        successCallback: (response) => {
            let subsystemRequestPoReceivedInfo = response['subsystemRequestPoReceivedInfo']
            if(subsystemRequestPoReceivedInfo.length > 0){
                $("#txtPoReceivedCategory").val(subsystemRequestPoReceivedInfo[0].Category);
                $("#txtPoReceivedDateIssued").val(subsystemRequestPoReceivedInfo[0].DateIssued);
                $("#txtPoReceivedPoNumber").val(subsystemRequestPoReceivedInfo[0].ProductPONo);
                $("#txtPoReceivedPoBalanace").val(subsystemRequestPoReceivedInfo[0].POBalance);
                $("#txtPoReceivedItemCode").val(subsystemRequestPoReceivedInfo[0].ItemCode);
                $("#txtPoReceivedItemName").val(subsystemRequestPoReceivedInfo[0].ItemName);
                $("#txtPoReceivedOrderNo").val(subsystemRequestPoReceivedInfo[0].OrderNo);
                $("#txtPoReceivedOrderQuantity").val(subsystemRequestPoReceivedInfo[0].OrderQty);
                $("#txtPoReceivedPrice").val(subsystemRequestPoReceivedInfo[0].Price);
                $("#txtPoReceivedAmount").val(subsystemRequestPoReceivedInfo[0].Amount);
                $("#txtPoReceivedMaterialCost").val(subsystemRequestPoReceivedInfo[0].material_cost);
                $("#txtPoReceivedLocation").val(subsystemRequestPoReceivedInfo[0].location);
            }        
        },
        errorCallback: () => {

        }
    };
    ajaxRequest(ajaxGetSubSystemRequestPoReceivedDetails);
}
