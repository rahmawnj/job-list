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
    public function index(Request $request)
    {
        if ($request->ajax() && $request->has('draw')) {
            $draw=(int)$request->input('draw'); $start=(int)$request->input('start',0); $length=(int)$request->input('length',10); $search=trim((string)$request->input('search.value','')); $totalRecords=Job::count(); $query=Job::query()->with(['company','jobcategory'])->withCount('applyjobs');
            if($search!=='') $query->where(function($q)use($search){$q->where('title','like',"%{$search}%")->orWhere('type','like',"%{$search}%")->orWhere('status','like',"%{$search}%")->orWhereHas('company',fn($qc)=>$qc->where('name','like',"%{$search}%"))->orWhereHas('jobcategory',fn($qc)=>$qc->where('name','like',"%{$search}%"));});
            $recordsFiltered=(clone $query)->count(); $order=$request->input('order.0');
            if($order&&isset($order['column'],$order['dir'])){$columns=['id','image','title','company_name','jobcategory_name','apply_count','action'];$orderColumn=$columns[(int)$order['column']]??'id';$orderDir=$order['dir']==='asc'?'asc':'desc';switch($orderColumn){case'title':$query->orderBy('jobs.title',$orderDir);break;case'company_name':$query->orderBy(Company::select('name')->whereColumn('companies.id','jobs.company_id'),$orderDir);break;case'jobcategory_name':$query->orderBy(Jobcategory::select('name')->whereColumn('jobcategories.id','jobs.jobcategory_id'),$orderDir);break;case'apply_count':$query->orderBy('applyjobs_count',$orderDir);break;default:$query->orderBy('jobs.id',$orderDir);}}else$query->orderBy('jobs.id','desc');
            $jobs=$query->skip($start)->take($length)->get(); $data=$jobs->map(function($job,$key)use($start){return['no'=>$start+$key+1,'image'=>$job->image?asset('storage/'.$job->image):asset('img/default.png'),'title'=>$job->title,'company_name'=>optional($job->company)->name??'-','jobcategory_name'=>optional($job->jobcategory)->name??'-','apply_count'=>(int)$job->applyjobs_count,'edit_url'=>url('/dashboard/jobs/'.$job->id.'/edit'),'show_url'=>url('/dashboard/jobs/'.$job->id),'delete_url'=>url('/dashboard/jobs/'.$job->id),'apply_url'=>route('admin.job.apply-job',$job->id)];});
            return response()->json(['draw'=>$draw,'recordsTotal'=>$totalRecords,'recordsFiltered'=>$recordsFiltered,'data'=>$data]);
        }
        return view('dashboard.jobs.index',['title'=>'Jobs','jobs'=>Job::all()]);
    }
    public function create(){return view('dashboard.jobs.create',['title'=>'Jobs','companies'=>Company::all(),'locations'=>Location::all(),'jobcategories'=>Jobcategory::all()]);}
    public function store(Request $request){$validatedData=$request->validate(['company_id'=>'required','jobcategory_id'=>'required','location_id'=>'required','type'=>'required','title'=>'required','status'=>'required','image'=>'image|file|max:2048']);$validatedData['company_id']=$request->company_id;$validatedData['location_id']=$request->location_id;$validatedData['type']=$request->type;$validatedData['salary']=$request->salary;$validatedData['title']=$request->title;$validatedData['total_position']=$request->total_position;$validatedData['description']=$request->description;$validatedData['requirement']=$request->requirement;$validatedData['status']=$request->status;if($request->file('image'))$validatedData['image']=$request->file('image')->store('uploads/image/jobs');Job::create($validatedData);return redirect('/dashboard/jobs')->with('success','New Job has been added');}
    public function show(Job $job){return view('dashboard.jobs.show',['title'=>'Jobs','job'=>$job]);}
    public function edit(Job $job){return view('dashboard.jobs.edit',['title'=>'Jobs','job'=>$job,'companies'=>Company::all(),'locations'=>Location::all(),'jobcategories'=>Jobcategory::all()]);}
    public function update(Request $request,Job $job){$request->validate(['company_id'=>'required','jobcategory_id'=>'required','location_id'=>'required','title'=>'required','type'=>'required','status'=>'required','logo'=>'image|file|max:2048']);if($request->file('image')){if($job->image)Storage::delete([$job->image]);$validatedData['image']=$request->file('image')->store('uploads/image/jobs');}$validatedData['company_id']=$request->company_id;$validatedData['jobcategory_id']=$request->jobcategory_id;$validatedData['location_id']=$request->location_id;$validatedData['title']=$request->title;$validatedData['type']=$request->type;$validatedData['total_position']=$request->total_position;$validatedData['salary']=$request->salary;$validatedData['description']=$request->description;$validatedData['requirement']=$request->requirement;$validatedData['status']=$request->status;$validatedData['updated_at']=now();Job::where('id',$job->id)->update($validatedData);return redirect('/dashboard/jobs')->with('success','Job has been Updated');}
    public function destroy(Job $job){Storage::delete([$job->image]);Job::destroy($job->id);return redirect('/dashboard/jobs')->with('success','Job has been Deleted');}
    public function dump(){return view('dashboard.jobs.dump',['title'=>'Jobs Dump','jobs'=>Job::onlyTrashed()->get()]);}
    public function dump_destroy($id){Job::withTrashed()->find($id)->forceDelete();return redirect('/dashboard/jobs/dump')->with('success','Job has been Deleted');}
    public function apply_jobs(Job $job){$applyjobs=ApplyJob::where('job_id',$job->id)->orderBy('created_at','desc')->get();return view('dashboard.jobs.apply',['title'=>'Jobs','job'=>$job,'applyjobs'=>$applyjobs]);}
    public function apply_job_detail($apply_job_id){$apply_job=ApplyJob::findOrFail($apply_job_id);$apply_job->update(['read'=>1]);return view('dashboard.jobs.apply_detail',['apply_job'=>$apply_job,'title'=>'Jobs']);}
    public function update_apply_job_detail(Request $request,ApplyJob $apply_job){$request->validate(['status'=>'required|in:pending,approved,rejected']);$apply_job->update(['note'=>$request->note,'status'=>$request->status]);return redirect()->back()->with('success','Catatan dan status lamaran berhasil diperbarui.');}
    public function candidates(Job $job){$usedCandidateIds=$job->jobCandidates()->pluck('candidate_id')->filter()->unique()->values()->all();return view('dashboard.jobs.candidates',['title'=>'Recruitment Process','job'=>$job,'jobCandidates'=>$job->jobCandidates()->with(['candidate','milestones'])->orderBy('id','desc')->get(),'candidateOptions'=>Candidate::whereNotIn('id',$usedCandidateIds)->orderBy('name')->get(),'usedCandidateIds'=>$usedCandidateIds]);}

    public function exportCandidates(Job $job)
    {
        $job->load(['company','jobcategory','location']);
        $jobCandidates=$job->jobCandidates()->with(['candidate'])->orderBy('id','asc')->get();
        $filename='candidates-'.preg_replace('/[^A-Za-z0-9_-]+/','-',$job->title).'-'.$job->id.'.xls';
        $escape=static fn($value)=>htmlspecialchars((string)($value??'-'),ENT_QUOTES,'UTF-8');
        $rows='';
        if($jobCandidates->isEmpty()){
            $rows='<tr><td colspan="4">No candidate assigned.</td></tr>';
        }else{
            foreach($jobCandidates as $jobCandidate){
                $rows.='<tr>'
                    .'<td>'.$escape($jobCandidate->candidate->name??'-').'</td>'
                    .'<td>'.$escape($jobCandidate->candidate->email??'-').'</td>'
                    .'<td>'.$escape($jobCandidate->candidate->phone??'-').'</td>'
                    .'<td>'.$escape($jobCandidate->candidate->cv_url??'-').'</td>'
                    .'</tr>';
            }
        }

        $jobInfo='<h2>Recruitment Process Report</h2>'
            .'<div><strong>Company:</strong> '.$escape($job->company->name??'-').'</div>'
            .'<div><strong>Jabatan / Position:</strong> '.$escape($job->title).'</div>'
            .'<div><strong>Job Category:</strong> '.$escape($job->jobcategory->name??'-').'</div>'
            .'<div><strong>Job Type:</strong> '.$escape($job->type??'-').'</div>'
            .'<div><strong>Salary / Gaji:</strong> '.$escape($job->salary??'-').'</div>'
            .'<div><strong>Total Position:</strong> '.$escape($job->total_position??'-').'</div>'
            .'<div><strong>Location:</strong> '.$escape($job->location->name??'-').'</div>'
            .'<div><strong>Job Status:</strong> '.$escape($job->status??'-').'</div>'
            .'<br>';

        $html='<html><head><meta charset="UTF-8"><style>body{font-family:Arial,sans-serif}table{border-collapse:collapse}th,td{border:1px solid #ccc;padding:7px;vertical-align:top}th{font-weight:bold;background:#f2f2f2;white-space:nowrap}.job-info{line-height:1.8}</style></head><body><div class="job-info">'.$jobInfo.'</div><table><tr><th>Candidate Name</th><th>Email</th><th>Phone</th><th>CV Link</th></tr>'.$rows.'</table></body></html>';
        return response($html,200,['Content-Type'=>'application/vnd.ms-excel; charset=UTF-8','Content-Disposition'=>'attachment; filename="'.$filename.'"','Cache-Control'=>'max-age=0']);
    }

    public function storeCandidate(Request $request,Job $job){$validated=$request->validate(['candidate_id'=>'required|exists:candidates,id']);$alreadyAssigned=JobCandidate::where('job_id',$job->id)->where('candidate_id',$validated['candidate_id'])->exists();if($alreadyAssigned)return redirect()->back()->withErrors(['candidate_id'=>'Candidate sudah di-assign ke job ini.'])->withInput();JobCandidate::create(['job_id'=>$job->id,'candidate_id'=>$validated['candidate_id']]);return redirect()->route('admin.job.candidates',$job->id)->with('success','Candidate berhasil di-assign.');}
    public function updateCandidate(Request $request,Job $job,JobCandidate $jobCandidate){if($jobCandidate->job_id!==$job->id)abort(404);$validated=$request->validate(['candidate_id'=>'required|exists:candidates,id']);$alreadyAssigned=JobCandidate::where('job_id',$job->id)->where('candidate_id',$validated['candidate_id'])->where('id','!=',$jobCandidate->id)->exists();if($alreadyAssigned)return redirect()->back()->withErrors(['candidate_id'=>'Candidate sudah di-assign ke job ini.'])->withInput();$jobCandidate->update(['candidate_id'=>$validated['candidate_id']]);return redirect()->route('admin.job.candidates',$job->id)->with('success','Assignment candidate berhasil diperbarui.');}
    public function destroyCandidate(Job $job,JobCandidate $jobCandidate){if($jobCandidate->job_id!==$job->id)abort(404);$jobCandidate->delete();return redirect()->route('admin.job.candidates',$job->id)->with('success','Candidate removed from recruitment process.');}
}
