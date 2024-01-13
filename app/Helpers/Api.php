<?php

namespace App\Helpers;

use App\Models\Connection;
use App\Models\User;
use App\Models\WpMessage;
use App\Models\Subscription;
use App\Models\Campaigns;
use App\Models\CampaignsList;
use App\Models\Contacts;
use App\Models\Reports;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Api
{
        protected static $wa_api_url;

        private static function init()
        {
                //Do initialization
                self::$wa_api_url = env('WA_API_URL');
        }
        /**
         * WhatsApp Register
         * 
         * @param Array $data  
         * 
         * @return void
         */

        public static function whatsappUserRegister($data): void
        {
                self::init();
                $mobile = $data['phone'];

                $mobile = (strlen($mobile) == 12) ? substr($mobile, 2) : $mobile;
                $params = [
                        'mobile'        => $mobile,
                        'email'         => $data['email'],
                        'name'          => $data['name'],
                ];
                $params['partner_id'] = '3';
                $user = User::find($data['user_id']);
                $queryString1 =  http_build_query($params);
                // $url1='https://oc.wapost.net/user/info?'.$queryString1;
                $url1 = self::$wa_api_url . 'user/info?' . $queryString1;
                $headers = [
                        "Content-Type" => "application/json",
                ];

                $client1 = new \GuzzleHttp\Client(['headers' => $headers]);
                try {
                        $response1 = $client1->request('GET', $url1);
                        $statusCode1 = $response1->getStatusCode();
                        $content1 = $response1->getBody();
                        $result1 = json_decode($content1, true);
                        Log::info("whatsappUserRegister result1 ==");
                        Log::info($result1);

                        if ($result1['error'] == false) {
                                if (isset($result1['user']['key_id']) && !empty($result1['user']['key_id'])) {
                                        $user->key_id = $result1['user']['key_id'];
                                        $user->key_secret = $result1['user']['key_secret'];
                                        $user->save();
                                } else {
                                        $params['partner_key'] = (isset($data['partner_key'])) ? $data['partner_key'] : 'PRT-0IDR245P';
                                        self::createWhatsAccount($params, $headers, $user);
                                }
                        }
                } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                        $response = $e->getResponse();
                        $responseBodyAsString = $response->getBody()->getContents();
                        $errResponseBodyAsString = json_decode($responseBodyAsString);
                        $err = ($errResponseBodyAsString == null) ? [] : (array) $errResponseBodyAsString;
                        Log::info("whatsappUserRegister err ==");
                        Log::info($err);
                        if (isset($err['error'])) // && $err['error'])
                        {
                                $params['partner_key'] = (isset($data['partner_key'])) ? $data['partner_key'] : 'PRT-0IDR245P';
                                self::createWhatsAccount($params, $headers, $user);
                        }
                }
        }
        /**
         * Generate WhatsApp Account
         * 
         * @param Array $data  
         * 
         * @return boolean
         */

        public static function createWhatsAccount($params, $headers, $user)
        {
                $queryString =  http_build_query($params);
                $url = self::$wa_api_url . 'user/register?' . $queryString;

                $client = new \GuzzleHttp\Client(['headers' => $headers]);
                try {
                        $response = $client->request('GET', $url);
                        $statusCode = $response->getStatusCode();
                        $content = $response->getBody();
                        $result = json_decode($content, true);
                        Log::info("createWhatsAccount result ==");
                        Log::info($result);
                        if (isset($result['user']) && !empty($result['user']['key_id'])) {
                                $user->key_id = $result['user']['key_id'];
                                $user->key_secret = $result['user']['key_secret'];
                                $user->save();
                        }
                } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                        $response = $e->getResponse();
                        $responseBodyAsString = $response->getBody()->getContents();
                        $errResponseBodyAsString = json_decode($responseBodyAsString);
                        $err1 = ($errResponseBodyAsString == null) ? [] : (array) $errResponseBodyAsString;
                        Log::info("createWhatsAccount err1 ==");
                        Log::info($err1);
                }
        }

        /**
         * Check WhatsApp Number
         * 
         * @param Array $data  
         * 
         * @return boolean
         */

        public static function checkWhatsNumber($data): bool
        {
                self::init();
                $params  = [
                        'key'        => $data['key'],
                        'id'         => $data['id']
                ];
                $queryString =  http_build_query($params);
                $url = self::$wa_api_url . 'misc/onwhatsapp?' . $queryString;
                $headers = [
                        "Content-Type" => "application/json",
                ];
                $client = new \GuzzleHttp\Client(['headers' => $headers]);
                try {
                        $response = $client->request('GET', $url);
                        $statusCode = $response->getStatusCode();
                        $content = $response->getBody();
                        $result = json_decode($content, true);

                        return $result['error'];
                } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                        $response = $e->getResponse();
                        $responseBodyAsString = $response->getBody()->getContents();
                        $errResponseBodyAsString = json_decode($responseBodyAsString);
                        // $connection = Connection::where('user_id', auth()->user()->id)->first();
                        // $connection->status = 0;
                        // $connection->save();
                        return true;
                }
        }

        /**
         * Check WhatsApp Login Or Not
         * 
         *  
         * return null
         */

        public static function checkWhatsLogin()
        {
                self::init();
                /** Check User Is Login Or Not */
                if (!isset(auth()->user()->id))
                        return true;

                // Log::info("checkWhatsLogin user()->key_id ==");
                Log::info(auth()->user());
                // if(isset(auth()->user()->key_id) && empty(auth()->user()->key_id))
                if (empty(auth()->user()->key_id)) {
                        $data = [
                                'phone' => auth()->user()->customer->phone,
                                'name' => auth()->user()->first_name,
                                'email' => auth()->user()->email,
                                'user_id' => auth()->user()->id
                        ];
                        Log::info("checkWhatsLogin data ==");
                        Log::info($data);
                        self::whatsappUserRegister($data);
                }
                // $connection = Connection::where('user_id', auth()->user()->id)->where('status', 1)->first();
                $connections = Connection::where('user_id', auth()->user()->id)->where('status', 1)->get()->toArray();
                foreach ($connections as $k => $conn) {
                        $conn = (object) $conn;
                        $connection = Connection::where('user_id', auth()->user()->id)->where('key', $conn->key)->where('status', 1)->first();
                        if ($connection != null && !empty($connection)) {
                                $params  = [
                                        'key'        => $connection->key
                                ];
                                $queryString =  http_build_query($params);
                                $url = self::$wa_api_url . 'instance/info?' . $queryString;
                                $headers = [
                                        "Content-Type" => "application/json",
                                ];
                                $client = new \GuzzleHttp\Client(['headers' => $headers]);
                                try {
                                        $response = $client->request('GET', $url);
                                        $statusCode = $response->getStatusCode();
                                        $content = $response->getBody();
                                        $result = json_decode($content, true);

                                        if ($result['error'] == false) {
                                                if (isset($result['instance_data']['phone_connected']) && $result['instance_data']['phone_connected'])
                                                        $status = 1;
                                                else
                                                        $status = 0;
                                                $connection->status = $status;
                                                $connection->save();
                                        }
                                        // return $result['error'];
                                } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                                        $response = $e->getResponse();
                                        $responseBodyAsString = $response->getBody()->getContents();
                                        $connection->status = 0;
                                        $connection->save();
                                        // return true;
                                }
                        }
                }
        }

        /**
         * Send WhatsApp Message
         * 
         * @param Array $data  
         * 
         * $return json
         */

        public static function sendWhatsappMsg($data = [], $requestedMessage, $apiUserId = null)
        {
                $param  = $data['param'] ?? [];
                $key    = $data['key'] ?? "";
                $type   = $data['type'] ?? "";
                $from   = isset($data['from']) ? $data['from'] : "";
                $headers = $data['headers'] ?? [];
                /** check time delay */

                if (!$apiUserId) {
                        $checkTimeDelay = self::checkTimeDelay($apiUserId);

                        $timePenalty = $checkTimeDelay['timePenalty'];
                        $diff_in_minutes = $checkTimeDelay['min'];
                        $sec = $checkTimeDelay['sec'];
                }else{
                        $timePenalty = true;
                }
                
                $mobile = ($type == 'text' || $type == 'contact' || $type == 'button' || $type == 'list' || $type == 'MediaButton') ? $param['form_params']['id'] : $param['multipart'][1]['contents'];

                $reportData = [
                        'type'          => "quick",
                        'sub_type'      => $type,
                        'from'          => $from,
                        'status'        => "pending",
                        'to'            => $mobile
                ];

                if (!empty($key) && $timePenalty) {
                        $url = self::$wa_api_url . 'message/' . $type . '?key=' . $key;
                        // $url = 'https://oc.wapost.net/' . 'message/' . $type . '?key=' . $key;
                        // dd($url);
                        $client = new \GuzzleHttp\Client(['headers' => $headers]);
                        try {
                                $response = $client->request('POST', $url, $param);
                                $statusCode = $response->getStatusCode();
                                $content = $response->getBody();

                                $result = json_decode($content, true);

                                if (!$result['error']) {
                                        // $wpMsg = new WpMessage();
                                        // $wpMsg->type = $type;
                                        // $wpMsg->message = json_encode($result['data']);
                                        // $wpMsg->number = $mobile;
                                        // $wpMsg->user_id = auth()->user()->id;
                                        // $wpMsg->status = 1;
                                        // $wpMsg->save();

                                        $reportData['msg'] = json_encode($result['data']);
                                        $reportData['status'] = 'pending';
                                        /** add Resports */
                                        self::addReport($reportData, $requestedMessage, null, $apiUserId);

                                        return response()->json([
                                                'status'  => 'success',
                                                'message' => __('locale.contacts.whatsapp_message_sent_successfully'),
                                                'data' => $result
                                        ]);
                                } else {
                                        $reportData['msg'] = json_encode($data['param']);
                                        $reportData['status'] = 'failed';
                                        /** add Resports */
                                        self::addReport($reportData, $requestedMessage, null, $apiUserId);

                                        return response()->json([
                                                'status'  => 'error',
                                                'message' => __('locale.contacts.whatsapp_message_not_sent'),
                                                'data' => ""
                                        ]);
                                }
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                                $response = $e->getResponse();
                                $responseBodyAsString = $response->getBody()->getContents();
                                $errResponseBodyAsString = json_decode($responseBodyAsString);
                                $reportData['msg'] = json_encode($data['param']);
                                $reportData['status'] = 'failed';
                                /** add Resports */
                                self::addReport($reportData, $requestedMessage, null, $apiUserId);

                                return response()->json([
                                        'status'  => 'error',
                                        'message' => __('locale.contacts.whatsapp_message_not_sent'),
                                        'data' => ""
                                ]);
                        }
                } else {
                        return response()->json([
                                'status'  => 'error',
                                'message' => __('You Can send Message After ' . $diff_in_minutes . ':' . $sec . ' Minutes'),
                                'data' => ""
                        ]);
                }
        }

        /**
         * Send WhatsApp Message Campaign
         * 
         * @param Array $data  
         * 
         * $return json
         */

        public static function scheduleWhatsappMsgCamp($data = [], $requestedMessage)
        {
                $param   = $data['param'] ?? [];
                $key     = $data['key'] ?? "";
                $from    = auth()->user()->connection->number;
                $headers = $data['headers'] ?? [];
                $schedule_type = $data['schedule_type'] ?? [];
                $page_type = $data['page_type'] ?? [];
                $contact_groups = $data['contact_groups'] ?? [];
                $timeDelay = "10";
                $user_id = auth()->user()->id;
                $schedule_id = isset($data['schedule_id']) ? $data['schedule_id'] : null;

                $subscription = Subscription::where('user_id', $user_id)->whereHas('subscriptionLogs', function ($q) {
                        $q->orderBy('created_at', 'desc');
                })->orderBy('created_at', 'desc')->first();

                $planData = (isset($subscription->subscriptionLogs[0])) ? json_decode($subscription->subscriptionLogs[0]->data) : '';
                $param['query']['delay'] = null;
                if (!empty($planData) && $planData->plan == 'Free') {
                        $param['query']['delay'] = 600000; //10 minute  //'60000';//one minute//
                        // $param['query']['delay'] = 120000; //10 minute  //'60000';//one minute//

                        if ($schedule_type == 'schedule') {
                                $check_delay_time = $check_delay_time_count = 0;
                                // foreach($contact_groups as $cokey => $coval)
                                // {
                                //         $check_contacts = Contacts::where('group_id',$coval)->count();
                                //         $check_delay_time_count = $check_contacts + $check_delay_time_count;        
                                // }
                                $check_contacts = Contacts::whereIn('group_id', $contact_groups)->count();
                                $check_delay_time_count = $check_contacts + $check_delay_time_count;
                                // $check_contacts = Contacts::whereIn('group_id',$contact_groups)->count();

                                $startScheDate = $param['query']['date'] . " " . $param['query']['time'];

                                $scheDate = \Carbon\Carbon::parse($startScheDate);
                                $check_delay_time = 10 * $check_delay_time_count;
                                $endSchDate = $scheDate->addMinutes($check_delay_time)->format('Y-m-d H:i:s');
                                /** check campaign not present on get time */
                                $checkCampaign = Campaigns::whereBetween('schedule_time', [$startScheDate, $endSchDate])->orWhereBetween('delay_time', [$startScheDate, $endSchDate])->orWhere('schedule_time', "<=", $startScheDate)->where('delay_time', ">=", $endSchDate)->count();

                                if (!empty($checkCampaign)) {
                                        return response()->json([
                                                'status'  => 'error',
                                                'message' => "This Schedule Time is aleady Presesnt",
                                                'data' => ""
                                        ]);
                                }
                        } else {
                                /** check time delay */
                                $checkTimeDelay = self::checkTimeDelay();
                                $timeDelay = $checkTimeDelay['timePenalty'];
                                $min = $checkTimeDelay['min'];
                                $sec = $checkTimeDelay['sec'];
                        }
                }

                if (!empty($key) && $timeDelay) {
                        $reportData = [
                                'type'          => "campaign",
                                'sub_type'      => $schedule_type,
                                'from'          => $from,
                        ];
                        // Log::info("campaign Param ==");
                        // Log::info($param);

                        $client = new \GuzzleHttp\Client(['headers' => $headers]);
                        try {
                                $reqParam = $param['query'];
                                $tempMessage = [];
                                $campaignName = null;
                                if (isset($data['campaign_name']))  $campaignName = $data['campaign_name'];

                                if (isset($param['query']['multipart'])) {
                                        $makeAdditionalBodyData = [
                                                ["name" => "key_id", "contents" => $param['query']['key_id']],
                                                ["name" => "key_secret", "contents" => $param['query']['key_secret']],
                                                ["name" => "sender", "contents" => $param['query']['sender']],
                                                ["name" => "type", "contents" => $param['query']['type']],
                                                ["name" => "date", "contents" => $param['query']['date']],
                                                ["name" => "time",   "contents" => $param['query']['time']],
                                                ["name" => "delay",   "contents" => $reqParam['delay']],
                                                ["name" => "campaign_name",   "contents" => $campaignName],
                                                ["name" => "schedule_id",   "contents" => $schedule_id]
                                        ];

                                        $getMultipartData = [];
                                        // if ($param['query']['type'] == 'image' || $param['query']['type'] == 'video') {
                                        if ($param['query']['type'] != 'audio') {
                                                foreach ($param['query']['multipart'] as $value) {
                                                        if ($value['name'] != 'file' && $value['name'] != 'numbers') {
                                                                $getMultipartData[$value['name']] = $value['contents'];
                                                                $tempMessage[$value['name']] = $value['contents'];
                                                        }
                                                }
                                        }

                                        $makeAdditionalBodyData[] = ["name" => "messageData",   "contents" => json_encode($getMultipartData)];
                                        $multipartData = array_merge($param['query']['multipart'], $makeAdditionalBodyData);

                                        $reqParam = ['multipart' => $multipartData];

                                        $tempMessage = json_encode(["message" => $tempMessage]);
                                } else {
                                        $reqParam['form_params'] = [
                                                "key_id" => $reqParam['key_id'],
                                                "key_secret" => $reqParam['key_secret'],
                                                "sender" => $reqParam['sender'],
                                                "numbers" => $reqParam['numbers'],
                                                "type" => $reqParam['type'],
                                                "date" => $reqParam['date'],
                                                "time" => $reqParam['time'],
                                                "delay" => $reqParam['delay'],
                                                "campaign_name" => $campaignName,
                                                "schedule_id" => $schedule_id,
                                                "messageData" => $reqParam['form_params'],
                                        ];

                                        $reqParam = ['form_params' => $reqParam['form_params']];
                                        $tempMessage = json_encode($reqParam['form_params']['messageData']);
                                }

                                $data['param']['query']['message'] = $tempMessage;

                                if ($schedule_id) {
                                        $url = self::$wa_api_url . 'scheduled/updateScheduledMessage?key=' . $key;
                                } else {
                                        $url = self::$wa_api_url . 'scheduled/messagebynumbers?key=' . $key;
                                }

                                $response = $client->request('POST', $url, $reqParam);
                                // $response = $client->post($url, [\GuzzleHttp\RequestOptions::JSON => $reqParam]);
                                $statusCode = $response->getStatusCode();
                                $content = $response->getBody();
                                $result = json_decode($content, true);

                                Log::info("campaign response ==");
                                Log::info($result);
                                if ($result['error']) {
                                        /** add Resports */
                                        // $reportData['msg'] = $param['query']['message'];
                                        $reportData['msg'] = $tempMessage;
                                        $reportData['status'] = "failed";
                                        $reportData['campaign_id'] = 0;
                                        self::addReport($reportData, $requestedMessage, $schedule_id);

                                        return response()->json([
                                                'status'  => 'error',
                                                'message' => $result['message'],
                                                'data' => ""
                                        ]);
                                }

                                if ($schedule_id) {
                                        $campaign = Campaigns::where('schedule_id', $schedule_id)->first();
                                        $campaign->schedule_id = $schedule_id;
                                } else {
                                        $campaign = new Campaigns;
                                        $campaign->schedule_id = $result['schedule_id'];
                                }

                                $campaign->batch_id = implode(",", $contact_groups);
                                // $campaign->message = $data['param']['query']['message'];
                                $campaign->message = json_encode($requestedMessage, true);
                                $campaign->media_type = $requestedMessage['mediaType'];
                                $campaign->user_id = auth()->user()->id;
                                $campaign->schedule_time = $result['scheduled_date'] . " " . $result['scheduled_time'];
                                $campaign->schedule_type = $schedule_type;
                                $campaign->page_type = $page_type;
                                $campaign->status = 'pending';
                                $campaign->sender = $data['param']['query']['sender'];
                                $campaign->campaign_name = $campaignName;
                                $campaign->save();

                                $delay_time = $delay_time_count = 0;
                                foreach ($contact_groups as $cokey => $coval) {
                                        $CampaignsList = CampaignsList::find($campaign->id);
                                        if (!empty($CampaignsList))
                                                $CampaignsList->delete();
                                        $CampaignsList = new CampaignsList();

                                        $CampaignsList->campaign_id = $campaign->id;
                                        $CampaignsList->contact_list_id = $coval;
                                        $CampaignsList->save();
                                        $contacts = Contacts::where('group_id', $coval)->count();
                                        $delay_time_count = $contacts + $delay_time_count;
                                }

                                /** Set Delay Time */
                                $delay_time = 10 * $delay_time_count;
                                $campaign->delay_time = $campaign->schedule_time->addMinutes($delay_time);
                                $campaign->save();

                                /** add Resports */
                                $reportData['msg'] = $data['param']['query']['message'];
                                $reportData['status'] = "pending";
                                $reportData['campaign_id'] = $campaign->id;
                                self::addReport($reportData, $requestedMessage, $schedule_id);

                                $msg = ($schedule_type == 'schedule') ? __('locale.contacts.whatsapp_message_schedule') : __('locale.contacts.whatsapp_message_sent_successfully');

                                return response()->json([
                                        'status'  => 'success',
                                        'message' => $msg,
                                        'data' => ""
                                ]);
                        } catch (\GuzzleHttp\Exception\ClientException $e) {
                                $response = $e->getResponse();
                                $responseBodyAsString = $response->getBody()->getContents();
                                $errResponseBodyAsString = json_decode($responseBodyAsString);
                                // if($page_type == 'single_contact')
                                //         $msg = (isset($errResponseBodyAsString->error->error_user_title))?$errResponseBodyAsString->error->error_user_title.". ".$errResponseBodyAsString->error->error_user_msg:$errResponseBodyAsString->error->message;
                                // else
                                $msg = __('locale.contacts.whatsapp_message_not_sent');
                                Log::info("campaign err ==");
                                Log::info($errResponseBodyAsString);
                                return response()->json([
                                        'status'  => 'error',
                                        'message' => $msg,
                                        'data' => ""
                                ]);
                        }
                } else {
                        return response()->json([
                                'status'  => 'error',
                                'message' => __('You Can Schedule Message After ' . $min . ':' . $sec . ' Minutes'),
                                'data' => ""
                        ]);
                }
        }
        /**
         * Add Message Report
         * 
         * return Array
         */
        public static function addReport($data, $requestedMessage = [], $schedule_id = null, $apiUserId = null)
        {
                $from           = isset($data['from']) ? $data['from'] : "";
                $to             = isset($data['to']) ? $data['to'] : "";
                $msg            = isset($data['msg']) ? $data['msg'] : "";
                $campaign_id    = isset($data['campaign_id']) ? $data['campaign_id'] : "";
                $status         = isset($data['status']) ? $data['status'] :  "";
                $type           = isset($data['type']) ? $data['type'] : "";
                $sub_type       = isset($data['sub_type']) ? $data['sub_type'] : "";
                $user_id = $apiUserId ?? auth()->user()->id;

                if ($schedule_id) {
                        $report = Reports::where('campaign_id', $campaign_id)->first();
                } else {
                        $report = new Reports;
                }

                $report->from = $from;
                $report->to = $to;
                $report->message = $msg;
                $report->requested_message = json_encode($requestedMessage, true);

                if (!empty($campaign_id))
                        $report->campaign_id = $campaign_id;

                $report->user_id = $user_id;
                $report->status = ($type == 'campaign' && $sub_type == 'schedule') ? $status : 'sent';
                $report->type = $type;
                $report->sub_type = $sub_type;
                $report->cost = 0;
                $report->save();
        }
        /**
         * check Time Penalty Delay
         * 
         * return Array
         */
        public static function checkTimeDelay($apiUserId = null)
        {
                $timePenalty            = false;
                $diff_in_minutes = $sec = 0;
                $user_id = $apiUserId ?? auth()->user()->id;
                $subscription = Subscription::where('user_id', $user_id)->whereHas('subscriptionLogs', function ($q) {
                        $q->orderBy('created_at', 'desc');
                })->orderBy('created_at', 'desc')->first();

                $planData = (isset($subscription->subscriptionLogs[0])) ? json_decode($subscription->subscriptionLogs[0]->data) : '';

                $options = json_decode($subscription->options);

                // $delay_time = json_decode($subscription->plan->options);
                $delay_time = $options->delay_time ?? 10;
                if (!empty($planData) && $planData->plan == 'Free') {
                        $currDate = \Carbon\Carbon::now();
                        $today = \Carbon\Carbon::today();

                        // $checkScheduleCamp = Campaigns::where('user_id', $user_id)->whereDate('schedule_time',$today)->get();
                        $checkScheduleCamp = Campaigns::where('user_id', $user_id)->whereDate('schedule_time', $today)->where('status', "!=", 'failed')->get();

                        if (!empty($checkScheduleCamp)) {
                                $start = $end = false;
                                foreach ($checkScheduleCamp as $key => $val) {
                                        $start = ($val->schedule_type == 'schedule') ? $currDate->gte($val->schedule_time) : $currDate->gte($val->created_at);
                                        $end = $currDate->lte($val->delay_time);
                                        $createdAdd10Min = $val->delay_time;
                                }
                                $timePenalty = ($start && $end) ? false : true;
                        }
                        if ($timePenalty) {
                                $checkWPMsg = Reports::where('type', '!=', 'campaign')->orderBy('created_at', 'desc')->first();
                                if (!empty($checkWPMsg)) {
                                        $createdAdd10Min = $checkWPMsg->created_at->addMinutes($delay_time);
                                        $timePenalty = $currDate->gte($createdAdd10Min);
                                }
                        }
                        if (isset($createdAdd10Min)) {
                                $diff_in_minutes = $currDate->diffInMinutes($createdAdd10Min);
                                $diff_in_seconds = $currDate->diffInSeconds($createdAdd10Min);
                                $sec = $diff_in_seconds % 60;
                        }
                } else
                        $timePenalty = true;

                $data = [
                        "timePenalty"   => $timePenalty,
                        "sec"           => $sec,
                        "min"           => $diff_in_minutes,
                        "delay_time"    => $delay_time
                ];
                return $data;
        }
        /**
         * Check STatus Of Schedule Messages
         * 
         * return string
         */
        public static function checkStatusScheduleMsg()
        {
                self::init();
                $user_id = auth()->user()->id;
                $connection = Connection::where('user_id', $user_id)->where('status', 1)->first();
                if (empty($connection)) {
                        return response()->json([
                                'status'  => 'error',
                                'message' => __('Whatsapp is not login'),
                                'data' => ""
                        ]);
                }
                $key = $connection->key;
                $key_id = auth()->user()->key_id;
                $key_secret = auth()->user()->key_secret;
                $reports = Reports::where('user_id', $user_id)->where('status', 'pending')->get();
                $params = [
                        'key'           => $key,
                        'key_id'        => $key_id,
                        'key_secret'    => $key_secret,
                ];

                foreach ($reports as $key => $val) {
                        if (!empty($val->campaign->schedule_id)) {
                                $schedule_id = $val->campaign->schedule_id;
                                $params['schedule_id'] = $schedule_id;
                                $queryString =  http_build_query($params);
                                $url = self::$wa_api_url . 'scheduled/messagestatusbyuser?' . $queryString;
                                $headers = [
                                        "Content-Type" => "application/json",
                                ];

                                $client = new \GuzzleHttp\Client(['headers' => $headers]);
                                try {
                                        $response = $client->post($url);
                                        $statusCode = $response->getStatusCode();
                                        $content = $response->getBody();
                                        $result = json_decode($content, true);

                                        if ($result['error'] == false) {
                                                $campaign = Campaigns::where('user_id', $user_id)->where('schedule_id', $schedule_id)->first();
                                                $campaign->status = $result['record']['status'];
                                                $campaign->save();
                                                $val->status = $result['record']['status'];
                                                $val->save();
                                        }
                                } catch (\GuzzleHttp\Exception\ClientException $e) {
                                        $response = $e->getResponse();
                                        $responseBodyAsString = $response->getBody()->getContents();
                                        $errResponseBodyAsString = json_decode($responseBodyAsString);
                                }
                        }
                }
        }
}
