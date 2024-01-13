<div class="nav-area-wrapper-relative">
    <nav class="navbar navbar-area navbar-expand-lg navigation-style-02">
        <div class="container custom-container custom-container-01">
            <div class="responsive-menu">
                <div class="logo-wrapper">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('website/img/logo/logo-horizontal-black.svg') }}" alt=""
                            class="main-logo">
                    </a>
                </div>
                <button class="navbar-toggler navbar-bs-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#themeim_main_menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="themeim_main_menu">
                <ul class="navbar-nav">
                    <li class="{{ Request::is('features') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('features') }}">Features</a>
                    </li>

                    <li class="{{ Request::is('pricing') ? 'current-menu-item' : '' }}">
                        @if (Auth::user() && !Auth::user()->is_admin && !Auth::user()->customer->subscription)
                            <a
                                href="{{ URL::to('subscriptions') }}">Pricing</a>
                        @elseif (Auth::user() && !Auth::user()->is_admin && Auth::user()->customer->subscription)
                            <a
                                href="{{ URL::to('subscriptions/' . Auth::user()->customer->subscription->uid . '/change-plan') }}">Pricing</a>
                        @else
                            <a href="{{ route('pricing') }}">Pricing</a>
                        @endif
                    </li>

                    
                    {{-- <li class="{{ Request::is('about-us') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('about_us') }}">About Us</a>
                    </li>
                    <li class="{{ Request::is('documentation.dashboard') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('documentation.dashboard') }}">Documentation</a>
                    </li> --}}

                    {{-- <li class="menu-item-has-children">
                        <a href="#">Resources</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('blog') }}">Blogs & Articles</a></li>
                            <li><a href="{{ route('documentation.dashboard') }}">Documentation</a></li>
                        </ul>
                    </li> --}}
                    <li class="{{ Request::is('contact-us') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('contact_us') }}">Contact Us</a>
                    </li>
                    <li class="{{ Request::is('become-a-partner') ? 'current-menu-item' : '' }}">
                        <a href="{{ URL::to('become-a-partner') }}" id="becomePartner">Become a partner</a>
                    </li>
                    {{-- <li class="{{ Request::is('blogs') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('blog') }}">Blogs</a>
                    </li> --}}
                    <li class="btn-wrap d-block d-lg-none">
                        <a href="{{ route('login') }}" >Login</a>
                    </li>
                    <li class="btn-wrap d-block d-lg-none">
                        <a href="{{ route('pricing') }}" >Register</a>
                    </li>
                </ul>
            </div>
            <div class="nav-right-content">
                <div class="icon-part">
                    <ul>
                        @auth
                            <li class="btn-wrap">
                                @if (Auth::user()->active_portal == 'admin' && Auth::user()->is_admin == 1)
                                    <a href="{{ route('admin.home') }}" class="btn px-3 btn-common nav-btn hp"> Dashboard</a>
                                @else
                                    <a href="{{ route('user.home') }}" class="btn px-3 btn-common nav-btn hpp"> Dashboard</a>
                                @endif
                            </li>
                        @else
                            <li class="btn-wrap">
                                <a href="{{ route('login') }}" class="login-btnx btn-common nav-btn">Login</a>
                                <a href="{{ url('pricing') }}" class="registr-btnx btn-common nav-btn">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
                {{-- <div class="btn-wrap">
                    <a href="#" class="btn-common nav-btn">Free Demo</a>
                </div> --}}
            </div>
        </div>
    </nav>
</div>
