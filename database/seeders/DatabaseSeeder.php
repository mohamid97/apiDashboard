<?php

namespace Database\Seeders;

use App\Models\Api\Admin\Lang;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $adminUser = User::firstOrCreate(
            ['email' => 'cangrow@gmail.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'username' => 'superadmin',
                'password' => Hash::make('123456'), 
            ]
        );

        Lang::firstOrCreate(['code' => 'ar'], ['lang' => 'Arabic']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole = Role::firstOrCreate(['name' => 'manager']);
       
        $models = ['user' , 'role' ,'post', 'service' , 'lang' , 'slider' , 'category' , 'about' , 'contact' , 'location'];
        $actions = ['view', 'create', 'update', 'delete'];
        foreach ($models as $model) {
            foreach ($actions as $action) {
               $permission = Permission::firstOrCreate(['name' => "{$action} {$model}"]);
               $adminRole->givePermissionTo($permission);             
            }
        }

         $adminUser->assignRole($adminRole);
 
       














    }

    


    
}