<?php

namespace Doefom\CurrencyFieldtype\Fieldtypes;

use Doefom\CurrencyFieldtype\Utils\Currencies;
use Statamic\Fields\Fieldtype;
use Statamic\Support\Arr;
use Statamic\Support\Str;

class CurrencyFieldtype extends Fieldtype
{

    /**
     * The blank/default value.
     *
     * @return array
     */
    public function defaultValue()
    {
        return null;
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function preProcess($data)
    {
        return Arr::get($data, 'value');
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function process($data)
    {
        $config = $this->field()->config();
        $iso = Arr::get($config, 'iso');
        $currency = Currencies::getCurrency($iso);
        $name = Arr::get($currency, 'name');
        $symbol = Currencies::getSymbol($iso);
        $append = Arr::get($currency, 'append');
        $space = Arr::get($currency, 'space');
        $groupSeparator = Arr::get($currency, 'group_separator');
        $radixPoint = Arr::get($currency, 'radix_point');
        $digits = Arr::get($currency, 'digits');

        $raw = Str::replace($groupSeparator, '', $data);
        $raw = Str::replace($radixPoint, '.', $raw);
        $raw = floatval($raw);

        return [
            'value' => $data,
            'formatted' => $append ? $data . ($space ? " " : "") . $symbol : $symbol . ($space ? " " : "") . $data,
            'raw' => $raw,
            'iso' => $iso,
            'name' => $name,
            'symbol' => $symbol,
            'append' => $append,
            'space' => $space,
            'radix_point' => $radixPoint,
            'group_separator' => $groupSeparator,
            'digits' => $digits
        ];
    }

    protected function configFieldItems(): array
    {
        return [
            'iso' => [
                'display' => 'Currency',
                'instructions' => 'Select which currency you want to use for the field.',
                'type' => 'select',
                'default' => 'USD',
                'options' => collect(Currencies::$currencyList)->map(fn($item) => $item['name'] . " (" . $item['symbol'] . ")"),
                'width' => 50
            ],
        ];
    }

    public function preload()
    {
        return [
            'currencies' => Currencies::$currencyList
        ];
    }

}
