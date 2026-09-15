<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@cyberdreams.net'],
            [
                'name'     => 'Cyber Dreams Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('CyberD@2026#'),
            ]
        );

        $this->call([
            PortfolioSeeder::class,
            BlogPostSeeder::class,
            SettingSeeder::class,
            HomePageSectionSeeder::class,
            FooterLogoSeeder::class,
        ]);
    }
}
