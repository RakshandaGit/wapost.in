@extends('layouts/contentLayoutMaster')

@section('title', __('locale.labels.renew'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
    <style>
        #address .error {
            display: none;
        }
    </style>
    {{-- <div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-skip-back"><polygon points="19 20 9 12 19 4 19 20"></polygon><line x1="5" y1="19" x2="5" y2="5"></line></svg> Back</a></div> --}}

    <div class="col-md-2 col-12 text-end">
        <a href="#!" class="back-dashbordbtn" onclick="window.history.go(-1); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg>
            Back
        </a>
    </div>

    <!-- Modern Horizontal Wizard -->
    <section class="modern-horizontal-wizard renew-plan-page">
        <form action="{{ route('customer.subscriptions.renew', $subscription->uid) }}" method="post">
            @csrf
            <input type="hidden" id="totalAddonsInput" name="total_addons" value="{{ $addonsConnections }}">
            <input type="hidden" id="totalFrequencyDuration" name="total_frequency_duration" value="{{ $durationCount }}">
            <input type="hidden" id="totalAdditionalAmountInput" name="total_additional_adjested_mount" value="0">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $error }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif

            <div class="bs-stepper wizard-modern modern-wizard-example">
                <div class="bs-stepper-header">

                    <div class="step" data-target="#cart" role="tab" id="cart-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="shopping-cart" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('locale.labels.cart') }}</span>
                                <span class="bs-stepper-subtitle">{{ $subscription->plan->name }}
                                    {{ __('locale.menu.Plan') }}</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i data-feather="chevron-right" class="font-medium-2"></i>
                    </div>


                    <div class="step" data-target="#address" role="tab" id="address-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="map-pin" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('locale.labels.address') }}</span>
                                <span class="bs-stepper-subtitle">{{ __('locale.labels.billing_address') }}</span>
                            </span>
                        </button>
                    </div>
                    <div class="line">
                        <i data-feather="chevron-right" class="font-medium-2"></i>
                    </div>


                    <div class="step" data-target="#payment" role="tab" id="payment-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="credit-card" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ __('locale.labels.payment') }}</span>
                                <span class="bs-stepper-subtitle">{{ __('locale.labels.pay_payment') }}</span>
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row m-0">
                    <!-- Left Text-->
                    <div class="col-lg-7 ">
                        <div class="bs-stepper-content">

                            <div id="cart" class="content" role="tabpanel" aria-labelledby="cart-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">{{ __('locale.menu.Subscriptions') }}</h5>
                                    <small class="text-muted">{!! __('locale.subscription.log_subscribe', ['plan' => $subscription->plan->name]) !!}</small>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td> Plan Name </td>
                                                    <td> {{ $plan->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td> {{ __('locale.plans.price') }} </td>
                                                    <td> {{ \App\Library\Tool::format_price($subscription->plan->price, $subscription->plan->currency->format) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td> Max Contact Groups </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> Max Contacts </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> Max Contacts per Group </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> Text Messages </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> Media (Image/Video/Audio) Messages </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> File/Document Messages </td>
                                                    <td> Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td> Contact Messages </td>
                                                    <td> Unlimited</td>
                                                </tr>

                                                {{-- <tr>
                                                    <td> {{ __('locale.labels.renew') }} </td>
                                                    <td> {{ __('locale.labels.every') }}
                                                        {{ $subscription->plan->displayFrequencyTime() }} </td>
                                                </tr>
        
                                                <tr>
                                                    <td> {{ __('locale.labels.sms_credit') }} </td>
                                                    <td> {{ $subscription->plan->displayTotalQuota() }} </td>
                                                </tr>
        
                                                <tr>
                                                    <td> {{ __('locale.plans.create_own_sending_server') }} </td>
                                                    <td>
                                                        @if ($subscription->plan->getOption('create_sending_server') == 'yes')
                                                            {{ __('locale.labels.yes') }}
                                                        @else
                                                            {{ __('locale.labels.no') }}
                                                        @endif
                                                    </td>
                                                </tr>
        
                                                <tr>
                                                    <td> {{ __('locale.customer.sender_id_verification') }} </td>
                                                    <td>
                                                        @if ($subscription->plan->getOption('sender_id_verification') == 'yes')
                                                            {{ __('locale.labels.yes') }}
                                                        @else
                                                            {{ __('locale.labels.no') }}
                                                        @endif
                                                    </td>
                                                </tr>
        
                                                <tr>
                                                    <td> {{ __('locale.labels.cutting_system_available') }} </td>
                                                    <td>
                                                        {{ __('locale.labels.yes') }}
                                                    </td>
                                                </tr>
        
        
                                                <tr>
                                                    <td> {{ __('locale.labels.api_access') }} </td>
                                                    <td>
                                                        @if ($subscription->plan->getOption('api_access') == 'yes')
                                                            {{ __('locale.labels.yes') }}
                                                        @else
                                                            {{ __('locale.labels.no') }}
                                                        @endif
                                                    </td>
                                                </tr> --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span
                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" type="button">
                                        <span
                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="address" class="content" role="tabpanel" aria-labelledby="address-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">{{ __('locale.labels.address') }}</h5>
                                    <small>{{ __('locale.labels.billing_address') }}</small>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="first_name"
                                                class="required form-label">{{ __('locale.labels.first_name') }}</label>
                                            <input type="text" id="first_name" class="form-control required"
                                                name="first_name" value="{{ Auth::user()->first_name }}">
                                            <label id="first_name-error" class="error" for="first_name">This field is
                                                required.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="last_name">{{ __('locale.labels.last_name') }}</label>
                                            <input type="text" id="last_name" class="form-control" name="last_name"
                                                value="{{ Auth::user()->last_name }}">
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="email"
                                                class="required form-label">{{ __('locale.labels.email') }}</label>
                                            <input type="email" id="email" class="form-control required"
                                                name="email" value="{{ Auth::user()->email }}">
                                            <label id="email-error" class="error" for="email">Please enter your email
                                                address.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="phone"
                                                class="required form-label">{{ __('locale.labels.phone') }}</label>
                                            <input type="number" id="phone" class="form-control required"
                                                name="phone" value="{{ Auth::user()->customer->phone }}">
                                            <label id="phone-error" class="error" for="phone">This field is
                                                required.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="address"
                                                class="required form-label">{{ __('locale.labels.address') }}</label>
                                            <input type="text" id="address" class="form-control required"
                                                name="address" value="{{ Auth::user()->customer->address }}">
                                            <label id="address-error" class="error" for="address">This field is
                                                required.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="city"
                                                class="required form-label">{{ __('locale.labels.city') }}</label>
                                            <input type="text" id="city" class="form-control required"
                                                name="city" value="{{ Auth::user()->customer->city }}">
                                            <label id="city-error" class="error" for="city">This field is
                                                required.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="postcode"
                                                class="form-label">{{ __('locale.labels.postcode') }}</label>
                                            <input type="text" id="postcode" class="form-control" name="postcode"
                                                value="{{ Auth::user()->customer->postcode }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="country"
                                                class="required form-label">{{ __('locale.labels.country') }}</label>
                                            <select class="form-select select2" id="country" name="country">
                                                @foreach (\App\Helpers\Helper::countries() as $country)
                                                    <option value="{{ $country['name'] }}"
                                                        {{ Auth::user()->customer->country == $country['name'] ? 'selected' : null }}>
                                                        {{ $country['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev" type="button">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span
                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" type="button">
                                        <span
                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.next') }}</span>
                                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="payment" class="content" role="tabpanel" aria-labelledby="payment-trigger">
                                <div class="content-header">
                                    <h5 class="mb-0">{{ __('locale.labels.payment_options') }}</h5>
                                    <small>{{ __('locale.payment_gateways.click_on_correct_option') }}</small>
                                </div>
                                <div class="row mb-2 mt-2 ">
                                    <ul class="other-payment-options list-unstyled">

                                        @foreach ($payment_methods as $method)
                                            <li class="py-50">
                                                <div class="form-check">
                                                    <input type="radio" id="{{ $method->type }}"
                                                        value="{{ $method->type }}" name="payment_methods"
                                                        class="form-check-input" />
                                                    <label class="form-check-label" for="{{ $method->type }}">
                                                        {{ $method->name }} </label>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                    <label id="payment_methods-error" class="error" for="payment_methods"></label>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev" type="button">
                                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                        <span
                                            class="align-middle d-sm-inline-block d-none">{{ __('locale.datatables.previous') }}</span>
                                    </button>
                                    <button class="btn btn-success btn-submit"
                                        type="submit">{{ __('locale.labels.checkout') }}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /Left Text-->
                    <div class="col-lg-5">
                        <div class="addonbox mb-2">
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
                                                <option value="1" {{ $durationCount == 1 ? 'selected' : '' }}>1 Month
                                                </option>
                                                <option value="3" {{ $durationCount == 3 ? 'selected' : '' }}>3
                                                    Months</option>
                                                <option value="6" {{ $durationCount == 6 ? 'selected' : '' }}>6
                                                    Months</option>
                                                <option value="9" {{ $durationCount == 9 ? 'selected' : '' }}>9
                                                    Months</option>
                                            @else
                                                <option value="1" {{ $durationCount == 1 ? 'selected' : '' }}>1 Year
                                                </option>
                                                <option value="2" {{ $durationCount == 2 ? 'selected' : '' }}>2 Years
                                                </option>
                                                <option value="3" {{ $durationCount == 3 ? 'selected' : '' }}>3 Years
                                                </option>
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
                                            <input type='button' value='-' class='addonqtyminus' field='quantity'
                                                onclick="onChangeAddonQty('-')" />
                                            <input type='text' name='addonquantity' value="{{ $addonsConnections }}"
                                                min="{{ count($connections) > 0 ? count($connections) - 1 : 0 }}"
                                                class='qty' id="addonquantity" />
                                            <input type='button' value='+' class='addonqtyplus' field='quantity'
                                                onclick="onChangeAddonQty('+')" />
                                        </div>
                                        <label id="addonquantity-error" class="error" for="quantity"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="addon-total">
                            <p class="list-total">
                                <span>Total</span>
                                <span id="totalPlanPrice">Rs.{{ $plan->price * $durationCount }}/-</span>
                            </p>
                            <p class="list-total">
                                <span>Addon Amount</span>
                                <span
                                    id="totalAddonAmount">Rs.{{ $plan->connection_addons_price * $addonsConnections * $durationCount }}/-</span>
                            </p>

                            <p class="list-total">
                                <span id="totalAdditionalAmountLable">Additional Amount:</span>
                                {{-- <span id="totalAdditionalAmount">Rs.{{ abs($calculatedPrice * $addonsConnections) }}/-</span> --}}
                                <span id="totalAdditionalAmount">Rs.0/-</span>
                            </p>

                            <p class="list-total">
                                <span class="text-blue">Total Payable Amount</span>
                                <span id="totalPayableAmount">
                                    Rs.{{ $plan->price * $durationCount + $plan->connection_addons_price * $addonsConnections * $durationCount }}/-
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /Modern Horizontal Wizard -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
    <script>
        var totalConnection = parseInt("{{ count($connections) > 0 ? count($connections) - 1 : 0 }}");
        $('.addonqtyplus').click(function(e) {
            e.preventDefault();
            var $input = $(this).prev('input');
            // console.log($input.val())
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal)) {
                $input.val(currentVal + 1);
            } else {
                $input.val(0);
            }
        });
        $('.addonqtyminus').click(function(e) {
            e.preventDefault();
            var $input = $(this).next('input');
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal)) {

                if (currentVal > totalConnection) {
                    $input.val(currentVal - 1);
                }
            } else {
                $input.val();
            }
        });

        function onChangeAddonQty(type) {
            var addonQty = parseInt($("#addonquantity").val())
            if (type == "+" && addonQty == totalConnection) {
                addonQty = parseInt(totalConnection) + parseInt(1);
            }

            if (addonQty > totalConnection) {
                if (type == "-") {
                    addonQty = parseInt($("#addonquantity").val()) - parseInt(1);
                } else {
                    addonQty = parseInt($("#addonquantity").val()) + parseInt(1);
                }

                var planPrice = parseFloat("{{ $plan->price }}");
                var addonsPrice = parseFloat("{{ $plan->connection_addons_price }}");
                var avilableAddons = parseInt("{{ $addonsConnections }}");
                var frequencyVal = parseInt($("#frequencyOpt").val());

                var totalAdditionalAmount = parseFloat("{{ abs($calculatedPrice) }}");
                var totalPlanPrice = (planPrice * frequencyVal).toFixed(2);
                var totalAddonAmount = ((addonQty * addonsPrice) * frequencyVal).toFixed(2)
                var totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount)).toFixed(2);

                $('#totalAdditionalAmountLable').text('Additional Amount');
                if (addonQty > avilableAddons) {
                    totalAdditionalAmount = (totalAdditionalAmount * (addonQty - avilableAddons)).toFixed(2);
                    totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount) + parseFloat(
                        totalAdditionalAmount)).toFixed(2);
                } else {
                    // totalAdditionalAmount = parseFloat(0);
                    totalAdditionalAmount = (Math.abs(totalAdditionalAmount * (avilableAddons - addonQty))).toFixed(2);
                    totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount) - parseFloat(
                        totalAdditionalAmount)).toFixed(2);
                    $('#totalAdditionalAmountLable').text('Adjusted Amount');
                }

                $("#totalPlanPrice").text(`Rs.${totalPlanPrice}/-`);
                $("#totalAddonAmount").text(`Rs.${totalAddonAmount}/-`);
                $("#totalPayableAmount").text(`Rs.${totalPayableAmount}/-`);
                $("#totalAddonsInput").val(addonQty);
                $("#totalAdditionalAmount").text(`Rs.${totalAdditionalAmount}/-`);
                $("#totalAdditionalAmountInput").val(totalAdditionalAmount);
                $("#totalAdditionalAmountInput").text(`Rs.${totalAdditionalAmount}/-`);
            }
        }

        function onChangeFrequency(that) {
            var planPrice = parseFloat("{{ $plan->price }}");
            var addonsPrice = parseFloat("{{ $plan->connection_addons_price }}");
            var frequencyVal = parseInt($(that).val());
            var addonQty = parseInt($("#addonquantity").val());

            var avilableAddons = parseInt("{{ $addonsConnections }}");

            var totalPlanPrice = (planPrice * frequencyVal).toFixed(2);
            var totalAddonAmount = ((addonQty * addonsPrice) * frequencyVal).toFixed(2);
            var totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount)).toFixed(2);
            var totalAdditionalAmount = parseFloat("{{ abs($calculatedPrice) }}");
            
            $('#totalAdditionalAmountLable').text('Additional Amount');
            
            if (addonQty > avilableAddons) {
                totalAdditionalAmount = (totalAdditionalAmount * (addonQty - avilableAddons)).toFixed(2);
                totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount) + parseFloat(
                    totalAdditionalAmount)).toFixed(2);
            } else {
                // totalAdditionalAmount = parseFloat(0);
                totalAdditionalAmount = (Math.abs(totalAdditionalAmount * (avilableAddons - addonQty))).toFixed(2);
                console.log(totalAdditionalAmount, avilableAddons, addonQty, addonQty, ' - addonQty > avilableAddons');
                totalPayableAmount = (parseFloat(totalPlanPrice) + parseFloat(totalAddonAmount) - parseFloat(
                    totalAdditionalAmount)).toFixed(2);
                $('#totalAdditionalAmountLable').text('Adjusted Amount');
            }

            console.log(totalAdditionalAmount, totalPayableAmount)
            $("#totalPlanPrice").text(`Rs.${totalPlanPrice}/-`);
            $("#totalAddonAmount").text(`Rs.${totalAddonAmount}/-`);
            $("#totalPayableAmount").text(`Rs.${totalPayableAmount}/-`);
            $("#totalAddonsInput").val(addonQty);
            $("#totalFrequencyDuration").val(frequencyVal);
            $("#totalAdditionalAmount").text(`Rs.${totalAdditionalAmount}/-`);
            $("#totalAdditionalAmountInput").val(totalAdditionalAmount);
        }

        // --------------------- multistrper from----------------------------------
        $("#payment .btn-submit").on('click', function(e) {
            $.validator.setDefaults({
                debug: false,
                success: "valid",
            });
            var form = $(".renew-plan-page form");
            form.validate({
                rules: {
                    payment_methods: {
                        required: true
                    }
                }
            });
            console.log(form.valid());
            if (form.valid() === false) {
                e.preventDefault();
                return false;
            } else {
                $("#payment .btn-submit").click(function() {
                    $(".renew-plan-page form").submit();
                });
            }
        });
        let firstname = document.querySelector("#first_name");
        let emailinput = document.querySelector("#email");
        let phoneinput = document.querySelector("#phone");
        let addressinput = document.querySelector("#address");
        let cityinput = document.querySelector("#city");
        let button = document.querySelector("#address .btn-next");
        firstname.addEventListener("change", stateHandle);
        emailinput.addEventListener("change", stateHandle);
        phoneinput.addEventListener("change", stateHandle);
        addressinput.addEventListener("change", stateHandle);
        cityinput.addEventListener("change", stateHandle);

        function stateHandle() {
            if (document.querySelector("#first_name").value === "" || document.querySelector("#email").value === "" ||
                document.querySelector("#phone").value === "" || document.querySelector("#address").value === "" || document
                .querySelector("#city").value === "") {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        }

        $(document).ready(function() {
            $('#address input').on('change', function() {
                if ($('#first_name').val() === '') {
                    $('#first_name-error').show();
                } else {
                    $('#first_name-error').hide();
                }
                if ($('#email').val() === '') {
                    $('#email-error').show();
                } else {
                    $('#email-error').hide();
                }
                if ($('#phone').val() === '') {
                    $('#phone-error').show();
                } else {
                    $('#phone-error').hide();
                }
                if ($('input#address').val() === '') {
                    $('#address-error').show();
                } else {
                    $('#address-error').hide();
                }
                if ($('#city').val() === '') {
                    $('#city-error').show();
                } else {
                    $('#city-error').hide();
                }
            });
        });
    </script>
@endsection
