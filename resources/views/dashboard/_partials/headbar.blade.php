<!-- BEGIN #header -->
<div id="header" class="app-header app-header-inverse header-sticky sticky-top">
    <!-- BEGIN navbar-header -->
    <div class="navbar-header">
        <a href="/home" class="navbar-brand"><img src="{{asset('Desain-Logo-TTC_LOGO-PANJANG-2.png')}}" alt="" srcset=""></a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- END navbar-header -->
    <!-- BEGIN header-nav -->
    <div class="navbar-nav">
      
      <div class="navbar-item dropdown">
        <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
            <i class="fa fa-bell"></i>
            <span class="badge">{{App\Models\Message::where('status', 'unread')->count() + App\Models\ApplyJob::where('read', '0')->count()}}</span>
        </a>
        <div class="dropdown-menu media-list dropdown-menu-end">
            <div class="dropdown-header">NOTIFICATIONS ({{App\Models\Message::where('status', 'unread')->count() + App\Models\ApplyJob::where('read', '0')->count()}})</div>
            @foreach ( App\Models\Message::where('status', 'unread')->latest()->take(5)->get() as $item)
            <a href="javascript:;" class="dropdown-item media">
                <div class="media-left">
                    <i class="fa fa-envelope media-object bg-gray-400"></i>
                </div>
                <div class="media-body">
                    <h6 class="media-heading">{{$item->subject}} </h6>
                    <div class="text-muted fs-10px">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</div>
                </div>
            </a>
            @endforeach
           @foreach (App\Models\ApplyJob::where('read', '0')->latest()->take(5)->get() as $item)
                <a href="{{ route('admin.job.apply-job', ['job' => $item->job_id]) }}" class="dropdown-item media">
                    <div class="media-left">
                        <i class="fa fa-envelope media-object bg-gray-400"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">{{ $item->subject }}</h6>
                        <div class="text-muted fs-10px">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                        <div class="text-muted fs-10px">Pelamar: {{ $item->name }}</div>
                        <div class="text-muted fs-10px">Pekerjaan: {{ $item->job->title }}</div>
                    </div>
                </a>
            @endforeach

            <div class="dropdown-footer text-center">
                <a href="/dashboard/messages" class="text-decoration-none">View more</a>
            </div>
        </div>
    </div>


        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                <img src="{{asset('storage/' . auth()->user()->image)}}" alt="" /> 
                {{-- <span class="d-none d-md-inline">{{auth()->user()->name}}</span> <b class="caret ms-6px"></b> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a href="/profile" class="dropdown-item">Edit Profile</a>
                <a href="/dashboard/messages" class="dropdown-item"><span class="badge bg-danger float-end rounded-pill">{{App\Models\Message::where('status', 'unread')->count()}}</span> Inbox</a>
                <a href="/dashboard/content" class="dropdown-item">Setting</a>
                <div class="dropdown-divider"></div>
                <form action="/auth/logout" method="post">
                    @csrf
                    <button class="dropdown-item" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </div>
    <!-- END header-nav -->
</div>
<!-- END #header -->