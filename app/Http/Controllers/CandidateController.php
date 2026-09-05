<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::with([
            'jobCandidates.job',
            'jobCandidates.milestones'
        ])->orderBy('created_at', 'desc')->get();

        return view('dashboard.candidates.index', [
            'title' => 'Candidates',
            'candidates' => $candidates,
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
