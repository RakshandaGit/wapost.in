@extends('layouts.website')
@section('title', __('WA Post Bulk WhatsApp Sender - No Downloading Required'))
@section('meta-title', __('WA Post Bulk WhatsApp Sender - No Downloading Required'))
@section('meta-description', __('Boost your business reach and engagement with WA POST - the best bulk WhatsApp sender in the market. Try it now and watch your business thrive!'))
@section('canonical', __('https://wapost.net/'))

@section('vendor-style')
    {{-- vendor css files --}}
    {{-- <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}"> --}}

@endsection
@section('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Banner Area Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="banner-area section-top-space home-01">
        <div class="container">
            <div class="banner-wrapper py-5">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-10">
                        <div class="banner-inner">
                            <h1 class="title">Send Unlimited Bulk WhatsApp Messages with WA Post -  No Block, No Ban</h1>
                            <ul>
                                <li><i class="fa-solid fa-check"></i><p>Reach your customers anytime on the most trusted messaging platform.</p></li>
                                <li><i class="fa-solid fa-check"></i><p>100% Delivery Rate. Safe, Secure, and Encrypted.</p></li>
                                <li><i class="fa-solid fa-check"></i><p>Send Bulk Messages Instantly with No Waiting Time Or Schedule For Later.</p></li>
                                <li><i class="fa-solid fa-check"></i><p>Have Full Control over What You Send and When You Send with WA Post Bulk WhatsApp Sender.</p></li>
                            </ul>
                            
                            <div class="header-btn">
                                <div class="btn-wrap">
                                    @auth
                                        <a href="{{ route('user.home') }}" class="btn-common flat-btn btn-active">Get Started Today</a> <span class="px-2"><b>No Downloading Required</b></span>
                                    @else
                                        <a href="{{ url('pricing') }}" class="btn-common flat-btn btn-active">Get Started Today</a> <span class="px-2"><b>No Downloading Required</b></span>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="thumbnail">
                            {{-- <img src="{{asset('website/img/shapes/Ellipse-01.png')}}" class="element-01" alt="Ellipse">
                            <img src="{{asset('website/img/shapes/Ellipse-02.png')}}" class="element-02" alt="Ellipse"> --}}
                            <img src="{{ asset('website/img/shapes/Vector-15.png') }}" class="element-03" alt="vector">
                            {{-- <img src="{{asset('website/img/header/plane.png')}}" class="element-04" alt="plane">
                            <img src="{{asset('website/img/icon/location.png')}}" class="element-05" alt="location"> --}}
                            <img src="{{ asset('website/img/header/header-img.png') }}" class="banner-img" alt="Student">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Banner Area End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="video-sec my-5">
        <div class="container">
            <div class="theme-section-title desktop-center text-center">
                <h2 class="title">How WA Post Bulk WhatsApp Sender Works
                    <svg class="title-shape" width="355" height="15" viewBox="0 0 355 15" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path class="path" d="M351.66 12.6362C187.865 -6.32755 49.6478 6.37132 3.41142 12.6362"
                            stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                        <path class="path" d="M351.66 13C187.865 -5.96378 49.6478 6.73509 3.41142 13"
                            stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                        <path class="path" d="M2.5 5.5C168.5 2.0001 280.5 -1.49994 352.5 8.49985"
                            stroke="#FFC44E" stroke-width="3" stroke-linecap="square" />
                    </svg>
                </h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{-- <iframe width="100%" height="586" src="https://www.youtube.com/embed/hVtyJ6pfeTI?autoplay=1&loop=1&muted=1" allow="autoplay" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                    <iframe width="100%" height="500"
                        src="https://www.youtube.com/embed/hVtyJ6pfeTI?autoplay=0&mute=1&loop=3" loop="true"></iframe>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Features Area Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!-- <section class="features-section margin-top-100">
            {{-- <img src="{{asset('website/img/shapes/graduation.png')}}" class="shape" alt="graduation cap"> --}}
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="theme-section-title desktop-center text-center">
                            <h4 class="title">Amazing Features to take your customers
                                communication <br> experience to next level
                                <svg class="title-shape" width="355" height="15" viewBox="0 0 355 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="path"
                                        d="M351.66 12.6362C187.865 -6.32755 49.6478 6.37132 3.41142 12.6362"
                                        stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                                    <path class="path" d="M351.66 13C187.865 -5.96378 49.6478 6.73509 3.41142 13"
                                        stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                                    <path class="path" d="M2.5 5.5C168.5 2.0001 280.5 -1.49994 352.5 8.49985"
                                        stroke="#FFC44E" stroke-width="3" stroke-linecap="square" />
                                </svg>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="icon-box-item">
                            <div class="icon">
                                {{-- <img src="{{asset('website/img/icon/idea.png')}}" alt=""> --}}
                                <img src="{{ asset('website/img/feature-icon/schedule-bulk-msg.svg') }}" class="icon-width" alt="">
                            </div>
                            <div class="content">
                                <h4 class="title">Schedule & Send Bulk WhatsApp Messages </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="icon-box-item">
                            <div class="icon">
                                <img src="{{ asset('website/img/feature-icon/attach-images.svg') }}" alt="" class="icon-width">
                            </div>
                            <div class="content">
                                <h4 class="title">Attach Images And Documents</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="icon-box-item">
                            <div class="icon">
                                <img src="{{ asset('website/img/feature-icon/interact-customer.svg') }}" alt="" class="icon-width">
                            </div>
                            <div class="content">
                                <h4 class="title">Interact With Customers Easily</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            features-section End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            features-section-two Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="features-section-two margin-top-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="theme-section-title desktop-center text-center">
                        <h4 class="title">Pro Features at your Finger-Tips
                            <svg class="title-shape" width="355" height="15" viewBox="0 0 355 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path class="path" d="M351.66 12.6362C187.865 -6.32755 49.6478 6.37132 3.41142 12.6362"
                                    stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                                <path class="path" d="M351.66 13C187.865 -5.96378 49.6478 6.73509 3.41142 13"
                                    stroke="#08828c" stroke-width="3" stroke-linecap="square" />
                                <path class="path" d="M2.5 5.5C168.5 2.0001 280.5 -1.49994 352.5 8.49985"
                                    stroke="#FFC44E" stroke-width="3" stroke-linecap="square" />
                            </svg>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="destination-items-wrap">
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/quick-scanner.svg') }}" alt="">
                    </div>
                    <h6 class="name">Quick Scan & Connect</h6>
                    <p class="mt-2 text-center">Engage customers instantly. <a href="{{ route('features') }}/#Featurerowone" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/broadcast-bulk.svg') }}" alt="">
                    </div>
                    <h6 class="name">Broadcast & Bulk Messages</h6>
                    <p class="mt-2 text-center">Message all of your customers in just one click. <a href="{{ route('features') }}/#Featurerowone" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Send-schedule.svg') }}" alt="">
                    </div>
                    <h6 class="name">Send & Schedule customized messages</h6>
                    <p class="mt-2 text-center">Messages get sent automatically on the time and date set by you. <a href="{{ route('features') }}/#feature3" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Import-contacts.svg') }}" alt="">
                    </div>
                    <h6 class="name">Import Contacts</h6>
                    <p class="mt-2 text-center">Manage all important contacts with our easy Import and Export functionality. <a href="{{ route('features') }}/#Featurerowtwo" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/custom-automated-msg.svg') }}" alt="">
                    </div>
                    <h6 class="name">Group Messaging </h6>
                    <p class="mt-2 text-center">Bifurcate important customers in different groups based on your preference. <a href="{{ route('features') }}/#Featurerowtwo" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Customize-analytics.svg') }}" alt="">
                    </div>
                    <h6 class="name">Customize Analytics & Reports</h6>
                    <p class="mt-2 text-center">Real time reports and statistics compiled based on your preference. <a href="{{ route('features') }}/#feature6" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/blacklist-management.svg') }}" alt="">
                    </div>
                    <h6 class="name">Contact Blacklist Management</h6>
                    <p class="mt-2 text-center">Block out messages from contacts that are not relevant to your business. <a href="{{ route('features') }}/#Featurerowtwo" class="text-primary">Click here</a> to know more.</p>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/campaign-builder.svg') }}" alt="">
                    </div>
                    <h6 class="name">Campaign Builder</h6>
                    <p class="mt-2 text-center">Create and send engaging messages to your target audience. <a href="{{ route('features') }}/#Featurerowone" class="text-primary">Click here</a> to know more.</p>
                </div>
            </div>
            <div class="header-btn">
                <div class="btn-wrap text-center">
                    @auth
                        <a href="{{ route('user.home') }}" class="btn-common flat-btn btn-active">Get Started Now</a>
                    @else
                        <a href="{{ url('pricing') }}" class="btn-common flat-btn btn-active">Get Started Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            features-section-two Area End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Benefit Area Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="benefits-section margin-top-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 d-flex align-items-center"><img
                        src="{{ asset('website/img/features/whatsapp-marketing.png') }}" class="shape"
                        alt="graduation cap"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="benefits-content-box">
                        <h2 class="title">The Only Bulk WhatsApp Sender You’ll Ever Need</h2>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>No Waiting Period </h3>
                                <p>WA Post allows you to send your bulk WhatsApp Messages Instantly. You don’t have to wait for 2-3 hours for your bulk messages to be delivered. WA Post delivers them immediately, or if you’d like, you can schedule them for a date and time in the future.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Import and Export</h3>
                                <p>You can import and export all your data, from contacts to reports. WA Post ensures you have everything you need.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Send Bulk Messages without Saving the Contact</h3>
                                <p>Send Bulk Messages without Saving Contacts. No hassle of saving the contacts every time you want to send messages to a new number.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Auto verification of numbers</h3>
                                <p>WA Post automatically verifies numbers for you. It ensures that the numbers you’re sending your messages to are WhatsApp numbers.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Share Unlimited Multimedia</h3>
                                <p>Send unlimited images, videos, audio, documents, and even contacts. Share with your customers everything you want to. No restrictions at all!</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Segment Audience</h3>
                                <p>Group Audience with different categories. Send Bulk Messages to individuals in different categories for customised bulk messaging. Your audience wouldn’t know they are grouped in categories. We can keep a secret, can you?</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Connect Multiple WhatsApp Accounts</h3>
                                <p>WA Post lets you connect multiple WhatsApp Accounts. You can switch easily, synchronise groups, and more!</p>
                            </div>
                        </div>
                        <div class="header-btn">
                            <div class="btn-wrap">
                                @auth
                                    <a href="{{ route('user.home') }}" class="btn-common flat-btn btn-active">Get Started
                                        Now</a>
                                @else
                                    <a href="{{ url('pricing') }}" class="btn-common flat-btn btn-active">Get Started Now</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Benefit-section End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            call-to-action Area Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="margin-top-110 section-bottom-space lifetime-free">
        <div class="call-to-action">
            <div class="container custom-cta">
                <img src="{{ asset('website/img/shapes/mountant.png') }}"
                    class="shape-01 wow animate__animated animate__delay-1s animate__fadeInUp" alt="mountant">
                <div class="plane-wrap">
                    <img src="{{ asset('website/img/shapes/plane.png') }}" class="shape-02" alt="mountant">
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="theme-section-title desktop-center text-center">
                            <h4 class="title text-white">Jumpstart Your Bulk Messaging Now Reach Thousands in Less Than a Minute With WA Post - The Best Bulk WhatsApp Sender For Business.</h4>
                        </div>
                        <div class="btn-wrap-unlock text-center">
                            @auth
                                <a href="{{ route('user.home') }}" class="subscribe-btn">Sign Up Today</a>
                            @else
                                <a href="{{ url('pricing') }}" class="subscribe-btn">Sign Up Today</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            call-to-action Area End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


    
@endsection
@section('page-script')
@endsection
