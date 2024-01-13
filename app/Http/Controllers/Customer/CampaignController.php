<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Campaigns\CampaignBuilderRequest;
use App\Http\Requests\Campaigns\ImportRequest;
use App\Http\Requests\Campaigns\ImportVoiceRequest;
use App\Http\Requests\Campaigns\MMSCampaignBuilderRequest;
use App\Http\Requests\Campaigns\MMSImportRequest;
use App\Http\Requests\Campaigns\MMSQuickSendRequest;
use App\Http\Requests\Campaigns\QuickSendRequest;
use App\Http\Requests\Campaigns\VoiceCampaignBuilderRequest;
use App\Http\Requests\Campaigns\VoiceQuickSendRequest;
use App\Http\Requests\Campaigns\WhatsAppCampaignBuilderRequest;
use App\Http\Requests\Campaigns\WhatsAppQuickSendRequest;
use App\Library\Tool;
use App\Models\Campaigns;
use App\Models\ContactGroups;
use App\Models\CsvData;
use App\Models\PhoneNumbers;
use App\Models\Plan;
use App\Models\PlansCoverageCountries;
use App\Models\PlansSendingServer;
use App\Models\Senderid;
use App\Models\SendingServer;
use App\Models\Templates;
use App\Models\TemplateTags;
use App\Models\Blacklists;
use App\Repositories\Contracts\CampaignRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use App\Helpers\Api;
use App\Helpers\Helper;
use App\Helpers\MessageDataFormatter;
use App\Models\Connection;
use App\Http\Controllers\Customer\WhatsAppMessageController;

class CampaignController extends CustomerBaseController
{
    protected CampaignRepository $campaigns;

    /**
     * CampaignController constructor.
     *
     * @param  CampaignRepository  $campaigns
     */
    public function __construct(CampaignRepository $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * quick send message
     *
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function quickSend(Request $request): View|Factory|RedirectResponse|Application
    {
        $this->authorize('sms_quick_send');

        if (isset($request->recipient)) {

            $phone = str_replace(['(', ')', '+', '-', ' '], '', $request->recipient);

            try {
                $phoneUtil         = PhoneNumberUtil::getInstance();
                $phoneNumberObject = $phoneUtil->parse('+' . $phone);
                if (!$phoneUtil->isPossibleNumber($phoneNumberObject)) {
                    return redirect()->route('customer.subscriptions.index')->with([
                        'status'  => 'error',
                        'message' => __('locale.customer.invalid_phone_number'),
                    ]);
                }
                if ($phoneNumberObject->isItalianLeadingZero()) {
                    $recipient = '0' . $phoneNumberObject->getNationalNumber();
                } else {
                    $recipient = $phoneNumberObject->getNationalNumber();
                }
            } catch (NumberParseException $e) {
                return redirect()->route('customer.subscriptions.index')->with([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ]);
            }
        } else {
            $recipient = null;
        }

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
            ['name' => __('locale.menu.Quick Send')],
        ];

        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('plain', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage  = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        return view('customer.Campaigns.quickSend', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'recipient', 'sending_server', 'coverage', 'templates'));
    }

    /**
     * quick send message
     *
     * @param  Campaigns  $campaign
     * @param  QuickSendRequest  $request
     *
     * @return RedirectResponse
     */
    public function postQuickSend(Campaigns $campaign, QuickSendRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.sms.quick_send')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.sms.quick_send')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $data = $this->campaigns->quickSend($campaign, $request->except('_token'));

