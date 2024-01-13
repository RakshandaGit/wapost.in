<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Free Connection</title>
</head>

<body>
    <!-- Basic Vertical form layout section start -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    <section id="basic-vertical-layouts" class="freeConnection">
        <div class="posHeader text-center">
            <a class="brand-logo m-0" href="/">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
            </a>
            <p class="my-2">Please scan the QR code from the number you would like to send <br> WhatsApp messages to
                your
                customers</p>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
        <div class="posActivePage">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="scannerBox">
                        <p class="mb-2 fw-bolder">Scan QR, to start sending messages.</p>
                        <p class="mb-1">
                            Code will change in
                            <b>
                                <span class="text-danger js-timeout">0:59</span>
                                sec.
                            </b>
                        </p>

                        <div class="wa-qr" id="qr_code_img">

                            <div class="reload-qr">
                                <div class="circle-reload" data-toggle="tooltip" title=""
                                    data-original-title="Refresh QR code">
                                    <i class="fa fa-redo-alt fa-3x fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div id="disconnected" class="main-connectscanner">
                        <h6 class="text-free-color mb-2">Steps to Connect WhatsApp</h6>

                        <ul class="list-unstyled list-unstyled-border mb-0">
                            <li class="media align-items-center">
                                <div class="step-num">
                                    <p>01.</p>
                                </div>
                                <div class="media-body">
                                    <div class="media-title fw-bold lh-2">Open WhatsApp</div>
                                    <div class="text-muted lh-2">Open WhatsApp application
                                        on
                                        your
                                        phone.</div>
                                </div>
                            </li>
                            <li class="media align-items-center">
                                <div class="step-num">
                                    <p>02.</p>
                                </div>
                                <div class="media-body">
                                    <div class="media-title fw-bold lh-2">Select Linked Devices
                                    </div>
                                    <div class="text-muted lh-2">Tap on
                                        <span class="">
                                            <svg height="18px" viewBox="0 0 24 24" width="18px">
                                                <rect fill="#f2f2f2" height="24" rx="3" width="24">
                                                </rect>
                                                <path
                                                    d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                                                    fill="#818b90"></path>
                                            </svg>
                                        </span>
                                        Menu or
                                        <span class="">
                                            <svg width="18" height="18" viewBox="0 0 24 24">
                                                <rect fill="#F2F2F2" width="24" height="24" rx="3">
                                                </rect>
                                                <path
                                                    d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                                                    fill="#818b90"></path>
                                            </svg>
                                        </span>
                                        Settings and select <b class="text-free-color">Linked
                                            Devices</b>
                                    </div>
                                </div>
                            </li>
                            <li class="media align-items-center">
                                <div class="step-num">
                                    <p>03.</p>
                                </div>
                                <div class="media-body">
                                    <div class="media-title fw-bold lh-2">Scan QR Code</div>
                                    <div class="text-muted lh-2">Tap on <b class="text-free-color">Link
                                            a Device</b> and Point your phone to this screen
                                        to
                                        <b class="text-free-color">capture the code</b>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <p class="mb-5 h-25"></p>
    </section>
    <!-- // Basic Vertical form layout section end -->

    <section id="basic-vertical-layouts" class="freeConnection freeRegister pb-4" style="display: none">
        <div class="posHeader text-center">
            <a class="brand-logo m-0" href="/">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
            </a>
            {{-- <p class="my-2">Please fill login details</p> --}}
        </div>
        <div class="posActivePage">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="dataBox">
                        <div id="connected" class="py-1 px-1 rounded" style="background: #f4fff8;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="d-md-flex">
                                        {{-- <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image"
                                                src="https://pps.whatsapp.net/v/t61.24694-24/309726448_645168360732293_4554821732045755499_n.jpg?ccb=11-4&amp;oh=01_AdSkeHf8FdtdZBVmNl4gEpy-QAauD4X6gWTNY3GDGIdzeQ&amp;oe=657E5760&amp;_nc_sid=e6ed6c&amp;_nc_cat=102"
                                                class="img-fluid" data-toggle="tooltip" title=""
                                                data-original-title="">
                                        </div> --}}
                                        <div>
                                            <p class="h5"><span id="wa-mobile">91XXXXXXXXXX</span><small
                                                    id="wa_name">(<span
                                                        id="wa-address">91XXXXXXXXXX@s.whatsapp.net</span>)</small></p>
                                            <p class="mb-0"><i class="fa fa-wifi text-primary mr-2"></i>
                                                State: <span class="badge text-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="{{ asset('images/partner/pos-activation.png') }}" alt="pos-activation"
                            class="w-100 main-img">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div id="connectionForm">
                        <h6 class="text-free-color mb-2">Fill in Details</h6>

                        <form method="POST" action="{{ URL::to('register-pos-user') }}" id="connectForm"
                            novalidate="novalidate">
                            @csrf
                            <input type="hidden" id="whatsappDetails" name="whatsapp_details">
                            <input type="hidden" name="enterprise_id" value="{{ $enterprise_id }}">
                            <input type="hidden" name="enterprise_user_id" value="{{ $enterprise_user_id }}">
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label class="form-label required" for="first_name" aria-required="true">First
                                        name <span class="text-danger">*</span></label>
                                    <input id="first_name" type="text" class="form-control " name="first_name"
                                        value="" minlength="2" require autocomplete="first_name"
                                        aria-required="true">
                                </div>

                                <div class="mb-1 col-md-12">
                                    <label class="form-label" for="last_name">Last name</label>
                                    <input id="last_name" type="text" class="form-control " name="last_name"
                                        value="" autocomplete="last_name">
                                </div>

                                <div class="col-md-12 mb-1">
                                    <label class="form-label required" for="phone"
                                        aria-required="true">Phone <span class="text-danger">*</span></label>
                                    <input type="number" id="phone" class="form-control required "
                                        name="phone" required="" value="" maxlength="10" minlength="10"
                                        aria-required="true" autocomplete="off" data-intl-tel-input-id="0">
                                    <label id="phone-error" class="error" for="phone"></label>
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label class="form-label required" for="email"
                                        aria-required="true">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" class="form-control required "
                                        value="" name="email" required="" aria-required="true">

                                </div>
                                <div class="col-md-12 mb-1">
                                    <label class="form-label required" for="password"
                                        aria-required="true">Password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" id="password" class="form-control " value=""
                                            name="password" required="" aria-required="true">
                                        <span onclick="toggle_pass()" class="field_icon cursor-pointer"><i
                                                class="fa fa-fw fa-eye"></i></span>
                                    </div>
                                    <label id="password-error" class="error valid" for="password"></label>
                                </div>

                                <div class="col-md-12 mb-1">
                                    <label class="form-label required" for="password_confirmation"
                                        aria-required="true">Confirm password <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" id="password_confirmation" class="form-control "
                                            value="" name="password_confirmation" required=""
                                            aria-required="true">
                                        <span onclick="toggle_confpass()" class="field_icon cursor-pointer-toggle"><i
                                                class="fa fa-fw fa-eye"></i></span>
                                    </div>
                                    <label id="password_confirmation-error" class="error"
                                        for="password_confirmation"></label>
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
    <script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>
    <script>
        var interval;
        var n = 0;
        var QrScaned = false;
        var start = Date.now();
        get_wa_token();

        function callNow(instance_key) {
            if (QrScaned != true) {
                get_key_info(instance_key);
            }
        }

        function updateBeat() {
            n = parseInt(n) + 1;
        }

        function checkNow() {
            if (n >= 3) {
                clearInterval(interval);
                return true;
            } else {
                return false;
            }
        }

        function get_wa_token() {
            $("#qr_code_img img").remove();
            $('.reload-qr').show();
            $.ajax({
                url: '{{ $wa_api_url }}instance/init-for-pos-user',
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    if (res.error == false) {
                        // $('#instance_key').text();
                        // $('#instance_key').text(res.instance_key);
                        setTimeout(function() {
                            get_qrcode(res.key);
                        }, 2000);

                    }
                }
            });
        }

        /* get QR Code */
        function get_qrcode(instance_key) {

            $.ajax({
                url: '{{ $wa_api_url }}instance/qrbase64?key=' + instance_key,
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    if (res.error == false) {
                        var image = new Image();
                        image.src = res.qrcode;
                        $('.reload-qr').hide();
                        $('#qr_code_img').append(image);
                        $('.js-timeout').html('0:59');
                        countdown();
                        intervalCallNow = setInterval(function() {
                            callNow(instance_key);
                        }, 4000)
                    }
                }
            });
        }

        function countdown() {
            clearInterval(interval);
            interval = setInterval(function() {
                var timer = $('.js-timeout').html();
                timer = timer.split(':');
                var minutes = timer[0];
                var seconds = timer[1];
                seconds -= 1;
                if (minutes < 0)
                    return;
                else if (seconds < 0 && minutes != 0) {
                    minutes -= 1;
                    seconds = 59;
                } else if (seconds < 10 && length.seconds != 2)
                    seconds = '0' + seconds;
                $('.js-timeout').html(minutes + ':' + seconds);

                if (minutes == 0 && seconds == 0)
                    clearInterval(interval);

                var timeout = $('.js-timeout').html();
                if (timeout == '0:00') {
                    countdown2()
                }
            }, 1000);
        }

        function countdown2() {
            if (checkNow()) {
                var image = new Image();
                image.src = "{{ asset('public/images/click-to-reload1.jpg') }}";
                $('.reload-qr').hide();
                $("#qr_code_img img:last-child").remove()
                $('#qr_code_img').append(image);
                $("#qr_code_img img:last-child").attr('id', 'onClickReloadQR');
                $('#countdownTest').html('');
                $('#countdownTest').html(
                    '<span>Code will not change </span><b><span class="text-danger js-timeout">until</span> you reload.</b>'
                );

                clearInterval(interval);
                return false;
            }
            updateBeat();
            get_wa_token();
        }


        /* check instance id is connected or not*/
        function get_key_info(instance_key) {
            let phone_connected = false;
            if (QrScaned != true) {
                $.ajax({
                    url: '{{ $wa_api_url }}instance/info?key=' + instance_key,
                    type: 'GET',
                    dataType: "json",
                    success: function(res) {
                        phone_connected = res.instance_data.phone_connected;
                        if (res.error == false && (phone_connected != undefined || phone_connected == true)) {
                            let wa_data = set_key(res.instance_data);
                            let number = res.instance_data.user.id.split(':');
                            $('#disconnected').hide();
                            $('#connected img').attr('title', number[0]);
                            $('#connected #wa_name').text('');
                            $('#connected #wa_name').text('(' + res.instance_data.user.id + ')');
                            $('#connected #wa_number').text('');
                            $('#connected #wa_number').text(number[0]);
                            $('#connected').show();

                            clearInterval(interval);
                            clearInterval(intervalCallNow);
                            QrScaned = true;
                        } else {
                            console.log('Not Connected');
                        }
                    }
                });
            }
        }

        /* inserting instance data into database */
        function set_key(instance_data) {
            var jid = instance_data.user.id;
            var number = jid.split(':');
            var instance_key = instance_data.instance_key;
            $('#wa-mobile').text(number[0])
            $('#wa-address').text(jid)

            var whatsappDetails = {
                "jid": jid,
                "number": number[0],
                "instance_key": instance_key
            }

            var is_existed_user = "{{ $is_existed_user }}";
            var existed_user_email = "{{ $existed_user_email }}";

            if (is_existed_user == 1) {
                location.href = "{{ URL::to('thank-you') }}?email=" + existed_user_email + "&whatsapp_details=" + JSON
                    .stringify(whatsappDetails);
            } else {
                $('.freeConnection').hide();
                $('.freeConnection.freeRegister').show();
                $('#whatsappDetails').val(JSON.stringify(whatsappDetails))
            }

            // $.ajax({
            //     url: "{{ route('customer.set_instance') }}",
            //     type: 'POST',
            //     data: {
            //         "jid": jid,
            //         "number": number[0],
            //         "instance_key": instance_key,
            //         "_token": $('meta[name="csrf-token"]').attr('content')
            //     },
            //     dataType: "json",
            //     success: function(res) {
            //         console.log('set_key: ', res);
            //         // window.location.reload();
            //         alert('Page EndUser')
            //         if (res.error == false) {
            //             $('#instance_key').text();
            //             $('#instance_key').text(instance_key);
            //         } else {
            //             $('#instance_key').text(instance_key);
            //             logout();
            //         }
            //     }
            // });
        }
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
            // validate signup form on keyup and submit
            $("#connectForm").validate({
                rules: {
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
                        equalTo: "#password"
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter your firstname",
                        minlength: "Please enter at least 2 characters."
                    },
                    phone: {
                        required: "Please provide a mobile number",
                        minlength: "Your password must be at least 10 digits long"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    password_confirmation: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long",
                        equalTo: "Entered Password and Confirm password do not match"
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address.",
                        remote: "Email ID Already registered",
                    },
                }
            });
        });
        $('#phone').on('keypress', function(event) {
            if (event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
            const value = event.target.value
            if (value.length > 9) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>
