<?php

namespace Doefom\CurrencyFieldtype;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Illuminate\Contracts\Foundation\Application;
use NumberFormatter;
use Statamic\Facades\Site;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Support\Arr;

class ServiceProvider extends AddonServiceProvider
{

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function register()
    {
        $this->app->bind(NumberFormatter::class, function (Application $app, array $params = []): NumberFormatter {
            $style = Arr::get($params, 'style', NumberFormatter::CURRENCY);
            return new NumberFormatter(Site::current()->locale(), $style);
        });
    }

    public function bootAddon()
    {
        CurrencyFieldtype::register();
    }
}
