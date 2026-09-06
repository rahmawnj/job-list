<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JobCandidateMilestoneController extends Controller
{
    public function edit(Job $job, JobCandidate $jobCandidate)
    {
        if ((int) $jobCandidate->job_id !== (int) $job->id) {
            abort(404);
        }

        $jobCandidate->load(['candidate', 'milestones']);

        return view('dashboard.jobs.candidate_milestones', [
            'title' => 'Recruitment Process',
            'job' => $job,
            'jobCandidate' => $jobCandidate,
            'milestones' => $jobCandidate->milestones->values(),
        ]);
    }

    public function update(
        Request $request,
        Job $job,
        JobCandidate $jobCandidate
    ) {
        if ((int) $jobCandidate->job_id !== (int) $job->id) {
            abort(404);
        }

        $inputMilestones = $request->input('milestones', []);
        $rawMilestones = [];

        foreach ($inputMilestones as $group) {
            if (is_array($group) && (
                array_key_exists('step', $group) ||
                array_key_exists('date', $group) ||
                array_key_exists('notes', $group) ||
                array_key_exists('status', $group) ||
                array_key_exists('link', $group)
            )) {
                $rawMilestones[] = $group;
                continue;
            }

            if (is_array($group)) {
                foreach ($group as $milestone) {
                    if (!is_array($milestone)) {
                        continue;
                    }

                    if (
                        array_key_exists('step', $milestone) ||
                        array_key_exists('date', $milestone) ||
                        array_key_exists('notes', $milestone) ||
                        array_key_exists('status', $milestone) ||
                        array_key_exists('link', $milestone)
                    ) {
                        $rawMilestones[] = $milestone;
                    }
                }
            }
        }

        $validator = Validator::make(
            ['milestones' => array_values($rawMilestones)],
            [
                'milestones' => 'nullable|array',
                'milestones.*' => 'array',
                'milestones.*.step' => [
                    'required',
                    'string',
                    Rule::in(config('milestones.steps')),
                ],
                'milestones.*.status' => [
                    'required',
                    'string',
                    Rule::in(config('milestones.statuses')),
                ],
                'milestones.*.date' => ['nullable', 'date'],
                'milestones.*.notes' => ['nullable', 'string', 'max:500'],
                'milestones.*.link' => ['nullable', 'url', 'max:2048'],
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->route('admin.job.candidates.milestones.edit', [$job->id, $jobCandidate->id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $milestones = $validated['milestones'] ?? [];

        $jobCandidate->milestones()->delete();

        foreach ($milestones as $milestone) {
            $jobCandidate->milestones()->create([
                'step' => $milestone['step'],
                'status' => $milestone['status'],
                'date' => $milestone['date'] ?? null,
                'notes' => $milestone['notes'] ?? null,
                'link' => $milestone['link'] ?? null,
            ]);
        }

        return redirect()
            ->route('admin.job.candidates', $job->id)
            ->with('success', 'Recruitment process updated successfully.');
    }
}
