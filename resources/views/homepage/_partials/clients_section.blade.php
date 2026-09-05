@php
    $companies = $companies ?? \App\Models\Company::where('show', 'active')->get()->all();
    $companyCount = count($companies);
    $rowShift = $companyCount > 0 ? max(1, (int) floor($companyCount / 3)) : 0;
    $masterQueue = $companyCount ? array_merge($companies, $companies) : [];
    $rowOneQueue = $companyCount ? $masterQueue : [];
    $rowTwoQueue = $companyCount ? array_merge(array_slice($companies, $rowShift), $companies) : [];
    $rowThreeQueue = $companyCount ? array_merge(array_slice($companies, $rowShift * 2), $companies) : [];
@endphp

<style>
    #clients {
        padding: 60px 0 70px;
        background-color: #f8fbff;
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

<section id="clients" class="center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('homepage._partials.section_heading', ['title' => 'Our Clients'])
            </div>
        </div>
        <div class="row no-gutters clients-wrap clearfix wow" style="visibility: visible;">
            <div class="client-marquee">
                <div class="client-track track-right">
                    @foreach ($rowOneQueue as $company)
                        <div class="client-logo">
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Client Logo">
                        </div>
                    @endforeach
                </div>

                <div class="client-track track-left">
                    @foreach ($rowTwoQueue as $company)
                        <div class="client-logo">
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Client Logo">
                        </div>
                    @endforeach
                </div>

                <div class="client-track track-right-slow">
                    @foreach ($rowThreeQueue as $company)
                        <div class="client-logo">
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Client Logo">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
