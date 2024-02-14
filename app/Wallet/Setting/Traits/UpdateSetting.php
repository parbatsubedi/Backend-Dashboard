<?php


namespace App\Wallet\Setting\Traits;


use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;

trait UpdateSetting
{
    public function updatedSettingsCollection($request, $model = Setting::class)
    {
        if ($request->isMethod('post')) {
            $settings = (new $model())->storeSetting($request);
        }else {
            $settings = $model::all() ?? [];
        }

        $arr = [];

        foreach ($settings as $setting) {
            $arr[$setting->option] = $setting->value;
        }

        return $arr;

    }
}
