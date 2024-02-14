<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\UserKYC;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SettingsSeeder::class);
        //$this->call(MerchantRevenueSeeder::class);
        //$this->call(CompanyServiceCodeSeeder::class);
    }
}
