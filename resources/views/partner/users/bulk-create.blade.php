@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('Bulk Create User'))

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="card p-2">
                    <div class="body">
                        @if (Session::get('status') == 'success')
                            <div class="alert alert-block alert-success alert-dismissible mb-5" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        @if (Session::get('status') == 'error')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        {{-- @dd($user); --}}
                        <form id="form" method="POST" action="{{ URL::to('partner/users/bulk-store') }}"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="checkUserdata">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" class="form-check-input" name="option_toggle"
                                        value="on" id="option_toggle" checked>
                                       

                                        <div class="import_file">

                                            <div class="mb-1 mt-2">
                                                <p class="text-uppercase">{{ __('Sample file') }}</p>
                                                <a href="{{ asset('sample_user_file.csv') }}"
                                                    class="btn btn-success fw-bold text-uppercase">
                                                    <i data-feather="file-text"></i>
                                                    {{ __('locale.labels.download_sample_file') }}
                                                </a>

                                            </div>


                                            <div class="mb-1">
                                                <label for="import_file"
                                                    class="form-label">{{ __('Select File') }} <span class="required"></span></label>
                                                <div class="us-file-zone us-clickable">
                                                    {{-- <input type="file" name="file" class="form-control"
                                                    value="{{ old('file') }}" required> --}}
                                                    <input type="file" name="file" class="us-file upload-file"
                                                        id="import_file"
                                                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                                    <div class="us-file-message">
                                                        {{ __('locale.filezone.click_here_to_upload') }}</div>
                                                    <div class="us-file-footer">
                                                        {!! __('locale.contacts.only_supported_file') !!}
                                                    </div>
                                                </div>
                                                @error('file')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary waves-effect my-2"
                                type="submit">{{ __('locale.buttons.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dashboard Analytics end -->
@endsection


@section('vendor-script')
    {{--     Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('validator-js/jquery.validate.min.js') }}"></script>

@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            // Your form validation logic
            $('#form').validate({
                rules: {
                    
                },
                messages: {
                    file: {
                        accept: "Please choose a valid file type (csv, xls, xlsx)."
                    }
                }
            });
        });
        $("body").on("change", ".upload-file", function(e) {
            if ($(this).val() !== '') {
                $('.us-file-message').addClass('us-file-message-done');
                $('.us-file-message.us-file-message-done').text("File Uploaded Successfully.");
            } else {
                $('.us-file-message').removeClass('us-file-message-done');
            }

        });
    </script>
@endsection
