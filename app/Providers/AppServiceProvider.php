<?php

namespace App\Providers;

use App\Models\Phone;
use App\Models\Category;
use App\Observers\PhoneObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Phone::observe(PhoneObserver::class);
    }
}
