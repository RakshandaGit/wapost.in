<?php

namespace App\Http\Controllers\API;

use App\Helpers\Api;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\ApiDetail;
use App\Models\Connection;
use App\Models\MessageTransaction;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'sendername'  => ['required', 'min:8'],
            'mobile'  => ['required', 'numeric'],
            'message' => ['required', 'string'],
            'routetype' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = 'Validation errors.';
            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'data' => $errors
            ], 400);
        }

        $number = Helper::formatMobileNumber($request->mobile);
        $message = $request->message;

        $apiDetail = ApiDetail::where(['username' => $request->username, 'password' => $request->password, 'sendername' => $request->sendername])->first();
        if (!$apiDetail) {
            $message = 'Enter the correct details.';
            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'data' => null
            ], 400);
        }

        // if (Auth::user()->customer->activeSubscription()) {
        //     $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
        //     if (!$plan) {
        //         return redirect()->route('customer.sms.quick_send')->with([
        //             'status'  => 'error',
        //             'message' => 'Purchased plan is not active. Please contact support team.',
        //         ]);
        //     }
        // }

        $userId = $apiDetail->user_id;
        $connections = Connection::where('user_id', $userId)->where('status', 1)->get();
        if (count($connections) == 0) {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.labels.wa_logout_msg'),
                'data' => ""
            ], 400);
        }

        $checkWhatsappNumber = Api::checkWhatsNumber(['key' => $connections[0]->key, 'id' => $number]);

        if ($checkWhatsappNumber) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This Number is not Whatsapp Number',
                'data' => $number
            ], 400);
        }

        $user = User::find($userId);
        if ($user) {

            if ($user->is_enterprise || $user->parent_id != 0) {



                $lastPUserTransaction = MessageTransaction::where('user_id', $userId)->orderBy('id', 'desc')->first();
                $mtBalance = 0;
                if ($lastPUserTransaction) {
                    $mtBalance = $lastPUserTransaction->balance;
                }

                if ($mtBalance < 1) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Insufficient Balance',
                        'data' => null
                    ], 400);
                }

                MessageTransaction::create([
                    'user_id' => $userId,
                    'debit' => 1,
                    'balance' => $mtBalance - 1,
                    'remark' => 'Sent Message'
                ]);
            }
        }
        $senderKey = $connections[0]->key;
        $senderNumber = $connections[0]->number;
        $param = [
            "query" =>  [
                "key" => $senderKey
            ],
            "form_params" =>  [
                "id" => $number,
                "message" => $message
            ]
        ];

        $headers = [
            "Content-Type" => "multipart/form-data"
        ];

        $dataParams = [
            "param"     => $param,
            "type"      => 'text',
            "key"       => $senderKey,
            "from"      => $senderNumber,
            "headers"   => $headers
        ];

        $requestedMessage = [
            'message' => $request->message,
            'filePath' => null,
            'mediaType' => 'text',
            'fullname' => null,
            'displayname' => null,
            'organization' => null,
            'phonenumber' => null
        ];

        $whatsappResponse = Api::sendWhatsappMsg($dataParams, $requestedMessage, $userId);
        return $whatsappResponse;
    }

    public function sendPOSMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enterprise_id' => ['required', 'string'],
            'enterprise_user_id' => ['required', 'string'],
            // 'sendername'  => ['required', 'min:8'],
            'customer_mobile'  => ['required', 'numeric'],
            'message' => ['required', 'string'],
            // 'document' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,csv,,jpg,jpeg,png,svg,gif,txt,mp3,mp4', 'max:2048']
            'document' => ['nullable', 'file']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = 'Validation errors.';
            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'data' => $errors
            ], 400);
        }

        $user = User::where(['parent_id' => $request->enterprise_id, 'enterprise_user_id' => $request->enterprise_user_id])->first();
        if (!$user) {
            $message = 'Enter the correct details.';
            return response()->json([
                'status'  => 'error',
                'message' => $message,
                'data' => null
            ], 400);
        }

        $number = Helper::formatMobileNumber($request->customer_mobile);
        $message = $request->message;

        $filePath = null;
        $filedata = [];

        if ($request->hasFile('document')) {
            $fileSize = $_FILES['document']["size"] / 1000;
            if ($fileSize > 16384) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'File Size Should be less than 16MB',
                    'data' => null
                ], 400);
            }

            $uploadedImage = $request->file('document');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            // $destinationPath = public_path('/public/upload/messageFiles/');
            // $uploadedImage->move($destinationPath, $imageName);
            $filePath = env('APP_URL') . '/public/public/upload/messageFiles/' . $imageName;

            $file = $_FILES['document'];
            if (!($file['tmp_name'] == '')) {
                $file['filename'] = $file['name'];
                $file['name'] = 'file'; //$key;
                $file['contents'] = fopen($file['tmp_name'], 'r');
                $file['headers'] = array('Content-Type' => mime_content_type($file['tmp_name']));
            } else {
                $file['contents'] = '';
            }
            array_push($filedata, $file);
            array_push($filedata, ['name' => 'id', 'contents' => $number]);
            array_push($filedata, ['name' => 'filename', 'contents' => $file['filename']]);
            array_push($filedata, ['name' => 'caption', 'contents' => $request->message]);
        }

        $userId = $user->id;
        $connections = Connection::where('user_id', $userId)->where('status', 1)->get();
        if (count($connections) == 0) {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.labels.wa_logout_msg'),
                'data' => ""
            ], 400);
        }

        $checkWhatsappNumber = Api::checkWhatsNumber(['key' => $connections[0]->key, 'id' => $number]);

        if ($checkWhatsappNumber) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This Number is not Whatsapp Number',
                'data' => $number
            ], 400);
        }

        $senderKey = $connections[0]->key;
        $senderNumber = $connections[0]->number;
        $param = [
            "query" =>  [
                "key" => $senderKey
            ]
        ];

        if (count($filedata) > 0) {
            $param['multipart'] = $filedata;
        } else {
            $param['form_params'] = [
                "id" => $number,
                "message" => $message
            ];
        }

        $headers = [
            "Content-Type" => "multipart/form-data"
        ];

        $dataParams = [
            "param"     => $param,
            "type"      => $request->document ? 'doc' : 'text',
            "key"       => $senderKey,
            "from"      => $senderNumber,
            "headers"   => $headers
        ];

        $requestedMessage = [
            'message' => $request->message,
            'filePath' => $filePath,
            'mediaType' => $request->document ? 'file' : 'text',
            'fullname' => null,
            'displayname' => null,
            'organization' => null,
            'phonenumber' => null
        ];

        $lastPUserTransaction = MessageTransaction::where('user_id', $userId)->orderBy('id', 'desc')->first();
        $mtBalance = 0;
        if ($lastPUserTransaction) {
            $mtBalance = $lastPUserTransaction->balance;
        }

        if ($mtBalance < 1) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Insufficient Balance',
                'data' => null
            ], 400);
        }

        MessageTransaction::create([
            'user_id' => $userId,
            'debit' => 1,
            'balance' => $mtBalance - 1,
            'remark' => 'Sent Message'
        ]);

        $whatsappResponse = Api::sendWhatsappMsg($dataParams, $requestedMessage, $userId);
        if ($request->hasFile('document')) {
            $destinationPath = public_path('/public/upload/messageFiles/');
            $uploadedImage->move($destinationPath, $imageName);
        }
        return $whatsappResponse;
    }
}
