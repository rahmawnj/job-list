@extends('homepage._layout.main')

@push('meta')
<meta name="description" content="{{\App\Models\Job::find($id)->title}}">
@endpush

@section('container')
@once
<style>
/* Match the site’s standard page hero styling so the title looks consistent with other pages */
.slider-height2 {
    min-height: 450px !important;
}

.hero-cap h2 {
    color: #fff;
    font-size: 50px;
    font-weight: 700;
    text-transform: capitalize;
    line-height: 1.2;
    margin: 0;
    letter-spacing: 0;
}

@media (max-width: 767px) {
    .hero-cap h2 {
        font-size: 40px;
    }
}

/* Card Job Single Bagian Atas */
.job-post-company .single-job-items {
    display: flex;
    flex-direction: column;
    gap: 18px;
    background: #fff;
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03);
    padding: 24px;
    transition: all 0.3s ease;
}

.job-post-company .single-job-items:hover {
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.06);
}

.job-post-company .job-items {
    display: flex;
    align-items: center;
    width: 100%;
}

.job-post-company .company-img {
    width: 80px;
    min-width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    background: linear-gradient(135deg, #f0f7ff 0%, #e8f2ff 100%);
    border: 1px solid rgba(42, 147, 213, 0.12);
    overflow: hidden;
    position: relative;
}

.job-post-company .company-img img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.job-post-company .job-tittle {
    flex: 1;
    padding-left: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: left;
}

.job-post-company .job-tittle h4 {
    margin: 0 0 10px;
    font-size: clamp(20px, 2vw, 26px);
    font-weight: 700;
    color: #1e214e;
    line-height: 1.25;
    letter-spacing: -0.02em;
}

.job-post-company .job-tittle ul {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px 20px;
    padding: 0;
    margin: 0;
    list-style: none;
    color: #64748b;
    font-size: 15px;
}

.job-post-company .job-tittle ul li {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.job-post-company .job-tittle ul li i {
    color: #94a3b8;
    font-size: 14px;
}

/* Kotak Detail Konten (Deskripsi & Requirement) */
.job-post-details {
    background: #ffffff;
    border-radius: 24px;
    border: 1px solid rgba(148, 163, 184, 0.15);
    padding: 30px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03);
}

.small-section-tittle h4 {
    font-size: 20px;
    font-weight: 700;
    color: #1e214e;
    letter-spacing: -0.01em;
    margin-bottom: 16px;
}

/* Sidebar Job Overview ala Modern Card */
.post-details3 {
    background: #ffffff;
    border: 1px solid rgba(148, 163, 184, 0.15);
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.03);
}

.post-details3 ul {
    list-style: none;
    padding: 0;
    margin: 0 0 24px 0;
}

.post-details3 ul li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 15px;
    color: #64748b;
}

.post-details3 ul li:last-child {
    border-bottom: none;
}

.post-details3 ul li span {
    font-weight: 600;
    color: #1e214e;
}

/* Tombol Apply Custom Youthful */
.apply-btn2 .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 58px;
    box-sizing: border-box;
    background-color: #2a93d5 !important;
    color: #fff !important;
    font-weight: 700;
    border-radius: 16px;
    padding: 0 20px;
    text-align: center;
    line-height: 1 !important;
    box-shadow: 0 8px 20px rgba(42, 147, 213, 0.25);
    transition: all 0.25s ease;
    border: none;
}

.apply-btn2 .btn:hover {
    background-color: #1f82c4 !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(42, 147, 213, 0.35);
}

/* Action buttons: Apply + Share */
.apply-actions {
    display: flex;
    align-items: stretch;
    gap: 10px;
    width: 100%;
}

.apply-actions .apply-btn2 {
    flex: 1 1 auto;
    min-width: 0;
}

.apply-actions .job-share-btn {
    flex: 0 0 58px;
    width: 58px;
    min-width: 58px;
}

.apply-actions .apply-btn2 .btn,
.job-share-btn {
    width: 100%;
    height: 58px;
    min-height: 58px;
    box-sizing: border-box;
}

.job-share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: 1.5px solid #2a93d5;
    background: #fff;
    color: #2a93d5;
    border-radius: 16px;
    font-weight: 700;
    font-size: 15px;
    line-height: 1;
    cursor: pointer;
    text-align: center;
    transition: all 0.25s ease;
}

.job-share-btn:hover {
    background: #f0f7ff;
    color: #1f82c4;
    border-color: #1f82c4;
}

.job-share-btn i {
    font-size: 17px;
    line-height: 1;
}

.job-share-status {
    min-height: 20px;
    padding-top: 8px;
    text-align: center;
    color: #64748b;
    font-size: 12px;
}

