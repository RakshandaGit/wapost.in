@extends('layouts.website')
@section('title', __('thank you'))
@section('meta-title', __('thank you'))
@section('meta-description', __(''))
{{-- @section('meta-keywords', __('')) --}}

@section('content')
    <!------ Blog Page strat here ------>
    <div class="thankyou-wrapper single-page-section-top-space single-page-section-bottom-space">
        <div class="container single-page-section-top-space">
            <div class="thankyoupage">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 d-flex align-items-center">
                        <div class="thankyoupage-content">
                            <div class="checkmark mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" width="100" height="100"
                                    viewBox="0 0 512 512">
                                    <path d="M448 256c0-106-86-192-192-192S64 150 64 256s86 192 192 192 192-86 192-192z"
                                        fill="none" stroke="#08828C" stroke-miterlimit="10" stroke-width="32" />
                                    <path fill="none" stroke="#08828C" stroke-linecap="#08828C" stroke-linejoin="#08828C"
                                        stroke-width="32"
                                        d="M368 192L256.13 320l-47.95-48M191.95 320L144 272M305.71 192l-51.55 59" />
                                </svg>
                            </div>
                            <h1 class="title mb-3">Congratulations!</h1>
                            <h6> We are thrilled to have you onboard and can't wait to see you get started.</h6>
                            <h6> Launch Your WA Post Campaign Now.</h6>
                            {{-- <p>You should receive a conformation email soon.</p> --}}
                            <div class="counter-box d-lg-flex d-md-flex d-block align-items-center">
                                <div class="counternum">
                                    <span id="counter">01</span>
                                </div>
                                <button
                                    class="btn btn-primary waves-effect waves-float waves-light btn-common flat-btn btn-active ms-lg-3 ms-md-3"><a
                                        href="dashboard">Click Here</a></button>
                            </div>
                            <ul class="ul social-media-list style-01 color-02 mt-3">
                                <li class="single-social-item">

                                    <a href="https://www.instagram.com/wapostindia/" tabindex="-1" target="_blank">

                                        <i class="fa-brands fa-instagram icon"></i>

                                    </a>

                                </li>

                                <li class="single-social-item">

                                    <a href="https://www.facebook.com/wapostindia" tabindex="-1" target="_blank">

                                        <i class="fa-brands fa-facebook-f icon"></i>

                                    </a>

                                </li>

                                <li class="single-social-item">

                                    <a href="https://twitter.com/WAPostIndia" tabindex="-1" target="_blank">

                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#1e9ca7}</style><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>

                                    </a>

                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="thankyou-img">
                            <img src="{{ asset('website/img/about/thank-you.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Set the date we're counting down to
        var minutes = 2;
        var seconds = 60;
        // Update the count down every 1 second
        var x = setInterval(function() {

            seconds = seconds - 1; //Math.floor((distance % (1000 * 60)) / 1000);
            if (seconds == 0) {
                seconds = 60;
                minutes = minutes - 1;
            }
            if (minutes == -1) {
                window.location.href = "/dashboard";
            }
            // Output the result in an element with id="demo"
            //   document.getElementById("counter").innerHTML = minutes + "m " + seconds + "s ";

            document.getElementById("counter").innerHTML = "0" + minutes + ":" + ((seconds < 10) ? "0" : "") +
                seconds + "";
        }, 1000);
    </script>

@endsection
