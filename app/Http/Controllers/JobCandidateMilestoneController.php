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
        // Pastikan candidate memang milik job yang dipilih
        if ($jobCandidate->job_id !== $job->id) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data milestones
        |--------------------------------------------------------------------------
        |
        | Data yang masuk bisa berbentuk:
        |
        | milestones[4][0][step]
        | milestones[4][0][date]
        | milestones[4][0][notes]
        |
        | atau:
        |
        | milestones[0][step]
        | milestones[0][date]
        | milestones[0][notes]
        |
        */

        $inputMilestones = $request->input('milestones', []);

        $rawMilestones = [];

        /*
        |--------------------------------------------------------------------------
        | Normalisasi struktur milestones
        |--------------------------------------------------------------------------
        */

        foreach ($inputMilestones as $group) {

            // Jika langsung berupa milestone
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

            // Jika berupa group seperti:
            // 4 => [
            //     0 => [
            //         'step' => ...
            //     ]
            // ]
            if (is_array($group)) {
                foreach ($group as $milestone) {

                    if (!is_array($milestone)) {
                        continue;
                    }

                    // Jika masih nested, cek lagi
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

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

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
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Jika validasi gagal
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {
            return redirect()
                ->route('admin.job.candidates', $job->id)
                ->withErrors($validator)
                ->withInput()
                ->with('open_milestone_modal', $jobCandidate->id);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data yang sudah tervalidasi
        |--------------------------------------------------------------------------
        */

        $validated = $validator->validated();

        $milestones = $validated['milestones'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Hapus milestone lama
        |--------------------------------------------------------------------------
        */

        $jobCandidate->milestones()->delete();

        /*
        |--------------------------------------------------------------------------
        | Simpan milestone baru
        |--------------------------------------------------------------------------
        */

        foreach ($milestones as $milestone) {

            if (!is_array($milestone)) {
                continue;
            }

            $step = $milestone['step'] ?? 'send_resume';

            if ($step === null || $step === '') {
                $step = 'send_resume';
            }

            $jobCandidate->milestones()->create([
                'step' => $step,
                'status' => $milestone['status'] ?? 'pending',
                'date' => $milestone['date'] ?? null,
                'notes' => $milestone['notes'] ?? null,
            ]);
        }

        $latestMilestone = collect($milestones)->filter(fn ($milestone) => is_array($milestone))->last();
        $jobCandidate->update([
            'step' => $latestMilestone['step'] ?? $jobCandidate->step,
            'status' => $latestMilestone['status'] ?? $jobCandidate->status ?? 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Selesai
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.job.candidates', $job->id)
            ->with('success', 'Milestone updated.');
    }

}
