@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Campaign')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

    <style>
        .customized_select2 .select2-selection--multiple {
            border-left: 0;
            border-radius: 0 4px 4px 0;
            min-height: 2.75rem !important;
        }

        .customized_select2 .select2-selection--single,
        .input_sender_id {
            border-left: 0;
            border-radius: 0 4px 4px 0;
            min-height: 2.75rem !important;
        }
    </style>

@endsection

@section('content')

    <div class="col-md-2 col-12 text-end">
        <a href="#!" class="back-dashbordbtn" onclick="window.history.go(-1); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg>
            Back
        </a>
    </div>

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts campaign_builder" class="whatsup-camp-build">
        <div class="row match-height">
            <div class="col-md-7 col-12">
                <div class="card m-0">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical"
                                action="{{ URL::to('reports/campaign/update/' . $campaign->schedule_id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="name"
                                                class="required form-label">{{ __('locale.labels.campaign_name') }}</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $campaign->campaign_name }}" name="name" required
                                                placeholder="{{ __('locale.labels.required') }}" autofocus>
                                            @error('name')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="contact_groups"
                                                class="form-label required">{{ __('locale.contacts.contact_groups') }}</label>
                                            <select class="select2 form-select" name="contact_groups[]" multiple="multiple"
                                                required="">
                                                @foreach ($contact_groups as $group)
                                                    <option
                                                        {{ in_array($group->id, explode(',', $campaign->batch_id)) ? 'selected' : '' }}
                                                        value="{{ $group->id }}"> {{ $group->name }}
                                                        ({{ Tool::number_with_delimiter($group->subscribersCount($group->cache)) }}
                                                        {{ __('locale.menu.Contacts') }})
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('contact_groups')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="date"
                                                class="form-label required">{{ __('locale.labels.schedule_date') }}</label>
                                            <input type="text" id="datepicker" class="form-control" name="date"
                                                required autocomplete="off"
                                                value="{{ date('Y-m-d H:i', strtotime($campaign->schedule_date . ' ' . $campaign->schedule_time)) }}">
                                            {{-- <input type="date" id="date" class="form-control" min="@php echo date('Y-m-d'); @endphp" name="date"> --}}
                                            @error('date')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-12">
                                        <div class="mb-1">
                                            <label for="time"
                                                class="form-label required">{{ __('locale.labels.schedule_time') }}</label>
                                            <input id="timepicker" class="form-control" type="text" name="time"
                                                required autocomplete="off"
                                                value="{{ date('H:i', strtotime($campaign->schedule_time)) }}">
                                            @error('time')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="mediaType"
                                                class="form-label d-block">{{ __('locale.labels.mediaType') }}</label>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="mediaType"
                                                    value="text" onchange="onChangeMediaType(this.value)"
                                                    {{ $campaign->media_type == 'text' ? 'checked' : '' }}>Text
                                                <label class="form-check-label"></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="mediaType"
                                                    value="specifiedFile" onchange="onChangeMediaType(this.value)"
                                                    {{ in_array($campaign->media_type, ['image', 'video', 'audio']) ? 'checked' : '' }}>Media
                                                <label class="form-check-label"></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="mediaType"
                                                    value="file" onchange="onChangeMediaType(this.value)"
                                                    {{ $campaign->media_type == 'file' ? 'checked' : '' }}>Document
                                                <label class="form-check-label"></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="mediaType"
                                                    value="contact" onchange="onChangeMediaType(this.value)"
                                                    {{ $campaign->media_type == 'contact' ? 'checked' : '' }}>Contact
                                                <label class="form-check-label"></label>
                                            </div>

                                            @error('mediaType')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="formMessageFields">
                                        @if ($campaign->media_type == 'text')
                                            @include('customer.contactGroups.mediaTypes._text', [
                                                'messageData' => json_decode($campaign->message),
                                            ])
                                        @elseif(in_array($campaign->media_type, ['image', 'video', 'audio']))
                                            @include(
                                                'customer.contactGroups.mediaTypes._specified_file_edit',
                                                [
                                                    'messageData' => json_decode($campaign->message),
                                                ]
                                            )
                                        @elseif($campaign->media_type == 'file')
                                            @include('customer.contactGroups.mediaTypes._file_edit', [
                                                'messageData' => json_decode($campaign->message),
                                            ])
                                        @elseif($campaign->media_type == 'contact')
                                            @include('customer.contactGroups.mediaTypes._contact', [
                                                'messageData' => json_decode($campaign->message),
                                            ])
                                        @endif
                                    </div>
                                </div>
                                <div class="row advanced_div">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" value="true" name="send_copy"
                                                    class="form-check-input">
                                                <label
                                                    class="form-check-label">{{ __('locale.campaigns.send_copy_via_email') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" value="true" name="create_template"
                                                    class="form-check-input">
                                                <label
                                                    class="form-check-label">{{ __('locale.campaigns.create_template_based_message') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" value="whatsapp" name="sms_type" id="sms_type" />
                                        <input type="hidden" value="{{ __('schedule') }}" name="schedule_type"
                                            id="schedule_type" />
                                        <input type="hidden" name="page_type" value="campaign_builder" />
                                        <input type="hidden" value="{{ $plan_id }}" name="plan_id" />
                                        <button type="submit" class="btn btn-primary mt-1 mb-1" id="post-wa"><i
                                                data-feather="save"></i> {{ __('locale.buttons.save') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div id="messagetype_prview">
                    <div id="formMessagePreview">
                        @if ($campaign->media_type == 'text')
                            @include('customer.contactGroups.mediaTypes._message_preview', [
                                'messageData' => json_decode($campaign->message),
                            ])
                        @elseif(in_array($campaign->media_type, ['image', 'video', 'audio']))
                            @include('customer.contactGroups.mediaTypes._specified_file_preview', [
                                'messageData' => json_decode($campaign->message),
                            ])
                        @elseif($campaign->media_type == 'file')
                            @include('customer.contactGroups.mediaTypes._file_preview', [
                                'messageData' => json_decode($campaign->message),
                            ])
                        @elseif($campaign->media_type == 'contact')
                            {{ dd(json_decode($campaign->message)) }}
                            @include('customer.contactGroups.mediaTypes._contact_preview', [
                                'messageData' => json_decode($campaign->message),
                            ])
                        @endif
                        {{-- @include('customer.contactGroups.mediaTypes._message_preview') --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/dom-rules.js')) }}"></script>
    <!--For Emoji -->
@endsection

@section('page-script')

    <!-- for conversion of tags -->
    <script src="{{ asset(mix('js/scripts/sms-counter.js')) }}"></script>

    <script>
        $(document).ready(function() {
            var today = new Date();
            today.setMinutes(today.getMinutes() + 5);
            var date = today.toISOString().split('T')[0];
            var time = today.getHours() + ":" + today.getMinutes();

            $('#datepicker').datetimepicker({
                    timepicker: true,
                    minDate: 0,
                    // minTime:0,
                    minDateTime: new Date(`${date} ${time}`),
                    format: 'Y-m-d H:i',
                    formatDate: 'd-m-Y',
                    step: 10
                })

                .on('change', function(e) {
                    $('#timepicker').val('')
                    var str = $(this).val();
                    // var today = new Date();
                    // var time = today.getHours() + ":" + today.getMinutes();
                    var dateTime = `${str} ${time}`

                    var setDisTime = {
                        minDateTime: null
                    }
                    if (new Date(dateTime) <= new Date()) {
                        setDisTime = {
                            minDateTime: new Date(dateTime)
                        }
                    }

                    $('#timepicker').datetimepicker({
                        datepicker: false,
                        ...setDisTime,
                        format: 'H:i',
                        step: 10
                    });
                    e.preventDefault();
                });
            jQuery.extend(jQuery.validator.messages, {
                accept: "Please enter valid media type file."
            });
        });

        
        function toMarkup($this) {
            var text = $this.text();
            text = text.replace(/\*\*(.*?)\*\*/g, "<b>$1</b>");
            text = text.replace(/__(.*?)__/g, "<u>$1</u>");
            text = text.replace(/~~(.*?)~~/g, "<i>$1</i>");
            text = text.replace(/--(.*?)--/g, "<del>$1</del>");
            text = text.replace(/<<(.*?)>>/g, "<a href='$1'>Link</a>");
            $this.html(text);
        }

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
            });
            var limit = 4096;
            quill.on('text-change', function(e, delta, old, source) {
                var delta = quill.getContents();
                let editorSelection = quill.getSelection();
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
                    return false;
                } else {
                    $('#remains-count').text(remain);

                }
                
                $(".appnedQuillTextMessage").val(addWsNodes(returndata));
                $("#messaage_preview").html(addWsNodes(justHtml).split('*').join('<b>').split("*").join('</b>'));
                $("#messaage_preview").html(addWsNodes(justHtml));
                var demoprev = toMarkup(addWsNodes(justHtml))
                $("#messaage_preview").html(demoprev.replace(/\\n/g, ''));
                $("#messaage-quick").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".img-cap").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".footerpreview").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".mediafooter").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".listmessage").html(addWsNodes(justHtml).replace(/\\n/g, ''));
                $(".file-caption").html(addWsNodes(justHtml).replace(/\\n/g, ''));
            });
        }
        function onChangeMediaType(type) {
            $.get("{{ URL::to('contacts/get-message-field-view') }}/" + type + "?useFor=form", function(data) {
                $('#formMessageFields').html(data);
                if (type == 'text') {
                    loadQuill()
                }
                if (type == 'button') {
                    loadQuill()
                }
                if (type == 'list') {
                    loadQuill()
                }
                if (type == 'specifiedFile') {
                    loadQuill()
                    // specifiedFile()
                    $("#mediaCaption .ql-editor").attr("data-placeholder", "Compose a Caption..");
                    $("#image_file").change(function() {
                        setTimeout(() => {
                            readURL(this);
                        }, 100)

                    });
                }
                if (type == 'file') {
                    loadQuill()
                    $("#any_file").change(function() {
                        $("#preview_allfile").removeClass('d-none');
                        setTimeout(() => {
                            $("#file-prev").text(this.files[0].name);
                        }, 300);
                    });
                    $("#mediaCaption .ql-editor").attr("data-placeholder", "Compose a Caption..");
                }
                if (type == 'contact') {
                    contactpreview()
                }
                if (type == 'button') {
                    buttonpreview()
                }
                if (type == 'mediaButton') {
                    loadQuill()
                    mediabuttonpreview()
                }
                if (type == 'list') {
                    listviewpreview()
                }
            })

            $.get("{{ URL::to('contacts/get-message-field-view') }}/" + type + "?useFor=preview", function(data) {
                $('#formMessagePreview').html(data);
                var content = $(data).find("#content");
                $("#result").empty().append(content);
            })
        }
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#spacified-img').attr('src', e.target.result);
                    var fileExt = input.files[0].name.split('.').pop();
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

                    if (fileExt == 'png' || fileExt == 'jpg' || fileExt == 'jpeg' || fileExt == 'gif' || fileExt ==
                        'webp') {
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

        function contactpreview() {
            // show contact data in preview
            $("#fullname").change(function() {
                var inputtext = document.getElementById("fullname").value;
                $("#fullname-demo").html(inputtext);
            });
            $('#displayname').change(function() {
                var inputdisname = document.getElementById("displayname").value;
                $("#displayname-demo").html(inputdisname);
            });
            $('#organization').change(function() {
                var inputorg = document.getElementById("organization").value;
                $("#organization-demo").html(inputorg);
            });
            $('#phonenumber').change(function() {
                var inputphone = document.getElementById("phonenumber").value;
                $("#phonenumber-demo").html(inputphone);
            });
        }

        function buttonpreview() {
            // show button data in preview
            $('#btn_title').change(function() {
                var inputdisname = document.getElementById("btn_title").value;
                $(".button-msg").html(inputdisname);
            });
            $('#reply_button_title').change(function() {
                var replybtnname = document.getElementById("reply_button_title").value;
                $(".btntext a").html(replybtnname);
            });
            $('#url_button_title').change(function() {
                var replybtnname1 = document.getElementById("url_button_title").value;
                $("#replytitle").html(replybtnname1);
            });
            $('#call_button').change(function() {
                var callbtnname = document.getElementById("call_button").value;
                $(".btncall span").html(callbtnname);
            });
            $('#url_button_payload').on('input', function() {
                $('.btnreplay a').prop('href', this.value);
            });
            $('#call_button_payload').on('input', function() {
                $('.btncall a').prop('href', this.value);
            });
        }

        function mediabuttonpreview() {
            $("#button_media_file").change(function() {
                $("#mediafile").text(this.files[0].name);
            });
            $('#mediatitle').change(function() {
                var replybtnname = document.getElementById("mediatitle").value;
                $(".buttonmedia-preview .button-msg").html(replybtnname);
            });
            $('#call_button_payload').change(function() {
                var replybtnname1 = document.getElementById("call_button_payload").value;
                $(".buttonmedia-preview .mediacall").html(replybtnname1);
            });
            $('#reply_button').change(function() {
                var replybtnname2 = document.getElementById("reply_button").value;
                $("#replaybtn").html(replybtnname2);
            });
            $('#call_button').change(function() {
                var replybtnname3 = document.getElementById("call_button").value;
                $("#callbtnreply").html(replybtnname3);
            });
        }

        function listviewpreview() {
            $('#title').change(function() {
                var replybtnname = document.getElementById("title").value;
                $("#listmaintitle").html(replybtnname);
            });
            $('#description').change(function() {
                var replybtnname1 = document.getElementById("description").value;
                $(".listmaindec").html(replybtnname1);
            });
            $('#list_title').change(function() {
                var replybtnname2 = document.getElementById("list_title").value;
                $(".listtitle").html(replybtnname2);
            });
            $('#button_text').change(function() {
                var replybtnname3 = document.getElementById("button_text").value;
                $("#replay-btn a").html(replybtnname3);
            });


            $("#addrowbtn")
                .on("click", function() {
                    $('#list_row_div').append($('#list_row_append').html())
                    var n = $("#list_row_append").length;
                    $("span").text("There are " + n + " divs." +
                        "Click to add more.");
                })
                // Trigger the click to start
                .trigger("click");


            var addButton = $('#addrowbtn');

            var wrapper = $('.wrap_add_input li.wrap_input');
            var conveniancecount = $("div[class*='conveniancecount']").length;

            function addMoreList(that) {

                $('#row_title').change(function() {
                    var replybtnname2 = document.getElementById("row_title").value;
                    $("#listrowtitle").html(replybtnname2);
                });
                $('#row_desc').change(function() {
                    var replybtnname3 = document.getElementById("row_desc").value;
                    $("#listrowdec").html(replybtnname3);
                });
            }
        }

        $(document).ready(function() {
            $('#post-wa').on('click', function() {
                if ($('input[type=hidden]').val().length === 0) {
                    alert('warning');
                }
            });
            $('.schedule_date').flatpickr({
                minDate: "today",
                dateFormat: "Y-m-d",
                defaultDate: "{{ date('Y-m-d') }}",
            });

            $('.flatpickr-time').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "{{ date('H:i') }}",
            });

            $(".sender_id").on("click", function() {
                $("#sender_id").prop("disabled", !this.checked);
                $("#phone_number").prop("disabled", this.checked);
            });

            $(".phone_number").on("click", function() {
                $("#phone_number").prop("disabled", !this.checked);
                $("#sender_id").prop("disabled", this.checked);
            });


            let schedule = $('.schedule'),
                scheduleTime = $(".schedule_time");

            if (schedule.prop('checked') === true) {
                scheduleTime.show();
            } else {
                scheduleTime.hide();
            }

            $('.advanced_div').hide();

            schedule.change(function() {
                scheduleTime.fadeToggle();
            });

            $('.advanced').change(function() {
                $('.advanced_div').fadeToggle();
            });

            $.createDomRules({

                parentSelector: 'body',
                scopeSelector: 'form',
                showTargets: function(rule, $controller, condition, $targets, $scope) {
                    $targets.fadeIn();
                },
                hideTargets: function(rule, $controller, condition, $targets, $scope) {
                    $targets.fadeOut();
                },

                rules: [{
                        controller: '#frequency_cycle',
                        value: 'custom',
                        condition: '==',
                        targets: '.show-custom',
                    },
                    {
                        controller: '#frequency_cycle',
                        value: 'onetime',
                        condition: '!=',
                        targets: '.show-recurring',
                    },
                    {
                        controller: '.message_type',
                        value: 'mms',
                        condition: '==',
                        targets: '.send-mms',
                    }
                ]
            });


            $(".select2").each(function() {
                let $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent()
                });
            });

            let $remaining = $('#remaining'),

                $messages = $remaining.next(),
                $get_msg = $("#message"),
                merge_state = $('#available_tag'),
                firstInvalid = $('form').find('.is-invalid').eq(0);

            if (firstInvalid.length) {
                $('body, html').stop(true, true).animate({
                    'scrollTop': firstInvalid.offset().top - 200 + 'px'
                }, 200);
            }


            function isArabic(text) {
                let pattern = /[\u0600-\u06FF\u0750-\u077F]/;
                return pattern.test(text);
            }

            function get_character() {
                if ($get_msg[0].value !== null) {

                    let data = SmsCounter.count($get_msg[0].value, true);

                    if (data.encoding === 'UTF16') {
                        if (isArabic($(this).val())) {
                            $get_msg.css('direction', 'rtl');
                        }
                    } else {
                        $get_msg.css('direction', 'ltr');
                    }

                    $remaining.text(data.remaining + " {!! __('locale.labels.characters_remaining') !!}");
                    $messages.text(data.messages + " {!! __('locale.labels.message') !!}" + '(s)');

                }

            }


            merge_state.on('change', function() {
                const caretPos = $get_msg[0].selectionStart;
                const textAreaTxt = $get_msg.val();
                let txtToAdd = this.value;
                if (txtToAdd) {
                    txtToAdd = '{' + txtToAdd + '}';
                }

                $get_msg.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(
                    caretPos));
            });


            $("#sms_template").on('change', function() {

                let template_id = $(this).val();

                $.ajax({
                    url: "{{ url('templates/show-data') }}" + '/' + template_id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    success: function(data) {
                        if (data.status === 'success') {
                            const caretPos = $get_msg[0].selectionStart;
                            const textAreaTxt = $get_msg.val();
                            let txtToAdd = data.message;

                            $get_msg.val(textAreaTxt.substring(0, caretPos) + txtToAdd +
                                textAreaTxt.substring(caretPos)).val().length;

                            get_character();

                        } else {
                            toastr['warning'](data.message,
                                "{{ __('locale.labels.attention') }}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                        }
                    },
                    error: function(reject) {
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
                        } else {
                            toastr['warning'](reject.responseJSON.message,
                                "{{ __('locale.labels.attention') }}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                        }
                    }
                });
            });

            $get_msg.keyup(get_character);

        });
    </script>
    <script>
        $(".whatsup-camp-build form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                fullname: {
                    required: true,
                    minlength: 2
                }
            }
        });
    </script>

@endsection
