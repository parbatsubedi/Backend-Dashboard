<?php

namespace App\Http\Controllers;

use App\Models\UserLoginHistory;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function userSession(Request $request)
    {
        $length = 15;
        $sessions = UserLoginHistory::with('user')->latest()->filter($request)->paginate($length);
        return view('admin.logs.userSession')->with(compact('sessions'));
    }

    public function auditing()
    {
        return view('admin.logs.auditing');
    }

    public function profiling()
    {
        return view('admin.logs.profiling');
    }

    public function statistics()
    {
        return view('admin.logs.statistics');
    }

    public function development()
    {
        return view('admin.logs.development');
    }
}
