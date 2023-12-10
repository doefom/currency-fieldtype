<?php

namespace Doefom\CurrencyFieldtype\Utils;

use Illuminate\Support\Facades\App;
use NumberFormatter;
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
     * A list of currencies sorted by trade volume with information about each currency.
     * @var array|array[]
     */
    public static array $currencyList = [
        "USD" => ["name" => "US Dollar", "numeric_code" => "840"],
        "EUR" => ["name" => "Euro", "numeric_code" => "978"],
        "JPY" => ["name" => "Yen", "numeric_code" => "392", "sub_unit_factor" => 1],
        "GBP" => ["name" => "Pound Sterling", "numeric_code" => "826"],
        "AUD" => ["name" => "Australian Dollar", "numeric_code" => "036"],
        "CAD" => ["name" => "Canadian Dollar", "numeric_code" => "124"],
        "CHF" => ["name" => "Swiss Franc", "numeric_code" => "756"],
        "CNY" => ["name" => "Yuan Renminbi", "numeric_code" => "156"],
        "SEK" => ["name" => "Swedish Krona", "numeric_code" => "752"],
        "MXN" => ["name" => "Mexican Peso", "numeric_code" => "484"],
        "NZD" => ["name" => "New Zealand Dollar", "numeric_code" => "554"],
        "SGD" => ["name" => "Singapore Dollar", "numeric_code" => "702"],
        "HKD" => ["name" => "Hong Kong Dollar", "numeric_code" => "344"],
        "NOK" => ["name" => "Norwegian Krone", "numeric_code" => "578"],
        "KRW" => ["name" => "Won", "numeric_code" => "410"],
        "TRY" => ["name" => "Turkish Lira", "numeric_code" => "949"],
        "INR" => ["name" => "Indian Rupee", "numeric_code" => "356"],
        "RUB" => ["name" => "Russian Ruble", "numeric_code" => "643"],
        "BRL" => ["name" => "Brazilian Real", "numeric_code" => "986"],
        "ZAR" => ["name" => "Rand", "numeric_code" => "710"],
        "DKK" => ["name" => "Danish Krone", "numeric_code" => "208"],
        "PLN" => ["name" => "Zloty", "numeric_code" => "985"],
        "TWD" => ["name" => "New Taiwan Dollar", "numeric_code" => "901"],
        "THB" => ["name" => "Baht", "numeric_code" => "764"],
        "MYR" => ["name" => "Malaysian Ringgit", "numeric_code" => "458"],
        "CZK" => ["name" => "Czech Koruna", "numeric_code" => "203"],
    ];

    /**
     * Get the symbol of a currency by its ISO identifier ("EUR", "USD", etc.).
     * @param string $iso
     * @return string|null
     */
    public static function getSymbol(string $iso): string|null
    {
        collect(\Doefom\CurrencyFieldtype\Utils\Currencies::$currencyList)->filter(fn($item, $key) => collect(\Doefom\CurrencyFieldtype\Utils\Currencies::$temp)->has($key));

        $currency = self::getCurrency($iso);
        return Arr::get($currency, 'symbol');
    }

    /**
     * Get the symbol of all currencies in $currencyList, keyed by their ISO identifiers ("EUR", "USD", etc.).
     * @return array
     */
    public static function getAllSymbols()
    {
        $formatter;

        return collect(array_keys(self::$currencyList))
            ->mapWithKeys(function($iso) use(&$formatter, &$count){
                if( is_null($formatter) ){
                    $formatter = App::make(NumberFormatter::class, ['iso' => $iso]);
                }
                $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $iso);
                return [ $iso => $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL) ];
            });
    }
}
