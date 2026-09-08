<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplyJobController extends Controller
{
    /**
     * Open Gmail compose for a job application.
     *
     * No application data or CV is stored locally or in the database.
     */
    public function apply_job($id_job)
    {
        $job = Job::findOrFail($id_job);

        // Get the application recipient from the Email Apply content setting.
        $recipient = Content::where('name', 'email_apply')->value('description');
        $subject = 'Lamaran : ' . $job->title;

        $body = "Halo Tim Top Talents Consulting,\n\n"
            . "Saya tertarik untuk melamar posisi {$job->title}.\n\n"
            . "Berikut saya sampaikan lamaran saya untuk dapat dipertimbangkan.\n\n"
            . "Terima kasih.\n\n"
            . "Hormat saya,\n";

        // Open Gmail web compose with the recipient, subject, and body prefilled.
        $gmailUrl = 'https://mail.google.com/mail/?view=cm&fs=1'
            . '&to=' . rawurlencode($recipient)
            . '&su=' . rawurlencode($subject)
            . '&body=' . rawurlencode($body);

        return redirect()->away($gmailUrl);
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
