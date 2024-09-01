<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'articles',
            'users',
            'employees',
            'projects',
            'products',
            'contractors',
            'brands',
            'files',
            'notes',
            'meetings',
            'vacations',
        ];

        foreach ($settings as $setting) {
            if (!Setting::where('name', $setting)->exists()) {
                Setting::factory()->create([
                    'name' => $setting,
                ]);
            }
        }


    }
}
