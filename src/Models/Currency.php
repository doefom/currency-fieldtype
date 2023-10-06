<?php

namespace Doefom\CurrencyFieldtype\Models;

use Doefom\CurrencyFieldtype\Augmentables\AugmentedCurrency;
use Statamic\Contracts\Data\Augmentable;
use Statamic\Contracts\Data\Augmented;
use Statamic\Data\HasAugmentedInstance;

class Currency implements Augmentable
{
    use HasAugmentedInstance;

    public float|null $value;
    public array $config;

    public function __construct(?float $value, array $config)
    {
        $this->value = $value;
        $this->config = $config;
    }

    public function newAugmentedInstance(): Augmented
    {
        return new AugmentedCurrency($this);
    }
}
