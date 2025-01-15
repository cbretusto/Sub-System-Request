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
@section('title', 'Export Report')
@section('content_page')
    @php
        date_default_timezone_set('Asia/Manila');
    @endphp
    <div class="content-wrapper layout-fixed">
        <section class="content p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title"><strong>Sub-System Request Export Report</strong></span>
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('message') }}</strong>
                                    </div>
                                @endif
                                <div class="input-group mb-3"> 
                                    <label class="input-group-text w-25"><strong>PO No:</strong></label> 
                                    <select class="form-select select2bs5 get-po_no" id="slctSearchPoNo" name="search_po_no"></select>    
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text w-25"><strong>Device Name:</strong></span> 
                                    <select class="form-select select2bs5 get-device_name" id="slctSearchDeviceName" name="search_device_name"></select>    
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text w-25"><strong>Category:</strong></span> 
                                    <select class="form-select" id="slctSearchCategory" name="search_category">
                                        <option disabled selected value=""> ----- </option>
                                        <option value="Internal"> Internal </option>
                                        <option value="External"> External </option>
                                    </select>    
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text w-25"><strong>From:</strong></span> 
                                    <input type="date" class="form-control" name="from" id="txtSearchFrom" max="<?= date('Y-m-d'); ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text w-25"><strong>To:</strong></span> 
                                    <input type="date" class="form-control" name="to" id="txtSearchTo" max="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark float-end" id="btnExportTroubleLogs"><i class="fas fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2bs5').select2({
                dropdownAutoWidth: true,
                minimumInputLength: 5,
                theme: 'bootstrap-5'
            })          
            
            getPo($('.get-po_no'),'1');
            getDeviceName($('.get-device_name'),'2');

            $('#btnExportTroubleLogs').on('click', function(){
                let poNo        = $('#slctSearchPoNo').val();
                let deviceName  = $('#slctSearchDeviceName').val();
                let category    = $('#slctSearchCategory').val();
                let from        = $('#txtSearchFrom').val();
                let to          = $('#txtSearchTo').val();
                console.log('category: ', category);
                if(category == null){
                    console.log('category',category)
                    alert('Select Category');
                }else if(from == ''){
                    console.log('from',from)
                    alert('Select Date From');
                }else if(to == ''){
                    console.log('to',to)
                    alert('Select Date To');
                }else{
                    if(deviceName != null){
                        encode_deviceName = deviceName.replace('/','||')
                        url_encode_deviceName = encodeURIComponent(encode_deviceName);
                    }else{
                        url_encode_deviceName = 'null';
                    }
                    
                    window.location.href = `export/${category}/${poNo}/${url_encode_deviceName}/${from}/${to}`;
                    $('.alert').remove();
                }            
            });
        });
    </script>
@endsection
