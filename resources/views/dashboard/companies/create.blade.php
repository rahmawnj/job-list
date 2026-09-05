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
                    <form action="/dashboard/companies" method="post" enctype="multipart/form-data">
                        @csrf
                        <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                            <img class="h-100px my-n1 mx-n1" src="{{ asset('img/default.png') }}" id="img-preview" alt="">
                        </figure>
                        <fieldset>
    
                            <div class="mb-3">
                                <label class="form-label" for="logo">Logo</label>
                                <input class="form-control" type="file" name="logo" id="image" onchange="previewImage()" value="{{ old('logo') }}" >
                                @error('logo')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" >
                                @error('name')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" >
                                @error('email')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" >
                                @error('phone')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="website">Website</label>
                                <input class="form-control" type="text" name="website" value="{{ old('website') }}" >
                                @error('website')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                       
                            <div class="mb-3">
                                <label class="form-label" for="show">Display Status</label>
                                <select class="form-control" name="show" id="show">
                                    <option value="" selected disabled>Display Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('show')
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

