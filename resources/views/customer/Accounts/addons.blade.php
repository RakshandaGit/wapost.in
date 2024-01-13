@extends('layouts/contentLayoutMaster')

@section('title', __('locale.labels.addons'))

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
        #address .error{
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
        <form action="{{ route('customer.subscriptions.addons', $subscription->uid) }}" method="post">
            @csrf
            <input type="hidden" name="formType" value="addons">
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
                                            <label id="first_name-error" class="error" for="first_name" >This field is required.</label>
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
                                            <label id="email-error" class="error" for="email">Please enter your email address.</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="phone"
                                                class="required form-label">{{ __('locale.labels.phone') }}</label>
                                            <input type="number" id="phone" class="form-control required"
                                                name="phone" value="{{ Auth::user()->customer->phone }}">
                                            <label id="phone-error" class="error" for="phone">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="address"
                                                class="required form-label">{{ __('locale.labels.address') }}</label>
                                            <input type="text" id="address" class="form-control required"
                                                name="address" value="{{ Auth::user()->customer->address }}">
                                            <label id="address-error" class="error" for="address">This field is required.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-1">
                                            <label for="city"
                                                class="required form-label">{{ __('locale.labels.city') }}</label>
                                            <input type="text" id="city" class="form-control required"
                                                name="city" value="{{ Auth::user()->customer->city }}">
                                            <label id="city-error" class="error" for="city">This field is required.</label>
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
                                            <input type='text' name='total_addons' value="1" min="1"
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
                                <span>Addon Amount</span>
                                <span id="totalAddonAmount">Rs.{{ $plan->connection_addons_price }}/-</span>
                            </p>
                            <p class="list-total">
                                <span
                                    id="totalAdjustedAmountLable">{{ $plan->connection_addons_price - $calculatedPrice < 0 ? 'Additional Amount' : 'Adjusted Amount' }}</span>
                                <span
                                    id="totalAdjustedAmount">Rs.{{ abs($plan->connection_addons_price - $calculatedPrice) }}/-</span>
                            </p>
                            <p class="list-total">
                                <span class="text-blue">Total Payable Amount</span>
                                <span id="totalPayableAmount">
                                    Rs.{{ $calculatedPrice }}/-
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
                if (currentVal > 1) {
                    $input.val(currentVal - 1);
                }
            } else {
                $input.val();
            }
        });

        function onChangeAddonQty(type) {
            var addonQty = parseInt($("#addonquantity").val())
            if (type == "+" && addonQty == 1) {
                addonQty = 2
            }

            if (addonQty > 1) {
                if (type == "-") {
                    addonQty = parseInt($("#addonquantity").val()) - parseInt(1);
                } else {
                    addonQty = parseInt($("#addonquantity").val()) + parseInt(1);
                }

                var calculatedPrice = parseFloat("{{ $calculatedPrice }}");
                var addonsPrice = parseFloat("{{ $plan->connection_addons_price }}");

                var totalAddonAmount = (addonQty * addonsPrice).toFixed(2)
                var totalAdjustedAmount = ((addonsPrice - calculatedPrice) * addonQty).toFixed(2)
                $('#totalAdjustedAmountLable').text('Adjusted Amount');
                if (totalAdjustedAmount < 0) {
                    $('#totalAdjustedAmountLable').text('Additional Amount');
                    totalAdjustedAmount = Math.abs(totalAdjustedAmount).toFixed(2)
                }
                var totalPayableAmount = parseFloat(addonQty * calculatedPrice).toFixed(2);

                $("#totalAddonAmount").text(`Rs.${totalAddonAmount}/-`);
                $("#totalAdjustedAmount").text(`Rs.${totalAdjustedAmount}/-`);
                $("#totalPayableAmount").text(`Rs.${totalPayableAmount}/-`);
            }
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
            if(document.querySelector("#first_name").value === "" || document.querySelector("#email").value === "" || document.querySelector("#phone").value === "" || document.querySelector("#address").value === "" || document.querySelector("#city").value === "") {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        }

        $(document).ready(function() {
            $('#address input').on('change', function() {
                if($('#first_name').val() === '') {
                    $('#first_name-error').show();
                } else {
                    $('#first_name-error').hide();
                }
                if($('#email').val() === '') {
                    $('#email-error').show();
                } else {
                    $('#email-error').hide();
                }
                if($('#phone').val() === '') {
                    $('#phone-error').show();
                } else {
                    $('#phone-error').hide();
                }
                if($('input#address').val() === '') {
                    $('#address-error').show();
                } else {
                    $('#address-error').hide();
                }
                if($('#city').val() === '') {
                    $('#city-error').show();
                } else {
                    $('#city-error').hide();
                }
            });

        });
    </script>
@endsection
