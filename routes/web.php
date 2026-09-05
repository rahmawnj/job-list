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
    return Job::where('status', 'active')
        ->orderBy('updated_at', 'desc')
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc');
}

Route::get('/', function(){
    insertVisitor(getUserIpAddr(), '/home');
    $jobs = activeJobsQuery();
    $topCategories = Jobcategory::where('is_top_category', true)->whereNotNull('logo')->get(['id', 'name']);
    $html = view('homepage.index', ['jobs' => $jobs->paginate(5), 'count_job' => $jobs->count()])->render();

    // Top Categories: server-side links, no JavaScript.
    $categoryIndex = 0;
    $html = preg_replace_callback('/<a href="\/jobs" class="text-decoration-none">/', function ($match) use (&$categoryIndex, $topCategories) {
        $category = $topCategories->values()->get($categoryIndex++);
        if (!$category) return $match[0];
        return '<a href="/jobs?job_category=' . urlencode($category->id) . '" class="text-decoration-none">';
    }, $html);

    // Home search/filter forms use normal GET requests handled by PHP.
    $html = str_replace('<form action="/jobs" method="post">', '<form action="/jobs" method="GET">', $html);
    $html = str_replace('<div class="card border-0 shadow-sm p-4 mb-5 job-filter-card">', '<form action="/jobs" method="GET"><div class="card border-0 shadow-sm p-4 mb-5 job-filter-card">', $html);
    $html = str_replace('<select class="job-filter-select" data-picker id="job_category" name="select">', '<select class="job-filter-select" data-picker id="job_category" name="job_category">', $html);
    $html = str_replace('<select class="job-filter-select" data-picker id="location" name="select">', '<select class="job-filter-select" data-picker id="location" name="location">', $html);
    $html = str_replace('</div>\n\n                <div id="job_data" style="position: relative; z-index: 1;">', '</div><div class="text-center mt-3"><button type="submit" class="btn px-4 py-2" style="background:#2a93d5;color:#fff;border-radius:50px;">Filter Jobs</button></div></div></form>\n\n                <div id="job_data" style="position: relative; z-index: 1;">', $html);

    return $html;
});

Route::get('/home', fn () => redirect('/'));

Route::get('/job/{id_job}', function($id){
    insertVisitor(getUserIpAddr(), '/job_detail');
    return view('homepage.job_detail', ['id' => $id]);
});

