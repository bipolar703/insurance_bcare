<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title')</title>
    <link rel="canonical" href="" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('style_files/backend/images/favicon.png') }}">
    <!-- Custom CSS -->
    <link href="{{ asset('style_files/backend/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('header')
</head>

<body>
    @include('layouts.admin.preloader')
    <div id="main-wrapper">
        @include('layouts.admin.header')
        @include('layouts.admin.sidebar')
        <div class="page-wrapper">
            @yield('content')
            @include('layouts.admin.footer')
        </div>
    </div>

    <!-- Core JavaScript -->
    <script src="{{ asset('style_files/backend/src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Apps -->
    <script src="{{ asset('style_files/backend/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/app.init.horizontal.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/app-style-switcher.horizontal.js') }}"></script>
    
    <!-- Plugins -->
    <script src="{{ asset('style_files/backend/src/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/src/assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/waves.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/custom.min.js') }}"></script>
    
    <!-- DataTables -->
    <script src="{{ asset('style_files/backend/src/assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/pages/datatable/custom-datatable.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('style_files/backend/dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>
    
    <!-- Additional Plugins -->
    <script src="{{ asset('style_files/backend/src/assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/src/assets/extra-libs/sweetalert2/sweet-alert.init.js') }}"></script>
    <script src="{{ asset('style_files/backend/src/assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/src/assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('style_files/backend/dist/js/pages/forms/select2/select2.init.js') }}"></script>
    
    <!-- Custom Scripts -->
    <script src="{{ asset('style_files/backend/dist/js/custom_lal.js') }}"></script>
    <script src="{{ asset('style_files/shared/js/custom.js') }}"></script>
    
    @yield('footer')
</body>

</html>
