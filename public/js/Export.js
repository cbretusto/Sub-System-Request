function getPo(cboElement,check){
    let po_result = '';
    $.ajax({
        url: 'search_po_received_details',
        method: 'get',
        data: {
            'check'            :   check,
        },
        dataType: 'json',
        beforeSend: function(){
            po_result = '<option value="0" selected disabled> -- Loading -- </option>';
        },
        success: function(response){
            console.log('PO No. Length: ', response['getSearchPoReceivedDetails'].length);
            if(response['getSearchPoReceivedDetails'].length > 0){
                // po_result = '<option value="0" selected disabled> --- Select PO Number ---</option>';
                po_result = '<option value="0" selected disabled> --- Optional --- </option>';
                for(let index = 0; index < response['getSearchPoReceivedDetails'].length; index++){
                    po_result += '<option value="' + response['getSearchPoReceivedDetails'][index].ProductPONo + '">' + response['getSearchPoReceivedDetails'][index].ProductPONo + '</option>';
                }
            }
            else{
                po_result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(po_result);
        }
    });
}

function getDeviceName(cboElement,check){
    let device_name_result = '';
    $.ajax({
        url: 'search_po_received_details',
        method: 'get',
        data: {
            'check'    :   check,
        },
        dataType: 'json',
        beforeSend: function(){
            device_name_result = '<option value="0" selected disabled> -- Loading -- </option>';
        },
        success: function(response){
            console.log('Device Name Length: ', response['getSearchPoReceivedDetails'].length);
            if(response['getSearchPoReceivedDetails'].length > 0){
                // device_name_result = '<option value="0" selected disabled> --- Select Device Name ---</option>';
                device_name_result = '<option value="0" selected disabled> --- Optional --- </option>';
                for(let index = 0; index < response['getSearchPoReceivedDetails'].length; index++){
                    device_name_result += '<option value="' + response['getSearchPoReceivedDetails'][index].ItemName + '">' + response['getSearchPoReceivedDetails'][index].ItemName + '</option>';
                }
            }
            else{
                device_name_result = '<option value="0" selected disabled> No record found </option>';
            }
            cboElement.html(device_name_result);
        }
    });
}