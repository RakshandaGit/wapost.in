@extends('layouts/contentLayoutMaster')

@section('title', __('API Integration'))

@section('content')
    <!-- Basic Vertical form layout section start -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    <section id="basic-vertical-layouts" class="apiIntegration">
        <div class="main-content" style="min-height: 546px;">


            <section class="section">
                <div class="section-body">


                    <div class="row align-items-center">
                        <div class="col-sm-5 mb-3">
                            <a href="{{ route('customer.developerDocs') }}" class="btn btn-primary"><i
                                    class="far fa-copy copy-ico"></i> Documentation</a>
                        </div>

                        <div class="col-sm-7 mb-3">
                            {{-- <div>

                                <div class="form-group mb-0">

                                    <div class="custom-switches-stacked flex-row justify-content-end">


                                        <label class="message-route-toggle custom-switch mb-0 pl-0" id="wa_4"
                                            data-toggle="tooltip" title="" data-original-title="WhatsApp Message">
                                            <input type="checkbox" data-toggle="toggle" name="message_route"
                                                value="0" class="custom-switch-input set-wa_4" data-route_name="wa">
                                            <span class="custom-switch-description ml-0 mr-1"><i
                                                    class="fab fa-whatsapp"></i></span>
                                            <span class="custom-switch-indicator"></span>
                                        </label>


                                        <label class="message-route-toggle custom-switch mb-0 pl-4" id="sms_4"
                                            data-toggle="tooltip" title="" style="opacity: 1;"
                                            data-original-title="SMS Message">
                                            <input type="checkbox" data-toggle="toggle" name="message_route"
                                                value="1" class="custom-switch-input set-sms_4" checked=""
                                                data-route_name="sms">
                                            <span class="custom-switch-description ml-0 mr-1"><i
                                                    class="far fa-comment-dots"></i></span>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Get your Credentials</h4>
                        </div>
                        <div class="card-body">
                            <p>Click below button to get your credential for integration with Messaging API.</p>
                            <button class="btn btn-primary px-3" onclick="credential();">
                                Get Credentials <i class="fas fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                    </div>


                    <div class="card" style="overflow: hidden;">
                        <div class="card-body p-0">
                            <div class="border-bottom">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="p-3 lh-normal pb-md-5 pb-4">
                                            <p class="text-primary"><b>API (GET Method)</b></p>
                                            <p>Here is the example of wapost.net Messaging API from the <b
                                                    class="text-danger">GET Method</b>.</p>
                                            <p class="mb-1">URL addresses that you need to use to connect to
                                                wapost.net WA API is:</p>
                                            <p><code>{{url('/')}}/api/v3/whatsapp-message/send?</code></p>
                                            <p class="mb-0">Just copy &amp; paste this URL in your POS system/Billing
                                                system.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="h-100 bg-black p-3 pb-md-5">
                                            <div class="code-area">
                                                <code class="text-success">GET/</code>
                                                <p class="mb-0">
                                                    {{url('/')}}/api/v3/whatsapp-message/send?username={{ $apiDetail->username ?? '' }}&amp;password={{ $apiDetail->password ?? '' }}&amp;mobile=91XXXXXXXXXX&amp;sendername={{ $apiDetail->sendername ?? '' }}&amp;message=Thanks
                                                    for visiting and choosing Postpaid Testing
                                                    We would be pleased to serve you again.
                                                    WAPOST&amp;routetype=1</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                            <p class="text-primary"><b>API (POST Method)</b></p>
                                            <p>Here is the example of wapost.net Messaging API from the <b
                                                    class="text-danger">POST Method</b>.</p>
                                            <p class="mb-1">URL addresses that you need to use to connect to
                                                wapost.net WA API is:</p>
                                            <p class="mb-0">
                                                <code>{{url('/')}}/api/v3/whatsapp-message/send</code>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="h-100 bg-black p-3 pt-md-5 pb-md-5">
                                            <div class="code-area">
                                                <code class="text-success">POST/</code>
                                                <p><code>URL:</code>
                                                    {{url('/')}}/api/v3/whatsapp-message/send</p>
                                                <p class="mb-0"><code>Parameters:</code></p>
                                                <table class="w-100 para-table mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 75px">username</td>
                                                            <td>:</td>
                                                            <td>{{ $apiDetail->username ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>password</td>
                                                            <td>:</td>
                                                            <td>{{ $apiDetail->password ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>mobile</td>
                                                            <td>:</td>
                                                            <td>91XXXXXXXXXX</td>
                                                        </tr>
                                                        <tr>
                                                            <td>sendername</td>
                                                            <td>:</td>
                                                            <td>{{ $apiDetail->sendername ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>message</td>
                                                            <td>:</td>
                                                            <td>Thanks for visiting and choosing Postpaid Testing
                                                                We would be pleased to serve you again.
                                                                WAPOST</td>
                                                        </tr>
                                                        <tr>
                                                            <td>routetype</td>
                                                            <td>:</td>
                                                            <td>1</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </section>
        </div>
    </section>
    <script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <!-- // Basic Vertical form layout section end -->


@endsection


@section('page-script')
    <script>
        function credential() {
            var username = "{{ $apiDetail->username ?? '' }}";
            var password = "{{ $apiDetail->password ?? '' }}";
            var sendername = "{{ $apiDetail->sendername ?? '' }}";

            Swal.fire({
                title: '<h5>Credentials</h5>',
                text: 'You clicked the button!',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                showCloseButton: true,
                html: '<table class="table text-start border-0 table-sm mx-auto credentialPopup" style="max-width:320px;">' +
                    '<tr>' +
                    '<td style="color:#237cd8;font-weight:500;">Username</td>' +
                    '<td>:</td>' +
                    '<td><font face="monospace" id="un_copy">' + username + '</font></td>' +
                    '<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#un_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="color:#237cd8;font-weight:500;">Password</td>' +
                    '<td>:</td>' +
                    '<td><font face="monospace" id="pw_copy">' + password + '</font></td>' +
                    '<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#pw_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td style="color:#237cd8;font-weight:500;">Sender Name</td>' +
                    '<td>:</td>' +
                    '<td><font face="monospace" id="sn_copy">' + sendername + '</font></td>' +
                    '<td><i class="far fa-copy copy-ico" data-toggle="tooltip" title="Copy" onclick="copyToClipboard(\'#sn_copy\');$(this).attr(\'title\',\'Copied!\');"></i></td>' +
                    '</tr>' +
                    '</table>',
            })
        }

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
        $(document).ready(function() {
            $(".copy-btn").on("click", function(event) {
                event.preventDefault();
                var element = $(this).data("copy");
                copyToClipboard(element);
                $(this).parent("div.copy-parent").prepend('<span style="font-size:10px;">Copied!</span>');
                setTimeout(() => {
                    $(this).parent("div.copy-parent").children('span').remove();
                }, 3000);
            })
        });
    </script>
@endsection
