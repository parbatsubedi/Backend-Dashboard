<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        Admin::query()->truncate();
        Permission::query()->truncate();
        Role::query()->truncate();*/


        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'Dashboard',

            'Backend user update profile',
            'Backend user change password',

            'Backend users view',
            'Backend user update permission',
            'Backend user update role',
            'Backend user reset password',
            'Backend user create',

            'Roles view',
            'Role create',
            'Role edit',

            'Backend user log view',

            'Rebranding setting',
            'Rebranding setting update',

            'Api log',
            'Model log',

            ];

        //get users having all permissions
        $admin = Admin::first();
        if (!count(Admin::all())) {
            $admin = Admin::create([
                'name' => 'Parbat Subedi',
                'email' => 'Parbatsubedi@gmail.com',
                'password' => bcrypt('password'),
                'mobile_no' => '9843723270'
            ]);
        }

        $role = Role::where('name', 'Super admin')->first();
        if (!$role) {
            $role = Role::create(['name' => 'Super admin']);
            $admin->assignRole('Super admin');
        }


        //create permission
        foreach ($permissions as $key  => $permission) {

            if (!Permission::where('name', $permission)->first()) {
                $permission = Permission::create(['name' => $permission]);
            }

            if (!$role->hasPermissionTo($permission)) {

                $role->givePermissionTo($permission);
            }
        }

        /*$superAdmins = Admin::all();
        $superAdmins->map(function($value) use($permissions) {
           if($value->hasRole("Super admin") || $value->hasRole("Admin")){
            $value->givePermissionTo($permissions);
           }
        });*/
    }
}
