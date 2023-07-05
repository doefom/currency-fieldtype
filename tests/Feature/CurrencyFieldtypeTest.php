<?php

namespace Feature;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Statamic\Facades\Site;
use Statamic\Fields\Field;
use Statamic\Statamic;

class CurrencyFieldtypeTest extends \Orchestra\Testbench\TestCase
{

    protected CurrencyFieldtype $currencyFieldtype;

    protected function getPackageProviders($app)
    {
        return [
            'Doefom\CurrencyFieldtype\ServiceProvider',
            \Statamic\Providers\StatamicServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        Site::setCurrent('en_US');

        $field = new Field('price', [
            'iso' => 'USD',
            'type' => 'currency',
            'display' => 'Price',
            'icon' => 'currency',
            'listable' => 'hidden',
            'instructions_position' => 'above',
            'visibility' => 'visible',
            'hide_display' => false,
        ]);
        $field->setValue(1234.56);

        $currencyFieldtype = new CurrencyFieldtype();
        $currencyFieldtype->setField($field);

        $this->currencyFieldtype = $currencyFieldtype;
    }

    public function test_pre_process()
    {
        $result = $this->currencyFieldtype->preProcess(1234.56);
        $this->assertEquals('1,234.56', $result);
    }

}