/* Responsive Mobile Styles */
@media (max-width: 767px) {
    .job-post-company .single-job-items,
    .job-post-details,
    .post-details3 {
        padding: 18px;
    }
    .job-post-company .company-img {
        width: 65px;
        min-width: 65px;
        height: 65px;
        border-radius: 16px;
    }
    .job-post-company .company-img img {
        width: 48px;
        height: 48px;
    }
    .job-post-company .job-tittle {
        padding-left: 14px;
    }
    .job-post-company .job-tittle h4 {
        font-size: 17px;
    }
    .job-post-company .job-tittle ul {
        font-size: 13px;
        gap: 6px 12px;
    }

    /* Mobile order: Job header -> Job Overview -> Requirements -> Description */
    .job-post-company > .container > .row {
        display: flex;
        flex-wrap: wrap;
    }

    .job-post-company > .container > .row > .col-xl-7 {
        display: contents;
    }

    .job-post-company > .container > .row > .col-xl-7 > .single-job-items {
        order: 1;
        width: 100%;
        margin-bottom: 20px !important;
    }

    .job-post-company > .container > .row > .col-xl-4 {
        order: 2;
        flex: 0 0 100%;
        max-width: 100%;
        width: 100%;
        margin-top: 0 !important;
    }

    .job-post-company > .container > .row > .col-xl-7 > .job-post-details {
        order: 3;
        width: 100%;
        max-width: 100%;
    }

    .job-post-company .job-post-details {
        display: flex;
        flex-direction: column;
    }

    .job-post-company .job-post-details .post-details2 {
        order: 1;
    }

    .job-post-company .job-post-details .post-details1 {
        order: 2;
        margin-bottom: 0 !important;
    }

    .apply-actions {
        gap: 8px;
    }

    .apply-actions .job-share-btn {
        flex-basis: 52px;
        width: 52px;
        min-width: 52px;
    }

    .apply-actions .apply-btn2 .btn,
    .job-share-btn {
        height: 52px;
        min-height: 52px;
        padding: 0 10px;
        font-size: 13px;
    }

    .job-share-btn {
        padding: 0;
    }

    .job-share-btn i {
        font-size: 16px;
    }
}

@media (max-width: 360px) {
    .apply-actions .job-share-btn {
        flex-basis: 48px;
        width: 48px;
        min-width: 48px;
    }

    .apply-actions .apply-btn2 .btn,
    .job-share-btn {
        height: 48px;
        min-height: 48px;
        padding: 0 8px;
        font-size: 12px;
    }

    .job-share-btn {
        padding: 0;
    }

    .job-share-btn i {
        font-size: 15px;
    }

    .job-share-status {
        font-size: 11px;
    }
}
</style>
@endonce

<div class="slider-area">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description)}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{App\Models\Job::find($id)->jobcategory->name}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="job-post-company pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-7 col-lg-8">
                <div class="single-job-items mb-30">
                    <div class="job-items align-items-center">
                        <div class="company-img">
                            <img src="{{asset('storage/' . App\Models\Job::find($id)->image)}}" alt="Company Logo">
                        </div>
                        <div class="job-tittle">
                            <h4>{{App\Models\Job::find($id)->title}}</h4>
                            <ul>
                                <li>{{App\Models\Job::find($id)->jobcategory->name}}</li>
                                <li><i class="fas fa-map-marker-alt"></i> {{App\Models\Job::find($id)->location->name}}</li>
                                <li>{{App\Models\Job::find($id)->salary}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="job-post-details">
                    <div class="post-details1 mb-45">
                        <div class="small-section-tittle">
                            <h4>Job Description</h4>
                        </div>
                        {!! App\Models\Job::find($id)->description !!}
                    </div>
                   
                    <div class="post-details2">
                        <div class="small-section-tittle">
                            <h4>Requirement, Qualification & Experience</h4>
                        </div>
                        {!! App\Models\Job::find($id)->requirement !!}
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 mt-4 mt-lg-0">
                <div class="post-details3 mb-30">
                    <div class="small-section-tittle">
                        <h4>Job Overview</h4>
                    </div>
                    <ul>
                        <li>Posted date : <span>{{\Carbon\Carbon::parse(App\Models\Job::find($id)->created_at)->format('d M Y')}}</span></li>
                        <li>Location : <span>{{App\Models\Job::find($id)->location->name}}</span></li>
                        <li>Total Position : <span>{{App\Models\Job::find($id)->total_position}}</span></li>
                        <li>Job Type : <span>{{ucwords(str_replace("_", " ", App\Models\Job::find($id)->type))}}</span></li>
                        <li>Salary : <span>{{App\Models\Job::find($id)->salary}}</span></li>
                    </ul>
                    <div class="apply-actions">
                        <div class="apply-btn2">
                            <a href="{{ route('apply_job', $id) }}" class="btn">Apply Now</a>
                        </div>
                        <button
                            type="button"
                            class="job-share-btn"
                            id="job-share-btn"
                            data-share-url="{{ url('/job/' . $id) }}"
                            aria-label="Share this job"
                            title="Share this job"
                        >
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="job-share-status" id="job-share-status" aria-live="polite"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shareButton = document.getElementById('job-share-btn');
    const status = document.getElementById('job-share-status');

    if (!shareButton) {
        return;
    }

    const url = shareButton.getAttribute('data-share-url') || window.location.href;
    const title = document.title;

    const setStatus = function (message) {
        if (status) {
            status.textContent = message;
        }
    };

    const copyUrl = async function () {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(url);
            return;
        }

        const textarea = document.createElement('textarea');
        textarea.value = url;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();

        const copied = document.execCommand('copy');
        textarea.remove();

        if (!copied) {
            throw new Error('Copy failed');
        }
    };

    shareButton.addEventListener('click', async function () {
        try {
            if (navigator.share) {
                await navigator.share({
                    title: title,
                    url: url
                });
                setStatus('Link shared');
            } else {
                await copyUrl();
                setStatus('Link copied');
            }
        } catch (error) {
            if (error && error.name === 'AbortError') {
                return;
            }

            try {
                await copyUrl();
                setStatus('Link copied');
            } catch (copyError) {
                setStatus('Unable to copy link');
            }
        }
    });
});
</script>
@endsection