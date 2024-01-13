{{-- @extends('layouts/contentLayoutMaster')

@section('title', __('POS Activation'))

@section('content') --}}
<!-- Basic Vertical form layout section start -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<!-- Main Stylesheet -->
<link rel="stylesheet" href="{{ asset('dashboard_page/dashboard_pages.css') }}">
<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
<section id="basic-vertical-layouts" class="pos-activation">
    <a class="brand-logo" href="/">
        <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}" />
    </a>
    <div class="posActivePage">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="imgBox">
                    <img src="{{ asset('images/partner/pos-activation.png') }}" alt="pos-activation" class="w-100">
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                <div class="py-2 px-2">
                    <div class="multiconnection-scroll">
                        <div id="connected" class="py-0 px-2 rounded" >
                            <div class="row mb-1 p-1" style="background: #f4fff8;">
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image" src="https://pps.whatsapp.net/v/t61.24694-24/411971656_712061547685546_5400926328335505569_n.jpg?ccb=11-4&amp;oh=01_AdRXTQPK0eDp-uATdhl1eIjeSipMw2KeAVzu4ldtjDdPbg&amp;oe=65AA2921&amp;_nc_sid=e6ed6c&amp;_nc_cat=111" class="img-fluid  rounded-circle" data-toggle="tooltip" title="" data-original-title="">
                                        </div>
                                        <div class="mt-1">
                                            <p class="mb-0 h5"><b id="wa_number">917498888683</b>
                                                <small id="wa_name">User Name</small>
                                            </p>
                                            <p class="mb-0">
                                                State: <span class="badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-7">
                                    <div class="mb-3 mb-md-0" style="text-align:center;margin-top:1rem;">
                                        <button instance-key="WA_XX2P1U40" type="button" id="disconnect_account" class="btn btn-danger waves-effect waves-float waves-light">Log out</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 p-1" style="background: #f4fff8;">
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image" src="https://pps.whatsapp.net/v/t61.24694-24/411971656_712061547685546_5400926328335505569_n.jpg?ccb=11-4&amp;oh=01_AdRXTQPK0eDp-uATdhl1eIjeSipMw2KeAVzu4ldtjDdPbg&amp;oe=65AA2921&amp;_nc_sid=e6ed6c&amp;_nc_cat=111" class="img-fluid  rounded-circle" data-toggle="tooltip" title="" data-original-title="">
                                        </div>
                                        <div class="mt-1">
                                            <p class="mb-0 h5"><b id="wa_number">917498888683</b>
                                                <small id="wa_name">User Name</small>
                                            </p>
                                            <p class="mb-0">
                                                State: <span class="badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-7">
                                    <div class="mb-3 mb-md-0" style="text-align:center;margin-top:1rem;">
                                        <button instance-key="WA_XX2P1U40" type="button" id="disconnect_account" class="btn btn-danger waves-effect waves-float waves-light">Log out</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 p-1" style="background: #f4fff8;">
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image" src="https://pps.whatsapp.net/v/t61.24694-24/411971656_712061547685546_5400926328335505569_n.jpg?ccb=11-4&amp;oh=01_AdRXTQPK0eDp-uATdhl1eIjeSipMw2KeAVzu4ldtjDdPbg&amp;oe=65AA2921&amp;_nc_sid=e6ed6c&amp;_nc_cat=111" class="img-fluid  rounded-circle" data-toggle="tooltip" title="" data-original-title="">
                                        </div>
                                        <div class="mt-1">
                                            <p class="mb-0 h5"><b id="wa_number">917498888683</b>
                                                <small id="wa_name">User Name</small>
                                            </p>
                                            <p class="mb-0">
                                                State: <span class="badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-7">
                                    <div class="mb-3 mb-md-0" style="text-align:center;margin-top:1rem;">
                                        <button instance-key="WA_XX2P1U40" type="button" id="disconnect_account" class="btn btn-danger waves-effect waves-float waves-light">Log out</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 p-1" style="background: #f4fff8;">
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image" src="https://pps.whatsapp.net/v/t61.24694-24/411971656_712061547685546_5400926328335505569_n.jpg?ccb=11-4&amp;oh=01_AdRXTQPK0eDp-uATdhl1eIjeSipMw2KeAVzu4ldtjDdPbg&amp;oe=65AA2921&amp;_nc_sid=e6ed6c&amp;_nc_cat=111" class="img-fluid  rounded-circle" data-toggle="tooltip" title="" data-original-title="">
                                        </div>
                                        <div class="mt-1">
                                            <p class="mb-0 h5"><b id="wa_number">917498888683</b>
                                                <small id="wa_name">User Name</small>
                                            </p>
                                            <p class="mb-0">
                                                State: <span class="badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-7">
                                    <div class="mb-3 mb-md-0" style="text-align:center;margin-top:1rem;">
                                        <button instance-key="WA_XX2P1U40" type="button" id="disconnect_account" class="btn btn-danger waves-effect waves-float waves-light">Log out</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 p-1" style="background: #f4fff8;">
                                <div class="col-lg-8 col-md-12">
                                    <div class="d-md-flex">
                                        <div class="avatar-item mb-3 mb-md-0 me-1" style="max-width: 60px">
                                            <img alt="image" src="https://pps.whatsapp.net/v/t61.24694-24/411971656_712061547685546_5400926328335505569_n.jpg?ccb=11-4&amp;oh=01_AdRXTQPK0eDp-uATdhl1eIjeSipMw2KeAVzu4ldtjDdPbg&amp;oe=65AA2921&amp;_nc_sid=e6ed6c&amp;_nc_cat=111" class="img-fluid  rounded-circle" data-toggle="tooltip" title="" data-original-title="">
                                        </div>
                                        <div class="mt-1">
                                            <p class="mb-0 h5"><b id="wa_number">917498888683</b>
                                                <small id="wa_name">User Name</small>
                                            </p>
                                            <p class="mb-0">
                                                State: <span class="badge-success py-1">Connected</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-7">
                                    <div class="mb-3 mb-md-0" style="text-align:center;margin-top:1rem;">
                                        <button instance-key="WA_XX2P1U40" type="button" id="disconnect_account" class="btn btn-danger waves-effect waves-float waves-light">Log out</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="instance_key" style="display:none;">
                            WA_XX2P1U40
                        </div>
                    </div>
                    <div class="mt-2"><a href="{{ URL::to('connection-partner') }}"
                        class="activeFree"><i class="fa fa-handshake"></i><span>Add More</span></a></div>
                </div>
            </div>
        </div>
    </div>
    <p class="bottomText">Click here to know more about <a href="{{ url('/') }}">wapost.net</a> visit our website
    </p>
</section>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<!-- // Basic Vertical form layout section end -->


{{-- @endsection


@section('page-script')

@endsection --}}
