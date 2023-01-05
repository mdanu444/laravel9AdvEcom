<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Models\SiteIdentity;
use Illuminate\Support\Facades\View;
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
        $siteData = SiteIdentity::first();
        $siteTitle = !empty($siteData->title) ? $siteData->title : "Adv. Ecommerce";
        $sitelogo = !empty($siteData->logo) ? $siteData->logo : "dist/img/AdminLTELogo.png";
        $footer_copyright = !empty($siteData->footer_copyright) ? $siteData->footer_copyright : "Footer copyright text Not set yet.";
        $siteTagline = !empty($siteData->tagline) ? $siteData->tagline : "";
        View::share('siteName', $siteTitle);
        View::share('sitelogo', $sitelogo);
        View::share('footerCopyright', $footer_copyright);
        View::share('siteTagline', $siteTagline);
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
