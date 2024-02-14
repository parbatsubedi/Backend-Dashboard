<?php

namespace App\Http\Controllers;

use App\Events\SendOTPCodeEvent;
use App\Models\AdminOTP;
use App\Models\Clearance;
use App\Models\TransactionEvent;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserExecutePayment;
use App\Functions\Dashboard\Repository\DashboardRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // public function payPointYearly(Request $request)
    // {
    //     $now = Carbon::now();
    //     $year = $now->format('Y');

    //     //get current year transaction
    //     $transactions = TransactionEvent::whereYear('created_at', '=', $year)
    //         ->whereTransactionType('App\Models\UserTransaction')
    //         ->with('transactionable')
    //         ->get();

    //     $groupedTransactions =  $transactions
    //         ->groupBy(function ($val) {
    //             return Carbon::parse($val->created_at)->format('F');
    //         });

    //     //return num of transactions and sum of transaction amount in each grouped date
    //     $groupedTransactions->transform(function ($value, $key) {
    //         return [
    //             'count' => round(count($value), 0),
    //             'amount' => round($value->sum('amount'), 2),
    //             'userCount' =>  round($value->groupBy('user_id')->count(), 0) //number of unique users involved
    //         ];
    //     });

    //     return [
    //         'graph' => $groupedTransactions,
    //     ];
    // }

    // public function nPayYearly(Request $request)
    // {
    //     $now = Carbon::now();
    //     $year = $now->format('Y');

    //     //get current year transaction
    //     $transactions = TransactionEvent::whereYear('created_at', '=', $year)
    //         ->whereTransactionType('App\Models\UserLoadTransaction')
    //         ->with('transactionable')
    //         ->get();

    //     $groupedTransactions =  $transactions
    //         ->groupBy(function ($val) {
    //             return Carbon::parse($val->created_at)->format('F');
    //         });

    //     //return num of transactions and sum of transaction amount in each grouped date
    //     $groupedTransactions->transform(function ($value, $key) {
    //         return [
    //             'count' => round(count($value), 0),
    //             'amount' => round($value->sum('amount'), 2),
    //             'userCount' =>  round($value->groupBy('user_id')->count(), 0) //number of unique users involved
    //         ];
    //     });

    //     return [
    //         'graph' => $groupedTransactions,
    //     ];
    // }

    private function checkOldSession($userId)
    {
        $admin = Admin::with('session')->whereId($userId)->firstOrFail();
        $nowInTimeStamp = strtotime(now() . '- '. config('session.lifetime').' minutes');

        $oldSessions = \App\Models\Session::where('user_id', $admin->id)->where('expired', '=', null)->where('last_activity', '<', $nowInTimeStamp )
            ->update(['expired' => 1]);

        $userSessionCount = \App\Models\Session::whereUserId($userId)->whereExpired(null)->count();

        if ($userSessionCount) {
            return false;
        }
        return true;


    }

    public function login(Request $request){
        if ($request->isMethod('post'))
        {
            $data = $request->input();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])){
                $admin = Admin::whereId(auth()->user()->id)->first();
               /* event(new SendOTPCodeEvent($admin));
                Auth::logout();
                return redirect()->route('admin.login.otp');*/

                if (!$this->checkOldSession($admin->id)) {
                    Auth::logout();
                    return redirect()->route('admin.login')->with('error', 'Already logged in from another session')->withInput();
                }

                return redirect()->route('admin.dashboard');

            } else {
                $email = $request->email;
                return redirect()->back()->with('error', 'Invalid Username or Password')->withInput();
            }
        }
        return view('admin.login');
    }

    // public function loginOTP(Request $request)
    // {
    //     if ($request->isMethod('post')) {

    //         $otp = (new AdminOTP)->checkValidToken($request->otp);

    //         if (!$otp) {
    //             return redirect()->back()->with('error', 'Invalid OTP');
    //         }

    //         if ($otp->admin_id) {
    //             $user = Admin::where('id', $otp->admin_id)->first();

    //             if (!$user) {
    //                 return redirect()->back()->with('error', 'User not found');
    //             }

    //             if (!$this->checkOldSession($otp->admin_id)) {
    //                 return redirect()->route('admin.login')->with('error', 'Already logged in from another session');
    //             }
    //             Auth::loginUsingId($user->id);
    //         }
    //         return redirect()->route('admin.login')->with('error', 'Invalid OTP');
    //     }
    //     return view('admin.otp');
    // }

    public function logout()
    {
        \App\Models\Session::where('user_id', auth()->user()->id)->where('expired', '=', null)
            ->update(['expired' => 1]);
        Auth::logout();
        Session::Migrate(false); // prevents user_id from being destroyed in session table
        return redirect()->route('admin.login')->with('flash_message_success', 'Logout Successful');
    }

}
