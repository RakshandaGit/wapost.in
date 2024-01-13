<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\User;
use Auth;

class ConnectionController extends Controller
{
    public $wa_api_url;

    function __construct()
    {
        $this->wa_api_url = env('WA_API_URL');
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
            // ['link' => url('dashboard'), 'name' => __('locale.menu.WhatsApp')],
            ['name' => __('Connection')],
        ];

        $data = [
            "wa_api_url"    => $this->wa_api_url
        ];

        if (!Auth::user()->customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                'status'  => 'error',
                'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $user = Auth::User();
        $connections = Connection::where('user_id', $user->id)->where('status', 1)->get();
        return view('customer.Connection.index', compact('breadcrumbs', 'user', 'connections'), $data);
    }

    public function setInstanceKey(Request $request)
    {
        $user = Auth::User();
        // $connection = Connection::where('user_id', $user->id)->first();
        $connection = Connection::where(['number' => $request->number, 'user_id' => $user->id])->first();
        $instance_key = $request->instance_key;
        $jid = $request->jid;
        $number = $request->number;
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

        $avatar = $this->getVatar($instance_key, $number);
        $decode_avatar = json_decode($avatar);
        $connection->avatar = $decode_avatar->data;
        $connection->save();

        return response()->json(['error' => false, 'connection' => $connection]);
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

    public function logout(Request $request)
    {

        $instance_key = $request->instance_key;
        $user = Auth::User();
        $connection = Connection::where('user_id', $user->id)->where('key', $instance_key)->where('status', 1)->first();

        $postDataArray = [
            'key' => $instance_key
        ];

        $data = http_build_query($postDataArray);
        $ch = curl_init();
        // $url = $this->wa_api_url . 'instance/logout?key=';
        $url = $this->wa_api_url . 'instance/logout?' . $data;
        // $getUrl = $url . "?" . $data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) {
            return response()->json(['error' => true, 'message' => 'WhatsApp server not responding.', 'data' => json_decode($err)]);
        } else {
            // $connection->key = null;
            // $connection->status = 0;
            // $connection->save();
            return response()->json(['error' => false, 'message' => 'Successfully logout form server.', 'data' => json_decode($response)]);
        }
    }

    public function activeDeactiveStatus(Request $request)
    {
        return Connection::where('user_id', Auth::User()->id)
            ->where('id', $request->connId)
            ->update([
                'is_active' => $request->status
            ]);
    }

    public function acceptMessageDeclaration(Request $request)
    {
        // $request->decalrationStatus
        Auth::user()
            ->update([
                'is_accept_connection_declaration' => 1
            ]);

        return back();
    }
}
