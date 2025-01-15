/**
 * Reusable function for using Ajax Request
 * 
 * @param {object} options 
 */
const ajaxRequest = (options) => {
    var defaults = {
        url: '',
        method: 'GET',
        data: {},
        headers: {},
        dataType: 'json',
        beforeSendCallback: null,
        successCallback: () => {},
        errorCallback: () => {}
    };

    // Merge default options with user-provided options
    options = $.extend({}, defaults, options);

    $.ajax({
        url: options.url,
        method: options.method,
        data: options.data,
        headers: options.headers,
        dataType: options.dataType,
        beforeSend(xhr) {
            if (typeof options.beforeSendCallback === 'function') {
                options.beforeSendCallback(xhr);
            }
        },
        success(response) {
            options.successCallback(response);
        },
        error(xhr, status, error) {
            options.errorCallback(xhr, status, error);
        }
    });
};

/**
 * Set invalid class to elements for each field in the errors object
 * 
 * @param {object} errors 
 */
function handleValidatorErrors(errors) {
    // Remove all invalid class & title validation
    $('div').find('input').removeClass('is-invalid');
    $('div').find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $('div').find('select').attr('title', '');
    $('div').find('textarea').removeClass('is-invalid');
    $('div').find('textarea').attr('title', '');
    
    // Loop through each field in the errors object
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            // Extract the error messages for the field
            let fieldErrorMessage = errors[field];

            // Add invalid class & title validation
            if(field){
                $(`input[name="${field}"`).addClass('is-invalid');
                $(`input[name="${field}"`).attr('title', fieldErrorMessage);

                $(`select[name="${field}"`).addClass('is-invalid');
                $(`select[name="${field}"`).attr('title', fieldErrorMessage);

                $(`textarea[name="${field}"`).addClass('is-invalid');
                $(`textarea[name="${field}"`).attr('title', fieldErrorMessage);
            }
        }
    }
}

/**
 * Reset form values when the modal is hidden/closed
 * 
 * @param {string} modalId 
 * @param {string} formId 
 */
const resetModalFormValues = (modalId, formId) => {
    $(`#${modalId}`).on('hidden.bs.modal', function () {
        console.log(`${formId} modal is closed`);
        
        // Reset input values
        if(formId != undefined){
            $(`#${formId}`)[0].reset();
        }else{
            $('.form-select').val('');
        }
    
        // Reset select2 values
        $(`#${formId}`).find("select.select2-hidden-accessible").val('').trigger('change');
        $(`#${formId}`).find("select").prop('disabled', false);
    
        // Remove all invalid class & title validation
        $('div').find('input').removeClass('is-invalid');
        $("div").find('input').attr('title', '');
        $('div').find('select').removeClass('is-invalid');
        $("div").find('select').attr('title', '');
        $('div').find('textarea').removeClass('is-invalid');
        $("div").find('textarea').attr('title', '');
    });
}