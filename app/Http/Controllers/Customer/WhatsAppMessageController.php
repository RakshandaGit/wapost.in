<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\User;
use App\Models\Blacklists;
use App\Helpers\Api;
use App\Helpers\Helper;
use Auth;

class WhatsAppMessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('login')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $connections = Connection::where('user_id', Auth::user()->id)->where('status', 1)->get();
        $connKeys = [];
        $connNumbers = [];
        if (count($connections) == 0) {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.labels.wa_logout_msg'),
                'data' => ""
            ]);
        } else {
            foreach ($connections as $conn) {
                $connKeys[] = $conn->key;
                $connNumbers[] = $conn->number;
            }
        }

        $type = $request->mediaType;
        $whatsappResponse = null;
        $numbers = preg_split("/[;,\r\n]+/", $request->number);

        $senderKey = $connKeys[array_rand($connKeys, 1)];
        $senderNumber = $connNumbers[array_rand($connKeys, 1)];
        
        if (count($numbers) == 1) {
            $number = Helper::formatMobileNumber($numbers[0]);
            $blacklists = Blacklists::query()->where('user_id', auth()->user()->id)->where('number', $number)->count();
            if (!empty($blacklists)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'This Number is Blacklisted',
                    'data' => ""
                ]);
            }

            $checkWhatsappNumber = Api::checkWhatsNumber(['key' => $connKeys[0], 'id' => $number]);

            if ($checkWhatsappNumber) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'This Number is not Whatsapp Number',
                    'data' => $number
                ]);
            }

            // if (strlen($number) < 12 || strlen($number) > 13) {
            if (count($numbers) == 1 && strlen($number) != 12 && !$number) {
                return response()->json([
                    'status'  => 'error',
                    // 'message' => 'Please Enter Country Code Number',
                    'message' => 'Please Enter The Valid Number',
                    'data' => ""
                ]);
            }
        }

        if ($request->mediaType == 'text' && ($request->message == null || $request->message == '')) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Please Enter Message',
                'data' => ""
            ]);
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $uploadedImage = $request->file('file');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            // $uploadedImage->move($destinationPath, $imageName);
            $filePath = env('APP_URL') . '/public/public/upload/messageFiles/' . $imageName;
        }

        foreach ($numbers as $k => $number) {
            $number = Helper::formatMobileNumber($number);
            
            $blacklists = Blacklists::where('user_id', auth()->user()->id)->where('number', $number)->count();
            if (!empty($blacklists)) {
                continue;
            }

            $number = Helper::formatMobileNumber($number);
            if (strlen($number) != 12) {
                continue;
            }

            $checkWhatsappNumber = Api::checkWhatsNumber(['key' => $connKeys[0], 'id' => $number]);
            if ($checkWhatsappNumber) {
                continue;
            }

            $senderKey = $connKeys[array_rand($connKeys, 1)];
            $senderNumber = $connNumbers[array_rand($connKeys, 1)];

            $param = [];
            // $param['query'] = ['key' => $connection->key];
            if(isset($request->message)){
                $getLast2str = substr($request->message, -2);
                if($getLast2str == '\n'){
                    $request->message = substr($request->message, 0, -2);
                }
                $request->message = str_replace('\n', "\n", $request->message);
            } elseif(isset($request->caption)){
                $getLast2str = substr($request->caption, -2);
                if($getLast2str == '\n'){
                    $request->caption = substr($request->caption, 0, -2);
                }
                $request->caption = str_replace('\n', "\n", $request->caption);
            }

            $param['query'] = ['key' => $senderKey];
            if ($type == 'text') {
                $data = ['id' => $number, 'message' => $request->message];
                $headers = [
                    'Content-Type' => 'application/json',
                ];

                $param['form_params'] = $data;
            } elseif ($type == 'contact') {
                $vcard = [
                    'fullName'      => $request->fullname,
                    'displayName'   => $request->displayname,
                    'organization'  => $request->organization,
                    'phoneNumber'   => Helper::formatMobileNumber($request->phonenumber)
                ];
                $data = ['id' => $number, 'vcard' => $vcard];
                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $param['form_params'] = $data;
            } elseif ($type == 'button') {

                $buttons = [];
                if (empty($request->reply_button_title) && empty($request->call_button) && empty($request->url_button_title)) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Please Add One Or More Buttons',
                        'data' => ""
                    ]);
                }
                if (!empty($request->reply_button_title)) {
                    $buttons[] = [
                        'type' => 'replyButton',
                        'title' => $request->reply_button_title
                    ];
                }
                if (!empty($request->url_button_title)) {
                    $buttons[] = [
                        'type' => 'urlButton',
                        'title' => $request->url_button_title,
                        'payload' => $request->url_button_payload
                    ];
                }
                if (!empty($request->call_button)) {
                    $buttons[] = [
                        'type' => 'urlButton',
                        'title' => $request->call_button,
                        'payload' => $request->call_button_payload
                    ];
                }
                $btndata = [
                    'text'      => $request->message,
                    'buttons'   => $buttons,
                    'footerText'  => $request->footertext
                ];
                $data = ['id' => $number, 'btndata' => $btndata];
                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $param['form_params'] = $data;
            } elseif ($type == 'list') {

                $msgdata = $sections = [];

                $sections['title'] = $request->list_title;
                foreach ($request->row_title as $key => $val) {
                    $sections['rows'][$key]['title'] = $val;
                    $sections['rows'][$key]['description'] = $request->row_desc[$key];
                    $sections['rows'][$key]['rowId'] = 'string';
                }
                $msgdata = [
                    'buttonText'    => $request->button_text,
                    'text'          => $request->message,
                    'title'         => $request->title,
                    'description'   => $request->description,
                    'sections'      => [$sections],
                    'listType'      => 0
                ];
                $data = ['id' => $number, 'msgdata' => $msgdata];
                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $param['form_params'] = $data;
            } elseif ($type == 'MediaButton') {

                $btndata = $buttons = $button1 = $button2 = [];
                if (!empty($request->reply_button)) {
                    $button1['type'] = 'replyButton';
                    $button1['title'] = $request->reply_button;
                }
                if (!empty($request->call_button)) {
                    $button2['type'] = 'callButton';
                    $button2['title'] = $request->call_button;
                    $button2['payload'] = $request->call_button_payload;
                }
                if (!empty(count($button1)) || !empty(count($button2))) {
                    if (!empty(count($button1)))
                        $buttons[] = $button1;
                    if (!empty(count($button2)))
                        $buttons[] = $button2;
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Please Add One Or More Buttons',
                        'data' => ""
                    ]);
                }
                $media_type = $request->media_file_type;

                $file = $request->file('button_media_file');
                //Move Uploaded File
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $file->getClientOriginalName());
                $url = $request->getSchemeAndHttpHost() . "/" . $destinationPath . "/" . $file->getClientOriginalName();

                $btndata = [
                    'text'          => $request->title,
                    'buttons'       => $buttons,
                    'footerText'    => $request->footertext,
                    'image'         => $url, //$request->button_media_file,
                    'mediaType'     => "image", //$media_type,
                    'mimeType'      => "image/jpeg" //$request->media_file_mime,
                ];
                $data = ['id' => $number, 'btndata' => $btndata];
                $headers = [
                    'Content-Type' => 'application/json',
                ];
                $param['form_params'] = $data;
            } elseif ($type == 'image' || $type == 'video' || $type == 'audio' || $type == 'file') {
                if ($type == 'file') {
                    $type = 'doc';
                }
                $file = $_FILES['file']; //$request->file('image_file');
                $param['query'] = ['key' => $senderKey];

                $filedata = [];
                foreach ($_FILES as $key => $file) {
                    $fileSize = $file["size"] / 1000;
                    $content_type = mime_content_type($file['tmp_name']);
                    if ($type == 'doc') {
                        if ($fileSize > 16384) {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ]);
                        }
                    }
                    if ($type == 'image') {
                        if ($content_type != 'image/jpeg' && $content_type != 'image/png') {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Should be Image with Extension JPEG OR PNG',
                                'data' => ""
                            ]);
                        }

                        if ($fileSize > 16384) {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ]);
                        }
                    }
                    if ($type == 'video') {
                        if ($content_type != 'video/mp4' && $content_type != 'video/3gpp' && $content_type != 'video/x-m4v') {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Should be Video with Extension MP4 OR 3GPP',
                                'data' => ""
                            ]);
                        }
                        if ($fileSize > 16384) {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ]);
                        }
                    }
                    if ($type == 'audio') {
                        if ($content_type != 'audio/aac' && $content_type != 'audio/mp3' && $content_type != 'audio/amr' && $content_type != 'audio/mpeg') {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Should be Audio with Extension AAC, MP3, AMR OR MPEG',
                                'data' => ""
                            ]);
                        }
                        if ($fileSize > 16384) {
                            return response()->json([
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ]);
                        }
                    }

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
                    if ($type == 'doc')
                        array_push($filedata, ['name' => 'filename', 'contents' => $file['filename']]);

                    // if($type != 'audio' && $type != 'doc')
                    if ($type != 'audio')
                        array_push($filedata, ['name' => 'caption', 'contents' => $request->caption]);

                    $request->message = $request->caption;
                }

                $param['multipart'] = $filedata;
            }

            $url = 'https://api.wapost.net/message/' . $type . '?key=' . $senderKey;
            $headers = [
                "Content-Type" => "multipart/form-data"
            ];

            $dataParams = [
                "param"     => $param,
                "type"      => $type,
                "key"       => $senderKey,
                // "from"      => $connection->number,
                "from"      => $senderNumber,
                "headers"   => $headers
            ];

            $requestedMessage = [
                'message' => $request->hasFile('file') ? $request->caption : (isset($request->message) ? $request->message : null),
                'filePath' => $filePath,
                'mediaType' => $request->mediaType ?? null,
                'fullname' => $request->fullname ?? null,
                'displayname' => $request->displayname ?? null,
                'organization' => $request->organization ?? null,
                'phonenumber' => $request->phonenumber ?? null
            ];

            if ($type == 'doc') {
                $type = 'file';
            }

            $whatsappResponse = Api::sendWhatsappMsg($dataParams, $requestedMessage);
        }

        if ($request->hasFile('file')) {
            $destinationPath = public_path('/public/upload/messageFiles/');
            $uploadedImage->move($destinationPath, $imageName);
        }

        return $whatsappResponse;
    }
}
