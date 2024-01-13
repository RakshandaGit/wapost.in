@extends('layouts.website')

@section('title', __('Become A Partner'))
@section('meta-title', __('Become A Partner'))
@section('meta-description', __('Become A Partner'))
@section('canonical', __('https://wapost.net/'))
{{-- @section('meta-keywords', __('')) --}}

@section('content')
    <style>
        /* ------------ Pos Partner ------------ */
        .pos-activation {
            margin: 50px 0;
        }

        a.prtnbtndash {
            background-color: #fff;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            color: #128993;
            padding: 10px 20px;
            margin-right: 2rem;
        }

        a.prtnbtndash img {
            padding-right: 3px;
        }

        .posActivePage {
            border: 1px solid #BAB6B6;
            border-radius: 8px;
            max-width: 793px;
            margin: 0 auto;
        }

        .posActivePage .imgBox {
            background: linear-gradient(150deg, #0FF0B3, #036ED9 100%);
            padding: 90px 20px;
            border-radius: 8px 0 0 8px;
        }

        .posActivePage .left-data {
            padding: 0 16px 20px 0;
        }

        .posActivePage .left-data p {
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 20px;
            font-weight: 400;
            line-height: 30px;
            letter-spacing: 0em;
            text-align: left;
            color: #3C3C3C;
        }

        .posActivePage .tagbanner {
            display: inline-block;
            background-color: #0ccbbe66;
            border-radius: 8px;
            padding: 7px 25px;
            border: 1px solid #006EA34D;
            margin: 25px 0;
        }

        .posActivePage .tagbanner span {
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 14px;
            font-weight: 500;
            line-height: 27px;
            letter-spacing: 0em;
            text-align: left;
            color: #006EA3;
        }

        .posActivePage ul {
            padding: 0;
        }

        .posActivePage ul li {
            color: #000000;
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 16px;
            font-style: italic;
            font-weight: 400;
            line-height: 25px;
            letter-spacing: 0em;
            text-align: left;
            margin: 0 0 10px;
            list-style: none;
            padding: 0px 30px;
            background-image: url(../images/partner/logoimage.png);
            background-repeat: no-repeat;
            background-position: left top;
            background-size: 20px;
        }

        .posActivePage a.activeFree {
            color: #ffff;
            background: #14C35A;
            border-radius: 6px;
            padding: 10px 20px;
            float: right;
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 16px;
            font-weight: 600;
            line-height: 24px;
            letter-spacing: 0em;
            text-align: center;
            margin-bottom: 20px;
        }

        .pos-activation a.brand-logo img {
            width: 16%;
            margin: 0 auto;
            text-align: center;
        }

        .pos-activation a.brand-logo {
            text-align: center;
            display: block;
            margin: 0 0 40px;
        }

        .pos-activation p.bottomText {
            text-align: center;
            color: #000000;
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 18px;
            font-style: italic;
            font-weight: 400;
            line-height: 27px !important;
            margin: 20px 0;
        }

        .posHeader p {
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 26px;
            letter-spacing: 0em;
            text-align: center;
            color: #000000;
        }

        .freeConnection .dataBox {
            background: linear-gradient(150deg, #0FF0B3, #036ED9 100%);
            padding: 7rem 15px;
            border-radius: 8px 0 0 8px;
            text-align: center;
            
        }
        .freeConnection .dataBox p{
            color:#fff;
            font-family: Montserrat, Helvetica, Arial, serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 26px;
        }
        .dataBox img.main-img {
            margin: 5rem 0px;
        }

        div#connectionForm {
            padding: 20px 20px;
        }
    </style>
    <section id="basic-vertical-layouts" class="freeConnection my-5">
        <div class="posHeader text-center" style="margin-top: 6em;margin-bottom:20px">
            {{-- <a class="brand-logo m-0" href="/">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
            </a> --}}
            {{-- <p class="my-2">Please fill login details</p> --}}
        </div>
        <div class="posActivePage">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="dataBox">
                        {{-- <img src="{{ asset('images/partner/pos-activation.png') }}" alt="pos-activation"
                            class="w-100 main-img"> --}}
                        <p class="text-start">In a world where instant communication is crucial for business, tap into the potential of
                            WhatsApp Business API with WApost. Empower your partners with effortless communication channels
                            connecting them directly with their customers, while diversifying additional revenue streams.
                            Partnering with WAPost offers a seamlessly integrable and cost-effective conversational
                            solution, revolutionising your partners interactions with their audience.
                        </p>
                        <br>
                        <p class="text-center">Connect with us now!</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div id="connectionForm">
                        <h6 class="text-free-color mb-2">Fill in Details</h6>
                        <form class="form validationforms becomeForm" id="bepartnerForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label class="form-label required" for="firstname" aria-required="true">
                                        Name</label>
                                    <input id="firstname" type="text" class="form-control " name="firstname"
                                        value="" minlength="2" autocomplete="firstname" aria-required="true"
                                        required="">
                                </div>

                                {{-- <div class="mb-2 col-md-12">
                                    <label class="form-label" for="lastname">Last name</label>
                                    <input id="lastname" type="text" class="form-control " name="lastname"
                                        value="" autocomplete="lastname">
                                </div> --}}

                                <div class="col-md-12 mb-2">
                                    <label class="form-label required" for="mobile" aria-required="true">WhatsApp Number</label>
                                    <input type="number" id="mobile" class="form-control required " name="mobile"
                                        required="" value="" maxlength="10" minlength="10" aria-required="true"
                                        autocomplete="off" data-intl-tel-input-id="0">
                                    <label id="mobile-error" class="error" for="mobile" style="display:none"></label>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" class="form-control"
                                        name="email">

                                </div>
                                <div class="col-md-12 mb-1">
                                    <input class="submit btn btn-success btn-submit" type="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p class="mb-5 h-25"></p>
    </section>
@endsection
@section('page-script')
    <script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script>
        $(document).ready(function() {
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
                "Please enter a valid email address!"
            );

            // validate signup form on keyup and submit
            var form = $("#bepartnerForm");
            form.validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 2,
                    },
                    email: {
                        // required: false,
                        customEmail: true,
                    },
                    mobile: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10,
                        customPhoneValidation: true,
                    },
                },
                messages: {
                    firstname: {
                        required: "Please enter your firstname",
                        minlength: "Please enter at least 2 characters."
                    },
                    mobile: {
                        required: "Please provide a mobile number",
                        minlength: "Your password must be at least 10 digits long"
                    },
                    email: {
                        // required: "Please enter your email address.",
                        email: "Please enter a valid email address!",
                        remote: "Email ID Already registered",
                    },
                }
            });
        });

        $(document).ready(function() {
            var form = $("#bepartnerForm");
            form.submit(function(e) {
                e.preventDefault();
                if (form.valid() === false) {
                    e.preventDefault();
                    return false;
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('Customer.storePartner') }}',
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('.btn-success').val("Please Wait....");
                        },
                        success: function(data) {
                            if (data && data.status == true) {
                                // Use SweetAlert for success message

                                window.location.href = '{{ route('Customer.thankYouPartner') }}';
                            
                                // Reset the form
                                $('#firstname').val('');
                                $('#lastname').val('');
                                $('#mobile').val('');
                                $('#email').val('');

                                // Clear any previous validation errors
                                $('#bepartnerForm .error').html('');
                                // Optionally, hide any success message container
                                $('.success-message').hide();
                                $('.btn-success').val("Submit");
                            }
                        },
                        error: function(error) {
                            // Handle error, e.g., show validation errors
                            var errors = error.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                // Display validation errors next to corresponding form fields
                                $('#' + key + '-error').html(value[0]);
                            });
                            $('.btn-success').val("Submit");
                        }
                    });
                }
            });
        });
        $('#mobile').on('keypress', function(event) {
            if (event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
            const value = event.target.value
            if (value.length > 9) {
                event.preventDefault();
            }
        });
    </script>
@endsection
