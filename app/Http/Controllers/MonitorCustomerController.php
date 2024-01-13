<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class MonitorCustomerController extends Controller
{
    public function index()
    {
        $users = User::with('availableMessage')
            ->where('is_customer', 1)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.MonitorCustomer.index', compact('users'));
    }
}
