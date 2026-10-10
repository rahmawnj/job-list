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
                        <style>
                            .application-date-grid {
                                display: grid;
                                grid-template-columns: repeat(2, minmax(0, 1fr));
                                gap: 16px;
                                margin-bottom: 26px;
                            }
                            .application-date-card {
                                position: relative;
                                display: flex;
                                align-items: flex-start;
                                gap: 15px;
                                min-width: 0;
                                padding: 22px;
                                overflow: hidden;
                                border: 1px solid #e7edf5;
                                border-radius: 16px;
                                background: linear-gradient(135deg, #fff 0%, #f8fbff 100%);
                                box-shadow: 0 8px 24px rgba(30, 55, 90, .055);
                            }
                            .application-date-card::after {
                                position: absolute;
                                right: -24px;
                                bottom: -34px;
                                width: 100px;
                                height: 100px;
                                border-radius: 50%;
                                background: rgba(42, 147, 213, .055);
                                content: "";
                            }
                            .application-date-icon {
                                display: flex;
                                flex: 0 0 48px;
                                align-items: center;
                                justify-content: center;
                                width: 48px;
                                height: 48px;
                                border-radius: 14px;
                                background: #eaf4ff;
                                color: #2586d7;
                                font-size: 19px;
                            }
                            .application-date-card.is-updated .application-date-icon {
                                background: #e8faf2;
                                color: #159568;
                            }
                            .application-date-content { min-width: 0; position: relative; z-index: 1; }
                            .application-date-label {
                                display: block;
                                margin: 2px 0 9px;
                                color: #718096;
                                font-size: 12px;
                                font-weight: 700;
                                letter-spacing: .055em;
                                line-height: 1.5;
                                text-transform: uppercase;
                            }
                            .application-date-value {
                                display: block;
                                color: #202b3c;
                                font-size: 21px;
                                font-weight: 750;
                                letter-spacing: -.035em;
                                line-height: 1.25;
                                overflow-wrap: anywhere;
                            }
                            .application-date-time {
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                margin-top: 9px;
                                color: #8491a3;
                                font-size: 13px;
                                font-weight: 500;
                            }
                            @media (max-width: 767.98px) {
                                .application-date-grid { grid-template-columns: 1fr; gap: 12px; }
                                .application-date-card { padding: 18px; }
                                .application-date-value { font-size: 19px; }
                            }
                        </style>

                        <div class="application-date-grid">
                            <div class="application-date-card">
                                <div class="application-date-icon" aria-hidden="true">
                                    <i class="fa fa-paper-plane"></i>
                                </div>
                                <div class="application-date-content">
                                    <span class="application-date-label">Tanggal Kirim Lamaran</span>
                                    <span class="application-date-value">
                                        {{ $apply_job->created_at ? $apply_job->created_at->format('d M Y') : '—' }}
                                    </span>
                                    <span class="application-date-time">
                                        <i class="fa fa-clock" aria-hidden="true"></i>
                                        {{ $apply_job->created_at ? $apply_job->created_at->format('H:i:s') : 'Waktu tidak tersedia' }}
                                    </span>
                                </div>
                            </div>

                            <div class="application-date-card is-updated">
                                <div class="application-date-icon" aria-hidden="true">
                                    <i class="fa fa-clock-rotate-left"></i>
                                </div>
                                <div class="application-date-content">
                                    <span class="application-date-label">Terakhir Diperbarui</span>
                                    <span class="application-date-value">
                                        {{ $apply_job->updated_at ? $apply_job->updated_at->format('d M Y') : '—' }}
                                    </span>
                                    <span class="application-date-time">
                                        <i class="fa fa-clock" aria-hidden="true"></i>
                                        {{ $apply_job->updated_at ? $apply_job->updated_at->format('H:i:s') : 'Waktu tidak tersedia' }}
                                    </span>
                                </div>
                            </div>
                        </div>

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
