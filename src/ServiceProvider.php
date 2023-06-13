<?php

namespace Doefom\CurrencyFieldtype;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        CurrencyFieldtype::register();
    }
}
