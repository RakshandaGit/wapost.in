@extends('layouts/contentLayoutMaster')

@section('title', __('WhatsApp Connetion'))
@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> --}}
    <style>
        .default.alert-info {
            color: #0c5460 !important;
            background-color: #f4fbfc !important;
            border: 1px solid #99c5cc;
            padding: 1rem;
        }

        .step-num {
            margin-right: 15px;
            width: 48px;
        }

        .step-num p {
            font-size: 2rem;
            margin-bottom: 0px;
            line-height: 1;
            color: #d9e3f3;
        }

        .wa-div {
            position: relative;
            width: 100%;
            max-width: 280px;
            margin: auto;
        }

        .wa-qr {
            position: relative;
            width: 100%;
            height: auto;
            /*padding: 5px 0px;*/
            border: 2px solid #128C7E;
            text-align: center;
        }

        .wa-qr img {
            width: 100%;
        }

        .reload-qr {
            width: 100%;
            height: 100%;
            min-height: 280px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reload-qr .circle-reload {
            display: inline;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #128C7E;
            color: #ffffff;
            text-align: center;
        }

        .reload-qr .circle-reload i {
            line-height: 80px;
        }

        #onClickReloadQR {
            cursor: pointer;
        }

        .list-unstyled-border li {
            border-bottom: 1px solid #f9f9f9;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .media .media-title {
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 15px;
            color: #34395e;
        }

        .badge {
            color: #bd8b08;
        }

        .avatar-item {
            margin-right: 1rem;
        }

        .avatar-item img {
            border-radius: 50%;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .declaration-box {
            background: #F5515F !important;
            border-color: #F5515F;
            color: #fff !important;
            padding: 20px;
        }

        .declaration-box p b {
            font-size: 24px;
        }

        .declaration-box p {
            font-size: 16px;
            line-height: 22px !important;
        }

        .declaration-box a {
            color: #2d2d2d;
            font-weight: 900;
            letter-spacing: 0;
        }

        #decalrationStatus-error {
            color: red;
        }
    </style>
@endsection

