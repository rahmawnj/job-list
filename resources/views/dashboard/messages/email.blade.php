@extends('dashboard._layout.main')

@section('container')


    <!-- BEGIN breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <!-- END breadcrumb -->
    <!-- BEGIN page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- END page-header -->
    
    <div class="row">
        <!-- BEGIN col-2 -->
     
        <!-- END col-2 -->
        <!-- BEGIN col-10 -->
        <div class="col-xl-12">
            <!-- BEGIN panel -->
            <div class="panel panel-inverse">
                <!-- BEGIN panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">{{$title}}</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <!-- END panel-heading -->
                <!-- BEGIN alert -->
               
                @if (session()->has('success'))
                <div class="flash-data-success" data-flashdatasuccess="{{session('success')}} " ></div>
                @endif
                @if (session()->has('error'))
                <div class="flash-data-error" data-flashdataerror="{{session('error')}} " ></div>
                @endif
                @if (session()->has('warning'))
                <div class="flash-data-warning" data-flashdatawarning="{{session('warning')}} " ></div>
                @endif
                <!-- END alert -->
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                    <a href="/dashboard/emails/write_email" class="btn mb-3 btn-primary"> <i class="fa fa-paper-plane"></i> Send Email</a>
                    <div class="mailbox" style="width: 100%;">
                        <div class="" style="width: 100%;">
                           
                            <div class="mailbox-content-body" style="width: 100%;">
                                <div data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                                    <!-- BEGIN list-email -->
                                    <ul class="list-group list-group-lg no-radius list-email">
                                  @foreach ($emails as $email)
                                        <li style="" class="list-group-item">
                                            <div class="email-info">
                                                <a href="/dashboard/emails/{{$email->id}}">
                                                    <span class="email-title">{{$email->subject}}</span>
                                                    <span class="email-desc">{{$email->email}}</span>
                                                    <span class="email-time">{{\Carbon\Carbon::parse($email->created_at)->diffForHumans()}}</span>
                                                </a>
                                            </div>
                                        </li>
                                  @endforeach
                    
                                    </ul>
                                    <!-- END list-email -->
                                </div>
                            </div>
                            <div class="mailbox-content-footer d-flex align-items-center">
                                <div class="text-inverse fw-bold"> {{App\Models\email::all()->count()}} emails</div>
                            </div>
                        </div>
                        <!-- END mailbox-content -->
                    </div>
                </div>
                <!-- END hljs-wrapper -->
            </div>
            <!-- END panel -->
        </div>
        <!-- END col-10 -->
    </div>


@endsection
