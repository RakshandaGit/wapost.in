<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Library\SMSCounter;
use App\Library\Tool;
use App\Models\Campaigns;
use App\Models\CampaignsList;
use App\Models\CampaignsSenderid;
use App\Models\ContactGroups;
use App\Models\PhoneNumbers;
use App\Models\PlansCoverageCountries;
use App\Models\Reports;
use App\Models\Senderid;
use App\Models\Templates;
use App\Models\TemplateTags;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Carbon\Carbon;
use Exception;
use Generator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Helpers\Api;
use Illuminate\Contracts\Auth\Guard;


class ReportsController extends Controller
{
    /**
     * sms reports
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function reports(Request $request)
    {
        /** check Status Of Scheduled Message */
        Api::checkStatusScheduleMsg();

        $this->authorize('view_reports');
        $recipient = $request->recipient;
        if ($recipient) {
            $title = __('locale.contacts.conversion_with', ['recipient' => $recipient]);
            $name  = __('locale.contacts.view_conversion');
        } else {
            $title = __('locale.menu.Reports');
            $name  = __('locale.menu.Reports');
        }

        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Reports')],
            ['name' => __('locale.labels.all')],
        ];


        return view('customer.Reports.all_messages', compact('breadcrumbs', 'recipient', 'title'));
    }

    /**
     * get all message reports
     *
     * @param  Request  $request
     *
     * @throws AuthorizationException
     */
    #[NoReturn] public function searchAllMessages(Request $request)
    {

        $this->authorize('view_reports');

        $columns = [
            0 => 'responsive_id',
            1 => 'uid',
            2 => 'uid',
            3 => 'created_at',
            4 => 'send_by',
            5 => 'type',
            6 => 'from',
            7 => 'to',
            8 => 'message',
            9 => 'status',
        ];

        $totalData = Reports::where('user_id', auth()->user()->id)->count();

        $totalFiltered = $totalData;

        $limit     = $request->input('length');
        $start     = $request->input('start');
        $order     = $columns[$request->input('order.0.column')];
        $dir       = $request->input('order.0.dir');
        $recipient = $request->get('recipient');

        if (empty($request->input('search.value')) && empty($recipient)) {

            $sms_reports = Reports::where('user_id', auth()->user()->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } elseif ($recipient != null) {
            $sms_reports = Reports::where('user_id', auth()->user()->id)
                ->where('to', $recipient)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sms_reports = Reports::where('user_id', auth()->user()->id)->whereLike(['uid', 'send_by', 'type', 'from', 'to', 'messsage', 'status', 'created_at'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = \App\Models\WpMessage::where('user_id', auth()->user()->id)->whereLike(['uid', 'send_by', 'type', 'from', 'to', 'message', 'status', 'created_at'], $search)->count();
        }

        $data = [];
        if (!empty($sms_reports)) {
            foreach ($sms_reports as $report) {
                if ($report->created_at == null) {
                    $created_at = null;
                } else {
                    $created_at = Tool::customerDateTime($report->created_at);
                }
                $to = '';
                if ($report->type == 'campaign') {
                    foreach ($report->campaign->contactList as $key => $val) {
                        foreach ($val->contactGroups->subscribers as $key1 => $val1) {
                            $to = (empty($key1)) ? $val1->phone : $to . ',' . $val1->phone;
                        }
                    }
                } else {
                    $to = $report->to;
                }
                $msg = json_decode($report->message);

                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $report->uid;
                $nestedData['created_at']    = $created_at;
                $nestedData['send_by']       = ""; //$report->getSendBy();
                $nestedData['type']          = ($report->type == 'campaign' && $report->sub_type == 'immediate') ? "Quick (" . ucfirst($report->sub_type) . ")" : ucfirst($report->type) . " (" . ucfirst($report->sub_type) . ")";
                $nestedData['from']          = $report->from; //explode('@',$msg->key->remoteJid)[0];
                $nestedData['to']            = $to;
                $nestedData['message']       = ""; //($report->type == 'campaign')?$report->message:"<button>Preview</button>";//$msg->message; 
                $nestedData['status']        = str_limit($report->status, 20);
                // $nestedData['action']        = "";
                $data[]                      = $nestedData;
            }
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ];

        echo json_encode($json_data);
        exit();
    }

    /**
     * view single reports
     *
     * @param  Reports  $uid
     *
     * @return JsonResponse
     */
    public function viewReports(Reports $uid): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $uid,
        ]);
    }

    /**
     * @param  Reports  $uid
     *
     * @return JsonResponse
     * @throws Exception
     */

    public function destroy(Reports $uid): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }


        if (!$uid->delete()) {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => __('locale.campaigns.sms_was_successfully_deleted'),
        ]);
    }

    /**
     * bulk sms delete
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function batchAction(Request $request): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $ids = $request->get('ids');

        if (Reports::whereIn('uid', $ids)->where('user_id', auth()->user()->id)->delete()) {
            return response()->json([
                'status'  => 'success',
                'message' => __('locale.campaigns.sms_was_successfully_deleted'),
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    /**
     * sms received
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function received()
    {
        $this->authorize('view_reports');

        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Reports')],
            ['name' => __('locale.menu.Received Messages')],
        ];

        return view('customer.Reports.received_messages', compact('breadcrumbs'));
    }


    /**
     * get all received reports
     *
     * @param  Request  $request
     *
     * @throws AuthorizationException
     */
    #[NoReturn] public function searchReceivedMessage(Request $request)
    {
        $this->authorize('view_reports');

        $columns = [
            0 => 'responsive_id',
            1 => 'uid',
            2 => 'uid',
            3 => 'created_at',
            5 => 'type',
            6 => 'from',
            7 => 'to',
            8 => 'message',
            9 => 'status',
        ];

        $totalData = Reports::where('user_id', auth()->user()->id)->where('send_by', 'to')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sms_reports = Reports::where('user_id', auth()->user()->id)->where('send_by', 'to')->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sms_reports = Reports::where('user_id', auth()->user()->id)->where('send_by', 'to')->whereLike(['uid', 'type', 'from', 'to', 'message', 'status', 'created_at'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Reports::where('user_id', auth()->user()->id)->where('send_by', 'to')->whereLike(['uid', 'type', 'from', 'to', 'message', 'status', 'created_at'], $search)->count();
        }

        $data = [];
        if (!empty($sms_reports)) {
            foreach ($sms_reports as $report) {
                if ($report->created_at == null) {
                    $created_at = null;
                } else {
                    $created_at = Tool::customerDateTime($report->created_at);
                }

                $msg = json_decode($report->message);
                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $report->uid;
                $nestedData['created_at']    = $created_at;
                $nestedData['send_by']       = $report->getSendBy();
                $nestedData['type']          = $report->type;
                $nestedData['from']          = $report->from; //explode('@',$msg->key->remoteJid)[0];
                $nestedData['to']            = $report->to;
                $nestedData['message']       = ($report->type == 'campaign') ? $report->message : $msg->message;
                $nestedData['status']        = str_limit($report->status, 20);
                $data[]                      = $nestedData;

                // $nestedData['responsive_id'] = '';
                // $nestedData['uid']           = $report->uid;
                // $nestedData['created_at']    = $created_at;
                // $nestedData['sms_type']      = $report->getSMSType();
                // $nestedData['from']          = $report->from;
                // $nestedData['to']            = $report->to;
                // $nestedData['message']       = $report->cost;
                // $nestedData['status']        = str_limit($report->status, 20);
                // $data[]                      = $nestedData;

            }
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ];

        echo json_encode($json_data);
        exit();
    }

    /**
     * sms sent
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function sent()
    {
        /** check Status Of Scheduled Message */
        Api::checkStatusScheduleMsg();

        $this->authorize('view_reports');

        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Reports')],
            ['name' => __('locale.menu.Sent Messages')],
        ];

        return view('customer.Reports.sent_messages', compact('breadcrumbs'));
    }


    /**
     * get all sent reports
     *
     * @param  Request  $request
     *
     * @throws AuthorizationException
     */
    #[NoReturn] public function searchSentMessage(Request $request)
    {
        $this->authorize('view_reports');

        $columns = [
            0 => 'responsive_id',
            1 => 'uid',
            2 => 'uid',
            // 5 => 'type',
            3 => 'created_at',
            4 => 'from',
            5 => 'to',
            8 => 'cost',
            9 => 'status',
        ];

        $totalData = Reports::where('user_id', auth()->user()->id)->where('type', 'quick')
            // ->orWhere('sub_type', 'immediate')
            ->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sms_reports = Reports::where('user_id', auth()->user()->id)
                ->where('type', 'quick')
                // ->orWhere('sub_type', 'immediate')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sms_reports = Reports::where('user_id', auth()->user()->id)
                ->where('type', 'quick')
                // ->orWhere('sub_type', 'immediate')
                ->whereLike(['uid', 'type', 'from', 'to', 'cost', 'status', 'created_at'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Reports::where('user_id', auth()->user()->id)
                ->where('type', 'quick')
                // ->orWhere('sub_type', 'immediate')
                ->whereLike(['uid', 'type', 'from', 'to', 'cost', 'status', 'created_at'], $search)
                ->count();
        }



        $data = [];
        if (!empty($sms_reports)) {

            foreach ($sms_reports as $report) {
                if ($report->created_at == null) {
                    $created_at = null;
                } else {
                    // $created_at = Tool::customerDateTime($report->created_at);
                    $created_at = date('Y-m-d h:i A', strtotime(($report->created_at)));
                }
                if ($report->type == 'campaign') {
                    foreach ($report->campaign->contactList as $key => $val) {
                        foreach ($val->contactGroups->subscribers as $key1 => $val1) {
                            $to = (empty($key1)) ? $val1->phone : $to . ',' . $val1->phone;
                        }
                    }
                } else {
                    $to = $report->to;
                }
                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $report->uid;
                $nestedData['created_at']    = $created_at;
                $nestedData['type']          = $report->getSMSType();
                $nestedData['from']          = $report->from;
                $nestedData['to']            = $report->to;
                $nestedData['cost']          = $report->cost;
                $nestedData['status']        = str_limit($report->status, 20);
                $nestedData['update']   = __('locale.permission.update');
                $nestedData['delete']   = __('locale.buttons.delete');
                $data[]                      = $nestedData;
            }
        }
        // dd($request->input('search.value'), $totalData, $totalFiltered, $data);
        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ];

        echo json_encode($json_data);
        exit();
    }


    /**
     * get campaign details
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function campaigns()
    {
        /** check Status Of Scheduled Message */
        Api::checkStatusScheduleMsg();

        $this->authorize('view_reports');

        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Reports')],
            ['name' => __('locale.menu.Campaigns')],
        ];

        return view('customer.Reports.campaigns', compact('breadcrumbs'));
    }


    /**
     * search campaign data
     *
     * @param  Request  $request
     *
     * @throws AuthorizationException
     */
    #[NoReturn] public function searchCampaigns(Request $request)
    {
        $this->authorize('view_reports');

        $columns = [
            0 => 'id',
            1 => 'id',
            // 2 => 'campaign_name',
            3 => 'sender',
            4 => 'date',
            5 => 'time',
            6 => 'status'
        ];

        $dates = explode(',', $request->columns[3]['search']['value']);
        $orderBy = $columns[$request->input('order.0.column')];
        $orderType = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $query = [
            'key_id' => auth()->user()->key_id,
            'key_secret' => auth()->user()->key_secret,
            'from' => (empty($dates[0])) ? '' : $dates[0],
            'to' => (empty($dates[1])) ? '' : $dates[1],
            'start' => $request->start ?? 0,
            'limit' => $request->length ?? 10,
            'orderBy' => $orderBy,
            'orderType' => $orderType,
            'search' => $search
        ];

        $data = [];
        $param['query'] = $query;

        $headers = [
            'Content-Type' => 'application/json',
        ];
        $url = env('WA_API_URL') . 'scheduled/listbyuser';

        $client = new \GuzzleHttp\Client(['headers' => $headers]);
        try {
            $response = $client->request('POST', $url, $param);
            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
            $result = json_decode($content, true);
            if (isset($result['data'])) {
                foreach ($result['data']['schedules'] as $key => $val) {
                    $nestedData['id']       = $val['id'];
                    $nestedData['status']   = $val['status'];
                    $nestedData['date']     = date('Y-m-d', strtotime($val['date']));
                    $nestedData['time']     = date('h:i A', strtotime($val['date'] . ' ' . $val['time']));
                    $nestedData['campaign_name']   = $val['message'] ? ($val['message']['campaign_name'] ? $val['message']['campaign_name'] : 'Group Message') : 'Group Message';
                    $nestedData['sender']   = $val['sender'];
                    $nestedData['update']   = __('locale.permission.update');
                    $nestedData['delete']   = __('locale.buttons.delete');
                    $data[]                 = $nestedData;
                }
            }
            // $totalData = count($result['data']['schedules']);
            $totalData = isset($result['totalCount']) ? $result['totalCount'] : 0;
            $totalFiltered = $totalData;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $errResponseBodyAsString = json_decode($responseBodyAsString);
            $data[]                 = $errResponseBodyAsString;
        }
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
        } else {
            $search = $request->input('search.value');
        }
        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ];
        echo json_encode($json_data);
        exit();
    }

    public function editCampaign(Campaigns $campaign)
    {

        if ($campaign->upload_type == 'file') {
            return redirect()->route('customer.reports.campaigns')->with([
                'status'  => 'info',
                'message' => __('locale.campaigns.you_are_not_able_to_update_file_import_campaign'),
            ]);
        }

        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/reports/all"), 'name' => __('locale.menu.Reports')],
            ['name' => 'Details'],
        ];

        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        $campaign_sender_ids = CampaignsSenderid::where('campaign_id', $campaign->id)->cursor();

        $exist_sender_id     = null;
        $exist_phone_numbers = [];
        $originator          = 'sender_id';

        foreach ($campaign_sender_ids as $sender_id) {
            if ($sender_id->originator == 'sender_id') {
                $exist_sender_id = $sender_id->sender_id;
            } else {
                $originator            = 'phone_number';
                $exist_phone_numbers[] = $sender_id->sender_id;
            }
        }

        $exist_groups = CampaignsList::where('campaign_id', $campaign->id)->select('contact_list_id')->get()->pluck('contact_list_id')->toArray();
        //  $exist_recipients = CampaignsRecipients::where('campaign_id', $campaign->id)->select('recipient')->get()->pluck('recipient')->toArray();

        //     $exist_recipients = implode(',', $exist_recipients);

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        return view('customer.Campaigns.updateCampaignBuilder', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'campaign', 'exist_sender_id', 'originator', 'exist_phone_numbers', 'exist_groups', 'plan_id'));
    }


    /**
     * @param  Campaigns  $campaign
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function postEditCampaign(Campaigns $campaign, Request $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $input    = $request->except('_token');
        $sms_type = $input['sms_type'];

        $sending_servers = $campaign->getSendingServers();

        if (empty($sending_servers)) {

            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                'status'  => 'error',
                'message' => __('locale.campaigns.sending_server_not_available'),
            ]);
        }

        $sender_id = null;
        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            if (isset($input['originator'])) {
                if ($input['originator'] == 'sender_id') {

                    if (!isset($input['sender_id'])) {
                        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                            'status'  => 'error',
                            'message' => __('locale.sender_id.sender_id_required'),
                        ]);
                    }

                    $sender_id = $input['sender_id'];

                    if (is_array($sender_id) && count($sender_id) > 0) {
                        $invalid   = [];
                        $senderids = Senderid::where('user_id', Auth::user()->id)
                            ->where('status', 'active')
                            ->select('sender_id')
                            ->cursor()
                            ->pluck('sender_id')
                            ->all();

                        foreach ($sender_id as $sender) {
                            if (!in_array($sender, $senderids)) {
                                $invalid[] = $sender;
                            }
                        }

                        if (count($invalid)) {

                            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                                'status'  => 'error',
                                'message' => __('locale.sender_id.sender_id_invalid', ['sender_id' => $invalid[0]]),
                            ]);
                        }
                    } else {

                        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                            'status'  => 'error',
                            'message' => __('locale.sender_id.sender_id_required'),
                        ]);
                    }
                } else {

                    if (!isset($input['phone_number'])) {
                        $sender_id = CampaignsSenderid::where('campaign_id', $campaign->id)->pluck('sender_id')->toArray();
                    } else {
                        $sender_id = $input['phone_number'];
                    }


                    if (isset($sender_id) && is_array($sender_id) && count($sender_id) > 0) {
                        $type_supported = [];
                        PhoneNumbers::where('user_id', Auth::user()->id)
                            ->where('status', 'assigned')
                            ->cursor()
                            ->reject(function ($number) use ($sender_id, &$type_supported, &$invalid) {
                                if (in_array($number->number, $sender_id) && !str_contains($number->capabilities, 'sms')) {
                                    return $type_supported[] = $number->number;
                                }

                                return $sender_id;
                            })->all();

                        if (count($type_supported)) {

                            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                                'status'  => 'error',
                                'message' => __('locale.sender_id.sender_id_sms_capabilities', ['sender_id' => $type_supported[0]]),
                            ]);
                        }
                    } else {

                        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                            'status'  => 'error',
                            'message' => __('locale.sender_id.sender_id_required'),
                        ]);
                    }
                }
            } else {

                return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                    'status'  => 'error',
                    'message' => __('locale.sender_id.sender_id_required'),
                ]);
            }
        } elseif (Auth::user()->can('view_numbers') && isset($input['originator']) && $input['originator'] == 'phone_number') {
            $sender_id = $input['phone_number'];

            if (isset($sender_id) && is_array($sender_id) && count($sender_id) > 0) {
                $type_supported = [];
                PhoneNumbers::where('user_id', Auth::user()->id)
                    ->where('status', 'assigned')
                    ->cursor()
                    ->reject(function ($number) use ($sender_id, &$type_supported, &$invalid) {
                        if (in_array($number->number, $sender_id) && !str_contains($number->capabilities, 'sms')) {
                            return $type_supported[] = $number->number;
                        }

                        return $sender_id;
                    })->all();

                if (count($type_supported)) {

                    return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                        'status'  => 'error',
                        'message' => __('locale.sender_id.sender_id_sms_capabilities', ['sender_id' => $type_supported[0]]),
                    ]);
                }
            } else {

                return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                    'status'  => 'error',
                    'message' => __('locale.sender_id.sender_id_required'),
                ]);
            }
        } else {
            if (isset($input['originator'])) {
                if ($input['originator'] == 'sender_id') {
                    if (!isset($input['sender_id'])) {

                        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                            'status'  => 'error',
                            'message' => __('locale.sender_id.sender_id_required'),
                        ]);
                    }

                    $sender_id = $input['sender_id'];
                } else {

                    if (!isset($input['phone_number'])) {

                        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                            'status'  => 'error',
                            'message' => __('locale.sender_id.phone_numbers_required'),
                        ]);
                    }

                    $sender_id = $input['phone_number'];
                }

                if (!is_array($sender_id) || count($sender_id) <= 0) {

                    return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                        'status'  => 'error',
                        'message' => __('locale.sender_id.sender_id_required'),
                    ]);
                }
            }
            if (isset($input['sender_id'])) {
                $sender_id           = $input['sender_id'];
                $input['originator'] = 'sender_id';
            }
        }

        $total           = 0;
        $campaign_groups = [];

        // update contact groups details
        if (isset($input['contact_groups']) && is_array($input['contact_groups']) && count($input['contact_groups']) > 0) {
            $contact_groups = ContactGroups::whereIn('id', $input['contact_groups'])->where('status', true)->where('customer_id', Auth::user()->id)->cursor();
            foreach ($contact_groups as $group) {
                $total             += $group->subscribersCount($group->cache);
                $campaign_groups[] = [
                    'campaign_id'     => $campaign->id,
                    'contact_list_id' => $group->id,
                    'created_at'      => Carbon::now(),
                    'updated_at'      => Carbon::now(),
                ];
            }
        }

        // update manual input numbers
        //        if (isset($input['recipients'])) {
        //            $recipients = match ($input['delimiter']) {
        //                ','        => explode(',', $input['recipients']),
        //                ';'        => explode(';', $input['recipients']),
        //                '|'        => explode('|', $input['recipients']),
        //                'tab'      => explode(' ', $input['recipients']),
        //                'new_line' => explode("\n", $input['recipients']),
        //                default    => [],
        //            };
        //
        //            $recipients = collect($recipients)->unique();
        //
        //            $total   += $recipients->count();
        //            $numbers = [];
        //
        //            foreach ($recipients->chunk(500) as $chunk) {
        //                foreach ($chunk as $number) {
        //                    $numbers[] = [
        //                            'campaign_id' => $campaign->id,
        //                            'recipient'   => preg_replace("/\r/", "", $number),
        //                            'created_at'  => Carbon::now(),
        //                            'updated_at'  => Carbon::now(),
        //                    ];
        //                }
        //            }
        //
        //            CampaignsRecipients::where('campaign_id', $campaign->id)->delete();
        //
        //            CampaignsRecipients::insert($numbers);
        //        } else {
        //            CampaignsRecipients::where('campaign_id', $campaign->id)->delete();
        //        }

        if ($total == 0) {
            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                'status'  => 'error',
                'message' => __('locale.campaigns.contact_not_found'),
            ]);
        }


        if (Auth::user()->sms_unit != '-1') {
            $coverage = PlansCoverageCountries::where('plan_id', $input['plan_id'])->first();

            $priceOption = json_decode($coverage->options, true);

            $sms_count = 1;
            $price     = 0;

            if (isset($input['message'])) {
                $sms_counter  = new SMSCounter();
                $message_data = $sms_counter->count($input['message']);
                $sms_count    = $message_data->messages;
            }


            if ($sms_type == 'plain' || $sms_type == 'unicode') {
                $unit_price = $priceOption['plain_sms'];
                $price      = $total * $unit_price;
            }

            if ($sms_type == 'voice') {
                $unit_price = $priceOption['voice_sms'];
                $price      = $total * $unit_price;
            }

            if ($sms_type == 'mms') {
                $unit_price = $priceOption['mms_sms'];
                $price      = $total * $unit_price;
            }

            if ($sms_type == 'whatsapp') {
                $unit_price = $priceOption['whatsapp_sms'];
                $price      = $total * $unit_price;
            }

            $price *= $sms_count;

            $balance = Auth::user()->sms_unit;

            if ($price > $balance) {
                return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                    'status'  => 'error',
                    'message' => __('locale.campaigns.not_enough_balance', [
                        'current_balance' => $balance,
                        'campaign_price'  => $price,
                    ]),
                ]);
            }
        }

        CampaignsSenderid::where('campaign_id', $campaign->id)->delete();

        foreach ($sender_id as $id) {

            $data = [
                'campaign_id' => $campaign->id,
                'sender_id'   => $id,
            ];

            if (isset($input['originator'])) {
                $data['originator'] = $input['originator'];
            }

            CampaignsSenderid::create($data);
        }

        CampaignsList::where('campaign_id', $campaign->id)->delete();

        CampaignsList::insert($campaign_groups);


        // if schedule is available then check date, time and timezone
        if (isset($input['schedule']) && $input['schedule'] == "true") {

            $schedule_date = $input['schedule_date'] . ' ' . $input['schedule_time'];
            $schedule_time = Tool::systemTimeFromString($schedule_date, $input['timezone']);

            $campaign->timezone      = $input['timezone'];
            $campaign->status        = Campaigns::STATUS_SCHEDULED;
            $campaign->schedule_time = $schedule_time;


            if ($input['frequency_cycle'] == 'onetime') {
                // working with onetime schedule
                $campaign->schedule_type = Campaigns::TYPE_ONETIME;
            } else {
                // working with recurring schedule
                //if schedule time frequency is not one time then check frequency details
                $recurring_date = $input['recurring_date'] . ' ' . $input['recurring_time'];
                $recurring_end  = Tool::systemTimeFromString($recurring_date, $input['timezone']);

                $campaign->schedule_type = Campaigns::TYPE_RECURRING;
                $campaign->recurring_end = $recurring_end;

                if (isset($input['frequency_cycle'])) {
                    if ($input['frequency_cycle'] != 'custom') {
                        $schedule_cycle             = $campaign::scheduleCycleValues();
                        $limits                     = $schedule_cycle[$input['frequency_cycle']];
                        $campaign->frequency_cycle  = $input['frequency_cycle'];
                        $campaign->frequency_amount = $limits['frequency_amount'];
                        $campaign->frequency_unit   = $limits['frequency_unit'];
                    } else {
                        $campaign->frequency_cycle  = $input['frequency_cycle'];
                        $campaign->frequency_amount = $input['frequency_amount'];
                        $campaign->frequency_unit   = $input['frequency_unit'];
                    }
                }
            }
        } else {
            $campaign->status = Campaigns::STATUS_QUEUED;
        }
        //update cache
        $campaign->cache = json_encode([
            'ContactCount'         => $total,
            'DeliveredCount'       => 0,
            'FailedDeliveredCount' => 0,
            'NotDeliveredCount'    => 0,
        ]);

        $campaign->message = $input['message'];

        if ($sms_type == 'voice') {
            $campaign->language = $input['language'];
            $campaign->gender   = $input['gender'];
        }

        if ($sms_type == 'mms') {
            $campaign->media_url = Tool::uploadImage($input['mms_file']);
        }

        $camp = $campaign->save();

        if ($camp) {
            return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
                'status'  => 'success',
                'message' => __('locale.campaigns.campaign_successfully_updated'),
            ]);
        }

        return redirect()->route('customer.reports.campaign.edit', $campaign->uid)->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    public function campaignOverview(Campaigns $campaign)
    {
        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/reports/campaigns"), 'name' => __('locale.menu.Reports')],
            ['name' => __('locale.menu.Overview')],
        ];


        $campaign = Campaigns::where('user_id', Auth::user()->id)->where('uid', $campaign->uid)->first();


        if (!$campaign) {
            return redirect()->route('customer.reports.campaigns')->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.invalid_action'),
            ]);
        }


        return view('customer.Campaigns.overview', compact('campaign', 'breadcrumbs'));
    }

    /**
     * view campaign reports
     *
     * @param  Campaigns  $campaign
     * @param  Request  $request
     *
     * @throws AuthorizationException
     */
    #[NoReturn] public function campaignReports(Campaigns $campaign, Request $request)
    {

        $this->authorize('view_reports');

        $columns = [
            0 => 'responsive_id',
            1 => 'uid',
            2 => 'uid',
            3 => 'created_at',
            6 => 'from',
            7 => 'to',
            8 => 'cost',
            9 => 'status',
        ];

        $totalData = Reports::where('user_id', auth()->user()->id)->where('campaign_id', $campaign->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sms_reports = Reports::where('user_id', auth()->user()->id)->where('campaign_id', $campaign->id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $sms_reports = Reports::where('user_id', auth()->user()->id)->where('campaign_id', $campaign->id)->whereLike(['uid', 'from', 'to', 'cost', 'status', 'created_at'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Reports::where('user_id', auth()->user()->id)->where('campaign_id', $campaign->id)->whereLike(['uid', 'from', 'to', 'cost', 'status', 'created_at'], $search)->count();
        }

        $data = [];
        if (!empty($sms_reports)) {
            foreach ($sms_reports as $report) {
                if ($report->created_at == null) {
                    $created_at = null;
                } else {
                    $created_at = Tool::customerDateTime($report->created_at);
                }

                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $report->uid;
                $nestedData['created_at']    = $created_at;
                $nestedData['from']          = $report->from;
                $nestedData['to']            = $report->to;
                $nestedData['cost']          = $report->cost;
                $nestedData['status']        = str_limit($report->status, 20);
                $data[]                      = $nestedData;
            }
        }

        $json_data = [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data,
        ];

        echo json_encode($json_data);
        exit();
    }

    /**
     * @param $type
     *
     * @return Generator
     */

    public function reportsGenerator($type, $dateRange = null): Generator
    {
        // if ($type == 'all') {
        //     foreach (Reports::where('user_id', Auth::user()->id)->cursor() as $report) {
        //         yield $report;
        //     }
        // } else {
        //     foreach (Reports::where('user_id', Auth::user()->id)->where('send_by', $type)->cursor() as $report) {
        //         yield $report;
        //     }
        // }


        $reportObj = Reports::where('user_id', Auth::user()->id)->where("type", "quick");

        if ($dateRange) {
            $fromDate = $dateRange['fromDate'];
            $toDate = $dateRange['toDate'];
            if ($fromDate && $toDate) {
                $reportObj->whereBetween('created_at', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $reportObj->whereDate('created_at', '>=', $fromDate);
            } elseif ($toDate) {
                $reportObj->whereDate('created_at', '<=', $toDate);
            }
        }

        $reports = $reportObj->get(['from', 'to', 'sub_type', 'created_at', 'status']);

        foreach ($reports as $report) {
            yield $report;
        }
    }

    /**
     * @param $campaign_id
     *
     * @return Generator
     */

    public function campaignReportsGenerator($campaign_id): Generator
    {
        foreach (Reports::where('user_id', Auth::user()->id)->where('campaign_id', $campaign_id)->cursor() as $report) {
            yield $report;
        }
    }

    /**
     * @param  Request  $request
     *
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function export(Request $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.all')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('view_reports');

        Tool::resetMaxExecutionTime();


        $file_name = (new FastExcel($this->exportData($request)))->export(storage_path('Reports_' . time() . '.xlsx'));

        return response()->download($file_name);
    }


    /**
     * @param $request
     *
     * @return Generator
     */
    public function exportData($request): Generator
    {
        $start_date = null;
        $end_date   = null;

        if ($request->start_date && $request->end_date) {
            $start_time = $request->start_date . ' ' . $request->start_time;
            $start_date = Tool::systemTimeFromString($start_time, Auth::user()->timezone);

            $end_time = $request->end_date . ' ' . $request->end_time;
            $end_date = Tool::systemTimeFromString($end_time, Auth::user()->timezone);
        }

        $status    = $request->status;
        $direction = $request->direction;
        $type      = $request->type;
        $to        = $request->to;
        $from      = $request->from;

        if ($status == 'delivered') {
            $status = 'Delivered';
        }

        $get_data = Reports::query()->when($status, function ($query) use ($status) {
            $query->whereLike(['status'], $status);
        })->when($from, function ($query) use ($from) {
            $query->whereLike(['from'], $from);
        })->when($to, function ($query) use ($to) {
            $query->whereLike(['to'], $to);
        })->when($direction, function ($query) use ($direction) {
            $query->where('send_by', $direction);
        })->when($start_date, function ($query) use ($start_date, $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        })->where('sms_type', $type)->where('user_id', Auth::user()->id)->cursor();

        foreach ($get_data as $report) {
            yield $report;
        }
    }

    /**
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function exportSent(Request $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.all')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('view_reports');

        $file_name = (new FastExcel($this->reportsGenerator('quickSend', $request->all())))->export(storage_path('Reports_' . time() . '.xlsx'));

        return response()->download($file_name);
    }

    /**
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function exportReceive()
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.all')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('view_reports');

        $file_name = (new FastExcel($this->reportsGenerator('to')))->export(storage_path('Reports_' . time() . '.xlsx'));

        return response()->download($file_name);
    }

    /**
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function exportCampaign(Campaigns $campaign)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.all')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('view_reports');

        $file_name = (new FastExcel($this->campaignReportsGenerator($campaign->id)))->export(storage_path('Reports_' . time() . '.xlsx'));

        return response()->download($file_name);
    }

    /**
     * @return Generator
     */

    public function campaignGenerator($dateRange = null): Generator
    {
        // foreach (Campaigns::where('user_id', Auth::user()->id)->cursor() as $report) {
        //     yield $report;
        // }

        $reportObj = Campaigns::where('user_id', Auth::user()->id)
        ->select('id', 'campaign_name', 'media_type AS message_type', 'schedule_time', 'sender', 'status', 'created_at');
        
        if ($dateRange) {
            $fromDate = $dateRange['fromDate'];
            $toDate = $dateRange['toDate'];
            if ($fromDate && $toDate) {
                $reportObj->whereBetween('created_at', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $reportObj->whereDate('created_at', '>=', $fromDate);
            } elseif ($toDate) {
                $reportObj->whereDate('created_at', '<=', $toDate);
            }
        }

        // $reports = $reportObj->get(['from', 'to', 'sub_type', 'created_at', 'status']);
        $reports = $reportObj->get(['id', 'campaign_name', 'media_type', 'schedule_time', 'sender', 'status', 'created_at']);

        foreach ($reports as $report) {
            $report->status = null;
            yield $report;
        }

    }

    /**
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    public function campaignExport(Request $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.reports.all')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('view_reports');
        $file_name = (new FastExcel($this->campaignGenerator($request->all())))->export(storage_path('Campaign_' . time() . '.xlsx'));

        return response()->download($file_name);
    }

    /**
     * Api of delete campaign
     *
     * @param  Campaigns  $campaign
     *
     * @return bool
     * @throws Exception
     */
    public function apiCampaignDelete($id): bool
    {
        $data = [
            'key_id' => auth()->user()->key_id,
            'key_secret' => auth()->user()->key_secret,
            'schedule_id' => $id
        ];
        $param['query'] = $data;
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $url = env('WA_API_URL') . 'scheduled/delete';

        $client = new \GuzzleHttp\Client(['headers' => $headers]);
        try {
            $response = $client->request('POST', $url, $param);
            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
            $result = json_decode($content, true);
            $camp = Campaigns::where('schedule_id', $id)->delete();
            return true;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $errResponseBodyAsString = json_decode($responseBodyAsString);
            return false;
        }
    }


    /**
     * delete campaign
     *
     * @param  Campaigns  $campaign
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function campaignDelete($campaign): JsonResponse
    {
        if (config('app.stage') == 'demo') {

            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }
        $deleteCampaign = $this->apiCampaignDelete($campaign);
        if ($deleteCampaign) {
            return response()->json([
                'status'  => 'success',
                'message' => __('locale.campaigns.campaign_was_successfully_deleted'),
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }
    }

    /**
     * bulk campaign delete
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function campaignBatchAction(Request $request): JsonResponse
    {
        if (config('app.stage') == 'demo') {

            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }
        $ids = $request->get('ids');

        $deleteCampaign = false;
        foreach ($ids as $key => $val) {
            $deleteCampaign = $this->apiCampaignDelete($val);
        }
        if ($deleteCampaign) {
            return response()->json([
                'status'  => 'success',
                'message' => __('locale.campaigns.campaign_was_successfully_deleted'),
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }
    }

    public function viewCharts()
    {
        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['name' => __('locale.menu.View Charts')],
        ];

        $sms_outgoing = Reports::currentMonth()
            ->where('user_id', Auth::user()->id)
            ->selectRaw('Day(created_at) as day, count(send_by) as outgoing,send_by')
            ->where('send_by', "from")
            ->groupBy('day')->pluck('day', 'outgoing')->flip()->sortKeys();

        $sms_incoming = Reports::currentMonth()
            ->where('user_id', Auth::user()->id)
            ->selectRaw('Day(created_at) as day, count(send_by) as incoming,send_by')
            ->where('send_by', "to")
            ->groupBy('day')->pluck('day', 'incoming')->flip()->sortKeys();


        $outgoing = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.outgoing'), $sms_outgoing->values()->toArray())
            ->setXAxis($sms_outgoing->keys()->toArray());


        $incoming = (new LarapexChart)->lineChart()
            ->addData(__('locale.labels.incoming'), $sms_incoming->values()->toArray())
            ->setXAxis($sms_incoming->keys()->toArray());


        return view('customer.Reports.charts', compact('breadcrumbs', 'sms_incoming', 'sms_outgoing', 'outgoing', 'incoming'));
    }

    public function campaignDetails($schedule_id)
    {
        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/reports/all"), 'name' => __('locale.menu.Reports')],
            ['name' => 'Details'],
        ];

        $query = [
            'key_id' => auth()->user()->key_id,
            'key_secret' => auth()->user()->key_secret,
            'schedule_id' => $schedule_id
        ];
        $data = [];
        $param['query'] = $query;
        $campaign = Campaigns::where('schedule_id', $schedule_id)->first();

        $headers = [
            'Content-Type' => 'application/json',
        ];
        $url = env('WA_API_URL') . 'scheduled/details';

        $client = new \GuzzleHttp\Client(['headers' => $headers]);

        try {
            $response = $client->request('POST', $url, $param);
            $statusCode = $response->getStatusCode();
            $content = $response->getBody();
            $result = json_decode($content, true);
            if (isset($result['data'])) {
                return view('customer.Reports.campaign_details')->with(['data' => $result['data'], 'campaign' => $campaign, 'breadcrumbs' => $breadcrumbs]);
            }
            return 'Something went wrong';
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $errResponseBodyAsString = json_decode($responseBodyAsString);
            $data[]                 = $errResponseBodyAsString;
        }

        return view('customer.Reports.campaign_details', ['campaign' => $campaign, 'breadcrumbs' => $breadcrumbs]);
    }
    public function quicksendDetails($reportUid)
    {
        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/reports/all"), 'name' => __('locale.menu.Reports')],
            ['name' => 'Details'],
        ];

        $report = Reports::where('user_id', auth()->user()->id)->where('uid', $reportUid)->first();
        return view('customer.Reports.quick_send_report_details')->with(['report' => $report, 'breadcrumbs' => $breadcrumbs]);
    }
}
