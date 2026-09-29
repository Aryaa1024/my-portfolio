<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Permission Seeding Started');
        $modules = [];
        $permissions = ['index', 'create', 'edit', 'destroy', 'import', 'export'];

        foreach ($modules as $module) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$permission}",
                ]);
            }
        }
        Log::info('Permission Seeder Completed');
    }
}
