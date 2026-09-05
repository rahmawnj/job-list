@extends('homepage._layout.main')

@push('meta')
<meta name="description" content="{!! \App\Models\Content::where('name', 'about')->first()->description !!}">
@endpush

@section('container')
    <!-- Hero Area Start-->
<div class="slider-area">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{ asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description) }}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{!! \App\Models\Content::where('name', 'title_about_hero')->first()->description !!}</h2>
                        
                        <!-- Teks Ajakan & Social Media -->
                        <div class="mt-4">
                            <p class="text-white mb-3" style="font-size: 16px; font-weight: 500;">
                                Want to get closer to us? Follow our social media:                            </p>
                            <div class="hero-social d-flex justify-content-center align-items-center">
                                @foreach (\App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                                    <a class="text-white mx-2" style="font-size:30px;" title="{{ $mediasocial->name }}" href="{{ $mediasocial->link }}" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-{{ $mediasocial->icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- Hero Area End -->

    <div class="about-page">
        <div class="container">
            <div class="">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5">
                        <div class="about-image-wrap">
                            <img src="{{ asset('storage/' . \App\Models\Content::where('name', 'about_image')->first()->description) }}" alt="About us image" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-content">
                            <span class="section-kicker">About</span>
                            <h3 class="about-heading">Who We Are</h3>
                            <div class="about-text">
                                {!! \App\Models\Content::where('name', 'about')->first()->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('homepage._partials.apply_process')

    <style>
        .about-page {
            background: white;
            padding: 76px 0 34px;
        }

        .about-story-card {
            background: #ffffff;
            border: 1px solid rgba(30, 33, 78, 0.08);
            border-radius: 28px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            padding: 36px;
        }

        /* .about-image-wrap {
            width: 100%;
            height: 100%;
            min-height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #f8fafc 0%, #eef4ff 100%);
            border: 1px solid rgba(30, 33, 78, 0.05);
            border-radius: 22px;
            overflow: hidden;
            padding: 18px;
        } */

        .about-image-wrap img {
            display: block;
            width: 100%;
            max-width: 420px;
            max-height: 260px;
            object-fit: contain;
            border-radius: 18px;
        }

        .about-content {
            padding: 8px 6px;
        }

        .section-kicker {
            display: inline-block;
            margin-bottom: 12px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #3aa6ea;
        }

        .about-heading {
            margin: 0 0 18px;
            color: #1e214e;
            font-size: clamp(28px, 2.7vw, 42px);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.04em;
            border-bottom: none !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }

        .about-text {
            color: #475569;
            font-size: 17px;
            line-height: 1.9;
            font-weight: 400;
        }

        .about-text p {
            margin: 0;
            color: #475569;
            font-size: 17px;
            line-height: 1.9;
        }

        .about-text p + p {
            margin-top: 16px;
        }

        .section-header h3 {
            font-size: 36px;
            color: #283d50;
            text-align: center;
            font-weight: 500;
            position: relative;
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
            padding: 60px 0;
            background: #1e214e;
        }
        #clients .section-heading h2 {
            color: #ffffff !important;
        }
        #clients .clients-wrap {
            margin-bottom: 30px;
        }
        #clients .client-logo-box {
            background: #ffffff;
            border-radius: 14px;
            padding: 18px 12px;
            min-height: 110px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
        }
        #clients .client-logo-box img {
            max-height: 68px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }

        @media (max-width: 767px) {
            .about-page {
                padding-top: 52px;
            }
            .about-story-card {
                padding: 22px 18px;
                border-radius: 22px;
            }
            .about-image-wrap {
                min-height: 220px;
            }
            .about-text,
            .about-text p {
                font-size: 16px;
                line-height: 1.8;
            }
        }
    </style>
    @include('homepage._partials.clients_section')

@endsection
