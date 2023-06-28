<?php

namespace Feature;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use PHPUnit\Framework\TestCase;
use Statamic\Fields\Field;

class CurrencyFieldtypeTest extends TestCase
{
    /**
     * Get the fieldtype configured with an ISO.
     * @param $fieldConfig
     * @return CurrencyFieldtype
     */
    protected function fieldtype($fieldConfig = []): CurrencyFieldtype
    {
        return (new CurrencyFieldtype)->setField(new Field('test', $fieldConfig));
    }

    public function testProcessMethodUSD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'USD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodEUR()
    {
        $fieldtype = $this->fieldtype(['iso' => 'EUR']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '1.234,56 €',
            'raw' => 1234.56,
            'iso' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'append' => true,
            'space' => true,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodJPY()
    {
        $fieldtype = $this->fieldtype(['iso' => 'JPY']);
        $processed = $fieldtype->process('123,456');
        $this->assertEquals([
            'value' => '123,456',
            'formatted' => '¥123,456',
            'raw' => 123456.0,
            'iso' => 'JPY',
            'name' => 'Japanese Yen',
            'symbol' => '¥',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => null,
            'digits' => 0
        ], $processed);
    }

    public function testProcessMethodGBP()
    {
        $fieldtype = $this->fieldtype(['iso' => 'GBP']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '£1,234.56',
            'raw' => 1234.56,
            'iso' => 'GBP',
            'name' => 'Sterling',
            'symbol' => '£',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodCNY()
    {
        $fieldtype = $this->fieldtype(['iso' => 'CNY']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '¥1,234.56',
            'raw' => 1234.56,
            'iso' => 'CNY',
            'name' => 'Renminbi',
            'symbol' => '¥',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodAUD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'AUD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'AUD',
            'name' => 'Australian Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodCAD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'CAD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'CAD',
            'name' => 'Canadian Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodCHF()
    {
        $fieldtype = $this->fieldtype(['iso' => 'CHF']);
        $processed = $fieldtype->process('1\'234.56');
        $this->assertEquals([
            'value' => '1\'234.56',
            'formatted' => 'CHF 1\'234.56',
            'raw' => 1234.56,
            'iso' => 'CHF',
            'name' => 'Swiss Franc',
            'symbol' => 'CHF',
            'append' => false,
            'space' => true,
            'group_separator' => "'",
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodHKD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'HKD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'HKD',
            'name' => 'Hong Kong Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodSGD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'SGD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'SGD',
            'name' => 'Singapore Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodSEK()
    {
        $fieldtype = $this->fieldtype(['iso' => 'SEK']);
        $processed = $fieldtype->process('1 234,56');
        $this->assertEquals([
            'value' => '1 234,56',
            'formatted' => '1 234,56 kr',
            'raw' => 1234.56,
            'iso' => 'SEK',
            'name' => 'Swedish Krona',
            'symbol' => 'kr',
            'append' => true,
            'space' => true,
            'group_separator' => ' ',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodKRW()
    {
        $fieldtype = $this->fieldtype(['iso' => 'KRW']);
        $processed = $fieldtype->process('1,234');
        $this->assertEquals([
            'value' => '1,234',
            'formatted' => '₩1,234',
            'raw' => 1234,
            'iso' => 'KRW',
            'name' => 'South Korean Won',
            'symbol' => '₩',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => null,
            'digits' => 0
        ], $processed);
    }

    public function testProcessMethodNOK()
    {
        $fieldtype = $this->fieldtype(['iso' => 'NOK']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '1.234,56 kr',
            'raw' => 1234.56,
            'iso' => 'NOK',
            'name' => 'Norwegian Krone',
            'symbol' => 'kr',
            'append' => true,
            'space' => true,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodNZD()
    {
        $fieldtype = $this->fieldtype(['iso' => 'NZD']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'NZD',
            'name' => 'New Zealand Dollar',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodMXN()
    {
        $fieldtype = $this->fieldtype(['iso' => 'MXN']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '$1,234.56',
            'raw' => 1234.56,
            'iso' => 'MXN',
            'name' => 'Mexican Peso',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodBRL()
    {
        $fieldtype = $this->fieldtype(['iso' => 'BRL']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '$1.234,56',
            'raw' => 1234.56,
            'iso' => 'BRL',
            'name' => 'Brazilian Real',
            'symbol' => '$',
            'append' => false,
            'space' => false,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodDKK()
    {
        $fieldtype = $this->fieldtype(['iso' => 'DKK']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '1.234,56 kr',
            'raw' => 1234.56,
            'iso' => 'DKK',
            'name' => 'Danish Krone',
            'symbol' => 'kr',
            'append' => true,
            'space' => true,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodPLN()
    {
        $fieldtype = $this->fieldtype(['iso' => 'PLN']);
        $processed = $fieldtype->process('1 234,56');
        $this->assertEquals([
            'value' => '1 234,56',
            'formatted' => '1 234,56 zł',
            'raw' => 1234.56,
            'iso' => 'PLN',
            'name' => 'Polish Złoty',
            'symbol' => 'zł',
            'append' => true,
            'space' => true,
            'group_separator' => ' ',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodTHB()
    {
        $fieldtype = $this->fieldtype(['iso' => 'THB']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '฿1,234.56',
            'raw' => 1234.56,
            'iso' => 'THB',
            'name' => 'Thai Baht',
            'symbol' => '฿',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodCZK()
    {
        $fieldtype = $this->fieldtype(['iso' => 'CZK']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '1.234,56 Kč',
            'raw' => 1234.56,
            'iso' => 'CZK',
            'name' => 'Czech Koruna',
            'symbol' => 'Kč',
            'append' => true,
            'space' => true,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodTRY()
    {
        $fieldtype = $this->fieldtype(['iso' => 'TRY']);
        $processed = $fieldtype->process('1,234.56');
        $this->assertEquals([
            'value' => '1,234.56',
            'formatted' => '₺1,234.56',
            'raw' => 1234.56,
            'iso' => 'TRY',
            'name' => 'Turkish Lira',
            'symbol' => '₺',
            'append' => false,
            'space' => false,
            'group_separator' => ',',
            'radix_point' => '.',
            'digits' => 2
        ], $processed);
    }

    public function testProcessMethodRON()
    {
        $fieldtype = $this->fieldtype(['iso' => 'RON']);
        $processed = $fieldtype->process('1.234,56');
        $this->assertEquals([
            'value' => '1.234,56',
            'formatted' => '1.234,56 L',
            'raw' => 1234.56,
            'iso' => 'RON',
            'name' => 'Romanian Leu',
            'symbol' => 'L',
            'append' => true,
            'space' => true,
            'group_separator' => '.',
            'radix_point' => ',',
            'digits' => 2
        ], $processed);
    }

}
