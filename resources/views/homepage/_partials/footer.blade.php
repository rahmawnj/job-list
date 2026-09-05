<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-bg footer-padding" style="background-color: #1e214e;">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-12">
                    <!-- logo -->
                    <div class="footer-logo mb-20">
                    <a href="/"><img height="50" src="{{asset('storage/' . \App\Models\Content::where('name', 'logo_footer')->first()->description)}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Contact Info</h4>
                            <ul>
                                <li>
                                    <p class="text-white">Address :
                                        <a style="color: white;" href="https://www.google.com/maps/place/{{\App\Models\Content::where('name', 'address')->first()->description}}">{{\App\Models\Content::where('name', 'address')->first()->description}}</a>
                                    </p>
                                </li>
                                <li><a class="text-white" href="https://wa.me/{{\App\Models\Content::where('name', 'phone')->first()->description}}">Phone : {{\App\Models\Content::where('name', 'phone')->first()->description}}</a></li>
                                <li><a class="text-white" href="mailto:{{\App\Models\Content::where('name', 'email')->first()->description}}">Email : {{\App\Models\Content::where('name', 'email')->first()->description}}</a></li>
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
                     <div class="col-xl-10 col-lg-10 ">
                         <div class="footer-copy-right">
                             <p class="text-white"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;<script>document.write(new Date().getFullYear());</script> {{\App\Models\Content::where('name', 'name')->first()->description}}
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                         </div>
                     </div>
                     <div class="col-xl-2 col-lg-2">
                         <div class="footer-social f-right site-social-group">
                            @foreach (\App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                            <a class="site-social-link footer-social-link" title="{{$mediasocial->name}}" href="{{$mediasocial->link}}" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-{{$mediasocial->icon}}"></i></a>
                            @endforeach
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->

    <style>
        .hero-social > a,
        .social-media-item,
        .footer-social-link {
            width: 42px !important;
            height: 42px !important;
            min-width: 42px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            margin: 0 !important;
            padding: 0 !important;
            border-radius: 12px !important;
            border: 1px solid rgba(30, 33, 78, 0.12) !important;
            background: rgba(255, 255, 255, 0.94) !important;
            color: #1e214e !important;
            font-size: 18px !important;
            line-height: 1;
            text-decoration: none !important;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
            transition: transform 0.25s ease, background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .hero-social > a i,
        .social-media-item i,
        .footer-social-link i {
            color: inherit !important;
            transition: color 0.25s ease;
        }

        .hero-social > a:hover,
        .social-media-item:hover,
        .footer-social-link:hover {
            background: #1e214e !important;
            border-color: #1e214e !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 12px 22px rgba(30, 33, 78, 0.2);
        }

        .hero-social > a:hover i,
        .social-media-item:hover i,
        .footer-social-link:hover i {
            color: #ffffff !important;
        }

        .site-social-group {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 767px) {
            .site-social-group {
                justify-content: center;
                margin-top: 12px;
            }
        }
    </style>
</footer>
