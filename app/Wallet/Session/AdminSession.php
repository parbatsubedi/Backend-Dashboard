<?php


namespace App\Wallet\Session;


use App\Models\Admin;
use App\Models\Session;

class AdminSession
{
    public function __invoke()
    {
        $admin = Admin::with('session')->firstOrFail();
        $nowInTimeStamp = strtotime(now() . '- '. config('session.lifetime').' minutes');

        \App\Models\Session::where('expired', '=', null)->where('last_activity', '<', $nowInTimeStamp )
            ->update(['expired' => 1]);
    }
}
