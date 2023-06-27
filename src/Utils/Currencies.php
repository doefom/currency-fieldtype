<?php

namespace Doefom\CurrencyFieldtype\Utils;

use Statamic\Support\Arr;

class Currencies
{

    /**
     * Get the currency details by its ISO identifier ("EUR", "USD", etc.).
     * @param string $iso
     * @return array|null
     */
    public static function getCurrency(string $iso): array|null
    {
        return Arr::get(self::$currencyList, $iso);
    }

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
            "radix_point" => ".",
            "digits" => 2
        ],
        "EUR" => [
            "name" => "Euro",
            "symbol" => "€",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ],
        "JPY" => [
            "name" => "Japanese Yen",
            "symbol" => "¥",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => null,
            "digits" => 0
        ],
        "GBP" => [
            "name" => "Sterling",
            "symbol" => "£",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "CNY" => [
            "name" => "Renminbi",
            "symbol" => "¥",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "AUD" => [
            "name" => "Australian Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "CAD" => [
            "name" => "Canadian Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "CHF" => [
            "name" => "Swiss Franc",
            "symbol" => "CHF",
            "append" => false,
            "space" => true,
            "group_separator" => "'",
            "radix_point" => ".",
            "digits" => 2
        ],
        "HKD" => [
            "name" => "Hong Kong Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "SGD" => [
            "name" => "Singapore Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "SEK" => [
            "name" => "Swedish Krona",
            "symbol" => "kr",
            "append" => true,
            "space" => true,
            "group_separator" => " ",
            "radix_point" => ",",
            "digits" => 2
        ],
        "KRW" => [
            "name" => "South Korean Won",
            "symbol" => "₩",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => null,
            "digits" => 0
        ],
        "NOK" => [
            "name" => "Norwegian Krone",
            "symbol" => "kr",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ],
        "NZD" => [
            "name" => "New Zealand Dollar",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "MXN" => [
            "name" => "Mexican Peso",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "BRL" => [
            "name" => "Brazilian Real",
            "symbol" => "$",
            "append" => false,
            "space" => false,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ],
        "DKK" => [
            "name" => "Danish Krone",
            "symbol" => "kr",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ],
        "PLN" => [
            "name" => "Polish Złoty",
            "symbol" => "zł",
            "append" => true,
            "space" => true,
            "group_separator" => " ",
            "radix_point" => ",",
            "digits" => 2
        ],
        "THB" => [
            "name" => "Thai Baht",
            "symbol" => "฿",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "CZK" => [
            "name" => "Czech Koruna",
            "symbol" => "Kč",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ],
        "TRY" => [
            "name" => "Turkish Lira",
            "symbol" => "₺",
            "append" => false,
            "space" => false,
            "group_separator" => ",",
            "radix_point" => ".",
            "digits" => 2
        ],
        "RON" => [
            "name" => "Romanian Leu",
            "symbol" => "L",
            "append" => true,
            "space" => true,
            "group_separator" => ".",
            "radix_point" => ",",
            "digits" => 2
        ]
    ];

    /**
     * Get the symbol of a currency by its ISO identifier ("EUR", "USD", etc.).
     * @param string $iso
     * @return string|null
     */
    public static function getSymbol(string $iso): string|null
    {
        $currency = self::getCurrency($iso);
        return Arr::get($currency, 'symbol');
    }

}
