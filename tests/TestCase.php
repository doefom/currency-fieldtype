<?php

use \PHPUnit\Framework\TestCase as BaseTestCase;
use Statamic\Providers\StatamicServiceProvider;

class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            'Doefom\CurrencyFieldtype\ServiceProvider',
            StatamicServiceProvider::class,
        ];
    }

}
