@extends('layouts.website')
<link rel="stylesheet" href="https://wapost.net/vendors/css/forms/select/select2.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://wapost.net/vendors/js/forms/select/select2.full.min.js"></script>

<style>
.content.get_form_data {
    display: none;
    visibility: hidden;
}

.content.get_form_data.active {
    display: block;
    visibility: visible;
}

.auth-bg {
    background-color: #fff;
}

.width-700 {
    width: 700px !important;
}

.bs-stepper {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 4px 24px 0 rgba(34, 41, 47, .1);
}

.bs-stepper .bs-stepper-header {
    border-bottom: 1px solid rgba(34, 41, 47, .08);
    flex-wrap: wrap;
    margin: 0;
    padding: 1.5rem;
}

.px-0 {
    padding-left: 0 !important;
    padding-right: 0 !important;
}

.bs-stepper-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
}

.bs-stepper .bs-stepper-header .step {
    margin-bottom: 0.25rem;
    margin-top: 0.25rem;
}

.bs-stepper .bs-stepper-header .step .step-trigger {
    flex-wrap: nowrap;
    font-weight: 400;
    padding: 0;
}

.bs-stepper .step-trigger.disabled,
.bs-stepper .step-trigger:disabled {
    pointer-events: none;
    opacity: .65;
}

