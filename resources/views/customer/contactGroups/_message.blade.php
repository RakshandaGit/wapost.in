@php use App\Library\Tool; @endphp
<div class="whatsup-camp-build">
    <div class="row match-height">
        <div class="col-md-7 col-12">
            <div class="card m-0">
                <div class="card-body">
                    <!-- <form class="form form-vertical" action="{{ route('customer.contacts.message', $contact->uid) }}" method="post"> -->
                    <form class="form form-vertical" action="{{ url('whatsapp/campaign-builder') }}" method="post"
                        enctype="multipart/form-data">

                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="schedule" class="form-label d-block">Message
                                        {{ __('locale.labels.type') }}</label>
                                    {{-- <select class="select2 form-select" name="schedule_type"
                                        onchange="messageType(this.value)">
                                        <option value="{{ __('locale.labels.schedule') }}">
                                            {{ __('locale.labels.schedule') }}</option>
                                        <option value="{{ __('immediate') }}"> {{ __('Immediate') }}</option>
                                    </select> --}}
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="schedule_type"
                                            value="{{ __('schedule') }}" onchange="messageType(this.value)"
                                            checked>{{ __('locale.labels.schedule') }}
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="schedule_type"
                                            value="{{ __('immediate') }}"
                                            onchange="messageType(this.value)">{{ __('Immediate') }}
                                        <label class="form-check-label"></label>
                                    </div>
                                    @error('contact_groups')
                                        <p><small class="text-danger">{{ $message }}</small></p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="schedule">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="date"
                                            class="form-label required">{{ __('locale.labels.schedule_date') }}</label>
                                        {{-- <input type="date" id="date" class="form-control" min="@php echo date('Y-m-d'); @endphp" name="date"> --}}
                                        <input type="text" id="datepicker" class="form-control" name="date"
                                            required autocomplete="off">
                                        @error('contact_groups')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label for="time"
                                            class="form-label required">{{ __('locale.labels.schedule_time') }}</label>
                                        {{-- <input type="time" id="time" name="time" class="form-control"> --}}
                                        <input id="timepicker" class="form-control" type="text" name="time"
                                            required autocomplete="off">
                                        @error('contact_groups')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--   using on select message like sms template in ultimate sms     --}}

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label for="mediaType"
                                        class="form-label d-block">{{ __('locale.labels.mediaType') }}</label>
                                    {{-- <select class="select2 form-select" name="mediaType"
                                        onchange="onChangeMediaType(this.value)">
                                        <option value="text"> Send Text</option>
                                        <option value="specifiedFile"> Send Media</option>
                                        <option value="file"> Send File Or Document</option>
                                        <option value="contact"> Send Contact</option>
                                        <option value="button"> Send Button Message</option>
                                        <option value="list"> Send List Message</option>
                                        <option value="mediaButton"> Send Button With Media</option>
                                    </select> --}}
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="mediaType" value="text"
                                            onchange="onChangeMediaType(this.value)" checked>Text
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="mediaType"
                                            value="specifiedFile" onchange="onChangeMediaType(this.value)">Media
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="mediaType" value="file"
                                            onchange="onChangeMediaType(this.value)">Document
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="mediaType" value="contact"
                                            onchange="onChangeMediaType(this.value)">Contact
                                        <label class="form-check-label"></label>
                                    </div>

                                    @error('mediaType')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="formMessageFields">
                            @include('customer.contactGroups.mediaTypes._text')
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <input type="hidden" name="page_type" value="single_contact" />
                                <input type="hidden" name="contact_groups[]" value="{{ $contact->id }}" />
                                <button type="submit" id="submit" class="btn btn-primary mb-1 sechdulebtn">
                                    <i data-feather="save"></i> {{ __('locale.buttons.save') }}
                                </button>
                                <button type="submit" id="submit" class="btn btn-primary mb-1 imedatebtn"
                                    style="display:none;">
                                    <i data-feather="send"></i> {{ __('locale.buttons.send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-12">
            <div id="messagetype_prview">
                <div id="formMessagePreview">
                    @include('customer.contactGroups.mediaTypes._message_preview')
                </div>
            </div>
        </div>
    </div>
</div>
@section('page-script')
    <script>
        $(document).ready(function () {
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

            .on('change', function (e) {
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
        function messageType(type) {
            if (type == 'immediate') {
                $('#schedule').hide();
                $('#datepicker').removeAttr('required');
                $('#timepicker').removeAttr('required');
                $('.imedatebtn').show();
                $('.sechdulebtn').hide();
            } else {
                $('#schedule').show();
                $('#datepicker').attr('required', '');
                $('#timepicker').attr('required', '');
                $('.imedatebtn').hide();
                $('.sechdulebtn').show();
            }
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
                    specifiedFile()
                    $("#mediaCaption .ql-editor").attr("data-placeholder", "Compose a Caption..");
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
                var delta1 = quill.getContents();
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
                $("#messaage_preview").html(addWsNodes(justHtml));
                $(".img-cap").html(addWsNodes(justHtml));
                $(".footerpreview").html(addWsNodes(justHtml));
                $(".mediafooter").html(addWsNodes(justHtml));
                $(".file-caption").html(addWsNodes(justHtml));

            });

        }

        function specifiedFile() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#spacified-img').attr('src', e.target.result);
                        var fileExt = input.files[0].name.split('.').pop();
                        if (fileExt == 'm4v' || fileExt == 'avi' || fileExt == 'mpg' || fileExt == 'mp4') {
                            $("#divVideo").show();
                            $("#divaudio").hide();
                        }

                        if (fileExt == 'mp3' || fileExt == 'wav' || fileExt == 'ogg') {
                            $("#divaudio").show();
                            $("#divVideo").hide();
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_file").change(function() {
                readURL(this);
            });
        }

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
