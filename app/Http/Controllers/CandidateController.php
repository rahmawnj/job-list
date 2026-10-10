<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        // DataTables server-side: return only the requested page as JSON.
        if ($request->ajax() && $request->has('draw')) {
            $draw = (int) $request->input('draw');
            $start = max(0, (int) $request->input('start', 0));
            $length = (int) $request->input('length', 10);
            $length = $length === -1 ? 1000 : min(max($length, 1), 100);
            $search = trim((string) $request->input('search.value', ''));

            $totalRecords = Candidate::count();

            $query = Candidate::query()->with([
                'jobCandidates.job',
                'jobCandidates.milestones',
            ]);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('linkedin_url', 'like', "%{$search}%")
                        ->orWhere('cv_url', 'like', "%{$search}%")
                        ->orWhereHas('jobCandidates.job', function ($jobQuery) use ($search) {
                            $jobQuery->where('title', 'like', "%{$search}%");
                        })
                        ->orWhereHas('jobCandidates.milestones', function ($milestoneQuery) use ($search) {
                            $milestoneQuery->where('step', 'like', "%{$search}%")
                                ->orWhere('status', 'like', "%{$search}%");
                        });
                });
            }

            $recordsFiltered = (clone $query)->count();

            $order = $request->input('order.0');
            $orderColumns = [
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'phone',
            ];

            if ($order && isset($order['column'], $order['dir'])) {
                $columnIndex = (int) $order['column'];
                $direction = $order['dir'] === 'asc' ? 'asc' : 'desc';
                $column = $orderColumns[$columnIndex] ?? 'id';
                $query->orderBy($column, $direction);
            } else {
                $query->orderByDesc('created_at')->orderByDesc('id');
            }

            $candidates = $query->skip($start)->take($length)->get();

            $data = $candidates->values()->map(function ($candidate, $key) use ($start) {
                $jobsApplied = $candidate->jobCandidates;
                $latestJobCandidate = $jobsApplied->sortByDesc('created_at')->first();
                $latestMilestone = $latestJobCandidate
                    ? $latestJobCandidate->milestones->sortByDesc('date')->first()
                    : null;

                $latestStep = $latestMilestone->step ?? $latestJobCandidate->step ?? null;
                $latestDate = $latestMilestone->date ?? $latestJobCandidate->date ?? null;

                return [
                    'no' => $start + $key + 1,
                    'name' => $candidate->name,
                    'email' => $candidate->email,
                    'phone' => $candidate->phone,
                    'jobs' => $jobsApplied->map(function ($jobCandidate) {
                        return [
                            'title' => optional($jobCandidate->job)->title ?? 'Unknown Job',
                            'url' => url('/dashboard/jobs/' . $jobCandidate->job_id . '/candidates'),
                        ];
                    })->values(),
                    'latest_milestone' => $latestStep
                        ? str_replace('_', ' ', ucfirst($latestStep))
                            . ($latestDate ? ' · ' . \Carbon\Carbon::parse($latestDate)->format('d-m-Y') : '')
                        : '-',
                    'linkedin_url' => $candidate->linkedin_url,
                    'cv_url' => $candidate->cv_url,
                    'edit_url' => url('/dashboard/candidates/' . $candidate->id . '/edit'),
                    'show_url' => url('/dashboard/candidates/' . $candidate->id),
                    'delete_url' => url('/dashboard/candidates/' . $candidate->id),
                ];
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
            ]);
        }

        return view('dashboard.candidates.index', [
            'title' => 'Candidates',
        ]);
    }

    public function create()
    {
        return view('dashboard.candidates.create', [
            'title' => 'Create Candidate',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'cv_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
        ]);

        Candidate::create($validated);

        return redirect('/dashboard/candidates')->with('success', 'Candidate has been added.');
    }

    public function show(Candidate $candidate)
    {
        $candidate->load([
            'jobCandidates.job.company',
            'jobCandidates.milestones',
        ]);

        return view('dashboard.candidates.show', [
            'title' => 'Candidate Detail',
            'candidate' => $candidate,
        ]);
    }

    public function edit(Candidate $candidate)
    {
        return view('dashboard.candidates.edit', [
            'title' => 'Edit Candidate',
            'candidate' => $candidate,
        ]);
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'cv_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'notes' => 'nullable|string',
        ]);

        $candidate->update($validated);

        return redirect('/dashboard/candidates')->with('success', 'Candidate has been updated.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return redirect('/dashboard/candidates')->with('success', 'Candidate has been deleted.');
    }
}