.bs-stepper .step-trigger {
    display: -ms-inline-flexbox;
    display: inline-flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding: 20px;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.5;
    color: #6c757d;
    text-align: center;
    text-decoration: none;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: none;
    border-radius: 0.25rem;
    transition: background-color .15s ease-out, color .15s ease-out;
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-box {
    align-items: center;
    background-color: rgba(186, 191, 199, .12);
    border-radius: 0.35rem;
    color: #babfc7;
    display: flex;
    font-weight: 500;
    height: 38px;
    justify-content: center;
    padding: 0.5em 0;
    width: 38px;
}

svg.font-medium-3 {
    height: 1.3rem !important;
    width: 1.3rem !important;
}

.font-medium-3 {
    font-size: 1.3rem !important;
}

.feather,
[data-feather] {
    height: 1rem;
    width: 1rem;
    display: inline-block;
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label {
    margin: 0.5rem 0 0 1rem;
    text-align: left;
}

.bs-stepper-label {
    display: inline-block;
    margin: 0.25rem;
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-title {
    color: #6e6b7b;
    display: inherit;
    font-weight: 600;
    line-height: 1rem;
    margin-bottom: 0;
}

.bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-subtitle {
    color: #b9b9c3;
    font-size: .85rem;
    font-weight: 400;
}

.bs-stepper .bs-stepper-header .line {
    background-color: transparent;
    color: #6e6b7b;
    flex: 0;
    font-size: 1.5rem;
    margin: 0;
    min-height: auto;
    min-width: auto;
    padding: 0 1.75rem;
}

.bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-box {
    background-color: #08828c;
    box-shadow: 0 3px 6px 0 rgb(8 130 140 / 43%);
    color: #fff;
}

.bs-stepper .bs-stepper-header .step.active .step-trigger .bs-stepper-label .bs-stepper-title {
    color: #08828c;
}

.bs-stepper .bs-stepper-header .step.active .step-trigger {
    opacity: 1;
}

.content-header h2 {
    color: #5e5873;
    font-weight: 600;
    line-height: 1.2;
    margin-bottom: 0.5rem;
    margin-top: 0;
    font-size: calc(1.2964rem + .5568vw);
}

.content-header span {
    color: #6e6b7b;
    font-family: "Montserrat", Helvetica, Arial, serif;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.45;
}

form label {
    color: #5e5873;
    font-size: .857rem;
    margin-bottom: 0.2857rem;
}

.form-control {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid #d8d6de;
    border-radius: 0.357rem;
    color: #6e6b7b;
    display: block;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.45;
    padding: 0.571rem 1rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    width: 100%;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
}

.select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    padding-left: 8px;
    padding-right: 20px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Change the white to any color */
form .get_form_data input:-webkit-autofill,
form .get_form_data input:-webkit-autofill:hover,
form .get_form_data input:-webkit-autofill:focus,
form .get_form_data input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}

form .get_form_data .input-group-text {
    background-color: #fff;
}

.input-group-merge .form-control:not(:last-child) {
    border-right: 0;
    padding-right: 0;
}

.position-relative .position-relative:nth-child(2) {
    display: none;
}

form .get_form_data .form-control {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid #d8d6de;
    border-radius: 0.357rem;
    color: #6e6b7b;
    display: block;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.45;
    padding: 0.571rem 1rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.select2-container--classic .select2-selection--single,
.select2-container--default .select2-selection--single {
    border: 1px solid #d8d6de;
    min-height: 2.714rem;
    padding: 5px;
}

.select2-container--classic .select2-selection--single .select2-selection__arrow b,
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    background-image: url("public/website/img/icon/select-arrow.svg");
    background-repeat: no-repeat;
    background-size: 18px 14px, 18px 14px;
    border-style: none;
    height: 1rem;
    left: -8px;
    margin-left: 0;
    margin-top: 0;
    padding-right: 1.5rem;
}

.custom-options-checkable .custom-option-item {
    background-color: hsla(213, 4%, 53%, .06);
    border: 1px solid #ebe9f1;
    border-radius: 0.42rem;
    color: #82868b;
    cursor: pointer;
    width: 100%;
}

.custom-options-checkable .custom-option-item {
    background-color: hsla(213, 4%, 53%, .06);
    border: 1px solid #ebe9f1;
    border-radius: .42rem;
    color: #82868b;
    cursor: pointer;
    width: 100%
}

.custom-options-checkable .custom-option-item .custom-option-item-title {
    color: #82868b
}

.custom-option-item-check {
    clip: rect(0, 0, 0, 0);
    position: absolute;
}

.custom-option-item-check:checked+.custom-option-item {
    background-color: rgba(115, 103, 240, .12);
    border-color: #7367f0;
    color: #7367f0
}

.custom-option-item-check:checked+.custom-option-item .custom-option-item-title {
    color: #7367f0
}

.auth-wrapper .custom-options-checkable .plan-price .pricing-value {
    font-size: 3rem;
    color: var(--main-color-one) !important;
}

.font-medium-1 {
    font-size: 1.1rem !important;
    font-weight: 500 !important;
    color: rgba(110, 107, 123, 1) !important;
}

.custom-option-item span.d-block {
    color: #82868b;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1.45;
    font-weight: 400;
    font-family: var(--body-font);
}
.back-btn a {
    color: #0d6efd;
}
.content.get_form_data .btn-primary,.content.get_form_data .btn-success {
    display: inline-block;
    font-family: var(--body-font);
    font-size: 18px;
    font-weight: 600;
    line-height: 0;
    text-transform: capitalize;
    color: var(--heading-color);
    background-color: #fff;
    padding: 20px 24px 20px;
    border: 1px solid #E4E4E4;
    border-radius: 15px;
    text-align: center;
    cursor: pointer;
    -webkit-transition: all ease-in-out 0.2s;
    transition: all ease-in-out 0.2s;
    position: relative;
    z-index: 1;
}
.content.get_form_data .btn-primary,.content.get_form_data .btn-success {
    background-color: var(--main-color-one);
    border-color: var(--main-color-one);
    color: #fff;
}
.content.get_form_data .btn-primary:hover,.content.get_form_data .btn-success:hover{
    background-color: transparent;
    color: var(--main-color-one);
}
.content.get_form_data button.btn.btn-outline-secondary {
    border-radius: 10px;
    display: inline-block;
    font-family: var(--body-font);
    font-size: 18px;
    line-height: 0;
    text-transform: capitalize;
    background-color: #fff;
    padding: 20px 20px 20px;
    border-radius: 15px;
    text-align: center;
    -webkit-transition: all ease-in-out 0.2s;
    transition: all ease-in-out 0.2s;
    position: relative;
    z-index: 1;
}
.widget.widget_subscribe .subscibe-wrapper .content-wrap .icon{
    display: flex;
    align-items: center;
    justify-content: center;
}
.required:after {
    content:" *";
    color: red;
}
form .get_form_data .form-control:focus{
    background-color: #fff;
    border-color: #08828c;
    box-shadow: 0 3px 10px 0 rgba(34,41,47,.1);
    color: #6e6b7b;
    outline: 0;
}
.input-group:not(.bootstrap-touchspin):focus-within .form-control, .input-group:not(.bootstrap-touchspin):focus-within .input-group-text {
    border-color: #08828c;
    box-shadow: none;
}
.select2-container--classic.select2-container--open .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--single {
    border-color: #08828c!important;
    outline: 0;
}
@media (max-width:768px){
    .bs-stepper .bs-stepper-header{
        display: block;
    }
    .bs-stepper .bs-stepper-header .line{
        opacity: 0;
    }
}
@media (max-width:991px){
    .content-wrapper.register-page{
        margin-top:50px;
    }
}
</style>
@section('content')

<div class="content-wrapper register-page">
    <div class="content-body">
        <div class="container custom-container">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Left Text-->
                    <div class="col-lg-3 d-none d-lg-flex align-items-center p-0">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center">
                            <img class="img-fluid w-100" src="{{asset('images/pages/create-account.svg')}}"
                                alt="WAPOST">
                        </div>
                    </div>
                    <!-- /Left Text-->

                    <!-- Register-->
                    <div class="col-lg-9 d-flex align-items-center auth-bg px-2 px-sm-3 px-lg-5 pt-3 pb-5">
                        <div class="width-700 mx-auto">
                            <div class="bs-stepper register-multi-steps-wizard shadow-none linear">
                                <div class="bs-stepper-header px-0" role="tablist">


                                    <div class="step active" data-target="#account-details" role="tab"
                                        id="account-details-trigger">
                                        <button type="button" class="step-trigger" aria-selected="true"
                                            disabled="disabled">
                                            <span class="bs-stepper-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-home font-medium-3">
                                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                                </svg>
                                            </span>
                                            <span class="bs-stepper-label">
                                                <span class="bs-stepper-title">Account</span>
                                                <span class="bs-stepper-subtitle">Enter credentials</span>
                                            </span>
                                        </button>
                                    </div>


                                    <div class="line">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-chevron-right font-medium-2">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </div>

                                    <div class="step" data-target="#personal-info" role="tab"
                                        id="personal-info-trigger">
                                        <button type="button" class="step-trigger" aria-selected="false"
                                            disabled="disabled">
                                            <span class="bs-stepper-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-user font-medium-3">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </span>

                                            <span class="bs-stepper-label">
                                                <span class="bs-stepper-title">Personal</span>
                                                <span class="bs-stepper-subtitle">Personal Information</span>
                                            </span>
                                        </button>
                                    </div>


                                    <div class="line">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-chevron-right font-medium-2">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </div>
                                    <div class="step" data-target="#billing" role="tab" id="billing-trigger">
                                        <button type="button" class="step-trigger" aria-selected="false"
                                            disabled="disabled">
                                            <span class="bs-stepper-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-credit-card font-medium-3">
                                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                                </svg>
                                            </span>

                                            <span class="bs-stepper-label">
                                                <span class="bs-stepper-title">Billing</span>
                                                <span class="bs-stepper-subtitle">Payment Details</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <div class="bs-stepper-content px-0 mt-5">



                                    <form method="POST" action="https://wapost.net/register">
                                        <input type="hidden" name="_token"
                                            value="74X6QbHse3TmyoLFXz7pgbC5YIcQVYJCuoHoSupJ">
                                        <div id="account-details" class="content get_form_data active dstepper-block"
                                            role="tabpanel" aria-labelledby="account-details-trigger">
                                            <div class="content-header mb-3">
                                                <h1 class="fw-bolder mb-4">Account Information</h1>
                                                <span>Fill the below form to create a new account</span>
                                            </div>

                                            <div class="row">

                                                <div class="col-12 mb-4">
                                                    <label class="form-label required" for="email">Email</label>
                                                    <input type="email" id="email" class="form-control required "
                                                        value="" name="email" required="">
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required" for="password">Password</label>
                                                    <div class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" id="password" class="form-control "
                                                            value="" name="password" required="">
                                                        <span class="input-group-text cursor-pointer" onclick="toggle_pass()"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="14" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-eye">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                </path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required"
                                                        for="password_confirmation">Confirm password</label>
                                                    <div class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" id="password_confirmation"
                                                            class="form-control " value="" name="password_confirmation"
                                                            required="">
                                                        <span class="input-group-text cursor-pointer" onclick="toggle_confpass()"><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="14" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-eye">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                </path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg></span>
                                                    </div>
                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required" for="timezone">Timezone</label>
                                                    <div class="position-relative"><select
                                                            class="select2 w-100 select2-hidden-accessible"
                                                            name="timezone" id="timezone" data-select2-id="timezone"
                                                            tabindex="-1" aria-hidden="true">
                                                            <option value="Atlantic/Cape_Verde">
                                                                (GMT-01:00) Atlantic/Cape_Verde
                                                            </option>
                                                            <option value="America/Miquelon">
                                                                (GMT-02:00) America/Miquelon
                                                            </option>
                                                            <option value="America/Noronha">
                                                                (GMT-02:00) America/Noronha
                                                            </option>
                                                            <option value="America/Nuuk">
                                                                (GMT-02:00) America/Nuuk
                                                            </option>
                                                            <option value="Atlantic/South_Georgia">
                                                                (GMT-02:00) Atlantic/South_Georgia
                                                            </option>
                                                            <option value="America/St_Johns">
                                                                (GMT-02:30) America/St_Johns
                                                            </option>
                                                            <option value="America/Araguaina">
                                                                (GMT-03:00) America/Araguaina
                                                            </option>
                                                            <option value="America/Argentina/Buenos_Aires">
                                                                (GMT-03:00) America/Argentina/Buenos_Aires
                                                            </option>
                                                            <option value="America/Argentina/Catamarca">
                                                                (GMT-03:00) America/Argentina/Catamarca
                                                            </option>
                                                            <option value="America/Argentina/Cordoba">
                                                                (GMT-03:00) America/Argentina/Cordoba
                                                            </option>
                                                            <option value="America/Argentina/Jujuy">
                                                                (GMT-03:00) America/Argentina/Jujuy
                                                            </option>
                                                            <option value="America/Argentina/La_Rioja">
                                                                (GMT-03:00) America/Argentina/La_Rioja
                                                            </option>
                                                            <option value="America/Argentina/Mendoza">
                                                                (GMT-03:00) America/Argentina/Mendoza
                                                            </option>
                                                            <option value="America/Argentina/Rio_Gallegos">
                                                                (GMT-03:00) America/Argentina/Rio_Gallegos
                                                            </option>
                                                            <option value="America/Argentina/Salta">
                                                                (GMT-03:00) America/Argentina/Salta
                                                            </option>
                                                            <option value="America/Argentina/San_Juan">
                                                                (GMT-03:00) America/Argentina/San_Juan
                                                            </option>
                                                            <option value="America/Argentina/San_Luis">
                                                                (GMT-03:00) America/Argentina/San_Luis
                                                            </option>
                                                            <option value="America/Argentina/Tucuman">
                                                                (GMT-03:00) America/Argentina/Tucuman
                                                            </option>
                                                            <option value="America/Argentina/Ushuaia">
                                                                (GMT-03:00) America/Argentina/Ushuaia
                                                            </option>
                                                            <option value="America/Bahia">
                                                                (GMT-03:00) America/Bahia
                                                            </option>
                                                            <option value="America/Belem">
                                                                (GMT-03:00) America/Belem
                                                            </option>
                                                            <option value="America/Cayenne">
                                                                (GMT-03:00) America/Cayenne
                                                            </option>
                                                            <option value="America/Fortaleza">
                                                                (GMT-03:00) America/Fortaleza
                                                            </option>
                                                            <option value="America/Glace_Bay">
                                                                (GMT-03:00) America/Glace_Bay
                                                            </option>
                                                            <option value="America/Goose_Bay">
                                                                (GMT-03:00) America/Goose_Bay
                                                            </option>
                                                            <option value="America/Halifax">
                                                                (GMT-03:00) America/Halifax
                                                            </option>
                                                            <option value="America/Maceio">
                                                                (GMT-03:00) America/Maceio
                                                            </option>
                                                            <option value="America/Moncton">
                                                                (GMT-03:00) America/Moncton
                                                            </option>
                                                            <option value="America/Montevideo">
                                                                (GMT-03:00) America/Montevideo
                                                            </option>
                                                            <option value="America/Paramaribo">
                                                                (GMT-03:00) America/Paramaribo
                                                            </option>
                                                            <option value="America/Punta_Arenas">
                                                                (GMT-03:00) America/Punta_Arenas
                                                            </option>
                                                            <option value="America/Recife">
                                                                (GMT-03:00) America/Recife
                                                            </option>
                                                            <option value="America/Santarem">
                                                                (GMT-03:00) America/Santarem
                                                            </option>
                                                            <option value="America/Santiago">
                                                                (GMT-03:00) America/Santiago
                                                            </option>
                                                            <option value="America/Sao_Paulo">
                                                                (GMT-03:00) America/Sao_Paulo
                                                            </option>
                                                            <option value="America/Thule">
                                                                (GMT-03:00) America/Thule
                                                            </option>
                                                            <option value="Antarctica/Palmer">
                                                                (GMT-03:00) Antarctica/Palmer
                                                            </option>
                                                            <option value="Antarctica/Rothera">
                                                                (GMT-03:00) Antarctica/Rothera
                                                            </option>
                                                            <option value="Atlantic/Bermuda">
                                                                (GMT-03:00) Atlantic/Bermuda
                                                            </option>
                                                            <option value="Atlantic/Stanley">
                                                                (GMT-03:00) Atlantic/Stanley
                                                            </option>
                                                            <option value="America/Anguilla">
                                                                (GMT-04:00) America/Anguilla
                                                            </option>
                                                            <option value="America/Antigua">
                                                                (GMT-04:00) America/Antigua
                                                            </option>
                                                            <option value="America/Aruba">
                                                                (GMT-04:00) America/Aruba
                                                            </option>
                                                            <option value="America/Asuncion">
                                                                (GMT-04:00) America/Asuncion
                                                            </option>
                                                            <option value="America/Barbados">
                                                                (GMT-04:00) America/Barbados
                                                            </option>
                                                            <option value="America/Blanc-Sablon">
                                                                (GMT-04:00) America/Blanc-Sablon
                                                            </option>
                                                            <option value="America/Boa_Vista">
                                                                (GMT-04:00) America/Boa_Vista
                                                            </option>
                                                            <option value="America/Campo_Grande">
                                                                (GMT-04:00) America/Campo_Grande
                                                            </option>
                                                            <option value="America/Caracas">
                                                                (GMT-04:00) America/Caracas
                                                            </option>
                                                            <option value="America/Cuiaba">
                                                                (GMT-04:00) America/Cuiaba
                                                            </option>
                                                            <option value="America/Curacao">
                                                                (GMT-04:00) America/Curacao
                                                            </option>
                                                            <option value="America/Detroit">
                                                                (GMT-04:00) America/Detroit
                                                            </option>
                                                            <option value="America/Dominica">
                                                                (GMT-04:00) America/Dominica
                                                            </option>
                                                            <option value="America/Grand_Turk">
                                                                (GMT-04:00) America/Grand_Turk
                                                            </option>
                                                            <option value="America/Grenada">
                                                                (GMT-04:00) America/Grenada
                                                            </option>
                                                            <option value="America/Guadeloupe">
                                                                (GMT-04:00) America/Guadeloupe
                                                            </option>
                                                            <option value="America/Guyana">
                                                                (GMT-04:00) America/Guyana
                                                            </option>
                                                            <option value="America/Havana">
                                                                (GMT-04:00) America/Havana
                                                            </option>
                                                            <option value="America/Indiana/Indianapolis">
                                                                (GMT-04:00) America/Indiana/Indianapolis
                                                            </option>
                                                            <option value="America/Indiana/Marengo">
                                                                (GMT-04:00) America/Indiana/Marengo
                                                            </option>
                                                            <option value="America/Indiana/Petersburg">
                                                                (GMT-04:00) America/Indiana/Petersburg
                                                            </option>
                                                            <option value="America/Indiana/Vevay">
                                                                (GMT-04:00) America/Indiana/Vevay
                                                            </option>
                                                            <option value="America/Indiana/Vincennes">
                                                                (GMT-04:00) America/Indiana/Vincennes
                                                            </option>
                                                            <option value="America/Indiana/Winamac">
                                                                (GMT-04:00) America/Indiana/Winamac
                                                            </option>
                                                            <option value="America/Iqaluit">
                                                                (GMT-04:00) America/Iqaluit
                                                            </option>
                                                            <option value="America/Kentucky/Louisville">
                                                                (GMT-04:00) America/Kentucky/Louisville
                                                            </option>
                                                            <option value="America/Kentucky/Monticello">
                                                                (GMT-04:00) America/Kentucky/Monticello
                                                            </option>
                                                            <option value="America/Kralendijk">
                                                                (GMT-04:00) America/Kralendijk
                                                            </option>
                                                            <option value="America/La_Paz">
                                                                (GMT-04:00) America/La_Paz
                                                            </option>
                                                            <option value="America/Lower_Princes">
                                                                (GMT-04:00) America/Lower_Princes
                                                            </option>
                                                            <option value="America/Manaus">
                                                                (GMT-04:00) America/Manaus
                                                            </option>
                                                            <option value="America/Marigot">
                                                                (GMT-04:00) America/Marigot
                                                            </option>
                                                            <option value="America/Martinique">
                                                                (GMT-04:00) America/Martinique
                                                            </option>
                                                            <option value="America/Montserrat">
                                                                (GMT-04:00) America/Montserrat
                                                            </option>
                                                            <option value="America/Nassau">
                                                                (GMT-04:00) America/Nassau
                                                            </option>
                                                            <option value="America/New_York">
                                                                (GMT-04:00) America/New_York
                                                            </option>
                                                            <option value="America/Port-au-Prince">
                                                                (GMT-04:00) America/Port-au-Prince
                                                            </option>
                                                            <option value="America/Port_of_Spain">
                                                                (GMT-04:00) America/Port_of_Spain
                                                            </option>
                                                            <option value="America/Porto_Velho">
                                                                (GMT-04:00) America/Porto_Velho
                                                            </option>
                                                            <option value="America/Puerto_Rico">
                                                                (GMT-04:00) America/Puerto_Rico
                                                            </option>
                                                            <option value="America/Santo_Domingo">
                                                                (GMT-04:00) America/Santo_Domingo
                                                            </option>
                                                            <option value="America/St_Barthelemy">
                                                                (GMT-04:00) America/St_Barthelemy
                                                            </option>
                                                            <option value="America/St_Kitts">
                                                                (GMT-04:00) America/St_Kitts
                                                            </option>
                                                            <option value="America/St_Lucia">
                                                                (GMT-04:00) America/St_Lucia
                                                            </option>
                                                            <option value="America/St_Thomas">
                                                                (GMT-04:00) America/St_Thomas
                                                            </option>
                                                            <option value="America/St_Vincent">
                                                                (GMT-04:00) America/St_Vincent
                                                            </option>
                                                            <option value="America/Toronto">
                                                                (GMT-04:00) America/Toronto
                                                            </option>
                                                            <option value="America/Tortola">
                                                                (GMT-04:00) America/Tortola
                                                            </option>
                                                            <option value="America/Atikokan">
                                                                (GMT-05:00) America/Atikokan
                                                            </option>
                                                            <option value="America/Bogota">
                                                                (GMT-05:00) America/Bogota
                                                            </option>
                                                            <option value="America/Cancun">
                                                                (GMT-05:00) America/Cancun
                                                            </option>
                                                            <option value="America/Cayman">
                                                                (GMT-05:00) America/Cayman
                                                            </option>
                                                            <option value="America/Chicago">
                                                                (GMT-05:00) America/Chicago
                                                            </option>
                                                            <option value="America/Eirunepe">
                                                                (GMT-05:00) America/Eirunepe
                                                            </option>
                                                            <option value="America/Guayaquil">
                                                                (GMT-05:00) America/Guayaquil
                                                            </option>
                                                            <option value="America/Indiana/Knox">
                                                                (GMT-05:00) America/Indiana/Knox
                                                            </option>
                                                            <option value="America/Indiana/Tell_City">
                                                                (GMT-05:00) America/Indiana/Tell_City
                                                            </option>
                                                            <option value="America/Jamaica">
                                                                (GMT-05:00) America/Jamaica
                                                            </option>
                                                            <option value="America/Lima">
                                                                (GMT-05:00) America/Lima
                                                            </option>
                                                            <option value="America/Matamoros">
                                                                (GMT-05:00) America/Matamoros
                                                            </option>
                                                            <option value="America/Menominee">
                                                                (GMT-05:00) America/Menominee
                                                            </option>
                                                            <option value="America/North_Dakota/Beulah">
                                                                (GMT-05:00) America/North_Dakota/Beulah
                                                            </option>
                                                            <option value="America/North_Dakota/Center">
                                                                (GMT-05:00) America/North_Dakota/Center
                                                            </option>
                                                            <option value="America/North_Dakota/New_Salem">
                                                                (GMT-05:00) America/North_Dakota/New_Salem
                                                            </option>
                                                            <option value="America/Ojinaga">
                                                                (GMT-05:00) America/Ojinaga
                                                            </option>
                                                            <option value="America/Panama">
                                                                (GMT-05:00) America/Panama
                                                            </option>
                                                            <option value="America/Rankin_Inlet">
                                                                (GMT-05:00) America/Rankin_Inlet
                                                            </option>
                                                            <option value="America/Resolute">
                                                                (GMT-05:00) America/Resolute
                                                            </option>
                                                            <option value="America/Rio_Branco">
                                                                (GMT-05:00) America/Rio_Branco
                                                            </option>
                                                            <option value="America/Winnipeg">
                                                                (GMT-05:00) America/Winnipeg
                                                            </option>
                                                            <option value="Pacific/Easter">
                                                                (GMT-05:00) Pacific/Easter
                                                            </option>
                                                            <option value="America/Bahia_Banderas">
                                                                (GMT-06:00) America/Bahia_Banderas
                                                            </option>
                                                            <option value="America/Belize">
                                                                (GMT-06:00) America/Belize
                                                            </option>
                                                            <option value="America/Boise">
                                                                (GMT-06:00) America/Boise
                                                            </option>
                                                            <option value="America/Cambridge_Bay">
                                                                (GMT-06:00) America/Cambridge_Bay
                                                            </option>
                                                            <option value="America/Chihuahua">
                                                                (GMT-06:00) America/Chihuahua
                                                            </option>
                                                            <option value="America/Ciudad_Juarez">
                                                                (GMT-06:00) America/Ciudad_Juarez
                                                            </option>
                                                            <option value="America/Costa_Rica">
                                                                (GMT-06:00) America/Costa_Rica
                                                            </option>
                                                            <option value="America/Denver">
                                                                (GMT-06:00) America/Denver
                                                            </option>
                                                            <option value="America/Edmonton">
                                                                (GMT-06:00) America/Edmonton
                                                            </option>
                                                            <option value="America/El_Salvador">
                                                                (GMT-06:00) America/El_Salvador
                                                            </option>
                                                            <option value="America/Guatemala">
                                                                (GMT-06:00) America/Guatemala
                                                            </option>
                                                            <option value="America/Inuvik">
                                                                (GMT-06:00) America/Inuvik
                                                            </option>
                                                            <option value="America/Managua">
                                                                (GMT-06:00) America/Managua
                                                            </option>
                                                            <option value="America/Merida">
                                                                (GMT-06:00) America/Merida
                                                            </option>
                                                            <option value="America/Mexico_City">
                                                                (GMT-06:00) America/Mexico_City
                                                            </option>
                                                            <option value="America/Monterrey">
                                                                (GMT-06:00) America/Monterrey
                                                            </option>
                                                            <option value="America/Regina">
                                                                (GMT-06:00) America/Regina
                                                            </option>
                                                            <option value="America/Swift_Current">
                                                                (GMT-06:00) America/Swift_Current
                                                            </option>
                                                            <option value="America/Tegucigalpa">
                                                                (GMT-06:00) America/Tegucigalpa
                                                            </option>
                                                            <option value="America/Yellowknife">
                                                                (GMT-06:00) America/Yellowknife
                                                            </option>
                                                            <option value="Pacific/Galapagos">
                                                                (GMT-06:00) Pacific/Galapagos
                                                            </option>
                                                            <option value="America/Creston">
                                                                (GMT-07:00) America/Creston
                                                            </option>
                                                            <option value="America/Dawson">
                                                                (GMT-07:00) America/Dawson
                                                            </option>
                                                            <option value="America/Dawson_Creek">
                                                                (GMT-07:00) America/Dawson_Creek
                                                            </option>
                                                            <option value="America/Fort_Nelson">
                                                                (GMT-07:00) America/Fort_Nelson
                                                            </option>
                                                            <option value="America/Hermosillo">
                                                                (GMT-07:00) America/Hermosillo
                                                            </option>
                                                            <option value="America/Los_Angeles">
                                                                (GMT-07:00) America/Los_Angeles
                                                            </option>
                                                            <option value="America/Mazatlan">
                                                                (GMT-07:00) America/Mazatlan
                                                            </option>
                                                            <option value="America/Phoenix">
                                                                (GMT-07:00) America/Phoenix
                                                            </option>
                                                            <option value="America/Tijuana">
                                                                (GMT-07:00) America/Tijuana
                                                            </option>
                                                            <option value="America/Vancouver">
                                                                (GMT-07:00) America/Vancouver
                                                            </option>
                                                            <option value="America/Whitehorse">
                                                                (GMT-07:00) America/Whitehorse
                                                            </option>
                                                            <option value="America/Anchorage">
                                                                (GMT-08:00) America/Anchorage
                                                            </option>
                                                            <option value="America/Juneau">
                                                                (GMT-08:00) America/Juneau
                                                            </option>
                                                            <option value="America/Metlakatla">
                                                                (GMT-08:00) America/Metlakatla
                                                            </option>
                                                            <option value="America/Nome">
                                                                (GMT-08:00) America/Nome
                                                            </option>
                                                            <option value="America/Sitka">
                                                                (GMT-08:00) America/Sitka
                                                            </option>
                                                            <option value="America/Yakutat">
                                                                (GMT-08:00) America/Yakutat
                                                            </option>
                                                            <option value="Pacific/Pitcairn">
                                                                (GMT-08:00) Pacific/Pitcairn
                                                            </option>
                                                            <option value="America/Adak">
                                                                (GMT-09:00) America/Adak
                                                            </option>
                                                            <option value="Pacific/Gambier">
                                                                (GMT-09:00) Pacific/Gambier
                                                            </option>
                                                            <option value="Pacific/Marquesas">
                                                                (GMT-09:30) Pacific/Marquesas
                                                            </option>
                                                            <option value="Pacific/Honolulu">
                                                                (GMT-10:00) Pacific/Honolulu
                                                            </option>
                                                            <option value="Pacific/Rarotonga">
                                                                (GMT-10:00) Pacific/Rarotonga
                                                            </option>
                                                            <option value="Pacific/Tahiti">
                                                                (GMT-10:00) Pacific/Tahiti
                                                            </option>
                                                            <option value="Pacific/Midway">
                                                                (GMT-11:00) Pacific/Midway
                                                            </option>
                                                            <option value="Pacific/Niue">
                                                                (GMT-11:00) Pacific/Niue
                                                            </option>
                                                            <option value="Pacific/Pago_Pago">
                                                                (GMT-11:00) Pacific/Pago_Pago
                                                            </option>
                                                            <option value="Africa/Abidjan">
                                                                (GMT+00:00) Africa/Abidjan
                                                            </option>
                                                            <option value="Africa/Accra">
                                                                (GMT+00:00) Africa/Accra
                                                            </option>
                                                            <option value="Africa/Bamako">
                                                                (GMT+00:00) Africa/Bamako
                                                            </option>
                                                            <option value="Africa/Banjul">
                                                                (GMT+00:00) Africa/Banjul
                                                            </option>
                                                            <option value="Africa/Bissau">
                                                                (GMT+00:00) Africa/Bissau
                                                            </option>
                                                            <option value="Africa/Casablanca">
                                                                (GMT+00:00) Africa/Casablanca
                                                            </option>
                                                            <option value="Africa/Conakry">
                                                                (GMT+00:00) Africa/Conakry
                                                            </option>
                                                            <option value="Africa/Dakar">
                                                                (GMT+00:00) Africa/Dakar
                                                            </option>
                                                            <option value="Africa/El_Aaiun">
                                                                (GMT+00:00) Africa/El_Aaiun
                                                            </option>
                                                            <option value="Africa/Freetown">
                                                                (GMT+00:00) Africa/Freetown
                                                            </option>
                                                            <option value="Africa/Lome">
                                                                (GMT+00:00) Africa/Lome
                                                            </option>
                                                            <option value="Africa/Monrovia">
                                                                (GMT+00:00) Africa/Monrovia
                                                            </option>
                                                            <option value="Africa/Nouakchott">
                                                                (GMT+00:00) Africa/Nouakchott
                                                            </option>
                                                            <option value="Africa/Ouagadougou">
                                                                (GMT+00:00) Africa/Ouagadougou
                                                            </option>
                                                            <option value="Africa/Sao_Tome">
                                                                (GMT+00:00) Africa/Sao_Tome
                                                            </option>
                                                            <option value="America/Danmarkshavn">
                                                                (GMT+00:00) America/Danmarkshavn
                                                            </option>
                                                            <option value="America/Scoresbysund">
                                                                (GMT+00:00) America/Scoresbysund
                                                            </option>
                                                            <option value="Atlantic/Azores">
                                                                (GMT+00:00) Atlantic/Azores
                                                            </option>
                                                            <option value="Atlantic/Reykjavik">
                                                                (GMT+00:00) Atlantic/Reykjavik
                                                            </option>
                                                            <option value="Atlantic/St_Helena">
                                                                (GMT+00:00) Atlantic/St_Helena
                                                            </option>
                                                            <option value="UTC">
                                                                (GMT+00:00) UTC
                                                            </option>
                                                            <option value="Africa/Algiers">
                                                                (GMT+01:00) Africa/Algiers
                                                            </option>
                                                            <option value="Africa/Bangui">
                                                                (GMT+01:00) Africa/Bangui
                                                            </option>
                                                            <option value="Africa/Brazzaville">
                                                                (GMT+01:00) Africa/Brazzaville
                                                            </option>
                                                            <option value="Africa/Douala">
                                                                (GMT+01:00) Africa/Douala
                                                            </option>
                                                            <option value="Africa/Kinshasa">
                                                                (GMT+01:00) Africa/Kinshasa
                                                            </option>
                                                            <option value="Africa/Lagos">
                                                                (GMT+01:00) Africa/Lagos
                                                            </option>
                                                            <option value="Africa/Libreville">
                                                                (GMT+01:00) Africa/Libreville
                                                            </option>
                                                            <option value="Africa/Luanda">
                                                                (GMT+01:00) Africa/Luanda
                                                            </option>
                                                            <option value="Africa/Malabo">
                                                                (GMT+01:00) Africa/Malabo
                                                            </option>
                                                            <option value="Africa/Ndjamena">
                                                                (GMT+01:00) Africa/Ndjamena
                                                            </option>
                                                            <option value="Africa/Niamey">
                                                                (GMT+01:00) Africa/Niamey
                                                            </option>
                                                            <option value="Africa/Porto-Novo">
                                                                (GMT+01:00) Africa/Porto-Novo
                                                            </option>
                                                            <option value="Africa/Tunis">
                                                                (GMT+01:00) Africa/Tunis
                                                            </option>
                                                            <option value="Atlantic/Canary">
                                                                (GMT+01:00) Atlantic/Canary
                                                            </option>
                                                            <option value="Atlantic/Faroe">
                                                                (GMT+01:00) Atlantic/Faroe
                                                            </option>
                                                            <option value="Atlantic/Madeira">
                                                                (GMT+01:00) Atlantic/Madeira
                                                            </option>
                                                            <option value="Europe/Dublin">
                                                                (GMT+01:00) Europe/Dublin
                                                            </option>
                                                            <option value="Europe/Guernsey">
                                                                (GMT+01:00) Europe/Guernsey
                                                            </option>
                                                            <option value="Europe/Isle_of_Man">
                                                                (GMT+01:00) Europe/Isle_of_Man
                                                            </option>
                                                            <option value="Europe/Jersey">
                                                                (GMT+01:00) Europe/Jersey
                                                            </option>
                                                            <option value="Europe/Lisbon">
                                                                (GMT+01:00) Europe/Lisbon
                                                            </option>
                                                            <option value="Europe/London">
                                                                (GMT+01:00) Europe/London
                                                            </option>
                                                            <option value="Africa/Blantyre">
                                                                (GMT+02:00) Africa/Blantyre
                                                            </option>
                                                            <option value="Africa/Bujumbura">
                                                                (GMT+02:00) Africa/Bujumbura
                                                            </option>
                                                            <option value="Africa/Cairo">
                                                                (GMT+02:00) Africa/Cairo
                                                            </option>
                                                            <option value="Africa/Ceuta">
                                                                (GMT+02:00) Africa/Ceuta
                                                            </option>
                                                            <option value="Africa/Gaborone">
                                                                (GMT+02:00) Africa/Gaborone
                                                            </option>
                                                            <option value="Africa/Harare">
                                                                (GMT+02:00) Africa/Harare
                                                            </option>
                                                            <option value="Africa/Johannesburg">
                                                                (GMT+02:00) Africa/Johannesburg
                                                            </option>
                                                            <option value="Africa/Juba">
                                                                (GMT+02:00) Africa/Juba
                                                            </option>
                                                            <option value="Africa/Khartoum">
                                                                (GMT+02:00) Africa/Khartoum
                                                            </option>
                                                            <option value="Africa/Kigali">
                                                                (GMT+02:00) Africa/Kigali
                                                            </option>
                                                            <option value="Africa/Lubumbashi">
                                                                (GMT+02:00) Africa/Lubumbashi
                                                            </option>
                                                            <option value="Africa/Lusaka">
                                                                (GMT+02:00) Africa/Lusaka
                                                            </option>
                                                            <option value="Africa/Maputo">
                                                                (GMT+02:00) Africa/Maputo
                                                            </option>
                                                            <option value="Africa/Maseru">
                                                                (GMT+02:00) Africa/Maseru
                                                            </option>
                                                            <option value="Africa/Mbabane">
                                                                (GMT+02:00) Africa/Mbabane
                                                            </option>
                                                            <option value="Africa/Tripoli">
                                                                (GMT+02:00) Africa/Tripoli
                                                            </option>
                                                            <option value="Africa/Windhoek">
                                                                (GMT+02:00) Africa/Windhoek
                                                            </option>
                                                            <option value="Antarctica/Troll">
                                                                (GMT+02:00) Antarctica/Troll
                                                            </option>
                                                            <option value="Arctic/Longyearbyen">
                                                                (GMT+02:00) Arctic/Longyearbyen
                                                            </option>
                                                            <option value="Europe/Amsterdam">
                                                                (GMT+02:00) Europe/Amsterdam
                                                            </option>
                                                            <option value="Europe/Andorra">
                                                                (GMT+02:00) Europe/Andorra
                                                            </option>
                                                            <option value="Europe/Belgrade">
                                                                (GMT+02:00) Europe/Belgrade
                                                            </option>
                                                            <option value="Europe/Berlin">
                                                                (GMT+02:00) Europe/Berlin
                                                            </option>
                                                            <option value="Europe/Bratislava">
                                                                (GMT+02:00) Europe/Bratislava
                                                            </option>
                                                            <option value="Europe/Brussels">
                                                                (GMT+02:00) Europe/Brussels
                                                            </option>
                                                            <option value="Europe/Budapest">
                                                                (GMT+02:00) Europe/Budapest
                                                            </option>
                                                            <option value="Europe/Busingen">
                                                                (GMT+02:00) Europe/Busingen
                                                            </option>
                                                            <option value="Europe/Copenhagen">
                                                                (GMT+02:00) Europe/Copenhagen
                                                            </option>
                                                            <option value="Europe/Gibraltar">
                                                                (GMT+02:00) Europe/Gibraltar
                                                            </option>
                                                            <option value="Europe/Kaliningrad">
                                                                (GMT+02:00) Europe/Kaliningrad
                                                            </option>
                                                            <option value="Europe/Ljubljana">
                                                                (GMT+02:00) Europe/Ljubljana
                                                            </option>
                                                            <option value="Europe/Luxembourg">
                                                                (GMT+02:00) Europe/Luxembourg
                                                            </option>
                                                            <option value="Europe/Madrid">
                                                                (GMT+02:00) Europe/Madrid
                                                            </option>
                                                            <option value="Europe/Malta">
                                                                (GMT+02:00) Europe/Malta
                                                            </option>
                                                            <option value="Europe/Monaco">
                                                                (GMT+02:00) Europe/Monaco
                                                            </option>
                                                            <option value="Europe/Oslo">
                                                                (GMT+02:00) Europe/Oslo
                                                            </option>
                                                            <option value="Europe/Paris">
                                                                (GMT+02:00) Europe/Paris
                                                            </option>
                                                            <option value="Europe/Podgorica">
                                                                (GMT+02:00) Europe/Podgorica
                                                            </option>
                                                            <option value="Europe/Prague">
                                                                (GMT+02:00) Europe/Prague
                                                            </option>
                                                            <option value="Europe/Rome">
                                                                (GMT+02:00) Europe/Rome
                                                            </option>
                                                            <option value="Europe/San_Marino">
                                                                (GMT+02:00) Europe/San_Marino
                                                            </option>
                                                            <option value="Europe/Sarajevo">
                                                                (GMT+02:00) Europe/Sarajevo
                                                            </option>
                                                            <option value="Europe/Skopje">
                                                                (GMT+02:00) Europe/Skopje
                                                            </option>
                                                            <option value="Europe/Stockholm">
                                                                (GMT+02:00) Europe/Stockholm
                                                            </option>
                                                            <option value="Europe/Tirane">
                                                                (GMT+02:00) Europe/Tirane
                                                            </option>
                                                            <option value="Europe/Vaduz">
                                                                (GMT+02:00) Europe/Vaduz
                                                            </option>
                                                            <option value="Europe/Vatican">
                                                                (GMT+02:00) Europe/Vatican
                                                            </option>
                                                            <option value="Europe/Vienna">
                                                                (GMT+02:00) Europe/Vienna
                                                            </option>
                                                            <option value="Europe/Warsaw">
                                                                (GMT+02:00) Europe/Warsaw
                                                            </option>
                                                            <option value="Europe/Zagreb">
                                                                (GMT+02:00) Europe/Zagreb
                                                            </option>
                                                            <option value="Europe/Zurich">
                                                                (GMT+02:00) Europe/Zurich
                                                            </option>
                                                            <option value="Africa/Addis_Ababa">
                                                                (GMT+03:00) Africa/Addis_Ababa
                                                            </option>
                                                            <option value="Africa/Asmara">
                                                                (GMT+03:00) Africa/Asmara
                                                            </option>
                                                            <option value="Africa/Dar_es_Salaam">
                                                                (GMT+03:00) Africa/Dar_es_Salaam
                                                            </option>
                                                            <option value="Africa/Djibouti">
                                                                (GMT+03:00) Africa/Djibouti
                                                            </option>
                                                            <option value="Africa/Kampala">
                                                                (GMT+03:00) Africa/Kampala
                                                            </option>
                                                            <option value="Africa/Mogadishu">
                                                                (GMT+03:00) Africa/Mogadishu
                                                            </option>
                                                            <option value="Africa/Nairobi">
                                                                (GMT+03:00) Africa/Nairobi
                                                            </option>
                                                            <option value="Antarctica/Syowa">
                                                                (GMT+03:00) Antarctica/Syowa
                                                            </option>
                                                            <option value="Asia/Aden">
                                                                (GMT+03:00) Asia/Aden
                                                            </option>
                                                            <option value="Asia/Amman">
                                                                (GMT+03:00) Asia/Amman
                                                            </option>
                                                            <option value="Asia/Baghdad">
                                                                (GMT+03:00) Asia/Baghdad
                                                            </option>
                                                            <option value="Asia/Bahrain">
                                                                (GMT+03:00) Asia/Bahrain
                                                            </option>
                                                            <option value="Asia/Beirut">
                                                                (GMT+03:00) Asia/Beirut
                                                            </option>
                                                            <option value="Asia/Damascus">
                                                                (GMT+03:00) Asia/Damascus
                                                            </option>
                                                            <option value="Asia/Famagusta">
                                                                (GMT+03:00) Asia/Famagusta
                                                            </option>
                                                            <option value="Asia/Gaza">
                                                                (GMT+03:00) Asia/Gaza
                                                            </option>
                                                            <option value="Asia/Hebron">
                                                                (GMT+03:00) Asia/Hebron
                                                            </option>
                                                            <option value="Asia/Jerusalem">
                                                                (GMT+03:00) Asia/Jerusalem
                                                            </option>
                                                            <option value="Asia/Kuwait">
                                                                (GMT+03:00) Asia/Kuwait
                                                            </option>
                                                            <option value="Asia/Nicosia">
                                                                (GMT+03:00) Asia/Nicosia
                                                            </option>
                                                            <option value="Asia/Qatar">
                                                                (GMT+03:00) Asia/Qatar
                                                            </option>
                                                            <option value="Asia/Riyadh">
                                                                (GMT+03:00) Asia/Riyadh
                                                            </option>
                                                            <option value="Europe/Athens">
                                                                (GMT+03:00) Europe/Athens
                                                            </option>
                                                            <option value="Europe/Bucharest">
                                                                (GMT+03:00) Europe/Bucharest
                                                            </option>
                                                            <option value="Europe/Chisinau">
                                                                (GMT+03:00) Europe/Chisinau
                                                            </option>
                                                            <option value="Europe/Helsinki">
                                                                (GMT+03:00) Europe/Helsinki
                                                            </option>
                                                            <option value="Europe/Istanbul">
                                                                (GMT+03:00) Europe/Istanbul
                                                            </option>
                                                            <option value="Europe/Kirov">
                                                                (GMT+03:00) Europe/Kirov
                                                            </option>
                                                            <option value="Europe/Kyiv">
                                                                (GMT+03:00) Europe/Kyiv
                                                            </option>
                                                            <option value="Europe/Mariehamn">
                                                                (GMT+03:00) Europe/Mariehamn
                                                            </option>
                                                            <option value="Europe/Minsk">
                                                                (GMT+03:00) Europe/Minsk
                                                            </option>
                                                            <option value="Europe/Moscow">
                                                                (GMT+03:00) Europe/Moscow
                                                            </option>
                                                            <option value="Europe/Riga">
                                                                (GMT+03:00) Europe/Riga
                                                            </option>
                                                            <option value="Europe/Simferopol">
                                                                (GMT+03:00) Europe/Simferopol
                                                            </option>
                                                            <option value="Europe/Sofia">
                                                                (GMT+03:00) Europe/Sofia
                                                            </option>
                                                            <option value="Europe/Tallinn">
                                                                (GMT+03:00) Europe/Tallinn
                                                            </option>
                                                            <option value="Europe/Vilnius">
                                                                (GMT+03:00) Europe/Vilnius
                                                            </option>
                                                            <option value="Europe/Volgograd">
                                                                (GMT+03:00) Europe/Volgograd
                                                            </option>
                                                            <option value="Indian/Antananarivo">
                                                                (GMT+03:00) Indian/Antananarivo
                                                            </option>
                                                            <option value="Indian/Comoro">
                                                                (GMT+03:00) Indian/Comoro
                                                            </option>
                                                            <option value="Indian/Mayotte">
                                                                (GMT+03:00) Indian/Mayotte
                                                            </option>
                                                            <option value="Asia/Tehran">
                                                                (GMT+03:30) Asia/Tehran
                                                            </option>
                                                            <option value="Asia/Baku">
                                                                (GMT+04:00) Asia/Baku
                                                            </option>
                                                            <option value="Asia/Dubai">
                                                                (GMT+04:00) Asia/Dubai
                                                            </option>
                                                            <option value="Asia/Muscat">
                                                                (GMT+04:00) Asia/Muscat
                                                            </option>
                                                            <option value="Asia/Tbilisi">
                                                                (GMT+04:00) Asia/Tbilisi
                                                            </option>
                                                            <option value="Asia/Yerevan">
                                                                (GMT+04:00) Asia/Yerevan
                                                            </option>
                                                            <option value="Europe/Astrakhan">
                                                                (GMT+04:00) Europe/Astrakhan
                                                            </option>
                                                            <option value="Europe/Samara">
                                                                (GMT+04:00) Europe/Samara
                                                            </option>
                                                            <option value="Europe/Saratov">
                                                                (GMT+04:00) Europe/Saratov
                                                            </option>
                                                            <option value="Europe/Ulyanovsk">
                                                                (GMT+04:00) Europe/Ulyanovsk
                                                            </option>
                                                            <option value="Indian/Mahe">
                                                                (GMT+04:00) Indian/Mahe
                                                            </option>
                                                            <option value="Indian/Mauritius">
                                                                (GMT+04:00) Indian/Mauritius
                                                            </option>
                                                            <option value="Indian/Reunion">
                                                                (GMT+04:00) Indian/Reunion
                                                            </option>
                                                            <option value="Asia/Kabul">
                                                                (GMT+04:30) Asia/Kabul
                                                            </option>
                                                            <option value="Antarctica/Mawson">
                                                                (GMT+05:00) Antarctica/Mawson
                                                            </option>
                                                            <option value="Asia/Aqtau">
                                                                (GMT+05:00) Asia/Aqtau
                                                            </option>
                                                            <option value="Asia/Aqtobe">
                                                                (GMT+05:00) Asia/Aqtobe
                                                            </option>
                                                            <option value="Asia/Ashgabat">
                                                                (GMT+05:00) Asia/Ashgabat
                                                            </option>
                                                            <option value="Asia/Atyrau">
                                                                (GMT+05:00) Asia/Atyrau
                                                            </option>
                                                            <option value="Asia/Dushanbe">
                                                                (GMT+05:00) Asia/Dushanbe
                                                            </option>
                                                            <option value="Asia/Karachi">
                                                                (GMT+05:00) Asia/Karachi
                                                            </option>
                                                            <option value="Asia/Oral">
                                                                (GMT+05:00) Asia/Oral
                                                            </option>
                                                            <option value="Asia/Qyzylorda">
                                                                (GMT+05:00) Asia/Qyzylorda
                                                            </option>
                                                            <option value="Asia/Samarkand">
                                                                (GMT+05:00) Asia/Samarkand
                                                            </option>
                                                            <option value="Asia/Tashkent">
                                                                (GMT+05:00) Asia/Tashkent
                                                            </option>
                                                            <option value="Asia/Yekaterinburg">
                                                                (GMT+05:00) Asia/Yekaterinburg
                                                            </option>
                                                            <option value="Indian/Kerguelen">
                                                                (GMT+05:00) Indian/Kerguelen
                                                            </option>
                                                            <option value="Indian/Maldives">
                                                                (GMT+05:00) Indian/Maldives
                                                            </option>
                                                            <option value="Asia/Colombo">
                                                                (GMT+05:30) Asia/Colombo
                                                            </option>
                                                            <option value="Asia/Kolkata" selected=""
                                                                data-select2-id="2">
                                                                (GMT+05:30) Asia/Kolkata
                                                            </option>
                                                            <option value="Asia/Kathmandu">
                                                                (GMT+05:45) Asia/Kathmandu
                                                            </option>
                                                            <option value="Antarctica/Vostok">
                                                                (GMT+06:00) Antarctica/Vostok
                                                            </option>
                                                            <option value="Asia/Almaty">
                                                                (GMT+06:00) Asia/Almaty
                                                            </option>
                                                            <option value="Asia/Bishkek">
                                                                (GMT+06:00) Asia/Bishkek
                                                            </option>
                                                            <option value="Asia/Dhaka">
                                                                (GMT+06:00) Asia/Dhaka
                                                            </option>
                                                            <option value="Asia/Omsk">
                                                                (GMT+06:00) Asia/Omsk
                                                            </option>
                                                            <option value="Asia/Qostanay">
                                                                (GMT+06:00) Asia/Qostanay
                                                            </option>
                                                            <option value="Asia/Thimphu">
                                                                (GMT+06:00) Asia/Thimphu
                                                            </option>
                                                            <option value="Asia/Urumqi">
                                                                (GMT+06:00) Asia/Urumqi
                                                            </option>
                                                            <option value="Indian/Chagos">
                                                                (GMT+06:00) Indian/Chagos
                                                            </option>
                                                            <option value="Asia/Yangon">
                                                                (GMT+06:30) Asia/Yangon
                                                            </option>
                                                            <option value="Indian/Cocos">
                                                                (GMT+06:30) Indian/Cocos
                                                            </option>
                                                            <option value="Antarctica/Davis">
                                                                (GMT+07:00) Antarctica/Davis
                                                            </option>
                                                            <option value="Asia/Bangkok">
                                                                (GMT+07:00) Asia/Bangkok
                                                            </option>
                                                            <option value="Asia/Barnaul">
                                                                (GMT+07:00) Asia/Barnaul
                                                            </option>
                                                            <option value="Asia/Ho_Chi_Minh">
                                                                (GMT+07:00) Asia/Ho_Chi_Minh
                                                            </option>
                                                            <option value="Asia/Hovd">
                                                                (GMT+07:00) Asia/Hovd
                                                            </option>
                                                            <option value="Asia/Jakarta">
                                                                (GMT+07:00) Asia/Jakarta
                                                            </option>
                                                            <option value="Asia/Krasnoyarsk">
                                                                (GMT+07:00) Asia/Krasnoyarsk
                                                            </option>
                                                            <option value="Asia/Novokuznetsk">
                                                                (GMT+07:00) Asia/Novokuznetsk
                                                            </option>
                                                            <option value="Asia/Novosibirsk">
                                                                (GMT+07:00) Asia/Novosibirsk
                                                            </option>
                                                            <option value="Asia/Phnom_Penh">
                                                                (GMT+07:00) Asia/Phnom_Penh
                                                            </option>
                                                            <option value="Asia/Pontianak">
                                                                (GMT+07:00) Asia/Pontianak
                                                            </option>
                                                            <option value="Asia/Tomsk">
                                                                (GMT+07:00) Asia/Tomsk
                                                            </option>
                                                            <option value="Asia/Vientiane">
                                                                (GMT+07:00) Asia/Vientiane
                                                            </option>
                                                            <option value="Indian/Christmas">
                                                                (GMT+07:00) Indian/Christmas
                                                            </option>
                                                            <option value="Asia/Brunei">
                                                                (GMT+08:00) Asia/Brunei
                                                            </option>
                                                            <option value="Asia/Choibalsan">
                                                                (GMT+08:00) Asia/Choibalsan
                                                            </option>
                                                            <option value="Asia/Hong_Kong">
                                                                (GMT+08:00) Asia/Hong_Kong
                                                            </option>
                                                            <option value="Asia/Irkutsk">
                                                                (GMT+08:00) Asia/Irkutsk
                                                            </option>
                                                            <option value="Asia/Kuala_Lumpur">
                                                                (GMT+08:00) Asia/Kuala_Lumpur
                                                            </option>
                                                            <option value="Asia/Kuching">
                                                                (GMT+08:00) Asia/Kuching
                                                            </option>
                                                            <option value="Asia/Macau">
                                                                (GMT+08:00) Asia/Macau
                                                            </option>
                                                            <option value="Asia/Makassar">
                                                                (GMT+08:00) Asia/Makassar
                                                            </option>
                                                            <option value="Asia/Manila">
                                                                (GMT+08:00) Asia/Manila
                                                            </option>
                                                            <option value="Asia/Shanghai">
                                                                (GMT+08:00) Asia/Shanghai
                                                            </option>
                                                            <option value="Asia/Singapore">
                                                                (GMT+08:00) Asia/Singapore
                                                            </option>
                                                            <option value="Asia/Taipei">
                                                                (GMT+08:00) Asia/Taipei
                                                            </option>
                                                            <option value="Asia/Ulaanbaatar">
                                                                (GMT+08:00) Asia/Ulaanbaatar
                                                            </option>
                                                            <option value="Australia/Perth">
                                                                (GMT+08:00) Australia/Perth
                                                            </option>
                                                            <option value="Australia/Eucla">
                                                                (GMT+08:45) Australia/Eucla
                                                            </option>
                                                            <option value="Asia/Chita">
                                                                (GMT+09:00) Asia/Chita
                                                            </option>
                                                            <option value="Asia/Dili">
                                                                (GMT+09:00) Asia/Dili
                                                            </option>
                                                            <option value="Asia/Jayapura">
                                                                (GMT+09:00) Asia/Jayapura
                                                            </option>
                                                            <option value="Asia/Khandyga">
                                                                (GMT+09:00) Asia/Khandyga
                                                            </option>
                                                            <option value="Asia/Pyongyang">
                                                                (GMT+09:00) Asia/Pyongyang
                                                            </option>
                                                            <option value="Asia/Seoul">
                                                                (GMT+09:00) Asia/Seoul
                                                            </option>
                                                            <option value="Asia/Tokyo">
                                                                (GMT+09:00) Asia/Tokyo
                                                            </option>
                                                            <option value="Asia/Yakutsk">
                                                                (GMT+09:00) Asia/Yakutsk
                                                            </option>
                                                            <option value="Pacific/Palau">
                                                                (GMT+09:00) Pacific/Palau
                                                            </option>
                                                            <option value="Australia/Darwin">
                                                                (GMT+09:30) Australia/Darwin
                                                            </option>
                                                            <option value="Antarctica/DumontDUrville">
                                                                (GMT+10:00) Antarctica/DumontDUrville
                                                            </option>
                                                            <option value="Asia/Ust-Nera">
                                                                (GMT+10:00) Asia/Ust-Nera
                                                            </option>
                                                            <option value="Asia/Vladivostok">
                                                                (GMT+10:00) Asia/Vladivostok
                                                            </option>
                                                            <option value="Australia/Brisbane">
                                                                (GMT+10:00) Australia/Brisbane
                                                            </option>
                                                            <option value="Australia/Lindeman">
                                                                (GMT+10:00) Australia/Lindeman
                                                            </option>
                                                            <option value="Pacific/Chuuk">
                                                                (GMT+10:00) Pacific/Chuuk
                                                            </option>
                                                            <option value="Pacific/Guam">
                                                                (GMT+10:00) Pacific/Guam
                                                            </option>
                                                            <option value="Pacific/Port_Moresby">
                                                                (GMT+10:00) Pacific/Port_Moresby
                                                            </option>
                                                            <option value="Pacific/Saipan">
                                                                (GMT+10:00) Pacific/Saipan
                                                            </option>
                                                            <option value="Australia/Adelaide">
                                                                (GMT+10:30) Australia/Adelaide
                                                            </option>
                                                            <option value="Australia/Broken_Hill">
                                                                (GMT+10:30) Australia/Broken_Hill
                                                            </option>
                                                            <option value="Antarctica/Casey">
                                                                (GMT+11:00) Antarctica/Casey
                                                            </option>
                                                            <option value="Antarctica/Macquarie">
                                                                (GMT+11:00) Antarctica/Macquarie
                                                            </option>
                                                            <option value="Asia/Magadan">
                                                                (GMT+11:00) Asia/Magadan
                                                            </option>
                                                            <option value="Asia/Sakhalin">
                                                                (GMT+11:00) Asia/Sakhalin
                                                            </option>
                                                            <option value="Asia/Srednekolymsk">
                                                                (GMT+11:00) Asia/Srednekolymsk
                                                            </option>
                                                            <option value="Australia/Hobart">
                                                                (GMT+11:00) Australia/Hobart
                                                            </option>
                                                            <option value="Australia/Lord_Howe">
                                                                (GMT+11:00) Australia/Lord_Howe
                                                            </option>
                                                            <option value="Australia/Melbourne">
                                                                (GMT+11:00) Australia/Melbourne
                                                            </option>
                                                            <option value="Australia/Sydney">
                                                                (GMT+11:00) Australia/Sydney
                                                            </option>
                                                            <option value="Pacific/Bougainville">
                                                                (GMT+11:00) Pacific/Bougainville
                                                            </option>
                                                            <option value="Pacific/Efate">
                                                                (GMT+11:00) Pacific/Efate
                                                            </option>
                                                            <option value="Pacific/Guadalcanal">
                                                                (GMT+11:00) Pacific/Guadalcanal
                                                            </option>
                                                            <option value="Pacific/Kosrae">
                                                                (GMT+11:00) Pacific/Kosrae
                                                            </option>
                                                            <option value="Pacific/Noumea">
                                                                (GMT+11:00) Pacific/Noumea
                                                            </option>
                                                            <option value="Pacific/Pohnpei">
                                                                (GMT+11:00) Pacific/Pohnpei
                                                            </option>
                                                            <option value="Asia/Anadyr">
                                                                (GMT+12:00) Asia/Anadyr
                                                            </option>
                                                            <option value="Asia/Kamchatka">
                                                                (GMT+12:00) Asia/Kamchatka
                                                            </option>
                                                            <option value="Pacific/Fiji">
                                                                (GMT+12:00) Pacific/Fiji
                                                            </option>
                                                            <option value="Pacific/Funafuti">
                                                                (GMT+12:00) Pacific/Funafuti
                                                            </option>
                                                            <option value="Pacific/Kwajalein">
                                                                (GMT+12:00) Pacific/Kwajalein
                                                            </option>
                                                            <option value="Pacific/Majuro">
                                                                (GMT+12:00) Pacific/Majuro
                                                            </option>
                                                            <option value="Pacific/Nauru">
                                                                (GMT+12:00) Pacific/Nauru
                                                            </option>
                                                            <option value="Pacific/Norfolk">
                                                                (GMT+12:00) Pacific/Norfolk
                                                            </option>
                                                            <option value="Pacific/Tarawa">
                                                                (GMT+12:00) Pacific/Tarawa
                                                            </option>
                                                            <option value="Pacific/Wake">
                                                                (GMT+12:00) Pacific/Wake
                                                            </option>
                                                            <option value="Pacific/Wallis">
                                                                (GMT+12:00) Pacific/Wallis
                                                            </option>
                                                            <option value="Antarctica/McMurdo">
                                                                (GMT+13:00) Antarctica/McMurdo
                                                            </option>
                                                            <option value="Pacific/Apia">
                                                                (GMT+13:00) Pacific/Apia
                                                            </option>
                                                            <option value="Pacific/Auckland">
                                                                (GMT+13:00) Pacific/Auckland
                                                            </option>
                                                            <option value="Pacific/Fakaofo">
                                                                (GMT+13:00) Pacific/Fakaofo
                                                            </option>
                                                            <option value="Pacific/Kanton">
                                                                (GMT+13:00) Pacific/Kanton
                                                            </option>
                                                            <option value="Pacific/Tongatapu">
                                                                (GMT+13:00) Pacific/Tongatapu
                                                            </option>
                                                            <option value="Pacific/Chatham">
                                                                (GMT+13:45) Pacific/Chatham
                                                            </option>
                                                            <option value="Pacific/Kiritimati">
                                                                (GMT+14:00) Pacific/Kiritimati
                                                            </option>
                                                        </select><span
                                                            class="select2 select2-container select2-container--default"
                                                            dir="ltr" data-select2-id="1" style="width: 100%;"><span
                                                                class="selection"><span
                                                                    class="select2-selection select2-selection--single"
                                                                    role="combobox" aria-haspopup="true"
                                                                    aria-expanded="false" tabindex="0"
                                                                    aria-disabled="false"
                                                                    aria-labelledby="select2-timezone-container"><span
                                                                        class="select2-selection__rendered"
                                                                        id="select2-timezone-container" role="textbox"
                                                                        aria-readonly="true" title="
                                                                (GMT+05:30) Asia/Kolkata
                                                            ">
                                                                        (GMT+05:30) Asia/Kolkata
                                                                    </span><span class="select2-selection__arrow"
                                                                        role="presentation"><b
                                                                            role="presentation"></b></span></span></span><span
                                                                class="dropdown-wrapper"
                                                                aria-hidden="true"></span></span></div>
                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required" for="locale">Language</label>
                                                    <div class="position-relative">
                                                        <select class="select2 w-100 select2-hidden-accessible"
                                                            name="locale" id="locale" data-select2-id="locale"
                                                            tabindex="-1" aria-hidden="true">
                                                            <option value="en" data-select2-id="4"> English</option>
                                                            <option value="fr"> French</option>
                                                            <option value="zh"> Chinese</option>
                                                            <option value="es"> Spanish</option>
                                                            <option value="pt"> Portuguese</option>
                                                            <option value="ar"> Arabic</option>
                                                            <option value="it"> Italian</option>
                                                            <option value="ko"> Korean</option>
                                                            <option value="sl"> Slovenian</option>
                                                        </select>
                                                        <span
                                                            class="select2 select2-container select2-container--default"
                                                            dir="ltr" data-select2-id="3" style="width: 100%;"><span
                                                                class="selection"><span
                                                                    class="select2-selection select2-selection--single"
                                                                    role="combobox" aria-haspopup="true"
                                                                    aria-expanded="false" tabindex="0"
                                                                    aria-disabled="false"
                                                                    aria-labelledby="select2-locale-container"><span
                                                                        class="select2-selection__rendered"
                                                                        id="select2-locale-container" role="textbox"
                                                                        aria-readonly="true" title=" English">
                                                                        English</span><span
                                                                        class="select2-selection__arrow"
                                                                        role="presentation"><b
                                                                            role="presentation"></b></span></span></span><span
                                                                class="dropdown-wrapper"
                                                                aria-hidden="true"></span></span>
                                                    </div>
                                                </div>
                                                <div class="mb-4">


                                                </div>
                                                <p class="mt-3 mb-5 back-btn">
                                                    <a href="{{route('login')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-chevron-left">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg> Back to Login
                                                    </a>
                                                </p>
                                            </div>

                                            <div class="d-flex justify-content-between mt-2">
                                                <button class="btn btn-outline-secondary btn-prev waves-effect"
                                                    disabled="" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button
                                                    class="btn btn-primary btn-next waves-effect waves-float waves-light"
                                                    type="button">
                                                    <span class="align-middle d-sm-inline-block d-none">Next</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-right align-middle ms-sm-25 ms-0">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="personal-info" class="content get_form_data" role="tabpanel"
                                            aria-labelledby="personal-info-trigger">
                                            <div class="content-header mb-4">
                                                <h2 class="fw-bolder mb-4">Personal Information</h2>
                                                <span>Fill the below form to create a new account</span>
                                            </div>
                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required" for="first_name">First
                                                        name</label>
                                                    <input id="first_name" type="text" class="form-control "
                                                        name="first_name" placeholder="First name" value="" required=""
                                                        autocomplete="first_name">

                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label" for="last_name">Last name</label>
                                                    <input id="last_name" type="text" class="form-control "
                                                        name="last_name" placeholder="Last name" value=""
                                                        autocomplete="last_name">

                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label required" for="phone">Phone</label>
                                                    <input type="number" id="phone" class="form-control " name="phone"
                                                        required="" placeholder="Phone" value="">

                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label" for="postcode">Postcode</label>
                                                    <input type="text" id="postcode" class="form-control "
                                                        name="postcode" placeholder="Postal code" value="">
                                                </div>

                                                <div class="col-12 mb-4">
                                                    <label class="form-label required" for="address">Address</label>
                                                    <input type="text" id="address" class="form-control " name="address"
                                                        required="" placeholder="Address" value="">
                                                </div>

                                                <div class="col-12 mb-4">
                                                    <label class="form-label" for="company">Company</label>
                                                    <input type="text" id="company" class="form-control " name="company"
                                                        placeholder="Company" value="">
                                                </div>

                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required" for="city">City</label>
                                                    <input type="text" id="city" class="form-control " name="city"
                                                        required="" placeholder="City" value="">
                                                </div>
                                                <div class="mb-4 col-md-6">
                                                    <label class="form-label required" for="country">Country</label>
                                                    <div class="position-relative">
                                                        <select
                                                            class="select2 w-100 select2-hidden-accessible"
                                                            name="country" id="country" required=""
                                                            data-select2-id="country" tabindex="-1" aria-hidden="true">
                                                            <option value="Afghanistan"> Afghanistan</option>
                                                            <option value="Albania"> Albania</option>
                                                            <option value="Algeria"> Algeria</option>
                                                            <option value="American Samoa"> American Samoa</option>
                                                            <option value="Andorra"> Andorra</option>
                                                            <option value="Angola"> Angola</option>
                                                            <option value="Anguilla"> Anguilla</option>
                                                            <option value="Antigua"> Antigua</option>
                                                            <option value="Argentina"> Argentina</option>
                                                            <option value="Armenia"> Armenia</option>
                                                            <option value="Aruba"> Aruba</option>
                                                            <option value="Australia"> Australia</option>
                                                            <option value="Austria"> Austria</option>
                                                            <option value="Azerbaijan"> Azerbaijan</option>
                                                            <option value="Bahrain"> Bahrain</option>
                                                            <option value="Bangladesh"> Bangladesh</option>
                                                            <option value="Barbados"> Barbados</option>
                                                            <option value="Belarus"> Belarus</option>
                                                            <option value="Belgium"> Belgium</option>
                                                            <option value="Belize"> Belize</option>
                                                            <option value="Benin"> Benin</option>
                                                            <option value="Bermuda"> Bermuda</option>
                                                            <option value="Bhutan"> Bhutan</option>
                                                            <option value="Bolivia"> Bolivia</option>
                                                            <option value="Bosnia and Herzegovina"> Bosnia and
                                                                Herzegovina</option>
                                                            <option value="Botswana"> Botswana</option>
                                                            <option value="Brazil"> Brazil</option>
                                                            <option value="British Indian Ocean Territory"> British
                                                                Indian Ocean Territory</option>
                                                            <option value="British Virgin Islands"> British Virgin
                                                                Islands</option>
                                                            <option value="Brunei"> Brunei</option>
                                                            <option value="Bulgaria"> Bulgaria</option>
                                                            <option value="Burkina Faso"> Burkina Faso</option>
                                                            <option value="Burma Myanmar"> Burma Myanmar</option>
                                                            <option value="Burundi"> Burundi</option>
                                                            <option value="Cambodia"> Cambodia</option>
                                                            <option value="Cameroon"> Cameroon</option>
                                                            <option value="Canada"> Canada</option>
                                                            <option value="Cape Verde"> Cape Verde</option>
                                                            <option value="Cayman Islands"> Cayman Islands</option>
                                                            <option value="Central African Republic"> Central African
                                                                Republic</option>
                                                            <option value="Chad"> Chad</option>
                                                            <option value="Chile"> Chile</option>
                                                            <option value="China"> China</option>
                                                            <option value="Colombia"> Colombia</option>
                                                            <option value="Comoros"> Comoros</option>
                                                            <option value="Cook Islands"> Cook Islands</option>
                                                            <option value="Costa Rica"> Costa Rica</option>
                                                            <option value="Côte d'Ivoire"> Côte d'Ivoire</option>
                                                            <option value="Croatia"> Croatia</option>
                                                            <option value="Cuba"> Cuba</option>
                                                            <option value="Cyprus"> Cyprus</option>
                                                            <option value="Czech Republic"> Czech Republic</option>
                                                            <option value="Democratic Republic of Congo"> Democratic
                                                                Republic of Congo</option>
                                                            <option value="Denmark"> Denmark</option>
                                                            <option value="Djibouti"> Djibouti</option>
                                                            <option value="Dominica"> Dominica</option>
                                                            <option value="Dominican Republic"> Dominican Republic
                                                            </option>
                                                            <option value="Ecuador"> Ecuador</option>
                                                            <option value="Egypt"> Egypt</option>
                                                            <option value="El Salvador"> El Salvador</option>
                                                            <option value="Equatorial Guinea"> Equatorial Guinea
                                                            </option>
                                                            <option value="Eritrea"> Eritrea</option>
                                                            <option value="Estonia"> Estonia</option>
                                                            <option value="Ethiopia"> Ethiopia</option>
                                                            <option value="Falkland Islands"> Falkland Islands</option>
                                                            <option value="Faroe Islands"> Faroe Islands</option>
                                                            <option value="Federated States of Micronesia"> Federated
                                                                States of Micronesia</option>
                                                            <option value="Fiji"> Fiji</option>
                                                            <option value="Finland"> Finland</option>
                                                            <option value="France"> France</option>
                                                            <option value="French Guiana"> French Guiana</option>
                                                            <option value="French Polynesia"> French Polynesia</option>
                                                            <option value="Gabon"> Gabon</option>
                                                            <option value="Georgia"> Georgia</option>
                                                            <option value="Germany"> Germany</option>
                                                            <option value="Ghana"> Ghana</option>
                                                            <option value="Gibraltar"> Gibraltar</option>
                                                            <option value="Greece"> Greece</option>
                                                            <option value="Greenland"> Greenland</option>
                                                            <option value="Grenada"> Grenada</option>
                                                            <option value="Guadeloupe"> Guadeloupe</option>
                                                            <option value="Guam"> Guam</option>
                                                            <option value="Guatemala"> Guatemala</option>
                                                            <option value="Guinea"> Guinea</option>
                                                            <option value="Guinea-Bissau"> Guinea-Bissau</option>
                                                            <option value="Guyana"> Guyana</option>
                                                            <option value="Haiti"> Haiti</option>
                                                            <option value="Honduras"> Honduras</option>
                                                            <option value="Hong Kong"> Hong Kong</option>
                                                            <option value="Hungary"> Hungary</option>
                                                            <option value="Iceland"> Iceland</option>
                                                            <option value="India" selected="" data-select2-id="6"> India
                                                            </option>
                                                            <option value="Indonesia"> Indonesia</option>
                                                            <option value="Iran"> Iran</option>
                                                            <option value="Iraq"> Iraq</option>
                                                            <option value="Ireland"> Ireland</option>
                                                            <option value="Israel"> Israel</option>
                                                            <option value="Italy"> Italy</option>
                                                            <option value="Jamaica"> Jamaica</option>
                                                            <option value="Japan"> Japan</option>
                                                            <option value="Jordan"> Jordan</option>
                                                            <option value="Kazakhstan"> Kazakhstan</option>
                                                            <option value="Kenya"> Kenya</option>
                                                            <option value="Kiribati"> Kiribati</option>
                                                            <option value="Kosovo"> Kosovo</option>
                                                            <option value="Kuwait"> Kuwait</option>
                                                            <option value="Kyrgyzstan"> Kyrgyzstan</option>
                                                            <option value="Laos"> Laos</option>
                                                            <option value="Latvia"> Latvia</option>
                                                            <option value="Lebanon"> Lebanon</option>
                                                            <option value="Lesotho"> Lesotho</option>
                                                            <option value="Liberia"> Liberia</option>
                                                            <option value="Libya"> Libya</option>
                                                            <option value="Liechtenstein"> Liechtenstein</option>
                                                            <option value="Lithuania"> Lithuania</option>
                                                            <option value="Luxembourg"> Luxembourg</option>
                                                            <option value="Macau"> Macau</option>
                                                            <option value="Macedonia"> Macedonia</option>
                                                            <option value="Madagascar"> Madagascar</option>
                                                            <option value="Malawi"> Malawi</option>
                                                            <option value="Malaysia"> Malaysia</option>
                                                            <option value="Maldives"> Maldives</option>
                                                            <option value="Mali"> Mali</option>
                                                            <option value="Malta"> Malta</option>
                                                            <option value="Marshall Islands"> Marshall Islands</option>
                                                            <option value="Martinique"> Martinique</option>
                                                            <option value="Mauritania"> Mauritania</option>
                                                            <option value="Mauritius"> Mauritius</option>
                                                            <option value="Mayotte"> Mayotte</option>
                                                            <option value="Mexico"> Mexico</option>
                                                            <option value="Moldova"> Moldova</option>
                                                            <option value="Monaco"> Monaco</option>
                                                            <option value="Mongolia"> Mongolia</option>
                                                            <option value="Montenegro"> Montenegro</option>
                                                            <option value="Montserrat"> Montserrat</option>
                                                            <option value="Morocco"> Morocco</option>
                                                            <option value="Mozambique"> Mozambique</option>
                                                            <option value="Namibia"> Namibia</option>
                                                            <option value="Nauru"> Nauru</option>
                                                            <option value="Nepal"> Nepal</option>
                                                            <option value="Netherlands"> Netherlands</option>
                                                            <option value="Netherlands Antilles"> Netherlands Antilles
                                                            </option>
                                                            <option value="New Caledonia"> New Caledonia</option>
                                                            <option value="New Zealand"> New Zealand</option>
                                                            <option value="Nicaragua"> Nicaragua</option>
                                                            <option value="Niger"> Niger</option>
                                                            <option value="Nigeria"> Nigeria</option>
                                                            <option value="Niue"> Niue</option>
                                                            <option value="Norfolk Island"> Norfolk Island</option>
                                                            <option value="North Korea"> North Korea</option>
                                                            <option value="Northern Mariana Islands"> Northern Mariana
                                                                Islands</option>
                                                            <option value="Norway"> Norway</option>
                                                            <option value="Oman"> Oman</option>
                                                            <option value="Pakistan"> Pakistan</option>
                                                            <option value="Palau"> Palau</option>
                                                            <option value="Palestine"> Palestine</option>
                                                            <option value="Panama"> Panama</option>
                                                            <option value="Papua New Guinea"> Papua New Guinea</option>
                                                            <option value="Paraguay"> Paraguay</option>
                                                            <option value="Peru"> Peru</option>
                                                            <option value="Philippines"> Philippines</option>
                                                            <option value="Poland"> Poland</option>
                                                            <option value="Portugal"> Portugal</option>
                                                            <option value="Puerto Rico"> Puerto Rico</option>
                                                            <option value="Qatar"> Qatar</option>
                                                            <option value="Republic of the Congo"> Republic of the Congo
                                                            </option>
                                                            <option value="Réunion"> Réunion</option>
                                                            <option value="Romania"> Romania</option>
                                                            <option value="Russia"> Russia</option>
                                                            <option value="Rwanda"> Rwanda</option>
                                                            <option value="Saint Barthélemy"> Saint Barthélemy</option>
                                                            <option value="Saint Helena"> Saint Helena</option>
                                                            <option value="Saint Kitts and Nevis"> Saint Kitts and Nevis
                                                            </option>
                                                            <option value="Saint Martin"> Saint Martin</option>
                                                            <option value="Saint Pierre and Miquelon"> Saint Pierre and
                                                                Miquelon</option>
                                                            <option value="Saint Vincent and the Grenadines"> Saint
                                                                Vincent and the Grenadines</option>
                                                            <option value="Samoa"> Samoa</option>
                                                            <option value="San Marino"> San Marino</option>
                                                            <option value="São Tomé and Príncipe"> São Tomé and Príncipe
                                                            </option>
                                                            <option value="Saudi Arabia"> Saudi Arabia</option>
                                                            <option value="Senegal"> Senegal</option>
                                                            <option value="Serbia"> Serbia</option>
                                                            <option value="Seychelles"> Seychelles</option>
                                                            <option value="Sierra Leone"> Sierra Leone</option>
                                                            <option value="Singapore"> Singapore</option>
                                                            <option value="Slovakia"> Slovakia</option>
                                                            <option value="Slovenia"> Slovenia</option>
                                                            <option value="Solomon Islands"> Solomon Islands</option>
                                                            <option value="Somalia"> Somalia</option>
                                                            <option value="South Africa"> South Africa</option>
                                                            <option value="South Korea"> South Korea</option>
                                                            <option value="Spain"> Spain</option>
                                                            <option value="Sri Lanka"> Sri Lanka</option>
                                                            <option value="St. Lucia"> St. Lucia</option>
                                                            <option value="Sudan"> Sudan</option>
                                                            <option value="Suriname"> Suriname</option>
                                                            <option value="Swaziland"> Swaziland</option>
                                                            <option value="Sweden"> Sweden</option>
                                                            <option value="Switzerland"> Switzerland</option>
                                                            <option value="Syria"> Syria</option>
                                                            <option value="Taiwan"> Taiwan</option>
                                                            <option value="Tajikistan"> Tajikistan</option>
                                                            <option value="Tanzania"> Tanzania</option>
                                                            <option value="Thailand"> Thailand</option>
                                                            <option value="The Bahamas"> The Bahamas</option>
                                                            <option value="The Gambia"> The Gambia</option>
                                                            <option value="Timor-Leste"> Timor-Leste</option>
                                                            <option value="Togo"> Togo</option>
                                                            <option value="Tokelau"> Tokelau</option>
                                                            <option value="Tonga"> Tonga</option>
                                                            <option value="Trinidad and Tobago"> Trinidad and Tobago
                                                            </option>
                                                            <option value="Tunisia"> Tunisia</option>
                                                            <option value="Turkey"> Turkey</option>
                                                            <option value="Turkmenistan"> Turkmenistan</option>
                                                            <option value="Turks and Caicos Islands"> Turks and Caicos
                                                                Islands</option>
                                                            <option value="Tuvalu"> Tuvalu</option>
                                                            <option value="Uganda"> Uganda</option>
                                                            <option value="Ukraine"> Ukraine</option>
                                                            <option value="United Arab Emirates"> United Arab Emirates
                                                            </option>
                                                            <option value="United Kingdom"> United Kingdom</option>
                                                            <option value="United States"> United States</option>
                                                            <option value="Uruguay"> Uruguay</option>
                                                            <option value="US Virgin Islands"> US Virgin Islands
                                                            </option>
                                                            <option value="Uzbekistan"> Uzbekistan</option>
                                                            <option value="Vanuatu"> Vanuatu</option>
                                                            <option value="Vatican City"> Vatican City</option>
                                                            <option value="Venezuela"> Venezuela</option>
                                                            <option value="Vietnam"> Vietnam</option>
                                                            <option value="Wallis and Futuna"> Wallis and Futuna
                                                            </option>
                                                            <option value="Yemen"> Yemen</option>
                                                            <option value="Zambia"> Zambia</option>
                                                            <option value="Zimbabwe"> Zimbabwe</option>
                                                        </select>
                                                        <span class="select2 select2-container select2-container--default"
                                                            dir="ltr" data-select2-id="5" style="width: 100%;">
                                                            <span class="selection">
                                                                <span class="select2-selection select2-selection--single"
                                                                    role="combobox" aria-haspopup="true"
                                                                    aria-expanded="false" tabindex="0"
                                                                    aria-disabled="false"
                                                                    aria-labelledby="select2-country-container">
                                                                    <span class="select2-selection__rendered" id="select2-country-container" role="textbox"
                                                                        aria-readonly="true" title=" India">
                                                                        India</span>
                                                                    <span class="select2-selection__arrow" role="presentation"><b
                                                                            role="presentation"></b></span>
                                                                </span>
                                                            </span><span class="dropdown-wrapper" aria-hidden="true"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-5 back-btn">
                                                <a href="{{route('login')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg> Back to Login
                                                </a>
                                            </p>

                                            <div class="d-flex justify-content-between mt-2">
                                                <button
                                                    class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button
                                                    class="btn btn-primary btn-next waves-effect waves-float waves-light"
                                                    type="button">
                                                    <span class="align-middle d-sm-inline-block d-none">Next</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-right align-middle ms-sm-25 ms-0">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>


                                        <div id="billing" class="content get_form_data" role="tabpanel"
                                            aria-labelledby="billing-trigger">
                                            <div class="content-header mb-5">
                                                <h2 class="fw-bolder mb-4">Select Plan</h2>
                                                <span>Select plan as per your retirement</span>
                                            </div>

                                            <!-- select plan options -->
                                            <div class="row custom-options-checkable gx-3 gy-2 pricing-data">

                                                <div class="col-md-4 planPrice" data-value="0.00">
                                                    <input class="custom-option-item-check" type="radio" name="plans"
                                                        id="1" value="1">
                                                    <label class="custom-option-item text-center p-3" for="1">
                                                        <span class="custom-option-item-title h3 fw-bolder">Free</span>
                                                        <span class="d-block m-4"></span>
                                                        <span class="plan-price">
                                                            <span class="pricing-value fw-bolder text-primary">&lrm;₹0</span>
                                                            <sub class="pricing-duration text-body font-medium-1 fw-bold">/year</sub>
                                                        </span>
                                                        <hr>
                                                        <span class="d-block m-3">Unlimited Sms Unit</span>
                                                        <span class="d-block m-3">
                                                            Text Messages: 1 Credit Per SMS
                                                        </span>
                                                        <span class="d-block m-3">Voice Messages: 2 Credit Per SMS</span>
                                                        <span class="d-block m-3">Picture Messages: 3 Credit Per SMS</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- / select plan options -->
                                            <div class="hide-for-free">
                                                <div class="content-header my-4 py-1">
                                                    <h2 class="fw-bolder mb-3">Payment Options</h2>
                                                    <span>Be sure to click on correct payment option</span>
                                                </div>
                                                <div class="row gx-2">
                                                    <ul class="other-payment-options list-unstyled">
                                                        <li>
                                                            <div class="form-check mt-1">
                                                                <input type="radio" name="payment_methods"
                                                                    class="form-check-input" value="instamojo">
                                                                <label class="form-check-label">Instamojo</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check mt-1">
                                                                <input type="radio" name="payment_methods"
                                                                    class="form-check-input" value="razorpay">
                                                                <label class="form-check-label">Razorpay</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p class="mt-2 mb-3 back-btn">
                                                <a href="{{route('login')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg> Back to Login
                                                </a>
                                            </p>
                                            <div class="d-flex justify-content-between mt-1">
                                                <button
                                                    class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                                    type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-chevron-left align-middle me-sm-25 me-0">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button
                                                    class="btn btn-success btn-submit waves-effect waves-float waves-light"
                                                    type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-check align-middle me-sm-25 me-0">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                    <span class="align-middle d-sm-inline-block d-none">Submit</span>
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let select = $('.select2');

    // select2
    select.each(function() {
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
</script>
<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
</script>
<script type="text/javascript">
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        var divs = $('.step');
        var tabpanel = $('.get_form_data');
        var now = 0; // currently shown div
        $(".btn-next").click(function() {
            divs.eq(now).removeClass('active');
            tabpanel.eq(now).removeClass('active');
            now = (now + 1 < divs.length) ? now + 1 : 0;
            divs.eq(now).addClass('active'); // show next
            tabpanel.eq(now).addClass('active'); // show next

        });
        $(".btn-prev").click(function() {
            divs.eq(now).removeClass('active');
            tabpanel.eq(now).removeClass('active');
            now = (now > 0) ? now - 1 : divs.length - 1;
            divs.eq(now).addClass('active'); // show previous
            tabpanel.eq(now).addClass('active'); // show previous

        });
    });
</script>

<script>
    function toggle_pass() {
        var x = document.getElementById("password");
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
    }
    function toggle_confpass() {
        var x = document.getElementById("password_confirmation");
        if (x.type === "password") {
        x.type = "text";
        } else {
        x.type = "password";
        }
    }
</script>
@endsection