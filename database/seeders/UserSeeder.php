<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('User Seeder Started');
        $user = User::updateOrCreate([
            'email' => 'admin@example.com',
            'mobile_number' => '7880497004',
        ], [
            'name' => 'Aryan Pal Dhangar',
            'mobile_code' => '+91',
        ]);
        $role = Role::firstOrCreate([
            'name' => 'Admin',
        ]);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $user->assignRole($role);
        Log::info('User Seeder Completed');
    }
}
