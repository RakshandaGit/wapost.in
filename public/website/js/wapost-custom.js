// --------------- Home page js ----------------------
//   function openForm() {
    //     document.getElementById("popupForm").style.display = "block";
    //     document.getElementById("popupForm").style.opacity = 1;
    //     var element = document.getElementById("popupForm");
    //      element.classList.add("show-form");
    //   }

    //   function closeForm() {
    //     document.getElementById("popupForm").style.display = "none";
    //     document.getElementById("popupForm").style.opacity = 0;
    //   }
      
    // $(document).ready(function(){

    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //     $('#enquiryForm').submit(function(e){

    //         e.preventDefault();
    //         var btn = $('#contactBtn');

    //         var name = $('#name').val();

    //         var email = $('#email').val();

    //         var mobile = $('#mobile').val();

    //         var message = $('#message').val();
    //         var form_send = true;
    //         /*Name validation*/

    //         if(name == ''  || name.length < 3) {

    //             $("#name").focus();

    //             $('.name-has-error').text('Please enter a valid name.');

    //             form_send = false;

    //         }else{
    //             $('.name-has-error').text('');
    //         }

    //         /*Mobile number validation*/

    //         if (isNaN(mobile) || mobile == 0 || mobile == -1 || mobile.length != 10) {
    //             $("#mobile").focus();
    //             $('.mobile-has-error').text('Please enter a valid mobile number.');
    //             form_send = false;
    //         }else{
    //             $('.mobile-has-error').text('');
    //         }

    //         /*Email Validation*/

    //         var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    //         if(email == ''  || email == "null" || email.length < 2 || !regex.test(email)) {
    //             $("#email").focus();
    //             $('.email-has-error').text('Please enter a valid email address.');
    //             form_send = false;
    //         }else{
    //             $('.email-has-error').text('');
    //         }

    //         if (form_send) {
    //             $.ajax({
    //                 url: '{{ route('postEnquiry') }}',
    //                 type: "POST",
    //                 data: {
    //                     _token: CSRF_TOKEN,
    //                     name: name,
    //                     email: email,
    //                     mobile: mobile,
    //                     message: message
    //                 },
    //                 dataType: 'json',
    //                 beforeSend: function(){
    //                     btn.attr('disabled','')
    //                     btn.html('Please Wait....')
    //                 },

    //                 /* remind that 'data' is the response of the AjaxController */

    //                 success: function (data) {
    //                     console.log(data);
    //                     if(data.status == true){
    //                         $('#name').val('');
    //                         $('#email').val('');
    //                         $('#mobile').val('');
    //                         $('#message').val('');
    //                         $('.success-message').show();
    //                         $('.success-message-text').html(data.message);
    //                         setTimeout(function() {
    //                             $(".success-message").fadeOut(700)
    //                         }, 15000);
    //                         setTimeout(function() {
    //                             $('.success-message-text').html('');
    //                         }, 16000);
    //                     }else{

    //                     }
    //                 },

    //                 complete: function(){
    //                     btn.removeAttr('disabled')
    //                     btn.html('Sent Message')
    //                 }
    //             });
    //         }
    //         return false;
    //     })

    // });
