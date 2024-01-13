@extends('layouts.website')

@section('title', __('Contact Us | WhatsApp Bulk Message Sender | WAPost '))

@section('meta-title', __('Contact Us | WhatsApp Bulk Message Sender | WAPost '))

@section('meta-description',
    __('Contact Us for all your WhatsApp bulk message sender needs. Reach out to our experts and get assistance with your messaging campaigns. Connect with WAPost today!'))
@section('canonical', __('https://wapost.net/contact-us'))
    {{-- @section('meta-keywords', __('')) --}}

@section('content')
    <!-- contact us page start here  -->

    <div class="contact-us-wrapper single-page-section-top-space single-page-section-bottom-space">
        <!-- breadcrumb area start here  -->
        <div class="breadcrumb-wrap section-top-space style-01">
            <div class="container custom-container-01">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-content">
                            <h1 class="title">Contact Us</h1>
                            <p class="details">We are excited to hear from you and are always here to answer any questions or
                                concerns you may have. We are here to help / assist. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end here  -->

        <!-- contact form start hare  -->
        <section class="contact-form-area-wrapper section-bottom-space">
            <div class="container custom-container-01">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="apply-form-inner">
                            <div class="row justify-content-between">
                                <div class="col-lg-5">
                                    <div class="contact-address">
                                        <h3 class="title">Get in touch</h3>
                                        <ul class="ul contact-address-list">
                                            <li class="single-address-item">
                                                <span class="icon-wrap color-01">
                                                    <i class="fa-sharp fa-solid fa-location-dot icon"></i>
                                                </span>
                                                <span class="text">Creative Networks,<br> Maharashtra.
                                                </span>
                                            </li>
                                            <li class="single-address-item">
                                                <span class="icon-wrap color-02">
                                                    <i class="fa-solid fa-phone icon"></i>
                                                </span>
                                                <span class="text">Phone Number:<br>
                                                    <a href="tel:+91 8010779567" class="contact-link"> +91
                                                        8010779567</a>
                                                </span>
                                            </li>
                                            <li class="single-address-item">
                                                <span class="icon-wrap color-03">
                                                    <i class="fa-solid fa-envelope-open icon"></i>
                                                </span>
                                                <span class="text">Email ID : <br> <a href="mailto:care@wapost.net"
                                                        class="contact-link">care@wapost.net</a> </span>
                                            </li>
                                        </ul>

                                        <ul class="ul social-media-list style-01 color-02">
                                            <li class="single-social-item">
                                                <a href="https://www.instagram.com/wapostindia/" tabindex="-1"
                                                    target="_blank"><i class="fa-brands fa-instagram icon"></i>
                                                </a>
                                            </li>
                                            <li class="single-social-item">
                                                <a href="https://www.facebook.com/wapostindia" tabindex="-1"
                                                    target="_blank">
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
                                <div class="col-lg-7">
                                    <div class="success-message" style="display:none;">
                                        <p class="success-message-text alert alert-success mt-2"></p>
                                    </div>
                                    <div class="contact-form">
                                        <form class="form validationforms" id="contactForm">
                                            <div class="part">
                                                <h5 class="title">Primary Information</h5>
                                                <div class="form-element">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <i class="fa-solid fa-user"></i>
                                                            <input type="text" name="name" id="name"
                                                                placeholder="Full name" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-element">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <i class="fa-solid fa-phone"></i>
                                                            <input type="tel" name="mobile" id="mobile"
                                                                placeholder="Phone number" required="" maxlength="12">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <i class="fa-solid fa-envelope-open"></i>
                                                            <input type="email" name="email" id="email"
                                                                placeholder="Email address" required="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-element">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <textarea class="textarea" name="message" id="message" placeholder="Write description..." rows="10" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-submit text-right">
                                                <button type="submit" id="contactBtn" class="btn-common btn-active">submit
                                                    Message </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact form end hare  -->
    </div>
@endsection
@section('page-script')
@endsection
