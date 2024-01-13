<div class="footer-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="footer-widget widget widget_subscribe">
                    <div class="subscibe-wrapper">
                        <div class="content-wrap text-center">
                            <div class="content">
                                <h4 class="title mb-4">Experience The Ultimate WhatsApp Marketing with WAPOST </h4>
                                <div class="btn-wrap-unlock">
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
            </div>
        </div>
        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-headline">Important Links</h4>
                        <ul class="mb-5">
                            {{-- <li><a href="{{ route('about_us') }}">About Us</a></li> --}}
                            <li><a href="{{ route('terms_condition') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                        </ul>
                        <a href="{{ URL::to('become-a-partner') }}" id="becomePartner">Become a partner</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-headline">Site Highlight</h4>
                        <ul>
                            {{-- <li><a href="#">Free Demo</a></li> --}}
                            <li><a href="{{ route('blog') }}">Blogs</a></li>
                            <li><a href="{{ route('documentation.dashboard') }}">Documentation</a></li>
                            {{-- <li><a href="#">FAQ</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="footer-widget widget widget_nav_menu">
                        <h4 class="widget-headline">Registered Address</h4>
                        <ul class="contact_info_list">
                            <li class="single-info-item">
                                <div class="icon">
                                    <img src="{{asset('website/img/icon/location-02.png')}}" alt="">
                                </div>
                                <div class="details">
                                    Creative Networks,<br /> Maharashtra.
                                </div>
                            </li>
                        </ul>

                        <h4 class="widget-headline mt-4">Social Links</h4>
                        <ul class="ul social-media-list foot-social style-01 color-02">
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
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    
                    <hr>
                    <p style="text-align:center;">Powered by <a href="#">Creative Networks</a></p>
                </div>
            </div>
        </div>
    </div>
</div>