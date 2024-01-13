<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reports;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Invoices;
use App\Models\Customer;
use App\Models\PartnerTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Senderid;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "/dashboard", 'name' => __('locale.menu.Panel')],
            ['name' => Auth::user()->displayName()],
        ];

        $sms_outgoing = Reports::currentMonth()
            ->selectRaw('Day(created_at) as day, count(send_by) as outgoing,send_by')
            ->where('send_by', "from")
            ->groupBy('day')->pluck('day', 'outgoing')->flip()->sortKeys();

        $sms_incoming = Reports::currentMonth()
            ->selectRaw('Day(created_at) as day, count(send_by) as incoming,send_by')
            ->where('send_by', "to")
            ->groupBy('day')->pluck('day', 'incoming')->flip()->sortKeys();

        $sms_api = Reports::currentMonth()
            ->selectRaw('Day(created_at) as day, count(send_by) as api,send_by')
            ->where('send_by', "api")
            ->groupBy('day')->pluck('day', 'api')->flip()->sortKeys();


        $outgoing = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.outgoing'), $sms_outgoing->values()->toArray())
            ->setXAxis($sms_outgoing->keys()->toArray());


        $incoming = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.incoming'), $sms_incoming->values()->toArray())
            ->setXAxis($sms_incoming->keys()->toArray());


        $api = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.api'), $sms_api->values()->toArray())
            ->setXAxis($sms_api->keys()->toArray());


        $revenue = Invoices::CurrentMonth()
            ->selectRaw('Day(created_at) as day, sum(amount) as revenue')
            ->groupBy('day')
            ->pluck('revenue', 'day');

        $revenue_chart = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.revenue'), $revenue->values()->toArray())
            ->setXAxis($revenue->keys()->toArray());

        $customers = Customer::thisYear()
            ->selectRaw('DATE_FORMAT(created_at, "%m-%Y") as month, count(uid) as customer')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('customer', 'month');


        $customer_growth = (new LarapexChart)->barChart()
            ->addData(__('locale.labels.customers_growth'), $customers->values()->toArray())
            ->setXAxis($customers->keys()->toArray());

        $sms_history = (new LarapexChart)->pieChart()
            ->addData([
                Reports::where('status', 'like', "%Delivered%")->count(),
                Reports::where('status', 'not like', "%Delivered%")->count(),
            ]);

        $sender_ids = Senderid::where('status', 'pending')->latest()->take(10)->cursor();

        $user = Auth::user();
        $pendingTransaction = PartnerTransaction::where(['user_id' => $user->id, 'status' => 'pending'])->orderBy('id', 'desc')->first();
        $availableTransaction = PartnerTransaction::where(['user_id' => $user->id, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        // $requestedBalance = $pendingTransaction ? $pendingTransaction->credit : 0;
        $availableBalance =  $availableTransaction ? $availableTransaction->balance : 0;
        $totalUser = User::where('parent_id', $user->id)->count();

        return view('partner.dashboard', compact('breadcrumbs', 'sms_incoming', 'sms_outgoing', 'outgoing', 'incoming', 'revenue_chart', 'customer_growth', 'sms_history', 'sender_ids', 'sms_api', 'api', 'availableBalance', 'totalUser'));
    }
}
