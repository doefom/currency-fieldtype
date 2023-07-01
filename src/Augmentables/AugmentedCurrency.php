<?php

namespace Doefom\CurrencyFieldtype\Augmentables;

use Illuminate\Support\Arr;
use NumberFormatter;
use Statamic\Data\AbstractAugmented;
use Statamic\Facades\Site;

class AugmentedCurrency extends AbstractAugmented
{

    public function keys()
    {
        return [
            'value',
            'formatted'
        ];
    }

    public function value()
    {
        return $this->data->value;
    }

    public function formatted()
    {
        $fmt = new NumberFormatter(Site::current()->handle(), NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($this->value(), Arr::get($this->data->config, 'iso', 'USD'));
    }

}
