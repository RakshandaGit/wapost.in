@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Dashboard'))

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
@endsection

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section>

        <div class="row ">

            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ url('contacts') }}">
                        <div class="card-header">
                            
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="users" class="text-primary font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ url('contacts') }}">
                        <div class="card-header">
                            @if (Auth::user()->customer->activeSubscription() != null)
                                <div class="d-flex">
                                    <h2 class="fw-bolder mb-0">
                                        {{ Auth::user()->customer->subscriberCounts() != null ? Tool::format_number(Auth::user()->customer->subscriberCounts()) : 0 }}
                                    </h2>
                                    <p class="card-text">{{ __('locale.menu.Contacts') }}</p>
                                </div>
                            @else
                                <div class="d-flex">
                                    <h2 class="fw-bolder mb-0">0</h2>
                                    <p class="card-text">{{ __('locale.menu.Contacts') }}</p>
                                </div>
                            @endif

                            <div class="avatar bg-light-success p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="user" class="text-success font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{ url('blacklists') }}">
                        <div class="card-header">
                            <div class="d-flex">
                                <h2 class="fw-bolder mb-0">{{ Auth::user()->customer->blacklistCounts() }}</h2>
                                <p class="card-text">{{ __('locale.menu.Blacklist') }}</p>
                            </div>
                            <div class="avatar bg-light-danger p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="user-x" class="text-danger font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="row same-height">
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-primary">{{ \App\Helpers\Helper::greetingMessage() }}</h3>
                        <p class="font-medium-2 mt-2">
                            {{ __('locale.description.dashboard', ['brandname' => config('app.name')]) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card connection-cards">
                    <div class="card-body">
                        <h3 class="mb-2">{{ __('WhatsApp Connections') }}</h3>
                        @if (count($connections) > 0)

                            @foreach ($connections as $k => $connection)
                                @if ($k == 3)
                                    @php break; @endphp
                                @endif
                                <div class="d-md-flex">
                                    <div class="condata mb-1 d-md-flex align-items-center">
                                        <div class="avatar-item ">
                                            @if ($connection->avatar == null && $connection->avatar == '')
                                                <img alt="image" src="{{ route('user.avatar', Auth::user()->uid) }}"
                                                    class="img-fluid" data-toggle="tooltip" title=""
                                                    data-original-title=""
                                                    style="border:1px solid;border-radius:50%;width:80%;">
                                            @else
                                                <img alt="image"
                                                    src="{{ !empty($connection->avatar) ? $connection->avatar : URL::to('/') . '/avatar?63e23288e5d0d' }}"
                                                    class="img-fluid" data-toggle="tooltip" title=""
                                                    data-original-title=""
                                                    style="border:1px solid;border-radius:50%;width:80%;">
                                            @endif

                                        </div>
                                        <p class="mb-0 h5 ">
                                            <b id="wa_number">
                                                {{ $connection->number }}
                                                @if ($connection->name != null)
                                                    ({{ $connection->name }})
                                                @endif
                                            </b>
                                        </p>
                                        {{-- <p class="mb-0 constate"><i class="fa fa-wifi mr-2"></i> State: <span class="badge badge-success text-body-heading py-1">Connected</span></p> --}}
                                    </div>
                                </div>
                            @endforeach
                            @if (count($connections) > 3)
                                <div class="add-more-con"><a href="{{ route('customer.connection') }}"
                                        class="btn btn-common flat-btn btn-active"><i
                                            class="fa fa-plus"></i>{{ count($connections) - 3 }}</a></div>
                            @endif
                        @else
                            <div>
                                <h4>To connect your WhatsApp</h4> <a href="{{ route('customer.connection') }}"
                                    class="btn btn-common flat-btn btn-active mt-md-3 mt-2">Connect Now</a>
                            </div>
                        @endempty
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-12">
            <div class="card moreinfo-msg">
                <div class="card-body">
                    <h3 class="text-primary">{{ __('locale.labels.current_plan') }}</h3>
                    @if (Auth::user()->customer->activeSubscription() == null)
                        <h3 class="mt-1 text-danger">{{ __('locale.subscription.no_active_subscription') }}</h3>
                    @else
                        <p class="mb-2 mt-1 font-medium-2">{!! __('locale.subscription.you_are_currently_subscribed_to_plan', [
                            'plan' => auth()->user()->customer->subscription->plan->name,
                            'price' => Tool::format_price(
                                auth()->user()->customer->subscription->plan->price,
                                auth()->user()->customer->subscription->plan->currency->format,
                            ),
                            'remain' => Tool::formatHumanTime(auth()->user()->customer->subscription->current_period_ends_at),
                            'end_at' => Tool::customerDateTime(auth()->user()->customer->subscription->current_period_ends_at),
                        ]) !!}</p>
                    @endif
                    <a href="{{ route('customer.subscriptions.index') }}"
                        class="btn btn-common flat-btn btn-active mt-lg-1 mt-md-1 mt-1"><i data-feather="info"></i>
                        {{ __('locale.labels.more_info') }}</a>
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
@endsection