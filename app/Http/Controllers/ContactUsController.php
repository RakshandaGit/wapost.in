<?php

namespace App\Http\Controllers;

use App\Models\AdminMessage;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

use App\Models\EmailSubscriber;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SalesroboController;

class ContactUsController extends Controller
{

    public function postContact(Request $request){

        /* Save Contact for data to the DATABASE */
        $message = new ContactMessage;
        $message->name = $request->name;
        $message->mobile = $request->mobile;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message
        ];
        CommonMailController::ContactToAdminMail($data);
        CommonMailController::ContactToUserMail($data);
       
        $return = array( "status" => true, "type" => "success", "message" => "Thank you for getting in touch! We have received your message and one of our executive will get back in touch with you soon.");
        return json_encode($return);
    }
    
    public function postEnquiry(Request $request){
        // dd('test');
        /* Save Contact for data to the DATABASE */
        $message = new ContactMessage;
        $message->name = $request->name;
        $message->mobile = $request->mobile;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message
        ];
        CommonMailController::EnquiryToUserMail($data);
        CommonMailController::EnquiryToAdminMail($data);
       
        $return = array( "status" => true, "type" => "success", "message" => "Thank you for getting in touch! We have received your message and one of our executive will get back in touch with you soon.");

        return json_encode($return);
    }
    
    public function subscribe(Request $request){
        $phone = $request->phone;
        $email = $request->email;
        $type = $request->type;
        $msgAlSub = ($type == 'subscribe_email')?"Email":"Phone Number";
        if($phone != '' || $email != ''){
            if($type == 'subscribe_email')
                $check = EmailSubscriber::where('email', $email)->first();
            else
                $check = EmailSubscriber::where('phone', $phone)->first();
            
            if($check){
                echo json_encode(array("status" => false, "type"=>"success", "message"=>"Your ".$msgAlSub." is already subscribed."));
            }else{
                $subsciber = new EmailSubscriber;
                $subsciber->phone = $phone;
                $subsciber->email = $email;
                $subsciber->save();

                /* Sending email */
                $data = [
                    'email' => $email
                ];
                if($type == 'subscribe_email')
                    \App\Http\Controllers\CommonMailController::EmailSubscriptionMail($data);

                echo json_encode(array("status" => true, "type"=>"success", "message"=>"Thank You! Your ".$msgAlSub." Successfully subscibed."));
            }
                
        }else{
            echo json_encode(array("status" => false, "type"=>"error", "message"=>"Please Enter Valid ".$msgAlSub."."));
        }

    }
}
