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
        console.log(n * 20 + ' Seconds Completed! & ', 'n = ' + n);
    }

    function checkNow() {
        console.log(n)
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
            // console.log("Sleep");
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
        console.log('hey');
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
                // get_wa_token();
                countdown2();
            }
        }, 1000);
    }

    /* get instance id*/
    var action = '';
    var key_id = '{{ $user->key_id }}';
    var key_secret = '{{ $user->key_secret }}';

    function get_wa_token() {
        $("#qr_code_img img").remove();
        $('.reload-qr').show();
        $.ajax({
            url: 'https://oc.wapost.net/instance/init?key_secret=' + key_secret + '&key_id=' + key_id +
                '&wa_mobile=8600363127',
            type: 'GET',
            dataType: "json",
            success: function(res) {
                console.log('get_wa_token:', res);
                if (res.error == false) {
                    $('#instance_key').text();
                    $('#instance_key').text(res.instance_key);
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
            url: 'https://oc.wapost.net/instance/qrbase64?key=' + instance_key,
            type: 'GET',
            dataType: "json",
            success: function(res) {
                console.log('get_qrcode: ', res);
                if (res.error == false) {
                    var image = new Image();
                    image.src = res.qrcode;
                    $('.reload-qr').hide();
                    $('#qr_code_img').append(image);
                    $('.js-timeout').html('0:20');
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
                url: 'https://oc.wapost.net/instance/info?key=' + instance_key,
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


                        // $('#contact_tab6 .status-icon').empty();
                        // $('#contact_tab6 .status-icon').html('<i class="fas fa-check-circle text-success"></i>');

                        clearInterval(interval);
                        clearInterval(intervalCallNow);
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
                if (res.error == false) {
                    $('#instance_key').text();
                    $('#instance_key').text(instance_key);
                }
            }
        });
    }

    $(document).on('click', '#disconnect_account', function() {
        var instance_key = $('#instance_key').text();
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
                }
            }
        });
    })

    function reconnectOnLoad(instance_key) {

        if (QrScaned != true) {
            if (instance_key != '' || instance_key != null) {
                $.ajax({
                    url: 'https://oc.wapost.net/instance/qrbase64?key=' + instance_key,
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
                console.log(data);
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
                '<span>Code will change in </span><b><span class="text-danger js-timeout">0:20</span> sec.</b>'
                );
            n = 0;
            get_wa_token();
            countdown();
            console.log(n);
        })
        var instance_key = "{{ isset($connection->key) ? $connection->key : '' }}";
        console.log(instance_key);
        if (instance_key) {
            reconnectOnLoad(instance_key)
        } else {
            get_wa_token();
        }
    });
</script>