Route::get('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs');
    $jobs = activeJobsQuery();

    if ($request->filled('job_category')) {
        $jobs->where('jobcategory_id', $request->job_category);
    }
    if ($request->filled('location')) {
        $jobs->where('location_id', $request->location);
    }
    if ($request->filled('job_type')) {
        $jobs->where('type', $request->job_type);
    }
    if ($request->filled('search')) {
        $search = $request->search;
        $jobs->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('salary', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('jobcategory', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    if ($request->sort_by === 'latest') {
        $jobs->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
    } elseif ($request->sort_by === 'oldest') {
        $jobs->orderBy('updated_at', 'asc')->orderBy('created_at', 'asc');
    }

    $countJob = (clone $jobs)->count();
    $html = view('homepage.jobs', ['jobs' => $jobs->paginate(5)->withQueryString(), 'count_job' => $countJob])->render();

    // Convert the existing jobs filter form to a normal PHP GET form.
    $html = str_replace('<form action="" class="jobs-filter-form">', '<form action="/jobs" method="GET" class="jobs-filter-form">', $html);
    $html = str_replace('<select id="location" name="select" data-picker>', '<select id="location" name="location" data-picker>', $html);
    $html = str_replace('<select id="job_category" name="select" data-picker>', '<select id="job_category" name="job_category" data-picker>', $html);
    $html = str_replace('<select id="sort_by" name="select">', '<select id="sort_by" name="sort_by">', $html);
    $html = str_replace('</div>\n                    </form>', '</div>\n                        <button type="submit" class="btn w-100 mt-4" style="background:#2a93d5;color:#fff;border-radius:50px;">Filter Jobs</button>\n                    </form>', $html);

    // Keep current values visible after a PHP GET submission.
    $searchValue = e($request->query('search', ''));
    $html = preg_replace('/(<input class="form-control" name="search" id="search" type="search"[^>]*)(>)/', '$1 value="' . $searchValue . '"$2', $html, 1);
    $locationValue = (string) $request->query('location', '');
    $categoryValue = (string) $request->query('job_category', '');
    $html = preg_replace('/(<select id="location" name="location" data-picker>)/', '$1', $html, 1);
    $html = preg_replace('/(<select id="job_category" name="job_category" data-picker>)/', '$1', $html, 1);

    // Mark selected options server-side.
    if ($locationValue !== '') {
        $pattern = '/(<select id="location" name="location" data-picker>.*?<option value="' . preg_quote($locationValue, '/') . '")/s';
        $html = preg_replace($pattern, '$1 selected', $html, 1);
    }
    if ($categoryValue !== '') {
        $pattern = '/(<select id="job_category" name="job_category" data-picker>.*?<option value="' . preg_quote($categoryValue, '/') . '")/s';
        $html = preg_replace($pattern, '$1 selected', $html, 1);
    }

    $jobType = (string) $request->query('job_type', '');
    if ($jobType !== '') {
        $html = preg_replace('/(<input name="job_type" type="radio" value="' . preg_quote($jobType, '/') . '")/', '$1 checked', $html, 1);
    }
    $sortBy = (string) $request->query('sort_by', '');
    if ($sortBy !== '') {
        $html = preg_replace('/(<select id="sort_by" name="sort_by">.*?<option value="' . preg_quote($sortBy, '/') . '")/s', '$1 selected', $html, 1);
    }

    return $html;
});

Route::get('/get-more-jobs', function (Request $request) {
    $jobs = activeJobsQuery();

    if ($request->filled('job_category')) {
        $jobs->where('jobcategory_id', $request->job_category);
    }
    if ($request->filled('location')) {
        $jobs->where('location_id', $request->location);
    }
    if ($request->filled('job_type')) {
        $jobs->where('type', $request->job_type);
    }
    if ($request->filled('search')) {
        $search = $request->search;
        $jobs->where(function($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('salary', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('jobcategory', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        });
    }

    if ($request->sort_by === 'latest') {
        $jobs->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
    } elseif ($request->sort_by === 'oldest') {
        $jobs->orderBy('updated_at', 'asc')->orderBy('created_at', 'asc');
    }

    $countJob = (clone $jobs)->count();

    return view('homepage.job_data', [
        'jobs' => $jobs->paginate(5)->withQueryString(),
        'count_job' => $countJob
    ])->render();
})->name('jobs.get-more-jobs');

Route::get('/about', function(){ insertVisitor(getUserIpAddr(), '/about'); return view('homepage.about'); });
Route::get('/contact', function(){ insertVisitor(getUserIpAddr(), '/contact'); return view('homepage.contact'); });
Route::post('/send_message', function(Request $request){
    Message::create(['name' => $request->name, 'subject' => $request->subject, 'email' => $request->email, 'status' => 'unread', 'message' => $request->message]);
    return redirect('/contact')->with('success', 'Your Message has been send');
});

Route::get('/apply_job/{id}', [ApplyJobController::class, 'apply_job'])->name('apply_job');
Route::post('/apply_job', [ApplyJobController::class, 'apply_job_post'])->name('apply_job.post');
Route::get('/mail', [MailController::class, 'sendMail']);
Route::post('/mail/send_mail', [MailController::class, 'send_mail']);
Route::get('/send', [MailController::class, 'index']);
Route::get('/auth/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::name('auth.')->group(function(){
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/auth/profile', [AuthController::class, 'profile_post']);
    Route::post('/auth/login', [AuthController::class, 'login_post']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::name('admin.')->group(function(){
    Route::get('/dashboard', function(){
        $visitor = DB::table('visitors')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))->groupBy('date')->whereDate('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->orderBy('date', 'asc')->get();
        $jobCategories = Jobcategory::all(); $categories = []; $jobsCount = [];
        foreach ($jobCategories as $val) $categories[] = $val->name;
        foreach ($jobCategories as $val) $jobsCount[] = $val->jobs->count();
        return view('dashboard.index', ['title' => 'Dashboard', 'jobsCount' => response()->json($jobsCount), 'categories' => response()->json($categories), 'job_categories' => Jobcategory::all()->toJson(), 'visitors' => $visitor]);
    })->middleware('auth');
    Route::get('/dashboard/content', [ContentController::class, 'form'])->middleware('auth');
    Route::get('/dashboard/messages', [MessageController::class, 'index'])->middleware('auth');
    Route::get('/dashboard/messages/{id_message}', [MessageController::class, 'show']);
    Route::post('/messages/send_email', [MessageController::class, 'send_email'])->middleware('auth');
    Route::get('/dashboard/emails', [MessageController::class, 'emails'])->middleware('auth');
    Route::get('/dashboard/emails/write_email', [MessageController::class, 'write_email'])->middleware('auth');
    Route::get('/dashboard/emails/{id_email}', [MessageController::class, 'show_email']);
    Route::post('/messages/reply_message', [MessageController::class, 'reply_message'])->middleware('auth');
    Route::put('/content/store', [ContentController::class, 'store'])->middleware('auth');
    Route::get('/dashboard/applyprocess', [ApplyprocessController::class, 'form'])->middleware('auth');
    Route::put('/applyprocess/store', [ApplyprocessController::class, 'store'])->middleware('auth');
    Route::resource('/dashboard/mediasocials', MediasocialController::class)->middleware('auth');
    Route::resource('/dashboard/companies', CompanyController::class)->middleware('auth');
    Route::resource('/dashboard/candidates', CandidateController::class)->middleware('auth');
    Route::get('/dashboard/jobcategories/slug', [JobcategoryController::class, 'slug'])->middleware('auth');
    Route::resource('/dashboard/jobcategories', JobcategoryController::class)->middleware('auth');
    Route::resource('/dashboard/locations', LocationController::class)->middleware('auth');
    Route::get('/dashboard/jobs/dump', [JobController::class, 'dump'])->middleware('auth');
    Route::get('/jobs/apply-delete/{id}', [JobController::class, 'apply_delete'])->middleware('auth')->name('job.apply-delete');
    Route::get('/dashboard/jobs/apply-jobs-detail/{apply_job}', [JobController::class, 'apply_job_detail'])->middleware('auth')->name('job.apply-job-detail');
    Route::resource('/dashboard/users', UserController::class)->middleware('auth');
    Route::get('/dashboard/jobs/apply-jobs/{job}', [JobController::class, 'apply_jobs'])->middleware('auth')->name('job.apply-job');
    Route::get('/dashboard/jobs/{job}/candidates', [JobController::class, 'candidates'])->middleware('auth')->name('job.candidates');
    Route::post('/dashboard/jobs/{job}/candidates', [JobController::class, 'storeCandidate'])->middleware('auth')->name('job.candidates.store');
    Route::put('/dashboard/jobs/{job}/candidates/{jobCandidate}', [JobController::class, 'updateCandidate'])->middleware('auth')->name('job.candidates.update');
    Route::put('/dashboard/jobs/{job}/candidates/{jobCandidate}/milestones', [JobCandidateMilestoneController::class, 'update'])->middleware('auth')->name('job.candidates.milestones.update');
    Route::delete('/dashboard/jobs/{job}/candidates/{jobCandidate}', [JobController::class, 'destroyCandidate'])->middleware('auth')->name('job.candidates.destroy');
    Route::put('/dashboard/jobs/apply-jobs-detail/{apply_job}', [JobController::class, 'update_apply_job_detail'])->middleware('auth')->name('job.apply-job-detail.update');
    Route::resource('/dashboard/jobs', JobController::class)->middleware('auth');
    Route::delete('/dashboard/jobs/delete_dump/{id_job}', [JobController::class, 'dump_destroy'])->middleware('auth');
});