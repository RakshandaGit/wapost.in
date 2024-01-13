<?php

namespace App\Http\Controllers\Partner;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reports;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Invoices;
use App\Models\Customer;
use App\Models\User;
use App\Rules\Phone;
use Illuminate\Support\Facades\Auth;
use App\Models\Senderid;
use App\Models\Language;
use App\Models\MessageTransaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\PartnerTransaction;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionLog;
use App\Models\SubscriptionTransaction;
use App\Notifications\WelcomeEmailNotification;
use App\Repositories\Contracts\AccountRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use AWS\CRT\HTTP\Message;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class UserController extends Controller
{
    protected AccountRepository $account;
    protected SubscriptionRepository $subscriptions;

    function __construct(AccountRepository $account, SubscriptionRepository $subscriptions)
    {
        $this->middleware('guest');
        $this->account       = $account;
        $this->subscriptions = $subscriptions;
    }

    public function index()
    {
        $breadcrumbs = [
            ['name' => __('locale.menu.users')],
        ];

        $languages = Language::where('status', 1)->get();

        return view('partner.users.index', compact('breadcrumbs', 'languages'));
    }

    public function ajaxPartnerUsers(Request $request)
    {

        $columns = [
            '0' => 'enterprise_user_id',
            '1' => 'first_name',
            '2' => 'phone',
            '3' => 'email'
        ];
        // request in get input field
        $totalData = User::where('parent_id', Auth::user()->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column') ?? 0; // Get column index
        $order = $columns[$orderColumnIndex] ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';
        $search = $request->input('search.value') ?? '';

        $partnerQuery = User::with('availableMessage')->where('parent_id', Auth::user()->id);

        if ($search != '') {
            $partnerQuery->whereLike(['first_name', 'last_name', 'phone', 'email'], $search);
            $totalFiltered = $partnerQuery->whereLike(['first_name', 'last_name', 'phone', 'email'], $search)->count();
        }

        $partner_users = $partnerQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();


        $data = [];
        // foreach loop filter records
        if (!empty($partner_users)) {
            foreach ($partner_users as $partner_user) {
                $availableBalance =  $partner_user->availableMessage ? $partner_user->availableMessage?->balance : 0;

                $nestedData['responsive_id'] = '';
                $nestedData['enterprise_user_id']          = $partner_user->enterprise_user_id;
                $nestedData['name']          = $partner_user->first_name . ' ' . $partner_user->last_name;
                $nestedData['phone']          = $partner_user->phone;
                $nestedData['email']          = $partner_user->email;
                $nestedData['available_message'] = $availableBalance;
                $nestedData['edit'] = route('Partner.user-edit', $partner_user->id);
                $nestedData['editAllocate'] = route('Partner.userTransactions', ['user_id' => $partner_user->id]);
                $data[]               = $nestedData;
            }
        }

        // return response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => url("partner/users"), 'name' => __('locale.menu.users')],
            ['name' => __('New User')],
        ];
        return view('partner.users.create', compact('breadcrumbs'));
    }

    /**
     *
     * add new customer
     *
     * @param  StoreCustomerRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        // validation
        $request->validate([
            'enterprise_user_id' => 'required', 'string',
            'first_name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'phone'  => 'required',  'numeric', 'unique:users',
            'password'   => 'required', 'string', 'min:8', 'confirmed',
        ]);

        $parentId = Auth::user()->id;

        if (User::where(['parent_id' => $parentId, 'enterprise_user_id' => $request->enterprise_user_id])->first()) {
            return back()->with([
                'status'  => 'error',
                'message' => __('The user has already been added.'),
            ]);
        }

        $data = $request->except('_token');
        $plan = Plan::where('name', 'Free')->first();
        $data['is_login_require'] = false;
        $user = $this->account->register($data);

        if ($plan->price == 0.00) {
            $subscription                         = new Subscription();
            $subscription->user_id                = $user->id;
            $subscription->start_at               = Carbon::now();
            $subscription->status                 = Subscription::STATUS_ACTIVE;
            $subscription->plan_id                = $plan->getBillableId();
            $subscription->end_period_last_days   = '10';
            // $subscription->current_period_ends_at = $subscription->getPeriodEndsAt(Carbon::now());
            $intervalCount = 120;
            $subscription->current_period_ends_at = $subscription->getPeriodEndsAt(Carbon::now(), $intervalCount);
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
            $user->parent_id =  $parentId;
            $user->enterprise_user_id = $request->enterprise_user_id;
            $user->is_enterprise = 0;
            $user->save();
        }

        return redirect()->route('Partner.partners')->with([
            'status'  => 'success',
            'message' => __('You have created user successfully.'),
        ]);
    }

    public function bulkCreate()
    {
        $breadcrumbs = [
            ['link' => url("partner/users"), 'name' => __('locale.menu.users')],
            ['name' => __('Bulk Create Users')],
        ];
        return view('partner.users.bulk-create', compact('breadcrumbs'));
    }
    public function validateEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true; // Valid email address
        } else {
            return false; // Invalid email address
        }
    }
    public function bulkStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,txt'
        ], [
            'file.required' => 'The file field is required.',
            'file.mimes' => 'The selected file should be of type: xls, xlsx, csv, txt',
        ]);

        $parentId = Auth::user()->id;
        $plan = Plan::where('name', 'Free')->first();
        if ($request->file('file')->isValid()) {
            $data = Excel::toArray(new stdClass(), $request->file('file'))[0];

            foreach ($data as $key => $val) {
                if ($val[0] != null) {
                    $enterpriceUserId  = $val[0];
                    $firstname = isset($val[1]) ? trim($val[1]) : null;
                    $lastname = isset($val[2]) ? trim($val[2]) : null;
                    $email = $val[3];
                    $phone = Helper::formatMobileNumber($val[4]);
                    $password = $val[5] ?? null;

                    if (strlen($phone) == 12 && is_numeric($phone) && $firstname && $email && $password && strlen($password) >= 8) {
                        $isCheckUser = User::where('email', $email)->orWhere('phone', $phone)->first();
                        $isCheckEnterpriceUse = User::where(['parent_id' => $parentId, 'enterprise_user_id' => $enterpriceUserId])->first();
                        if ($isCheckUser || $isCheckEnterpriceUse || !$this->validateEmail($email)) {
                            continue;
                        }
                        $registerData = [
                            "enterprise_user_id" => $enterpriceUserId,
                            "first_name" =>  $firstname,
                            "last_name" => $lastname,
                            "phone" => $phone,
                            "email" => $email,
                            "password" => $password,
                            "password_confirmation" => $password,
                            "is_login_require" => false
                        ];

                        $user = $this->account->register($registerData);

                        if ($plan->price == 0.00) {
                            $subscription                         = new Subscription();
                            $subscription->user_id                = $user->id;
                            $subscription->start_at               = Carbon::now();
                            $subscription->status                 = Subscription::STATUS_ACTIVE;
                            $subscription->plan_id                = $plan->getBillableId();
                            $subscription->end_period_last_days   = '10';
                            $intervalCount = 120;
                            $subscription->current_period_ends_at = $subscription->getPeriodEndsAt(Carbon::now(), $intervalCount);
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

                            $user->phone = $phone;
                            $user->parent_id = $parentId;
                            $user->enterprise_user_id = $enterpriceUserId;
                            $user->is_enterprise = 0;
                            $user->save();
                        }
                    }
                }
            }
        }

        return redirect()->route('Partner.partners')->with([
            'status'  => 'success',
            'message' => __('You have created user successfully.'),
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('partner.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'enterprise_user_id' => 'required', 'string',
            'first_name' => 'required', 'string', 'max:255',
            'last_name' => 'required', 'string', 'max:255',
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $id],
            'phone' => ['required', 'numeric', 'unique:users,phone,' . $id]
        ]);

        $parentId = Auth::user()->id;

        if (User::where(['parent_id' => $parentId, 'enterprise_user_id' => $request->enterprise_user_id])->whereNot('id', $id)->first()) {
            return back()->with([
                'status'  => 'error',
                'message' => __('The user has already been added.'),
            ]);
        }

        $user = User::find($id);
        $user->enterprise_user_id = $request->enterprise_user_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();

        return redirect()
            ->route('Partner.partners')
            ->with([
                'status' => 'success',
                'message' => __('User updated Successfully.'),
            ]);
    }
    /**
     * View customer for edit
     *
     * @param  User  $user
     *
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     */

    public function allocate()
    {
        $breadcrumbs = [
            ['name' => __('locale.menu.transactions')],
        ];
        $user = Auth::user();
        $pendingTransaction = PartnerTransaction::where(['user_id' => $user->id, 'status' => 'pending'])->orderBy('id', 'desc')->first();
        $availableTransaction = PartnerTransaction::where(['user_id' => $user->id, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        $requestedBalance = $pendingTransaction ? $pendingTransaction->credit : 0;
        $availableBalance =  $availableTransaction ? $availableTransaction->balance : 0;

        return view('partner.transactions', compact('breadcrumbs', 'user', 'requestedBalance', 'availableBalance'));
    }

    public function allocateUserShow(Request $request)
    {
        $columns = [
            '0' => 'user_id',
            '1' => 'credit',
            '2' => 'status',
        ];

        // request in get input field
        $user = Auth::user();
        $totalData = PartnerTransaction::where('user_id', $user->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column') ?? 0; // Get column index
        $order = $columns[$orderColumnIndex] ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';
        $search = $request->input('search.value') ?? '';

        $partnerTxnsQuery = PartnerTransaction::where('user_id', $user->id);
        if ($search != '') {
            $partnerTxnsQuery->whereLike(['user_id', 'status'], $search);
        }

        $partnerTxns = $partnerTxnsQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = $partnerTxnsQuery->count();

        //total records count
        $data = [];
        if (!empty($partnerTxns)) {
            foreach ($partnerTxns as $partnerTxn) {
                $nestedData['responsive_id'] = '';
                // $nestedData['enterprise_user_id']          = $partnerTxn->user->enterprise_user_id;
                $nestedData['name']          = $partnerTxn->user->displayName();
                $nestedData['credit']          = $partnerTxn->credit;
                $nestedData['debit']          = $partnerTxn->debit;
                $nestedData['balance']          = $partnerTxn->balance;
                $nestedData['remark']          = $partnerTxn->remark;
                $data[]               = $nestedData;
            }
        }

        // return response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function allocateMessage(Request $request)
    {
        $breadcrumbs = [
            ['link' => url("partner/transactions"), 'name' => __('locale.menu.transactions')],
            ['name' => __('Allocate Messages')],
        ];
        $parentId = Auth::user()->id;
        // $pendingTransaction = PartnerTransaction::where(['user_id' => $parentId, 'status' => 'pending'])->orderBy('id', 'desc')->first();
        $availableTransaction = PartnerTransaction::where(['user_id' => $parentId, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        // $requestedBalance = $pendingTransaction ? $pendingTransaction->credit : 0;
        $availableBalance =  $availableTransaction ? $availableTransaction->balance : 0;
        $users = User::where(['parent_id' => $parentId, 'is_enterprise' => 0])->get();

        $userId = $request->user_id ?? null;
        $tansactions = MessageTransaction::where('user_id', $parentId)->first();
        return view('partner.allocate.allocate-message', ['users' => $users, 'availableBalance' => $availableBalance, 'userId' => $userId], compact('breadcrumbs', 'tansactions'));
    }

    public function assginMessagesToUser(Request $request)
    {
        // validation
        $request->validate([
            'user_id' => 'required', 'string', 'max:255',
            'message_qty' => 'required', 'string'
        ]);

        if ($request->message_qty > $request->avaliable_message) {
            return back()->with([
                'status'  => 'error',
                'message' => __('The message quantity exceeds the available quantity.'),
            ]);
        }

        if ($request->message_qty <= 0) {
            return back()->with([
                'status'  => 'error',
                'message' => __('The quantity should be greater than 0.'),
            ]);
        }

        $parentId = Auth::user()->id;
        $parentName = Auth::user()->displayName();
        $userName = User::find($request->user_id)->displayName();

        $pUserBalance = 0;
        $availablePartnerUserMessage = PartnerTransaction::where(['user_id' => $request->user_id])->orderBy('id', 'desc')->first();
        if ($availablePartnerUserMessage) {
            $pUserBalance = $availablePartnerUserMessage->balance;
        }

        $availablePartnerMessage = PartnerTransaction::where(['user_id' => $parentId, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        $ptBalance = 0;
        if ($availablePartnerMessage) {
            $ptBalance = $availablePartnerMessage->balance;
        }

        PartnerTransaction::create([
            'user_id' => $request->user_id,
            'credit' => $request->message_qty,
            'balance' => $pUserBalance + $request->message_qty,
            'status' => 'approved',
            'remark' => 'Allocated by ' . $parentName
        ]);

        PartnerTransaction::create([
            'user_id' => $parentId,
            'debit' => $request->message_qty,
            'balance' => $ptBalance - $request->message_qty,
            'status' => 'approved',
            'remark' => 'Allocated to ' . $userName
        ]);

        $lastPUserTransaction = MessageTransaction::where('user_id', $request->user_id)->orderBy('id', 'desc')->first();
        $mtBalance = 0;
        if ($lastPUserTransaction) {
            $mtBalance = $lastPUserTransaction->balance;
        }

        MessageTransaction::create([
            'user_id' => $request->user_id,
            'credit' => $request->message_qty,
            'balance' => $mtBalance + $request->message_qty,
            'remark' => 'Credited by ' . $parentName
        ]);

        return redirect()->route('Partner.allocateMessage')->with([
            'status'  => 'success',
            'message' => __("You have successfully allocated $request->message_qty messages to $userName."),
        ]);
    }

    public function userTransactions($userId)
    {
        $breadcrumbs = [
            ['link' => url("partner/users"), 'name' => __('locale.menu.users')],
            ['name' => __('locale.menu.transactions')]
        ];

        $availableTransaction = MessageTransaction::where(['user_id' => $userId])->orderBy('id', 'desc')->first();
        $availableBalance =  $availableTransaction ? $availableTransaction->balance : 0;

        $tansactions = MessageTransaction::where('user_id', $userId)->get();
        return view('partner.users.transactions', compact('breadcrumbs', 'tansactions', 'availableBalance', 'userId'));
    }

    public function userAllocateMessagesShow(Request $request, $userId)
    {
        $columns = [
            '0' => 'user_id',
            '1' => 'credit',
            '2' => 'status',
        ];

        $totalData = MessageTransaction::where('user_id', $userId)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column') ?? 0; // Get column index
        $order = $columns[$orderColumnIndex] ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';
        $search = $request->input('search.value') ?? '';
        $partnerTxnsQuery = MessageTransaction::where('user_id', $userId);
        if ($search != '') {
            $partnerTxnsQuery->whereLike(['user_id', 'status'], $search);
            $totalFiltered = $partnerTxnsQuery->whereLike(['user_id', 'status'], $search)->count();
        }

        $partnerTxns = $partnerTxnsQuery->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        //total records count
        $data = [];
        if (!empty($partnerTxns)) {
            foreach ($partnerTxns as $partnerTxn) {
                // dd($partnerTxn);
                $nestedData['responsive_id'] = '';
                // $nestedData['enterprise_user_id']          = $partnerTxn->user->enterprise_user_id;
                $nestedData['name']          = $partnerTxn->user->displayName();
                $nestedData['credit']          = $partnerTxn->credit;
                $nestedData['debit']          = $partnerTxn->debit;
                $nestedData['balance']          = $partnerTxn->balance;
                $nestedData['remark']          = $partnerTxn->remark;
                $data[]               = $nestedData;
            }
        }

        // return response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
    public function invoice()
    {
        $breadcrumbs = [
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("partner/users"), 'name' => __('locale.menu.users')],
            ['name' => __('Invoice')],
        ];
        return view('partner.invoice', compact('breadcrumbs'));
    }
}
