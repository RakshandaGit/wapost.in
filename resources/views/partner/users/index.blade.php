@php use App\Library\Tool; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.users'))

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
        table.dataTable>thead .sorting:before,table.dataTable>thead .sorting_desc:after,
        table.dataTable>thead .sorting:after,table.dataTable>thead .sorting_desc:before {
            content: "";
            right: 0;
        }
    </style>
@endsection

@section('content')
    {{-- Dashboard Analytics Start --}}
    <section>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('Partner.create') }}"
                    class="btn btn-success waves-light waves-effect fw-bold w-auto"> {{ __('locale.buttons.add_new') }} <i
                        data-feather="plus-circle"></i></a>
                <a href="{{ route('Partner.bulkCreate') }}"
                    class="btn btn-primary waves-light waves-effect fw-bold ms-2 w-auto"> {{ __('Add Bulk Users') }} <i
                        data-feather="plus-circle"></i></a>
                <div class="card mt-3">
                    <table class="table datatables-partner-basic">
                        <thead>
                            <tr>
                                <th>{{ __('Enterprise user id') }}</th>
                                <th>{{ __('locale.labels.name') }} </th>
                                <th>{{ __('locale.labels.phone') }}</th>
                                <th>{{ __('locale.labels.email') }}</th>
                                <th>{{ __('Available Message') }}</th>
                                <th>{{ __('locale.labels.actions') }}</th>
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

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('Partner.ajaxPartnerUsers') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'enterprise_user_id',
                    },
                    {
                        data: 'name',
                        searchable: true,
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'available_message',
                        orderable: false
                    },
                ],

                searchDelay: 1500,
                columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2
                    },
                    {
                        // Actions
                        targets: 5,
                        orderable: false,
                        render: function(data, type, full) {
                            console.log(full, 'full');
                            return (
                                
                                '<a href="' + full['edit'] +'" class="text-primary pe-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">' +
                                feather.icons['edit'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</a><a href="' + full['editAllocate'] +'" class="text-dark pe-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Transaction">' +
                                feather.icons['alert-circle'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</a>'
                            );
                        }
                    }
                ],
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
                    [4, "desc"]
                ],
                displayLength: 10,
            });
        });
    </script>
@endsection
