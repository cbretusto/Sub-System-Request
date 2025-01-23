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
@section('title', 'Sub-System Request History')
@section('content_page')
    <style type="text/css">
        table.table thead th{
            text-align: center;
            vertical-align: middle;
        }

        th.dt-type-numeric {
            text-align: center !important;
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
                                <h3 class="card-title" style="margin-top: 8px;">Sub-System Request Data</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="shadow btn shadow btn-dark button-hide d-none" id="buttonExport" data-bs-toggle="modal" data-bs-target="#modalExport">
                                        <i class="fas fa-file-excel fa-md"></i> Export Data
                                    </button>
                                    <button type="button" class="shadow btn shadow btn-primary button-hide d-none" id="buttonImport" data-bs-toggle="modal" data-bs-target="#modalImport">
                                        <i class="fas fa-file-excel fa-md"></i> Import Data
                                    </button>
                                    <button type="button" class="shadow btn shadow btn-secondary button-hide d-none" id="buttonAddData" data-bs-toggle="modal" data-bs-target="#modalCreateUpdateSubSystemRequest">
                                        <i class="fas fa-plus fa-md"></i> Add Data
                                    </button>                                 
                                </div>
                                <div class="table-responsive">
                                    <table id="tableSubSystemRequestHistory" class="table table-bordered table-hover nowrap">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Order No.</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Material Cost</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Modal Start -->
            <div class="modal fade modal-hide" id="modalExport" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Export Data</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="card-body p-3">
                            <div class="row form-hide">
                                <div class="col-md-12 d-flex flex-column mb-3">
                                    <label for="" class="form-label"><strong>Category</strong></label> 
                                    <select class="form-select" id="slctExportCategory"  name="export_category" required>
                                        <option value="" selected disabled> Select Category </option>
                                        <option value="0"> Template </option>
                                        <option value="1"> Record </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnExportData" class="btn btn-dark button-hide d-none"><i id="iBtnExportDataIcon"></i> Export</button>
                        </div>
                    </div>
                </div>
            </div><!-- Export Modal End -->

            <!-- Import Modal Start -->
            <div class="modal fade modal-hide" id="modalImport" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Import Data</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="form-hide" method="post" id="formSubSystemRequestImport" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="input-group mb-3"> 
                                        <input type="file" class="form-control" id="fileSubSystemRequestImport" name="import_subsystem_request" accept=".xlsx, .xls, .csv" required> 
                                    </div>
                                </div> 
                            </div> 
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="btnImportData" class="btn btn-dark button-hide d-none"><i id="iBtnImportDataIcon"></i> Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Import Modal End -->

            <!-- Create/Update Modal Start -->
            <div class="modal fade modal-hide" id="modalCreateUpdateSubSystemRequest" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Sub-System Request</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="form-hide" method="post" id="formCreateUpdateSubSystemRequest">
                            @csrf

                            <div class="card-body p-3">
                                <div class="row">
                                    <input type="text" class="input_hidden" id="textSubSystemRequestId" name="subsystem_request_id" placeholder="╭∩╮( •̀_•́ )╭∩╮" readonly>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Order No.:</strong></label> 
                                        <input type="text" class="form-control" id="txtOrderNo"  name="order_no" autocomplete="off" required>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Material Cost:</strong></label> 
                                        <input type="text" class="form-control" id="txtMaterialCost"  name="material_cost" autocomplete="off" required>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Item Code:</strong></label> 
                                        <select class="get-item_code select2bs5" id="slctItemCode" name="item_code"></select>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Item Name:</strong></label> 
                                        <input type="text" class="form-control" id="txtItemName"  name="item_name" autocomplete="off" required readonly>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Location:</strong></label> 
                                        <input type="text" class="form-control" id="txtLocation"  name="location" autocomplete="off" required>
                                    </div>

                                    <div class="col-md-6 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Created at:</strong></label> 
                                        <input type="date" class="form-control" id="dateCreatedAt" name="created_at" readonly>
                                    </div>
                                </div> 
                            </div> 
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="btnCreateUpdateData" class="btn btn-dark button-hide d-none"><i id="iBtnCreateUpdateDataIcon"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- Create/Update Modal End -->

            <!-- View SubSystem Request Modal Start -->
            <div class="modal fade" id="modalViewPoRevievedDetails" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;PO Received Details</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="card-body class-disabled p-4">
                            <div class="row">
                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Category:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedCategory" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Date Issued:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedDateIssued" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>PO Number:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedPoNumber" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>PO Balance:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedPoBalanace" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Item Code:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedItemCode" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Item Name:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedItemName" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Order Number:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedOrderNo" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Order Quantity:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedOrderQuantity" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Price:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedPrice" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Amount:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedAmount" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Material Cost:</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedMaterialCost" autocomplete="off" readonly>
                                </div>

                                <div class="col-md-6 d-flex flex-column mb-3"> 
                                    <label for="" class="form-label"><strong>Location</strong></label> 
                                    <input type="text" class="form-control" id="txtPoReceivedLocation" autocomplete="off" readonly>
                                </div>

                            </div> 
                        </div> 
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div><!-- View SubSystem Request Modal End -->
            
        </section>
    </div>
@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        let dataTableSubSystemRequestHistory

        $(document).ready(function () {
            $('.select2bs5').select2({
                theme: 'bootstrap-5',
                minimumInputLength: 5,
                dropdownAutoWidth: true,
                dropdownParent: $('#modalCreateUpdateSubSystemRequest')
            })          

            $('#modalCreateUpdateSubSystemRequest').on('shown.bs.modal', function () {
            });
            GetDeviceCode($('.get-item_code'),'3');


            dataTableSubSystemRequestHistory = $("#tableSubSystemRequestHistory").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ Request Data",
                    "lengthMenu": "Show _MENU_ Request Data",
                },
                "ajax" : {
                    url: "view_subsystem_request_history",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "order_no"},
                    { "data" : "item_code"},
                    { "data" : "item_name"},
                    { "data" : "material_cost"},
                    { "data" : "location"}
                ],
                "columnDefs": [
                    {
                        "targets": '_all',
                        "createdCell": function(td, cellData, rowData, row, col) {
                            // if ($.isNumeric(cellData)) {
                            //     $(td).css('text-align', 'left');
                            // }
                            $(td).css('text-align', 'left');
                        }
                    },
                    {
                        "targets": 0,
                        "createdHeader": function(th, column) {
                            $(th).css('text-align', 'center');
                        }
                    }
                ]
            });

            $('#btnExportData').on('click', function(){
                let category    = $('#slctExportCategory').val();
                if(category != null){
                    window.location.href = `export/${category}`;
                }
            });

            $('#formSubSystemRequestImport').submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'import',
                    method: 'post',
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response['result'] == 1){
                            $('#modalImport').modal('hide');
                            toastr.success('Import Data Successful!');
                            dataTableSubSystemRequestHistory.draw();
                        }
                        else{
                            toastr.error('Import Failed! Please Check File');
                            $('#modalImport').modal('hide');
                        }
                    }
                });
            })

            $('.get-item_code').change(function (e) { 
                e.preventDefault();
                $.ajax({
                    url: "search_po_received_details",
                    method: "get",
                    data: {
                        check: $(this).val(),
                    },
                    dataType: "json",
                    beforeSend: function(){

                    },
                    success: function (response) {
                        let getItemName = response['getSearchPoReceivedDetails']

                        if(getItemName.length > 0){
                            $('#txtItemName').val(getItemName[0].ItemName)
                        }

                    }
                });
            });

            $('#buttonAddData').click(function (e) { 
                e.preventDefault();
                $('#dateCreatedAt').val(new Date().toISOString().split('T')[0])
            });
            $(document).on('click', '.actionSubSystemRequestEdit', function(e){
                e.preventDefault();
                let subSystemRequestId = $(this).attr('subsystem_request-id'); 
                    $("#textSubSystemRequestId").val(subSystemRequestId);
                    SubSystemRequestGetInfoByIdToEdit(subSystemRequestId); 
            });

            $("#formCreateUpdateSubSystemRequest").submit(function(event){
                event.preventDefault();
                CreateUpdateSubSystemRequest();
            });

            $(document).on('click', '.actionViewPoReceivedDetails', function(e){
                e.preventDefault();
                let subSystemRequestOrderNo = $(this).attr('subsystem_request-order_no'); 
                ViewPoReceivedDetails(subSystemRequestOrderNo); 
            });
            
            $('.modal-hide').on('shown.bs.modal', function(event){
                event.preventDefault();

                let modal = $(this).closest('.modal-hide');
                let form = modal.find('.form-hide');
        
                let getModalId = modal.attr('id');
                let getFormId = form.attr('id');

                resetModalFormValues(getModalId, getFormId)
            }); 
            // resetModalFormValues('modalCreateUpdateSubSystemRequest', 'formCreateUpdateSubSystemRequest');

        });
    </script>
@endsection
