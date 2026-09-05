@extends('homepage._layout.main')

@section('container')
@push('page-css')
<link href="{{ asset('assets/dashboard/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
@endpush

<div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description)}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{!! \App\Models\Content::where('name', 'title_jobs_hero')->first()->description !!}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->
<!-- Job List Area Start -->
<div class="job-listing-area pt-120 pb-120">
    <div class="container">
        <div class="row">
            <!-- Left content -->
            <div class="col-xl-3 col-lg-3 col-md-4">
                <div class="job-category-listing mb-50">
                    <div class="small-section-tittle2 mb-30">
                        <div class="ion">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="12px">
                                <path fill-rule="evenodd" fill="rgb(27, 207, 107)" d="M7.778,12.000 L12.222,12.000 L12.222,10.000 L7.778,10.000 L7.778,12.000 ZM-0.000,-0.000 L-0.000,2.000 L20.000,2.000 L20.000,-0.000 L-0.000,-0.000 ZM3.333,7.000 L16.667,7.000 L16.667,5.000 L3.333,5.000 L3.333,7.000 Z"/>
                            </svg>
                        </div>
                        <h4>Filter Jobs</h4>
                    </div>

                    <form action="{{ url('/jobs') }}" method="GET" class="jobs-filter-form">
                        <!-- Search Filter Group -->
                        <div class="single-listing mb-25">
                            <div class="select-Categories jobs-search-filter">
                                <input class="form-control" name="search" id="search" type="search" placeholder="Search..." value="{{ request('search', '') }}">
                            </div>
                        </div>

                        <!-- Job Location Group -->
                        <div class="single-listing mb-25">
                            <div class="small-section-tittle2 mb-20">
                                <h4>Job Location</h4>
                            </div>
                            <div class="select-job-items">
                                <select id="location" name="location" data-picker>
                                    <option value="" {{ request('location', '') === '' ? 'selected' : '' }}>All Locations</option>
                                    @foreach (App\Models\Location::all() as $location)
                                        <option value="{{$location->id}}" {{ (string) request('location', '') === (string) $location->id ? 'selected' : '' }}>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Job Category Group -->
                        <div class="single-listing mb-25">
                            <div class="small-section-tittle2 mb-20">
                                <h4>Job Category</h4>
                            </div>
                            <div class="select-job-items">
                                <select id="job_category" name="job_category" data-picker>
                                    <option value="" {{ request('job_category', '') === '' ? 'selected' : '' }}>All Category</option>
                                    @foreach (App\Models\Jobcategory::all() as $jobcategory)
                                        <option value="{{$jobcategory->id}}" {{ (string) request('job_category', '') === (string) $jobcategory->id ? 'selected' : '' }}>{{$jobcategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Job Type Group -->
                        <div class="single-listing mb-25">
                            <div class="small-section-tittle2 mb-20">
                                <h4>Job Type</h4>
                            </div>
                            <div class="select-Categories jobs-type-filter">
                                <label class="container">Full Time
                                    <input name="job_type" type="radio" value="full_time" {{ request('job_type') === 'full_time' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Part Time
                                    <input name="job_type" type="radio" value="part_time" {{ request('job_type') === 'part_time' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Remote
                                    <input name="job_type" type="radio" value="remote" {{ request('job_type') === 'remote' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Freelance
                                    <input name="job_type" type="radio" value="freelance" {{ request('job_type') === 'freelance' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="jobs-filter-submit btn btn-primary w-100 mt-2">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Right content -->
            <div class="col-xl-9 col-lg-9 col-md-8">
                <!-- Featured_job_start -->
                <section class="featured-job-area">
                    <div class="container">
                        <!-- Count of Job list Start -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="count-job mb-35">
                                    <div class="job-list-topbar">
                                        <div class="job-results-count">
                                            <span>{{ $jobs->total() ?? 0 }} Jobs found</span>
                                        </div>

                                        <div class="select-job-items">
                                            <span>Sort by</span>
                                            <select id="sort_by" name="sort_by">
                                                <option value="">None</option>
                                                <option value="latest" {{ request('sort_by') === 'latest' ? 'selected' : '' }}>Latest</option>
                                                <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="job_data">
                            @include('homepage.job_data')
                        </div>
                    </div>
                </section>
                <!-- Featured_job_end -->
            </div>
        </div>
    </div>
</div>
<style id="jobs-sidebar-spacing">
    .job-listing-area {
        background: #f7f9fc;
    }

    .job-category-listing {
        background: #fff;
        border: 1px solid rgba(30, 33, 78, 0.08);
        border-radius: 24px;
        padding: 26px 20px;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.05);
    }

    .job-listing-area .job-category-listing > .small-section-tittle2 {
        margin-bottom: 28px !important;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .job-listing-area .job-category-listing > .small-section-tittle2 h4 {
        margin-bottom: 0 !important;
        line-height: 1.2;
        font-size: 18px;
        color: #1d2a4a;
        font-weight: 700;
    }
    .job-listing-area .job-category-listing .jobs-filter-form > .single-listing {
        margin-bottom: 24px !important;
    }
    .job-listing-area .job-category-listing .jobs-filter-form > .single-listing:last-of-type {
        margin-bottom: 12px !important;
    }
    .job-listing-area .job-category-listing .single-listing > .small-section-tittle2 h4 {
        margin-bottom: 12px !important;
        line-height: 1.2;
        font-size: 16px;
        color: #2a3145;
        font-weight: 700;
    }
    .job-listing-area .job-category-listing .small-section-tittle2 .ion {
        padding-right: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: rgba(42, 147, 213, 0.1);
    }
    .job-listing-area .job-category-listing .small-section-tittle2 .ion svg path {
        fill: #2a93d5;
    }

    .jobs-search-filter input,
    .select-job-items select {
        width: 100%;
        height: 46px;
        border: 1px solid #e7ebf2;
        background: #f8fafc;
        color: #1f2937;
        border-radius: 12px;
        padding: 0 16px;
        font-size: 15px;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    .jobs-filter-submit {
        height: 46px;
        border: 0;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
    }

    .job-category-listing .picker {
        display: block;
        width: 100%;
    }

    .job-category-listing .picker .pc-select {
        display: block;
        width: 100%;
        min-width: 0;
        max-width: none;
    }

    .job-category-listing .picker .pc-trigger {
        width: 100%;
        min-height: 46px;
        border: 1px solid #d7e3f0;
        border-radius: 12px;
        background: #fff;
        color: #172b4d;
        font-size: 15px;
        line-height: 44px;
        padding: 0 36px 0 16px;
        box-shadow: 0 4px 12px rgba(31, 75, 122, 0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .job-category-listing .picker .pc-trigger:hover,
    .job-category-listing .picker .pc-trigger:focus {
        border-color: #2a93d5;
        background: #fff;
        color: #172b4d;
        box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.1);
    }

    .job-category-listing .picker .pc-list {
        top: calc(100% + 8px);
        z-index: 1000;
        width: 100%;
        max-height: none;
        overflow: visible;
        border: 1px solid #dce7f2;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 16px 32px rgba(31, 75, 122, 0.16);
        padding: 8px;
    }

    .job-category-listing .picker .pc-list ul {
        max-height: 204px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .job-category-listing .picker .pc-list input[type="search"] {
        height: 36px;
        margin-bottom: 6px;
        padding: 0 10px;
        border: 1px solid #dce7f2;
        border-radius: 8px;
        background: #f7faff;
        color: #172b4d;
        font-size: 14px;
    }

    .job-category-listing .picker .pc-list input[type="search"]:focus {
        border-color: #2a93d5;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(42, 147, 213, 0.1);
    }

    .job-category-listing .picker .pc-list li {
        margin: 2px 0;
        padding: 8px 10px;
        border-radius: 8px;
        color: #30445f;
        font-size: 14px;
        line-height: 1.3;
    }

    .job-category-listing .picker .pc-list li:nth-child(even) {
        background: transparent;
    }

    .job-category-listing .picker .pc-list li:hover {
        background: #eaf6ff;
        color: #1677b7;
    }

    .jobs-search-filter input:focus,
    .select-job-items select:focus {
        border-color: rgba(42, 147, 213, 0.5);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.08);
        outline: none;
    }

    .select-job-items select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: linear-gradient(45deg, transparent 50%, #64748b 50%), linear-gradient(135deg, #64748b 50%, transparent 50%);
        background-position: calc(100% - 18px) calc(50% - 2px), calc(100% - 13px) calc(50% - 2px);
        background-size: 5px 5px, 5px 5px;
        background-repeat: no-repeat;
        padding-right: 36px;
    }

    .jobs-type-filter {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .jobs-type-filter .container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-left: 36px;
        margin: 0;
        min-height: 24px;
        cursor: pointer;
        color: #374151;
        font-size: 15px;
        line-height: 1.4;
    }
    .jobs-type-filter .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        border-radius: 6px;
    }
    .jobs-type-filter .checkmark {
        position: absolute;
        left: 0;
        height: 20px;
        width: 20px;
        border-radius: 6px;
        border: 1.5px solid #cbd5e1;
        background: #fff;
        transition: all 0.2s ease;
    }
    .jobs-type-filter .container input:checked ~ .checkmark {
        background: #2a93d5;
        border-color: #2a93d5;
    }
    .jobs-type-filter .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 7px;
        top: 3px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .jobs-type-filter .container input:checked ~ .checkmark:after {
        display: block;
    }

    .count-job {
        margin-bottom: 20px;
        padding: 0 2px;
    }
    .job-list-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        width: 100%;
    }
    .job-results-count {
        font-size: 18px;
        color: #1f2937;
        font-weight: 500;
        line-height: 1.4;
        flex: 1;
    }
    .job-results-count span {
        display: inline-block;
        color: #1f2937;
    }
    .count-job .select-job-items {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 12px;
        justify-content: flex-end;
    }
    .count-job .select-job-items span {
        font-size: 15px;
        color: #4b5563;
        font-weight: 600;
    }
    .count-job .select-job-items select {
        min-width: 150px;
        height: 42px;
        border: 1px solid #dfe7f1;
        border-radius: 12px;
        background: #fff;
        padding: 0 38px 0 14px;
        color: #1f2937;
        font-size: 15px;
        appearance: none;
        background-image: linear-gradient(45deg, transparent 50%, #64748b 50%), linear-gradient(135deg, #64748b 50%, transparent 50%);
        background-position: calc(100% - 18px) calc(50% - 2px), calc(100% - 13px) calc(50% - 2px);
        background-size: 5px 5px, 5px 5px;
        background-repeat: no-repeat;
    }
</style>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-picker]').picker({
            search: true,
            searchAutofocus: false,
            texts: {
                trigger: 'Select filter',
                search: 'Search...',
                noResult: 'No result found'
            }
        });

        $('#sort_by').on('change', function () {
            var url = new URL(window.location.href);
            var current = new URLSearchParams(window.location.search);

            current.forEach(function (value, key) {
                url.searchParams.set(key, value);
            });

            if ($(this).val()) {
                url.searchParams.set('sort_by', $(this).val());
            } else {
                url.searchParams.delete('sort_by');
            }

            // Always restart from page 1 when changing the sort order.
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        });
    });
</script>
@endpush
