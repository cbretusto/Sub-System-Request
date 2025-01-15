<!-- AdminLTE -->
<script src="{{ asset('public/template/adminlte/js/adminlte.min.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('public/template/jquery/js/jquery.min.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}

<!-- Bootstrap 5 -->
<script src="{{ asset('public/template/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('public/template/datatables/js/datatables.min.js') }}"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}

<!-- Select2 -->
<script src="{{ asset('public/template/select2/js/select2.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('public/template/toastr/js/toastr.min.js') }}"></script>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "iconClass":  "toast-custom"
    };
</script>

<script src="@php echo asset("public/js/JsFunction.js?".date("YmdHis")) @endphp"></script>
<script src="@php echo asset("public/js/UserManagement.js?".date("YmdHis")) @endphp"></script>
<script src="@php echo asset("public/js/SubSystemRequest.js?".date("YmdHis")) @endphp"></script>
<script src="@php echo asset("public/js/Export.js?".date("YmdHis")) @endphp"></script>