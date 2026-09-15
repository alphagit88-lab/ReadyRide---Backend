<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FooterLogoSeeder extends Seeder
{
    public function run(): void
    {
        $logos = [
            // Awards & Recognitions
            ['group' => 'awards', 'name' => 'ICTA',        'image_path' => null, 'url' => null, 'sort_order' => 1],
            ['group' => 'awards', 'name' => 'SLASSCOM',    'image_path' => null, 'url' => null, 'sort_order' => 2],

            // Cloud & Hosting Partners (used / recommended by Cyber Dreams)
            ['group' => 'cloud', 'name' => 'AWS',          'image_path' => null, 'url' => 'https://aws.amazon.com',       'sort_order' => 1],
            ['group' => 'cloud', 'name' => 'SHOUTcast',    'image_path' => null, 'url' => 'https://www.shoutcast.com',    'sort_order' => 2],
            ['group' => 'cloud', 'name' => 'Google Cloud', 'image_path' => null, 'url' => 'https://cloud.google.com',     'sort_order' => 3],
            ['group' => 'cloud', 'name' => 'DigitalOcean', 'image_path' => null, 'url' => 'https://www.digitalocean.com', 'sort_order' => 4],

            // Partners
            ['group' => 'partners', 'name' => 'Cyber Dreams Network', 'image_path' => null, 'url' => 'https://cyberdreams.net', 'sort_order' => 1],
        ];

        foreach ($logos as $logo) {
            \App\Models\FooterLogo::updateOrCreate(
                ['group' => $logo['group'], 'name' => $logo['name']],
                [
                    'image_path' => $logo['image_path'],
                    'url'        => $logo['url'],
                    'sort_order' => $logo['sort_order'],
                    'is_enabled' => true,
                ]
            );
        }
    }
}
