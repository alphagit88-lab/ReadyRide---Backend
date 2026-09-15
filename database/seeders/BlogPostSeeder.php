<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title'      => 'Web Hosting Made Easy — What to Look for in a Hosting Provider',
                'content'    => "Choosing the right web hosting provider is one of the most important decisions for any online business. Cyber Dreams offers web hosting services with 24/7 online support, expanding from Cloud hosting to Dedicated servers — ensuring no time is wasted when upgrading resources. In this guide, we cover the key factors: reliability and performance, maintenance and updates, data and system security, and how to scale without downtime. Whether you need shared hosting or a fully managed dedicated server, knowing what to ask before you sign up can save you significant headaches down the line.",
                'image_path' => null,
            ],
            [
                'title'      => 'Why Your Business Needs a Custom Website in 2026',
                'content'    => "In today's digital-first world, a cookie-cutter website template no longer cuts it. Cyber Dreams specialises in designing extraordinary, intuitive, engaging, functional, and user-friendly customised websites that reflect your brand's presence and expertise. A custom website gives you full control over your brand identity, loading speed, SEO structure, and conversion optimisation. This article breaks down the key reasons businesses that invest in custom web design consistently outperform competitors using off-the-shelf solutions.",
                'image_path' => null,
            ],
            [
                'title'      => 'SHOUTcast Hosting — Bringing Your Online Radio to Life',
                'content'    => "If you want people to hear what you have to say, online radio is the fastest and most accessible way to do that. Cyber Dreams offers professional SHOUTcast Hosting servers to help you achieve your broadcasting goals. In this post, we explore how SHOUTcast works, the difference between shared and dedicated streaming servers, how to grow your listener base, and how Cyber Dreams can set up your entire broadcast infrastructure from start to finish.",
                'image_path' => null,
            ],
            [
                'title'      => 'E-Commerce Success — How to Turn Browsers into Buyers',
                'content'    => "Our E-Commerce projects are designed to drive traffic, increase leads, and convert browsers into buyers. Whether you are just starting out or branching into new ventures, Cyber Dreams works with your budget and resources to create an efficient e-commerce solution. This article covers product page optimisation, checkout flow best practices, mobile commerce trends, and the importance of fast hosting when running an online store. A slow page load on checkout can cost you up to 40% of your sales.",
                'image_path' => null,
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
