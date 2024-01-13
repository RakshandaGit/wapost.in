{{-- @extends('layouts/contentLayoutMaster')

@section('title', __('POS Activation'))

@section('content') --}}
<!-- Basic Vertical form layout section start -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">
<!-- Main Stylesheet -->
<link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
<section id="basic-vertical-layouts" class="freeConnection">
    <div class="posHeader text-center mb-2">
        <a class="brand-logo m-0" href="/">
            <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
        </a>
    </div>
    <div class="thankYouPage text-center">
        <svg width="88" height="88" viewBox="0 0 88 88" fill="none" class="img-fluid mb-2 mt-3"
            xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_3_154)">
                <path
                    d="M44.0002 7.33334C64.2512 7.33334 80.6668 23.749 80.6668 44C80.6668 64.251 64.2512 80.6667 44.0002 80.6667C23.7492 80.6667 7.3335 64.251 7.3335 44C7.3335 23.749 23.7492 7.33334 44.0002 7.33334ZM56.9618 30.7303L38.8118 48.8803L31.0385 41.1033C30.6981 40.7627 30.2939 40.4924 29.849 40.3079C29.4041 40.1235 28.9272 40.0284 28.4456 40.0283C27.473 40.0279 26.54 40.414 25.852 41.1015C25.164 41.789 24.7773 42.7217 24.7769 43.6944C24.7766 44.667 25.1626 45.6 25.8502 46.288L35.9628 56.4007C36.3374 56.7754 36.7821 57.0727 37.2716 57.2755C37.761 57.4783 38.2857 57.5827 38.8155 57.5827C39.3453 57.5827 39.87 57.4783 40.3594 57.2755C40.8489 57.0727 41.2936 56.7754 41.6682 56.4007L62.1502 35.9187C62.8382 35.2307 63.2247 34.2975 63.2247 33.3245C63.2247 32.3515 62.8382 31.4184 62.1502 30.7303C61.4622 30.0423 60.529 29.6558 59.556 29.6558C58.583 29.6558 57.6498 30.0423 56.9618 30.7303Z"
                    fill="#14C35A" />
            </g>
            <defs>
                <clipPath id="clip0_3_154">
                    <rect width="88" height="88" fill="white" />
                </clipPath>
            </defs>
        </svg>
        <p class="maintext">Congratulations!</p>
        <p>Now You will be able to send messages to your <br>Customer’s WhatsApp number.</p>
        <div class="my-3">
            @auth
                <a href="{{ route('user.home') }}" class="activeFree"><span>Go To Dashboard</span></a>
            @else
                <a href="{{ route('login') }}" class="activeFree"><span>Login</span></a>
            @endauth

        </div>
    </div>
    <p class="h-25 "></p>
</section>
<!-- // Basic Vertical form layout section end -->


{{-- @endsection


@section('page-script')

@endsection --}}
