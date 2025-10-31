<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Atk;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
         View::composer('*', function ($view) {
        $stokMenipis = Atk::whereColumn('stok', '<=', 'stok_minimum')->count();
        $view->with('stokMenipis', $stokMenipis);
    });
    }
}
