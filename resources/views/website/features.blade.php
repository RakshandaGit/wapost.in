@extends('layouts.website')
@section('title', __('Explore WA Post Features | Best Bulk WhatsApp Sender Tool'))
@section('meta-title', __('Explore WA Post Features | Best Bulk WhatsApp Sender Tool'))
@section('meta-description', __('Looking for the best bulk WhatsApp sender tool? Discover the features of WAPost, your ultimate solution for efficient messaging. Elevate your strategy, Get it Today!'))
@section('canonical', __('https://wapost.net/features'))
{{-- @section('meta-keywords', __('')) --}}

@section('content')

    <!-- about page start here  -->
    <div class="services-details-wrapper feature-page single-page-section-top-space single-page-section-bottom-space">
        <!-- about content area start here  -->
        <section class="about-section-area-wrapper section-top-space section-bottom-space">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6 col-md-12">
                        <div class="features-content">
                            <h1 class="content-title text-blue">WAPOST - Bulk WhatsApp Marketing Tool Features</h1>

                            <p class="paragraph font-weight-600 color-heading">Analyse and streamline your messaging with WhatsApp Marketing Tool. Try our demo or get started now!</p>

                            <div class="d-flex">
                                <div class="btn-wrap">
                                    @auth
                                        <a href="{{ route('user.home') }}" class="btn-common flat-btn btn-active">Get Started Now</a>
                                    @else
                                        <a href="{{ url('pricing') }}" class="btn-common flat-btn btn-active">Get Started Now</a>
                                    @endauth
                                </div>
                                {{-- <div class="btn-wrap margin-left-20">
                                    <a href="#" class="btn-common flat-btn btn-active">Free Demo</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="thumbnail text-right">
                            <img src="{{asset('website/img/features/feature-banner.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about content area end here  -->

        <!-- about content area start here  -->
        <section class="about-section-area-wrapper section-top-space section-bottom-space section-bg">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-12 col-md-12">
                        <div class="section-title-wrapper mb-0 text-center">
                            <h4 class="section-title text-white">Transform Your Business Messaging with WAPost: The Ultimate WhatsApp Marketing Platform </h4>
                            <p class="description text-white">WAPost WhatsApp Marketing Solution allows you to save time, improve efficiency, and improve customer experience. WAPost platform is easy to use and offers a variety of features to enhance your messaging capabilities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about content area end here  -->

        <section class="about-section-area-wrapper section-top-space section-bottom-space">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="theme-section-title desktop-center text-center">
                            <h4 class="title text-blue">Great Features to Take Your Customer's Experience to the Next Level
                                <svg class="title-shape" width="355" height="15" viewBox="0 0 355 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="path" d="M351.66 12.6362C187.865 -6.32755 49.6478 6.37132 3.41142 12.6362" stroke="#08828c" stroke-width="3" stroke-linecap="square"></path>
                                    <path class="path" d="M351.66 13C187.865 -5.96378 49.6478 6.73509 3.41142 13" stroke="#08828c" stroke-width="3" stroke-linecap="square"></path>
                                    <path class="path" d="M2.5 5.5C168.5 2.0001 280.5 -1.49994 352.5 8.49985" stroke="#FFC44E" stroke-width="3" stroke-linecap="square"></path>
                                </svg>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section" id="FeatureSec">
            <div class="container">
                <div id="Featurerowone">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 my-5">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" id="feature1">
                                    <img src="{{asset('website/img/features/feature-1.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Quick Scanner WhatsApp Connect</h4>
                                    <p class="mb-0">WAPost Quick Scanner WhatsApp Connect feature enables you to connect with your customers & start a conversation (both manual & automated) with them instantly.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-5">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" id="feature2">
                                    <img src="{{asset('website/img/features/feature-2.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Broadcast & Bulk Messages</h4>
                                    <p class="mb-0">With WAPost Broadcast & Bulk Messages feature, you can send personalised messages to multiple recipients at once. This feature assists you save time and improving the efficiency of your messaging campaigns.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-5">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" id="Campaignbuild">
                                    <img src="{{asset('website/img/features/feature-3.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Campaign Builder</h4>
                                    <p class="mb-0">WAPost Campaign Builder feature allows you to generate engaging messaging campaigns that resonate with your customers. You can customise your campaigns to target particular audiences and track their performance in real time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Featurerowtwo">
                    <div class="row ">
                        <div class="col-lg-4 col-md-6 my-5">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" id="group-message">
                                    <img src="{{asset('website/img/features/feature-4.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Contact Management</h4>
                                    <p class="mb-0">WAPost Contact Management feature allows you to organise and manage your contacts more efficiently. You can easily add, delete, and modify your contacts and keep track of their messaging activity.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-5">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" id="Importfeature">
                                    <img src="{{asset('website/img/features/feature-5.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Custom Automated Message Builder</h4>
                                    <p class="mb-0">With WAPost Custom Automated Message Builder, you can generate personalised messages that are automatically sent to your customers. These characteristics assist you to save time and ensure that your customers receive timely and relevant messaging.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 my-5" id="BlacklistFeature">
                            <div class="icon-box-item pb-0 h-100">
                                <div class="feature-icon" >
                                    <img src="{{asset('website/img/features/feature-6.png')}}" alt="">
                                </div>
                                <div class="content text-center py-4">
                                    <h4 class="title">Blacklist Management</h4>
                                    <p class="mb-0">WAPost Blacklist Management characteristics enable you to block unwanted messages from particular contacts. These characteristics assist you to maintain the integrity of your messaging campaigns and ensure that your customers receive relevant messaging.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       {{-- feature call to act area --}}
        <section class="">
            <div class="container feature-call-to-act-area section-bg">
                <h4 class="feature-title text-white">Transform Your Customer Experience with WhatsApp Marketing</h4>
                <div class="call-to-act-btn-sec">
                    {{-- <div class="btn-wrap">
                        <a href="#" class="btn-call-to-act">Free Demo</a>
                    </div> --}}
                    <div class="btn-wrap margin-left-20">
                        @auth
                            <a href="{{ route('user.home') }}" class="btn-call-to-act flat-btn fill-btn">Buy Now</a>
                        @else
                            <a href="{{ url('pricing') }}" class="btn-call-to-act flat-btn fill-btn">Buy Now</a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
        
    </div>
    <!-- about page end here  -->
   <!-- Add this script to your layout or include it on each page where you want to remove the hash -->
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        if (window.location.hash) {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }

        $('a').on('click', function (e) {
            if (this.href.indexOf('#') > -1) {
                e.preventDefault();
                history.pushState(null, null, this.href.split('#')[0]);
            }
        });
    });
</script> --}}

@endsection