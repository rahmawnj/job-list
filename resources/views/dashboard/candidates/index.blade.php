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
                        <table class="table table-striped table-bordered align-middle">
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
                            <tbody>
                                @forelse ($candidates as $candidate)
                                    @php
                                        $jobsApplied = $candidate->jobCandidates;
                                        $latestJobCandidate = $jobsApplied->sortByDesc('created_at')->first();
                                        $latestMilestone = $latestJobCandidate?->milestones->sortByDesc('date')->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $candidate->name }}</td>
                                        <td>{{ $candidate->email ?? '-' }}</td>
                                        <td>{{ $candidate->phone ?? '-' }}</td>
                                        <td>
                                            @if($jobsApplied->isNotEmpty())
                                                <div class="d-flex flex-column gap-1">
                                                    @foreach($jobsApplied as $jobCandidate)
                                                        <div>
                                                            <a href="{{ route('admin.job.candidates', $jobCandidate->job_id) }}" class="text-primary">
                                                                {{ optional($jobCandidate->job)->title ?? 'Unknown Job' }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($latestMilestone)
                                                <div>{{ str_replace('_', ' ', ucfirst($latestMilestone->step)) }}</div>
                                                <small class="text-muted">{{ $latestMilestone->date ? \Carbon\Carbon::parse($latestMilestone->date)->format('d-m-Y') : '-' }}</small>
                                            @elseif($latestJobCandidate)
                                                <div>{{ str_replace('_', ' ', ucfirst($latestJobCandidate->step)) }}</div>
                                                <small class="text-muted">{{ $latestJobCandidate->date ? \Carbon\Carbon::parse($latestJobCandidate->date)->format('d-m-Y') : '-' }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($candidate->linkedin_url)
                                                <a href="{{ $candidate->linkedin_url }}" target="_blank">Open</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($candidate->cv_url)
                                                <a href="{{ $candidate->cv_url }}" target="_blank">Open</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/dashboard/candidates/{{ $candidate->id }}/edit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.candidates.show', $candidate) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                            <form action="/dashboard/candidates/{{ $candidate->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this candidate?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No candidate data yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
