
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
    
    <!-- BEGIN row -->
    <div class="row ">
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-building"></i></div>
                <div class="stats-info">
                    <h4>TOTAL Companies</h4>
                    <p>{{App\Models\Jobcategory::all()->count()}}</p>	
                </div>
                <div class="stats-link">
                    <a href="/dashboard/companies">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-info">
                <div class="stats-icon"><i class="fa fa-id-badge"></i></div>
                <div class="stats-info">
                    <h4>TOTAL Jobs</h4>
                    <p>{{App\Models\Job::all()->count()}}</p>	
                </div>
                <div class="stats-link">
                    <a href="/dashboard/jobs">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-orange">
                <div class="stats-icon"><i class="fa fa-fax"></i></div>
                <div class="stats-info">
                    <h4>TOTAL Job Categories</h4>
                    <p>{{App\Models\Jobcategory::all()->count()}}</p>	
                </div>
                <div class="stats-link">
                    <a href="/dashboard/jobcategories">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
        <!-- BEGIN col-3 -->
        <div class="col-xl-3 col-md-6">
            <div class="widget widget-stats bg-red">
                <div class="stats-icon"><i class="fa fa-user"></i></div>
                <div class="stats-info">
                    <h4>TOTAL Users</h4>
                    <p>{{App\Models\User::all()->count()}}</p>	
                </div>
                <div class="stats-link">
                    <a href="/dashboard/users">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- END col-3 -->
    </div>

     
        <!-- BEGIN row -->
        <div class="row">
        
            <!-- END col-6 -->
            <!-- BEGIN col-6 -->
            <div class="col-xl-6">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="chart-js-3">
                    <div class="panel-heading">
                        <h4 class="panel-title">Visitors in last 7 days</h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="panel-body p-0">
                        <div style="height: 200px;" id="apex-area-chart"></div>
                    </div>
                
                </div>
                <!-- END panel -->
            </div>
            <div class="col-xl-6">
                <!-- BEGIN panel -->
                <div class="panel panel-inverse" data-sortable-id="chart-js-3">
                    <div class="panel-heading">
                        <h4 class="panel-title">Job Categories Percentage</h4>
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
               
                    <div class="panel-body p-0">
                        <div style="height: 200px;" id="chart-job-categories"></div>
                    </div>
                
                </div>
                <!-- END panel -->
            </div>
            <!-- END col-6 -->
            <!-- BEGIN col-6 -->
    
        </div>
        <!-- END row -->

   

@endsection

@push('scripts')

<script src="{{asset('assets/dashboard/plugins/apexcharts/dist/apexcharts.min.js')}}"></script>
<script>
      var visitors = {{ Js::from($visitors) }}
      var dates = [];
      var total = [];
    visitors.forEach(element => {
        dates.push(element.date)
        total.push(element.total)
    });
     var options = {
        title: {
            position: 'top', // top, center, bottom

        //   text: 'Visitors in last 7 days',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        },
          series: [{
          name: 'visitors',
          data: total
        }],
          chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 2,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val ;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: dates,
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val ;
            }
          }
        
        },
      
        };

        var chart = new ApexCharts(document.querySelector("#apex-area-chart"), options);
        chart.render();
      
      
    
  </script>
  <script>
      var categories = {{ Js::from($categories) }}
    var jobsCount = {{ Js::from($jobsCount) }}
    var options = {
      chart: {
        height: 365,
        type: 'pie',
      },
      dataLabels: {
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          opacity: 0.45
        }
      },
      labels: categories.original,
		series: jobsCount.original,
		title: {
			text: 'Job Categories'
		}
    };
  
    var chart = new ApexCharts(
      document.querySelector('#chart-job-categories'),
      options
    );
  
    chart.render();
  </script>


@endpush