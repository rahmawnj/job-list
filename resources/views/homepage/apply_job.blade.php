@extends('homepage._layout.main')

@push('meta')
<meta name="description" content="{{\App\Models\Job::find($id_job)->title}} {{App\Models\Job::find($id_job)->company->name}}">
@endpush

@section('container')
    <!-- Hero Area Start-->
    <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description)}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{App\Models\Job::find($id_job)->jobcategory->name}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Hero Area End -->
    <!-- job post company Start -->
    <div class="job-post-company pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-between">
                <!-- Left Content -->
                <div class="col-12">
                    <!-- job single -->
                    <div class="single-job-items mb-50">
                        <div class="job-items align-items-center">
                            <div class="company-img">
                                <img height="60" style="border: 1px #c4bfbf solid" src="{{asset('storage/' . App\Models\Job::find($id_job)->image)}}" alt="">
                            </div>
                            <div class="job-tittle">
                                <h4>{{App\Models\Job::find($id_job)->title}}</h4>
                            </div>
                        </div> 
                    </div>
                    <div class=""> 
                        @if (session()->has('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        @if (session()->has('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                        @endif
                        <form action="{{route('apply_job.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                      
                        <input type="hidden" name="job_id" value="{{$id_job}}" >
                            <div class="mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" >
                                @error('name')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="link">Insert Link (optional)</label>
                                <input class="form-control" type="text" name="link" value="{{ old('link') }}" >
                                @error('link')
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
                                <label class="form-label" for="description">Description</label>
                                <textarea class="textarea form-control" id="description" name="description" cols="30" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="document">Upload CV</label>
                                <b>[pdf]</b>
                                <input class="form-control" type="file" name="document" value="{{ old('document') }}" accept="application/pdf">
                                @error('document')
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
    </div>
    <!-- job post company End -->


@endsection
