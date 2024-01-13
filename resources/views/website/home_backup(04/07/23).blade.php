@extends('layouts.website')
@section('title', __('Best Bulk WhatsApp Sender for Business - WAPOST'))
@section('meta-title', __('Best Bulk WhatsApp Sender for Business - WAPOST'))
@section('meta-description', __('Safe and fastest bulk WhatsApp sender software, optimize & send messages to customers
    with best WhatsApp marketing tool.'))
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
                            <h1 class="title">Drive High-Quality Customer Engagement on WhatsApp with WAPost</h1>
                            <p>Reach more customers, save time, increase engagement and track results with <b>WAPOST</b>
                                WhatsApp Bulk Messaging Sender. Implement your WhatsApp Marketing Strategy with WAPost
                                Campaign Builder Now.</p>

                            <div class="header-btn">
                                <div class="btn-wrap">
                                    @auth
                                        <a href="{{ route('user.home') }}" class="btn-common flat-btn btn-active">Get Started
                                            Now</a>
                                    @else
                                        <a href="{{ url('pricing') }}" class="btn-common flat-btn btn-active">Get Started
                                            Now</a>
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
            <div class="row">
                <div class="col-lg-12">
                    {{-- <iframe width="100%" height="586" src="https://www.youtube.com/embed/hVtyJ6pfeTI?autoplay=1&loop=1&muted=1" allow="autoplay" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> --}}
                    <iframe width="100%" height="586"
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
                        <h4 class="title">Amazing features to leverage the power of<br> WhatsApp Marketing
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
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/broadcast-bulk.svg') }}" alt="">
                    </div>
                    <h6 class="name">Broadcast & Bulk Messages</h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Send-schedule.svg') }}" alt="">
                    </div>
                    <h6 class="name">Send & Schedule customized messages</h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Import-contacts.svg') }}" alt="">
                    </div>
                    <h6 class="name">Import Contacts</h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/custom-automated-msg.svg') }}" alt="">
                    </div>
                    <h6 class="name">Group Messaging </h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/Customize-analytics.svg') }}" alt="">
                    </div>
                    <h6 class="name">Customize Analytics & Reports</h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/blacklist-management.svg') }}" alt="">
                    </div>
                    <h6 class="name">Contact Blacklist Management</h6>
                </div>
                <div class="destination-single-item style-01">
                    <div class="thumbnail">
                        <img src="{{ asset('website/img/feature-icon/campaign-builder.svg') }}" alt="">
                    </div>
                    <h6 class="name">Campaign Builder</h6>
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
                        <h2 class="title">Why you should choose WAPost as your WhatsApp Bulk Sender Tool?</h2>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Works on most trusted channel with 98%
                                    Open Rate </h3>
                                <p>With a 98% open rate, WhatsApp is one of the most effective channels for reaching
                                    customers with important updates and promotions.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>WhatsApp Messaging Automation</h3>
                                <p>WApost offers automation features and allows you to schedule messages in advance. This
                                    enables you to send messages at specific times, ensuring timely delivery and
                                    convenience.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Track with Analytics and Report</h3>
                                <p>WApost tool provides detailed analytics and reporting features. This information can
                                    assist you to measure the effectiveness of your campaigns and make informed decisions
                                    for future outreach.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Send Unlimited Multimedia</h3>
                                <p>WApost Tool often supports multimedia messages, including images, videos, and audio
                                    files. This allows you to create visually appealing and engaging content that can
                                    capture the attention of your recipients.</p>
                            </div>
                        </div>
                        <div class="icon-box-item">
                            <div class="content">
                                <h3 class="title"><i class="fa-solid fa-check"></i>Quick Send without Saving Contact</h3>
                                <p>Quick Send enables you to message multiple contacts by separating their numbers with
                                    commas. It automatically verifies WhatsApp connection status and displays the number of
                                    connected accounts.</p>
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
                            <h4 class="title text-white">Send personalised bulk WhatsApp messages to your leads and
                                customers at scale and watch your sales soar.</h4>

                        </div>
                        <div class="btn-wrap-unlock text-center">
                            @auth
                                <a href="{{ route('user.home') }}" class="subscribe-btn">Get Started Now</a>
                            @else
                                <a href="{{ url('pricing') }}" class="subscribe-btn">Get Started Now</a>
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


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Faq Section Area Start Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="faq-section-area margin-top-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="theme-section-title">
                        <span class="subtitle">FAQ</span>
                        <h4 class="title">Frequently asked question</h4>
                    </div>
                    <div class="faq-content">
                        <h6 class="subtitle">Still do you have any questions to know? <br> Feel free to ask our
                            experts here.</h6>
                        <div class="btn-wrap">
                            <a class="btn-common flat-btn" href="{{ route('contact_us') }}">ASK YOUR QUESTIONS</a>
                            {{-- <button class="btn-common flat-btn" onclick="openForm()">ASK YOUR QUESTIONS</button> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion-wrapper">
                        <!-- accordion wrapper -->
                        <div id="accordionOne">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            1. What is WAPOST, and how does it work?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        WAPOST is a powerful whatsapp bulk message software solution that allows businesses
                                        to send custom messages and campaigns to their target audience. It comes with a
                                        user-friendly dashboard that offers detailed analytics and reporting to help
                                        businesses track their messages' performance.
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            2. What features does WAPOST offer?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        WAPOST offers a range of features, including contact management, custom messages, group contacts, blacklist management, campaign builder, and reporting. These features make it easy for businesses to manage their WhatsApp campaigns and track their performance.
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            2. Can I manage my contacts using WAPOST?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST comes with a contact management feature that allows you to manage your
                                        contacts easily. You can add, edit, and delete contacts, as well as import and
                                        export contact lists.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            3. Can I send custom messages using WAPOST?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseFour" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST allows you to send custom messages to your target audience. You can
                                        create custom messages using the campaign builder or send individual messages to
                                        specific contacts.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive" aria-expanded="false"
                                            aria-controls="collapseFive">
                                            4. Can I manage blacklisted contacts using WAPOST?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseFive" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST comes with a blacklist management feature that allows you to manage
                                        blacklisted contacts easily. You can add, edit, and delete blacklisted contacts to
                                        ensure that your messages are only sent to the intended recipients.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                            5. Does WAPOST offer a campaign builder?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseSix" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST comes with a campaign builder that allows you to create custom campaigns
                                        quickly and easily. You can add images, videos, and text to your campaigns to make
                                        them more engaging.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSeven">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven">
                                            6. Can I track my messages' performance using WAPOST?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseSeven" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST offers detailed reporting and analytics that allow you to track your
                                        messages' performance. You can see how many messages were delivered, read, and
                                        replied to, as well as other key metrics.
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-header" id="headingEight">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseEight" aria-expanded="false"
                                            aria-controls="collapseEight">
                                            8. Is WAPOST easy to use?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseEight" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST is designed to be user-friendly and easy to use. Its intuitive dashboard and simple navigation make it easy for businesses to manage their WhatsApp campaigns.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingNine">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseNine" aria-expanded="false"
                                            aria-controls="collapseNine">
                                            9. Can I send messages to group contacts using WAPOST?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseNine" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST allows you to send messages to group contacts easily. You can create custom groups and send messages to all members of the group with just a few clicks.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTen">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTen" aria-expanded="false"
                                            aria-controls="collapseTen">
                                            10. Is WAPOST suitable for businesses of all sizes?
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTen" class="collapse" data-bs-parent="#accordionOne">
                                    <div class="card-body">
                                        Yes, WAPOST is designed to be scalable and suitable for businesses of all sizes. Whether you are a small startup or a large enterprise, WAPOST can help you manage your WhatsApp campaigns and reach your target audience more effectively.
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="enquery-form">
                <div class="loginPopup" id="popupForm">
                    <div class="formPopup">
                        <form action="" id="enquiryForm" class="formContainer">
                            <div class="btn-cancel" onclick="closeForm()">X</div>
                            <h6 class="subtitle">Enquiry Form</h6>
                            <p>Use these online inquiry form and get started quickly.</p>
                            <div class="success-message" style="display:none;">
                                <p class="success-message-text alert alert-success mt-2"></p>
                            </div> 
                            <div class="form-element">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Full Name" required 
                                            value="@auth{{Auth::user()->first_name .' '.Auth::user()->last_name}}@endauth">
                                        <span class="has-error name-has-error"></span>  
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" name="email" id="email" placeholder="E-mail Address" required
                                        value="@auth{{Auth::user()->email}}@endauth">
                                        <span class="has-error email-has-error"></span>  
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="tel" name="mobile" id="mobile" placeholder="Phone number" required=""  maxlength="12"
                                        value="@auth{{Auth::user()->customer ? Auth::user()->customer->phone : ''}}@endauth">
                                        <span class="has-error mobile-has-error"></span>  
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" name="message" id="message" placeholder="Message" required></textarea>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-button mt-3">
                                             <button id="submit" type="submit" class="btn btn-common btn-active">Send Enquiry</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="form-button mt-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Faq Section Area End Here
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection
@section('page-script')

@endsection
