<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Manager;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roleSuperAdmin = Role::create(['guard_name' => 'backend', 'name' => 'super-admin']);
        $roleManager    = Role::create(['guard_name' => 'backend', 'name' => 'manager']);
        $roleOperator   = Role::create(['guard_name' => 'backend', 'name' => 'operator']);

        $permission = Permission::create(['guard_name' => 'backend', 'name' => 'edit article']);

        $roleManager->givePermissionTo($permission);
        $roleOperator->givePermissionTo($permission);


        $manager = new Manager();
        $manager->name = 'システム管理者';
        $manager->email = 'super-admin@laravel6';
        $manager->password = Hash::make('password');
        $manager->active = true;
        $manager->save();

        $manager->assignRole('super-admin');


        $manager = new Manager();
        $manager->name = '管理者';
        $manager->email = 'manager@laravel6';
        $manager->password = Hash::make('password');
        $manager->active = true;
        $manager->save();

        $manager->assignRole('manager');


        $manager = new Manager();
        $manager->name = '運営者';
        $manager->email = 'operator@laravel6';
        $manager->password = Hash::make('password');
        $manager->active = true;
        $manager->save();

        $manager->assignRole('operator');


        $manager = new Manager();
        $manager->name = 'ゲスト';
        $manager->email = 'guest@laravel6';
        $manager->password = Hash::make('password');
        $manager->active = true;
        $manager->save();

    }
}
