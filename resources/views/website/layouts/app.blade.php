<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <title>HUD | Landing Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- ================== BEGIN core-css ================== -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <!-- ================== END core-css ================== -->

    <!-- ================== BEGIN page-css ================== -->
    <link href="{{ asset('assets/plugins/lity/dist/lity.min.css') }}" rel="stylesheet">
    <!-- ================== END page-css ================== -->

    @stack('page-style')

</head>

<body>
    <!-- BEGIN #app -->
    <div id="app" class="app">
        @include('website.layouts.header')
        @yield('page-content')
        @include('website.layouts.footer')
       
    </div>
    <!-- END #app -->

    <!-- ================== BEGIN core-js ================== -->
    <script data-cfasync="false" src="{{ asset('assets/js/email-decode.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app.min.js') }}" type="text/javascript"></script>
    <!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-js ================== -->
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/lity/dist/lity.min.js') }}" type="text/javascript"></script>
    <!-- ================== END page-js ================== -->

    <script src="{{ asset('assets/js/rocket-loader.min.js') }}" data-cf-settings="|49" defer></script>

    @stack('page-script')
</body>

</html>
