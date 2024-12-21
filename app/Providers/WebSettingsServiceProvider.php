<?php

namespace App\Providers;

use App\Models\Dashboard\Gas;
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
        if (Schema::hasTable('web_settings')) {
            $sets = DB::table('web_settings')->first();
            View::share('sets', $sets);
        }
        if (Schema::hasTable('gases')) {
            $gases = Gas::all();
            View::share('sidebarGas', $gases);
        }
    }
}
