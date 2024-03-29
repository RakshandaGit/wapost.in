{{-- @extends('layouts/contentLayoutMaster')

@section('title', __('POS Activation'))

@section('content') --}}
<!-- Basic Vertical form layout section start -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<!-- Main Stylesheet -->
<link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
<section id="basic-vertical-layouts" class="pos-activation">
    <a class="brand-logo" href="/">
        <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
    </a>
    <div class="posActivePage">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="imgBox">
                    <img src="{{ asset('images/partner/pos-activation.png') }}" alt="pos-activation" class="w-100">
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                {{-- @if (Session::get('status') == 'success')
                    <div class="alert alert-block alert-success alert-dismissible mb-5" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ Session::get('message') }}
                    </div>
                @endif --}}

                @if ($status == 'error')
                    <div class="alert alert-danger alert-dismissible posActivation" role="alert">
                        {{-- <button type="button"></button> --}}
                        {{ $message }}
                    </div>
                @endif
                {{-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            {{ $error }}
                        </div>
                    @endforeach
                @endif --}}
                <div class="left-data">
                    <p>Now You Can Send Invoices To Your <br />Customer’s WhatsApp Number For Free*</p>
                    <div class="tagbanner">
                        <svg width="25" height="25" viewBox="0 0 32 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M27.6653 16L29.1373 13.456C29.3142 13.1499 29.3623 12.7861 29.2711 12.4446C29.1798 12.103 28.9566 11.8117 28.6506 11.6347L26.104 10.1627V7.22934C26.104 6.87572 25.9635 6.53658 25.7135 6.28653C25.4634 6.03648 25.1243 5.89601 24.7706 5.89601H21.8386L20.368 3.35067C20.1904 3.04523 19.8996 2.82201 19.5586 2.72934C19.3895 2.68349 19.213 2.67167 19.0393 2.69456C18.8656 2.71745 18.6981 2.77459 18.5466 2.86267L16 4.33467L13.4533 2.86134C13.1471 2.68454 12.7831 2.63662 12.4416 2.72814C12.1 2.81966 11.8088 3.04311 11.632 3.34934L10.16 5.89601H7.22797C6.87435 5.89601 6.53521 6.03648 6.28516 6.28653C6.03512 6.53658 5.89464 6.87572 5.89464 7.22934V10.1613L3.34797 11.6333C3.19602 11.7207 3.06283 11.8373 2.95606 11.9764C2.84929 12.1154 2.77105 12.2742 2.72583 12.4435C2.6806 12.6129 2.66929 12.7895 2.69254 12.9633C2.71579 13.137 2.77315 13.3045 2.86131 13.456L4.33331 16L2.86131 18.544C2.68529 18.8504 2.63754 19.2139 2.72845 19.5553C2.81937 19.8968 3.04158 20.1884 3.34664 20.3667L5.89331 21.8387V24.7707C5.89331 25.1243 6.03378 25.4634 6.28383 25.7135C6.53388 25.9635 6.87302 26.104 7.22664 26.104H10.16L11.632 28.6507C11.75 28.8525 11.9186 29.02 12.121 29.1369C12.3235 29.2538 12.5529 29.316 12.7866 29.3173C13.0186 29.3173 13.2493 29.256 13.4546 29.1373L15.9986 27.6653L18.5453 29.1373C18.8515 29.3139 19.2152 29.3618 19.5566 29.2706C19.898 29.1793 20.1894 28.9564 20.3666 28.6507L21.8373 26.104H24.7693C25.1229 26.104 25.4621 25.9635 25.7121 25.7135C25.9622 25.4634 26.1026 25.1243 26.1026 24.7707V21.8387L28.6493 20.3667C28.801 20.279 28.9339 20.1623 29.0405 20.0232C29.1471 19.8842 29.2252 19.7255 29.2704 19.5562C29.3156 19.3869 29.327 19.2104 29.3039 19.0367C29.2808 18.863 29.2238 18.6956 29.136 18.544L27.6653 16ZM12.6653 9.32C13.1959 9.32018 13.7047 9.53114 14.0798 9.90646C14.4549 10.2818 14.6655 10.7907 14.6653 11.3213C14.6651 11.8519 14.4542 12.3608 14.0789 12.7358C13.7035 13.1109 13.1946 13.3215 12.664 13.3213C12.1334 13.3212 11.6246 13.1102 11.2495 12.7349C10.8744 12.3596 10.6638 11.8506 10.664 11.32C10.6642 10.7894 10.8751 10.2806 11.2504 9.90552C11.6257 9.53044 12.1347 9.31983 12.6653 9.32ZM13.0653 22.12L10.932 20.5213L18.932 9.85467L21.0653 11.4533L13.0653 22.12ZM19.332 22.6533C19.0692 22.6532 18.8091 22.6014 18.5664 22.5008C18.3237 22.4002 18.1032 22.2527 17.9175 22.0669C17.7318 21.881 17.5845 21.6604 17.484 21.4177C17.3835 21.1749 17.3319 20.9147 17.332 20.652C17.3321 20.3893 17.3839 20.1291 17.4845 19.8864C17.5851 19.6437 17.7326 19.4232 17.9184 19.2375C18.1043 19.0518 18.3249 18.9045 18.5676 18.804C18.8104 18.7036 19.0706 18.6519 19.3333 18.652C19.8639 18.6522 20.3727 18.8631 20.7478 19.2385C21.1229 19.6138 21.3335 20.1227 21.3333 20.6533C21.3331 21.1839 21.1222 21.6928 20.7469 22.0678C20.3715 22.4429 19.8626 22.6535 19.332 22.6533Z"
                                fill="url(#paint0_linear_93_60)" />
                            <defs>
                                <linearGradient id="paint0_linear_93_60" x1="-6.00002" y1="2.39999" x2="32.7998"
                                    y2="29.6003" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#003A9C" />
                                    <stop offset="1" stop-color="#00E3AC" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <span class="ml-1">FREE* WhatsApp Messages</span>
                    </div>
                    <ul>
                        <li>
                            <span>No Free Trial, No credit card details required</span>
                        </li>
                        <li>
                            <span>After exhausting the message limit you can contact to support.</span>
                        </li>
                    </ul>
                    <div><a href="{{ URL::to('free-connection') }}?enterprise_id={{ $enterpriseId }}&enterprise_user_id={{ $enterpriseUserId }}"
                            class="activeFree"><i class="fa fa-handshake"></i><span>Activate For Free</span></a></div>
                    
                </div>
            </div>
        </div>
    </div>
    <p class="bottomText">Click here to know more about <a href="{{url('/')}}">wapost.net</a> visit our website
    </p>
</section>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<!-- // Basic Vertical form layout section end -->


{{-- @endsection


@section('page-script')

@endsection --}}
