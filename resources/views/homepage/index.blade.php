@extends('homepage._layout.main')

@section('container')
@push('page-css')
<link href="{{ asset('assets/dashboard/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

<div class="slider-area ">
    <div class="slider-active"  >
        <div class="single-slider section-overly-hero slider-height d-flex align-items-center hero-home-overlay" data-background="{{asset('storage/' . App\Models\Content::where('name', 'hero_image')->first()->description)}}">
            <div class="container"  >
                <div class="row mt-auto mb-auto text-center justify-content-center " >
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="hero__caption text-dark">
                            <h1 class="hero-title-main">{{ \App\Models\Content::where('name', 'name')->first()?->description }}</h1>
                            <h2 class="top-0 hero-title-sub">{{ \App\Models\Content::where('name', 'hero_caption_description')->first()?->description }}</h2>
                            <p class="hero-description">{{ \App\Models\Content::where('name', 'hero_description')->first()?->description }}</p>
                        </div>
                    </div>
                </div>
                 <div class="mt-4">
                            <div class="hero-social d-flex justify-content-center align-items-center gap-3">
                                <span class="hero-connect-text">Connect with Us on Social Media : </span> 
                                @foreach (\App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                                     <a class="hero-social-icon mx-2" style="font-size:30px;" title="{{ $mediasocial->name }}" href="{{ $mediasocial->link }}" target="_blank" rel="noopener noreferrer">
                                        <i style="color:#1d2d5c" class="fa-brands fa-{{ $mediasocial->icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                <div  class="row d-flex justify-content-center mt-5">
                   <div class="col-12 d-flex justify-content-center">
                        <div class="w-100" style="max-width: 650px;">
                            <form action="/jobs" method="post">
                                @csrf
                                <div class="input-group input-group-lg shadow-sm search-hero-wrap" style="border-radius: 50px; overflow: hidden; background: #fff;">
                                    
                                    <input id="search" type="text" class="form-control border-0 px-4 py-3 search-hero-input" name="search" placeholder="Job Title or keyword..." aria-label="Job Title or keyword" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" formnovalidate="formnovalidate" style="box-shadow: none; font-size: 16px;">
                                    
                                   <div class="input-group-append">
                                        <button style="background-color: #2a93d5; color: white; border: none; font-size: 14px;" type="submit" class="btn px-3 h-100 d-flex align-items-center gap-2" id="inputGroup-sizing">
                                            <i class="fa fa-search" aria-hidden="true"></i><span class="find-job-label"> Find Job</span>
                                        </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>


<div class="support-company-area support-padding fix mt-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                @php
                    $aboutContent = \App\Models\Content::where('name', 'about')->first();
                    $aboutText = trim(strip_tags($aboutContent?->description ?? ''));
                    $visionText = trim(strip_tags(\App\Models\Content::where('name', 'vision')->first()?->description ?? ''));
                @endphp

                @include('homepage._partials.section_heading', ['title' => 'About Us'])

                <div class="support-caption text-center">
                    <div class="mb-4" style="color: #555; font-size: 16px; line-height: 1.8;">
                        {{ Str::limit($aboutText, 260) }}
                    </div>

                    <div class="d-flex justify-content-center">
                        <a style="background-color: #2a93d5; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 500; box-shadow: 0 4px 10px rgba(42, 147, 213, 0.3); transition: all 0.3s ease;" 
                           href="/about" 
                           class="btn post-btn">
                            Read More <i class="fa fa-arrow-right ms-2" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.about-vision {
    margin-top: 20px;
    margin-bottom: 28px;
}
.about-vision h4 {
    margin: 0 0 12px;
    color: #1e214e;
    font-size: 24px;
    line-height: 1.3;
    font-weight: 700;
    letter-spacing: -0.02em;
}
.about-vision p {
    margin: 0;
    color: #4a4f63;
    font-size: 20px;
    line-height: 1.5;
    font-weight: 400;
    font-style: italic;
}
@media (max-width: 767px) {
    .about-vision h4 {
        font-size: 22px;
    }
    .about-vision p {
        font-size: 18px;
    }
}
</style>
<div class="our-services section-pad-t30 py-5" style="margin-top: 56px;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-12">
                @include('homepage._partials.section_heading', ['title' => 'Top Categories'])
            </div>
        </div>

        <div class="row d-flex justify-content-center g-4">
            
            @foreach(App\Models\Jobcategory::where('is_top_category', true)->whereNotNull('logo')->get() as $category)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                    <a href="/jobs" class="text-decoration-none">
                        <div class="single-services text-center p-4 bg-white h-100 shadow-sm" style="border-radius: 12px; border: 1px solid rgba(0,0,0,0.04); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                            
                            <div class="services-ion mb-3 d-flex align-items-center justify-content-center" style="height: 70px;">
                                <img height="55" src="{{ asset('storage/' . $category->logo) }}" alt="{{ $category->name }}" style="object-fit: contain;">
                            </div>
                            
                            <div class="services-cap">
                                <h5 style="color: #1e214e; font-weight: 600; font-size: 17px; margin-bottom: 0;">
                                    {{ $category->name }}
                                </h5>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>

<section class="featured-job-area feature-padding py-5" style="padding-top: 0px; background-color: #f8fbff; position: relative; z-index: 50;">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-12">
                @include('homepage._partials.section_heading', ['title' => 'We are Hiring!'])
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-10" style="position: relative; z-index: 60;">
                
                <div class="card border-0 shadow-sm p-4 mb-5 job-filter-card">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="job-filter-label">Job Category</label>
                            <select class="job-filter-select" data-picker id="job_category" name="select">
                                <option value="">All Category</option>
                                @foreach (App\Models\Jobcategory::all() as $jobcategory)
                                <option value="{{$jobcategory->id}}">{{$jobcategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="job-filter-label">Job Location</label>
                            <select class="job-filter-select" data-picker id="location" name="select">
                                <option value="">All Locations</option>
                                @foreach (App\Models\Location::all() as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="job-filter-label">Job Type</label>
                            <select class="job-filter-select" data-picker name="job_type" id="job_type">
                                <option value="">All Type</option>
                                <option value="full_time">Full Time</option>
                                <option value="part_time">Part Time</option>
                                <option value="remote">Remote</option>
                                <option value="freelance">Freelance</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="job_data" style="position: relative; z-index: 1;">
                    @include('homepage.job_data')
                </div>

            </div>
        </div>
    </div>
</section>
@include('homepage._partials.apply_process')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.focus();
            searchInput.setAttribute('autocomplete', 'off');
            searchInput.setAttribute('autocorrect', 'off');
            searchInput.setAttribute('autocapitalize', 'off');
            searchInput.setAttribute('spellcheck', 'false');
        }
    });
</script>

<style>
.hero-home-overlay {
    position: relative;
}

.hero-home-overlay::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(117, 139, 188, 0.03);
    z-index: 0;
}

