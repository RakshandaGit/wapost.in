<!-- Basic table -->
<section id="datatables-basic-campaine" class="mt-3">
    {{-- <div class="mb-3 mt-2">
        @if (Auth::user()->customer->getOption('delete_sms_history') == 'yes')
            <div class="btn-group">
                <button class="btn btn-primary fw-bold dropdown-toggle me-1" type="button" id="bulk_actions"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('locale.labels.actions') }}
                </button>
                <div class="dropdown-menu" aria-labelledby="bulk_actions">
                    <a class="dropdown-item bulk-delete" href="#"><i data-feather="stop-circle"></i>
                        {{ __('locale.datatables.bulk_delete') }}</a>
                </div>
            </div>
        @endif
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table">
                    <tbody>
                        <tr class="d-md-table-cell d-block">
                            <td><label>From Date:</label></td>
                            <td><input type="text" class="form-control" id="start_date" placeholder="dd-mm-yyyy"
                                    name="start_date" required></td>
                        </tr>
                        <tr class="d-md-table-cell d-block">
                            <td><label>To Date:</label></td>
                            <td><input type="text" class="form-control" id="end_date" placeholder="dd-mm-yyyy"
                                    name="end_date" required></td>
                        </tr>
                        <tr class="d-md-table-cell d-block">
                            <td></td>
                            <td>
                                @if (Auth::user()->customer->getOption('list_export') == 'yes')
                                    <div class="btn-group">
                                        {{-- <a href="{{ route('customer.reports.campaign.export') }}"
                                            class="btn btn-info waves-light waves-effect fw-bold"> {{ __('locale.buttons.export') }} <i
                                                data-feather="file-text"></i></a> --}}
                                        <a href="javascript:void(0)"
                                            class="btn btn-info waves-light waves-effect fw-bold" id="exportcampainSendReport">
                                            {{ __('locale.buttons.export') }} <i data-feather="file-text"></i></a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table">
                    <tbody>
                        <tr class="d-md-table-cell d-block">
                            <td>Start Date:</td>
                            <td><input type="date" class="form-control" id="start_date" name="start_date"
                                    fdprocessedid="v6o0p"></td>
                        </tr>
                        <tr class="d-md-table-cell d-block">
                            <td>End Date:</td>
                            <td><input type="date" class="form-control" id="end_date" name="end_date"
                                    fdprocessedid="djajh3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}


    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table cap-datatables-basic">
                    <thead>
                        <tr>
                            <th></th>
                            <!-- <th></th> -->
                            <!-- <th>{{ __('locale.labels.id') }}</th> -->
                            <th> Campaign Name</th>
                            <th>{{ __('locale.labels.sender_id') }}</th>
                            <th>{{ __('locale.labels.date') }}</th>
                            <th>{{ __('locale.labels.time') }}</th>
                            <th>{{ __('locale.labels.status') }}</th>
                            <th>{{ __('locale.labels.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
