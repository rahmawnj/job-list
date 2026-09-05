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
                    <form action="/content/store" method="post" name="wysihtml5" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input type="hidden" id="id_name" name="id_name" value="{{ $content[0]->id }}" >
                                <input required class="form-control" type="text" id="name" name="name" value="{{ old('name', $content[0]->description) }}" >
                                @error('name')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="hero_description">Hero Title</label>
                                <input type="hidden" id="id_hero_description" name="id_hero_description" value="{{ $content[10]->id }}" >
                                <input required class="form-control" type="text" id="hero_description" name="hero_description" value="{{ old('hero_description', $content[10]->description) }}" >
                                @error('hero_description')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="hero_caption_description">Hero Caption</label>
                                <input type="hidden" id="id_hero_caption_description" name="id_hero_caption_description" value="{{ $content[2]->id }}" >
                                <input required class="form-control" type="text" id="hero_caption_description" name="hero_caption_description" value="{{ old('hero_caption_description', $content[2]->description) }}" >
                                @error('hero_caption_description')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="about">About</label>
                                <input type="hidden" id="id_about" name="id_about" value="{{ $content[8]->id }}" >
                                <textarea class="ckeditor" id="editor1" name="about" rows="10">{{ old('about', $content[8]->description) }}</textarea>
                                @error('about')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                           
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="hidden" id="id_email" name="id_email" value="{{ $content[6]->id }}" >
                                <input required class="form-control" type="email" id="email" name="email" value="{{ old('email', $content[6]->description) }}" >
                                @error('email')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email_apply">Email Apply</label>
                                <input type="hidden" id="id_email_apply" name="id_email_apply" value="{{ $content[14]->id }}" >
                                <input required class="form-control" type="email_apply" id="email_apply" name="email_apply" value="{{ old('email_apply', $content[14]->description) }}" >
                                @error('email_apply')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input type="hidden" id="id_phone" name="id_phone" value="{{ $content[5]->id }}" >
                                <input required class="form-control" type="phone" id="phone" name="phone" value="{{ old('phone', $content[5]->description) }}" >
                                @error('phone')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="map_location">Map Location</label>
                                <input type="hidden" id="id_map_location" name="id_map_location" value="{{ $content[13]->id }}" >
                                <input required class="form-control" type="map_location" id="map_location" name="map_location" value="{{ old('map_location', $content[13]->description) }}" >
                                @error('map_location')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Address</label>
                                <input type="hidden" id="id_address" name="id_address" value="{{ $content[7]->id }}" >
                                <textarea required class="form-control" id="address" name="address" cols="30" rows="3">{{ old('address', $content[7]->description) }}</textarea>
                                @error('address')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="title_jobs_hero">Title Jobs Vacancy Hero</label>
                                <input type="hidden" id="id_title_jobs_hero" name="id_title_jobs_hero" value="{{ $content[15]->id }}" >
                                <input required class="form-control" type="text" id="title_jobs_hero" name="title_jobs_hero" value="{{ old('title_jobs_hero', $content[15]->description) }}" >
                                @error('title_jobs_hero')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="title_about_hero">Title About Hero</label>
                                <input type="hidden" id="id_title_about_hero" name="id_title_about_hero" value="{{ $content[16]->id }}" >
                                <input required class="form-control" type="text" id="title_about_hero" name="title_about_hero" value="{{ old('title_about_hero', $content[16]->description) }}" >
                                @error('title_about_hero')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="title_contact_hero">Title Contact Hero</label>
                                <input type="hidden" id="id_title_contact_hero" name="id_title_contact_hero" value="{{ $content[17]->id }}" >
                                <input required class="form-control" type="text" id="title_contact_hero" name="title_contact_hero" value="{{ old('title_contact_hero', $content[17]->description) }}" >
                                @error('title_contact_hero')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                          

                            <hr>
                            <h3>Image</h3>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $content[3]->description)}}" id="img-preview-logo-header" alt="">
                                </figure>

                                <label class="form-label" for="logo_header">Logo Header</label>
                                <input type="hidden" id="id_logo_header" name="id_logo_header" value="{{ $content[3]->id }}" >
                                <input class="form-control" id="logo-header" value="{{ old('logo_header', $content[3]->description) }}" name="logo_header" type="file" onchange="previewImageLogoHeader()">
                                @error('logo_header')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $content[4]->description)}}" id="img-preview-logo-footer" alt="">
                                </figure>
                                <label class="form-label" for="logo_footer">Logo Footer</label>
                                <input type="hidden" id="id_logo_footer" name="id_logo_footer" value="{{ $content[4]->id }}" >
                                <input class="form-control" id="logo-footer" value="{{ old('logo_footer', $content[4]->description) }}" name="logo_footer" type="file" onchange="previewImageLogoFooter()">
                                @error('logo_footer')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $content[1]->description)}}" id="img-preview-hero-image" alt="">
                                </figure>
                                <label class="form-label" for="hero_image">Hero Image</label>
                                <input type="hidden" id="id_hero_image" name="id_hero_image" value="{{ $content[1]->id }}" >
                                <input class="form-control" id="hero-image" value="{{ old('hero_image', $content[1]->description) }}" name="hero_image" type="file" onchange="previewImageHeroImage()">
                                @error('hero_image')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $content[11]->description)}}" id="img-preview-slider-background" alt="">
                                </figure>
                                <label class="form-label" for="slider_background">Slider Background</label>
                                <input type="hidden" id="id_slider_background" name="id_slider_background" value="{{ $content[11]->id }}" >
                                <input class="form-control" id="slider-background" value="{{ old('slider_background', $content[11]->description) }}" name="slider_background" type="file" onchange="previewImageSliderBackground()">
                                @error('slider_background')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <figure class="m-auto d-flex justify-content-center">
                                    <img height="100" src="{{asset('storage/' . $content[12]->description)}}" id="img-preview-about-image" alt="">
                                </figure>
                                <label class="form-label" for="about_image">About Image</label>
                                <input type="hidden" id="id_about_image" name="id_about_image" value="{{ $content[12]->id }}" >
                                <input class="form-control" id="about-image" value="{{ old('about_image', $content[12]->description) }}" name="about_image" type="file" onchange="previewImageAboutImage()">
                                @error('about_image')
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
        function previewImageAboutImage()
        {
            const image = document.querySelector('#about-image')
            const imgPreview = document.querySelector('#img-preview-about-image')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageSliderBackground()
        {
            const image = document.querySelector('#slider-background')
            const imgPreview = document.querySelector('#img-preview-slider-background')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageHeroImage()
        {
            const image = document.querySelector('#hero-image')
            const imgPreview = document.querySelector('#img-preview-hero-image')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageLogoHeader()
        {
            const image = document.querySelector('#logo-header')
            const imgPreview = document.querySelector('#img-preview-logo-header')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
        function previewImageLogoFooter()
        {
            const image = document.querySelector('#logo-footer')
            const imgPreview = document.querySelector('#img-preview-logo-footer')
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0])
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }

        const name = document.querySelector('#name')
        const slug = document.querySelector('#slug')
        name.addEventListener('change', function(){
            fetch('/jobcategories/slug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
        })
    </script>
@endsection