<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Mail\MailNotify;
use App\Models\ApplyJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ApplyJobController extends Controller
{
    public function apply_job($id_job)
    {
        return view('homepage.apply_job', [
            'title' => 'Apply_Job',
            'id_job' => $id_job
        ]);
    }

    public function apply_job_post(Request $request)
    {
       
        $request->validate([
            'job_id' => 'required',
            'description' => 'required',
            'email' => 'required',
            'name' => 'required',
            'document' => 'required|mimes:pdf,doc,docx|max:2048'
        ]);

        // if ($request->hasFile('document') && $request->file('document')->isValid()) {
            // $file_ext = $request->file('document')->extension();
            // $document = $applyJob->addMediaFromRequest('document')->usingFileName(Str::random(40) . '.' . $file_ext)->toMediaCollection('document');
            
            // $applyJob->url = $document->id % 100 . '/'. $document->file_name;
            // $applyJob->save();

            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $newFileName =strtolower(str_replace(' ', '', $request->name)) . '-' . time() . '.' . $extension;
            $path = $file->storeAs('uploads/files', $newFileName);
        // }
           ApplyJob::create([
            'job_id' => $request->job_id,
            'description' => $request->description,
            'name' => $request->name,
            'email' => $request->email,
            'url' => $path
        ]);

        $job = Job::find($request->job_id);

        Mail::to('liim@toptalentscosulting.co.id')->send(new MailNotify([
            'subject' => 'Lamaran : ' . $job->title,
            'to' => 'liim@toptalentscosulting.co.id            ',
            'from' => 'official@toptalentsconsulting.co.id',
            'text' => 'Ada Pelamar Baru. Segera cek CV nya! <br> <a class="btn btn-primary" href='. asset('storage/' . $path).'> CV nya</a>',
            'text' => `Nama : $request->name <br> $request->description <br> <a href='http://toptalentsconsulting.co.id/`. asset('storage/' . $path) .`' class="btn btn-danger"> Download Resume </a>`,

        ]));

        return redirect()->route('apply_job', $request->input('job_id'))->with('success', 'Lamaran Berhasil Dikirim!');

    }
}
