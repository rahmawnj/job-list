@extends('dashboard._layout.main')

@push('page-css')
<style>
    .milestone-page-header { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
    .milestone-row-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; }
    .milestone-row-title { margin:0; font-size:14px; font-weight:600; }
    .notes-help { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:6px; color:#6c757d; font-size:12px; }
    .notes-count { white-space:nowrap; }
    .candidate-summary { border:1px solid rgba(0,0,0,.08); border-radius:10px; padding:16px; background:#f8f9fa; margin-bottom:20px; }
</style>
@endpush

@section('container')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.job.candidates', $job->id) }}">Candidates</a></li>
    <li class="breadcrumb-item active">Recruitment Process</li>
</ol>

<div class="milestone-page-header mb-3">
    <div>
        <h1 class="page-header mb-1">Recruitment Process</h1>
        <div class="text-muted">Manage recruitment milestones for this candidate.</div>
    </div>
    <a href="{{ route('admin.job.candidates', $job->id) }}" class="btn btn-default btn-sm">
        <i class="fa fa-arrow-left"></i> Back to Candidates
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ $job->title }}</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger m-3 mb-0" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="panel-body">
                <div class="candidate-summary">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small">Candidate</div>
                            <strong>{{ $jobCandidate->candidate->name ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Email</div>
                            <strong>{{ $jobCandidate->candidate->email ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                @if(empty(config('milestones.steps', [])) || empty(config('milestones.statuses', [])))
                    <div class="alert alert-warning">Recruitment process step/status belum dikonfigurasi di Settings.</div>
                @endif

                <form id="milestoneForm" action="{{ route('admin.job.candidates.milestones.update', [$job->id, $jobCandidate->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div id="milestoneRows" class="milestone-rows">
                        @php
                            $oldMilestones = old('milestones');
                            $formMilestones = is_array($oldMilestones) ? collect($oldMilestones) : $milestones;
                        @endphp

                        @forelse($formMilestones as $index => $milestone)
                            <div class="milestone-row border rounded p-3 mb-3">
                                <div class="milestone-row-header">
                                    <h6 class="milestone-row-title">Recruitment Step {{ $index + 1 }}</h6>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Step</label>
                                        <select name="milestones[{{ $index }}][step]" class="form-control milestone-step" required>
                                            <option value="">Select step</option>
                                            @foreach(config('milestones.steps', []) as $step)
                                                <option value="{{ $step }}" @selected(data_get($milestone, 'step') === $step)>{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select name="milestones[{{ $index }}][status]" class="form-control milestone-status" required>
                                            <option value="">Select status</option>
                                            @foreach(config('milestones.statuses', []) as $status)
                                                <option value="{{ $status }}" @selected(data_get($milestone, 'status') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="milestones[{{ $index }}][date]" class="form-control milestone-date" value="{{ data_get($milestone, 'date') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Link <span class="text-muted">(optional)</span></label>
                                        <input type="url" name="milestones[{{ $index }}][link]" class="form-control milestone-link" maxlength="2048" value="{{ data_get($milestone, 'link') }}" placeholder="https://...">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notes</label>
                                        <textarea name="milestones[{{ $index }}][notes]" class="form-control milestone-notes" rows="4" maxlength="500" placeholder="Add notes or context for this recruitment step...">{{ data_get($milestone, 'notes') }}</textarea>
                                        <div class="notes-help"><span>Describe important updates, feedback, or follow-up details for this step.</span><span class="notes-count"><span class="current-count">{{ strlen((string) data_get($milestone, 'notes')) }}</span>/500</span></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="milestone-row border rounded p-3 mb-3">
                                <div class="milestone-row-header">
                                    <h6 class="milestone-row-title">Recruitment Step 1</h6>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove"><i class="fa fa-trash"></i></button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Step</label>
                                        <select name="milestones[0][step]" class="form-control milestone-step" required>
                                            <option value="">Select step</option>
                                            @foreach(config('milestones.steps', []) as $step)
                                                <option value="{{ $step }}">{{ str_replace('_', ' ', ucfirst($step)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select name="milestones[0][status]" class="form-control milestone-status" required>
                                            <option value="">Select status</option>
                                            @foreach(config('milestones.statuses', []) as $status)
                                                <option value="{{ $status }}">{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="milestones[0][date]" class="form-control milestone-date">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Link <span class="text-muted">(optional)</span></label>
                                        <input type="url" name="milestones[0][link]" class="form-control milestone-link" maxlength="2048" placeholder="https://...">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Notes</label>
                                        <textarea name="milestones[0][notes]" class="form-control milestone-notes" rows="4" maxlength="500" placeholder="Add notes or context for this recruitment step..."></textarea>
                                        <div class="notes-help"><span>Describe important updates, feedback, or follow-up details for this step.</span><span class="notes-count"><span class="current-count">0</span>/500</span></div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if(!empty(config('milestones.steps', [])) && !empty(config('milestones.statuses', [])))
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addMilestone"><i class="fa fa-plus"></i> Add Recruitment Step</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Recruitment Process</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- IMPORTANT: the dashboard layout renders @stack('scripts'), not @stack('page-js'). --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('milestoneRows');
    const addButton = document.getElementById('addMilestone');

    if (!container || !addButton) return;

    function updateNotesCount(row) {
        const textarea = row.querySelector('.milestone-notes');
        const counter = row.querySelector('.current-count');
        if (textarea && counter) counter.textContent = textarea.value.length;
    }

    function reindexRows() {
        container.querySelectorAll('.milestone-row').forEach(function (row, index) {
            const title = row.querySelector('.milestone-row-title');
            const step = row.querySelector('.milestone-step');
            const status = row.querySelector('.milestone-status');
            const date = row.querySelector('.milestone-date');
            const link = row.querySelector('.milestone-link');
            const notes = row.querySelector('.milestone-notes');

            if (title) title.textContent = 'Recruitment Step ' + (index + 1);
            if (step) step.name = 'milestones[' + index + '][step]';
            if (status) status.name = 'milestones[' + index + '][status]';
            if (date) date.name = 'milestones[' + index + '][date]';
            if (link) link.name = 'milestones[' + index + '][link]';
            if (notes) notes.name = 'milestones[' + index + '][notes]';
        });
    }

    function bindRow(row) {
        const notes = row.querySelector('.milestone-notes');
        if (notes) {
            notes.addEventListener('input', function () {
                updateNotesCount(row);
            });
            updateNotesCount(row);
        }
    }

    container.querySelectorAll('.milestone-row').forEach(bindRow);
    reindexRows();

    addButton.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        const rows = container.querySelectorAll('.milestone-row');
        const source = rows[rows.length - 1];
        if (!source) return;

        const clone = source.cloneNode(true);

        clone.querySelectorAll('select').forEach(function (field) {
            field.selectedIndex = 0;
        });

        clone.querySelectorAll('input, textarea').forEach(function (field) {
            field.value = '';
        });

        const counter = clone.querySelector('.current-count');
        if (counter) counter.textContent = '0';

        container.appendChild(clone);
        reindexRows();
        bindRow(clone);

        clone.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        const firstSelect = clone.querySelector('.milestone-step');
        if (firstSelect) firstSelect.focus();
    });

    container.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-milestone');
        if (!removeButton) return;

        event.preventDefault();
        event.stopPropagation();

        const row = removeButton.closest('.milestone-row');
        if (!row) return;

        const rows = container.querySelectorAll('.milestone-row');
        if (rows.length > 1) {
            row.remove();
        } else {
            row.querySelectorAll('select').forEach(function (field) { field.selectedIndex = 0; });
            row.querySelectorAll('input, textarea').forEach(function (field) { field.value = ''; });
            updateNotesCount(row);
        }

        reindexRows();
    });
});
</script>
@endpush
