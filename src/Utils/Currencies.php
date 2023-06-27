<?php

namespace Doefom\CurrencyFieldtype\Utils;

use Statamic\Support\Arr;

class Currencies
{

    /**
     * A list of currencies with detailed information about each currency.
     * @var array|array[]
     */
    public static array $currencyList = [
        "USD" => [
            "name" => "US Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => "."
        ],
        "EUR" => [
            "name" => "Euro",
            "symbol" => "€",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ","
        ],
        "AUD" => [
            "name" => "Australian Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => true,
            "group_separator" => ",",
            "radix_point" => "."
        ]
    ];

    /**
     * Get the currency details by its ISO identifier ("EUR", "USD", etc.).
     * @param string $iso
     * @return array|null
     */
    public static function getCurrency(string $iso): array|null
    {
        return Arr::get(self::$currencyList, $iso);
    }

    public static function getSymbol(string $iso): string|null
    {
        $currency = self::getCurrency($iso);
        return Arr::get($currency, 'symbol');
    }

}
