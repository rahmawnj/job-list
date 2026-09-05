@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.candidates.index') }}">Candidates</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>

    <h1 class="page-header">{{ $title }}</h1>

    <div class="row mb-3">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Candidate Information</h4>
                </div>
                <div class="panel-body">
                    <dl class="row mb-0">
                        <dt class="col-md-3">Name</dt>
                        <dd class="col-md-9">{{ $candidate->name }}</dd>
                        <dt class="col-md-3">Email</dt>
                        <dd class="col-md-9">{{ $candidate->email ?? '-' }}</dd>
                        <dt class="col-md-3">Phone</dt>
                        <dd class="col-md-9">{{ $candidate->phone ?? '-' }}</dd>
                        <dt class="col-md-3">LinkedIn</dt>
                        <dd class="col-md-9">
                            @if($candidate->linkedin_url)
                                <a href="{{ $candidate->linkedin_url }}" target="_blank">Open</a>
                            @else
                                -
                            @endif
                        </dd>
                        <dt class="col-md-3">CV</dt>
                        <dd class="col-md-9">
                            @if($candidate->cv_url)
                                <a href="{{ $candidate->cv_url }}" target="_blank">Open</a>
                            @else
                                -
                            @endif
                        </dd>
                        <dt class="col-md-3">Portfolio</dt>
                        <dd class="col-md-9">
                            @if($candidate->portfolio_url)
                                <a href="{{ $candidate->portfolio_url }}" target="_blank">Open</a>
                            @else
                                -
                            @endif
                        </dd>
                        <dt class="col-md-3">Notes</dt>
                        <dd class="col-md-9">{!! nl2br(e($candidate->notes ?? '-')) !!}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Jobs</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Job</th>
                                    <th>Company</th>
                                    <th>Latest Status</th>
                                    <th>Latest Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($candidate->jobCandidates as $jobCandidate)
                                    @php
                                        $latestMilestone = $jobCandidate->milestones->sortByDesc('date')->first();
                                        $latestStatus = $latestMilestone?->status ?? $jobCandidate->status ?? '-';
                                        $latestDate = $latestMilestone?->date ?? $jobCandidate->date;
                                    @endphp
                                    <tr>
                                        <td>{{ optional($jobCandidate->job)->title ?? 'Unknown Job' }}</td>
                                        <td>{{ optional($jobCandidate->job?->company)->name ?? '-' }}</td>
                                        <td>{{ str_replace('_', ' ', ucfirst($latestStatus)) }}</td>
                                        <td>{{ $latestDate ? \Carbon\Carbon::parse($latestDate)->format('d-m-Y') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No jobs yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.candidates.index') }}" class="btn btn-default">Back</a>
@endsection
