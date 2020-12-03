<?php

namespace App\Providers;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Observers\Category\CategoryObserver;
use App\Observers\Product\ProductObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe( ProductObserver::class );
        Category::observe( CategoryObserver::class );
    }
}
