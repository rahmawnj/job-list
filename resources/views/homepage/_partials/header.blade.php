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
                                        <li><a href="/">Home</a></li>
                                        <li><a href="/jobs">Job Vacancy</a></li>
                                        <li><a href="/about">About</a></li>
                                        {{-- <li><a href="#">Page</a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="single-blog.html">Blog Details</a></li>
                                                <li><a href="elements.html">Elements</a></li>
                                                <li><a href="job_details.html">job Details</a></li>
                                            </ul>
                                        </li> --}}
                                        <li><a href="/contact">Contact</a></li>
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
</header>