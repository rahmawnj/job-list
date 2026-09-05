@extends('dashboard._layout.main')

@section('container')

    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- END page-header -->

    <div class="row">
        <!-- BEGIN col-10 -->
        <div class="col-xl-12">
            <!-- BEGIN panel -->
            <div class="panel panel-inverse">
                <!-- BEGIN panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">{{$title}}</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                        <a href="/dashboard/jobs/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <!-- END panel-heading -->
                <!-- BEGIN alert -->

                @if (session()->has('success'))
                <div class="flash-data-success" data-flashdatasuccess="{{session('success')}} " ></div>
                @endif
                @if (session()->has('error'))
                <div class="flash-data-error" data-flashdataerror="{{session('error')}} " ></div>
                @endif
                @if (session()->has('warning'))
                <div class="flash-data-warning" data-flashdatawarning="{{session('warning')}} " ></div>
                @endif
                <!-- END alert -->
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                    <table style="width: 100%;" id="data-table-jobs" class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th data-orderable="false">Image</th>
                                <th>Job Title</th>
                                <th class="text-nowrap">Company Name</th>
                                <th class="text-nowrap">Job Category</th>
                                <th class="">Apply</th>
                                <th class="text-nowrap" data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data diisi oleh DataTables (server-side) --}}
                        </tbody>
                    </table>
                </div>
                <!-- END hljs-wrapper -->
            </div>
            <!-- END panel -->
        </div>
        <!-- END col-10 -->
    </div>

    {{-- CSRF token untuk DELETE via AJAX kalau nanti dibutuhkan --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script>
$(function () {
    if (!$.fn.dataTable) {
        console.error('DataTables library belum dimuat.');
        return;
    }

    var table = $('#data-table-jobs').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: '/dashboard/jobs',
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            error: function (xhr) {
                console.error('DataTables AJAX error', xhr.status, xhr.responseText);
            }
        },
        columns: [
            {
                data: 'no',
                name: 'id',
                orderable: true,
                searchable: false,
                className: 'fw-bold text-inverse',
                width: '1%'
            },
            {
                data: 'image',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return '<figure class="m-auto d-flex justify-content-center rounded" style="width:50px; overflow:hidden;">' +
                           '<img class="h-50px my-n1 mx-n1" src="' + data + '" alt="">' +
                           '</figure>';
                }
            },
            { data: 'title', name: 'title' },
            { data: 'company_name', name: 'company_name' },
            { data: 'jobcategory_name', name: 'jobcategory_name' },
            {
                data: 'apply_count',
                name: 'apply_count',
                searchable: false,
                render: function (data, type, row) {
                    return '<a href="' + row.apply_url + '" class="btn btn-info">' + data + '</a>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return '' +
                        '<a class="btn btn-success" href="/dashboard/jobs/' + row.show_url.split('/').slice(-1)[0] + '/candidates"><i class="fa fa-user-plus"></i></a> ' +
                        '<a class="btn btn-warning" href="' + row.edit_url + '"><i class="fa fa-edit"></i></a> ' +
                        '<a class="d-inline btn btn-info" href="' + row.show_url + '"><i class="fa fa-eye"></i></a> ' +
                        '<form class="d-inline btn-del-form" action="' + row.delete_url + '" method="POST">' +
                            '<input type="hidden" name="_method" value="delete">' +
                            '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">' +
                            '<button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>' +
                        '</form>';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            processing: "Memuat...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_",
            infoEmpty: "Menampilkan 0 dari 0",
            zeroRecords: "Tidak ada data",
            paginate: { previous: "Prev", next: "Next" }
        }
    });

    // Konfirmasi hapus tetap pakai SweetAlert yang sudah ada di layout
    $('#data-table-jobs').on('submit', '.btn-del-form', function (e) {
        e.preventDefault();
        var form = this;
        swal({
            title: "Peringatan!",
            text: "Yakin akan dihapus?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (result) {
            if (result) { form.submit(); }
        });
    });
});
</script>
@endpush



