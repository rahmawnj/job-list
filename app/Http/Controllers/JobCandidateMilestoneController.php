<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JobCandidateMilestoneController extends Controller
{
    public function update(
        Request $request,
        Job $job,
        JobCandidate $jobCandidate
    ) {
        if ($jobCandidate->job_id !== $job->id) {
            abort(404);
        }

        $inputMilestones = $request->input('milestones', []);
        $rawMilestones = [];

        foreach ($inputMilestones as $group) {
            if (
                is_array($group) &&
                (
                    array_key_exists('step', $group) ||
                    array_key_exists('date', $group) ||
                    array_key_exists('notes', $group) ||
                    array_key_exists('status', $group)
                )
            ) {
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
                        array_key_exists('status', $milestone)
                    ) {
                        $rawMilestones[] = $milestone;
                    }
                }
            }
        }

        $validator = Validator::make(
            [
                'milestones' => array_values($rawMilestones),
            ],
            [
                'milestones' => 'nullable|array',
                'milestones.*' => 'array',
                'milestones.*.step' => [
                    'nullable',
                    'string',
                    Rule::in(config('milestones.steps')),
                ],
                'milestones.*.status' => [
                    'nullable',
                    'string',
                    Rule::in(config('milestones.statuses')),
                ],
                'milestones.*.date' => [
                    'nullable',
                    'date',
                ],
                'milestones.*.notes' => [
                    'nullable',
                    'string',
                    'max:500',
                ],
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->route('admin.job.candidates', $job->id)
                ->withErrors($validator)
                ->withInput()
                ->with('open_milestone_modal', $jobCandidate->id);
        }

        $validated = $validator->validated();
        $milestones = $validated['milestones'] ?? [];

        $jobCandidate->milestones()->delete();

        foreach ($milestones as $milestone) {
            if (!is_array($milestone)) {
                continue;
            }

            $step = $milestone['step'] ?? null;

            $jobCandidate->milestones()->create([
                'step' => $step,
                'status' => $milestone['status'] ?? null,
                'date' => $milestone['date'] ?? null,
                'notes' => $milestone['notes'] ?? null,
            ]);
        }

        $latestMilestone = collect($milestones)
            ->filter(fn ($milestone) => is_array($milestone))
            ->last();

        $jobCandidate->update([
            'step' => $latestMilestone['step'] ?? null,
            'status' => $latestMilestone['status'] ?? null,
        ]);

        return redirect()
            ->route('admin.job.candidates', $job->id)
            ->with('success', 'Milestone updated.');
    }
}
