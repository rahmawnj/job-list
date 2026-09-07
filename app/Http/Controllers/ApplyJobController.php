<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class ApplyJobController extends Controller
{
    /**
     * Open the user's default mail application for a job application.
     *
     * No application data or CV is stored locally or in the database.
     */
    public function apply_job($id_job)
    {
        $job = Job::findOrFail($id_job);

        // Keep the existing recruitment email used by the application flow.
        $recipient = 'liim@toptalentscosulting.co.id';
        $subject = 'Lamaran : ' . $job->title;

        $body = "Halo Tim Top Talents Consulting,\n\n"
            . "Saya tertarik untuk melamar posisi {$job->title}.\n\n"
            . "Berikut saya sampaikan lamaran saya untuk dapat dipertimbangkan.\n\n"
            . "Terima kasih.\n\n"
            . "Hormat saya,\n";

        // mailto opens the user's configured default email application
        // (Gmail, Outlook, Apple Mail, etc.).
        $mailto = 'mailto:' . $recipient
            . '?subject=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);

        return redirect()->away($mailto);
    }

    /**
     * Legacy POST endpoint.
     *
     * Kept so old links/forms do not cause a missing-route error. It no
     * longer saves uploaded files or creates an ApplyJob record.
     */
    public function apply_job_post(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
        ]);

        return $this->apply_job($request->input('job_id'));
    }
}
