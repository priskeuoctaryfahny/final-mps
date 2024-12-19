<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class WebSettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Check if the 'web_settings' table exists
        if (Schema::hasTable('web_settings')) {
            // Retrieve the first record from the web_settings table
            $sets = DB::table('web_settings')->first();
            // Share the settings with all views
            View::share('sets', $sets);
        }
    }
}
