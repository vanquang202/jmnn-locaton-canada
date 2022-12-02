<?php

namespace Jmnn\LocationCa;

use Illuminate\Support\ServiceProvider;
use Jmnn\LocationCa\Console\Commands\ImportCsvCanada;
use Jmnn\LocationCa\Console\Commands\LocationCanada;

class LocationCanadaServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('j-location-canada',function () {
            return new \Jmnn\LocationCa\LocationCanada();
        });
    }

    public function boot()
    {
        $this->__publishes();
        $this->__commands();
    }

    private function __publishes()
    {
        $this->publishes(
            [__DIR__.'/config/location_ca.php' => config_path('location_ca.php')],
            'j-config'
        );
        $this->publishes(
            [__DIR__.'/migrations/create_location_american_table.php' =>  database_path('migrations/' . date('Y_m_d_His', time()) . '_create_location_american_table.php')],
            'j-migration'
        );
    }

    private function __commands()
    {
        $this->commands([
            ImportCsvCanada::class,
            LocationCanada::class,
        ]);
    }
}
