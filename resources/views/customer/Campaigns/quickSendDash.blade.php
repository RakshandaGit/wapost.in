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

        #quicksend-dashbordtab #settings_tab_content .tab-content {
            border: 1px solid #08828c;
            margin: 1rem 0;
            padding: 1rem;
        }
    </style>

@endsection

@section('content')

    <!-- Basic Vertical form layout section start -->
    <section>
        <div class="section" id="quicksend-dashbordtab">

            <div class="card" style="overflow: hidden;">

                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12 col-sm-5 col-md-3 pr-sm-0">

                            <ul class="nav flex-column h-100" style="border-right: 1px solid #e1e7ed;" id="b-setting-tab">
                                <li class="nav-item">
                                    <a href="#tab-1" class="tab actived" id="textMessage">
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
                                    <a href="#tab-2" class="tab" id="imageMessage">
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
                                    <a href="#tab-3" class="tab" id="fileMessage">
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
                                    <a href="#tab-4" class="tab" id="contactMessage">

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
                            <div class="tabbed-content no-padding" id="settings_tab_content">
                                <div id="tab-1" class="tab-content">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form1" class="validjquerycustomer">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                {{-- <input type="tel" id="text_number" class="required form-control"
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number" required="" placeholder="Required"
                                                    autofocus="" minlength="6"> --}}
                                                    <textarea class="required form-control" id="text_number" name="number" rows="3" cols="40" required="" placeholder="Required" minlength="6">{{ !empty($recipient) ? $recipient : '' }}</textarea>    
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_message" class="required form-label">Message</label>
                                                <div class="position-relative mb-3">
                                                    <div class="wa-editor-area">
                                                        <div class="wa-editor" id="quillTextMessageEditor"
                                                            style="height: 200px;"></div>
                                                        <input type="text" class="appnedQuillTextMessage" name="message"
                                                            required="" style="visibility: hidden;">
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
                                <div id="tab-2" class="tab-content hidden">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form2" class="">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="image_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                {{-- <input type="tel" id="image_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus=""> --}}

                                                    <textarea class="required form-control" id="image_number" name="number" rows="3" cols="40" required="" placeholder="Required" minlength="6">{{ !empty($recipient) ? $recipient : '' }}</textarea> 
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
                                <div id="tab-3" class="tab-content hidden">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form3">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                {{-- <input type="tel" id="text_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus=""> --}}
                                                    <textarea class="required form-control" id="text_number" name="number" rows="3" cols="40" required="" placeholder="Required" minlength="6">{{ !empty($recipient) ? $recipient : '' }}</textarea>
                                                    
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
                                <div id="tab-4" class="tab-content hidden">
                                    <form action="{{ route('customer.sendMessage') }}" method="post"
                                        enctype="multipart/form-data" id="send_message_form4">
                                        @csrf
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    WhatsApp Number
                                                </label>
                                                {{-- <input type="tel" id="contact_number" class="form-control "
                                                    value="{{ !empty($recipient) ? $recipient : '' }}" name="number"
                                                    required="" placeholder="Required" autofocus=""> --}}
                                                    <textarea class="required form-control" id="contact_number" name="number" rows="3" cols="40" required="" placeholder="Required" minlength="6">{{ !empty($recipient) ? $recipient : '' }}</textarea>    
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="text_number" class="required form-label">
                                                    Full Name
                                                </label>
                                                <input type="text" id="fullname" class="form-control "
                                                    value="" name="fullname" required="" placeholder="Required"
                                                    autofocus="" onchange="myChangeFunction(this)">
                                                <input type="hidden" id="displayname" class="form-control "
                                                    value="" name="displayname" placeholder="Required"
                                                    autofocus="">
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
                                <p class="mb-2">You have not connected to WhatsApp. Please make WhatsApp connection to
                                    send messages.</p>
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
        loadQuill()

        function loadQuill() {
            var quill = new Quill('#quillTextMessageEditor', {
                modules: {
                    "toolbar": toolbarOptions,
                    "emoji-toolbar": true,
                    "emoji-shortname": false,
                    "emoji-textarea": false
                },
                clipboard: {
                    newLines: true
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
                console.log(justHtml, "justHtml");
                var returndata = prepareFormattedContent(justHtml);
                console.log(returndata, "returndata");
                var text = quill.getText();
                if (quill.getLength() > limit) {
                    quill.deleteText(limit, quill.getLength());
                }
                tlength = addWsNodes(returndata).length - 1,
                remain = parseInt(limit - (tlength - 1));
                if (remain < 0 && e.which !== 0 && e.charCode !== 0) {
                    $('#quillTextMessageEditor').val((text).substring(0, addWsNodes(returndata).length - 1));
                    $('#remains-count').text(0);
                    
                    return false;
                } else {
                  var demo = $('#remains-count').text(remain);
                }

                $(".appnedQuillTextMessage").val(addWsNodes(returndata));
                $("#messaage-quick").html(addWsNodes(justHtml).replace(/\\n/g, ''));

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
                $("#img-cap").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".img-cap").html(addWsNodes(justHtml).replace(/\\n/g, ''));

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
                $("#img-cap").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".file-caption").html(addWsNodes(justHtml).replace(/\\n/g, ''));

            });

        }
        $(document).ready(function() {
            $("#quicksend-dashbordtab .tab").click(function() {
                $("#settings_tab_content .tab-content").hide();
                $($(this).attr("href")).show();
            });

            $("#quicksend-dashbordtab .tab").click(function() {
                $("#quicksend-dashbordtab .tab").removeClass("actived");
                $(this).addClass("actived");
            });
            $("#quicksend-dashbordtab .tab").click(function() {
                $("#settings_tab_content .tab-content").removeClass("hidden");
            });

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
                        if($("input[name=user-type]:checked").val() == "Brand"){
                            
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
            $("#fullname-demo").hide();
            $("#full_name").hide();
            $(".contact-blankbtn").hide();
            $("#fullname").on('keyup', function() {
                $("#fullname-demo").show();
                $("#full_name").show();
                $(".contact-blankbtn").show();
                $("#fullname-demo").html($(this).val());
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
                $(".specified-preview").hide();
            } else if (val == 'video') {
                $('#image_file').attr("accept", "video/*");
                $(".specified-preview").show();
            } else if (val == 'image') {
                $('#image_file').attr("accept", "image/*");
                $(".specified-preview").show();
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
                            $('#quillTextMessageEditor').find('.ql-editor').append(data.status +
                                "<br/>");
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
                            $("#fullname-demo").hide();
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
        $.validator.addMethod('filesize', function(value, element, arg) {
            if ((element.files[0].size < 16777216)) {
                return true;
            } else {
                return false;
            }
        }, 'File size should be less than 16MB');

        $(".validjquerycustomer").validate({
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
        $('form').each(function() {
            if ($(this).data('validator'))
                $(this).data('validator').settings.ignore = ".note-editor *";
        });
        $("#send_message_form2 .send-message").on('click', function(e) {
            var form = $("#send_message_form2");
            form.validate({
                rules: {
                    file: {
                        filesize: 16777216,
                    }
                },
                messages: {
                    number: {
                        minlength: "Your phone number must be at least 6 digits long"
                    }
                },
            });
            // console.log(form.valid());
            if (form.valid() === false) {
                $('#send_message_form2 .send-message').attr('disabled', true);
                e.preventDefault();
                return false;
            } else {
                $("#send_message_form2 .send-message").click(function() {
                    $('#send_message_form2 .send-message').attr('disabled', false);
                    $("#send_message_form2").submit();
                });
            }
        });
        $("#send_message_form3 .send-message").on('click', function(e) {
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
                $("#send_message_form3 .send-message").click(function() {
                    $('#send_message_form3 .send-message').attr('disabled', false);
                    $("#send_message_form3").submit();
                });
            }
        });

        function myChangeFunction(input1) {
            var input2 = document.getElementById('displayname');
            input2.value = input1.value;
        }

        $(document).ready(function() {
            $('#text_number, #image_number, #contact_number').on('input', function(e) {
                var inputValue = $(this).val();
                
                // Remove non-numeric characters
                var numericValue = inputValue.replace(/[^\d;,\n]/g, '');

                // Update the input field with the cleaned value
                $(this).val(numericValue);
            });

            $('#text_number, #image_number, #contact_number').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var inputValue = $(this).val();
                    $(this).val(inputValue + '\n');
                }
            });
        });

    </script>
@endsection
