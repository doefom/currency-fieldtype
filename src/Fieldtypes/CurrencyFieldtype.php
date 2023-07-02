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

    protected NumberFormatter $fmt;

    public function __construct(NumberFormatter $fmt)
    {
        $this->fmt = $fmt;
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

        $this->fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->getIso());
        $formatted = $this->fmt->formatCurrency($data, $this->getIso());
        $symbol = $this->fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

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
        $fmt = App::make(NumberFormatter::class, ['style' => NumberFormatter::DECIMAL]);
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->getIso());
        $float = $fmt->parse($data);

        return $float === false ? null : $float;
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
        $this->fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->getIso());
        return [
            'symbol' => $this->fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
            'append' => str_starts_with($this->fmt->getPattern(), '¤'),
            'group_separator' => $this->fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'radix_point' => $this->fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
            'digits' => $this->fmt->getAttribute(NumberFormatter::FRACTION_DIGITS),
        ];
    }

    public function augment($value)
    {
        return new Currency($value, $this->field()->config());
    }

    private function getIso()
    {
        return Arr::get($this->field()->config(), 'iso', 'USD');
    }

}
