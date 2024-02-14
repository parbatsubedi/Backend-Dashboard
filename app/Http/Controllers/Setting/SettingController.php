<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\RebrandingSetting;
use App\Http\Controllers\Controller;
use App\Functions\Setting\Traits\UpdateSetting;

class SettingController extends Controller
{
    use UpdateSetting;

    public function generalSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.generalSetting')->with(compact('settings'));
    }

    public function rebrandingSetting(Request $request)
    {
        // Log::info('Rebranding request', [$request->all()]);
        $email = config('mail.from.address');
        $smtp_password = config('mail.password');
        $dbData = RebrandingSetting::firstOrFail();
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.rebrandingSetting')->with(compact('settings', 'dbData', 'email', 'smtp_password'));
    }
}
