<?php

namespace Database\Seeders;

use App\Models\RebrandingSetting;
use Illuminate\Database\Seeder;

class RebrandingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rebrandingSettings = RebrandingSetting::first();
        if (!count(RebrandingSetting::all())) {
            $rebrandingSettings = RebrandingSetting::create([
                'site_title' => 'Silk Innovation',
                'logo' => null,
                'favicon' => null,
                'smtp_email' => null,
                'smtp_password' => null,
                'primary_color' => '#FFFFFF',
                'secondary_color' => '#7967ad',
                'text_color' => '#000000',
                'button_text_color' => '#FFFFFF',
                'hover_color' => '#7967ad',
                'global_text_color' => '#000000',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
