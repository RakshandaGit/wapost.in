@php
    $configData = Helper::applClasses();
@endphp

@extends('layouts.website')

@section('title', __('locale.auth.password_reset'))
@section('canonical', __('https://wapost.net/password/reset'))
@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <style>
        .h2.card-title{
            font-size: 36px;
            line-height: 1.4444444444;
        }
    </style>
    <div class="auth-wrapper auth-cover section-top-space">
        <div class="auth-inner section-top-space">
            <div class="container custom-container">
                <div class="row m-0">
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                            @if($configData['theme'] === 'dark')
                                <img src="{{asset('images/pages/reset-password-v2-dark.svg')}}" class="img-fluid" alt="Register V2"/>
                            @else
                                <img src="{{asset('images/pages/reset-password-v2.svg')}}" class="img-fluid" alt="Register V2"/>
                            @endif
                        </div>
                    </div>
                    <!-- /Left Text-->

                    <!-- Reset password-->
                    <div class="d-flex col-lg-4 align-items-center bg-white px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h1 class="h2 card-title mb-3">{{ __('locale.auth.password_reset') }}</h1>
                            <p class="card-text my-4">{{ __('locale.auth.enter_new_password') }}</p>
                            <form class="auth-reset-password-form mt-2 validationforms" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('locale.labels.email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('locale.labels.email') }}" value="{{ $email ?? old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">{{ __('locale.labels.new_password') }}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input id="password" type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" name="password" placeholder="{{ __('locale.labels.password') }}" required autocomplete="new-password" autofocus tabindex="1">
                                        <span class="input-group-text cursor-pointer" onclick="toggle_pass()"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password-confirm">{{ __('locale.labels.password_confirmation') }}</label>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input id="password-confirm" type="password" class="form-control form-control-merge" name="password_confirmation" placeholder="{{ __('locale.labels.password_confirmation') }}" required autocomplete="new-password">
                                        <span class="input-group-text cursor-pointer" onclick="toggle_confpass()"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                    </div>
                                </div>


                                @if(config('no-captcha.login'))
                                    <div class="mb-3">
                                        {{ no_captcha()->input('g-recaptcha-response') }}
                                    </div>
                                @endif
                                <input type="hidden" name="token" value="{{ $token }}">
                                <button type="submit" class="btn btn-primary w-100 waves-effect waves-float waves-light btn-common flat-btn btn-active" tabindex="3">{{ __('locale.buttons.reset') }}</button>
                            </form>
                            <p class="text-center mt-5 mb-3">
                                <a href="{{url('login')}}" class="text-primary">
                                    <i class="fa-solid fa-angle-left"></i> {{ __('locale.auth.back_to_login') }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Reset password-->
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
            function toggle_pass() {
                var x = document.getElementById("password");
                if (x.type === "password") {
                x.type = "text";
                } else {
                x.type = "password";
                }
            }
            function toggle_confpass() {
                var x = document.getElementById("password-confirm");
                if (x.type === "password") {
                x.type = "text";
                } else {
                x.type = "password";
                }
            }
        </script>
@if(config('no-captcha.login'))
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

