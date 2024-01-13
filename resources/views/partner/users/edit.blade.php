@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('Edit User'))

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
                <div class="card">
                    <div class="card-body py-2 my-25">
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
                        <!-- header section -->
                        <div class="d-flex">
                            <img src="{{ !empty($connection->avatar) ? $connection->avatar : URL::to('/') . '/avatar?63e23288e5d0d' }}"
                                alt="{{ $user->displayName() }}" class="uploadedAvatar rounded me-50" height="100"
                                width="100" />
                            <!-- upload and reset button -->
                            <div class="d-flex align-items-center w-100 mt-75 ms-1 me-2 justify-content-sm-between">
                                <div>
                                    <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                                </div>
                                <div class="btn-group w-auto mb-2 mt-2 float-end">
                                    <a href="{{ route('Partner.allocateMessage', ['user_id' => $user->id]) }}"
                                        class="btn btn-success waves-light waves-effect fw-bold">
                                        {{ __('Allocate Messages') }} <i data-feather="map"></i></a>
                                </div>
                            </div>
                            <!--/ upload and reset button -->
                        </div>
                        <!--/ header section -->

                        <!-- form -->
                        <form id="form" class="form mt-2 pt-50"
                            action="{{ URL::to('partner/users/update/' . $user->id) }}" method="post" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    {{-- @dd($customer->is_enterprise) --}}
                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <div class="mb-1">
                                                <label for="enterprise_user_id"
                                                    class="form-label required">{{ __('Enterprise user id') }}</label>
                                                <input type="text" id="enterprise_user_id"
                                                    class="form-control @error('enterprise_user_id') is-invalid @enderror"
                                                    value="{{ $user->enterprise_user_id }}" name="enterprise_user_id"
                                                    required>
                                                @error('enterprise_user_id')
                                                    <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label for="first_name"
                                                    class="form-label required">{{ __('locale.labels.first_name') }}</label>
                                                <input type="text" id="first_name"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    value="{{ $user->first_name }}" name="first_name" required>
                                                @error('first_name')
                                                    <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label for="last_name"
                                                    class="form-label">{{ __('locale.labels.last_name') }}</label>
                                                <input type="text" id="last_name"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    value="{{ $user->last_name }}" name="last_name">
                                                @error('last_name')
                                                    <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label for="phone" class="form-label">{{ __('Mobile Number') }}</label>
                                                <input type="text" id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ $user->phone }}" name="phone">
                                                @error('phone')
                                                    <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label for="email"
                                                    class="form-label">{{ __('locale.labels.email') }}</label>
                                                <input type="text" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ $user->email }}" name="email">
                                                @error('email')
                                                    <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="password">{{ __('locale.labels.password') }}</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        value="{{ old('password') }}" name="password" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            data-feather="eye"></i></span>
                                                </div>

                                                @if ($errors->has('password'))
                                                    <p><small class="text-danger">{{ $errors->first('password') }}</small>
                                                    </p>
                                                @else
                                                    <p><small class="text-primary">
                                                            {{ __('locale.customer.leave_blank_password') }}
                                                        </small></p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="password_confirmation">{{ __('locale.labels.password_confirmation') }}</label>
                                                <div class="input-group input-group-merge form-password-toggle">
                                                    <input type="password" id="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        value="{{ old('password_confirmation') }}"
                                                        name="password_confirmation" />
                                                    <span class="input-group-text cursor-pointer"><i
                                                            data-feather="eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button type="submit" class="btn btn-primary mt-1 me-1"><i data-feather="save"></i>
                                        {{ __('locale.buttons.save_changes') }}</button>
                                </div>

                            </div>
                        </form>
                        <!--/ form -->
                    </div>
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
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
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
