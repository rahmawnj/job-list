@extends('homepage._layout.main')

@push('meta')
<meta name="description" content="{{\App\Models\Content::where('name', 'email')->first()->description}}">
@endpush

@section('container')

<div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description)}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{!! \App\Models\Content::where('name', 'title_contact_hero')->first()->description !!}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row align-items-start g-4">
            <div class="col-lg-7">
                <div class="contact-form-card">
                    <div class="section-intro">
                        <span class="eyebrow">Contact</span>
                        <h2 class="contact-title">Get in Touch</h2>
                    </div>

                    @if (session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if (session()->has('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                    @endif

                    <form class="form-contact contact_form" action="/send_message" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea required class="form-control w-100" name="message" id="message" cols="30" rows="7" placeholder="Enter Message"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input required class="form-control valid" name="name" id="name" type="text" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input required class="form-control valid" name="email" id="email" type="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input required class="form-control" name="subject" id="subject" type="text" placeholder="Enter Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4 mb-0">
                            <button type="submit" class="button button-contactForm boxed-btn">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-side-card">
                    <div class="map-wrap">
                        <iframe height="260" width="100%" style="border:0; border-radius: 18px;" src="https://maps.google.com/maps?q={{\App\Models\Content::where('name', 'map_location')->first()->description}}&output=embed" loading="lazy"></iframe>
                    </div>

                    <div class="contact-info-list">
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-home"></i></span>
                            <div class="media-body">
                                {{\App\Models\Content::where('name', 'address')->first()->description}}
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                            <div class="media-body">
                                {{\App\Models\Content::where('name', 'phone')->first()->description}}
                            </div>
                        </div>
                        <div class="media contact-info">
                            <span class="contact-info__icon"><i class="ti-email"></i></span>
                            <div class="media-body">
                                {{\App\Models\Content::where('name', 'email')->first()->description}}
                            </div>
                        </div>
                    </div>

                    <div class="social-media-block">
                        <p class="social-media-title">Follow us on social media</p>
                        <div class="social-media-links">
                            @foreach (\App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                                <a class="social-media-item" title="{{ $mediasocial->name }}" href="{{ $mediasocial->link }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-{{ $mediasocial->icon }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-section {
    padding: 90px 0 100px;
    background: linear-gradient(180deg, #f8fafc 0%, #f3f6fb 100%);
}
.contact-form-card,
.contact-side-card {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 28px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
    backdrop-filter: blur(2px);
}
.contact-form-card {
    padding: 32px;
}
.section-intro {
    margin-bottom: 24px;
}
.eyebrow {
    display: inline-block;
    margin-bottom: 8px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #3aa6ea;
}
.contact-title {
    margin: 0;
    font-size: clamp(32px, 3vw, 46px);
    line-height: 1.1;
    font-weight: 700;
    color: #1e214e;
}
.form-contact .form-control {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    background: #f8fafc;
    color: #1f2937;
    padding: 15px 16px;
    font-size: 15px;
    box-shadow: none;
    transition: all 0.25s ease;
}
.form-contact .form-control:focus {
    border-color: rgba(58, 166, 234, 0.7);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(58, 166, 234, 0.08);
}
.form-contact textarea.form-control {
    min-height: 180px;
    resize: vertical;
}
.button-contactForm {
    border: none;
    border-radius: 10px;
    padding: 15px 30px;
    background: #d4efff;
    color: #1f2d3d;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
    transition: all 0.25s ease;
}
.button-contactForm:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #3aa6ea 0%, #2a8ed8 100%);
    box-shadow: 0 16px 30px rgba(42, 147, 213, 0.28);
    color: #fff;
}
.contact-side-card {
    padding: 18px;
}
.map-wrap {
    margin-bottom: 18px;
}
.contact-info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.contact-info {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 18px;
    padding: 16px 18px;
    margin: 0;
}
.contact-info__icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #eaf6ff 0%, #dfeeff 100%);
    color: #1d7dd8;
    font-size: 18px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
}
.contact-info .media-body {
    color: #374151;
    font-size: 15px;
    line-height: 1.7;
    font-weight: 500;
}
.social-media-block {
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px solid #edf2f7;
}
.social-media-title {
    margin: 0 0 12px;
    color: #475569;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.04em;
}
.social-media-links {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    flex-wrap: wrap;
}
.social-media-item {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #1e214e;
    font-size: 18px;
    text-decoration: none;
    transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, transform 0.25s ease, box-shadow 0.25s ease;
    will-change: transform;
}
.social-media-item i {
    color: inherit;
    transition: color 0.2s ease;
}
.social-media-item:hover {
    background: #1e214e;
    border-color: #1e214e;
    color: #fff;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(30, 33, 78, 0.18);
}
.social-media-item:focus-visible,
.hero-social-icon:focus-visible {
    outline: 2px solid #2a93d5;
    outline-offset: 3px;
}
@media (max-width: 991px) {
    .contact-section {
        padding-top: 72px;
    }
    .contact-form-card {
        padding: 24px 20px;
    }
}
@media (max-width: 767px) {
    .contact-section {
        padding: 56px 0 72px;
    }
    .contact-form-card,
    .contact-side-card {
        border-radius: 22px;
    }
    .button-contactForm {
        width: 100%;
    }
}
</style>

@endsection
