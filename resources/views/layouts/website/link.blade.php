<!-- favicon -->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

<!-- Bootstrap 5.2.0 -->
<link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap/css/bootstrap.min.css') }}">

<!-- ICONS (Bootstrap) V1.5.0 -->
<link rel="stylesheet" href="{{ asset('assets/website/vendor/bootstrap-icons/font/bootstrap-icons.css') }}">
{{-- <link rel="stylesheet" href="{{asset('assets/css/fontello/css/fontello.css')}}"> --}}

{{-- /* A Laravel Blade directive that allows you to push scripts to the head of the page. */ --}}
@stack('css')

<!-- CUSTOM CSS -->
<link rel="stylesheet" href="{{ asset('assets/website/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/css/customs.css') }}">

<!-- Owl Carousel CSS (2) -->
<link rel="stylesheet" href="{{ asset('assets/website/vendor/owl.carousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/website/vendor/owl.carousel/css/owl.theme.default.css') }}">