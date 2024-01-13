@extends('layouts.website')
@section('title', __('thank you'))
@section('meta-title', __('thank you'))
@section('meta-description', __(''))
{{-- @section('meta-keywords', __('')) --}}

@section('content')
    <!------ Blog Page strat here ------>
    <div class="thankyou-wrapper single-page-section-top-space single-page-section-bottom-space">
        <div class="container single-page-section-top-space">
            <div class="thankyoupage-partner">
                <div class="swal2-container swal2-center swal2-backdrop-show" style="overflow-y: auto;">
                    <div aria-labelledby="swal2-title" aria-describedby="swal2-html-container"
                        class="swal2-popup swal2-modal swal2-icon-success swal2-show" tabindex="-1" role="dialog"
                        aria-live="assertive" aria-modal="true" style="display: grid;">
                        <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
                            <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);">
                            </div>
                            <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                            <div class="swal2-success-ring"></div>
                            <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                            <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);">
                            </div>
                        </div>
                        <h2 class="swal2-title" id="swal2-title" style="display: block;">Success!</h2>
                        <div class="swal2-html-container" style="display: block;">Thank you for contacting us. We will get
                            back to you soon.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @isset($_GET['paymentStatus'])
        @if ($_GET['paymentStatus'] == 'PAYMENT_SUCCESS')
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
        @endif
    @endisset
@endsection
