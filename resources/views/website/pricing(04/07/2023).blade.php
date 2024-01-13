@extends('layouts.website')
@section('title', __('Bulk WhatsApp Sender Price in India - WAPOST'))
@section('meta-title', __('Bulk WhatsApp Sender Price in India - WAPOST'))
@section('meta-description', __('Check out Bulk WhatsApp sender price in India, send unlimited whatsapp messages, Get
    started today with our affordable plans and start growing NOW!'))
@section('canonical', __('https://wapost.net/pricing'))
{{-- @section('meta-keywords', __('')) --}}

@section('content')

    <!-- pricing page start here  -->
    <div class="price-page-area-wrapper single-page-section-top-space single-page-section-bottom-space">
        <!-- pricing area start here  -->
        <section class="price-section-area section-top-space section-bottom-space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="theme-section-title desktop-center text-center">
                            <h1 class="title">WhatsApp Sender Pricing in India
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
                    </div>
                </div>
                <div class="row justify-content-center">
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
                                <h4 class="head-common">Wa Post Monthly</h4>
                            </div>
                            <p>Take your business to the next level with our Pro Plan, offering advanced <br> features and
                                unlimited support to help you grow your business faster.</p>
                            <h5>Rs 449/-<span class="price">Per Month</span></h5>
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
                                <a href="{{ url('register?plan_id=2') }}" class="btn-common flat-btn btn-active">Get
                                    Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="@if (in_array(1, $plans)) col-lg-4 @else col-lg-5 @endif col-md-12">
                        <div class="price-inner-box price-inner-right">
                            <div class="popular-tag">Save 24%</div>
                            <div class="btn-wrap btn-right">
                                <h4 class="head-common">Wa Post Yearly</h4>
                            </div>
                            <p>Take your business to the next level with our Pro Plan, offering advanced <br> features and
                                unlimited support to help you grow your business faster.</p>
                            <h5>Rs 4499/-<span class="price">Per Year</span></h5>
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
        <!-- pricing area end here  -->
    </div>
    <!-- pricing page end here  -->

@endsection
