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
                        <a href="/dashboard/jobs/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
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
                    <figure class="m-auto d-flex justify-content-center rounded" style="width:100px; overflow:hidden;" >
                        @if ($job->image)
                            <img class="h-100px my-n1 mx-n1" src="{{asset('storage/' . $job->image)}}" id="img-preview" alt="">
                        @else
                            <img class="h-100px my-n1 mx-n1" src="{{asset('img/default.png')}}" id="img-preview" alt="">
                        @endif
                    </figure>
                    <h1>{{$job->title}}</h1>
                    <span>{{$job->applyjobs->count()}} Lamaran</span>
                    <table style="width: 100%;" id="data-table-buttons" class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th width="1%"></th>
                                <th>Name</th>
                                <th class="text-nowrap">Link</th>
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">Document Name</th>
                                <th class="text-nowrap">Date</th>
                                <th class="text-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applyjobs as $applyjob)
                            <tr class="{{ $applyjob->read == '0' ? 'table-warning' : '' }}">
                                <td width="1%" class="fw-bold text-inverse">{{$loop->iteration}}</td>
                                <td>{{$applyjob->name}}</td>
                                <td>{{$applyjob->link}}</td>
                                <td>{{$applyjob->email}}</td>

                                <td>
                                    {{ basename($applyjob->url)}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($applyjob->created_at)->format('d-m-Y') }}
                                </td>
                                <td>
                                    <a href="/jobs/apply-delete/{{$applyjob->id}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    <a href="#modal-dialog-{{$applyjob->id}}" class="btn btn-sm btn-info" data-bs-toggle="modal"><i class="fa fa-file-alt"></i></a>
                                    <a href="{{ route('admin.job.apply-job-detail', $applyjob->id) }}" class="btn btn-sm btn-indigo"><i class="fa fa-eye"></i></a>
                                </td>
                                <div class="modal fade" id="modal-dialog-{{$applyjob->id}}" >
                                  <div class="modal-dialog modal-dialog-centered" style="  width: 100%;
                                          max-width: 100%;
                                          margin: 0 auto;" >
                                    <div class="modal-content" style="width: 80%; margin: 0 auto;" >
                                      <div class="modal-header">
                                        <h4 class="modal-title">{{$applyjob->name}}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                      </div>
                                      <div class="modal-body" style="height: 350px;">
                                          <iframe src="{{asset('storage/' . $applyjob->url)}}" style="width: 100%; height:100%;" frameborder="0"></iframe>
                                      </div>
                                      <div class="modal-footer">
                                        <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                                        <!--<a href="javascript:;" class="btn btn-success">Action</a>-->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END hljs-wrapper -->
            </div>
            <!-- END panel -->
        </div>
        <!-- END col-10 -->
    </div>
@endsection
