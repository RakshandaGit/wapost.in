@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Quick Send'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> --}}
@endsection

@section('page-style')

    <style>
        .customized_select2 .select2-selection--single,
        .input_sender_id {
            border-left: 0;
            border-radius: 0 4px 4px 0;
            min-height: 2.75rem !important;
        }

        #b-setting-tab .nav-item>.nav-link {
            padding: 0px;
        }

        #b-setting-tab .nav-item>.nav-link.active>.sb-tabs {
            border-left: 3px solid var(--primary);
            background-color: #f8fbff;
        }

        .sb-tabs {
            position: relative;
            width: 100%;
            border-bottom: 1px solid #e1e7ed;
            border-left: 3px solid transparent;
        }

        .sb-tabs .inner {
            position: relative;
            padding: 20px 12px;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }

        .sb-tabs .status-icon {
            width: 35px;
            text-align: left;
        }

        .sb-tabs .title_ {
            width: calc(100% - 50px);
            text-align: left;
        }

        .sb-tabs .dirction-ico {
            width: 15px;
            text-align: right;
        }

        .tab-pane {
            border: 1px solid #024c95;
            padding: 1rem;
            margin-top: 1rem;
            margin-right: 1rem;
        }

        .whatsapp-preview {
            background-image: url(../website/img/shapes/whatsup-preview-img.png);
            border-radius: 10px;
        }

        .whatsapp-preview .preview-box .card {
            margin: 0 6px 6px;
        }

        .whatsapp-preview .preview-box {
            margin: 0 15px 0 0px
        }

        .whatsapp-preview .previewtabs {
            display: none;
        }

        .whatsapp-preview #tabpre1 {
            display: block;
        }

        .whatsapp-preview .preview-box .seccard-body {
            margin: 0 6px 6px;
        }

        .tab-content .btn.btn-primary {
            font-size: 1rem !important;
            font-weight: 400 !important;
            border-radius: 5px !important;
            padding: 9px 20px !important;
        }
    </style>

@endsection

