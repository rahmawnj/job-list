@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <h1 class="page-header">{{$title}}</h1>
    
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
                                @if ($company->logo)
                                <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $company->logo)}}" id="img-preview" alt="">
                                @else 
                                <img class="h-100px my-n1 mx-n1" src="{{asset('img/default.png')}}" id="img-preview" alt="">
                                @endif
                            </figure>

                        <dl>
                            <dt>Company Name</dt>
                            <dd>{{$company->name}}</dd>
                            <dt>Email</dt>
                            <dd>{{$company->email}}</dd>
                            <dt>Phone</dt>
                            <dd>{{$company->phone}}</dd>
                            <dt>Website</dt>
                            <dd>{{$company->website}}</dd>
                            <dt>Address</dt>
                            <dd>{{$company->address}}</dd>
                            <dt>Description</dt>
                            <dd>{{$company->description}}</dd>
                            <dt>Display Status</dt>
                            <dd class="badge {{($company->show == 'active') ? 'bg-success' : 'bg-warning'}}"> {{$company->show}} </dd>
                        </dl>
                </div>
               
            </div>
        </div>
    </div>
@endsection