.hero-home-overlay > .container,
.hero-home-overlay > .container > .row,
.hero-home-overlay > .container > .row > div,
.hero-home-overlay .hero__caption,
.hero-home-overlay .hero-social,
.hero-home-overlay form {
    position: relative;
    z-index: 1;
}

.hero__caption .hero-title-main,
.hero__caption .hero-title-sub {
    color: #1d2d5c !important;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.12);
}

.hero__caption .hero-title-main,
.hero__caption .hero-title-sub,
.hero__caption .hero-description,
.search-hero-input,
.search-hero-wrap button {
    font-family: 'Montserrat', sans-serif;
}

.hero__caption {
    display: flex;
    flex-direction: column;
    align-items: center;
}


.hero__caption .hero-title-main {
    margin-bottom: 18px;
    font-size: 64px;
    font-weight: 700;
    line-height: 1.12;
}

.hero__caption .hero-title-sub {
    margin-bottom: 18px;
    font-size: 40px;
    font-weight: 600;
    line-height: 1.2;
}

.hero__caption .hero-description {
    margin: 0;
    color: #243755 !important;
    font-size: 22px;
    font-weight: 400;
    line-height: 32px;
}

.search-hero-input,
.search-hero-wrap button {
    font-size: 30px !important;
    font-weight: 500;
}

.search-hero-input::placeholder {
    font-size: 22px;
    font-weight: 400;
}

