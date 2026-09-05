@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <h1 class="page-header">{{$title}}</h1>
    
    <div class="row mb-3">
        <div class="col-xl-12">
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
                    @if (session()->has('success'))
                <div class="flash-data-success" data-flashdatasuccess="{{session('success')}} " ></div>
                @endif
                    <form action="/auth/profile" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                            @if ($user->image)
                            <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $user->image)}}" id="img-preview" alt="">
                            @else 
                            <img class="h-100px my-n1 mx-n1" src="{{asset('img/default-user.png')}}" id="img-preview" alt="">
                            @endif
                        </figure>
                        <fieldset>
                            <div class="mb-3">
                                <label class="form-label" for="image">Image</label>
                                <input class="form-control" type="file" name="image" id="image" onchange="previewImage()" value="{{ old('image') }}" >
                                @error('image')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" >
                                @error('name')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                             
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" >
                                @error('email')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" type="password" name="password" value="" >
                                @error('password')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                           
                           
                            <button type="submit" class="btn btn-primary w-100px me-5px">Submit</button>
                        </fieldset>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
@endsection
