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
    
    <div class="row mb-3">
        <div class="col-12">
            <!-- BEGIN panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-10">
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
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                            <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                                @if ($user->image)
                                <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $user->image)}}" id="img-preview" alt="">
                                @else 
                                <img class="h-100px my-n1 mx-n1" src="{{asset('img/default-user.png')}}" id="img-preview" alt="">
                                @endif
                            </figure>

                            <dl>
                                <dt>Name</dt>
                                <dd>{{$user->name}}</dd>
                                <dt>Email</dt>
                                <dd>{{$user->email}}</dd>
                            </dl>
                        
                </div>
               
            </div>
        </div>
    </div>
 
@endsection