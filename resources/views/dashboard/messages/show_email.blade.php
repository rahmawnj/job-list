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
                    <div class="mailbox" style="width: 100%;">
                        <div class="" style="width: 100%;">
                           
                        	<div class="mailbox-content-body">
                                <!-- BEGIN scrollbar -->
                                <div data-scrollbar="true" data-height="100%" data-skip-mobile="true">
                                    <div class="p-3">
                                        <h3 class="mb-3">{{$email->subject}}</h3>
                                        <small class="mb-3">{{$email->email}}</small>
                                        <div class="d-flex mb-3">
                                            <a href="javascript:;">
                                                <img class="rounded-pill" width="48" alt="" src="../assets/img/user/user-12.jpg" />
                                            </a>
                                            <div class="ps-3">
                                                <div class="email-from text-inverse fs-14px mb-3px fw-bold">
                                                    {{$email->from}}
                                                </div>
                                                <div class="mb-3px"><i class="fa fa-clock fa-fw"></i> {{\Carbon\Carbon::parse($email->created_at)}}</div>
                                              
                                            </div>
                                        </div>
                                        <hr class="bg-gray-500" />
        
                                        {!!$email->message!!}


                                    </div>
                                </div>
                                <!-- END scrollbar -->
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
