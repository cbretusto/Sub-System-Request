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
@section('title', 'P.O Received Category')
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
                                <h3 class="card-title" style="margin-top: 8px;">P.O Received Category</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="shadow btn shadow btn-secondary button-hide d-none" id="buttonAddData" data-bs-toggle="modal" data-bs-target="#modalCreateUpdateSubSystemPoReceivedCategory">
                                        <i class="fas fa-plus fa-md"></i> Add Category
                                    </button>                                 
                                </div>
                                <div class="table-responsive">
                                    <table id="tableSubSystemPoReceivedCategory" class="table table-bordered table-hover nowrap">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Category</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create/Update Modal Start -->
            <div class="modal fade modal-category-hide" id="modalCreateUpdateSubSystemPoReceivedCategory" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Sub-System P.O Received Category</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="form-hide" method="post" id="formCreateUpdateSubSystemPoReceivedCategory">
                            @csrf

                            <div class="card-body p-3">
                                <div class="row">
                                    <input type="text" class="input_hidden" id="textSubSystemPoReceivedCategoryId" name="subsystem_po_received_category_id" placeholder="╭∩╮( •̀_•́ )╭∩╮" readonly>

                                    <div class="col-md-12 d-flex flex-column mb-3"> 
                                        <label for="" class="form-label"><strong>Category:</strong></label> 
                                        <input type="text" class="form-control" id="txtCategory"  name="category" autocomplete="off" required>
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

            <!-- Change Status Modal Start -->
            <div class="modal fade modal-category-hide" id="modalChangeSubSystemPoReceivedCategoryStatus" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="h4SubSystemPoReceivedCategoryStatusTitle"><i class="fa fa-"></i> Change Status</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" id="formSubSystemPoReceivedCategoryStatus" autocomplete="off">
                            @csrf
                            <div class="card-body p-3">
                                <label id="lblSubSystemPoReceivedCategoryStatusLabel"></label>
                                <input type="text" class="input_hidden" name="category_id" placeholder="Category Id" id="txtSubSystemPoReceivedCategoryId">
                                <input type="text" class="input_hidden" name="status" placeholder="Status" id="txtSubSystemPoReceivedCategoryStatus">

                            </div> 
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="btnSubSystemPoReceivedCategoryStatus" class="btn btn-dark button-hide d-none"><i id="iBtnSubSystemPoReceivedCategoryStatusIcon"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- User Status Modal End -->

        </section>
    </div>
@endsection

<!-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        let dataTableSubSystemPoReceivedCategory

        $(document).ready(function () {
            $('.select2bs5').select2({
                theme: 'bootstrap-5',
            })          

            dataTableSubSystemPoReceivedCategory = $("#tableSubSystemPoReceivedCategory").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                "order": [[ 0, "asc" ],[ 1, "asc" ]],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ Category",
                    "lengthMenu": "Show _MENU_ Category",
                },
                "ajax" : {
                    url: "view_subsystem_po_received_category",
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "status",
                        "defaultContent": 'N/A',
                        "name": 'status',
                        "orderable": true,
                        "searchable": true,
                        "render": function (data, type, row) {
                            if(row.status == 0){
                                return "<center><span class='badge bg-success'>Active</span></center>";
                            }else{
                                return "<center><span class='badge bg-danger'>Inactive</span></center>";
                            }
                        },
                    },
                    { "data" : "category"}
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

            $(document).on('click', '.actionEditSubSystemPoReceivedCategory', function(e){
                e.preventDefault();
                let subSystemPoReceivedCategoryId = $(this).attr('subsystem_po_received_category-id'); 
                    $("#textSubSystemPoReceivedCategoryId").val(subSystemPoReceivedCategoryId);
                    SubSystemPoReceivedCategoryGetInfoByIdToEdit(subSystemPoReceivedCategoryId); 
            });

            $("#formCreateUpdateSubSystemPoReceivedCategory").submit(function(event){
                event.preventDefault();
                SubSystemPoReceivedCategoryCreateUpdate();
            });
            
            $(document).on('click', '.actionChangeSubSystemPoReceivedCategoryStatus', function(){
                let categoryStatus = $(this).attr('status');
                let categoryId = $(this).attr('subsystem_po_received_category-id'); 
                $("#txtSubSystemPoReceivedCategoryStatus").val(categoryStatus); 
                $("#txtSubSystemPoReceivedCategoryId").val(categoryId); 

                if(categoryStatus == 0){
                    $("#lblSubSystemPoReceivedCategoryStatusLabel").text('Are you sure to activate?'); 
                    $("#h4SubSystemPoReceivedCategoryStatusTitle").html('<i class="fa fa-check-square"></i> Activate Category');
                }
                else{
                    $("#lblSubSystemPoReceivedCategoryStatusLabel").text('Are you sure to deactivate?');
                    $("#h4SubSystemPoReceivedCategoryStatusTitle").html('<i class="fa fa-window-close"></i> Deactivate Category');
                }
            });

            $("#formSubSystemPoReceivedCategoryStatus").submit(function(event){
                event.preventDefault();
                SubSystemPoReceivedCategoryChangeStatus();
            });

            $('.modal-category-hide').on('shown.bs.modal', function(event){
                event.preventDefault();
                let modal = $(this).closest('.modal-category-hide');
                let form = modal.find('.form-hide');
        
                let getModalId = modal.attr('id');
                let getFormId = form.attr('id');

                resetModalFormValues(getModalId, getFormId)
            }); 

        });
    </script>
@endsection
