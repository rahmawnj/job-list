<?php

use App\Models\Job;
use App\Models\Mail;
use App\Models\Content;
use App\Models\District;
use App\Models\Message;
use App\Models\Jobcategory;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobcategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MediasocialController;
use App\Http\Controllers\ApplyprocessController;
use App\Http\Controllers\ApplyJobController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobCandidateMilestoneController;

function getUserIpAddr()
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? ($_SERVER['HTTP_CLIENT_IP'] ?? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? '127.0.0.1'));
    if (is_string($ip) && str_contains($ip, ',')) $ip = trim(explode(',', $ip)[0]);
    return $ip;
}

Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (! File::exists($file)) abort(404);
    return Response::file($file);
})->where('path', '.*');

function insertVisitor($ip_address, $page)
{
    Visitor::create(['ip_address' => $ip_address, 'page' => $page]);
}

function activeJobsQuery()
{
    return Job::where('status', 'active')->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
}

function appendHomepageAjaxStateScript($html)
{
    $script = <<<'HTML'
<style>
.job-data-ajax-state{min-height:220px;padding:36px 24px;border:1px solid rgba(148,163,184,.18);border-radius:22px;background:rgba(255,255,255,.88);box-shadow:0 16px 30px rgba(15,23,42,.04);display:flex;align-items:center;justify-content:center;text-align:center}.job-data-ajax-state-inner{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px}.job-data-ajax-spinner{width:42px;height:42px;border:4px solid rgba(42,147,213,.18);border-top-color:#2a93d5;border-radius:50%;animation:homepage-job-spin .75s linear infinite}.job-data-ajax-title{margin:0;color:#1e214e;font-size:22px;font-weight:700}.job-data-ajax-text{margin:0;color:#64748b;font-size:15px;line-height:1.5}.job-data-ajax-state.is-error .job-data-ajax-spinner{display:none}.job-data-ajax-state.is-error .job-data-ajax-icon{width:42px;height:42px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(239,68,68,.1);color:#dc2626;font-size:22px;font-weight:700}@keyframes homepage-job-spin{to{transform:rotate(360deg)}}
</style>
<script>
$(function(){function isHomepageJobsRequest(settings){return settings&&typeof settings.url==='string'&&settings.url.indexOf('/get-more-jobs')!==-1}function showHomepageJobLoading(){$('#job_data').html('<div class="job-data-ajax-state" aria-live="polite" aria-busy="true"><div class="job-data-ajax-state-inner"><div class="job-data-ajax-spinner" aria-hidden="true"></div><h4 class="job-data-ajax-title">Loading jobs...</h4><p class="job-data-ajax-text">Updating the job listings. Please wait.</p></div></div>')}function showHomepageJobError(){$('#job_data').html('<div class="job-data-ajax-state is-error" role="alert"><div class="job-data-ajax-state-inner"><div class="job-data-ajax-icon" aria-hidden="true">!</div><h4 class="job-data-ajax-title">Could not load jobs</h4><p class="job-data-ajax-text">Please try changing the filter again.</p></div></div>')}$(document).on('ajaxSend.homepageJobsState',function(e,x,s){if(isHomepageJobsRequest(s))showHomepageJobLoading()});$(document).on('ajaxError.homepageJobsState',function(e,x,s,error){if(isHomepageJobsRequest(s)&&error!=='abort')showHomepageJobError()})});
</script>
HTML;
    if (stripos($html, '</body>') !== false) return preg_replace('/<\/body>/i', $script . '</body>', $html, 1);
    return $html . $script;
}

Route::get('/', function(){
    insertVisitor(getUserIpAddr(), '/home'); $jobs=activeJobsQuery();
    return appendHomepageAjaxStateScript(view('homepage.index',['jobs'=>$jobs->paginate(5),'count_job'=>$jobs->count()])->render());
});
Route::get('/home', fn()=>redirect('/'));
Route::get('/job/{id_job}', fn($id)=>view('homepage.job_detail',['id'=>$id]));
Route::post('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs'); $jobs=activeJobsQuery();
    if($request->filled('search')){$search=$request->search;$jobs->where(function($q)use($search){$q->where('title','like',"%{$search}%")->orWhere('type','like',"%{$search}%")->orWhere('salary','like',"%{$search}%")->orWhere('description','like',"%{$search}%")->orWhereHas('jobcategory',fn($q)=>$q->where('name','like',"%{$search}%"));});}
    return view('homepage.jobs',['jobs'=>$jobs->paginate(5)->withQueryString(),'count_job'=>(clone $jobs)->count()]);
});
Route::get('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs'); $jobs=Job::where('status','active');
    foreach(['job_category'=>'jobcategory_id','location'=>'location_id','job_type'=>'type'] as $input=>$column) if($request->filled($input)) $jobs->where($column,$request->$input);
    if($request->filled('search')){$search=$request->search;$jobs->where(function($q)use($search){$q->where('title','like',"%{$search}%")->orWhere('type','like',"%{$search}%")->orWhere('salary','like',"%{$search}%")->orWhere('description','like',"%{$search}%")->orWhereHas('jobcategory',fn($q)=>$q->where('name','like',"%{$search}%"));});}
    $jobs->orderBy('updated_at',$request->sort_by==='oldest'?'asc':'desc')->orderBy('created_at',$request->sort_by==='oldest'?'asc':'desc')->orderBy('id',$request->sort_by==='oldest'?'asc':'desc');
    return view('homepage.jobs',['jobs'=>$jobs->paginate(5)->withQueryString(),'count_job'=>(clone $jobs)->count()]);
});
Route::get('/get-more-jobs', function(Request $request){
    $jobs=Job::where('status','active');
    foreach(['job_category'=>'jobcategory_id','location'=>'location_id','job_type'=>'type'] as $input=>$column) if($request->filled($input)) $jobs->where($column,$request->$input);
    if($request->filled('search')){$search=$request->search;$jobs->where(function($q)use($search){$q->where('title','like',"%{$search}%")->orWhere('type','like',"%{$search}%")->orWhere('salary','like',"%{$search}%")->orWhere('description','like',"%{$search}%")->orWhereHas('jobcategory',fn($q)=>$q->where('name','like',"%{$search}%"));});}
    $jobs->orderBy('updated_at',$request->sort_by==='oldest'?'asc':'desc')->orderBy('created_at',$request->sort_by==='oldest'?'asc':'desc')->orderBy('id',$request->sort_by==='oldest'?'asc':'desc');
    return view('homepage.job_data',['jobs'=>$jobs->paginate(5)->withQueryString(),'count_job'=>(clone $jobs)->count()])->render();
})->name('jobs.get-more-jobs');
Route::get('/about',fn()=>view('homepage.about'));
Route::get('/contact',fn()=>view('homepage.contact'));
Route::post('/send_message',function(Request $request){Message::create(['name'=>$request->name,'subject'=>$request->subject,'email'=>$request->email,'status'=>'unread','message'=>$request->message]);return redirect('/contact')->with('success','Your Message has been send');});
Route::get('/apply_job/{id}',[ApplyJobController::class,'apply_job'])->name('apply_job');
Route::post('/apply_job',[ApplyJobController::class,'apply_job_post'])->name('apply_job.post');
Route::get('/mail',[MailController::class,'sendMail']); Route::post('/mail/send_mail',[MailController::class,'send_mail']); Route::get('/send',[MailController::class,'index']);
Route::get('/auth/login',[AuthController::class,'login'])->middleware('guest')->name('login'); Route::get('/login',[AuthController::class,'login'])->middleware('guest')->name('login');
Route::name('auth.')->group(function(){Route::get('/profile',[AuthController::class,'profile']);Route::put('/auth/profile',[AuthController::class,'profile_post']);Route::post('/auth/login',[AuthController::class,'login_post']);Route::post('/auth/logout',[AuthController::class,'logout']);});

