@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('Allocate Messages'))

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
                        
                        <form id="form" method="POST" action="{{ URL::to('partner/transactions/userTransactionsUpdate/'. $userId) }}"
                            autocomplete="off">
                            @csrf

                            <div class="checkUserdata">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float mb-2">
                                            <label class="form-label">{{ __('Avaliable Message') }} <span
                                                    class="required"></span></label>
                                            <div class="form-line">
                                                <input type="text" id="avaliable_message" class="form-control"
                                                    name="avaliable_message" value="{{ $tansactions->balance ?? '0' }}" required
                                                    readonly>
                                            </div>
                                            @error('avaliable_message')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float mb-2">
                                            <label class="form-label">{{ __('Select User') }}<span
                                                    class="required"></span></label>
                                            <div class="form-line">
                                                <select class="form-control select-inputClr" name="user_id">
                                                    <option value="">Select User</option>
                                                    @foreach ($users as $user)
                                                        <option @if($user->id == $tansactions->user_id ?? 0) selected  @endif value="{{ $user->id ?? 0}}">{{ $user->first_name }}
                                                            {{ $user->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('user_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group form-float mb-2">
                                            <label class="form-label">{{ __('Message quantity') }}<span
                                                    class="required"></span></label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="message_qty"
                                                    id="message_qty" value="{{ $tansactions->credit ?? '0'}}" required
                                                    minlength="1" maxlength="10">
                                            </div>
                                            @error('message_qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-raised btn-primary waves-effect my-2"
                                type="submit">{{ __('Allocate Messages') }}</button>

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
