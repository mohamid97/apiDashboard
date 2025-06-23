<?php

namespace Database\Seeders;

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

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
       
        $models = ['user' , 'role' ,'post', 'service'];
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