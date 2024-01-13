@extends('layouts.website')
@section('title', __('Unlimited Bulk WhatsApp at lowest Price in India - WAPost'))
@section('meta-title', __('Unlimited Bulk WhatsApp at lowest Price in India - WAPost'))
@section('meta-description', __('Get Bulk WhatsApp Messages at lowest prices in India. Choose cost-effective solutions for efficient messaging campaigns. Get started today with WAPost!'))
@section('canonical', __('https://wapost.net/pricing'))
{{-- @section('meta-keywords', __('')) --}}

@section('content')

    <!-- pricing page start here  -->
    <div class="price-page-area-wrapper single-page-section-top-space">
        <!-- pricing area start here  -->
        <section class="price-section-area section-top-space section-bottom-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="theme-section-title desktop-center text-center">
                            <h1 class="title">Plans That Fit Your Business Needs
                                <svg class="title-shape active" width="355" height="15" viewBox="0 0 355 15"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="path"
                                        d="M351.66 12.6362C187.865 -6.32755 49.6478 6.37132 3.41142 12.6362"
                                        stroke="#08828c" stroke-width="3" stroke-linecap="square"></path>
                                    <path class="path" d="M351.66 13C187.865 -5.96378 49.6478 6.73509 3.41142 13"
                                        stroke="#08828c" stroke-width="3" stroke-linecap="square"></path>
                                    <path class="path" d="M2.5 5.5C168.5 2.0001 280.5 -1.49994 352.5 8.49985"
                                        stroke="#FFC44E" stroke-width="3" stroke-linecap="square"></path>
                                </svg>
                            </h1>
                        </div>
                        <h4 class="mb-3">Choose a plan that aligns with your business requirements.</h4>
                        <ul>
                            <li style="display:inline-block;padding:10px;"><i class="fa-solid fa-circle-check" style="color: #2A757E;"></i> Reliable Message Delivery</li>
                            <li style="display:inline-block;padding:10px;"><i class="fa-solid fa-circle-check" style="color: #2A757E;"></i> User-Friendly Features</li>
                            <li style="display:inline-block;padding:10px;"><i class="fa-solid fa-circle-check" style="color: #2A757E;"></i> Full Control - No Restriction and No Ban!</li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    @if (in_array(1, $plans))
                        <div class="col-lg-4 col-md-12">
                            <div class="price-inner-box">
                                <div class="btn-wrap btn-left">
                                    <h4 class="head-common">Wa Post Free</h4>
                                </div>
                                <p>Get started with our most affordable plan and enjoy all the <br> essential features you
                                    need to get your business up and running.</p>
                                <h5>Free<span class="price">for lifetime</span></h5>
                                <h6>Feature You'll Love</h6>
                                <ul>
                                    <li>One connect WhatsApp with QR scanner</li>
                                    <li>Contact Management</li>
                                    <li>Blacklist Management</li>
                                    <li>Custom WhatsApp Manager</li>
                                    <li>Message Campaign Builder</li>
                                    <li>Custom Analytics & Reports</li>
                                    <li>Limited Message Speed - 1 message per 10 minutes</li>
                                </ul>
                                <div class="btn-wrap-right">
                                    <a href="{{ url('register') }}" class="btn-common flat-btn btn-active">Get Started</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="@if (in_array(1, $plans)) col-lg-4 @else col-lg-5 @endif col-md-12">
                        <div class="price-inner-box price-inner-right">
                            <div class="btn-wrap btn-right">
                                <h4 class="head-common">WA Post Starter Pack</h4>
                            </div>
                            <p><b>Billed Monthly</b></p>
                            <p>Ideal for businesses that are starting or have just started bulk WhatsApp messaging</p>
                            <p>Reach more people than ever and pay gradually with WA Post.</p>
                            <h5>Rs 249/-<span class="price">Per Month</span></h5>
                            <h6>Every plan includes:</h6>
                            <ul>
                                <li>One Connect WhatsApp with a QR scanner</li>
                                <li>Contact Management</li>
                                <li>Blacklist Management</li>
                                <li>Custom WhatsApp Manager</li>
                                <li>Message Campaign Builder</li>
                                <li>Custom Analytics & Reports</li>
                                <li>Unlimited Message Speed</li>
                            </ul>
                            <div class="btn-wrap-right">
                                <a href="{{ url('register?plan_id=2') }}" class="btn-common flat-btn btn-active">Get
                                    Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="@if (in_array(1, $plans)) col-lg-4 @else col-lg-5 @endif col-md-12">
                        <div class="price-inner-box price-inner-right">
                            <div class="popular-tag h6">Save 16.50% with the Annual Plan</div>
                            <div class="btn-wrap btn-right">
                                <h4 class="head-common">WA Post Super Saver Pack</h4>
                            </div>
                            <p><b>Billed Annually</b></p>
                            <p>Ideal for businesses looking for long-term bulk WhatsApp messaging Keep reaching thousands with the snap of your fingers.</p>
                            <p>More Connections = More Business Send unlimited bulk messages throughout the year, while playing only once.</p>
                            <span><h6 style="float:left;margin:0 5px 0 0;line-height:40px"><del>Rs 2988</del><h6><h5>Rs 2490/-<span class="price">Per Year</span></h5></span>
                            <h6>Feature You'll Love</h6>
                            <ul>
                                <li>One connect WhatsApp with QR scanner</li>
                                <li>Contact Management</li>
                                <li>Blacklist Management</li>
                                <li>Custom WhatsApp Manager</li>
                                <li>Message Campaign Builder</li>
                                <li>Custom Analytics & Reports</li>
                                <li>Unlimited Message Speed</li>
                            </ul>
                            <div class="btn-wrap-right">
                                <a href="{{ url('register?plan_id=3') }}" class="btn-common flat-btn btn-active">Get
                                    Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                                1. Can I upgrade from a monthly plan to an annual plan?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            Yes, you can upgrade your plan anytime!
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="false"
                                                aria-controls="collapseOne">
                                                2. Can I cancel my plan anytime?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                        While you can’t manually cancel your plan, your plan automatically gets canceled when it ends. You will not be charged after your plan ends. You’ll need to subscribe to the plan again to continue.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                3. Will I get a refund if I no longer want to use WA Post?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                        We are sorry to see you unhappy. Although we don’t offer refunds, we would be happy to help make the most of your WA Post subscription. Do reach out to us. Our team will be happy to help.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFour">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseFour" aria-expanded="false"
                                                aria-controls="collapseFour">
                                                4. What payment methods do you accept?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseFour" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            You can pay using UPI, Net Banking, Debit Card, and Credit Card.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingFive">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseFive" aria-expanded="false"
                                                aria-controls="collapseFive">
                                                5. How many messages can I send at once?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseFive" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            You can send unlimited messages with WA Post
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingSix">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSix" aria-expanded="false"
                                                aria-controls="collapseSix">
                                                6. Can I send multimedia messages, such as images, videos, audio, or some documents?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseSix" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            Yes, you can send anything and everything you like from images, videos, and audio to documents and contacts!
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingSeven">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSeven" aria-expanded="false"
                                                aria-controls="collapseSeven">
                                                7. Will WhatsApp ban me if I send bulk messages?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseSeven" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            WhatsApp won’t block you upon sending bulk messages. However, you might get banned if you spam people. There are always ways to go about it.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingEight">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseEight" aria-expanded="false"
                                                aria-controls="collapseEight">
                                                8. How can I send bulk messages without getting banned?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseEight" class="collapse" data-bs-parent="#accordionOne">
                                        <div class="card-body">
                                            WA Post Bulk WhatsApp Sender allows you to easily communicate with people who are already expecting to receive your messages. It is not a tool for spamming. Hence, it should not get banned. 
                                            <p><b>Here’s how you can send bulk WhatsApp messages without getting banned:</b></p>
                                            <ol>
                                                <li>Use multiple WhatsApp accounts. Try sending bulk messages from a different account to see how the strategies are working for you and what mistakes to avoid in the future.</li>
                                                <li>Get your number saved by the people you wish to send your messages to.</li>
                                                <li>Join different WhatsApp Groups and engage with people there. It will help give you more credibility.</li>
                                                <li>Start by sending bulk messages to a small group of people. Increase the number gradually.</li>
                                                <li>Write your messages from the receiver’s point of view. Sending too many promotional messages too frequently will make people frustrated and they might mark you as spam.</li>
                                                <li>Chat with your friends and family through the number you’ll be sending the bulk messages from.</li>
                                                <li>Keep changing your mobile IP dynamically by putting your phone on flight mode or aeroplane mode.</li>
                                                <li>Use variations of the same messages for different sets of people.</li>
                                                <li>Send messages to only opt-in users.</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card">
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
                                </div> -->
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
        <!-- pricing area end here  -->
    </div>
    <!-- pricing page end here  -->

@endsection