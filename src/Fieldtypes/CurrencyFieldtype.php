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
        return $data;
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
        $config = $this->field()->config();
        $iso = Arr::get($config, 'iso');

        $fmt = new NumberFormatter(Site::current()->handle(), NumberFormatter::CURRENCY);
        $formattedNoSymbol = $this->field()->value() === null ? null: $fmt->formatCurrency($this->field->value(), $iso);

        return [
            'symbol' => Currencies::getSymbol($iso),
            'append' => str_starts_with($fmt->getPattern(), '¤'),
            'group_separator' => $fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'radix_point' => $fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
            'digits' => $fmt->getAttribute(NumberFormatter::FRACTION_DIGITS),
            'formatted_no_symbol' => $formattedNoSymbol
        ];
    }

    public function augment($value)
    {
        return new Currency($value, $this->field()->config());
    }

}
