<?php

namespace Doefom\CurrencyFieldtype\Fieldtypes;

use Doefom\CurrencyFieldtype\Models\Currency;
use Doefom\CurrencyFieldtype\Utils\Currencies;
use Illuminate\Support\Facades\App;
use NumberFormatter;
use Statamic\Fields\Fieldtype;
use Statamic\Support\Arr;

class CurrencyFieldtype extends Fieldtype
{

    public function icon()
    {
        return file_get_contents(__DIR__ . '/../../resources/svg/dollar.svg');
    }

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
        if ($data === null) {
            return null;
        }

        $fmt = App::make(NumberFormatter::class, ['iso' => $this->getIso()]);
        $formatted = $fmt->formatCurrency($data, $this->getIso());
        $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        return trim(str_replace($symbol, '', $formatted));
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function process($data)
    {
        $fmt = App::make(NumberFormatter::class, ['style' => NumberFormatter::DECIMAL, 'iso' => $this->getIso()]);
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->getIso());
        $float = $fmt->parse($data);

        return $float === false ? null : $float;
    }

    /**
     * Defines the configuration for the currency field.
     *
     * @return array Configuration for the currency field.
     */
    protected function configFieldItems(): array
    {
        return [
            'iso' => [
                'display' => 'Currency',
                'instructions' => 'Select which currency you want to use for the field.',
                'type' => 'select',
                'default' => 'USD',
                'options' => collect(Currencies::$currencyList)
                    ->map(fn($item, $key) => Arr::get($item, 'name') . " ($key)")
                    ->sortBy(fn($val) => $val),
                'max_items' => 1,
                'taggable' => true,
                'push_tags' => false,
                'clearable' => true,
                'width' => 50
            ],
        ];
    }

    /**
     * Preloads necessary currency data for the fieldtype's Vue component.
     *
     * @return array Array containing symbols, grouping and radix information.
     */
    public function preload(): array
    {
        $fmt = App::make(NumberFormatter::class, ['iso' => $this->getIso()]);

        return [
            'symbol' => $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
            'append' => ends_with($fmt->getPattern(), '¤'),
            'group_separator' => $fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'radix_point' => $fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
            'digits' => $fmt->getAttribute(NumberFormatter::FRACTION_DIGITS),
            'handle' => $this->field()->handle(),
        ];
    }

    /**
     * Augments the value of the field by wrapping it in a Currency model.
     *
     * @param mixed $value The value to augment.
     * @return Currency The augmented value wrapped in a Currency model.
     */
    public function augment($value)
    {
        return new Currency($value, $this->field()->config());
    }

    /**
     * Fetches the ISO code of the selected currency from the field's configuration.
     *
     * @return string The ISO code of the currency.
     */
    private function getIso(): string
    {
        return Arr::get($this->field()->config(), 'iso');
    }

}
