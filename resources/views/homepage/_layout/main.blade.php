
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{App\Models\Content::where('name', 'name')->first()->description}}</title>
        <meta name="description" content="{{App\Models\Content::where('name', 'name')->first()->description}} {{App\Models\Content::where('name', 'hero_description')->first()->description}} {{App\Models\Content::where('name', 'about')->first()->description}}">
        @stack('meta')
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('Logo.png')}}">

        <link href="{{asset('assets/plugins/fontawesome/css/all.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/homepage/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/flaticon.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/price_rangs.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/slicknav.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/slick.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/nice-select.css')}}">
        <link rel="stylesheet" href="{{asset('assets/homepage/css/style.css')}}">
        @stack('page-css')
        <link rel="stylesheet" href="{{asset('assets/plugins/floating-whatsapp-master/floating-wpp.min.css')}}">
   </head>

   <body>
    <!-- Preloader Start -->
    {{-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img  src="{{asset('storage/' . App\Models\Content::where('name', 'logo_header')->first()->description)}}" alt="">
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Preloader Start -->
  {{-- HEADER --}}
  @include('homepage._partials.header')

    <main>
        @yield('container')
    </main>
   
    @include('homepage._partials.footer')
    <div class="floating-wpp"></div>
  <!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="{{asset('assets/homepage/js/vendor/modernizr-3.5.0.min.js')}}"></script>
		<!-- Jquery, Popper, Bootstrap -->
        <script src="{{asset('assets/homepage/js/vendor/jquery-1.12.4.min.js')}}"></script>
        <script src="{{asset('assets/dashboard/plugins/select-picker/dist/picker.min.js')}}"></script>
        @stack('scripts')

        <!-- Bridge select-picker's custom event to the normal jQuery change event used by page filters -->
        <script>
            $(function () {
                $(document).on('sp-change', '.job-filter-card .job-filter-select', function () {
                    $(this).trigger('change');
                });
            });
        </script>

        <script src="{{asset('assets/homepage/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/bootstrap.min.js')}}"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="{{asset('assets/homepage/js/jquery.slicknav.min.js')}}"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="{{asset('assets/homepage/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/slick.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/price_rangs.js')}}"></script>
        
		<!-- One Page, Animated-HeadLin -->
        <script src="{{asset('assets/homepage/js/wow.min.js')}}"></script>
		<script src="{{asset('assets/homepage/js/animated.headline.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.magnific-popup.js')}}"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="{{asset('assets/homepage/js/jquery.scrollUp.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.nice-select.min.js')}}"></script>
		<script src="{{asset('assets/homepage/js/jquery.sticky.js')}}"></script>
        
        <!-- contact js -->
        <script src="{{asset('assets/homepage/js/contact.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.form.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/mail-script.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.ajaxchimp.min.js')}}"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="{{asset('assets/homepage/js/plugins.js')}}"></script>
        <script src="{{asset('assets/homepage/js/main.js')}}"></script>

        <script src="{{asset('assets/plugins/floating-whatsapp-master/floating-wpp.min.js')}}"></script>
        <script>
            $(function () { 
                $('.floating-wpp').floatingWhatsApp({ 
                    phone: "{{\App\Models\Content::where('name', 'phone')->first()->description}}", 
                    popupMessage: 'Selamat datang diwebsite Top Talents Consulting', 
                    showPopup: true, 
                    position: 'left', 
                    autoOpen: false, 
                    message: 'Write here!', 
                    headerTitle: 'Whatsapp', 
                }); 
            });
        </script>
    </body>
</html>