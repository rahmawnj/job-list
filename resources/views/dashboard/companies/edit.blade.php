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
                    <form action="/dashboard/companies/{{$company->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                       
                            <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                                @if ($company->logo)
                                <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $company->logo)}}" id="img-preview" alt="">
                                @else 
                                <img class="h-100px my-n1 mx-n1" src="{{asset('img/default.png')}}" id="img-preview" alt="">
                                @endif
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
                                <input class="form-control" type="text" name="name" value="{{ old('name', $company->name) }}" >
                                @error('name')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                              <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ old('description', $company->description) }}</textarea>
                                @error('description')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email', $company->email) }}" >
                                @error('email')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input class="form-control" type="text" name="phone" value="{{ old('phone', $company->phone) }}" >
                                @error('phone')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="website">Website</label>
                                <input class="form-control" type="text" name="website" value="{{ old('website', $company->website) }}" >
                                @error('website')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="5">{{ old('address', $company->address) }}</textarea>
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
                                    <option {{ ($company->show == 'active') ? 'selected' : '' }} value="active">Active</option>
                                    <option {{ ($company->show == 'inactive') ? 'selected' : '' }}  value="inactive">Inactive</option>
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
