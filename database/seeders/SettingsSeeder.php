<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        ];

        foreach($data as $key => $value){
            DB::table("settings")->insert([
                "option" => $key,
                "value" => $value,
            ]);
        }
    }
}
