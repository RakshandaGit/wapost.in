@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection


@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection
<style>
    #sendtable_content tr.odd td.control,
    #sendtable_content tr.even td.control {
        opacity: 0;
        visibility: hidden;
    }
</style>
@section('content')

    <div class="reportsTab">

        <ul class="nav nav-tabs mt-3" id="reportsout" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active btn-lg" id="reportstable_tab" data-bs-toggle="tab"
                    data-bs-target="#reportstable_content" type="button" role="tab"
                    aria-controls="reportstable_content" aria-selected="true"> <svg xmlns="http://www.w3.org/2000/svg"
                        width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server">
                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2">
                        </rect>
                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2">
                        </rect>
                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                    </svg> Campaign Reports</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-lg" id="sendtable_tab" data-bs-toggle="tab" data-bs-target="#sendtable_content"
                    type="button" role="tab" aria-controls="sendtable_content" aria-selected="false"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-send">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg> Quick Send Reports</button>
            </li>
        </ul>
        <div class="tab-content" id="reportsoutContent">

            <!-- send Form  -->
            <div class="tab-pane fade show active" id="reportstable_content" role="tabpanel"
                aria-labelledby="reportstable_tab">
                @include('customer.Reports.campaigns')
            </div>
            <div class="tab-pane fade" id="sendtable_content" role="tabpanel" aria-labelledby="sendtable_tab">
                @include('customer.Reports.sent_messages')
            </div>

        </div>
    </div>
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


            // init table dom
            let Table = $("table");

            // init list view datatable
            let dataListView = $('.datatables-basic').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('customer.reports.search.sent') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": 'responsive_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "uid",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "uid",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "created_at",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "from",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "to",
                        orderable: true,
                        searchable: true
                    },
                    // {"data": "type"},
                    // {"data": "cost"},
                    {
                        "data": "status",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    }
                ],

                searchDelay: 1500,
                columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    },
                    {
                        // For Checkboxes
                        targets: 1,
                        orderable: false,
                        responsivePriority: 3,
                        render: function(data) {
                            // return (
                            //     '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="' +
                            //     data +
                            //     '" /><label class="form-check-label" for="' +
                            //     data +
                            //     '"></label></div>'
                            // );
                            return ('');
                        },
                        // checkboxes: {
                        //     selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
                        //     selectRow: true
                        // }
                    },
                    {
                        targets: 2,
                        visible: false
                    },
                    {
                        // Actions
                        targets: -1,
                        title: '{{ __('locale.labels.actions') }}',
                        orderable: false,
                        render: function(data, type, full) {
                            return (
                                // '<span class="action-delete text-danger pe-1 cursor-pointer" data-id=' + full['uid'] + '>' +
                                // feather.icons['trash'].toSvg({class: 'font-medium-4'}) +
                                // '</span>' +
                                // '<span class="action-view text-primary pe-1 cursor-pointer" data-id=' + full['uid'] + '>' +
                                // feather.icons['eye'].toSvg({class: 'font-medium-4'}) +
                                // '</span>'

                                '<a href="{{ URL::to('reports/quick-send/details') }}/' + full[
                                    'uid'] + '"><span class="action-view text-primary pe-1">' +
                                feather.icons['eye'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</span></a>'
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
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title !==
                                    '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIdx +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/>').append('<tbody>' + data +
                                '</tbody>') : false;
                        }
                    }
                },
                aLengthMenu: [
                    [10, 20, 10, 100],
                    [10, 20, 10, 100]
                ],
                select: {
                    style: "multi"
                },
                order: [
                    [3, "desc"]
                ],
                displayLength: 10,
            });

            // init table dom
            let Table1 = $("table");
            // Changes to the inputs will trigger a redraw to update the table
            $('#start_date').on('input', function() {
                var end = $('#end_date').val();
                var start = $(this).val();
                var search = searchFilter(start, end);
                if (search) {
                    return true;
                } else {
                    return false;
                }
            });

            $('#end_date').on('input', function() {
                var end = $(this).val();
                var start = $('#start_date').val();
                var search = searchFilter(start, end);
                if (search) {
                    return true;
                } else {
                    return false;
                }
            });

            searchFilter('', '')

            function searchFilter(start, end) {
                if (start == '' || end == '') {
                    return false;
                }
                if (end < start) {
                    toastr['warning']("{{ __('locale.exceptions.something_went_wrong') }}",
                        '{{ __('locale.labels.warning') }}!', {
                            closeButton: true,
                            positionClass: 'toast-top-right',
                            progressBar: true,
                            newestOnTop: true,
                            rtl: isRtl
                        });
                    return false;
                }
                dataListViewcap.columns(3).search(start + ',' + end).draw();
                return true;
            }

            // init list view datatable
            let dataListViewcap = $('.cap-datatables-basic').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('customer.reports.search.campaigns') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [
                    {
                        "data": 'id',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     "data": 'id',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        "data": "campaign_name",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "sender",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "date",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "time",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "status",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "action",
                        orderable: false,
                        searchable: false
                    },
                ],

                searchDelay: 1500,
                columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    },
                    // {
                    //     // For Checkboxes
                    //     targets: 1,
                    //     orderable: false,
                    //     responsivePriority: 3,
                    //     render: function(data) {

                    //         return (
                    //             '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="' +
                    //             data +
                    //             '" /><label class="form-check-label" for="' +
                    //             data +
                    //             '"></label></div>'
                    //         );
                    //     },
                    //     checkboxes: {
                    //         selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
                    //         selectRow: true
                    //     }
                    // },
                    {
                        targets: 2,
                        visible: true
                    },
                    {
                        targets: 3,
                        visible: true
                    },
                    {
                        // Actions
                        targets: -1,
                        title: '{{ __('locale.labels.actions') }}',
                        orderable: false,
                        render: function(data, type, full) {

                            let actions =
                                '<a href="{{ URL::to('reports/campaign/details') }}/' + full[
                                    'id'] + '"><span class="action-view text-primary pe-1">' +
                                feather.icons['eye'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</span></a>';

                            if (full['status'] != 'delivered') {
                                actions +=
                                    '<a href="{{ URL::to('reports/campaign/edit') }}/' + full[
                                        'id'] + '"><span class="action-view text-primary pe-1">' +
                                    feather.icons['edit'].toSvg({
                                        class: 'font-medium-4'
                                    }) +
                                    '</span></a>';

                                actions +=
                                    '<span class="action-delete text-danger cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title=' +
                                    full['delete'] + ' data-id=' + full['id'] + '>' +
                                    feather.icons['trash'].toSvg({
                                        class: 'font-medium-4'
                                    }) +
                                    '</span>';
                            }

                            return actions;
                        }
                    }
                ],
                // dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                // dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',

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

                                return 'Details of ' + data['uid'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            let data = $.map(columns, function(col) {
                                return col.title !==
                                    '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIdx +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/>').append('<tbody>' + data +
                                '</tbody>') : false;
                        }
                    }
                },
                // aLengthMenu: [
                //     [10, 20, 50, 100],
                //     [10, 20, 50, 100]
                // ],
                select: {
                    style: "multi"
                },
                order: [
                    [4, "desc"]
                ],
                displayLength: 10,
            });

            // On Delete
            Table1.delegate(".action-delete", "click", function(e) {
                e.stopPropagation();
                let id = $(this).data('id');
                Swal.fire({
                    title: "{{ __('locale.labels.are_you_sure') }}",
                    text: "{{ __('locale.labels.able_to_revert') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.labels.delete_it') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('/reports/campaigns') }}" + '/' + id + '/delete',
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                showResponseMessage(data);
                            },
                            error: function(reject) {
                                if (reject.status === 422) {
                                    let errors = reject.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        toastr['warning'](value[0],
                                            "{{ __('locale.labels.attention') }}", {
                                                closeButton: true,
                                                positionClass: 'toast-top-right',
                                                progressBar: true,
                                                newestOnTop: true,
                                                rtl: isRtl
                                            });
                                    });
                                } else {
                                    toastr['warning'](reject.responseJSON.message,
                                        "{{ __('locale.labels.attention') }}", {
                                            positionClass: 'toast-top-right',
                                            containerId: 'toast-top-right',
                                            progressBar: true,
                                            closeButton: true,
                                            newestOnTop: true
                                        });
                                }
                            }
                        })
                    }
                })
            });

            //Bulk Delete
            $(".bulk-delete").on('click', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: "{{ __('locale.labels.are_you_sure') }}",
                    text: "{{ __('locale.campaigns.delete_campaigns') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.labels.delete_selected') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function(result) {
                    if (result.value) {
                        let campaigns_id = [];
                        let rows_selected = dataListViewcap.column(1).checkboxes.selected();

                        $.each(rows_selected, function(index, rowId) {
                            campaigns_id.push(rowId)
                        });

                        if (campaigns_id.length > 0) {

                            $.ajax({
                                url: "{{ route('customer.reports.campaign.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    action: 'destroy',
                                    ids: campaigns_id
                                },
                                success: function(data) {
                                    showResponseMessage(data);
                                },
                                error: function(reject) {
                                    if (reject.status === 422) {
                                        let errors = reject.responseJSON.errors;
                                        $.each(errors, function(key, value) {
                                            toastr['warning'](value[0],
                                                "{{ __('locale.labels.attention') }}", {
                                                    closeButton: true,
                                                    positionClass: 'toast-top-right',
                                                    progressBar: true,
                                                    newestOnTop: true,
                                                    rtl: isRtl
                                                });
                                        });
                                    } else {
                                        toastr['warning'](reject.responseJSON.message,
                                            "{{ __('locale.labels.attention') }}", {
                                                closeButton: true,
                                                positionClass: 'toast-top-right',
                                                progressBar: true,
                                                newestOnTop: true,
                                                rtl: isRtl
                                            });
                                    }
                                }
                            })
                        } else {
                            toastr['warning']("{{ __('locale.labels.at_least_one_data') }}",
                                "{{ __('locale.labels.attention') }}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                        }

                    }
                })
            });

            // start date range
            $('#date_timepicker_start').datetimepicker({
                format: 'Y-m-d',
                onShow: function(ct) {
                    this.setOptions({
                        maxDate: $('#date_timepicker_end').val() ? $(
                            '#date_timepicker_end').val() : false
                    })
                },
                timepicker: false
            });

            $('#date_timepicker_end').datetimepicker({
                format: 'Y-m-d',
                onShow: function(ct) {
                    this.setOptions({
                        minDate: $('#date_timepicker_start').val() ? $(
                            '#date_timepicker_start').val() : false
                    })
                },

                timepicker: false
            });

            $("#searchQuickSendReport").click(function() {
                var fromDate = $("#date_timepicker_start").val()
                var toDate = $("#date_timepicker_end").val()

                console.log(fromDate, toDate)
            })

            $("#exportQuickSendReport").click(function() {
                var fromDate = $("#date_timepicker_start").val()
                var toDate = $("#date_timepicker_end").val()
                window.location.href = "{{ route('customer.reports.export.sent') }}?fromDate=" + fromDate +
                    "&toDate=" + toDate
                // window.open("https://www.w3schools.com");
                console.log(fromDate, toDate)
            })

            //show response message
            function showResponseMessage(data) {

                if (data.status === 'success') {
                    toastr['success'](data.message, '{{ __('locale.labels.success') }}!!', {
                        closeButton: true,
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        newestOnTop: true,
                        rtl: isRtl
                    });
                    dataListViewcap.draw();
                } else {
                    toastr['warning']("{{ __('locale.exceptions.something_went_wrong') }}",
                        '{{ __('locale.labels.warning') }}!', {
                            closeButton: true,
                            positionClass: 'toast-top-right',
                            progressBar: true,
                            newestOnTop: true,
                            rtl: isRtl
                        });
                }
            }
        });
        // start date range
        $('#start_date').datetimepicker({
                format: 'Y-m-d',
                onShow: function(ct) {
                    this.setOptions({
                        maxDate: $('#end_date').val() ? $(
                            '#end_date').val() : false
                    })
                },
                timepicker: false
            });

            $('#end_date').datetimepicker({
                format: 'Y-m-d',
                onShow: function(ct) {
                    this.setOptions({
                        minDate: $('#start_date').val() ? $(
                            '#start_date').val() : false
                    })
                },

                timepicker: false
            });

            // $("#searchQuickSendReport").click(function() {
            //     var fromDate = $("#start_date").val()
            //     var toDate = $("#end_date").val()

            //     console.log(fromDate, toDate)
            // })

            $("#exportcampainSendReport").click(function() {
                var fromDate = $("#start_date").val()
                var toDate = $("#end_date").val()
                // alert(fromDate);
                // alert(toDate);
                window.location.href = "{{ route('customer.reports.campaign.export') }}?fromDate=" + fromDate +
                    "&toDate=" + toDate
                // window.open("https://www.w3schools.com");
                console.log(fromDate, toDate)
            })
    </script>

@endsection