Route::name('admin.')->group(function(){
    Route::get('/dashboard', function(){
        $visitor=DB::table('visitors')->select(DB::raw('DATE(created_at) as date'),DB::raw('count(*) as total'))->groupBy('date')->whereDate('created_at','>=',\Carbon\Carbon::today()->subDays(7))->orderBy('date','asc')->get();
        $jobCategories=Jobcategory::all();$categories=[];$jobsCount=[];foreach($jobCategories as $val){$categories[]=$val->name;$jobsCount[]=$val->jobs->count();}
        return view('dashboard.index',['title'=>'Dashboard','jobsCount'=>response()->json($jobsCount),'categories'=>response()->json($categories),'job_categories'=>Jobcategory::all()->toJson(),'visitors'=>$visitor]);
    })->middleware('auth');
    Route::get('/dashboard/content',[ContentController::class,'form'])->middleware('auth');
    Route::get('/dashboard/messages',[MessageController::class,'index'])->middleware('auth');
    Route::get('/dashboard/messages/{id_message}',[MessageController::class,'show']);
    Route::post('/messages/send_email',[MessageController::class,'send_email'])->middleware('auth');
    Route::get('/dashboard/emails',[MessageController::class,'emails'])->middleware('auth');
    Route::get('/dashboard/emails/write_email',[MessageController::class,'write_email'])->middleware('auth');
    Route::get('/dashboard/emails/{id_email}',[MessageController::class,'show_email']);
    Route::post('/messages/reply_message',[MessageController::class,'reply_message'])->middleware('auth');
    Route::put('/content/store',[ContentController::class,'store'])->middleware('auth');
    Route::get('/dashboard/applyprocess',[ApplyprocessController::class,'form'])->middleware('auth');
    Route::put('/applyprocess/store',[ApplyprocessController::class,'store'])->middleware('auth');
    Route::resource('/dashboard/mediasocials',MediasocialController::class)->middleware('auth');
    Route::resource('/dashboard/companies',CompanyController::class)->middleware('auth');
    Route::resource('/dashboard/candidates',CandidateController::class)->middleware('auth');
    Route::get('/dashboard/jobcategories/slug',[JobcategoryController::class,'slug'])->middleware('auth');
    Route::resource('/dashboard/jobcategories',JobcategoryController::class)->middleware('auth');
    Route::resource('/dashboard/locations',LocationController::class)->middleware('auth');
    Route::get('/dashboard/jobs/dump',[JobController::class,'dump'])->middleware('auth');
    Route::get('/jobs/apply-delete/{id}',[JobController::class,'apply_delete'])->middleware('auth')->name('job.apply-delete');
    Route::get('/dashboard/jobs/apply-jobs-detail/{apply_job}',[JobController::class,'apply_job_detail'])->middleware('auth')->name('job.apply-job-detail');
    Route::resource('/dashboard/users',UserController::class)->middleware('auth');
    Route::get('/dashboard/jobs/apply-jobs/{job}',[JobController::class,'apply_jobs'])->middleware('auth')->name('job.apply-job');
    Route::get('/dashboard/jobs/{job}/candidates',[JobController::class,'candidates'])->middleware('auth')->name('job.candidates');
    Route::get('/dashboard/jobs/{job}/candidates/export',[JobController::class,'exportCandidates'])->middleware('auth')->name('job.candidates.export');
    Route::post('/dashboard/jobs/{job}/candidates',[JobController::class,'storeCandidate'])->middleware('auth')->name('job.candidates.store');
    Route::put('/dashboard/jobs/{job}/candidates/{jobCandidate}',[JobController::class,'updateCandidate'])->middleware('auth')->name('job.candidates.update');
    Route::get('/dashboard/jobs/{job}/candidates/{jobCandidate}/milestones',[JobCandidateMilestoneController::class,'edit'])->middleware('auth')->name('job.candidates.milestones.edit');
    Route::put('/dashboard/jobs/{job}/candidates/{jobCandidate}/milestones',[JobCandidateMilestoneController::class,'update'])->middleware('auth')->name('job.candidates.milestones.update');
    Route::delete('/dashboard/jobs/{job}/candidates/{jobCandidate}',[JobController::class,'destroyCandidate'])->middleware('auth')->name('job.candidates.destroy');
    Route::get('/dashboard/jobs/apply-jobs-detail/{apply_job}',[JobController::class,'apply_job_detail'])->middleware('auth')->name('job.apply-job-detail');
    Route::put('/dashboard/jobs/apply-jobs-detail/{apply_job}',[JobController::class,'update_apply_job_detail'])->middleware('auth')->name('job.apply-job-detail.update');
    Route::resource('/dashboard/jobs',JobController::class)->middleware('auth');
    Route::delete('/dashboard/jobs/delete_dump/{id_job}',[JobController::class,'dump_destroy'])->middleware('auth');
});