@section('content')

    <!-- Basic Vertical form layout section start -->
    <section>
        <div class="section">

            <div class="card" style="overflow: hidden;">

                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12 col-sm-5 col-md-3 pr-sm-0">

                            <ul class="nav flex-column h-100" style="border-right: 1px solid #e1e7ed;" id="b-setting-tab"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link setting-tab show" id="textMessage" data-bs-toggle="tab"
                                        href="#tab1" role="tab" aria-controls="home" aria-selected="true">

                                        <div class="sb-tabs py-2 px-1">
                                            <div class="inner">

                                                <div class="status-icon">
                                                    {{-- <i class="fas fa-check-circle text-success"></i> --}}
                                                    <i class="fa fa-file-text text-success"></i>
                                                </div>

                                                <div class="title_">
                                                    <h6 class="mb-0">Send Text</h6>
                                                    {{-- <p class="text-secondary">Update all required fields</p> --}}
                                                </div>

                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>

                                            </div>
                                        </div>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link setting-tab" id="imageMessage" data-bs-toggle="tab" href="#tab2"
                                        role="tab" aria-controls="profile" aria-selected="false">

                                        <div class="sb-tabs py-2 px-1">
                                            <div class="inner">

                                                <div class="status-icon">
                                                    <i class="fas fa-photo-video text-success"></i>
                                                </div>

                                                <div class="title_">
                                                    <h6 class="mb-0">Send Media</h6>
                                                    {{-- <p class="text-secondary">Add your business contacts</p> --}}
                                                </div>

                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link setting-tab" id="fileMessage" data-bs-toggle="tab" href="#tab3"
                                        role="tab" aria-controls="contact" aria-selected="false">

                                        <div class="sb-tabs py-2 px-1">
                                            <div class="inner">

                                                <div class="status-icon">
                                                    {{-- <i class="fas fa-exclamation-circle text-warning"></i> --}}
                                                    <i class="fa fa-file text-warning"></i>

                                                </div>

                                                <div class="title_">
                                                    <h6 class="mb-0">Send File Or Document</h6>
                                                    {{-- <p class="text-secondary">Scan your WhatsApp to send messages.</p> --}}
                                                </div>

                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>

                                            </div>
                                        </div>

                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link setting-tab" id="contactMessage" data-bs-toggle="tab" href="#tab4"
                                        role="tab" aria-controls="contact" aria-selected="false">

                                        <div class="sb-tabs py-2 px-1">
                                            <div class="inner">

                                                <div class="status-icon">
                                                    {{-- <i class="fas fa-check-circle text-success"></i> --}}
                                                    <i class="far fa-address-book text-success"></i>

                                                </div>

                                                <div class="title_">
                                                    <h6 class="mb-0">Send Contact</h6>
                                                    {{-- <p class="text-secondary">Set message route for channels</p> --}}
                                                </div>

                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>

                                            </div>
                                        </div>

                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link setting-tab" id="videoMessage" data-bs-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false">
                                        <div class="sb-tabs">
                                            <div class="inner">
    
                                                <div class="status-icon">
                                                    <i class="far fa-file-video text-success"></i>
                                                </div>
    
                                                <div class="title_">
                                                    <h6>Send Button Message</h6>
                                                </div>
    
                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>
    
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link setting-tab" id="audioMessage" data-bs-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false">
    
                                        <div class="sb-tabs">
                                            <div class="inner">
                                                <div class="status-icon">
                                                    <i class="far fa-file-audio text-warning"></i>
                                                </div>
    
                                                <div class="title_">
                                                    <h6>Send List Message</h6>
                                                </div>
    
                                                <div class="dirction-ico">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>
    
                                            </div>
                                        </div>
    
                                    </a>
                                </li>
    
    
                                <li class="nav-item">
                                    <a class="nav-link setting-tab" id="documentMessage" data-bs-toggle="tab" href="#tab7" role="tab" aria-controls="contact" aria-selected="false">
                                    <div class="sb-tabs">
                                        <div class="inner">
                                            <div class="status-icon">
                                                <i class="far fa-file-pdf text-success"></i>
    
                                            </div>
                                            <div class="title_">
                                                <h6>Send Button With Media</h6>
                                            </div>
                                            <div class="dirction-ico">
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="col-12 col-sm-7 col-md-5 pl-sm-0">
                            <div class="tab-content no-padding" id="settings_tab_content">


                                <div class="tab-pane fade active show" id="tab1" role="tabpanel"
                                    aria-labelledby="textMessage">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form1" class="validjquerycustomer">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                <input type="tel" id="text_number" class="required form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    {{-- required="" placeholder="Required" autofocus="" minlength="6" maxlength="13" > --}} required="" placeholder="Required"
                                                    autofocus="" minlength="6">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_message" class="required form-label">Message</label>
                                                <div class="position-relative mb-3">
                                                    <div class="wa-editor-area">
                                                        <div class="wa-editor" id="quillTextMessageEditor"
                                                            style="height: 200px;"></div>
                                                        <input type="text" class="appnedQuillTextMessage"
                                                            name="message" required="" style="visibility: hidden;">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <small class="text-primary text-uppercase text-start"
                                                        id="remaining"><span id="remains-count">4096 </span>
                                                        characters</small>
                                                    {{-- <small class="text-primary text-uppercase text-end" id="messages">1
                                                        Message (s)</small> --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" value="text" name="mediaType" />
                                                <button type="submit"
                                                    class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-send">
                                                        <line x1="22" y1="2" x2="11"
                                                            y2="13"></line>
                                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                    </svg> Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="imageMessage">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form2" class="">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="image_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                <input type="tel" id="image_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="image_number" class="required form-label">
                                                Select Media Type
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">

                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="mediaType"
                                                        value="{{ __('image') }}" onchange="mediaTypeChange(this.value)"
                                                        checked>{{ __('locale.labels.image') }}
                                                    <label class="form-check-label"></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="mediaType"
                                                        value="{{ __('video') }}"
                                                        onchange="mediaTypeChange(this.value)">{{ __('Video') }}
                                                    <label class="form-check-label"></label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input" name="mediaType"
                                                        value="{{ __('audio') }}"
                                                        onchange="mediaTypeChange(this.value)">{{ __('Audio') }}
                                                    <label class="form-check-label"></label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="image_file" class="required form-label"
                                                    id="imagelable">{{ __('locale.labels.media_file') }}</label>
                                                <input type="file" name="file" class="form-control"
                                                    id="image_file" required="" accept="image/*" />
                                                {{-- @error('mms_file')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror --}}
                                            </div>
                                        </div>

                                        <div class="col-12" id="mediaCaption">
                                            <div class="mb-1">
                                                <label for="image_caption" class="form-label">Caption</label>
                                                <!-- <textarea class="form-control" name="message" rows="5" id="image_caption" id="caption"></textarea> -->

                                                <div class="position-relative mb-3">
                                                    <div class="wa-editor-area">
                                                        <div class="wa-editor" id="quillTextcaptionEditor"
                                                            style="height: 200px;"></div>
                                                        <input type="hidden" class="appnedQuillTextMessage"
                                                            name="caption">
                                                    </div>
                                                </div>
                                                <!-- <div class="d-flex justify-content-between">
                                                                            <small class="text-primary text-uppercase text-start" id="remaining">160 characters remaining</small>
                                                                            <small class="text-primary text-uppercase text-end" id="messages">1 Message (s)</small>
                                                                        </div> -->
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-send">
                                                        <line x1="22" y1="2" x2="11"
                                                            y2="13"></line>
                                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                    </svg> Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="fileMessage">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form3">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                <input type="tel" id="text_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="any_file"
                                                    class="required form-label">{{ __('locale.labels.any_file') }}</label>
                                                <input type="file" name="file" class="form-control" required=""
                                                    id="any_file" accept="" />
                                                {{-- @error('any_file')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror --}}
                                            </div>
                                        </div>
                                        <div class="col-12" id="mediaCaption">
                                            <div class="mb-1">
                                                <label for="image_caption" class="form-label">Caption</label>
                                                <div class="position-relative mb-3">
                                                    <div class="wa-editor-area">
                                                        <div class="wa-editor" id="quillTextFilecaptionEditor"
                                                            style="height: 200px;"></div>
                                                        <input type="hidden" class="appnedQuillTextMessage"
                                                            name="caption">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" value="file" name="mediaType" />
                                                <button type="submit"
                                                    class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-send">
                                                        <line x1="22" y1="2" x2="11"
                                                            y2="13"></line>
                                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                    </svg> Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade" id="tab4" role="tabpanel"
                                    aria-labelledby="contactMessage">
                                    <p>Send contact</p>
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form4">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                <input type="tel" id="contact_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    Full Name
                                                </label>
                                                <input type="text" id="fullname" class="form-control "
                                                    value="" name="fullname" required="" placeholder="Required"
                                                    autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    Display Name
                                                </label>
                                                <input type="text" id="displayname" class="form-control "
                                                    value="" name="displayname" required=""
                                                    placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    Organization Name
                                                </label>
                                                <input type="text" id="organization" class="form-control "
                                                    value="" name="organization" required=""
                                                    placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    Phone Number
                                                </label>
                                                <input type="tel" id="phonenumber" class="form-control "
                                                    value="" name="phonenumber" required=""
                                                    placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" value="contact" name="mediaType" />
                                                <button type="submit"
                                                    class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-send">
                                                        <line x1="22" y1="2" x2="11"
                                                            y2="13"></line>
                                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                                    </svg> Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="videoMessage">
                                    <form action="{{ route('customer.sendMessage')}}" method="post" enctype="multipart/form-data" id="send_message"> 
                                        @csrf 
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="video_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                <input type="tel" id="video_number" class="form-control " value="{{(!empty($recipient))?$recipient:''}}" name="number" required="" placeholder="Required" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                                <div class="mb-1">
                                                    <label for="image_caption" class="required form-label">Message</label>
                                                    <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                                                    <!-- <div class="d-flex justify-content-between">
                                                        <small class="text-primary text-uppercase text-start" id="remaining">160 characters remaining</small>
                                                        <small class="text-primary text-uppercase text-end" id="messages">1 Message (s)</small>
                                                    </div> -->
                                                </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="reply_button" class="form-label">{{__('Reply Button Title')}}</label>
                                                <input type="text" name="reply_button_title" class="form-control" id="reply_button_title" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="url_button" class="form-label">{{__('URL Button Title')}}</label>
                                                <input type="text" name="url_button_title" class="form-control" id="url_button_title" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="url_button_payload" class="form-label">{{__('URL Button Payload')}}</label>
                                                <input type="text" name="url_button_payload" class="form-control" id="url_button_payload" placeholder="url" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="call_button" class="form-label">{{__('Call Button Title')}}</label>
                                                <input type="text" name="call_button" class="form-control" id="call_button" placeholder="title" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="call_button_payload" class="form-label">{{__('Call Button Payload')}}</label>
                                                <input type="text" name="call_button_payload" class="form-control" id="call_button_payload" placeholder="number" />
                                            </div>
                                        </div>        
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="footer_text" class="form-label">{{__('Footer Text')}}</label>
                                                <input type="text" name="footertext" class="form-control" id="footertext" placeholder="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="hidden" name="mediaType" value="button" />
                                                <button type="submit" class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>  --}}

                                {{-- <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="audioMessage">
                                <form action="{{ route('customer.sendMessage')}}" method="post" enctype="multipart/form-data" id="send_message"> 
                                    @csrf
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="audio_number" class="required form-label">
                                                WhatsApp Number
                                            </label>
                                            <input type="tel" id="audio_number" class="form-control " value="{{(!empty($recipient))?$recipient:''}}" name="number" required="" placeholder="Required" autofocus="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="button_text" class="form-label">{{__('Button Text')}}</label>
                                            <input type="text" name="button_text" class="form-control" required="" id="button_text" />
                                        </div>
                                    </div>
    
                                    <div class="col-12">
                                            <div class="mb-1">
                                                <label for="message" class="required form-label">Message</label>
                                                <textarea class="form-control" name="message" required="" rows="5" id="message"></textarea>
                                                <!-- <div class="d-flex justify-content-between">
                                                    <small class="text-primary text-uppercase text-start" id="remaining">160 characters remaining</small>
                                                    <small class="text-primary text-uppercase text-end" id="messages">1 Message (s)</small>
                                                </div> -->
                                            </div>
                                    </div>
    
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="title" class="required form-label">{{__('Title')}}</label>
                                            <input type="text" name="title" required="" class="form-control" id="title" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="description" class="required form-label">{{__('Description')}}</label>
                                            <input type="text" name="description" required="" class="form-control" id="description" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="list_title" class="required form-label">{{__('List Title')}}</label>
                                            <input type="text" name="list_title" required="" class="form-control" id="list_title" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-1">
                                            <button class="form-control" id="add_row"> Add Row </button>
                                        </div>
                                    </div>
                                    <div id="list_row_div" style="border: 1px solid black;padding: 7%;}">
                                        <label for="list" class="form-label font-weight-bold">{{__('LIST')}}</label>        
                                    <div class="col-12" id="list_row_append">
                                        
                                        <div class="mb-1">
                                            <label for="list_title" class="required form-label">{{__('Row Title')}}</label>
                                            <input type="text" name="row_title[]" required="" class="form-control" id="row_title" />
                                        </div>
                                        <div class="mb-1">
                                            <label for="list_title" class="required form-label">{{__('Row Description')}}</label>
                                            <input type="text" name="row_desc[]" required="" class="form-control" id="row_desc" />
                                        </div>
                                    </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                        <input type="hidden" value="list" name="mediaType"/>
                                            <button type="submit" class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                </div> --}}

                                {{-- <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="documentMessage">
                                <form action="{{ route('customer.sendMessage')}}" method="post" enctype="multipart/form-data" id="send_message"> 
                                    @csrf    
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="text_number" class="required form-label">
                                                WhatsApp Number
                                            </label>
                                            <input type="tel" id="text_number" class="form-control " value="{{(!empty($recipient))?$recipient:''}}" name="number" required="" placeholder="Required" autofocus="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="title" class="required form-label">{{__('Title Of Message')}}</label>
                                            <input type="text" name="title" class="form-control" required="" id="title" />
                                            
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="reply_button" class="form-label">{{__('Reply Button Title')}}</label>
                                            <input type="text" name="reply_button" class="form-control" id="reply_button" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="call_button" class="form-label">{{__('Call Button Title')}}</label>
                                            <input type="text" name="call_button" class="form-control" id="call_button" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="call_button_payload" class="form-label">{{__('Phone Number')}}</label>
                                            <input type="tel" name="call_button_payload" class="form-control" id="call_button_payload" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="doc_file" class="required form-label">{{__('locale.labels.doc_file')}}</label>
                                            <input type="file" class="form-control" required="" name="button_media_file" id="button_media_file" accept="image/*"/>
                                            <input type="hidden" name="button_media_file" />
                                            <input type="hidden" name="media_file_type" />
                                            <input type="hidden" name="media_file_mime" />
                                            {{-- @error('doc_file')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror --}}
                                {{-- </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="footertext" class="form-label">{{__('Footer Text')}}</label>
                                            <input type="text" name="footertext" class="form-control" id="footertext" />
                                            {{-- @error('doc_file')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror --}}
                                {{-- </div>
                                    </div>            
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" name="mediaType" value="MediaButton"/>
                                            <button type="submit" class="send-message btn btn-primary mt-1 mb-1 waves-effect waves-float waves-light"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-md-4 col-12 col-sm-12 whatsapp-preview">
                            <div id="messagetype_prview">
                                <div id="formMessagePreview">
                                    {{-- <div class="tab-content no-padding" id="settings_tab_contentb"> --}}

                                    <div id="tabpre1" class="previewtabs">
                                        @include('customer.contactGroups.mediaTypes.quickSend._message_preview')
                                    </div>

                                    <div id="tabpre2" class="previewtabs">
                                        @include('customer.contactGroups.mediaTypes.quickSend._media_preview')
                                    </div>

                                    <div id="tabpre3" class="previewtabs">
                                        @include('customer.contactGroups.mediaTypes.quickSend._file_preview')
                                    </div>

                                    <div id="tabpre4" class="previewtabs">
                                        @include('customer.contactGroups.mediaTypes.quickSend._contact_preview')
                                    </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

    @if (!$connection)
        <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-modal="true" style="padding-right: 19px; display: block;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-2">
                    <div class="modal-body p-4 px-5">
                        <div class="main-content text-center">
                            <form action="#">
                                <p class="mb-2">You have not connected to WhatsApp. Please make WhatsApp connection to send messages.</p>
                                <div class="d-flex">
                                    <div class="mx-auto">
                                        <div class="advance-wrapper callout-special-font">
                                            <a href="{{ URL::to('connection') }}"
                                                class="leadin-button cancel-btn leadin-advance-button leadin-button-primary">
                                                Connect Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/sms-counter.js')) }}"></script>
    <script>
        /* get html text format like wa message */
        function addWsNodes(s) {
            var waFormat = s;
            waFormat = waFormat.replaceAll("<strong>", " <strong>").replaceAll("</strong>", "</strong> ").replaceAll("<b>",
                " <b>").replaceAll("</b>", "</b> ");
            waFormat = waFormat.replaceAll("<em>", " <em>").replaceAll("</em>", "</em> ").replaceAll("<i>", " <i>")
                .replaceAll("</i>", "</i> ");
            waFormat = waFormat.replaceAll("<s>", " <s>").replaceAll("</s>", "</s> ").replaceAll("<strike>", " <strike>")
                .replaceAll("</strike>", "</strike> ");
            waFormat = waFormat.replaceAll('<p> ', '<p>').replaceAll("</p>", "</p> ").replaceAll('<div> ', '<div>')
                .replaceAll(/<\/p[^>]*>/mgi, '\n');
            
            return waFormat;
        }
        /* END -- get html text format like wa message */


        /* get html to wa message format */
        function prepareFormattedContent(htmlContent) {
            var waFormat = htmlContent
            var trimSpace = $('<div></div>').html(waFormat);
            $(trimSpace).find('strong, b, i, em, s, del, p').each(function (i, v) {
                var $elem = $(this).html();
                $(this).html($elem.trim());
                waFormat = waFormat.replace($elem, v.innerHTML);
            });
            waFormat = waFormat.replace(/&nbsp;/gi, " ").replace(/&amp;/gi, "&").replace(/&quot;/gi, '"').replace(/&lt;/gi,
                '<').replace(/&gt;/gi, '>');
            waFormat = waFormat.replace(/<b [^>]*>/mgi, ' *').replace(/<\/b>/mgi, '* ');
            waFormat = waFormat.replace(/<strong[^>]*>/mgi, ' *').replace(/<\/strong>/mgi, '* ');
            waFormat = waFormat.replace(/<i[^>]*>/mgi, ' _').replace(/<\/i>/mgi, '_ ');
            waFormat = waFormat.replace(/<em[^>]*>/mgi, ' _').replace(/<\/em>/mgi, '_ ');
            waFormat = waFormat.replaceAll('<s>', ' ~').replace(/<s [^>]*>/mgi, ' ~').replace(/<\/s>/mgi, '~ ');
            waFormat = waFormat.replace(/<strike[^>]*>/mgi, ' ~').replace(/<\/strike>/mgi, '~ ');
            waFormat = waFormat.replace(/<del[^>]*>/mgi, ' ~').replace(/<\/del>/mgi, '~ ');
            waFormat = waFormat.replaceAll('<p> ', '<p>').replace('<div> ', '<div>');
            waFormat = waFormat.replace(/<\/p[^>]*>/mgi, '\n').replace(/<\/div[^>]*>/mgi, '\n');
            waFormat = waFormat.replace(/(<([^>]+)>)/mgi, "");
            waFormat = waFormat.replaceAll("_ *", "_*")
                .replaceAll("* _", "*_")
                .replaceAll("~ _", "~_")
                .replaceAll("_ ~", "_~")
                .replaceAll("* ~", "*~")
                .replaceAll("~ *", "~*");
            waFormat.trim();

            return waFormat;
        }
        /* END - get html to wa message format */
        loadQuill()

        function loadQuill() {
            var quill = new Quill('#quillTextMessageEditor', {
                modules: {
                    "toolbar": toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": false,
                    "emoji-textarea": false
                },
                placeholder: 'Compose a Message..',
                theme: 'snow',
                required: 'true',
            });
            var limit = 4096;
            var remain = 4096;
            quill.on('text-change', function(e, delta, old, source) {
                var delta = quill.getContents();
                var justHtml = quill.root.innerHTML;
                var returndata = prepareFormattedContent(justHtml);
                var text = quill.getText();
                if (quill.getLength() > limit) {
                    quill.deleteText(limit, quill.getLength());
                }
                tlength = addWsNodes(returndata).length,
                    remain = parseInt(limit - (tlength - 1));
                if (remain < 0 && e.which !== 0 && e.charCode !== 0) {
                    $('#quillTextMessageEditor ').val((text).substring(0, addWsNodes(returndata).length - 1));
                    $('#remains-count').text(0);
                    console.log(addWsNodes(returndata));
                    return false;
                } else {
                    $('#remains-count').text(remain);

                }
                
                // console.log('Hello Blog demo %0a just for text');
                console.log(addWsNodes(returndata));
                $(".appnedQuillTextMessage").val(addWsNodes(returndata));
                $("#messaage-quick").html(addWsNodes(justHtml));

            });


            $('#send_message_form1 .send-message').attr('disabled', true);
            $('#send_message_form1 #text_number').keyup(function() {
                if ($("#send_message_form1 #text_number").val().length != 0 && remain < limit) {
                    $('#send_message_form1 .send-message').attr('disabled', false);
                } else {
                    $('#send_message_form1 .send-message').attr('disabled', true);
                }
            })
            $('#send_message_form1 #quillTextMessageEditor').keyup(function() {
                if ($("#send_message_form1 #text_number").val().length != 0 && remain < limit) {
                    $('#send_message_form1 .send-message').attr('disabled', false);
                } else {
                    $('#send_message_form1 .send-message').attr('disabled', true);
                }
            })


            var quillcaption = new Quill('#quillTextcaptionEditor', {
                modules: {
                    "toolbar": toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": false,
                    "emoji-textarea": false
                },
                placeholder: 'Compose a caption...',
                theme: 'snow',
            });

            quillcaption.on('text-change', function() {
                var delta = quillcaption.getContents();
                var justHtml = quillcaption.root.innerHTML;
                var returndata = prepareFormattedContent(justHtml);
                $(".appnedQuillTextMessage").val(addWsNodes(returndata));
                $("#img-cap").html(addWsNodes(justHtml));
                $(".img-cap").html(addWsNodes(justHtml));

                // if (returndata.getLength() == "" || returndata.getLength() == "0") {
                //     console.log(returndata.getLength());
                // }

            });

            var fileQuillcaption = new Quill('#quillTextFilecaptionEditor', {
                modules: {
                    "toolbar": toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": false,
                    "emoji-textarea": false
                },
                placeholder: 'Compose a caption...',
                theme: 'snow',
            });
            fileQuillcaption.on('text-change', function() {
                var delta = fileQuillcaption.getContents();
                var justHtml = fileQuillcaption.root.innerHTML;
                var returndata = prepareFormattedContent(justHtml);
                $(".appnedQuillTextMessage").val(addWsNodes(returndata));
                $("#img-cap").html(addWsNodes(justHtml));
                $(".file-caption").html(addWsNodes(justHtml));

            });
        }
        // function callFunction() {
        //     var x = document.getElementById("text_number").value;
        //     document.getElementById("messaage-quickcall").innerHTML = x;
        // }
        $(document).ready(function() {

            // media file data
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {

                        $('#spacified-img').attr('src', e.target.result);
                        var fileExt = input.files[0].name.split('.').pop();
                        console.log(fileExt)
                        if (fileExt == 'm4v' || fileExt == 'avi' || fileExt == 'mpg' || fileExt == 'mp4') {
                            $("#divVideo").show();
                            $("#divaudio").hide();
                            $(".spacifed-img").hide();
                        }

                        if (fileExt == 'mp3' || fileExt == 'wav' || fileExt == 'ogg') {
                            $("#divaudio").show();
                            $("#divVideo").hide();
                            $(".spacifed-img").hide();
                        }
                        if (fileExt == 'png' || fileExt == 'jpg' || fileExt == 'jpeg' || fileExt == 'gif' ||
                            fileExt == 'webp') {
                            $("#divVideo").hide();
                            $("#divaudio").hide();
                            $(".spacifed-img").show();
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_file").change(function() {
                readURL(this);
            });


            // file data
            $("#preview_allfile").hide();
            $("#any_file").change(function() {
                $("#preview_allfile").show();
                $("#file-prev").text(this.files[0].name);
            });
            // contact data
            $("#phonenumber").on('keyup', function() {
                $("#phonenumber-demo").html($(this).val());
            });
            $("#fullname").on('keyup', function() {
                $("#fullname-demo").html($(this).val());
            });
            $("#displayname-demo").hide();
            $("#full_name").hide();
            $(".contact-blankbtn").hide();
            $("#displayname").on('keyup', function() {
                $("#displayname-demo").show();
                $("#full_name").show();
                $(".contact-blankbtn").show();
                $("#displayname-demo").html($(this).val());
            });
            $("#organization").on('keyup', function() {
                $("#organization-demo").html($(this).val());
            });
            $("#textMessage").click(function() {
                $("#tabpre1").show();
                $("#tabpre2").hide();
                $("#tabpre3").hide();
                $("#tabpre4").hide();
            });
            $("#imageMessage").click(function() {
                $("#tabpre2").show();
                $("#tabpre1").hide();
                $("#tabpre3").hide();
                $("#tabpre4").hide();
            });
            $("#fileMessage").click(function() {
                $("#tabpre3").show();
                $("#tabpre1").hide();
                $("#tabpre2").hide();
                $("#tabpre4").hide();
            });
            $("#contactMessage").click(function() {
                $("#tabpre4").show();
                $("#tabpre1").hide();
                $("#tabpre2").hide();
                $("#tabpre3").hide();
            });
        });
        $('#add_row').on('click', function(e) {
            e.preventDefault();
            this.focus();
            $('#list_row_div').append($('#list_row_append').html());
        });
        //Media type Actions
        function mediaTypeChange(val) {
            if (val == 'audio') {
                $('#mediaCaption').hide();
                $('#media_image_caption').removeAttr('required');
            } else {
                $('#mediaCaption').show();
                $('#media_image_caption').attr('required', '');
            }

            if (val == 'audio') {
                $('#image_file').attr("accept", "audio/*");
            } else if (val == 'video') {
                $('#image_file').attr("accept", "video/*");
            } else if (val == 'image') {
                $('#image_file').attr("accept", "image/*");
            }
        }
        jQuery.extend(jQuery.validator.messages, {
            accept: "Please enter valid media type file."
        });
        $(document).ready(function() {
            "use strict"

            //show response message
            function showResponseMessage(data) {

                if (data.status === 'success') {
                    toastr['success'](data.message, '{{ __('locale.labels.success') }}!!', {
                        closeButton: true,
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        newestOnTop: true,
                        rtl: isRtl
                    });
                    // dataListView.draw();
                } else { //"{{ __('locale.exceptions.something_went_wrong') }}"
                    toastr['warning'](data.message, '{{ __('locale.labels.warning') }}!', {
                        closeButton: true,
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        newestOnTop: true,
                        rtl: isRtl
                    });
                }
            }
            //Create Media File Url
            $('#button_media_file').change(function() {
                var media_type = '';
                const file = this.files[0];
                var type = file.type.split('/');
                if (type[0] == 'image') {
                    media_type = type[0];
                } else {
                    toastr['warning']("Please Select Proper Media File (Image)",
                        "{{ __('locale.labels.attention') }}", {
                            closeButton: true,
                            positionClass: 'toast-top-right',
                            progressBar: true,
                            newestOnTop: true,
                            rtl: isRtl
                        });
                }
                const reader = new FileReader();
                var url = URL.createObjectURL(file);
                $('[name="button_media_file"]').val(url);
                $('[name="media_file_type"]').val(media_type);
                $('[name="media_file_mime"]').val(file.type);
            });

            $('form').on('submit', function(e) {


                var formData = new FormData(this);
                var basicbtnhtml = $(' .send-message').html();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: this.action,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $(' .send-message').html("Please Wait....");
                        $(' .send-message').attr('disabled', '')
                    },
                    success: function(data) {
                        $(' .send-message').html(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> Send'
                        );
                        $(' .send-message').removeAttr('disabled');
                        // $("#formMessagePreview .preview-box")[0].reset();
                        if (data.status == 'success') {
                            document.getElementById("send_message_form1").reset();
                            document.getElementById("send_message_form2").reset();
                            document.getElementById("send_message_form3").reset();
                            document.getElementById("send_message_form4").reset();

                            $("#quillTextMessageEditor").find('.ql-editor').html("");
                            $("#quillTextcaptionEditor").find('.ql-editor').html("");
                            $("#quillTextFilecaptionEditor").find('.ql-editor').html("");
                            $('#spacified-img').attr('src', null);
                            $("#divaudio").hide();
                            $("#divVideo").hide();
                            $("#preview_allfile").hide();
                            $("#displayname-demo").hide();
                            $("#full_name").hide();
                            $(".contact-blankbtn").hide();
                            $('.send-message').attr('disabled', '')

                            // document.getElementById("send_message_form5").reset();
                            // document.getElementById("send_message_form6").reset();
                            // document.getElementById("send_message_form7").reset();
                        }
                        showResponseMessage(data);

                    },
                    error: function(reject) {
                        $(' .send-message').html("Send");
                        $(' .send-message').removeAttr('disabled');

                        if (reject.status === 422) {
                            let errors = reject.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr['warning'](value[0],
                                    "{{ __('locale.labels.attention') }}", {
                                        closeButton: true,
                                        positionClass: 'toast-top-right',
                                        progressBar: true,
                                        newestOnTop: true,
                                        rtl: isRtl
                                    });
                            });
                        } else if (reject.status === 500) {
                            toastr['warning'](reject.statusText,
                                "{{ __('locale.labels.attention') }}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                        } else {
                            toastr['warning'](
                                "{{ __('locale.exceptions.something_went_wrong') }}",
                                "{{ __('locale.labels.attention') }}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                        }
                    }
                })
                e.preventDefault();
                return false;
            })
        });
    </script>
    <script>
        $.validator.setDefaults({
            debug: false,
            success: "valid"
        });
        $.validator.addMethod('filesize', function (value, element, arg) {
            // var minsize=3097152; // min 1kb
            // console.log(value);
            // console.log(element.files[0].size, ' - element.files[0].size');
            // console.log(arg);
            if((element.files[0].size < 16777216)){
                return true;
            }else{
                return false;
            }
        },'File size should be less than 16MB');
        // jQuery.validator.addMethod("customphone", function(value, element) {
        //     return this.optional(element) || /^(\+91|\+91|0)?\d{10}$/i.test(value);
        // }, "Please enter a valid phone number");
        $(".validjquerycustomer").validate({
            rules: {

            },
            messages: {
                number: {
                    minlength: "Your phone number must be at least 6 digits long"
                }
            },
        });
        $("#send_message_form2").validate({
            rules: {

            },
            messages: {
                number: {
                    minlength: "Your phone number must be at least 6 digits long"
                }
            },
        });
        $("#send_message_form4").validate({
            rules: {
                fullname: {
                    required: true,
                    minlength: 2
                },
                displayname: {
                    required: true,
                },
                organization: {
                    required: true,
                },
                phonenumber: {
                    required: true,
                }
            },
            messages: {
                number: {
                    minlength: "Your phone number must be at least 6 digits long",
                    maxlength: "Your phone number only 12 "
                }
            },
        });
        $('form').each(function () {
            if ($(this).data('validator'))
                $(this).data('validator').settings.ignore = ".note-editor *";
        });
        $("#send_message_form3 .send-message").on('click', function (e) {
            var form = $("#send_message_form3");
            form.validate({
                rules: {
                    file: {
                        filesize: 16777216,
                    }
                },
                messages: {
                    number: {
                        minlength: "Your phone number must be at least 6 digits long",
                        maxlength: "Your phone number only 12 "
                    }
                }
            });
            // console.log(form.valid());
            if (form.valid() === false) {
                $('#send_message_form3 .send-message').attr('disabled', true);
                e.preventDefault();
                return false;
            } else {
            $("#send_message_form3 .send-message").click(function () {
                $('#send_message_form3 .send-message').attr('disabled', false);
                $("#send_message_form3").submit();
            });
            }
        });
    </script>
@endsection
