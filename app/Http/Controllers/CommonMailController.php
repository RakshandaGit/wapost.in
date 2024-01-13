<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactUsMail;
use App\Mail\ContactToAdminMail;
use App\Mail\EnquiryMail;
use App\Mail\EnquiryToAdminMail;
use App\Mail\EmailSubscriptionMail;
use Illuminate\Support\Facades\Mail;

class CommonMailController extends Controller
{ 
    public static function ContactToAdminMail($data){
        Mail::to('care@wapost.net')->send(new ContactToAdminMail($data));
    }

    public static function EnquiryToUserMail($data){
        Mail::to($data['email'])->send(new EnquiryMail($data));
    }
    public static function EnquiryToAdminMail($data){
        Mail::to('care@wapost.net')->send(new EnquiryToAdminMail($data));
    }

    public static function ContactToUserMail($data){
        Mail::to($data['email'])->send(new ContactUsMail($data));
    }

    public static function EmailSubscriptionMail($data){
        Mail::to($data['email'])->send(new EmailSubscriptionMail($data));
    }

}
