@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>

    <h1 class="page-header">{{$title}}</h1>

    <div class="row mb-3">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{$title}}</h4>
                    <div class="panel-heading-btn">
                        <a href="/dashboard/candidates/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Candidate</a>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="flash-data-success" data-flashdatasuccess="{{ session('success') }}"></div>
                @endif

                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="data-table-candidates" class="table table-striped table-bordered align-middle w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Jobs</th>
                                    <th>Latest Milestone</th>
                                    <th>Linkedin</th>
                                    <th>CV</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@push('scripts')
<script>
$(function () {
    if (!$.fn.DataTable) {
        console.error('DataTables library belum dimuat.');
        return;
    }

    function escapeHtml(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    }

    $('#data-table-candidates').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '/dashboard/candidates',
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            error: function (xhr) {
                console.error('Candidates DataTables AJAX error', xhr.status, xhr.responseText);
            }
        },
        columns: [
            {
                data: 'no',
                name: 'id',
                searchable: false,
                className: 'fw-bold text-inverse',
                width: '1%'
            },
            {
                data: 'name',
                name: 'name',
                render: function (data, type) {
                    return type === 'display' ? escapeHtml(data || '-') : (data || '');
                }
            },
            {
                data: 'email',
                name: 'email',
                render: function (data, type) {
                    return type === 'display' ? escapeHtml(data || '-') : (data || '');
                }
            },
            {
                data: 'phone',
                name: 'phone',
                render: function (data, type) {
                    return type === 'display' ? escapeHtml(data || '-') : (data || '');
                }
            },
            {
                data: 'jobs',
                name: 'jobs',
                orderable: false,
                render: function (jobs, type) {
                    if (type !== 'display') {
                        return (jobs || []).map(function (job) { return job.title; }).join(' ');
                    }
                    if (!jobs || !jobs.length) return '-';
                    return '<div class="d-flex flex-column gap-1">' + jobs.map(function (job) {
                        return '<div><a class="text-primary" href="' + escapeHtml(job.url) + '">' +
                            escapeHtml(job.title) + '</a></div>';
                    }).join('') + '</div>';
                }
            },
            {
                data: 'latest_milestone',
                name: 'latest_milestone',
                orderable: false,
                render: function (data, type) {
                    return type === 'display' ? escapeHtml(data || '-') : (data || '');
                }
            },
            {
                data: 'linkedin_url',
                name: 'linkedin_url',
                orderable: false,
                render: function (data, type) {
                    if (!data) return '-';
                    return type === 'display'
                        ? '<a href="' + escapeHtml(data) + '" target="_blank" rel="noopener noreferrer">Open</a>'
                        : data;
                }
            },
            {
                data: 'cv_url',
                name: 'cv_url',
                orderable: false,
                render: function (data, type) {
                    if (!data) return '-';
                    return type === 'display'
                        ? '<a href="' + escapeHtml(data) + '" target="_blank" rel="noopener noreferrer">Open</a>'
                        : data;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (type !== 'display') return '';
                    return '<a href="' + escapeHtml(row.edit_url) + '" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a> ' +
                        '<a href="' + escapeHtml(row.show_url) + '" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-eye"></i></a> ' +
                        '<form action="' + escapeHtml(row.delete_url) + '" method="POST" class="d-inline btn-del-form">' +
                            '<input type="hidden" name="_token" value="' + escapeHtml($('meta[name="csrf-token"]').attr('content')) + '">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></button>' +
                        '</form>';
                }
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            processing: 'Memuat...',
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ kandidat',
            infoEmpty: 'Menampilkan 0 kandidat',
            infoFiltered: '(difilter dari _MAX_ total kandidat)',
            zeroRecords: 'Kandidat tidak ditemukan',
            emptyTable: 'Belum ada data kandidat',
            paginate: { first: 'Pertama', last: 'Terakhir', next: 'Berikutnya', previous: 'Sebelumnya' }
        }
    });

    $('#data-table-candidates').on('submit', '.btn-del-form', function (e) {
        e.preventDefault();
        var form = this;
        if (typeof swal === 'function') {
            swal({
                title: 'Peringatan!',
                text: 'Yakin akan menghapus kandidat ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (confirmed) {
                if (confirmed) form.submit();
            });
        } else if (confirm('Yakin akan menghapus kandidat ini?')) {
            form.submit();
        }
    });
});
</script>
@endpush
