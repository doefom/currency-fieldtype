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

//    protected $icon = '<svg height="100%" stroke-miterlimit="10"style="fill-rule:nonzero;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;" version="1.1" viewBox="0 0 1024 1024" width="100%" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs/><g id="Ebene-1"><g opacity="1"><path d="M696.625 641.124C696.625 437.244 386.274 541.449 386.274 385.141C386.274 333.038 406.662 271.874 513.133 271.874C621.869 271.874 635.461 357.957 637.726 396.468L685.299 396.468C689.829 333.038 644.522 240.159 535.786 235.628L535.786 172.199L489.347 172.199L489.347 235.628C362.487 242.424 340.967 337.569 340.967 380.61C340.967 593.552 651.318 480.285 651.318 641.124C651.318 661.513 646.788 752.126 513.133 752.126C508.602 752.126 370.416 752.126 374.947 609.41L327.375 609.41C331.905 761.188 428.182 781.576 489.347 788.372L489.347 851.801L534.653 851.801L534.653 788.372C686.431 777.045 696.625 663.778 696.625 641.124Z" fill="#000000" fill-rule="nonzero" opacity="1" stroke="#1f2937" stroke-linecap="butt" stroke-linejoin="miter" stroke-width="2"/><path d="M512 13.625C236.755 13.625 13.625 236.755 13.625 512C13.625 787.245 236.755 1010.38 512 1010.38C787.245 1010.38 1010.38 787.245 1010.38 512C1010.38 236.755 787.245 13.625 512 13.625Z" fill="none" opacity="1" stroke="#1f2937" stroke-linecap="butt" stroke-linejoin="miter" stroke-width="2"/></g></g></svg>';

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
                'options' => Currencies::$currencyList,
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
