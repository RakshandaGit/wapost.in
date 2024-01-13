<!-- BEGIN: Vendor JS-->
<script src="{{asset('website/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset(mix('vendors/js/ui/jquery.sticky.js')) }}"></script>
<script src="{{ asset('vendors/js/jquery.datetimepicker.full.min.js') }}"></script>
{{-- <script src="http://cdn.craig.is/js/rainbow-custom.min.js"></script> --}}

@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custom scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>
<script src="{{ asset('vendors/wa-editors/quill/quill.editor.js') }}"></script>
<script src="{{ asset('vendors/wa-editors/quill/quill.emoji.js') }}"></script>
<script src="{{ asset('message_script/messagescript.js') }}"></script>

<!-- Validation custom script -->
<script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('validator-js/additional-methods.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<!-- END: Theme JS-->
<script>
    var media_selector = $("#mediaWA");
    var allowed_ext = ['jpeg', 'jpg', 'mp4'];
    var allowed_file = ['image', 'video'];
    var pre_media = $("#media_preview");
    var pre_media_pop = $("#message_media");

    $(document).ready(function() {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        var fname, fsize, fpath, fext, ftype;

        media_selector.on("change", function(evnt) {

            var media = evnt.target.files[0];
            console.log(media);
            $("#mediaErrorShow").html('');
            pre_media.html('');
            pre_media_pop.html('');
            $('#removeAttachment').hide();

            if (evnt.target.files.length > 0) {
                let mediaOK = true;
                let mediaError = '';

                fpath = (window.URL || window.webkitURL).createObjectURL(media); // Path
                fext = media.name.split('.').pop(); // extension
                fsize = media.size / 1024 / 1024; // size in MB
                ftype = media.type;
                ftype = ftype.substr(0, ftype.indexOf("/")).toLowerCase(); // type
                /* Validations */
                if (allowed_file.indexOf(ftype) >= 0) {
                    if (allowed_ext.indexOf(fext) == -1) {
                        mediaOK = false;
                        mediaError += ' "' + fext.toUpperCase() +
                            '" this file extension are not allowed. Only ' + allowed_ext.join(', ')
                            .toUpperCase() + ' are allowed. ';
                    }
                    if (ftype == 'video' && fsize > 10) {
                        mediaOK = false;
                        mediaError += 'Video file size should be less than equals to 10 MB. ';
                    }
                    if (ftype == 'image' && fsize > 1.5) {
                        mediaOK = false;
                        mediaError += 'Image file size should be less than equals to 1.5 MB. ';
                    }
                } else {
                    mediaOK = false;
                    mediaError += 'Only ' + allowed_file.join(', ').toUpperCase() +
                        ' file types are allowed. ';
                }

                if (mediaOK) {
                    let reader = new FileReader();
                    reader.readAsDataURL(media);
                    reader.onloadend = function(evt) {
                        if (evt.target.readyState == FileReader.DONE) {

                            pre_media.empty();
                            pre_media_pop.empty();

                            let tmpElement;
                            let tmpElementPop
                            //# if IMAGE...
                            if (ftype == "image") {
                                tmpElement = $('<img />', {
                                    class: 'img-fluid',
                                    alt: ''
                                });

                                tmpElementPop = $('<img />', {
                                    class: 'img-fluid',
                                    alt: ''
                                });
                            }
                            //# if VIDEO...
                            if (ftype == "video") {
                                tmpElement = $('<video />', {
                                    class: 'img-fluid',
                                    type: 'video/mp4',
                                    controls: true
                                });
                                tmpElementPop = $('<video />', {
                                    class: 'img-fluid',
                                    type: 'video/mp4',
                                    controls: true
                                });
                            }

                            tmpElement.attr("src", fpath);
                            tmpElementPop.attr("src", fpath);

                            pre_media.html(tmpElement);
                            pre_media_pop.html(tmpElementPop);

                            $('#removeAttachment').show();
                        }
                    }
                } else {
                    $("#mediaErrorShow").html(mediaError);
                    media_selector.val('');
                    pre_media.html('');


                }
            }
        });
    });
</script>

<script type="text/javascript">
    var toolbarOptions = {
        container: [
            ['bold', 'italic', 'strike'],
            ['clean'],
            ['emoji'],
        ]
    }
</script>
<script>
    $(document).ready(function() {
        $(".ql-formats button").each(function() {
            var name = $(this).attr('class').split('-');
            $(this).attr('data-bs-toggle', 'tooltip').attr('title', name[1].toLowerCase().replace(
                /\b(\w)/g, s => s.toUpperCase()));
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<script src="{{ asset(mix('js/scripts/sms-counter.js')) }}"></script>

<script>
    $(document).ready(function() {

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

        // $.createDomRules({

        //     parentSelector: 'body',
        //     scopeSelector: 'form',
        //     showTargets: function (rule, $controller, condition, $targets, $scope) {
        //         $targets.fadeIn();
        //     },
        //     hideTargets: function (rule, $controller, condition, $targets, $scope) {
        //         $targets.fadeOut();
        //     },

        //     rules: [
        //         {
        //             controller: '#frequency_cycle',
        //             value: 'custom',
        //             condition: '==',
        //             targets: '.show-custom',
        //         },
        //         {
        //             controller: '#frequency_cycle',
        //             value: 'onetime',
        //             condition: '!=',
        //             targets: '.show-recurring',
        //         },
        //         {
        //             controller: '.message_type',
        //             value: 'mms',
        //             condition: '==',
        //             targets: '.send-mms',
        //         }
        //     ]
        // });


        $(".select2").each(function() {
            let $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
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

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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

<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<script>
    let isRtl = $('html').attr('data-textdirection') === 'rtl';
</script>
@if (Auth::check() && Auth::user()->active_portal == 'customer' && Auth::user()->is_customer == 1)
    @if (Auth::user()->customer->activeSubscription() == null)
        <script>
            toastr['warning']("{!! __('locale.customer.no_active_subscription') !!}", 'Warning!', {
                closeButton: true,
                positionClass: 'toast-bottom-right',
                containerId: 'toast-bottom-right',
                timeout: 0,
                rtl: isRtl
            });
        </script>
    @endif
@endif

{{-- page script --}}
@yield('page-script')
<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>

@if (Session::has('message'))
    <script>
        let type = "{{ Session::get('status', 'success') }}";
        switch (type) {
            case 'info':
                toastr['info']("{!! Session::get('message') !!}", '{{ __('locale.labels.information') }}!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                    rtl: isRtl
                });

                break;

            case 'warning':
                toastr['warning']("{!! Session::get('message') !!}", '{{ __('locale.labels.warning') }}!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                    rtl: isRtl
                });
                break;

            case 'success':
                toastr['success']("{!! Session::get('message') !!}", '{{ __('locale.labels.success') }}!!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                    rtl: isRtl
                });
                break;

            case 'error':
                toastr['error']("{!! Session::get('message') !!}", '{{ __('locale.labels.ops') }}..!!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                    rtl: isRtl
                });
                break;
        }
    </script>
@endif
