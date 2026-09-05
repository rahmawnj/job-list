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
                    <form action="/dashboard/jobcategories" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">name</label>
                                <input class="form-control" type="text" id="name" onchange="SlugChange()" name="name" value="{{ old('name') }}" >
                                @error('name')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="logo">Logo</label>
                                <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
                                @error('logo')<span class="text-sm text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="is_top_category" name="is_top_category" value="1" @checked(old('is_top_category'))>
                                <label class="form-check-label" for="is_top_category">Tampilkan di Top Categories</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="slug">slug</label>
                                <input class="form-control" id="slug" type="text" readonly name="slug" value="{{ old('slug') }}" >
                                @error('slug')
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
    <script>
        const name = document.querySelector('#name')
        const slug = document.querySelector('#slug')
        // name.addEventListener('change', function(){
        //     fetch('/dashboard/jobcategories/slug?name=' + name.value)
        //     .then(response => response.json())
        //     .then(data => slug.value = data.slug)
        // })
        function SlugChange(){
            fetch('/dashboard/jobcategories/slug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        }
    </script>
@endsection