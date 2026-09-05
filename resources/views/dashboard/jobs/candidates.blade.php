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
                                    <th>Milestone</th>
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
                                            @if($item->milestones->isNotEmpty())
                                                @foreach($item->milestones as $milestone)
                                                    <div class="mb-1">
                                                        {{ str_replace('_', ' ', ucfirst($milestone->step)) }}
                                                        <span class="text-muted">({{ str_replace('_', ' ', ucfirst($milestone->status ?? '-')) }})</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No milestone</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#milestoneModal{{ $item->id }}">
                                                    <i class="fa fa-list-check"></i> Milestone
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
                                                <form action="{{ route('admin.job.candidates.milestones.update', [$job->id, $item->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Milestone - {{ $item->candidate->name ?? 'Candidate' }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted mb-3">Atur tahapan recruitment untuk candidate ini.</p>
                                                        <div id="milestoneRows{{ $item->id }}">
                                                            @php
                                                                $candidateMilestones = $item->milestones->values();
                                                            @endphp

                                                            @forelse($candidateMilestones as $index => $milestone)
                                                                <div class="milestone-row border rounded p-3 mb-3">
                                                                    <div class="row g-3 align-items-end">
                                                                        <div class="col-md-4">
                                                                            <label class="form-label">Step</label>
                                                                            <select name="milestones[{{ $index }}][step]" class="form-control" required>
                                                                                <option value="">Select step</option>
                                                                                @foreach(config('milestones.steps', []) as $step)
                                                                                    <option value="{{ $step }}" @selected($milestone->step === $step)>{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select name="milestones[{{ $index }}][status]" class="form-control" required>
                                                                                <option value="">Select status</option>
                                                                                @foreach(config('milestones.statuses', []) as $status)
                                                                                    <option value="{{ $status }}" @selected($milestone->status === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="form-label">Date</label>
                                                                            <input type="date" name="milestones[{{ $index }}][date]" class="form-control" value="{{ $milestone->date }}">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="form-label">Notes</label>
                                                                            <input type="text" name="milestones[{{ $index }}][notes]" class="form-control" maxlength="500" value="{{ $milestone->notes }}">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="milestone-row border rounded p-3 mb-3">
                                                                    <div class="row g-3 align-items-end">
                                                                        <div class="col-md-4">
                                                                            <label class="form-label">Step</label>
                                                                            <select name="milestones[0][step]" class="form-control" required>
                                                                                <option value="">Select step</option>
                                                                                @foreach(config('milestones.steps', []) as $step)
                                                                                    <option value="{{ $step }}">{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select name="milestones[0][status]" class="form-control" required>
                                                                                <option value="">Select status</option>
                                                                                @foreach(config('milestones.statuses', []) as $status)
                                                                                    <option value="{{ $status }}">{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="form-label">Date</label>
                                                                            <input type="date" name="milestones[0][date]" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="form-label">Notes</label>
                                                                            <input type="text" name="milestones[0][notes]" class="form-control" maxlength="500">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforelse
                                                        </div>

                                                        @if(empty(config('milestones.steps', [])) || empty(config('milestones.statuses', [])))
                                                            <div class="alert alert-warning mb-0">
                                                                Milestone step/status belum dikonfigurasi di Settings.
                                                            </div>
                                                        @else
                                                            <button type="button" class="btn btn-outline-primary btn-sm add-milestone" data-target="milestoneRows{{ $item->id }}">
                                                                <i class="fa fa-plus"></i> Add Milestone
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary" @disabled(empty(config('milestones.steps', [])) || empty(config('milestones.statuses', [])))>
                                                            <i class="fa fa-save"></i> Save Milestones
                                                        </button>
                                                    </div>
                                                </form>
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

            document.querySelectorAll('.add-milestone').forEach(function (button) {
                button.addEventListener('click', function () {
                    const target = document.getElementById(button.dataset.target);
                    if (!target) return;

                    const rows = target.querySelectorAll('.milestone-row');
                    const nextIndex = rows.length;
                    const template = rows[0]?.cloneNode(true);
                    if (!template) return;

                    template.querySelectorAll('input, select').forEach(function (field) {
                        field.name = field.name.replace(/milestones\\[[0-9]+\\]/, 'milestones[' + nextIndex + ']');
                        if (field.tagName === 'SELECT') {
                            field.selectedIndex = 0;
                        } else {
                            field.value = '';
                        }
                    });

                    target.appendChild(template);
                });
            });

            document.addEventListener('click', function (event) {
                const button = event.target.closest('.remove-milestone');
                if (!button) return;

                const row = button.closest('.milestone-row');
                const container = row?.parentElement;
                if (!row || !container) return;

                const rows = container.querySelectorAll('.milestone-row');
                if (rows.length > 1) {
                    row.remove();
                } else {
                    row.querySelectorAll('input').forEach(input => input.value = '');
                    row.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                }
            });

            @if(session('open_milestone_modal'))
                const milestoneModal = document.getElementById('milestoneModal{{ session('open_milestone_modal') }}');
                if (milestoneModal && window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                    new window.bootstrap.Modal(milestoneModal).show();
                }
            @endif
        });
    </script>
@endsection
