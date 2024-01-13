@extends('layouts/contentLayoutMaster')

@section('title', __('locale.menu.Customers'))

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
        <div class="mb-3 mt-2">
            @can('view customer')
                <div class="btn-group">
                    <button class="btn btn-primary fw-bold dropdown-toggle" type="button" id="bulk_actions"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('locale.labels.actions') }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="bulk_actions">
                        <a class="dropdown-item bulk-enable" href="#"><i data-feather="check"></i>
                            {{ __('locale.datatables.bulk_enable') }}</a>
                        <a class="dropdown-item bulk-disable" href="#"><i data-feather="stop-circle"></i>
                            {{ __('locale.datatables.bulk_disable') }}</a>
                    </div>
                </div>
            @endcan

            @can('create customer')
                <div class="btn-group">
                    <a href="{{ route('admin.customers.create') }}"
                        class="btn btn-success waves-light waves-effect fw-bold mx-1"> {{ __('locale.buttons.add_new') }} <i
                            data-feather="plus-circle"></i></a>
                </div>
            @endcan

            @can('view customer')
                <div class="btn-group">
                    <a href="{{ route('admin.customers.export') }}" class="btn btn-info waves-light waves-effect fw-bold">
                        {{ __('locale.buttons.export') }} <i data-feather="file-text"></i></a>
                </div>
            @endcan

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="table datatables-basic">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>{{ __('locale.labels.id') }}</th>
                                <th>{{ __('locale.labels.name') }} </th>
                                <th>{{ __('locale.labels.current_plan') }}</th>
                                <th>{{ __('Expiry Date') }} </th>
                                <th>{{ __('Available Balance') }} </th>
                                <th>{{ __('locale.labels.status') }}</th>
                                <th>{{ __('locale.labels.actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-12">
                <h2 class="mb-2">Partner Inquiry</h2>
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
        </div> --}}
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
                    dataListView.draw();
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

            // init table dom
            let Table = $("table");

            // init list view datatable
            let dataListView = $('.datatables-basic').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.customers.search') }}",
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
                        "data": "uid"
                    },
                    {
                        "data": "uid"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "subscription",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "expiry_date",
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "available_balance",
                        orderable: false,
                        searchable: false
                    },
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
                            return (
                                '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="' +
                                data +
                                '" /><label class="form-check-label" for="' +
                                data +
                                '"></label></div>'
                            );
                        },
                        checkboxes: {
                            selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
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
                        render: function(data, type, full) {
                            var $user_img = full['avatar'],
                                $name = full['name'],
                                $created_at = full['created_at'],
                                $email = full['email'];
                            if ($user_img) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + $user_img +
                                    '" alt="Avatar" width="32" height="32">';
                            } else {
                                // For Avatar badge
                                var stateNum = full['status'];
                                var states = ['success', 'danger', 'warning', 'info', 'dark',
                                    'primary', 'secondary'
                                ];
                                var $state = states[stateNum],
                                    $name = full['name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() || ''))
                                    .toUpperCase();
                                $output = '<span class="avatar-content">' + $initials + '</span>';
                            }

                            var colorClass = $user_img === '' ? ' bg-light-' + $state + ' ' : '';
                            // Creates full output for row
                            // full['is_pos_user'] 
                            return '<div class="d-flex justify-content-left align-items-center">' +
                                '<div class="avatar ' +
                                colorClass +
                                ' me-1">' +
                                $output +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<span class="emp_name text-truncate fw-bold">' +
                                $name + (full['is_enterprise'] == 1 ?
                                    ' <span class="text-danger"> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAACXBIWXMAAAsTAAALEwEAmpwYAAAByElEQVR4nKWU7ytkYRTHb1bU+hHt/mFSkxcUyfNkbUOZ/CgxxUsvGLvxnMva8aPUUH6MQsYbxrtRKEq8ULitZUbWYmPMV/eZabruPHOtnDp1O+d5Pn3Pee45mqaw2hEUcYEKLiC4QJATFjlhmAtUfRlEqfaaeb3I5QItjBDjBChd4A8jdLkCyFNC3D4Uc4HlrADK8A1O+PwC4grgQ0r+/0KQUrfp9iE/DeICzdkON/uf0D756ATslpCqcRQwwmW2g/rKLSbWbpxU/ZUlcoFyJ/nhnSgi+xeOJTJCrcYJPmuwdTyOtsmkd0494uTUwJlhoCfwkI63TcTtoDFT0Yw12B14wN7ROQzDUPrh8S/0zv2zg0IaI0zbpTaOJrAaucqAhHcv4fHHVX1aNRX1q+p2/0jIsgwLyDOmgCTdb/aoTJUcCN7Jy3uH59g++C2/R1ZulaA6HTUm6CMnXNiToUgMoa0YGkef0DCcwOzmNcK7UdWL3Xz9hk/yX2KEJmuyXjcV3Wdc6pu/l1Bbf7zWYc1JTfn7RkRLDS0jLL0Bsp4uyW5yeM25E4g6AMw10pF1jVit4TsKOcHFCEOMsCA3g4Bep6Oy+idKVJeeASbbKn3LY2drAAAAAElFTkSuQmCC"> </span>' :
                                    '') +
                                 " " + (full['is_pos_user'] == 1 ?
                                    ' <span class="text-danger"> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAAACXBIWXMAAAsTAAALEwEAmpwYAAABf0lEQVR4nO2UzUrDQBDH41EPirVtZppaUehJ9DH8figFhaLoA/TsQ+ipNbMJirUPoMXPk6DWa5iFlW2sJmkbE9ubDixhd//89j+T2TWM/xgmlA05VbfKqobZkQGZcJ8FPEiBqjuY8J4FVNRFYeZXYBawwQLaQWh0sIA3dnA1HZhgnQXKOPD3AcgscCVZKWqY7eeYBTwqMVtggqeePYIX5RYzScpR6euQcNvPCncG7O8mgONt0K0kcCTBqSIsdTIjLEmCE72uf2zA/U18SdxiJuhGnZnzsXoH5kL688zkYHHdKofSJWh2Hfdo/QyaITjlFxI7l34tn5VbHA/pGjih16Na1Zieii0NE95FuuR6gK4VMdGKBffrFiao6nXPtpaZ4Nhz80s+HKoR3V76Pie8ZMIjJvA+IZ6eSwFXAfBroj7vuHLMzRQ3VLINa4nAXwfY5hYTvv/wtrT1U5EK3A3lmHkmPIxeeX25WODBSJ5fpYwxVcuBR+ai/ur50FDjz8YH36LwrYWnzoEAAAAASUVORK5CYII="> </span>' :
                                    '') +
                                '</span>' +
                                '<small class="emp_post text-truncate text-muted">' +
                                $email +
                                '</small>' +
                                '<small class="emp_post text-truncate text-muted">' +
                                $created_at +
                                '</small>' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        title: '{{ __('locale.labels.actions') }}',
                        orderable: false,
                        render: function(data, type, full) {
                            var $super_user = '';

                            if (full['super_user'] === false) {
                                $super_user =
                                    '<span class="action-delete text-danger pe-1 cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title=' +
                                    full['delete_label'] + ' data-id=' + full['delete'] + '>' +
                                    feather.icons['trash'].toSvg({
                                        class: 'font-medium-4'
                                    }) +
                                    '</span>';
                            }
                            return (
                                $super_user +

                                '<a href="' + full['show'] +
                                '" class="text-primary pe-1" data-bs-toggle="tooltip" data-bs-placement="top" title=' +
                                full['show_label'] + '>' +
                                feather.icons['edit'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</a>' +
                                '<a href="' + full['assign_plan'] +
                                '" class="text-info pe-1" data-bs-toggle="tooltip" data-bs-placement="top" title="' +
                                full['assign_plan_label'] + '">' +
                                feather.icons['shopping-cart'].toSvg({
                                    class: 'font-medium-4'
                                }) +
                                '</a>' +
                                '<a href="' + full['login_as'] +
                                '" class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="' +
                                full['login_as_label'] + '">' +
                                feather.icons['log-in'].toSvg({
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


            Table.delegate(".get_status", "click", function() {
                let customer = $(this).data('id');
                $.ajax({
                    url: "{{ url(config('app.admin_path') . '/customers') }}" + '/' + customer +
                        '/active',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        showResponseMessage(data);
                    }
                });
            });

            // On Delete
            Table.delegate(".action-delete", "click", function(e) {
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
                            url: "{{ url(config('app.admin_path') . '/customers') }}" +
                                '/' +
                                id,
                            type: "POST",
                            data: {
                                _method: 'DELETE',
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


            //Bulk Enable
            $(".bulk-enable").on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "{{ __('locale.labels.are_you_sure') }}",
                    text: "{{ __('locale.customer.customers_enabled') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.labels.enable_selected') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,

                }).then(function(result) {
                    if (result.value) {
                        let customer_ids = [];
                        let rows_selected = dataListView.column(1).checkboxes.selected();

                        $.each(rows_selected, function(index, rowId) {
                            customer_ids.push(rowId)
                        });

                        if (customer_ids.length > 0) {

                            $.ajax({
                                url: "{{ route('admin.customers.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    action: 'enable',
                                    ids: customer_ids
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

            //Bulk disable
            $(".bulk-disable").on('click', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: "{{ __('locale.labels.are_you_sure') }}",
                    text: "{{ __('locale.customer.disable_customers') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "{{ __('locale.labels.disable_selected') }}",
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false,
                }).then(function(result) {
                    if (result.value) {
                        let customer_ids = [];
                        let rows_selected = dataListView.column(1).checkboxes.selected();

                        $.each(rows_selected, function(index, rowId) {
                            customer_ids.push(rowId)
                        });

                        if (customer_ids.length > 0) {

                            $.ajax({
                                url: "{{ route('admin.customers.batch_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    action: 'disable',
                                    ids: customer_ids
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
        });
    </script>
@endsection
