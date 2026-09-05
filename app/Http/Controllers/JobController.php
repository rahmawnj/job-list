<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\ApplyJob;
use App\Models\Location;
use App\Models\Jobcategory;
use App\Models\Candidate;
use App\Models\JobCandidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Server-side DataTables: balas JSON kalau request AJAX + ada param draw.
        if ($request->ajax() && $request->has('draw')) {
            $draw   = (int) $request->input('draw');
            $start  = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            $search = trim((string) $request->input('search.value', ''));

            // Total record (mengikuti default scope model, soft delete sudah otomatis)
            $totalRecords = Job::count();

            // Query dasar + relasi
            $query = Job::query()
                ->with(['company', 'jobcategory'])
                ->withCount('applyjobs');

            // Global search
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhereHas('company', function ($qc) use ($search) {
                          $qc->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('jobcategory', function ($qc) use ($search) {
                          $qc->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $recordsFiltered = (clone $query)->count();

            // Ordering dari DataTables (order.0.column & order.0.dir)
            $order = $request->input('order.0');
            if ($order && isset($order['column'], $order['dir'])) {
                $columns = ['id', 'image', 'title', 'company_name', 'jobcategory_name', 'apply_count', 'action'];
                $orderColumn = $columns[(int) $order['column']] ?? 'id';
                $orderDir = $order['dir'] === 'asc' ? 'asc' : 'desc';

                switch ($orderColumn) {
                    case 'title':
                        $query->orderBy('jobs.title', $orderDir);
                        break;
                    case 'company_name':
                        $query->orderBy(
                            Company::select('name')->whereColumn('companies.id', 'jobs.company_id'),
                            $orderDir
                        );
                        break;
                    case 'jobcategory_name':
                        $query->orderBy(
                            Jobcategory::select('name')->whereColumn('jobcategories.id', 'jobs.jobcategory_id'),
                            $orderDir
                        );
                        break;
                    case 'apply_count':
                        $query->orderBy('applyjobs_count', $orderDir);
                        break;
                    default:
                        $query->orderBy('jobs.id', $orderDir);
                }
            } else {
                $query->orderBy('jobs.id', 'desc');
            }

            $jobs = $query->skip($start)->take($length)->get();

            $data = $jobs->map(function ($job, $key) use ($start) {
                $imageUrl = $job->image
                    ? asset('storage/' . $job->image)
                    : asset('img/default.png');

                return [
                    'no'              => $start + $key + 1,
                    'image'           => $imageUrl,
                    'title'           => $job->title,
                    'company_name'    => optional($job->company)->name ?? '-',
                    'jobcategory_name'=> optional($job->jobcategory)->name ?? '-',
                    'apply_count'     => (int) $job->applyjobs_count,
                    'edit_url'        => url('/dashboard/jobs/' . $job->id . '/edit'),
                    'show_url'        => url('/dashboard/jobs/' . $job->id),
                    'delete_url'      => url('/dashboard/jobs/' . $job->id),
                    'apply_url'       => route('admin.job.apply-job', $job->id),
                ];
            });

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);
        }

        // Bukan request DataTables: render halaman seperti biasa.
        return view('dashboard.jobs.index', [
            'title' => 'Jobs',
            'jobs' => Job::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.jobs.create', [
            'title' => 'Jobs',
            'companies' => Company::all(),
            'locations' => Location::all(),
            'jobcategories' => Jobcategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required',
            'jobcategory_id' => 'required',
            'location_id' => 'required',
            'type' => 'required',
            'title' => 'required',
            'status' => 'required',
            'image' => 'image|file|max:2048'
        ]);

        $validatedData['company_id'] = $request->company_id;
        $validatedData['location_id'] = $request->location_id;
        $validatedData['type'] = $request->type;
        $validatedData['salary'] = $request->salary;
        $validatedData['title'] = $request->title;
        $validatedData['total_position'] = $request->total_position;
        $validatedData['description'] = $request->description;
        $validatedData['requirement'] = $request->requirement;
        $validatedData['status'] = $request->status;

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('uploads/image/jobs');
        }

        Job::create($validatedData);
        return redirect('/dashboard/jobs')->with('success', 'New Job has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return view('dashboard.jobs.show', [
            'title' => 'Jobs',
            'job' => $job,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('dashboard.jobs.edit', [
            'title' => 'Jobs',
            'job' => $job,
            'companies' => Company::all(),
            'locations' => Location::all(),
            'jobcategories' => Jobcategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'company_id' => 'required',
            'jobcategory_id' => 'required',
            'location_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'logo' => 'image|file|max:2048'
        ]);
        if ($request->file('image')) {
            if ($job->image) {
                Storage::delete([$job->image]);
            }
            $validatedData['image'] = $request->file('image')->store('uploads/image/jobs');
        }
        $validatedData['company_id'] = $request->company_id;
        $validatedData['jobcategory_id'] = $request->jobcategory_id;
        $validatedData['location_id'] = $request->location_id;
        $validatedData['title'] = $request->title;
        $validatedData['type'] = $request->type;
        $validatedData['total_position'] = $request->total_position;
        $validatedData['salary'] = $request->salary;
        $validatedData['description'] = $request->description;
        $validatedData['requirement'] = $request->requirement;
        $validatedData['status'] = $request->status;
        $validatedData['updated_at'] = now();

        Job::where('id', $job->id)->update($validatedData);
        return redirect('/dashboard/jobs')->with('success', 'Job has been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        Storage::delete([$job->image]);

        Job::destroy($job->id);
        return redirect('/dashboard/jobs')->with('success', 'Job has been Deleted');
    }

    public function dump()
    {
        return view('dashboard.jobs.dump', [
            'title' => 'Jobs Dump',
            'jobs' => Job::onlyTrashed()->get()
        ]);
    }

    public function dump_destroy($id)
    {
        Job::withTrashed()->find($id)->forceDelete();
        return redirect('/dashboard/jobs/dump')->with('success', 'Job has been Deleted');
    }

    public function apply_jobs(Job $job)
    {
       $applyjobs =  ApplyJob::where('job_id', $job->id)->orderBy('created_at', 'desc')->get();

        return view('dashboard.jobs.apply', [
            'title' => 'Jobs',
            'job' => $job,
            'applyjobs' => $applyjobs,
        ]);
    }

    public function apply_job_detail($apply_job_id)
    {
        $apply_job = ApplyJob::findOrFail($apply_job_id);

        // Ubah status read menjadi 1
        $apply_job->update(['read' => 1]);

        $title = 'Jobs';
        return view('dashboard.jobs.apply_detail', compact('apply_job', 'title'));
    }

    public function update_apply_job_detail(Request $request, ApplyJob $apply_job)
    {
        $request->validate([
            // 'note' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $apply_job->update([
            'note' => $request->note,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Catatan dan status lamaran berhasil diperbarui.');
    }

    public function candidates(Job $job)
    {
        $usedCandidateIds = $job->jobCandidates()->pluck('candidate_id')->filter()->unique()->values()->all();

        return view('dashboard.jobs.candidates', [
            'title' => 'Recruitment Process',
            'job' => $job,
            'jobCandidates' => $job->jobCandidates()->with('candidate')->orderBy('id', 'desc')->get(),
            'candidateOptions' => Candidate::whereNotIn('id', $usedCandidateIds)->orderBy('name')->get(),
            'usedCandidateIds' => $usedCandidateIds,
        ]);
    }

    public function storeCandidate(Request $request, Job $job)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $alreadyAssigned = JobCandidate::where('job_id', $job->id)
            ->where('candidate_id', $validated['candidate_id'])
            ->exists();

        if ($alreadyAssigned) {
            return redirect()->back()
                ->withErrors(['candidate_id' => 'Candidate sudah di-assign ke job ini.'])
                ->withInput();
        }

        JobCandidate::create([
            'job_id' => $job->id,
            'candidate_id' => $validated['candidate_id'],
        ]);

        return redirect()->route('admin.job.candidates', $job->id)
            ->with('success', 'Candidate berhasil di-assign.');
    }

    public function updateCandidate(Request $request, Job $job, JobCandidate $jobCandidate)
    {
        if ($jobCandidate->job_id !== $job->id) {
            abort(404);
        }

        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $alreadyAssigned = JobCandidate::where('job_id', $job->id)
            ->where('candidate_id', $validated['candidate_id'])
            ->where('id', '!=', $jobCandidate->id)
            ->exists();

        if ($alreadyAssigned) {
            return redirect()->back()
                ->withErrors(['candidate_id' => 'Candidate sudah di-assign ke job ini.'])
                ->withInput();
        }

        $jobCandidate->update([
            'candidate_id' => $validated['candidate_id'],
        ]);

        return redirect()->route('admin.job.candidates', $job->id)
            ->with('success', 'Assignment candidate berhasil diperbarui.');
    }

    public function destroyCandidate(Job $job, JobCandidate $jobCandidate)
    {
        if ($jobCandidate->job_id !== $job->id) {
            abort(404);
        }

        $jobCandidate->delete();

        return redirect()->route('admin.job.candidates', $job->id)->with('success', 'Candidate removed from recruitment process.');
    }
}
