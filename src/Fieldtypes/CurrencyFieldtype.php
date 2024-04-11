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
     * @return null|integer
     */
    public function defaultValue()
    {
        $default = Arr::get($this->field()->config(), 'default_value');
        if( $default > 0 && $this->usesSubUnitStorage() ){
            // Default is multiplied, to "cancel out" the division.
            // Default is always stored in primary units,
            // and the same method used for value retrieval is used for initializing default.
            $default *= $this->getSubUnitFactor();
        }
        return $default;
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return string|null
     */
    public function preProcess($data): ?string
    {
        if ($data === null) {
            return null;
        }

        $data = $this->convertFromStorage($data);

        $fmt = App::make(NumberFormatter::class, ['iso' => $this->getIso()]);
        $formatted = $fmt->formatCurrency($data, $this->getIso());
        $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        return trim(str_replace($symbol, '', $formatted));
    }

    /**
     * Pre-process the data before it gets sent to the listing/index page.
     *
     * @param $data
     * @return string|null
     */
    public function preProcessIndex($data): ?string
    {
        if ($data === null) {
            return null;
        }

        $data = $this->convertFromStorage($data);

        $fmt = App::make(NumberFormatter::class, ['iso' => $this->getIso()]);
        return $fmt->formatCurrency($data, $this->getIso());
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

        $float = $float === false ? null : $float;
        return $this->convertToStorage($float);
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
                'width' => 50
            ],

            'store_sub_units' => [
                'display' => 'Sub-Units',
                'instructions' => 'Store values in their lowest sub-unit _(eg, USD is stored in cents)_.',
                'type' => 'toggle',
                'default' => false,
                'width' => 50
            ],

            'default_value' => [
                'display' => 'Default Value',
                'instructions' => __('statamic::messages.fields_default_instructions'),
                'type' => 'currency',
                'width' => 50,
                'dynamic_currency_field' => 'iso',
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

        $dynamicCurrencyField = $this->field()->config()['dynamic_currency_field'] ?? false;

        return [
            'symbol' => $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
            'append' => str_ends_with($fmt->getPattern(), '¤'),
            'group_separator' => $fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'radix_point' => $fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
            'digits' => $fmt->getAttribute(NumberFormatter::FRACTION_DIGITS),
            'handle' => $this->field()->handle(),
            'dynamic_currency_field' => $dynamicCurrencyField,
            'available_symbols' => $dynamicCurrencyField ? Currencies::getAllSymbols() : null,
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
        return Arr::get($this->field()->config(), 'iso', 'USD');
    }

    private function convertToStorage($value)
    {
        if( $value > 0 && $this->usesSubUnitStorage() ){
            $value *= $this->getSubUnitFactor();
        }
        return $value;
    }

    private function convertFromStorage($value)
    {
        if( $value > 0 && $this->usesSubUnitStorage() ){
            $value /= $this->getSubUnitFactor();
        }
        return $value;
    }

    /**
     * Fetches the sub-unit factor from the field's configuration.
     *
     * @return integer The sub-unit factor of the currency.
     */
    private function getSubUnitFactor(): int
    {
        $currency = Currencies::getCurrency($this->getIso());
        return Arr::get($currency, 'sub_unit_factor', 100);
    }

    /**
     * Fetches the sub-unit storage boolean from the field's configuration.
     *
     * @return bool The sub-unit boolean of the currency.
     */
    public function usesSubUnitStorage(): bool
    {
        return Arr::get($this->field()->config(), 'store_sub_units', false);
    }

}
