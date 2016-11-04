<?php


namespace CristianVuolo\Helpers\Providers;


use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
       $this->publishes([__DIR__ . '/../../resources/publish/config/' => base_path('config')], 'config');
//        $this->publishes([__DIR__ . '/../../resources/publish/views/' => base_path('resources/views/cv')], 'views');
        require __DIR__ . "/../Helpers/CvHelpers.php";
        require __DIR__ . "/../Helpers/CvExpressHelpers.php";
    }

    public function register()
    {

    }
}