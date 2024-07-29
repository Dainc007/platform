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
            UserSeeder::class,
            EmployeeSeeder::class,
            ConversationSeeder::class,
            MessageSeeder::class,
            ArticleSeeder::class,
            NoteSeeder::class,
            ProjectSeeder::class,
            ProductSeeder::class,
            CurrencySeeder::class
        ]);
    }
}
