<header>
    <!-- Header Start -->
   <div class="header-area header-transparrent">
       <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-2">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="/"><img height="50" src="{{asset('storage/' . \App\Models\Content::where('name', 'logo_header')->first()->description)}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 ">
                        <div class="menu-wrapper float-right"  >
                            <!-- Main-menu -->
                            <div class="main-menu" >
                                <nav class="d-none d-lg-block">
                                    <ul id="navigation">
                                        <li><a class="{{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                                        <li><a class="{{ request()->is('jobs*') ? 'active' : '' }}" href="/jobs">Job Vacancy</a></li>
                                        <li><a class="{{ request()->is('about') ? 'active' : '' }}" href="/about">About</a></li>
                                        {{-- <li><a href="#">Page</a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="single-blog.html">Blog Details</a></li>
                                                <li><a href="elements.html">Elements</a></li>
                                                <li><a href="job_details.html">job Details</a></li>
                                            </ul>
                                        </li> --}}
                                        <li><a class="{{ request()->is('contact') ? 'active' : '' }}" href="/contact">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header-btn -->
                            {{-- <div class="header-btn d-none f-right d-lg-block"> --}}
                                {{-- <a href="/login" class="btn head-btn1" style="background-color: #2a93d5;">Login</a> --}}
                                {{-- <a href="/login" class="btn head-btn2" style="border-color: #2a93d5; color: 2a93d5;">Login</a> --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
       </div>
   </div>
    <!-- Header End -->

    <style>
        #navigation > li > a {
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
            text-decoration: none;
        }

        #navigation > li > a::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: calc(100% - 8px);
            height: 2px;
            border-radius: 999px;
            background: #2a93d5;
            transform: translateX(-50%) scaleX(0);
            transform-origin: center;
            transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #navigation > li > a:hover::after,
        #navigation > li > a.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        #navigation > li > a.active {
            color: #2a93d5 !important;
        }
    </style>
    <!-- Header End -->
</header>