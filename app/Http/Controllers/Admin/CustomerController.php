<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\GeneralException;
use App\Helpers\Helper;
use App\Http\Requests\Customer\AddUnitRequest;
use App\Http\Requests\Customer\PermissionRequest;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateAvatarRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Requests\Customer\UpdateInformationRequest;
use App\Library\Tool;
use App\Models\Blacklists;
use App\Models\Campaigns;
use App\Models\ChatBox;
use App\Models\ContactGroups;
use App\Models\Customer;
use App\Models\Invoices;
use App\Models\Keywords;
use App\Models\Language;
use App\Models\MessageTransaction;
use App\Models\Notifications;
use App\Models\PhoneNumbers;
use App\Models\Plan;
use App\Models\Reports;
use App\Models\Senderid;
use App\Models\SendingServer;
use App\Models\Subscription;
use App\Models\SubscriptionTransaction;
use App\Models\Templates;
use App\Models\User;
use App\Models\PartnerContact;
use App\Models\PartnerTransaction;
use App\Models\SubscriptionLog;
use App\Repositories\Contracts\CustomerRepository;
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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use JetBrains\PhpStorm\NoReturn;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Auth;
use DB;

class CustomerController extends AdminBaseController
{
    /**
     * @var CustomerRepository
     */
    protected CustomerRepository $customers;

    /**
     * Create a new controller instance.
     *
     * @param  CustomerRepository  $customers
     */
    public function __construct(CustomerRepository $customers)
    {
        $this->customers = $customers;
    }


    /**
     * @return Application|Factory|View
     * @throws AuthorizationException
     */

    public function index(): Factory|View|Application
    {


        $breadcrumbs = [
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Customer')],
            ['name' => __('locale.menu.Customers')],
        ];


        return view('admin.customer.index', compact('breadcrumbs'));
    }


