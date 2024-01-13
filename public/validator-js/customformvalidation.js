$.validator.setDefaults({
  debug: false,
  success: "valid",
});
$('form').each(function () {
  if ($(this).data('validator'))
      $(this).data('validator').settings.ignore = ".note-editor *";
});
jQuery.validator.addMethod(
  "customEmail",
  function (value, element) {
    return (
      this.optional(element) ||
      /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value)
    );
  },
  "Please enter valid email address!"
);

jQuery.validator.addMethod(
  "uniqueEmail",
  function (value, element) {
    var result = false
    var email = $("#email").val();
    $.ajax({
      async: false,
      type: "GET",
      url: window.location.origin + "/check-username?email=" + email,
      success: function (response) {
        if (response.error) {
          result = false;
        } else {
          result = true;
        }
      },
    });
    return result;
  },

  "The email has already been taken."
);

jQuery.validator.addMethod(
  "uniquePhone",
  function (value, element) {
    var result = false
    var phone = $("#phone").val();
    $.ajax({
      async: false,
      type: "GET",
      url: window.location.origin + "/check-username?phone=" + phone,
      success: function (response) {
        if (response.error) {
          result = false;
        } else {
          result = true;
        }
      },
    });
    return result;
  },
  "The phone has already been taken."
);
$(".validationforms").validate({
  
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
    },
    phone: {
      required: true,
      digits: true,
      minlength: 10,
      maxlength: 10
    },
    password: {
      required: true,
      minlength: 8,
    },
    password_confirmation: {
      required: true,
      minlength: 8,
      equalTo: "#password",
    },
  },
  messages: {
    mobile: {
      minlength: "Your phone number must be at least 6 digits long",
      maxlength: "Your phone number only 12 ",
    },
    password_confirmation: {
      equalTo: "Entered Password and Confirm password do not match",
    },
  },
  highlight: function (element, errorClass, validClass) {
    if ($(element).attr("type") === "password") {
      this.findByName(element.name)
        .parent("div.form-password-toggle")
        .addClass("newclass");
    }
    if ($(element).attr("type") === "password_confirmation") {
      this.findByName(element.name)
        .parent("div.form-password-toggle")
        .addClass("newclass");
    }
  },
  onkeyup: function (element) {
    this.element(element);
  },
});
//    ------------------Registartion page------------------------
let registerMultiStepsWizard = document.querySelector(
    ".register-multi-steps-wizard"
  ),
  pageResetForm = $(".auth-register-form"),
  numberedStepper,
  priceOption = $(".pricing-data"),
  select = $(".select2");

priceOption.delegate(".planPrice", "click", function (e) {
  e.stopPropagation();
  if ($(this).data("value") === "0.00") {
    $(".hide-for-free").hide();
  } else {
    $(".hide-for-free").show();
  }
});

// multi-steps registration
// --------------------------------------------------------------------
var form = $("#registration");
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
    email: {
      required: true,
      customEmail: true,
      uniqueEmail: true,
    },
    phone: {
      required: true,
      digits: true,
      minlength: 10,
      maxlength: 10,
      uniquePhone: true,
    },
    message: {
      required: true,
      minlength: 2,
    },
    password: {
      required: true,
      minlength: 8,
    },
    password_confirmation: {
      required: true,
      minlength: 8,
      equalTo: "#password",
    },
  },
  messages: {
    email: {
      required: "Please enter your email address.",
      email: "Please enter a valid email address.",
      remote: "Email ID Already registered",
    },
    password_confirmation: {
      equalTo: "Entered Password and Confirm password do not match",
    },
  },
  highlight: function (element, errorClass, validClass) {
    if ($(element).attr("type") === "password") {
      this.findByName(element.name)
        .parent("div.form-password-toggle")
        .addClass("newclass");
    }
    if ($(element).attr("type") === "password_confirmation") {
      this.findByName(element.name)
        .parent("div.form-password-toggle")
        .addClass("newclass");
    }
  },
  onkeyup: function (element) {
    this.element(element);
  },
});

