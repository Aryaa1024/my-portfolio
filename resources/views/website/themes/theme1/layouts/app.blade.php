<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($settings->site_title ?? 'Portfolio'))</title>
    <meta name="description" content="@yield('meta_description', ($settings->site_description ?? ''))">

    @if(!empty($settings->light_favicon))
        <link rel="icon" href="{{ asset('storage/' . $settings->light_favicon) }}">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/themes/theme1/css/theme.css') }}">
    @stack('styles')
</head>
<body class="theme1-body">

    @include('website.themes.theme1.layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('website.themes.theme1.layouts.partials.footer')

    <a href="#top" class="back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.splide').forEach(function (el) {
                new Splide(el, {
                    type: el.dataset.type || 'slide',
                    perPage: parseInt(el.dataset.perPage) || 3,
                    perMove: 1,
                    gap: '1.5rem',
                    pagination: el.dataset.pagination === 'true',
                    arrows: true,
                    autoplay: el.dataset.autoplay === 'true',
                    breakpoints: { 992: { perPage: parseInt(el.dataset.perPageTablet) || 2 }, 576: { perPage: 1 } }
                }).mount();
            });
        });
    </script>
    <script src="{{ asset('assets/themes/theme1/js/theme.js') }}"></script>
    @stack('scripts')
</body>
</html>
