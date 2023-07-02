<?php

namespace Unit;

use NumberFormatter;
use Statamic\Support\Str;
use Tests\TestCase;

class CurrencyPatternConversionTest extends TestCase
{

    public function testPattern()
    {
        $locales = collect(['de_DE', 'fr_FR', 'en_GB', 'en_US', 'ja_JP', 'zh-CN']);
        $output = $locales->map(function ($locale) {
            $value = 1234.56;
            $currency = 'EUR';

            $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);
            $pattern = $fmt->getPattern();
            $formatted = $fmt->formatCurrency($value, $currency);

            return [
                "locale" => $locale,
                "pattern" => $pattern,
                "value" => $value,
                "currency" => $currency,
                "formatted" => $formatted
            ];
        });

        dump(json_encode($output));
    }

    function testParseNumberFormatterPattern()
    {
        $this->parseNumberFormatterPattern("#,##0.00 ¤");
    }

    function parseNumberFormatterPattern($pattern)
    {
        $groupSeparator = null;
        $radixPoint = null;
        $appendSymbol = false;

        $fmt = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
        $radixPoint = $fmt->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL);

        $keyIndicators = str_replace('#', '', $pattern);
        $keyIndicators = str_replace('0', '', $keyIndicators);
        $keyIndicators = str_replace(' ', '', $keyIndicators);

        // Find out if the symbol is appended or prepended
        $symbolIndex = strpos($keyIndicators, '¤');
        if ($symbolIndex !== false) {
            // Symbol found
            $appendSymbol = $symbolIndex === 0;
        }

        // Remove the symbol placeholder from the key indicators
        $keyIndicators = str_replace('¤', '', $keyIndicators);
        $keyIndicatorsArr = explode('', $keyIndicators);

        $keyIndicators = collect(explode('', $keyIndicators));

        return $keyIndicators;

        return [
            'groupSeparator' => $groupSeparator,
            'radixPoint' => $radixPoint,
            'symbolPosition' => $symbolPosition
        ];
    }

}
