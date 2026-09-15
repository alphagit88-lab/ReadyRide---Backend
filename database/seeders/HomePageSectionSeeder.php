<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Seeder;

class HomePageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (HomePageSection::defaults() as $section) {
            HomePageSection::updateOrCreate(
                ['section_key' => $section['section_key']],
                [
                    'title'      => $section['title'],
                    'content'    => $section['content'],
                    'is_enabled' => $section['is_enabled'],
                ]
            );
        }
    }
}