// Horizontal Wizard
if (
  typeof registerMultiStepsWizard != undefined &&
  registerMultiStepsWizard != null
) {
  numberedStepper = new Stepper(registerMultiStepsWizard);
  $(registerMultiStepsWizard)
    .find(".btn-next")

    .each(function () {
      $("#account-details .btn-next").on('click', function (e) {
        $.validator.setDefaults({
          debug: false,
          success: "valid",
        });
        $("#phone").rules("add", {
          messages: {
            minlength: "Enter number must be 10 digits.",
          },
        });
        if (form.valid() === true) {
          $("#account-details").removeClass("active");
          $("#personal-info").addClass("active");
          numberedStepper.next();
          $("#account-details-trigger").removeClass("active");
          $("#personal-info-trigger").addClass("active");
        }
      });


      $("#personal-info .btn-next").on('click', function (e) {
        var form = $("#registration");
        form.validate({
          
          rules: {
            address: {
              required: true,
            },
            city: {
              required: true,
            },
          },
          messages: {
            address: {
              required: "This is required.",
            },
            city: {
              required: "This is required.",
            },
          },
          onkeyup: function (element) {
            this.element(element);
          },
        });
        if (form.valid() === true) {
          $("#personal-info").removeClass("active");
          $("#billing").addClass("active");
          numberedStepper.next();
          $("#personal-info-trigger").removeClass("active");
          $("#billing-trigger").addClass("active");
        }
      });

      $("#billing .btn-submit").on('click', function (e) {
        var form = $("#registration");
        form.validate({
          
          rules: {
            plans: {
              required: true,
            },
            payment_methods: {
              required: true,
            },
          },
          messages: {
            plans: {
              required: "This is required.",
            },
            payment_methods: {
              required: "This is required.",
            },
          },
          onkeyup: function (element) {
            this.element(element);
          },
        });
        console.log(form.valid());
        if (form.valid() === false) {
          e.preventDefault();
          return false;
        } else {
          $("#registration").submit();
        }
      });
    });

  $(registerMultiStepsWizard)
  $("#personal-info .btn-prev").on('click', function (e) {
    $("#account-details").addClass("active");
    $("#personal-info").removeClass("active");

    $("#account-details-trigger").addClass("active");
    $("#personal-info-trigger").removeClass("active");
  });
  $("#billing .btn-prev").on('click', function (e) {
    $("#billing").removeClass("active");
    $("#personal-info").addClass("active");

    $("#personal-info-trigger").addClass("active");
    $("#billing-trigger").removeClass("active");
  });
  $("#registration #phone")
    .unbind("keyup change input paste")
    .bind("keyup change input paste", function (e) {
      var $this = $(this);
      var val = $this.val();
      var valLength = val.length;
      var maxCount = $this.attr("maxlength");
      if (valLength > maxCount) {
        $this.val($this.val().substring(0, maxCount));
      }
    });
}
// select countery code
const phoneInputField = document.querySelector("#phone");
const phoneInput = window.intlTelInput(phoneInputField, {
  initialCountry: "In",
  separateDialCode: true,
  allowDropdown: false,
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
});
// select2
select.each(function () {
  let $this = $(this);
  $this.wrap('<div class="position-relative"></div>');
  $this.select2({
    dropdownAutoWidth: true,
    width: "100%",
    dropdownParent: $this.parent(),
  });
});
$(document).on("select2:open", () => {
  document.querySelector(".select2-search__field").focus();
});

// ------------ cart input ------------------

$('.qtyplus').click(function (e) {
  e.preventDefault();
  var $input  = $(this).prev('input');
  console.log($input.val())
  var currentVal = parseInt($input.val());
  if (!isNaN(currentVal)) {
      $input.val(currentVal + 1);
  } else {
      $input.val(1);
  }
});
$('.qtyminus').click(function (e) {
  e.preventDefault();
  var $input  = $(this).next('input');
  var currentVal = parseInt($input.val());
  if (!isNaN(currentVal)) {
    if(currentVal > 1){
      $input.val(currentVal - 1);
    }
  } else {
      $input.val(1);
  }
});
// Dropdown toggle
$(function() { 
  $('.dropdown-toggle').click(function() { $(this).next('.dropdown-menu').slideToggle();
  });
  
  $(document).click(function(e) 
  { 
  var target = e.target; 
  if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) 
  //{ $('dropdown-menu').hide(); }
    { $('.dropdown-menu').slideUp(); }
  });
});


// ------------ Registration cart input ------------------

$('.addonqtyplus').click(function (e) {
  e.preventDefault();
  var $input  = $(this).prev('input');
  // console.log($input.val())
  var currentVal = parseInt($input.val());
  if (!isNaN(currentVal)) {
      $input.val(currentVal + 1);
  } else {
      $input.val(0);
  }
});
$('.addonqtyminus').click(function (e) {
  e.preventDefault();
  var $input  = $(this).next('input');
  var currentVal = parseInt($input.val());
  if (!isNaN(currentVal)) {
    if(currentVal > 0){
      $input.val(currentVal - 1);
    }
  } else {
      $input.val();
  }
});