@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.transactions'))

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
    <style>
        table.dataTable>thead .sorting:before,
        table.dataTable>thead .sorting:after {
            content: "";
            right: 0;
        }
    </style>
@endsection

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section>
        <div class="row mt-3">
            <div class="col-12 col-sm-6">
                <p><strong> Available Message : <span>{{ $availableBalance }}</span></strong></p>
            </div>
            <div class="col-12 col-sm-6">
                <div class="btn-group w-auto mb-2 mt-2 float-end">
                    <a href="{{ route('Partner.allocateMessage', ['user_id' => $userId]) }}"
                        class="btn btn-success waves-light waves-effect fw-bold"> {{ __('Allocate Messages') }} <i
                            data-feather="map"></i></a>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <table class="table datatables-partner-basic">
                        <thead>
                            <tr>
                                {{-- <th>{{ __('User Id') }}</th> --}}
                                {{-- <th>{{ __('Name') }}</th> --}}
                                <th>{{ __('Credit') }} </th>
                                <th>{{ __('Debit') }} </th>
                                <th>{{ __('Balance') }} </th>
                                <th>{{ __('Remark') }} </th>
                                {{-- <th>{{ __('locale.labels.status') }}</th> --}}
                            </tr>
                        </thead>
                    </table>
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
    <script>
        $(document).ready(function() {
            "use strict"

            // ---------------- Partner inquery--------------------

            // init list view datatable
            let dataListView = $('.datatables-partner-basic').DataTable({
                sort: false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('Partner.userAllocateMessagesShow', $userId) }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    // {
                    //     data: 'enterprise_user_id',
                    // },
                    // {
                    //     data: 'name',
                    // },
                    {
                        data: 'credit',
                    },
                    {
                        data: 'debit',
                    },
                    {
                        data: 'balance',
                    },
                    {
                        data: 'remark',
                    },
                ],

                searchDelay: 1500,
                columnDefs: [{
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2
                }],
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',

                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    sLengthMenu: "_MENU_",
                    sZeroRecords: "{{ __('locale.datatables.no_results') }}",
                    sSearch: "{{ __('locale.datatables.search') }}",
                    sProcessing: "{{ __('locale.datatables.processing') }}",
                    sInfo: "{{ __('locale.datatables.showing_entries', ['start' => '_START_', 'end' => '_END_', 'total' => '_TOTAL_']) }}"
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                let data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',

                    }
                },
                aLengthMenu: [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100]
                ],
                select: {
                    style: "multi"
                },
                order: [
                    [2, "desc"]
                ],
                displayLength: 10,
            });
        });
    </script>
@endsection