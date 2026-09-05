@extends('dashboard._layout.main')

@push('page-css')
<link href="{{ asset('assets/dashboard/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
@endpush

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
                    <h4 class="panel-title">{{ $job->title }}</h4>
                    <div class="panel-heading-btn">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#candidateModal">
                            <i class="fa fa-user-plus"></i> Assign Candidate
                        </button>
                        <a href="/dashboard/jobs" class="btn btn-default btn-sm">Back to Jobs</a>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                        <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>CV Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobCandidates as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->candidate->name ?? '-' }}</td>
                                        <td>{{ $item->candidate->email ?? '-' }}</td>
                                        <td>
                                            @if($item->candidate && $item->candidate->cv_url)
                                                <a href="{{ $item->candidate->cv_url }}" target="_blank">Open CV</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.job.candidates.destroy', [$job->id, $item->id]) }}" method="POST" onsubmit="return confirm('Unassign this candidate from this job?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-user-minus"></i> Unassign
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No candidate assigned to this job yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.job.candidates.store', $job->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Candidate - {{ $job->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Job</label>
                            <input type="text" class="form-control" value="{{ $job->title }}" readonly>
                        </div>
                        <div>
                            <label class="form-label">Candidate</label>
                            <select class="form-control candidate-picker" name="candidate_id" required>
                                <option value="">Select candidate</option>
                                @foreach ($candidateOptions as $candidate)
                                    <option value="{{ $candidate->id }}" @selected(old('candidate_id') == $candidate->id)>
                                        {{ $candidate->name }} - {{ $candidate->email ?? 'No email' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($candidateOptions->isEmpty())
                            <div class="alert alert-info mt-3 mb-0">
                                Semua candidate sudah di-assign ke job ini.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" @disabled($candidateOptions->isEmpty())>
                            <i class="fa fa-user-plus"></i> Assign Candidate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery && typeof window.jQuery.fn.picker === 'function') {
                $('.candidate-picker').picker({
                    search: true,
                    searchAutofocus: true,
                    texts: {
                        trigger: 'Select candidate',
                        search: 'Search candidate',
                        noResult: 'Candidate not found'
                    }
                });
            }

            const hasValidationError = {{ $errors->any() ? 'true' : 'false' }};
            const modalEl = document.getElementById('candidateModal');

            if (hasValidationError && modalEl && window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                const modal = new window.bootstrap.Modal(modalEl);
                modal.show();
            }
        });
    </script>
@endsection
