@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Subscriptions'))

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/page-pricing.css') }}">
@endsection

@section('content')
    {{-- <div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-skip-back"><polygon points="19 20 9 12 19 4 19 20"></polygon><line x1="5" y1="19" x2="5" y2="5"></line></svg> Back</a></div> --}}
    <div class="col-md-2 col-12 text-end">
        <a href="#!" class="back-dashbordbtn" onclick="window.history.go(-1); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg>
            Go Back
        </a>
    </div>

    <section id="pricing-plan">
        <!-- title text and switch button -->
        <div class="text-center">
            <h1 class="mt-5">{{ __('locale.plans.pricing') }} {{ __('locale.menu.Plans') }}</h1>
            <p class="mb-2 pb-75">
                {{ __('locale.description.plan_price') }}
            </p>
        </div>
        <!--/ title text and switch button -->

        <!-- pricing plan cards -->
        <div class="row pricing-card">
            <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                @foreach ($plans->chunk(3) as $chunk)
                    <div class="row">

                        @foreach ($chunk as $plan)
                            <div class="col-12 col-md-4 mb-2">
                                <div
                                    class="card standard-pricing {{ $plan->is_popular ? 'Most Popular' : null }} text-center">
                                    <div class="card-body d-flex flex-column">
                                        @if ($plan->id == 3)
                                            <div class="popular-tag">Most Popular </div>
                                        @endif
                                        @if ($plan->is_popular)
                                            <div class="pricing-badge text-end">
                                                <span class="badge rounded-pill badge-light-primary">Popular</span>
                                            </div>
                                        @endif

                                        <i data-feather="shopping-cart" class="mb-2 mt-5 feather-32 align-self-center"></i>
                                        <h3>{{ $plan->name }}</h3>
                                        <p class="card-text">{{ $plan->description }}</p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2">
                                                <sup
                                                    class="font-medium-1 fw-bold text-primary">{{ str_replace('{PRICE}', '', $plan->currency->format) }}</sup>
                                                <span
                                                    class="pricing-basic-value fw-bolder text-primary">{{ round($plan->price) }}</span>
                                                <sub
                                                    class="pricing-duration text-body font-medium-1 fw-bold">/{{ $plan->displayFrequencyTime() }}</sub>
                                            </div>
                                            <small class="annual-pricing d-none text-muted"></small>
                                        </div>
                                        <ul class="list-group list-group-circle text-start">

                                            {{-- <li class="list-group-item">{{ $plan->displayTotalQuota() }}
                                            {{ __('locale.labels.sms_credit') }}</li>

                                        @if ($plan->getOption('create_sending_server') == 'yes')
                                            <li class="list-group-item">
                                                {{ __('locale.plans.create_own_sending_server') }}</li>
                                        @endif

                                        @if ($plan->getOption('sender_id_verification') == 'yes')
                                            <li class="list-group-item">
                                                {{ __('locale.plans.need_sender_id_verification') }}</li>
                                        @endif

                                        @if ($plan->getOption('api_access') == 'yes')
                                            <li class="list-group-item">{{ __('locale.plans.customer_can_use_api') }}
                                            </li>
                                        @endif
                                        <li class="list-group-item">{{ __('locale.labels.text_messages') }}:
                                            {{ $plan->getOption('plain_sms') }}
                                            {{ __('locale.labels.credit_per_sms') }}</li>
                                        <li class="list-group-item">{{ __('locale.labels.voice_messages') }}:
                                            {{ $plan->getOption('voice_sms') }}
                                            {{ __('locale.labels.credit_per_sms') }}</li>
                                        <li class="list-group-item">{{ __('locale.labels.picture_messages') }}:
                                            {{ $plan->getOption('mms_sms') }} {{ __('locale.labels.credit_per_sms') }}
                                        </li> --}}
                                            @if ($plan->id == 1)
                                                <li class="list-group-item">One connect WhatsApp with QR scanner</li>
                                                <li class="list-group-item">Contact Management</li>
                                                <li class="list-group-item">Blacklist Management</li>
                                                <li class="list-group-item">Custom WhatsApp Manager</li>
                                                <li class="list-group-item">Message Campaign Builder</li>
                                                <li class="list-group-item">Custom Analytics & Reports</li>
                                                <li class="list-group-item">Limited Message Speed - 1 message per 10
                                                    minutes
                                                </li>
                                            @else
                                                <li class="list-group-item">One connect WhatsApp with QR scanner</li>
                                                <li class="list-group-item">Contact Management</li>
                                                <li class="list-group-item">Blacklist Management</li>
                                                <li class="list-group-item">Custom WhatsApp Manager</li>
                                                <li class="list-group-item">Message Campaign Builder</li>
                                                <li class="list-group-item">Custom Analytics & Reports</li>
                                                <li class="list-group-item">Unlimited Message Speed</li>
                                            @endif

                                        </ul>

                                        @if ((isset($subscription) && $subscription->plan->id == 1) || @$isPlanExpired)
                                            <a href="{{ route('customer.subscriptions.purchase', $plan->uid) }}"
                                                class="btn w-75 mt-2  {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} {{ isset($subscription) && $plan->id == $subscription->plan_id ? 'disabled' : '' }} ">

                                                {{ isset($subscription) && $plan->id == $subscription->plan_id ? __('locale.labels.current_plan') : __('locale.labels.subscribe_now') }}
                                            </a>
                                        @elseif((isset($subscription) && ($subscription->plan->frequency_unit == 'month' && $plan->id != 1)) || @$isPlanExpired)
                                            <a href="{{ route('customer.subscriptions.purchase', $plan->uid) }}"
                                                class="btn w-75 mt-auto align-self-center  {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} {{ isset($subscription) && $plan->id == $subscription->plan_id ? 'disabled' : '' }} ">

                                                {{ isset($subscription) && $plan->id == $subscription->plan_id ? __('locale.labels.current_plan') : __('locale.labels.subscribe_now') }}
                                            </a>
                                        @elseif(isset($subscription) && $plan->id == $subscription->plan_id)
                                            <a href="#!"
                                                class="btn w-75 mt-2  {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} {{ isset($subscription) && $plan->id == $subscription->plan_id ? 'disabled' : '' }} ">
                                                {{ isset($subscription) && $plan->id == $subscription->plan_id ? __('locale.labels.current_plan') : __('locale.labels.subscribe_now') }}
                                            </a>
                                        @elseif(!isset($subscription))
                                            <a href="{{ route('customer.subscriptions.purchase', $plan->uid) }}"
                                                class="btn w-75 mt-2  {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} ">
                                                {{ __('locale.labels.subscribe_now') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>
        </div>


    </section>
@endsection
