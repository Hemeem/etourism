<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Package;
use App\Models\News;
use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Bagikan data hitungan ke file layout admin secara otomatis
        View::composer('layouts.admin', function ($view) {
            $view->with([
                'totalPackages'  => Package::count(),
                'totalNews'      => News::count(),
                'avgRating'      => round(Review::where('status', 'published')->avg('rating'), 1) ?: 0.0,
                'totalReviews'   => Review::count(),
                'totalGalleries' => Gallery::count(),
            ]);
        });

        {
        Paginator::useTailwind();
        }

        {
        // Paksa skema URL menjadi HTTPS jika diakses di luar localhost murni
        if (config('app.env') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }
        }
    }

    
}