@extends('layouts/website')

@section('title', __('locale.auth.register'))
@section('canonical', __('https://wapost.net/register'))
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

@section('content')
    <style>
        .content-header .h2 {
            color: #5e5873;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 0.5rem;
            margin-top: 0;
            font-size: calc(1.2964rem + .5568vw);
        }
    </style>
    <div class="content-wrapper register-page single-page-section-top-space">
        <div class="content-body section-top-space">
            @php
                if (isset($_GET['plan_id']) && !in_array(1, $activePlansIds)) {
                    $currentPlan = $_GET['plan_id'] != 1 ? $_GET['plan_id'] : 2;
                } elseif (in_array(1, $activePlansIds)) {
                    $currentPlan = isset($_GET['plan_id']) ? $_GET['plan_id'] : 1;
                } else {
                    $currentPlan = isset($_GET['plan_id']) ? $_GET['plan_id'] : 2;
                }
            @endphp
            <div class="container-fluid custom-container custom-container-01">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">

                        <!-- Left Text-->
                        <div class="col-lg-7 d-flex align-items-center auth-bg px-2 px-sm-3 px-lg-5 pt-3 pb-5">
                            <div class="width-700 mx-auto">
                                <div class="bs-stepper register-multi-steps-wizard shadow-none linear">
                                    <div class="bs-stepper-header px-0" role="tablist">
                                        <div class="step active" data-target="#account-details" role="tab"
                                            id="account-details-trigger">
                                            <button type="button" class="step-trigger" aria-selected="true"
                                                disabled="disabled">
                                                <span class="bs-stepper-box">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-home font-medium-3">
                                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                    </svg>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">{{ __('locale.labels.account') }}</span>
                                                    <span
                                                        class="bs-stepper-subtitle">{{ __('locale.auth.enter_credentials') }}</span>
                                                </span>
                                            </button>
                                        </div>


                                        <div class="line">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-chevron-right font-medium-2">
                                                <polyline points="9 18 15 12 9 6"></polyline>
                                            </svg>
                                        </div>
                                        @if ($currentPlan != '1')
                                            <div class="step" data-target="#personal-info" role="tab"
                                                id="personal-info-trigger">
                                                <button type="button" class="step-trigger" aria-selected="false"
                                                    disabled="disabled">
                                                    <span class="bs-stepper-box">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-user font-medium-3">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                    </span>

                                                    <span class="bs-stepper-label">
                                                        <span
                                                            class="bs-stepper-title">{{ __('locale.auth.personal') }}</span>
                                                        <span
                                                            class="bs-stepper-subtitle">{{ __('locale.customer.personal_information') }}</span>
                                                    </span>
                                                </button>
                                            </div>


                                            <div class="line">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-right font-medium-2">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg>
                                            </div>
                                            <div class="step" data-target="#billing" role="tab" id="billing-trigger">
                                                <button type="button" class="step-trigger" aria-selected="false"
                                                    disabled="disabled">
                                                    <span class="bs-stepper-box">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-credit-card font-medium-3">
                                                            <rect x="1" y="4" width="22"
                                                                height="16" rx="2" ry="2"></rect>
                                                            <line x1="1" y1="10" x2="23"
                                                                y2="10"></line>
                                                        </svg>
                                                    </span>

                                                    <span class="bs-stepper-label">
                                                        <span
                                                            class="bs-stepper-title">{{ __('locale.labels.billing') }}</span>
                                                        <span
                                                            class="bs-stepper-subtitle">{{ __('locale.labels.payment_details') }}</span>
                                                    </span>
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="bs-stepper-content px-0 mt-5">
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

                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger" role="alert">
                                                    <div class="alert-body">{{ $error }}</div>
                                                </div>
                                            @endforeach

                                        @endif
                                        @if ($currentPlan != '1')
                                            <form method="POST" action="{{ route('register') }}" id="registration">
                                            @else
                                                <form method="POST" action="{{ route('registerForFreeUsers') }}"
                                                    id="registration">
                                                    {{-- <input type="hidden" name="plans" value="{{ $currentPlan }}">
                                                    <input type="text" id="totalAddonsInput" name="total_addons" value="0"> --}}
                                        @endif
                                        @csrf
                                        <input type="hidden" name="plans" value="{{ $currentPlan }}">
                                        <input type="hidden" id="totalAddonsInput" name="total_addons" value="0">
                                        <input type="hidden" id="totalFrequencyDuration" name="total_frequency_duration"
                                            value="1">
                                        <div id="account-details" class="content get_form_data active dstepper-block"
                                            role="tabpanel" aria-labelledby="account-details-trigger">
                                            <div class="content-header mb-3">
                                                <h1 class="fw-bolder mb-4 h2">{{ __('locale.auth.account_information') }}
                                                </h1>
                                                <span>{{ __('locale.auth.create_new_account') }}</span>
                                            </div>
                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required"
                                                        for="first_name">{{ __('locale.labels.first_name') }}</label>
                                                    <input id="first_name" type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        name="first_name"
                                                        placeholder="{{ __('locale.labels.first_name') }}"
                                                        value="{{ old('first_name') }}" required
                                                        autocomplete="first_name" />
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label"
                                                        for="last_name">{{ __('locale.labels.last_name') }}</label>
                                                    <input id="last_name" type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        name="last_name"
                                                        placeholder="{{ __('locale.labels.last_name') }}"
                                                        value="{{ old('last_name') }}" autocomplete="last_name" />
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required"
                                                        for="phone">{{ __('locale.labels.phone') }}</label>
                                                    <div class="has-icon input">
                                                        <input type="number" id="phone"
                                                            class="form-control required @error('phone') is-invalid @enderror"
                                                            name="phone" required
                                                            placeholder="{{ __('locale.labels.phone') }}"
                                                            value="{{ old('phone') }}" maxlength="10" minlength="10">
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <label id="phone-error" class="error" for="phone"></label>
                                                </div>
                                                <div class="col-md-6 col-12 mb-4">
                                                    <label class="form-label required"
                                                        for="email">{{ __('locale.labels.email') }}</label>
                                                    <input type="email" id="email"
                                                        class="form-control required @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" name="email" required />

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required"
                                                        for="password">{{ __('locale.labels.password') }}</label>
                                                    <div class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" id="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            value="{{ old('password') }}" name="password" required />
                                                        <span onclick="toggle_pass()" class="field_icon cursor-pointer"><i
                                                                class="fa fa-fw fa-eye"></i></span>
                                                    </div>
                                                    <label id="password-error" class="error valid"
                                                        for="password"></label>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required"
                                                        for="password_confirmation">{{ __('locale.labels.password_confirmation') }}</label>
                                                    <div class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" id="password_confirmation"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            value="{{ old('password_confirmation') }}"
                                                            name="password_confirmation" required />
                                                        <span onclick="toggle_confpass()"
                                                            class="field_icon cursor-pointer-toggle"><i
                                                                class="fa fa-fw fa-eye"></i></span>
                                                    </div>
                                                    <label id="password_confirmation-error" class="error"
                                                        for="password_confirmation"></label>
                                                </div>

                                                <div class="mb-1">
                                                    @if (config('no-captcha.registration'))
                                                        <fieldset class="form-label-group position-relative">
                                                            {{ no_captcha()->input('g-recaptcha-response') }}
                                                        </fieldset>
                                                    @endif

                                                    @if (config('no-captcha.registration'))
                                                        @error('g-recaptcha-response')
                                                            <span
                                                                class="text-danger">{{ __('locale.labels.g-recaptcha-response') }}</span>
                                                        @enderror
                                                    @endif
                                                </div>
                                                <p class="mt-3 mb-5 back-btn">
                                                    <a href="{{ route('login') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-chevron-left">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg> {{ __('locale.auth.back_to_login') }}
                                                    </a>
                                                </p>
                                            </div>

                                            @if ($currentPlan != '1')
                                                <div class="d-flex justify-content-between mt-2">
                                                    <button class="btn btn-outline-secondary btn-prev waves-effect"
                                                        disabled="" type="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg>
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                                    </button>
                                                    <button
                                                        class="btn btn-primary btn-next waves-effect waves-float waves-light"
                                                        type="button">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-right align-middle ms-sm-25 ms-0">
                                                            <polyline points="9 18 15 12 9 6"></polyline>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-between mt-2">
                                                    <div></div>
                                                    <button
                                                        class="btn btn-success btn-submit waves-effect waves-float waves-light"
                                                        type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-check align-middle me-sm-25 me-0">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg>
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.buttons.submit') }}</span>
                                                    </button>
                                                </div>
                                            @endif

                                        </div>
                                        <div id="personal-info" class="content get_form_data" role="tabpanel"
                                            aria-labelledby="personal-info-trigger">
                                            <div class="content-header mb-4">
                                                <h2 class="fw-bolder mb-4">
                                                    {{ __('locale.customer.personal_information') }}</h2>
                                                <span>{{ __('locale.auth.create_new_account') }}</span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label"
                                                        for="postcode">{{ __('locale.labels.postcode') }}</label>
                                                    <input type="number" id="postcode"
                                                        class="form-control @error('postcode') is-invalid @enderror"
                                                        name="postcode"
                                                        placeholder="{{ __('locale.labels.postal_code') }}"
                                                        value="{{ old('postcode') }}">
                                                    @error('postcode')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label"
                                                        for="company">{{ __('locale.labels.company') }}</label>
                                                    <input type="text" id="company"
                                                        class="form-control @error('company') is-invalid @enderror"
                                                        name="company" placeholder="{{ __('locale.labels.company') }}"
                                                        value="{{ old('company') }}">
                                                    @error('company')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-4">
                                                    <label class="form-label required"
                                                        for="address">{{ __('locale.labels.address') }}</label>
                                                    <input type="text" id="address"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        name="address" required
                                                        placeholder="{{ __('locale.labels.address') }}"
                                                        value="{{ old('address') }}">
                                                    @error('address')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required"
                                                        for="city">{{ __('locale.labels.city') }}</label>
                                                    <input type="text" id="city"
                                                        class="form-control @error('city') is-invalid @enderror"
                                                        name="city" required
                                                        placeholder="{{ __('locale.labels.city') }}"
                                                        value="{{ old('city') }}">
                                                    @error('city')
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required"
                                                        for="country">{{ __('locale.labels.country') }}</label>
                                                    <div class="position-relative">
                                                        <select class="select2 w-100 select2-hidden-accessible"
                                                            name="country" id="country" required=""
                                                            data-select2-id="country" tabindex="-1" aria-hidden="true">
                                                            @foreach (\App\Helpers\Helper::countries() as $country)
                                                                <option value="{{ $country['name'] }}"
                                                                    {{ config('app.country') == $country['name'] ? 'selected' : null }}>
                                                                    {{ $country['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-5 back-btn">
                                                <a href="{{ route('login') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg> {{ __('locale.auth.back_to_login') }}
                                                </a>
                                            </p>

                                            <div class="d-flex justify-content-between mt-2">
                                                <button
                                                    class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                                </button>
                                                <button
                                                    class="btn btn-primary btn-next secondnext-btn waves-effect waves-float waves-light"
                                                    type="button">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-right align-middle ms-sm-25 ms-0">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div id="billing" class="content get_form_data" role="tabpanel"
                                            aria-labelledby="billing-trigger">
                                            {{-- <div class="content-header mb-5">
                                                <h2 class="fw-bolder mb-4">{{ __('locale.labels.select_plan') }}</h2>
                                                <span>{{ __('locale.plans.select_plan_as_per_requirement') }}</span>
                                            </div>

                                            <!-- select plan options -->
                                            <div class="row custom-options-checkable gx-3 gy-2 pricing-data">
                                                @foreach ($plans as $k => $plan)
                                                    <div class="col-md-4 planPrice" data-value="{{ $plan->price }}"
                                                        id="addonplans{{ $k }}">
                                                        <input class="custom-option-item-check" type="radio"
                                                            name="plans" id="{{ $plan->id }}"
                                                            value="{{ $plan->id }}" required
                                                            @if (isset($_GET['plan_id']) && $_GET['plan_id'] == $plan->id) {!! 'checked' !!} @endif>
                                                        <label class="custom-option-item text-center p-3"
                                                            for="{{ $plan->id }}">
                                                            <span
                                                                class="custom-option-item-title h3 fw-bolder">{{ $plan->name }}</span>
                                                            <span class="d-block m-4">{{ $plan->description }}</span>
                                                            <span class="plan-price">
                                                                <span
                                                                    class="pricing-value fw-bolder text-primary">{{ \App\Library\Tool::format_price($plan->price, $plan->currency->format) }}</span>
                                                                <sub
                                                                    class="pricing-duration text-body font-medium-1 fw-bold">/{{ $plan->displayFrequencyTime() }}</sub>
                                                            </span>
                                                            <hr>
                                                            {{-- <span class="d-block m-3">{{ $plan->displayTotalQuota() }}
                                                            {{ __('locale.labels.whatsapp_credit') }}</span>
                                                        <span class="d-block m-3">
                                                            {{ __('locale.labels.text_messages') }}
                                                            {{ $plan->displayTotalQuota() }}
                                                        </span>
                                                        <span
                                                            class="d-block m-3">{{ __('locale.labels.voice_messages') }}
                                                            {{ $plan->displayTotalQuota() }} </span>
                                                        <span
                                                            class="d-block m-3">{{ __('locale.labels.picture_messages') }}
                                                            {{ $plan->displayTotalQuota() }} </span>
                                                        @if (empty(number_format($plan->price)))
                                                            <span class="d-block m-3">{{ __('Message Queue 10-minute intervals') }}</span>
                                                        @else
                                                            <span
                                                                class="d-block m-3">{{ __('Unlimited Message Speed') }}</span>
                                                        @endif --}}

                                            {{-- @if ($plan->id == 1)
                                                            <span class="d-block m-3">One connect WhatsApp with QR
                                                                scanner</span>
                                                            <span class="d-block m-3">Contact Management</span>
                                                            <span class="d-block m-3">Blacklist Management</span>
                                                            <span class="d-block m-3">Custom WhatsApp Manager</span>
                                                            <span class="d-block m-3">Message Campaign Builder</span>
                                                            <span class="d-block m-3">Custom Analytics & Reports</span>
                                                            <span class="d-block m-3">Limited Message Speed - 1
                                                                message per 10 minutes
                                                            </span>
                                                        @else
                                                            <span class="d-block m-3">One connect WhatsApp with QR
                                                                scanner</span>
                                                            <span class="d-block m-3">Contact Management</span>
                                                            <span class="d-block m-3">Blacklist Management</span>
                                                            <span class="d-block m-3">Custom WhatsApp Manager</span>
                                                            <span class="d-block m-3">Message Campaign Builder</span>
                                                            <span class="d-block m-3">Custom Analytics & Reports</span>
                                                            <span class="d-block m-3">Unlimited Message Speed</span>
                                                        @endif
                                                            <span class="d-block my-2"><b>Connection Addon</b></span>
                                                            <div class="plan-cart-input{{ $k }}">
                                                                <div class="cart_quantity">
                                                                    <input type='button' value='-' class='qtyminus'
                                                                        field='quantity' />
                                                                    <input type='text' name='quantity' value='5'
                                                                        min="1" class='qty' />
                                                                    <input type='button' value='+' class='qtyplus'
                                                                        field='quantity' />
                                                                </div>
                                                                <label id="quantity-error" class="error"
                                                                    for="quantity">Please enter a value greater than or
                                                                    equal to 1.</label>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div> --}}
                                            <!-- / select plan options -->
                                            <div class="hide-for-free">
                                                <div class="content-header my-4 py-1">
                                                    <h2 class="fw-bolder mb-3">{{ __('locale.labels.payment_options') }}
                                                    </h2>
                                                    <span>{{ __('locale.payment_gateways.click_on_correct_option') }}</span>
                                                </div>
                                                <div class="row gx-2">
                                                    <ul class="other-payment-options list-unstyled">
                                                        @foreach ($payment_methods as $method)
                                                            <li>
                                                                <div class="form-check mt-1">
                                                                    <input type="radio" name="payment_methods"
                                                                        class="form-check-input"
                                                                        value="{{ $method->type }}" required>
                                                                    <label
                                                                        class="form-check-label">{{ $method->name }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <label id="payment_methods-error" class="error"
                                                        for="payment_methods">This field is required.</label>
                                                </div>
                                            </div>
                                            <p class="mt-2 mb-3 back-btn">
                                                <a href="{{ route('login') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg> {{ __('locale.auth.back_to_login') }}
                                                </a>
                                            </p>
                                            <div class="d-flex justify-content-between mt-1">
                                                <button
                                                    class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                                </button>
                                                <button
                                                    class="btn btn-success btn-submit waves-effect waves-float waves-light"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-check align-middle me-sm-25 me-0 d-md-none d-block">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">{{ __('locale.buttons.checkout') }}</span>
                                                </button>
                                            </div>

                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /Left Text-->
                        <div class="col-lg-5">
                            <div class="addonbox mb-4">
                                <span class="order-sum text-blue">Order Summary</span>
                                <div class="order-cont d-md-flex d-block align-items-end justify-content-between">
                                    <div>
                                        <h2>{{ $plan->name }}</h2>
                                        <p class="text-blue rsdata">
                                            Rs.{{ $plan->price }} /
                                            <span> {{ $plan->frequency_unit }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <div class="dropdown month-dropdown">
                                            <select id="frequencyOpt" onchange="onChangeFrequency(this)">
                                                @if ($plan->frequency_unit == 'month')
                                                    <option value="1">1 Month</option>
                                                    <option value="3">3 Months</option>
                                                    <option value="6">6 Months</option>
                                                    <option value="9">9 Months</option>
                                                @else
                                                    <option value="1">1 Year</option>
                                                    <option value="2">2 Years</option>
                                                    <option value="3">3 Years</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="addonconnection d-md-flex d-block align-items-center justify-content-between">
                                    <div class="addon-data">
                                        <h2 class="text-blue">Add On Connections</h2>
                                        <p>Subscription plan already have one connection</p>
                                    </div>
                                    <div class="addon-cart">
                                        <p class="mb-1">1 x Rs.{{ $plan->connection_addons_price }}</p>
                                        <div class="addon-cart-input">
                                            <div class="addoncart_quantity">
                                                <input type='button' value='-' class='addonqtyminus'
                                                    field='quantity' onclick="onChangeAddonQty('-')" />
                                                <input type='text' name='addonquantity' value='0' min="0"
                                                    class='qty' id="addonquantity" />
                                                <input type='button' value='+' class='addonqtyplus'
                                                    field='quantity' onclick="onChangeAddonQty('+')" />
                                            </div>
                                            <label id="addonquantity-error" class="error" for="quantity"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addon-total">
                                <p class="list-total">
                                    <span>Total</span>
                                    <span id="totalPlanPrice">Rs.{{ $plan->price }}/-</span>
                                </p>
                                <p class="list-total">
                                    <span>Addon Amount</span>
                                    <span id="totalAddonAmount">Rs.0/-</span>
                                </p>
                                <p class="list-total">
                                    <span class="text-blue">Total Payable Amount</span>
                                    <span id="totalPayableAmount">Rs.{{ $plan->price }}/-</span>
                                </p>
                            </div>
                        </div>
                        <!-- Register-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

    <script>
        let isRtl = $('html').attr('data-textdirection') === 'rtl';
    </script>

    <script>
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

        function toggle_confpass() {
            var x = document.getElementById("password_confirmation");
            var icon = document.querySelector(".cursor-pointer-toggle i");

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

        function onChangeAddonQty(type) {
            var addonQty = parseInt($("#addonquantity").val())
            if (type == "+" && addonQty == 0) {
                addonQty = 1
            }

            if (addonQty > 0) {
                if (type == "-") {
                    addonQty = parseInt($("#addonquantity").val()) - parseInt(1);
                } else {
                    addonQty = parseInt($("#addonquantity").val()) + parseInt(1);
                }

                var planPrice = parseFloat("{{ $plan->price }}");
                var addonsPrice = parseFloat("{{ $plan->connection_addons_price }}");
                var frequencyVal = parseInt($("#frequencyOpt").val());

                var totalPlanPrice = (planPrice * frequencyVal).toFixed(2);
                var totalAddonAmount = ((addonQty * addonsPrice) * frequencyVal).toFixed(2)
                var totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount)).toFixed(2);

                $("#totalPlanPrice").text(`Rs.${totalPlanPrice}/-`);
                $("#totalAddonAmount").text(`Rs.${totalAddonAmount}/-`);
                $("#totalPayableAmount").text(`Rs.${totalPayableAmount}/-`);
                $("#totalAddonsInput").val(addonQty);
            }
        }

        function onChangeFrequency(that) {
            var planPrice = parseFloat("{{ $plan->price }}");
            var addonsPrice = parseFloat("{{ $plan->connection_addons_price }}");
            var frequencyVal = parseInt($(that).val());
            var addonQty = parseInt($("#addonquantity").val());

            var totalPlanPrice = (planPrice * frequencyVal).toFixed(2);
            var totalAddonAmount = ((addonQty * addonsPrice) * frequencyVal).toFixed(2);
            var totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount)).toFixed(2);

            $("#totalPlanPrice").text(`Rs.${totalPlanPrice}/-`);
            $("#totalAddonAmount").text(`Rs.${totalAddonAmount}/-`);
            $("#totalPayableAmount").text(`Rs.${totalPayableAmount}/-`);
            $("#totalAddonsInput").val(addonQty);
            $("#totalFrequencyDuration").val(frequencyVal);
        }
    </script>
@endsection

@if (config('no-captcha.registration'))
    @push('scripts')
        {{ no_captcha()->script() }}
        {{ no_captcha()->getApiScript() }}

        <script>
            grecaptcha.ready(() => {
                window.noCaptcha.render('register', (token) => {
                    document.querySelector('#g-recaptcha-response').value = token;
                });
            });
        </script>
    @endpush
@endif
