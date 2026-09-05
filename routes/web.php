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

    if (is_string($ip) && str_contains($ip, ',')) {
        $ip = trim(explode(',', $ip)[0]);
    }

    return $ip;
}

Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);

    if (! File::exists($file)) {
        abort(404);
    }

    return Response::file($file);
})->where('path', '.*');

function insertVisitor($ip_address, $page)
{
    Visitor::create([
        'ip_address' => $ip_address,
        'page' => $page,
    ]);
}

function activeJobsQuery()
{
    return Job::where('status', 'active')
        ->orderBy('updated_at', 'desc')
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc');
}

function appendHomepageAjaxStateScript($html)
{
    $script = <<<'HTML'
<style>
    .job-data-ajax-state {
        min-height: 220px;
        padding: 36px 24px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.88);
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .job-data-ajax-state-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .job-data-ajax-spinner {
        width: 42px;
        height: 42px;
        border: 4px solid rgba(42, 147, 213, 0.18);
        border-top-color: #2a93d5;
        border-radius: 50%;
        animation: homepage-job-spin 0.75s linear infinite;
    }

    .job-data-ajax-title {
        margin: 0;
        color: #1e214e;
        font-size: 22px;
        font-weight: 700;
    }

    .job-data-ajax-text {
        margin: 0;
        color: #64748b;
        font-size: 15px;
        line-height: 1.5;
    }

    .job-data-ajax-state.is-error .job-data-ajax-spinner {
        display: none;
    }

    .job-data-ajax-state.is-error .job-data-ajax-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        font-size: 22px;
        font-weight: 700;
    }

    @keyframes homepage-job-spin {
        to { transform: rotate(360deg); }
    }
</style>

<script>
    $(function () {
        function isHomepageJobsRequest(settings) {
            return settings && typeof settings.url === 'string' && settings.url.indexOf('/get-more-jobs') !== -1;
        }

        function showHomepageJobLoading() {
            $('#job_data').html(
                '<div class="job-data-ajax-state" aria-live="polite" aria-busy="true">' +
                    '<div class="job-data-ajax-state-inner">' +
                        '<div class="job-data-ajax-spinner" aria-hidden="true"></div>' +
                        '<h4 class="job-data-ajax-title">Loading jobs...</h4>' +
                        '<p class="job-data-ajax-text">Updating the job listings. Please wait.</p>' +
                    '</div>' +
                '</div>'
            );
        }

        function showHomepageJobError() {
            $('#job_data').html(
                '<div class="job-data-ajax-state is-error" role="alert">' +
                    '<div class="job-data-ajax-state-inner">' +
                        '<div class="job-data-ajax-icon" aria-hidden="true">!</div>' +
                        '<h4 class="job-data-ajax-title">Could not load jobs</h4>' +
                        '<p class="job-data-ajax-text">Please try changing the filter again.</p>' +
                    '</div>' +
                '</div>'
            );
        }

        $(document).on('ajaxSend.homepageJobsState', function (event, jqXHR, settings) {
            if (isHomepageJobsRequest(settings)) {
                showHomepageJobLoading();
            }
        });

        $(document).on('ajaxError.homepageJobsState', function (event, jqXHR, settings, error) {
            if (isHomepageJobsRequest(settings) && error !== 'abort') {
                showHomepageJobError();
            }
        });
    });
</script>
HTML;

    if (stripos($html, '</body>') !== false) {
        return preg_replace('/<\/body>/i', $script . '</body>', $html, 1);
    }

    return $html . $script;
}

Route::get('/', function(){
    insertVisitor(getUserIpAddr(), '/home');
    $jobs = activeJobsQuery();

    $html = view('homepage.index', [
        'jobs' => $jobs->paginate(5),
        'count_job' => $jobs->count()
    ])->render();

    return appendHomepageAjaxStateScript($html);
});

Route::get('/home', function(){
    return redirect('/');
});

Route::get('/job/{id_job}', function($id){
    insertVisitor(getUserIpAddr(), '/job_detail');

    return view('homepage.job_detail', [
        'id' => $id
    ]);
});

Route::post('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs');
    $jobs = activeJobsQuery();

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

    $countJob = (clone $jobs)->count();

    return view('homepage.jobs', [
        'jobs' => $jobs->paginate(5)->withQueryString(),
        'count_job' => $countJob
    ]);
});

Route::get('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs');
    $jobs = Job::where('status', 'active');

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

    if ($request->sort_by === 'oldest') {
        $jobs->orderBy('updated_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc');
    } else {
        $jobs->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    $countJob = (clone $jobs)->count();

    return view('homepage.jobs', [
        'jobs' => $jobs->paginate(5)->withQueryString(),
        'count_job' => $countJob
    ]);
});

Route::get('/get-more-jobs', function (Request $request) {
    $jobs = Job::where('status', 'active');

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

    if ($request->sort_by === 'oldest') {
        $jobs->orderBy('updated_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc');
    } else {
        $jobs->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    $countJob = (clone $jobs)->count();

    return view('homepage.job_data', [
        'jobs' => $jobs->paginate(5)->withQueryString(),
        'count_job' => $countJob
    ])->render();
})->name('jobs.get-more-jobs');