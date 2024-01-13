@extends('layouts/contentLayoutMaster')

@section('title', __('Partner Inquiry'))

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection

@section('content')
    <div class="col-md-2 col-12 text-end"><a href="{{ URL::previous() }}" class="back-dashbordbtn"><svg
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-skip-back">
                <polygon points="19 20 9 12 19 4 19 20"></polygon>
                <line x1="5" y1="19" x2="5" y2="5"></line>
            </svg> Back</a></div>

    <!-- Basic table -->
    <section id="datatables-basic">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table partner-datatables-basic">
                        <thead>
                            <tr>
                                <th>{{ __('locale.labels.name') }} </th>
                                <th>{{ __('locale.labels.mobile') }}</th>
                                <th>{{ __('locale.labels.email') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--/ Basic table -->


@endsection


@section('vendor-script')
    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>

@endsection
@section('page-script')
    {{-- Page js files --}}
    <script>
        $(document).ready(function() {
            "use strict"

            // ---------------- Partner inquery--------------------

            // init list view datatable
            let dataListView = $('.partner-datatables-basic').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.partnerShow') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'name',
                        searchable: true,
                    },
                    {
                        data: 'mobile',
                    },
                    {
                        data: 'email',
                    },
                ],

                searchDelay: 1500,
                columnDefs: [{
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2
                }, ],
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
                        // renderer: function(api, rowIdx, columns) {
                        //     let data = $.map(columns, function(col) {
                        //         console.log(data,'data');
                        //         return col.name !==
                        //             '' // ? Do not show row in modal popup if title is blank (for check box)
                        //             ?
                        //             '<tr data-dt-row="' +
                        //             col.rowIdx +
                        //             '" data-dt-column="' +
                        //             col.columnIndex +
                        //             '">' +
                        //             '<td class="name">' +
                        //             col.name +
                        //             ':' +
                        //             '</td> ' +
                        //             '<td>' +
                        //             col.data +
                        //             '</td>' +
                        //             '</tr>' :
                        //             '';
                        //     }).join('');

                        //     return data ? $('<table class="table"/>').append('<tbody>' + data +
                        //         '</tbody>') : false;
                        // }
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
