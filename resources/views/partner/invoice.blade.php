@php use App\Library\Tool;use App\Models\Campaigns;use App\Models\Plan;use App\Models\Reports;use App\Models\User; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', 'Panel')

{{--Vendor Css files--}}
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether-theme-arrows.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/tether.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/shepherd.min.css')) }}">
@endsection

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tour.css')) }}">
@endsection



@section('content')

    <div class="invoice-print p-3">
        <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
            <div>
                <div class="d-flex mb-1">
                    <img src="{{asset(config('app.logo'))}}" alt="{{config('app.name')}}" class=""/>
                </div>
                <p class="card-text">{!! \App\Helpers\Helper::app_config('company_address') !!}</p>
            </div>
            <div class="mt-md-0 mt-2">
                <h4 class="font-weight-bold text-right mb-1">{{ __('locale.labels.invoice') }} #WP/23-24/25</h4>
                <div class="invoice-date-wrapper mb-50">
                    <span class="invoice-date-title">{{ __('locale.labels.invoice_date') }}:</span>
                    <span class="font-weight-bold"> {{ __('Jun 30, 2023')}}</span>
                </div>
            </div>
        </div>

        <hr class="my-2"/>

        <div class="row pb-2">
            <div class="col-sm-6">
                <h6 class="mb-1">{{ __('locale.labels.recipient') }}:</h6>
                <h6 class="mb-25">{{ __('Shubham Malewar') }}</h6>
                <p class="mb-25">{{ __('IT Park') }}</p>
                <p class="mb-25">{{ __('') }}-{{ __('-440028') }}</p>
                <p class="mb-25">{{ __('Nagpur')}}, {{ __('India') }}</p>
                <p class="mb-0">{{ __('shubham.malewar@selftech.in') }}</p>
            </div>
            <div class="col-sm-6 mt-sm-0 mt-2">
                <h6 class="mb-1">{{ __('locale.labels.payment_details') }}:</h6>
                <table>
                    <tbody>
                    <tr>
                        <td class="pr-1">{{ __('locale.labels.total') }}:</td>
                        <td><strong>₹515.34</strong></td>
                    </tr>
                    <tr>
                        <td class="pr-1">{{ __('locale.labels.paid_by') }}:</td>
                        <td>Stripe</td>
                    </tr>
                    <tr>
                        <td class="pr-1">{{ __('locale.labels.transaction_id') }}:</td>
                        <td>pi_3NOgBlSA3Mws5oPl0mTI3M6k</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table class="table m-0">
                <thead>
                <tr class="text-uppercase">
                    <th>{{ __('locale.labels.payment_details') }}</th>
                    <th>{{ __('Message Amount') }}</th>
                    <th>{{ __('locale.labels.status') }}</th>
                    <th>{{ __('locale.labels.amount') }}</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td>Payment for Messages</td>
                    <td>500</td>
                    <td>Paid</td>
                    <td>₹515.34</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="row invoice-sales-total-wrapper mt-3">
            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                <p class="card-text mb-0"></p>
            </div>
            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                <div class="invoice-total-wrapper">
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">{{ __('locale.labels.subtotal') }}:</p>
                        <p class="invoice-total-amount">₹515.34</p>
                    </div>
                    <hr class="my-50"/>
                    <div class="invoice-total-item">
                        <p class="invoice-total-title">{{ __('locale.labels.total') }}:</p>
                        <p class="invoice-total-amount">₹515.34</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('js/scripts/pages/app-invoice-print.js')}}"></script>
@endsection

