<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Mail\MailNotify;
use App\Models\ApplyJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplyJobController extends Controller
{
    /**
     * Open the user's default mail application for a job application.
     *
     * No application data or CV is stored locally when the user clicks
     * Apply Job from the public jobs page.
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

        $mailto = 'mailto:' . $recipient
            . '?subject=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);

        return redirect()->away($mailto);
    }

    /**
     * Legacy POST endpoint.
     *
     * The public Apply Job flow no longer uses this endpoint. It is kept so
     * old links/forms do not cause a missing-route error, but it does not
     * save uploaded files or create an ApplyJob record anymore.
     */
    public function apply_job_post(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
        ]);

        return $this->apply_job($request->input('job_id'));
    }
}
