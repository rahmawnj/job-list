
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
        <style>
            /* Keep the floating WhatsApp widget above every page section/filter/dropdown. */
            .floating-wpp {
                position: fixed !important;
                z-index: 2147483647 !important;
            }
            .floating-wpp .floating-wpp-button,
            .floating-wpp .floating-wpp-popup {
                z-index: 2147483647 !important;
            }

            /* Keep homepage stacking levels consistent: We are Hiring and its filter use one layer. */
            .featured-job-area,
            .featured-job-area .container,
            .featured-job-area .row,
            .featured-job-area .col-xl-10,
            .job-filter-card,
            #job_data {
                position: relative;
                z-index: 100 !important;
            }

            @media (max-width: 767px) {
                .our-services .row > .col-xl-3,
                .our-services .row > .col-lg-3,
                .our-services .row > .col-md-4,
                .our-services .row > .col-sm-6 {
                    flex: 0 0 50% !important;
                    max-width: 50% !important;
                    width: 50% !important;
                    padding-left: 7px !important;
                    padding-right: 7px !important;
                }

                .our-services .row {
                    margin-left: -7px !important;
                    margin-right: -7px !important;
                    row-gap: 14px !important;
                }

                .our-services .single-services {
                    padding: 16px 10px !important;
                }

                .our-services .services-cap {
                    display: none !important;
                }

                .our-services .services-ion {
                    height: 64px !important;
                    margin-bottom: 0 !important;
                }

                .our-services .services-ion img {
                    height: 48px !important;
                    max-width: 100%;
                    object-fit: contain;
                }

                /* Mobile job cards: move the company image above the job information and center it. */
                .single-job-items .job-items {
                    flex-direction: column !important;
                    align-items: center !important;
                }

                .single-job-items .company-img {
                    margin-left: auto !important;
                    margin-right: auto !important;
                    flex: 0 0 auto !important;
                }

                .single-job-items .job-tittle {
                    width: 100% !important;
                    max-width: 100% !important;
                    padding-left: 0 !important;
                    align-items: center !important;
                    text-align: center !important;
                }
            }
        </style>
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

        <script>
            $(function () {
                $(document).on('sp-change', '.job-filter-card .job-filter-select', function () {
                    $(this).trigger('change');
                });
            });
        </script>

        <script>
            $(function () {
                var topCategoryMap = @json(\App\Models\Jobcategory::where('is_top_category', true)->pluck('id', 'name'));

                $('.our-services .single-services').each(function () {
                    var $card = $(this);
                    var categoryName = $.trim($card.find('.services-cap h5').text());
                    var categoryId = topCategoryMap[categoryName];
                    var $link = $card.closest('a');

                    if (categoryId && $link.length) {
                        $link.attr('href', '/jobs?job_category=' + encodeURIComponent(categoryId));
                    }
                });
            });
        </script>

        <script>
            $(function () {
                if (window.location.pathname.replace(/\/+$/, '') !== '/jobs') {
                    return;
                }

                var $form = $('.jobs-filter-form');
                if (!$form.length) {
                    return;
                }

                $(document).off('click', '.pagination a');
                $('#search').off('keyup');
                $('#sort_by').off('change');
                $('[name="job_type"]').off('change');
                $('#job_category').off('change');
                $('#location').off('change');

                $form.attr('action', '/jobs').attr('method', 'GET');
                $('#location').attr('name', 'location');
                $('#job_category').attr('name', 'job_category');

                var params = new URLSearchParams(window.location.search);
                var locationValue = params.get('location') || '';
                var categoryValue = params.get('job_category') || '';
                var jobTypeValue = params.get('job_type') || '';

                $('#location').val(locationValue);
                $('#job_category').val(categoryValue);
                $('[name="job_type"]').prop('checked', false);
                if (jobTypeValue) {
                    $('[name="job_type"][value="' + jobTypeValue + '"]').prop('checked', true);
                }

                if (!$form.find('.jobs-filter-submit').length) {
                    $form.append(
                        '<button type="submit" class="jobs-filter-submit btn btn-primary w-100 mt-4">Filter</button>'
                    );
                }

                $('#sort_by').on('change', function () {
                    var url = new URL('/jobs', window.location.origin);

                    params.forEach(function (value, key) {
                        url.searchParams.set(key, value);
                    });

                    if ($(this).val()) {
                        url.searchParams.set('sort_by', $(this).val());
                    } else {
                        url.searchParams.delete('sort_by');
                    }

                    window.location.href = url.toString();
                });

                var currentSort = params.get('sort_by') || '';
                $('#sort_by').val(currentSort);
            });
        </script>

        <script>
            $(function () {
                if (window.location.pathname.replace(/\/+$/, '') !== '/jobs') {
                    return;
                }

                var $typeFilter = $('.jobs-type-filter');
                if (!$typeFilter.length || $typeFilter.find('input[name="job_type"][value=""]').length) {
                    return;
                }

                $typeFilter.prepend(
                    '<label class="container">All Job Types' +
                        '<input name="job_type" type="radio" value="" checked>' +
                        '<span class="checkmark"></span>' +
                    '</label>'
                );

                var params = new URLSearchParams(window.location.search);
                var currentType = params.get('job_type');
                if (currentType) {
                    $typeFilter.find('input[name="job_type"][value=""]').prop('checked', false);
                    $typeFilter.find('input[name="job_type"][value="' + currentType + '"]').prop('checked', true);
                }
            });
        </script>

        <script src="{{asset('assets/homepage/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/bootstrap.min.js')}}"></script>
	    <script src="{{asset('assets/homepage/js/jquery.slicknav.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/slick.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/price_rangs.js')}}"></script>
        <script src="{{asset('assets/homepage/js/wow.min.js')}}"></script>
		<script src="{{asset('assets/homepage/js/animated.headline.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.magnific-popup.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.scrollUp.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.nice-select.min.js')}}"></script>
		<script src="{{asset('assets/homepage/js/jquery.sticky.js')}}"></script>
        <script src="{{asset('assets/homepage/js/contact.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.form.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/homepage/js/mail-script.js')}}"></script>
        <script src="{{asset('assets/homepage/js/jquery.ajaxchimp.min.js')}}"></script>
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