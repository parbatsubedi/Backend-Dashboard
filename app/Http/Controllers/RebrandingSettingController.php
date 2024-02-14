<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\UploadImage;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\RebrandingSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;

class RebrandingSettingController extends Controller
{
    use UploadImage;
    public function rebrandingSettingUpdate(Request $request)
    {
        Log::info('Rebranding Setting', [$request->all()]);
        $site_title = $request->site_title;
        $site_logo = $request->site_logo;
        $favicon = $request->favicon;
        $newEmail = $request->smtp_email;
        $newPassword = $request->smtp_password;
        $primaryColor = $request->primary_color;
        $secondaryColor = $request->secondary_color;
        $globalTextColor = $request->global_text_color;
        $textColor = $request->text_color;
        $buttonTextColor = $request->button_text_color;
        $hoverColor = $request->hover_color;
        $setting = RebrandingSetting::firstOrFail();

        if ($site_title == $setting->site_title && $site_logo == NULL && $favicon == NULL && $newEmail == $setting->smtp_email && $newPassword == $setting->smtp_password && $primaryColor == $setting->primary_color && $secondaryColor == $setting->secondary_color && $globalTextColor == $setting->global_text_color && $textColor == $setting->text_color && $buttonTextColor == $setting->button_text_color && $hoverColor == $setting->hover_color) {
            return redirect()->route('settings.rebranding')->with('error', 'Nothing new to Update');
        }
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');

            if ($request->hasFile('site_logo')) {
                $data['logo'] = $this->uploadImage(['site_logo' => $request->file('site_logo')], 'site_logo', 'app/public/uploads/settings/');
            }

            if ($request->hasFile('favicon')) {
                $data['favicon'] = $this->uploadImage(['favicon' => $request->file('favicon')], 'favicon', 'app/public/uploads/settings/favicon/');
            }

            $newEmail = $request->smtp_email;
            $newPassword = $request->smtp_password;

            $envFilePath = base_path('.env');

            if (file_exists($envFilePath)) {
                $envFileContents = file_get_contents($envFilePath);

                $dbData = RebrandingSetting::first();
                $updatedEnvFileContents = $envFileContents;

                if ($dbData->smtp_email != $newEmail && $dbData->smtp_password != $newPassword) {
                    $updatedEnvFileContents = preg_replace(
                        '/MAIL_FROM_ADDRESS=.*/',
                        "MAIL_FROM_ADDRESS={$newEmail}",
                        $updatedEnvFileContents
                    );

                    $updatedEnvFileContents = preg_replace(
                        '/MAIL_PASSWORD=.*/',
                        "MAIL_PASSWORD={$newPassword}",
                        $updatedEnvFileContents
                    );
                    Artisan::call('config:clear');
                }

                file_put_contents($envFilePath, $updatedEnvFileContents);
            }
            $setting->update($data);
            return redirect()->route('settings.rebranding')->with('success', 'Updated Successfully');
        }
        return view('admin.setting.rebrandingSetting');
    }
}
