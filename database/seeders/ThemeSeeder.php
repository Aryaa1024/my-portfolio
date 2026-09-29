<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('Theme Seeding Started');

        for ($i = 1; $i <= 10; $i++) {
            Theme::firstOrCreate([
                'name' => 'theme' . $i,
                'image'=>null,
                'is_active' => false
            ]);
        }
        Log::info('Theme Seeding Completed');
    }
}
