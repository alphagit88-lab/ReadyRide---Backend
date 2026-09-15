<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\FooterLogo;
use App\Models\HomePageSection;
use App\Http\View\Composers\SectionsComposer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            View::share('site_settings', $settings);
        }

        if (Schema::hasTable('home_page_sections')) {
            HomePageSection::syncDefaults();
        }

        if (Schema::hasTable('footer_logos')) {
            $footerLogos = FooterLogo::where('is_enabled', true)
                ->orderBy('sort_order')
                ->get()
                ->groupBy('group');
            View::share('footer_logos', $footerLogos);
        } else {
            View::share('footer_logos', collect());
        }

        // Share $sections with all public-facing views
        View::composer(['home', 'layouts.public', 'blog.*', 'portfolio.*', 'legal.*'], SectionsComposer::class);
    }
}

