<?php

namespace Doefom\CurrencyFieldtype\Fieldtypes;

use Doefom\CurrencyFieldtype\Models\Currency;
use Doefom\CurrencyFieldtype\Utils\Currencies;
use NumberFormatter;
use Statamic\Facades\Site;
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
        return $data;
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
        $groupSeparator = Arr::get($currency, 'group_separator');
        $radixPoint = Arr::get($currency, 'radix_point');

        $raw = Str::replace($groupSeparator, '', $data);
        $raw = Str::replace($radixPoint, '.', $raw);

        return floatval($raw);
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
            'currencies' => Currencies::$currencyList,
            'patter' => (new NumberFormatter(Site::current()->handle(), NumberFormatter::CURRENCY))->getPattern()
        ];
    }

    public function augment($value)
    {
        return new Currency($value, $this->field()->config());
    }

}
