@extends('layouts/contentLayoutMaster')

@section('title', __('Developer\'s API Documentation'))

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

                    <div class="row">
                        <div class="col-lg-3">
                            <div class="sticky-top pb-3" style="top: 0rem;">
                                <div class="card mb-0">
                                    <div class="card-body p-0">
                                        <div class="list-group" id="menu_cs_api_doc">
                                            <a href="#docs_sec_1"
                                                class="list-group-item list-group-item-action border-0 clickscroll">What is
                                                wapost.net Messaging API?</a>
                                            <a href="#docs_sec_3"
                                                class="list-group-item list-group-item-action border-0 clickscroll">Parameters</a>
                                            <a href="#docs_sec_4"
                                                class="list-group-item list-group-item-action border-0 clickscroll">GET
                                                Method</a>
                                            <a href="#docs_sec_5"
                                                class="list-group-item list-group-item-action border-0 clickscroll">POST
                                                Method</a>
                                            <a href="#docs_sec_6"
                                                class="list-group-item list-group-item-action border-0 clickscroll">Success
                                                Response</a>
                                            <a href="#docs_sec_7"
                                                class="list-group-item list-group-item-action border-0 clickscroll">Error
                                                Response</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">

                            <div class="card" style="overflow: hidden;">
                                <div class="card-body p-0">

                                    <div class="border-bottom" id="docs_sec_1">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pb-md-5 pb-4 pt-md-5">
                                                    <p class="text-primary h6 mb-4"><b>What is wapost.net Messaging
                                                            API?</b>
                                                    </p>
                                                    <p class="mb-0">The wapost.net Messaging API allows you to
                                                        integrate
                                                        your billing software and send messages to your customer’s WhatsApp.
                                                        You can
                                                        send billing messages, notifications, alerts, offers, and any custom
                                                        message
                                                        to individual customers directly on their WhatsApp.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pb-md-5 d-none d-md-block">
                                                    <div class="code-area">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom" id="docs_sec_2">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                                    <p class="text-primary h6 mb-4"><b>Introduction</b></p>
                                                    <p class="mb-0">
                                                        wapost.net Messaging API calls are sent to the <span
                                                            class="h6"><code>/api/v3/whatsapp-message/send</code></span>
                                                        endpoint regardless of message text type, but the content of the
                                                        JSON
                                                        message body differs for text of message. See the following
                                                        documentation
                                                        for information regarding the type of messages you want to send
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pt-md-5 pb-md-5">
                                                    <div class="code-area">
                                                        <p class="mb-0"><code class="text-info">Endpoint</code></p>
                                                        <p class="mb-0">/api/v3/whatsapp-message/send</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom" id="docs_sec_3">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pb-md-5 pb-4 pt-5">
                                                    <p class="text-primary h6 mb-4"><b>Parameters</b></p>
                                                    <p class="mb-2">Every API request supports the following parameters.
                                                    </p>
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-bordered table-striped parameter-table table-sm mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Parameter</th>
                                                                    <th>Type</th>
                                                                    <th>Info</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>username</td>
                                                                    <td>string</td>
                                                                    <td>Autogenerated by the system after successfully QR
                                                                        code scan.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>password</td>
                                                                    <td>string</td>
                                                                    <td>Autogenerated by the system after successfully QR
                                                                        code scan.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>mobile</td>
                                                                    <td>12 Digits Number</td>
                                                                    <td>Include 91 before 10 digit WA mobile number where
                                                                        you want
                                                                        to send message</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>sendername</td>
                                                                    <td>6 Digit Alphabet</td>
                                                                    <td>Autogenerated by the system after successfully QR
                                                                        code scan.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>message</td>
                                                                    <td>string</td>
                                                                    <td>text</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>routetype</td>
                                                                    <td>boolean</td>
                                                                    <td>"0" or "1"</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pb-md-5 pt-md-5 d-none d-md-block">
                                                    <div class="code-area">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom" id="docs_sec_4">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                                    <p class="text-primary h6 mb-4"><b>API integration using <span
                                                                class="text-danger">GET</span> Method</b></p>
                                                    <p class="mb-1">Here is the example of wapost.net Messaging API
                                                        from
                                                        the <b class="text-danger">GET Method</b>.</p>
                                                    <p class="mb-0">URL addresses that you need to use to connect to
                                                        wapost.net WA API is:</p>
                                                    <p><code>{{url('/')}}/api/v3/whatsapp-message/send?</code>
                                                    </p>
                                                    <p class="mb-0">Just copy &amp; paste this URL in your POS
                                                        system/Billing
                                                        system.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pt-md-5 pb-md-5">
                                                    <div class="code-area">
                                                        <code class="text-success">GET/</code>
                                                        <p class="mb-0">
                                                            {{url('/')}}/api/v3/whatsapp-message/send?username={{ $apiDetail->username ?? '' }}&amp;password={{ $apiDetail->password ?? '' }}&amp;mobile=91XXXXXXXXXX&amp;sendername={{ $apiDetail->sendername ?? '' }}&amp;message=Thanks
                                                            for visiting and choosing Postpaid Testing
                                                            We would be pleased to serve you again.
                                                            wapost&amp;routetype=1</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom" id="docs_sec_5">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                                    <p class="text-primary h6 mb-4"><b>API integration using <span
                                                                class="text-danger">POST</span> Method</b></p>
                                                    <p class="mb-0">Here is the example of wapost.net Messaging API
                                                        from
                                                        the <b class="text-danger">POST Method</b>.</p>
                                                    <p class="mb-0">URL addresses that you need to use to connect to
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
                                                                        wapost</td>
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

                                    <div class="border-bottom" id="docs_sec_6">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                                    <p class="text-primary h6 mb-4"><b>API Success Response</b></p>
                                                    <p class="mb-0">Here is the example of the success response of the
                                                        wapost.net Messaging API. All the responce are return in the
                                                        <code>JSON</code> format.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pt-md-5 pb-md-5">
                                                    <div class="code-area">
                                                        <code class="text-warning mb-2 d-block">JSON</code>
                                                        <div>
                                                            <pre class="text-white cp_responce" id="cp_responce1">{
    "status": "success",
    "message": "WhatsApp message has sent successfully",
    "data": {
        "error": false,
        "data": {
            "key": {
                "remoteJid": "91XXXXXXXXXX@s.whatsapp.net",
                "fromMe": true,
                "id": "BAE5EAF25A7B3986"
            },
            "message": {
                "extendedTextMessage": {
                    "text": "Thanks for visiting and choosing WapostTestFree We would be pleased to serve you again."
                }
            },
            "messageTimestamp": "1702032079",
            "status": "PENDING"
        }
    }
}
                                                                </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-bottom" id="docs_sec_7">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="p-3 lh-normal pt-5 pb-md-5 pb-4">
                                                    <p class="text-primary h6 mb-4"><b>API Error Responses</b></p>
                                                    <p class="mb-1">Here is the example of the error response of the
                                                        wapost.net Messaging API. All the responce are return in the
                                                        <code>JSON</code> format.
                                                    </p>
                                                    <p class="mb-0">Below is the list of error messages:</p>
                                                    <ul class="mb-0">
                                                        <li>Sendername is invalid.</li>
                                                        <li>Whatsapp number is invalid.</li>
                                                        <li>Messaging Api data not found.</li>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="h-100 bg-black p-3 pt-md-5 pb-md-5">
                                                    <div class="code-area">
                                                        <code class="text-warning mb-2 d-block">JSON</code>
                                                        <div>
                                                            <pre class="text-white cp_responce" id="cp_responce2">{
"status": false,
"data": [],
"message": "Validation errors."
}</pre>
                                                        </div>
                                                    </div>
                                                </div>
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
        $(document).ready(function() {
            $(".clickscroll").click(function(event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 500);
            });
        });
    </script>
@endsection
