<?php

namespace Doefom\CurrencyFieldtype\Augmentables;

use Doefom\CurrencyFieldtype\Utils\Currencies;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use NumberFormatter;
use Statamic\Data\AbstractAugmented;

class AugmentedCurrency extends AbstractAugmented
{

    /**
     * The preconfigured NumberFormatter instance to be used throughout the class
     * which handles all necessary currency string conversion.
     *
     * @var NumberFormatter|mixed
     */
    protected NumberFormatter $fmt;

    /**
     * Constructs a new AugmentedCurrency instance.
     *
     * @param mixed $data The data to be used by the AugmentedCurrency instance. This consists of $value and $config of the Currency.php class.
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->fmt = App::make(NumberFormatter::class, ['iso' => $this->iso()]);;
    }

    /**
     * Returns the keys of the augmented instance whereas each key reflects one method of this class.
     * https://statamic.dev/extending/augmentation#augmented
     *
     * @return array The keys of the data.
     */
    public function keys()
    {
        return [
            'value',
            'formatted',
            'formatted_no_symbol',
            'iso',
            'numeric_code',
            'symbol',
            'append',
            'group_separator',
            'radix_point',
            'digits'
        ];
    }

    /**
     * Returns the value of the data.
     *
     * @return mixed The value of the data.
     */
    public function value()
    {
        return $this->data->value;
    }

    /**
     * Returns the formatted currency value.
     *
     * @return string The formatted currency value.
     */
    public function formatted()
    {
        return $this->fmt->formatCurrency($this->value(), $this->iso());
    }

    /**
     * Returns the formatted currency value without the symbol.
     *
     * @return string The formatted currency value without the symbol.
     */
    public function formattedNoSymbol()
    {
        $formatted = $this->formatted();
        $symbol = $this->fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        return trim(str_replace($symbol, '', $formatted));
    }

    /**
     * Returns the ISO code of the currency.
     *
     * @return string|null The ISO code of the currency or null if not present.
     */
    public function iso(): string|null
    {
        return Arr::get($this->data->config, 'iso');
    }

    /**
     * Returns the numeric code of the currency.
     *
     * @return string|null
     */
    public function numericCode(): string|null
    {
        $currency = Currencies::getCurrency($this->iso());
        return Arr::get($currency, 'numeric_code');
    }

    /**
     * Returns the symbol of the currency.
     *
     * @return string The symbol of the currency.
     */
    public function symbol(): string
    {
        return $this->fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }

    /**
     * Determines if the symbol should be appended.
     *
     * @return bool True if the symbol should be appended, false otherwise.
     */
    public function append(): bool
    {
        return str_starts_with($this->fmt->getPattern(), '¤');
    }

    /**
     * Returns the group separator symbol.
     *
     * @return string The group separator symbol.
     */
    public function groupSeparator(): string
    {
        return $this->fmt->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL);
    }

    /**
     * Returns the radix point symbol.
     *
     * @return string The radix point symbol.
     */
    public function radixPoint(): string
    {
        return $this->fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);
    }

    /**
     * Returns the number of fraction digits.
     *
     * @return int The number of fraction digits.
     */
    public function digits(): int
    {
        return $this->fmt->getAttribute(NumberFormatter::FRACTION_DIGITS);
    }

}
