@php
    $configData = Helper::applClasses();
@endphp
@php
    use Illuminate\Support\Facades\Request;
    if (Request::has('tab')) {
        if (Request::get('tab') == 'register') {
            $tab = 'register';
        } else {
            $tab = '';
        }
    } else {
        $tab = '';
    }
@endphp
@extends('layouts.website')
@section('title', __('locale.auth.login'))
@section('canonical', __('https://wapost.net/login'))
@section('page-style')
    {{-- Page Css files --}}
    {{-- <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}"> --}}
@endsection

@section('content')
    <style>
        .required:after {
            content: " *";
            color: red;
        }

        label.error,
        label.valid {
            color: red !important;
        }
        .login-form-sec .h2.card-title {
            font-size: 26px;
            color: var(--heading-color);
            margin-top: 0;
            display: inline-block;
            font-family: var(--heading-font);
            text-transform: capitalize;
            font-weight: 500;
            line-height: 36px;
        }
        .login-form-sec .iti.iti--separate-dial-code {
            display: none;
        }
    </style>
    <!-- login page start here  -->
    <div class="login-page-area-wrapper single-page-section-top-space">
        <!-- login area start here  -->
        <div class="login-page-area section-top-space">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-lg-8 col-md-6 login-left-img p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-1 px-lg-5">
                            <!-- <img src="{{ asset('images/pages/login-v2-dark.svg') }}" alt="login-img"> -->
                            @if ($configData['theme'] === 'dark')
                                <img src="{{ asset('images/pages/login-v2-dark.svg') }}" alt="{{ config('app.name') }}" />
                            @else
                                <img src="{{ asset('images/pages/login-v2.svg') }}" alt="{{ config('app.name') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 login-form-sec bg-white d-flex align-items-center p-0">
                        <div class="signinoutTab px-4 py-4 p-lg-5">

                            <!-- Login Form  -->
                            <div class="signForm pt-5" id="__login_form__">
                                <div class="login-form mx-auto">
                                    <h1 class="h2 card-title mb-3">{{ __('locale.labels.welcome_to') }}
                                        {{ config('app.name') }}</h1>
                                    <p class="card-text mb-3 paragraph">{{ __('locale.auth.welcome_message') }}</p>

                                    @if (Session::get('status') == 'error')
                                        <div class="alert alert-block alert-danger">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif

                                    @if (Session::get('status') == 'success')
                                        <div class="alert alert-block alert-success">
                                            {{ Session::get('message') }}
                                        </div>
                                    @endif

                                    @if (config('app.stage') == 'demo')
                                        <div class="d-flex justify-content-between" style="cursor: pointer;">
                                            <span class="text-primary admin-login">Admin Login</span>
                                            <span class="text-success pull-right client-login">Client Login</span>
                                        </div>
                                    @endif

                                    <form class="validationforms auth-login-form mt-2" method="POST"
                                        action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label required"
                                                for="username">{{ __('locale.labels.email') }} /
                                                {{ __('locale.labels.phone') }}</label>
                                            <input type="hidden" id="phone"
                                                class="form-control"
                                                name="phone"
                                                placeholder="{{ __('locale.labels.phone') }}"
                                                value="">
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                placeholder="{{ __('locale.labels.username') }}"
                                                value="{{ old('username') }}" required autocomplete="username" autofocus>
                                            <label id="username-error" class="error valid" for="username"></label>
                                            @error('username')
                                                <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                    <div class="alert-body d-flex align-items-center">
                                                        <i data-feather="info" class="me-50"></i>
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                </div>
                                            @enderror

                                            @error('g-recaptcha-response')
                                                <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
                                                    <div class="alert-body d-flex align-items-center">
                                                        <i data-feather="info" class="me-50"></i>
                                                        <span>{{ __('locale.labels.g-recaptcha-response') }}</span>
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label class="form-label required"
                                                    for="password">{{ __('locale.labels.password') }}</label>
                                                <!-- <a href="#"><small>Forgot Password?</small></a> -->
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="forgot-link">
                                                        <small>{{ __('locale.auth.forgot_password') }}?</small>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <!-- <input id="password" type="password" class="form-control" name="password" placeholder="Password" required="" autocomplete="password"> -->
                                                <input id="password" type="password" class="form-control" name="password"
                                                    placeholder="{{ __('locale.labels.password') }}" required
                                                    autocomplete="password"
                                                    @if (config('app.stage') == 'demo') value="12345678" @endif>
                                                    <span onclick="toggle_pass()" class="field_icon cursor-pointer"><i class="fa fa-fw fa-eye"></i></span>
                                            </div>
                                            <label id="password-error" class="error" for="password"></label>
                                        </div>
                                        @if (config('no-captcha.login'))
                                            <div class="mb-1">
                                                {{ no_captcha()->input('g-recaptcha-response') }}
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <!-- <input class="form-check-input" name="remember" id="remember-me" type="checkbox" tabindex="3">
                                                                                <label class="form-check-label m-0" for="remember-me"> Remember Me</label> -->
                                                <input class="form-check-input" {{ old('remember') ? 'checked' : '' }}
                                                    name="remember" id="remember-me" type="checkbox" tabindex="3" />
                                                <label class="form-check-label m-0" for="remember-me">
                                                    {{ __('locale.auth.remember_me') }}</label>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary w-100 waves-effect waves-float waves-light btn-common flat-btn btn-active"
                                            tabindex="4">{{ __('locale.auth.login') }}</button>
                                    </form>
                                    @if (config('account.can_register'))
                                        <p class="text-center mt-5">
                                            <span>{{ __('locale.auth.new_on_our_platform') }}?</span>
                                            <a
                                                href="{{ url('register') }}"><span>&nbsp;{{ __('locale.auth.register') }}</span></a>
                                        </p>
                                    @endif
                                    @if (config('services.facebook.active') ||
                                            config('services.twitter.active') ||
                                            config('services.google.active') ||
                                            config('services.github.active'))
                                        <div class="divider my-2">
                                            <div class="divider-text">{{ __('locale.auth.or') }}</div>
                                        </div>

                                        <div class="auth-footer-btn d-flex justify-content-center">

                                            @if (config('services.facebook.active'))
                                                <a class="btn btn-facebook"
                                                    href="{{ route('social.login', 'facebook') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
                                                    <i data-feather="facebook"></i>
                                                </a>
                                            @endif

                                            @if (config('services.twitter.active'))
                                                <a class="btn btn-twitter" href="{{ route('social.login', 'twitter') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter">
                                                    <i data-feather="twitter"></i>
                                                </a>
                                            @endif

                                            @if (config('services.google.active'))
                                                <a class="btn btn-google" href="{{ route('social.login', 'google') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Google">
                                                    <i data-feather="mail"></i>
                                                </a>
                                            @endif

                                            @if (config('services.github.active'))
                                                <a class="btn btn-github" href="{{ route('social.login', 'github') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Github">
                                                    <i data-feather="github"></i>
                                                </a>
                                            @endif

                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
            </div>
            
            <script type="text/javascript">
                function toggle_pass() {
                    var x = document.getElementById("password");
                    var icon = document.querySelector(".cursor-pointer i");

                    if (x.type === "password") {
                        x.type = "text";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    } else {
                        x.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                }
            </script>
        @endsection

        @if (config('no-captcha.login'))
            @push('scripts')
                {{ no_captcha()->script() }}
                {{ no_captcha()->getApiScript() }}

                <script>
                    grecaptcha.ready(() => {
                        window.noCaptcha.render('login', (token) => {
                            document.querySelector('#g-recaptcha-response').value = token;
                        });
                    });
                </script>
            @endpush
        @endif

        @push('scripts')
            <script>
                $('.admin-login').on('click', function() {
                    $('#email').val('admin@codeglen.com')
                });

                $('.client-login').on('click', function() {
                    $('#email').val('client@codeglen.com')
                });
                
            </script>
        @endpush
