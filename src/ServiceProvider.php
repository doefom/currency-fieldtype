<?php

namespace Doefom\CurrencyFieldtype;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use NumberFormatter;
use Statamic\Facades\Site;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Support\Arr;

class ServiceProvider extends AddonServiceProvider
{

    protected $vite = [
        'input' => [
            'resources/js/currency-fieldtype.js',
            // 'resources/css/currency-fieldtype.css',
        ],
        'publicDirectory' => 'resources/dist',
        'hotFile' => __DIR__ . '/../resources/dist/hot',
    ];

    public function register()
    {
        $this->app->bind(NumberFormatter::class, function (Application $app, array $params = []): NumberFormatter {
            if (!Arr::has($params, 'iso')) {
                throw new InvalidArgumentException('The required iso key is missing in params array');
            }

            $style = Arr::get($params, 'style', NumberFormatter::CURRENCY);
            $iso = Arr::get($params, 'iso');

            $fmt = new NumberFormatter(Site::current()->locale(), $style);
            $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $iso);

            return $fmt;
        });
    }

    public function bootAddon()
    {
        CurrencyFieldtype::register();
    }
}
