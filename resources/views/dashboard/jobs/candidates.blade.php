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
                            <i class="fa fa-user-plus"></i> Add Candidate
                        </button>
                        <a href="/dashboard/jobs" class="btn btn-default btn-sm">Back to Jobs</a>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="flash-data-success" data-flashdatasuccess="{{ session('success') }}"></div>
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
                                    <th>Client</th>
                                    <th>Step</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobCandidates as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->candidate->name }}</td>
                                        <td>{{ $item->candidate->email ?? '-' }}</td>
                                        <td>
                                            @if($item->candidate->cv_url)
                                                <a href="{{ $item->candidate->cv_url }}" target="_blank">Open CV</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->client_name ?? optional($job->company)->name ?? '-' }}</td>
                                        <td>
                                            @if($item->milestones->isNotEmpty())
                                                @foreach($item->milestones as $milestone)
                                                    <div class="mb-1">{{ str_replace('_', ' ', ucfirst($milestone->step)) }}</div>
                                                @endforeach
                                            @else
                                                {{ str_replace('_', ' ', ucfirst($item->step)) }}
                                            @endif
                                        </td>
                                        <td>{{ str_replace('_', ' ', ucfirst($item->status ?? '-')) }}</td>
                                        <td>
                                            @if($item->milestones->isNotEmpty())
                                                @foreach($item->milestones as $milestone)
                                                    <div class="mb-1">{{ $milestone->date ? \Carbon\Carbon::parse($milestone->date)->format('d-m-Y') : '-' }}</div>
                                                @endforeach
                                            @else
                                                {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') : '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->milestones->isNotEmpty())
                                                @foreach($item->milestones as $milestone)
                                                    <div class="mb-1">{{ $milestone->notes ?? '-' }}</div>
                                                @endforeach
                                            @else
                                                {{ $item->notes ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCandidateModal{{ $item->id }}">
                                                    <i class="fa fa-user-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#milestoneModal{{ $item->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <form action="{{ route('admin.job.candidates.destroy', [$job->id, $item->id]) }}" method="POST" onsubmit="return confirm('Delete this candidate entry?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No candidate yet for this job.</td>
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
                        <h5 class="modal-title">Recruitment Process - {{ $job->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Job</label>
                                <input type="text" class="form-control" value="{{ $job->title }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Company / Client</label>
                                <input type="text" class="form-control" value="{{ optional($job->company)->name ?? '-' }}" readonly>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Search Candidate</label>
                                <select class="form-control candidate-picker" name="candidate_id" required>
                                    <option value="">Select candidate</option>
                                    @foreach ($candidateOptions as $candidate)
                                        <option value="{{ $candidate->id }}" data-name="{{ $candidate->name }}" data-email="{{ $candidate->email ?? '' }}" data-phone="{{ $candidate->phone ?? '' }}" data-linkedin="{{ $candidate->linkedin_url ?? '' }}" data-cv="{{ $candidate->cv_url ?? '' }}" data-portfolio="{{ $candidate->portfolio_url ?? '' }}" @selected(old('candidate_id') == $candidate->id)>{{ $candidate->name }} - {{ $candidate->email ?? 'No email' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Candidate name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@email.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="08xxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CV Link</label>
                                <input type="url" class="form-control" name="cv_url" value="{{ old('cv_url') }}" placeholder="https://...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Portfolio</label>
                                <input type="url" class="form-control" name="portfolio_url" value="{{ old('portfolio_url') }}" placeholder="https://...">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Candidate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($jobCandidates as $item)
        <div class="modal fade" id="editCandidateModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.job.candidates.update', [$job->id, $item->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Candidate Data - {{ $item->candidate->name ?? 'Candidate' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Search Candidate</label>
                                    <select class="form-control candidate-picker" name="candidate_id" required>
                                        @if ($item->candidate)
                                            <option value="{{ $item->candidate->id }}" data-name="{{ $item->candidate->name }}" data-email="{{ $item->candidate->email ?? '' }}" data-phone="{{ $item->candidate->phone ?? '' }}" data-linkedin="{{ $item->candidate->linkedin_url ?? '' }}" data-cv="{{ $item->candidate->cv_url ?? '' }}" data-portfolio="{{ $item->candidate->portfolio_url ?? '' }}" selected>{{ $item->candidate->name }} - {{ $item->candidate->email ?? 'No email' }}</option>
                                        @endif
                                        @foreach ($candidateOptions as $candidate)
                                            <option value="{{ $candidate->id }}" data-name="{{ $candidate->name }}" data-email="{{ $candidate->email ?? '' }}" data-phone="{{ $candidate->phone ?? '' }}" data-linkedin="{{ $candidate->linkedin_url ?? '' }}" data-cv="{{ $candidate->cv_url ?? '' }}" data-portfolio="{{ $candidate->portfolio_url ?? '' }}">{{ $candidate->name }} - {{ $candidate->email ?? 'No email' }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $item->candidate->name ?? '' }}" placeholder="Candidate name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $item->candidate->email ?? '' }}" placeholder="name@email.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $item->candidate->phone ?? '' }}" placeholder="08xxx">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" name="linkedin_url" value="{{ $item->candidate->linkedin_url ?? '' }}" placeholder="https://linkedin.com/in/...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">CV Link</label>
                                    <input type="url" class="form-control" name="cv_url" value="{{ $item->candidate->cv_url ?? '' }}" placeholder="https://...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Portfolio</label>
                                    <input type="url" class="form-control" name="portfolio_url" value="{{ $item->candidate->portfolio_url ?? '' }}" placeholder="https://...">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Candidate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="milestoneModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('admin.job.candidates.milestones.update', [$job->id, $item->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Add / Update Milestone - {{ $item->candidate->name ?? 'Candidate' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                <div class="alert alert-danger py-2 mb-3">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Milestone</label>
                                    <div class="milestone-list-edit" data-item-id="{{ $item->id }}">
                                        @php $milestones = $item->milestones->isNotEmpty() ? $item->milestones : collect([null]); @endphp
                                        @foreach($milestones as $index => $milestone)
                                            <div class="milestone-item row g-2 align-items-end mb-3">
                                                <div class="col-md-3">
                                                    <select class="form-select" name="milestones[{{ $item->id }}][{{ $index }}][step]">
                                                        @foreach(config('milestones.steps') as $step)
                                                            <option value="{{ $step }}" @selected(($milestone?->step ?? $item->step ?? '') === $step)>{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-select" name="milestones[{{ $item->id }}][{{ $index }}][status]">
                                                        @foreach(config('milestones.statuses') as $status)
                                                            <option value="{{ $status }}" @selected(($milestone?->status ?? $item->status ?? '') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="date" class="form-control" name="milestones[{{ $item->id }}][{{ $index }}][date]" value="{{ $milestone?->date ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label mb-1">Deskripsi</label>
                                                    <textarea class="form-control milestone-notes" name="milestones[{{ $item->id }}][{{ $index }}][notes]" rows="3" maxlength="500" placeholder="Deskripsi milestone (maks. 500 karakter)">{{ $milestone?->notes ?? '' }}</textarea>
                                                    <small class="text-muted milestone-notes-counter">0/500</small>
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <button type="button" class="btn btn-danger btn-sm remove-milestone-btn" title="Remove"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-light btn-sm add-milestone-edit-btn" data-item-id="{{ $item->id }}"><i class="fa fa-plus"></i> Add More Milestone</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Step</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fillCandidate(select) {
                const option = select.options[select.selectedIndex];
                const form = select.closest('form');
                if (!option || !option.value || !form) return;

                const fields = {
                    name: option.dataset.name || '',
                    email: option.dataset.email || '',
                    phone: option.dataset.phone || '',
                    linkedin_url: option.dataset.linkedin || '',
                    cv_url: option.dataset.cv || '',
                    portfolio_url: option.dataset.portfolio || ''
                };

                Object.keys(fields).forEach(function (name) {
                    const field = form.querySelector('input[name="' + name + '"]');
                    if (field) field.value = fields[name];
                });
            }

            if (window.jQuery && typeof window.jQuery.fn.picker === 'function') {
                $('.candidate-picker').picker({
                    search: true,
                    searchAutofocus: true,
                    texts: {
                        trigger: 'Select candidate',
                        search: 'Search candidate',
                        noResult: 'Candidate not found'
                    }
                }).on('sp-change', function () {
                    fillCandidate(this);
                });

                $('.candidate-picker').each(function () {
                    fillCandidate(this);
                });
            }

            function bindMilestoneButtons() {
                document.querySelectorAll('.remove-milestone-btn').forEach(function (button) {
                    button.onclick = function () {
                        const item = button.closest('.milestone-item');
                        if (item) item.remove();
                    };
                });

                document.querySelectorAll('.milestone-notes').forEach(function (textarea) {
                    const counter = textarea.parentElement.querySelector('.milestone-notes-counter');
                    const updateCounter = function () {
                        if (counter) counter.textContent = textarea.value.length + '/500';
                    };
                    textarea.removeEventListener('input', updateCounter);
                    textarea.addEventListener('input', updateCounter);
                    updateCounter();
                });
            }

            document.querySelectorAll('.add-milestone-edit-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const itemId = button.dataset.itemId;
                    const container = document.querySelector('.milestone-list-edit[data-item-id="' + itemId + '"]');
                    if (!container) return;

                    const index = container.querySelectorAll('.milestone-item').length;
                    const prefix = 'milestones[' + itemId + '][' + index + ']';
                    const item = document.createElement('div');
                    item.className = 'milestone-item row g-2 align-items-end mb-3';
                    item.innerHTML = `
                        <div class="col-md-3">
                            <select class="form-select" name="${prefix}[step]">
                                @foreach(config('milestones.steps') as $step)
                                    <option value="{{ $step }}">{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="${prefix}[status]">
                                @foreach(config('milestones.statuses') as $status)
                                    <option value="{{ $status }}">{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="${prefix}[date]">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Deskripsi</label>
                            <textarea class="form-control milestone-notes" name="${prefix}[notes]" rows="3" maxlength="500" placeholder="Deskripsi milestone (maks. 500 karakter)"></textarea>
                            <small class="text-muted milestone-notes-counter">0/500</small>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-milestone-btn" title="Remove"><i class="fa fa-trash"></i></button>
                        </div>`;
                    container.appendChild(item);
                    bindMilestoneButtons();
                });
            });

            bindMilestoneButtons();

            const openMilestoneModalId = '{{ session('open_milestone_modal') ?? '' }}';
            if (openMilestoneModalId) {
                const modalEl = document.getElementById('milestoneModal' + openMilestoneModalId);
                if (modalEl && window.bootstrap && typeof window.bootstrap.Modal === 'function') {
                    const modal = new window.bootstrap.Modal(modalEl);
                    modal.show();
                }
            }
        });
    </script>
@endsection
