<?php

namespace Feature;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Doefom\CurrencyFieldtype\Models\Currency;
use Statamic\Facades\Site;
use Statamic\Fields\Field;
use Tests\TestCase;

class CurrencyFieldtypeTest extends TestCase
{

    protected CurrencyFieldtype $currencyFieldtype;
    protected Currency $augmented;

    /**
     * Set up a field of currency fieldtype with a value of 1234.56 and the following configuration:
     * handle: price
     * iso: USD
     *
     * For NumberFormatter use the locale en_US.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Site::setCurrent('en_US');

        $value = 1234.56;

        // --------------------------------------------------------
        // SET UP FIELDTYPE
        // --------------------------------------------------------

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
        $field->setValue($value);

        $currencyFieldtype = new CurrencyFieldtype();
        $currencyFieldtype->setField($field);

        $this->currencyFieldtype = $currencyFieldtype;

        // --------------------------------------------------------
        // SET UP AUGMENTED INSTANCE
        // --------------------------------------------------------

        $this->augmented = $this->currencyFieldtype->augment($value);

    }

    public function test_pre_process()
    {
        $result = $this->currencyFieldtype->preProcess(1234.56);
        $this->assertEquals('1,234.56', $result);
    }

    public function test_process()
    {
        $result = $this->currencyFieldtype->process('1,234.56');
        $this->assertEquals(1234.56, $result);
    }

    public function test_pre_process_index()
    {
        $result = $this->currencyFieldtype->preProcessIndex(1234.56);
        $this->assertEquals('$1,234.56', $result);
    }

    public function test_augmented_value()
    {
        $this->assertEquals(1234.56, $this->augmented->value);
    }

    public function test_augmented_display_value()
    {
        $this->assertEquals(1234.56, $this->augmented->display_value);
    }

    public function test_augmented_formatted()
    {
        $this->assertEquals('$1,234.56', $this->augmented->formatted);
    }

    public function test_augmented_formatted_no_symbol()
    {
        $this->assertEquals('1,234.56', $this->augmented->formattedNoSymbol);
    }

    public function test_augmented_iso()
    {
        $this->assertEquals('USD', $this->augmented->iso);
    }

    public function test_augmented_numeric_code()
    {
        $this->assertEquals('840', $this->augmented->numericCode);
    }

    public function test_augmented_symbol()
    {
        $this->assertEquals('$', $this->augmented->symbol);
    }

    public function test_augmented_append()
    {
        $this->assertFalse($this->augmented->append);
    }

    public function test_augmented_group_separator()
    {
        $this->assertEquals(',', $this->augmented->groupSeparator);
    }

    public function test_augmented_radix_point()
    {
        $this->assertEquals('.', $this->augmented->radixPoint);
    }

    public function test_augmented_digits()
    {
        $this->assertEquals(2, $this->augmented->digits);
    }

}
