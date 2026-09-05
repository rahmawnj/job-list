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
                @if (session()->has('success'))
                <div class="flash-data-success" data-flashdatasuccess="{{session('success')}} " ></div>
                @endif
                @if (session()->has('error'))
                <div class="flash-data-error" data-flashdataerror="{{session('error')}} " ></div>
                @endif
                @if (session()->has('warning'))
                <div class="flash-data-warning" data-flashdatawarning="{{session('warning')}} " ></div>
                @endif
                <div class="panel-body">
                    <form action="/applyprocess/store" method="post" name="wysihtml5" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $applyprocess[0]->logo)}}" id="img-preview-logo-s1" alt="">
                                </figure>
                                <label class="form-label" for="logo_s1">Logo Step 1</label>
                                <input type="hidden" id="id_s1" name="id_s1" value="{{ $applyprocess[0]->id }}" >
                                <input class="form-control" id="logo-s1" value="{{ old('logo_s1', $applyprocess[0]->logo) }}" name="logo_s1" type="file" onchange="previewImageLogoS1()">
                                @error('logo_s1')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                         
                            <div class="mb-3">
                                <label class="form-label" for="title_s1">Title Step 1</label>
                                <input required class="form-control" type="text" id="title_s1" name="title_s1" value="{{ old('title_s1', $applyprocess[0]->title) }}" >
                                @error('title_s1')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="description_s1">Description Step 1</label>
                                <textarea required class="form-control" id="description_s1" name="description_s1" rows="3">{{ old('description_s1', $applyprocess[0]->description) }}</textarea>
                                @error('description_s1')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $applyprocess[1]->logo)}}" id="img-preview-logo-s2" alt="">
                                </figure>
                                <label class="form-label" for="logo_s2">Logo Step 2</label>
                                <input type="hidden" id="id_s2" name="id_s2" value="{{ $applyprocess[1]->id }}" >
                                <input class="form-control" id="logo-s2" value="{{ old('logo_s2', $applyprocess[1]->logo) }}" name="logo_s2" type="file" onchange="previewImageLogoS2()">
                                @error('logo_s2')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                         
                            <div class="mb-3">
                                <label class="form-label" for="title_s2">Title Step 2</label>
                                <input required class="form-control" type="text" id="title_s2" name="title_s2" value="{{ old('title_s2', $applyprocess[1]->title) }}" >
                                @error('title_s2')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="description_s2">Description Step 2</label>
                                <textarea required class="form-control" id="description_s2" name="description_s2" rows="3">{{ old('description_s2', $applyprocess[1]->description) }}</textarea>
                                @error('description_s2')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $applyprocess[2]->logo)}}" id="img-preview-logo-s3" alt="">
                                </figure>
                                <label class="form-label" for="logo_s3">Logo Step 3</label>
                                <input type="hidden" id="id_s3" name="id_s3" value="{{ $applyprocess[2]->id }}" >
                                <input class="form-control" id="logo-s3" value="{{ old('logo_s3', $applyprocess[2]->logo) }}" name="logo_s3" type="file" onchange="previewImageLogoS3()">
                                @error('logo_s3')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                         
                            <div class="mb-3">
                                <label class="form-label" for="title_s3">Title Step 3</label>
                                <input required class="form-control" type="text" id="title_s3" name="title_s3" value="{{ old('title_s3', $applyprocess[2]->title) }}" >
                                @error('title_s3')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="description_s3">Description Step 3</label>
                                <textarea required class="form-control" id="description_s3" name="description_s3" rows="3">{{ old('description_s3', $applyprocess[2]->description) }}</textarea>
                                @error('description_s3')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $applyprocess[3]->logo)}}" id="img-preview-logo-s4" alt="">
                                </figure>
                                <label class="form-label" for="logo_s4">Logo Step 4</label>
                                <input type="hidden" id="id_s4" name="id_s4" value="{{ $applyprocess[3]->id }}" >
                                <input class="form-control" id="logo-s4" value="{{ old('logo_s4', $applyprocess[3]->logo) }}" name="logo_s4" type="file" onchange="previewImageLogoS4()">
                                @error('logo_s4')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                         
                            <div class="mb-3">
                                <label class="form-label" for="title_s4">Title Step 4</label>
                                <input required class="form-control" type="text" id="title_s4" name="title_s4" value="{{ old('title_s4', $applyprocess[3]->title) }}" >
                                @error('title_s4')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="description_s4">Description Step 4</label>
                                <textarea required class="form-control" id="description_s4" name="description_s4" rows="3">{{ old('description_s4', $applyprocess[3]->description) }}</textarea>
                                @error('description_s4')
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
   
        function previewImageLogoS1()
        {
            const image = document.querySelector('#logo-s1')
            const imgPreview = document.querySelector('#img-preview-logo-s1')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageLogoS2()
        {
            const image = document.querySelector('#logo-s2')
            const imgPreview = document.querySelector('#img-preview-logo-s2')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageLogoS3()
        {
            const image = document.querySelector('#logo-s3')
            const imgPreview = document.querySelector('#img-preview-logo-s3')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageLogoS4()
        {
            const image = document.querySelector('#logo-s4')
            const imgPreview = document.querySelector('#img-preview-logo-s4')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
  
    </script>
@endsection