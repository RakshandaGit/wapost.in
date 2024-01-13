<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class MessageDataFormatter
{
    public function getMessageFormattedData($request, $connection, $numbers, $isFile = false)
    {
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
        
        $type = $request->mediaType;

        if ($type == 'specifiedFile') {
            $type = $request->fileType;
        }

        $param = [];
        $data = [
            'key_id' => auth()->user()->key_id,
            'key_secret' => auth()->user()->key_secret,
            'sender' => $connection->number,
            'numbers' => $numbers,
            'type' => $type,
        ];

        if ($type == 'text') {
            $inData = [
                'message' => $request->message
            ];

            $param['form_params'] = $inData;
        } elseif ($type == 'contact') {
            $phonenumber = $request->phonenumber ?? null;
            if($phonenumber){
                $phonenumber = Helper::formatMobileNumber($phonenumber);
            }

            $vcard = [
                'fullName'      => $request->fullname,
                'displayName'   => $request->displayname,
                'organization'  => $request->organization,
                'phoneNumber'   => $phonenumber
            ];

            $inData = ['vcard' => $vcard];
            $param['form_params'] = $inData;
        } elseif ($type == 'button') {

            $buttons = [];
            if (empty($request->reply_button_title) && empty($request->call_button) && empty($request->url_button_title)) {
                return [
                    'status'  => 'error',
                    'message' => 'Please Add One Or More Buttons',
                    'data' => ""
                ];
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

            $inData = ['btndata' => $btndata];
            $param['form_params'] = $inData;
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

            $inData = ['msgdata' => $msgdata];
            $param['form_params'] = $inData;
        } elseif ($type == 'mediaButton') {

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
                return [
                    'status'  => 'error',
                    'message' => 'Please Add One Or More Buttons',
                    'data' => ""
                ];
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

            $inData = ['btndata' => $btndata];
            $param['form_params'] = $inData;
        } elseif ($type == 'image' || $type == 'video' || $type == 'audio' || $type == 'file') {

            if ($type == 'file') {
                $type = 'doc';
            }

            $file = $_FILES['file'];
            $param['query'] = ['key' => $connection->key];
            $filedata = [];
            foreach ($_FILES as $key => $file) {
                if ($isFile) {
                    $fileSize = $file["size"] / 1000;
                    $content_type = mime_content_type($file['tmp_name']);
                    if ($type == 'doc') {
                        // if ($fileSize > 5120) {
                        if ($fileSize > 16384) {
                            return [
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ];
                        }
                    }
                    if ($type == 'image') {
                        if ($content_type != 'image/jpeg' && $content_type != 'image/png') {
                            return [
                                'status'  => 'error',
                                'message' => 'File Should be Image with Extension JPEG OR PNG',
                                'data' => ""
                            ];
                        }
                        if ($fileSize > 16384) {
                            return [
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ];
                        }
                    }
                    if ($type == 'video') {
                        if ($content_type != 'video/mp4' && $content_type != 'video/3gpp' && $content_type != 'video/x-m4v') {
                            return [
                                'status'  => 'error',
                                'message' => 'File Should be Video with Extension MP4 OR 3GPP',
                                'data' => ""
                            ];
                        }
                        if ($fileSize > 16384) {
                            return [
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ];
                        }
                    }
                    if ($type == 'audio') {
                        if ($content_type != 'audio/aac' && $content_type != 'audio/mp3' && $content_type != 'audio/amr' && $content_type != 'audio/mpeg') {
                            return [
                                'status'  => 'error',
                                'message' => 'File Should be Audio with Extension AAC, MP3, AMR OR MPEG',
                                'data' => ""
                            ];
                        }
                        if ($fileSize > 16384) {
                            return [
                                'status'  => 'error',
                                'message' => 'File Size Should be less than 16MB',
                                'data' => ""
                            ];
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
                }
                // array_push($filedata, ['name' => 'id', 'contents' => $request->number]);
                if ($type == 'doc') {
                    array_push($filedata, ['name' => 'filename', 'contents' => $file['filename']]);
                }

                // if ($type != 'audio' && $type != 'doc')
                if ($type != 'audio')
                    array_push($filedata, ['name' => 'caption', 'contents' => $request->caption]);

                array_push($filedata, ['name' => 'numbers', 'contents' => json_encode($numbers)]);

                unset($data['numbers']);
            }

            $param['multipart'] = $filedata;
        }

        $newData = array_merge($data, $param);
        return $newData;
    }
}
