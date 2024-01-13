<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Include DataTables and Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Include Responsive DataTables and Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

</head>

<body>
    <table id="example" class="table table-striped nowrap" style="width:100%">
        <thead>
            <tr>
                <th>{{ __('locale.labels.name') }} </th>
                <th>{{ __('locale.labels.phone') }} </th>
                <th>{{ __('locale.labels.email') }} </th>
                <th>{{ __('locale.labels.current_plan') }}</th>
                <th>{{ __('Expiry Date') }} </th>
                <th>{{ __('Available Balance') }} </th>
                <th>{{ __('locale.labels.status') }}</th>
            </tr>
        </thead>
        <tbody>
            <h3>Monitor Customer</h3>
            @foreach ($users as $user)
                @php
                    if (isset($user->customer) && $user->customer->currentPlanName()) {
                        $subscription = $user->customer->currentPlanName();
                    } else {
                        $subscription = __('locale.subscription.no_active_subscription');
                    }
                    $isPOSUser = $user->parent_id != 0;

                    $availableBalance = $user->availableMessage ? $user->availableMessage?->balance : 0;
                @endphp

                <tr>
                    <td>{{ $user->first_name . ' ' . $user->last_name }}

                        @if ($isPOSUser)
                            {{-- @php
                                $parent = \App\Models\User::find($user->parent_id);
                            @endphp
                            {{ $parent->first_name . ' ' . $parent->last_name }} --}}
                            <b>(POS User)</b>
                        @elseif($user->is_enterprise)
                            <b>(Partner)</b>
                        @else
                            <b>(WAPost User)</b>
                        @endif

                    </td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_enterprise || $isPOSUser ? '-' : $subscription }}</td>
                    <td>
                        @if ($user->customer->subscription?->current_period_ends_at && !$isPOSUser)
                            {{ !$user->is_enterprise ? date('Y-m-d', strtotime($user->customer->subscription->current_period_ends_at)) : '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $user->is_enterprise ? $availableBalance : '-' }}</td>
                    <td>{{ $user->status == 1 ? 'active' : 'inactive' }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <!-- Add DataTables script -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Add DataTables Buttons script -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });
        });
    </script>
</body>

</html>
