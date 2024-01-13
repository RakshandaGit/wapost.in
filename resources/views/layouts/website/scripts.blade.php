<!-- Jquery Js -->
<script src="{{asset('website/js/jquery-3.6.0.min.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('website/js/bootstrap.min.js')}}"></script>
<!-- magnific popup -->
<script src="{{asset('website/js/jquery.magnific-popup.js')}}"></script>
<!-- wow -->
<script src="{{asset('website/js/wow.min.js')}}"></script>
<!-- Nice Select -->
<script src="{{asset('website/js/jquery.nice-select.js')}}"></script>
<!-- countdown -->
<script src="{{asset('website/js/jquery.countdown.min.js')}}"></script>
<!-- Odomiters -->
<script src="{{asset('website/js/odometer.min.js')}}"></script>
<!-- Viewport Js -->
<script src="{{asset('website/js/viewport.jquery.js')}}"></script>
<!-- slick Js -->
<script src="{{asset('website/js/slick.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('website/js/main.js')}}"></script>
<!-- All Sustom js -->
<script src="{{asset('website/js/wapost-custom.js')}}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('validator-js/additional-methods.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="{{ asset('validator-js/customformvalidation.js') }}"></script>

@yield('page-script')
<!-- Validation custom script -->

{{-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> --}}


<script type="text/javascript">
    $(document).ready(function(){
       
        //  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).on('click', '#subscribeEmail', function(event){
            
            event.preventDefault();
            var subscribe_input = $(this).prev('input').attr('id');
            console.log(subscribe_input, "subscribe_input ok done");
            var btn = $(this);
            var email = (subscribe_input=='subscribe_email')?$('#subscribe_email').val():'';
            var phone = (subscribe_input=='subscribe_phone')?$('#subscribe_phone').val():'';

            if(subscribe_input=='subscribe_email' && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
                $('#subscribe_email').parents('div.subscribe_form').prepend('<p class="text-danger small mb-0 form-group">Please enter a valid Email-ID!</p>');
                setTimeout(function() { 
                    $('#subscribe_email').parents('div.subscribe_form').children('p').remove();
                }, 5000)
                return false;
            }
            if(subscribe_input=='subscribe_phone' && !/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/.test(phone)){ 
                $('#'+subscribe_input).parents('div.subscribe_form').prepend('<p class="text-danger small mb-0 form-group">Please enter a valid Mobile Number!</p>');
                setTimeout(function() { 
                    $('#'+subscribe_input).parents('div.subscribe_form').children('p').remove();
                }, 5000)
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                /* the route pointing to the post function */
                url: '{{ route('subscribe') }}',
                type: "POST",
                /* send the csrf-token and the input to the controller */
                data: {
                    email: email,
                    phone: phone,
                    type: subscribe_input
                },
                dataType: 'JSON',
                beforeSend: function(){
                    btn.children('a').attr('disabled','').html('Please Wait....');
                },
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    console.log(data.message);
                    if(data.status == true){
                        $('#'+subscribe_input).val('');
                        $('#'+subscribe_input).parents('div.subscribe_form').prepend('<p class="text-success small mb-0 form-group">'+data.message+'</p>');
                    }else{
                        $('#'+subscribe_input).parents('div.subscribe_form').prepend('<p class="text-danger small mb-0 form-group">'+data.message+'</p>');
                    }
                    setTimeout(function() {
                        $('#'+subscribe_input).parents('div.subscribe_form').children('p').remove();
                    }, 10000)
                },
                error:function(errors, ero){
                    console.log(ero);
                },
                complete: function(){
                    if(subscribe_input == 'subscribe_email')
                    {
                        btn.children('a').removeAttr('disabled').html('<img src="website/img/icon/bell.png" alt="">subscribe');
                    }else{
                        btn.children('a').removeAttr('disabled').html('Sign Up For Free');
                    }
                }
            });
        })
    });
</script>