@media (max-width: 767px) {
    .hero-home-overlay .container {
        padding-top: 34px;
        padding-bottom: 24px;
    }

    .hero-home-overlay .hero__caption {
        margin-bottom: 24px;
    }

    .hero__caption .hero-title-main {
        width: 100%;
        margin-bottom: 13px;
        font-size: 25px;
        white-space: nowrap;
    }

    .hero__caption .hero-title-sub {
        margin-bottom: 13px;
        font-size: 15px;
    }

    .hero__caption .hero-description {
        width: min(100%, 340px);
        margin: 0 auto;
        padding: 0 10px;
        font-size: 12px !important;
        line-height: 19px;
    }

    .hero-description-break {
        display: none;
    }

    .search-hero-input,
    .search-hero-wrap button {
        font-size: 15px !important;
    }

    .search-hero-input::placeholder {
        font-size: 15px;
    }

    .hero-home-overlay .hero-social {
        margin-top: 8px;
    }

    .hero-home-overlay form {
        margin-top: 8px;
    }

    .hero-home-overlay .search-hero-wrap button {
        width: 58px;
        justify-content: center;
        padding: 0 !important;
    }

    .hero-home-overlay .find-job-label {
        display: none;
    }
}

.search-hero-wrap {
    border: 2px solid transparent;
    transition: all 0.2s ease;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
}

.search-hero-wrap:focus-within {
    border-color: rgba(42, 147, 213, 0.55);
    box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.12), 0 8px 18px rgba(15, 23, 42, 0.08);
}

.search-hero-input {
    background: #fff;
    transition: all 0.2s ease;
}

.search-hero-input:focus {
    background: #fff;
    box-shadow: none !important;
    outline: none;
}

.job-filter-card {
    display: none !important;
    position: relative;
    z-index: 100 !important;
    overflow: visible !important;
    padding-top: 28px !important;
    padding-bottom: 28px !important;
    margin-top: 36px !important;
    border-radius: 12px;
    background: #ffffff;
}

.job-filter-card .picker {
    display: block;
    width: 100%;
}

.job-filter-card .picker .pc-select {
    display: block;
    width: 100%;
    min-width: 0;
    max-width: none;
}

.job-filter-card .picker .pc-trigger {
    width: 100%;
    height: 52px;
    border: 1px solid #d7e3f0;
    border-radius: 12px;
    background: #fff;
    color: #172b4d;
    font-size: 16px;
    line-height: 50px;
    padding: 0 42px 0 16px;
    box-shadow: 0 4px 12px rgba(31, 75, 122, 0.04);
    transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
}

.job-filter-card .picker .pc-trigger:hover,
.job-filter-card .picker .pc-trigger:focus {
    border-color: #2a93d5;
    background: #fff;
    color: #172b4d;
    box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.1), 0 8px 18px rgba(31, 75, 122, 0.08);
}

