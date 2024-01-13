<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\ApiDetail;
use Illuminate\Support\Facades\Auth;

class CustomerBaseController extends Controller
{
    /**
     * Show admin home.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        return view('customer.dashboard');
    }

    protected function redirectResponse(Request $request, $message, $type = 'success')
    {
        if ($request->wantsJson()) {
            return response()->json([
                    'status'  => $type,
                    'message' => $message,
            ]);
        }

        return redirect()->back()->with("flash_{$type}", $message);
    }

    public function messageApi()
    {
        $userId = Auth::user()->id;
        $apiDetail = ApiDetail::where('user_id', $userId)->first();
        return view("customer.messaging-api", compact('apiDetail'));
    }

    public function developerAPIDocs()
    {
        $userId = Auth::user()->id;
        $apiDetail = ApiDetail::where('user_id', $userId)->first();
        return view("customer.developer-api-docs",compact('apiDetail'));
    }

}
