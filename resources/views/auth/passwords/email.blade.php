@php
    $configData = Helper::applClasses();
@endphp

@extends('layouts.website')

@section('title', __('locale.auth.forgot_password'))

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
                            @if ($configData['theme'] === 'dark')
                                <img class="img-fluid" src="{{ asset('images/pages/forgot-password-v2-dark.svg') }}"
                                    alt="{{ config('app.name') }}" />
                            @else
                                <img class="img-fluid" src="{{ asset('images/pages/forgot-password-v2.svg') }}"
                                    alt="{{ config('app.name') }}" />
                            @endif
                        </div>
                    </div>
                    <!-- /Left Text-->

                    <!-- Forgot password-->
                    <div class="d-flex col-lg-4 align-items-center bg-white px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            @if (Session::get('status') == 'success')
                                <div class="alert alert-block alert-success">
                                    {{ Session::get('message') }}
                                </div>
                            @endif

                            @if (Session::get('status') == 'error')
                                <div class="alert alert-block alert-danger">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <h1 class="h2 card-title mb-3">{{ __('locale.auth.recover_your_password') }}</h1>
                            <p class="card-text my-4">{{ __('locale.auth.recover_password_instructions') }}</p>
                            <form class="auth-forgot-password-form mt-2 validationforms" method="POST"
                                action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('locale.labels.email') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="{{ __('locale.labels.email') }}" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                @if (config('no-captcha.login'))
                                    <div class="mb-3">
                                        {{ no_captcha()->input('g-recaptcha-response') }}
                                    </div>
                                @endif

                                <button type="submit"
                                    class="btn btn-primary w-100 waves-effect waves-float waves-light btn-common flat-btn btn-active"
                                    tabindex="2">{{ __('locale.auth.recover_password') }}</button>
                            </form>
                            <p class="text-center mt-5 mb-3">
                                <a href="{{ url('login') }}" class="text-primary">
                                    <i class="fa-solid fa-angle-left"></i> {{ __('locale.auth.back_to_login') }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- /Forgot password-->
                </div>
            </div>
        </div>
    </div>
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
