@extends('layouts/contentLayoutMaster')

@section('title', __('locale.customer.add_new'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('content')
<div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-skip-back"><polygon points="19 20 9 12 19 4 19 20"></polygon><line x1="5" y1="19" x2="5" y2="5"></line></svg> Back</a></div>

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> {{__('locale.customer.add_new')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="form" class="form form-vertical" action="{{ route('admin.customers.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="required form-label b-block me-2">{{__('Is Partner')}}</label>
                                            <input name="is_enterprise" type="radio" id="yes_enterprises" value="1" required>
                                            <label for="yes_enterprises" class="me-1">Yes</label>
                                            <input name="is_enterprise" type="radio" id="no_enterprises" value="0" required checked>
                                            <label for="no_enterprises">No</label>

                                            <label id="role-error" class="error" for="role"></label>
                                            @error('role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12" id="amount_container" style="display: none">
                                        <div class="mb-1">
                                            <label for="amount" class="required form-label">{{__('Amount')}}</label>
                                            <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" name="amount" required>
                                            @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12"  id="msg_quantity_container" style="display: none">
                                        <div class="mb-1">
                                            <label for="msg_quantity" class="required form-label">{{__('Message quantity')}}</label>
                                            <input type="text" id="msg_quantity" class="form-control @error('msg_quantity') is-invalid @enderror" value="{{ old('msg_quantity') }}" name="msg_quantity" required>
                                            @error('msg_quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="first_name" class="required form-label">{{__('locale.labels.first_name')}}</label>
                                            <input type="text" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" name="first_name" required>
                                            @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="last_name" class="form-label">{{__('locale.labels.last_name')}}</label>
                                            <input type="text" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" name="last_name">
                                            @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="phone" class="required form-label">{{__('locale.labels.phone')}}</label>
                                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone" required>
                                            @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="email" class="required form-label">{{__('locale.labels.email')}}</label>
                                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" required>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label required" for="password">{{ __('locale.labels.password') }}</label>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" required/>
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                            <label id="password-error" class="error" style="display: none;" for="password"></label>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label required" for="password_confirmation">{{ __('locale.labels.password_confirmation') }}</label>
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                       value="{{ old('password_confirmation') }}"
                                                       name="password_confirmation" required/>
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                            <label id="password_confirmation-error" class="error" style="display: none;" for="password_confirmation"></label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="timezone" class="required form-label">{{__('locale.labels.timezone')}}</label>
                                            <select class="select2 w-100" id="timezone" name="timezone">
                                                @foreach(\App\Library\Tool::allTimeZones() as $timezone)
                                                    <option value="{{$timezone['zone']}}" {{ config('app.timezone') == $timezone['zone'] ? 'selected': null }}> {{ $timezone['text'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('timezone')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="locale" class="required form-label">{{__('locale.labels.language')}}</label>
                                            <select class="select2 w-100" id="locale" name="locale">
                                                @foreach($languages as $language)
                                                    <option value="{{ $language->code }}" {{old('locale') == $language->code ? 'selected': null }}> {{ $language->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('locale')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="status" class="required form-label">{{ __('locale.labels.status') }}</label>
                                            <select class="form-select" name="status" id="status">
                                                <option value="1">{{ __('locale.labels.active') }}</option>
                                                <option value="0">{{ __('locale.labels.inactive')}} </option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="image" class="form-label">{{__('locale.labels.image')}}</label>
                                            <input type="file" name="image" class="form-control" id="image" accept="image/*"/>
                                            @error('image')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <p><small class="text-primary"> {{__('locale.customer.profile_image_size')}} </small></p>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="welcome_message" value="checked" name="welcome_message">
                                                <label class="form-check-label" for="welcome_message">{{ __('locale.customer.send_welcome_email') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                                            <i data-feather="save"></i> {{__('locale.buttons.save')}}
                                        </button>
                                    </div>


                                </div>
                            </form>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection


@section('page-script')

    <script>
        let firstInvalid = $('form').find('.is-invalid').eq(0);

        if (firstInvalid.length) {
            $('body, html').stop(true, true).animate({
                'scrollTop': firstInvalid.offset().top - 200 + 'px'
            }, 200);
        }

        // Basic Select2 select
        $(".select2").each(function () {
            let $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
        $(document).ready(function () {
            // Initially hide the "Message quantity" input
            $('#msg_quantity_container,#amount_container').hide();

            // Attach a change event listener to the radio buttons
            $('input[name="is_enterprise"]').change(function () {
                // Check if "Yes" is selected
                if ($(this).val() === '1') {
                    // Show the "Message quantity" input
                    $('#msg_quantity_container,#amount_container').show();
                } else {
                    // Hide the "Message quantity" input
                    $('#msg_quantity_container,#amount_container').hide();
                }
            });
        });
        $(function() {
            $('#phone').on('input', function(e) {
                var inputValue = e.target.value;
                var numericValue = inputValue.replace(/[^0-9]/g, '');

                $(this).val(numericValue);
            });

            // Prevent paste of non-numeric characters
            $('#phone').on('paste', function(e) {
                e.preventDefault();
                var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');
                var numericValue = pastedText.replace(/[^0-9]/g, '');
                document.execCommand('insertText', false, numericValue);
            });

        });
        $(function() {
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return parseFloat(value) > 0;
            }, "Amount must be greater than 0.");

            jQuery.validator.addMethod(
                "customPhoneValidation",
                function(value, element) {
                    return this.optional(element) || /^[6789]\d{9}$/.test(value);
                },
                "Must be 10 digits and start with 6, 7, 8, or 9"
            );

            jQuery.validator.addMethod(
                "customEmail",
                function(value, element) {
                    return (
                        this.optional(element) ||
                        /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value)
                    );
                },
                "Please enter valid email address!"
            );
            jQuery.validator.addMethod(
                "uniqueEmail",
                function(value, element) {
                    var result = false
                    var email = $("#email").val();
                    $.ajax({
                        async: false,
                        type: "GET",
                        url: window.location.origin + "/check-username?email=" + email,
                        success: function(response) {
                            if (response.error) {
                                result = false;
                            } else {
                                result = true;
                            }
                        },
                    });
                    return result;
                },

                "The email has already been taken."
            );

            jQuery.validator.addMethod(
                "uniquePhone",
                function(value, element) {
                    var result = false
                    var phone = $("#phone").val();
                    $.ajax({
                        async: false,
                        type: "GET",
                        url: window.location.origin + "/check-username?phone=" + phone,
                        success: function(response) {
                            if (response.error) {
                                result = false;
                            } else {
                                result = true;
                            }
                        },
                    });
                    return result;
                },
                "The phone has already been taken."
            );

            var mainform = $("#form");
            var mainformRules = mainform.find("[data-rules]");
            var allrules = getRuls(mainformRules);
            var additionalRules = {
                amount:{
                    required: true,
                    greaterThanZero: true,
                },
                first_name: {
                    required: true,
                    minlength: 2,
                },
                email: {
                    required: true,
                    customEmail: true,
                    uniqueEmail: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    uniquePhone: true,
                    customPhoneValidation: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password",
                },
            };

            $.extend(allrules, additionalRules);
            mainform.validate({
                rules: allrules,
                messages: {
                    phone: {
                        minlength: "Please enter at least {0} digits.",
                        maxlength: "Please enter no more than {0} digits.",
                    },
                    password_confirmation: {
                        equalTo: "Entered Password and Confirm password do not match",
                    },
                },
            });
        });

        function getRuls(inputs) {
            var rules = {};
            inputs.each(function(index, element) {
                var curInput = $(element);
                var dataName = curInput.attr("name");
                var dataRules = curInput.attr("data-rules");

                if (dataName && dataRules) {
                    var parsedDataRules = dataRules;
                    try {
                        rules[dataName] = JSON.parse(parsedDataRules);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                }
            });
            return rules;
        }
    </script>
@endsection

