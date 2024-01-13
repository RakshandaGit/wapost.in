@extends('layouts/contentLayoutMaster')

@section('title', __('locale.blacklist.add_new_blacklist'))

@section('content')
    <div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-skip-back"><polygon points="19 20 9 12 19 4 19 20"></polygon><line x1="5" y1="19" x2="5" y2="5"></line></svg> Back</a></div>
    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.blacklist.add_new_blacklist') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            <p>{!!  __('locale.description.blacklist') !!} </p>

                            <form class="form form-vertical" action="{{ route('customer.blacklists.store') }}" method="post">
                                @csrf

                                <div class="row">

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="number" class="form-label required">{{ __('locale.labels.paste_numbers') }}</label>
                                            <textarea id="number" class="form-control @error('number') is-invalid @enderror" name="number" required autofocus></textarea>
                                            @error('number')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">

                                            <div class="btn-group backlist-btn-group" role="group">
                                                <input type="radio" class="btn-check" name="delimiter" value="," id="comma" autocomplete="off" checked/>
                                                <label class="btn btn-outline-primary" for="comma">, ({{ __('locale.labels.comma') }})</label>

                                                <input type="radio" class="btn-check" name="delimiter" value=";" id="semicolon" autocomplete="off"/>
                                                <label class="btn btn-outline-primary" for="semicolon">; ({{ __('locale.labels.semicolon') }})</label>

                                                <input type="radio" class="btn-check" name="delimiter" value="|" id="bar" autocomplete="off"/>
                                                <label class="btn btn-outline-primary" for="bar">| ({{ __('locale.labels.bar') }})</label>

                                                {{-- <input type="radio" class="btn-check" name="delimiter" value="tab" id="tab" autocomplete="off"/>
                                                <label class="btn btn-outline-primary" for="tab">{{ __('locale.labels.tab') }}</label> --}}

                                                <input type="radio" class="btn-check" name="delimiter" value="new_line" id="new_line" autocomplete="off"/>
                                                <label class="btn btn-outline-primary" for="new_line">{{ __('locale.labels.new_line') }}</label>

                                            </div>

                                            @error('delimiter')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="reason" class="form-label">{{ __('locale.labels.reason') }}</label>
                                            <input type="text" id="reason"
                                                   class="form-control @error('reason') is-invalid @enderror"
                                                   value="{{ old('reason')}}"
                                                   name="reason">
                                            @error('reason')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"><i data-feather="save"></i> {{ __('locale.buttons.save') }}</button>
                                        <button type="reset" class="btn btn-outline-warning mb-1"><i data-feather="refresh-cw"></i> {{ __('locale.buttons.reset') }}</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

@endsection

@section('page-script')

    <script>
        $(document).ready(function () {

            let firstInvalid = $('form').find('.is-invalid').eq(0);

            if (firstInvalid.length) {
                $('body, html').stop(true, true).animate({
                    'scrollTop': firstInvalid.offset().top - 200 + 'px'
                }, 200);
            }
            $('#number').on('input', function() {
                let inputValue = $(this).val();

                let numericValue = inputValue.replace(/[^\d;,|\n]/g, '');

                $(this).val(numericValue);
            });
        });
    </script>
@endsection
