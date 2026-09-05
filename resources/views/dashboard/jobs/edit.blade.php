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
                    <form action="/dashboard/jobs/{{$job->id}}" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                            @if ($job->image)
                            <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $job->image)}}" id="img-preview" alt="">
                            @else 
                            <img class="h-100px my-n1 mx-n1" src="{{asset('img/default.png')}}" id="img-preview" alt="">
                            @endif
                        </figure>
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
                                <label class="form-label" for="company_id">Company</label>
                                <select class="form-control" name="company_id" id="company_id">
                                    @foreach ($companies as $company)
                                    <option {{ ($company->id == old('company_id', $job->company_id)) ? 'selected' : '' }} value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jobcategory_id">Job Category</label>
                                <select class="form-control" name="jobcategory_id" id="jobcategory_id">
                                    @foreach ($jobcategories as $jobcategory)
                                    <option {{ ($jobcategory->id == old('jobcategory_id', $job->jobcategory_id)) ? 'selected' : '' }} value="{{$jobcategory->id}}">{{$jobcategory->name}}</option>
                                    @endforeach
                                </select>
                                @error('jobcategory_id')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input class="form-control" type="text" name="title" value="{{ old('title', $job->title) }}" >
                                @error('title')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                         
                            <div class="mb-3">
                                <label class="form-label" for="salary">Salary</label>
                                <input class="form-control" type="text" name="salary" value="{{ old('salary', $job->salary) }}" >
                                @error('salary')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label" for="total_position">Total Position</label>
                                <input class="form-control" type="number" name="total_position" value="{{ old('total_position', $job->total_position) }}" >
                                @error('total_position')
                                <span class="text-sm text-danger">
                                    {{$message}}
                                </span>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="location_id">Location</label>
                                <select class="form-control" name="location_id" id="location_id">
                                    @foreach ($locations as $location)
                                    <option {{ ($location->id == old('location_id', $job->location_id)) ? 'selected' : '' }} value="{{$location->id}}">{{$location->name}}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Job Description</label>
                                <textarea class="ckeditor" id="editor1" rows="20" name="description">
                                    {{ old('description', $job->description) }}
                                   </textarea>
                           
                                {{-- <textarea class="textarea form-control" id="wysihtml5-desc" class="form-control" name="description" id="description" cols="30" rows="5">{{ old('description', $job->description) }}</textarea> --}}
                                @error('description')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="requirement">Requirement, Qualification & Experience</label>
                                <textarea class="ckeditor" id="editor1" rows="20" name="requirement" rows="5">{{ old('requirement', $job->requirement) }}</textarea>
                                @error('requirement')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="type">Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="" selected disabled>Type</option>
                                    <option {{ ('full_time' == old('type', $job->type)) ? 'selected' : '' }} value="full_time">Full Time</option>
                                    <option {{ ('part_time' == old('type', $job->type)) ? 'selected' : '' }} value="part_time">Part Time</option>
                                    <option {{ ('freelance' == old('type', $job->type)) ? 'selected' : '' }} value="freelance">Freelance</option>
                                    <option {{ ('remote' == old('type', $job->type)) ? 'selected' : '' }} value="remote">Remote</option>
                                </select>
                                @error('type')
                                    <span class="text-sm text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option {{ ('active' == old('status', $job->status)) ? 'selected' : '' }} value="active">Active</option>
                                    <option {{ ('inactive' == old('status', $job->status)) ? 'selected' : '' }} value="inactive">Inactive</option>
                                </select>
                                @error('status')
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

@push('scripts')
<script>
    $('#wysihtml5-desc').wysihtml5();
    $('#wysihtml5-req').wysihtml5();
  </script>
@endpush