@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('Create User'))

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card p-2">
                    <div class="body">
                        @if (Session::get('status') == 'success')
                            <div class="alert alert-block alert-success alert-dismissible mb-5" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        @if (Session::get('status') == 'error')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        {{-- @dd($user); --}}
                        <form id="form" method="POST" action="{{ URL::to('/partner/users/store') }}"
                            autocomplete="off">
                            @csrf
                            <div class="checkUserdata">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float">
                                            <label class="form-label">Enterprise user id <span
                                                    class="required"></span></label>
                                            <div class="form-line">
                                                <input type="text" name="enterprise_user_id" class="form-control"
                                                    value="{{ old('enterprise_user_id') }}" required>
                                            </div>
                                            @error('enterprise_user_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float">
                                            <label class="form-label">Firstname <span class="required"></span></label>
                                            <div class="form-line">
                                                <input type="text" id="first_name" class="form-control" name="first_name"
                                                    value="{{ old('first_name') }}" required>
                                            </div>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float">
                                            <label class="form-label">Lastname</label>
                                            <div class="form-line">
                                                <input type="text" id="last_name" class="form-control" name="last_name"
                                                    value="{{ old('last_name') }}">
                                            </div>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float">
                                            <label class="form-label">Mobile Number <span class="required"></span></label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    value="{{ old('phone') }}" required minlength="10" maxlength="10">
                                            </div>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float">
                                            <label class="form-label">Email <span class="required"></span></label>
                                            <div class="form-line">
                                                <input type="email" id="email" class="form-control" name="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
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
                                        <label id="password-error" class="error valid" for="password"></label>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label required"
                                            for="password_confirmation">{{ __('locale.labels.password_confirmation') }}</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" id="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                value="{{ old('password_confirmation') }}" name="password_confirmation"
                                                required />
                                            <span onclick="toggle_confpass()" class="field_icon cursor-pointer-toggle"><i
                                                    class="fa fa-fw fa-eye"></i></span>
                                        </div>
                                        <label id="password_confirmation-error" class="error"
                                            for="password_confirmation"></label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary waves-effect my-2"
                                type="submit">{{ __('locale.buttons.submit') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Analytics end -->
@endsection


@section('vendor-script')
    {{--     Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>

@endsection

@section('page-script')
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
        $(function() {
            $('#mobile').on('input', function(e) {
                var inputValue = e.target.value;
                var numericValue = inputValue.replace(/[^0-9]/g, '');

                $(this).val(numericValue);
            });

            // Prevent paste of non-numeric characters
            $('#mobile').on('paste', function(e) {
                e.preventDefault();
                var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');
                var numericValue = pastedText.replace(/[^0-9]/g, '');
                document.execCommand('insertText', false, numericValue);
            });

        });
        $(function() {
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
            };

            $.extend(allrules, additionalRules);
            mainform.validate({
                rules: allrules,
                messages: {
                    mobile: {
                        minlength: "Please enter at least {0} digits.",
                        maxlength: "Please enter no more than {0} digits.",
                    }
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
