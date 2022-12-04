<?php

namespace Jmnn\LocationCa\Tests;

use Jmnn\LocationCa\LocationCanadaServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LocationCanadaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql_test');
        $app['config']->set('database.connections.mysql_test', [
            'driver'   => 'mysql',
            'database' => 'canada',
            'prefix'   => '',
            'username' => 'root',
            'password' => 'password',
            'host' => '127.0.0.1'
        ]);
    }

}
