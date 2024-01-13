@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Leads'))

@section('content')
    <style>
        div#DataTables_Table_0_filter {
            text-align: right;
        }

        input.form-control {
            display: inline-block;
            width: auto;
        }
    </style>
    <!-- Basic table -->
    <section id="datatables-basic-admin">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table">
                        <tbody>
                            <tr class="d-table-cell">
                                <td><label>From Date:</label></td>
                                <td><input type="text" id="date_timepicker_start" class="form-control" id="start_date" placeholder="dd-mm-yyyy" name="start_date"
                                    required></td>
                            </tr>
                            <tr class="d-table-cell">
                                <td><label>To Date:</label></td>
                                <td><input type="text" id="date_timepicker_end" class="form-control" id="end_date" placeholder="dd-mm-yyyy" name="end_date"
                                    required></td>
                            </tr>
                            <tr class="d-table-cell">
                                <td></td>
                                <td>
                                    @can('view_contact_group')
                                        <div class="btn-group">
                                            <a href="{{route('customer.contacts.export')}}" class="btn btn-info waves-light waves-effect fw-bold mx-1" id="fetchregdata"> {{__('locale.buttons.export')}} <i data-feather="file-text"></i></a>
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table datatables-basic-admin">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{ __('locale.labels.id') }}</th>
                            <th>{{__('locale.labels.name')}} </th>
                            <th>{{__('locale.menu.Contacts')}}</th>
                            <th>{{__('locale.labels.email')}}</th>
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
        
        $(document).ready(function () {
            "use strict"

            //show response message
            function showResponseMessage(data) {

                if (data.status === 'success') {
                    toastr['success'](data.message, '{{__('locale.labels.success')}}!!', {
                        closeButton: true,
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        newestOnTop: true,
                        rtl: isRtl
                    });
                    dataListView.draw();
                } else {
                    toastr['warning']("{{__('locale.exceptions.something_went_wrong')}}", '{{ __('locale.labels.warning') }}!', {
                        closeButton: true,
                        positionClass: 'toast-top-right',
                        progressBar: true,
                        newestOnTop: true,
                        rtl: isRtl
                    });
                }
            }

            // init table dom
            let Table = $("table");
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

            let div = $("div");
            
            // On Pause
            div.delegate(".action-pause", "click", function (e) { 
                e.stopPropagation();
                if($(' .dt-checkboxes').is(":checked"))
                {
                    var str = '';
                    $(' .dt-checkboxes').filter(function(){
                        if($(this).is(':checked'))
                        {
                           str += $(this).attr('id')+',';      
                        }
                    });
                    window.location.href = "{{route('customer.contact.group_message')}}?contacts="+str;
                }else{
                    Swal.fire({
                        title: "{{ __('Please Select One Or More Contacts') }}",
                        text: "{{ __('You would not be able to send group messages!') }}",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonText: "{{ __('Ok') }}",
                        customClass: {
                            confirmButton: 'btn btn-danger',
                        },
                        buttonsStyling: false,
                    }).then(function (result) {
                        if (result.value) {}
                    })
                }
            });
            // init list view datatable
            let dataListView = $('.datatables-basic-admin').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('customer.contacts.search') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": 'responsive_id', orderable: false, searchable: false},
                    {"data": "uid"},
                    {"data": "uid"},
                    {"data": "name"},
                    {"data": "contacts", orderable: false, searchable: false},
                    {"data": "created_at"},
                    {"data": "status"},
                    {"data": "action", orderable: false, searchable: false}
                ],

                searchDelay: 1500,
                columnDefs: [
                    {
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
                        render: function (data) {
                            return (
                                '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="' +
                                data +
                                '" /><label class="form-check-label" for="' +
                                data +
                                '"></label></div>'
                            );
                        },
                        checkboxes: {
                            selectAllRender:
                                '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
                            selectRow: true
                        }
                    },
                    {
                        targets: 2,
                        visible: false
                    },
                    {
                        // Avatar image/badge, Name and post
                        targets: 3,
                        responsivePriority: 1,
                        render: function (data, type, full) {
                            return (
                                '<a href="' + full['show'] + '">' + full['name'] + '</a>'
                            );
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        title: '{{ __('locale.labels.actions') }}',
                        orderable: false,
                        render: function (data, type, full) {

                            let $actions = '';

                            if(full['can_create']){
                                $actions += '<a href="' + full['new_contact'] + '" class="text-info me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="' + full['new_contact_label'] + '">' +
                                    feather.icons['plus-circle'].toSvg({class: 'font-medium-4'}) +
                                    '</a>';
                            }

                            if(full['can_update']){
                                $actions += '<a href="' + full['show'] + '" class="text-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" title=' + full['show_label'] + '>' +
                                    feather.icons['edit'].toSvg({class: 'font-medium-4'}) +
                                    '</a>';
                            }

                            if(full['can_delete']){
                                $actions +='<span class="action-delete text-danger cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title=' + full['delete'] + ' data-id=' + full['uid'] + '>' +
                                    feather.icons['trash'].toSvg({class: 'font-medium-4'}) +
                                    '</span>';
                            }

                            return (
                                '<span class="action-copy text-success me-1" data-value='+full['name']+' data-bs-toggle="tooltip" data-bs-placement="top" title=' + full['copy'] + ' data-id=' + full['uid'] + '>' +
                                feather.icons['copy'].toSvg({class: 'font-medium-4'}) +
                                '</span>' + $actions
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
                            header: function (row) {
                                let data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            let data = $.map(columns, function (col) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ? '<tr data-dt-row="' +
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
                                    '</tr>'
                                    : '';
                            }).join('');

                            return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                        }
                    }
                },
                aLengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                select: {
                    style: "multi"
                },
                order: [[2, "desc"]],
                displayLength: 10,
            });


            Table.delegate(".get_status", "click", function () {
                let group_id = $(this).data('id');
                $.ajax({
                    url: "{{ url('contacts')}}" + '/' + group_id + '/active',
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        showResponseMessage(data);
                    }
                });
            });

            // On copy
            Table.delegate(".action-copy", "click", function (e) {
                e.stopPropagation();
                let id = $(this).data('id');
                let group_name = $(this).data('value')
                Swal.fire({
                    title: "{{ __('locale.contacts.new_contact_group') }}",
                    text: "{{ __('locale.contacts.what_would_you_like_to_name_your_group') }}",
                    input: 'text',
                    inputValue: 'Copy of ' + group_name,
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    cancelButtonText:"{{ __('locale.buttons.cancel') }}",
                    cancelButtonAriaLabel: "{{ __('locale.buttons.cancel') }}",
                    confirmButtonText: feather.icons['copy'].toSvg({ class: 'font-medium-1 me-50' }) + "{{ __('locale.labels.copy') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('contacts')}}" + '/' + id + '/copy',
                            type: "POST",
                            data: {
                                _method: 'POST',
                                group_name: result.value,
                                _token: "{{csrf_token()}}"
                            },
                            success: function (data) {
                                showResponseMessage(data);
                            },
                            error: function (reject) {
                                if (reject.status === 422) {
                                    let errors = reject.responseJSON.errors;
                                    $.each(errors, function (key, value) {
                                        toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                            closeButton: true,
                                            positionClass: 'toast-top-right',
                                            progressBar: true,
                                            newestOnTop: true,
                                            rtl: isRtl
                                        });
                                    });
                                } else {
                                    toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
                                        closeButton: true,
                                        positionClass: 'toast-top-right',
                                        progressBar: true,
                                        newestOnTop: true,
                                        rtl: isRtl
                                    });
                                }
                            }
                        })
                    }
                })
            });

            // On Delete
            Table.delegate(".action-delete", "click", function (e) {
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
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('contacts')}}" + '/' + id,
                            type: "POST",
                            data: {
                                _method: 'DELETE',
                                _token: "{{csrf_token()}}"
                            },
                            success: function (data) {
                                showResponseMessage(data);
                            },
                            error: function (reject) {
                                if (reject.status === 422) {
                                    let errors = reject.responseJSON.errors;
                                    $.each(errors, function (key, value) {
                                        toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                            closeButton: true,
                                            positionClass: 'toast-top-right',
                                            progressBar: true,
                                            newestOnTop: true,
                                            rtl: isRtl
                                        });
                                    });
                                } else {
                                    toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
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


            //Bulk Enable
            $(".bulk-enable").on('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "{{__('locale.labels.are_you_sure')}}",
                    text: "{{__('locale.contacts.enable_contact_groups')}}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{__('locale.labels.enable_selected')}}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,

                }).then(function (result) {
                    if (result.value) {
                        let group_ids = [];
                        let rows_selected = dataListView.column(1).checkboxes.selected();

                        $.each(rows_selected, function (index, rowId) {
                            group_ids.push(rowId)
                        });

                        if (group_ids.length > 0) {

                            $.ajax({
                                url: "{{ route('customer.contacts.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{csrf_token()}}",
                                    action: 'enable',
                                    ids: group_ids
                                },
                                success: function (data) {
                                    showResponseMessage(data);
                                },
                                error: function (reject) {
                                    if (reject.status === 422) {
                                        let errors = reject.responseJSON.errors;
                                        $.each(errors, function (key, value) {
                                            toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                                closeButton: true,
                                                positionClass: 'toast-top-right',
                                                progressBar: true,
                                                newestOnTop: true,
                                                rtl: isRtl
                                            });
                                        });
                                    } else {
                                        toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
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
                            toastr['warning']("{{ __('locale.labels.at_least_one_data') }}", "{{ __('locale.labels.attention') }}", {
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

            //Bulk disable
            $(".bulk-disable").on('click', function (e) {

                e.preventDefault();

                Swal.fire({
                    title: "{{__('locale.labels.are_you_sure')}}",
                    text: "{{__('locale.contacts.disable_contact_groups')}}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{__('locale.labels.disable_selected')}}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        let group_ids = [];
                        let rows_selected = dataListView.column(1).checkboxes.selected();

                        $.each(rows_selected, function (index, rowId) {
                            group_ids.push(rowId)
                        });

                        if (group_ids.length > 0) {

                            $.ajax({
                                url: "{{ route('customer.contacts.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{csrf_token()}}",
                                    action: 'disable',
                                    ids: group_ids
                                },
                                success: function (data) {
                                    showResponseMessage(data);
                                },
                                error: function (reject) {
                                    if (reject.status === 422) {
                                        let errors = reject.responseJSON.errors;
                                        $.each(errors, function (key, value) {
                                            toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                                closeButton: true,
                                                positionClass: 'toast-top-right',
                                                progressBar: true,
                                                newestOnTop: true,
                                                rtl: isRtl
                                            });
                                        });
                                    } else {
                                        toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
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
                            toastr['warning']("{{__('locale.labels.at_least_one_data')}}", "{{__('locale.labels.attention')}}", {
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


            //Bulk Delete
            $(".bulk-delete").on('click', function (e) {

                e.preventDefault();

                Swal.fire({
                    title: "{{__('locale.labels.are_you_sure')}}",
                    text: "{{__('locale.contacts.delete_contact_groups')}}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{__('locale.labels.delete_selected')}}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        let group_ids = [];
                        let rows_selected = dataListView.column(1).checkboxes.selected();

                        $.each(rows_selected, function (index, rowId) {
                            group_ids.push(rowId)
                        });

                        if (group_ids.length > 0) {

                            $.ajax({
                                url: "{{ route('customer.contacts.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{csrf_token()}}",
                                    action: 'destroy',
                                    ids: group_ids
                                },
                                success: function (data) {
                                    showResponseMessage(data);
                                },
                                error: function (reject) {
                                    if (reject.status === 422) {
                                        let errors = reject.responseJSON.errors;
                                        $.each(errors, function (key, value) {
                                            toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                                closeButton: true,
                                                positionClass: 'toast-top-right',
                                                progressBar: true,
                                                newestOnTop: true,
                                                rtl: isRtl
                                            });
                                        });
                                    } else {
                                        toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
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
                            toastr['warning']("{{__('locale.labels.at_least_one_data')}}", "{{__('locale.labels.attention')}}", {
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

            $("#fetchregdata").click(function() {
                var fromDate = $("#date_timepicker_start").val()
                var toDate = $("#date_timepicker_end").val()
                window.location.href = "{{ route('customer.reports.export.sent') }}?fromDate="+fromDate+"&toDate="+toDate
                // window.open("https://www.w3schools.com");
                console.log(fromDate, toDate)
            })
            // fetch successfully
            $(".fetch-group").on('click', function (e) {

                e.preventDefault();

                $.ajax({
                    url: "{{route('customer.fetch_group')}}",
                    type: "GET",
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    success: function (data) {
                        showResponseMessage(data);
                    },
                    error: function (reject) {
                        if (reject.status === 422) {
                            let errors = reject.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                            });
                        } else {
                            toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
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

        });
        
    </script>
@endsection
