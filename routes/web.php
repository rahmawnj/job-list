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


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
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

function appendJobsFilterScript($html, $script)
{
    $tag = '<script>' . $script . '</script>';

    if (stripos($html, '</body>') !== false) {
        return preg_replace('/<\/body>/i', $tag . '</body>', $html, 1);
    }

    return $html . $tag;
}

Route::get('/', function(){

    insertVisitor(getUserIpAddr(), '/home');

    $jobs = activeJobsQuery();

    $topCategories = Jobcategory::where('is_top_category', true)
        ->whereNotNull('logo')
        ->get(['id', 'name']);

    $categoryMap = $topCategories->mapWithKeys(function ($category) {
        return [$category->name => $category->id];
    });

    $html = view('homepage.index', [
      'jobs' => $jobs->paginate(5),
      'count_job' => $jobs->count()
    ])->render();

    $categoryMapJson = json_encode($categoryMap, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    return appendJobsFilterScript($html, <<<JS
(function () {
    var topCategoryMap = {$categoryMapJson};

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.single-services').forEach(function (card) {
            var title = card.querySelector('h5');
            var link = card.closest('a');

            if (!title || !link) {
                return;
            }

            var categoryName = title.textContent.trim();
            var categoryId = topCategoryMap[categoryName];

            if (categoryId) {
                link.href = '/jobs?job_category=' + encodeURIComponent(categoryId);
            }
        });
    });
})();
JS
    );
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
    $jobs = activeJobsQuery()->where(function($query) use ($request){
        $query->where('title', 'like', "%{$request->search}%")
            ->orWhere('type', 'like', "%{$request->search}%")
            ->orWhere('salary', 'like', "%{$request->search}%")
            ->orWhere('description', 'like', "%{$request->search}%");
    })->orWhereHas('jobcategory', function($query) use ($request) {
        $query->where('name', 'like', "%{$request->search}%");
    });
    return view('homepage.jobs', [
        'jobs' => $jobs->paginate(5),
        'count_job' => $jobs->count()
    ]);
});

Route::get('/jobs', function(Request $request){
    insertVisitor(getUserIpAddr(), '/jobs');

    $jobs = activeJobsQuery();

    if ($request->filled('job_category')) {
        $jobs->whereHas('jobcategory', function ($query) use ($request) {
            $query->whereKey($request->job_category);
        });
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
                ->orWhereHas('jobcategory', function ($categoryQuery) use ($search) {
                    $categoryQuery->where('name', 'like', "%{$search}%");
                });
        });
    }

    $countJob = (clone $jobs)->count();
    $html = view('homepage.jobs', [
        'jobs' => $jobs->paginate(5)->withQueryString(),
        'count_job' => $countJob
    ])->render();

    $jobCategory = $request->query('job_category', '');

    return appendJobsFilterScript($html, <<<JS
(function () {
    var initialJobCategory = "{$jobCategory}";

    document.addEventListener('DOMContentLoaded', function () {
        if (!initialJobCategory) {
            return;
        }

        var categorySelect = document.getElementById('job_category');
        if (!categorySelect) {
            return;
        }

        categorySelect.value = initialJobCategory;
        if (window.jQuery) {
            window.jQuery(categorySelect).trigger('change');
        }
    });
})();

(function () {
    function enableRadioUncheck() {
        if (!window.jQuery) {
            return;
        }

        window.jQuery(document)
            .off('click.jobsTypeUncheck', '.jobs-type-filter input[name="job_type"]')
            .on('click.jobsTypeUncheck', '.jobs-type-filter input[name="job_type"]', function (event) {
                var radio = this;

                if (radio.dataset.wasChecked === 'true') {
                    event.preventDefault();
                    radio.checked = false;
                    radio.dataset.wasChecked = 'false';
                    window.jQuery(radio).trigger('change');
                    return;
                }

                document.querySelectorAll('.jobs-type-filter input[name="job_type"]').forEach(function (item) {
                    item.dataset.wasChecked = item === radio ? 'true' : 'false';
                });
            });

        window.jQuery('.jobs-type-filter input[name="job_type"]').each(function () {
            this.dataset.wasChecked = this.checked ? 'true' : 'false';
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', enableRadioUncheck);
    } else {
        enableRadioUncheck();
    }
})();
JS
    );
});