        if ($data->getData()->status == 'error') {
            return redirect()->route('customer.sms.quick_send')->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.reports.sent')->with([
            'status'  => $data->getData()->status,
            'message' => $data->getData()->message,
        ]);
    }


    /**
     * campaign builder
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function campaignBuilder(): View|Factory|RedirectResponse|Application
    {

        $this->authorize('sms_campaign_builder');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
            ['name' => __('locale.menu.Campaign Builder')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('plain', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        //    $coverage = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();


        return view('customer.Campaigns.campaignBuilder', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'sending_server', 'plan_id'));
    }

    /**
     * template info not found
     *
     * @param  Templates  $template
     * @param $id
     *
     * @return JsonResponse
     */
    public function templateData(Templates $template, $id): JsonResponse
    {
        $data = $template->where('user_id', auth()->user()->id)->find($id);
        if ($data) {
            return response()->json([
                'status'  => 'success',
                'message' => $data->message,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.templates.template_info_not_found'),
        ]);
    }


    /**
     * store campaign
     *
     *
     * @param  Campaigns  $campaign
     * @param  CampaignBuilderRequest  $request
     *
     * @return RedirectResponse
     */
    public function storeCampaign(Campaigns $campaign, CampaignBuilderRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.sms.campaign_builder')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.sms.campaign_builder')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        if ($request->mediaType == 'text' && ($request->message == null || $request->message == '')) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Please Enter Message'
            ]);
        }

        $data = $this->campaigns->campaignBuilder($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return redirect()->route('customer.reports.campaigns')->with([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return redirect()->route('customer.sms.campaign_builder')->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.sms.campaign_builder')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     * send message using file
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function import(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('sms_bulk_messages');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
            ['name' => __('locale.menu.Send Using File')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('plain', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('plain', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        return view('customer.Campaigns.import', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'sending_server', 'plan_id'));
    }


    /**
     * send message using file
     *
     * @param  ImportRequest  $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function importCampaign(ImportRequest $request): View|Factory|RedirectResponse|Application
    {
        if ($request->file('import_file')->isValid()) {

            $form_data = $request->except('_token', 'import_file');

            $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
                ['name' => __('locale.menu.Send Using File')],
            ];

            $data = Excel::toArray(new stdClass(), $request->file('import_file'))[0];

            $csv_data_file = CsvData::create([
                'user_id'      => Auth::user()->id,
                'ref_id'       => uniqid(),
                'ref_type'     => CsvData::TYPE_CAMPAIGN,
                'csv_filename' => $request->file('import_file')->getClientOriginalName(),
                'csv_header'   => $request->has('header'),
                'csv_data'     => json_encode($data),
            ]);

            $csv_data = array_slice($data, 0, 2);

            return view('customer.Campaigns.import_fields', compact('csv_data', 'csv_data_file', 'breadcrumbs', 'form_data'));
        }

        return redirect()->route('customer.sms.import')->with([
            'status'  => 'error',
            'message' => __('locale.settings.invalid_file'),
        ]);
    }

    /**
     * import processed file
     *
     * @param  Campaigns  $campaign
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function importProcess(Campaigns $campaign, Request $request): RedirectResponse
    {

        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.sms.import')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.sms.import')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $form_data = json_decode($request->form_data, true);

        $data = $this->campaigns->sendUsingFile($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {
            if ($form_data['sms_type'] == 'whatsapp') {
                return redirect()->route('customer.whatsapp.import')->with([
                    'status'  => $data->getData()->status,
                    'message' => $data->getData()->message,
                ]);
            }

            if ($form_data['sms_type'] == 'voice') {
                return redirect()->route('customer.voice.import')->with([
                    'status'  => $data->getData()->status,
                    'message' => $data->getData()->message,
                ]);
            }

            if ($form_data['sms_type'] == 'mms') {
                return redirect()->route('customer.mms.import')->with([
                    'status'  => $data->getData()->status,
                    'message' => $data->getData()->message,
                ]);
            }

            return redirect()->route('customer.sms.import')->with([
                'status'  => $data->getData()->status,
                'message' => $data->getData()->message,
            ]);
        }

        if ($form_data['sms_type'] == 'whatsapp') {
            return redirect()->route('customer.whatsapp.import')->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }
        if ($form_data['sms_type'] == 'mms') {
            return redirect()->route('customer.mms.import')->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }

        if ($form_data['sms_type'] == 'voice') {
            return redirect()->route('customer.voice.import')->with([
                'status'  => 'error',
                'message' => __('locale.exceptions.something_went_wrong'),
            ]);
        }

        return redirect()->route('customer.sms.import')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | voice module
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function voiceQuickSend(Request $request): View|Factory|RedirectResponse|Application
    {
        $this->authorize('voice_quick_send');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.Voice')],
            ['name' => __('locale.menu.Quick Send')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('voice', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage  = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        $recipient = $request->recipient;

        return view('customer.Campaigns.voiceQuickSend', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'recipient', 'sending_server', 'coverage', 'templates'));
    }

    /**
     * quick send message
     *
     * @param  Campaigns  $campaign
     * @param  VoiceQuickSendRequest  $request
     *
     * @return RedirectResponse
     */
    public function postVoiceQuickSend(Campaigns $campaign, VoiceQuickSendRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.voice.quick_send')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.voice.quick_send')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        } else {
            return redirect()->route('customer.voice.quick_send')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $data = $this->campaigns->quickSend($campaign, $request->except('_token'));

        if ($data->getData()->status == 'success') {
            return redirect()->route('customer.reports.sent')->with([
                'status'  => 'success',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.reports.sent')->with([
            'status'  => $data->getData()->status,
            'message' => $data->getData()->message,
        ]);
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function voiceCampaignBuilder(): View|Factory|RedirectResponse|Application
    {

        $this->authorize('sms_campaign_builder');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.Voice')],
            ['name' => __('locale.menu.Campaign Builder')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers  = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();
        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('voice', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();


        return view('customer.Campaigns.voiceCampaignBuilder', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'sending_server', 'coverage', 'plan_id'));
    }

    /**
     * store campaign
     *
     *
     * @param  Campaigns  $campaign
     * @param  VoiceCampaignBuilderRequest  $request
     *
     * @return RedirectResponse
     */
    public function storeVoiceCampaign(Campaigns $campaign, VoiceCampaignBuilderRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.voice.campaign_builder')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.voice.campaign_builder')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $data = $this->campaigns->campaignBuilder($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return redirect()->route('customer.reports.campaigns')->with([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return redirect()->route('customer.voice.campaign_builder')->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.voice.campaign_builder')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function voiceImport(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('sms_bulk_messages');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.Voice')],
            ['name' => __('locale.menu.Send Using File')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('voice', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('voice', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        return view('customer.Campaigns.voiceImport', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'sending_server', 'plan_id'));
    }


    /**
     * send message using file
     *
     * @param  ImportVoiceRequest  $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function importVoiceCampaign(ImportVoiceRequest $request): View|Factory|RedirectResponse|Application
    {
        if ($request->file('import_file')->isValid()) {

            $form_data = $request->except('_token', 'import_file');

            $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.Voice')],
                ['name' => __('locale.menu.Send Using File')],
            ];

            $path = $request->file('import_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            $csv_data_file = CsvData::create([
                'user_id'      => Auth::user()->id,
                'ref_id'       => uniqid(),
                'ref_type'     => CsvData::TYPE_CAMPAIGN,
                'csv_filename' => $request->file('import_file')->getClientOriginalName(),
                'csv_header'   => $request->has('header'),
                'csv_data'     => json_encode($data),
            ]);

            $csv_data = array_slice($data, 0, 2);

            return view('customer.Campaigns.import_fields', compact('csv_data', 'csv_data_file', 'breadcrumbs', 'form_data'));
        }

        return redirect()->route('customer.voice.import')->with([
            'status'  => 'error',
            'message' => __('locale.settings.invalid_file'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MMS module
    |--------------------------------------------------------------------------
    |
    |
    |
    */


    /**
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function mmsQuickSend(Request $request): View|Factory|RedirectResponse|Application
    {
        $this->authorize('mms_quick_send');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.MMS')],
            ['name' => __('locale.menu.Quick Send')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('mms', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage  = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        $recipient = $request->recipient;

        return view('customer.Campaigns.mmsQuickSend', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'recipient', 'coverage', 'sending_server', 'templates'));
    }

    /**
     * quick send message
     *
     * @param  Campaigns  $campaign
     * @param  MMSQuickSendRequest  $request
     *
     * @return RedirectResponse
     */
    public function postMMSQuickSend(Campaigns $campaign, MMSQuickSendRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.mms.quick_send')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.mms.quick_send')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $data = $this->campaigns->quickSend($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {
            return redirect()->route('customer.reports.sent')->with([
                'status'  => $data->getData()->status,
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.mms.quick_send')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function mmsCampaignBuilder(): View|Factory|RedirectResponse|Application
    {

        $this->authorize('mms_campaign_builder');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.MMS')],
            ['name' => __('locale.menu.Campaign Builder')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();


        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('mms', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        //   $coverage = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();


        return view('customer.Campaigns.mmsCampaignBuilder', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'sending_server', 'plan_id'));
    }


    /**
     * store campaign
     *
     *
     * @param  Campaigns  $campaign
     * @param  MMSCampaignBuilderRequest  $request
     *
     * @return RedirectResponse
     */
    public function storeMMSCampaign(Campaigns $campaign, MMSCampaignBuilderRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.mms.quick_send')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.mms.quick_send')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $data = $this->campaigns->campaignBuilder($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return redirect()->route('customer.reports.campaigns')->with([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return redirect()->route('customer.mms.campaign_builder')->with([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.mms.campaign_builder')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function mmsImport(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('mms_bulk_messages');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            ['link' => url('dashboard'), 'name' => __('locale.menu.MMS')],
            ['name' => __('locale.menu.Send Using File')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('mms', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('mms', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }


        return view('customer.Campaigns.mmsImport', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'sending_server', 'plan_id'));
    }


    /**
     * send message using file
     *
     * @param  MMSImportRequest  $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function importMMSCampaign(MMSImportRequest $request): View|Factory|RedirectResponse|Application
    {

        if ($request->file('import_file')->isValid()) {

            $media_url = Tool::uploadImage($request->mms_file);

            $form_data              = $request->except('_token', 'import_file', 'mms_file');
            $form_data['media_url'] = $media_url;

            $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.MMS')],
                ['name' => __('locale.menu.Send Using File')],
            ];

            $path = $request->file('import_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            $csv_data_file = CsvData::create([
                'user_id'      => Auth::user()->id,
                'ref_id'       => uniqid(),
                'ref_type'     => CsvData::TYPE_CAMPAIGN,
                'csv_filename' => $request->file('import_file')->getClientOriginalName(),
                'csv_header'   => $request->has('header'),
                'csv_data'     => json_encode($data),
            ]);

            $csv_data = array_slice($data, 0, 2);

            return view('customer.Campaigns.import_fields', compact('csv_data', 'csv_data_file', 'breadcrumbs', 'form_data'));
        }

        return redirect()->route('customer.mms.import')->with([
            'status'  => 'error',
            'message' => __('locale.settings.invalid_file'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | whatsapp module
    |--------------------------------------------------------------------------
    |
    |
    |
    */


    /**
     * whatsapp quick send
     *
     * @param  Request  $request
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function whatsAppQuickSend(Request $request): View|Factory|RedirectResponse|Application
    {
        $this->authorize('whatsapp_quick_send');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            // ['link' => url('dashboard'), 'name' => __('locale.menu.WhatsApp')],
            ['name' => __('locale.menu.Quick Send')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('whatsapp', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage  = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        $recipient = $request->recipient;

        return view('customer.Campaigns.whatsAppQuickSend', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'recipient', 'sending_server', 'coverage', 'templates'));
    }

    public function quickSendDash(Request $request): View|Factory|RedirectResponse|Application
    {
        $this->authorize('whatsapp_quick_send');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            // ['link' => url('dashboard'), 'name' => __('locale.menu.WhatsApp')],
            ['name' => __('locale.menu.Quick Send')],
        ];

        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('whatsapp', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        $coverage  = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        $recipient = $request->recipient;
        $connection = Connection::where('user_id', Auth::user()->id)->where('status', '1')->first();
        return view('customer.Campaigns.quickSendDash', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'recipient', 'sending_server', 'coverage', 'templates', 'connection'));
    }

    /**
     * quick send message
     *
     * @param  Campaigns  $campaign
     * @param  WhatsAppQuickSendRequest  $request
     *
     * @return RedirectResponse
     */
    public function postWhatsAppQuickSend(Campaigns $campaign, WhatsAppQuickSendRequest $request): RedirectResponse
    {
        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.whatsapp.quick_send')->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return redirect()->route('customer.sms.quick_send')->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $data = $this->campaigns->quickSend($campaign, $request->except('_token'));

        if (isset($data->getData()->status)) {
            return redirect()->route('customer.reports.sent')->with([
                'status'  => $data->getData()->status,
                'message' => $data->getData()->message,
            ]);
        }

        return redirect()->route('customer.whatsapp.quick_send')->with([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     * whatsapp campaign builder
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function whatsappCampaignBuilder(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('whatsapp_campaign_builder');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            // ['link' => url('dashboard'), 'name' => __('locale.menu.WhatsApp')],
            ['name' => __('locale.menu.Campaign Builder')],
        ];

        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('whatsapp', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }
        $contacts = isset($_GET['contacts']) ? explode(',', $_GET['contacts']) : [];
        //  $coverage = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();
        $campaignName = null;
        if (count($contacts) == 1) {
            $group = ContactGroups::where('uid', $contacts[0])->first();
            $campaignName = $group->name;
        }

        $connection = Connection::where('user_id', Auth::user()->id)->where('status', '1')->first();
        return view('customer.Campaigns.whatsAppCampaignBuilder', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'sending_server', 'plan_id', 'contacts', 'campaignName', 'connection'));
    }

    public function checkCampaign(Request $request)
    {
        $date = \Carbon\Carbon::parse($request->date)->format('Y/m/d'); //createFromFormat('Y/m/d',$request->date);
        $checkCamp = Campaigns::whereDate('schedule_time', $date)->get();
        $startTime = $endTime = [];
        $option = $optionMin = "";
        foreach ($checkCamp as $key => $val) {
            if (!empty($val->delay_time)) {
                $startTime[] = $val->schedule_time->format('H'); //'H:i'
                $endTime[] = $val->delay_time->format('H');
            }
        }
        for ($i = 0; $i < 24; $i++) {
            if ($i < 10)
                $hour = "0" . $i;
            else
                $hour = $i;

            if (!empty($startTime)) {
                $count = 0;
                foreach ($startTime as $key => $val) {
                    if ($val <= $i && $i <= $endTime[$key]) {
                        $count = 1;
                        $end_time = $endTime[$key];
                        if ($val == $hour) {
                            $option .= "<option value=" . $i . " style='background-color: peachpuff;'>" . $hour . "</option>";
                            break;
                        }
                    } elseif (isset($end_time) && $i <= $end_time) {
                        $count = 1;
                        $option .= "<option value=" . $i . " style='background-color: peachpuff;'>" . $hour . "</option>";
                        break;
                    }
                }
                if (empty($count))
                    $option .= "<option value=" . $i . ">" . $hour . "</option>";
            } else {
                if ($i < 10)
                    $option .= "<option value=" . $i . ">" . $hour . "</option>";
                else
                    $option .= "<option value=" . $i . ">" . $hour . "</option>";
            }
        }
        for ($i = 0; $i < 60; $i++) {
            if ($i < 10)
                $optionMin .= "<option value=0" . $i . ">0" . $i . "</option>";
            else
                $optionMin .= "<option value=" . $i . ">" . $i . "</option>";
        }
        $data = [
            "status" => "success",
            "hours"  => $option,
            "minutes" => $optionMin
        ];
        return response()->json($data);
    }

    public function checkCampaignHours(Request $request)
    {
        $date = $request->date;
        $hour = $request->hour;
        $checkCamp = Campaigns::whereDate('schedule_time', $date)->get();

        $startTime = $endTime = [];
        $option = $optionMin = "";
        $checkHour = 0;

        if (!empty($checkCamp)) {
            foreach ($checkCamp as $key => $val) {
                if (!empty($val->delay_time)) {
                    $start_time = $val->schedule_time->format('H:i');
                    $end_time = $val->delay_time->format('H:i');

                    $start_time = explode(":", $start_time);
                    $end_time = explode(":", $end_time);

                    /** compare hour for getting start position  */
                    if ($hour >= $start_time[0] && $hour <= $end_time[0]) {
                        $checkHour = 1;
                        if ($end_time[0] > $hour && $start_time[0] != $hour) {
                            for ($i = 0; $i < 60; $i++) {
                                $optionMin .= $this->getOptionTag($i, 'disable');
                            }
                            break;
                        }
                        /** compare hour for getting end position  */
                        elseif ($end_time[0] == $hour && $start_time[0] != $hour) {
                            $start_counter = 0;
                        } else {
                            $start_counter = $start_time[1];
                        }
                        for ($i = 0; $i < $start_counter; $i++) {
                            $optionMin .= $this->getOptionTag($i, '');
                        }

                        $count = ($end_time[1] <= $start_counter) ? 60 : $end_time[1];
                        for ($j = $start_counter; $j < $count; $j++) {
                            $optionMin .= $this->getOptionTag($j, 'disable');
                        }
                        if ($count != 60) {
                            for ($i = $end_time[1]; $i < 60; $i++) {
                                $optionMin .= $this->getOptionTag($i, '');
                            }
                        }
                        break;
                    }
                }
            }
            if (empty($checkHour)) {
                for ($i = 0; $i < 60; $i++) {
                    $optionMin .= $this->getOptionTag($i, '');
                }
            }
        } else
            $optionMin .= $this->getOptionTag($i, '');

        $data = [
            "status" => "success",
            "minutes" => $optionMin
        ];
        return response()->json($data);
    }

    public function getOptionTag($counter, $cond)
    {
        $condVal = '';
        if ($cond == 'disable')
            $condVal = "disabled style='background-color: peachpuff;'";

        if (strlen($counter) == 1)
            $optionMin = "<option value=0" . $counter . " " . $condVal . ">0" . $counter . "</option>";
        else
            $optionMin = "<option value=" . $counter . " " . $condVal . ">" . $counter . "</option>";
        return $optionMin;
    }
    /**
     * store campaign
     *
     *
     * @param  Campaigns  $campaign
     * @param  WhatsAppCampaignBuilderRequest  $request
     *
     * @return RedirectResponse
     */
    // public function storeWhatsAppCampaign(Campaigns $campaign, WhatsAppCampaignBuilderRequest $request): RedirectResponse
    public function storeWhatsAppCampaign(Campaigns $campaign, Request $request)
    {
        if (config('app.stage') == 'demo') {
            return back()->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return back()->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $connection = Connection::where('user_id', Auth::user()->id)->where('status', '1')->first();

        if (empty($connection) || empty($connection->key)) {
            return back()->with([
                'status'  => 'error',
                'message' => __('locale.labels.wa_logout_msg')
            ]);
        }

        if ($request->mediaType == 'text' && ($request->message == null || $request->message == '')) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Please Enter Message'
            ]);
        }

        $contact_groups = $request->contact_groups;

        $dateTime = explode(' ', $request->date);
        $request->date = $dateTime[0];
        $request->time = $dateTime[1];

        $page_type = $request->page_type;
        $inputTime = $request->time ? $request->time . ":00" : null; //$request->hours.":".$request->minutes;

        $date = $request->date;
        $message = $request->message;
        $schedule_type = strtolower($request->schedule_type);

        $numbers = $checkNumber = [];
        $blacklists = Blacklists::where('user_id', auth()->user()->id)->get();
        foreach ($blacklists as $key => $val) {
            $checkNumber[] = $val->number;
        }
        $groups = ContactGroups::whereIn('id', $contact_groups)->with(['subscribers' => function ($query) {
            $query->where('status', 'subscribe');
        }])->get();

        $index = 0;
        foreach ($groups as $key => $val) {
            foreach ($val->subscribers as $k => $v) {
                if (!in_array($v->phone, $checkNumber)) {
                    // $numbers[$k]['name'] = (empty($v->first_name))?'Customer':$v->first_name." ".$v->last_name;
                    // $numbers[$k]['mobile'] = $v->phone;
                    $numbers[] = [
                        'name' => (empty($v->first_name)) ? 'Customer' : $v->first_name . " " . $v->last_name,
                        'mobile' => $v->phone
                    ];
                    $checkNumber[] = $v->phone; // add number for check dulicate number
                }
            }
        }
        $mytime = \Carbon\Carbon::parse(\Carbon\Carbon::now()->format('Y-m-d H:i:00'));
        $time = \Carbon\Carbon::parse($mytime->toTimeString())->addMinutes(1);

        if (isset($request->message)) {
            $getLast2str = substr($request->message, -2);
            if ($getLast2str == '\n') {
                $request->message = substr($request->message, 0, -2);
            }
            $request->message = str_replace('\n', "\n", $request->message);
        } elseif (isset($request->caption)) {
            $getLast2str = substr($request->caption, -2);
            if ($getLast2str == '\n') {
                $request->caption = substr($request->caption, 0, -2);
            }
            $request->caption = str_replace('\n', "\n", $request->caption);
        }

        $messageDataFormatter = new MessageDataFormatter();
        $isFile = $request->hasFile('file') ? true : false;
        $massageData = $messageDataFormatter->getMessageFormattedData($request, $connection, $numbers, $isFile);
        if (isset($massageData['status']) && $massageData['status'] == 'error') {
            return back()->with($massageData);
        }

        $massageData['date'] = $schedule_type == 'schedule' ? $date : $mytime->toDateString();
        $massageData['time'] = $schedule_type == 'schedule' ? $inputTime : $time->toTimeString();

        if ($request->mediaType == 'specifiedFile') {
            $request->mediaType = $request->fileType;
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $uploadedImage = $request->file('file');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $destinationPath = public_path('/public/upload/messageFiles/');
            $uploadedImage->move($destinationPath, $imageName);
            $filePath = env('APP_URL') . '/public/public/upload/messageFiles/' . $imageName;
        }

        $phonenumber = $request->phonenumber ?? null;

        if($phonenumber){
            $phonenumber = Helper::formatMobileNumber($phonenumber);
        }

        $requestedMessage = [
            'message' => isset($request->message) ? $request->message : (isset($request->caption) ? $request->caption : null),
            'filePath' => $filePath,
            'mediaType' => $request->mediaType ?? null,
            'fullname' => $request->fullname ?? null,
            'displayname' => $request->displayname ?? null,
            'organization' => $request->organization ?? null,
            'phonenumber' => $phonenumber ?? null
        ];

        $param['query'] = $massageData;
        $headers = [
            // 'Content-Type' => 'application/json',
            "Content-Type" => "multipart/form-data"
        ];
        $url = env('WA_API_URL') . 'scheduled/messagebynumbers';
        $dataParams = [
            "param"         => $param,
            "key"           => $connection->key,
            "headers"       => $headers,
            "schedule_type" => $schedule_type,
            "page_type"     => $page_type,
            "contact_groups" => $contact_groups,
            "campaign_name" => $request->name
        ];

        // dd($request->all(), $connection, $dataParams);

        $scheduleCamp = Api::scheduleWhatsappMsgCamp($dataParams, $requestedMessage)->getData();

        if ($scheduleCamp->status == "success") {
            if ($page_type == 'single_contact') {
                return redirect()->route('customer.contacts.show', $groups[0]->uid)->withInput(['tab' => 'message'])->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            } elseif ($page_type == 'group_contact') {
                return redirect('contacts')->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            } else {
                // campaign_builder
                return redirect()->route('customer.reports.all')->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            }
        } else {
            if ($page_type == 'single_contact') {
                return redirect()->route('customer.contacts.show', $groups[0]->uid)->withInput(['tab' => 'message'])->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message
                ]);
            } elseif ($page_type == 'group_contact') {
                return back()->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message
                ]);
            } else {
                return back()->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message,
                ]);
            }
        }
    }

    /**
     * whatsapp send message using file
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function whatsappImport(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('whatsapp_bulk_messages');

        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            // ['link' => url('dashboard'), 'name' => __('locale.menu.WhatsApp')],
            ['name' => __('locale.menu.Send Using File')],
        ];


        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('whatsapp', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }

        return view('customer.Campaigns.whatsAppImport', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'sending_server', 'plan_id'));
    }


    /**
     * send message using file
     *
     * @param  ImportRequest  $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function importWhatsAppCampaign(ImportRequest $request): View|Factory|RedirectResponse|Application
    {
        if ($request->file('import_file')->isValid()) {

            $form_data = $request->except('_token', 'import_file');

            $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
                ['name' => __('locale.menu.Send Using File')],
            ];

            $path = $request->file('import_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            $csv_data_file = CsvData::create([
                'user_id'      => Auth::user()->id,
                'ref_id'       => uniqid(),
                'ref_type'     => CsvData::TYPE_CAMPAIGN,
                'csv_filename' => $request->file('import_file')->getClientOriginalName(),
                'csv_header'   => $request->has('header'),
                'csv_data'     => json_encode($data),
            ]);

            $csv_data = array_slice($data, 0, 2);

            return view('customer.Campaigns.import_fields', compact('csv_data', 'csv_data_file', 'breadcrumbs', 'form_data'));
        }

        return redirect()->route('customer.whatsapp.import')->with([
            'status'  => 'error',
            'message' => __('locale.settings.invalid_file'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Version 3.5
    |--------------------------------------------------------------------------
    |
    | Campaign pause, restart, resend
    |
    */


    /**
     * Pause the Campaign
     *
     * @param  Campaigns  $campaign
     *
     * @return JsonResponse
     */
    public function campaignPause(Campaigns $campaign)
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $data = $this->campaigns->pause($campaign);

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return response()->json([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }


    /**
     * Restart the Campaign
     *
     * @param  Campaigns  $campaign
     *
     * @return JsonResponse
     */
    public function campaignRestart(Campaigns $campaign)
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $data = $this->campaigns->restart($campaign);

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return response()->json([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    /**
     * Resend the Campaign
     *
     * @param  Campaigns  $campaign
     *
     * @return JsonResponse
     */
    public function campaignResend(Campaigns $campaign)
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $data = $this->campaigns->resend($campaign);

        if (isset($data->getData()->status)) {

            if ($data->getData()->status == 'success') {
                return response()->json([
                    'status'  => 'success',
                    'message' => $data->getData()->message,
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => $data->getData()->message,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => __('locale.exceptions.something_went_wrong'),
        ]);
    }

    public function editWhatsAppCampaignBuilder($schedule_id): View|Factory|RedirectResponse|Application
    {
        $this->authorize('whatsapp_campaign_builder');
        $breadcrumbs = [
            ['link' => url("/dashboard"), 'name' => __('locale.menu.Dashboard')],
            ['link' => url("/reports/all"), 'name' => __('locale.menu.Reports')],
            ['name' => 'Update Campaign'],
        ];

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $campaign = Campaigns::where('schedule_id', $schedule_id)->first();

        if (Auth::user()->customer->getOption('sender_id_verification') == 'yes') {
            $sender_ids = Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->cursor();
        } else {
            $sender_ids = null;
        }

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->cursor();

        $template_tags  = TemplateTags::cursor();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->cursor();

        $templates = Templates::where('user_id', auth()->user()->id)->where('status', 1)->cursor();

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = Auth::user()->customer->activeSubscription()->plan_id;

        // Check the customer has permissions using sending servers and has his own sending servers
        if (Auth::user()->customer->getOption('create_sending_server') == 'yes') {
            if (PlansSendingServer::where('plan_id', $plan_id)->count()) {

                $sending_server = SendingServer::where('user_id', Auth::user()->id)->where('whatsapp', 1)->where('status', true)->get();

                if ($sending_server->count() == 0) {
                    $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                    $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
                }
            } else {
                $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
                $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
            }
        } else {
            // If customer don't have permission creating sending servers
            $sending_server_ids = PlansSendingServer::where('plan_id', $plan_id)->pluck('sending_server_id')->toArray();
            $sending_server     = SendingServer::where('whatsapp', 1)->where('status', true)->whereIn('id', $sending_server_ids)->get();
        }
        $contacts = isset($_GET['contacts']) ? explode(',', $_GET['contacts']) : [];
        //  $coverage = PlansCoverageCountries::where('plan_id', $plan_id)->where('status', true)->cursor();

        return view('customer.Campaigns.editWhatsAppCampaignBuilder', compact('breadcrumbs', 'schedule_id', 'campaign', 'sender_ids', 'phone_numbers', 'template_tags', 'contact_groups', 'templates', 'sending_server', 'plan_id', 'contacts'));
    }

    public function updateWhatsAppCampaign($schedule_id, Request $request)
    {
        if (config('app.stage') == 'demo') {
            return back()->with([
                'status'  => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        if (Auth::user()->customer->activeSubscription()) {
            $plan = Plan::where('status', true)->find(Auth::user()->customer->activeSubscription()->plan_id);
            if (!$plan) {
                return back()->with([
                    'status'  => 'error',
                    'message' => 'Purchased plan is not active. Please contact support team.',
                ]);
            }
        }

        $connection = Connection::where('user_id', Auth::user()->id)->where('status', '1')->first();

        if (empty($connection) || empty($connection->key)) {
            return back()->with([
                'status'  => 'error',
                'message' => __('locale.labels.wa_logout_msg')
            ]);
        }

        if ($request->mediaType == 'text' && ($request->message == null || $request->message == '')) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Please Enter Message'
            ]);
        }

        $contact_groups = $request->contact_groups;
        $dateTime = explode(' ', $request->date);
        $request->date = $dateTime[0];
        $request->time = $dateTime[1];

        $page_type = $request->page_type;
        $inputTime = $request->time ? $request->time . ":00" : null;

        $date = $request->date;
        $schedule_type = strtolower($request->schedule_type);

        $numbers = $checkNumber = [];
        $blacklists = Blacklists::where('user_id', auth()->user()->id)->get();
        foreach ($blacklists as $key => $val) {
            $checkNumber[] = $val->number;
        }

        $groups = ContactGroups::whereIn('id', $contact_groups)->with(['subscribers' => function ($query) {
            $query->where('status', 'subscribe');
        }])->get();

        foreach ($groups as $key => $val) {
            foreach ($val->subscribers as $k => $v) {
                if (!in_array($v->phone, $checkNumber)) {
                    $numbers[] = [
                        'name' => (empty($v->first_name)) ? 'Customer' : $v->first_name . " " . $v->last_name,
                        'mobile' => $v->phone
                    ];
                    $checkNumber[] = $v->phone; // add number for check dulicate number
                }
            }
        }

        $mytime = \Carbon\Carbon::parse(\Carbon\Carbon::now()->format('Y-m-d H:i:00'));
        $time = \Carbon\Carbon::parse($mytime->toTimeString())->addMinutes(1);

        $messageDataFormatter = new MessageDataFormatter();
        $isFile = $request->hasFile('file') ? true : false;
        $massageData = $messageDataFormatter->getMessageFormattedData($request, $connection, $numbers, $isFile);
        if (isset($massageData['status']) && $massageData['status'] == 'error') {
            return back()->with($massageData);
        }

        $massageData['date'] = $schedule_type == 'schedule' ? $date : $mytime->toDateString();
        $massageData['time'] = $schedule_type == 'schedule' ? $inputTime : $time->toTimeString();


        if ($request->mediaType == 'specifiedFile') {
            $request->mediaType = $request->fileType;
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $uploadedImage = $request->file('file');
            $imageName = time() . '.' . $uploadedImage->getClientOriginalExtension();
            $destinationPath = public_path('/public/upload/messageFiles/');
            $uploadedImage->move($destinationPath, $imageName);
            $filePath = env('APP_URL') . '/public/public/upload/messageFiles/' . $imageName;
        } elseif (in_array($request->mediaType, ['image', 'video', 'audio', 'file'])) {
            $campaign = Campaigns::where('schedule_id', $schedule_id)->first();
            $filePath = json_decode($campaign->message)->filePath;
        }

        $phonenumber = $request->phonenumber ?? null;

        if($phonenumber){
            $phonenumber = Helper::formatMobileNumber($phonenumber);
        }

        $requestedMessage = [
            'message' => isset($request->message) ? $request->message : (isset($request->caption) ? $request->caption : null),
            'filePath' => $filePath,
            'mediaType' => $request->mediaType ?? null,
            'fullname' => $request->fullname ?? null,
            'displayname' => $request->displayname ?? null,
            'organization' => $request->organization ?? null,
            'phonenumber' => $phonenumber ?? null
        ];

        $param['query'] = $massageData;
        $headers = [
            "Content-Type" => "multipart/form-data"
        ];

        $dataParams = [
            "param"         => $param,
            "key"           => $connection->key,
            "headers"       => $headers,
            "schedule_type" => $schedule_type,
            "page_type"     => $page_type,
            "contact_groups" => $contact_groups,
            "campaign_name" => $request->name,
            "schedule_id" => $schedule_id
        ];

        $scheduleCamp = Api::scheduleWhatsappMsgCamp($dataParams, $requestedMessage)->getData();

        if ($scheduleCamp->status == "success") {
            if ($page_type == 'single_contact') {
                return redirect()->route('customer.contacts.show', $groups[0]->uid)->withInput(['tab' => 'message'])->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            } elseif ($page_type == 'group_contact') {
                return redirect('contacts')->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            } else {
                return back()->with([
                    'status'  => 'success',
                    'message' => $scheduleCamp->message,
                ]);
            }
        } else {
            if ($page_type == 'single_contact') {
                return redirect()->route('customer.contacts.show', $groups[0]->uid)->withInput(['tab' => 'message'])->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message
                ]);
            } elseif ($page_type == 'group_contact') {
                return back()->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message
                ]);
            } else {
                return back()->with([
                    'status'  => 'error',
                    'message' => $scheduleCamp->message,
                ]);
            }
        }
    }
}
