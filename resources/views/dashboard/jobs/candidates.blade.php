@extends('dashboard._layout.main')

@push('page-css')
<style>
    .recruitment-summary { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-bottom:20px; }
    .recruitment-summary-card { border:1px solid rgba(0,0,0,.08); border-radius:10px; padding:14px; background:#f8f9fa; }
    .recruitment-summary-card .label { display:block; color:#6c757d; font-size:12px; margin-bottom:4px; }
    .milestone-report-row { border:1px solid rgba(0,0,0,.08); border-radius:10px; padding:16px; margin-bottom:12px; }
    .milestone-report-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px; }
    .milestone-report-title { margin:0; font-size:15px; font-weight:600; }
    .milestone-report-meta { display:flex; flex-wrap:wrap; gap:8px 18px; color:#6c757d; font-size:13px; margin-bottom:8px; }
    .milestone-report-notes { margin:0; white-space:pre-wrap; color:#495057; }
    .milestone-empty { text-align:center; padding:30px 16px; border:1px dashed rgba(0,0,0,.15); border-radius:10px; color:#6c757d; }
</style>
@endpush

@section('container')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
<h1 class="page-header">{{ $title }}</h1>

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
                                <th>Recruitment Process</th>
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
                                        <a href="{{ $item->candidate->cv_url }}" target="_blank" rel="noopener">Open CV</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($item->milestones->isNotEmpty())
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($item->milestones as $milestone)
                                                <div>
                                                    {{ str_replace('_', ' ', ucfirst($milestone->step)) }}
                                                    <span class="text-muted">({{ str_replace('_', ' ', ucfirst($milestone->status ?? '-')) }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No recruitment process yet</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#milestoneModal{{ $item->id }}">
                                            <i class="fa fa-list-check"></i> Recruitment Process
                                        </button>
                                        <form action="{{ route('admin.job.candidates.destroy', [$job->id, $item->id]) }}" method="POST" onsubmit="return confirm('Unassign this candidate from this job?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-user-minus"></i> Unassign
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="milestoneModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div>
                                                <h5 class="modal-title mb-1">Recruitment Process</h5>
                                                <div class="text-muted small">{{ $item->candidate->name ?? 'Candidate' }}</div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="recruitment-summary">
                                                <div class="recruitment-summary-card">
                                                    <span class="label">Candidate</span>
                                                    <strong>{{ $item->candidate->name ?? '-' }}</strong>
                                                </div>
                                                <div class="recruitment-summary-card">
                                                    <span class="label">Email</span>
                                                    <strong>{{ $item->candidate->email ?? '-' }}</strong>
                                                </div>
                                                <div class="recruitment-summary-card">
                                                    <span class="label">Total Steps</span>
                                                    <strong>{{ $item->milestones->count() }}</strong>
                                                </div>
                                            </div>

                                            @if($item->milestones->isNotEmpty())
                                                @foreach($item->milestones as $index => $milestone)
                                                    <div class="milestone-report-row">
                                                        <div class="milestone-report-header">
                                                            <h6 class="milestone-report-title">
                                                                Step {{ $index + 1 }} — {{ str_replace('_', ' ', ucfirst($milestone->step)) }}
                                                            </h6>
                                                            <span class="badge bg-secondary">
                                                                {{ str_replace('_', ' ', ucfirst($milestone->status ?? '-')) }}
                                                            </span>
                                                        </div>

                                                        <div class="milestone-report-meta">
                                                            <span><i class="fa fa-calendar me-1"></i>{{ $milestone->date ? \Carbon\Carbon::parse($milestone->date)->format('d M Y') : 'No date' }}</span>
                                                            @if($milestone->link)
                                                                <span><i class="fa fa-link me-1"></i><a href="{{ $milestone->link }}" target="_blank" rel="noopener">Open related link</a></span>
                                                            @endif
                                                        </div>

                                                        @if($milestone->notes)
                                                            <p class="milestone-report-notes">{{ $milestone->notes }}</p>
                                                        @else
                                                            <p class="milestone-report-notes text-muted">No notes.</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="milestone-empty">
                                                    <i class="fa fa-list-check fa-2x mb-2"></i>
                                                    <div class="fw-semibold">No recruitment process yet</div>
                                                    <div class="small">Add the candidate's recruitment steps from the management page.</div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                            <a href="{{ route('admin.job.candidates.milestones.edit', [$job->id, $item->id]) }}" class="btn btn-primary">
                                                <i class="fa fa-pen-to-square"></i> Manage Recruitment Process
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No candidate assigned to this job yet.</td>
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
                        <div class="alert alert-info mt-3 mb-0">Semua candidate sudah di-assign ke job ini.</div>
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
@endsection

@push('page-js')
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

    @if($errors->has('candidate_id'))
        const candidateModal = document.getElementById('candidateModal');
        if (candidateModal && window.bootstrap) {
            new bootstrap.Modal(candidateModal).show();
        }
    @endif
});
</script>
@endpush
