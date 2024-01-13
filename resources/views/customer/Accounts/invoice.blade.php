@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.labels.invoice'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/pages/app-invoice.css') }}">
@endsection

@section('content')
    <div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg> Back</a></div>

    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body invoice-padding pb-0">
                        <!-- Header starts -->
                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                            <div>
                                <div class="logo-wrapper">
                                    <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}"
                                        class="" />
                                </div>
                                <p class="card-text">{!! \App\Helpers\Helper::app_config('company_address') !!}</p>
                            </div>
                            <div class="mt-md-0 mt-2">
                                <h4 class="invoice-title">
                                    {{ __('locale.labels.invoice') }}
                                    <span class="invoice-number">#{{ $invoice->invoice_number }}</span>
                                </h4>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">{{ __('locale.labels.invoice_date') }}:</p>
                                    <p class="invoice-date">{{ Tool::formatDate($invoice->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>
                    @php
                        if ($invoice->amount == 0) {
                            // is for addons invoice
                            $totalAddonsPrice = $invoice->addons_connections * $invoice->connection_addons_price;
                        } else {
                            $totalAddonsPrice = $invoice->addons_connections * $invoice->connection_addons_price * $invoice->duration_count;
                        }
                        
                        $totalPlanPrice = $invoice->amount * $invoice->duration_count;
                        $totalAdjustedAmount = $invoice->adjusted_plan_price + $invoice->adjusted_addons_price;
                        
                        $totalAmount = $totalAddonsPrice + $totalPlanPrice - $totalAdjustedAmount;
                    @endphp
                    <hr class="invoice-spacing" />
                    <!-- Address and Contact starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row invoice-spacing">
                            <div class="col-xl-8 p-0">
                                <h6 class="mb-2">{{ __('locale.labels.recipient') }}:</h6>
                                <h6 class="mb-25">{{ $invoice->user->displayName() }}</h6>
                                <p class="card-text mb-25">{{ $invoice->user->customer->address }}</p>
                                <p class="card-text mb-25">
                                    {{ $invoice->user->customer->state }}-{{ $invoice->user->customer->postcode }}</p>
                                <p class="card-text mb-25">{{ $invoice->user->customer->city }},
                                    {{ $invoice->user->customer->country }}</p>
                                <p class="card-text mb-0">{{ $invoice->user->email }}</p>
                            </div>
                            <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                <h6 class="mb-2">{{ __('locale.labels.payment_details') }}:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-1">{{ __('locale.labels.total') }}:</td>
                                            <td><span {{-- class="fw-bold">{{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</span> --}}
                                                    class="fw-bold">{{ Tool::format_price($totalAmount, $invoice->currency->format) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-1">{{ __('locale.labels.paid_by') }}:</td>
                                            <td>{{ $invoice->paymentMethod->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pe-1">{{ __('locale.labels.transaction_id') }}:</td>
                                            <td style="word-break: break-all">{{ $invoice->transaction_id }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Address and Contact ends -->

                    <!-- Invoice Description starts -->
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>{{ __('locale.labels.payment_details') }}</th>
                                    <th>{{ __('locale.labels.status') }}</th>
                                    <th>{{ __('locale.labels.type') }}</th>
                                    <th>{{ __('locale.labels.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->description }}</td>
                                    <td>{{ ucfirst($invoice->status) }}</td>
                                    <td>{{ ucfirst($invoice->type) }}</td>
                                    {{-- <td>{{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</td> --}}
                                    <td>
                                        @if ($invoice->amount > 0)
                                            {{ Tool::format_price($totalPlanPrice, $invoice->currency->format) }}
                                        @else ($invoice->amount > 0)
                                            {{ Tool::format_price($totalAmount, $invoice->currency->format) }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body invoice-padding pb-0">
                        <div class="row invoice-sales-total-wrapper">
                            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                <p class="card-text mb-0"></p>
                            </div>

                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                <div class="invoice-total-wrapper">
                                    @if ($invoice->amount > 0)
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">{{ __('locale.labels.subtotal') }}:</p>
                                            <p class="invoice-total-amount">
                                                {{-- {{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</p> --}}
                                                {{ Tool::format_price($totalPlanPrice, $invoice->currency->format) }}</p>
                                        </div>
                                    @endif
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Addon Amount:</p>
                                        <p class="invoice-total-amount">
                                            {{-- {{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</p> --}}
                                            {{ Tool::format_price($totalAddonsPrice, $invoice->currency->format) }}</p>
                                    </div>
                                    @if ($totalAdjustedAmount > 0)
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">Previous Plan Adjustment:</p>
                                            <p class="invoice-total-amount">
                                                {{-- {{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</p> --}}
                                                {{ Tool::format_price($totalAdjustedAmount, $invoice->currency->format) }}
                                            </p>
                                        </div>
                                    @endif
                                    <hr class="my-50" />
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">{{ __('locale.labels.total') }}:</p>
                                        <p class="invoice-total-amount">
                                            {{-- {{ Tool::format_price($invoice->amount, $invoice->currency->format) }}</p> --}}
                                            {{ Tool::format_price($totalAmount, $invoice->currency->format) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Description ends -->
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-primary w-100 mb-75" href="{{ route('customer.invoices.print', $invoice->uid) }}"
                            target="_blank"> <i data-feather="printer"></i> {{ __('locale.labels.print') }}</a> 
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </section>

@endsection
