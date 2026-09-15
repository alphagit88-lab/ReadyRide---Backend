<?php

namespace App\Http\View\Composers;

use App\Models\HomePageSection;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class SectionsComposer
{
    public function compose(View $view): void
    {
        if (Schema::hasTable('home_page_sections')) {
            $view->with('sections', HomePageSection::keyed());
        } else {
            $view->with('sections', collect());
        }
    }
}
