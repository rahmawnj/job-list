@extends('dashboard._layout.main')

@push('page-css')
<link href="{{ asset('assets/dashboard/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
<style>
    .milestone-row-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; }
    .milestone-row-title { margin:0; font-size:14px; font-weight:600; }
    .notes-help { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:6px; color:#6c757d; font-size:12px; }
    .notes-count { white-space:nowrap; }
    .milestone-form-alert { margin-bottom:16px; }
</style>
@endpush

@section('container')
<ol class="breadcrumb"><li class="breadcrumb-item"><a href="javascript:;">Home</a></li><li class="breadcrumb-item active">{{$title}}</li></ol>
<h1 class="page-header">{{$title}}</h1>

<div class="row mb-3"><div class="col-12"><div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">{{ $job->title }}</h4>
        <div class="panel-heading-btn">
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#candidateModal"><i class="fa fa-user-plus"></i> Assign Candidate</button>
            <a href="/dashboard/jobs" class="btn btn-default btn-sm">Back to Jobs</a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert"><i class="fa fa-check-circle me-1"></i> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert"><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    @endif

    <div class="panel-body"><div class="table-responsive"><table class="table table-striped table-bordered align-middle">
        <thead><tr><th>No</th><th>Name</th><th>Email</th><th>CV Link</th><th>Recruitment Process</th><th>Action</th></tr></thead>
        <tbody>
        @forelse ($jobCandidates as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->candidate->name ?? '-' }}</td>
                <td>{{ $item->candidate->email ?? '-' }}</td>
                <td>@if($item->candidate && $item->candidate->cv_url)<a href="{{ $item->candidate->cv_url }}" target="_blank">Open CV</a>@else - @endif</td>
                <td>
                    @if($item->milestones->isNotEmpty())
                        <div class="d-flex flex-column gap-1">@foreach($item->milestones as $milestone)<div>{{ str_replace('_', ' ', ucfirst($milestone->step)) }} <span class="text-muted">({{ str_replace('_', ' ', ucfirst($milestone->status ?? '-')) }})</span></div>@endforeach</div>
                    @else <span class="text-muted">No recruitment process yet</span> @endif
                </td>
                <td><div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#milestoneModal{{ $item->id }}"><i class="fa fa-list-check"></i> Recruitment Process</button>
                    <form action="{{ route('admin.job.candidates.destroy', [$job->id, $item->id]) }}" method="POST" onsubmit="return confirm('Unassign this candidate from this job?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-user-minus"></i> Unassign</button></form>
                </div></td>
            </tr>

            <div class="modal fade" id="milestoneModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"><div class="modal-content">
                    <form id="milestoneForm{{ $item->id }}" action="{{ route('admin.job.candidates.milestones.update', [$job->id, $item->id]) }}" method="POST" class="milestone-form">
                        @csrf @method('PUT')
                        <div class="modal-header"><h5 class="modal-title">Recruitment Process - {{ $item->candidate->name ?? 'Candidate' }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                        <div class="modal-body">
                            <div class="alert alert-danger d-none milestone-form-alert" role="alert"></div>
                            <p class="text-muted mb-3">Atur tahapan recruitment untuk candidate ini. Isi Step dan Status pada setiap tahap, lalu klik Save Recruitment Process.</p>
                            <div id="milestoneRows{{ $item->id }}" class="milestone-rows">
                                @php $candidateMilestones = $item->milestones->values(); @endphp
                                @forelse($candidateMilestones as $index => $milestone)
                                    <div class="milestone-row border rounded p-3 mb-3">
                                        <div class="milestone-row-header"><h6 class="milestone-row-title">Recruitment Step {{ $index + 1 }}</h6><button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove"><i class="fa fa-trash"></i></button></div>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label class="form-label">Step</label><select name="milestones[{{ $index }}][step]" class="form-control milestone-step" required><option value="">Select step</option>@foreach(config('milestones.steps', []) as $step)<option value="{{ $step }}" @selected($milestone->step === $step)>{{ str_replace('_', ' ', ucfirst($step)) }}</option>@endforeach</select></div>
                                            <div class="col-md-3"><label class="form-label">Status</label><select name="milestones[{{ $index }}][status]" class="form-control milestone-status" required><option value="">Select status</option>@foreach(config('milestones.statuses', []) as $status)<option value="{{ $status }}" @selected($milestone->status === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>@endforeach</select></div>
                                            <div class="col-md-5"><label class="form-label">Date</label><input type="date" name="milestones[{{ $index }}][date]" class="form-control milestone-date" value="{{ $milestone->date }}"></div>
                                            <div class="col-12"><label class="form-label">Link <span class="text-muted">(optional)</span></label><input type="url" name="milestones[{{ $index }}][link]" class="form-control milestone-link" maxlength="2048" value="{{ $milestone->link }}" placeholder="https://..."><small class="text-muted">Tambahkan link terkait step ini, misalnya meeting, assessment, dokumen, atau hasil interview.</small></div>
                                            <div class="col-12"><label class="form-label">Notes</label><textarea name="milestones[{{ $index }}][notes]" class="form-control milestone-notes" rows="4" maxlength="500" placeholder="Add notes or context for this recruitment step...">{{ $milestone->notes }}</textarea><div class="notes-help"><span>Describe important updates, feedback, or follow-up details for this step.</span><span class="notes-count"><span class="current-count">{{ strlen($milestone->notes ?? '') }}</span>/500</span></div></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="milestone-row border rounded p-3 mb-3">
                                        <div class="milestone-row-header"><h6 class="milestone-row-title">Recruitment Step 1</h6><button type="button" class="btn btn-outline-danger btn-sm remove-milestone" title="Remove"><i class="fa fa-trash"></i></button></div>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label class="form-label">Step</label><select name="milestones[0][step]" class="form-control milestone-step" required><option value="">Select step</option>@foreach(config('milestones.steps', []) as $step)<option value="{{ $step }}">{{ str_replace('_', ' ', ucfirst($step)) }}</option>@endforeach</select></div>
                                            <div class="col-md-3"><label class="form-label">Status</label><select name="milestones[0][status]" class="form-control milestone-status" required><option value="">Select status</option>@foreach(config('milestones.statuses', []) as $status)<option value="{{ $status }}">{{ str_replace('_', ' ', ucfirst($status)) }}</option>@endforeach</select></div>
                                            <div class="col-md-5"><label class="form-label">Date</label><input type="date" name="milestones[0][date]" class="form-control milestone-date"></div>
                                            <div class="col-12"><label class="form-label">Link <span class="text-muted">(optional)</span></label><input type="url" name="milestones[0][link]" class="form-control milestone-link" maxlength="2048" placeholder="https://..."><small class="text-muted">Tambahkan link terkait step ini, misalnya meeting, assessment, dokumen, atau hasil interview.</small></div>
                                            <div class="col-12"><label class="form-label">Notes</label><textarea name="milestones[0][notes]" class="form-control milestone-notes" rows="4" maxlength="500" placeholder="Add notes or context for this recruitment step..."></textarea><div class="notes-help"><span>Describe important updates, feedback, or follow-up details for this step.</span><span class="notes-count"><span class="current-count">0</span>/500</span></div></div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            @if(empty(config('milestones.steps', [])) || empty(config('milestones.statuses', [])))
                                <div class="alert alert-warning mb-0">Recruitment process step/status belum dikonfigurasi di Settings.</div>
                            @else
                                <button type="button" class="btn btn-outline-primary btn-sm add-milestone" data-target="milestoneRows{{ $item->id }}"><i class="fa fa-plus"></i> Add Recruitment Step</button>
                            @endif
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary" @disabled(empty(config('milestones.steps', [])) || empty(config('milestones.statuses', [])))><i class="fa fa-save"></i> Save Recruitment Process</button></div>
                    </form>
                </div></div>
            </div>
        @empty
            <tr><td colspan="6" class="text-center">No candidate assigned to this job yet.</td></tr>
        @endforelse
        </tbody>
    </table></div></div>
</div></div></div>

<div class="modal fade" id="candidateModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content">
    <form action="{{ route('admin.job.candidates.store', $job->id) }}" method="POST">@csrf
        <div class="modal-header"><h5 class="modal-title">Assign Candidate - {{ $job->title }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body"><div class="mb-3"><label class="form-label">Job</label><input type="text" class="form-control" value="{{ $job->title }}" readonly></div><div><label class="form-label">Candidate</label><select class="form-control candidate-picker" name="candidate_id" required><option value="">Select candidate</option>@foreach ($candidateOptions as $candidate)<option value="{{ $candidate->id }}" @selected(old('candidate_id') == $candidate->id)>{{ $candidate->name }} - {{ $candidate->email ?? 'No email' }}</option>@endforeach</select></div>@if ($candidateOptions->isEmpty())<div class="alert alert-info mt-3 mb-0">Semua candidate sudah di-assign ke job ini.</div>@endif</div>
        <div class="modal-footer"><button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary" @disabled($candidateOptions->isEmpty())><i class="fa fa-user-plus"></i> Assign Candidate</button></div>
    </form>
</div></div></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery && typeof window.jQuery.fn.picker === 'function') $('.candidate-picker').picker({search:true, searchAutofocus:true, texts:{trigger:'Select candidate', search:'Search candidate', noResult:'Candidate not found'}});

    function updateNotesCount(textarea) { const counter = textarea?.closest('.col-12')?.querySelector('.current-count'); if (counter) counter.textContent = textarea.value.length; }
    function updateTitles(container) { container.querySelectorAll('.milestone-row').forEach((row,i)=>{ const t=row.querySelector('.milestone-row-title'); if(t)t.textContent='Recruitment Step '+(i+1); }); }
    function reindex(container) {
        container.querySelectorAll('.milestone-row').forEach((row,index)=>{
            row.querySelector('.milestone-step').name=`milestones[${index}][step]`;
            row.querySelector('.milestone-status').name=`milestones[${index}][status]`;
            row.querySelector('.milestone-date').name=`milestones[${index}][date]`;
            row.querySelector('.milestone-link').name=`milestones[${index}][link]`;
            row.querySelector('.milestone-notes').name=`milestones[${index}][notes]`;
        });
        updateTitles(container);
    }
    function showError(form,message,field){ const alert=form.querySelector('.milestone-form-alert'); if(alert){alert.textContent=message;alert.classList.remove('d-none');} field?.focus(); field?.scrollIntoView({behavior:'smooth',block:'center'}); }

    document.querySelectorAll('.milestone-notes').forEach(t=>{t.addEventListener('input',()=>updateNotesCount(t));updateNotesCount(t);});

    document.addEventListener('click', function(event){
        const add=event.target.closest('.add-milestone');
        if(add){
            event.preventDefault();
            const container=document.getElementById(add.dataset.target); if(!container)return;
            const rows=container.querySelectorAll('.milestone-row'); const source=rows[rows.length-1]; if(!source)return;
            const clone=source.cloneNode(true); const nextIndex=rows.length;
            clone.querySelector('.milestone-step').name=`milestones[${nextIndex}][step]`; clone.querySelector('.milestone-step').value='';
            clone.querySelector('.milestone-status').name=`milestones[${nextIndex}][status]`; clone.querySelector('.milestone-status').value='';
            clone.querySelector('.milestone-date').name=`milestones[${nextIndex}][date]`; clone.querySelector('.milestone-date').value='';
            clone.querySelector('.milestone-link').name=`milestones[${nextIndex}][link]`; clone.querySelector('.milestone-link').value='';
            clone.querySelector('.milestone-notes').name=`milestones[${nextIndex}][notes]`; clone.querySelector('.milestone-notes').value='';
            clone.querySelector('.current-count').textContent='0';
            container.appendChild(clone);
            updateTitles(container);
            const notes=clone.querySelector('.milestone-notes'); notes.addEventListener('input',()=>updateNotesCount(notes));
            clone.scrollIntoView({behavior:'smooth',block:'nearest'}); clone.querySelector('.milestone-step')?.focus();
            return;
        }
        const remove=event.target.closest('.remove-milestone');
        if(remove){
            event.preventDefault();
            const row=remove.closest('.milestone-row'); const container=row?.closest('.milestone-rows'); if(!row||!container)return;
            const rows=container.querySelectorAll('.milestone-row');
            if(rows.length>1) row.remove(); else { row.querySelector('.milestone-step').value=''; row.querySelector('.milestone-status').value=''; row.querySelector('.milestone-date').value=''; row.querySelector('.milestone-link').value=''; row.querySelector('.milestone-notes').value=''; updateNotesCount(row.querySelector('.milestone-notes')); }
            reindex(container);
        }
    });

    document.querySelectorAll('.milestone-form').forEach(function(form){
        form.addEventListener('submit', function(event){
            const container=form.querySelector('.milestone-rows'); if(!container)return;
            reindex(container);
            const rows=container.querySelectorAll('.milestone-row'); let invalid=null; let message='';
            rows.forEach((row,index)=>{ if(invalid)return; const step=row.querySelector('.milestone-step'); const status=row.querySelector('.milestone-status'); if(!step.value){invalid=step;message=`Recruitment Step ${index+1}: pilih Step terlebih dahulu.`;} else if(!status.value){invalid=status;message=`Recruitment Step ${index+1}: pilih Status terlebih dahulu.`;} });
            if(invalid){event.preventDefault();showError(form,message,invalid);return;}
            form.querySelector('.milestone-form-alert')?.classList.add('d-none');
        });
        form.addEventListener('invalid',function(event){const alert=form.querySelector('.milestone-form-alert');if(alert&&event.target?.validationMessage){alert.textContent=event.target.validationMessage;alert.classList.remove('d-none');}},true);
    });

    @if(session('open_milestone_modal'))
        const milestoneModal=document.getElementById('milestoneModal{{ session('open_milestone_modal') }}');
        if(milestoneModal&&window.bootstrap&&typeof window.bootstrap.Modal==='function') new window.bootstrap.Modal(milestoneModal).show();
    @endif
});
</script>
@endsection