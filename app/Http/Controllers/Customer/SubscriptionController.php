<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\SenderID\PayPaymentRequest;
use App\Http\Requests\Subscription\UpdatePreferencesRequest;
use App\Models\PaymentMethods;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Connection;

class SubscriptionController extends CustomerBaseController
{
    protected $subscriptions;

    /**
     * SubscriptionController constructor.
     *
     * @param  SubscriptionRepository  $subscriptions
     */
    public function __construct(SubscriptionRepository $subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }


    /**
     * @return Application|Factory|View
     */

    public function index()
    {

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => Auth::user()->displayName()],
            ['name' => __('locale.labels.billing')],
        ];
        
        $subscription = Auth::user()->customer->activeSubscription();
        if ($subscription) {
            $isPlanExpired = $subscription->current_period_ends_at < now();
            if ($isPlanExpired) {
                $freePlan = Plan::where('name', 'free')->first(); 
                if ($freePlan) {
                    Subscription::where('user_id',$subscription->user_id)->update([
                        'plan_id' => $freePlan->id,
                    ]);
                }
            }
            
            return view('customer.Accounts.index', [
                'breadcrumbs'  => $breadcrumbs,
                'subscription' => $subscription,
                'isPlanExpired' => $isPlanExpired,
                'plan'         => $subscription->plan,
            ]);
        } elseif (isset(Auth::user()->customer->subscription) && Auth::user()->customer->subscription->status == 'new') {

            $subscription = Auth::user()->customer->subscription;
            $isPlanExpired = $subscription->current_period_ends_at < now();

            return view('customer.Accounts.index', [
                'breadcrumbs'  => $breadcrumbs,
                'subscription' => $subscription,
                'isPlanExpired' => $isPlanExpired,
                'plan'         => $subscription->plan,
            ]);
        }

        $plans = Plan::where('status', 1)->where('show_in_customer', 1)->cursor();

        return view('customer.Accounts.plan', compact('breadcrumbs', 'plans'));
    }


    /**
     * @return Application|Factory|View
     */

    public function changePlan()
    {

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('subscriptions'), 'name' => __('locale.labels.billing')],
            ['name' => __('locale.labels.change_plan')],
        ];

        $subscription = Auth::user()->customer->activeSubscription();

        $plans = Plan::where('status', 1)->where('show_in_customer', 1)->cursor();
        $isPlanExpired = $subscription->current_period_ends_at < date('Y-m-d H:i:s');
        return view('customer.Accounts.plan', compact('breadcrumbs', 'plans', 'subscription', 'isPlanExpired'));
    }


    /**
     * view specific subscription logs
     *
     * @param  Subscription  $subscription
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function logs(Subscription $subscription)
    {

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => Auth::user()->displayName()],
            ['name' => __('locale.menu.Subscriptions')],
        ];


        return view('admin.subscriptions.logs', compact('breadcrumbs', 'subscription'));
    }

    public function renew(Subscription $subscription)
    {
        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('subscriptions'), 'name' => __('locale.labels.billing')],
            ['name' => __('locale.labels.renew')],
        ];

        $pageConfigs = [
            'bodyClass' => 'ecommerce-application',
        ];

        $plan = Plan::find($subscription->plan_id);
        $check_free = $plan->price;
        if ((int) $check_free == 0) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => "You have already subscribed your free plan",
            ]);
        }

        $payment_methods = PaymentMethods::where('status', true)->cursor();
        $addonsConnections = $subscription->addons_connections;
        $currentPlanInvoice = Auth::user()->customer->subscription?->invoice ?? null;
        $durationCount = 0;
        if ($currentPlanInvoice) {
            $durationCount = $currentPlanInvoice->duration_count;
        }
        $connections = Connection::where('user_id', Auth::user()->id)->where('status', 1)->get();

        // start checking
        $addonsConnections = $subscription->addons_connections;
        $calculatedPrice = $plan->connection_addons_price;

        $currentSubscription = Auth::user()->customer->subscription ?? null;
        $currentPlanInvoice = Auth::user()->customer->subscription?->invoice ?? null;
        if ($currentSubscription && $currentPlanInvoice) {
            $todays = date("Y-m-d H:i:s");
            $endDate = $currentSubscription->current_period_ends_at;
            $remainDays = floor((strtotime($endDate) - strtotime($todays)) / (60 * 60 * 24));

            if ($plan->frequency_unit == 'month') {
                $adjustedAddonsAmountForPerDayPerAddons = ($currentPlanInvoice->connection_addons_price / 30) * $remainDays;
                $calculatedPrice = number_format($adjustedAddonsAmountForPerDayPerAddons, 2, '.', '');
            } else if ($plan->frequency_unit == 'year') {
                $adjustedAddonsAmountForPerDayPerAddons = ($currentPlanInvoice->connection_addons_price / 365) * $remainDays;
                $calculatedPrice = number_format($adjustedAddonsAmountForPerDayPerAddons, 2, '.', '');
            }
        }

        // end checking
        return view('customer.Accounts.renew', compact('breadcrumbs', 'subscription', 'pageConfigs', 'plan', 'payment_methods', 'addonsConnections', 'durationCount', 'connections', 'calculatedPrice'));
    }

    public function renewPost(Subscription $subscription, PayPaymentRequest $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $plan = $subscription->plan;
        $data = $this->subscriptions->payPayment($plan, $subscription, $request->except('_token'));

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {

                if ($request->payment_methods == PaymentMethods::TYPE_BRAINTREE) {
                    return view('customer.Payments.braintree', [
                        'token'    => $data->getData()->token,
                        'post_url' => route('customer.subscriptions.braintree', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_STRIPE) {
                    return view('customer.Payments.stripe', [
                        'session_id'      => $data->getData()->session_id,
                        'publishable_key' => $data->getData()->publishable_key,
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_AUTHORIZE_NET) {

                    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

                    return view('customer.Payments.authorize_net', [
                        'months'   => $months,
                        'post_url' => route('customer.subscriptions.authorize_net', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_CASH) {
                    return view('customer.Payments.offline', [
                        'data'      => $data->getData()->data,
                        'type'      => 'subscription',
                        'post_data' => $plan->uid,
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_VODACOMMPESA) {
                    return view('customer.Payments.vodacom_mpesa', [
                        'post_url' => route('customer.subscriptions.vodacommpesa', $plan->uid),
                    ]);
                }

                return redirect()->to($data->getData()->redirect_url);
            }

            return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    public function addons(Subscription $subscription)
    {
        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('connection'), 'name' => __('locale.menu.Connection')],
            ['name' => __('locale.labels.addons')],
        ];

        $pageConfigs = [
            'bodyClass' => 'ecommerce-application',
        ];

        $plan = Plan::find($subscription->plan_id);

        $payment_methods = PaymentMethods::where('status', true)->cursor();
        $addonsConnections = $subscription->addons_connections;
        $calculatedPrice = $plan->connection_addons_price;
        $currentSubscription = Auth::user()->customer->subscription ?? null;
        $currentPlanInvoice = Auth::user()->customer->subscription?->invoice ?? null;
        if ($currentSubscription && $currentPlanInvoice) {
            $todays = date("Y-m-d H:i:s");
            $endDate = $currentSubscription->current_period_ends_at;
            $remainDays = floor((strtotime($endDate) - strtotime($todays)) / (60 * 60 * 24));

            if ($plan->frequency_unit == 'month') {
                $adjustedAddonsAmountForPerDayPerAddons = ($currentPlanInvoice->connection_addons_price / 30) * $remainDays;
                $calculatedPrice = number_format($adjustedAddonsAmountForPerDayPerAddons, 2, '.', '');
            } else if ($plan->frequency_unit == 'year') {
                $adjustedAddonsAmountForPerDayPerAddons = ($currentPlanInvoice->connection_addons_price / 365) * $remainDays;
                $calculatedPrice = number_format($adjustedAddonsAmountForPerDayPerAddons, 2, '.', '');
            }
        }

        return view('customer.Accounts.addons', compact('breadcrumbs', 'subscription', 'pageConfigs', 'plan', 'payment_methods', 'addonsConnections', 'calculatedPrice'));
    }

    public function addonsPost(Subscription $subscription, PayPaymentRequest $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $plan = $subscription->plan;
        $data = $this->subscriptions->payPayment($plan, $subscription, $request->except('_token'));

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {

                if ($request->payment_methods == PaymentMethods::TYPE_BRAINTREE) {
                    return view('customer.Payments.braintree', [
                        'token'    => $data->getData()->token,
                        'post_url' => route('customer.subscriptions.braintree', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_STRIPE) {
                    return view('customer.Payments.stripe', [
                        'session_id'      => $data->getData()->session_id,
                        'publishable_key' => $data->getData()->publishable_key,
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_AUTHORIZE_NET) {

                    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

                    return view('customer.Payments.authorize_net', [
                        'months'   => $months,
                        'post_url' => route('customer.subscriptions.authorize_net', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_CASH) {
                    return view('customer.Payments.offline', [
                        'data'      => $data->getData()->data,
                        'type'      => 'subscription',
                        'post_data' => $plan->uid,
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_VODACOMMPESA) {
                    return view('customer.Payments.vodacom_mpesa', [
                        'post_url' => route('customer.subscriptions.vodacommpesa', $plan->uid),
                    ]);
                }

                return redirect()->to($data->getData()->redirect_url);
            }

            return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.subscriptions.renew', $subscription->uid)->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     * @param  Plan  $plan
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function purchase(Plan $plan)
    {
        if ($plan->price == 0) {

            if (config('app.stage') == 'demo') {

                return redirect()->route('customer.subscriptions.index')->with([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
                ]);
            }


            $subscribed = false;
            if (Auth::user()->customer->subscription) {
                foreach (Auth::user()->customer->subscription->getTransactions() as $log) {
                    if ((int) filter_var($log->amount, FILTER_SANITIZE_NUMBER_INT) == 0) {
                        $subscribed = true;
                    }
                }

                if ($subscribed && Auth::user()->customer->subscription->status != 'ended') {
                    return redirect()->route('customer.subscriptions.index')->with([
                        'status'  => 'error',
                        'message' => "You have already subscribed your free plan",
                    ]);
                }
            }
            $data = $this->subscriptions->freeSubscription($plan);

            if ($data) {
                return redirect()->route('customer.subscriptions.index')->with([
                    'status'  => $data->getData()->status,
                    'message' => $data->getData()->message,
                ]);
            }

            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('subscriptions'), 'name' => __('locale.labels.billing')],
            ['name' => __('locale.labels.purchase')],
        ];

        $pageConfigs = [
            'bodyClass' => 'ecommerce-application',
        ];

        $currentSubscription = Auth::user()->customer->subscription ?? null;
        $currentPlanInvoice = Auth::user()->customer->subscription->invoice ?? null;
        $adjustedPlanAmount = 0;
        $adjustedAddonsAmount = 0;
        $totalAadjustedAmount = 0;
        if ($currentSubscription && $currentPlanInvoice) {
            $todays = date("Y-m-d H:i:s");
            $startDate = $currentSubscription->start_at;
            $endDate = $currentSubscription->current_period_ends_at;
            $lastTotalPlanAmount = $currentPlanInvoice->amount * $currentPlanInvoice->duration_count;
            $lastTotalAddonsAmount = ($currentPlanInvoice->connection_addons_price * $currentPlanInvoice->duration_count) * $currentPlanInvoice->addons_connections;
            $totalDays = floor((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24));
            $remainDays = floor((strtotime($endDate) - strtotime($todays)) / (60 * 60 * 24));

            $lastTotalPerPlanAmount = $lastTotalPlanAmount / $totalDays;
            $lastTotalPerAddonsAmount = $lastTotalAddonsAmount / $totalDays;
            $isPlanNotExpired = $currentSubscription->current_period_ends_at > date('Y-m-d H:i:s');
            if ($isPlanNotExpired) {
                $adjustedPlanAmount = $lastTotalPerPlanAmount * $remainDays;
                $adjustedAddonsAmount = $lastTotalPerAddonsAmount * $remainDays;
                $totalAadjustedAmount = $adjustedPlanAmount + $adjustedAddonsAmount;
            }
        }

        $payment_methods = PaymentMethods::where('status', true)->cursor();

        return view('customer.Accounts.purchase', compact('breadcrumbs', 'plan', 'pageConfigs', 'payment_methods', 'adjustedPlanAmount', 'adjustedAddonsAmount', 'totalAadjustedAmount'));
    }

    /**
     * cancelled subscription
     *
     * @param  Subscription  $subscription
     *
     * @return JsonResponse
     */
    public function cancel(Subscription $subscription): JsonResponse
    {

        if (config('app.stage') == 'demo') {

            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        try {
            $subscription->setEnded(Auth::user()->id);

            return response()->json([
                'status'  => 'success',
                'message' => __('locale.subscription.log_cancelled', [
                    'plan' => $subscription->plan->name,
                ]),
            ]);
        } catch (Exception $exception) {

            return response()->json([
                'status'  => 'success',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function checkoutPurchase(Plan $plan, Subscription $subscription, PayPaymentRequest $request)
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.subscriptions.purchase', $plan->uid)->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $data = $this->subscriptions->payPayment($plan, $subscription, $request->except('_token'));

        if (isset($data)) {

            if ($data->getData()->status == 'success') {

                if ($request->payment_methods == PaymentMethods::TYPE_BRAINTREE) {
                    return view('customer.Payments.braintree', [
                        'token'    => $data->getData()->token,
                        'post_url' => route('customer.subscriptions.braintree', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_AUTHORIZE_NET) {

                    $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];

                    return view('customer.Payments.authorize_net', [
                        'months'   => $months,
                        'post_url' => route('customer.subscriptions.authorize_net', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_CASH) {
                    return view('customer.Payments.offline', [
                        'data'      => $data->getData()->data,
                        'type'      => 'subscription',
                        'post_data' => $plan->uid,
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_VODACOMMPESA) {
                    return view('customer.Payments.vodacom_mpesa', [
                        'post_url' => route('customer.subscriptions.vodacommpesa', $plan->uid),
                    ]);
                }

                if ($request->payment_methods == PaymentMethods::TYPE_STRIPE) {
                    return view('customer.Payments.stripe', [
                        'session_id'      => $data->getData()->session_id,
                        'publishable_key' => $data->getData()->publishable_key,
                    ]);
                }
                return redirect()->to($data->getData()->redirect_url);
            }

            return redirect()->route('customer.subscriptions.purchase', $plan->uid)->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.subscriptions.purchase', $plan->uid)->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    /**
     * update preferences
     *
     * @param  Subscription  $subscription
     * @param  UpdatePreferencesRequest  $request
     *
     * @return RedirectResponse
     */
    public function preferences(Subscription $subscription, UpdatePreferencesRequest $request): RedirectResponse
    {

        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.subscriptions.index')->withInput(['tab' => 'preferences'])->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if ($request->end_period_last_days) {
            $subscription->update([
                'end_period_last_days' => $request->end_period_last_days,
            ]);
        }

        $input = $request->except('_token', 'end_period_last_days');

        if (empty($request->credit_warning)) {
            $input['credit_warning'] = false;
        } else {
            $input['credit_warning'] = true;
        }

        if (empty($request->subscription_warning)) {
            $input['subscription_warning'] = false;
        } else {
            $input['subscription_warning'] = true;
        }

        $subscription->updateOptions($input);

        return redirect()->route('customer.subscriptions.index')->withInput(['tab' => 'preferences'])->with([
            'status'  => 'success',
            'message' => __('locale.subscription.preferences_successfully_updated'),
        ]);
    }
}