    /**
     * view all customers
     *
     * @param  Request  $request
     *
     * @return void
     * @throws AuthorizationException
     */
    #[NoReturn] public function search(Request $request): void
    {


        $columns = [
            0 => 'responsive_id',
            1 => 'uid',
            2 => 'uid',
            3 => 'name',
            4 => 'subscription',
            5 => 'status',
            6 => 'status',
            7 => 'status',
            8 => 'actions',
        ];

        $totalData = User::where('is_customer', 1)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = User::with('availableMessage')->where('is_customer', 1)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = User::with('availableMessage')->where('is_customer', 1)->whereLike(['uid', 'first_name', 'last_name', 'status', 'email'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('is_customer', 1)->whereLike(['uid', 'first_name', 'last_name', 'status', 'email'], $search)->count();
        }

        $data = [];
        if (!empty($users)) {
            foreach ($users as $user) {
                $availableBalance =  $user->availableMessage ? $user->availableMessage?->balance : 0;
                $show        = route('admin.customers.show', $user->uid);
                $assign_plan = route('admin.subscriptions.create', ['customer_id' => $user->id]);
                $login_as    = route('admin.customers.login_as', $user->uid);

                $assign_plan_label = __('locale.customer.assign_plan');
                $login_as_label    = __('locale.customer.login_as_customer');
                $edit              = __('locale.buttons.edit');
                $delete            = __('locale.buttons.delete');

                if ($user->status === true) {
                    $status = 'checked';
                } else {
                    $status = '';
                }

                if (isset($user->customer) && $user->customer->currentPlanName()) {
                    $subscription = $user->customer->currentPlanName();
                } else {
                    $subscription = __('locale.subscription.no_active_subscription');
                }


                $super_user = true;
                if ($user->id != 1) {
                    $super_user = false;
                }

                $isPOSUser = $user->parent_id != 0;

                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $user->uid;
                $nestedData['avatar']        = route('admin.customers.avatar', $user->uid);
                $nestedData['email']         = $user->email;
                $nestedData['name']          = $user->first_name . ' ' . $user->last_name;
                $nestedData['is_enterprise']         = $user->is_enterprise;
                $nestedData['is_pos_user']         = $isPOSUser ? 1 : 0;

                $nestedData['created_at']    = __('locale.labels.created_at') . ': ' . Tool::formatDate($user->created_at);

                if ($isPOSUser || $user->is_enterprise) {
                    $nestedData['subscription'] = "<div>
                                                    <p class='text-bold-600'>- </p>
                                                </div>";

                    $nestedData['expiry_date'] =  '-';
                } else {
                    $nestedData['subscription'] = "<div>
                                                    <p class='text-bold-600'>$subscription </p>
                                                </div>";

                    $nestedData['expiry_date'] = Tool::customerDateTime($user->customer->subscription->current_period_ends_at);
                }

                $nestedData['available_balance'] = $user->is_enterprise ? $availableBalance : '-';

                $nestedData['status'] = "<div class='form-check form-switch form-check-primary'>
                <input type='checkbox' class='form-check-input get_status' id='status_$user->uid' data-id='$user->uid' name='status' $status>
                <label class='form-check-label' for='status_$user->uid'>
                  <span class='switch-icon-left'><i data-feather='check'></i> </span>
                  <span class='switch-icon-right'><i data-feather='x'></i> </span>
                </label>
              </div>";

                $nestedData['assign_plan']       = $assign_plan;
                $nestedData['assign_plan_label'] = $assign_plan_label;
                $nestedData['login_as']          = $login_as;
                $nestedData['login_as_label']    = $login_as_label;
                $nestedData['show']              = $show;
                $nestedData['show_label']        = $edit;
                $nestedData['delete']            = $user->uid;
                $nestedData['delete_label']      = $delete;
                $nestedData['super_user']        = $super_user;

                $data[] = $nestedData;
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
     * create new customer
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(): Factory|View|Application
    {
        $this->authorize('create customer');

        $breadcrumbs = [
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url(config('app.admin_path') . "/customers"), 'name' => __('locale.menu.Customers')],
            ['name' => __('locale.customer.add_new')],
        ];

        $languages = Language::where('status', 1)->get();

        return view('admin.customer.create', compact('breadcrumbs', 'languages'));
    }

    /**
     *
     * add new customer
     *
     * @param  StoreCustomerRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.index')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }
        $customerData = $request->input();
        $customerData['is_enterprise'] = $request->input('is_enterprise') ? 1 : 0;

        // Create a new customer
        $customer = $this->customers->store($customerData);

        // Upload and save image
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $customer->image = $customer->uploadImage($request->file('image'));
                $customer->save();
            }
        }

        if ($request->is_enterprise == 1) {
            $user = User::where('id', $customer->id)->first();
            $plan = Plan::where('name', 'Free')->first();
            PartnerTransaction::create([
                'user_id' => $user->id,
                'credit' => $request->msg_quantity,
                'balance' => $request->msg_quantity,
                'amount' => $request->amount,
                'status' => 'pending',
                'remark' => 'New Recharge'
            ]);

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
                $user->phone = Helper::formatMobileNumber($request->phone);
                $user->save();
            }
        }

        return redirect()->route('admin.customers.show', $customer->uid)->with([
            'status'  => 'success',
            'message' => __('locale.customer.customer_successfully_added'),
        ]);
    }

    /**
     * View customer for edit
     *
     * @param  User  $customer
     *
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     */

    public function show(User $customer): Factory|View|Application
    {
        $this->authorize('edit customer');

        $breadcrumbs = [
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url(config('app.admin_path') . "/customers"), 'name' => __('locale.menu.Customers')],
            ['name' => $customer->displayName()],
        ];


        $languages = Language::where('status', 1)->get();

        $categories = collect(config('customer-permissions'))->map(function ($value, $key) {
            $value['name'] = $key;

            return $value;
        })->groupBy('category');

        $permissions = $categories->keys()->map(function ($key) use ($categories) {
            return [
                'title'       => $key,
                'permissions' => $categories[$key],
            ];
        });

        $existing_permission = json_decode($customer->customer->permissions, true);
        $pendingTransaction = PartnerTransaction::where(['user_id' => $customer->id, 'status' => 'pending'])->orderBy('id', 'desc')->first();
        $availableTransaction = PartnerTransaction::where(['user_id' => $customer->id, 'status' => 'approved'])->orderBy('id', 'desc')->first();

        $pending_balance = $pendingTransaction ? $pendingTransaction->credit : 0;
        $available_balance =  $availableTransaction ? $availableTransaction->balance : 0;
        return view('admin.customer.show', compact('breadcrumbs', 'customer', 'languages', 'permissions', 'existing_permission', 'pending_balance', 'available_balance'));
    }

    public function assginMessagesToCustomer(Request $request, User $customer)
    {
        // validation
        $request->validate([
            'amount' => 'required', 'string',
            'message_qty' => 'required',
        ]);


        if ($request->message_qty <= 0) {
            return back()->with([
                'status'  => 'error',
                'message' => __('The quantity should be greater than 0.'),
            ]);
        }

        $availablePartnerMessage = PartnerTransaction::where(['user_id' => $customer->id, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        $ptBalance = 0;
        if ($availablePartnerMessage) {
            $ptBalance = $availablePartnerMessage->balance;
        }

        PartnerTransaction::create([
            'user_id' => $customer->id,
            'credit' => $request->message_qty,
            'balance' => $ptBalance + $request->message_qty,
            'status' => 'approved',
            'remark' => 'Allocated by WAPOST'
        ]);

        $lastPUserTransaction = MessageTransaction::where('user_id', $customer->id)->orderBy('id', 'desc')->first();
        $mtBalance = 0;
        if ($lastPUserTransaction) {
            $mtBalance = $lastPUserTransaction->balance;
        }

        MessageTransaction::create([
            'user_id' => $customer->id,
            'credit' => $request->message_qty,
            'balance' => $mtBalance + $request->message_qty,
            'remark' => 'Allocated by WAPOST'
        ]);

        return redirect()->route('admin.customers.show', ['customer' => $customer->uid])->with([
            'status'  => 'success',
            'message' => __("You have successfully allocated $request->message_qty."),
        ]);
    }
    public function approveTransaction(Request $request, User $customer)
    {
        $this->authorize('edit customer');

        // Update the PartnerTransaction status to 'approved'
        PartnerTransaction::where(['user_id' => $customer->id, 'status' => 'pending'])
            ->update(['status' => 'approved']);


        $availablePartnerMessage = PartnerTransaction::where(['user_id' => $customer->id, 'status' => 'approved'])->orderBy('id', 'desc')->first();
        $ptBalance = 0;
        if ($availablePartnerMessage) {
            $ptBalance = $availablePartnerMessage->balance;
        }

        $lastPUserTransaction = MessageTransaction::where('user_id', $customer->id)->orderBy('id', 'desc')->first();
        $mtBalance = 0;
        if ($lastPUserTransaction) {
            $mtBalance = $lastPUserTransaction->balance;
        }

        MessageTransaction::create([
            'user_id' => $customer->id,
            'credit' => $ptBalance,
            'balance' => $mtBalance + $ptBalance,
            'remark' => 'New Recharge'
        ]);

        // PartnerTransaction::create([
        //     'user_id' => $request->user_id,
        //     'credit' => $request->message_qty,
        //     'balance' => $ptBalance + $request->message_qty,
        //     'status' => 'approved',
        //     'remark' => 'New Recharge'
        // ]);

        // Redirect back to the customer show page
        return redirect()->route('admin.customers.show', $customer->uid)->with([
            'status'  => 'success',
            'message' => __('Request Approved Successfully.'),
        ]);
    }
    /**
     * get customer avatar
     *
     * @param  User  $customer
     *
     * @return mixed
     */
    public function avatar(User $customer): mixed
    {

        if (!empty($customer->imagePath())) {

            try {
                $image = Image::make($customer->imagePath());
            } catch (NotReadableException) {
                $customer->image = null;
                $customer->save();

                $image = Image::make(public_path('images/profile/profile.jpg'));
            }
        } else {
            $image = Image::make(public_path('images/profile/profile.jpg'));
        }

        return $image->response();
    }

    /**
     * update avatar
     *
     * @param  User  $customer
     * @param  UpdateAvatarRequest  $request
     *
     * @return RedirectResponse
     */
    public function updateAvatar(User $customer, UpdateAvatarRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        try {
            // Upload and save image
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {

                    // Remove old images
                    $customer->removeImage();
                    $customer->image = $customer->uploadImage($request->file('image'));
                    $customer->save();

                    return redirect()->route('admin.customers.show', $customer->uid)->with([
                        'status'  => 'success',
                        'message' => __('locale.customer.avatar_update_successful'),
                    ]);
                }

                return redirect()->route('admin.customers.show', $customer->uid)->with([
                    'status'  => 'error',
                    'message' => __('locale.exceptions.invalid_image'),
                ]);
            }

            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.invalid_image'),
            ]);
        } catch (Exception $exception) {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * remove avatar
     *
     * @param  User  $customer
     *
     * @return JsonResponse
     */
    public function removeAvatar(User $customer): JsonResponse
    {

        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        // Remove old images
        $customer->removeImage();
        $customer->image = null;
        $customer->save();

        return response()->json([
            'status'  => 'success',
            'message' => __('locale.customer.avatar_remove_successful'),
        ]);
    }


    /**
     * update customer basic account information
     *
     * @param  User  $customer
     * @param  UpdateCustomerRequest  $request
     *
     * @return RedirectResponse
     */

    public function update(User $customer, UpdateCustomerRequest $request): RedirectResponse
    {

        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->customers->update($customer, $request->input());

        return redirect()->route('admin.customers.show', $customer->uid)->withInput(['tab' => 'account'])->with([
            'status'  => 'success',
            'message' => __('locale.customer.customer_successfully_updated'),
        ]);
    }


    /**
     * update customer detail information
     *
     * @param  User  $customer
     * @param  UpdateInformationRequest  $request
     *
     * @return RedirectResponse
     */
    public function updateInformation(User $customer, UpdateInformationRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->customers->updateInformation($customer, $request->except('_token'));

        return redirect()->route('admin.customers.show', $customer->uid)->withInput(['tab' => 'information'])->with([
            'status'  => 'success',
            'message' => __('locale.customer.customer_successfully_updated'),
        ]);
    }


    /**
     * update user permission
     *
     * @param  User  $customer
     * @param  PermissionRequest  $request
     *
     * @return RedirectResponse
     */
    public function permissions(User $customer, PermissionRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->customers->permissions($customer, $request->only('permissions'));

        return redirect()->route('admin.customers.show', $customer->uid)->withInput(['tab' => 'permission'])->with([
            'status'  => 'success',
            'message' => __('locale.customer.customer_successfully_updated'),
        ]);
    }


    /**
     * change customer status
     *
     * @param  User  $customer
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws GeneralException
     */
    public function activeToggle(User $customer): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }
        try {
            $this->authorize('edit customer');

            if ($customer->update(['status' => !$customer->status])) {
                return response()->json([
                    'status'  => 'success',
                    'message' => __('locale.customer.customer_successfully_change'),
                ]);
            }

            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * Bulk Action with Enable, Disable
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */

    public function batchAction(Request $request): JsonResponse
    {

        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $action = $request->get('action');
        $ids    = $request->get('ids');

        switch ($action) {

            case 'enable':

                $this->authorize('edit customer');

                $this->customers->batchEnable($ids);

                return response()->json([
                    'status'  => 'success',
                    'message' => __('locale.customer.customers_enabled'),
                ]);

            case 'disable':

                $this->authorize('edit customer');

                $this->customers->batchDisable($ids);

                return response()->json([
                    'status'  => 'success',
                    'message' => __('locale.customer.customers_disabled'),
                ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.exceptions.invalid_action'),
        ]);
    }

    /**
     * destroy customer
     *
     * @param  User  $customer
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(User $customer): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('delete customer');

        PhoneNumbers::where('user_id', $customer->id)->update([
            'status'  => 'available',
            'user_id' => 1,
        ]);

        Blacklists::where('user_id', $customer->id)->delete();
        Campaigns::where('user_id', $customer->id)->delete();
        ChatBox::where('user_id', $customer->id)->delete();
        ContactGroups::where('customer_id', $customer->id)->delete();
        Customer::where('user_id', $customer->id)->delete();
        Invoices::where('user_id', $customer->id)->delete();
        Keywords::where('user_id', $customer->id)->delete();
        Notifications::where('user_id', $customer->id)->delete();
        Plan::where('user_id', $customer->id)->delete();
        Reports::where('user_id', $customer->id)->delete();
        Senderid::where('user_id', $customer->id)->delete();
        SendingServer::where('user_id', $customer->id)->delete();
        Subscription::where('user_id', $customer->id)->delete();
        Templates::where('user_id', $customer->id)->delete();


        if (!$customer->delete()) {
            return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => __('locale.customer.customer_successfully_deleted'),
        ]);
    }


    /**
     * @return Generator
     */
    public function customerGenerator(): Generator
    {
        foreach (User::where('is_customer', 1)->join('customers', 'user_id', '=', 'users.id')->cursor() as $customer) {
            yield $customer;
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
    public function export(): BinaryFileResponse|RedirectResponse
    {

        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.index')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $this->authorize('edit customer');

        $file_name = (new FastExcel($this->customerGenerator()))->export(storage_path('Customers_' . time() . '.xlsx'));

        return response()->download($file_name);
    }

    /**
     * add custom unit
     *
     * @param  User  $customer
     * @param  AddUnitRequest  $request
     *
     * @return RedirectResponse
     * @throws GeneralException
     */
    public function addUnit(User $customer, AddUnitRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.index')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        try {

            if ($customer->sms_unit != '-1') {

                $balance = $customer->sms_unit + $request->add_unit;

                if ($customer->update(['sms_unit' => $balance])) {

                    $subscription = $customer->customer->activeSubscription();

                    $subscription->addTransaction(SubscriptionTransaction::TYPE_SUBSCRIBE, [
                        'end_at'                 => $subscription->end_at,
                        'current_period_ends_at' => $subscription->current_period_ends_at,
                        'status'                 => SubscriptionTransaction::STATUS_SUCCESS,
                        'title'                  => 'Add ' . $request->add_unit . ' sms units',
                        'amount'                 => $request->add_unit . ' sms units',
                    ]);

                    return redirect()->route('admin.customers.show', $customer->uid)->with([
                        'status'  => 'success',
                        'message' => __('locale.customer.add_unit_successful'),
                    ]);
                }

                throw new GeneralException(__('locale.exceptions.something_went_wrong'));
            }

            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'info',
                'message' => 'You are already in unlimited plan',
            ]);
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * remove custom unit
     *
     * @param  User  $customer
     * @param  AddUnitRequest  $request
     *
     * @return RedirectResponse
     * @throws GeneralException
     */
    public function removeUnit(User $customer, AddUnitRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('admin.customers.index')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        try {

            if ($customer->sms_unit != '-1') {

                $balance = $customer->sms_unit - $request->add_unit;

                if ($balance < 0) {
                    return redirect()->route('admin.customers.show', $customer->uid)->with([
                        'status'  => 'error',
                        'message' => 'Sorry! You can remove maximum ' . $customer->sms_unit . ' unit',
                    ]);
                }

                if ($customer->update(['sms_unit' => $balance])) {

                    $subscription = $customer->customer->activeSubscription();

                    $subscription->addTransaction(SubscriptionTransaction::TYPE_SUBSCRIBE, [
                        'end_at'                 => $subscription->end_at,
                        'current_period_ends_at' => $subscription->current_period_ends_at,
                        'status'                 => SubscriptionTransaction::STATUS_SUCCESS,
                        'title'                  => 'Remove ' . $request->add_unit . ' sms units',
                        'amount'                 => $request->add_unit . ' sms units',
                    ]);

                    return redirect()->route('admin.customers.show', $customer->uid)->with([
                        'status'  => 'success',
                        'message' => __('locale.customer.add_unit_successful'),
                    ]);
                }

                throw new GeneralException(__('locale.exceptions.something_went_wrong'));
            }

            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'info',
                'message' => 'You are already in unlimited plan',
            ]);
        } catch (ModelNotFoundException $exception) {
            return redirect()->route('admin.customers.show', $customer->uid)->with([
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Version 3.3
    |--------------------------------------------------------------------------
    |
    | Logged in as a customer option
    |
    */

    /**
     * @param  User  $customer
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function impersonate(User $customer): mixed
    {
        $this->authorize('edit customer');

        return $this->customers->impersonate($customer);
    }
    public function partner(): Factory|View|Application
    {

        $this->authorize('view partner');

        $breadcrumbs = [
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url(config('app.admin_path') . "/dashboard"), 'name' => __('locale.menu.Customer')],
            ['name' => __('Partner Inquiry')],
        ];


        return view('admin.customer.partner', compact('breadcrumbs'));
    }
    public function partnerShow(Request $request)
    {
        $columns = [
            '0' => 'id',
            '1' => 'firstname',
            '2' => 'lastname',
            '3' => 'mobile',
            '4' => 'email',
        ];

        // request in get input field
        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column') ?? 0; // Get column index
        $order = $columns[$orderColumnIndex] ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';

        if (empty($request->input('search.value'))) {
            $partner_contacts = PartnerContact::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $partner_contacts = PartnerContact::whereLike(['firstname', 'lastname', 'email', 'mobile'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = PartnerContact::whereLike(['firstname', 'lastname', 'mobile', 'email'], $search)->count();
        }

        //get query
        $query = PartnerContact::all();


        //total records count
        // $totalRecords = PartnerContact::count(groupBy('id')->distinct()->get());
        // $totalRecords = PartnerContact::get();
        $data = [];


        // foreach loop filter records
        if (!empty($partner_contacts)) {
            foreach ($partner_contacts as $partner_contact) {
                $nestedData['responsive_id'] = '';
                $nestedData['name']          = $partner_contact->firstname . ' ' . $partner_contact->lastname;
                $nestedData['mobile']          = $partner_contact->mobile;
                $nestedData['email']          = $partner_contact->email;

                $data[]               = $nestedData;
            }
        }

        // dd($data);
        // return response
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
}
