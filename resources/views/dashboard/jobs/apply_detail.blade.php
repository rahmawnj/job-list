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

    <div class="row">
        <!-- BEGIN col-2 -->

        <!-- END col-2 -->
        <!-- BEGIN col-10 -->
        <div class="col-xl-12">
            <!-- BEGIN panel -->
            <div class="panel panel-inverse">
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
                <!-- BEGIN alert -->

                @if (session()->has('success'))
                <div class="flash-data-success" data-flashdatasuccess="{{session('success')}} " ></div>
                @endif
                @if (session()->has('error'))
                <div class="flash-data-error" data-flashdataerror="{{session('error')}} " ></div>
                @endif
                @if (session()->has('warning'))
                <div class="flash-data-warning" data-flashdatawarning="{{session('warning')}} " ></div>
                @endif
                <!-- END alert -->
                <!-- BEGIN panel-body -->
                <div class="panel-body">
                        <span for="sent_at">Tanggal Kirim Lamaran</span>
                  {{ $apply_job->created_at ? $apply_job->created_at->format('d-m-Y H:i:s') : '' }}

                        <span for="updated_at">Tanggal Terakhir Diperbarui</span>
                  {{ $apply_job->updated_at ? $apply_job->updated_at->format('d-m-Y H:i:s') : '' }}

                    <div class="input">
                        <form class="my-2" action="{{ route('admin.job.apply-job-detail.update', $apply_job->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group my-2">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending" {{ old('status',$apply_job->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status',$apply_job->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status',$apply_job->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="note">Catatan</label>
                                <textarea class="form-control" id="note" name="note" rows="3">{{ old('note', $apply_job->note) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>

                    <div class="preview">
                        <iframe src="{{asset('storage/' . $apply_job->url)}}" style="width: 100%;" height="400" frameborder="1"></iframe>
                    </div>
                </div>
                <!-- END hljs-wrapper -->
            </div>
            <!-- END panel -->
        </div>
        <!-- END col-10 -->
    </div>
@endsection
