<?php

namespace Doefom\CurrencyFieldtype;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Doefom\CurrencyFieldtype\Listeners\UpdateEntriesWithCurrencyFields;
use Statamic\Events\BlueprintSaved;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $listen = [
        BlueprintSaved::class => [
            UpdateEntriesWithCurrencyFields::class
        ],
    ];

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
