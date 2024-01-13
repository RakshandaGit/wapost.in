<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Plan;
use App\Models\User;
use App\Models\BlogsSetting;
use Illuminate\Http\Request;
use App\Models\EmailSubscriber;
use App\Http\Controllers\CommonMailController;

class PageController extends Controller
{
    //

    public function home(){

        return view('website.home');
    }

    public function pricing(){
        $plans = Plan::where('status', 1)->where('show_in_customer', 1)->pluck('id')->toArray();
        return view('website.pricing')->with(['plans' => $plans]);
    }

    public function about_us(){

        return view('website.about-us');
    }

    public function contact_us(){

        return view('website.contact-us');
    }

    public function terms_condition(){

        return view('website.terms-condition');
    }

    public function privacy_policy(){

        return view('website.privacy-policy');
    }

    public function refund_policy(){

        return view('website.refund-policy');
    }
    public function dashboard(){

        return view('website.documentation.dashboard');
    }
    public function connection(){

        return view('website.documentation.connection');
    }
    public function contacts(){

        return view('website.documentation.contacts');
    }
    public function blacklist(){

        return view('website.documentation.blacklist');
    }
    public function quicksend(){

        return view('website.documentation.quicksend');
    }
    public function campaign_builder(){

        return view('website.documentation.campaign-builder');
    }
    public function reports(){

        return view('website.documentation.reports');
    }
    public function sent_messages(){

        return view('website.documentation.sent-messages');
    }
    public function features(){

        return view('website.features');
    }

    public function blog(Request $request)
    {
        
        $setting = BlogsSetting::first();
        
        if (!empty($request->src)) {
            $letestBlog = Blog::with('author')->where('title', 'like', '%' . $request->src . '%')->orderBy('id', 'desc')->where('status', 1)->paginate(6);
        }else {
            $letestBlog = Blog::with('author')->orderBy('id', 'desc')->where('status', 1)->paginate(6);
        }

        $featuredBlog = Blog::orderBy('id', 'asc')->where('status', 1)->limit(3)->get();
        // if ($letestBlog != null) {
        //     $blogs = Blog::with('author')->orderBy('id', 'desc')->where('id', '<>', $letestBlog->id)->where('status', 1)
        //     ->paginate(1);
        // }else {
        //     $blogs = '';
        // }
        

        return view('website.blog', compact('letestBlog', 'featuredBlog', 'setting', 'request'))->with('i', (request()->input('page', 1) - 6) * 6);
    }

    public function blog_details(Request $request,$slug){
        $blog = Blog::with('author')->where('slug', $slug)->where('status', 1)->first();
        $featuredBlog = Blog::orderBy('id', 'asc')->where('status', 1)->limit(3)->get();
        if (!empty($request->src)) {
            $featuredBlog = Blog::where('title', 'like', '%' . $request->src . '%')->orderBy('id', 'asc')->where('status', 1)->limit(3)->get();
        }else {
            $featuredBlog = Blog::orderBy('id', 'asc')->where('status', 1)->limit(3)->get();
        }

        if(!$blog){
            return view('errors.404');
        }else{
            // $user = User::where('id',$blog->user_id)->orderBy('id','desc')->first();
            $setting = BlogsSetting::first();
        }

        return view('website.blog-details', compact('request','blog','setting', 'featuredBlog'));

    }
    public function blog_details2(){
        return view('website.blog-details2');
    }
    public function registration(){

        return view('website.registration');
    }
    public function thank_you(){

        return view('website.thank-you');
    }

    public function subscribe(Request $request){

        $rules = [
            'email' => 'required', 
        ];

        $messages = [
            'email.required' => 'Email can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $email = $request->email;
            
            if($email != '') {
                $check = EmailSubscriber::where('email', $email)->first();
            }

            if($check){
                return response()->json([
                    'status' => true,
                    'message' => 'Thank You! Your email Successfully subscibed.'
                ]);
            }else{
                $subsciber = new EmailSubscriber;
                $subsciber->email = $email;
                $subsciber->status = 1;
                $subsciber->save();

                /* Sending email */
                $data = [
                    'email' => $email
                ];
                
                CommonMailController::EmailSubscriptionMail($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Thank You! Your email Successfully subscibed.'
                ]);
                
            }
    }
}