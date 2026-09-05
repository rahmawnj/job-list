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
           <!--  -->
           {{-- <div class="row footer-wejed justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                    <!-- logo -->
                    <div class="footer-logo mb-20">
                    <a href="/"><img height="50" src="{{asset('storage/' . \App\Models\Content::where('name', 'logo_footer')->first()->description)}}" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                <div class="footer-tittle-bottom">
                    <span>5000+</span>
                    <p>Talented Hunter</p>
                </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="footer-tittle-bottom">
                        <span>451</span>
                        <p>Talented Hunter</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <!-- Footer Bottom Tittle -->
                    <div class="footer-tittle-bottom">
                        <span>568</span>
                        <p>Talented Hunter</p>
                    </div>
                </div>
           </div> --}}
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
                         <div class="footer-social f-right">
                            @foreach (\App\Models\Mediasocial::where('status', 'active')->get() as $mediasocial)
                            <a class="text-white" style="color: white;" title="{{$mediasocial->name}}" href="{{$mediasocial->link}}"><i class="fa-brands fa-{{$mediasocial->icon}}"></i></a>
                            @endforeach
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
