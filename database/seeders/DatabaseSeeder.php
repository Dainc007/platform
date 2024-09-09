<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CurrencySeeder::class,
            BrandSeeder::class,
            EmployeeSeeder::class,
            ConversationSeeder::class,
            MessageSeeder::class,
            ArticleSeeder::class,
            NoteSeeder::class,
            ProjectSeeder::class,
            ContractorSeeder::class,
            FileSeeder::class,
            ProductSeeder::class,
            VacationSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
