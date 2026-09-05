<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-bg footer-padding" style="background-color: #1e214e;">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-12">
                    <div class="footer-logo mb-20">
                        <a href="/"><img height="50" src="{{asset('storage/' . App\Models\Content::where('name', 'logo_footer')->first()->description)}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Contact Info</h4>
                            <ul>
                                <li>
                                    <p class="text-white">Address :
                                        <a style="color: white;" href="https://www.google.com/maps/place/{{App\Models\Content::where('name', 'address')->first()->description}}">{{App\Models\Content::where('name', 'address')->first()->description}}</a>
                                    </p>
                                </li>
                                <li><a class="text-white" href="https://wa.me/{{App\Models\Content::where('name', 'phone')->first()->description}}">Phone : {{App\Models\Content::where('name', 'phone')->first()->description}}</a></li>
                                <li><a class="text-white" href="mailto:{{App\Models\Content::where('name', 'email')->first()->description}}">Email : {{App\Models\Content::where('name', 'email')->first()->description}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Important Link</h4>
                            <ul>
                                <li><a class="text-white" href="/">Home</a></li>
                                <li><a class="text-white" href="/jobs">Job Vacancy</a></li>
                                <li><a class="text-white" href="/about">About</a></li>
                                <li><a class="text-white" href="/contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer-bottom area -->
    <div class="footer-bottom-area footer-bg" style="background-color: #1e214e;">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-xl-10 col-lg-10">
                        <div class="footer-copy-right">
                            <p class="text-white">
                                Copyright &copy;<script>document.write(new Date().getFullYear());</script> {{App\Models\Content::where('name', 'name')->first()->description}}
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2">
                        <div class="footer-social f-right footer-social-consistent">
                            @foreach (App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                                <a class="site-social-link" title="{{$mediasocial->name}}" href="{{$mediasocial->link}}" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-{{$mediasocial->icon}}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .footer-social-consistent {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 10px !important;
            flex-wrap: wrap;
        }

        .footer-social-consistent .site-social-link {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px;
            margin: 0 !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 12px !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e214e !important;
            font-size: 18px !important;
            line-height: 1 !important;
            text-decoration: none !important;
            vertical-align: middle !important;
            box-sizing: border-box;
            transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, transform 0.25s ease, box-shadow 0.25s ease;
        }

        .footer-social-consistent .site-social-link i {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 1em;
            height: 1em;
            line-height: 1 !important;
            margin: 0 !important;
            color: inherit !important;
        }

        .footer-social-consistent .site-social-link:hover,
        .footer-social-consistent .site-social-link:focus-visible {
            background: #1e214e !important;
            border-color: #1e214e !important;
            color: #fff !important;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(30, 33, 78, 0.18);
        }

        @media (max-width: 767px) {
            .footer-social-consistent {
                justify-content: flex-start !important;
                margin-top: 12px;
            }
        }
    </style>
    <!-- Footer End-->
</footer>