@section('content')
    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts" class="mt-2">
        @if (Auth::user()->is_accept_connection_declaration)
            <div class="row match-height">
                <div class="col-md-12 col-12">

                    <div class="card">
                        {{-- <div class="card-header">
                        <h4 class="card-title">{{ __('WhatsApp Connetion') }}</h4>
                    </div> --}}
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-pane fade active show" id="contact6" role="tabpanel"
                                    aria-labelledby="contact_tab6">
                                    <div class="p-1 p-md-2 p-lg-2">
                                        <div class="default alert mb-1 declaration-box">
                                            <p class="mb-2 lh-1"><b>Declaration</b></p>
                                            <p class="mb-0 small lh-1">
                                                All messages sent using WA Post via WhatsApp should comply the required
                                                terms
                                                and conditions, privacy policies laid down by WhatsApp.
                                                In case of violation of rules WhatsApp may block the number.
                                            </p>
                                            <p class="mb-0 small lh-1">
                                                WA Post is not liable for any misuse of the platform.
                                            </p>
                                            <p class="mb-0 small lh-1">
                                                For more details on WhatsApp norms please
                                                <a href="https://www.whatsapp.com/legal/terms-of-service/?lang=en"
                                                    target="_blank">Click Here.</a>
                                            </p>
                                        </div>

                                        <div class="default alert alert-info mb-4">
                                            <p class="mb-2 lh-1"><b>WhatsApp Setting</b></p>
                                            <p class="mb-0 small lh-2">Connect your WhatsApp with WAPost.net via QR code to
                                                start sharing your messages. This will allow you to send quick message,
                                                campaign
                                                scheduling & more...</p>
                                        </div>

                                        @if (count($connections) > 0)
                                            <div class="row multicon-box mb-3">
                                                <div class="col-md-4 col-sm-12 col-12">
                                                    <div class="add-morebtn">
                                                        @if (count($connections) < Auth::user()->customer?->subscription?->addons_connections + 1)
                                                            <button id="addmorebtn" onclick="addMoreConnection()"
                                                                class="mb-3 btn btn-success btn-submit waves-effect waves-float waves-light">Add
                                                                Connection</button>
                                                        @else
                                                            <a href="{{ route('customer.subscriptions.addons', Auth::user()->customer?->subscription?->uid) }}"
                                                                id="addmorebtn"
                                                                class="mb-3 btn btn-common flat-btn btn-active btn-submit waves-effect waves-float waves-light">Buy
                                                                Add-On</a>
                                                        @endif
                                                        <p>You have utilised
                                                            {{ count($connections) > 1 ? count($connections) . ' connections' : '1 connection' }}
                                                            out of
                                                            {{ Auth::user()->customer?->subscription?->addons_connections + 1 }}
                                                            available connections.</p>
                                                        <div id="add-disconnected" class="main-connectscanner"
                                                            style="display: none">
                                                            <div class="d-flex flex-column mx-auto mb-4"
                                                                style="width: 100%;max-width:500px;">
                                                                <div class="">
                                                                    <div class="text-center mb-3" id="countdownTest">
                                                                        <span>Code will change in</span>
                                                                        <b><span class="text-danger js-timeout">0:59</span>
                                                                            sec.</b>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="wa-setting">
                                                                        <div class="wa-div">
                                                                            <div class="wa-qr" id="qr_code_img">

                                                                                <div class="reload-qr">
                                                                                    <div class="circle-reload"
                                                                                        data-toggle="tooltip" title=""
                                                                                        data-original-title="Refresh QR code">
                                                                                        <i
                                                                                            class="fa fa-redo-alt fa-3x fa-spin"></i>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div id="instance_key" style="display:none">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-12 col-12">
                                                    <div class="multiconnection-scroll">
                                                        @foreach ($connections as $k => $connection)
                                                            <div id="connected" class="py-2 px-2 rounded"
                                                                style="background: #f4fff8;">
                                                                <div class="row">
                                                                    <div class="col-lg-8 col-md-12">
                                                                        <div class="d-md-flex">
                                                                            <div class="avatar-item mb-3 mb-md-0 mr-3"
                                                                                style="max-width: 60px">
                                                                                <img alt="image"
                                                                                    src="{{ !empty($connection->avatar) ? $connection->avatar : URL::to('/') . '/avatar?63e23288e5d0d' }}"
                                                                                    class="img-fluid" data-toggle="tooltip"
                                                                                    title="" data-original-title="">
                                                                            </div>
                                                                            <div>
                                                                                <p class="mb-2 h5"><b
                                                                                        id="wa_number">{{ $connection->number }}</b>
                                                                                    <small id="wa_name">
                                                                                        @if ($connection->name != null)
                                                                                            ({{ $connection->name }})
                                                                                        @endif
                                                                                    </small>
                                                                                </p>
                                                                                <p class="mb-0"><i
                                                                                        class="fa fa-wifi text-primary mr-2"></i>
                                                                                    State: <span
                                                                                        class="badge badge-success py-1">Connected</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="col-lg-2 col-md-6 col-5">
                                                                        <div class="mb-3 mb-md-0 mr-3"
                                                                            style="text-align:center;margin-top:1rem;">
                                                                            <div
                                                                                class="form-check form-switch form-check-primary">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input get_status"
                                                                                    id="switchStatusId{{ $connection->id }}"
                                                                                    onclick="activeDeactiveStatus({{ $connection->id }}, {{ $connection->is_active ? 0 : 1 }})"
                                                                                    {{ $connection->is_active ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="switchStatusId{{ $connection->id }}">
                                                                                    <span class="switch-icon-left">Active
                                                                                    </span>
                                                                                    <span
                                                                                        class="switch-icon-right">Deactive</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="col-lg-3 col-md-6 col-7">
                                                                        <div class="mb-3 mb-md-0 mr-3"
                                                                            style="text-align:center;margin-top:1rem;">
                                                                            <button instance-key="{{ $connection->key }}"
                                                                                type="button" id="disconnect_account"
                                                                                class="btn btn-danger">Log out</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="instance_key" style="display:none">
                                                                {{ $connection->key }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex flex-column mx-auto mb-4"
                                                        style="width: 100%;max-width:500px;">
                                                        <div>
                                                            <div class="card card-body p-1 p-lg-3 mt-3">
                                                                <div class="d-flex">
                                                                    <div class="me-1 me-lg-3">
                                                                        <i class="fas fa-shield-alt mt-1 text-primary"
                                                                            style="font-size: 20px;"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="small mb-0" style="line-height: 1.7;">
                                                                            Your
                                                                            WhatsApp
                                                                            account will be secured with WAPost.net as we
                                                                            can't
                                                                            read,
                                                                            listen or store your personal or business
                                                                            conversation
                                                                            as
                                                                            per our data <a
                                                                                href="{{ route('privacy_policy') }}"
                                                                                target="_blank">Privacy policy</a>.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <h6 class="text-primary mb-4">Steps to Connect WhatsApp</h6>

                                                            <ul class="list-unstyled list-unstyled-border mb-0">
                                                                <li class="media align-items-center">
                                                                    <div class="step-num">
                                                                        <p>01.</p>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <div class="media-title lh-2">Open WhatsApp</div>
                                                                        <div class="text-muted lh-2">Open WhatsApp
                                                                            application
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
                                                                        <div class="media-title lh-2">Select Linked Devices
                                                                        </div>
                                                                        <div class="text-muted lh-2">Tap on
                                                                            <span class="">
                                                                                <svg height="18px" viewBox="0 0 24 24"
                                                                                    width="18px">
                                                                                    <rect fill="#f2f2f2" height="24"
                                                                                        rx="3" width="24">
                                                                                    </rect>
                                                                                    <path
                                                                                        d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                                                                                        fill="#818b90"></path>
                                                                                </svg>
                                                                            </span>
                                                                            Menu or
                                                                            <span class="">
                                                                                <svg width="18" height="18"
                                                                                    viewBox="0 0 24 24">
                                                                                    <rect fill="#F2F2F2" width="24"
                                                                                        height="24" rx="3">
                                                                                    </rect>
                                                                                    <path
                                                                                        d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                                                                                        fill="#818b90"></path>
                                                                                </svg>
                                                                            </span>
                                                                            Settings and select <b
                                                                                class="text-primary">Linked
                                                                                Devices</b>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="media align-items-center">
                                                                    <div class="step-num">
                                                                        <p>03.</p>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <div class="media-title lh-2">Scan QR Code</div>
                                                                        <div class="text-muted lh-2">Tap on <b
                                                                                class="text-primary">Link
                                                                                a Device</b> and Point your phone to this
                                                                            screen
                                                                            to
                                                                            <b class="text-primary">capture the code</b>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div id="disconnected" class="main-connectscanner">
                                                <div class="d-flex flex-column mx-auto mb-4"
                                                    style="width: 100%;max-width:500px;">
                                                    <div class="">
                                                        <div class="text-center mb-3" id="countdownTest">
                                                            <span>Code will change in</span>
                                                            <b><span class="text-danger js-timeout">0:59</span> sec.</b>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="wa-setting">
                                                            <div class="wa-div">
                                                                <div class="wa-qr" id="qr_code_img">

                                                                    <div class="reload-qr">
                                                                        <div class="circle-reload" data-toggle="tooltip"
                                                                            title=""
                                                                            data-original-title="Refresh QR code">
                                                                            <i class="fa fa-redo-alt fa-3x fa-spin"></i>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="instance_key" style="display:none"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="card card-body p-3 mt-3">
                                                            <div class="d-flex">
                                                                <div class="mr-3">
                                                                    <i class="fas fa-shield-alt mt-1 text-primary"
                                                                        style="font-size: 20px;"></i>
                                                                </div>
                                                                <div>
                                                                    <p class="small mb-0" style="line-height: 1.7;">Your
                                                                        WhatsApp
                                                                        account will be secured with WAPost.net as we can't
                                                                        read,
                                                                        listen or store your personal or business
                                                                        conversation
                                                                        as
                                                                        per our data <a
                                                                            href="{{ route('privacy_policy') }}"
                                                                            target="_blank">Privacy policy</a>.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <h6 class="text-primary mb-4">Steps to Connect WhatsApp</h6>

                                                        <ul class="list-unstyled list-unstyled-border mb-0">
                                                            <li class="media align-items-center">
                                                                <div class="step-num">
                                                                    <p>01.</p>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="media-title lh-2">Open WhatsApp</div>
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
                                                                    <div class="media-title lh-2">Select Linked Devices
                                                                    </div>
                                                                    <div class="text-muted lh-2">Tap on
                                                                        <span class="">
                                                                            <svg height="18px" viewBox="0 0 24 24"
                                                                                width="18px">
                                                                                <rect fill="#f2f2f2" height="24"
                                                                                    rx="3" width="24"></rect>
                                                                                <path
                                                                                    d="m12 15.5c.825 0 1.5.675 1.5 1.5s-.675 1.5-1.5 1.5-1.5-.675-1.5-1.5.675-1.5 1.5-1.5zm0-2c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5zm0-5c-.825 0-1.5-.675-1.5-1.5s.675-1.5 1.5-1.5 1.5.675 1.5 1.5-.675 1.5-1.5 1.5z"
                                                                                    fill="#818b90"></path>
                                                                            </svg>
                                                                        </span>
                                                                        Menu or
                                                                        <span class="">
                                                                            <svg width="18" height="18"
                                                                                viewBox="0 0 24 24">
                                                                                <rect fill="#F2F2F2" width="24"
                                                                                    height="24" rx="3"></rect>
                                                                                <path
                                                                                    d="M12 18.69c-1.08 0-2.1-.25-2.99-.71L11.43 14c.24.06.4.08.56.08.92 0 1.67-.59 1.99-1.59h4.62c-.26 3.49-3.05 6.2-6.6 6.2zm-1.04-6.67c0-.57.48-1.02 1.03-1.02.57 0 1.05.45 1.05 1.02 0 .57-.47 1.03-1.05 1.03-.54.01-1.03-.46-1.03-1.03zM5.4 12c0-2.29 1.08-4.28 2.78-5.49l2.39 4.08c-.42.42-.64.91-.64 1.44 0 .52.21 1 .65 1.44l-2.44 4C6.47 16.26 5.4 14.27 5.4 12zm8.57-.49c-.33-.97-1.08-1.54-1.99-1.54-.16 0-.32.02-.57.08L9.04 5.99c.89-.44 1.89-.69 2.96-.69 3.56 0 6.36 2.72 6.59 6.21h-4.62zM12 19.8c.22 0 .42-.02.65-.04l.44.84c.08.18.25.27.47.24.21-.03.33-.17.36-.38l.14-.93c.41-.11.82-.27 1.21-.44l.69.61c.15.15.33.17.54.07.17-.1.24-.27.2-.48l-.2-.92c.35-.24.69-.52.99-.82l.86.36c.2.08.37.05.53-.14.14-.15.15-.34.03-.52l-.5-.8c.25-.35.45-.73.63-1.12l.95.05c.21.01.37-.09.44-.29.07-.2.01-.38-.16-.51l-.73-.58c.1-.4.19-.83.22-1.27l.89-.28c.2-.07.31-.22.31-.43s-.11-.35-.31-.42l-.89-.28c-.03-.44-.12-.86-.22-1.27l.73-.59c.16-.12.22-.29.16-.5-.07-.2-.23-.31-.44-.29l-.95.04c-.18-.4-.39-.77-.63-1.12l.5-.8c.12-.17.1-.36-.03-.51-.16-.18-.33-.22-.53-.14l-.86.35c-.31-.3-.65-.58-.99-.82l.2-.91c.03-.22-.03-.4-.2-.49-.18-.1-.34-.09-.48.01l-.74.66c-.39-.18-.8-.32-1.21-.43l-.14-.93a.426.426 0 00-.36-.39c-.22-.03-.39.05-.47.22l-.44.84-.43-.02h-.22c-.22 0-.42.01-.65.03l-.44-.84c-.08-.17-.25-.25-.48-.22-.2.03-.33.17-.36.39l-.13.88c-.42.12-.83.26-1.22.44l-.69-.61c-.15-.15-.33-.17-.53-.06-.18.09-.24.26-.2.49l.2.91c-.36.24-.7.52-1 .82l-.86-.35c-.19-.09-.37-.05-.52.13-.14.15-.16.34-.04.51l.5.8c-.25.35-.45.72-.64 1.12l-.94-.04c-.21-.01-.37.1-.44.3-.07.2-.02.38.16.5l.73.59c-.1.41-.19.83-.22 1.27l-.89.29c-.21.07-.31.21-.31.42 0 .22.1.36.31.43l.89.28c.03.44.1.87.22 1.27l-.73.58c-.17.12-.22.31-.16.51.07.2.23.31.44.29l.94-.05c.18.39.39.77.63 1.12l-.5.8c-.12.18-.1.37.04.52.16.18.33.22.52.14l.86-.36c.3.31.64.58.99.82l-.2.92c-.04.22.03.39.2.49.2.1.38.08.54-.07l.69-.61c.39.17.8.33 1.21.44l.13.93c.03.21.16.35.37.39.22.03.39-.06.47-.24l.44-.84c.23.02.44.04.66.04z"
                                                                                    fill="#818b90"></path>
                                                                            </svg>
                                                                        </span>
                                                                        Settings and select <b class="text-primary">Linked
                                                                            Devices</b>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="media align-items-center">
                                                                <div class="step-num">
                                                                    <p>03.</p>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="media-title lh-2">Scan QR Code</div>
                                                                    <div class="text-muted lh-2">Tap on <b
                                                                            class="text-primary">Link
                                                                            a Device</b> and Point your phone to this screen
                                                                        to
                                                                        <b class="text-primary">capture the code</b>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="connected" class="p-3 rounded"
                                                style="background: #f4fff8; display:none ">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="d-md-flex">
                                                            <div class="avatar-item mb-3 mb-md-0 mr-3"
                                                                style="max-width: 60px">
                                                                <img alt="image"
                                                                    src="{{ !empty($connection->avatar) ? $connection->avatar : URL::to('/') . '/avatar?63e23288e5d0d' }}"
                                                                    class="img-fluid" data-toggle="tooltip"
                                                                    title="" data-original-title="">
                                                            </div>
                                                            <div>
                                                                <p class="mb-2 h5"><b id="wa_number"></b> <small
                                                                        id="wa_name">()</small> </p>
                                                                <p class="mb-0"><i
                                                                        class="fa fa-wifi text-primary mr-2"></i>
                                                                    State: <span
                                                                        class="badge badge-success py-1">Connected</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3 mb-md-0 mr-3"
                                                            style="text-align:center;margin-top:1rem;">
                                                            <button type="button" id="disconnect_account"
                                                                class="btn btn-danger">Disconnect</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div id="leadinModal-mode" class="leadinModal leadinModal-preview" tabindex="0">
                    <div class="leadinModal-overlay"></div>
                    <div class="leadinModal-content" role="dialog" aria-modal="true"
                        aria-label="Generate a Free Terms and Conditions Agreement">
                        <div class="leadinModal-content-wrapper" tabindex="-1">
                            <div class="leadin-content-body leadin-preview-wrapper-no-image">
                                <div class="leadin-preview-wrapper">
                                    <form class="validationforms" action="{{ URL::to('acceptMessageDeclaration') }}"
                                        method="post">
                                        @csrf
                                        <h4 class="text-center pb-2">Terms and Conditions Agreement</h4>
                                        <div tabindex="-1" class="leadinModal-hide-outline leadinModal-description">
                                            <div class="leadinModal-description-body">
                                                <p>Welcome to WA Post (the "Site") provided to you by Creative Networks.
                                                    (which will be referred to herein as either WA Post”, “we”, “us” or
                                                    “our”). The Site and any related services were created by us in order to
                                                    provide you with a much easier way to send messages and increase
                                                    business reach. These WA Post Terms & Conditions (the “Terms”) are made
                                                    under a set of rules required to run services.
                                                    By using WA Post, you acknowledge that you agree to the Terms of
                                                    Service. If you do not agree to this Terms of Service document, please
                                                    do not access WA Post. Carefully read all the Terms of service.
                                                </p>
                                                <h2>Platform Description:</h2>
                                                <p>The platform allows users to send bulk and custom WhatsApp messages to
                                                    multiple recipients simultaneously. The platform provides a
                                                    user-friendly interface and tools to facilitate message creation,
                                                    customization, and management.
                                                </p>
                                                <h2>User Responsibilities</h2>
                                                <p>
                                                    You acknowledge and agree that the platform is provided for legitimate
                                                    and lawful purposes. You are solely responsible for any messages you
                                                    send using the platform. You must not use the platform for any illegal,
                                                    abusive, harmful, fraudulent, or unauthorized purposes. In case of
                                                    violation of WhatsApp's rules & regulations, WhatsApp may block the
                                                    number. WA Post shall not be held responsible for any misuse of the
                                                    platform by users. If you think your account was banned by mistake,
                                                    please email us. We will definitely get back to you as soon as possible.
                                                </p>
                                                <h2>Termination Of Services</h2>
                                                <p>
                                                    WA Post has the right to limit, suspend, or stop providing the Services
                                                    to you if you fail to comply with these Terms.
                                                </p>
                                                <h2>Copyright Policy</h2>
                                                <p>
                                                    As WA Post requests that others respect its intellectual property right,
                                                    it respects the intellectual property rights of others.
                                                    If you found that content situated on or connected to WA Post disregards
                                                    your copyright, you are urged to tell WA Post.
                                                    WA Post will react to every such notification, including as required or
                                                    properly by eliminating the faulty material or crippling all connections
                                                    to the faulty material.
                                                    WA Post will end a guest's admittance to and utilization of the Site if,
                                                    under suitable conditions, the user does not follow the copyrights
                                                    policy.
                                                    On account of an end, WA Post will have no refund or discount of any
                                                    amount recently paid to WA Post.
                                                </p>
                                                <h2>Intellectual Property</h2>
                                                <p>
                                                    By presenting your Content to WA Post, you give WA Post non-elite
                                                    permission around the world, eminence free, sublicensable, adaptable
                                                    permit to use all copyright privileges now in the presence or that might
                                                    emerge in the future regarding your Content, in any medium that
                                                    currently exists or may emerge later on, just as to do whatever else
                                                    that is sensibly fitting to our Services and its utilization of your
                                                    Content counting, however not restricted to, utilization of your name
                                                    in relationship with your
                                                    You are allowed to eliminate or erase your Content whenever.
                                                    You comprehend and concur, nonetheless, that regardless of whether you
                                                    erase Content, WA Post might hold, however not show or disperse, server
                                                    duplicates of your Content.
                                                </p>
                                                <p>Your address that you have every one of the important freedoms to publish
                                                    all Content to WA Post.
                                                </p>
                                                <h2>Limitation Of Liability</h2>
                                                <p>On no occasion WA Post, or its providers or licensors, will not be
                                                    responsible for any topic of this understanding under any agreement,
                                                    carelessness, severe obligation, or other legitimate or fair theory for:
                                                </p>
                                                <ul>
                                                    <li>Any uncommon, accidental, or considerable harm; </li>
                                                    <li>The expense of acquisition for substitute products and services.
                                                    </li>
                                                    <li>For the interference of utilization or misfortune or defilement of
                                                        information; or </li>
                                                    <li>For any amount that surpasses the expenses paid by you to WA Post
                                                        under this arrangement during the membership time frame before the
                                                        reason for the activity. WA Post will have no responsibility for any
                                                        disappointment or deferral because of issues past their sensible
                                                        control.</li>
                                                </ul>

                                                <h2>General Representation And Warranty</h2>
                                                <p>Your address and warrant that</p>
                                                <p>Your utilization of the Site will be as per the security segment, with
                                                    this Agreement and with every pertinent law and guideline (remembering
                                                    without impediment any nearby laws or guidelines for your nation, state,
                                                    city, or another legislative region, in regards to online lead and OK
                                                    substance, and including all relevant laws in regards to the
                                                    transmission of specialized information traded from the United States or
                                                    the country where you dwell) and your utilization of the Site won't
                                                    encroach on or misuse any third-party content of any outsider.</p>

                                                <h2>This Is A Binding Agreement</h2>
                                                <p>By getting to or utilizing any piece of the site, you consent to become
                                                    limited by the terms of this agreement. If you don't consent to any one
                                                    of the agreements of this understanding, then, at that point, you may
                                                    not get to the Site or utilize any administrations.</p>

                                                <h2>We Can Change Our Services</h2>
                                                <p>We might change any part of the services we need, or even stop it,
                                                    whenever without giving you notice. We can likewise end or confine
                                                    admittance to it whenever in our sole attentiveness. The end of your
                                                    entrance and utilization of WA Post Services will not free you from any
                                                    commitments emerging or building before the end.</p>

                                                <h2>Fees, Payments & Cancellation Policy</h2>
                                                <p>You consent to pay for the Services you use on the WA Post Site in
                                                    understanding the estimating and pricing terms introduced to you for
                                                    that assistance. Expenses paid by you are non-refundable.
                                                    For memberships, you will be charged ahead of time on a repetitive cycle
                                                    for the period you have chosen (month to month or yearly, or quarterly)
                                                    toward the start of that period. Your membership will naturally restore
                                                    toward the finish of every period.
                                                    WA Post might change the subscription fees charged for Services
                                                    whenever, given that, for membership Services, the change will become
                                                    compelling just upon the following recharging date.
                                                </p>

                                                <h2>Miscellaneous:</h2>
                                                <p>This Agreement establishes the whole arrangement between WA Post and you
                                                    concerning the topic, and they may just be adjusted by a composed change
                                                    endorsed by an approved leader of WA Post, or by the posting by WA Post
                                                    of the revised version.
                                                    To the extent applicable law, if anyone assuming disagrees in any case,
                                                    of this Agreement, any admittance to or utilization of the Site will be
                                                    administered by the laws of the state.
                                                    Aside from claims for injunctive or impartial help or cases in regards
                                                    to protected innovation privileges (which might be acquired by any
                                                    capable court without the posting of a bond), any question emerging
                                                    under this Agreement will be at long last gotten comfortable
                                                    understanding with the Comprehensive Arbitration Rules of the Judicial
                                                    Arbitration and Mediation Service, Inc. ("JAMS").
                                                    If any piece of this Agreement is held invalid or unenforceable, that
                                                    part will be understood to mirror the gatherings' unique purpose, and
                                                    the excess segments will stay in full power and impact.
                                                    You might appoint your freedoms under this Agreement to any party that
                                                    agrees to, and consents to be limited by, its agreements; WA Post might
                                                    dole out its privileges under this Agreement without condition. This
                                                    Agreement will be restricting upon and will acclimate to the advantage
                                                    of the gatherings, their replacements, and allowed relegates.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="advance-wrapper callout-special-font">
                                            <h2>Acceptance of Terms:</h2>
                                            <p id="last">
                                                By using the platform, you acknowledge that you have read, understood, and
                                                agreed to these Terms. You represent and warrant that you have the legal
                                                authority to accept these Terms on behalf of yourself or any party you
                                                represent.
                                            </p>
                                            <div class="">
                                                <div>
                                                    <input type="radio" name="decalrationStatus" id="accept"
                                                        value="accept" required>
                                                    <label for="accept">I Accept</label>
                                                </div>
                                                <label id="decalrationStatus-error" class="error"
                                                    for="decalrationStatus"></label>
                                            </div>
                                            <div class="advance-wrapper callout-special-font">
                                                {{-- <a href="" target="_blank"
                                                class="leadin-button accept-btn leadin-advance-button leadin-button-primary">Proceed</a> --}}
                                                <button type="submit"
                                                    class="leadin-button accept-btn leadin-advance-button leadin-button-primary">
                                                    Proceed
                                                </button>

                                                <a href="{{ URL::to('dashboard') }}"
                                                    class="leadin-button cancel-btn leadin-advance-button leadin-button-primary">
                                                    Cancel
                                                </a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
    </section>
@endsection

@section('page-script')
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        var n = 0;

        var interval;
        var refreshId;
        var intervalReconnect;
        var intervalCallNow;
        var QrScaned = false;
        var start = Date.now();

        function callNow(instance_key) {
            if (QrScaned != true) {
                get_key_info(instance_key);
            }
        }

        function updateBeat() {
            n = parseInt(n) + 1;
            // console.log(n * 20 + ' Seconds Completed! & ', 'n = ' + n);
            console.log(n * 20 + ' Seconds Completed! & ', 'n = ' + n);
        }

        function checkNow() {
            if (n >= 3) {
                clearInterval(interval);
                // clearInterval(refreshId);
                // clearInterval(intervalReconnect);
                clearInterval(intervalCallNow);
                return true;
            } else {
                return false;
            }
        }

        function reload(frame, url) {
            $(frame).load(url);
        }

        function addMoreConnection() {
            get_wa_token('ADD_CONNECTION');
            document.getElementById("add-disconnected").style.display = "block";
            $('#addmorebtn').hide();
        }

        /* Countdown 2 */
        function countdown2() {
            // refreshId = setInterval(function() {
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
                // clearInterval(refreshId);
                // clearInterval(intervalReconnect);
                clearInterval(intervalCallNow);
                return false;
            }
            updateBeat();
            get_wa_token();
            // }, 20000);
        }

        /* 20 seconds countdown */
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
                    countdown2();
                }
            }, 1000);
        }

        /* get instance id*/
        var action = '';
        var key_id = "{{ $user->key_id }}";
        var key_secret = "{{ $user->key_secret }}";

        function get_wa_token(temp = null) {
            var connections = "{{ count($connections) }}";
            if (temp == 'ADD_CONNECTION' || connections == 0) {
                $("#qr_code_img img").remove();
                $('.reload-qr').show();
                $.ajax({
                    url: '{{ $wa_api_url }}instance/init?key_secret=' + key_secret + '&key_id=' + key_id +
                        '&wa_mobile=8600363127',
                    type: 'GET',
                    dataType: "json",
                    success: function(res) {
                        if (res.error == false) {
                            $('#instance_key').text();
                            $('#instance_key').text(res.instance_key);
                            setTimeout(function() {
                                console.log('get_qrcode:', res);
                                get_qrcode(res.key);
                            }, 2000);
                            // }, 5900);
                        }
                    }
                });
            }
        }

        /* get QR Code */
        function get_qrcode(instance_key, connectionNumber = '') {

            $.ajax({
                url: '{{ $wa_api_url }}instance/qrbase64?key=' + instance_key,
                type: 'GET',
                dataType: "json",
                success: function(res) {
                    console.log('get_qrcode: ', res);
                    if (res.error == false) {
                        var image = new Image();
                        image.src = res.qrcode;
                        $('.reload-qr').hide();
                        $('#qr_code_img').append(image);
                        // $('.js-timeout').html('0:20');
                        $('.js-timeout').html('0:59');
                        countdown();
                        intervalCallNow = setInterval(function() {
                            callNow(instance_key);
                        }, 4000)
                    }
                }
            });
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
                        console.log('get_key_info: ', res);
                        phone_connected = res.instance_data.phone_connected;
                        if (res.error == false && (phone_connected != undefined || phone_connected == true)) {
                            console.log('Connected');
                            let wa_data = set_key(res.instance_data);
                            let number = res.instance_data.user.id.split(':');
                            $('#disconnected').hide();
                            // $('#connected img').attr('src', number[0]);
                            $('#connected img').attr('title', number[0]);
                            $('#connected #wa_name').text('');
                            $('#connected #wa_name').text('(' + res.instance_data.user.id + ')');
                            $('#connected #wa_number').text('');
                            $('#connected #wa_number').text(number[0]);
                            $('#connected').show();

                            clearInterval(interval);
                            QrScaned = true;

                            // window.location.href = '{{ url('connection') }}'
                            // }
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
            $.ajax({
                url: "{{ route('customer.set_instance') }}",
                type: 'POST',
                data: {
                    "jid": jid,
                    "number": number[0],
                    "instance_key": instance_key,
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(res) {
                    console.log('set_key: ', res);
                    window.location.reload();
                    if (res.error == false) {
                        $('#instance_key').text();
                        $('#instance_key').text(instance_key);
                    } else {
                        $('#instance_key').text(instance_key);
                        logout();
                        // window.reload();
                        // alert(res.message);
                    }
                }
            });
        }

        $(document).on('click', '#disconnect_account', function() {
            // var instance_key = $('#instance_key').text();
            var instance_key = $(this).attr("instance-key");

            $.ajax({
                url: "{{ route('customer.logut_instance') }}",
                type: 'POST',
                data: {
                    "instance_key": instance_key,
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(res) {
                    console.log('logout: ', res);
                    if (res.error == false) {
                        $('#instance_key').text();
                        $('#connected').hide();
                        $('#disconnected').show();
                        get_wa_token();
                        window.location.reload();
                    }
                }
            });
        })

        function reconnectOnLoad(instance_key) {

            if (QrScaned != true) {
                if (instance_key != '' || instance_key != null) {
                    $.ajax({
                        url: '{{ $wa_api_url }}instance/qrbase64?key=' + instance_key,
                        type: 'GET',
                        dataType: "json",
                        success: function(res) {
                            console.log('reconnectOnLoad: ', res);
                            if (res.error == false) {
                                if (res.qrcode == '' || res.qrcode == ' ') {
                                    let data = get_wa_token();
                                }
                                $('#instance_key').text();
                                $('#instance_key').text(res.key);
                            } else {

                            }
                        }
                    });
                } else {
                    let data = get_wa_token();
                }
            }
        }

        /* at end of the all script */
        $(document).ready(function() {
            $(document).on('click', '#onClickReloadQR', function() {
                clearInterval(interval);
                clearInterval(refreshId);
                clearInterval(intervalCallNow);
                $('#countdownTest').html('');
                $('#countdownTest').html(
                    '<span>Code will change in </span><b><span class="text-danger js-timeout">0:59</span> sec.</b>'
                );
                n = 0;
                get_wa_token();
                countdown();
                console.log(n);
            })

            var instance_key = "{{ isset($connection->key) ? $connection->key : '' }}";
            if (instance_key) {
                reconnectOnLoad(instance_key)
            } else {
                get_wa_token();
            }
        });

        // function activeDeactiveStatus(connId, status) {
        //     $.get("{{ URL::to('activeDeactiveStatus') }}?connId=" + connId + "&status=" + status, function(response) {
        //         console.log(response);
        //     })
        // }

        jQuery(function() {
            jQuery('.add-morebtn .btn-success').click(function() {
                jQuery('.addmore-scanner').show();
                jQuery('#disconnected').hide();
            });
        });
    </script>
@endsection
