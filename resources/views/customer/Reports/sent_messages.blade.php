<!-- Basic table -->
<section id="datatables-basic" class="mt-3">
    <div class="mb-3 mt-2">
        {{-- @if (Auth::user()->customer->getOption('delete_sms_history') == 'yes')
            <div class="btn-group">
                <button class="btn btn-primary fw-bold dropdown-toggle me-1" type="button" id="bulk_actions"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('locale.labels.actions') }}
                </button>
                <div class="dropdown-menu" aria-labelledby="bulk_actions">
                    <a class="dropdown-item bulk-delete" href="#"><i data-feather="trash"></i>
                        {{ __('locale.datatables.bulk_delete') }}</a>
                </div>
            </div>
        @endif --}}


    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table">
                    <tbody>
                        <tr class="d-md-table-cell d-block">
                            <td><label>From Date:</label></td>
                            <td><input type="text" id="date_timepicker_start" class="form-control" id="start_date" placeholder="dd-mm-yyyy" name="start_date"
                                required></td>
                        </tr>
                        <tr class="d-md-table-cell d-block">
                            <td><label>To Date:</label></td>
                            <td><input type="text" id="date_timepicker_end" class="form-control" id="end_date" placeholder="dd-mm-yyyy" name="end_date"
                                required></td>
                        </tr>
                        <tr class="d-md-table-cell d-block">
                            <td></td>
                            <td>
                                {{-- <button class="btn btn-info waves-light waves-effect fw-bold" id="searchQuickSendReport" disabled>
                                Search
                                    <i data-feather="search-text"></i>
                                </button> --}}
                                @if (Auth::user()->customer->getOption('list_export') == 'yes')
                                    {{-- <a href="{{ route('customer.reports.export.sent') }}"
                                        class="btn btn-info waves-light waves-effect fw-bold">
                                        {{ __('locale.buttons.export') }}
                                        <i data-feather="file-text"></i>
                                    </a> --}}
                
                                    <button class="btn btn-info waves-light waves-effect fw-bold" id="exportQuickSendReport">
                                        {{ __('locale.buttons.export') }}
                                        <i data-feather="file-text"></i>
                                    </button>
                                @endif
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
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ __('locale.labels.date') . '' . __('locale.labels.time') }}</th>
                            <th>{{ __('locale.labels.from') }}</th>
                            <th>{{ __('locale.labels.to') }}</th>
                            <!-- <th>{{ __('locale.labels.type') }} </th> -->
                            <!-- <th>{{ __('locale.labels.cost') }}</th> -->
                            <th>{{ __('locale.labels.status') }}</th>
                            <th>{{ __('locale.labels.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<!--/ Basic table -->
