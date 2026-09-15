<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioItem;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title'             => 'Famico — Micro Finance Platform',
                'description'       => 'A fully-featured micro finance management system built for credit unions and cooperative societies. Handles member accounts, loan management, savings, and automated statement generation.',
                'category'          => 'Software Solution',
                'image_path'        => 'portfolio/famico-hl.jpg',
                'detail_image_path' => 'portfolio/famico-tr.jpg',
            ],
            [
                'title'             => 'Radio LK — Online Radio Portal',
                'description'       => 'A professional SHOUTcast-powered online radio streaming portal allowing broadcasters to go live effortlessly. Features listener counts, playlist management, and embeddable player widgets.',
                'category'          => 'Web Application',
                'image_path'        => 'portfolio/radiolk.jpg',
                'detail_image_path' => 'portfolio/radio.jpg',
            ],
            [
                'title'             => 'Prime Portal — Corporate Web Presence',
                'description'       => 'A modern corporate website and customer portal for a multi-service business. Includes a responsive public-facing site with a secure client login area for service tracking.',
                'category'          => 'Web Design',
                'image_path'        => 'portfolio/prime-portal.jpg',
                'detail_image_path' => 'portfolio/prime-site.jpg',
            ],
            [
                'title'             => 'CD Micro Finance — Real Estate',
                'description'       => 'A real estate listing and property management solution built for a property services firm. Features property search, photo galleries, agent profiles, and online inquiry forms.',
                'category'          => 'Web Application',
                'image_path'        => null,
                'detail_image_path' => null,
            ],
            [
                'title'             => 'Mobile Radio — Streaming App',
                'description'       => 'A cross-platform mobile application for iOS and Android that enables users to tune into live online radio stations, browse schedules, and save their favourite channels.',
                'category'          => 'Mobile App',
                'image_path'        => null,
                'detail_image_path' => null,
            ],
            [
                'title'             => 'E-Commerce Store — Online Retail',
                'description'       => 'A high-performance e-commerce website designed to drive traffic, increase leads, and convert browsers into buyers. Features full cart, checkout, and payment gateway integration.',
                'category'          => 'Web Design',
                'image_path'        => null,
                'detail_image_path' => null,
            ],
            [
                'title'             => 'The Watcher — Monitoring System',
                'description'       => 'A real-time website and server uptime monitoring tool that issues instant email and SMS alerts upon service interruptions, helping teams respond before customers notice downtime.',
                'category'          => 'Software Solution',
                'image_path'        => null,
                'detail_image_path' => null,
            ],
        ];

        foreach ($items as $item) {
            PortfolioItem::create($item);
        }
    }
}
