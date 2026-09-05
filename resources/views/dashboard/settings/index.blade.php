@extends('dashboard._layout.main')

@section('container')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>

    <h1 class="page-header">{{$title}}</h1>

    <div class="row">
        <div class="col-xl-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Milestone Settings</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="flash-data-success" data-flashdatasuccess="{{ session('success') }}"></div>
                @endif

                @if (session()->has('error'))
                    <div class="flash-data-error" data-flashdataerror="{{ session('error') }}"></div>
                @endif

                <div class="panel-body">
                    <form action="/content/store" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="section" value="setting">

                        <div class="mb-4">
                            <label class="form-label fw-bold" for="milestone_steps">MILESTONE_STEPS</label>
                            <textarea class="form-control" id="milestone_steps" name="milestone_steps" rows="3" required>{{ old('milestone_steps', $milestoneSteps->description) }}</textarea>
                            <div class="form-text">Pisahkan setiap step dengan koma. Contoh: send_resume,interview_1,interview_2,mcu,offering,joint</div>
                            @error('milestone_steps')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" for="milestone_statuses">MILESTONE_STATUSES</label>
                            <textarea class="form-control" id="milestone_statuses" name="milestone_statuses" rows="3" required>{{ old('milestone_statuses', $milestoneStatuses->description) }}</textarea>
                            <div class="form-text">Pisahkan setiap status dengan koma. Contoh: pending,active,completed</div>
                            @error('milestone_statuses')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
