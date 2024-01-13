<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Connection;
use App\Models\PartnerContact;
use App\Models\Plan;
use App\Models\Senderid;
use App\Models\Subscription;
use App\Models\SubscriptionLog;
use App\Models\SubscriptionTransaction;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PartnerController extends Controller
{
    protected AccountRepository $account;
    protected SubscriptionRepository $subscriptions;
    public $wa_api_url;

    function __construct(AccountRepository $account, SubscriptionRepository $subscriptions)
    {
        $this->middleware('guest');
        $this->account       = $account;
        $this->subscriptions = $subscriptions;
        $this->wa_api_url = env('WA_API_URL');
    }

    public function becomePartner()
    {
        return view('website.become-partner');
    }
    public function thankYouPartner()
    {
        return view('website.thank-you-partner');
    }

    public function storePartner(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'nullable|string',
            'mobile' => 'required|numeric|digits:10',
            'email' => 'email',
        ]);
        dd($validatedData);
        PartnerContact::create($validatedData);

        return response()->json(['status' => true, 'message' => 'Thank you for contacting us. We will get back to you soon.']);
    }

    public function posActivation(Request $request)
    {
        $enterpriseId = $request->enterprise_id ?? null;
        $enterpriseUserId = $request->enterprise_user_id ?? null;

        $status = 'success';
        if (!$enterpriseId || !$enterpriseUserId) {
            $status = 'error';
        } else {
            $user = User::where(['id' => $enterpriseId, 'is_enterprise' => 1])->first();
            $checkEnterpriseUser = User::where(['parent_id' => $enterpriseId, 'enterprise_user_id' => $enterpriseUserId])->first();
            if (!$user) {
                $status = 'error';
            } elseif ($checkEnterpriseUser) {
                return redirect("free-connection?enterprise_id=$enterpriseId&enterprise_user_id=$enterpriseUserId&added=1");
            }
        }

        return view("customer.Partner.pos-activation")
            ->with([
                'enterpriseId' => $enterpriseId,
                'enterpriseUserId' => $enterpriseUserId,
                'status' => $status,
                'message' =>
                "The enterprise information provided for the Point of Sale (POS) user is incorrect. Please verify the enterprise details and try again."
            ]);
    }

    public function freeConnection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enterprise_id' => ['required', 'string'],
            'enterprise_user_id' => ['required', 'string'],
        ]);

        // http://localhost:8000/pos-activation?enterprise_id=123&enterprise_user_id=123
        $existed_user_email = null;
        if ($validator->fails()) {
            return back()->with(['status' => 'error', 'message' => "The enterprise information provided for the Point of Sale (POS) user is incorrect. Please verify the enterprise details and try again."]);
        } else {
            $user = User::where(['id' => $request->enterprise_id, 'is_enterprise' => 1])->first();
            if (!$user) {
                return back()->with(['status' => 'error', 'message' => "The enterprise information provided for the Point of Sale (POS) user is incorrect. Please verify the enterprise details and try again."]);
            }
            
            if($enterpriseUser = User::where(['parent_id' => $request->enterprise_id, 'enterprise_user_id' => $request->enterprise_user_id])->first()){
                $existed_user_email = $enterpriseUser->email;
            }
        }

        $is_existed_user = $request->added ? 1 : 0;
        return view("customer.Partner.free-connection")->with([
            "wa_api_url" => $this->wa_api_url,
            "enterprise_id" => $request->enterprise_id,
            "enterprise_user_id" => $request->enterprise_user_id,
            "is_existed_user" => $is_existed_user,
            "existed_user_email" => $existed_user_email
        ]);
    }

    public function registerPOSUser(Request $request)
    {
        $request->validate([
            'enterprise_id' => ['required', 'string'],
            'enterprise_user_id' => ['required', 'string'],
            'whatsapp_details' => 'required',
            'first_name' => 'required|min:2',
            'lastname' => 'nullable|string',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => 'required|numeric|digits:10',
            'email' => ['string', 'email', 'max:255', 'unique:users'],
        ]);


        $data = $request->except('_token');
        $whatsappDetails = json_decode($request->whatsapp_details, true);
        $instance_key = $whatsappDetails['instance_key'];
        $jid = $whatsappDetails['jid'];
        $number = $whatsappDetails['number'];

        $plan = Plan::where('name', 'Free')->first();
        $user = $this->account->register($data);

        if ($plan->price == 0.00) {
            $subscription                         = new Subscription();
            $subscription->user_id                = $user->id;
            $subscription->start_at               = Carbon::now();
            $subscription->status                 = Subscription::STATUS_ACTIVE;
            $subscription->plan_id                = $plan->getBillableId();
            $subscription->end_period_last_days   = '10';
            $subscription->current_period_ends_at = $subscription->getPeriodEndsAt(Carbon::now());
            $subscription->end_at                 = null;
            $subscription->end_by                 = null;
            $subscription->payment_method_id      = null;
            $subscription->save();

            // add transaction
            $subscription->addTransaction(SubscriptionTransaction::TYPE_SUBSCRIBE, [
                'end_at'                 => $subscription->end_at,
                'current_period_ends_at' => $subscription->current_period_ends_at,
                'status'                 => SubscriptionTransaction::STATUS_SUCCESS,
                'title'                  => trans('locale.subscription.subscribed_to_plan', ['plan' => $subscription->plan->getBillableName()]),
                'amount'                 => $subscription->plan->getBillableFormattedPrice(),
            ]);

            // add log
            $subscription->addLog(SubscriptionLog::TYPE_ADMIN_PLAN_ASSIGNED, [
                'plan'  => $subscription->plan->getBillableName(),
                'price' => $subscription->plan->getBillableFormattedPrice(),
            ]);

            $user->sms_unit = $plan->getOption('sms_max');
            if (config('account.verify_account')) {
                $user->sendEmailVerificationNotification();
            } else {
                if (Helper::app_config('user_registration_notification_email')) {
                    $user->notify(new WelcomeEmailNotification($user->first_name, $user->last_name, $user->email, route('login'), $data['password']));
                }
            }

            if (isset($plan->getOptions()['sender_id']) && $plan->getOption('sender_id') !== null) {
                $sender_id = Senderid::where('sender_id', $plan->getOption('sender_id'))->where('user_id', $user->id)->first();
                if (!$sender_id) {
                    $current = Carbon::now();
                    Senderid::create([
                        'sender_id'        => $plan->getOption('sender_id'),
                        'status'           => 'active',
                        'price'            => $plan->getOption('sender_id_price'),
                        'billing_cycle'    => $plan->getOption('sender_id_billing_cycle'),
                        'frequency_amount' => $plan->getOption('sender_id_frequency_amount'),
                        'frequency_unit'   => $plan->getOption('sender_id_frequency_unit'),
                        'currency_id'      => $plan->currency->id,
                        'validity_date'    => $current->add($plan->getOption('sender_id_frequency_unit'), $plan->getOption('sender_id_frequency_amount')),
                        'payment_claimed'  => true,
                        'user_id'          => $user->id,
                    ]);
                }
            }

            $user->phone = Helper::formatMobileNumber($request->phone);
            $user->enterprise_user_id = $request->enterprise_user_id;
            $user->parent_id = $request->enterprise_id;
            $user->save();


            $connection = new Connection();
            $connection->user_id = $user->id;
            $connection->key = $instance_key;
            $connection->jid = $jid;
            $connection->number = $number;
            $connection->status = 1;
            $connection->is_active = 1;
            $connection->save();

            $avatar = $this->getVatar($instance_key, $number);
            $decode_avatar = json_decode($avatar);
            $connection->avatar = $decode_avatar->data;
            $connection->save();

            $this->createInstance($instance_key, $jid, $number, $request->email);

            return redirect('pos-thank-you')->with([
                'status'  => 'success',
                'message' => 'You have successfully registered with the WA Post.',
            ]);
        }

        return back()->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    public function thankYou(Request $request)
    {
        if (isset($request->email) && isset($request->whatsapp_details)) {
            $user = User::where('email', $request->email)->first();
            $connection = Connection::where(['number' => $user->phone, 'user_id' => $user->id])->first();
            $whatsappDetails = json_decode($request->whatsapp_details, true);
            $instance_key = $whatsappDetails['instance_key'];
            $jid = $whatsappDetails['jid'];
            $number = $whatsappDetails['number'];

            if (!$connection) {
                $connection = new connection;
                $connection->user_id = $user->id;
                $connection->key = $instance_key;
                $connection->jid = $jid;
                $connection->number = $number;
                $connection->status = 1;
                $connection->is_active = 1;
                $connection->save();
            } else {
                $connection->user_id = $user->id;
                $connection->key = $instance_key;
                $connection->jid = $jid;
                $connection->number = $number;
                $connection->status = 1;
                $connection->is_active = 1;
                $connection->save();
            }

            $this->createInstance($instance_key, $jid, $number, $request->email);
            $avatar = $this->getVatar($instance_key, $number);
            $decode_avatar = json_decode($avatar);
            $connection->avatar = $decode_avatar->data;
            $connection->save();

            return redirect("pos-thank-you");
        }

        return view("customer.Partner.thank-you");
    }

    public function getVatar($instance_key, $number)
    {
        $postDataArray = [
            'key' => $instance_key,
            'id' => $number
        ];
        $data = http_build_query($postDataArray);
        $ch = curl_init();
        $url = $this->wa_api_url . 'misc/downProfile';
        $getUrl = $url . "?" . $data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    public function createInstance($instance_key, $jid, $number, $email)
    {
        $url = $this->wa_api_url . 'instance/store-pos-user-instance';
        $postDataArray = [
            "key" => $instance_key,
            "jid" => $jid,
            "number" => $number,
            "email" => $email
        ];

        $postData = json_encode($postDataArray, true);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
    public function connectionsList(Request $request)
    {
        $enterpriseId = $request->enterprise_id ?? null;
        $enterpriseUserId = $request->enterprise_user_id ?? null;
        $status = 'success';
        if (!$enterpriseId || !$enterpriseUserId) {
            $status = 'error';
        } else {
            $user = User::where(['id' => $enterpriseId, 'is_enterprise' => 1])->first();
            $checkEnterpriseUser = User::where(['parent_id' => $enterpriseId, 'enterprise_user_id' => $enterpriseUserId])->first();
            if (!$user) {
                $status = 'error';
            } elseif ($checkEnterpriseUser) {
                return redirect("free-connection?enterprise_id=$enterpriseId&enterprise_user_id=$enterpriseUserId&added=1");
            }
        }
        $user = User::where(['is_enterprise' => 1])->get();

        return view("customer.Partner.connection")
            ->with([
                'enterpriseId' => $enterpriseId,
                'enterpriseUserId' => $enterpriseUserId,
                'status' => $status,
                'message' =>
                "The enterprise information provided for the Point of Sale (POS) user is incorrect. Please verify the enterprise details and try again."
            ]);
    }
}
