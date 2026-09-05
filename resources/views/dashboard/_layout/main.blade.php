
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8" />
	<title>Top Talents Consulting | {{ $title }}</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('Logo.png')}}">
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="{{asset('assets/dashboard/css/vendor.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/dashboard/css/facebook/app.min.css')}}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	
	<!-- ================== BEGIN page-css ================== -->
	<link href="{{asset('assets/plugins/fontawesome/css/all.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/dashboard/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />
	


	<link href="{{asset('assets/dashboard/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/dashboard/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/dashboard/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
	@stack('page-css')
	<!-- ================== END page-css ================== -->
</head>
<body>
	<!-- BEGIN #loader -->
	{{-- <div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div> --}}
	<!-- END #loader -->

	<!-- BEGIN #app -->
	<div id="app" class="app app-header-fixed app-sidebar-fixed ">
		
		@include('dashboard._partials.headbar')
		
		@include('dashboard._partials.sidebar')
		
        <div id="content" class="app-content">
		    @yield('container')
        </div>
	
		@include('dashboard._partials.footbar')
		
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="{{asset('assets/dashboard/js/vendor.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/js/app.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/js/theme/facebook.min.js')}}"></script>
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="{{asset('assets/dashboard/plugins/sweetalert/dist/sweetalert.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/pdfmake/build/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/pdfmake/build/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/jszip/dist/jszip.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/js/demo/table-manage-buttons.demo.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/ckeditor/ckeditor.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/js/demo/form-wysiwyg.demo.js')}}"></script>
	<script src="{{asset('assets/dashboard/plugins/select-picker/dist/picker.min.js')}}"></script>
	@stack('scripts')
	<script src="{{asset('assets/dashboard/plugins/@highlightjs/cdn-assets/highlight.min.js')}}"></script>
	<script src="{{asset('assets/dashboard/js/demo/render.highlight.js')}}"></script>
	<script>

    function previewImage()
    {
        const image = document.querySelector('#image')
        const imgPreview = document.querySelector('#img-preview')
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0])
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result
        }
    }

	$('.table').on('click', '.btn-del', function(e) {
		e.preventDefault()

		swal({
				title: "Peringatan!",
				text: "Yakin akan dihapus?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((result) => {
				if (result) {
					document.getElementById('delete-form').submit()
				}
			});
	})
	const flashDataError = $('.flash-data-error').data('flashdataerror')
	if (flashDataError) {
		swal({
			title: "Gagal!",
			text: flashDataError,
			icon: "error",
		});
	}

	const flashDataSuccess = $('.flash-data-success').data('flashdatasuccess')
	if (flashDataSuccess) {
		swal({
			title: "Berhasil!",
			text: flashDataSuccess,
			icon: "success",
		});
	}

	const flashDataWarning = $('.flash-data-warning').data('flashdatawarning')
	if (flashDataWarning) {
		swal({
			title: "Peringatan!",
			text: flashDataWarning,
			icon: "warning",
		});
	}
	</script>
	<!-- ================== END page-js ================== -->
</body>
</html>