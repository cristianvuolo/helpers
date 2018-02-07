<?php


namespace CristianVuolo\Helpers\Providers;


use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
       $this->publishes([__DIR__ . '/../../resources/publish/config/' => base_path('config')], 'config');
        require __DIR__ . "/../Helpers/CvHelpers.php";
        require __DIR__ . "/../Helpers/CvExpressHelpers.php";
        require __DIR__ . "/../Helpers/CvAdminHelpers.php";
    }

    public function register()
    {

    }
}