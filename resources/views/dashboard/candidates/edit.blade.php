@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>

    <h1 class="page-header">{{$title}}</h1>

    <div class="row mb-3">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{$title}}</h4>
                </div>
                <div class="panel-body">
                    <form action="/dashboard/candidates/{{ $candidate->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $candidate->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $candidate->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $candidate->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="linkedin_url">Linkedin URL</label>
                            <input type="url" class="form-control" name="linkedin_url" value="{{ old('linkedin_url', $candidate->linkedin_url) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="cv_url">CV Link</label>
                            <input type="url" class="form-control" name="cv_url" value="{{ old('cv_url', $candidate->cv_url) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="portfolio_url">Portfolio URL</label>
                            <input type="url" class="form-control" name="portfolio_url" value="{{ old('portfolio_url', $candidate->portfolio_url) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control" name="notes" rows="4">{{ old('notes', $candidate->notes) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="/dashboard/candidates" class="btn btn-default">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
