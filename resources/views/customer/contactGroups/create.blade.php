@extends('layouts/contentLayoutMaster')

@section('title', __('locale.contacts.new_contact_group'))

@section('content')
    <div class="col-md-2 col-12 text-end">
        <a href="#!" class="back-dashbordbtn" onclick="window.history.go(-1); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg>
            Back
        </a>
    </div>
    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-6 col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('locale.contacts.new_contact_group') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" action="{{ route('customer.contacts.store') }}" method="post">
                                @csrf
                                <div class="row">

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="name"
                                                class="form-label required">{{ __('locale.labels.name') }}</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" name="name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-12">
                                        <div class="divider divider-left divider-primary">
                                            <div class="divider-text text-uppercase fw-bold text-primary">{{ __('locale.labels.settings') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-10">
                                        <p class="mb-0 text-primary">{{ __('locale.contacts.send_welcome_message') }}?</p>
                                        <p><small class="">{!! __('locale.contacts.send_welcome_message_description') !!}</small></p>

                                    </div>
                                    <div class="col-2">
                                        <div class="mb-1">
                                            <div class="form-check form-switch form-check-primary form-switch-md">
                                                <input type="checkbox" name="send_welcome_sms" value="1" checked class="form-check-input" id="send_welcome_sms">
                                                <label class="form-check-label" for="send_welcome_sms">
                                                    <span class="switch-text-left">{{ __('locale.labels.yes') }}</span>
                                                    <span class="switch-text-right">{{ __('locale.labels.no') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-10">
                                        <p class="mb-0 text-primary">{{ __('locale.contacts.send_unsubscribe_notification') }}?</p>
                                        <p><small class="">{!! __('locale.contacts.send_unsubscribe_notification_description') !!}</small></p>

                                    </div>
                                    <div class="col-2">
                                        <div class="mb-1">
                                            <div class="form-check form-switch form-check-primary form-switch-md">
                                                <input type="checkbox" name="unsubscribe_notification" value="1" checked class="form-check-input" id="unsubscribe_notification">
                                                <label class="form-check-label" for="unsubscribe_notification">
                                                    <span class="switch-text-left">{{ __('locale.labels.yes') }}</span>
                                                    <span class="switch-text-right">{{ __('locale.labels.no') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @can('view_keywords')
                                    <div class="row mt-2">
                                        <div class="col-10">
                                            <p class="mb-0 text-primary">{{ __('locale.contacts.send_keyword_message') }}?</p>
                                            <p><small class="">{!! __('locale.contacts.send_keyword_message_description') !!}</small> <a href="#" class="text-danger small">{{ __('locale.menu.Keywords') }}</a> </p>

                                        </div>
                                        <div class="col-2">
                                            <div class="mb-1">
                                                <div class="form-check form-switch form-check-primary form-switch-md">
                                                    <input type="checkbox" name="send_keyword_message" value="1" class="form-check-input" id="send_keyword_message">
                                                    <label class="form-check-label" for="send_keyword_message">
                                                        <span class="switch-text-left">{{ __('locale.labels.yes') }}</span>
                                                        <span class="switch-text-right">{{ __('locale.labels.no') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
 --}}
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <input type="hidden" value="1" name="is_admin">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                                            <i data-feather="save"></i> {{ __('locale.buttons.save') }}
                                        </button>
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
        let firstInvalid = $('form').find('.is-invalid').eq(0);

        if (firstInvalid.length) {
            $('body, html').stop(true, true).animate({
                'scrollTop': firstInvalid.offset().top - 200 + 'px'
            }, 200);
        }
    </script>
@endsection
