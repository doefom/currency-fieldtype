<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Orchestra\Testbench\Concerns\CreatesApplication;
use Statamic\Providers\StatamicServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getPackageProviders($app)
    {
        return [
            'Doefom\CurrencyFieldtype\ServiceProvider',
            StatamicServiceProvider::class,
        ];
    }
}