// ------------------ End home page -----------------------------
// ------------------ Contact Us page -----------------------------
$(document).ready(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#contactForm').submit(function(e) {
        e.preventDefault();
        var btn = $('#contactBtn');
        var name = $('#name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var message = $('#message').val();
        // var url = '{{ route(postContact) }}';
        var url = window.location.origin + "/post-contact";
            
        $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: CSRF_TOKEN,
                name: name,
                email: email,
                mobile: mobile,
                message: message
            },
            dataType: 'json',
            beforeSend: function() {
                btn.attr('disabled', '')
                btn.html('Please Wait....')
            },
            success: function(data) {
                if (data.status == true) {

                    $('#name').val('');
                    $('#email').val('');
                    $('#mobile').val('');
                    $('#message').val('');
                    $('.success-message').show();
                    window.scrollTo(0, 0);
                    $('.success-message-text').html(data.message);
                    
                    setTimeout(function() {
                        $(".success-message").fadeOut(700)
                    }, 15000);

                    setTimeout(function() {
                        $('.success-message-text').html('');
                    }, 16000);

                }
            },
            complete: function() {
                btn.removeAttr('disabled')
                btn.html('Sent Message')
            }
        });
        return false;
    });
    // ---------------------- Contact US page -----------------------------
    $("#contactForm #contactBtn").on('click', function (e) {
    var form = $("#contactForm");
    form.validate({
      rules: {
        name: {
          required: true,
          minlength: 2,
        },
        first_name: {
          required: true,
          minlength: 2,
        },
        // last_name: {
        //     required: true,
        //     minlength: 5
        // },
    
        mobile: {
          required: true,
          digits: true,
          minlength: 6,
          maxlength: 12,
        },
        message: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          customEmail: true
        }
      },
      messages: {
        mobile: {
          minlength: "Your phone number must be at least 6 digits long",
          maxlength: "Your phone number only 12 ",
        },
      }
    });
    // console.log(form.valid());
    if (form.valid() === false) {
      e.preventDefault();
      return false;
    } else {
      $("#contactForm #contactBtn").click(function () {
        $("#contactForm").submit();
      });
    }
    });
});

// ------------- Blog page ----------------
// $(document).ready(function(){
           
//   //  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//   $(document).on('click', '#subscribeEmails', function(event){
      
//       event.preventDefault();

//       $.ajaxSetup({
//           headers: {
//               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//           }
//       });
//       var url_blog = window.location.origin + "/subscribe-email";
//       $.ajax({
//           /* the route pointing to the post function */
//           url: url_blog,
//           type: "POST",
//           /* send the csrf-token and the input to the controller */
//           data: {
//               email: email,
//               // phone: phone,
//               type: subscribe_input
//           },
//           dataType: 'JSON',
//           beforeSend: function(){
//               btn.children('a').attr('disabled','').html('Please Wait....');
//           },
//           /* remind that 'data' is the response of the AjaxController */
//           success: function (data) {
//               console.log(data.message);
//               if(data.status == true){
//                   $('#'+subscribe_input).val('');
//                   $('#'+subscribe_input).parents('div.subscribe_form').prepend('<p class="text-success small mb-0 form-group">'+data.message+'</p>');
//               }else{
//                   $('#'+subscribe_input).parents('div.subscribe_form').prepend('<p class="text-danger small mb-0 form-group">'+data.message+'</p>');
//               }
//               setTimeout(function() {
//                   $('#'+subscribe_input).parents('div.subscribe_form').children('p').remove();
//               }, 10000)
//           },
//           error:function(errors, ero){
//               console.log(ero);
//           },
//           complete: function(){
//               if(subscribe_input == 'subscribe_email')
//               {
//                   btn.children('a').removeAttr('disabled').html('<img src="website/img/icon/bell.png" alt="">subscribe');
//               }else{
//                   btn.children('a').removeAttr('disabled').html('Sign Up For Free');
//               }
//           }
//       });
//   })
// });

$("#blogform").on('submit', function(e){
  e.preventDefault();
  
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  var basicbtnhtml=$('.basicbtn').html();
  $.ajax({
      type: 'POST',
      url: this.action,
      data: new FormData(this),
      dataType: 'json',
      contentType: false,
      cache: false,
      processData:false,
      beforeSend: function() {

          $('.basicbtn').html("Please Wait....");
          $('.basicbtn').attr('disabled','')

      },
      
      success: function(response){ 
          $('.basicbtn').removeAttr('disabled')
          if(response.type == 'success'){
              Sweet('success',response.message);
          }else{
              Sweet('error','Failed to update.');
          }
          $('.basicbtn').html(basicbtnhtml);
          //success(response);
      },
      error: function(xhr, status, error) 
      {
          $('.basicbtn').html(basicbtnhtml);
          $('.basicbtn').removeAttr('disabled')
          $('.errorarea').show();
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
              Sweet('error',item)
              $("#errors").html("<li class='text-danger'>"+item+"</li>")
          });
          errosresponse(xhr, status, error);
      }
  })
});