.job-filter-card .picker .pc-list {
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

.job-filter-card .picker .pc-list input[type="search"] {
    height: 38px;
    margin-bottom: 6px;
    padding: 0 11px;
    border: 1px solid #dce7f2;
    border-radius: 8px;
    background: #f7faff;
    color: #172b4d;
    font-size: 14px;
}

.job-filter-card .picker .pc-list input[type="search"]:focus {
    border-color: #2a93d5;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(42, 147, 213, 0.1);
}

.job-filter-card .picker .pc-list ul {
    max-height: 204px;
    overflow-y: auto;
    overflow-x: hidden;
}

.job-filter-card .picker .pc-list li {
    margin: 2px 0;
    padding: 9px 10px;
    border-radius: 8px;
    color: #30445f;
    font-size: 14px;
    line-height: 1.3;
}

.job-filter-card .picker .pc-list li:nth-child(even) {
    background: transparent;
}

.job-filter-card .picker .pc-list li:hover {
    background: #eaf6ff;
    color: #1677b7;
}

@media (max-width: 767px) {
    .job-filter-card {
        margin-top: 22px !important;
        padding: 22px 18px !important;
    }
}

.job-filter-card .row {
    position: relative;
    z-index: 101 !important;
}

.job-filter-label {
    display: block;
    margin: 0 0 10px;
    color: #1d2d5c;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.3;
}

.job-filter-select {
    position: relative;
    z-index: 102 !important;
    display: block;
    width: 100%;
    height: 52px;
    padding: 0 42px 0 16px;
    border: 1px solid #dfe7f1;
    border-radius: 12px;
    background-color: #fff;
    color: #1f2937;
    font-size: 16px;
    font-weight: 500;
    line-height: 1.3;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: linear-gradient(45deg, transparent 50%, #64748b 50%), linear-gradient(135deg, #64748b 50%, transparent 50%);
    background-position: calc(100% - 18px) calc(50% - 2px), calc(100% - 13px) calc(50% - 2px);
    background-size: 5px 5px, 5px 5px;
    background-repeat: no-repeat;
    overflow: visible !important;
    text-overflow: ellipsis;
    cursor: pointer;
}

.job-filter-select:focus {
    border-color: rgba(42, 147, 213, 0.55);
    box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.08);
    outline: none;
}

.job-filter-select option {
    padding: 10px 14px;
    font-size: 15px;
    line-height: 1.5;
    color: #1f2937;
}

.section-header p {
    text-align: center;
    margin: auto;
    font-size: 15px;
    padding-bottom: 60px;
    color: #556877;
    width: 50%;
}
#clients {
    padding: 60px 0 70px;
    background-color: #f4f3f1;
}
#clients .section-tittle h2,
#clients .section-heading h2 {
    color: #1e214e !important;
    font-size: clamp(3rem, 5vw, 6rem);
    letter-spacing: -0.05em;
    margin-bottom: 28px;
}
#clients .clients-wrap {
    width: 100%;
    max-width: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    position: relative;
}

#clients .client-marquee {
    display: flex;
    flex-direction: column;
    gap: 18px;
    width: 100%;
    overflow: hidden;
    padding: 0;
}
#clients .client-track {
    display: flex;
    width: max-content;
    align-items: center;
    gap: 18px;
    will-change: transform;
    padding-left: 8px;
    padding-right: 8px;
    transform: translate3d(0, 0, 0);
}
#clients .client-track.track-right {
    animation: client-marquee-right 72s linear infinite;
}
#clients .client-track.track-left {
    animation: client-marquee-left 80s linear infinite;
}
#clients .client-track.track-right-slow {
    animation: client-marquee-right 88s linear infinite;
}
#clients .client-track:hover {
    animation-play-state: paused;
}
#clients .client-logo {
    flex: 0 0 auto;
    width: 240px;
    height: 120px;
    padding: 18px 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid rgba(30,33,78,0.08);
    border-radius: 12px;
    box-shadow: 0 8px 18px rgba(30, 33, 78, 0.06);
}
#clients .client-logo img {
    max-height: 60px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    transition: all 0.4s ease-in-out;
}
@keyframes client-marquee-right {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
}
@keyframes client-marquee-left {
    from { transform: translateX(-50%); }
    to { transform: translateX(0); }
}
@media (max-width: 767px) {
    #clients {
        padding: 50px 0 60px;
    }
    #clients .client-logo {
        width: 170px;
        height: 90px;
    }
}
</style>

@include('homepage._partials.clients_section')

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

        $(document).on('click', '.pagination a', function(event) {
          event.preventDefault();
          var page = $(this).attr('href').split('page=')[1];
          getMoreJobs(page);
        });
        $('#job_type').on('change', function (e) {
            getMoreJobs();
        });
        $('#job_category').on('change', function (e) {
            getMoreJobs();
        });
        $('#location').on('change', function (e) {
            getMoreJobs();
        });
        $('#search').on('keyup', function() {
            getMoreJobs(1);
        });
    });

    function getMoreJobs(page) {
      var search = $('#search').val();
      var selectedJobType = $("#job_type option:selected").val();
      var selectedJobCategory = $("#job_category option:selected").val();
      var selectedLocation = $("#location option:selected").val();
      $.ajax({
        type: "GET",
        data: {
          'location': selectedLocation,
          'job_category': selectedJobCategory,
          'job_type' : selectedJobType,
          'search' : search,
        },
        url: "{{ route('jobs.get-more-jobs') }}" + "?page=" + (page || 1),
        success:function(data) {
          $('#job_data').html(data);
        },
        error:function(e){
          console.log(e)
        }
      });
    }
  </script>

@endpush