Route::get('/get-more-jobs', function (Request $request) {
    if($request->ajax()) {
        $jobs = activeJobsQuery();
        if ($request->filled('job_category')) {
            $jobs->whereHas('jobcategory', function ($query) use ($request) {
                $query->whereKey($request->job_category);
            });
        }
        if ($request->filled('location')) {
            $jobs->where('location_id', $request->location);
        }
        if($request->filled('job_type')) {
            $jobs->where('type', $request->job_type);
        }
        if($request->filled('search')){
            $search = $request->search;
            $jobs->where(function($query) use ($search){
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%")
                      ->orWhere('salary', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('jobcategory', function ($categoryQuery) use ($search) {
                          $categoryQuery->where('name', 'like', "%{$search}%");
                      });
            });
        }
        if (!empty($request->sort_by)) {
            if ($request->sort_by == 'latest') {
                $jobs->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
            } else if($request->sort_by == 'oldest') {
                $jobs->orderBy('updated_at', 'asc')->orderBy('created_at', 'asc');
            }
        }
        $count_job = $jobs->count();
        return view('homepage.job_data', [
            'jobs' => $jobs->paginate(5)->withQueryString(),
            'count_job' => $count_job
        ])->render();
    }
});


Route::get('/about', function(){
    insertVisitor(getUserIpAddr(), '/about');

    return view('homepage.about');
});
Route::get('/contact', function(){
    insertVisitor(getUserIpAddr(), '/contact');

    return view('homepage.contact');
});
Route::post('/send_message', function(Request $request){
    Message::create([
        'name' => $request->name,
        'subject' => $request->subject,
        'email' => $request->email,
        'status' => 'unread',
        'message' => $request->message,
    ]);
    return redirect('/contact')->with('success', 'Your Message has been send');
});

// Route::get('/job_type/{job_type}', [HomeController::class, 'job_type']);
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
    Route::get('/dashboard', function()
    {
        $visitor = DB::table('visitors')
                 ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                 ->groupBy('date')
                 ->whereDate('created_at', '>=' , \Carbon\Carbon::today()->subDays(7))
                 ->orderBy('date', 'asc')
                 ->get();

        $jobCategories = Jobcategory::all();
        $categories = [];
        $jobsCount = [];
        foreach ($jobCategories as $key => $val) {
            $categories[] = $val->name;
        }
        foreach ($jobCategories as $key => $val) {
            $jobsCount[] = $val->jobs->count();
        }
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'jobsCount' => response()->json($jobsCount),
            'categories' => response()->json($categories),
            'job_categories' => Jobcategory::all()->toJson(),
            'visitors' => $visitor
        ]);
    })->middleware('auth');
    Route::get('/dashboard/content', [ContentController::class, 'form'])->middleware('auth');
    Route::get('/dashboard/messages', [MessageController::class, 'index'])->middleware('auth');
    Route::get('/dashboard/messages/{id_message}', [MessageController::class, 'show']);
    Route::post('/messages/send_email', [MessageController::class, 'send_email'])->middleware('auth');
    Route::get('/dashboard/emails', [MessageController::class, 'emails'])->middleware('auth');
    Route::get('/dashboard/emails/write_email', [MessageController::class, 'write_email'])->middleware('auth');
    Route::get('/dashboard/emails/{id_email}', [MessageController::class, 'show_email']);
    Route::post('/messages/reply_message', [MessageController::class, 'reply_message'])->middleware('auth');/*  */

    Route::put('/content/store', [ContentController::class, 'store'])->middleware('auth');

    Route::get('/dashboard/applyprocess', [ApplyprocessController::class, 'form'])->middleware('auth');
    Route::put('/applyprocess/store', [ApplyprocessController::class, 'store'])->middleware('auth');


    Route::resource('/dashboard/mediasocials', MediasocialController::class )->middleware('auth');
    Route::resource('/dashboard/companies', CompanyController::class )->middleware('auth');
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

    Route::get('/dashboard/jobs/apply-jobs-detail/{apply_job}', [JobController::class, 'apply_job_detail'])->middleware('auth')->name('job.apply-job-detail');
    Route::put('/dashboard/jobs/apply-jobs-detail/{apply_job}', [JobController::class, 'update_apply_job_detail'])->middleware('auth')->name('job.apply-job-detail.update');


    Route::resource('/dashboard/jobs', JobController::class)->middleware('auth');
    Route::delete('/dashboard/jobs/delete_dump/{id_job}', [JobController::class, 'dump_destroy'])->middleware('auth');
});


